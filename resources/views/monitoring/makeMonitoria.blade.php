@extends('layouts.app', ["current"=>"monitor"])
@section('content')
<!-- START PAGE CONTAINER -->
<div class="page-container">


    <!-- PAGE CONTENT -->
    <div class="page-content">

        @component('assets.components.x-navbar')
        @endcomponent

        {{-- Preloader --}}
        <div class="spinner-grow text-dark" role="status" id='loadingPreLoader' style="margin-left:35%; margin-right:35%; margin-top:10%; width: 30rem; height:30rem">
            <span class="sr-only">Loading...</span>
        </div>

        <!-- START CONTENT FRAME -->
        <div class="content-frame" id="contentFrameMonitoring" style="display: none;">

            <!-- START PAGE CONTENT WRAP -->
            <div class="page-content-wrap" style="padding: 2rem">
                <div class="page-title">
                    <a href="{{ route('GetMonitoriasIndex') }}">
                        <h2 class="page-title">
                            <span class="fa fa-arrow-circle-o-left">
                            </span>
                            Monitoria LiderBook
                        </h2>
                    </a>
                </div>
                {{-- START PAGE BODY MONITORIA --}}
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            @if (isset($monitoria))
                            Editar Monitoria #{{$monitoria->id}}
                            @elseif(isset($laudo))
                            Aplicar Monitoria - <b>{{$laudo->titulo}}</b>
                            @endif
                        </h3>
                        <h5 class="panel-title pull-right">Monitor: <b>{{Auth::user()->name}}</b></h5>
                    </div>
                    {{-- START FORM  --}}
                    <form id="monitoria" onsubmit="return false">
                        @csrf
                        {{-- Modelo da Monitoria --}}
                        @if (isset($monitoria))
                            <input required type="hidden" name="modelo_id" id="modelo_id" value="{{$monitoria->modelo_id}}">
                        @else
                            <input required type="hidden" name="modelo_id" id="modelo_id" value="{{$model}}">
                        @endif

                        <div class="panel-body">
                            {{-- Dados do Operador  --}}
                            <div class="form-row">
                                <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                    @if(isset($operador))
                                        <label for="operador">Operador</label>
                                        <b class="form-control">{{$operador->name}}</b>
                                        <input type="hidden" validate="Operador" name="operador" id="operador" value="{{$operador->id}}">
                                    @else
                                        <label for="operador">Selecione o operador</label>
                                        {{-- Colaborador avaliado --}}
                                        <select data-live-search="true" validate="Operador" name="operador" id="operador" onchange="selectSup(this)" class="form-control select monitoria ">
                                            <option value="">Selecione um operador</option>
                                            @forelse ($users as $item)
                                                <option value="{{$item->id}}" @if(isset($monitoria) && $monitoria->operador_id === $item->id) selected="true" @endif id="supervisor_slct{{$item->id}}" class="{{$item->supervisor_id}}">{{$item->name}}</option>
                                            @empty
                                                <option value="0">Nenhum usuário encontrado</option>
                                            @endforelse
                                        </select>
                                    @endif
                                </div>
                                @if(Auth::user()->carteira_id == 1)
                                <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                    <label for="monitor">Usuário-Cliente</label>
                                    <input required type="text" validate="Usuário-Cliente" class="form-control monitoria" @if(isset($monitoria)) value="{{$monitoria->usuario_cliente}}" @elseif(isset($operador)) value="" @endif name="userCli" id="userCli" placeholder="Ex: Usuário X">
                                </div>
                                @else 
                                <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                    <label for="tp_call">Tipo da Ligação</label>
                                    <select name="tp_call" validate="Tipo da Ligação" id="tp_call" class="form-control select monitoria ">
                                        <option value="0" @if(isset($monitoria) && $monitoria->tipo_ligacao === '0') selected="true" @endif>Selecione o tipo da ligação</option>
                                        <option value="sucesso" @if(isset($monitoria) && $monitoria->tipo_ligacao === 'sucesso') selected="true" @endif>Sucesso</option>
                                        <option value="insucesso" @if(isset($monitoria) && $monitoria->tipo_ligacao === 'insucesso') selected="true" @endif>Insucesso</option>
                                        <option value="recado" @if(isset($monitoria) && $monitoria->tipo_ligacao === 'recado') selected="true" @endif>Recado</option>
                                        <option value="Promessa de Pagamento" @if(isset($monitoria) && $monitoria->tipo_ligacao === 'Promessa de Pagamento') selected="true" @endif>Promessa de Pagamento</option>
                                        <option value="Sem Condições" @if(isset($monitoria) && $monitoria->tipo_ligacao === 'Sem Condições') selected="true" @endif>Sem Condições</option>
                                        <option value="Preventivo Positivo" @if(isset($monitoria) && $monitoria->tipo_ligacao === 'Preventivo Positivo') selected="true" @endif>Preventivo Positivo</option>
                                        <option value="Manutenção Negativa" @if(isset($monitoria) && $monitoria->tipo_ligacao === 'Manutenção Negativa') selected="true" @endif>Manutenção Negativa</option>
                                        <option value="Preventivo em Atraso Positiva" @if(isset($monitoria) && $monitoria->tipo_ligacao === 'Preventivo em Atraso Positiva') selected="true" @endif>Preventivo em Atraso Positiva</option>
                                        <option value="Preventivo em Atraso Negativo" @if(isset($monitoria) && $monitoria->tipo_ligacao === 'Preventivo em Atraso Negativo') selected="true" @endif>Preventivo em Atraso Negativo</option>
                                    </select>
                                </div>
                                @endif
                            </div>
                            {{-- Dados da Monitoria  --}}
                            <div class="form-row">
                                <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                    <label for="supervisor">Supervisor</label>
                                    @if(isset($operador))
                                        <input type="text" name="supervisor" id="supervisor" validate="Supervisor" @if(!is_null($operador->supervisor)) value="{{$operador->supervisor}}" @endif class="form-control monitoria" >
                                        <button class="btn btn-danger col-sm-1 col-md-1 col-lg-1" type="button" onclick="$('#modalTrue').show()">
                                            <span class="fa fa-pencil"></span>
                                        </button>
                                    @elseif(isset($monitoria))
                                        <input type="text" name="supervisor" validate="Supervisor" id="supervisor" @if(isset($monitoria) && isset($monitoria->supervisor)) value="{{$monitoria->supervisor->name}}" @else value="Selecione um Operador" @endif class="form-control col-sm-11 col-md-11 col-lg-11" readonly>

                                        <button class="btn btn-secondary col-sm-1 col-md-1 col-lg-1" type="button" onclick="$('#modalTrue').show()">
                                            <span class="fa fa-pencil"></span>
                                        </button>
                                    @else
                                        <label for="supervisor">Supervisor</label>
                                        <input type="text" validate="Supervisor" name="supervisor" class="form-control monitoria" >
                                        <button class="btn btn-danger col-sm-1 col-md-1 col-lg-1" type="button" onclick="$('#modalTrue').show()">
                                            <span class="fa fa-pencil"></span>
                                        </button>
                                    @endif
                                    <input required type="hidden" class="monitoria" name="monitor" id="monitor" value="{{Auth::id()}}">
                                </div>
                                <div class="form-group col-sm-6 col-md-6 col-lg-6">
                                    <label for="produto">Produto</label>
                                    <select data-live-search="true" validate="Produto" name="produto" id="produto" class="form-control select monitoria ">
                                        @forelse ($ilhas as $item)
                                            <option value="{{$item->id}}" @if(isset($operador) && $operador->ilha_id === $item->id || isset($monitoria) && $monitoria->produto == $item->id) selected="true" @endif >{{$item->name}}</option>
                                        @empty
                                            <option value="0">Nenhum produto encontrado</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            {{-- Dados da Ligação  --}}
                            @if(Auth::user()->carteira_id == 1)
                            <div class="form-row">
                                <div class="form-group col-sm-5 col-md-5 col-lg-5">
                                    <label for="nome_cliente">Cliente</label>
                                    <input required type="text" validate="Cliente" class="form-control monitoria" name="nome_cliente" id="nome_cliente" placeholder="Nome do Cliente" @if(isset($monitoria)) value="{{$monitoria->cliente}}" @endif>
                                </div>
                                <div class="form-group col-sm-4 col-md-4 col-lg-4">
                                    <label for="tp_call">Tipo da Ligação</label>
                                    <select name="tp_call" validate="Tipo da Ligação" id="tp_call" class="form-control select monitoria ">
                                        <option value="0" @if(isset($monitoria) && $monitoria->tipo_ligacao === '0') selected="true" @endif>Selecione o tipo da ligação</option>
                                        <option value="sucesso" @if(isset($monitoria) && $monitoria->tipo_ligacao === 'sucesso') selected="true" @endif>Sucesso</option>
                                        <option value="insucesso" @if(isset($monitoria) && $monitoria->tipo_ligacao === 'insucesso') selected="true" @endif>Insucesso</option>
                                        <option value="recado" @if(isset($monitoria) && $monitoria->tipo_ligacao === 'recado') selected="true" @endif>Recado</option>
                                        <option value="Promessa de Pagamento" @if(isset($monitoria) && $monitoria->tipo_ligacao === 'Promessa de Pagamento') selected="true" @endif>Promessa de Pagamento</option>
                                        <option value="Sem Condições" @if(isset($monitoria) && $monitoria->tipo_ligacao === 'Sem Condições') selected="true" @endif>Sem Condições</option>
                                        <option value="Preventivo Positivo" @if(isset($monitoria) && $monitoria->tipo_ligacao === 'Preventivo Positivo') selected="true" @endif>Preventivo Positivo</option>
                                        <option value="Manutenção Negativa" @if(isset($monitoria) && $monitoria->tipo_ligacao === 'Manutenção Negativa') selected="true" @endif>Manutenção Negativa</option>
                                        <option value="Preventivo em Atraso Positiva" @if(isset($monitoria) && $monitoria->tipo_ligacao === 'Preventivo em Atraso Positiva') selected="true" @endif>Preventivo em Atraso Positiva</option>
                                        <option value="Preventivo em Atraso Negativo" @if(isset($monitoria) && $monitoria->tipo_ligacao === 'Preventivo em Atraso Negativo') selected="true" @endif>Preventivo em Atraso Negativo</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-3 col-md-3 col-lg-3">
                                    <label for="cpf_cliente">CPF</label>
                                    <input required type="number" validate="CPF" class="form-control" name="cpf_cliente" id="cpf_cliente" @if(isset($monitoria)) value="{{$monitoria->cpf_cliente}}" @endif>
                                </div>
                            </div>
                            @endif
                            <div class="form-row">
                                <div class="form-group col-sm-2 col-md-2 col-lg-2">
                                    <label for="dt_call">Data da Ligação</label>
                                    <input required type="date" class="form-control monitoria" validate="Data da Ligação" name="dt_call" id="dt_call" @if(isset($monitoria)) value="{{$monitoria->data_ligacao}}" @endif>
                                </div>
                                <div class="form-group col-sm-3 col-md-3 col-lg-3">
                                    <label for="hora_ligacao">Hora da Ligação</label>
                                    <div class="input-group input-group-md col-sm-12 col-md-12 col-lg-12" id="hora_ligacao">
                                        <input required type="time" validate="Hora da Ligação" step="1" max="23:59:59" name="hr_call" id="hr_call" class="form-control col-sm-12 col-md-12 col-lg-12" @if(isset($monitoria)) value="{{ $monitoria->hora_ligacao }}" @else value="{{ date('H:i') }}:53" @endif>
                                    </div>
                                </div>
                                <div class="form-group col-sm-4 col-md-4 col-lg-4">
                                    <label for="id_audio">ID do Áudio</label>
                                    <input required type="text" class="form-control monitoria" validate="ID do Áudio" name="id_audio" id="id_audio" placeholder="Digite o código do audio" @if(isset($monitoria)) value="{{$monitoria->id_audio}}" @endif>
                                </div>
                                <div class="form-group col-sm-3 col-md-3 col-lg-3">
                                    <label for="tempo_ligacao">Tempo da Ligação</label>
                                    <div class="input-group input-group-md col-sm-12 col-md-12 col-lg-12" id="tempo_ligacao">
                                        <input required type="time" step="1" max="23:59:59" validate="Tempo da Ligação" name="hr_tp_call" id="hr_tp_call" class="form-control col-sm-12 col-md-12 col-lg-12" @if(isset($monitoria)) value="{{ $monitoria->tempo_ligacao}}" @else value="00:30:12" @endif>
                                    </div>
                                </div>
                            </div>
                            {{-- Pontos Monitoria --}}
                            @if(Auth::user()->carteira_id == 1)
                            <div class="form-row">
                                <div class="form-group col-sm-4 col-md-4 col-lg-4">
                                    <label for="pt_pos">
                                        Pontos Positivos
                                    </label>
                                    <input required type="text" class="form-control monitoria" validate="Pontos Positivos" name="pt_pos" id="pt_pos" placeholder="Descreva os Pontos Positivos" @if(isset($monitoria)) value="{{$monitoria->pontos_positivos}}" @endif>
                                </div>
                                <div class="form-group col-sm-4 col-md-4 col-lg-4">
                                    <label for="pt_dev">
                                        Pontos a Desenvolver
                                    </label>
                                    <input required type="text" class="form-control monitoria" validate="Pontos a Desenvolver" name="pt_dev" id="pt_dev" placeholder="Descreva os Pontos a Desenvolver" @if(isset($monitoria)) value="{{$monitoria->pontos_desenvolver}}" @endif>
                                </div>
                                <div class="form-group col-sm-4 col-md-4 col-lg-4">
                                    <label for="pt_att">
                                        Pontos de Atenção
                                    </label>
                                    <input required type="text" class="form-control monitoria" validate="Pontos a Atenção" name="pt_att" id="pt_att" placeholder="Descreva os Pontos de Atenção" @if(isset($monitoria)) value="{{$monitoria->pontos_atencao}}" @endif>
                                </div>
                            </div>
                            @endif
                            {{-- NCG btn & Feedback  --}}
                            <div class="form-row">
                                <div class="form-row col-sm-8 col-md-8 col-lg-8">
                                    <div class="form-group col-sm-10 col-md-10 col-lg-10">
                                        <label for="feedback">FeedBack/Dicas</label>
                                        <textarea type="text" id="feedback" validate="FeedBack" class="form-control" name="feedback" placeholder="Escreva um Feedback para o colaborador" @if(isset($monitoria)) value="{{$monitoria->feedback_monitor}}" @endif></textarea>
                                    </div>
                                </div>
                                <div class="form-group col-sm-4 col-md-4 col-lg-4">
                                    @php
                                       $hash = md5(base64_encode('MONITORIA_MONITOR'.Auth::id().date('D')).microtime()).date('ymd');
                                    @endphp
                                    <input type="hidden" name="hash" id="hash" value="{{$hash}}">
                                </div>
                            </div>
                        </div>
                    </form>
                    {{-- END FORM --}}
                </div>
                {{-- END PAGE BODY MONITORIA  --}}
                {{-- START Laudos --}}
                <div class="panel panel-colorful">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Laudos
                        </h3>
                    </div>
                    <div class="panel-body" style="max-height: 500px; overflow-y: auto;">
                        <table class="table table-bordered">
                            <thead>
                                <thead>
                                    <tr>
                                        <th>{{env('N_MON')}}</th>
                                        <th>{{env('QUEST_MON')}}</th>
                                        <th>{{env('CAT_MON')}}</th>
                                        <th>{{env('PROCED_MON')}}</th>
                                    </tr>
                                </thead>
                            </thead>
                            <tbody>
                                {{-- Se não é edição --}}
                                @php
                                if(!isset($laudoItens) || (isset($laudoItens) && !is_null($laudoItens))) {
                                    $laudoItens = $laudo->itens;
                                } 
                                @endphp
                                @if(!isset($itens))
                                    @forelse ($laudoItens as $item)
                                        @if(is_null($item->deleted_at))
                                            <tr id="trAplicarLaudos">
                                                <td>
                                                    <p>
                                                        {{$item->numero}}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p>
                                                        {{$item->questao}}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p>
                                                        {{$item->sinalizacao}}
                                                    </p>
                                                </td>
                                                <td class="procedimentos" id="{{$item->id}}">
                                                    <label class="check btn btn-success">
                                                        <input required type="radio" value="Conforme" @if(isset($monitoria) && $monitoria->itens === "Conforme") checked="true" @endif id="procedimento_{{$item->id}}" valor="{{round($item->valor*100,2)}}" name="procedimento_{{$item->id}}" title="Conforme" /> {{-- <span class="fa fa-check"></span> --}} Conforme
                                                    </label>
                                                    @if($item->valor < 1)
                                                    <label class="check btn btn-dark">
                                                        <input required type="radio" value="Não Conforme"  @if(isset($monitoria) && $monitoria->itens === "Não Conforme") checked="true" @endif id="procedimento_{{$item->id}}" valor="{{round($item->valor*100,2)}}" name="procedimento_{{$item->id}}" title="Não Conforme" /> {{-- <span class="fa fa-times"></span> --}} Não Conforme
                                                    </label>
                                                    @endif
                                                    @if($item->valor == 1 || Auth::user()->carteira_id == 1)
                                                    <label class="check btn btn-danger">
                                                        <input required type="radio" @if(isset($monitoria)) @if($monitoria->itens === "NCG") checked="true" @endif  @endif value="NCG" id="procedimento_{{$item->id}}" valor="{{round($item->valor*100,2)}}" name="procedimento_{{$item->id}}" class="NCG_{{$item->id}}" title="NCG" /> {{-- <span class="fa fa-times"></span> --}} NCG
                                                    </label>
                                                    @endif
                                                    <label class="check btn btn-secondary">
                                                        <input required type="radio" @if(isset($monitoria)) @if($monitoria->itens === "Não Avaliado") checked="true" @endif @else checked="true"  @endif value="Não Avaliado" id="procedimento_{{$item->id}}" valor="{{round($item->valor*100,2)}}" name="procedimento_{{$item->id}}" title="Não Avaliado" /> {{-- <span class="fa fa-times"></span> --}} Não Avaliado
                                                    </label>
                                                </td>
                                            </tr>
                                        @endif
                                    @empty
                                        <td colspan="4" class="text-center">Nenhum dado encontrado</td>
                                    @endforelse
                                {{-- Se não, é edição --}}
                                @elseif(isset($itens))
                                    @forelse ($itens as $item)
                                        <tr id="trAplicarLaudos">
                                            <td>
                                                <p>
                                                    {{$item->laudo->numero}}
                                                </p>
                                            </td>
                                            <td>
                                                <p>
                                                    {{$item->laudo->questao}}
                                                </p>
                                            </td>
                                            <td>
                                                <p>
                                                    {{$item->laudo->sinalizacao}}
                                                </p>
                                            </td>
                                            <td class="procedimentos" id="{{$item->laudo->id}}">
                                                <label class="check btn btn-success">
                                                    <input required type="radio" value="Conforme"  @if($item->value === "Conforme")  checked="true" @endif id="procedimento_{{$item->laudo->id}}" valor="{{round($item->laudo->valor*100,2)}}" name="procedimento_{{$item->laudo->id}}" title="Conforme"/> Conforme
                                                </label>
                                                @if($item->laudo->valor < 1)
                                                <label class="check btn btn-dark">
                                                    <input required type="radio" value="Não Conforme"  @if($item->value === "Não Conforme") checked="true" @endif id="procedimento_{{$item->laudo->id}}" valor="{{round($item->laudo->valor*100,2)}}" name="procedimento_{{$item->laudo->id}}" title="Não Conforme"/> Não Conforme
                                                </label>
                                                @endif
                                                <label class="check btn btn-danger">
                                                    <input required type="radio" @if($item->value === "NCG") checked="true" @endif value="NCG" id="procedimento_{{$item->laudo->id}}" valor="{{round($item->laudo->valor*100,2)}}" name="procedimento_{{$item->laudo->id}}" title="NCG"/> NCG
                                                </label>
                                                <label class="check btn btn-secondary">
                                                    <input required type="radio" @if($item->value !== "Não Conforme" && $item->value !== "Conforme") checked="true" @endif value="Não Avaliado" id="procedimento_{{$item->laudo->id}}" valor="{{round($item->laudo->valor*100,2)}}" name="procedimento_{{$item->laudo->id}}" title="Não Avaliado"/> Não Avaliado
                                                </label>
                                            </td>
                                        </tr>
                                    @empty
                                        <td colspan="4" class="text-center">Nenhum dado encontrado para edição</td>
                                    @endforelse
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- END laudos  --}}
                {{-- START Salvar Monitoria  --}}
                <div class="panel panel-dark">
                    <div class="panel-body">
                        <div class="form-row text-center">
                            <button type="button" class="btn btn-block btn-success" id="btnSaveMonitoriaGravar">@if (isset($monitoria)) Editar @else Gravar @endif Monitoria</button>
                        </div>
                    </div>
                </div>
                {{-- END Monitoria  --}}

            </div>
            {{-- END PAGE CONTENT WRAP --}}

        </div>
        {{-- END CONTENT FRAME  --}}

    </div>
    {{-- END PAGE CONTENT  --}}

