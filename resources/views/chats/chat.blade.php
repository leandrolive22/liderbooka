@extends('layouts.app', ["current" => 'msgs'])
@section('content')
<!-- PAGE CONTENT -->
<div class="page-content">

    @component('assets.components.x-navbar')
    @endcomponent

    <!-- START BREADCRUMB -->
    <ul class="breadcrumb push-down-0">
        <li><a href="{{ asset('/home') }}">Home</a></li>
        <li class="active">Mensagens</li>
    </ul>
    <!-- END BREADCRUMB -->

    <!-- START CONTENT FRAME -->
    <div class="content-frame">
        <!-- START CONTENT FRAME TOP -->
        <div class="content-frame-top" id="msgTop" style="display:none">
            <div class="page-title">
                <h2 id="contactInfo"><span class="fa fa-comments"></span> Chat<strong>Book</strong></h2>
                <br>
                <span>Histórico de 20 mensagens, para obter todo histórico, contate o suporte</span>
            </div>
        </div>
        <!-- END CONTENT FRAME TOP -->
        <!-- START CONTENT FRAME RIGHT -->
        <input type="hidden" id="clearInterval">
        <div class="content-frame-right" style="display:none;" id="contacts">

            <div class="panel panel-primary push-down-20">
                <div class="list-group list-group-contacts border-bottom push-down-0">
                    <div class="list-group-item" style="padding: 0">
                        <div class="panel-heading ui-draggable-handle">
                            <h3 class="panel-title">Contatos</h3>
                            <input type="text" class="form-control col-md-10" id="filtro" placeholder="Digite algum nome">

                            <ul class="panel-controls">
                                <a role="button" href="#contacts" class="panel-collapse"><span class="fa fa-angle-down"></span></a>
                            </ul>
                        </div>
                    </div>
                    {{-- <div class="panel-heading ui-draggable-handle">

                        </div> --}}
                    <ul class="panel-body" id="contacts" type="none" style="padding:0; margin:0; max-height: 15rem; overflow-y: auto">
                        @php
                            $ids = Auth::id();
                        @endphp
                        @forelse ($contacts as $contact)
                        @if(Auth::id() != $contact->id)
                            @php
                                $ids .= ','.$contact->id
                            @endphp

                            <li id="contactLi{{$contact->id}}">
                                <a href='javascript:clearInterval($("input#clearInterval").val());intervalGetMsg({{$contact->id}},"{{$contact->name}}","{{Auth::user()->name}}","{{ $contact->avatar }}");'
                                    class="list-group-item active" id="chat{{ $contact->id }}">
                                    @if($contact->deleted_at === NULL)
                                        <img src="{{asset($contact->avatar)}}" class="pull-left" alt="{{$contact->name}}">
                                    @else
                                        <span class="fa fa-times-circle-o fa-3x pull-left"></span>
                                    @endif

                                    <div class="contacts-title">
                                        {{-- Verifica online --}}
                                        @if($contact->last_login >= date('Y-m-d H:i:s',strtotime('-10 Minutes')))
                                            <span id="online{{ $contact->id }}" class="fa fa-circle text-success" style="color: #95b75d"></span>
                                        @else 
                                            <span id="online{{ $contact->id }}" class="fa fa-circle text-muted" style="color: #555555"></span>
                                        @endif
                                        <span class="label label-danger" id="msgNumber{{$contact->id}}"></span>
                                        {{$contact->name}}
                                        <p class="text-mute" style="font-size: 85%;">{{$contact->cargo}}</p>
                                    </div>
                                </a>
                            </li>
                        @else
                        @endif
                        @empty
                    </ul>
                    <div class="col-md-12 text-center" id="noMSG" style="height: 20rem; padding:5rem;">
                        <i class="fa fa-comments fa-3x"></i>
                        <p>Nenhum contato disponível</p>
                    </div>
                    @endforelse
                    <!-- ids dos contatos listados para facilitar consulta - str assim: 1,2,3,56,...,n -->
                    <input type="hidden" id="ids" value="{{$ids}}">
                </div>
            </div>
            <div class="panel panel-colorful">
                <div class="list-group list-group-contacts border-bottom push-down-10">
                    <div class="list-group-item"  style="padding: 0">
                        <div class="panel-heading ui-draggable-handle">
                            <h3 class="panel-title">Grupos</h3>
                            <ul class="panel-controls">
                                <a role="button" href="#" class="panel-collapse"><span class="fa fa-angle-down"></span></a>
                            </ul>
                            <input type="text" class="form-control" id="filtroGroup" placeholder="Digite algum Titulo de grupo">
