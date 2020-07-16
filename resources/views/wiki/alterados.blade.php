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
            <li><a>Circulares</a></li>
        </ul>
        <!-- END BREADCRUMB -->


        <!-- PAGE TITLE -->
        <div class="page-title">
            <h3><span class="fa fa-arrow-circle-o-left"></span> Alterados</h3>
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
                                        <h3 class="panel-title">Alterados</h3>
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
                                            <tbody>
                                                @foreach ($circulares as $circular)
                                                <tr>
                                                    <td> {{ $circular->name }}</td>
                                                    <td>{{ $circular->number }}</td>
                                                    <td>{{ implode('/',(explode('-',explode(' ',$circular->updated_at)[0]))) }}
                                                    </td>
                                                    <td>{{ $circular->Ilha->name }}</td>
                                                    <td>{{ $circular->subLocal->name }}</td>
                                                    <td>{{ $circular->status}}</td>
                                                    <td>
                                                        {{-- gera hash --}}
                                                        @php
                                                        $assinatura = md5(date('Y-m-d
                                                        H:i:s').'_'.Auth::user()->id.'_'.$circular->id.'_'.Auth::user()->name);
                                                        @endphp
                                                        <a type="button"
                                                            onclick="$('#id{{$circular->id}}').show();signatureHash({{$circular->id}},'{{$assinatura}}');"
                                                            class="btn btn-info btn-rounded">Abrir</a>
                                                        {{-- Modal --}}
                                                        <div id='id{{$circular->id}}' class="w3-modal">
                                                            <div style="width: 880px; height: 490px;"
                                                                class="w3-modal-content w3-animate-zoom">
                                                                <header style="width: 880px; height: 35px;"
                                                                    class="w3-container w3-green">
                                                                    <h4
                                                                        style="text-align: center; padding-top: 10px; color: black;">
                                                                        Circular
                                                                    </h4>
                                                                </header>
                                                                <br>
                                                                <div style="width: 100%; height:100%;;"
                                                                    class="w3-container">
                                                                    <embed src="{{ asset($circular->file_path) }}"
                                                                        frameborder="0" width="100%" height="75%">
                                                                    @component('assets.components.assinatura-digital',["material"=>$circular, "type"=>"CIRCULAR"  ])
                                                                    @endcomponent
                                                                </div>
                                                            </div>

                                                        </div>
                                                        {{-- ./Modal --}}
                                    </div>
                                </div>
                                </td>
                                <!-- Fim Modal  -->
                                </tr>
                                @endforeach
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
<script>
    $(document).ready(function(){

                        $.getJSON('{{ route("GetCountCirculares",["ilha" => Auth::user()->ilha_id]) }}',function(data){
                            $("#CircularesBtn").html(data)
                        })

                    });
                    $(document).ready(function(){

                        $.getJSON('{{ route("GetCountRoteiros",["ilha" => Auth::user()->ilha_id]) }}',function(data){
                            $("#RoteirosBtn").html(data)
                        })

                    });
</script>

@endsection

@section('assinatura')
@include('assets.js.assinatura-digitalJs')
@endsection
