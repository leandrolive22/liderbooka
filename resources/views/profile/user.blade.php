@extends('layouts.app',['current' => 'profile'])
@section('content')

    <!-- START PAGE CONTAINER -->
    <div class="page-container">

        <!-- PAGE CONTENT -->
        <div class="page-content">

            @component('assets.components.x-navbar')
            @endcomponent

             <!-- PROFILE WIDGET -->
             <div class="col-md-12">

                <div class="panel panel-secondary">
                    <div class="panel-body profile bg-secondary">

                        <div class="profile-image">
                            <img src="{{ asset(Auth::user()->avatar) }}" alt="{{Auth::user()->name}}">
                        </div>
                        <div class="profile-data">
                            <div class="profile-data-name">{{ Auth::user()->name }}</div>
                            <div class="profile-data-title" id="cargoScript2"></div>
                        </div>

                    </div>
                    <div class="panel-body">
                            <div class="form-group col-md-12">
                                <form role="form" id="styleBookForm" action="{{ route('PostUsersStyle', ['id' =>Auth::user()->id]) }}" method="POST" class="form-horizontal">
                                    @csrf
                                    <label class="col-md-2 control-label">Estilo do Book</label>
                                    <select class="form-control col-md-9" name="option" id="styleBook">
                                        <option>Selecione o estilo do Book</option>
                                        <option value="black">Padrão</option>
                                        <option value="default">Cinza</option>
                                        <option value="white">Branco</option>
                                        <!-- <option value="blue">Azul</option>
                                        <option value="brown">Roxo</option> -->
                                    </select>
                                </form>
                            </div>
                            <div class="form-group col-md-12">
                                <form role="form" method="POST" class="form-horizontal" id="changePass">
                                    <label class="col-md-2 control-label">Alterar Senha</label>
                                    @csrf
                                    <input class="form-control col-md-4" id="passwordInput" type="password" name="password" placeholder="Digite sua senha">
                                    <input class="form-control col-md-4" id="confirmPassInput" type="password" name="confirmPass" placeholder="Confirme sua senha">
                                    <input type="hidden" name="id" value="{{ Auth::user()->id }}">
                                    <button type="button" onclick="changePass({{ Auth::user()->id }})" class="btn btn-primary col-md-1">Salvar</button>
                                </form>
                            </div>
                            {{-- <div class="form-group col-md-12">
                                <form role="form" method="POST" action="{{ route('PostUsersuUsername', ['id' =>Auth::user()->id]) }}" class="form-horizontal">
                                    <label class="col-md-2 control-label">Username</label>
                                    @csrf
                                    <input class="form-control col-md-8" id="username" name="username" value="{{ Auth::user()->username }}">
                                    <button class="btn btn-primary col-md-1">Salvar</button>
                                </form>
                            </div> --}}
                    </div>
                </div>
                <div class="panel panel-primary panel">
                    <div class="panel-heading ui-draggable-handle">
                        <h3 class="panel-title">Pacote de Avatares padrão</h3>
                        <ul class="panel-controls">
                            <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                        </ul>
                    </div>
                    <div class="panel-body profile bg-white">
                        <div class="col-md-12">
                            <a href="{{ route('GetUsersAvatar', ['id' => Auth::user()->id, 'pic' => 'default']) }}">
                                <div class="profile-image col-md-2">
                                    <img src="{{ asset('storage/img/avatar/default.png') }}" alt="{{Auth::user()->name}}">
                                </div>
                            </a>
                            <a href="{{ route('GetUsersAvatar', ['id' => Auth::user()->id, 'pic' => 1]) }}">
                                <div class="profile-image col-md-2">
                                    <img src="{{ asset('storage/img/avatar/1.png') }}" alt="">
                                </div>
                            </a>
                            <a href="{{ route('GetUsersAvatar', ['id' => Auth::user()->id, 'pic' => 2]) }}">
                                <div class="profile-image col-md-2">
                                    <img src="{{ asset('storage/img/avatar/2.png') }}" alt="">
                                </div>
                            </a>
                            <a href="{{ route('GetUsersAvatar', ['id' => Auth::user()->id, 'pic' => 3]) }}">
                                <div class="profile-image col-md-2">
                                    <img src="{{ asset('storage/img/avatar/3.png') }}" alt="">
                                </div>
                            </a>
                            <a href="{{ route('GetUsersAvatar', ['id' => Auth::user()->id, 'pic' => 4]) }}">
                                <div class="profile-image col-md-2">
                                    <img src="{{ asset('storage/img/avatar/4.png') }}" alt="">
                                </div>
                            </a>
                            <a href="{{ route('GetUsersAvatar', ['id' => Auth::user()->id, 'pic' => 5]) }}">
                                <div class="profile-image col-md-2">
                                    <img src="{{ asset('storage/img/avatar/5.png') }}" alt="">
                                </div>
                            </a>
                            <a href="{{ route('GetUsersAvatar', ['id' => Auth::user()->id, 'pic' => 6]) }}">
                                <div class="profile-image col-md-2">
                                    <img src="{{ asset('storage/img/avatar/6.png') }}" alt="">
                                </div>
                            </a>
                            <a href="{{ route('GetUsersAvatar', ['id' => Auth::user()->id, 'pic' => 7]) }}">
                                <div class="profile-image col-md-2">
                                    <img src="{{ asset('storage/img/avatar/7.png') }}" alt="">
                                </div>
                            </a>
                            <a href="{{ route('GetUsersAvatar', ['id' => Auth::user()->id, 'pic' => 8]) }}">
                                <div class="profile-image col-md-2">
                                    <img src="{{ asset('storage/img/avatar/8.png') }}" alt="">
                                </div>
                            </a>
                            <a href="{{ route('GetUsersAvatar', ['id' => Auth::user()->id, 'pic' => 9]) }}">
                                <div class="profile-image col-md-2">
                                    <img src="{{ asset('storage/img/avatar/9.png') }}" alt="">
                                </div>
                            </a>
                            <a href="{{ route('GetUsersAvatar', ['id' => Auth::user()->id, 'pic' => 10]) }}">
                                <div class="profile-image col-md-2">
                                    <img src="{{ asset('storage/img/avatar/10.png') }}" alt="">
                                </div>
                            </a>
                            <a href="{{ route('GetUsersAvatar', ['id' => Auth::user()->id, 'pic' => 11]) }}">
                            <div class="profile-image col-md-2">
                                <img src="{{ asset('storage/img/avatar/11.png') }}" alt="">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- END PROFILE WIDGET -->

        </div>
        <!-- END PAGE CONTENT -->

    </div>
    <!-- END PAGE CONTAINER -->