</div>
{{-- END PAGE CONTAINER  --}}
@endsection
@section('modal')
{{-- Selecione supervisor --}}
<div class="modal in" id="modalTrue" tabindex="-1" z-index="999" role="dialog" aria-labelledby="defModalHead" aria-hidden="false" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title" id="defModalHead">Altere o Supervisor!</div>

            </div>
            <div class="modal-body">
                <div class="row">
                    <label for="supervisorselect" class="form-label">Supervisores</label>
                    <select name="supSelection" class="form-control select" id="supSelection" data-live-search="true">
                        <option value="0">Selecione um Supervisor</option>
                        @forelse ($supers as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                        @empty
                            <option value="0">Nenhum Supervisor Encontrado</option>
                        @endforelse
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-warning" id="editsupBtn" onclick="saveSup()"><span class="fa fa-pencil"> Alterar</span></button>
            </div>
        </div>
    </div>
</div>
{{-- Confirma Dados --}}
<div class="modal in" id="modalConfirm" tabindex="-1" z-index="999" role="dialog" aria-labelledby="defModalHead" aria-hidden="false" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title" id="defModalHead">Resultado da Monitoria</div>

            </div>
            <div class="modal-body">
                <input type="hidden" name="dataStoreMonitoring" id="dataStoreMonitoring">
                <div class="row">
                    <table class="table table-bordered">
                        <body>
                            <tr>
                                <th>Conforme</th>
                                <td id="resultConf"></td>
                            </tr>
                            <tr>
                                <th>Não conforme</th>
                                <td id="resultnConf"></td>
                            </tr>
                            <tr>
                                <th>Não Avaliado</th>
                                <td id="resultnAv"></td>
                            </tr>
                            <tr>
                                <th>NCG</th>
                                <td id="resultncg"></td>
                            </tr>
                            <tr>
                                <th>Media</th>
                                <td id="resultMedia"></td>
                            </tr>
                        </body>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" onclick="$('#modalConfirm').hide()">Cancelar</button>
                <button class="btn btn-success" id="btnConfirmModal" onclick="$('#modalConfirm').hide()">@if (isset($monitoria)) <span class="fa fa-pencil"> Editar @else <span class="fa fa-save"> Gravar @endif</span></button>
            </div>
        </div>
    </div>
</div>
{{-- CONFIRMAÇÃO --}}
<div class="modal in" id="modalConfirmacao" tabindex="-1" z-index="999" role="dialog" aria-labelledby="defModalHead" aria-hidden="false" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title" id="defModalHead">Sucesso!</div>
                <button type="button" class="pull-right btn btn-outline-default" onclick="$('#modalConfirmacao').hide()" data-dismiss="modal"><span class="fa fa-times"></span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="alert alert-success" id="response">Sucesso!</div>
                </div>
                <div class="row text-center">
                    <div class="col-md-12">
                        <a href="{{ asset('monitoring/manager') }}" class="btn btn-block btn-dark">
                            <span class="fa fa-home"></span>
                            Voltar ao Menu Monitoria
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('Javascript')
<script language="javascript">
    // Altera supervisor
    function saveSup() {
        supervisor = $("#supSelection").val()
        if(typeof $("select#operador").val() === 'undefined') {
            idOpe = $("input#operador").val()
        } else {
            idOpe = $("select#operador").val()
        }

        $("button#editsupBtn").html('<span class="fa fa-spinner fa-spin"></span> Alterando...')
        $.ajax({
            url: "{{route('PutUsersEditSupervisor',['user' => Auth::id()])}}",
            data: 'id='+idOpe+'&supSelection='+supervisor,
            method: "PUT",
            success: function(resp) {
                $("input#supervisor").val(resp.super)
                $("#modalTrue").hide()
                console.log(resp)
                noty({
                        text: resp.msg,
                        layout: 'topRight',
                        type: 'success',
                        timeout: 3000
                });
            },
            error: (xhr) => {
                console.log(xhr)
                noty({
                    text: 'Error! Contate o suporte.',
                    layout: 'topRight',
                    type: 'error',
                    timeout: 3000
                });

                if(responseJSON.errors) {
                    $.each(responseJSON.errors,(i,v) => {
                        noty({
                            text: v[i],
                            layout: 'topRight',
                            type: 'error',
                            timeout: 3000
                        });
                    });
                }
            }
        });
        $("#editsupBtn").html('<span class="fa fa-pencil"> Alterar</span>')
    }

    // Seleciona supervisor
    function selectSup(element) {
        selectedSup = $("#supervisor_slct"+element.value).attr('class')
        if(selectedSup == "") {
            delete selectedSup
            selectedSup = 0
        }
        if(element.value != 0) {
            $.ajax({
                url: "{{asset('api/data/user')}}/"+selectedSup,
                method: "GET",
                success: (resp) => {
                    if(resp.length > 0) {
                        return $("#supervisor").val(resp[0].name)
                    } else {
                        $("#modalTrue").show()
                    }
                },
                error: (xhr) => {
                    console.log(xhr)
                    noty({
                        text: 'Error ao salvar o supervisor! Contate o suporte.',
                        layout: 'topRight',
                        type: 'error',
                        timeout: 3000
                    })
                }
            });
        }
    }

    // Verifica se todos os campos form preenchidos corretamente
    function checkInputs() {
        //Variável de controle
        errors = Number(0)

        // checa se todos inputs estão preenchidos
        $.each($("input.monitoria"), function(i,v) {
            if($.inArray(v.value,[null,'',' ']) > -1) {
                if(v.class !== 'input-block-level') {
                    noty({
                        text: 'Preencha corretamente o campo '+$(v).attr('validate'),
                        layout: 'topRight',
                        type: 'warning',
                        timeout: 3000
                    });
                    errors += Number(1)
                }
            }
        });

        // checa Selects
        $.each($("select.monitoria"),function(i,v){
            if($.inArray(v.value,[null,'',' ',0]) > -1) {
                noty({
                    text: 'Preencha corretamente o input'+v.id,
                    layout: 'topRight',
                    type: 'warning',
                    timeout: 3000
                });
                errors += Number(1)
            }
        });

        // Checa se há algum laudo sem escolher
        $.each($("td.procedimentos"),function(i,v){
            id = v.id
            value = $("input#procedimento_"+id+":checked").val()
            if(typeof value === 'undefined') {
                errors += Number(1)
                noty({
                    text: 'Existem itens não selecionados, verifique os laudos!',
                    type: 'warning',
                    layout: 'topRight',
                    timeout: 3000
                })
                console.log('procedimento'+id+' não selecionado')
            }
        });

        if(errors === 0) {
            return 0
        } else {
            return noty({
                text: 'Preencha todos os campos corretamente!',
                type: 'warning',
                layout: 'topRight',
                timeout: 3000,
                timeOut: 3000,
            })
        }
    }

    // grava monitoria
    $("#btnSaveMonitoriaGravar").click(function() {
        html = $("button#btnSaveMonitoriaGravar").html()
        $("button#btnSaveMonitoriaGravar").html("<span class='fa fa-spinner fa-spin'></span>")
        if(checkInputs() === 0) {
            console.log('sem erro input')
            //dados monitoria
            data = $("#monitoria").serialize()
            conf = Number(0)
            nConf = Number(0)
            nAv = Number(0)
            ncg = Number(0)
            valueTotal = Number(0)
            valueConsiderar = Number(0)
            media = parseFloat(0)

            // concatena procedimentos selecionados em laudos
            procedimentos = ''

            /// dados laudos
            $.each($("td.procedimentos"),function(i,v){
                isNcg = 0
                id = v.id
                value = $("input#procedimento_"+id+":checked").val()
                valor = parseFloat($("input#procedimento_"+id+":checked").attr('valor'))

                // Conta se existe NCG
                if(value == 'NCG') {
                    ncg++
                    isNcg++
                } else {
                    // conta conformes
                    if(value == 'Conforme') {
                        conf += Number(1)
                        valueTotal += valor
                        console.log('considerar: '+valor)
                        valueConsiderar += valor
                    }

                    // conta não conformes
                    else if(value == 'Não Conforme') {
                        nConf += Number(1)
                        console.log('total: '+valor)
                        valueTotal += valor
                    }

                    // conta não conformes
                    else if(value == 'Não Avaliado') {
                        nAv += Number(1)
                    }
                }

                procedimentos += id+'|||||'+value+'|||||'+isNcg+'|||||'+(valor/100).toFixed(6)+'_____'
            });

            if(ncg === 0) {
                if(valueTotal == 0) {
                    valueTotal++
                }
                media += Number(parseFloat(((valueConsiderar/valueTotal)*100)).toFixed(2))
                if(media > 0 || media < 0) {
                    media = media
                } else {
                    media = 0
                }
            }

            $("#resultConf").html(conf)
            $("#resultnConf").html(nConf)
            $("#resultnAv").html(nAv)
            $("#resultncg").html(ncg)
            $("#resultMedia").html(media+'%')

            data += '&laudos='+procedimentos+'&media='+media+'&conf='+conf+'&nConf='+nConf+'&nAv='+nAv+'&ncg='+ncg
            $("input#dataStoreMonitoring").val(data)

            $("#btnConfirmModal").attr('onclick','storeMonitoring(@if($id > 0) 0 @else 1 @endif)')
            $("#modalConfirm").show()

        }
        $("#btnSaveMonitoriaGravar").html(html)
    });

    // Salva monitoria
    function storeMonitoring(type) {
        $('#modalConfirm').hide()
        data = $("input#dataStoreMonitoring").val()
        $("button#btnConfirmModal").prop('disabled',true)
        if(type === 0) {
            url = "{{ route('PutMonitoriaEdit', ['id' => $id, 'user' => Auth::id()]) }}"
            method = "PUT"
        } else if( type === 1) {
            url = "{{ route('PostMonitoriaStore', ['user' => Auth::id(),]) }}"
            method = "POST"
        }

        $.ajax({
                url: url,
                data: data,
                method: method,
                success: function (response) {
                        $("div#response").html(response.msg)
                        $("#modalConfirmacao").show()
                        noty({
                            text: response.msg,
                            timeout: 3000,
                            layout: 'topRight',
                            type: 'success',
                        });
                        $("button#btnConfirmModal").prop('disabled',false)
                    },
                    error: function (xhr) {
                        console.log(xhr)
                        $("button#btnConfirmModal").prop('disabled',false)
                        if(xhr.message) {
                            noty({
                                text: xhr.message,
                                timeout: 3000,
                                layout: 'topRight',
                                type: 'error',
                            });
                        } else if(xhr.responseJSON.errors) {
                            // Caso seja erro Laravel, mostra esses erros em alertas
                            $.each(xhr.responseJSON.errors,function(i,v){
                                noty({
                                    text: v,
                                    timeout: 3000,
                                    layout: 'topRight',
                                    type: 'error',
                                });
                            });
                        } else if(xhr.status == 429){
                            noty({
                                text: 'Erro de conexão!',
                                timeout: 3000,
                                layout: 'topRight',
                                type: 'error',
                            });
                        } else {
                            noty({
                                text: 'Erro! Verifique os campos e Tente novamente mais tarde.',
                                timeout: 3000,
                                layout: 'topRight',
                                type: 'error',
                            });
                        }
                    }
            });
    }

    // teste
    function testePreench() {
        try{
            $("#nome_cliente").val('teste')
            $("input#userCli").val('teste')
            $("#cpf_cliente").val('12365478950')
            $("#dt_call").val('{{date('Y-m-d')}}')
            $("input#id_audio").val('teste')
            $("#pt_pos").val('teste')
            $("#pt_dev").val('teste')
            $("#pt_att").val('teste')
            $("#feedback").val('teste')
            $("#tp_call > option").attr('selected',true)
            return 'Preenchido'
        } catch(e) {
            console.log(e)
            return 'Não preenchido'
        }
    }

    $(function(){
        $("#contentFrameMonitoring").show()
        $("#loadingPreLoader").hide()

        @if(isset($operador))
            @if(is_null($operador->supervisor))
                noty({
                    text:'Selecione um supervisor!',
                    layout: 'topRight',
                    typeo: 'warning'
                });
            @endif
        @endif
    })
</script>
@endsection
