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
                    <a href="{{ url()->previous() }}">
                        <h2><span class="fa fa-arrow-circle-o-left"></span> Gerenciamento</h2>
                    </a>
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
                                <h3 class="panel-title">Relatório de Quizzes</h3>
                            </div>
                            <div class="panel-body">
                                <div class="form-row">
                                    <div class="form-group col-md-10">
                                        <label for="selectQuiz">Quiz</label>
                                        <select data-live-search="true" id="selectQuiz" name="Quiz"
                                            class="form-control select">

                                            @forelse ($quizzes as $quiz)
                                            <option value="{{$quiz->id}}" @if(isset($quiz_id) && $quiz_id==$quiz->id))
                                                selected="selected" @endif>{{$quiz->title}}</option>
                                            @empty
                                            <option value="0" selected>Nenhum Quiz Ativo Encontrado</option>
                                            @endforelse

                                        </select>
                                    </div>
                                    <div class="form-group col-md-2">
                                        <button id="btnQuiz" type="button"
                                            class="btn btn-dark btn-block">Pesquisar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    @if($filters == 1)
                    <div class="panel">
                        <div class="panel-heading bg-secondary">
                            <h3 class="panel-title" style="color: white">Filtros de Busca</h3>
                        </div>
                        <div class="panel-body" style="display:none" id="preloader">
                            <div class="d-flex justify-content-center">
                                <div class="spinner-grow" style="width: 7rem; height: 7rem;" role="status">
                                    <span class="sr-only">Buscando resultados...</span>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body" id="filters">
                            {{-- CheckBox  --}}
                            <div class="form-row col-md-12">
                                <h3 class="col-md-12">Por gerencia</h3>
                                <div class="form-group col-md-2">
                                    <label class="check" name="Todas gerencias">
                                        <input type="checkbox" value="0" name="all" class="icheckbox" />
                                        Todos(as)
                                    </label>
                                </div>

                                @forelse ($adm as $c)
                                <div class="form-group col-md-2">
                                    <label class="check">
                                        <input type="checkbox" value="{{ $c->id }}" name="gerencia" class="icheckbox"
                                            id="icheck{{ $c->id }}" />
                                        {{ $c->description }}
                                    </label>
                                </div>
                                @empty
                                <div class="form-group col-md-12">
                                    <label class="check">
                                        <input type="checkbox" disabled value="0" name="gerencia"
                                            class="icheckbox disabled" /> Nenhum
                                        Gestor disponível para esta consulta
                                    </label>
                                </div>
                                @endforelse


                            </div>

                            {{-- Selects  --}}
                            <div class="form-row col-md-12">
                                <h3 class="col-md-12">Personalizar Busca</h3>
                                <div class="form-group col-md-4">
                                    <label for="selectSup">Por superior</label>
                                    <select multiple data-live-search="true" name="Superior" id="selectSup"
                                        class="form-control select" data-style="btn-primary">
                                        <option value="0" selected>Todos(as)</option>

                                        @forelse ($superiores as $superior)
                                        <option value="{{ $superior->superior_id }}">{{ $superior->superior->name }}
                                        </option>
                                        @empty
                                        <option value="-">Nenhum superior/hierarquia registrado no sistema</option>
                                        @endforelse

                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="selectSite">Por sitio</label>
                                    <select data-live-search="true" id="selectSite" name="Sitio"
                                        class="form-control select" data-style="btn-primary">
                                        <option value="0" selected>Todos(as)</option>
                                        @foreach($filiais as $filial)
                                        <option value="{{ $filial->id }}">{{ $filial->name }}</option>
                                        @endforeach

                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="formcontrol">Por carteira</label>
                                    <select multiple data-live-search="true" class="form-control select"
                                        data-style="btn-primary" id="selectCarteira" name="Carteira">
                                        <option value="0" selected>Todos(as)</option>

                                        @forelse($users as $carteira)
                                        {{-- Pega o carteira de todos entervistados e separa, fazendo um "Distinct" neles  --}}
                                        @if(isset($dist))
                                        @if($dist != $carteira->carteira_id)
                                        @php
                                        unset($dist);
                                        $dist = $carteira->carteira_id;
                                        @endphp
                                        <option value="{{ $carteira->carteira_id }}">{{ $carteira->carteira->name }}
                                        </option>
                                        @endif
                                        @else
                                        {{ $dist = $carteira->carteira_id }}
                                        <option value="{{ $carteira->carteira_id }}">{{ $carteira->carteira->name }}
                                        </option>
                                        @endif
                                        @empty
                                        <option value="-">Nenhum carteira disponível</option>
                                        @endforelse

                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="formcontrol">Por Segmento/Setor</label>
                                    <select multiple data-live-search="true" id="selectSegment" name="Segmento"
                                        class="form-control select" data-style="btn-primary">
                                        <option value="0" selected>Todos(as)</option>

                                        @forelse($setores as $setor)
                                        <option value="{{ $setor->id }}">{{ $setor->name }}</option>
                                        @empty
                                        <option value="-">Nenhum setor disponível</option>
                                        @endforelse

                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="formcontrol">Por Produto/Ilha</label>
                                    <select multiple data-live-search="true" id="selectIlha" name="Ilha"
                                        class="form-control select" data-style="btn-primary">
                                        <option value="0" selected>Todos(as)</option>

                                        @forelse($ilhas as $ilha)
                                        <option value="{{ $ilha->id }}">{{ $ilha->name }}</option>
                                        @empty
                                        <option value="-">Nenhuma Ilha encontrada</option>
                                        @endforelse

                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="formcontrol">Por cargo do entrevistado</label>
                                    <select multiple data-live-search="true" id="selectCrgEtr"
                                        name="Cargo do Entrevistado" class="form-control select"
                                        data-style="btn-primary">
                                        <option value="0" selected>Todos(as)</option>

                                        @forelse($users as $u)
                                        {{-- Pega o cargo de todos entervistados e separa, fazendo um "Distinct" neles  --}}
                                        @if(isset($distinct))
                                        @if($distinct != $u->cargo_id)
                                        @php
                                        unset($distinct);
                                        $distinct = $u->cargo_id;
                                        @endphp
                                        <option value="{{ $u->cargo_id }}">{{ $u->cargo->description }}</option>
                                        @endif
                                        @else
                                        {{ $distinct = $u->cargo_id }}
                                        <option value="{{ $u->cargo_id }}">{{ $u->cargo->description }}</option>
                                        @endif
                                        @empty
                                        <option value="-">Nenhum Participante respondeu o Quiz</option>
                                        @endforelse

                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="formcontrol">Por pergunta</label>
                                    <select multiple data-live-search="true" id="selectPergunta" name="Pergunta"
                                        class="form-control select" data-style="btn-primary">
                                        <option value="0" selected>Todos(as)</option>

                                        @forelse($questions as $question)
                                        <option value="{{ $question->qId }}">{{ $question->question }}</option>
                                        @empty
                                        <option value="">Nenhum Quest]ao encontrada</option>
                                        @endforelse

                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="formcontrol">Por resposta</label>
                                    <select multiple data-live-search="true" id="selectResp" name="Resposta"
                                        class="form-control select" data-style="btn-primary">
                                        <option value="0" selected>Todos(as)</option>
                                        @foreach($options as $option)
                                        <option id="answ{{ $option->optId }}" class="answers"
                                            value="{{ $option->optId }}">{{ $option->question->question }} ->
                                            {{ $option->option }}</option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="formcontrol">Por participante</label>
                                    <select multiple data-live-search="true" id="selectPartic" name="Participante"
                                        class="form-control select" data-style="btn-primary">
                                        <option value="0" selected>Todos(as)</option>

                                        @forelse($users as $u)
                                        <option value="{{ $u->id }}">{{ $u->name }}</option>
                                        @empty
                                        <option value="-">Nenhum Participante respondeu o Quiz</option>
                                        @endforelse

                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <button class="btn btn-dark btn-block" onclick="search();"
                                        type="button">Pesquisar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="panel">
                        <div class="panel-body" id="awnswers">

                        </div>
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
<script type="text/javascript" src="{{ asset('js/plugins/bootstrap/bootstrap-select.js') }}"></script>

