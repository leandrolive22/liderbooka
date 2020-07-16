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
            <li><a href="#">Materiais</a></li>


        </ul>
        <!-- END BREADCRUMB -->

        <!-- PAGE TITLE -->
        <div class="page-title">
            <a href="{{url()->previous()}}"><h3><span class="fa fa-arrow-circle-o-left"></span> Materiais</h3></a>
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
                                        <h3 class="panel-title">Materiais</h3>
                                        @if(in_array(Auth::user()->cargo_id,[1,3,21]))
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
                                            @forelse($materiais as $material)
                                            <tr id="linhaWiki{{$material->id}}"
                                                {{-- Variável de Controle  --}}
                                                @php
                                                    $count = 0;
                                                @endphp

                                                {{-- Percorre laço que contem logs  --}}
                                                @forelse ($material->materialLog as $item)
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
                                                <td> {{ $material->name }}</td>
                                                <td>{{ $material->id }}</td>
                                                <td>{{ implode('/',(explode('-',explode(' ',$material->updated_at)[0]))) }}
                                                </td>
                                                {{-- <td>{{ $material->subLocal->name }}</td> --}}
                                                <td class="btn-group btn-group-xs">
                                                    <button id="btnOpen{{$material->id}}" onclick="openMaterial({{$material->id}},'{{asset($material->file_path)}}','MATERIAL')" class="btn btn-primary">Abrir</button>
                                                    @if(!in_array(Auth::user()->cargo_id, [4,5]))
                                                    <button onclick='window.location.href="{{asset('manager/report/MATERIAL/'.$material->id)}}"'  class="btn btn-default">Relatório</button>
                                                    {{-- Botão de edição  --}
                                                    <button class="btn btn-warning">Editar</button>
                                                    {{-- Botão de exclusão  --}}
                                                    @endif
                                                    @if(in_array(Auth::user()->cargo_id,[1,3,21]))
                                                    <button class="btn btn-danger" id="deleteMaterial{{$material->id}}" onclick="deleteMaterial({{$material->id}})">Excluir</button>
                                                    @endif
                                                </td>
                                                <!-- Fim Modal  -->
                                            </tr>
                                            @empty
                                            <tr><td colspan="4"></td></tr>
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
                            url: "{{asset('/manager/material/delete')}}/"+id+"/{{ Auth::user()->id }}",
                            success: function(xhr) {
                                $("#linhaWiki"+id).hide()
                                $("#linhaWiki"+id).remove()
                                noty({text: 'Material excluído com sucesso.', layout: 'topRight', type: 'success', timeout: '3000'});
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
