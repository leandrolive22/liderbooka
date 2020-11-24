<?php

namespace App\Http\Controllers\Relatorios;

use App\Http\Controllers\Tools\ExcelExports;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Users\Ilha;
use App\Users\User;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Logs\Logs;
use App\Http\Controllers\Users\Ilhas;
use App\Http\Controllers\Users\Setores;
use App\Http\Controllers\Users\Superiors;
use App\Quiz\Answer;
use App\Quiz\Option;
use App\Quiz\Question;
use App\Quiz\Quiz;
use App\Users\Cargo;
use App\Users\Carteira;
use App\Users\Filial;
use DB;

class Quizzes extends Controller {


    public function quizDataById($i)
    {
        try {
            $id = base64_decode($i);
            $ids = '';
            //$ids = 'a.id As answer_id, q.id AS quiz_id, questions.id AS question_id, o.id As option_id, a.user_id, a.option_id AS multiple_answer';
            $result = DB::select(
                // SELECT '.$ids.' q.title, q.description, q.num_responses, q.validity, creator.id, creator.name,
                // questions.question, o.text AS question_text, a.text AS text_answer, o.is_correct,
                // u.name AS answer_user, supervisor.name As supervisor, coordenador.name As coordenador, gerente.name AS gerente, superintendente.name AS superintendente

                // FROM book_quizzes.quizzes AS q
                // LEFT JOIN book_quizzes.questions
                //     ON q.id = questions.quiz_id
                // LEFT JOIN book_quizzes.options AS o
                //     ON o.question_id = questions.id
                // LEFT JOIN book_quizzes.answers AS a
                //     ON questions.id = a.question_id
                // LEFT JOIN book_usuarios.users AS creator
                //     ON q.creator_id = creator.id
                // LEFT JOIN book_usuarios.users AS u
                //     ON u.id = a.user_id
                // LEFT JOIN book_usuarios.users AS supervisor
                //     ON supervisor.id = u.supervisor_id
                // LEFT JOIN book_usuarios.users AS coordenador
                //     ON coordenador.id = u.coordenador_id
                // LEFT JOIN book_usuarios.users AS gerente
                //     ON gerente.id = u.gerente_id
                // LEFT JOIN book_usuarios.users AS superintendente
                //     ON superintendente.id = u.superintendente_id
                // WHERE q.id = ?
                // "SELECT distinct q.title, q.description, q.num_responses, q.validity, creator.id, creator.name,
                // questions.question, o.text AS question_text, a.text AS text_answer, o.is_correct,
                // u.name AS answer_user, supervisor.name As supervisor, coordenador.name As coordenador, gerente.name AS gerente, superintendente.name AS superintendente

                // FROM book_quizzes.quizzes AS q
                // LEFT JOIN book_quizzes.questions
                //     ON q.id = questions.quiz_id
                // LEFT JOIN book_quizzes.options AS o
                //     ON o.question_id = questions.id

                // LEFT JOIN book_quizzes.answers AS a
                //     ON (questions.id = a.question_id AND a.option_id = o.id) OR (questions.id = a.question_id AND a.option_id IS NULL)


                // LEFT JOIN book_usuarios.users AS creator
                //     ON q.creator_id = creator.id
                // LEFT JOIN book_usuarios.users AS u
                //     ON u.id = a.user_id
                // LEFT JOIN book_usuarios.users AS supervisor
                //     ON supervisor.id = u.supervisor_id
                // LEFT JOIN book_usuarios.users AS coordenador
                //     ON coordenador.id = u.coordenador_id
                // LEFT JOIN book_usuarios.users AS gerente
                //     ON gerente.id = u.gerente_id
                // LEFT JOIN book_usuarios.users AS superintendente
                //     ON superintendente.id = u.superintendente_id
                // WHERE q.id = ?"
                "SELECT u.name As usuario, u.matricula AS matricula, u.username, SUM(is_correct) AS acertos, CAST((SUM(is_correct) / COUNT(q.id))*100 AS DECIMAL(5,2)) As porcentagem
                FROM book_quizzes.quizzes qu
                JOIN book_quizzes.questions AS q ON qu.id = q.quiz_id
                JOIN book_quizzes.options AS o ON o.question_id = q.id
                JOIN book_quizzes.answers AS a ON o.id = a.option_id AND q.id = a.question_id
                LEFT JOIN book_usuarios.users AS u ON a.user_id = u.id
                WHERE qu.id = ?
                    AND a.deleted_At IS NULL
                    AND qu.deleted_At IS NULL
                    AND q.deleted_At IS NULL
                GROUP BY usuario, matricula, username"
                ,[$id]);


            $data = collect($result)->map(function($x){ return (array) $x; })->toArray();
            if(count($data) === 0) {
                return back()->with('errorAlert','Nenhum dado encontrado!');
            }
            $columns = array_keys($data[0]);

            $excel = new ExcelExports();
            return $excel->analyticMonitoria($data,$columns,'liderbook_quiz_'.$i.'_report');

            // return $result

            return back()->with('errorAlert','Quiz Não encontrado');
        } catch (Exception $e) {
            @DB::table('book_relatorios.error_logs')->insert([
                'user' => Auth::id(),
                'error' => 'ERROR_QUIZ_REPORT',
                'error_detail' => $e->getMessage(),
                'created_at' => date('Y-m-d H:i:s')
            ]);

            return back()->with('errorAlert','Erro, contate o suporte!');
        }

    }


