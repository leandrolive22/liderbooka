@extends('layouts.app-horizontal',['current' => 'quiz'])
@section('content')
<!-- START PAGE CONTAINER -->
<div class="page-container">

	<!-- START PAGE CONTENT -->
	<div class="page-content">
		@component('assets.components.x-navbar-horizontal')
		@endcomponent
		<div class="content-frame"  style="padding-right:2rem; padding-left:2rem;">
			<div class="row" style="padding-top: 1rem;">
				<div class="col-md-12">
					<div class="panel-default">
						<div class="row text-center">
							<div class="panel panel-primary" style="padding-top: 1rem;">
								<div class="panel-heading ui-draggable-handle">
									<a href="{{url()->previous()}}"> <h3 class="panel-title text-justify"><span class="fa fa-arrow-circle-o-left"></span> <b>Quiz #{{ $quiz->id }}</b> {{ $quiz->title }}</h3></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
			<!-- START FORM -->
			<form class="class-horizontal" method="POST">
				@csrf
				<div class="panel-default" style="padding:1rem">
					<div class="panel panel-colorful">
						<div class="panel-heading bg-white">
							<h4 class="panel-title col-md-12"><b>Descrição</b></h4>
							<h5 class="panel-title col-md-12">{{$quiz->description}}</h5>	
						</div>
					</div>
					<!-- Perguntas -->
					@foreach($questions as $question)
					<div class="panel panel-info">
						<div class="panel-heading ui-draggable-handle ui-sortable-handle">
							<p class="panel-title col-md-12 text-justify">{{ $question->question }}</p>
						</div>
						<div class="panel-body">

							@if(!isset($question->option[0]->id))
							{{-- texto --}}
							<textarea name="question" id="{{$question->id}}" placeholder="Digite aqui tua resposta" class="form-control col-md-12"></textarea>
							{{-- ./texto --}}
							@else
							@php 
							$options = ($question->option);
							@endphp
							{{-- alternativas --}}							
							<div class="form-group col-md-12  text-justify" id="option{{$question->id}}">
								<input type="hidden" name="multiple" id="multiple{{$question->id}}">
								{{-- Alternativas --}}
								@foreach($options as $option)
								<div class="col-md-3">
									<label class="check @if($option->is_correct == 1) checkdataBaseCO @endif" id="{{$question->id}}">
										<input type="radio" class="iradio option_of_question @if($option->is_correct == 1) dataBaseCO @endif " value="{{$question->id}}" id="{{$option->id}}" name="question{{$question->id}}"/> 
										{{$option->text}}
									</label>
								</div>
								@endforeach
							</div>
							{{-- ./alternativas --}}
							@endif

						</div>
					</div>
					@endforeach
					<!-- ./ Perguntas -->
				</div>
				<div class="panel">
					<div class="panel-body">
						<div class="form-group">
							<button type="button" onclick="saveAnswer()" id="svBtnQ" class="btn btn-primary btn-block">Salvar Resposta</button>
						</div>	
					</div>
				</div>
			</form>
			<!-- END FORM -->

		</div>
	</div>
	<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->
@endsection

@section('Javascript')
<script type="text/javascript" src="{{ asset('js/plugins/tagsinput/jquery.tagsinput.min.js') }}"></script>

<script language="javascript">
	function nl2br (str, is_xhtml) {
		if (typeof str === 'undefined' || str === null) {
			return '';
		}
		var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
		return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
	}
	function saveAnswer() {
		data = '_token='+$("input[name=_token]").val()+'&user={{ Auth::id() }}&quiz={{ $quiz->id }}&question=';
		check = '&multiple=';

		//respostas objetivas
		$.each($("input[type=radio].option_of_question:checked"),function(i,v){
			question_id = v.value //id da questão
			id = v.id //id da alternativa escolhida

			check += question_id+'|_|___R___|_|'+id+'|_|___@___|_|';
		});

		//respostas dissertativa
		$.each($("textarea[name=question]"),function(i,v){
			value = v.value //resposta em texto
			id = v.id //id da questão

			data += id+'|_|___R___|_|'+value+'|_|___@___|_|';
		});

		data += check
		console.log(data)

		$.ajax({
			url: "{{ route('PostQuizzesAnswer') }}",
			type: "POST",
			data: data,
			success: function(xhr,response) {
				$("#message-box-success").show();
				$("#tagPsuccess").html('Resposta salva com sucesso!');
				console.log(xhr)
				
				showCorrect()
			}, 
			error: function(xhr,status) {
				$("#message-box-danger").show();
				$("#tagPdanger").html(xhr.status);
				console.log(xhr)
			},
		})
	}

	function showCorrect() {
		// A parte comentada coloca como vermelho as respostas erradas
		// v = $("input[type=radio].option_of_question:checked").parent().parent()
		// $.each(v,function(i,va){
		// 	$(va).attr('class',$(va).attr('class')+' bg-danger')
		// })
		$('label.checkdataBaseCO').attr('class','check bg-success')
		$("#svBtnQ").attr('onclick','window.location.href="{{route('GetQuizIndex',[ 'ilha' => Auth::user()->ilha_id, 'id' => Auth::id(), 'skip' => 0, 'take' => 20 ])}}"')
		$("#svBtnQ").html('Voltar')
	}
</script>
@include('quiz.components.quizJs')
@endsection
