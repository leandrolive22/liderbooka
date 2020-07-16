@extends('layouts.app', ["current"=>"adm"])
@section('style')
<style type="text/css">
	
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
						<h2><span class="fa fa-arrow-circle-o-left"></span> Medidas Disciplinares - Criar</h2>
					</a>
				</div>
			</div>
			<!-- END CONTENT FRAME TOP-->

			<!-- START CONTENT FRAME RIGHT -->
			@include('assets.components.updates')
			<!-- END CONTENT FRAME RIGHT -->

			<!-- START CONTENT FRAME LEFT -->
			<div class="content-frame-body content-frame-body-left">
				<div class="panel panel-dark">
					<div class="row">

						<div class="panel-body">
							<div class="form-group">
								<h4>Selecione o usuário para aplicar a medida</h4>
								<select class="form-control select" data-live-search="true" name="user" id="user">
									<option value="0" selected="true" class="text-muted">Selecione um colaborador</option>
									@forelse($users as $u)
									<option value="{{$u->id}}">{{$u->name}}</option>
									@empty
									<option value="0">Nenhum colaborador disponível</option>
									@endforelse
								</select>
							</div>
							<div class="form-group">
								<div class="col-md-6">
									<button type="button" onclick="$('#modalAlineas').show()" class="btn btn-dark btn-block">Alíneas</button>
								</div>
								<div class="col-md-6">
									<button type="button" onclick="$('#modalTermo').show()" class="btn btn-dark btn-block">Termo de Conduta</button>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="panel-body">
							<div class="form-group">
								<label class="col-md-2 control-label" for="title">
									Título
								</label>
								<div class="input-group col-md-10 ">
									@if(!is_null($model))
									{{nl2br($model->title)}}
									@else
									<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
									<input type="text" name="title" id="title" maxlength="255" class="form-control">
									@endif
								</div>                                            
							</div>
							<div class="form-group">
								<label class="col-md-2 control-label" for="description">
									Corpo
								</label>
								@if(!is_null($model))
								<p class="col-md-10">
								@php 
								echo nl2br($model->description); 
								@endphp
								</p>
								@else
								<textarea style="min-height: 300px" class="col-md-10 form-control" type="text" name="description" id="description"></textarea>
								<p>
									<b>Para colocar dados dos usuários, utilize: </b>
									<code>:nome</code>
									<code>:cpf</code>
									<code>:cargo</code>
								</p>
								@endif
							</div>
							<div class="form-group">
								<label class="col-md-2 control-label" for="obs">
									Observações
								</label>
								<div class="input-group col-md-10 ">
									@if(!is_null($model))
									{{nl2br($model->obs)}}
									@else
									<span class="input-group-addon"><span class="fa fa-pencil"></span></span>
									<input type="text" name="obs" id="obs" maxlength="255" class="form-control">
									@endif
								</div>
							</div>
							@if(is_null($model))
							<div class="form-group">
								<label class="col-md-3 control-label">Tornar Modelo?</label>
								<div class="col-md-9">                         
									<label class="check">
										<input type="checkbox" class="icheckbox" name="icheck" id="icheck" />Caso queria salvar esse modelo para futuras aplicações, clique aqui.
									</label>
								</div>
							</div>
							@else
							<input type="hidden" name="modelId" id="modelId" value="{{  $model->id }}">
							@endif
							<div class="form-group">
								<button type="button" id="submit" class="btn btn-block btn-dark">Salvar</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- END CONTENT FRAME LEFT -->
	</div>
	<!-- START CONTENT FRAME -->

</div>
<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->
@endsection
@section('Javascript')
<script type="text/javascript">

	function checkInputs(argument) {
		verify = 0;
		if($("#user").val() === '0') {
			noty({
				text: 'Selecione um colaborador!',
				type: 'warning',
				layout: 'topRight',
				timeout: 3000
			});

			verify += 1;
		}

		if($("#title").val() === '') {
			noty({
				text: 'Selecione um colaborador!',
				type: 'warning',
				layout: 'topRight',
				timeout: 3000
			});

			verify += 1;
		}

		if($("#description").val() === '') {
			noty({
				text: 'Selecione um colaborador!',
				type: 'warning',
				layout: 'topRight',
				timeout: 3000
			});

			verify += 1;
		}

		if(verify > 0) {
			return false;
		}

		return true;
	}

	// submit form
	$("#submit").click(function(){
		if(checkInputs()) {
			if(typeof $("#icheck:checked").val() === 'undefined') {
				icheck = 1
			} else { 
				icheck = 0
			}

			//Dados do Form
			data = 'user='+$("#user").val()+'&title='+$("#title").val()+'&description='+$("#description").val()+'&obs='+$("#obs").val()+'&icheck='+icheck+'&modelId=@if(is_null($model)) 0 @else {{$model->id}} @endif';
			console.log(data)
			//Envia dados do Form
			$.ajax({
				url: '{{ route('PostMeasuresStore', [base64_encode(Auth::id())] ) }}',
				method: 'POST',
				data: data,
				error: function (xhr, error, status) {
					console.log(xhr)

					// Trata erros específicos
					if(status === 429 || status === 504 || status === 408) {
						noty({
							text: 'Erro! O servidor demorou para responder.<br> Aguarde, recarregue a página e tente novamente.',
							type: 'error',
							layout: 'topRight',
							timeout: 3000
						});	
					} else if(status === 500) {
						noty({
							text: 'Erro! Tente novamente!<br>Se o erro persistir, <a href="https://suporte.ativy.com">contate o suporte</a>',
							type: 'error',
							layout: 'topRight',
							timeout: 3000
						});	
					}
				},
				success: function (resp) {
					//Notificação de sucess
					noty({
						text: 'Salvo com sucesso!',
						type: 'success',
						layout: 'topRight',
						timeout: 3000
					});

					//Defini parâmetros dos campos como padrão
					$("#user").val(0)
					$("#title").val('')
					$("#description").val('')
					$("#obs").val('')
					$("#icheck").val(0)
				}
			})
		}
	})



</script>
@endsection
@section('modal')
@include('gerenciamento.measures.components.alineas')
@include('gerenciamento.measures.components.termodeconduta')
@endsection