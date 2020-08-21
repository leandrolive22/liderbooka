@extends('layouts.app',['current' => 'adm'])
@section('content')

<!-- START PAGE CONTAINER -->
<div class="page-container">

    <!-- PAGE CONTENT -->
    <div class="page-content">

        @component('assets.components.x-navbar')
        @endcomponent
        <div class="row">
            <div class="col-md-12">
                {{-- preloader page --}}
                <div class="spinner-grow text-dark" role="status" id='loadingPreLoader'
                style="width:20rem; height:20rem; margin-left:35%; margin-right:35%; margin-top:10%;">
                <span class="sr-only">Loading...</span>
            </div>
            {{-- Content page  --}}
            <div class="panel panel-default" id="managerUsers" style="display:none;">

                <div class="panel-heading ui-draggable-handle">
                    <h3 class="panel-title">
                        <strong>
                            Gerenciamento de Usuário
                        </strong>
                        <div class="spinner-grow text-dark align-center text-center pull-center" role="status" style="display: none;" id='loadingDataPreLoader'>
                            <span class="sr-only">Loading...</span>
                        </div>
                    </h3>
                    {{-- Excluir --}}
                    @if(in_array(34, session('permissionsIds')) || in_array(1,session('permissionsIds')))
                    <a class="btn btn-primary pull-right" href="{{ route('GetUsersRegisterUser') }}">Registrar</a>
                    @endif
                </div>

                <div class="panel panel-body">

                    <div class="table-responsive panel-body-table">
                        @if(in_array(1, session('permissionsIds')) || in_array(45, session('permissionsIds')))
                        <a href="{{ route('GetPermissionsIndex') }}" class="btn btn-primary pull-right">
                            Permissionamento
                        </a>
                        @endif
                        @if(in_array(1, session('permissionsIds')) || in_array(45, session('permissionsIds')))
                            @if(Route::current()->getName() === 'GetUsersManagerUserDeleted')
                            <a href="{{ route('GetUsersManagerUser') }}" class="btn btn-light pull-right">
                                Ativos 
                            </a>
                            @else
                            <a href="{{ route('GetUsersManagerUserDeleted') }}" class="btn btn-light pull-right">
                                Deletados 
                            </a>
                            @endif
                        @endif
                        <div class="col-md-5 input-group">
                            <input class="form-control col-md-4" name="searchInTable" id="searchInTable" placeholder="Pesquise um usuário aqui">
                            <span class="input-group-addon fa fa-search btn" onclick="searchInTable()"></span>
                        </div>
                        <table class="table table-bordered table-striped table-actions" id="usersTable">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Usuário</th>
                                    <th>CPF</th>
                                    @if(in_array(34, session('permissionsIds')) || in_array(35, session('permissionsIds')) || in_array(36, session('permissionsIds')) || in_array(37, session('permissionsIds')) || in_array(45, session('permissionsIds')) || in_array(1, session('permissionsIds')) )
                                    <th>Ações</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                <form id="retoreUserForm{{$user->id}}" method="POST" action="{{route('PostRestoreUser',['userAction' => Auth::id(), 'user' => $user->id])}}">@csrf</form>
                                <tr id="usersTr{{$user->id}}">
                                    <form id="formEditDelete{{$user->id}}" method="POST" onsubmit="return false;">
                                        @csrf
                                        <input type="hidden" name="user" value="{{ Auth::id() }}">
                                        <input type="hidden" name="id" value="{{ $user->id }}">
                                        <td>
                                            {{ $user->name }}
                                        </td>
                                        <td>
                                            {{ $user->username }}
                                        </td>
                                        <td>
                                            <!-- Formata CPF  -->
                                            {{ preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", str_pad($user->cpf,'11','0',STR_PAD_LEFT)) }}
                                        </td>
                                        @if(!in_array(34, session('permissionsIds')) || in_array(35, session('permissionsIds')) || in_array(36, session('permissionsIds')) || in_array(37, session('permissionsIds')) || in_array(45, session('permissionsIds')) || in_array(1, session('permissionsIds')) )
                                        <td>
                                            <div class="input-group btn">
{{-- Se a view traz usuários deletados --}}
                                                @if(Route::current()->getName() === 'GetUsersManagerUserDeleted')
                                                @php $titleDelete = 'Clique aqui para excluir de vez o usuário'; @endphp
                                                <button type="button" class="btn btn-success btn-sm" title="Clique aqui para restaurar o usuário" onclick="$('form#retoreUserForm{{$user->id}}').submit();">
                                                    <span id="btnPencil{{$user->id}}" class="fa fa-mail-reply"></span>
                                                </button>
                                                {{-- Se traz usuários ativos --}}
                                                @else
                                                @php $titleDelete = 'Clique aqui para desativar usuário'; @endphp
                                                {{-- Editar --}}
                                                @if(in_array(35, session('permissionsIds')) || in_array(1,session('permissionsIds')))
                                                <button type="button" class="btn btn-default btn-sm" title="Clique aqui para salvar alterações" onclick="updateUser({{$user->id}});">
                                                    <span id="btnPencil{{$user->id}}" class="fa fa-pencil"></span>
                                                </button>
                                                {{-- editar senha --}}
                                                <button type="button" onclick="resetPassword({{$user->id}})" title="Clique aqui para redefinir senha de usuário" class="btn btn-warning btn-sm">
                                                    <span class="fa fa-lock"></span>
                                                </button>
                                                @endif
                                                {{-- Excluir --}}
                                                @if(in_array(45, session('permissionsIds')) || in_array(1,session('permissionsIds')))
                                                <button type="button" onclick="window.location.href = '{{ route('GetPermissionsIndexUser', $user->id) }}'" class="btn btn-dark btn-sm">
                                                    <span class="fa fa-sitemap"></span>
                                                </button>
                                                @endif
                                                @endif
                                                @if(in_array(36, session('permissionsIds')) || in_array(1,session('permissionsIds')))
                                                <button type="button" class="btn btn-danger btn-sm" title="{{$titleDelete}}" onclick="deleteUser({{$user->id}});">
                                                    <span class="fa fa-times"></span>
                                                </button>
                                                @endif
                                            </div>
                                        </td>
                                        @endif
                                    </form>
                                </tr>
                                @empty
                                <td colspan="5">Nenhum usuário encontrado</td>
                                @endforelse
                            </tbody>

                        </table>
                        {{ $users->links() }}
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>
</div>
</div>

@endsection
@section('Javascript')
<script type="text/javascript">
        //deleta usuário
        function deleteUser(id) {
            data = "id="+id+"&user={{Auth::id()}}"
            console.log(data)
            noty({
                text: 'Deseja excluir o usuário?',
                layout: 'topRight',
                buttons: [
                {addClass: 'btn btn-success', text: 'Excluir', onClick: function($noty) {
                    $("#changescript"+id).attr('value','1');

                    try {
                        $.ajax({
                            type: "POST",
                            url: "{{ route('PostUsersDeleteUser') }}",
                            data: data,
                            success: function( xhr,status )
                            {
                                console.log(xhr)
                                $noty.close();
                                noty({
                                    text: "Usuário Excluído com sucesso!",
                                    layout: 'topRight',
                                    type: 'success',
                                    timeout: '3000'
                                })
                                $("#usersTr"+id).remove();
                            },
                            error: function(xhr,error,status) {
                                $noty.close();
                                noty({
                                    text: "Erro ao excluir usuário, tente novamente mais tarde <br>"+
                                    "se o erro persistir, <a href='mailto:leandro.freitas@liderancacobrancas.com.br'>contate o suporte</a>"+
                                    "("+status+")",
                                    layout: 'topRight',
                                    type: 'error',
                                    timeout: '3000'
                                })
                                console.log(xhr);
                            }
                        });
                    } catch(e) {
                        console.log(e)
                    }

                }},
                {addClass: 'btn btn-danger btn-clean', text: 'Cancelar', onClick: function($noty) {
                    $noty.close();
                }
            },]
        });
        }
        @if(Route::current()->getName() !== 'GetUsersManagerUserDeleted')
        //edita usuario
        function updateUser(id) {
            $("#btnPencil"+id).attr('class','fa fa-refresh')
            modal = $('#modalUpdate'+id)
            if(typeof modal.attr('id') !== 'undefined') {
                modal.show()
                $("#btnPencil"+id).attr('class','fa fa-pencil')

            } else {
                $("#loadingDataPreLoader").show()
                modalHide = $('#modalUpdate'+id).hide()

                $.ajax({
                    url: '{{asset("api/data/user/")}}/'+id,
                    success: function(data) {
                        modal = '<div class="modal in" id="modalUpdate'+id+'" tabindex="-1" z-index="999" role="dialog" aria-labelledby="defModalHead" aria-hidden="false" style="display: block;">'+
                        '<div class="modal-dialog">'+
                        '<div class="modal-content">'+
                        '<div class="modal-header">'+
                        '<h4 class="modal-title" id="defModalHead">Editar <b>'+data[0].name.split(' ')[0]+'</b>   <span class="fa fa-refresh" id="preloadModal'+data[0].id+'" style="display: none"> Buscando dados...</span> </h4>'+
                        '</div>'+
                        '<div class="modal-body">'+
                        '<form class="form-horizontal" id="formUser'+data[0].id+'">'+
                        '@csrf'+
                        '<input type="hidden" name="id" id="id'+data[0].id+'" value="'+data[0].id+'">'+
                        '<div class="panel panel-dark tabs">'+
                        '<ul class="nav nav-tabs" role="tablist">'+
                        '<li class="active"><a href="#tab-first'+data[0].id+'" role="tab" data-toggle="tab">Dados do Usuário</a></li>'+
                        '<li><a href="#tab-third'+data[0].id+'" role="tab" data-toggle="tab">Área/Produto</a></li>'+
                        '<li><a href="#tab-second'+data[0].id+'" role="tab" data-toggle="tab">Hierarquia</a></li>'+
                        '</ul>'+
                        '<div class="panel-body tab-content">'+
                        '<div class="tab-pane active" id="tab-first'+data[0].id+'">'+
                        '<div class="form-group">'+
                        '<label class="control-label">Nome <b style="color:red; font-size: 8px">(Obrigatório) </b></label>'+
                        '<input type="text" name="name" class="form-control" id="name'+data[0].id+'" value="'+data[0].name+'">'+
                        '</div>'+
                        '<div class="form-group">'+
                        '<label class="control-label">CPF <b style="color:red; font-size: 8px">(Obrigatório) </b> </label><span class="text-muted">(somente números)</span>'+
                        '<input type="text" name="cpf" class="form-control" id="cpf'+data[0].id+'" value="'+data[0].cpf+'">'+
                        '</div>'+
                        '<div class="form-group">'+
                        '<label class="control-label">Cargo <b style="color:red; font-size: 8px">(Obrigatório) </b></label>'+
                        '<select type="text" name="cargo_id" id="cargo_id'+data[0].id+'" class="form-control select">'+
                        '<optgroup label="Atual">'+
                        '<option selected value="'+data[0].cargo_id+'">'+data[0].cargo+'</option>'+
                        '</optgroup>'+
                        '<optgroup label="Opções">'+
                        @forelse($cargos as $data)
                        '<option value="{{$data->id}}">{{$data->description}}</option>'+
                        @empty
                        '<option value="null">Nenhum dado disponível</option>'+
                        @endforelse
                        '</optgroup>'+
                        '<select>'+
                        '</div>'+
                        '</div>'+
                        '<div class="tab-pane" id="tab-third'+data[0].id+'">'+
                        '<div class="form-group">'+
                        '<label class="control-label">Filial</label>'+
                        '<select type="text" name="filial_id" id="filial_id'+data[0].id+'" class="form-control select">'+
                        '<optgroup label="Atual">'+
                        '<option selected value="'+data[0].filial_id+'">'+data[0].filial+'</option>'+
                        '</optgroup>'+
                        '<optgroup label="Opções">'+
                        @forelse($filiais as $data)
                        '<option value="{{$data->id}}">{{$data->name}}</option>'+
                        @empty
                        '<option value="null">Nenhum dado disponível</option>'+
                        @endforelse
                        '</optgroup>'+
                        '<select>'+
                        '</div>'+
                        '<div class="form-group">'+
                        '<label class="control-label">Carteira</label>'+
                        '<select type="text" name="carteira_id" id="carteira_id'+data[0].id+'" class="form-control select" onchange="getSetores(this,'+data[0].id+')">'+
                        '<optgroup label="Atual">'+
                        '<option selected value="'+data[0].carteira_id+'">'+data[0].carteira+'</option>'+
                        '</optgroup>'+
                        '<optgroup label="Opções" id="carteirasOpt'+data[0].id+'">'+
                        @forelse($carteiras as $data)
                        '<option value="{{$data->id}}">{{$data->name}}</option>'+
                        @empty
                        '<option value="null">Nenhum dado disponível</option>'+
                        @endforelse
                        '</optgroup>'+
                        '<select>'+
                        '</div>'+
                        '<div class="form-group">'+
                        '<label class="control-label">Setor</label>'+
                        '<select type="text" name="setor_id" id="setor_id'+data[0].id+'" class="form-control select" onchange="getIlhas(this,'+data[0].id+');getCoordenadores(this,'+data[0].id+')">'+
                        '<optgroup label="Atual">'+
                        '<option selected value="'+data[0].setor_id+'">'+data[0].setor+'</option>'+
                        '</optgroup>'+
                        '<optgroup label="Opções" id="setorOpt'+data[0].id+'">'+
                        '<option value="null">Nenhum dado disponível</option>'+
                        '</optgroup>'+
                        '<select>'+
                        '</div>'+
                        '<div class="form-group">'+
                        '<label class="control-label">Segmento/Ilha</label>'+
                        '<select type="text" name="ilha_id" id="ilha_id'+data[0].id+'" class="form-control select" onchange="getSup(this,'+data[0].id+')">'+
                        '<optgroup label="Atual">'+
                        '<option selected value="'+data[0].ilha_id+'">'+data[0].segmento+'</option>'+
                        '</optgroup>'+
                        '<optgroup label="Opções" id="segmentoOpt'+data[0].id+'">'+
                        '<option value="null">Nenhum dado disponível</option>'+
                        '</optgroup>'+
                        '<select>'+
                        '</div>'+
                        '</div>'+
                        '<div class="tab-pane" id="tab-second'+data[0].id+'">'+
                        '<div class="form-group">'+
                        '<label class="control-label">Superintendente</label>'+
                        '<select type="text" name="superintendente_id" id="superintendente_id'+data[0].id+'" class="form-control select">'+
                        '<optgroup label="Atual">'+
                        '<option selected value="'+data[0].superintendente_id+'">'+data[0].superintendente+'</option>'+
                        '</optgroup>'+
                        '<optgroup label="Opções">'+
                        @forelse($superintendentes as $data)
                        '<option value="{{$data->id}}">{{$data->name}}</option>'+
                        @empty
                        '<option value="null">Nenhum dado disponível</option>'+
                        @endforelse
                        '</optgroup>'+
                        '<select>'+
                        '</div>'+
                        '<div class="form-group">'+
                        '<label class="control-label">Gerente</label>'+
                        '<select type="text" name="gerente_id" id="gerente_id'+data[0].id+'" class="form-control select">'+
                        '<optgroup label="Atual">'+
                        '<option selected value="'+data[0].gerente_id+'">'+data[0].gerente+'</option>'+
                        '</optgroup>'+
                        '<optgroup label="Opções">'+
                        @forelse($gerentes as $data)
                        '<option value="{{$data->id}}">{{$data->name}}</option>'+
                        @empty
                        '<option value="null">Nenhum dado disponível</option>'+
                        @endforelse
                        '</optgroup>'+
                        '<select>'+
                        '</div>'+
                        '<div class="form-group">'+
                        '<label class="control-label">Coordenador</label>'+
                        '<select type="text" name="coordenador_id" id="coordenador_id'+data[0].id+'" class="form-control select">'+
                        '<optgroup label="Atual">'+
                        '<option selected value="'+data[0].coordenador_id+'">'+data[0].coordenador+'</option>'+
                        '</optgroup>'+
                        '<optgroup label="Opções" id="coordOpt">'+
                        @forelse($coordenadores as $data)
                        '<option value="{{$data->id}}">{{$data->name}}</option>'+
                        @empty
                        '<option value="null">Nenhum dado disponível</option>'+
                        @endforelse
                        '</optgroup>'+
                        '<select>'+
                        '</div>'+
                        '<div class="form-group">'+
                        '<label class="control-label">Supervisor</label>'+
                        '<select type="text" name="supervisor_id" id="supervisor_id'+data[0].id+'" class="form-control select">'+
                        '<optgroup label="Atual">'+
                        '<option selected value="'+data[0].supervisor_id+'">'+data[0].supervisor+'</option>'+
                        '</optgroup>'+
                        '<optgroup label="Opções" id="supOpt">'+
                        '<option value="null">Nenhum dado disponível</option>'+
                        @forelse($supervisores as $data)
                        '<option value="{{$data->id}}">{{$data->name}}</option>'+
                        @empty
                        '<option value="null">Nenhum dado disponível</option>'+
                        @endforelse
                        '</optgroup>'+
                        '<select>'+
                        '</div>'+
                        '</div>'+
                        '</div>'+
                        '</div>'+
                        '</form>'+
                        '</div>'+
                        '<div class="modal-footer">'+
                        '<label class="text-muted col-md-12 pull-left" style="font-size: 10px">Caso o usuário não possua algum dado, escreva <b>null</b></label>'+
                        '<button type="button" class="btn btn-danger" onclick="'+"$('#modalUpdate"+id+"').hide()"+'" data-dismiss="modal">Cancelar</button>'+
                        '<button type="button" class="btn btn-success" id="saveChangesBtn'+data[0].id+'" onclick="saveChanges(this,'+data[0].id+')" data-dismiss="modal">Salvar</button>'+
                        '</div>'+
                        '</div>'+
                        '</div>'+
                        '</div>';
                        $('body').append(modal)
                        $("#btnPencil"+id).attr('class','fa fa-pencil')
                        $("#loadingDataPreLoader").hide()
                    },
                    error: function(xhr, status) {
                        if(xhr.status == 429) {
                            noty({
                                text: 'Muitas requisições! recarregue e tente novamente em 30 segundos',
                                type: 'error',
                                timeout: 3000,
                                layout: 'topRight'
                            })
                        } else {
                            noty({
                                text: "Erro ao buscar dados do usuário<br>"+
                                "Se o erro persistir, <a href='mailto:gustavo.gumieiro@liderancacobrancas.com.br'>contate o suporte</a>"+
                                "("+xhr.status+")",
                                layout: 'topRight',
                                type: 'error',
                                timeout: '5000'
                            })
                            console.log(xhr);
                        }

                        $("#btnPencil"+id).attr('class','fa fa-pencil')
                        $("#loadingDataPreLoader").hide()
                    }
                })
}
}
@endif



        //salva alterações de usuário
        function saveChanges(element,id) {
            $("#"+element.id).attr('disabled', true)
            arr = ['undefined',null,'',' ']
            if( $.inArray($("input[name=name]#name"+id).val(),arr) > -1 || $.inArray($("input[name=cpf]#cpf"+id).val(),arr) > -1 ) {
                return noty({
                    text: 'Prencha os campos corretamente',
                    layout: 'topRight',
                    type: 'warning',
                    timeout: 3000
                })
            }


            data = $("#formUser"+id).serialize()
            $.ajax({
                type: "POST",
                url: "{{ route('PostUsersEditUser', [ 'id' => Auth::id() ]) }}",
                data: data,
                success: function( xhr,status )
                {
                    noty({
                        text: 'Usuário alterado com sucesso!',
                        layout: 'topRight',
                        type: 'success',
                        timeout: 3000
                    })
                },
                error: function(xhr,error,status) {
                    noty({
                        text: "Erro ao alterar usuário, tente novamente mais tarde <br>"+
                        "Se o erro persistir, <a href='https://suporte.ativy.com'>contate o suporte</a>"+
                        "("+status+")",
                        layout: 'topRight',
                        type: 'error',
                        timeout: '5000'
                    })
                    console.log(xhr);
                }
            });
            $("#"+element.id).attr('disabled', false)
        }

        //reseta senha
        function resetPassword(id) {
            $.ajax({
                url: "{{ asset('api/user/resetPass/') }}/"+id+"/{{ Auth::user()->id }}/{{ Auth::user()->ilha_id }}",
                type: "POST",
                success: function() {
                    noty({
                        text: 'Senha redefinida com sucesso!',
                        layout: 'topRight',
                        type: 'success',
                        timeout: '3000'
                    });
                },
                error: function(xhr, status) {
                    console.log(xhr)
                    noty({
                        text: 'Erro ao redefnir senha! ('+xhr.status+')',
                        layout: 'topRight',
                        type: 'error',
                        timeout: '3000'
                    });
                }
            })
        }

        /**** DADOS DO FORM ****/

        // on carteiras change, caal this function
        function getSetores(element, id) {
            $("#preloadModal"+id).show()
            idCarteira = element.value
            $('#setor_id'+id).attr('disabled',true)
            $.getJSON('{{asset("api/data/setores/json/byCarteira/")}}/'+idCarteira,function(data){
                if(data.length > 0) {
                    options = ''
                    for(i=0; i<data.length; i++) {
                        options += '<option value="'+data[i].id+'">'+data[i].name+'</option>'
                    }
                    $("#setorOpt"+id).html(options)
                } else {
                    $("#setorOpt"+id).html('<option value="null">Nenhum dado encontrado</option>')
                }
                $('#setor_id'+id).attr('disabled',false)
            });
            $("#preloadModal"+id).hide()
        }

        function getIlhas(element, id) {
            $("#preloadModal"+id).show()
            idSetor = element.value
            $('#ilha_id'+id).attr('disabled',true)
            //segmentos/ilhas
            $.getJSON('{{asset("api/data")}}/'+idSetor+'/ilha',function(data){
                if(data.length > 0) {
                    console.log(data)
                    options = ''
                    for(i=0; i<data.length; i++) {
                        options += '<option value="'+data[i].id+'">'+data[i].name+'</option>'
                    }
                    $("#segmentoOpt"+id).html(options)
                    $('#ilha_id'+id).attr('disabled',false)
                } else {
                    $("#segmentoOpt"+id).html('<option value="null">Nenhum dado encontrado</option>')
                }
            });
        }

        function getCoordenadores(element, id) {
            $("#preloadModal"+id).show()
            idSetor = element.value
            $('#coordenador_id'+id).attr('disabled',true)

            //coordenadores
            $.getJSON('{{asset("api/data/coordenator")}}/'+idSetor,function(data){
                if(data.length > 0) {
                    options = ''
                    for(i=0; i<data.length; i++) {
                        options += '<option value="'+data[i].id+'">'+data[i].name+'</option>'
                    }
                    $("#coordOpt"+id).html(options)
                } else {
                    $("#coordOpt"+id).html('<option value="null">Nenhum dado encontrado</option>')
                }
                $('#coordenador_id'+id).attr('disabled',false)
            });
            $("#preloadModal"+id).hide()
        }

        // get supervisor by ilha/segmnet id
        function getSup(element, id){
            $("#preloadModal"+id).show()
            idIlha = element.value
            $('#supervisor_id'+id).attr('disabled',true)
            $.getJSON('{{asset("api/data/supervisor")}}/'+idIlha,function(data){
                if(data.length > 0) {
                    options = ''
                    for(i=0; i<data.length; i++) {
                        options += '<option value="'+data[i].id+'">'+data[i].name+'</option>'
                    }
                    $("#supOpt"+id).html(options)
                } else {
                    $("#supOpt"+id).html('<option value="null">Nenhum dado encontrado</option>')
                }
                $('#supervisor_id'+id).attr('disabled',false)
            });
            $("#preloadModal"+id).hide()
        }

        function searchInTable() {
            $(".input-group-addon.fa.fa-search.btn").attr('class','input-group-addon fa fa-spin fa-spinner btn')
            val = $("#searchInTable").val()
            if(val.length > 0) {
                data = 'str='+val 
                
                @if(Route::current()->getName() === 'GetUsersManagerUserDeleted') data += 'deleted_at=1' @endif


                $.ajax({
                    url: '{{route("searchInTableUser")}}',
                    data: data,
                    success: function(data) {
                        console.log(data)
                        if(data.length > 0) {
                            $("#usersTable > tbody tr").hide()
                            linhas = ''
                            for(i=0;i<data.length;i++) {
                                linhas += '<tr id="usersTr'+data[i].id+'">'+
                                '<form id="formEditDelete'+data[i].id+'" method="POST">'+
                                '@csrf'+
                                '<input type="hidden" name="user" value="{{ Auth::id() }}">'+
                                '<input type="hidden" name="id" value="'+data[i].id+'">'+
                                '</form>'+
                                '<td>'+
                                data[i].name+
                                '</td>'+
                                '<td>'+
                                data[i].username+
                                '</td>'+
                                '<td>'+
                                '<!-- Formata CPF  -->'+
                                data[i].cpf+
                                '</td>'+
                                @if(!in_array(34, session('permissionsIds')) || in_array(35, session('permissionsIds')) || in_array(36, session('permissionsIds')) || in_array(37, session('permissionsIds')) || in_array(45, session('permissionsIds')) || in_array(1, session('permissionsIds')) )
                                '<td>'+
                                '<div class="input-group btn">'+
                                {{-- Editar --}}
                                @if(in_array(35, session('permissionsIds')) || in_array(1,session('permissionsIds')))
                                '<button type="button" class="btn btn-default btn-sm" title="Clique aqui para salvar alterações" onclick="updateUser('+data[i].id+');">'+
                                '<span id="btnPencil'+data[i].id+'" class="fa fa-pencil"></span>'+
                                '</button>'+
                                {{-- editar senha --}}
                                '<button type="button" onclick="resetPassword('+data[i].id+')" title="Clique aqui para redefinir senha de usuário" class="btn btn-warning btn-sm">'+
                                '<span class="fa fa-lock"></span>'+
                                '</button>'+
                                @endif
                                {{-- Excluir --}}
                                @if(in_array(36, session('permissionsIds')) || in_array(1,session('permissionsIds')))
                                '<button type="button" class="btn btn-danger btn-sm" title="Clique aqui para desativar usuário" onclick="deleteUser('+data[i].id+');">'+
                                '<span class="fa fa-times"></span>'+
                                '</button>'+
                                @endif
                                @if(in_array(45, session('permissionsIds')) || in_array(1,session('permissionsIds')))
                                '<button type="button" onclick="window.location.href = '+"'{{ asset('manager/permissions') }}/"+data[i].id+"'"+'" class="btn btn-dark btn-sm">'+
                                '<span class="fa fa-sitemap"></span>'+
                                '</button>'+
                                @endif
                                '</div>'+
                                '</td>'+
                                @endif
                                '</tr>';
                            }

                            $("#usersTable >tbody").append(linhas)
                        } else {
                            noty({
                                text: 'Nenhum dado encontrado',
                                layout: 'topRight',
                                type: 'warning'
                            })
                            $("#usersTable > tbody tr").show()
                        }
                        $(".input-group-addon.fa.fa-spin.fa-spinner.btn").attr('class','input-group-addon fa fa-search btn')
                    }
                });// end Ajax
} else {
    $("#usersTable > tbody tr").show()
    $(".input-group-addon.fa.fa-spin.fa-spinner.btn").attr('class','input-group-addon fa fa-search btn')
}
}

$(function(){
    $("#loadingPreLoader").hide();
    $("#managerUsers").show();
})

</script>
@endsection
