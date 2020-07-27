@extends('layouts.app', ["current"=>"adm"])
@section('style')
<style type="text/css">
    img {
        width: 100%;
        height: auto;
    }

    /* Set a background color */
    body {
        background-color: ;
        font-family: Helvetica, sans-serif;
    }

    /* The actual timeline (the vertical ruler) */
    .timeline {
        position: relative;
        max-width: 600px;
        margin: 0 auto;

    }

    /* The actual timeline (the vertical ruler) */
    .timeline::after {
        content: '';
        position: absolute;
        width: 0px;
        background-color: ;
        top: 0;
        bottom: 0;
        left: %;
        margin-left: -3px;
    }

    /* Container around content */
    .container {
        padding: 10px 40px;
        position: relative;
        background-color: inherit;
        width: 50%;
    }

    /* The circles on the timeline */
    .container::after {
        content: '';
        position: absolute;
        width: 25px;
        height: 25px;
        right: -17px;
        background-color: ;
        border: 4px solid #0f0438;
        top: 15px;
        border-radius: 50%;
        z-index: 1;
    }

    /* Place the container to the left */
    .left {
        left: 0;
    }

    /* Place the container to the right */
    .right {
        left: 50%;
    }

    /* Add arrows to the left container (pointing right) */
    .left::before {
        content: " ";
        height: 0;
        position: absolute;
        top: 22px;
        width: 0;
        z-index: 1;
        right: 30px;
        border: medium solid white;
        border-width: 10px 0 10px 10px;
        border-color: transparent transparent transparent white;
    }

    /* Add arrows to the right container (pointing left) */
    .right::before {
        content: " ";
        height: 0;
        position: absolute;
        top: 12px;
        width: 0;
        z-index: 1;
        left: 30px;
        border: medium solid white;
        border-width: 10px 10px 10px 0;
        border-color: transparent white transparent transparent;
    }

    /* Fix the circle for containers on the right side */
    .right::after {
        left: -16px;
    }

    /* The actual content */
    .content {
        padding: 20px 30px;
        background-color: ;
        position: relative;
        border-radius: 6px;
    }

    #insertPhoto {
        height:7rem;
    }

    @media screen and (min-width:2000) {
        #insertPhoto {
            height:15rem;
        }
    }

    @media screen and (max-width: 1300px) {
        #insertPhoto {
            height:5rem;
        }
    }

    /* Media queries - Responsive timeline on screens less than 600px wide */
    @media screen and (max-width: 600px) {

        #insertPhoto {
            height:20rem;
        }

        /* Place the timelime to the left */
        .timeline::after {
            left: 31px;
        }

        /* Full-width containers */
        .container {
            width: 100%;
            padding-left: 70px;
            padding-right: 25px;
        }

        /* Make sure that all arrows are pointing leftwards */
        .container::before {
            left: 60px;
            border: ;
            border-width: 10px 10px 10px 0;
            border-color: transparent white transparent transparent;
        }

        /* Make sure all circles are at the same spot */
        .left::after,
        .right::after {
            left: 15px;
        }

        /* Make all right containers behave like the left ones */
        .right {
            left: 0%;
        }
    }
