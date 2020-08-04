<?php

Route::post('/logout/{user}/{ilha}/','Logs\Logs@logout')
    ->where('user','[0-9]+')
    ->where('ilha','[0-9]+')
    ->name('logLogOut');

Route::group(['prefix' => 'data'],function(){
    Route::get('cargo/{id}','Users\Cargos@nameCargo')->name('GetCargoData');
    Route::post('clickLink/','Logs\Logs@clickLink')->name('PostLogsClicklink');
    Route::get('ilha/{id}','Users\Ilhas@nameIlha')->name('GetIlhaName');
    Route::get('reaction/{id}/{user}','Posts\Reactions@view');
    Route::get('setores/json/byCarteira/{id}', 'Users\Setores@byCarteiraJSON')->name('GetSetoresByCarteira');
    Route::get('setores/{id}','Users\Setores@name')->name('GetSetoresName');
    Route::get('setores/json/byCarteira/{id}', 'Users\Setores@byCarteiraJSON')->name('GetSetoresByCarteira');
    Route::get('sub_locais/ilha/{id}','Materials\SubLocais@byIlha')->name('GetSubLocalIlhaName');
    Route::get('sub_locais/byid/{id}','Materials\SubLocais@byid')->name('GetSubLocalIdName');
    Route::get('superior/{id}','Users\Superiors@getSup')->name('GetSuperiorData');
    Route::get('supervisor/{ilha}/','Users\Users@getSupervisores')->name('GetUsersSupervisores');
    Route::get('supervisor/{ilha}/{json}','Users\Users@getSupervisores')
                ->where('json','[0-1]')
                ->name('GetUsersSupervisoresJson');
    Route::get('coordenator/{setor}','Users\Users@getCoordenadores')->name('GetUsersGetCoordenadores');
    Route::get('manager','Users\Users@getGerentes')->name('GetUsersGerentes');
    Route::get('superintendente','Users\Users@getSuperintendentes')->name('GetUsersSuperintendentes');
    Route::get('{setor}/ilha/','Users\Ilhas@bySetor')->name('GetIlhabySetor');
    Route::get('wiki/count/nonread/{user}/{ilha}','Logs\Logs@countNotRead')->name('GetLogsCountRead');
    Route::get('user/{id}','Users\Users@byId')->name('GetUserById');
    Route::get('user/json/{id}','Users\Users@jsonById')->name('GetUserJsonById');
    Route::get('userPost/{userPost}','Users\Users@userPost');
    Route::get('ilha/get','Users\Ilhas@getIlhas')->name('getIlhasEdit');
    Route::get('ilha/getBy/{setor}','Users\Ilhas@getIlhas')->name('getIlhasEditBySetor');
    Route::post('ilha/edit/{id}','Users\Users@editIlha')->name('PostEditIlha');
    Route::get('searchInTable/user','Users\Users@searchInTable')->name('searchInTable');
});

//download materials
Route::group(['prefix' => 'download'], function () {

    Route::get('calculator/{id}/{user}','Materials\Calculadoras@download')
        ->where('id','[0-9]+')
        ->where('user','[0-9]+')
        ->name('GetDownloadCalculator');

    Route::get('circular/{id}/{user}','Materials\Circulares@download')
        ->where('id','[0-9]+')
        ->where('user','[0-9]+')
        ->name('GetDownloadCalculator');

    Route::get('script/{id}/{user}','Materials\Roteiros@download')
        ->where('id','[0-9]+')
        ->where('user','[0-9]+')
        ->name('GetDownloadCalculator');

});

// Medidas disciplinares
Route::group(['prefix' => 'measures'],function() {
    Route::post('/create/{bs4Id}', 'Measures\Measures@store')
                ->name('PostMeasuresStore');

    Route::get('/view/{id}', 'Measures\Measures@view')
        ->name('GetMeasuresView');

    Route::post('/resp/{id}', 'Measures\Measures@saveResp')
        ->name('PostMeasuresSaveResp');
});

//Manager Users
Route::group(['prefix' => 'user'], function () {

    //create User
    Route::post('{id}','Users\Users@store')
        ->where('id','[0-9]+')
        ->name('PostUsersStore');

    //get sup
    Route::get('sup/save/{id}/{user}','Users\Users@sup');

    Route::put('sup/edit/{user}','Users\Users@editSupervisor')->name("PutUsersEditSupervisor");

    //edit User
    Route::post('/update/{id}','Users\Users@editUser')
        ->name('PostUsersEditUser');

    //delete User
    Route::post('delete/','Users\Users@deleteUser')
        ->name('PostUsersDeleteUser');

    //change pass
    Route::post('changePass/{id}','Users\Users@changePass')->name('PostUsersPass');

    //reset user pass
    Route::post('resetPass/{id}/{user}/{ilha}','Users\Users@resetPass')
        ->where('id', '[0-9]+')
        ->where('user', '[0-9]+')
        ->where('ilha', '[0-9]+')
        ->name('PostUserResetPass');
});

