<div class="content-frame-right">
    <div class="panel panel-{{Auth::user()->css}}">
        <div class="panel-body">
            <h3 class="push-up-0">Mais Lidos</h3>
            <!-- Div Relógio e Clima -->
            <div class="widget widget-default widget-padding-sm">
                <div class="widget-big-int plugin-clock"></div>
                <div class="widget-subtitle plugin-date"></div>
          
                {{-- feedback  --}}
                <div class="widget-buttons widget-c3" id="time">
                    <div class="form-group">
                            <h4>Trendig Topics:</h4>
                            <div class="list-group border-bottom">
                                <a href="#" class="list-group-item"><span class="fa fa-circle text-primary"></span> Liderando #1</a>
                                <a href="#" class="list-group-item"><span class="fa fa-circle text-success"></span> Atendimento</a>
                                <a href="#" class="list-group-item"><span class="fa fa-circle text-warning"></span> Iniciando #2</a>
                                <a href="#" class="list-group-item"><span class="fa fa-circle text-danger"></span> C2</a>
                                <a href="#" class="list-group-item"><span class="fa fa-circle text-info"></span> Boleto</a>
                            </div>
                        </div>
                </div>
            </div>

   
        
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
