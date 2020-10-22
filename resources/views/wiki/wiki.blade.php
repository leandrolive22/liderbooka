@extends('layouts.app', ["current"=>"wiki"])
<!-- CARDS CSS INICIO -->
@section('css')
<style>
    #card4 {
        position: relative;
        border-width: 2px;
        width: 18rem;
        height: 115px;
        left: 480px;
        background-color: #23332e;
        float: left;
        top: -235px;
        font-color:white;
    }

    #card3 {
        position: relative;
        border-width: 2px;
        width: 18rem;
        height: 115px;
        left: 240px;
        background-color: #4169E1;
        float: left;
        top: -108px;
        font-color: white;
    }

    #card2 {
        position: relative;
        border-width: 2px;
        width: 18rem;
        height: 115px;
        left: 240px;
        background-color: #c73440;
        float: left;
        top: -94px;
        font-color:white;
    }

    #card1 {
        background-color: #4ea68b;
        font-color:white;
        border-width: 2px;

    }
</style>
@endsection
<!-- CARDS CSS FIM -->
@section('content')
<!-- START PAGE CONTAINER -->
<div class="page-container">

    <!-- PAGE CONTENT -->
    <div class="page-content">

        @component('assets.components.x-navbar')
        @endcomponent

        <br>

        <!-- START BREADCRUMB -->
        <ul class="breadcrumb">
            <li><a href="{{asset('/home')}}">Home</a></li>
            <li><a href="#">Wiki</a></li>
        </ul>
        <!-- END BREADCRUMB -->


        <!-- PAGE CONTENT WRAPPER -->
        <div class="page-content-wrap">

            <div class="row">
                <div class="col-md-12">

                    <!-- START WIKI BUSCA FILTER -->
                    @component('assets.components.wikiSearch', ['titlePage' => '', 'ilhas' => $ilhas])
                    @endcomponent

                    <div style="height: 100px;  width: 100%;" class="panel panel-success panel-hidden-controls">
                        <div class="panel-heading">
                            <h3 class="panel-title"> Trending Topics </h3>
                            <ul class="panel-controls">
                                <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span
                                        class="fa fa-cog"></span></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span>
                                            Collapse</a></li>
                                            <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span>
                                            Refresh</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                                </ul>
                            </div>
                            <div class="panel-body">
                                <incode></incode> <code> #Jornadadocliente #Atendimento #PromessadePagamento</code>
                            </div>
                        </div>

                        <!-- END WIKI BUSCA FILTER -->

                        <!-- INICIO CARDS -->



                        <div id="card1" class="card text-black bg-black mb-3" style="max-width: 18rem; height: 115px;">
                            <a href="{{ route('CircularesWiki', [ 'ilha' => Auth::user()->ilha_id ]) }}" class="selectIlha">
                                <div style="color:white; font-size:19px; text-align: center " class="card-header">Comunicados</div>
                            </a>
                            <div class="card-body">
                                <select name="text-center right: 12rem;" id="" onchange="redirectToSegment(this,'circular')" class="form-control">
                                    <option value="0">Pesquise por segmento</option>
                                @if($segmentos == 0)
                                @else
                                @forelse ([] as $segmento)
                                    <option value="{{$segmento->id}}">{{$segmento->name}}</option>
                                @empty
                                    <option value="0">Nenhum segmento encontrado</option>
                                @endforelse
                                @endif
                           </select>

                                <div id="card2" class="card text-black bg-black mb-3" style="max-width: 18rem;">
                                    {{-- Roteiros  --}}
                                    <a href="{{  route('GetRoteirosIndex', ['ilha' => Auth::user()->ilha_id ]) }}" class="selectIlha">
                                        <div style="color:white; font-size:19px; text-align: center" class="card-header text-white">
                                            Roteiros
                                        </div>
                                    </a>
                                    <div class="card-body">
                                        <select name="text-center right: 12rem;" id="" onchange="redirectToSegment(this,'scripts')" class="form-control">
                                                <option value="0">Pesquise por segmento</option>
                                            @if($segmentos == 0)
                                            @else
                                            @forelse ([] as $segmento)
                                                <option value="{{$segmento->id}}">{{$segmento->name}}</option>
                                            @empty
                                                <option value="0">Nenhum segmento encontrado</option>
                                            @endforelse
                                            @endif
                                       </select>
                                   </div>
                                   {{-- segmentos  --}}
                                   <div id="card3" class="card text-black bg-black mb-3" style="max-width: 18rem;">
                                    <a href="{{ route('GetMateriaisIndex', [ 'ilha' => Auth::user()->ilha_id ]) }}" class="selectIlha">
                                        <div style="color:white; font-size:19px; text-align: center" class="card-header text-white">
                                            Materiais
                                        </div>
                                    </a>
                                    <div class="card-body">
                                        <select name="text-center right: 12rem;" id="" onchange="redirectToSegment(this,'materials')" class="form-control">
                                            <option value="0">Pesquise por segmento</option>
                                            @if($segmentos == 0)
                                            @else
                                            @forelse ([] as $segmento)
                                            <option value="{{$segmento->id}}">{{$segmento->name}}</option>
                                            @empty
                                            <option value="0">Nenhum segmento encontrado</option>
                                            @endforelse
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                {{-- Videos  --}}
                                <div id="card4" class="card text-black bg-black mb-3" style="max-width: 18rem;">
                                    <a href="{{ route('GetVideosIndex', [ 'ilha' => Auth::user()->ilha_id ]) }}" class="selectIlha">
                                        <div style="color:white;font-size:19px; text-align: center" class="card-header">
                                            Vídeos
                                        </div>
                                    </a>
                                    <div class="card-body">
                                        <select name="text-center right: 12rem;" id="" onchange="redirectToSegment(this,'videos')" class="form-control">
                                            <option value="0">Pesquise por segmento</option>
                                            @if($segmentos == 0)
                                            @else
                                            @forelse ([] as $segmento)
                                            <option value="{{$segmento->id}}">{{$segmento->name}}</option>
                                            @empty
                                            <option value="0">Nenhum segmento encontrado</option>
                                            @endforelse
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <!-- FIM CARDS -->


                                <!-- START TIMELINE -->
                                <div class="col-md-6">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('Javascript')
