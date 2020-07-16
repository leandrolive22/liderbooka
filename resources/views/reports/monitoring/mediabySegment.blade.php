@extends('layouts.app', ["current"=>"monitor"])
@section('content')
<!-- START PAGE CONTAINER -->
<div class="page-container">

    <!-- PAGE CONTENT -->
    <div class="page-content">

        @component('assets.components.x-navbar')
        @endcomponent

        <!-- START BREADCRUMB -->
        <ul class="breadcrumb">
            <li><a href="{{asset('/home/page')}}">Home</a></li>
            <li><a href="{{asset('monitoring/manager')}}">Monitoria</a></li>
            <li><a href="#">Media Por Ilha</a></li>

        </ul>
        <!-- END BREADCRUMB -->

        <div class="d-flex justify-content-center col-md-12" id="preloaderPageContent">
            <div class="spinner-grow text-dark" role="status" style="width: 30rem; height:30rem">
            </div>
        </div>

        <!-- PAGE CONTENT WRAPPER -->
        <div class="page-content-wrap" id="content" style="display: none">
            {{-- START Charts --}}
            <div class="row">
                <div class="col-md-12">
                    <!-- START CArteiras CArd -->
                    <div class="panel panel-default chartLine" id="carteiras">
                        <div class="panel-heading">
                            <h3 class="panel-title col-md-1">
                                Carteiras
                            </h3>
                            <label for="carteiras" class="text-muted col-md-9">
                                Selecione a Carteira Clicando no Card Correspondente
                            </label>
                            <ul class="panel-controls">
                                <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                            </ul>
                        </div>
                        <div class="panel-body" style="overflow-x: auto;">
                            <table>
                                <tr>
                                @forelse ($carteiras as $item)
                                    <td class="btn col-md-3" onclick="getData('carteira',{{$item->id}})">
                                        <div class="col-md-12">
                                            <div class="widget @if($item->media >= 95 ) widget-success @elseif($item->media >= 90) widget-primary @else widget-danger @endif widget-padding-sm">
                                                <div class="widget-item-left">
                                                    <input class="knob" data-width="100" data-height="100" data-min="0" data-max="100" data-displayInput=true data-bgColor="#D3D3D3" data-fgColor="#FFF" value="{{round($item->media,2)}}" data-readOnly="true" data-thickness=".2"/>
                                                </div>
                                                <div class="widget-data">
                                                    <div class="widget-subtitle">Média por Carteira</div>
                                                    <div class="widget-title">{{$item->name}}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                @empty
                                    <td class="text-center col-md-12"><h3>Nenhum dado Encontrado</h3></td>
                                @endforelse
                                </tr>
                            </table>
                        </div>
                    </div>
                    {{-- END Setores Card --}}
                    <!-- START CArteiras CArd -->
                    <div class="panel panel-default chartLine" id="setores">
                        <div class="panel-heading">
                            <h3 class="panel-title col-md-2">
                                Setores
                            </h3>
                            <label for="setores" class="text-muted col-md-9">Selecione o Setor Clicando no Card Correspondente</label>
                            <ul class="panel-controls">
                                <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                            </ul>
                        </div>
                        <div class="panel-body" style="overflow-x: auto;">
                            <table class="table table-responsive table-hover">
                                <tr>
                                @forelse ($setores as $item)
                                    <td class="btn col-md-3" onclick="getData('setor',{{$item->id}})">
                                        <div class="col-md-12">
                                            <div class="widget @if($item->media >= 95 ) widget-success @elseif($item->media >= 90) widget-primary @else widget-danger @endif widget-padding-sm">
                                                <div class="widget-item-left">
                                                    <input class="knob" data-width="100" data-height="100" data-min="0" data-max="100" data-true=false data-bgColor="#D3D3D3" data-fgColor="#FFF" value="{{round($item->media,2)}}" data-readOnly="true" data-thickness=".2"/>
                                                </div>
                                                <div class="widget-data">
                                                    <div class="widget-subtitle">Média por Setor</div>
                                                    <div class="widget-title">{{$item->name}}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                @empty
                                    <td class="text-center col-md-12"><h3>Nenhum dado Encontrado</h3></td>
                                @endforelse
                                </tr>
                            </table>
                        </div>
                    </div>
                    {{-- END Setores Card --}}
                    <!-- START Ilhas CArd -->
                    <div class="panel panel-default chartLine" id="ilhas">
                        <div class="panel-heading">
                            <h3 class="panel-title col-md-2">
                                Ilhas
                            </h3>
                            <label for="ilhas" class="text-muted col-md-9">Selecione a Ilha Clicando no Card Correspondente</label>
                            <ul class="panel-controls">
                                <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                            </ul>
                        </div>
                        <div class="panel-body" style="overflow-x: auto;">
                            <table>
                                <tr>
                                @forelse ($ilhas as $item)
                                    <td class="btn col-md-3" onclick="getData('ilha',{{$item->id}})">
                                        <div class="col-md-12">
                                            <div class="widget @if($item->media >= 95 ) widget-success @elseif($item->media >= 90) widget-primary @else widget-danger @endif widget-padding-sm">
                                                <div class="widget-item-left">
                                                    <input class="knob" data-width="100" data-height="100" data-min="0" data-max="100" data-true=true data-bgColor="#D3D3D3" data-fgColor="#FFF" value="{{round($item->media,2)}}" data-readOnly="true" data-thickness=".2"/>
                                                </div>
                                                <div class="widget-data">
                                                    <div class="widget-subtitle">Média por Ilha</div>
                                                    <div class="widget-title">{{$item->name}}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                @empty
                                    <td class="text-center col-md-12"><h3>Nenhum dado Encontrado</h3></td>
                                @endforelse
                                </tr>
                            </table>
                        </div>
                    </div>
                    {{-- END Ilhas Card --}}
                </div>
            </div>
            {{-- END Charts --}}
            {{-- START TABLE --}}
            <div class="row" id="charts" style="display: none">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Gráficos</h3>
                            <ul class="panel-controls">
                                <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                            </ul>
                        </div>
                        <div class="panel-body text-center" style="overflow-x: auto; ">
                            <div class="col-md-4">
                                <label for="dadosAvaliacoes" class="col-md-12">Avaliações</label>
                                <div style="min-height: 150px; height: 300px" id="dadosAvaliacoes"></div>
                            </div>
                            <div class="col-md-4">
                                <label for="quartis" class="col-md-12">Quartis</label>
                                <div style="min-height: 150px; height: 300px" id="quartis"></div>
                            </div>
                            <div class="col-md-4">
                                <label for="feedbacks" class="col-md-12">Feedbacks (FB)</label>
                                <div style="min-height: 150px; height: 300px" id="feedbacks"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Relatório</h3>
                            <ul class="panel-controls">
                                <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                            </ul>
                        </div>
                        <div class="panel-body" style="overflow-y: scroll; max-height:500px;">
                            <div class="col-md-12" id="tableLoadingPreLoader" style="display: none;">
                                <p class="col-md-12">Buscando dados, aguarde...</p>
                                <div class="d-flex justify-content-center col-md-12" >
                                    <div class="spinner-grow text-dark" role="status" style="width: 5cm; height:5cm">
                                    </div>
                                </div>
                            </div>
                            <table class="table table-bordered table-responsive" id="table_report" >
                                <thead>
                                    <tr id="semDado">
                                        <td class="text-center">Nenhum dado encontrado, Selecione uma <a href="javascript:alertClick('carteiras')">Carteira</a>, <a href="javascript:alertClick('setores')">Setor</a> ou <a href="javascript:alertClick('ilhas')">Ilha</a> para ver o relatório</td>
                                    </tr>
                                    <tr id="comDado" style="display: none">
                                        <th>Monitoria</th>
                                        <th>Data da Monitoria</th>
                                        <th>Operador</th>
                                        <th>Tipo de Ligação</th>
                                        <th>Media</th>
                                        <th>Conforme</th>
                                        <th>Não Conforme</th>
                                        <th>Não Avaliado</th>
                                        <th>Feedback Aplicado</th>
                                        <th>Data do FeedBack</th>
                                        <th>Carteira</th>
                                        <th>Setor</th>
                                        <th>Ilha</th>
                                        <th>Quartil</th>
                                    </tr>
                                </thead>
                                <tbody id="table_body">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {{-- END TABLE --}}
        </div>
        {{-- END PAGE CONTENT WRAPPER --}}

    </div>
    {{-- END PAGE CONTENT --}}

