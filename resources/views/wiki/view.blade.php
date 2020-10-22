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
<style>
.form-control{
    position:absolute;
    left:-10px;
}
.btn.btn-success{
    position:absolute;
    left:120px;
}

</style>
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
                    <div style="height: 100px;  width: 100%;" class="panel panel-success panel-hidden-controls">
                        <div class="panel-heading">
                            <h3 class="panel-title"> Trending Topics </h3>
                            <ul class="panel-controls">
                                <li><a href="#" class="panel-fullscreen"><span class="fa fa-expand"></span></a></li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span
                                        class="fa fa-cog"></span></a>
                                        <ul class="dropdown-menu">
                                            <li><a href="#" class="panel-collapse"><span class="fa fa-angle-down"></span>
                                            Collapse</a></li>
                                            <li><a href="#" class="panel-refresh"><span class="fa fa-refresh"></span>
                                            Refresh</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#" class="panel-remove"><span class="fa fa-times"></span></a></li>
                                </ul>
                            </div>
                            <div class="panel-body">
                            @if($type == "MATERIAL")
                            <a onclick="hashtags()" href="#" > <input type="hidden" value="Jornadadocliente" class="tags">#Jornadadocliente </a> </input> 
                            @endif
               
                            </div>
                        </div>
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

                                    <div class="col-md-5 text-center">
                                        <label class="mr-sm-8 sr-only" for="inlineFormCustomSelect">Campos</label>
                                        <label class="icheck">
                                            <input class="campo" name="campo" type="radio" class="icheck" value="nome" checked="true">
                                            Nome
                                        </label>
                                        <label class="icheck">
                                            <input class="campo" name="campo" type="radio" class="icheck" value="id">
                                            Numero
                                        </label>
                                        <label class="icheck">
                                            <input class="campo" name="campo" type="radio" class="icheck" value="tags">
                                            Tags
                                        </label>

                                        <div class="input-group mb-3 col-md-6 pull-right">
                                            <input type="text" class="form-control col-md-6" name="valor" id="valor" placeholder="Digite aqui" aria-label="Pesquisar" aria-describedby="basic-addon2">
                                            <div class="input-group-append">
                                            @if($type == "MATERIAL")
                                                <button  style="background-color:green; color:white; width:72px;height:30px;" class="input-group-text"  onclick="pesquisar(String($('#campo').val()),String($('input#valor').val()),String($('#tipo').val()),String($('#ilha').val()));" id="pesquisarFiltro">Pesquisar</button>
                                            @endif
                                            @if($type == "VIDEO")
                                            <button  style="background-color:green; color:white; width:72px;height:30px;" class="input-group-text"  onclick="pesquisarvideo(String($('#campo').val()),String($('input#valor').val()),String($('#tipo').val()),String($('#ilha').val()));" id="pesquisarFiltro">Pesquisar</button>
                                            @endif
                                            @if($type == "CIRCULAR")
                                            <button  style="background-color:green; color:white; width:72px;height:30px;" class="input-group-text"  onclick="pesquisarcircular(String($('#campo').val()),String($('input#valor').val()),String($('#tipo').val()),String($('#ilha').val()));" id="pesquisarFiltro">Pesquisar</button>
                                            @endif
                                            @if($type == "SCRIPT")
                                            <button  style="background-color:green; color:white; width:72px;height:30px;" class="input-group-text"  onclick="pesquisarscript(String($('#campo').val()),String($('input#valor').val()),String($('#tipo').val()),String($('#ilha').val()));" id="pesquisarFiltro">Pesquisar</button>
                                            @endif

                                            </div>
                                        </div>
                                    </div>

                                        <div class="panel-body">
                                        <div class="panel-body"> 
                                        <table class="table">
                                            <form class="col-md-4">
                                            </form>
                                            <thead>
                                                <tr>
                                                    <th>Nome</th>
                                                    <th>Numero</th>
                                                    <th>Tags</th>
                                                    <th>Data (ano/mês/dia)</th>
                                                    @if($type === 'CIRCULAR')
                                                    <th>Ano</th>
                                                    @endif
                                                    <th>Vizualizar</th>
                                                </tr>
                                            </thead>
                                         <tbody id="tbodypesquisa">
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
                                                    <input type="hidden" name="tipo" id="tipo" value="{{$type}}">
                                                    <input type="hidden" name="ilha" id="ilha" value="{{Auth::user()->ilha}}">

                                                    <td> {{ $item->name }}</td>
                                                    <td>{{ $item->id }}</td>
                                                    <td>{{ $item->tags }}</td>
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
                                        {{ $result->links() }}

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- ./PAGE CONTENT WRAPPER -->

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
<script>

