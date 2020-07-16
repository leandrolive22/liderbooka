@extends('layouts.app', ["current"=>"wiki"])
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
            <li><a href="{{asset('/')}}">Home</a></li>
            <li><a href="{{asset('/wiki')}}">Wiki</a></li>
            <li><a>Lidos</a></li>
        </ul>
        <!-- END BREADCRUMB -->


        <!-- PAGE TITLE -->
        <div class="page-title">
            <h3><span class="fa fa-arrow-circle-o-left"></span> Lidos</h3>
        </div>
        <!-- END PAGE TITLE -->

        <!-- PAGE CONTENT WRAPPER -->
        <div class="page-content-wrap">

            <div class="row">
                <div class="col-md-12">

                    <!-- START WIKI BUSCA FILTER -->


                    @component('assets.components.wikiSearch')
                    @endcomponent

                    <!-- END WIKI BUSCA FILTER -->

                    <!-- PAGE CONTENT WRAPPER -->
                    <div class="page-content-wrap">

                        <div class="row">
                            <div class="col-md-12">

                                <!-- START DEFAULT DATATABLE -->
                                <div style=" width: 200%;" class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Lidos</h3>
                                        </ul>
                                    </div>
                                    <div class="panel-body">
                                        <table class="table datatable">
                                            <thead>
                                                <tr>
                                                    <th>Nome</th>
                                                    <th>Numero</th>
                                                    <th>Data (ano/mês/dia)</th>
                                                    <th>Ilha</th>
                                                    <th>Segmento</th>
                                                    <th>Status</th>
                                                    <th>Vizualizar</th>
                                                </tr>
                                            </thead>
                                            <tbody id="Lidos">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END DEFAULT DATATABLE -->
        @endsection
        @section('Javascript')
        <!-- END MESSAGE BOX-->
        <script type="text/javascript">
            function GetLidos(data) {
                var  id = 'id'+data.id
                var  linha = "<tr>"
                                '<td> '+ data.name +' </td>'+
                                '<td> '+ data.number +' </td>'+
                                '<td>' + data.updated_at + ' '+
                                '</td>'+
                                '<td> '+ data.Ilha.name +' </td>'+
                                '<td> '+ data.subLocal.name +' </td>'+
                                '<td> '+ data.status +'</td>'+
                                '<td>'+
                                    '{{-- gera hash --}}'+
                                    '<a type="button"'+
                                        'onclick="$(#'+id+').show();signatureHash('+data.id+',assinatura);"'+
                                        'class="btn btn-info btn-rounded">Abrir</a>'+
                                    '{{-- Modal --}}'+
                                    '<div id="id'+data.id+'" class="w3-modal">'+
                                        '<div style="width: 880px; height: 490px;"'+
                                            'class="w3-modal-content w3-animate-zoom">'+
                                            '<header style="width: 880px; height: 35px;"'+
                                                'class="w3-container w3-green">'+
                                                '<h4'+
                                                    'style="text-align: center; padding-top: 10px; color: black;">'+
                                                    'Circular'+
                                                '</h4>'+
                                            '</header>'+
                                            '<br>'+
                                            '<div style="width: 100%; height:100%;;"'+
                                                'class="w3-container">'+
                                                '<embed src=" asset(data.file_path) "'+
                                                    'frameborder="0" width="100%" height="75%">'+
                                                    '<div class="form-check col-md-12" id="material $material->id">'+
                                                                            '</div>'+
                                            '<input type="hidden" id="typeMaterials$material->id" value="$type">'+

                                            '</div>'+
                                        '</div>'+
                                        '</td>'+
                                    '<tr>';
            }

            function getLidos() {
                $.getJSON('{{ route("GetLogsCheckread",["user" => Auth::user()->id, 'type' =>"circular"]) }}',function(data){

                    for (i=0; i < data.lenght; i++){
                        $("#Lidos").html(Lidos(data[i]))

                        console.log(data)
                        return data;
                    }
                })
            }

            $(function(){
                $.getJSON('{{ route("GetCountCirculares",["ilha" => Auth::user()->ilha_id]) }}',function(data){
                    $("#CircularesBtn").html(data)
                })

                $.getJSON('{{ route("GetCountRoteiros",["ilha" => Auth::user()->ilha_id]) }}',function(data){
                    $("#RoteirosBtn").html(data)
                })

            });
        </script>
        @endsection
        @section('assinatura')
        @include('assets.js.assinatura-digitalJs')
        @endsection
