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
    h2{
        color:black;
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
                    <h2><span class="fa fa-image"></span> Categorias </h2>
					</a>
				</div>
			
				<!-- END CONTENT FRAME TOP -->

		   <!-- START CONTENT FRAME -->
           <div class="content-frame">   
                    
            <!-- START CONTENT FRAME TOP -->
            <div class="content-frame-top">                                                         
                <div class="text-center">                            
                    <button class="btn btn-primary">{{$type}}</button>
                    <button class="btn btn-default content-frame-right-toggle"><span class="fa fa-bars"></span></button>
                </div>                         
            </div>
            
        
        
            <!-- START CONTENT FRAME BODY -->
            <div class="content-frame-body content-frame-body-left">       
                <div class="gallery" id="links" style="float:center; width:150%;">
                     <div class="row">
                        <div class="image">                              
                            <iframe width="320" height="145"
                            src="https://www.youtube.com/embed/tgbNymZ7vqY">
                            </iframe>                                                                                 
                        </div>
                        <div class="image">                              
                            <iframe width="320" height="145"
                            src="https://www.youtube.com/embed/tgbNymZ7vqY">
                            </iframe>                                                                                 
                        </div>

                        <div class="image">                              
                            <iframe width="320" height="145"
                            src="https://www.youtube.com/embed/tgbNymZ7vqY">
                            </iframe>                                                                                 
                        </div>

                        <div class="image">                              
                            <iframe width="320" height="145"
                            src="https://www.youtube.com/embed/tgbNymZ7vqY">
                            </iframe>                                                                                 
                        </div>

                        <div class="image">                              
                            <iframe width="320" height="145"
                            src="https://www.youtube.com/embed/tgbNymZ7vqY">
                            </iframe>                                                                                 
                        </div>

                        <div class="image">                              
                            <iframe width="320" height="145"
                            src="https://www.youtube.com/embed/tgbNymZ7vqY">
                            </iframe>                                                                                 
                        </div>
                        
                    </div>      
                </div>
            </div>       
            <!-- END CONTENT FRAME BODY -->
        </div>               
        <!-- END CONTENT FRAME -->
                        
<!-- END PAGE CONTAINER -->
@endsection
@section('Javascript')
        <!-- START THIS PAGE PLUGINS-->        
        <script type='text/javascript' src='js/plugins/icheck/icheck.min.js'></script>
        <script type="text/javascript" src="js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
        
        <script type="text/javascript" src="js/plugins/blueimp/jquery.blueimp-gallery.min.js"></script>
        <script type="text/javascript" src="js/plugins/dropzone/dropzone.min.js"></script>
        <script type="text/javascript" src="js/plugins/icheck/icheck.min.js"></script>
        <!-- END THIS PAGE PLUGINS-->        
        <script>            
            document.getElementById('links').onclick = function (event) {
                event = event || window.event;
                var target = event.target || event.srcElement;
                var link = target.src ? target.parentNode : target;
                var options = {index: link, event: event,onclosed: function(){
                        setTimeout(function(){
                            $("body").css("overflow","");
                        },200);                        
                    }};
                var links = this.getElementsByTagName('a');
                blueimp.Gallery(links, options);
            };
        </script>        

@endsection
