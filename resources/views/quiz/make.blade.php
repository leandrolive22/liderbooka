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
                                            <span class="input-group-addon">
                                                <span class="fa fa-pencil"></span>
                                            </span> 
                                            <input type="text" id="title" class="form-control" placeholder="Título que será exibido no quiz">
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
                                                <label class="text-muted">Para selecionar mais de uma ilha, segure "CTRL" e clique nas ilhas</label>
                                                {{-- <input type="text" name="ilhas" id="ilhas" class="form-control" list="exampleList" multiple> --}}
                                                <select name="ilhas" id="ilhas" class="form-control" multiple="true">
                                                    {{-- <datalist id="exampleList"> --}}
                                                        @forelse ($ilhas as $ilha)
                                                        <option value="{{ $ilha->id }}">{{ $ilha->name }}</option>
                                                        @empty
                                                        <option>Nenhuma Ilha disponível</option>
                                                        @endforelse
                                                    {{-- </datalist> --}}
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

                                        <div class="panel panel-secondary" id="controls">
                                            <div class="panel-heading">
                                                <ul class="panel-controls pull-right">
                                                    <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                                                </ul>
                                                <h3 class="panel-title pull-left">
                                                    Controles
                                                </h3>
                                            </div>

                                            <div class="panel-body">
                                                <div class="list-group border-bottom" id="controlsList">
                                                    <a href="javascript:make(1)" class="list-group-item btn-outline-dark">
                                                        <span class="fa fa-pencil-square-o"></span>
                                                        Dissertativa
                                                    </a>
                                                    <a href="javascript:make(2)" class="list-group-item btn-outline-dark">
                                                        <span class="fa fa-check-square-o"></span>
                                                        Multipla Escolha
                                                    </a>
                                                    {{-- <a href="#" class="list-group-item btn-info text-white" id="viewquiz" style="display: none;">
                                                        <span class="fa fa-eye"></span> 
                                                        Vizualizar Quiz
                                                    </a> --}}
                                                    <a href="javascript:checkVoid()" class="list-group-item btn-success disabled" id="saveBtn">
                                                        <i class="fa fa-cloud-upload"></i>
                                                        <img src="{{ asset('img/loaders/default.gif') }}"
                                                        id="preloaderBtnsave" style="display:none;">
                                                        Salvar
                                                    </a>
                                                    <a class="list-group-item btn-danger text-white" href="javascript:deleteQuestions()">
                                                        <span class="glyphicon glyphicon-refresh"></span>
                                                        Redefinir
                                                    </a>
                                                </ul>
                                            </div>
                                        </div>
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
{{-- @section('modal')
@endsection --}}
@section('Javascript')
<script type="text/javascript" src="{{ asset('js/plugins/tagsinput/jquery.tagsinput.min.js') }}"></script>
@include('quiz.components.quizJs')
@endsection
