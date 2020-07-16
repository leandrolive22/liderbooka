@extends('layouts.app-horizontal',['current' => 'quiz'])
@section('content')
<!-- START PAGE CONTAINER -->
<div class="page-container">

    <!-- START PAGE CONTENT -->
    <div class="page-content">
	<input type="hidden" id="myRows" value="0">
        @component('assets.components.x-navbar-horizontal')
        @endcomponent
        <div class="content-frame">
            <div class="row">
                <div class="col-md-12">

                    <form class="form-horizontal" id="newQuiz" method="POST" action>
                        @csrf
                        <div class="panel-default">
                            <div class="row text-center">
                                <div class="col-md-3"></div>
                                <div class="panel panel-primary col-md-9" style="padding-top: 1rem;">
                                    <div class="panel-heading ui-draggable-handle">
                                        <h3 class="panel-title">Criar<strong> QuizBook</strong></h3>
                                    </div>
                                    <div class="panel-body">

                                        <div class="form-group">
                                            <h4>Título do Quiz</h4>


                                            <div class="input-group">
                                                <span class="input-group-addon"><span
                                                        class="fa fa-pencil"></span></span>
                                                <input type="text" id="title" class="form-control"
                                                    placeholder="Título que será exibido no quiz">
                                            </div>
                                            <span class="help-block">Opcional</span>

                                        </div>

                                        <div class="form-group">
                                            <h4>Descrição</h4>

                                            <textarea id="descript" placeholder="*limite de 10 linhas"
                                                class="form-control" rows="10"></textarea>
                                            <span class="help-block">Opcional</span>

                                        </div>

                                        <div class="form-group">
                                            <h4>Expira em:</h4>

                                            <div class="input-group" id="datepickerExp">
                                                <span class="input-group-addon"><span
                                                        class="fa fa-calendar"></span></span>
                                                <input type="text" id="datepicker" class="form-control datepicker"
                                                    value="{{date('d-m-Y')}}">
                                            </div>
                                            <span class="help-block">Formato de data: dd-mm-aaaa</span>
                                        </div>

                                        <div class="form-group">
                                            <label class="check" id="myCheck" onclick="icheck('on')">
                                                <div class="icheckbox_minimal-grey " style="position: relative;">
                                                    <input type="hidden" id="icheckbox" value="off">
                                                </div> Não expira
                                            </label>
                                            <span class="help-block">Selecione a checkbox para remover data de
                                                expiração</span>

                                        </div>

                                        <!-- START TAGSINPUT -->
                                        <div class="form-group">
                                            <div class="block">
                                                <h4>Ilhas</h4>
                                                <select multiple name="ilhas" id="ilhas" class="form-control select"
                                                    data-live-search="true">
                                                    @forelse ($ilhas as $ilha)
                                                    <option value="{{ $ilha->id }}">{{ $ilha->name }}</option>
                                                    @empty
                                                    <option>Nenhuma Ilha disponível</option>
                                                    @endforelse
                                                </select>
                                            </div>
                                        </div>
                                        <!-- END OF TAGSINPUT -->

                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="panel-footer col-md-12">
                                    <div class="col-xs-2 pull-left" style="position: fixed; bottom:0.5rem;">
                                        <div class="panel panel-colorful" id="controls">
                                            <div class="panel-heading ui-draggable-handle">
                                                <ul class="panel-controls">
                                                    <li>
                                                        <a href="javascript:$('#controls'). attr('class','panel panel-primary'); $('#controlUp').hide(); $('#controlDown').show();"
                                                            id="controlUp" style="display:none">
                                                            <span class="fa fa-angle-up"></span>
                                                        </a>
                                                        <a href="javascript:$('#controls'). attr('class','panel panel-primary panel-toggled'); $('#controlUp').show(); $('#controlDown').hide();"
                                                            id="controlDown">
                                                            <span class="fa fa-angle-down"></span>
                                                        </a>
                                                    </li>
                                                </ul>
                                                <h3 class="panel-title">Controles</h3>
                                            </div>
                                            <div class="panel-body">
                                                <div class="list-group border-bottom" id="controlsList">
                                                    {{-- select  --}}
                                                    <div class="list-group-item" style="padding:0;">
                                                        <div class="btn-group bootstrap-select form-control select">
                                                            <button type="button"
                                                                class="btn dropdown-toggle selectpicker list-group-item btn-dark text-dark"
                                                                onmouseover="$(this).attr('class','btn dropdown-toggle selectpicker list-group-item btn-dark text-white')"
                                                                onmouseout="$(this).attr('class','btn dropdown-toggle selectpicker list-group-item btn-dark text-dark')"
                                                                data-toggle="dropdown"
                                                                aria-expanded="false"><span
                                                                    class="filter-option pull-left text-center"><i
                                                                        class="fa fa-plus">&nbsp;</i> Nova
                                                                    Pergunta</span>&nbsp;<span class="caret"></span>
                                                            </button>
                                                            <div class="dropdown-menu open"
                                                                style="max-height: 291.915px; overflow: hidden;">
                                                                <ul class="dropdown-menu inner selectpicker" role="menu"
                                                                    style="max-height: 291.915px; overflow-y: auto; ">
                                                                    <li rel="0" onclick="make(1)" class="dropdown-item">
                                                                        <a tabindex="0" class="" style="">
                                                                            <span class="text"><i
                                                                                    class="fa fa-file-text-o"> </i>
                                                                                Dissertativa</span>
                                                                            <i
                                                                                class="glyphicon glyphicon-ok icon-ok check-mark"></i>
                                                                        </a>
                                                                    </li>
                                                                    <li rel="1" onclick="make(2)" class="dropdown-item">
                                                                        <a tabindex="0" class="" style="">
                                                                            <span class="text"><i
                                                                                    class="fa fa-check-square-o"> </i>
                                                                                Múltipla Escolha</span>
                                                                            <i
                                                                                class="glyphicon glyphicon-ok icon-ok check-mark"></i>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a type="button" role="button" id="viewquiz" class="list-group-item btn-info text-white" style="display:none">
                                                                            <i class="fa fa-eye"></i> Vizualizar Quiz
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- /select  --}}

                                                    <button class="list-group-item btn-success disabled" id="saveBtn"
                                                        role="button" type="button" onclick="checkVoid()">
                                                        <i class="fa fa-cloud-upload"></i>
                                                        <img src="{{ asset('img/loaders/default.gif') }}"
                                                            id="preloaderBtnsave" style="display:none;">
                                                        Salvar
                                                    </button>
                                                    <button type="reset" role="button" onclick="deleteQuestions()"
                                                        class="list-group-item btn-danger text-white"><i
                                                            class="glyphicon glyphicon-refresh"></i> Redefinir
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-colorful col-md-9 text-center pull-right">
                                        <h5 class="panel-title col-md-12">Perguntas</h5>
                                    </div>
                                    <div class="panel col-md-9 pull-right" style="padding:1rem">
                                        <!-- Perguntas -->
                                        <ul type="none" style="padding: 0%;" id="perguntas">
                                        </ul>
                                        <!-- ./ Perguntas -->
                                    </div>
                                </div>
                            </div>
                    </form>
                </div>
                <ul type="none">
                    <li>

                    </li>
                </ul>
            </div>

        </div>
        <!-- END PAGE CONTENT -->
    </div>
    <!-- END PAGE CONTAINER -->
    @endsection

    @section('Javascript')
    <script type="text/javascript" src="{{ asset('js/plugins/tagsinput/jquery.tagsinput.min.js') }}"></script>
    @include('quiz.components.quizJs')
    @endsection