</style>
@endsection
@section('content')
<!-- START PAGE CONTAINER -->
<div class="page-container">


    <!-- PAGE CONTENT -->
    <div class="page-content">

        @component('assets.components.x-navbar')

        @endcomponent


        <!-- START CONTENT FRAME -->
        <div class="content-frame">

            <!-- START CONTENT FRAME TOP -->
            <div class="content-frame-top">
                <div class="page-title">
                    <a href="{{ url()->previous() }}">
                        <h2><span class="fa fa-arrow-circle-o-left"></span> Gerenciamento</h2>
                    </a>
                </div>
                <div class="pull-right">
                    <button class="btn btn-{{Auth::user()->css}} content-frame-right-toggle">
                        <span class="fa fa-bars"></span>
                    </button>
                </div>
                <!-- END CONTENT FRAME TOP -->

                <!-- START CONTENT FRAME RIGHT -->
                @include('assets.components.updates')
                <!-- END CONTENT FRAME RIGHT -->

                <!-- START CONTENT FRAME LEFT -->
                <div class="content-frame-body content-frame-body-left">
                {{-- Gerenciamento  --}}
                <div class="row">
                    <div class="panel panel-default">
                        <!-- start gerenciamento  -->
                        <div class="row">
                            <div class="panel-title-box panel-heading ui-draggable-handle">
                                <h3 class="panel-title">Gerenciamento</h3>
                                <ul class="panel-controls">
                                    <li><a href="#" class="panel-collapse"><span class="fa fa-down-up"></span></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <!-- Gerenciar Materiais  -->
                                {{-- <a href="#{{ route('GetMaterialsManage') }}" class="col-md-6" data-placement="top" data-toggle="popover" data-content="Em Manutenção">
                                    <div class="panel panel-default">
                                        <div class="panel-heading ui-draggable-handle btn btn-primary">
                                            <h3 class="panel-title"><strong><i class="fa fa-book"></i> Materiais</strong></h3>
                                        </div>
                                    </div>
                                </a> --}}
                                <!-- ./Gerenciar Materiais  -->
                                @if (in_array(Auth::user()->cargo_id,[1,3,15]))
                                <a href="{{ route('GetUsersManagerUser')}}" class="col-md-6" >
                                    <div class="panel panel-default">
                                        <div class="panel-heading ui-draggable-handle btn btn-primary">
                                            <h3 class="panel-title"><strong><i class="fa fa-user"></i> Usuários</strong></h3>
                                        </div>
                                    </div>
                                </a>
                                <!-- Gerenciamento de Ilhas, setores, Filiais, etc -->
                                <a href="{{ route('GetPermissionsIndex') }}" class="col-md-6" data-placement="top" data-toggle="popover" data-content="Em Breve...">
                                    <div class="panel panel-default">
                                        <div class="panel-heading ui-draggable-handle btn btn-primary">
                                            <h3 class="panel-title"><i class="fa fa-unlock-alt"></i> <strong>Permissões</strong></h3>
                                        </div>
                                    </div>
                                </a>
                                @endif
                                @if(in_array(Auth::id(),[37,1711,1712,1746]))
                                <!-- Gerenciamento de Medidas Disciplinares -->
                                <a href="{{ route('GetMeasuresIndex')}}" class="col-md-6">
                                    <div class="panel panel-default">
                                        <div class="panel-heading ui-draggable-handle btn btn-primary">
                                            <h3 class="panel-title"><i class="fa fa-exclamation"></i> <strong>Medidas Disciplinares</strong></h3>
                                        </div>
                                    </div>
                                </a>
                                @endif
                            </div>
                        </div>
                        <!-- End gerenciamento  -->
                    </div>
                </div>

                {{-- Relatórios --}}
                <div class="row">
                    <div class="panel panel-default">
                        <div class="row">
                            <div class="panel-title-box panel-heading ui-draggable-handle">
                                <h3 class="panel-title">Relatórios</h3>
                                <ul class="panel-controls">
                                    <li><a href="#" class="panel-collapse"><span class="fa fa-angle-up"></span></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <a href="#{{-- route('GetRelatorioClima') --}}" class="col-md-4" style="margin-top: 1rem;" data-placement="top" data-toggle="popover" data-content="Em Manutenção">
                                    <div class="panel panel-default">
                                        <div class="panel-heading ui-draggable-handle btn btn-primary">
                                            <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> <strong>Clima Organizacional</strong>
                                            </h3>
                                        </div>
                                    </div>
                                </a>
                                <a href="#{{-- route('GetRelatorioQuiz') --}}" class="col-md-4"
                                style="margin-top: 1rem;" data-placement="top" data-toggle="popover" data-content="Em Breve...">
                                    <div class="panel panel-default">
                                        <div class="panel-heading ui-draggable-handle btn btn-primary">
                                            <h3 class="panel-title"><i class="fa fa-gamepad"></i><strong> Quizzes</strong></h3>
                                        </div>
                                    </div>
                                </a>
                                <a href="#{{-- route('GetRelatorioClima') --}}" class="col-md-4" style="margin-top: 1rem;" data-placement="top" data-toggle="popover" data-content="Em Breve...">
                                    <div class="panel panel-default">
                                        <div class="panel-heading ui-draggable-handle btn btn-primary">
                                            <h3 class="panel-title"><i class="fa fa-comments-o"></i> <strong>Chats</strong></h3>
                                        </div>
                                    </div>
                                </a>
                                <a href="#{{-- route('GetRelatorioClima') --}}" class="col-md-4"
                                style="margin-top: 1rem;" data-placement="top" data-toggle="popover" data-content="Em Breve...">
                                    <div class="panel panel-default">
                                        <div class="panel-heading ui-draggable-handle btn btn-primary">
                                            <h3 class="panel-title"><i class="fa fa-clock-o"></i> <strong>Publicações</strong></h3>
                                        </div>
                                    </div>
                                </a>
                        {{-- <a href="#{{ route('GetRelatorioClima') }}" class="col-md-4"
                        style="margin-top: 1rem;" data-placement="top" data-toggle="popover" data-content="Em Breve...">
                        <div class="panel panel-default">
                            <div class="panel-heading ui-draggable-handle btn btn-primary">
                                <h3 class="panel-title"><i class="fa fa-book"></i> <strong>Materiais</strong></h3>
                            </div>
                        </div>
                    </a> --}}
                    @if(isset(json_decode(Auth::user()->another_config,TRUE)['manager']['linksTags']) || in_array(Auth::user()->cargo_id,[1,2,3,6,7,9,10]))
                    <a href="{{ route('GetRelatorioLinkTag') }}" class="col-md-4"
                    style="margin-top: 1rem;">
                    <div class="panel panel-default">
                        <div class="panel-heading ui-draggable-handle btn btn-primary">
                            <h3 class="panel-title"><i class="fa fa-terminal"></i> <strong>Links e Tags</strong></h3>
                        </div>
                    </div>
                </a>
                @endif
            </div>
        </div>

        <!-- END CONTENT FRAME RIGHT -->
    </div>
    <!-- FIM PAGE CONTAINER -->
</div>

@endsection