/*********** Formulários - SELECT ***********/
//Dados de Formulários para <select></select>
Route::group(['prefix' => '/forms'], function () {

    Route::get('/cargos','Users\Cargos@index')
    ->name('GetFormUsersCargos');//Cargos

    Route::get('/carteiras','Users\Carteiras@index')
    ->name('GetFormUsersCarteiras');//Carteiras

    Route::get('/ilhas','Users\Ilhas@index')
    ->name('GetFormUsersIlhas');//Ilhas

    Route::get('/ilhas/post','Users\Ilhas@indexPost')
        ->name('GetFormIlhasPost');//Ilhas com público

    Route::get('/setores','Users\Setores@index')
    ->name('GetFormUsersSetores');//Setores

    Route::get('/superiores/{ilha}/{cargo}','Users\Users@superiores')
    ->where('ilha','[0-9]+')
    ->where('cargo','[0-9]+')
    ->name('GetFormUsersSuperiors');//Superiores

    Route::get('/sublocais','Materials\SubLocais@index')
    ->name('GetFormMaterialSubLocais');//Cards

    Route::get('/sublocais/{id}','Materials\SubLocais@byIlha')
    ->name('GetFormMaterialSubLocaisByIlha');//Cards por Ilha
});

/*********** Materiais ***********/
Route::get('/calculadoras/{ilha}','Materials\Calculadoras@index')->name('GetMaterialsCalculadoras'); //Traz as Calculadoras por Ilha

/***********  Posts ***********/
Route::group(['prefix' => 'post'], function () {
        Route::post("/insert/{id}","Posts\Posts@store")
            ->where(['id'=>'[0-9]+'])
            ->name('PostInsertPost');//Insere Posts

        Route::post("/delete/{id}/{user}","Posts\Posts@delete")
            ->where(['id'=>'[0-9]+'])
            ->name('PostInsertPost');//Insere Posts

        Route::post("/update/{id}","Posts\Posts@update")
            ->where('id','[0-9]+')
            ->name('PostUpdatePosts');//Altera Posts

        Route::get('/{ilha}/{skip}/{user}/{cargo}','Posts\Posts@indexJSON');

});

//Reações
Route::group(['prefix' => 'reaction'], function () {

    Route::get('/humour/{n}/{user}/{ilha}','Users\Users@humour')
        ->where('id','[1-3]')
        ->where('user','[0-9]+')
        ->where('ilha','[0-9]+')
        ->name('GetUsersHumour');

    Route::get('humour/{user}', 'Users\Users@checkHumour')
        ->name('GetUsersCheckHumour');

    Route::get('humour/chart/{id}/{cargo}/{ilha}','Users\Users@getHumourtToChart')
        ->name('GetUsersHumourChart');

    Route::get("/{id}","Posts\Reactions@index")
    ->where('id','[0-9]+')
    ->name('GetReactList');//Pega reações do post

    Route::post('/insert/{post_id}/{react_id}/{user}',"Posts\Reactions@reaction")
    ->where('post_id','[0-9]+')
    ->where('react_id','[0-2]')
    ->where('user','[0-9]+')
    ->name('PostNewReact');//Reage ao post

    Route::post('/delete/{post_id}/{react_id}/{user}',"Posts\Reactions@delete")
        ->where('post_id','[0-9]+')
        ->where('react_id','[0-2]')
        ->where('user','[0-9]+')
        ->name('PostNewReact');//Reage ao post
});

Route::get('/readed/{user}/{type}', 'Logs\Logs@checkRead')->name('GetLogsCheckread');