function pesquisarscript(campo, valor, tipo)
{

    if(valor.length >= 3) {
        var valor = $('#valor').val();
        var campo = $('input[name=campo]:checked').val();
        var tipo = $('#tipo').val();
        var url = "{{ route('pesquisarScripts',['campo' => '--', 'valor' => '---'])}}".replace('--',campo).replace('---',valor)
        $.ajax({
            url:url,
            method:'GET',
            data:{campo,valor,tipo},
            dataType:'json',
            success:function(data)
            {
                console.log(data)
                linhas =  ""
                for(i = 0; i < data.length; i++){
                    let nome = JSON.parse(JSON.stringify(data[i].name));
                    let numero = JSON.parse(JSON.stringify(data[i].id));
                    let tags = JSON.parse(JSON.stringify(data[i].tags))
                    let datas = JSON.parse(JSON.stringify(data[i].created_at));
                    let id = JSON.parse(JSON.stringify(data[i].id));
                    let file = JSON.parse(JSON.stringify(data[i].file_path));

                    if(tags == null) {
                        tags = ''
                    }

                    linhas += '<tr  id="linhaWiki'+id+'"><td> '+nome+' </td> <td>'+numero+' </td> <td>'+tags+' </td> <td>'+datas+' </td> <td class="btn-group btn-group-xs"> <button id="btnOpen'+id+'" onclick="openMaterial('+id+','+"'{{asset('/')}}/"+file+"','{{$type}}'"+')"   class="btn btn-primary">Abrir</button> @if(in_array(1,session('permissionsIds')) || in_array(41, session('permissionsIds'))) {{-- Botão para gerar relatório  --}} <button onclick="window.location.href='+"'"+'{{asset('manager/report/'.$type.'/')}}/'+id+"'"+'"  class="btn btn-default">Relatório</button> @endif @if(in_array(1,session('permissionsIds')) || in_array(39, session('permissionsIds'))) {{-- Botão de edição  --}}<button class="btn btn-warning" id="editBtn'+id+'" onclick="loadEdit('+id+')">Editar</button>@endif    @if(in_array(1,session('permissionsIds')) || in_array(40, session('permissionsIds'))) <button class="btn btn-danger" id="deleteMaterial'+id+'" onclick="deleteMaterial('+id+')">Excluir</button>@endif</td></tr>'   


                }
                $('#tbodypesquisa').html(linhas)
            },
            error: function(xhr) {
                console.log(xhr)
            }
        })
    }
}


