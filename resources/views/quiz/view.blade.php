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

							{{-- alternativas --}}
							@if(isset($question->option) || @count($question->option) > 0)
							@php 
							$options = ($question->option);
							@endphp
							
							<div class="form-group col-md-12  text-justify" id="option{{$question->id}}">
								<input type="hidden" name="multiple" id="multiple{{$question->id}}" value>
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
							@else
							<div class="panel-body">
								<textarea  name="question" id="{{$question->id}}" rows="5" placeholder="Digite aqui tua resposta" class="form-control"></textarea>
							</div>
							@endif

						</div>
					</div>
					@endforeach
					<!-- ./ Perguntas -->
				</div>
				<div class="panel">
					<div class="panel-body">
						<div class="form-group">
							<button type="button" onclick="saveAnswer()" class="btn btn-primary btn-block">Salvar Resposta</button>
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
	
	/******* Alternativas e seus formatos *******/
	function option(id) {
		$.getJSON('{{asset("api/quiz/options")}}/'+id,function(data){

			if(data.length == 0) {
				$("#option"+id).append(text(id))
			} else {
				input = '<input type="hidden" name="multiple" id="multiple'+id+'" value>';
				$("#option"+id).append(input)
				
				$.each(data,function(index, value){
					$("#option"+id).append(multiple(value))
				});
			}
		});
	}

	function multiple(value) {
		linha = ' <div class="col-md-3"><label class="check">'+
		'<input type="radio" class="option_of_question" value="'+value.question_id+'" id="'+value.id+'" name="question'+value.question_id+'"/> '+value.text+'</label></div>';

		return linha;
	}

	function text(id) {
		// id = id da questão
		return '<div class="panel-body"><textarea  name="question" id="'+id+'" rows="5" placeholder="Digite aqui tua resposta" class="form-control"></textarea></div>';
	}

	/******* /Alternativas e seus formatos *******/
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
		$.each($("label.checkdataBaseCO"),function(i,v){
			//  destaca todos os corretos
			$(v).attr('class','check bg-success')

			// id da questão
			id = v.id

			//verifica se a resposta escolhida é a mesma que está vermelha
			// if($("input.option_of_question:checked[value="+id+"]").attr('id') == selected) {
				

			// } 
		});

	}

	$(document).ready(function(){
		{{--
			@foreach($questions as $question)
			option({{$question->id}})
			@endforeach
			--}}
		});
	</script>
	@include('quiz.components.quizJs')
	@endsection
