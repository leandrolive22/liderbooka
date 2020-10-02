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
            <li><a href="{{asset('/wiki/' . Auth::user()->ilha_id )}}">Wiki</a></li>
            <li><a>Circulares</a></li>
        </ul>
        <!-- END BREADCRUMB -->


        <!-- PAGE TITLE -->
        <div class="page-title">
            <a href="{{url()->previous()}}"><h3><span class="fa fa-arrow-circle-o-left"></span> Circulares</h3></a>
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
                                        <h3 class="panel-title">Circulares</h3>
                                        @if(in_array(Auth::user()->cargo_id,[1,3,21]))
                                        <a href="{{ route('GetCircularesCreate') }}" class="btn btn-danger pull-right">Novo</a>
                                        @endif
                                    </ul>
                                </div>
                                <div class="panel-body">
                                    <table class="table datatable">
                                        <thead>
                                            <tr>
                                                <th>Nome</th>
                                                <th>Numero</th>
                                                <th>Data (ano/mês/dia)</th>
                                                {{-- <th>Ilha</th> --}}
                                                <!-- <th>Segmento</th> -->
                                                <th>Status</th>
                                                <th>Vizualizar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($circulares as $circular)
                                            <tr id="linhaWiki{{$circular->id}}"
                                                {{-- Variável de Controle  --}}
                                                @php
                                                    $count = 0;
                                                @endphp

                                                {{-- Percorre laço que contem logs  --}}
                                                @forelse ($circular->materialLog as $item)
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
                                                <td> {{ $circular->name }}</td>
                                                <td>{{ $circular->number }}</td>
                                                <td>{{ implode('/',(explode('-',explode(' ',$circular->updated_at)[0]))) }}
                                                </td>
                                                {{-- <td>{{ $circular->Ilha->name }}</td> --}}
                                                {{-- <td>{{ $circular->subLocal }}</td> --}}
                                                <td>{{ $circular->status}}</td>
                                                <td class="btn-group btn-group-xs">
                                                    <button id="btnOpen{{$circular->id}}" onclick="openMaterial({{$circular->id}},'{{asset($circular->file_path)}}','CIRCULAR');" class="btn btn-primary">Abrir </button>
                                                    @if(!in_array(Auth::user()->cargo_id, [4,5]))
                                                    <button onclick='window.location.href="{{asset('manager/report/CIRCULAR/'.$circular->id)}}"' class="btn btn-default">Relatório</button>
                                                    {{-- Botão de edição  --}
                                                     <button class="btn btn-warning">Editar</button>
                                                    {{-- Botão de exclusão  --}}
                                                    <button class="btn btn-danger" id="deleteMaterial{{$circular->id}}" onclick="deleteMaterial({{$circular->id}})">Excluir</button>
                                                    @endif

                                                </td>
                                                <!-- Fim Modal  -->
                                            </tr>
                                            @empty
                                            <tr><td colspan="7">Nenhuma Circular Encontrada</td></tr>
                                            @endforelse
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
<!-- END DEFAULT DATATABLE -->
@endsection

@section('assinatura')
@include('assets.js.assinatura-Js')
@endsection

@section('Javascript')
<!-- END MESSAGE BOX-->
<script type="text/javascript">
function deleteMaterial(id) {
    $("#deleteMaterial"+id).prop('disabled',true)
    $("#deleteMaterial"+id).html('<span class="fa fa-spinner fa-spin"></span>');
    noty({
        text: 'Deseja excluir o Circular?',
        layout: 'topRight',
        buttons: [
                {addClass: 'btn btn-success', text: 'Excluir', onClick: function($noty) {
                    $noty.close();
                    $.ajax({
                        type: 'DELETE',
                        url: "{{asset('/manager/circular/delete')}}/"+id+"/{{ Auth::user()->id }}",
                        success: function(xhr) {
                            $("#linhaWiki"+id).hide()
                            $("#linhaWiki"+id).remove()
                            noty({text: 'Circular excluída com sucesso.', layout: 'topRight', type: 'success', timeout: '3000'});
                        },
                        error: function(xhr,status) {
                            $("#deleteMaterial"+id).html('Excluir')
                            $("#deleteMaterial"+id).prop('disabled',false)
                            $("#deleteMaterial"+id).prop('enabled',true)
                            noty({text: 'Erro ao excluir circular. <br>Tente novamente mais tarde', layout: 'topRight', type: 'error', timeout: '3000'});
                            console.log(xhr)
                        }
                    });
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

@section('assinatura')
@include('assets.js.assinatura-digitalJs')
@endsection
