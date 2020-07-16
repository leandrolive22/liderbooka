<?php

/*********** Autenticação ***********/

use Illuminate\Support\Facades\Hash;

Auth::routes(['register' => false]);

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

Route::group(['middleware' => ['auth']], function () {

    //Controller de redirecionamento - login backend
    Route::get('/home', function () {
        return redirect('home/page');
    })->name('home');

    Route::get('about_blank/',function ()
    {
        return view('blank');
    });

    Route::get('/home/{n}', 'HomeController@index')->name('homeN');
    /*********** rotas do menu de navegação ***********/
    Route::group(['prefix' => 'messages'], function () {
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
    Route::get('/wiki/{ilha}', 'Users\Users@wiki')->name('GetUsersWiki');

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
    Route::group(['prefix' => 'monitoring'], function () {
        Route::get('manager','Monitoria\Monitorias@index')
            ->name('GetMonitoriasIndex');

        Route::get('create','Monitoria\Monitorias@create')
            ->name('GetMonitoriasCreate');

        Route::get('toApply/{model}/','Monitoria\Laudos@toApply');
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

        Route::get('/materials', 'Users\Users@manageMaterials')
        ->name('GetMaterialsManage');

        Route::group(['prefix' => 'user'], function () {

            Route::get('/', 'Users\Users@managerUserView')
                ->name('GetUsersManagerUser');

            Route::get('/register', 'Users\Users@registerUserView')
                ->name('GetUsersRegisterUser');
        });

        /*********** rotas de edição e Gerenciamento de Medidas Disciplinares ***********/
        Route::group(['prefix' => 'measures'], function () {
            
            Route::get('/manager', 'Measures\Measures@index')
                ->name('GetMeasuresIndex');
            
            Route::get('/create/{model}', 'Measures\Measures@create')
                ->name('GetMeasuresCreate');

            
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

            Route::get('/links_tags', 'Relatorios\Relatorios@linkTag')
                ->name('GetRelatorioLinkTag'); 
                
            Route::get('/{type}/{id}','Relatorios\Materiais@getReportMaterials') 
                ->name('GetMaterialsReport');
               
            Route::post('/chartview','Relatorios\Materiais@getViewsCharts') 
                ->name('GetMaterialsChart');

            // monitorias
            Route::group(['prefix' => 'monitoring'], function () {

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
                        ->name('PostFeedbacksEvolutionOperator'); 

                    Route::post('/evolutionoperator/{id}', 'Relatorios\Monitorias@findEvolutionOperator')
                        ->name('PostFeedbacksEvolutionOperatorPost'); 

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
            ->name('GetCircularesCreate');

            Route::post('/edit/{id}/{user}', 'Materials\Circulares@edit')
            ->where('id', '[0-9]+')
            ->where('user', '[0-9]+')
            ->name('PostCircularesEdit');

            Route::get('/edit/{id}', 'Materials\Circulares@editGet')
            ->where('id', '[0-9]+')
            ->name('GetCircularesEdit');

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
            ->name('GetRoteirosCreate');

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
            ->name('DeleteCircular');

            Route::post('/save/{user}', 'Materials\Roteiros@store')
            ->where('user', '[0-9]+')
            ->name('PostRoteirosStore');

            Route::post('saveFile/{user}', 'Materials\Roteiros@file')
            ->where('user', '[0-9]+')
            ->name('saveFileScript');
        });

        Route::group(['prefix' => 'material'], function () {

            Route::get('/', 'Materials\Materiais@create')
            ->name('GetMateriaisCreate');

            Route::post('/edit/{id}/{user}', 'Materials\Roteiros@edit')
            ->where('id', '[0-9]+')
            ->where('user', '[0-9]+')
            ->name('GetMateriaisEdit');

            Route::get('/edit/{id}', 'Materials\Materiais@editGet')
            ->where('id', '[0-9]+')
            ->name('GetMateriaisEdit');

            Route::delete('/delete/{id}/{user}', 'Materials\Materiais@destroy')
            ->where('id', '[0-9]+')
            ->where('user', '[0-9]+')
            ->name('DeleteCircular');

            Route::post('/save/{user}', 'Materials\Materiais@store')
            ->where('user', '[0-9]+')
            ->name('PostMateriaisStore');

            Route::post('saveFile/{user}', 'Materials\Materiais@file')
            ->where('user', '[0-9]+')
            ->name('saveFileScript');
        });

        Route::group(['prefix' => 'video'], function () {

            Route::get('/', 'Materials\Videos@create')
            ->name('GetVideosCreate');

            Route::post('/edit/{id}/{user}', 'Materials\Videos@edit')
            ->where('id', '[0-9]+')
            ->where('user', '[0-9]+')
            ->name('GetVideosEdit');

            Route::get('/edit/{id}', 'Materials\Videos@editGet')
            ->where('id', '[0-9]+')
            ->name('GetVideosEdit');

            Route::delete('/delete/{id}/{user}', 'Materials\Videos@destroy')
            ->where('id', '[0-9]+')
            ->where('user', '[0-9]+')
            ->name('DeleteCircular');

            Route::post('saveFile/{user}', 'Materials\Videos@file')
            ->where('user', '[0-9]+')
            ->name('saveFileScript');
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
            Route::get('/', 'Materials\Telefones@create')->name('GetTelefonesCreate');
            Route::post('save', 'Materials\Telefones@store')->name('PostTelefonesStore');
        });

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

        Route::get('/painel/getBase/{id}/{ilha}/{cpf}','Materials\Calculadoras@getPainelCPF')->name('');
        
        Route::get('/siape', 'Materials\Calculadoras@Siape')
        ->name('CalculadoraSiape');

        Route::get('/dilatacao', 'Materials\Calculadoras@Dilatacao')
        ->name('CalculadoraDilatacao');

        Route::get("/baseConsultaSR","Materials\Calculadoras@indexBase");

        Route::post("/baseConsultaSearch","Materials\Calculadoras@searchContract")
            ->name("GetCalculadorasBaseConsultaContrato");
    });

    /*********** WIKI ***********/
    Route::get('/wikicirculares', 'Materials\Circulares@selecionarCircular')
    ->name('Circulares Wiki');

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

    Route::get('/dilatacao', 'Materials\Calculadoras@Dilatacao')
        ->name('CalculadoraDilatacao');

    Route::get('/simuladorlimites', 'Materials\Calculadoras@Simulador')
    ->name('CalculadoraLimites');

    Route::get('/simuladorimobiliario', 'Materials\Calculadoras@Imobiliario')
    ->name('CalculadoraImobiliario');

    Route::get('calculators/{ilha}', 'Materials\calculadoras@index')
    ->name('GetCalculadorasIndex');

    Route::get('cpf','Materials\Calculadoras@CpfPending')->name('cpf');



    /*********** Quizz ***********/
    Route::group(['prefix' => 'quiz'], function () {

        Route::get('/get/{ilha}/{id}/{skip}', 'Quizzes\Quizzes@index')
        ->name('GetQuizIndex');

        Route::get('/create', 'Quizzes\Quizzes@create')
        ->name('GetQuizCreate');

        Route::get('view/{id}', 'Quizzes\Quizzes@view')->name('GetQuizzesView');

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

        //registrar usuario
    Route::group(['prefix' => '/register'], function () {
        Route::get('/', 'Users\Users@register')->name('GetRegisterUser');

        Route::post('/save', 'Users\Users@store')->name('PostRegisterUser');
    });


        //Inserts
    Route::group(['prefix' => 'insert'], function () {
            Route::post("/calculator", "Materials\Calculadoras@store")->name('PostMaterialsCalculadora'); //Inserir Calculadoras
            Route::post("/circular", "Materials\Circulares@store")->name('PostMaterialsCircular'); //Inserir Circulares
            Route::post("/script", "Materials\Roteiros@store")->name('PostMaterialsRoteiro'); //Inserir Roteiros
            Route::post("/material", "Materials\Materiais@store")->name('PostMaterialsStore'); //Inserir Materiais
            Route::post("/video/{user}", "Materials\Videos@store")->name('PostVideosStore'); //Inserir Materiais
        });

    /*********** Materiais ***********/
    Route::group(['prefix' => 'chats'], function () {
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