<script type="text/javascript" src="{{ asset('js/plugins/nvd3/lib/d3.v3.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/plugins/nvd3/nv.d3.min.js') }}"></script>
{{-- <script type="text/javascript" src="{{ asset('js/demo_charts_nvd3.js') }}"></script> --}}
<script language="javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //envia requisição POST baseada nos filtros
    function search() {
        // checkFields()
        $('#filters').hide()
        $("#preloader").show()

        token = $('input[name=_token]').val()
        selectQuiz = $('#selectQuiz').val()
        selectSup = $('#selectSup').val()
        selectSite = $('#selectSite').val()
        selectCarteira = $('#selectCarteira').val()
        selectSegment = $('#selectSegment').val()
        selectIlha = $('#selectIlha').val()
        selectCrgEtr = $('#selectCrgEtr').val()
        selectPergunta = $('#selectPergunta').val()
        selectResp = $('#selectResp').val()
        selectPartic = $('#selectPartic').val()
        gerencia =''

        if($("input[name='all']").is(':checked') == false) {
            $.each($('input[name=gerencia]'),function(i,v){
                if($('#'+v.id).is(':checked') == true) {
                    gerencia += v.value+','
                }
            })
        }

        if(gerencia == null || gerencia == '') {
            gerencia += 0
        }

        data = '_token='+token+'&selectQuiz='+selectQuiz+'&selectSup='+selectSup+'&selectSite='+selectSite+'&selectCarteira='+selectCarteira+'&selectSegment='+selectSegment+'&selectIlha='+selectIlha+'&selectCrgEtr='+selectCrgEtr+'&selectPergunta='+selectPergunta+'&selectResp='+selectResp+'&selectPartic='+selectPartic+'&gerencia='+gerencia

        $.ajax({
            type: "POST",
            url: "{{ route('PostQuizzesResults') }}",
            data: data,
            success: function (response) {
                if(response.none) {
                    noty({
                        layout: 'topRight',
                        type: 'error',
                        text: response.none,
                        timeout: 3000,
                    })
                }

                // Para as proximas 3 questões: element.split('_')[1] == question_id
                // Prepara gráficos
                q = questions(response)

                // Prepara alternativas
                o = options(response)

                // pega respostas de multipla escolha
                mult = answersMultiple(response)
                console.log(mult)

                for(i=0; q.length; i++) {

                }


                $('#filters').show()
                $("#preloader").hide()

            },
            error: function(xhr, status) {
                $('#filters').show()
                $("#preloader").hide()
                console.log(xhr)
                noty({
                    layout: 'topRight',
                    type: 'error',
                    text: 'Erro ' + xhr.status + ' | ' +status,
                    timeout: 3000,
                })
            }
        });
    }

    //concatena questões
    function questions(data) {
        dist = [];
        $.each(data,function(i,v){

            if(dist.indexOf(v.question + "_" + v.question_id) == -1) {
                dist.push(v.question + "_" + v.question_id)
            }

        })
        return dist

    }

    //concatena respostas
    function answersMultiple(data) {
        dist = [];
        $.each(data,function(i,v){

            if(dist.indexOf(v.multResp + "_" + v.question_id ) == -1 && v.multResp != null) {
                dist.push(v.multResp + "_" + v.question_id )
            }

        })
        return dist
    }

    //concatena alternativas
    function options(data) {
        dist = [];
        $.each(data,function(i,v){

            if(dist.indexOf(v.alternativa + "_" + v.question_id ) == -1) {
                dist.push(v.alternativa + "_" + v.question_id )
            }

        })
        return dist
    }

    //check fields of form to send a valid POST requests
    function checkFields() {

        // Check All selects
        $.each($('select'),function(i,v){
            if(v.value == null || typeof  v.value === undefined) {
                $(v).children("option:selected").val()
                noty({
                    layout: 'topRight',
                    theme: 'metroui',
                    type: 'warning',
                    text: "O campo "+v.name+" Não pode ser vazio, <b>selecione alguma opção</b>",
                    timeout: 3000,
                })
            }
        });

        check = 0

        // Check all checkboxs
        $.each($('checkbox :checked'),function(i,v){
            if(v.value != null || typeof  v.value != undefined) {
                check++
            }

        });

        if(check == 0) {
            noty({
                layout: 'topRight',
                theme: 'metroui',
                type: 'warning',
                text: "Selecione alguma gerencia",
                timeout: 3000,
            })
        }

        // Check all inputs
        $.each($('input'),function(i,v){
            if(v.value == null || typeof  v.value === undefined) {
                $(v).children("option:selected").val()
                noty({
                    layout: 'topRight',
                    theme: 'metroui',
                    type: 'warning',
                    text: "O campo "+v.name+" Não pode ser vazio, <b>selecione alguma opção</b>",
                    timeout: 3000,
                })
            }
        });
    }


    $(function(){
        @foreach($errors->all() as $error)
            noty({
                text: "{{$error}}",
                layout: 'topRight',
                type: 'error',
                timeout: 3000
            });
        @endforeach

        @if(session('erro')))
        noty({
                text: "{{session('erro')}}",
                layout: 'topRight',
                type: 'error',
                timeout: 3000
            });
        @endif
    })

    function multiple(data) {
        return '<div class="col-md-3">'+
            '<h3>'+data.question+'</h3>'+
            '<div id="chart'+data.id+'" style="height: 300px;"><svg></svg></div>'+
        '</div>';

    }


    function myPieChart(data) {
        nv.addGraph(function() {
            var chart = nv.models.donutChart()
                .x(function(d) { return d.label })
                .y(function(d) { return d.value })
                .showLabels(false);

                d3.select("#chart"+data.id+" svg")
                    .datum(pieChartData(data))
                    .transition().duration(350)
                    .call(chart);

            return chart;
        });
    }

    function pieChartData(info) {

        data = ''
        for(i=0; i < info.data; i++) {
            data += {
                "label": info.text,
                "value" : info.mtpAnswers
            }
        }

        return data

    }

    // faz select de filters
    $("#btnQuiz").click(function(){
        $("#formReport").attr('action','{{ asset("manager/report/quizzes") }}/'+$("#selectQuiz").val())
        $("#formReport").submit()
    })



</script>
@endsection
