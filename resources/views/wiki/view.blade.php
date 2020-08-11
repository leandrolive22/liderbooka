@php
    // Delete routes
if(strtoupper($type) === 'MATERIAL'){
    $urlDelete = asset('/manager/material/delete');
}
elseif(strtoupper($type) === 'VIDEO'){
    $urlDelete = asset('/manager/video/delete');
}
elseif(strtoupper($type) === 'SCRIPT'){
    $urlDelete = asset('/manager/script/delete');
}
elseif(strtoupper($type) === 'CIRCULAR'){
    $urlDelete = asset('/manager/circular/delete');
}

    // Edit routes
if(strtoupper($type) === 'MATERIAL'){
    $urlEdit = route("GetMateriaisEdit",["id" => 999]);
}
elseif(strtoupper($type) === 'VIDEO'){
    $urlEdit = route("GetVideosEdit",["id" => 999]);
}
elseif(strtoupper($type) === 'SCRIPT'){
    $urlEdit = route("GetRoteirosEdit",["id" => 999]);
}
elseif(strtoupper($type) === 'CIRCULAR'){
    $urlEdit = route("GetCircularesEdit",["id" => 999]);
}

    // Create Routes
if(strtoupper($type) === 'MATERIAL'){
    $urlCreate = route('GetMateriaisCreate',[Auth::id()]);
}
elseif(strtoupper($type) === 'VIDEO'){
    $urlCreate = route('GetVideosCreate',[Auth::id()]);
}
elseif(strtoupper($type) === 'SCRIPT'){
    $urlCreate = route('GetRoteirosCreate',[Auth::id()]);
}
elseif(strtoupper($type) === 'CIRCULAR'){
    $urlCreate = route('GetCircularesCreate',[Auth::id()]);
}

// Update Routes
if(strtoupper($type) === 'MATERIAL'){
    $urlPut = route('PutMaterialUpdate',[Auth::id()]);
}
elseif(strtoupper($type) === 'VIDEO'){
    $urlPut = route('PutVideosUpdate',[Auth::id()]);
}
elseif(strtoupper($type) === 'SCRIPT'){
    $urlPut = route('PutRoteirosUpdate',[Auth::id()]);
}
elseif(strtoupper($type) === 'CIRCULAR'){
    $urlPut = route('PutCircularesUpdate',[Auth::id()]);
}

    // file input name
if(strtoupper($type) === 'MATERIAL'){
    $file = "material";
}
elseif(strtoupper($type) === 'SCRIPT'){
    $file = "script";
}
elseif(strtoupper($type) === 'VIDEO'){
    $file = "video";
}
elseif(strtoupper($type) === 'CIRCULAR'){
    $file = "circular";
}


@endphp

@extends('layouts.app', ["current"=>"wiki"])
@section('content')

<!-- START PAGE CONTAINER -->
<div class="page-container">

    <!-- PAGE CONTENT -->
    @include('assets.components.preloaderdefault')
    <div class="page-content">
        <div style="display: none" id="appDefault">

            @component('assets.components.x-navbar')
            @endcomponent

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
                                            <a href="{{ $urlCreate }}" class="btn btn-danger pull-right">Novo</a>
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
                                                    @if($type === 'CIRCULAR')
                                                    <th>Ano</th>
                                                    @endif
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
                                                        @if($type === 'CIRCULAR')
                                                        <td>{{$item->year}}</td>
                                                        @endif
                                                    </td>
                                                    {{-- <td>{{ $item->subLocal->name }}</td> --}}
                                                    <td class="btn-group btn-group-xs">
                                                        <button id="btnOpen{{$item->id}}" onclick="openMaterial({{$item->id}},'{{asset($item->file_path)}}','{{$type}}')" class="btn btn-primary">Abrir</button>
                                                        @if(in_array(1,session('permissionsIds')) || in_array(41, session('permissionsIds')))
                                                        {{-- Botão para gerar relatório  --}}
                                                        <button onclick='window.location.href="{{asset('manager/report/'.$type.'/'.$item->id)}}"'  class="btn btn-default">Relatório</button>
                                                        @endif
                                                        @if(in_array(1,session('permissionsIds')) || in_array(39, session('permissionsIds')))
                                                        {{-- Botão de edição  --}}
                                                        <button class="btn btn-warning" id="editBtn{{$item->id}}" onclick="loadEdit({{$item->id}})">Editar</button>
                                                        @endif
                                                        {{-- Botão de exclusão  --}}
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
</div>

