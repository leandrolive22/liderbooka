<div class="modal-body" style=" max-height:300px;">
    <div class="panel panel-default">
        <div class="panel-body">
            <input type="hidden" name="idModal" value="0" id="idModal">
            <div class="form-row col-md-12">
                <div class="form-group col-md-6">
                    <label for="datelaudo" class=" pull-left">Data do Laudo</label>
                    <p class="myParagraph pull-left" type="hidden" id="datelaudo"></p>
                </div>
                <div class="form-group col-md-6">
                    <label for="hash_monitoria">Hash da Monitoria</label>
                    <p class="myParagraph pull-right" type="hidden" id="hash_monitoria"></p>
                </div>
            </div>
            <div class="form-row col-md-12">
                <div class="form-group col-md-6">
                    <label for="monitor">Monitor</label>
                    <p class="myParagraph" id="monitor"></p>
                </div>
                <div class="form-group col-md-6">
                    <label for="supervisor">Supervisor</label>
                    <p class="myParagraph" id="supervisor"></p>
                </div>
            </div>
            <div class="form-row col-md-12">
                <div class="form-group col-md-6">
                    <label for="operador">Operador</label>
                    <p class="myParagraph" id="operador"></p>
                </div>
                <div class="form-group col-md-6">
                    <label for="userCli">Usuário-Cliente</label>
                    <p class="myParagraph" id="userCli"></p>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="form-row col-md-12">
                <div class="form-group col-md-4">
                    <label for="user">Cliente</label>
                    <p class="myParagraph" id="cliente"></p>
                </div>
                <div class="form-group col-md-4">
                    <label for="user">CPF do Cliente</label>
                    <p class="myParagraph" id="cpf"></p>
                </div>
                <div class="form-group col-md-4">
                    <label for="monitor">Produto</label>
                    <p class="myParagraph" id="produto"></p>
                </div>
            </div>
            <div class="form-row col-md-12">
                <div class="form-group col-md-6">
                    <label for="monitor">ID do Audio</label>
                    <p class="myParagraph" id="id_audio"></p>
                </div>
                <div class="form-group col-md-6">
                    <label for="tipo_ligacao">Tipo de Ligação</label>
                    <p class="myParagraph" id="tipo_ligacao"></p>
                </div>
            </div>
            <div class="form-row col-md-12">
                <div class="form-group col-md-6">
                    <label for="user">Tempo da Ligação</label>
                    <p class="myParagraph" id="tempo_ligacao"></p>
                </div>
                <div class="form-group col-md-6">
                    <label for="monitor">Data da Ligação</label>
                    <p class="myParagraph" id="data_call"></p>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="form-row col-md-12">
                <div class="form-group col-md-4">
                    <label for="user">Pontos Positivos</label>
                    <p class="myParagraph" id="pontos_positivos"></p>
                </div>
                <div class="form-group col-md-4">
                    <label for="monitor">Pontos a Desenvolver</label>
                    <p class="myParagraph" id="pontos_desenvolver"></p>
                </div>
                <div class="form-group col-md-4">
                    <label for="monitor">Pontos de Atenção</label>
                    <p class="myParagraph" id="pontos_atencao"></p>
                </div>
            </div>
            <div class="form-row col-md-12">
                <div class="form-group col-md-4">
                    <label for="user">Feedback do Monitor</label>
                    <p class="myParagraph col-md-10" style="min-height: 20px" id="feedback_monitor"></p>
                </div>
                <div class="form-group col-md-4">
                    <label for="monitor">Feedback do Supervisor</label>
                    @if(Auth::user()->cargo_id == 4)
                    <textarea class="myParagraph col-md-10" placeholder="Digite aqui o feedback" style="border-color: red" id="feedback_supervisor"></textarea>
                    @else
                    <p class="myParagraph col-md-10" id="feedback_supervisor"></p>
                    @endif
                </div>
                <div class="form-group col-md-4">
                    <label for="monitor">Feedback do Operador</label>
                    @if(Auth::user()->cargo_id == 5)
                    <textarea class="myParagraph col-md-10" placeholder="Digite aqui sua resposta" style="border-color: red" id="feedback_operador"></textarea>
                    @else
                    <p class="myParagraph col-md-10" id="feedback_operador"></p>
                    @endif
                </div>
            </div>
            <div class="form-row col-md-12">
                <div class="form-group col-md-3">
                    <label for="conf">Conformes</label>
                    <p class="myParagraph" id="conf"></p>
                </div>
                <div class="form-group col-md-3">
                    <label for="nConf">Não conformes</label>
                    <p class="myParagraph" id="nConf"></p>
                </div>
                <div class="form-group col-md-3">
                    <label for="nAv">Não avaliado</label>
                    <p class="myParagraph" id="nAv"></p>
                </div>
                <div class="form-group col-md-3">
                    <label for="media">Média (%)</label>
                    <p class="myParagraph" id="media"></p>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="form-row col-md-12">
                <table class="table table-hover">
                    <thead>
                        <tr>
                           <th>{{env('N_MON')}}</th>
                           <th>{{env('QUEST_MON')}}</th>
                           <th>{{env('CAT_MON')}}</th>
                           <th>{{env('PROCED_MON')}}</th>
                       </tr>
                   </thead>
                   <tbody id="laudos">

                   </tbody>
               </table>
           </div>
       </div>
    </div>
    <div class="panel-footer flex-row-reverse">
        <button type="button" id="closeModal" onclick="$('#modalMonitoring').hide()" class="btn btn-dark">Fechar</button>
        @if(in_array(1,session('permissionsIds')) || in_array(19, session('permissionsIds')) || Auth::user()->cargo_id == 4)
        {{-- BTNS SUPERVISOR --}}
        @if(in_array(21,session('permissionsIds')))
        <button type="button" id="ContestSupModal" data-container="body" data-toggle="popover" data-placement="top" data-content="{{$popoverHtml}}" data-html="true" class="btn btn-danger">Contestar</button>
        @endif
        @if(Auth::user()->cargo_id == 4)
        <button type="button" id="GravarSupModal" onclick="saveFeedbackSupervisorMonitoring()" class="btn btn-success">Gravar FeedBack</button>
        @endif
        @elseif(in_array(1,session('permissionsIds')) || in_array(21, session('permissionsIds')) || Auth::user()->cargo_id === 5)
        @php
        $hash2 = md5('Eu, '.Auth::user()->name.' discordo com a monitoria acima').date('Ymd').'-'.'2';
        $hash1 = md5('Eu, '.Auth::user()->name.' discordo com a monitoria acima').date('Ymd').'-'.'1';
        @endphp

        {{-- BTNS Resposta Operador --}}
        <button type="button" id="closeModal" id="btnMo2" onclick="saveFeedbackOperatorMonitoring(2,'{{$hash2}}')" class="btn btn-danger"
        data-toggle="tooltip" data-placement="top"
        data-original-title="Eu, {{Auth::user()->name}} discordo com a monitoria acima / Hash: {{ $hash2 }}">Discordar</button>

        <button type="button" id="closeModal" id="btnMo1" onclick="saveFeedbackOperatorMonitoring(1,'{{$hash1}}')" class="btn btn-success"
        data-toggle="tooltip" data-placement="top"
        data-original-title="Eu, {{Auth::user()->name}} concordo com a monitoria acima / Hash: {{ $hash1 }}">Concordar</button>
        @endif
    </div>
</div>