    //mmonta filtros da página de acordo com o quiz escolhido
    public function setfilters($quiz_id)
    {
        //pesquisa ilhas a qual o quiz foi aplicado
        $quiz = Quiz::select('ilhas')->where('id',$quiz_id)->withTrashed()->get();

        if($quiz->count() == 0) {
            return back()->with('error','Nenhum dado encontrado para esses parametros de pesquisas');
        }

        //pega as ilhas e seus dados
        $ilha = new Ilhas();
        $ilhas = $ilha->IlhasIn($quiz[0]['ilhas']);

        // Pega id da questão e título da mesma onde o quiz foi aplicado
        $in = NULL;
        $questions = Question::select('id as qId','question')->where('quiz_id',$quiz_id)->get();
        if($questions->count() == 0) {
            return back()->with('error','Nenhum dado encontrado para esses parametros de pesquisas');
        }

        foreach($questions as $q) {
            $in .= $q->qId . ',';
        }

        $in .= $questions[0]['qId'];

        // pega alternativas dos quizzes
        $options = Option::select('id as optId', 'text as option', 'question_id')->whereRaw("`question_id` IN ($in)")->get();

        if($options->count() == 0) {
            return back()->with('error','Nenhum dado encontrado para esses parametros de pesquisas');
        }

        unset($in);
        $in = NULL;

        foreach($options as $o) {
            $in .= $o->optId . ',';
        }

        $in .= $options[0]['optId'];

        // pega respostas dos usuários
        $answers = Answer::select('id', 'option_id','user_id','text')->whereRaw("option_id IN ($in)")->get();

        if($answers->count() == 0) {
            return back()->with('error','Nenhum dado encontrado para esses parametros de pesquisas');
        }

        unset($in);
        $in = NULL;

        foreach($answers as $i) {
            $in .= $i->user_id . ',';
        }

        $in .= $answers[0]['user_id'];

        //busca superiores
        $superior = new Superiors();
        $superiores = $superior->superiorsIn($in);

        //busca participantes do quiz
        $users = User::select('id','cargo_id','carteira_id','name')->whereRaw("id IN ($in)")->withTrashed()->get();

        unset($in);
        $in = NULL;
        foreach($users as $u) {
            $in .= $u->cargo_id.',';
        }

        $in .= $users[0]['cargo_id'];

        // BUSCA SETORES DOS PARTICIPANTES DO QUIZ
        $setor = new Setores();
        $setores = $setor->byCarteiraIn($in);

        //title da página
        $title = 'Relatório de Quizzes';

        //indica que a página pode exibir os filtros
        $filters = 1;

        //Parâmetros de Filtros
        $quizzes = Quiz::withTrashed()->get();

        //verifica se o quiz é público ou se foi aplicado à mais de uma ilha
        if($quiz[0]['ilhas'] == 1 || count(explode(',',$quiz[0]['ilhas'])) > 1) {

            $adm = Cargo::where('type_id',1)->get();

        } else {
            $adm = [];
        }
        $cargos = Cargo::all();
        $filiais = Filial::all();

        // return
        return view('gerenciamento.reports.quiz',compact('quiz_id','superiores','setores','filiais','quizzes','filters','title','ilhas','answers','options','questions','users','adm','cargos'));

    }

