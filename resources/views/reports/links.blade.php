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
						<h2><span class="fa fa-arrow-circle-o-left"></span> Relatórios de Links</h2>
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
				<div class="panel panel-colorful">
					<div class="panel-heading pull-center text-center" id="preloaderPage">
						<div class="d-flex justify-content-center">
							  <div class="spinner-border" role="status">
							  </div>
						</div>
						Carregando...
					</div>
					<div class="panel-body">
						<table class="table datatable">
							<thead>
								<tr>
									<th>#</th>
									<th>Link/HashTag</th>
									<th>Ação</th>
								</tr>
							</thead>
							<tbody>
								@php $i = 1; @endphp
								@forelse($log as $item)
								<tr>
									<td>{{$i}}</td>
									<td>{{$item->value}}</td>
									<input type="hidden" name="linkTag{{$i}}" id="linkTag{{$i}}" value="{{$item->value}}">
									<td><button class="btn btn-sm btn-primary" id="relatorio{{$i}}" onclick="$(this).prop('disabled',true);$('#preloaderPage').show();getRelatorio({{$i}})">Ver Relatório</button></td>
								</tr>
								@php$i++;@endphp
								@empty
								<tr>
									<td colspan="2">Nenhum dado encontrado</td>
								</tr>
								@endforelse
							</tbody>
						</table>
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
<script type="text/javascript" src="{{ asset('js/plugins/tableexport/tableExport.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/plugins/tableexport/jquery.base64.js') }}"></script>
<script type="text/javascript">
	function getRelatorio(pageId) {
		// Verifica se pesquia já foi realizada
		if($("#modalLinkTagIpt"+pageId).val() > 0) {
			$("#modalLinkTag"+pageId).show()
		} else {
			// Pega link
			linkTag = $("#linkTag"+pageId).val();

			// Faz consulta pelo relatório
			$.ajax({
				url: '{{ route('PostRelatoriosGetLinkTag',[Auth::id()]) }}',
				data: 'linkTag='+linkTag,
				method: 'POST',
				success: function (data) {
					modal = '<div class="modal in" id="modalLinkTag'+pageId+'" tabindex="-1" z-index="999" role="dialog" aria-labelledby="defModalHead" aria-hidden="false" style="display: block;">'+
	                        '<div class="modal-dialog">'+
	                        '<input type="hidden" value="'+pageId+'" id="modalLinkTagIpt'+pageId+'" name="modalLinkTagIpt'+pageId+'">'+
	                        '<div class="modal-content">'+
	                        '<div class="modal-header">'+
	                        '<h4 class="modal-title" id="defModalHead">Relatório de Links/HashTags'+
	                        '</div>'+
	                        '<div class="modal-body" style="overflow-y: auto; max-height: 400px;">'+
	                        '<table id="linkTagTable'+pageId+'" class="table table-responsive table-bordered datatable">'+
	                        '<thead>'+
	                        '<tr>'+
	                        '<td colspan="3"><h4 class="text-center">Link/Tag: '+createTextLinks_(hashtag(linkTag))+'<h4></td>'+
	                        '</tr>'+
	                        '<tr>'+
	                        '<th>Usuário</th>'+
	                        '<th>CPF</th>'+
	                        '<th>Data de Acesso</th>'+
	                        '</tr>'+
	                        '</thead>'+
	                        '<tbody>'+
	                        '<tr>';
	                        //Quantidade total
	                        numberOfRows = 0;

	                        // Monta linhas da tabela no modal
	                        for(i=0; i<data.length; i++) {
								numberOfRows += 1
	                        	dbDate = new Date(data[i].linkTag)
	                        	date = dbDate.getDate()+'/'+("0" + (dbDate.getMonth() + 1)).slice(-2)+'/'+dbDate.getUTCFullYear()+' '+dbDate.getHours()+':'+dbDate.getMinutes()
	                        	modal += 	'<tr>'+
						                        '<td>'+data[i].name+'</td>'+
						                        '<td>'+data[i].cpf+'</td>'+
						                        '<td>'+date+'</td>'+
					                    	'</tr>';
	                        }
	                $('#relatorio'+pageId).prop('disabled',false)

	                        
	               modal += '</tbody>'+
	               			'<tfoot class="info">'+
	               			'<tr class="info">'+
	               			'<td>TOTAL</td>'+
	               			'<td colspan="2">'+Number(numberOfRows)+'</td>'+
	               			'</tr>'+
	               			'</tfoot>'+
	                        '</table>'+
	                        '</div>'+
	                        '<div class="modal-footer">'+
	                        '<button type="button" class="btn btn-secondary" onclick="$('+"'#modalLinkTag"+pageId+"'"+').hide()" data-dismiss="modal">Fechar</button>'+
	                        '<button type="button" class="btn btn-success" onclick="$('+"'#linkTagTable"+pageId+"'"+').tableExport({type:'+"'excel'"+',escape:'+"'false'"+'})" data-dismiss="modal">Exportar</button>'+
	                        '</div>'+
	                        '</div>'+
	                        '</div>'+
	                        '</div>';

	                // Coloca modal na página
	                $('body').append(modal);
				},
				error: function (xhr) {
	                $('#relatorio'+pageId).prop('disabled',false)
					console.log(xhr)
					noty({
						text: 'Erro! Tente novamente mais tarde,<br>Se o erro persistir, contate o suporte',
						layout: 'topRight',
						type: 'error',
						timeout: 3000
					})
				}
			});
		}

		// preloader
		return $("#preloaderPage").hide()
	}

	$(document).ready(function(){
		$("#preloaderPage").hide()
	})
</script>
@endsection