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
            <li><a href="#">{{$titlePage}}</a></li>
        </ul>
        <!-- END BREADCRUMB -->

        <!-- PAGE TITLE -->
        <div class="page-title">
            <a href="{{url()->previous()}}"><h3><span class="fa fa-arrow-circle-o-left"></span> {{$titlePage}}</h3></a>
        </div>
        <!-- END PAGE TITLE -->

        <!-- PAGE CONTENT WRAPPER -->
        <div class="page-content-wrap">

            <div class="row">
                <div class="col-md-12">
                    <!-- START WIKI BUSCA FILTER -->
                    @component('assets.components.wikiSearch', ['type' => $type, 'titlePage' => $titlePage])
                    @endcomponent
                    <!-- END WIKI BUSCA FILTER -->

                    <!-- PAGE CONTENT WRAPPER -->
                    <div class="page-content-wrap">

                        <div class="row">
                            <div class="col-md-12">

                                <!-- START DEFAULT DATATABLE -->
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">{{$titlePage}}</h3>
                                        @if(in_array(1,session('permissionsIds')) || in_array(38,session('permissionsIds')))
                                        <a href="{{ route('GetMateriaisCreate') }}" class="btn btn-danger pull-right">Novo</a>
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
                                                <th>Vizualizar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($result as $item)
                                            <tr id="linhaWiki{{$item->id}}"
                                                {{-- Variável de Controle  --}}
                                                @php
                                                    $count = 0;
                                                @endphp

                                                {{-- Percorre laço que contem logs  --}}
                                                @forelse ($item->materialLog as $log)
                                                    @if($log->user_id === Auth::id())
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
                                                <td> {{ $item->name }}</td>
                                                <td>{{ $item->id }}</td>
                                                <td>{{ implode('/',(explode('-',explode(' ',$item->updated_at)[0]))) }}
                                                </td>
                                                {{-- <td>{{ $item->subLocal->name }}</td> --}}
                                                <td class="btn-group btn-group-xs">
                                                    <button id="btnOpen{{$item->id}}" onclick="openMaterial({{$item->id}},'{{asset($item->file_path)}}','MATERIAL')" class="btn btn-primary">Abrir</button>
                                                    @if(in_array(1,session('permissionsIds')) || in_array(41, session('permissionsIds')))
                                                    {{-- Botão para gerar relatório  --}}
                                                    <button onclick='window.location.href="{{asset('manager/report/'.$type.'/'.$item->id)}}"'  class="btn btn-default">Relatório</button>
                                                    @endif
                                                    @if(in_array(1,session('permissionsIds')) || in_array(39, session('permissionsIds')))
                                                    {{-- Botão de edição  --}
                                                    <button class="btn btn-warning">Editar</button>
                                                    {{-- Botão de exclusão  --}}
                                                    @endif
                                                    @if(in_array(1,session('permissionsIds')) || in_array(40, session('permissionsIds')))
                                                        <button class="btn btn-danger" id="deleteMaterial{{$item->id}}" onclick="deleteMaterial({{$item->id}})">Excluir</button>
                                                    @endif
                                                </td>
                                                <!-- Fim Modal  -->
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="4" class="text-center">Nenhum dado Encontrado</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- Modal -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- END MESSAGE BOX-->
@endsection

@section('assinatura')
@include('assets.js.assinatura-Js')
@endsection

@section('Javascript')
<script lang="javascript">
    function deleteMaterial(id) {

        @if(strtoupper($type) === 'MATERIAL')
            url = "{{asset('/manager/material/delete')}}/"
        @elseif(strtoupper($type) === 'VIDEO')
            url = "{{asset('/manager/video/delete')}}/"
        @elseif(strtoupper($type) === 'SCRIPT')
            url = "{{asset('/manager/script/delete')}}/"
        @elseif(strtoupper($type) === 'CIRCULAR')
            url = "{{asset('/manager/cirular/delete')}}/"
        @endif

        $("#deleteMaterial"+id).prop('disabled',true)
        $("#deleteMaterial"+id).html('<span class="fa fa-spinner fa-spin"></span>');
        noty({
            text: 'Deseja excluir o Material?',
            layout: 'topRight',
            buttons: [
                    {addClass: 'btn btn-success', text: 'Excluir', onClick: function($noty) {
                        $noty.close();
                        $.ajax({
                            type: 'DELETE',
                            url: url+id+"/{{ Auth::user()->id }}",
                            success: function(xhr) {
                                $("#linhaWiki"+id).hide()
                                $("#linhaWiki"+id).remove()
                                noty({text: '{{$titlePage}} excluído com sucesso.', layout: 'topRight', type: 'success', timeout: '3000'});
                            },
                            error: function(xhr,status) {
                                $("#deleteMaterial"+id).html('Excluir')
                                $("#deleteMaterial"+id).prop('disabled',false)
                                $("#deleteMaterial"+id).prop('enabled',true)
                                noty({text: 'Erro ao excluir material. <br>Tente novamente mais tarde', layout: 'topRight', type: 'error', timeout: '3000'});
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



<!-- END MESSAGE BOX-->
@endsection

@section('assinatura')
@include('assets.js.assinatura-Js')
@endsection
