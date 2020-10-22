@extends('layouts.app', ["current"=>"wiki"])
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
						<h2><span class="fa fa-arrow-circle-o-left"></span> Wiki</h2>
					</a>
				</div>
				<div class="pull-right">
					<button class="btn btn-default content-frame-right-toggle">
						<span class="fa fa-bars"></span>
					</button>
				</div>
				<!-- END CONTENT FRAME TOP -->

			</div>
			<!-- END CONTENT FRAME TOP-->

			<!-- START CONTENT FRAME RIGHT -->
			@include('assets.components.updates')
			<!-- END CONTENT FRAME RIGHT -->

			<!-- START CONTENT FRAME LEFT -->
			<div class="content-frame-body content-frame-body-left">
				{{-- cabeçalho --}}
				<div class="row">
					<div class="panel panel-colorful">
						<div class="panel-body col-md-1">
							<button class="btn btn-block btn-primary"><span class="fa fa-plus"> </span></button>
						</div>
						<div class="col-md-11">
							@forelse($tipos as $item)
							<div class="panel-body col-md-3">
								<button class="btn btn-block btn-default dropdown-toggle" data-toggle="dropdown">{{$item->name}}</button>
								<ul class="dropdown-menu" role="menu">
									<li role="presentation" class="dropdown-header">Ações</li>
									<li><a href="javascript:insertMaterial({{$item->id}})">Adicionar Material</a></li>
									<li><a href="#">Editar Categoria</a></li>
									<li><a href="#" class="text-danger"><span class="fa fa-warning"></span>Excluir Categoria</a></li>
								</ul>
							</div>

							@empty
							@endforelse
						</div>
					</div>
				</div>

				{{-- materiais --}}
				<div class="row">
					@forelse($tipos as $item)
					<div class="panel panel-light col-md-2 m-5">
						<div class="panel-heading">
							<div class="panel-title">
								{{$item->name}}
								{{-- <button class="btn btn-sm btn-primary"><span class="fa fa-plus"> </span></button> --}}
							</div>
						</div>
						<div class="panel-body">
							@forelse($item->materiais as $material)
							@empty
							@endforelse()
						</div>
					</div>
					@empty
					@endforelse
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
	function insertMaterial(tipo_id,) {
		$("input#insertUpdateMaterialId").val(0)
		$("input#insertUpdatetipo_id").val(tipo_id)
		$("div#insertUpdateMaterial").show()
	}

</script>
@endsection
@section('modal')
<form onsubmit="return false" method="POST" id="insertUpdateMaterialForm">
	@csrf
	<input type="hidden" name="id" id="insertUpdateMaterialId" value="0">
	<input type="hidden" name="id" id="insertUpdatetipo_id" value="3">
	<div class="modal in" id="insertUpdateMaterial" tabindex="-1" role="dialog" aria-labelledby="defModalHead" aria-hidden="false" style="display: none;">
		<div class="modal-dialog modal-lg">
			<div class="modal-content" style="overflow-y: scroll;">
				<div class="modal-header">
					<h4 class="modal-title" id="defModalHead">Monitoria</h4>
					<button type="button" class="close" onclick="javascript:$('#insertUpdateMaterial').hide()" data-dismiss="modal">
						<span aria-hidden="true">×</span>
						<span class="sr-only">Close</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="name">Título / Assunto</label>
						<input required type="text" name="name" class="form-control" id="name" placeholder="Título / Assunto">
					</div>
					<div class="form-group">
						<label for="tags">Tags</label>
						<input required type="text" name="tags" class="form-control" id="tags"
						placeholder="Tags" list="tags">
						<datalist id="tags">
							<select multiple="">
								@foreach($tags as $t)
								<option data-value="1" value="Roberto"></option>
								<option data-value="2" value="Rosana"></option>
								<option data-value="3" value="Romualdo"></option>
								@endforeach
							</select>
						</datalist>
					</div>
					<div class="panel panel-default form-group">
						<div class="panel-body">
							<h3><span class="fa fa-mail-forward"></span> Selecionar Material</h3>
							<div class="form-group">
								<div class="col-md-12">
									<label>Selecione a Material</label>
									<input type="file" class="" name="material" data-preview-file-type="any"/>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
@endsection