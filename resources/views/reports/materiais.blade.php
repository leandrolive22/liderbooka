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
                                {{-- check boxes  --}}
                                <div class="form-check col-md-2">
                                    <label class="form-check-label">
                                        <label class="check">
                                            <input type="radio" class="iradio" name="iradio"
                                                onchange="searchMaterials(this)" value="calculadoras" />
                                            Calculadoras
                                        </label>
                                    </label>
                                </div>

                                <div class="form-check col-md-2">
                                    <label class="form-check-label">
                                        <label class="check">
                                            <input type="radio" class="iradio" name="iradio"
                                                onchange="searchMaterials(this)" value="circulares" />
                                            Circulares
                                        </label>
                                    </label>
                                </div>

                                <div class="form-check col-md-2">
                                    <label class="form-check-label">
                                        <label class="check">
                                            <input type="radio" class="iradio" name="iradio"
                                                onchange="searchMaterials(this)" value="materiais" />
                                            Materiais
                                        </label>
                                    </label>
                                </div>

                                <div class="form-check col-md-2">
                                    <label class="form-check-label">
                                        <label class="check">
                                            <input type="radio" class="iradio" name="iradio"
                                                onchange="searchMaterials(this)" value="roteiros" />
                                            Roteiros
                                        </label>
                                    </label>
                                </div>

                                <div class="form-check col-md-2">
                                    <label class="form-check-label">
                                        <label class="check">
                                            <input type="radio" class="iradio" name="iradio"
                                                onchange="searchMaterials(this)" value="videos" /> Videos
                                        </label>
                                    </label>
                                </div>
                            </div>
                    </div>
                </div>

                <div class="panel panel-dark">
                    <div class="panel-body">
                        <!-- START Datas -->
                        <div class="form-group col-md-12">
                            <label for="material">Selecione o material</label>
                            <select name="material" id="material" class="form-control select">
                                {{-- @forelse ($materials as $material)
                                    <option value="{{ $material->id }}"> {{ $material->name }}</option>
                                @empty
                                <option value="0">Nenhum Valor Encontrado</option>
                                @endforelse --}}
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Data Inicial:</label>
                            <input type="text" class="form-control datepicker" name="DataIn" id="DataIn"
                                value="{{date("d-m-Y",strtotime(date("Y-m-d")."-1 month"))}}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="">Data Inicial:</label>
                            <input type="text" class="form-control datepicker" name="DataFin" id="DataFin"
                                value="{{date("d-m-Y",strtotime(date("Y-m-d")."-1 month"))}}" required>
                        </div>

                        <!-- END Datas -->
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- FIM PAGE CONTAINER -->
@endsection

@section('ChartsUpdates')
{{-- .dtrange js  --}}
<script type="text/javascript" src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/plugins/moment.min.js') }}"></script>
<script type="text/javascript">
    function searchMaterials(element) {
   if($(element).is('checked')) {
        @if(in_array(Auth::user()->cargo_id,[1,2,3,4]))
            url = "asset('api/report')/"+element.value+"/Auth::user()->setor_id"
        @else
            url = "asset('api/report')/"+element.value+"/Auth::user()->setor_id"
        @endif
        $.ajax({
            type: "POST",
            url: url,
            success: function (response) {

            },
            error: function(xhr, status) {

            }
        });
   }
}
</script>
@endsection