function pesquisarcircular(campo, valor, ilha, cargo, tipo)
{

    if(valor.length >= 3) {
        var valor = $('#valor').val();
        var campo = $('input[name=campo]:checked').val();
        var tipo = $('#tipo').val();
        var url = "{{ route('pesquisarCirculares',['campo' => '--', 'valor' => '---', 'ilha' => Auth::user()->ilha_id , 'cargo' => Auth::user()->cargo_id])}}".replace('--',campo).replace('---',valor)
        $.ajax({
            url:url,
            method:'GET',
            data:{campo,valor,ilha,cargo,tipo},
            dataType:'json',
            success:function(data)
            {
                console.log(data)
                linhas =  ""
                for(i = 0; i < data.length; i++){
                    let nome = JSON.parse(JSON.stringify(data[i].name));
                    let numero = JSON.parse(JSON.stringify(data[i].id));
                    let tags = JSON.parse(JSON.stringify(data[i].tags))
                    let datas = JSON.parse(JSON.stringify(data[i].created_at));
                    let id = JSON.parse(JSON.stringify(data[i].id));
                    let file = JSON.parse(JSON.stringify(data[i].file_path));
                    let ano = JSON.parse(JSON.stringify(data[i].year));

                    if(tags == null) {
                        tags = '#'
                    }

                    linhas += '  <tr>  <td> '+nome+' </td> <td>'+numero+' </td> <td>'+tags+' </td> <td>'+datas+' </td> <td> '+ano+' </td> <td class="btn-group btn-group-xs"> <button id="btnOpen'+id+'" onclick="openMaterial('+id+','+"'{{asset('/')}}/"+file+"','{{$type}}'"+')"   class="btn btn-primary">Abrir</button> @if(in_array(1,session('permissionsIds')) || in_array(41, session('permissionsIds'))) {{-- Botão para gerar relatório  --}} <button onclick="window.location.href='+"'"+'{{asset('manager/report/'.$type.'/')}}/'+id+"'"+'"  class="btn btn-default">Relatório</button> @endif @if(in_array(1,session('permissionsIds')) || in_array(39, session('permissionsIds'))) {{-- Botão de edição  --}}<button class="btn btn-warning" id="editBtn'+id+'" onclick="loadEdit('+id+')">Editar</button>@endif    @if(in_array(1,session('permissionsIds')) || in_array(40, session('permissionsIds'))) <button class="btn btn-danger" id="deleteMaterial'+id+'" onclick="deleteMaterial('+id+')">Excluir</button>@endif</td></tr>'   

                                   
                }
                $('#tbodypesquisa').html(linhas)
            },
            error: function(xhr) {
                console.log(xhr)
            }
        })
    }
}

function pesquisarvideo(campo, valor, tipo)
{

    if(valor.length >= 3) {
        var valor = $('#valor').val();
        var campo = $('input[name=campo]:checked').val();
        var tipo = $('#tipo').val();
        var url = "{{ route('pesquisarVideos',['campo' => '--', 'valor' => '---'])}}".replace('--',campo).replace('---',valor)
        $.ajax({
            url:url,
            method:'GET',
            data:{campo,valor,tipo},
            dataType:'json',
            success:function(data)
            {
                console.log(data)
                linhas =  ""
                for(i = 0; i < data.length; i++){
                    let nome = JSON.parse(JSON.stringify(data[i].name));
                    let numero = JSON.parse(JSON.stringify(data[i].id));
                    let tags = JSON.parse(JSON.stringify(data[i].tags))
                    let datas = JSON.parse(JSON.stringify(data[i].created_at));
                    let id = JSON.parse(JSON.stringify(data[i].id));
                    let file = JSON.parse(JSON.stringify(data[i].file_path));

                    if(tags == null) {
                        tags = ''
                    }

                    linhas += '<tr  id="linhaWiki'+id+'"><td> '+nome+' </td> <td>'+numero+' </td> <td>'+tags+' </td> <td>'+datas+' </td> <td class="btn-group btn-group-xs"> <button id="btnOpen'+id+'" onclick="openMaterial('+id+','+"'{{asset('/')}}/"+file+"','{{$type}}'"+')"   class="btn btn-primary">Abrir</button> @if(in_array(1,session('permissionsIds')) || in_array(41, session('permissionsIds'))) {{-- Botão para gerar relatório  --}} <button onclick="window.location.href='+"'"+'{{asset('manager/report/'.$type.'/')}}/'+id+"'"+'"  class="btn btn-default">Relatório</button> @endif @if(in_array(1,session('permissionsIds')) || in_array(39, session('permissionsIds'))) {{-- Botão de edição  --}}<button class="btn btn-warning" id="editBtn'+id+'" onclick="loadEdit('+id+')">Editar</button>@endif    @if(in_array(1,session('permissionsIds')) || in_array(40, session('permissionsIds'))) <button class="btn btn-danger" id="deleteMaterial'+id+'" onclick="deleteMaterial('+id+')">Excluir</button>@endif</td></tr>'   


                }
                $('#tbodypesquisa').html(linhas)
            },
            error: function(xhr) {
                console.log(xhr)
            }
        })
    }
}

