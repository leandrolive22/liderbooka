<?php

/*********** Autenticação ***********/

use Illuminate\Support\Facades\Hash;

Auth::routes(['register' => false]);

Route::get('liderbook/public',function(){
    return redirect('/');
    });

Route::get('hash/{hash}/',function($hash){
    if(Hash::check($hash, '$2y$10$TrFpsB1/231332/ZH3dlon7noQmvuFNPF5hm44btv8kFYPoOwSlSt2b1mhzS')) {
        return 'ok___ $2y$10$TrFpsB1/231332/ZH3dlon7noQmvuFNPF5hm44btv8kFYPoOwSlSt2b1mhzS ';
    }
    return Hash::make($hash).'    '.$hash;
});

/*********** Login ***********/
Route::get('/', 'Users\Users@index')->name('default');
Route::group(['prefix' => 'forgot'], function () {
    Route::get('/', 'Users\Users@forgot')->name('forgot');
    Route::get('/', 'Users\Users@forgot')->name('forgotPost');
});
Route::post('acceptLgpd','Users\Users@lgpd')->name('PostUsersLgpd');

Route::group(['middleware' => ['auth','LogsRequest']], function () {
    //change pass
    Route::post('changePass/{id}','Users\Users@changePass')->name('PostUsersPass');

    //Controller de redirecionamento - login backend
    Route::get('/home/{page}','HomeController@index')->name('home');

    Route::get('about_blank/',function ()
    {
        return view('blank');
    });

    Route::get('/home', 'HomeController@index')->name('homeN');
    /*********** rotas do menu de navegação ***********/
    Route::group(['prefix' => 'messages', 'middleware' => 'Chat'], function () {
        Route::get('/adm', 'Chats\Chats@msgAdm')->name('GetUsersMsgAdm');
        Route::get('/coordenator', 'Chats\Chats@msgCoordenador')->name('GetUsersMsgCoord');
        Route::get('/training', 'Chats\Chats@msgMonitor')->name('GetUsersMsgTraining');
        Route::get('/supervisor', 'Chats\Chats@msgSupervisor')->name('GetUsersMsgSup');
        Route::get('/support', 'Chats\Chats@msgOperadorAdm')->name('GetUsersMsgOpeSup');
        Route::get('/operator', 'Chats\Chats@msgOperador')->name('GetUsersMsgOpe');
        Route::get('/monitor', 'Chats\Chats@msgMonitor')->name('GetUsersMsgMonit');
    });

    Route::get('/profile/{id}', 'Users\Users@profile')->name('GetUserProfile');
    Route::get('/gerenciamento', 'Users\Users@manager')->name('GetUsersManager');
    Route::get('/wiki/{ilha}', 'Users\Users@wiki')->name('GetUsersWiki')->middleware('Wiki');

    //pega quantidade de materiais
    Route::group(['prefix' => 'count'], function () {
        Route::get('/circulares/{ilha}/{cargo}', 'Materials\Circulares@getCount')->name('GetCountCirculares');
        Route::get('/roteiros/{ilha}/{cargo}', 'Materials\Roteiros@getCount')->name('GetCountRoteiros');
        Route::get('/materiais/{ilha}/{cargo}', 'Materials\Materiais@getCount')->name('GetCountMateriais');
        Route::get('/videos/{ilha}/{cargo}', 'Materials\Videos@getCount')->name('GetCountVideos');
        Route::get('/calculadoras/{ilha}/{cargo}', 'Materials\Calculadoras@getCount')->name('GetCountCalculadoras');
    });

    Route::get('teste/{id}/{user}', 'Users\Superiors@register')->where('id', '[0-9]+')->where('user', '[0-9]+');

    /*********** Rotas de Monitoria ***********/
    Route::group(['prefix' => 'monitoring', 'middleware' => 'Monitoria'], function () {
        Route::group(['prefix' => 'contestar'], function () {
            // Motivos de contestação
            Route::delete('delete/{id}','Monitoria\Monitorias@deleteContest')->name('DeleteMotivoContestacao');
            Route::post('add','Monitoria\Monitorias@addContest')->name('AddMotivoContestacao');

            // Contestações
            route::get('contestacao/{id}', 'Monitoria\Contestacoes@showBy')->name('GetContestacaoByMon');

        });

        Route::get('manager','Monitoria\Monitorias@index')
            ->name('GetMonitoriasIndex');

        Route::get('create','Monitoria\Laudos@create')
            ->name('GetMonitoriasCreate')
            ->middleware('CreateApplyLaudo');

        Route::get('editLaudo/{id}','Monitoria\Laudos@edit')
            ->name('GetMonitoriasEdit')
            ->middleware('CreateApplyLaudo');

        Route::group(['prefix' => 'save'],function() {
            Route::post('makeLaudo/{user}', 'Monitoria\Laudos@store')
            ->name('PostLaudosStore');

            Route::put('editLaudo/{user}', 'Monitoria\Laudos@update')
            ->name('PutLaudosEdit');

            Route::post('storeMonitoria/{user}', 'Monitoria\Monitorias@store')
                    ->name('PostMonitoriaStore');
        });

        Route::post('toApply/{model}/','Monitoria\Laudos@toApply')->name('PostLaudoToApply')->middleware('CreateApplyLaudo');
        Route::get('toApply/{model}/','Monitoria\Laudos@toApply')->name('GetLaudoToApply')->middleware('CreateApplyLaudo');
    /**Supervisão */
        Route::get('/supervision', 'Relatorios\Monitorias@supervision');

        Route::get('/findfeedback', 'Relatorios\Monitorias@index')->name('FindFeedBack');

        Route::get('/findresult', 'Relatorios\Monitorias@findresult')->name('FindResult');

        //editar
        Route::get('/edit/{id}','Monitoria\Monitorias@edit')->name('GetMonitoriaEdit');
        Route::put('/edit/{id}/{user}','Monitoria\Monitorias@update')->name('PutMonitoriaEdit');


    });

    /*********** rotas de edição de Gerenciamento ***********/
    Route::group(['prefix' => 'manager'], function () {

        /* Permissões */
        Route::group(['prefix' => 'permissions', 'middleware' => 'SetPermissions'], function () {

            Route::get('/','Permissions\Permissions@index')->name('GetPermissionsIndex');

            Route::get('/{id}','Permissions\Permissions@index')
                ->where('id',"[0-9]+")
                ->name('GetPermissionsIndexUser');
        });

        Route::group(['prefix' => 'areas', 'middleware' => 'web'], function () {

            Route::get('/{area_type}','Users\Carteiras@areas')->name('GetAreasIndex');
            Route::get('carteira/{carteira}','Users\Carteiras@getSetoresIlhasByCart')->name('GetAreasgetSetoresIlhasByCart');
            
            Route::put('sync','Users\Carteiras@sync')->name('PutSyncAreas');
            Route::delete('sync','Users\Carteiras@destroy')->name('DeleteSyncAreas');

            Route::put('syncIlha','Users\Ilhas@update')->name('PutSyncIlhas');

            Route::group(['prefix' => 'create'], function () {
                Route::post('carteira','Users\Carteiras@store')->name('PostCreateCarteira');
                Route::post('setor','Users\Setores@store')->name('PostCreateSetor');
                Route::post('ilha','Users\Ilhas@store')->name('PostCreateIlha');
            });
        });

        /**/

        /* Gerenciar materiais - desativada */
        Route::get('/materials', 'Users\Users@manageMaterials')
        ->name('GetMaterialsManage');

        /* gerenciamento de usuários */
        Route::group(['prefix' => 'user', 'middleware' => 'ManagerUsers'], function () {

            Route::get('/', 'Users\Users@managerUserView')
                ->name('GetUsersManagerUser');

            Route::get('restore_deleted', 'Users\Users@managerUserViewRestore')
                ->name('GetUsersManagerUserDeleted');

            Route::post('restore/{userAction}/{user}','Users\Users@restore')->name('PostRestoreUser');

            Route::get('/register', 'Users\Users@registerUserView')
                ->name('GetUsersRegisterUser')->middleware('AddUser');
        });

        /*********** rotas de edição e Gerenciamento de Medidas Disciplinares ***********/
        Route::group(['prefix' => 'measures', 'middleware' => 'Measures'], function () {

            Route::get('/manager', 'Measures\Measures@index')
                ->name('GetMeasuresIndex');

            Route::get('/create/{model}', 'Measures\Measures@create')
                ->name('GetMeasuresCreate')
                ->middleware('CreateMeasures');


            Route::get('export/{id}', 'Measures\Measures@export')
                ->name('GetMeasureExport');
        });

        /*********** rotas Relatorios ***********/
        Route::group(['prefix' => 'report'], function () {

            //rotas que retornam view
            Route::get('/clima', 'Relatorios\Relatorios@clima')
                ->name('GetRelatorioClima');

            Route::get('/quizzes', 'Relatorios\Relatorios@quiz')
                ->name('GetRelatorioQuiz');

            // Analitico provisório
            Route::post('/quizDataBy/{id}','Relatorios\Quizzes@quizDataById')->name('GetReportQuizDataById');

            Route::get('/links_tags', 'Relatorios\Relatorios@linkTag')
                ->name('GetRelatorioLinkTag');

            // Relatório de Materiais
            Route::get('/{type}/{id}','Relatorios\Materiais@getReportMaterials')
                ->name('GetMaterialsReport')
                ->middleware('ManagerWiki');

            Route::post('/chartview','Relatorios\Materiais@getViewsCharts')
                ->name('GetMaterialsChart');

            // monitorias
            Route::group(['prefix' => 'monitoring', 'middleware' => 'Monitoria'], function () {

                Route::get('/byCpfCli','Relatorios\Monitorias@ByCpfCli')->name('GetMonitoriasByCpfCli');

                Route::group(['prefix' => 'mediaSegments'], function () {
                    Route::get('/index', 'Relatorios\Monitorias@mediaSegments')
                        ->name('GetMonitoriasMediaSegments');

                    Route::post('/search/{id}/{type}', 'Relatorios\Monitorias@searchDetailSegment')
                        ->name('MediaByIlhaPost');

                });
                Route::group(['prefix' => 'supervisor'], function () {
                    Route::get('/search', 'Relatorios\Monitorias@findmonitoring')
                    ->name('FindMonitoring');

                    Route::post('/find/{id}', 'Relatorios\Monitorias@findmonitoringByDate')
                        ->name('PostFeedbacksFindMonitoring');

                    Route::get('/findcategory', 'Relatorios\Monitorias@ilhafind')
                        ->name('FeedbacksFindIlha');

                    Route::post('/findscategory/{id}', 'Relatorios\Monitorias@ilhafindPost')
                        ->name('FeedbacksFindIlhaPost');

                    Route::get('/findoperator', 'Relatorios\Monitorias@findoperator')
                        ->name('PostFeedbacksFindOperator');

                    Route::post('/findoperator/{id}', 'Relatorios\Monitorias@findmonitoringByDateOperator')
                        ->name('PostFeedbacksFindOperator');


                    Route::get('/evolutionoperator', 'Relatorios\Monitorias@findEvolutionOperator')
                        ->name('GetFeedbacksEvolutionOperator');

                    Route::post('/evolutionoperator/{id}', 'Relatorios\Monitorias@findEvolutionOperator')
                        ->name('PostFeedbacksEvolutionOperator');

                });

                Route::group(['prefix' => 'agent'], function () {
                    Route::get('/search', 'Relatorios\Monitorias@findmonitoringAgent')
                    ->name('FindMonitoringByAgent');

                    Route::post('/evolution/{id}', 'Relatorios\Monitorias@findmonitoringAgent')
                        ->name('PostMonitoriasFindByAgent');

                });

                Route::group(['prefix' => 'analytic'], function () {
                    Route::get('search','Relatorios\Monitorias@reportIndexAll')
                        ->name('GetMonitoringAll');

                    Route::post('search','Relatorios\Monitorias@analyticsSearch')
                        ->name('PostRelatoriosAnalytics');

                });

                Route::group(['prefix' => 'sign'], function () {
                    Route::post('search','Relatorios\Monitorias@searchSign')
                        ->name('PostRelatoriosSign');
                });

                // Route::group(['prefix' => 'operator'], function () {
                //     Route::get('findAll','Relatorios\Monitorias@reportIndexAll')
                //     ->name('GetMonitoringAlla');

                // });

                // Route::group(['prefix' => 'signs'], function () {
                //     Route::get('findAll','Relatorios\Monitorias@reportIndexAll')
                //     ->name('GetMonitoringAlle');

                // });
            });


            //exporta relatorios
            Route::group(['prefix' => 'export'], function () {

                //exporta em excel
                Route::group(['prefix' => 'excel'], function () {
                    Route::post('environment/{ilhas}', 'Relatorios\Clima@environment')
                    ->name('PostClimaEnvironment');
                });

                // exporta em pdf
                Route::group(['prefix' => 'PDF'], function () {
                });
            });
        });

        Route::group(['prefix' => 'circular'], function () {

            Route::get('/', 'Materials\Circulares@create')
                ->name('GetCircularesCreate')
                ->middleware('ManagerWiki');

            Route::post('/edit/{id}/{user}', 'Materials\Circulares@edit')
            ->where('id', '[0-9]+')
            ->where('user', '[0-9]+')
            ->name('PostCircularesEdit');

            Route::get('/edit/{id}', 'Materials\Circulares@editGet')
                ->where('id', '[0-9]+')
                ->name('GetCircularesEdit')
                ->middleware('ManagerWiki');

            Route::post('/save/{user}', 'Materials\Circulares@store')
            ->where('user', '[0-9]+')
            ->name('PostCircularesStore');

            Route::post('saveFile/{user}', 'Materials\Circulares@file')
            ->where('user', '[0-9]+')
            ->name('saveFileCirc');

            Route::delete('/delete/{id}/{user}', 'Materials\Circulares@destroy')
                ->name('DeleteCircular'); 
        });

        Route::group(['prefix' => 'script'], function () {

            Route::get('/', 'Materials\Roteiros@create')
                ->name('GetRoteirosCreate')
                ->middleware('ManagerWiki');

            Route::post('/edit/{id}/{user}', 'Materials\Roteiros@edit')
            ->where('id', '[0-9]+')
            ->where('user', '[0-9]+')
            ->name('PostRoteirosEdit');

            Route::get('/edit/{id}', 'Materials\Roteiros@editGet')
            ->where('id', '[0-9]+')
            ->name('GetRoteirosEdit');

            Route::delete('/delete/{id}/{user}', 'Materials\Roteiros@destroy')
                ->where('id', '[0-9]+')
                ->where('user', '[0-9]+')
                ->name('DeleteScript');

            Route::post('/save/{user}', 'Materials\Roteiros@store')
            ->where('user', '[0-9]+')
            ->name('PostRoteirosStore');

            Route::post('saveFile/{user}', 'Materials\Roteiros@file')
            ->where('user', '[0-9]+')
            ->name('saveFileScript');
        });

        Route::group(['prefix' => 'material'], function () {

            Route::get('/', 'Materials\Materiais@create')
                ->name('GetMateriaisCreate')
                ->middleware('ManagerWiki');

            Route::post('/edit/{id}/{user}', 'Materials\Roteiros@edit')
                ->where('id', '[0-9]+')
                ->where('user', '[0-9]+')
                ->name('GetMateriaisEdit');

            Route::get('/edit/{id}', 'Materials\Materiais@editGet')
                ->where('id', '[0-9]+')
                ->name('GetMateriaisEdit')
                ->middleware('ManagerWiki');

            Route::delete('/delete/{id}/{user}', 'Materials\Materiais@destroy')
                ->where('id', '[0-9]+')
                ->where('user', '[0-9]+')
                ->name('DeleteMaterial');

            Route::post('/save/{user}', 'Materials\Materiais@store')
            ->where('user', '[0-9]+')
            ->name('PostMateriaisStore');

            Route::post('saveFile/{user}', 'Materials\Materiais@file')
            ->where('user', '[0-9]+')
            ->name('saveFileScript');
        });

        Route::group(['prefix' => 'video'], function () {

            Route::get('/', 'Materials\Videos@create')
                ->name('GetVideosCreate')
                ->middleware('ManagerWiki');

            Route::post('/edit/{id}/{user}', 'Materials\Videos@edit')
                ->where('id', '[0-9]+')
                ->where('user', '[0-9]+')
                ->name('GetVideosEdit')
                ->middleware('ManagerWiki');

            Route::get('/edit/{id}', 'Materials\Videos@editGet')
            ->where('id', '[0-9]+')
            ->name('GetVideosEdit');

            Route::delete('/delete/{id}/{user}', 'Materials\Videos@destroy')
                ->where('id', '[0-9]+')
                ->where('user', '[0-9]+')
                ->name('DeleteVideo');

            Route::post('saveFile/{user}', 'Materials\Videos@file')
            ->where('user', '[0-9]+')
            ->name('saveFileSVideo');
        });

        Route::group(['prefix' => 'calculator'], function () {

            Route::get('/', 'Materials\Calculadoras@create')
            ->name('GetCalculadorasCreate');

            Route::get('/manage', 'Materials\Calculadoras@edit')
            ->name('GetCalculadorasManage');

            Route::post('/edit/{id}/{user}', 'Materials\Calculadoras@edit')
            ->where('id', '[0-9]+')
            ->where('user', '[0-9]+')
            ->name('PostCalculadorasEdit');

            Route::get('/edit/{id}', 'Materials\Calculadoras@editGet')
            ->where('id', '[0-9]+')
            ->name('GetCalculadorasEdit');

            Route::post('/save/{user}', 'Materials\Calculadoras@store')
            ->where('user', '[0-9]+')
            ->name('PostCalculadorasStore');

            Route::post('saveFile/{user}', 'Materials\Calculadoras@file')
            ->where('user', '[0-9]+')
            ->name('saveFileCalc');

            Route::delete('/delete/{id}/{user}', 'Materials\Calculadoras@destroy')
                ->name('DeleteCalc');
        });

        Route::group(['prefix' => 'phone'], function () {
            Route::get('/', 'Materials\Telefones@create')
                ->name('GetTelefonesCreate')
                ->middleware('ManagerWiki');

            Route::post('save', 'Materials\Telefones@store')
                ->name('PostTelefonesStore');
        });

    });

    Route::middleware('Wiki')->group(function () {
        /*********** UPDATE ***********/
        Route::group(['prefix' => 'update'], function () {
            Route::put('circular/{user}','Materials\Circulares@update')->where('user','[0-9]+')->name('PutCircularesUpdate');
            Route::put('material/{user}','Materials\Materiais@update')->where('user','[0-9]+')->name('PutMaterialUpdate');
            Route::put('roteiros/{user}','Materials\Roteiros@update')->where('user','[0-9]+')->name('PutRoteirosUpdate');
            Route::put('video/{user}','Materials\Videos@update')->where('user','[0-9]+')->name('PutVideosUpdate');
        });
        /*********** Calculadoras ***********/
        Route::group(['prefix' => 'Calculadoras'], function () {

            Route::get('/adicional', 'Materials\Calculadoras@Adicional')
            ->name('Calculadoraadicional');

            Route::get('/simuladorlimites', 'Materials\Calculadoras@Simulador')
            ->name('CalculadoraLimites');

            Route::get('/simuladorimobiliario', 'Materials\Calculadoras@Imobiliario')
            ->name('CalculadoraImobiliario');

            Route::get('/painel', 'Materials\Calculadoras@Painel')
            ->name('CalculadoraPainel');

            Route::get('/painel/getBase/{id}/{ilha}/{cpf}','Materials\Calculadoras@getPainelCPF');

            Route::get('/siape', 'Materials\Calculadoras@Siape')
            ->name('CalculadoraSiape');

            Route::get('/dilatacao', 'Materials\Calculadoras@Dilatacao')
            ->name('CalculadoraDilatacao');

            Route::get("/baseConsultaSR","Materials\Calculadoras@indexBase");

            Route::post("/baseConsultaSearch","Materials\Calculadoras@searchContract")
                ->name("GetCalculadorasBaseConsultaContrato");
        });

        /*********** WIKI ***********/
      
        Route::get('/pesquisarscript/{campo}/{valor}', 'Materials\Roteiros@pesquisar')
        ->name('pesquisarScripts');

        Route::get('/pesquisarcircular/{campo}/{valor}/{ilha}/{cargo}', 'Materials\Circulares@pesquisar')
        ->name('pesquisarCirculares');

        Route::get('/pesquisarvideo/{campo}/{valor}', 'Materials\Videos@pesquisar')
        ->name('pesquisarVideos');

        Route::get('/filtrosvideo/{valor}', 'Materials\Videos@filtros')
        ->name('filtrosVideo');

        Route::get('/pesquisar/{campo}/{valor}/{ilha}', 'Materials\Materiais@pesquisar')
        ->name('pesquisarMaterials');

        Route::get('/filtros/{valor}', 'Materials\Materiais@filtros')
        ->name('filtros');
        
        Route::get('/wikicirculares', 'Materials\Circulares@selecionarCircular')
        ->name('CircularesWiki');

        Route::get('/circulares/{ilha}', 'Materials\Circulares@index')
        ->where('ilha', '[0-9]+')
        ->name('CircularesWiki');

        Route::get('/circulares/{year}/{ilha}', 'Materials\Circulares@year')
        ->name('CircularesYearWiki');


        Route::get('/calculadoras/{ilha}', 'Materials\Calculadoras@indexView')
        ->where('ilha', '[0-9]+')
        ->name('CalculadorasWiki');

        Route::get('/pdf', 'Materials\SubLocais@pdf')
        ->name('Calculadoras Wiki');

        Route::get('circulars/{ilha}', 'Materials\Circulares@index')
        ->name('GetCircularesIndex');

        Route::get('scripts/{ilha}', 'Materials\Roteiros@index')
        ->name('GetRoteirosIndex');

        Route::get('/scripts/{segment}/{ilha}', 'Materials\Roteiros@segment')
        ->name('RoteirosSegmentWiki');


        Route::get('materials/{ilha}', 'Materials\Materiais@index')
        ->name('GetMateriaisIndex');

        Route::get('materialsteste/{ilha}', 'Materials\Materiais@index2')
        ->name('GetMateriaisIndexteste');

        Route::get('/materials/{segment}/{ilha}', 'Materials\Materiais@segment')
        ->name('MateriaisSegmentWiki');

        Route::get('videos/{ilha}', 'Materials\Videos@index')
        ->name('GetVideosIndex');

        Route::get('videos/{segment}/{ilha}', 'Materials\Videos@segment')
        ->name('GetVideosSegment');

        Route::get('lidos/{ilha}', 'Users\Users@lidos')
        ->name('GetLidosIndex');

        /*********** WIKI Relatorios Avançados***********/

        Route::get('videosrelatorios/{ilha}', 'Materials\Videos@relatorio')
        ->name('GetVideosRelatorioIndex');


        /*********** WIKI Calculadoras***********/

        Route::get('/adicional', 'Materials\Calculadoras@Adicional')
        ->name('Calcualdoraadicional');

        Route::get('/painel', 'Materials\Calculadoras@Painel')
        ->name('CalculadoraPainel');

        Route::get('/painelteste', 'Materials\Calculadoras@Painelteste')
        ->name('CalculadoraPainel');

        Route::get('/siape', 'Materials\Calculadoras@Siape')
        ->name('CalculadoraSiape');

        Route::get('/cartoes', 'Materials\Calculadoras@Cartoes')
        ->name('CalculadoraCartoes');

        Route::get('/dilatacao', 'Materials\Calculadoras@Dilatacao')
            ->name('CalculadoraDilatacao');

        Route::get('/simuladorlimites', 'Materials\Calculadoras@Simulador')
        ->name('CalculadoraLimites');

        Route::get('/simuladorimobiliario', 'Materials\Calculadoras@Imobiliario')
        ->name('CalculadoraImobiliario');

        Route::get('calculators/{ilha}', 'Materials\calculadoras@index')
        ->name('GetCalculadorasIndex');
    });

    Route::get('cpf','Materials\Calculadoras@CpfPending')->name('cpf');



    /*********** Quizz ***********/
    Route::group(['prefix' => 'quiz', 'middleware' => 'Quizzes'], function () {

        Route::get('/get/index/{ilha}/{id}/{skip}/{take}', 'Quizzes\Quizzes@index')
        ->name('GetQuizIndex');

        Route::get('/create', 'Quizzes\Quizzes@create')
            ->name('GetQuizCreate')
            ->middleware('CreateQuizzes');

        Route::get('view/{id}', 'Quizzes\Quizzes@view')->name('GetQuizzesView'); //responder

        Route::get('view/correct/{id}', 'Quizzes\Quizzes@correct')->name('GetQuizzesCorrect');
    });

    /*********** Calculadoras ***********/
    Route::group(['prefix' => 'calculadoras'], function () {

        Route::get('/adicional', 'Materials\Calculadoras@Adicional')
        ->name('Calculadoraadicional');

        Route::get('/simuladorlimites', 'Materials\Calculadoras@Simulador')
        ->name('CalculadoraLimites');

        Route::get('/simuladorimobiliario', 'Materials\Calculadoras@Imobiliario')
        ->name('CalculadoraImobiliario');

        Route::get('/painel', 'Materials\Calculadoras@Painel')
        ->name('CalculadoraPainel');

        Route::get('/siape', 'Materials\Calculadoras@Siape')
        ->name('CalculadoraSiape');

        Route::get('/dilatacao', 'Materials\Calculadoras@Dilatacao')
        ->name('CalculadoraDilatacao');

        Route::get('/cartoes', 'Materials\Calculadoras@Cartoes')
        ->name('CalculadoraCartoes');

    });


    /********** FAQ ********/

    route::get('/faq','Faq\Faq@index')->name('Faq');


    /*********** Dados do usuário ***********/
    Route::group(['prefix' => 'user'], function () {
        Route::post('style/{id}', 'Users\Users@style')->name('PostUsersStyle');
        Route::post('name/{id}', 'Users\Users@name')->name('PostUsersName');
        Route::post('username/{id}', 'Users\Users@username')->name('PostUsersuUsername');
        Route::get('pic/{id}/{pic}', 'Users\Users@setAvatar')->where('id', '[0-9]+')->name('GetUsersAvatar');
    });

    //registrar usuarios
    Route::group(['prefix' => '/register', 'middleware' => 'AddUser'], function () {
        Route::get('/', 'Users\Users@register')->name('GetRegisterUser');

        Route::post('/save', 'Users\Users@store')->name('PostRegisterUser');
    });


        //Inserts Wiki
    Route::group(['prefix' => 'insert'], function () {
            Route::post("/calculator", "Materials\Calculadoras@store")->name('PostMaterialsCalculadora'); //Inserir Calculadoras
            Route::post("/circular", "Materials\Circulares@store")->name('PostMaterialsCircular'); //Inserir Circulares
            Route::post("/script", "Materials\Roteiros@store")->name('PostMaterialsRoteiro'); //Inserir Roteiros
            Route::post("/material", "Materials\Materiais@store")->name('PostMaterialsStore'); //Inserir Materiais
            Route::post("/video/{user}", "Materials\Videos@store")->name('PostVideosStore'); //Inserir Materiais
        });

    /*********** Chat ADMIN ***********/
    Route::group(['prefix' => 'chats', 'middleware' => 'CreateDeleteChat'], function () {
        Route::get('new/groups/{id}', 'Chats\Chats@groupCreate')
        ->name('GetNewChat');

        Route::get('delete/groups/{cargo}/{user}', 'Chats\Chats@groupDelete')
        ->name('GetDeleteChat');

        Route::post('createGroup/{id}/{data}', 'Chats\Chats@createGroup')
        ->name('PostChatsCreateGroup');

        Route::post('deleteGroups/{id}/{data}', 'Chats\Chats@deleteGroup')
        ->name('PostDeleteChat');
    });

    Route::group(['prefix' => 'tab'], function () {
        Route::group(['prefix' => 'operator'], function () {
            Route::get('/','Tabs\Tabulacoes@operator')
                ->name('GetTabsOperador');
        });

        Route::group(['prefix' => 'supervisor'], function () {
            Route::get('/','Tabs\Tabulacoes@supervisor')
                ->name('GetTabsSupervisor');
        });

        Route::group(['prefix' => 'backoffice'], function () {
            Route::get('/','Tabs\Tabulacoes@backoffice')
                ->name('GetTabsBackOffice');
        });
    });
});

//ADMINS ROUTES
Route::group(['prefix' => 'admin', 'middleware' => 'SetPermissions'], function(){
    Route::get('permissions/by/user/','Permissions\Permissions@getUserPermissions')
        ->name('GetPermissionsByUser');
    Route::post('permissions/sync','Permissions\Permissions@store')
        ->name('PostPermissionsStore');
});
