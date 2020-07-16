@extends('layouts.app', ["current"=>"home"])
@section('content')

<!-- START PAGE CONTAINER -->
<div class="page-container">

    <!-- PAGE CONTENT -->
    <div class="page-content">

        @component('assets.components.x-navbar')
        @endcomponent

        <!-- START BREADCRUMB -->
        <ul class="breadcrumb">
            <li><a href="#">Menu</a></li>
            <li class="active">Home</li>
        </ul>
        <!-- END BREADCRUMB -->
        <div class="text-center" id="preloaderPage" style="width:100%; padding: 20% ">
            <div class="spinner-grow text-primary" role="status" style="width: 18rem; height: 18rem">
                <span class="sr-only"></span>
            </div>
        </div>

        <!-- START CONTENT FRAME -->
        <div class="content-frame" id="homePage" style="display:none">

            <!-- START CONTENT FRAME TOP -->
            <div class="content-frame-top">
                <div class="page-title">
                    <a href="{{url()->previous()}}">
                        <h2>
                            <span class="fa fa-arrow-circle-o-left"></span> Linha do tempo
                        </h2>
                    </a>
                </div>
                <div class="pull-right">
                    <button class="btn btn-{{Auth::user()->css}} content-frame-right-toggle"><span
                            class="fa fa-bars"></span></button>
                </div>
            </div>
            <!-- END CONTENT FRAME TOP -->
            {{-- ilha_id 48 = Marketing --}}
            @if( in_array(Auth::user()->cargo_id, [1,2,3,9]) || Auth::user()->ilha_id == 48 )
            @include('assets.components.postForm')
            @else

            @endif
            <!-- START CONTENT FRAME RIGHT -->
            @include('assets.components.updates')
            <!-- END CONTENT FRAME RIGHT -->

            <!-- START CONTENT FRAME BODY -->

            <div class="content-frame-body content-frame-body-left">
                <div class="panel panel-default">


                    <!-- Altere o cargo_id para 1 para ver novo modelo de timeline -->
                    @if(Auth::user()->cargo_id == 0)
                    <div class="page-content-wrap bg-light @if(Auth::user()->cargo_id == 1) col-md-4 pull-left @endif">
                        <div class="panel-body" style="height: 10000px">
                            <div class="panel-heading">
                                <h3>Canal Liderança</h3>
                            </div>
                            <div class="panel-body">
                                Em breve...
                            </div>
                        </div>
                    </div>
                    @endif
                    <!-- START TIMELINE -->
                        {{-- Altere o cargo_id para 1 para ver novo modelo de timeline  --}}
                    <div class="page-content-wrap bg-light @if(Auth::user()->cargo_id == 0) col-md-8 pull-right @endif">
                        <!-- START TIMELINE -->
                        <div class="timeline timeline-right">
                            <ul type='none' style="padding:0px;">
                                <!-- START TIMELINE ITEM -->
                                <div class="timeline-item timeline-main">
                                    <div class="timeline-date" id='lastPostDate'>
                                        Até agora
                                    </div>
                                </div>
                                <!-- END TIMELINE ITEM -->

                                <!-- START TIMELINE ITEM -->
                                <div id='Posts'></div>
                                <!-- END TIMELINE ITEM -->

                                <!-- START TIMELINE ITEM -->
                                <div class="timeline-item timeline-main">
                                    <div class="timeline-date">

                                        <a onclick="carregarPosts(); $('#loading_posts').show(); $('#content_loading').hide()"
                                            id='content_loading' class="btn col-md-12">
                                            <span class="fa fa-ellipsis-h"></span>
                                        </a>

                                        <div class="spinner-grow text-dark" role="status" id='loading_posts'
                                            style="display:none">
                                            <span class="sr-only">Loading...</span>
                                        </div>

                                    </div>
                                </div>
                                <!-- END TIMELINE ITEM -->
                            </ul>
                        </div>

                        <a href="#" id="top" class='btn btn-{{Auth::user()->css}}' style='float:right; margin:2%;'><i
                                class="fa fa-arrow-up"> Voltar ao Topo</i></a>
                        <div>
                            <!-- END TIMELINE -->



                        </div>
                    </div>
                    <!-- END CONTENT FRAME BODY -->
                </div>
                <!-- END CONTENT FRAME -->

            </div>
        </div>

        <div class="row">
            <div class="col-md-8">

            </div>
            <div class="common-modal modal fade" id="common-Modal1" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-content">
                    <ul class="list-inline item-details">
                        <li><a
                                href="http://themifycloud.com/downloads/janux-premium-responsive-bootstrap-admin-dashboard-template/">Admin
                                templates</a></li>
                        <li><a href="http://themescloud.org">Bootstrap themes</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-4">

            </div>
        </div>

        <!-- START DASHBOARD CHART -->
        <div class="chart-holder" id="dashboard-area-1" style="height: 200px;"></div>
        <div class="block-full-width">

        </div>
        <!-- END DASHBOARD CHART -->

    </div>
    <!-- END PAGE CONTENT WRAPPER -->
</div>
<!-- END PAGE CONTENT -->
@endsection
@section('PostsScript')
@include('assets.js.homeJs')
@endsection