@endsection
@section('Javascript')
    <script type="text/javascript" id="profileJs">
        //interações com modais
        $("#styleBook").change(function(){
            console.log($("#styleBookForm").serialize())
            $('#styleBookForm').submit()
        });

        $('#SuccessModalBtn').click(function () {
                $('#message-box-success').hide()
            }
        );

        $('#ErrorModalBtn').click(function () {
                $('#message-box-danger').hide()
            }
        );

        function changePass(id) {
            confirm = $('#confirmPassInput').val();
            pass = $('#passwordInput').val();

            if(pass === confirm) {
                data = $("#changePass").serialize();
                $.ajax({
                    url: "{{ route('PostUsersPass', ['id' =>Auth::user()->id]) }}",
                    type: 'POST',
                    data: data,
                    success: function() {
                        noty({
                            text: 'Senha alterada com Sucesso!',
                            timeout: '3000',
                            layout: 'topRight',
                            type: 'success'
                        })
                    },
                    error: function(xhr,status) {
                        console.log(xhr)
                        msg = '';
                        if(xhr.status == 409) {
                            msg += '(409) Tente novamente em alguns minutos'
                        } else if(xhr.status == 500) {
                            msg += '(500) Erro no servidor, tente novamente mais tarde'
                        } else if(xhr.status == 404) {
                            msg += '(404) Rota não encontrada, contate o <a href="mailto:leandro.freitas@liderancacobrancas.com.br">suporte</a>'
                        } else {
                            msg += xhr.status+'Tente novamente mais tarde';
                        }
                        noty({
                            text: 'Erro'+msg,
                            timeout: '3000',
                            layout: 'topRight',
                            type: 'error'
                        })
                        $("#message-box-danger").show();
                        $("#tagPerror").html('Erro('+xhr.status+')! Tente novamente em alguns minutos!');
                    }
                })
            } else {
                $("#message-box-danger").show();
                $("#tagPerror").html('As senhas digitadas não correspondem');
            }
        }

        $(document).ready(function(){
            // noty({
            //     text: 'Altere sua senha ou seu nome de usuário<br>'+
            //     'Digitando os dados em seus respectivos campos e clicando em "Salvar"',
            //     timeout: 2000,
            //     layout: 'topRight',
            //     type: 'error'
            // });
            // noty({
            //     text: 'Altere Selecione seu "Estilo do Book"<br>'+
            //     'E deixo o LiderBook&reg com sua cara',
            //     timeout: 3000,
            //     layout: 'topRight',
            //     type: 'success'
            // })
            // noty({
            //     text: 'Altere Selecione seu "Avatar"<br>'+
            //     'Veja o(s) pacote(s) de Avatar(es) disponíveis ',
            //     timeout: 5000,
            //     layout: 'topRight',
            //     type: 'error'
            // })
            // noty({
            //     text: 'Em breve, mais Pacotes de Avatares estarão disponíveis',
            //     timeout: 5000,
            //     layout: 'topRight',
            //     type: 'information'
            // })
        })

    </script>
@endsection
