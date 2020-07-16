@extends('layouts.app', ["current" => 'msgs'])
@section('content')
<!-- PAGE CONTENT -->
<div class="page-content" style="height: 100%">

    @component('assets.components.x-navbar')
    @endcomponent

    <!-- START BREADCRUMB -->
    <ul class="breadcrumb push-down-0">
        <li><a href="{{ asset('/home') }}">Home</a></li>
        <li><a href="{{ asset('/messages/adm/'.base64_encode( Auth::user()->id )) }}">ChatBook</a></li>
        <li class="active">Mensagens</li>
    </ul>
    <!-- END BREADCRUMB -->

    <!-- START CONTENT FRAME -->
    <div class="content-frame">
        <!-- START CONTENT FRAME TOP -->
        <div class="content-frame-top" id="msgTop" style="display:none">
            <div class="page-title">
                <a href="{{url()->previous()}}">
                    <h2><span class="fa fa-arrow-circle-o-left"></span> Chat<strong>Book</strong> - Criar Grupo</h2>
                </a>
            </div>
        </div>
        <!-- END CONTENT FRAME TOP -->

        <!-- START CONTENT FRAME RIGHT -->
        @include('assets.components.updates')
        <!-- END CONTENT FRAME RIGHT -->

        <!-- START CONTENT FRAME BODY -->
        <div class="content-frame-body content-frame-body-left">
            <!-- CONTACTS WITH CONTROLS -->
            <form id="createGroup" onsubmit="return false">
                <div class="panel panel-default">
                    <div class="panel-heading input-group">
                        <span class="input-group-addon">
                            <span class="fa fa-font"></span>
                        </span>
                        <input type="text" class="form-control col-md-10" id="title" name="conversation_title"
                            placeholder="Título do Grupo">
                        <button type="button" id="submitBtn" class="btn btn-primary pull-right">Criar</button>
                    </div>
                    <input type="text" class="form-control" placeholder="Pesquise seus contatos aqui" id="searchContacts">
                    <div class="panel-body list-group list-group-contacts" style="overflow-y:scroll; height:425px;">
                        <ul style="padding:0" type="none" id="newGroupList">
                            @forelse ($contacts as $contact)
                            <li>
                                <a class="list-group-item">
                                    <img src="{{ asset($contact->avatar) }}" class="pull-left"
                                        alt="{{ $contact->name }}" />
                                    <span class="contacts-title">{{ $contact->name }}</span>
                                    <p>{{ $contact->cargo }}</p>
                                    <div class="list-group-controls">
                                        <label class="switch">
                                            <input type="checkbox" id="checkbox{{$contact->id}}" name="checkbox"
                                                value="0" />
                                            <span id="select{{$contact->id}}" onclick="select({{$contact->id}})"></span>
                                        </label>
                                    </div>
                                </a>
                            </li>
                            @empty
                            <a class="list-group-item">
                                <img src="{{ asset('storage/img/avatar/default.png') }}" class="pull-left"
                                    alt="Padrão" />
                                <span class="contacts-title">Desculpe,</span>
                                <p>Nenhum contato disponível</p>
                                <div class="list-group-controls">
                                    <label class="switch">
                                        <input type="checkbox" disabled value="0" />
                                        <span></span>
                                    </label>
                                </div>
                            </a>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </form>
        </div>
        <!-- END CONTACTS WITH CONTROLS -->
    </div>
    <!-- END CONTENT FRAME BODY -->
</div>
</div>
<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->

@endsection
@section('msg')
@include('assets.js.msgJs')
<script type="text/javascript" id="msgJs">
    function select(id) {
        n = $("#checkbox"+id).val()
        if(n == id) {
            $("#checkbox"+id).attr('value','0')
        } else {
            $("#checkbox"+id).attr('value',id)
        }
    }


    $("#submitBtn").click(function(){
        $("#submitBtn").attr('class','btn btn-primary pull-right disabled')
        title = $("#title").val();
        if(title == null) {
            return noty({
                        text: "Preencha o Título do Grupo!",
                        layout: 'topRight',
                        type: 'error',
                        timeout: '5000'
                    })
        } else {

            values = '';

            $.each($("input[name=checkbox]"),function(index, value){
                val = value.value;
                if(val != 0) {
                    values += val+','
                }
            });

            values+="{{ Auth::user()->id }}";

            data = values.split(',')

            $.ajax({
                url: "{{ asset('chats/createGroup') }}/{{Auth::user()->id}}/"+data,
                type: 'POST',
                data: 'conversation_title='+title,
                success: function(xhr) {
                    $("#submitBtn").attr('class','btn btn-primary pull-right')
                    noty({
                        text: "Grupo criado <b>"+title+"</b> com sucesso!<br>Aguarde para ser redirecionado...",
                        layout: 'topRight',
                        type: 'success',
                        timeout: '5000'
                    });
                    $("#title").val('')
                    window.setTimeout(function(){
                        window.location.href = $("#MessagesTaskBtnMenu").attr('id')
                    },1500)

                },
                error: function(xhr, status){
                    $("#submitBtn").attr('class','btn btn-primary pull-right')
                    noty({
                        text: "Erro ao criar grupo!<br>Verifique se todos os campos estão preenchidos e tente novamente.",
                        layout: 'topRight',
                        type: 'error',
                        timeout: '5000'
                    })
                    console.log(xhr)
                }

            });
        }

    })

    $(function(){
        $("#searchContacts").keyup(function(){
            var texto = $(this).val();

            $("#newGroupList li").css("display", "block");
            $("#newGroupList li").each(function(){
                if($(this).text().indexOf(texto) < 0)
                $(this).css("display", "none");
            });
        });
    })

</script>
@endsection