function hashtagsvideos(valor)
{
  var valor =  $('.tags').val();
  if(valor.length >= 3) {     
    var url = "{{ route('filtrosVideo',['valor' => '--'])}}".replace('--',valor);

        $.ajax({
            url:url,
            method:'GET',
            data:{valor},
            dataType:'json',
            success:function(data)
            {
                console.log(data)
                linhas =  ""
                for(i = 0; i < data.length; i++){
                    let nome = JSON.parse(JSON.stringify(data[i].name));
                    let numero = JSON.parse(JSON.stringify(data[i].id));
                    let tags = JSON.parse(JSON.stringify(data[i].tags));
                    let datas = JSON.parse(JSON.stringify(data[i].created_at));
                    let id = JSON.parse(JSON.stringify(data[i].id));
                    let file = JSON.parse(JSON.stringify(data[i].file_path));

                    if(tags == null) {
                        tags = ''
                    }

                    linhas += '<tr  id="linhaWiki'+id+'"><td> '+nome+' </td> <td>'+numero+' </td> <td>'+tags+' </td> <td>'+datas+' </td> <td class="btn-group btn-group-xs"> <button id="btnOpen'+id+'" onclick="openMaterial('+id+','+"'{{asset('/')}}/"+file+"','{{$type}}'"+')"   class="btn btn-primary">Abrir</button> @if(in_array(1,session('permissionsIds')) || in_array(41, session('permissionsIds'))) {{-- Botão para gerar relatório  --}} <button onclick="window.location.href='+"'"+'{{asset('manager/report/'.$type.'/')}}/'+id+"'"+'"  class="btn btn-default">Relatório</button> @endif @if(in_array(1,session('permissionsIds')) || in_array(39, session('permissionsIds'))) {{-- Botão de edição  --}}<button class="btn btn-warning" id="editBtn'+id+'" onclick="loadEdit('+id+')">Editar</button>@endif    @if(in_array(1,session('permissionsIds')) || in_array(40, session('permissionsIds'))) <button class="btn btn-danger" id="deleteMaterial'+id+'" onclick="deleteMaterial('+id+')">Excluir</button>@endif</td></tr>'   


                }
                $('#tbodypesquisa').html(linhas)

            },
            error: function(xhr) {
                console.log(xhr)
            }
        })
    }
}