<script>
    function mudarCor(){
        $("#botao").attr("style","background-color: #09f;")
    }

</script>

<!-- Javascript Sistema de lider coins e modal inicio -->
<script type="text/javascript">
    var campo = document.querySelector("#campo-result");
    var pontos;
    pontos = 509;

    var gasto;
    gasto = 9;

    var mpontos;
    mpontos= 3;

    var pontosrestante = pontos - gasto;
    var pontosrestantes = pontos + mpontos;

    function aumentarValor() {
        if ((parseInt(campo.value)+mpontos)<18) {
            campo.value = 18;
        } else {
            campo.value=parseInt(campo.value)+mpontos;
        }
    }

    function mudarValor() {
        if ((parseInt(campo.value)-gasto)<0) {
            campo.value = 0;
        } else {
            campo.value=parseInt(campo.value)-gasto;
        }
    }


    $('#modal').on('shown.bs.modal', function () {
        $('#meuInput').trigger('focus')
    })

    function redirectToCircular(element) {
        year = element.value
        if(year > 0) {
            return location.href= "{{ asset('circulares/') }}/" + year + "/{{ Auth::user()->ilha_id }}"
        }
    }
    function redirectToSegment(element,type) {
        segment = element.value
        if(segment > 0) {
            return location.href= "{{ asset('/') }}"+type+"/" + segment + "/{{ Auth::user()->ilha_id }}"
        }
    }

</script>
</script>

<!-- Javascript Sistema de lider coins e modal fim -->

@endsection