<!-- END MESSAGE BOX-->
@endsection

@section('modal')
@include('wiki.components.modalEdit')
@endsection

@section('assinatura')
@include('assets.js.assinatura-Js')
@endsection

@section('Javascript')
<script type="text/javascript" src="{{asset('js/plugins/tagsinput/jquery.tagsinput.min.js')}}"></script>
<script lang="javascript">
    function deleteMaterial(id) {
        url = "{{ $urlDelete }}/"

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

    function loadEdit(id) {
        $("#editBtn"+id).attr('disabled',true)
        $("#editBtn"+id).html('<span class="fa fa-spin fa-spinner fa-xs"></span>')
        url = "{{ $urlEdit }}"
        if($("#idEdit").val() == id) {
            $("#modalupdateWiki").show()
        } else {
            $.getJSON(url.replace('/999','/'+id),(data) => {
                console.log(typeof data.id === 'undefined')
                if(typeof data.id === 'undefined') {
                    notDataFin()
                } else {
                    if(typeof data.msg !== 'undefined') {
                        return notDataFin(data.msg)
                    } else {
                        console.log(data)
                        if(data.tags !== null) {
                            tags = data.tags.substr(1).replace('#',',')+','
                        } else {
                            tags = ''
                        }

                        $("#idEdit").val(id)
                        $("#nameEdit").val(data.name)
                        $("#modalupdateWiki").show()
                    }
                }
            });
            $("#editBtn"+id).html('Editar')
        }
        $("#editBtn"+id).html('Editar')
        return $("#editBtn"+id).attr('disabled',false)
    }

    function updateMat() {
        url = "{{ $urlPut }}"
        $("#saveChangesBtn").html('<span class="fa fa-spin fa-spinner fa-xs"></span>')
        $("#saveChangesBtn").prop('disabled',true)

        // monta dados para enviar
        if(typeof $('#fileEdit')[0].files[0] !== 'undefined' ) {
            file = $('#fileEdit')[0].files[0]
        } else {
            file = 0
        }

        data = $('#formWikiUpdate').serialize()

        if(checkWikiInput() > 0) {
            return notDataFin('Preencha os dados Corretamente')
        } else {
            $.ajax({
                url: url,
                method: 'PUT',
                data: data,
                success: function(data) {
                    console.log(data)
                },
                error: function(xhr) {
                    console.log(xhr)
                },
            })
        }
        $("#saveChangesBtn").prop('disabled',false)
        $("#saveChangesBtn").html('Salvar')
    }

    function checkWikiInput() {
        error = Number(0)
        if(in_array($('#nameEdit').val())) {
            error++
        }

        @if(strtoupper($type) === 'CIRCULAR')
        if(in_array($('#yearEdit').val())) {
            error++
        }
        @endif

        if(in_array($('#islandEdit').val())) {
            error++
        }

        if(in_array($('#cargo_idEdit').val())) {
            error++
        }

        return error;
    }

    function notDataFin(msg = 'Erro! Nenhum dado encontrado') {
        noty({
            text: msg,
            type: 'warning',
            layout: 'topRight',
            timeout: 3000
        })
    }

    $(() => {
        $("#preloaderDefault").hide().remove()
        $("#appDefault").show()
        @if(!is_null(session::get('newOnClick')))
        newData = {{session("newOnClick") }}
        console.log(newData)
        id = newData.id
        text = newData.data
        @endif
    })

</script>



<!-- END MESSAGE BOX-->
@endsection

@section('assinatura')
@include('assets.js.assinatura-Js')
@endsection
