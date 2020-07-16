@extends('layouts.app', ["current"=>"monitor"])
@section('style')
<style type="text/css">
	td {
        height: 100%;
    }
    main h1 {
      font-size: 60px; 
     background-color: black; 
     color: #FFF; 
     text-align: center;
 }
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
					<a href="">
						<h2 class="page-title">
							<span class="fa fa-arrow-circle-o-left">
                            </span>
                            Supervisão Monitoria
                        </h2>
						</a>
                    </div>
                </div>
                {{-- Content --}}
                <div class="row col-md-12">
					<div style="padding-left: 1%; padding-right: 1%; background-color: #fff;" class="col-md-12">

                    <div class="panel-body" style="overflow-x: auto;">
								<table class="col-md-10">
									<tbody>
                                        <tr style="max-height: 50%">
                                            {{-- botao padrão  --}}
											<td class="col-md-4">
													<a href="{{ route('FindResult') }}" class="tile tile-default col-md-4" class="col-md-4">
														<span class="fa fa-plus fa-sm">
														</span>
														<p class="col-md-12">Buscar Resultado</p>
													</a>
                                            </td>
                                        </tr>
                                  </tbody>
                                        <table class="col-md-10">
                                        <tr style="max-height: 50%">
                                            {{-- botao padrão  --}}
											<td class="col-md-4">
													<a href="{{ route('FindMonitoring') }}" class="tile tile-default col-md-4" class="col-md-4">
														<span class="fa fa-plus fa-sm">
														</span>
														<p class="col-md-12">Buscar Monitoria</p>
													</a>
                                            </td>
                                       </tr>
                              </tbody>
                              <table class="col-md-10">
                                        <tr style="max-height: 50%">
                                            {{-- botao padrão  --}}
											<td class="col-md-4">
													<a href="{{ route('FindFeedBack') }}" class="tile tile-default col-md-4" class="col-md-4">
														<span class="fa fa-plus fa-sm">
														</span>
														<p class="col-md-12">Buscar FeedBack</p>
													</a>
                                            </td>
                                       </tr>
                              </tbody>
                            <br>
                     </div>
                 </div>           
             </div>
		</div>
	</div>
</div>
@endsection
@section('modal')
{{-- Modal de Relatório  --}}
<div class="modal in" id="modalMonitoring" tabindex="-1" role="dialog" aria-labelledby="defModalHead" aria-hidden="false" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defModalHead">Monitoria</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">×</span><span class="sr-only">Close</span>
                </button>
            </div>
            <div class="modal-body" style="overflow-y: auto; max-height:500px;">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <input type="hidden" name="idModal" value="0" id="idModal">
                        <div class="form-row col-md-12">
                            <div class="form-group col-md-6">
                                <label for="datelaudo">Data do Laudo</label>
                                <input class="form-control pull-right" readonly id="datelaudo">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="hash_monitoria">Hash da Monitoria</label>
                                <input class="form-control pull-right" readonly id="hash_monitoria" >
                            </div>
                        </div>
                        <div class="form-row col-md-12">
                            <div class="form-group col-md-6">
                                <label for="monitor">Monitor</label>
                                <input class="form-control" readonly id="monitor">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="supervisor">Supervisor</label>
                            </div>
                        </div>
                        <div class="form-row col-md-12">
                            <div class="form-group col-md-6">
                                <label for="operador">Operador</label>
                                <input class="form-control" readonly id="operador">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="userCli">Usuário-Cliente</label>
                                <input class="form-control" readonly id="userCli">
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="form-row col-md-12">
                            <div class="form-group col-md-4">
                                <label for="user">Cliente</label>
                                <input class="form-control" readonly id="cliente">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="user">CPF do Cliente</label>
                                <input class="form-control" readonly id="cpf">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="monitor">Produto</label>
                                <input class="form-control" readonly id="produto">
                            </div>
                        </div>
                        <div class="form-row col-md-12">
                            <div class="form-group col-md-6">
                                <label for="monitor">ID do Audio</label>
                                <input class="form-control" readonly id="id_audio">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="tipo_ligacao">Tipo de Ligação</label>
                                <input class="form-control" readonly id="tipo_ligacao">
                            </div>
                        </div>
                        <div class="form-row col-md-12">
                            <div class="form-group col-md-6">
                                <label for="user">Tempo da Ligação</label>
                                <input class="form-control" readonly id="tempo_ligacao">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="monitor">Data da Ligação</label>
                                <input class="form-control" readonly id="data_call">
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="form-row col-md-12">
                            <div class="form-group col-md-4">
                                <label for="user">Pontos Positivos</label>
                                <input class="form-control" readonly id="pontos_positivos">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="monitor">Pontos a Desenvolver</label>
                                <input class="form-control" readonly id="pontos_desenvolver">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="monitor">Pontos de Atenção</label>
                                <input class="form-control" readonly id="pontos_atencao">
                            </div>
                        </div>
                        <div class="form-row col-md-12">
                            <div class="form-group col-md-4">
                                <label for="user">Feedback do Monitor</label>
                                <textarea class="form-control" @if(Auth::user()->cargo_id == 15) @else readonly @endif id="feedback_monitor"></textarea>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="monitor">Feedback do Supervisor</label>
                                <textarea class="form-control" @if(Auth::user()->cargo_id == 4) @else readonly @endif id="feedback_supervisor"></textarea>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="monitor">Feedback do Operador</label>
                                <textarea class="form-control" readonly id="feedback_operador"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="form-row col-md-12">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Numero</th>
                                        <th>Pergunta</th>
                                        <th>Sinalização</th>
                                        <th>Procedimento</th>    
                                    </tr>
                                </thead>
                                <tbody id="laudos">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
          
        </div>
    </div>
</div>
@endsection
