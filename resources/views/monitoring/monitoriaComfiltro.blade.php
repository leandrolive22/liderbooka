@extends('layouts.app', ["current"=>"monitor"])
@section('style')
<style type="text/css">
    td {
        height: 100%;
    }
    #historico{
        font-family: Sans-serif;
    }
    .notfound{
        display: none;
    }
</style>
@endsection
@section('content')
<!-- START PAGE CONTAINER -->
<div class="page-container">

    <!-- PAGE CONTENT -->
    <div class="page-content">

        <div class="spinner-grow text-dark" role="status" id="loadingPreLoader" style="margin-left:35%; margin-right:35%; margin-top:10%; width: 30rem; height:30rem">
            <span class="sr-only">Loading...</span>
        </div>

        @component('assets.components.x-navbar')
        @endcomponent

        <!-- START CONTENT FRAME -->
        <div class="content-frame" id="monitoria" style="display: none">

            <!-- START CONTENT FRAME TOP -->
            <div class="content-frame-top">
                <div class="page-title">
                    <a href="{{ url()->previous() }}">
                        <h2 class="page-title">
                            <span class="fa fa-arrow-circle-o-left">
                            </span>
                            Monitoria LiderBook
                        </h2>
                    </a>
                </div>
            </div>
            {{-- Content --}}
            <div class="row col-md-12">
                @if($webMaster || $isMonitor)
                <div style="padding-left: 1%; padding-right: 1%;" class="col-md-12">
                    <div class="panel panel-colorful">
                        <div class="panel-heading ui-draggable-handle">
                            <h3 class="panel-title">Modelos/Laudos</h3>
                        </div>
                        <div class="panel-body" style="overflow-x: auto;">
                            <table class="col-md-10">
                                <tbody>
                                    <tr style="max-height: 50%">
                                        @if($webMaster || $criarLaudo)
                                        {{-- botao padrão  --}}
                                        <td class="col-md-4">
                                            <a href="{{ route('GetMonitoriasCreate') }}" class="tile tile-default col-md-12" class="col-md-12">
                                                <span class="fa fa-plus fa-sm">
                                                </span>
                                                <p class="col-md-12">Criar Modelo/Laudo</p>
                                            </a>
                                        </td>
                                        @endif
                                        {{-- laços com modelos pré-registrados   --}}
                                        @forelse ($models as $item)
                                        <td class="col-md-4" style="min-width: 20rem" id="laudoModel{{$item->id}}">
                                            <div class="tile tile-default col-md-12">
                                                <div class="form-group form-row col-md-12" style="height: 5rem">
                                                    <p>{{ $item->titulo }}</p>
                                                </div>
                                                <div class="btn-group btn-group-xs">
                                                    {{-- Aplicar Laudo --}}
                                                    @if($webMaster || $aplicarAplicar)
                                                    <a role="button" class="btn btn-success" href="javascript:$('#formToApply').attr('action','{{route('PostLaudoToApply',['model' => $item->id])}}');$('#formToApplyModal').show();">
                                                        Aplicar
                                                    </a>
                                                    @endif

                                                    {{-- Editar Laudo --}}
                                                    @if($webMaster || $editarLaudo)
                                                    @endif

                                                    {{-- <button role="button" class="btn btn-secondary">Editar</button> --}}
                                                    @if($webMaster || $excluirLaudo)
                                                    <button role="button" id="deleteLaudo{{$item->id}}" onclick="deleteLaudo({{$item->id}})" class="btn btn-danger">
                                                        Excluir
                                                    </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        @empty
                                        <td class="col-md-8"></td>
                                        @endforelse
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
            </div>
