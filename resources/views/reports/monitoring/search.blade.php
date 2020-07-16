@extends('layouts.app', ["current"=>"monitor"])
<!-- CARDS CSS INICIO -->
@section('css')
<style>

</style>
@endsection
<!-- CARDS CSS FIM -->
@section('content')
<!-- START PAGE CONTAINER -->
<div class="page-container">

    <!-- START PAGE CONTENT -->
    <div class="page-content">

        @component('assets.components.x-navbar')
        @endcomponent

        <br>

        <!-- START BREADCRUMB -->
        <ul class="breadcrumb">
            <li><a href="{{asset('/home/page')}}">Home</a></li>
            <li><a href="{{asset('monitoring/manager')}}">Monitoria</a></li>
            <li><a href="#">Buscar Analítico</a></li>
        </ul>
        <!-- END BREADCRUMB -->

        <div class="d-flex justify-content-center col-md-12" id="preloaderPageContent">
            <div class="spinner-grow text-dark" role="status" style="width: 30rem; height:30rem">
            </div>
        </div>

        <!-- START CONTENT FRAME -->
        <div class="content-frame" id="content" style="display:none;">

            <!-- START CONTENT FRAME TOP -->
            <div class="content-frame-top">
                <div class="page-title">
                    <a href="{{ url()->previous() }}">
                        <h2>
                            <span class="fa fa-arrow-circle-o-left"></span> Monitoria
                        </h2>
                    </a>
                </div>
                <div class="pull-right">
                    <button class="btn btn-{{Auth::user()->css}} content-frame-right-toggle"><span
                            class="fa fa-bars"></span></button>
                </div>
            </div>
            <!-- END CONTENT FRAME TOP -->

            <!-- START CONTENT FRAME LEFT -->
            <div class="col-md-12">
                <div class="row">
                    <div class="panel panel-dark">
                        <div class="panel-heading ui-dragable-handle">
                            <h3 class="panel-title">Selecione os Parâmetros de Busca</h3>
                        </div>
                        <div class="panel-body">
                            <div class="col-md-6">
                                <form method="POST" action="{{ route('PostRelatoriosAnalytics') }}" id="formMonitoringSearch">
                                    <div class="col-md-12">
                                        <div class="form-row col-md-12">
                                            <h3 class="panel-title col-md-12">Selecione o Período</h3>
                                            <select name="periodo" id="periodo" class="form-control select">
                                                @php
                                                    $today = date('Y-m-d');
                                                    $weekDay = date('w',strtotime($today));
                                                    $firstWeekDay = date('Y-m-d 00:00:00',strtotime("-$weekDay Days",strtotime($today)));
                                                @endphp
                                                <option value="{{date('Y-m-1 00:00:00')}}" selected>Este mês</option>
                                                {{-- <option value="{{$firstWeekDay}}">Esta semana</option>
                                                <option value="{{date('Y-m-d 00:00:00')}}">Hoje</option> --}}
                                            </select>
                                            {{-- <div class="form-row col-md-6">
                                                <label for="de">De</label>
                                                <input type="date" required name="de" id="de" value="{{$de}}" class="form-control">
                                            </div>
                                            <div class="form-row col-md-6">
                                                <label for="ate">Até</label>
                                                <input type="date" required name="ate" id="ate" value="{{$ate   }}" class="form-control">
                                            </div> --}}
                                        </div>
                                        <button type="submit" class="btn btn-block btn-dark" {{--onclick="search()"--}}>
                                            Pesquisar
                                        </button>
                                    </div>
                                    @csrf
                                </form>
                                    {{-- <div class="row panel-body col-md-12">
                                        <h3 class="panel-title">Selecione os campos</h3>
                                        <!-- ROW -->
                                        <div class="form-row col-md-12">
                                            <div class="form-group col-md-3">
                                                <label class="icheck">
                                                    <input type="checkbox" class="icheckbox" checked="true" name="registroMonitoria" value="monitorias.id AS Registro,">
                                                    Registro
                                                </label>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="icheck">
                                                    <input type="checkbox" class="icheckbox" checked="true" name="SEGMENTOMonitoria" value="setores.name AS Segmento,">
                                                    Segmento
                                                </label>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="icheck">
                                                    <input type="checkbox" class="icheckbox" checked="true" name="GrupoMonitoria" value="carteiras.name AS Grupo,">
                                                    Grupo
                                                </label>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="icheck">
                                                    <input type="checkbox" class="icheckbox" checked="true" name="OperadorMonitoria" value="u.name as Operador,">
                                                    Operador
                                                </label>
                                            </div>
                                        </div>
                                        <!-- ROW -->
                                        <div class="form-row col-md-12">
                                            <div class="form-group col-md-3">
                                                <label class="icheck">
                                                    <input type="checkbox" class="icheckbox" checked="true" name="MonitorMonitoria" value="monitores.name as Monitor,">
                                                    Monitor
                                                </label>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="icheck">
                                                    <input type="checkbox" class="icheckbox" checked="true" name="ClienteMonitoria" value="monitorias.cliente as Cliente,">
                                                    Cliente
                                                </label>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="icheck">
                                                    <input type="checkbox" class="icheckbox" checked="true" name="DataMonitoria" value="DATE_FORMAT(monitorias.created_at,'%Y-%m-%d') as data_monitoria,">
                                                    Data da Monitoria
                                                </label>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="icheck">
                                                    <input type="checkbox" class="icheckbox" checked="true" name="TpLigacaoMonitoria" value="monitorias.tipo_ligacao,">
                                                    Tipo de ligação
                                                </label>
                                            </div>
                                        </div>
                                        <!-- ROW -->
                                        <div class="form-row col-md-12">
                                            <div class="form-group col-md-3">
                                                <label class="icheck">
                                                    <input type="checkbox" class="icheckbox" checked="true" name="cpfclienteMonitoria" value="monitorias.cpf_cliente,">
                                                    CPF Cliente
                                                </label>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="icheck">
                                                    <input type="checkbox" class="icheckbox" checked="true" name="DataLigacaoMonitoria" value="monitorias.data_ligacao,">
                                                    Data da Ligação
                                                </label>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="icheck">
                                                    <input type="checkbox" class="icheckbox" checked="true" name="media" value="monitorias.media as Media,">
                                                    Media
                                                </label>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="icheck">
                                                    <input type="checkbox" class="icheckbox" checked="true" name="SupervisorMonitoria" value="super.name as Supervisor,">
                                                    Supervisor
                                                </label>
                                            </div>
                                        </div>
                                        <!-- ROW -->
                                        <div class="form-row col-md-12">
                                            <div class="form-group col-md-3">
                                                <label class="icheck">
                                                    <input type="checkbox" class="icheckbox" checked="true" name="tplaudoMonitoria" value="modelos.tipo_monitoria,">
                                                    Tipo de laudo
                                                </label>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="icheck">
                                                    <input type="checkbox" checked="true" class="icheckbox" name="ILHAMonitoria" value="ilhas.name as Ilha,">
                                                    Ilha
                                                </label>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="icheck">
                                                    <input type="checkbox" class="icheckbox" checked="true" name="FeedBackMonitoria" value="IF(monitorias.feedback_supervisor IS NULL,'NÃO APLICADO','APLICADO') as FeedBack,">
                                                    FeedBack
                                                </label>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="icheck">
                                                    <input type="checkbox" class="icheckbox" checked=true name="DataFeedBackMonitoria" value="IF(monitorias.feedback_supervisor IS NULL,'-',DATE_FORMAT(monitorias.feedback_supervisor,'%Y-%m-%d')) as data_feedback,">
                                                    Data FeedBack
                                                </label>
                                            </div>
                                        </div>
                                        <!-- ROW -->
                                        <div class="form-row col-md-12">
                                            <div class="form-group col-md-3">
                                                <label class="icheck">
                                                    <input type="checkbox" class="icheckbox" checked=true name="ItemMonitoria" value="laudos.questao as Item,">
                                                    Item
                                                </label>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="icheck">
                                                    <input type="checkbox" class="icheckbox" checked=true name="procedimentoMonitoria" value="itens.value as Procedimento,">
                                                    Procedimento
                                                </label>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="icheck">
                                                    <input type="checkbox" class="icheckbox" checked=true name="atendimentoMonitoria" value="laudos.sinalizacao as grupo_atendimento,">
                                                    Grupos de Atendimento
                                                </label>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="icheck">
                                                    <input type="checkbox" class="icheckbox" checked=true name="quartil" value="Quartil">
                                                    Quartis
                                                </label>
                                            </div>
                                        </div>
                                        <!-- ROW -->
                                        <div class="form-row col-md-12">
                                        </div>
                                    </div>
                                </form> --}}
                            </div>
                            <div class="col-md-6 text-center">
                                <p class="text-center col-md-12">Monitorias por Quartil</p>
                                <div id="qChart" class="text-center" style="height: 20rem; width: 20rem; margin-bottom:2rem; margin-left:30%; margin-left:30%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Relatório Analítico</h3>
                            <button class="btn btn-outline-success pull-right" id="btnExport"><span id="spanExport">Exportar</span></button>
                        </div>
                        <div class="panel-body col-md-12" style="overflow: auto; max-height: 500px;">
                            <table class="table" id="tabelaMonitoriaAnalitica">
                                <thead>
                                    <tr>
                                        @if(!empty($search))
                                            @foreach(array_keys((array) $search[0]) as $keys)
                                                @if($keys === 'ncg')
                                                    <th>Quartis</th>
                                                @else
                                                    <th>{{$keys}}</th>
                                                @endif
                                            @endforeach
                                        @else
                                        <th>Selecione as Datas e Faça sua pesquisa!</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $q1soma = 0;
                                        $q2soma = 0;
                                        $q3soma = 0;
                                        $q4soma = 0;
                                        $ncg = 0;
                                    @endphp
                                    @forelse ($search as $item)
                                    {{-- Checa Quartis e NCG --}}
                                    @php
                                                if($item->Quartil == 'Q4') {
                                                    $valor = 'Q4';
                                                    $q1soma++;
                                                    $class = 'bg-success';
                                                } else if($item->Quartil == 'Q3') {
                                                    $valor = 'Q3';
                                                    $q2soma++;
                                                    $class = 'bg-warning';
                                                } else if($item->Quartil == 'Q2') {
                                                    $valor = 'Q2';
                                                    $q3soma++;
                                                    $class = 'bg-info';
                                                } else if($item->ncg === 1) {
                                                    $ncg++;
                                                    $class = 'bg-danger';
                                                } else {
                                                    $q4soma++;
                                                    $class = 'bg-secondary';
                                                }
                                            @endphp
                                    <tr>
                                        <td>{{$item->Registro}}</td>
                                        <td>{{$item->Avaliacoes}}</td>
                                        <td>{{$item->Segmento}}</td>
                                        <td>{{$item->Grupo}}</td>
                                        <td>{{$item->Operador}}</td>
                                        <td>{{$item->Monitor}}</td>
                                        <td>{{$item->Supervisor}}</td>
                                        <td>{{$item->Media}}</td>
                                        <td>{{$item->Cliente}}</td>
                                        <td>{{$item->data_monitoria}}</td>
                                        <td>{{$item->tipo_ligacao}}</td>
                                        <td>{{$item->cpf_cliente}}</td>
                                        <td>{{$item->data_ligacao}}</td>
                                        <td>{{$item->tipo_monitoria}}</td>
                                        <td>{{$item->Ilha}}</td>
                                        <td>{{$item->FeedBack}}</td>
                                        <td>{{$item->data_feedback}}</td>
                                        <td>{{$item->Item}}</td>
                                        <td>{{$item->Procedimento}}</td>
                                        <td>{{$item->grupo_atendimento}}</td>
                                        <td>{{$item->Conforme}}</td>
                                        <td>{{$item->Nao_conforme}}</td>
                                        <td>{{$item->operador_novo}}</td>
                                        <td class="{{$class}}">
                                            {{$item->Quartil}}
                                        <td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td class="text-center" colspan="10">Nenhum dado encontrado</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END CONTENT FRAME LEFT -->

        </div>
        <!-- END CONTENT FRAME -->

    </div>
    <!-- END PAGE CONTENT -->

