<div class="modal-body" style="overflow-y: auto; max-height:500px;">
    <div class="panel panel-default">
        <div class="panel-body">
            <input type="hidden" name="idModal" value="0" id="idModal">
            <div class="form-row col-md-12">
                <div class="form-group col-md-6">
                    <label for="datelaudo">Data do Laudo</label>
                    <input class="form-control pull-right" type="hidden" id="datelaudo">
                </div>
                <div class="form-group col-md-6">
                    <label for="hash_monitoria">Hash da Monitoria</label>
                    <input class="form-control pull-right" type="hidden" id="hash_monitoria" >
                </div>
            </div>
            <div class="form-row col-md-12">
                <div class="form-group col-md-6">
                    <label for="monitor">Monitor</label>
                    <input class="form-control" type="hidden" id="monitor">
                    <p id="monitor"></p>
                </div>
                <div class="form-group col-md-6">
                    <label for="supervisor">Supervisor</label>
                    <input class="form-control" type="hidden" @if(Auth::user()->cargo_id == 4) value="{{Auth::user()->name}}" @else id="supervisor" @endif>
                    <p id="supervisor"></p>
                </div>
            </div>
            <div class="form-row col-md-12">
                <div class="form-group col-md-6">
                    <label for="operador">Operador</label>
                    <input class="form-control" type="hidden" id="operador">
                    <p id="operador"></p>
                </div>
                <div class="form-group col-md-6">
                    <label for="userCli">Usuário-Cliente</label>
                    <input class="form-control" type="hidden" id="userCli">
                    <p id="userCli"></p>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="form-row col-md-12">
                <div class="form-group col-md-4">
                    <label for="user">Cliente</label>
                    <input class="form-control" type="hidden" id="cliente">
                    <p id="cliente"></p>
                </div>
                <div class="form-group col-md-4">
                    <label for="user">CPF do Cliente</label>
                    <input class="form-control" type="hidden" id="cpf">
                    <p id="cpf"></p>
                </div>
                <div class="form-group col-md-4">
                    <label for="monitor">Produto</label>
                    <input class="form-control" type="hidden" id="produto">
                    <p id="produto"></p>
                </div>
            </div>
            <div class="form-row col-md-12">
                <div class="form-group col-md-6">
                    <label for="monitor">ID do Audio</label>
                    <input class="form-control" type="hidden" id="id_audio">
                    <p id="id_audio"></p>
                </div>
                <div class="form-group col-md-6">
                    <label for="tipo_ligacao">Tipo de Ligação</label>
                    <input class="form-control" type="hidden" id="tipo_ligacao">
                    <p id="tipo_ligacao"></p>
                </div>
            </div>
            <div class="form-row col-md-12">
                <div class="form-group col-md-6">
                    <label for="user">Tempo da Ligação</label>
                    <input class="form-control" type="hidden" id="tempo_ligacao">
                    <p id="tempo_ligacao"></p>
                </div>
                <div class="form-group col-md-6">
                    <label for="monitor">Data da Ligação</label>
                    <input class="form-control" type="hidden" id="data_call">
                    <p id="data_call"></p>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="form-row col-md-12">
                <div class="form-group col-md-4">
                    <label for="user">Pontos Positivos</label>
                    <input class="form-control" type="hidden" id="pontos_positivos">
                    <p id="pontos_positivos"></p>
                </div>
                <div class="form-group col-md-4">
                    <label for="monitor">Pontos a Desenvolver</label>
                    <input class="form-control" type="hidden" id="pontos_desenvolver">
                    <p id="pontos_desenvolver"></p>
                </div>
                <div class="form-group col-md-4">
                    <label for="monitor">Pontos de Atenção</label>
                    <input class="form-control" type="hidden" id="pontos_atencao">
                    <p id="pontos_atencao"></p>
                </div>
            </div>
            <div class="form-row col-md-12">
                <div class="form-group col-md-4">
                    <label for="user">Feedback do Monitor</label>
                    <textarea class="form-control" @if(Auth::user()->cargo_id == 15) @else type="hidden" @endif id="feedback_monitor"></textarea>
                </div>
                <div class="form-group col-md-4">
                    <label for="monitor">Feedback do Supervisor</label>
                    <textarea class="form-control" @if(Auth::user()->cargo_id == 4) @else type="hidden" @endif id="feedback_supervisor"></textarea>
                </div>
                <div class="form-group col-md-4">
                    <label for="monitor">Feedback do Operador</label>
                    <textarea class="form-control" type="hidden" id="feedback_operador"></textarea>
                </div>
            </div>
            <div class="form-row col-md-12">
                <div class="form-group col-md-3">
                    <label for="conf">Conformes</label>
                    <input class="form-control" type="hidden" id="conf">
                    <p id="conf"></p>
                </div>
                <div class="form-group col-md-3">
                    <label for="nConf">Não conformes</label>
                    <input class="form-control" type="hidden" id="nConf">
                    <p id="nConf"></p>
                </div>
                <div class="form-group col-md-3">
                    <label for="nAv">Não avaliado</label>
                    <input class="form-control" type="hidden" id="nAv">
                    <p id="nAv"></p>
                </div>
                <div class="form-group col-md-3">
                    <label for="media">Média (%)</label>
                    <input class="form-control" type="hidden" id="media">
                    <p id="media"></p>
                </div>
            </div>
        </div>
        <div class="panel-body">
            <div class="form-row col-md-12">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Numero</th>
                            <th>Pergunta</th>
                            <th>Sinalização</th>
                            <th>Procedimento</th>
                        </tr>
                    </thead>
                    <tbody id="laudos">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
