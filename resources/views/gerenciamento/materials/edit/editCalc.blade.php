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
                <!-- START CONTENT FRAME BODY -->
                <div class="content-frame-body-left">
                    <div class="panel panel-{{Auth::user()->css}}">
                        <!-- START DEFAULT -->
                        <div class="panel panel-default">
                            <div class="panel-heading">                                
                                <h3 class="panel-title">Editar calculadora <strong>{{$calculadora['name']}}</strong></h3>
                                <ul class="panel-controls">
                                    <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a></li>
                                </ul>                                
                            </div>
                            <div class="panel-body">
                                <form enctype="multipart/form-data" method="POST" action="{{ route('saveFileCalc',['user' => Auth::user()->id] ) }}">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$calculadora->id}}">
                                    <input type="hidden" name="ilha" value="{{$calculadora->ilha_id}}">
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label>Selecione o arquivo em <strong>BROWSE</strong> e clique em <strong>UPLOAD</strong></label>
                                            <input type="file" name="file" class="file" data-preview-file-type="any"/>
                                        </div>
                                    </div>                                       
                                </form>
                                @if($errors)
                                    <script type="text/javascript">
                                       console.log("{{$errors}}")
                                    </script>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('Javascript')
    <script type="text/javascript">
        function getIlhaName(id,local) {
            $.getJSON('{{asset("/")}}api/data/ilha/'+id,function(data){
                $("#ilhaName"+local).html(data[0].name);
            });
        }

        function getSetorName(id,local) {
            $.getJSON('{{asset("/")}}api/data/setores/'+id,function(data){
                $("#getSetorName"+local).html(data.name);
            });
        }
        
    </script>
    @include('assets.js.file')
@endsection