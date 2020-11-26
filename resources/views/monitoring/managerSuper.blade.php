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
    .popover{
        max-width: 100%; /* Max Width of the popover (depending on the container!) */
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
            <div class="row col-sm-12 col-md-12 col-lg-12">
                {{-- Histórico --}}
                <div class="panel panel-dark">
                    <div class="panel-heading">
                        <h2 id="historico" class="panel-title">
                            <p>Histórico de Monitorias</p>
                            {{-- Se é monitoria escobs --}}
                            @if(in_array(64, Session::get('permissionsIds')))
                            <p>As linhas em vermelho evidenciam quais monitorias estão pendentes de <strong class="text-danger">aceite de feedback do operador</strong></p>
                            @else {{-- Senão,se é callcenter --}}
                            <p>As linhas em vermelho evidenciam quais monitorias estão pendentes de <strong class="text-danger">feedback do supervisor</strong></p>
                            @endif
                        </h2>
                        <ul class="panel-controls">
                            <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                        </ul>
                        <div class="col-md-10">
                            <label class="mr-sm-8 sr-only" for="inlineFormCustomSelect">Campos</label>
                            <label class="icheck">
                                <input onchange="$('#selectMonit').hide();$('#selectOperador').hide();$('#selectSuper').hide();$('input#valor[name=valor]').show();" id="input_Monitoria" name="campo" type="radio" class="icheck" value="monitoria" checked="true">
                                Monitoria
                            </label>
                            <label class="icheck">
                                <input onchange="$('#selectMonit').hide();$('#selectSuper').hide();$('input#valor[name=valor]').hide();if(typeof $('#input_Operador:checked').val() != 'undefined'){$('#selectOperador').show()}" id="input_Operador" name="campo" type="radio" class="icheck" value="operador">
                                Operador
                            </label>
                            @if(in_array(67, Session::get('permissionsIds')))
                            <label class="icheck">
                                <input id="input_Supervisor" name="campo" onchange="$('input#valor[name=valor]').hide();$('#selectMonit').hide();$('#selectOperador').hide();if(typeof $('#input_Supervisor:checked').val() != 'undefined'){$('#selectSuper').show()}" type="radio" class="icheck" value="supervisor">
                                Supervisor
                            </label>
                            @endif
                            <label class="icheck">
                                <input id="input_Monitor" name="campo" onchange="$('input#valor[name=valor]').hide();$('#selectSuper').hide();if(typeof $('#input_Monitor:checked').val() != 'undefined'){$('#selectMonit').show()}" type="radio" class="icheck" value="monitor">
                                Monitor
                            </label>
                            <label class="icheck">
                                <input onchange="$('#selectMonit').hide();$('#selectOperador').hide();$('#selectSuper').hide();$('input#valor[name=valor]').show();" id="input_Cliente" name="campo" type="radio" class="icheck" value="usuariocliente">
                                Usuário-Cliente
                            </label>
                            <label class="icheck">
                                <input onchange="$('#selectMonit').hide();$('#selectOperador').hide();$('#selectSuper').hide();$('input#valor[name=valor]').show();" id="input_Matricula" name="campo" type="radio" class="icheck" value="matricula">
                                Matricula
                            </label>
                            <label class="icheck">
                                <input id="input_Aplicado" name="feedback_search" type="checkbox" value="1">
                                Feedback Aplicado
                            </label>
                            <label class="icheck">
                                <input id="input_Periodo" name="periodo_search" id="periodo_search" type="checkbox" value="periodo" onchange="if(typeof $('#periodo_search:checked').val() !== 'undefined'){$('#dateFilter').show()}else{$('#dateFilter').hide();$('#dataini_search').val('');$('#dataifi_search').val('')}">
                                Período
                            </label>
                            {{-- SELECTS --}}
                            <div class="form-group" id="selectOperador" style="display: none;">
                                <label for="operador">Selecione um Operador</label>
                                <select class="select" name="operador" id="selectOperadorIpt" data-live-search="true">
                                    @foreach ($usersFiltering as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @if(in_array(67, $permissions))
                            <div class="form-group" id="selectSuper" style="display: none;">
                                <label for="supervisor">Selecione um Supervisor</label>
                                <select class="select" name="supervisor" id="selectSuperIpt" data-live-search="true">
                                    @foreach ($supers as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif
                            <div class="form-group" id="selectMonit" style="display: none;">
                                <label for="monitor">Selecione um Monitor</label>
                                <select class="select" name="monitor" id="selectMonitIpt" data-live-search="true">
                                    @foreach ($monits as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-group" id="dateFilter" style="display: none">
                                <input type="date" id="dataini_search" name="dataini_search" class="form-control col-sm-6">
                                <input type="date" id="dataifi_search" name="dataifi_search" class="form-control col-sm-6">
                            </div>

                            <div class="input-group mb-3 col-md-9">
                                <input type="text" class="form-control col-md-6" name="valor" id="valor" placeholder="Digite aqui" aria-label="Pesquisar" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button  style="background-color:black; color:white; width:72px;height:30px;" class="input-group-text"  onclick="pesquisarmonitorias();" id="pesquisarFiltro">Pesquisar</button>
                                </div>
                                <button class="btn btn-secondary pull-right" data-title="Há contestações para você verificar" onclick="window.location= '{{ route("GetContestacoesIndex") }}' ">
                                    Contestações
                                    <span class="fa fa-warning text-danger" id="notifyContestacao" style="display: none"></span>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-2">
                            Média no Mês
                            <span class="sparkline" sparkType="pie" sparkFillColor="#FFF" sparkLineWidth="2" sparkLineColor="#9FD468" sparkWidth="100" sparkHeight="45" >{{ $media }},{{ 100-$media }}</span>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table class="table table-hover" id="searchInTable">
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
                            <tbody id="tbodypesquisa">
                                @forelse ($monitorias as $m)
                                <tr id="monitoriaLinha{{$m->id}}" @if(is_null($m->feedback_supervisor)) class="bg-danger" @endif>
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
                    <div class="panel-footer">
                        {{ $monitorias->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('modal')

{{-- Modal de resultado de Relatório  --}}
@component('monitoring.components.modais.resultRelatorio', ['motivos' => $motivos])
@endcomponent


<div class="modal in" id="AdminContestacao" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defModalHead">Motivos de Contestação</h4>
                <button type="button" class="close" onclick="javascript:$('#AdminContestacao').hide()" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">Close</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="list-group">
                    @forelse($motivos as $item)
                        <div class="list-group-item">
                            <label class="pull-left">{{$item->name}}</label>
                            <form action="{{route('DeleteMotivoContestacao', ['id' => $item->id])}}" method="POST">
                                @method('DELETE')
                                @csrf
                                <button title="Excluir Motivo" class="btn btn-danger pull-right"><span class="fa fa-trash-o"></span></button>
                            </form>
                        </div>
                    @empty
                        <div class="list-group-item">
                            Nenhum dado encontrado
                        </div>
                    @endforelse
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="$('#AdminContestacao').hide();$('#formAddMotivoContestacao').parent().parent().remove()">Cancelar</button>
                <button class="btn btn-success" data-container="body" data-toggle="popover" data-title="Adicionar Motivo" data-placement="top" data-content='<form action="{{route('AddMotivoContestacao')}}" method="POST" id="formAddMotivoContestacao">@csrf<input required class="form-control" placeholder="Nome do motivo" name="name"><button class="btn btn-block btn-success">Adicionar</button></form>' data-html="true">Adicionar</button>
            </div>
        </div>
    </div>
</div>

@endsection
@section('Javascript')
<script type="text/javascript" src="{{asset('js/plugins/knob/jquery.knob.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/plugins/sparkline/jquery.sparkline.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/plugins/owl/owl.carousel.min.js')}}"></script>
{{-- MORRIS  --}}
<script type="text/javascript" src="{{asset('js/plugins/morris/raphael-min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/plugins/morris/morris.min.js')}}"></script>
{{-- NVD3 --}}
<script type="text/javascript" src="{{asset('js/plugins/nvd3/lib/d3.v3.js')}}"></script>
<script type="text/javascript" src="{{asset('js/plugins/nvd3/nv.d3.min.js')}}"></script>
<script type="text/javascript">
    function viewMonitoring(id) {
        $("input#contestarId").val($("#idModal").val())
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
                    $("#ContestSupModal").attr('onclick','contestar('+id+')')
                    if(data[0].feedback_operador !== 'null' && data[0].feedback_operador !== null){
                        $("textarea#feedback_operador").prop('style','border-color: green')
                        $("p#feedback_operador").prop('style','border-color: green')
                    }

                    if(data[0].feedback_supervisor !== null) {
                        $("textarea#feedback_supervisor").attr('style','border-color: #95B75D')
                    }

                    //
                    $("#ContestSupModal").attr('onclick','getContestByMonitoriaId('+id+')')
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

    // Gravar feedback do supervisor
    function saveFeedbackSupervisorMonitoring() {
        id = $("#idModal").val()
        feed = $("#feedback_supervisor").val()
        if(in_array(feed)) {
            return noty({
                text: 'Preencha o campo <strong>FEEDBACK SUPERVISOR!</strong>',
                type: 'error',
                layout: 'topRight',
                timeout: '3000'
            })
        }
        $("#GravarSupModal"+id).html('<span class="fa fa-spinner fa-spin"></span>')
        $.ajax({
            url: "{{asset('api/monitoring/supervisor/feedback')}}/"+id,
            data: "feedback="+feed,
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
    function transformDataDb(date) {
        arr = date.split(' ')
        data = arr[0].split('-')
        date = date[2]+'/'+date[1]+'/'+date[0]
        return date
    }

    function getContestByMonitoriaId(monitoria_id) {
        url = '{{route("GetContestacaoByMon",['id' => '---'])}}'.replace('---', monitoria_id)
        $.getJSON(url,function(data) {

                table = "<table class='table table-hover table-responsive'>"+
                            "<thead>"+
                                "<tr>"+
                                    "<th>Data</th>"+
                                    "<th>Motivo</th>"+
                                    "<th>Grupo</th>"+
                                    "<th>OBS</th>"+
                                    "<th>Nome</th>"+
                                "</tr>"+
                            "</thead>"+
                            "<tbody>";

                //
                for(i=0; i<data.length; i++) {
                    table += '<tr>'+
                            '<td>Data</td>'+
                            '<td>Motivo</td>'+
                            '<td>Grupo</td>'+
                            '<td>OBS</td>'+
                            '<td>Nome</td>'+
                            '</tr>';
                }

                table += "</tbody></table>"

                $("#preLoaderContestar").html(table)
        })
    }

    function pesquisarmonitorias() {
        var valor = $('input#valor[name=valor]').val();
        if(valor.length == 0) {
            valor = 0
        }
        var campo = $('input[name=campo]:checked').val();
        var feedback = typeof $('input[name=feedback_search]:checked').val() !== 'undefined';
        var datain = $("input#dataini_search").val()
        var datafi = $("input#dataifi_search").val()
        var monit = $("#selectMonitIpt").val()
        var supers = $("#selectSuperIpt").val()
        var operads = $("#selectOperadorIpt").val()

        var periodo = $('input[name=periodo_search]:checked').val();

        var url = "{{ route('pesquisarMonitorias',['campo' => '--', 'valor' => '---'])}}".replace('--',campo).replace('---',valor)
        var data = {
            campo: campo,
            valor: valor,
            feedback: feedback,
            periodo: periodo,
            datain: datain,
            datafi: datafi,
            monit: monit,
            supers: supers,
            operads: operads
        }

        console.log(data)

        $.ajax({
            url:url,
            method:'GET',
            data: data,
            dataType:'json',
            success:function(data)
            {
                console.log(data)
                linhas =  ""
                for(i = 0; i < data.length; i++){
                    // console.log(data)

                    var monitoria = data[i].monitoria;
                    var operador = data[i].operador;
                    var supervisor = data[i].supervisor;
                    var monitor = data[i].monitor;
                    var dataligacao = dataBr(data[i].dataligacao).replace('undefined','');
                    var audio = data[i].audio;
                    var media = data[i].media;
                    var rota = "{{route('GetMonitoriaEdit',['id' => '---'])}}".replace('---',monitoria)
                    var classe = ''
                    @if(in_array(64, $permissions)))
                    if(data[i].feedback_operador == null || data[i].feedback_operador == 'null') {
                        classe += 'class="bg-danger"'
                    }
                    @else
                    if(data[i].feedback_supervisor == null || data[i].feedback_supervisor == 'null') {
                        classe += 'class="bg-danger"'
                    }
                    @endif


                    linhas += '<tr '+classe+'> <td>  '+monitoria+'  </td>  <td>  '+operador+'  </td> <td>  '+supervisor+'  </td> <td>  '+monitor+'  </td> <td> '+dataligacao+' </td> <td> '+audio+' </td> <td> '+media+' </td>     <td class="btn-group btn-group-sm"><div class="btn-group"><button type="button" class="btn btn-secondary"id="btnView'+monitoria+'" onclick="viewMonitoring('+monitoria+')">Ver</button></div>  </td> </tr> '
                }

                $('#tbodypesquisa').html(linhas)

            },
            error: function(xhr) {
                console.log(xhr)
            }
        })
    }

    function getContestByMonitoriaId(monitoria_id) {
        url = '{{route("GetContestacaoByMon",['id' => '---'])}}'.replace('---', monitoria_id)
        $.getJSON(url,function(data) {

                table = "<table class='table table-hover'>"+
                            "<thead>"+
                                "<tr>"+
                                    "<th>Data</th>"+
                                    "<th>Motivo</th>"+
                                    "<th>OBS</th>"+
                                    "<th>Nome</th>"+
                                "</tr>"+
                            "</thead>"+
                            "<tbody>";

                // Monta contestações
                for(i=0; i<data.length; i++) {
                    const item = data[i]
                    table += '<tr>'+
                            '<td>'+dataBr(item.created_at)+'</td>'+
                            '<td>'+$('select#contestarSelect > option[value='+item.motivo_id+']').html()+'</td>'+
                            '<td>'+item.obs+'</td>'+
                            '<td>'+item.name+'</td>'+
                            '</tr>';
                }

                table += "</tbody></table>"

                $("#preLoaderContestar").html(table)
        })
    }
 </script>
@endsection
