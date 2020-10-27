@extends('layouts.app', ["current"=>"wiki"])
@section('style')
<style type="text/css">
    /**
    * jQuery Flexdatalist basic stylesheet.
    *
    * Version:
    * 2.2.1
    *
    * Github:
    * https://github.com/sergiodlopes/jquery-flexdatalist/
    *
    */
    .flexdatalist-results {
        position: absolute;
        top: 0;
        left: 0;
        border: 1px solid #444;
        border-top: none;
        background: #fff;
        z-index: 100000;
        max-height: 300px;
        overflow-y: auto;
        box-shadow: 0 4px 5px rgba(0, 0, 0, 0.15);
        color: #333;
        list-style: none;
        margin: 0;
        padding: 0;
    }
    .flexdatalist-results li {
        border-bottom: 1px solid #ccc;
        padding: 8px 15px;
        font-size: 14px;
        line-height: 20px;
    }
    .flexdatalist-results li span.highlight {
        font-weight: 700;
        text-decoration: underline;
    }
    .flexdatalist-results li.active {
        background: #2B82C9;
        color: #fff;
        cursor: pointer;
    }
    .flexdatalist-results li.no-results {
        font-style: italic;
        color: #888;
    }

    /**
    * Grouped items
    */
    .flexdatalist-results li.group {
        background: #F3F3F4;
        color: #666;
        padding: 8px 8px;
    }
    .flexdatalist-results li .group-name {
        font-weight: 700;
    }
    .flexdatalist-results li .group-item-count {
        font-size: 85%;
        color: #777;
        display: inline-block;
        padding-left: 10px;
    }

    /**
    * Multiple items
    */
    .flexdatalist-multiple:before {
        content: '';
        display: block;
        clear: both;
    }
    .flexdatalist-multiple {
        width: 100%;
        margin: 0;
        padding: 0;
        list-style: none;
        text-align: left;
        cursor: text;
    }
    .flexdatalist-multiple.disabled {
        background-color: #eee;
        cursor: default;
    }
    .flexdatalist-multiple:after {
        content: '';
        display: block;
        clear: both;
    }
    .flexdatalist-multiple li {
        display: inline-block;
        position: relative;
        margin: 5px;
        float: left;
    }
    .flexdatalist-multiple li.input-container,
    .flexdatalist-multiple li.input-container input {
        border: none;
        height: auto;
        padding: 0 0 0 4px;
        line-height: 24px;
    }

    .flexdatalist-multiple li.value {
        display: inline-block;
        padding: 2px 25px 2px 7px;
        background: #eee;
        border-radius: 3px;
        color: #777;
        line-height: 20px;
    }
    .flexdatalist-multiple li.toggle {
        cursor: pointer;
        transition: opacity ease-in-out 300ms;
    }
    .flexdatalist-multiple li.toggle.disabled {
        text-decoration: line-through;
        opacity: 0.80;
    }

    .flexdatalist-multiple li.value span.fdl-remove {
        font-weight: 700;
        padding: 2px 5px;
        font-size: 20px;
        line-height: 20px;
        cursor: pointer;
        position: absolute;
        top: 0;
        right: 0;
        opacity: 0.70;
    }
    .flexdatalist-multiple li.value span.fdl-remove:hover {
        opacity: 1;
    }
    .btn.btn-dark.btn-lg.active{
        width:200px;
        border-radius: 30px 10px;
    }
    button{
        width:200px;
        border-radius: 30px 10px;
    }
    .btn.btn-danger.btn-lg{
        width:200px;

        border-radius: 30px 10px;
    }
    .btn.btn-primary.btn-lg{
        border-radius: 30px 10px;
    }
    .card-header{
        height: 5rem; text-align:center;font-size:20px;
    }
    h4{
        text-align:center;
        font-size:20px;
    }
    h5{
        font-size:20px;
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
						<h2><span class="fa fa-arrow-circle-o-left"></span> Wiki</h2>
					</a>
				</div>
			
				<!-- END CONTENT FRAME TOP -->

			</div>
			<!-- END CONTENT FRAME TOP-->

			<!-- START CONTENT FRAME RIGHT -->
			@include('assets.components.hashtags')
			<!-- END CONTENT FRAME RIGHT -->

			<!-- START CONTENT FRAME LEFT -->

			<div class="content-frame-body content-frame-body-left">
					<div class="panel panel-colorful">
                     {{-- Inicio Grupo Hashtags e Destaque Mes --}}
                        <div class="card-group">
                                          {{-- Inicio Hashtags --}}
                          <div style=" border-radius: 5px 10px 20px 30px; width:410px; height:200px;" class="form-control" >
                           <a>  #preventivo </a> 
                          </div>
                                        {{-- Fim Hashtags --}}

                                         {{-- Inicio Destaque Mes --}}
                           <div style="width:330px;" class="container text-center my-3">
                               <h5>Colaboradores Em Destaque Outubro</h5>
                                <div id="recipeCarousel" class="carousel slide w-100" data-ride="carousel">
                                    <div class="carousel-inner w-100" role="listbox">
                                        <div class="carousel-item row no-gutters active p-1">
                                            
                                            <div class="col-3 float-left"><img class="img-fluid" src="{{ asset(Auth::user()->avatar) }}" > 
                                            <img class="img-fluid" style="width:40px;"src="storage/img/medalhas/1medalha.png" > 
                                             <h5>{{ Auth::user()->name }}</h5> 
                                            </div>
                                            <div class="col-3 float-left"><img class="img-fluid" src="{{ asset(Auth::user()->avatar) }}" > 
                                            <img class="img-fluid" style="width:40px;"src="storage/img/medalhas/2medalha.png" > 
                                             <h5>{{ Auth::user()->name }}</h5> 
                                            </div>
                                            <div class="col-3 float-left"><img class="img-fluid" src="{{ asset(Auth::user()->avatar) }}" > 
                                            <img class="img-fluid" style="width:40px;"src="storage/img/medalhas/3medalha.png" > 
                                             <h5>{{ Auth::user()->name }}</h5> 
                                            </div>
                                            <div class="col-3 float-left"><img class="img-fluid" src="{{ asset(Auth::user()->avatar) }}" > 
                                            <img class="img-fluid" style="width:40px;"src="storage/img/medalhas/medalhabronze.png" > 
                                             <h5>{{ Auth::user()->name }}</h5> 
                                            </div>
                                       </div>
                            
                                    </div>
                                    <a class="carousel-control-prev" href="#recipeCarousel" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#recipeCarousel" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>                  
                           </div>
                           {{-- Fim Destaque Mes --}}

                  </div>
			  </div>
                                  {{-- Fim Grupo Hashtags e Destaque Mes --}}


            {{-- Inicio Materiais --}}
         <div class="row">
            <div style="padding-top:40px;" class="panel panel-colorful text-center">
                <h3 style="text-align:center;font-size:20px;"><strong>  Tipos de Materiais  </strong></h3>
                <a href="#" class="btn btn-dark btn-lg active" role="button" aria-pressed="true">Roteiros</a>
                <a href="#" class="btn btn-dark btn-lg active" role="button" aria-pressed="true">Comunicados</a>
                <a href="#" class="btn btn-dark btn-lg active" role="button" aria-pressed="true">Vídeos</a>
                <a href="#" class="btn btn-dark btn-lg active" role="button" aria-pressed="true">Materiais</a>
            </div>

            {{-- Fim Materiais --}}

            {{-- Inicio Categorias --}}

            <div style="padding-top:40px;" class="panel panel-colorful text-center">
                <h3 style="text-align:center;font-size:20px;"><strong>  Categorias  </strong></h3>
                <button type="button" class="btn btn-primary btn-lg">Unificado</button>
                <button type="button" class="btn btn-primary btn-lg">Cartões</button>
                <button type="button" class="btn btn-danger btn-lg">Próspera</button>
                <button type="button" class="btn btn-danger btn-lg">Atendimento</button>
            </div>

            {{-- Fim Categorias --}}

	</div>
</div>
<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->
@endsection
@section('Javascript')
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>



</script>

@endsection
