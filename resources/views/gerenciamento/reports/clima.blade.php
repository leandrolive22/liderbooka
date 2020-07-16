@extends('layouts.app', ["current"=>"adm"])
@section('style')
<style type="text/css">
    img {
        width: 100%;
        height: auto;
    }

    * {
        box-sizing: ;
    }

    /* Set a background color */
    body {
        background-color: ;
        font-family: Helvetica, sans-serif;
    }

    /* The actual timeline (the vertical ruler) */
    .timeline {
        position: relative;
        max-width: 600px;
        margin: 0 auto;

    }

    /* The actual timeline (the vertical ruler) */
    .timeline::after {
        content: '';
        position: absolute;
        width: 0px;
        background-color: ;
        top: 0;
        bottom: 0;
        left: %;
        margin-left: -3px;
    }

    /* Container around content */
    .container {
        padding: 10px 40px;
        position: relative;
        background-color: inherit;
        width: 50%;
    }

    /* The circles on the timeline */
    .container::after {
        content: '';
        position: absolute;
        width: 25px;
        height: 25px;
        right: -17px;
        background-color: ;
        border: 4px solid #0f0438;
        top: 15px;
        border-radius: 50%;
        z-index: 1;
    }

    /* Place the container to the left */
    .left {
        left: 0;
    }

    /* Place the container to the right */
    .right {
        left: 50%;
    }

    /* Add arrows to the left container (pointing right) */
    .left::before {
        content: " ";
        height: 0;
        position: absolute;
        top: 22px;
        width: 0;
        z-index: 1;
        right: 30px;
        border: medium solid white;
        border-width: 10px 0 10px 10px;
        border-color: transparent transparent transparent white;
    }

    /* Add arrows to the right container (pointing left) */
    .right::before {
        content: " ";
        height: 0;
        position: absolute;
        top: 12px;
        width: 0;
        z-index: 1;
        left: 30px;
        border: medium solid white;
        border-width: 10px 10px 10px 0;
        border-color: transparent white transparent transparent;
    }

    /* Fix the circle for containers on the right side */
    .right::after {
        left: -16px;
    }

    /* The actual content */
    .content {
        padding: 20px 30px;
        background-color: ;
        position: relative;
        border-radius: 6px;
    }

    /* Media queries - Responsive timeline on screens less than 600px wide */
    @media screen and (max-width: 600px) {

        /* Place the timelime to the left */
        .timeline::after {
            left: 31px;
        }

        /* Full-width containers */
        .container {
            width: 100%;
            padding-left: 70px;
            padding-right: 25px;
        }

        /* Make sure that all arrows are pointing leftwards */
        .container::before {
            left: 60px;
            border: ;
            border-width: 10px 10px 10px 0;
            border-color: transparent white transparent transparent;
        }

        /* Make sure all circles are at the same spot */
        .left::after,
        .right::after {
            left: 15px;
        }

        /* Make all right containers behave like the left ones */
        .right {
            left: 0%;
        }
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
                    <h2><span class="fa fa-arrow-circle-o-left"></span> Gerenciamento</h2>
                </div>
                <div class="pull-right">
                    <button class="btn btn-{{Auth::user()->css}} content-frame-right-toggle"><span
                            class="fa fa-bars"></span></button>
                </div>
            </div>
            <!-- END CONTENT FRAME TOP -->

            <!-- START CONTENT FRAME RIGHT -->
            @include('assets.components.updates')
            <!-- END CONTENT FRAME RIGHT -->

            <!-- START CONTENT FRAME LEFT -->

            <div class="content-frame-body content-frame-body-left">
                <div class="row">
                    <div class="panel">
                        <form method="POST" id="formReport">
                            @csrf
                            <div class="panel-heading">
                                <h3>Relatório de Clima</h3>
                                <div class="col-md-2">
                                    <h5>Pesquisar por:</h5>
                                </div>
                                <div class="col-md-8">

                                    <div class="form-group col-md-12">
                                        {{-- check boxes  --}}
                                        <div class="form-check col-md-4">
                                            <label class="form-check-label">
                                                <button class="btn btn-default"
                                                    onclick="$.each($('.searchParams'),function(i,v){$(v).hide()});"
                                                    type="reset"><i class="fa fa-check-square-o"></i> Data</button>
                                            </label>
                                        </div>

                                        <div class="form-check col-md-4">
                                            <label class="form-check-label">
                                                <button class="btn btn-default"
                                                    onclick="javascript:$.each($('.searchParams'),function(i,v){$(v).show()});"
                                                    type="reset"><i class="fa fa-check-square-o"></i> Ilhas</button>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="panel-body">

                                <!-- START Ilhas -->
                                <div class="form-group searchParams island">
                                    <h4>Ilhas</h4>
                                    <select multiple name="ilhas" id="ilhas" class="form-control select"
                                        data-live-search="true">
                                        @forelse ($ilhas as $ilha)
                                        <option value="{{ $ilha->id }}">{{ $ilha->name }}</option>
                                        @empty
                                        <option>Nenhuma Ilha disponivel</option>
                                        @endforelse
                                    </select>
                                </div>
                                <!-- END Ilhas -->
                                <!-- START Datas -->
                                <div class="form-group col-md-6">
                                    <label for="">Data Inicial:</label>
                                    <input type="text" class="form-control datepicker" name="DataIn" id="DataIn"
                                        value="{{date("d-m-Y",strtotime(date("Y-m-d")."-1 month"))}}" required>
                                </div>
                                <div class="form-group col-md-6 ">
                                    <label for="">Data Final:</label>
                                    <input type="text" class="form-control datepicker" name="DataFin" id="DataFin"
                                        value="{{ date('d-m-Y') }}" required>
                                </div>
                                <div class="form-group">
                                    <button type="button" onclick="search()" class="btn btn-primary btn-block">Pesquisar
                                    </button>
                                </div>
                                <!-- END Datas -->
                            </div>
                        </form>
                    </div>
                    @if(isset($log))
                    <div class="row col-md-12">

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">Resultados</h3>
                                <button class="btn btn-success pull-right"
                                    onclick="$('#resultTable').tableExport({type:'excel',escape:'false'})">Exportar em
                                    Excel</button>
                            </div>
                            <div class="panel-body ">
                                <div class="table-responsive" style="max-height:20rem;">
                                    <table class="table" id="resultTable">

                                        <thead>
                                            <tr>
                                                <th> Usuario </th>
                                                <th> Reação </th>
                                                <th> Ilha </th>
                                                <th> Data </th>
                                            </tr>

                                        </thead>
                                        <tbody style="overflow-y:scroll;">
                                            @forelse ($log as $result)
                                            <tr>
                                                <td>
                                                    @if($result->userData == NULL)
                                                    <b style="color:red">USUÁRIO EXCLUÍDO OU NÃO ENCONTRADO</b>
                                                    @else
                                                    {{$result->userData->name}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($result->value == 1)
                                                    <span class="fa fa-frown-o fa-2x" style="color:red;"></span>
                                                    <p>Insatisfeito</p>
                                                    @elseif($result->value == 2)
                                                    <span class="fa fa-meh-o fa-2x" style="color:#ffd700;"></span>
                                                    <p>Indiferente</p>
                                                    @elseif($result->value == 3)
                                                    <span class="fa fa-smile-o fa-2x" style="color:green"></span>
                                                    <p>Satisfeito</p>
                                                    @endif

                                                </td>
                                                <td> {{$result->ilha->name}} </td>
                                                <td> {{$result->created_at}}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="4" class="text-center"> Nenhum Resultado Encontrado </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FIM PAGE CONTAINER -->
@endsection
@section('Exports')
<script type="text/javascript" src="{{ asset('js/plugins/tableexport/tableExport.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/plugins/tableexport/jquery.base64.js') }}"></script>
<script language="javascript">
    function search() {
        DataIn = convertDate($("#DataIn").val())
        DataFin = convertDate($("#DataFin").val())
        ilhas = $("#ilhas").val()
        users = $("#users").val()

        dateDiff = checkDate(DataIn,DataFin)

        if(dateDiff < 0) {
            return  noty({
                        text: 'Data Final maior que a inicial!',
                        type: 'error',
                        layout: 'topRight',
                        timeout: '3000'
                    })
            throw "stop execution";
        }

        $("#DataIn").val(DataIn)
        $("#DataFin").val(DataFin)

        $("#formReport").attr('action','{{ asset("manager/report/export/excel/environment") }}/' + ilhas);
        $("#formReport").submit()
    }

    //recebe data inicial e final e retorna diferença entre elas
    function checkDate(i,f) {
        //diferença de data em dias
        dateDiff = (Date.parse(f) - Date.parse(i)) / 86400000

        return dateDiff
    }

    //recebe data em formato dd-mm-YYYY e converte para YYYY-mm-dd
    function convertDate(date) {
        //Separa dados do formato d-m-Y para formatar transformando-os em um vetor,inverte a ordem do vetor e junta novamente para o formato Y-m-d
        date = date.split('-').reverse().join('-')

        return date
    }

    $(function(){
        @foreach($errors->all() as $error)
            noty({
                text: {{$error}},
                layout: 'topRight',
                type: 'error',
                timeout: 3000
            });
        @endforeach
    })

    
</script>

@section('ChartsUpdates')
<script type="text/javascript" src="{{ asset('js/plugins/morris/raphael-min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/plugins/morris/morris.min.js') }}"></script>

<script language="javascript">
    //Pega dados de clima de euipe e converte em gráficos para os superiores
    function getEnvironment() {
        $.getJSON('{{ route("GetUsersChartHS", [ 'id' => Auth::id(), 'cargo' => Auth::user()->cargo_id, 'ilha' => Auth::user()->ilha_id ] ) }}',function(data) {
            if(!data[0] == 0 && data[1] == 0 && data[2] == 0) {
                total = data[0] + data[1] + data[2]

                env1 = (data[0] / total)*100
                env2 = (data[1] / total)*100
                env3 = (data[2] / total)*100

                Morris.Donut({
                        element: 'enviroChart',
                        data: [
                            {label: "Insatisfeito", value: data[0]},
                            {label: "Indiferente", value: data[1]},
                            {label: "Satisfeito", value: data[2]}
                        ],
                        colors: [
                            'green',
                            '#ffd700',
                            'red'
                        ]

                });


                $("#env1").html(env1.toFixed(2) + '%')
                $("#env2").html(env2.toFixed(2) + '%')
                $("#env3").html(env3.toFixed(2) + '%')
            } else {
                $("#enviroChart").html('Nenhum gráfico disponível')
            }//endif
        })
    }
</script>

@endsection
