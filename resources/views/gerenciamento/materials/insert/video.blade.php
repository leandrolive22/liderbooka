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
            <li href="{{route('GetUsersManager')}}" class="active">Administração</li>
        </ul>
        <!-- END BREADCRUMB -->

        <!-- START CONTENT FRAME -->
        <div class="content-frame">

            <!-- START CONTENT FRAME TOP -->
            <div class="content-frame-top">
                <div class="page-title">
                    <a href="{{url()->previous()}}">
                        <h2><span class="fa fa-arrow-circle-o-left"></span> Incluir Video</h2>
                    </a>
                </div>
                <div class="pull-right">
                    <button class="btn btn-{{Auth::user()->css}} content-frame-right-toggle"><span
                            class="fa fa-bars"></span></button>
                </div>
            </div>
            <!-- END CONTENT FRAME TOP -->

            <!-- START CONTENT FRAME RIGHT -->
            @include('assets.components.updates')
            <!-- END CONTENT FRAME RIGHT -->

            <!-- START CONTENT FRAME BODY -->
            <div class="content-frame-body content-frame-body-left">
                <div class="panel panel-default">


                    <!-- START TIMELINE -->
                    <div class="page-content-wrap" style='background-color:#f5f5f5 '>
                        <!-- START TIMELINE ITEM -->
                        <form method="POST" enctype="multipart/form-data" class="form-horizontal"
                            onsubmit="return false" id="Video">
                            @csrf
                            <div class="form-row">
                                <div class="panel panel-primary">
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label for="name">Título / Assunto</label>
                                            <input required type="text" name="name" class="form-control" id="name"
                                                placeholder="Título / Assunto">
                                        </div>
                                        {{-- ilhas --}}
                                        <div class="form-group">
                                            <label for="ilha_id">Cargos</label>
                                            <select multiple required class="form-control select" id="cargo_id" name="cargo_id">
                                                <option value="all">Todos</option>
                                            @forelse($cargos as $cargo)
                                                <option value="{{$cargo->id}}">{{$cargo->description}}</option>
                                            @empty
                                                <option id="noMoreS">Nenhum Cargo Encontrada</option>
                                            @endforelse
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="ilha_id">Ilha</label>
                                            <select multiple required class="form-control select" onchange="getSublocal(this)" id="ilha_id" name="ilha_id">
                                                @forelse ($ilhas as $ilha)
                                                    <option value="{{ $ilha->setor_id }}|{{ $ilha->id }}">{{ @$ilha->setor->name }} | {{ $ilha->name }}</option>
                                                @empty
                                                    <option value="0">Nenhuma ilha encontrada</option>
                                                @endforelse
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="tags">HashTag</label>
                                            <input required type="text" value="#" name="tags" class="form-control" id="tags"
                                                placeholder="Hash Tag">
                                        </div>
                                        <input required type="hidden" name="user" id="user" value="{{Auth::user()->id}}">

                                    <div class="panel panel-default form-group">
                                        <div class="panel-body">
                                            <h3><span class="fa fa-mail-forward"></span> Selecionar Video <font
                                                    style="font-size: 10px;">Arquivos suportados: MP4</font>
                                            </h3>
                                            <div class="form-group">
                                                <div class="col-md-12">
                                                    <label>Selecione o Video</label>
                                                    <input type="file" class="" name="video"
                                                        data-preview-file-type="video/mp4" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="button" onclick="save()" id="sendBtn" class="btn btn-primary col-md-12">Criar</button>                                    </div>
                                </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('Javascript')
@include('assets.js.file')
<script type="text/javascript">
    function save() {
        $("#sendBtn").html('<span class="fa fa-refresh fa-spin"></span>')
        $("#sendBtn").prop('disabled',true)
        // verifica inputs
        error = Number(0)
        $.each($('input'), function(i,v) {
            if(v == null || v == '') {
                error += Number(1)
            }
        });

        //verifica selects
        if($("#cargo_id").val() == null || $("#ilha_id").val() == null || error > 0) {
            noty({
                text: "Preencha todos os campos corretamente",
                layout: 'topRight',
                type: "error",
                timeout: 3000
            });
            $("#sendBtn").prop('disabled',false)
            $("#sendBtn").html('Criar')
        }  else {
            cargo = '';
            $.each($("#cargo_id").val(),function(i,v){
                cargo += String(v)+','
            })

            ilha = '';
            $.each($("#ilha_id").val(),function(i,v){
                ilha += String(v)+','
            })

            data = new FormData()
            data.append('_token',$('input[name=_token]').val());
            data.append('name',$('#name').val());
            data.append('video',$('input[type=file]')[0].files[0]);
            data.append('cargo_id',cargo);
            data.append('ilha_id',ilha);
            data.append('tags',$('#tags').val());
            data.append('user',$('#user').val());

            $.ajax({
                data: data,
                url: "{{ route('PostVideosStore', [ 'user' => Auth::id() ]) }}",
                method: "POST",
                processData: false,
                contentType: false,
                success: function (response) {
                    $("#sendBtn").prop('disabled',false)
                    $("#sendBtn").html('Criar')
                    console.log(response)
                    $('#POSTPreloader').hide();
                    $('#newPOSTForm').show();

                    noty({
                        text: response.successAlert,
                        timeout: 3000,
                        layout: 'topRight',
                        type: 'success',
                    });
                },
                error: function(xhr) {
                    $("#sendBtn").prop('disabled',false)
                    $("#sendBtn").html('Criar')
                    console.log(xhr)
                    if(xhr.responseJSON.errors.length > 0) {
                        $.each(xhr.responseJSON.errors,function(i,v){
                            noty({
                                text: v,
                                timeout: 3000,
                                layout: 'topRight',
                                type: 'error',
                            });
                        })
                    } else {
                        noty({
                            text: 'Error! Tente novamente mais tarde.',
                            timeout: 3000,
                            layout: 'topRight',
                            type: 'error',
                        });
                    }
                }
            })

        }

    }
</script>
@endsection