@if($webMaster || $dash || $export)
                
                {{-- <div class="panel panel-secondary">
                    <div class="panel-heading ui-dragable-handle">
                        <h3 class="panel-title">
                            Relatórios
                            <span class="fa fa-bar-chart-o"></span>
                        </h3>
                        <ul class="panel-controls">
                            <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                        </ul>
                    </div>
                    <div class="panel-body">
                        {{-- Relatórios em Cards --}
                        <div class="col-md-3">
                            <div class="widget @if($webMaster || $media > 94 ) widget-success @elseif($media > 89) widget-primary @else widget-danger @endif widget-padding-sm">
                                <a href="javascript:" class="text-light">
                                    <div class="widget-item-left">
                                        <input class="knob" data-width="80" data-height="80" data-min="0" data-max="100" data-displayInput=false data-bgColor="rgba(143,178,85,0.1)" data-fgColor="#FFF" value="{{$media}}%" data-readOnly="true" data-thickness=".3"/>
                                    </div>
                                    <div class="widget-data">
                                        <div class="widget-subtitle">Média Geral neste Mês</div>
                                        <div class="widget-big-int"><span class="num-count">{{$media}}</span>%</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="widget bg-dark widget-padding-sm">
                                <a href="#" class="text-light">
                                    <div class="widget-subtitle">NCG neste Mês</div>
                                    <div class="widget-big-int"><span class="num-count">{{@$ncgs}}</span></div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="widget widget-primary widget-padding-sm">
                                <a href="#" class="text-light">
                                    <div class="widget-subtitle">Avaliações neste Mês</div>
                                    <div class="widget-big-int"><span class="num-count">{{$count}}</span></div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="widget widget-info">
                                <div class="widget-subtitle">Relatório por</div>
                                <div class="widget-title">Cliente</div>
                                <div class="widget-int">
                                    <div class="btn-group">
                                        <input type="number" maxlength="11" name="cpf_cliente" id="cpf_cliente" class="btn btn-default" placeholder="Busca por CPF">
                                        <button class="btn btn-dark" id="btnSBCPF" onclick="searchByCpfCli()"><span class="fa fa-search"></span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div> --}
            {{-- Grafico --}}
            <div class="row col-md-12">
                <div class="panel panel-secondary">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Monitoria
                            <p class="text-muted">Atualizado diariamente</p>
                        </h3>
                        <ul class="panel-controls pull-right">
                            <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                        </ul>
                        @if($webMaster || $export)
                            <button onclick="$('#modalAnaliticoMonitoria').show();" class="btn btn-outline-success pull-right"><span class="fa fa-table">&nbsp;</span> Exportar Analítico</button>
                        @endif
                    </div>
                    <div class="panel-body text-center" style="overflow-x:scroll">
                        <div class="col-md-3" style="display: none">
                            <label for="quartisChart" class="col-md-12">Quartis</label>
                            <div id="quartisChart" style="width: 250px; height: 250px"></div>
                        </div>
                        <div class="col" style="border: solid 0.5px gray">
                            <iframe width="980" height="640" src="https://app.powerbi.com/view?r=eyJrIjoiMDE5OGNmMWEtN2E3Ni00MDNhLThkNjktMzA2ZmIxMTc1MDFiIiwidCI6ImZkYzJlZjNkLWEzZDEtNDA1OC1hOTA4LTAxMWMxMTcxZTYxNiJ9" frameborder="0" allowFullScreen="true"></iframe>
                        </div>
                    </div>
                </div>
            </div>
@endif
@if($webMaster || $isMonitor || $isSupervisor)
            <div class="row col-md-12">
                {{-- Histórico --}}
                <div class="panel panel-dark">
                    <div class="panel-heading">
                        <h2 id="historico" class="panel-title">
                            <p>Histórico de Monitorias</p>
                            <p class="text-danger">As linhas em vermelho evidenciam quais monitorias estão pendentes de feedback do supervisor</p>
                        </h2>
                        <ul class="panel-controls">
                            <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                        </ul>
                        <div class="input-group pull-right">
                            <input class="form-control col-md-4" name="searchInTable" id="searchInTable" placeholder="Pesquise por Monitoria Aqui">
                            <span class="input-group-addon fa fa-search btn" onclick="searchInTable()"></span>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table class="table table-hover @if(!$isMonitor && !$webMaster) datatable @endif">
                            <thead>
                                <tr>
                                    <th>Monitoria</th>
                                    <th>Operador</th>
                                    <th>Supervisor</th>
                                    <th>Monitor</th>
                                    <th>Data da Ligação</th>
                                    <th>ID do Audio</th>
                                    <th>Media</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($monitorias as $m)
                                <tr id="monitoriaLinha{{$m->id}}" @if(is_null($m->supervisor_at)) class="bg-danger" @endif>
                                    <td>#{{ $m->id }}</td>
                                    {{-- Operador  --}}
                                    @if (isset($m->operador->name))
                                    <td>{{ $m->operador->name }}</td>
                                    @else
                                    <td>N/P</td>
                                    @endif
                                    {{-- Supervisor  --}}
                                    @if (isset($m->supervisor->name))
                                    <td>{{ $m->supervisor->name }}</td>
                                    @else
                                    <td>N/P</td>
                                    @endif
                                    {{-- Monitor --}}
                                    @if(isset($m->monitor['name']))
                                    <td>{{ $m->monitor['name'] }}</td>
                                    @elseif(isset($m->monitor->name))
                                    @else
                                    <td>N/A</td>
                                    @endif

                                    <td>{{ date('d/m/Y',strtotime($m->created_at)) }}</td>
                                    <td>{{ $m->id_audio }}</td>
                                    <td>{{ $m->media }}%</td>
                                    <td class="btn-group btn-group-sm">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-secondary"id="btnView{{$m->id}}" onclick="viewMonitoring({{$m->id}})">Ver</button>
                                            @if ($webMaster || $isMonitor)
                                                @if($webMaster || $editarMonitoria || $excluirMonitoria)
                                                    <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown"></button>
                                                    <ul class="dropdown-menu" role="menu">
                                                        <li role="presentation" class="dropdown-header">Outras Ações</li>
                                                        {{-- Editar Monitoria --}}
                                                        @if($webMaster || $editarMonitoria)
                                                            <li><a href="{{route('GetMonitoriaEdit',['id' => $m->id])}}">Editar</a></li>
                                                        @endif

                                                        {{-- Excluir Monitoria --}}
                                                        @if($webMaster || $excluirMonitoria)
                                                            <li><a onclick="deleteMonitoria({{$m->id}})">Excluir</a></li>
                                                        @endif
                                                    </ul>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center">Nenhuma monitoria encontrada</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if($isMonitor  || $webMaster)
                    <div class="panel-footer">
                        {{ $monitorias->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
@section('modal')
@if($webMaster || $isMonitor)
{{-- Modal de relatório analítico --}}
@include('monitoring.components.modais.analitico')

{{-- Modal de relatório de Clientes --}}
@include('monitoring.components.modais.cliente')

{{-- Modal relatório de assinaturas --}}
@include('monitoring.components.modais.assinaturas')

{{-- Modal de Aplicação de Laudos --}}
@include('monitoring.components.modais.userslaudos')
@endif

{{-- Modal de resultado de Relatório  --}}
@include('monitoring.components.modais.resultRelatorio')

@endsection
@section('Javascript')
<script type="text/javascript" src="{{asset('js/plugins/knob/jquery.knob.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/plugins/owl/owl.carousel.min.js')}}"></script>
{{-- MORRIS  --}}
<script type="text/javascript" src="{{asset('js/plugins/morris/raphael-min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/plugins/morris/morris.min.js')}}"></script>
{{-- NVD3 --}}
<script type="text/javascript" src="{{asset('js/plugins/nvd3/lib/d3.v3.js')}}"></script>
<script type="text/javascript" src="{{asset('js/plugins/nvd3/nv.d3.min.js')}}"></script>
<script type="text/javascript">
    function viewMonitoring(id) {
        $("#btnView"+id).html('<span class="fa fa-spinner fa-spin"></span>')
        if($("#idModal").val() !== id) {
            $.getJSON('{{asset("api/monitoring/view")}}/'+id,function(data){
                if(data.length > 0) {
                    // Monta linhas da tabela com os laudos
                    linhas = ''
                    for ( i = 0; i < data.length; i++) {
                        linhas += '<tr>'+
                        '<td>'+data[i].numero+'</td>'+
                        '<td>'+data[i].questao+'</td>'+
                        '<td>'+data[i].sinalizacao+'</td>'+
                        '<td>'+data[i].value+'</td>'+
                        '</tr>';
                    }
                    $("#idModal").val(data[0].id)
                    // trata datas
                    dateCall = data[0].data_ligacao//.split('-');
                    // dateCall.reverse();
                    // dateCall.join('/');
                    datelaudo = data[0].created_at//.split('-');
                    // datelaudo.reverse();
                    // datelaudo.join('/');
                    // coloca campos
                    $("#operador").val(data[0].operador)
                    $("p#operador").html(data[0].operador)
                    $("#userCli").val(data[0].usuario_cliente)
                    $("p#userCli").html(data[0].usuario_cliente)
                    $("#supervisor").val(data[0].supName)
                    $("p#supervisor").html(data[0].supName)
                    $("#monitor").val(data[0].moniName)
                    $("p#monitor").html(data[0].moniName)
                    $("#produto").val(data[0].produto)
                    $("p#produto").html(data[0].produto)
                    $("#cliente").val(data[0].cliente)
                    $("p#cliente").html(data[0].cliente)
                    $("#cpf").val(data[0].cpf_cliente)
                    $("p#cpf").html(data[0].cpf_cliente)
                    $("#id_audio").val(data[0].id_audio)
                    $("p#id_audio").html(data[0].id_audio)
                    $("#tipo_ligacao").val(data[0].tipo_ligacao)
                    $("p#tipo_ligacao").html(data[0].tipo_ligacao)
                    $("#tempo_ligacao").val(data[0].tempo_ligacao)
                    $("p#tempo_ligacao").html(data[0].tempo_ligacao)
                    $("#data_call").val(data[0].data_ligacao+' '+data[0].hora_ligacao)
                    $("p#data_call").html(data[0].data_ligacao+' '+data[0].hora_ligacao)
                    $("#pontos_positivos").val(data[0].pontos_positivos)
                    $("p#pontos_positivos").html(data[0].pontos_positivos)
                    $("#pontos_desenvolver").val(data[0].pontos_desenvolver)
                    $("p#pontos_desenvolver").html(data[0].pontos_desenvolver)
                    $("#pontos_atencao").val(data[0].pontos_atencao)
                    $("p#pontos_atencao").html(data[0].pontos_atencao)
                    $("#hash_monitoria").val(data[0].hash_monitoria)
                    $("p#hash_monitoria").html(data[0].hash_monitoria)
                    $("#ncg").val(data[0].ncg)
                    $("p#ncg").html(data[0].ncg)
                    $("#feedback_monitor").val(data[0].feedback_monitor)
                    $("p#feedback_monitor").html(data[0].feedback_monitor)
                    $("#feedback_supervisor").val(data[0].feedback_supervisor)
                    $("p#feedback_supervisor").html(data[0].feedback_supervisor)
                    $("#feedback_operador").val(data[0].feedback_operador)
                    $("p#feedback_operador").html(data[0].feedback_operador)
                    $("#datelaudo").val(data[0].created_at)
                    $("p#datelaudo").html(data[0].created_at)
                    $("#conf").val(data[0].conf)
                    $("p#conf").html(data[0].conf)
                    $("#nConf").val(data[0].nConf)
                    $("p#nConf").html(data[0].nConf)
                    $("#nAV").val(data[0].nAv)
                    $("p#nAV").html(data[0].nAv)
                    $("#media").val(data[0].media)
                    $("p#media").html(data[0].media)
                    if(data[0].feedback_supervisor !== null) {
                        $("textarea#feedback_supervisor").attr('style','border-color: #95B75D')
                    }
                    //tabela de laudos
                    $("tbody#laudos").html(linhas)
                    $("#modalMonitoring").show()
                } else {
                    noty({
                        text: 'Nenhum dado encontrado',
                        layout: 'topRight',
                        timeout: 3000,
                        type: 'warning'
                    })
                }
                $("#btnView"+id).html('Ver')
            });
} else {
    $("#modalMonitoring").show()
    $("#btnView"+id).html('Ver')
}
}
    //pega nome do supervisor
    function getUserNameById(id,type) {
        $.getJSON("{{asset('api/data/user/json')}}/"+id,function(user){
            if(type == 'mon') {
                $("#monitor").val(user[0].name)
            } else {
                $("#supervisor").val(user[0].name)
            }
        })
    }
    @if($webMaster || $isMonitor)
    // exclui monitoria
    function deleteMonitoria(id) {
        $("#deleteMonitoria"+id).html('<span class="fa fa-spinner fa-spin  fa-xs"></span>')
        $.ajax({
            url: '{{ asset("api/monitoring/delete/".Auth::id()) }}/'+id,
            method: 'DELETE',
            success: function (response) {
                noty({
                    text: response.msg,
                    timeout: 3000,
                    layout: 'topRight',
                    type: 'success',
                });
                $("#monitoriaLinha"+id).hide().remove()
                $("#deleteMonitoria"+id).html('Excluir')
            },
            error: function (xhr) {
                console.log(xhr)
                $("#deleteMonitoria"+id).html('Excluir')
                if(xhr.responseJSON.errors) {
                    // Caso seja erro Laravel, mostra esses erros em alertas
                    $.each(xhr.responseJSON.errors,function(i,v){
                        noty({
                            text: v,
                            timeout: 3000,
                            layout: 'topRight',
                            type: 'error',
                        });
                    });
                } else if(xhr.status == 429){
                    noty({
                        text: 'Erro de Conexão!',
                        timeout: 3000,
                        layout: 'topRight',
                        type: 'error',
                    });
                } else {
                    noty({
                        text: 'Erro! Tente novamente mais tarde.',
                        timeout: 3000,
                        layout: 'topRight',
                        type: 'error',
                    });
                }
            }
        });
    }
    // exclui modelo de laudo
    function deleteLaudo(id) {
        $("#deleteLaudo"+id).html('<span class="fa fa-spinner fa-spin fa-xs"></span>')
        $.ajax({
            url: '{{ asset("api/monitoring/delete/laudo/".Auth::id()) }}/'+id,
            method: 'DELETE',
            success: function (response) {
                noty({
                    text: response.msg,
                    timeout: 3000,
                    layout: 'topRight',
                    type: 'success',
                });
                $("#laudoModel"+id).hide().remove()
                $("#deleteLaudo"+id).html('Excluir')
            },
            error: function (xhr) {
                console.log(xhr)
                $("#deleteLaudo"+id).html('Excluir')
                if(xhr.responseJSON.errors) {
                    // Caso seja erro Laravel, mostra esses erros em alertas
                    $.each(xhr.responseJSON.errors,function(i,v){
                        noty({
                            text: v,
                            timeout: 3000,
                            layout: 'topRight',
                            type: 'error',
                        });
                    });
                } else if(xhr.status == 429){
                    noty({
                        text: 'Erro de Conexão!',
                        timeout: 3000,
                        layout: 'topRight',
                        type: 'error',
                    });
                } else {
                    noty({
                        text: 'Erro! Tente novamente mais tarde.',
                        timeout: 3000,
                        layout: 'topRight',
                        type: 'error',
                    });
                }
            }
        });
    }
    @endif
    // Gravar feedback de monitoria
    function saveFeedbackSupervisorMonitoring() {
        id = $("#idModal").val()
        $("#GravarSupModal"+id).html('<span class="fa fa-spinner fa-spin"></span>')
        $.ajax({
            url: "{{asset('api/monitoring/supervisor/feedback')}}/"+id,
            data: "&feedback="+$("#feedback_supervisor").val(),
            method: "PUT",
            success: function (response) {
                noty({
                    text: response.msg,
                    timeout: 3000,
                    layout: 'topRight',
                    type: 'success',
                })
                $("#modalMonitoringFeedBack").hide().remove()
                $("#GravarSupModal").html("Gravae Feedback")
            },
            error: function (xhr) {
                $("#GravarSupModal"+id).html('Tentar Novamente')
                console.log(xhr)
                $("#deleteMonitoria"+id).html('Excluir')
                if(xhr.responseJSON.errors) {
                        // Caso seja erro Laravel, mostra esses erros em alertas
                        $.each(xhr.responseJSON.errors,function(i,v){
                            noty({
                                text: v,
                                timeout: 3000,
                                layout: 'topRight',
                                type: 'error',
                            });
                        });
                    } else if(xhr.status == 429){
                        noty({
                            text: 'Erro de conexão!',
                            timeout: 3000,
                            layout: 'topRight',
                            type: 'error',
                        });
                    } else {
                        noty({
                            text: 'Erro! Tente novamente mais tarde.',
                            timeout: 3000,
                            layout: 'topRight',
                            type: 'error',
                        });
                    }
                }
            })
    }
    @if($webMaster || $isMonitor)
    function searchByCpfCli() {
        $("#btnSBCPF").html('<span class="fa fa-spinner fa-spin"></span>')
        data = 'cpf='+$("#cpf_cliente").val()
        $.ajax({
            url: '{{route("GetMonitoriasByCpfCli")}}',
            data: data,
            method: 'GET',
            success: function (data) {
                if(data == 0) {
                    noty({
                        text: 'Nenhum dado encontrado!',
                        timeout: 3000,
                        layout: 'topRight',
                        type: 'warning',
                    });
                } else {
                    linhas = ''
                    for(i=0; i<data.length; i++) {
                        date = data[i].date.split(' ')[0]
                        datas = date.split('-')
                        dataFormatada = datas[2]+'/'+datas[1]+'/'+datas[0]
                        linhas += '<tr>'+
                        '<td>'+data[i].id+'</td>'+
                        '<td>'+data[i].name+'</td>'+
                        '<td>'+data[i].cliente+'</td>'+
                        '<td>'+data[i].media+'</td>'+
                        '<td>'+dataFormatada+'</td>'+
                        '</tr>'
                    }
                    $("#tableCli").html(linhas)
                    $("#modalMonitoringCli").show()
                }
            },
            error: function (xhr) {
                console.log(xhr)
                $("#deleteMonitoria"+id).html('Excluir')
                if(xhr.responseJSON.errors) {
                        // Caso seja erro Laravel, mostra esses erros em alertas
                        $.each(xhr.responseJSON.errors,function(i,v){
                            noty({
                                text: v,
                                timeout: 3000,
                                layout: 'topRight',
                                type: 'error',
                            });
                        });
                    } else if(xhr.status == 429){
                        noty({
                            text: 'Erro de conexão!',
                            timeout: 3000,
                            layout: 'topRight',
                            type: 'error',
                        });
                    } else {
                        noty({
                            text: 'Erro! Tente novamente mais tarde.',
                            timeout: 3000,
                            layout: 'topRight',
                            type: 'error',
                        });
                    }
                }
            });
        $("#btnSBCPF").html('<span class="fa fa-search"></span>')
    }
    @endif
    $(() => {
        // Preloader
        $("div#monitoria.content-frame").show()
        $("#loadingPreLoader").hide()
    });

    function selectUserToApply() {
        checked = $("input#userToApply.icheck:checked").val()
        console.log(checked)
        if(typeof checked === "undefined" || checked <= 0) {
            console.log('btnUn')
            $("#userToApplyBtn").prop('disabled',true)
        } else {
            console.log('btnEn')
            $("#userToApplyBtn").prop('disabled',false)
        }
    }

    $(document).ready(function(){

        // Search all columns
        $('#searchIpt').keyup(function(){
            // Search Text
            var search = $(this).val().toUpperCase();

            // Hide all table tbody rows
            $('table tbody tr').hide();

            // Count total search result
            var len = $('table tbody tr:not(.notfound) td:contains("'+search+'")').length;

            if(len > 0) {
                // Searching text in columns and show match row
                $('table tbody tr:not(.notfound) td:contains("'+search+'")').each(function(){
                    $(this).closest('tr').show();
                });
            } else {
                $('.notfound').show();
            }

        });
    });
</script>
@endsection