@if($createGroup || $deleteGroup || $webMaster)
                            @if($createGroup || $webMaster)
                                <a href="{{ route('GetNewChat', base64_encode(Auth::user()->id) ) }}" role="button"
                                    class="btn btn-default col-md-6">
                                    <span class="fa fa-users"></span> Novo Grupo
                                </a>
                            @endif
                            @if($deleteGroup || $webMaster)
                                <a href="{{ route('GetDeleteChat', [ 'cargo' => base64_encode(Auth::user()->cargo_id), 'user' => base64_encode(Auth::user()->id) ] ) }}" role="button"
                                    class="btn btn-default col-md-6">
                                    <span class="fa fa-trash-o"></span> Excluir Grupo
                                </a>
                            @endif
@endif
                        </div>
                    </div>
                    <ul class="panel-body" id="groups" type="none" style="padding:0;margin:0; max-height: 18rem; overflow-y: auto">
                        @foreach ($groups as $group)
                        <li>
                            <a href='javascript:clearInterval($("input#clearInterval").val());intervalGetGroupMsg({{$group->id}},"{{$group->conversation_title}}","{{Auth::user()->name}}")' role="button" class="list-group-item active" id="chatGroup{{ $group->id }}">
                                <i class="fa fa-users fa-3x" style="color:purple"></i>
                                <div class="contacts-title">
                                    <span class="label label-danger" id="msgNumberGroup{{$group->id}}"></span>

                                    <p><b> {{$group->conversation_title}}</b></p>
                                </div>
                            </a>
                        </li>
                        @endforeach

                </div>
            </div>
            <div class="block">
                <h4>Status</h4>
                <div class="list-group list-group-simple">
                    <a href="#" class="list-group-item"><span class="fa fa-circle text-success"></span> Online</a>
                    <a href="#" class="list-group-item"><span class="fa fa-circle text-muted"></span> Offline</a>
                </div>
            </div>


        </div>
        <!-- END CONTENT FRAME RIGHT -->
        {{-- START PRELOADER  --}}
        <div class="text-center" id="msgPreLoader">
            <div class="spinner-grow " role="status" style="width: 10rem; height: 10rem; margin-top: 15rem;">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        {{-- END PRELOADER  --}}
        <!-- START CONTENT FRAME BODY LEFT -->
        <div class="content-frame-body content-frame-body-left" id="msgs" style="max-height: 50%">
            <div class="hidden" id="keyinfo"></div>

            <div class="messages messages-img" id="divMsg" style="overflow-y: auto; max-height: 450px">
            </div>

            <div class="col-md-12 text-center" id="noMSG" style="height: 20rem; padding:15rem;">
                <i class="fa fa-comments fa-3x"></i>
                <p id="defaultP">Selecione um contato ao lado para carregar as conversas</p>
                <p style="display:none" id="noMSGp">Nenhuma mensagem para mostrar</p>
            </div>

            <form onsubmit="return false" id="sendMsgForm">
                @csrf
                <input type="hidden" name="groupInput" id="groupInput">
                <div class="panel panel-default push-up-10">
                    <div class="panel-body panel-body-search">
                        <div class="input-group">
                            <textarea class="form-control hidden" name="content" id="content"
                                placeholder="Escreva sua mensagem... Aperte Shift+Enter para pular linha"></textarea>
                            <div class="input-group-btn" id="sendMsgDivBTN">
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
        <!-- END CONTENT FRAME BODY -->
    </div>
    <!-- END PAGE CONTENT FRAME -->
</div>
<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->

@endsection
@section('msg')
@include('assets.js.msgJs')
@endsection
