<div class="content-frame-right">
    <div class="panel panel-{{Auth::user()->css}}">
        <div class="panel-body">
            <h3 class="push-up-0">Atualizações</h3>
            <!-- Div Relógio e Clima -->
            <div class="widget widget-default widget-padding-sm">
                <div class="widget-big-int plugin-clock"></div>
                <div class="widget-subtitle plugin-date"></div>
                @php
                $hh = Auth::user()->have_humour;
                $dateDiff = 0;
                if($hh !== NULL) {
                    $past = date_create($hh);
                    $now = date_create(date('Y-m-d'));
                    $diff=date_diff($past,$now);
                    $dateDiff = $diff->d;
                }
                @endphp
                @if($dateDiff == 0)
                {{-- pós feedback  --}}
                <div class="widget-buttons widget-c3" id="feedbackHumour">
                    <div class="widget-subtitle">Agradecemos teu feedback!</div>
                    <div class="widget-subtitle">Tenha um ótimo expediente! <span class="fa fa-smile-o"></span></div>
                </div>
                @else
                {{-- pós feedback  --}}
                <div class="widget-buttons widget-c3" id="feedbackHumour" style="display: none">
                    <div class="widget-subtitle">Agradecemos teu feedback!</div>
                    <div class="widget-subtitle">Tenha um ótimo expediente! <span class="fa fa-smile-o"></span></div>
                </div>
                {{-- feedback  --}}
                <div class="widget-buttons widget-c3" id="time">
                    <div class="widget-subtitle">Como está se sentindo?</div>
                    <div class="col">
                        <!-- 1 = sad  -->
                        <a onclick="saveHumour(1)">
                            <span class="fa fa-frown-o fa-2x"></span>
                        </a>
                    </div>
                    <div class="col">
                        <!-- 2 = meio  -->
                        <a onclick="saveHumour(2)">
                            <span class="fa fa-meh-o fa-2x"></span>
                        </a>
                    </div>
                    <div class="col">
                        <!-- 3 = sorriso  -->
                        <a onclick="saveHumour(3)">
                            <span class="fa fa-smile-o fa-2x"></span>
                        </a>
                    </div>
                </div>
                @endif
            </div>

            @php
            
            $i = 0;

            @endphp

            <!-- Quizzes Alerts -->
            @if(isset($quiz) && !is_null($quiz))
            @forelse($quiz as $item)
            @php

            $i++;

            @endphp
            <a class="widget @if($i % 2 === 0) widget-success @else widget-danger @endif widget-item-icon" href="{{ route('GetQuizzesView',[ 'id' => base64_encode($item->id) ]) }}">
                <div class="widget-item-left">
                    <img src="{{$item->avatar}}">
                </div>
                <div class="widget-data">
                    <div class="widget-title">Quiz #{{$item->id}}</div>
                    <div class="widget-subtitle">{{$item->title}}</div>
                    <div class="widget-subtitle">{{substr($item->description,0,30)}}</div>
                    <div class="widget-subtitle">Clique Aqui para responder</div>
                </div>
            </a>
            @empty

            @endforelse
            @endif


            {{-- ./Div Relógio e Clima --}}
            @if( in_array(Auth::user()->cargo_id,[1,2,4,9,7]) )
            {{-- Chart's Environment  --}}
            <div class="widget widget-default widget-padding-sm" id="chart1">

                <div class="widget-title">Clima da Equipe</div>
                <br>
                <div id="enviroChart" class="text-center" style="height: 2%;"></div>

                <div class="widget-buttons widget-c3">
                    <a>
                        <span class="fa fa-frown-o " style="color:red"></span>
                        <p class="text-muted" style="font-size: 15px;" id="env1">N/D</p>

                    </a>
                    <a style="margin-left:20%;">
                        <span class="fa fa-meh-o" style="color:#ffd700"></span>
                        <p class="text-muted" style="font-size: 15px;" id="env2">N/D</p>
                    </a>
                    <a style="margin-left:20%;">
                        <span class="fa fa-smile-o" style="color:green;"></span>
                        <p class="text-muted" style="font-size: 15px;" id="env3">N/D</p>
                    </a>
                </div>
            </div>
            @endif
            {{-- ./Chart's Environment  --}}
            {{-- Materials Widget  --}}
            @if(in_array(Auth::user()->cargo_id, [1,3,4,5,7]))
            <div id="NonReaded"></div>
            <input type="hidden" id="NonReadedIpt">
            <input type="hidden" id="material">
            <input type="hidden" id="script">
            <input type="hidden" id="circular">
            <input type="hidden" id="video">
            @endif
            {{-- ./Materials Widget  --}}
        </div>
    </div>
</div>

@section('ChartsUpdates')
@if( in_array(12,session('permissionsIds')) )
<script type="text/javascript" src="{{ asset('js/plugins/morris/raphael-min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/plugins/morris/morris.min.js') }}"></script>

<script type="text/javascript">
    //chama a função ao carergar a page
    $(window).on('load',function () {
        @if(in_array(Auth::user()->cargo_id,[1,2,4,9,7]))
        getEnvironment();
        @endif

        //chama as funções à cada 5 minutos
        setInterval(function(){

            //buscas
            @if(in_array(Auth::user()->cargo_id,[1,3,4,5,7]))
            nonReadMaterials()
            @endif

          //tempo de busca
      },5*60*1000);

        //if Laravel
        @if(in_array(Auth::user()->cargo_id,[1,3,4,5,7]))
        setTimeout(function(){

            nonReadMaterials()

        }, (30*1000))
        @endif

    })
    //Pega dados de clima de equipe e converte em gráficos para os superiores
    function getEnvironment() {
        $.getJSON('{{ route("GetUsersHumourChart", [
            'id' => Auth::id(),
            'cargo' => Auth::user()->cargo_id,
            'ilha' => Auth::user()->ilha_id
            ] ) }}',function(data) {

                if(data.length > 0) {
                    console.log(data)

                // insatisfeito
                if(typeof data[0] !== 'undefined' &&  data[0]['valTypes'] == 'Insatisfeito') {
                    env1 = data[0]['humor']
                } else if(typeof data[1] !== 'undefined' &&  data[1]['valTypes'] == 'Insatisfeito') {
                    env1 = data[1]['humor']
                } else if(typeof data[2] !== 'undefined' &&  data[2]['valTypes'] == 'Insatisfeito') {
                    env1 = data[2]['humor']
                } else {
                    env1 = 0
                }

                // indiferente
                if(typeof data[0] !== 'undefined' &&  data[0]['valTypes'] == 'Indiferente') {
                    env2 = data[0]['humor']
                } else if(typeof data[1] !== 'undefined' &&  data[1]['valTypes'] == 'Indiferente') {
                    env2 = data[1]['humor']
                } else if(typeof data[2] !== 'undefined' &&  data[2]['valTypes'] == 'Indiferente') {
                    env2 = data[2]['humor']
                } else {
                    env2 = 0
                }

                // Satisfeito
                if(typeof data[0] !== 'undefined' &&  data[0]['valTypes'] == 'Satisfeito') {
                    env3 = data[0]['humor']
                } else if(typeof data[1] !== 'undefined' &&  data[1]['valTypes'] == 'Satisfeito') {
                    env3 = data[1]['humor']
                } else if(typeof data[2] !== 'undefined' &&  data[2]['valTypes'] == 'Satisfeito') {
                    env3 = data[2]['humor']
                } else {
                    env3 = 0
                }

                // Total
                total =env1+env2+env3

                Morris.Donut({
                    element: 'enviroChart',
                    data: [
                    {label: "Insatisfeito", value: env1},
                    {label: "Indiferente", value: env2},
                    {label: "Satisfeito", value: env3}
                    ],
                    colors: [
                    'red',
                    '#ffd700',
                    'green'
                    ]

                });


                $("#env1").html(parseInt(env1/total*100) + '%')
                $("#env2").html(parseInt(env2/total*100) + '%')
                $("#env3").html(parseInt(env3/total*100) + '%')
            } else {
                $("#chart1").hide()
            }//endif
        })
    }
    @endif
</script>
@endsection