function pesquisar(campo, valor, ilha, tipo)
{

    if(valor.length >= 3) {
        var valor = $('#valor').val();
        var campo = $('input[name=campo]:checked').val();
        var tipo = $('#tipo').val();
        var url = "{{ route('pesquisarMaterials',['campo' => '--', 'valor' => '---','ilha' => Auth::user()->ilha_id])}}".replace('--',campo).replace('---',valor)
        $.ajax({
            url:url,
            method:'GET',
            data:{campo,valor,ilha,tipo},
            dataType:'json',
            success:function(data)
            {
                console.log(data)
                linhas =  ""
                for(i = 0; i < data.length; i++){
                    let nome = JSON.parse(JSON.stringify(data[i].name));
                    let numero = JSON.parse(JSON.stringify(data[i].id));
                    let tags = JSON.parse(JSON.stringify(data[i].tags))
                    let datas = JSON.parse(JSON.stringify(data[i].created_at));
                    let id = JSON.parse(JSON.stringify(data[i].id));
                    let file = JSON.parse(JSON.stringify(data[i].file_path));

                    if(tags == null) {
                        tags = ''
                    }

                    linhas += '<tr  id="linhaWiki'+id+'"><td> '+nome+' </td> <td>'+numero+' </td> <td>'+tags+' </td> <td>'+datas+' </td> <td class="btn-group btn-group-xs"> <button id="btnOpen'+id+'" onclick="openMaterial('+id+','+"'{{asset('/')}}/"+file+"','{{$type}}'"+')"   class="btn btn-primary">Abrir</button> @if(in_array(1,session('permissionsIds')) || in_array(41, session('permissionsIds'))) {{-- Botão para gerar relatório  --}} <button onclick="window.location.href='+"'"+'{{asset('manager/report/'.$type.'/')}}/'+id+"'"+'"  class="btn btn-default">Relatório</button> @endif @if(in_array(1,session('permissionsIds')) || in_array(39, session('permissionsIds'))) {{-- Botão de edição  --}}<button class="btn btn-warning" id="editBtn'+id+'" onclick="loadEdit('+id+')">Editar</button>@endif    @if(in_array(1,session('permissionsIds')) || in_array(40, session('permissionsIds'))) <button class="btn btn-danger" id="deleteMaterial'+id+'" onclick="deleteMaterial('+id+')">Excluir</button>@endif</td></tr>'   


                }
                $('#tbodypesquisa').html(linhas)
            },
            error: function(xhr) {
                console.log(xhr)
            }
        })
    }
}

function hashtags(valor)
{
  var valor =  $('.tags').val();
  if(valor.length >= 3) {     
    var url = "{{ route('filtros',['valor' => '--'])}}".replace('--',valor);

        $.ajax({
            url:url,
            method:'GET',
            data:{valor},
            dataType:'json',
            success:function(data)
            {
                console.log(data)
                linhas =  ""
                for(i = 0; i < data.length; i++){
                    let nome = JSON.parse(JSON.stringify(data[i].name));
                    let numero = JSON.parse(JSON.stringify(data[i].id));
                    let tags = JSON.parse(JSON.stringify(data[i].tags));
                    let datas = JSON.parse(JSON.stringify(data[i].created_at));
                    let id = JSON.parse(JSON.stringify(data[i].id));
                    let file = JSON.parse(JSON.stringify(data[i].file_path));

                    if(tags == null) {
                        tags = ''
                    }

                    linhas += '<tr  id="linhaWiki'+id+'"><td> '+nome+' </td> <td>'+numero+' </td> <td>'+tags+' </td> <td>'+datas+' </td> <td class="btn-group btn-group-xs"> <button id="btnOpen'+id+'" onclick="openMaterial('+id+','+"'{{asset('/')}}/"+file+"','{{$type}}'"+')"   class="btn btn-primary">Abrir</button> @if(in_array(1,session('permissionsIds')) || in_array(41, session('permissionsIds'))) {{-- Botão para gerar relatório  --}} <button onclick="window.location.href='+"'"+'{{asset('manager/report/'.$type.'/')}}/'+id+"'"+'"  class="btn btn-default">Relatório</button> @endif @if(in_array(1,session('permissionsIds')) || in_array(39, session('permissionsIds'))) {{-- Botão de edição  --}}<button class="btn btn-warning" id="editBtn'+id+'" onclick="loadEdit('+id+')">Editar</button>@endif    @if(in_array(1,session('permissionsIds')) || in_array(40, session('permissionsIds'))) <button class="btn btn-danger" id="deleteMaterial'+id+'" onclick="deleteMaterial('+id+')">Excluir</button>@endif</td></tr>'   


                }
                $('#tbodypesquisa').html(linhas)

            },
            error: function(xhr) {
                console.log(xhr)
            }
        })
    }
}
</script>


<!-- END MESSAGE BOX-->
@endsection

@section('assinatura')
@include('assets.js.assinatura-Js')
@endsection