//Chat
Route::group(['prefix' => 'msg'], function () {
    Route::get('/{id}/{user}/','Chats\Chats@receiveMsg')
        ->where('id','[0-9]+')
        ->where('user','[0-9]+')
        ->name('GetChatsMsg');

    Route::get('getGroup/{id}','Chats\Chats@getGroupsByUser')
        ->where('id','[0-9]+');

    Route::get('/last/{id}/{user}','Chats\Chats@lastMsg')
        ->where('id','[0-9]+')
        ->where('user','[0-9]+')
        ->name('GetChatsLastMsg');

    Route::get('/contacts/{id}/{ids}','Chats\Chats@getContacts')
        ->where('id','[0-9]+');

    Route::get('/number/{id}/{user}','Chats\Chats@numberMsg')
        ->where('id','[0-9]+')
        ->where('user','[0-9]+')
        ->name('GetChatsMsgNumber');

    Route::get('/notify/{id}','Chats\Chats@notifyMsg')
        ->where('id','[0-9]+')
        ->name('GetChatsNotify'); //Pega notificações de mensagens

    Route::post('/save/{user}/{id}','Chats\Chats@storeMsg')
        ->where('id','[0-9]+')
        ->where('user','[0-9]+')
        ->name('PostChatStore');

    Route::group(['prefix' => 'group'], function () {
        Route::get('/{id}/{user}/','Chats\Chats@receiveGroupMsg')
            ->where('id','[0-9]+')
            ->where('user','[0-9]+')
            ->name('GetChatsGroupMsg');
    });

});

// Monitoria
Route::group(['prefix' => 'monitoring'], function () {
    Route::post('makeLaudo/{user}', 'Monitoria\Laudos@store')
            ->name('PostLaudosStore');

    Route::post('storeMonitoria/{user}', 'Monitoria\Monitorias@store')
            ->name('PostMonitoriaStore');

    Route::get('view/{id}','Monitoria\Monitorias@view');

    Route::group(['prefix' => 'delete'], function () {
        Route::delete('/{user}/{id}','Monitoria\Monitorias@delete');

        Route::delete('laudo/{user}/{id}','Monitoria\Laudos@delete');
    });

    Route::group(['prefix' => 'get'], function () {
        Route::get('supervisor/{id}','Monitoria\Monitorias@navSuper')->name('GetMonitoriasNavSuper');

        Route::get('operator/{id}','Monitoria\Monitorias@navOpe')->name('GetMonitoriasOperador');
    });

    Route::put('operator/feedback/{id}/{option}/', 'Monitoria\Monitorias@operatorFeedback');
    Route::put('supervisor/feedback/{id}/', 'Monitoria\Monitorias@supervisorFeedback');

    Route::group(['prefix' => 'exports'], function () {
        Route::post('analytics/{boolExport}','Relatorios\Monitorias@analyticsSearch')->name('PostMonitoriasExportAnalytics');
    });
});

// Quiz api
Route::group(['prefix' => 'quiz'], function () {
    Route::post('/save/{user}', 'Quizzes\Quizzes@store')->name('PostQuizCreate');
    Route::delete('/{user}/{id}', 'Quizzes\Quizzes@delete')->name('DeleteQuizzesDelete');
    Route::get('options/{id}', 'Quizzes\Quizzes@option');
    Route::post('saveAnswer','Quizzes\Quizzes@saveAnswers')->name('PostQuizzesAnswer');
    Route::post('correct/answer','Quizzes\Quizzes@correctAnswer')->name('PostQuizzesCorrectAnswer');
});

Route::group(['prefix' => 'sign'],function () {
    Route::get('/{user}/{ilha}/{id}/{type}','Logs\Logs@checkSign')->name('GetLogsSign');
    Route::get('check/{user}/{id}/{type}','Logs\Logs@checkAllMaterials')->name('GetLogsChecKAll');
    Route::post('/circular/{hash}/{user}/{ilha}/{id}','Logs\Logs@signCirc');
});

Route::group(['prefix' => 'phone'], function () {
    Route::get('json/{setor}','Materials\Telefones@indexJSON')->name('GetTelefonesIndexJSON');
    Route::delete('delete/{user}/{ilha}/{id}', 'Materials\Telefones@delete');
});

// Relatórios
Route::group(['prefix' => 'reports'], function () {
    Route::post('get/{id}','Relatorios\Relatorios@getLinkTag')->name('PostRelatoriosGetLinkTag');

    Route::group(['prefix' => 'materials'], function() {
        Route::get('chart/{id}/{ilha}/{type}','Relatorios\Materiais@getViewsCharts')
            ->name('GetViewsCharts');
    });

});

// Exportações
Route::group(['prefix' => 'export'], function() {
    Route::group(['prefix' => 'excel'], function () {
        Route::post('basic/datatable/{id}/{ilha}','Tools\ExcelExports@basicDatatable')->name('PostApiExportBasicDatatable');
    });

    Route::group(['prefix' => 'pdf'], function () {

    });
});

