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
						<h2>
							<span class="fa fa-arrow-circle-o-left">
							</span> Medidas Disciplinares</h2>
						</a>
					</div>
					<div style="padding-left: 1%; padding-right: 1%;">
						<div class="panel panel-colorful">
							<div class="panel-heading ui-draggable-handle">
								<h3 class="panel-title">Modelos</h3>
							</div>
							<div class="panel-body" style="overflow-x: auto;">
								<table>
									<tbody>
										<tr>
											@php
											$i = 0
											@endphp
											<td class="col-md-2">
												<div class="col-md-12">
													<a href="{{ route('GetMeasuresCreate', [0]) }}" class="tile tile-default tile-valign" class="col-md-12">
														<span class="fa fa-plus fa-sm">
														</span>
														<p class="col-md-12">Criar</p>
													</a>
												</div>
											</td>
											@forelse($models as $m)
											<td class="col-md-2">
												<div class="col-md-12">
													<a href="{{ route('GetMeasuresCreate', [$m->id]) }}" class="tile tile-primary tile-valign" class="col-md-12">
														<span class="fa fa-file-text fa-sm">
														</span>
														<p class="col-md-12">{{$m->title}}</p>
													</a>
												</div>
											</td>
											@php
											switch ($i) {
												case 0:
												echo '<td class="col-md-8"></td>';
												break;
												
												case 1:
												echo '<td class="col-md-6"></td>';
												break;

												case 2:
												echo '<td class="col-md-4"></td>';
												break;

												case 3:
												echo '<td class="col-md-2"></td>';
												break;
											}
											@endphp
											@empty
											<td class="col-md-10"></td>
											@endforelse
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
				<!-- END CONTENT FRAME TOP-->

				<!-- START CONTENT FRAME RIGHT -->
				@include('assets.components.updates')
				<!-- END CONTENT FRAME RIGHT -->

				<!-- START CONTENT FRAME LEFT -->
				<div class="content-frame-body content-frame-body-left">
					<div class="rwo col-md-12">

						<div class="timeline timeline-right">
							{{-- laço que monta histórico de medidas  --}}
							@forelse($measures as $m)
							<div class="timeline-item timeline-item-right">
								<div class="timeline-item-info">{{ date('d/m/Y H:i') }}</div>
								<div class="timeline-item-icon">
									<span class="fa fa-file-text">
									</span>
								</div>
								<div class="timeline-item-content" style="margin-bottom:1rem;">
									<div class="timeline-heading padding-bottom-0">
										<img src="{{ asset($m->creator->avatar) }}">
										<label>{{ $m->creator->name }}</label>
									</div>
									<div class="timeline-body">
										<h4>{{ $m->title }}</h4>
										@if(!is_null($m->user_obs))
										<button class="btn btn-dark" onclick="$('#modalResp{{$m->id}}').show();">Clique para vizualizar a resposta do usuário</button>
										{{-- Modal  --}}
										<div class="modal in" id="modalResp{{$m->id}}" tabindex="-1" z-index="999" role="dialog" aria-labelledby="defModalHead" aria-hidden="false" style="margin-top:15%; display: none;">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">
														<h4 class="modal-title" id="defModalHead">Resposta do Usuário</h4>
													</div>
													<div class="modal-body">
														<div class="panel-body">
															<p>@php echo nl2br($m->user_obs) @endphp</p>
														</div>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-dark pull-right" onclick="$('#modalResp{{$m->id}}').hide()">Fechar</button>
													</div>
												</div>
											</div>
										</div>
										@endif
									</div>
									<div class="timeline-footer">
										@if($m->accept_user === 1)
										<button class="btn btn-default" style="	color: #38c172"><span class="fa fa-check"></span> Aceita pelo Usuário</button>
										@elseif($m->accept_user === 0)
										<button class="btn btn-default" style="	color: #e3342f"><span class="fa fa-times"></span> Não aceita pelo Usuário</button>
										@elseif($m->accept_user === 2)
										<button class="btn btn-default" style="	color: #6c757d"><span class="fa fa-clock-o"></span> Aguardando resposta do Usuário</button>
										@endif
										{{-- Exportar BTN  --}}
										<a href='{{ route('GetMeasureExport',['id' => $m->id]) }}' class="btn btn-danger text-white"><span class="fa fa-file-text-o"></span> Exportar</a>
									</div>
								</div>
							</div>
							@empty
							<div class="timeline-item timeline-item-right">
								<div class="timeline-item-info">{{ date('d/m/Y H:i') }}</div>
								<div class="timeline-item-icon">
									<span class="fa fa-file-text">
									</span>
								</div>
								<div class="timeline-item-content" style="margin-bottom:1rem;">
									<div class="timeline-heading padding-bottom-0">
										<span class="fa fa-times-circle-o fa-3x pull-left"></span>
									</div>
									<div class="timeline-body">
										<h4>Nenhuma Medida Disponível</h4>
									</div>
									<div class="timeline-footer">
										<button class="btn btn-default" style="	color: #6c757d"><span class="fa fa-times"></span> Nenhum status disponível</button>
									</div>
								</div>
							</div>
							@endforelse
							<div class="timeline-item timeline-main">
								<div class="timeline-date">
									<span class="fa fa-ellipsis-h"></span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
@section('Javascript')
<script type="text/javascript">

</script>
@endsection