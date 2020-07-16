@extends('layouts.app',['current' => 'adm'])
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
                            <a href="{{ url()->previous() }}"><h2><span class="fa fa-arrow-circle-o-left"></span> Gerenciar Materiais</h2></a>
                        </div>
                        <div class="pull-right">
                            <button class="btn btn-{{Auth::user()->css}} content-frame-right-toggle"><span class="fa fa-bars"></span></button>
                        </div>
                    </div>
                    {{-- preloader page --}}
                    <div class="spinner-grow text-dark" role="status" id='loadingPreLoader' style="width:20rem; height:20rem; margin-left:35%; margin-right:35%; margin-top:10%;">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <!-- START CONTENT FRAME BODY -->
                    <div class="content-frame-body-left col-md-12" id="managerMaterials" style="display:none; padding-top:1rem;">

                        {{-- Circulares --}}
                        @include('gerenciamento.materials.components.circulares')

                        {{-- Roteiros --}}
                        @include('gerenciamento.materials.components.roteiros')

                        {{-- Materiais --}}
                        @include('gerenciamento.materials.components.materiais')

                        {{-- Videos --}}
                        @include('gerenciamento.materials.components.videos')

                       {{-- Calculadoras --}}
                       @include('gerenciamento.materials.components.calculadoras')

                    </div>
                </div>
            </div>

@endsection
@section('Javascript')
    @include('assets.js.manageMaterials')
    <script language="javascript">
    $(document).ready(function(){
        $("#loadingPreLoader").hide();
        $("#managerMaterials").show()

        //Exclui Funções .datatable
        // $('#DataTables_Table_0_paginate').remove()
        // $('#DataTables_Table_0_info').remove()
        // $("#DataTables_Table_0_length").remove()
        // $('#DataTables_Table_1_paginate').remove()
        // $('#DataTables_Table_1_info').remove()
        // $("#DataTables_Table_1_length").remove()
        // $('#DataTables_Table_2_paginate').remove()
        // $('#DataTables_Table_2_info').remove()
        // $("#DataTables_Table_2_length").remove()
        // $('#DataTables_Table_3_paginate').remove()
        // $('#DataTables_Table_3_info').remove()
        // $("#DataTables_Table_3_length").remove()
        // $('#DataTables_Table_4_paginate').remove()
        // $('#DataTables_Table_4_info').remove()
        // $("#DataTables_Table_4_length").remove()
    });
    </script>
@endsection
