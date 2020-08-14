@extends('layouts.app',['current' => 'adm'])
@section('content')

<!-- START PAGE CONTAINER -->
<div class="page-container">

    <!-- PAGE CONTENT -->
    <div class="page-content">

        @component('assets.components.x-navbar')
        @endcomponent
        <div class="content-frame">
            <div class="content-frame-top">
                <div class="page-title">
                    <a href="{{url()->previous()}}">
                        <h2>
                            <span class="fa fa-arrow-circle-o-left"></span> Gerenciamento de Usuário
                        </h2>
                    </a>
                </div>
            </div>
            <div class="content-frame">
                <div class="panel panel-primary">
                 <div class="col-md-12" id="registerFormDiv">
                    <div class="panel-body">
                        <h3 class="panel-title"><b>Registrar usuário</b></h3>
                        <div class="form-group col-md-12">
                            <form role="form" id="createUserForm">
                                <br>
                                <br>
                                @csrf
                                <div class="form-group col-md-12">
                                    <label class="col-md-2 control-label">Nome</label>
                                    <input class="form-control col-md-8" id="name" name="name">
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="col-md-2 control-label">Username</label>
                                    <input class="form-control col-md-8" id="username" name="username">
                                    <label for="username" class="text-muted" style="font-size:10px; margin-left:18%;">*A Senha padrão é: Book2020@lidera</label>
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="col-md-2 control-label">Matricula</label>
                                    <input class="form-control col-md-8" maxlength="8" type="number" id="matricula" name="matricula">
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="col-md-2 control-label">Data de Admissão</label>
                                    <input class="form-control col-md-8" type="date" id="data_admissao" name="data_admissao">
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="col-md-2 control-label">CPF</label>
                                    <input type="number" class="form-control col-md-8" maxlength="11" id="cpf" name="cpf">
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="col-md-2 control-label">Carteira</label>
                                    <select data-live-search="true" class="form-control col-md-8" name="carteira_id" id="carteira_id" onchange="getSetores(this)">
                                        <option>Selecione uma Carteira</option>
                                        @foreach($carteiras as $carteira)
                                        <option value="{{ $carteira->id }}">{{ $carteira->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-12" id="setor_idDiv">
                                    <label class="col-md-2 control-label">Setor</label>
                                    <select data-live-search="true" class="form-control col-md-8" name="setor_id" id="setor_id" onchange="getIlhas(this)">
                                        <option value="-" id="noMoreSetor">Nenhum Setor Encontrado</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-12" id='ilhaDiv'>
                                    <label class="col-md-2 control-label">Ilha</label>
                                    <select data-live-search="true" class="form-control col-md-8" name="ilha_id" id="ilha_id" onchange="onChangeSelect();">
                                        <option id="noMoreI">Nenhuma Ilha Encontrada</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-12" id='cargoDiv'>
                                    <label class="col-md-2 control-label">Cargo</label>
                                    <select data-live-search="true" class="form-control col-md-8" name="cargo_id" id="cargo_id" onchange="onChangeSelect();">
                                        <option>Selecione um Cargo</option>
                                        @forelse ($cargos as $cargo)
                                        <option value="{{$cargo->id}}">{{$cargo->description}}</option>
                                        @empty
                                        <option value="-">Nenhum Cargo Encontrado</option>
                                        @endforelse
                                    </select>
                                </div>
                                <input type="hidden" name="carteira_id" value="1">
                                <div class="form-group col-md-12">
                                    <label class="col-md-2 control-label">Supervisor</label>
                                    <select data-live-search="true" class="form-control col-md-8" name="superior_id" id="superior_id">
                                        <option id="noMoreSup" value="">Selecione um Supervisor</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="col-md-2 control-label">Coordenador</label>
                                    <select data-live-search="true" class="form-control col-md-8" name="coordenador_id" id="coordenador_id">
                                        <option id="noMoreCoord" value="">Selecione um Coordenador</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="col-md-2 control-label">Gerente</label>
                                    <select data-live-search="true" class="form-control col-md-8" name="manager_id" id="manager_id">
                                        @forelse ($gerentes as $g)
                                        <option value="{{$g->id}}">{{$g->name}}</option>
                                        @empty
                                        <option value="-">Nenhum Gerente Encontrado</option>
                                        @endforelse
                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="col-md-2 control-label">Superintendente</label>
                                    <select data-live-search="true" class="form-control col-md-8" name="sup_id" id="sup_id">
                                        @forelse ($superintendentes as $superintendente)
                                        <option value="{{ $superintendente->id }}">{{ $superintendente->name }}</option>
                                        @empty
                                        <option id="noMoreSuper" value="0">Nenhum Superintendente Disponível</option>
                                        @endforelse
                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <button type="button" id="sendUserBtn" class="btn btn-primary col-md-12">Salvar</button>
                                </div>
                                <input type="hidden" name="id" value="{{Auth::user()->id}}">
                            </form>
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
    $('#sendUserBtn').click(function() {
        $(this).prop('enabled',false)
        $(this).prop('disabled',true)
        $("#sendUserBtn").html('<span class="fa fa-spin fa-spinner"></span>')

        var dados = $('#createUserForm').serialize();

        $.ajax({
            type: "POST",
            url: "{{ route('PostUsersStore', ['id' =>Auth::user()->id]) }}",
            data: dados,
            success: function( xhr,status )
            {
                noty({
                    text: "{{ __('Usuário registrado com sucesso!') }}",
                    layout: 'topRight',
                    type: 'success',
                    timeout: '3000'
                })

            },
            error: function(xhr,error,status) {
                if(xhr.status === 422) {
                    if(xhr.responseJSON.errors.cpf) {
                        noty({
                            text: xhr.responseJSON.errors.cpf,
                            layout: 'topRight',
                            type: 'error',
                            timeout: '3000'
                        });
                    }
                    if(xhr.responseJSON.errors.username) {
                        noty({
                            text: xhr.responseJSON.errors.username,
                            layout: 'topRight',
                            type: 'error',
                            timeout: '3000'
                        });
                    }
                    if(xhr.responseJSON.errors.matricula) {
                        noty({
                            text: xhr.responseJSON.errors.username,
                            layout: 'topRight',
                            type: 'error',
                            timeout: '3000'
                        });
                    }
                }
                else {
                    noty({
                        text: 'Não foi possível registrar usuário, tente novamente mais tarde.<br>'+
                        'se o erro persistir, contate o suporte. (error: '+xhr.status+')',
                        layout: 'topRight',
                        type: 'error',
                        timeout: '3000'
                    });
                }
                console.log(xhr);
            }
        });

        $(this).prop('disabled',false)
        $(this).prop('enabled',true)
        $("#sendUserBtn").html('Salvar')
    });

    function ModalBtnmodal(id) {
        $("#message-box"+id).hide();
    }

    function onChangeSelect() {
        getSupervisors()
        getCoordenador()
    }

    function getIlhas(setor_id){
        $.getJSON('{{ asset("api/data/") }}/'+setor_id.value+'/ilha', function(ilha){

            l = ilha.length;
            if(l > 0) {
                linha = '<option>Selecione a Ilha</option>'
                for(i=0; i< l; i++) {
                    linha += '<option value="'+ilha[i].id+'">'+ilha[i].name+'</option>'
                }
                $("#noMoreI").hide();
                $("#ilha_id").html(linha)
            } else {
                option = '<option id="noMoreI">Nenhum Ilha Encontrada</option>'
                $("#ilha_id").html(option)
            }
        });
    }

    function getSetores(carteira) {
        $.getJSON('{{ asset("api/data/setores/json/byCarteira/") }}/'+carteira.value,function(data){
            l = data.length;
            if(l > 0) {
                linha = '<option value="">Selecione o Setor</option>'
                for(i=0; i<l; i++) {
                    linha += '<option value="'+data[i].id+'">'+data[i].name+'</option>'
                }
                $("#noMoreSetor").hide();
                $("#setor_id").html(linha)
            }
        });
    }

    function getSupervisors(){
        ilha_id = $("select#ilha_id").val();

        $.getJSON('{{ asset("api/data/supervisor") }}/'+ilha_id+'/1' , function(ilha){

            l = ilha.length;
            if(l > 0) {
                linha = '<option value="">Selecione o Supervisor</option>'
                for(i=0; i< l; i++) {
                    linha += '<option value="'+ilha[i].id+'">'+ilha[i].name+'</option>'
                }
                $("#noMoreSup").hide();
                $("#superior_id").html(linha)
            } else {
                option = '<option id="noMoreSup" value="0">Nenhum Supervisor Encontrado</option>'
                $("#superior_id").html(option)
            }
        });

    }

    function getCoordenador(){
        setor = $("#setor_id").val()
        $.getJSON('{{ asset("api/data/coordenator") }}/'+setor, function(ilha){

            l = ilha.length;

            if(l > 0) {
                linha = '<option value="">Selecione o coordenador</option>'
                for(i=0; i< l; i++) {
                    linha += '<option value="'+ilha[i].id+'">'+ilha[i].name+'</option>'
                }
                $("#noMoreCoord").hide();
                $("#coordenador_id").html(linha)
            } else {
                option = '<option id="noMoreCoord" value="0 ">Nenhum coordenador Encontrado</option>'
                $("#coordenador_id").html(option)
            }
        });
    }

</script>
@endsection
