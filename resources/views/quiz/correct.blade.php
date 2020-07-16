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
                                    <h4 class="col-md-12"><b>{{ strtoupper('Selecione as alternativas corretas') }}</b></h4>
									<a href="{{url()->previous()}}" class="col-md-12"> <h3 class="panel-title"><span class="fa fa-arrow-circle-o-left"></span> <b>Quiz #{{ $quiz->id }}</b> {{ $quiz->title }}</h3></a>                                    
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
							<h5 class="panel-title col-md-12">{{$quiz->description}}</h5>	
						</div>
					</div>
					<!-- Perguntas -->
					@foreach($questions as $question)
					<div class="panel panel-info">
						<div class="panel-heading ui-draggable-handle ui-sortable-handle">
							<p class="panel-title col-md-5">{{ $question->question }}</p>
						</div>
						<div class="panel-body">
							<!-- alternativas -->
							<div class="form-group col-md-12" id="option{{$question->id}}">
							<!-- Questões  -->
							</div>
							<!-- ./alternativas -->

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
	
	/******* Alternativas e seus formatos *******/
	function option(id) {
		$.getJSON('{{asset("api/quiz/options")}}/'+id,function(data){

			if(data.length > 0) {
				input = '<input type="hidden" name="multiple" id="multiple'+id+'" value>';
				$("#option"+id).append(input)
				
				$.each(data,function(index, value){
					$("#option"+id).append(multiple(value))
				});
			}
		});
	}

	function multiple(value) {
		linha = ' <div class="col-md-3"><label class="check"><input type="radio" value="'+value.question_id+'" id="'+value.id+'" name="question"/> '+value.text+'</label></div>';

		return linha;
	}

	function text(id) {
		// id = id da questão
		return '<div class="panel-body"><textarea  name="question" id="'+id+'" rows="5" placeholder="Digite aqui tua resposta" class="form-control"></textarea></div>';
	}

	/******* /Alternativas e seus formatos *******/
	function saveAnswer() {
		data = '_token='+$("input[name=_token]").val()+'&user={{Auth::user()->id}}&quiz={{ $quiz->id }}&question=';
		check = '&multiple=';

		$.each($("input[name=question]:checked"),function(i,v) {
			question = v.value //id da questão
			id = v.id //id da alternativa

			check += question+'_'+id+',';
		});
		 
		data += check

		$.ajax({
			url: "{{ route('PostQuizzesCorrectAnswer') }}",
			type: "POST",
			data: data,
			success: function(xhr,response) {
				$("#message-box-success").show();
				$("#tagPsuccess").html('Resposta salva com sucesso!');
				console.log(xhr)
			}, 
			error: function(xhr,status) {
				$("#message-box-danger").show();
				$("#tagPdanger").html(xhr.status);
				console.log(xhr)
			},
		})
	}

	$(document).ready(function(){
		@foreach($questions as $question)
		option({{$question->id}})
		@endforeach
	});
</script>
@include('quiz.components.quizJs')
@endsection