</div>
<!-- END PAGE CONTAINER -->
<input type="number" name="ncgs" id="ncgs" aria-hidden="true" style="display: none" value="0">
<input type="number" name="q1" id="q1" aria-hidden="true" style="display: none" value="0">
<input type="number" name="q2" id="q2" aria-hidden="true" style="display: none" value="0">
<input type="number" name="q3" id="q3" aria-hidden="true" style="display: none" value="0">
<input type="number" name="q4" id="q4" aria-hidden="true" style="display: none" value="0">
<input type="number" name="confs" id="confs" aria-hidden="true" style="display: none" value="0">
<input type="number" name="nConfs" id="nConfs" aria-hidden="true" style="display: none" value="0">
<input type="number" name="nAvs" id="nAvs" aria-hidden="true" style="display: none" value="0">
<input type="number" name="aplicado" id="aplicado" aria-hidden="true" style="display: none" value="0">
<input type="number" name="n_aplicado" id="n_aplicado" aria-hidden="true" style="display: none" value="0">
@endsection
@section('Javascript')

    <script src="{{asset('js/plugins/knob/jquery.knob.min.js')}}"></script>
    <script src="{{asset('js/plugins/owl/owl.carousel.min.js')}}"></script>
    {{-- MORRIS  --}}
    <script type="text/javascript" src="{{asset('js/plugins/morris/raphael-min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/plugins/morris/morris.min.js')}}"></script>
    <script lang="javascript">
        function alertClick(id) {
            $("#"+id).attr('class','panel panel-default alert-danger')

            setTimeout(() => {
                $("#"+id).attr('class','panel panel-default')
            }, 700);
        }
        // Pesquisa datas
        function getData(type, id) {
            $("#tableLoadingPreLoader").show()
            $("#table_report").hide()
            $(".chartLine").attr("class","panel panel-default panel-toggled")
            $("#charts").hide()

            $.ajax({
                url: "{{asset('manager/report/monitoring/mediaSegments/search')}}/"+id+"/"+type,
                method: "POST",
                success: function(data) {
                    if(data == 0) {
                        $("#semDado").show()
                        $("#comDado").hide()
                        noty({
                            text: "Nenhum dado encontrado, reveja a consulta ou tente novamente mais tarde!",
                            layout: 'topRight',
                            type: 'error',
                            timeout: 3000,
                        });
                    } else {
                        // Zera input de controle para gerar dados de gráfico
                        $("#ncgs").val(0)
                        $("#q1").val(0)
                        $("#q2").val(0)
                        $("#q3").val(0)
                        $("#q4").val(0)
                        $("#confs").val(0)
                        $("#nConfs").val(0)
                        $("#nAvs").val(0)
                        $("#aplicado").val(0)
                        $("#n_aplicado").val(0)

                        // interações de carregamento
                        $("#semDado").hide()
                        $("#comDado").show()
                        $("#tableLoadingPreLoader").hide()
                        $("#table_report").show()

                        // monta linhas
                        linhas = ''
                        for(i=0;i<data.length; i++) {
                            linhas += montarLinha(data[i])
                        }

                        // Mostra Div de graficos
                        $("#charts").show()

                        //monta graficos
                        quartis()
                        dadosAvaliacoes(data.length)
                        feedbacks()

                        $("#table_body").html(linhas)
                    }
                },
                error: function (xhr) {
                    console.log(xhr)
                    $("#semDado").show()
                    $("#comDado").hide()
                    $("#tableLoadingPreLoader").hide()
                    $("#table_report").show()

                    if(xhr.responseJSON.errors) {
                        $.each(xhr.responseJSON.errors,(i,v) => {
                            noty({
                                text: v,
                                layout: 'topRight',
                                type: 'error',
                                timeout: 3000,
                            });
                        })
                    }
                    if(xhr.responseJSON.message) {
                        noty({
                            text: xhr.responseJSON.message,
                            layout: 'topRight',
                            type: 'error',
                            timeout: 3000,
                        });
                    }
                }
            });
        }

        // Monta linhas
        function montarLinha(data) {
            // Verifica qual quartil a Monitoria se encontra
            if(data.quartil === 'Q1') {
                quartil = 'Q1'
                $("#q1").val(Number($("#q1").val())+1)
            } else if(data.quartil === 'Q2') {
                quartil = 'Q2'
                $("#q2").val(Number($("#q2").val())+1)
            } else if(data.quartil === 'Q3') {
                quartil = 'Q3'
                $("#q3").val(Number($("#q3").val())+1)
            } else if(data.quartil === 'Q4'){
                quartil = 'Q4'
                $("#q4").val(Number($("#q4").val())+1)
            } else if(data.quartil === 'NCG'){
                quartil = 'NCG'
                $("#ncgs").val(Number($("#ncgs").val())+1)
            } else {
                quartil = "Não Atualizado"
            }

            switch (quartil) {
                case 'Q1':
                    classe = 'bg-danger Q1'
                    break;
                case 'Q2':
                    classe = 'bg-warning Q2'
                    break;
                case 'Q3':
                    classe = 'bg-primary Q3'
                    break;
                case 'Q4':
                    classe = 'bg-success Q4'
                    break;
                case 'NCG':
                    classe = 'bg-dark text-white NCG'
                    break;

                default:
                    classe = ''
                    break;
            }

            // Soma dados das monitorias em geral
            $("#confs").val(Number($("#confs").val())+Number(data.conf))
            $("#nConfs").val(Number($("#nConfs").val())+Number(data.nConf))
            $("#nAvs").val(Number($("#nAvs").val())+Number(data.nAv))

            if(data.dataFeedback == '-') {
                $("#n_aplicado").val(Number($("#n_aplicado").val())+1)
            } else {
                $("#aplicado").val(Number($("#aplicado").val())+1)
            }

            // prepara linha para concatenação
            linha = '<tr>'+
                        '<td>'+data.monitoria+'</td>'+
                        '<td>'+data.dataMonitoria+'</td>'+
                        '<td>'+data.operador+'</td>'+
                        '<td>'+data.tipo_ligacao+'</td>'+
                        '<td>'+data.media+'</td>'+
                        '<td>'+data.conf+'</td>'+
                        '<td>'+data.nConf+'</td>'+
                        '<td>'+data.nAv+'</td>'+
                        '<td>'+data.feedbackSupervisor+'</td>'+
                        '<td>'+data.dataFeedback+'</td>'+
                        '<td>'+data.carteiraName+'</td>'+
                        '<td>'+data.setorName+'</td>'+
                        '<td>'+data.ilhaName+'</td>'+
                        '<td class="'+classe+'">'+quartil+'</td>'+
                    '</tr>';

            return  linha

        }

        // calcula grafico de Quartis e NCGs
        function quartis() {
            $("#quartis").html('')
            return Morris.Donut({
            element: 'quartis',
                data: [
                    {"label": "NCG", "value": ($("#ncgs").val())},
                    {"label": "Q1", "value": ($("#q1").val())},
                    {"label": "Q2", "value": ($("#q1").val())},
                    {"label": "Q3", "value": ($("#q1").val())},
                    {"label": "Q4", "value": ($("#q1").val())},
                ],
                colors: [
                    'black',
                    '#E04B4A', //red
                    '#fe970a', // yellow
                    '#10254d', //blue
                    '#95b75d', // green
                ]
            });
        }

        // calcula grafico de dados das avaliações
        function dadosAvaliacoes(count) {
            $("#dadosAvaliacoes").html('')
            return Morris.Bar({
            element: 'dadosAvaliacoes',
                data: [
                    { y: 'Este Mês', a: count, b: $("#confs").val() , c: $("#nConfs").val(), d: $("#ncgs").val()},
                ],
                xkey: 'y',
                ykeys: ['a', 'b', 'c', 'd'],
                labels: ['Avaliações', 'Conformes', 'Não conformes', 'Não Avaliados', 'NCGs'],
                barColors: [
                    'black',
                    '#95b75d', // green
                    '#fe970a', // yellow
                    'blue', //blue
                    '#E04B4A', //red
                ]
            });
        }

        function feedbacks() {
            $("#feedbacks").html('')
            return Morris.Donut({
            element: 'feedbacks',
                data: [
                    {"label": "FB's Aplicados", "value": ($("#aplicado").val())},
                    {"label": "FB's Não Aplicados", "value": ($("#n_aplicado").val())},
                ],
                colors: [
                    '#95b75d', // green
                    '#E04B4A', //red
                ]
            });
        }

        //configurações quando a página carrega
        $(() => {
            $("#content").show()
            $("div#preloaderPageContent").remove()
        })
    </script>
@endsection