    public function results(Request $request)
    {
        //Verifica quais filtros são obrigatórios
        $rules = [
            'selectQuiz' => 'required',
        ];
        $msg = [
            'required' => 'Verifique se os filtros foram feitos corretamente!'
        ];

        $validator = Validator::make($request->all(), $rules, $msg);
        if($validator->fails()) {
            return back()->with(['errors' => $validator->errors()->all()]);
        }

        $gerencia = substr($request->input('gerencia'),0,-1);

        if(!in_array($gerencia,[0,'-',NULL,' ',''])) {
            $selectSup = $request->input('selectSup');
        } else {
            $selectSup = $gerencia.','.$request->input('selectSup');
        }

        $selectQuiz = $request->input('selectQuiz');
        $selectSup = $request->input('selectSup');
        $selectSite = $request->input('selectSite');
        $selectCarteira = $request->input('selectCarteira');
        $selectSegment = $request->input('selectSegment');
        $selectIlha = $request->input('selectIlha');
        $selectCrgEtr = $request->input('selectCrgEtr');
        $selectPergunta = $request->input('selectPergunta');
        $selectResp = $request->input('selectResp');
        $selectPartic = $request->input('selectPartic');

        $result = Question::select('questions.question titulo_questao','o.text as alternativa','o.question_id alternativa_id', 'a.option_id as alternativa_escolhida', 'a.text as resposta_dissertativa', 'o.is_correct 1_correta_0_incorreta','a.user_id', 'sup.superior_id')
                ->leftJoin('options as o','questions.id','o.question_id')
                ->leftJoin('answers as a','a.option_id','o.id')
                ->leftJoin('book_usuarios.superiors as sup','sup.superior_id','a.user_id')
                ->leftJoin('book_usuarios.users','users.id','a.user_id')
                ->where('questions.quiz_id','=',$selectQuiz)
                ->when(!in_array($selectSup,[0,'-',NULL,' ','']),function($query,$selectSup) {
                    return $query->whereRaw("sup.superior_id IN ($selectSup)");
                })
                ->when(!in_array($selectSite,[0,'-',NULL,' ','']),function($query,$selectSite) {
                    return $query->whereRaw("users.filial_id IN ($selectSite)");
                })
                ->when(!in_array($selectCarteira,[0,'-',NULL,' ','']),function($query,$selectCarteira) {
                    return $query->whereRaw("users.carteira_id IN ($selectCarteira)");
                })
                ->when(!in_array($selectSegment,[0,'-',NULL,' ','']),function($query,$selectSegment) {
                    return $query->whereRaw("users.setor_id IN ($selectSegment)");
                })
                ->when(!in_array($selectIlha,[0,'-',NULL,' ','']),function($query,$selectIlha) {
                    return $query->whereRaw("users.ilha_id IN ($selectIlha)");
                })
                ->when(!in_array($selectCrgEtr,[0,'-',NULL,' ','']),function($query,$selectCrgEtr) {
                    return $query->whereRaw("users.cargo_id IN ($selectCrgEtr)");
                })
                ->when(!in_array($selectPergunta,[0,'-',NULL,' ','']),function($query,$selectPergunta) {
                    return $query->whereRaw("q.id IN ($selectPergunta)");
                })
                ->when(!in_array($selectResp,[0,'-',NULL,' ','']),function($query,$selectResp) {
                    return $query->whereRaw("o.id IN ($selectResp)");
                })
                ->when(!in_array($selectPartic,[0,'-',NULL,' ','']),function($query,$selectPartic) {
                    return $query->whereRaw("a.user_id IN ($selectPartic)");
                })
                ->get();

        if($result->count() > 0) {
            return $result;
        }

        return ['none' => 'Nenhum resultado encontrado para a pesquisa'];

    }
}
