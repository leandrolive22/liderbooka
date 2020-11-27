@extends('layouts.app', ["current"=>"monitor"])
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
					<h2>
                        <a href="{{ route('GetMonitoriasIndex') }}">
                            <span class="fa fa-arrow-circle-o-left"></span>
                        </a>
                        Contestações
                    </h2>

				</div>
				<div class="pull-right">
					<button class="btn btn-default content-frame-right-toggle">
                        <span class="fa fa-bars"></span>
					</button>
				</div>
			</div>
			<!-- END CONTENT FRAME TOP-->

			<!-- START CONTENT FRAME RIGHT -->
			<div class="content-frame-right scroll">
                <h3 class="panel-title">
                    Filtros
                </h3>
                <div class="form-grup" id="por_status">
                    <label type="button" class="btn btn-default col m-1 text-left">
                        <input type="radio" name="filtro_status" id="tableContestStatus1" class="form-check m-1 pull-left">
                        Procedentes
                    </label>
                    <label type="button" class="btn btn-default col m-1 text-left">
                        <input type="radio" name="filtro_status" id="tableContestStatus2" class="form-check m-1 pull-left">
                        Improcedentes
                    </label>
                    <label type="button" class="btn btn-default col m-1 text-left">
                        <input type="radio" name="filtro_status" id="tableContestStatus3" class="form-check m-1 pull-left">
                        Contestado
                    </label>
                    <label for="por_status" class="text-muted">
                        Status
                    </label>
                </div>
                @if(Auth::user()->cargo_id != 5)
                    <div class="form-group" id="por_usuarios">
                        <label type="button" class="btn btn-default col m-1 text-left">
                            <input type="radio" name="filtro_tipo" id="minhas_contestacoes" class="form-check m-1 pull-left" onchange="if(typeof $('#minhas_contestacoes:checked').val() !== 'undefined'){$('input[name=filtro_tipo]').prop('checked',false);$(this).prop('checked',true)}">
                            Minhas Contestações
                        </label>
                        <label type="button" class="btn btn-default col m-1 text-left">
                            <input type="radio" name="filtro_tipo" id="tableContestMonitorFilter" class="form-check m-1 pull-left" onclick="$('#contestSupervisorFilterDiv').hide();$('#contestMonitorFilterDiv').show();$('#minhas_contestacoes').prop('checked',false)">
                            Por Monitor
                        </label>
                        <div class="form-group col m-1" id="contestMonitorFilterDiv" style="display: none;">
                            <select name="contestMonitorFilter" id="contestMonitorFilter" class="form-control select" data-live-search="true">
                                @foreach ($monitores as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        @if(Auth::user()->cargo_id != 4 || in_array(67, $permissions))
                        <label type="button" class="btn btn-default col m-1 text-left">
                            <input type="radio" name="filtro_tipo" id="tableContestSupervisorFilter" class="form-check m-1 pull-left" onclick="$('#contestSupervisorFilterDiv').show();$('#contestMonitorFilterDiv').hide();$('#minhas_contestacoes').prop('checked',false)">
                            Por Supervisor
                        </label>
                        @else
                        <input type="hidden" name="tableContestSupervisorFilter" id="tableContestSupervisorFilter">
                        @endif
                        <label for="por_usuarios" class="text-muted">
                            Usuário
                        </label>
                    </div>
                    {{-- Select de supervisor  --}}
                    <div class="form-group col m-1" id="contestSupervisorFilterDiv" style="display: none;">
                        <select name="contestSupervisorFilter" id="contestSupervisorFilter" class="form-control select" data-live-search="true">
                            @foreach ($supervisores as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    @else
                <input type="hidden" name="tableContestMonitorFilter" id="tableContestMonitorFilter" value="false">
                <input type="hidden" name="tableContestSupervisorFilter" id="tableContestSupervisorFilter" value="false">
                <input type="hidden" name="contestMonitorFilter" id="contestMonitorFilter" value="false">
                <input type="hidden" name="contestSupervisorFilter" id="contestSupervisorFilter" value="false">
                @endif
                <button id="tableContestFilterBtn" class="btn btn-info col m-1" type="button">
                    <span class="fa fa-search"></span>
                    Filtrar
                </button>
			</div>
			<!-- END CONTENT FRAME RIGHT -->

			<!-- START CONTENT FRAME LEFT -->
			<div class="content-frame-body content-frame-body-left">
                <div class="panel panel-dark">
                    <table class="table table-hover">
                        <thead class="@if(Auth::user()->css == 'dark') thead-default @else thead-dark @endif">
                            <tr>
                                <th>Monitoria</th>
                                <th>Motivo</th>
                                <th>Status</th>
                                <th>Monitor</th>
                                <th>Supervisor</th>
                                <th>Data da Contestação</th>
                                <th>Ação</th>
                            </tr>
                            <tr>
                                <th colspan="7" class="text-center bg-secondary" id="tableContestPreLoader">
                                    <span class="fa fa-spinner fa-spin"></span>
                                    Processando...
                                </th>
                            </tr>
                        </thead>
                        <tbody id="tableContestTbody" style="display: none;">
                            @forelse($contestacoes as $item)
                                <tr id="tableContestTr_{{$item->Registro}}">
                                    <td>{{$item->Registro}}</td>
                                    <td>{{$item->motivo}}</td>
                                    <td>
                                        @if($item->status == 3)
                                        <span class="text-danger">CONTESTADO</span>
                                        @elseif($item->status == 2)
                                        IMPROCEDENTE
                                        @elseif($item->status == 1)
                                        PROCEDENTE
                                        @else
                                        <strong class="text-danger">ERRO,CONTATE O SUPORTE!</strong>
                                        @endif
                                    </td>
                                    <td>{{$item->monitor}}</td>
                                    <td>{{$item->supervisor}}</td>
                                    <td>{{date('d/m/Y H:i:s',strtotime($item->data_contestacao))}}</td>
                                    <td>
                                        <button class="btn btn-info btn-sm" onclick="view({{$item->Registro}})">
                                            <span class="fa fa-eye"></span>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <td colspan="7" class="text-center">Nenhum dado encontrado</td>
                            @endforelse
                        </tbody>
                    </table>
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
@section('modal')
    <form onsubmit="return false" id="viewContestacoesForm">
        @csrf
        <input type="hidden" name="viewContestacoesIH" id="viewContestacoesIH">
        <div class="modal in" id="viewContestacoes" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            Detalhar Contestação
                        </h4>
                        <button type="button" class="close" onclick="javascript:$('#viewContestacoes').hide()" data-dismiss="modal">
                            <span aria-hidden="true">×</span>
                            <span class="sr-only">Close</span>
                        </button>
                    </div>
                    {{-- Tabela de Contestações  --}}
                    <div class="modal-body" style="max-height: 60vh; overflow-y: auto">
                        <div class="panel panel-black" style="max-height: 30vh; overflow-y: auto">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Motivo</th>
                                        <th>Passo</th>
                                        <th>Status</th>
                                        <th>Data</th>
                                        <th>Obs</th>
                                    </tr>
                                </thead>
                                <tbody id="viewContestacoesTbody">
                                    <tr>
                                        <td ccolspan="5" class="text-center">Nenhum dado encontrado</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class='form-group' @if(!Auth::user()->cargo_id == 15 || !in_array(1,Session::get('permissionsIds')) || !in_array(66, Session::get('permissionsIds'))) style="display:none;" @endif>
                            <label for='getContestarSelect'>Motivo:</label>
                            <select id='getContestarSelect' name='getContestarSelect' class='form-control' required>
                                @foreach($motivos as $item)
                                    <option value="{{$item->id}}"> {{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- Apenas para Monitores ou gestores --}}
                        @if(Auth::user()->cargo_id == 15 || in_array(1,Session::get('permissionsIds')) || in_array(66, Session::get('permissionsIds')))
                          @php
                              $responder = TRUE;
                          @endphp
                        <div class='form-group'>
                            <label for='getContestarSelect'>Status:</label>
                            <select id='status' name='status' class='form-control' required>
                                <option value='2'>Improcedente</option>
                                <option value='1'>Procedente</option>
                            </select>
                        </div>
                        <div class='form-group'>
                            <label for='contestarTextarea'>Obs:</label>
                            <input id='contestarTextarea' name='contestarTextarea' max-length='255' class='form-control' placeholder='Observações'>
                        </div>
                        @else
                            @php
                                $responder = FALSE;
                            @endphp
                        @endif
                    </div>
                    <div class="modal-footer">
                        @if($responder)
                            <button type="button" class='btn btn-block btn-success' id="viewContestacoesBtn">Responder</button>
                        @else
                            <button type="button" class='btn btn-block btn-secondary' onclick="$('#viewContestacoes').hide()">Fechar</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@section('Javascript')
    <script type="text/javascript" id="contestacoesJS">
        // Executa a função quando a página está pronta
        $(() => {
            $("#tableContestPreLoader").hide()
            $("#tableContestTbody").show()
        })

        // Executa função ao clicar no botão
        $("button#tableContestFilterBtn").click(() => {
            data = {
                minhas_contestacoes: (typeof $("#minhas_contestacoes:checked").val() !== 'undefined'),
                tableContestStatus1: (typeof $("#tableContestStatus1:checked").val() !== 'undefined'),
                tableContestStatus2: (typeof $("#tableContestStatus2:checked").val() !== 'undefined'),
                tableContestStatus3: (typeof $("#tableContestStatus3:checked").val() !== 'undefined'),
                tableContestMonitorFilter: (typeof $("#tableContestMonitorFilter:checked").val() !== 'undefined'),
                tableContestSupervisorFilter: (typeof $("#tableContestSupervisorFilter:checked").val() !== 'undefined'),
                monitor: $("#contestMonitorFilter").val(),
                supervisor: $("#contestSupervisorFilter").val(),
            }

            $("tbody#tableContestTbody > tr").hide()
            $("#tableContestPreLoader").show()

            $.ajax({
                type: "GET",
                url: "{{route('GetContestacaofilterContest')}}",
                data: data,
                dataType: "json",
                success: function (response) {
                    console.log(response)
                    len = response.length
                    if(len > 0) {
                        linhas = ''
                        for(i=0; i<len; i++) {
                            linhas += montarLinha(response[i])
                        }
                        $("#tableContestTbody").html(linhas);
                    } else {
                        noty({
                            text: 'Nenhum dado encontrado!',
                            layout: 'topRight',
                            type: 'info'
                        })
                        $("tbody#tableContestTbody > tr").show()
                    }
                },
                error: function (xhr) {
                    console.log(xhr)
                    noty({
                            text: 'Erro ao alterar contestação!',
                            layout: 'topRight',
                            type: 'error'
                    })
                    try {
                        noty({
                            text: xhr.responseJSON.errorAlert,
                            layout: 'topRight',
                            type: 'error'
                        })
                    } catch (error) {
                        try {
                            console.log(error)
                            noty({
                                text: xhr.responseJSON.message,
                                layout: 'topRight',
                                type: 'error'
                            })
                        } catch (error2) {
                            console.log(error2)
                        }
                    }
                }
            });

            $("#tableContestPreLoader").hide()
        })

        function montarLinha(item) {
            data_contestacao = dataBr(item.data_contestacao)
            return  '<tr id="tableContestTr_'+item.Registro+'">'+
                        '<td>'+item.Registro+'</td>'+
                        '<td>'+item.motivo+'</td>'+
                        '<td>'+item.status+'</td>'+
                        '<td>'+item.monitor+'</td>'+
                        '<td>'+item.supervisor+'</td>'+
                        '<td>'+data_contestacao+'</td>'+
                        '<td>'+
                            '<button class="btn btn-info btn-sm" onclick="view('+item.Registro+')">'+
                                '<span class="fa fa-eye"></span>'+
                            '</button>'+
                        '</td>'+
                    '</tr>';
        }

        // Vê detalhes da contetação
        function view(id) {
            url = '{{ route("GetContestacaoByMon", ["id" => "---------------"]) }}'.replace('---------------', id)
            console.log(url)
            $.getJSON(url, function(data) {
                $("#viewContestacoesIH").val(id)
                console.log(data)
                len = data.length
                if(len > 0) {
                    linhas = ''
                    for(i=0; i<len; i++) {
                        const item = data[i]
                        date = dataBr(item.created_at)
                        obs = item.obs
                        motivo = $("#getContestarSelect > option[value="+item.motivo_id+"]").html()
                        passo = item.passo
                        if(item.status == '1') {
                            status = 'PROCEDENTE'
                        } else {
                            status = 'IMPROCEDENTE'
                        }

                        linhas += ' <tr>'+
                                        '<td>'+motivo+'</td>'+
                                        '<td>'+passo+'</td>'+
                                        '<td>'+status+'</td>'+
                                        '<td>'+date+'</td>'+
                                        '<td>'+obs+'</td>'+
                                    '</tr>'
                    }
                    $("#viewContestacoesTbody").html(linhas)
                    $("#viewContestacoes").show()
                } else {
                    noty({
                        text: 'Nenhum dado encontrado!',
                        layout: 'topRight',
                        type: 'info'
                    })
                }
            })
        }
        $("button#viewContestacoesBtn").click(() => {
            data = $("#viewContestacoesForm").serialize()
            console.log(data)

        })
    </script>
@endsection