</div>
<!-- END PAGE CONTAINER -->
@endsection
@section('Javascript')
    @component('assets.components.basicDatatable',['id' => 'btnExport', 'span' => 'spanExport'])
    @endcomponent
    <script type="text/javascript" src="{{ asset('js/plugins/morris/raphael-min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/morris/morris.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/tableexport/tableExport.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/tableexport/jquery.base64.js') }}"></script>
    <script lang="javascript">
        Morris.Donut({
                element: 'qChart',
                data: [
                    {label: "Q4", value: {{$q4soma}}},
                    {label: "Q3", value: {{$q3soma}}},
                    {label: "Q2", value: {{$q2soma}}},
                    {label: "Q1", value: {{$q1soma}}},
                    {label: "NCG", value: {{$ncg}}}
                ],
                colors: [
                    'red',
                    '#ffd700',
                    '#009DD8',
                    'green',
                    'black'
                ],
                resize: true

        });
        $(() => {
            $("#content").show()
            $("#preloaderPageContent").hide().remove()
        })
        // function search() {
        //     de = Date($("#de").val())
        //     ate = Date($("#ate").val())

        //     // checa se todos campos foram preenchidos corretamente
        //     if(typeof $("input.icheckbox:checked").val() === 'undefined' || $("#de").val() === '' || $("#ate").val() === '') {
        //         noty({
        //             text: 'Selecione ao menos um campo e um período válido (limite 3 meses)',
        //             layout: 'topRight',
        //             type: 'warning',
        //             timeout: 3000
        //         });
        //     } else {
        //         $("#formMonitoringSearch").submit()
        //     }
        // }
    </script>
@endsection
