<?php

namespace App\Http\Controllers\Quizzes;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Quiz\Answer;
use App\Quiz\Correct;
use App\Quiz\Option;
use App\Quiz\Question;
use App\Quiz\Quiz;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Users\Ilhas;
use App\Http\Controllers\Logs\Logs;
use Session;


class Quizzes extends Controller
{
    public function getQuizFromUser($ilha,$user)
    {
        try {
            return Quiz::selectRaw('quizzes.id, quizzes.title, quizzes.description, quizzes.num_responses')
            ->leftJoin('book_relatorios.logs AS l', 'quizzes.id', 'l.value')
            ->leftJoin('book_usuarios.users As u', 'quizzes.creator_id', 'u.id')
            ->where('quizzes.ilhas','%'.$ilha.'%')
            ->where('l.action','QUIZ_ANSWERED')
            ->whereRaw('NOT l.user_id = '.$user)
            ->get();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    //trata respostas para salvar no banco
    public function saveAnswers(Request $request)
    {
        //data array to save in database
        $data = [];
        $questionReq = $request->input('question');
        $alternativaReq = $request->input('multiple');

        // trata dados de insert
        $quiz_id = $request->input('quiz');
        $user = $request->input('user');
        $texto = explode('|_|___@___|_|',substr($questionReq,0,-13));
        $multiple = explode('|_|___@___|_|',substr($alternativaReq,0,-13));
        $timestamp = date('Y-m-d H:i:s');

        if(!is_null($questionReq)) {
            //Questões de texto = [id_questao, resposta]
            foreach($texto as $text) {
                $t = explode('|_|___R___|_|',$text);
                $id = $t[0];
                $resposta = $t[1];

                $data[] = ['question_id' => $id, 'option_id' => NULL,'text' => $resposta,'user_id' => $user,'created_at' => $timestamp,'updated_at' => $timestamp];
            }
        }

        if(!is_null($alternativaReq)) {
            //Questões de multipla escolha = [id_questao, resposta]
            foreach($multiple as $mult) {

                $m = explode('|_|___R___|_|',$mult);
                $id = $m[0]; // id da questão
                $option_id = $m[1]; // alternativa escolhida

                $data[] = ['question_id' => $id, 'option_id' => $option_id,'text' => NULL,'user_id' => $user,'created_at' => $timestamp,'updated_at' => $timestamp];
            }
        }

        if(count($data) > 0) {

            try {
                $insert = Answer::insert($data);
                if($insert) {
                    $quiz = Quiz::find($quiz_id);
                    $quiz->num_responses++;
                    $quiz->save();
                    //grava logs
                    $log = new Logs();
                    @$log->awnswerQuiz($user,$quiz_id);

                    return response()->json(['success' => TRUE], 201);
                }

                return response()->json(['success' => FALSE], 422);
            } catch (Exception $e) {
                return response()->json(['success' => FALSE, 'msg' => $e->getMessage()], 422);
            }
        }


        return response()->json(['success' => FALSE], 422);
    }

    //////////////////////////////////////////////////////////////

    //retorna view com quizzes - index
    public function index($ilha, $id, $skip = 0, $take = 5) {
        if(Session::get('pwIsDf') == 1) {
            return redirect('profile/'.base64_encode(Auth::id()))->with('errorAlert','Altere sua senha');
        }

        $title = 'Quizzes';

        if(is_null($ilha)) {
            return back()->with(['errorAlert','Sessão expirada ou inválida, faça login novamente!']);
        }

        if(Auth::id() > 0) {
            $quizzes = Quiz::whereRaw('(validity >= NOW() OR ISNULL(validity)) AND ilhas LIKE "%,'.$ilha.',%"')
                            ->orWhere('creator_id',$id)
                            ->skip($skip)
                            ->take($take)
                            ->orderBy('validity')
                            ->orderBy('id')
                            ->get();
        } else {
            $quizzes =  DB::select('SELECT quizzes.id, quizzes.creator_id, quizzes.title, quizzes.description, quizzes.num_responses,
                            (SELECT COUNT(id) FROM book_relatorios.logs WHERE user_id = '.$id.' AND action = "ANSWER_QUIZ" AND value = quizzes.id) as answered , users.name, users.avatar
                        FROM book_quizzes.quizzes
                        LEFT JOIN book_usuarios.users ON users.id = quizzes.creator_id
                        LEFT JOIN book_relatorios.logs ON quizzes.id = logs.value AND users.id = logs.user_id
                        WHERE  quizzes.deleted_at is null AND (quizzes.validity >= NOW()
                        and quizzes.ilhas LIKE "%,'.$ilha.',%"
                        or (IF(quizzes.created_at <= DATE_SUB(NOW(), INTERVAL 90 DAY),1,0) = 1 AND logs.user_id = '.$id.') or quizzes.creator_id = '.$id.')
                        order by logs.user_id desc, quizzes.id desc
                        limit '.$take.'
                        offset '.$skip);
        }

        // Permissões
        $permissions = Session::get('permissionsIds');
        $webMaster = in_array(1,$permissions);
        $createQuiz = in_array(31,$permissions);
        $deleteQuiz = in_array(32,$permissions);
        $exportQuiz = in_array(33,$permissions);

        $compact = compact('title','quizzes','skip','take', 'permissions', 'webMaster', 'createQuiz', 'deleteQuiz', 'exportQuiz');

        return view('quiz.quizzes',$compact);
    }

    // retorna view de criação de quiz (criar)
    public function create(Request $request) {

        //Registra log de página
        $log = new Logs();
        $log->page($request->fullUrl(),Auth::user()->id,Auth::user()->ilha_id,$request->ip());

        //pega ilhas
        $i = new Ilhas();
        $ilhas = ($i->indexPost('*',null,FALSE));

        $title = 'Criar Quiz';
        return view('quiz.make',compact('title','ilhas'));
    }

    //retorna questões
    public function option($id)
    {
        $options = Option::where('question_id',$id)->get();
        return $options->toJSON();
    }

    //exibe quiz
    public function view($i, Request $request)
    {
        $id = base64_decode($i);

        //questions
        $questions = Question::where('quiz_id',$id)->get();

        //quiz
        $quiz= Quiz::find($id);

        //title
        $title = 'Quiz #' . $id;

        //log
        $log = new Logs();
        $log->page($request->fullUrl(),Auth::user()->id,Auth::user()->ilha_id,$request->ip());

        return view('quiz.view',compact('title','quiz','questions'));
    }

    public function correct($id,Request $request)
    {
        //questions
        $questions = Question::where('quiz_id',$id)
                            ->get();

        //quiz
        $quiz= Quiz::find($id);

         //title
         $title = 'Selecionar alternativas corretas #' . $id;

        //log
        $log = new Logs();
        $log->page($request->fullUrl(),Auth::user()->id,Auth::user()->ilha_id,$request->ip());

        return view('quiz.correct',compact('title','quiz','questions'));
    }

    //cria quiz
    public function store($user, Request $request) {
        /* Validação */
        // $rules = [
        //     'title' => 'required',
        //     'descript' => 'required',
        //     'validity' => 'required',
        //     'icheckbox' => 'required',
        //     'ilhas' => 'required',
        //     'question' => 'required',
        // ];

        // $messages = [
        //     'question.required' => 'Não é possível enviar Quiz sem questões',
        // ];

        // $validator = Validator::make($request->all(), $rules,$messages);

        // if ($validator->fails()) {
        //     return response()->json(['errors' => $validator->errors()->all()], 422);
        // }

        $return = NULL;
        $correct = NULL;

        // $request->validate($rules,$messages);

        //dados do form
        $title = $request->input('title');//ok
        $descript = $request->input('descript');
        $datepicker = implode('-',array_reverse(explode('-',$request->input('validity')))).' 00:00:00';//timestamp
        $icheckbox = $request->input('icheckbox'); //always on

        $ilhas = ','.$request->input('ilhas').','; // ilha_id (ilha-1,ilha-2,...,ilha-n)
        $question = explode('@|||||/*-@',substr($request->input('question'),0,-10));
        $options = explode('@|||||/*-@',substr($request->input('qvalues'),0,-10));

        //salva quiz
        $quizId = $this->saveQuiz($user,$title,$datepicker,$icheckbox,$ilhas,$descript);

        //pega cada questão
        foreach($question as $q):
            // separa questões
            $array = (explode('@|||||/*-@',$q));

            for($i = 0; $i < count($array); $i++):

                $qArray = explode('_=_=_=_',$array[$i]);//$question tratada

                $type = $qArray[0];
                $questionTitle = $qArray[1];

                $questionId = $this->saveQuestions($questionTitle,$quizId);

                // verifica se a questão é objetiva*(title_Multiple)* ou dissertativa *(title_dissert)*
                if($type !== 'title_dissert ') {

                    // Separa alternativas das questões
                    for($n = 0; $n < count($options); $n++) {
                        $alternativa = explode('_=_=_=_',$options[$n]);
                        $correct .= 'ok.';

                        // $alternativa[0] = titulo da questão
                        $idQuestionLoop = $alternativa[0];
                        // Verifica
                        if(trim($type) == trim($idQuestionLoop)) {
                            // Separa Alternativa e verifica qual é a correta
                            $dados_alternativa = explode('|_is_correct_|',$alternativa[1]);

                            $texto_alternativa = $dados_alternativa[0];
                            $alternativa_correta = isset($dados_alternativa[1]) ? $dados_alternativa[1] : 0;

                            if(!$this->saveOptions($questionId,$texto_alternativa,$alternativa_correta)) {
                                $return += '+fail';
                            }

                        }

                    }//for que salva alternativas

                }

            endfor;//salva questões

        endforeach; //separa dados

        if(!in_array('fail',explode('+',$return))) {

            //salva quiz
            $log = new Logs();
            $log->createQuiz($user,$quizId);

            return response()->json([ 'success' => TRUE, 'id' => $quizId, 'multiple' => explode('.',$correct) ]);
        }

        return FALSE;

    }

    // grava quiz
    public function saveQuiz($user,$title,$datepicker,$icheckbox,$ilhas,$description = NULL) : INT
    {

        if($icheckbox == 'on') {
            $quiz = new Quiz();
            $quiz->title = $title;
            $quiz->description = $description;
            $quiz->creator_id = $user;
            $quiz->creator_id;
            $quiz->ilhas = $ilhas;
            $quiz->creator_id = $user;
            if($quiz->save()) {
                return $quiz->id;
            }

            return 0;

        }// Caso não expire
        else {
            $quiz = new Quiz();
            $quiz->title = $title;
            $quiz->description = $description;
            $quiz->creator_id = $user;
            $quiz->validity = $datepicker;
            $quiz->creator_id;
            $quiz->ilhas = $ilhas;
            $quiz->creator_id = $user;
            if($quiz->save()) {
                return $quiz->id;
            }

            return 0;
        } // Caso expire




    }

    public function saveQuestions($title,$quiz) : INT
    {

        $question = new Question();
        $question->question = $title;
        $question->quiz_id = $quiz;
        $question->save();
        return $question->id;
    }

    public function saveOptions($question_id,$text = NULL, $correct = 0) : BOOL
    {

        $option = new Option();
        $option->question_id = $question_id;
        $option->is_correct = $correct;
        $option->text = $text;
        if($option->save()) {
            return TRUE;
        }

        return FALSE;
    }

    //delete quiz
    public function delete($user,$id)
    {
        $quiz = Quiz::find($id);

        if($quiz->delete()) {
            //deleta quiz
            $log = new Logs();
            $log->deleteQuiz($user,$id);

            return response()->json(['success' => TRUE], 200);
        }

        return response()->json(['success' => FALSE], 500);
    }

    public function correctAnswer(Request $request)
    {
        $return = NULL;
        $n = NULL;
        $data = NULL;

        $quiz = $request->input('quiz');
        $user = $request->input('user');
        $multiple = explode(',',substr($request->input('multiple'),0,-1));

        foreach($multiple as $mult) {

            $m = explode('_',$mult);
            $quiz_id = $m[0];
            $id = $m[1];


            if(!$this->selectCorrect($id,$quiz_id)) {
                $return .= 'fail_';
            }
        }

        //verifica se tudo foi salvo corretamente
        if(!in_array('fail',explode('_',$return))) {
            $n .= 200;
            $data .= FALSE;

            //log de resposta salva
            $log = new Logs();
            // $log->awnswerQuiz($user,$quiz);

        } else {
            $n .= 422;
            $data .= TRUE;

            //log de resposta salva
            $log = new Logs();
            // $log->awnswerQuiz($user,$quiz,"ANSWER_QUIZ_ERROR");
        }

        return response()->json(['success' => $data], $n);
    }

    //salva resposta no banco
    public function saveOption($user, $option_id = NULL, $text = NULL)
    {
        $answer = new Answer();
        $answer->option_id = $option_id;
        $answer->text = $text;
        $answer->user_id = $user;

        return $answer->save();
    }

    //seleciona qual questão é a correta
    public function selectCorrect($option_id,$question_id)
    {
        $correct = new Correct();
        $correct->option_id = $option_id;
        $correct->question_id = $question_id;

        return $correct->save();
    }

    //verifica se as respostas foram corretas
    public function verifyResp($quiz,$answers)
    {
        $quizzes = Quiz::find($quiz);

        foreach($quizzes as $q) {
            ($q->answers->id);
        }
    }

}
