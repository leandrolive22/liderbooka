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
                    <h2><span class="fa fa-arrow-circle-o-left"></span> Chat<strong>Book</strong> - Excluir Grupos</h2>
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
                        <button type="button" id="submitBtn" class="btn btn-primary pull-center"><i class="fa fa-trash-o"></i> Excluir Grupos</button>
                        <button type="button" id="selectAll" class="btn btn-info pull-right"><i class="fa fa-check-square-o"></i> Selecionar todos</button>
                    </div>
                    <div class="panel-body list-group list-group-contacts" style="overflow-y:scroll; height:425px;">
                        @forelse ($groups as $group)
                        <a class="list-group-item">
                            <i class="fa fa-users fa-3x"></i>
                            <span class="contacts-title">{{ $group->conversation_title }}</span>
                            <div class="list-group-controls">
                                <label class="switch">
                                    <input type="checkbox" id="checkbox{{$group->id}}" name="checkbox"
                                        value="0" />
                                    <span id="select{{$group->id}}" onclick="select({{$group->id}})"></span>
                                </label>
                            </div>
                        </a>
                        @empty
                        <a class="list-group-item disabled">
                            <img src="{{ asset('storage/img/avatar/default.png') }}" class="pull-left" alt="Padrão" />
                            <span class="contacts-title">Desculpe,</span>
                            <p>Nenhum Grupo disponível</p>
                            <div class="list-group-controls">
                                <label class="switch">
                                    <input type="checkbox" disabled value="0" />
                                    <span></span>
                                </label>
                            </div>
                        </a>
                        @endforelse
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
<script type="text/javascript" id="msgJs">
    function select(id) {
        n = $("#checkbox"+id).val()
        if(n == id) {
            $("#checkbox"+id).attr('value','0')
        } else {
            $("#checkbox"+id).attr('value',id)
        }
    }


    // $("#checkbox"+id).attr('value',id);
    function selectAllSwitch(n) {
        if(n == 0) {
            $("#selectAll").attr('onclick','selectAllSwitch(1)')
            $.each($("input[name=checkbox]"),function(index, value){
                id = value.id.split('checkbox')
                $("#"+value.id).trigger('click');
                $("#"+value.id).attr('value',id[1])
            });
        } else {
            $("#selectAll").attr('onclick','selectAllSwitch(0)')
            $.each($("input[name=checkbox]"),function(index, value){
                id = value.id.split('checkbox')
                $("#"+value.id).trigger('click');
                $("#"+value.id).attr('value','0')
            });
        }

    }


    $("#submitBtn").click(function(){
        values = '';
        $("#submitBtn").attr('class','btn btn-primary pull-center disabled')

        $.each($("input[name=checkbox]"),function(index, value){
                val = value.value;
                if(val != 0) {
                    values += val+','
                }

            });

        data = values.split(',')

        $.ajax({
            url: "{{ asset('chats/deleteGroups') }}/{{Auth::user()->id}}/"+data,
            type: 'POST',
            success: function(xhr) {
                $("#submitBtn").attr('class','btn btn-primary pull-center')
                noty({
                    text: "Grupo(s) deletado(s) com sucesso!",
                    layout: 'topRight',
                    type: 'success',
                    timeout: '5000'
                });

                setTimeout(function(){
                    location.reload()
                },1500)


            },
            error: function(xhr, status){
                $("#submitBtn").attr('class','btn btn-primary pull-center')
                noty({
                    text: "Erro ao deletar grupo!<br>Tente novamente mais tarde!<br>("+xhr.status+")",
                    layout: 'topRight',
                    type: 'error',
                    timeout: '5000'
                })
                console.log(xhr)
            }

        });

    })

    $(document).ready(function(){
        $("#selectAll").attr('onclick','selectAllSwitch(0)')
    })

</script>
@endsection
