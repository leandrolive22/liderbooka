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
            <li><a href="{{asset('wiki/' . Auth::user()->ilha_id ) }}">Wiki</a></li>
            <li><a href="#">Videos</a></li>
        </ul>
        <!-- END BREADCRUMB -->

        <!-- PAGE TITLE -->
        <div class="page-title">
            <a href="{{url()->previous()}}"><h3><span class="fa fa-arrow-circle-o-left"></span> Videos</h3></a>
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
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Videos</h3>
                                        @if(in_array(Auth::user()->cargo_id,[1,3,21]))
                                        <a href="{{ route('GetVideosCreate') }}" class="btn btn-danger pull-right">Novo</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <table class="table datatable">
                                        <thead>
                                            <tr>
                                                <th>Nome</th>
                                                <th>Numero</th>
                                                <th>Data (ano/mês/dia)</th>
                                                <th>Vizualizar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($videos as $video)
                                            <tr id="linhaWiki{{$video->id}}"
                                            {{-- Variável de Controle  --}}
                                            @php
                                                $count = 0;
                                            @endphp

                                            {{-- Percorre laço que contem logs  --}}
                                            @forelse ($video->materialLog as $item)
                                                @if($item->user_id === Auth::id())
                                                    @php
                                                        $count++;
                                                    @endphp
                                                @endif
                                            @empty
                                                class="trRed"
                                            @endforelse
                                            {{-- mostra visualizado --}}
                                            @if($count > 0)
                                                class="trGreen" 
                                            @else 
                                                class="trRed"
                                            @endif
                                            >
                                                <td> {{ $video->name }}</td>
                                                <td>{{ $video->id }}</td>
                                                <td>{{ implode('/',(explode('-',explode(' ',$video->updated_at)[0]))) }}</td>
                                                <td class="btn-group btn-group-xs">
                                                    <button id="btnOpen{{$video->id}}" onclick="openMaterial({{$video->id}},'{{asset($video->file_path)}}','VIDEO')" class="btn btn-primary">Abrir</button>

                                                    {{-- Visivel apenas para treinamento e devs  --}}
                                                    @if(!in_array(Auth::user()->cargo_id, [4,5]))
                                                    {{-- Botão para gerar relatório  --}}
                                                    <button onclick='window.location.href="{{asset('manager/report/VIDEO/'.$video->id)}}"'  class="btn btn-default">Relatório</button>
                                                    {{-- Botão de edição  --}
                                                    <button class="btn btn-warning">Editar</button>
                                                    {{-- Botão de exclusão  --}}
                                                    <button class="btn btn-danger" id="deleteMaterial{{$video->id}}" onclick="deleteMaterial({{$video->id}})">Excluir</button>
                                                    @endif

                                                </td>
                                            </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
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

@section('assinatura')
@include('assets.js.assinatura-Js')
@endsection

@section('ChartsUpdates')
<script type="text/javascript">
    // Deleta material
    function deleteMaterial(id) {
        $("#deleteMaterial"+id).prop('disabled',true)
        $("#deleteMaterial"+id).html('<span class="fa fa-spinner fa-spin"></span>');
        noty({
            text: 'Deseja excluir o Video?',
            layout: 'topRight',
            buttons: [
                    {addClass: 'btn btn-success', text: 'Excluir', onClick: function($noty) {
                        $.ajax({
                            type: 'DELETE',
                            url: "{{asset('/manager/video/delete')}}/"+id+"/{{ Auth::user()->id }}",
                            success: function(xhr) {
                                $("#linhaWiki"+id).hide()
                                $("#linhaWiki"+id).remove()
                                $noty.close();
                                noty({text: 'Video excluído com sucesso.', layout: 'topRight', type: 'success', timeout: '3000'});
                            },
                            error: function(xhr,status) {
                                $noty.close();
                                noty({text: 'Erro ao excluir video. <br>Tente novamente mais tarde', layout: 'topRight', type: 'error', timeout: '3000'});
                                console.log(xhr)
                            }
                        });
                        $("#deleteMaterial"+id).html('Excluir')
                        $("#deleteMaterial"+id).prop('disabled',false)
                        $("#deleteMaterial"+id).prop('enabled',true)
                    }
                    },
                    {addClass: 'btn btn-danger btn-clean', text: 'Cancelar', onClick: function($noty) {
                            $noty.close();
                        }
                    },
                ]
        });
    }

</script>

@endsection