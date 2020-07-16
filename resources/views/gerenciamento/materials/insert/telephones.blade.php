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


        <!-- START BREADCRUMB -->
        <ul class="breadcrumb">
            <li><a href="#">Menu</a></li>
            <li><a href="{{route('GetUsersManager')}}">Administração</a></li>
            <li class="active">Incluir</li>
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
                    <div id="phone1">
                        <div class="card">
                            <div class="list-group-item" style="max-width:100%;">
                                <p style="max-width:100%;"><strong style="color:black" id="nameView"><i class="fa fa-phone"></i> Nome</strong> <a id="descView">Veja como o telefone será exibido</a></p>
                                <div>
                                    <p><b style="color:red" id="tel1View">0800 000 0000</b> <a id="desc1View"> (Regiões Metropolitanas)</a> / <b style="color:red" id="tel2View">0800 000 0000</b> <a id="desc2View">(Demais Localidades)</a></p>
                                    <p><strong id="daysView">
                                        Atendimento de Segunda a Sexta das 0h ás 23h e Sábado e Domingo das 0h as
                                            23h, excetos feriados.
                                        </strong>
                                    </p>
                                    <p id="obsView">Observações</p>
                                    <p id="emailView">E-mail</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form method="POST" enctype="multipart/form-data" onsubmit="return false" id="telephones">
                            @csrf
                            {{-- Nome --}}
                            <div class="form-group">
                                <label for="name">Título / Nome</label>
                                <input required type="text" name="name" onkeyup="viewName(this)" class="form-control" id="name" placeholder="Campo Obrigatório" required>
                            </div>
                            {{-- Descrição  --}}
                            <div class="form-group">
                                <label for="name">Descrição</label>
                                <input required type="text" name="description" class="form-control" id="description" onkeyup="viewDesc(this)"
                                    placeholder="Campo Obrigatório">
                            </div>
                            {{-- Telefone 1  --}}
                            <div class="form-group">
                                <label for="name">Telefone 1</label>
                                <input required type="text" name="tel1" class="form-control" id="tel1" onkeyup="viewTel1(this)">
                            </div>
                            {{-- Descrição do telefone 1  --}}
                            <div class="form-group">
                                <label for="name">Descrição do Telefone 1</label>
                                <input required type="text" name="desc1" class="form-control" id="desc1" onkeyup="viewDesc1(this)">
                            </div>
                            {{-- Telefone 2  --}}
                            <div class="form-group">
                                <label for="name">Telefone 2</label>
                                <input required type="text" name="tel2" class="form-control" id="tel2" onkeyup="viewTel2(this)">
                            </div>
                            {{-- Descrição do telefone 2  --}}
                            <div class="form-group">
                                <label for="name">Descrição do Telefone 2</label>
                                <input required type="text" name="desc2" class="form-control" id="desc2" onkeyup="viewDesc2(this)">
                            </div>
                            {{-- E-mail  --}}
                            <div class="form-group">
                                <label for="name">E-mail</label>
                                <input required type="text" name="email" class="form-control" id="email" onkeyup="viewEmail(this)">
                            </div>
                            {{-- Período de Atendimento  --}}
                            <div class="form-group">
                                <label for="name">Período de Atendimento</label>
                                <input required type="text" name="days" class="form-control" id="days" onkeyup="viewDays(this)">
                            </div>
                            {{-- Observações  --}}
                            <div class="form-group">
                                <label for="name">Observações</label>
                                <input required type="text" name="obs" class="form-control" id="obs" onkeyup="viewObs(this)">
                            </div>

                            {{-- Setor  --}}
                            <div class="form-group">
                                <label for="setor_id">Setor</label>
                                <select required class="form-control" id="setor_id" name="setor_id">
                                    @forelse($setores as $setor)
                                    <option value="{{$setor->id}}">{{$setor->name}}</option>
                                    @empty
                                    <option id="noMoreS">Nenhum Setor Encontrado</option>
                                    @endforelse
                                </select>
                            </div>
                            {{-- Submit Btn  --}}
                            <div class="form-group">
                                <button type="button" id="saveTelephones"
                                    class="btn btn-primary btn-block">Criar</button>
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
<script type="text/javascript" id="roteiroJs">

    function viewName(element) {
        $("#nameView").html('<i class="fa fa-phone"></i>'+element.value+' ')
    }

    function viewDesc(element) {
        $("#descView").html('&nbsp;'+element.value+' ')
    }

    function viewTel1(element) {
        $("#tel1View").html('&nbsp;'+element.value+' ')
    }

    function viewDesc1(element) {
        $("#desc1View").html('&nbsp;'+element.value+' ')
    }

    function viewTel2(element) {
        $("#tel2View").html('&nbsp;'+element.value+' ')
    }

    function viewDesc2(element) {
        $("#desc2View").html('&nbsp;'+element.value+' ')
    }

    function viewEmail(element) {
        $("#emailView").html('&nbsp;'+element.value+' ')
    }

    function viewDays(element) {
        $("#daysView").html('&nbsp;'+element.value+' ')
    }

    function viewObs(element) {
        $("#obsView").html('&nbsp;'+element.value+' ')
    }

    $("#saveTelephones").click(function(){
        data = $("#telephones").serialize()
        $.ajax({
            url: '{{ route('PostTelefonesStore', [ 'user' => Auth::user()->id ]) }}',
            type: 'POST',
            data: data,
            success: function(xhr) {
                noty({
                    text: 'telefone incluído com sucesso!',
                    layout: 'topRight',
                    type: 'success',
                    timeout: 3000,
                })
            }, error: function(xhr, status) {
                noty({
                    text: "Não foi possível salvar telefone, <br>Tente novamente mais tarde! ("+status+')',
                    layout: 'topRight',
                    type: 'error',
                    timeout: 3000,
                })
                console.log(xhr)
            }
        })
    })

    $(function(){
        @foreach($errors->all() as $error)
        noty({
            text: "{{$erro}}",
            layout: 'topRight',
            type: 'error',
            timeout: 3000,
        })
        @endforeach

        @if(isset($success))

        @endif
    })

</script>
@include('assets.js.file')

@endsection
