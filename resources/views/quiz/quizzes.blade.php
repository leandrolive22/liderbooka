@extends('layouts.app',['current' => 'quiz'])
@section('content')
<!-- START PAGE CONTAINER -->
<div class="page-container">

    <!-- START PAGE CONTENT -->
    <div class="page-content">
        @component('assets.components.x-navbar')
        @endcomponent

        <div class="content-frame">

            <!-- START CONTENT FRAME TOP -->
            <div class="content-frame-top">
                <div class="page-title">
                 <a href="{{url()->previous()}}"> <h2><span class="fa fa-arrow-circle-o-left"></span> Quizzes</h2></a>
             </div>
             <div class="pull-right">
                <button class="btn btn-default content-frame-right-toggle"><span class="fa fa-bars"></span></button>
            </div>
        </div>
        <!-- END CONTENT FRAME TOP -->
        @if($createQuiz || $webMaster)
        <div class="content-frame-top">
            <div class="panel panel-colorful">
                <div class="panel-heading ui-draggable-handle">
                    <h3 class="panel-title">Criar Quiz</h3>
                </div>
                <div class="panel-body" id="">
                    <div class="col-md-2">
                        <a href="{{ route('GetQuizCreate') }}" class="tile tile-default tile-valign">
                            <span class="fa fa-plus fa-3x"></span>
                        </a>
                    </div>
                </div>
                <div class="panel-footer" id="quizModels">
                </div>
            </div>
        </div>
        @endif
        <!-- START CONTENT FRAME LEFT -->
        <div class="content-frame-right" style="height: 515px;">
            <div class="panel panel-default">
                <div class="panel-heading ui-draggable-handle">
                    <h3 class="push-up-0">Quizzes</h3>
                </div>
                <div class="panel-body list-group list-group-contacts">
                    <input type="text" class="form-control" id="searchQuiz" placeholder="Pesquise o quiz Aqui">
                    <ul type="none" style="padding:0;" id="listQuiz">
                        @forelse($quizzes as $quiz)
                        <li>
                            <a class="list-group-item"><b>Quiz #{{$quiz->id}}</b> - {{$quiz->title}}</a>
                        </li>
                        @empty
                        <li>
                            <a class="list-group-item"><b>Nenhum Quiz Disponível</b></a>
                        </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
        <!-- END CONTENT FRAME LEFT -->

        <!-- START CONTENT FRAME BODY -->
        <div class="content-frame-body content-frame-body-left" style="height: 575px;">
            <div class="timeline timeline-right">

                <div class="timeline-item timeline-item-right">
                    @forelse($quizzes as $quiz)
                    <div class="timeline-item-content bg-default" style="margin-bottom:1rem;" id="quiz{{$quiz->id}}">
                        <div class="timeline-heading padding-bottom-0">
                            <img src="{{ asset(@$quiz->avatar) }}" style="background-color:black"/> Publicado Por <a>{{@$quiz->name}}</a>

                            @if($deleteQuiz || $exportQuiz || $webMaster)
                            <ul class="panel-controls">
                                <li class="dropdown">
                                    <a class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-cog"></span></a>
                                    <ul class="dropdown-menu">
                                        @if($exportQuiz || $webMaster)
                                        <li class="dropdown-item text-success" onclick="$('form#exportExcelQuiz{{$quiz->id}}').submit()">
                                            {{-- form --}}
                                            <form action="{{route('GetReportQuizDataById', ['id' => base64_encode($quiz->id)])}}" method="POST" id="exportExcelQuiz{{$quiz->id}}">
                                                @csrf
                                            </form>
                                            <a href="#" onclick="noty({
                                                text: 'Seu Arquivo será baixado em breve, aguarde...',
                                                layout: 'topRight',
                                                type: 'success',
                                            })" class="text-success">
                                                <span class="fa fa-table"></span>
                                                Exportar
                                            </a>
                                        </li>
                                        @endif
                                        @if($deleteQuiz || $webMaster)
                                        <li class="dropdown-item text-danger">
                                            <a onclick="deleteQuiz({{$quiz->id}})" class="text-danger">
                                                <span class="fa fa-trash-o"></span>
                                                Excluir
                                            </a>
                                        </li>
                                        @endif
                                    </ul>
                                </li>
                            </ul>
                            @endif

                        </div>
                        <div class="timeline-body">
                            {{-- <img src="{{ asset('/') }}" style="background-color:black; width:100%; text-align:left" class="img-text" /> --}}
                            <h4><b>Quiz #{{$quiz->id}}</b> - {{$quiz->title}}</h4>
                            <p>{{$quiz->description}}</p>
                        </div>
                        <div class="timeline-footer">
                            <div class="input-group">
                                <div class="pull-left">

                                    <!-- if eu tiver respondido -->
                                    @if($quiz->answered >= 1)
                                    <a class="text-success">
                                        <i class="fa fa-check"></i>
                                        Respondido
                                    </a>
                                        @else
                                        <a href="{{ route('GetQuizzesView',[ 'id' => base64_encode($quiz->id) ]) }}" class="btn btn-{{Auth::user()->css}}">
                                            <!-- else eu tiver respondido -->
                                            <i class="fa fa-dot-circle-o"></i>
                                            Responda!
                                            @endif
                                        </a>
                                    </div>
                                    {{-- <div class="pull-right">
                                        <a><span class="fa fa-eye">{{$quiz->num_responses}}</span></a>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="timeline-item-content bg-default" style="margin-bottom:1rem;">
                            <div class="timeline-heading padding-bottom-0">
                                <div class="timeline-body">
                                    <h2><b>Nenhum Quiz Disponível</b></h2>
                                </div>
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT FRAME BODY -->
</div>


</div>
<!-- END PAGE CONTENT -->

</div>
<!-- END PAGE CONTAINER -->
@endsection
@section('Javascript')
<script language="javascript" id="quiz">
    $(function(){
        $("#searchQuiz").keyup(function(){
            var texto = $(this).val();

            $("#listQuiz li").css("display", "block");
            $("#listQuiz li").each(function(){
                if($(this).text().indexOf(texto) < 0)
                    $(this).css("display", "none");
            });
        });
    })

    function deleteQuiz(id) {
        $.ajax({
            url: "{{asset('api/quiz/' . Auth::user()->id )}}/"+id,
            method: "DELETE",
            success: function(response) {
                noty({
                    text: 'Quiz Excluído com Sucesso!',
                    layout: 'topRight',
                    type: 'success',
                    timeout: 1000
                })
                $("#quiz"+id).remove();

            },
            error: function(xhr,status) {
                noty({
                    text: xhr.message,
                    layout: 'topRight',
                    type: 'error',
                    timeout: 1000
                })
                console.log(xhr)
            }
        })
    }
</script>
@endsection
