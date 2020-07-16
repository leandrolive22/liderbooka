@extends('layouts.app', ["current"=>"adm"])
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
                              <li> <a href="{{route('GetUsersManager')}}"> Gerenciamento </a></li>
                            <li  href="{{route('GetUsersManager')}}" class="active">Administração</li>
                           </ul>
                           <!-- END BREADCRUMB -->


                        <!-- START CONTENT FRAME -->
                        <div class="content-frame">

                            <!-- START CONTENT FRAME TOP -->
                            <div class="content-frame-top">
                                <div class="page-title">
                                    <a href="{{url()->previous()}}"><h2><span class="fa fa-arrow-circle-o-left"></span> Incluir Calculadora</h2></a>
                                </div>
                                <div class="pull-right">
                                    <button class="btn btn-{{Auth::user()->css}} content-frame-right-toggle"><span class="fa fa-bars"></span></button>
                                </div>
                            </div>
                            <!-- END CONTENT FRAME TOP -->

                            <!-- START CONTENT FRAME RIGHT -->
                            @include('assets.components.updates')
                            <!-- END CONTENT FRAME RIGHT -->

                                                              <!-- START CONTENT FRAME BODY -->
                            <div class="content-frame-body content-frame-body-left">
                                <div class="panel panel-{{Auth::user()->css}}">


                                    <!-- START TIMELINE -->
                                    <div class="page-content-wrap" style='background-color:#f5f5f5 '>
                                        <!-- START TIMELINE -->
                                        <div class="timeline timeline-right">

                                            <!-- START TIMELINE ITEM -->
                                            <div class="form-row">
                                                <div class="panel border">
                                                    <div class="panel-body">
                                                        <form method="POST" enctype="multipart/form-data" class="form-horizontal" action="{{ route('PostCalculadorasStore', [ 'user' => Auth::user()->id ]) }}" id="calculadoras">
                                                        @csrf
                                                            {{-- Titulo / Assunto  --}}
                                                            <div class="form-group">
                                                                <label for="name">Título / Assunto</label>
                                                                <input type="text" name="name" class="form-control" id="name" placeholder="Título / Assunto">
                                                            </div>
                                                            {{-- Setor --}}
                                                            <div class="form-group">
                                                                <label for="setor_id">Setor</label>
                                                                <select class="form-control" id="setor_id" name="setor_id" onchange="getIlhas(this)">
                                                                    <option value="0">Selecione um Setor</option>
                                                        @forelse($setores as $setor)
                                                                    <option value="{{$setor->id}}">{{$setor->name}}</option>
                                                        @empty
                                                                    <option id="noMoreS">Nenhum Setor Encontrado</option>
                                                        @endforelse
                                                                </select>
                                                            </div>
                                                            {{-- Ilha --}}
                                                            <div class="form-group">
                                                                <label for="ilha_id">Ilha</label>
                                                                <select class="form-control" id="ilha_id" onchange="getSublocal()" name="ilha_id">
                                                                    <option value='0' id="noMoreI">Selecione a Ilha</option>
                                                                </select>
                                                            </div>
                                                            {{-- Sub - Local  --}}
                                                            {{-- <div class="form-group" id="divSubLocal">
                                                                <label for="sub_local_id">Categoria</label>
                                                                <select type="text" name="sub_local_id" class="form-control" id="sub_local_id">
                                                                </select>
                                                            </div> --}}
                                                            {{-- file input --}}
                                                            <input type="hidden" name="user" value="{{Auth::user()->id}}">
                                                            </div>
                                                            <div class="panel panel-default form-group">
                                                                <div class="panel-body">
                                                                    <h3><span class="fa fa-mail-forward"></span> Selecionar Calculadora</h3>
                                                                    <div class="form-group">
                                                                        <div class="col-md-12">
                                                                            <label>Selecione a Calculadora</label>
                                                                            <input type="file" class="" name="file" id="file" data-preview-file-type="any"/>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            {{-- btn submit --}}
                                                            <div class="form-group">
                                                                <button id="saveCalculadora" class="btn btn-warning col-md-12">Criar</button>
                                                            </div>
                                                        </form>
                                                    </div>
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
    <script type="text/javascript" id="CalculadorasJs">
        function getSublocal() {
            n = $("#ilha_id").val();
            $.getJSON('{{asset("api/forms/sublocais")}}/'+n,function(sub) {
                l = sub.length;
                if(l > 0) {
                    for(i=0; i < l; i++) {

                        option = '<option id="option" value="'+sub[i].id+'">'+sub[i].name+'</option>';

                        $("#sub_local_id").html(option)
                    }
                } else {
                    option = '<option value="0">Nenhum Sub-Local vinculado à esta Ilha</option>';
                    $("#sub_local_id").html(option)

                }
            });

        }

        function getIlhas(setor_id){
            $.getJSON('{{ asset("api/data/") }}/'+setor_id.value+'/ilha', function(ilha){
                l = ilha.length;
                if(l > 0) {
                    linha = '<option >Selecione a Ilha</option>'
                    for(i=0; i< l; i++) {
                        linha += '<option value="'+ilha[i].id+'">'+ilha[i].name+'</option>'
                    }
                    $("#noMoreI").hide();
                    $("#ilha_id").html(linha)
                } else {
                    option = '<option id="noMoreI">Nenhum Ilha Encontrada</option>'
                    $("#ilha_id").html(option)
                }
            });
        }

        function verify() {

                if($("#name").val() === '') {
                    $("#saveCalculadora").attr('type', 'button').html('Preencha o campo Título / Assunto')

                } else if($("#setor_id").val() === 0) {
                    $("#saveCalculadora").html('Escolha o Setor')

                } else if($("#ilha_id").val() === 0) {
                    $("#saveCalculadora").html('Selecione uma Ilha válida')

                // } else if($("#sub_local_id").val() === null) {
                //     $("#saveCalculadora").html('Selecione um Sub-Local válido')

                } else if($("#file").val() === '') {
                    $("#saveCalculadora").html('Selecione um arquivo válido')

                } else {
                    $("#saveCalculadora").attr('class','btn btn-primary col-md-12').attr('type','submit').html('Salvar Roteiro')
                    setTimeout(function() { verify() }, 5000)
                }
        }

        // function stop() {

        //     if( $("#name").val() != '' && $("#setor_id").val() != 0 && $("#ilha_id").val() != 0 && $("#sub_local_id").val() != null && $("#file").val() != '' ) {

        //     }
        // }

        $(document).ready(function(){
            setInterval(function() { verify() }, 500)

        })
    </script>
    @include('assets.js.file')
@endsection
