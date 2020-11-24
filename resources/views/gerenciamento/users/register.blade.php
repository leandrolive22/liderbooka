<form role="form" id="createUserForm">
    <div class="modal in" id="modalInsertUser" tabindex="-1" role="dialog" aria-labelledby="defModalHead" aria-hidden="false" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defModalHead"><b>Registrar usuário</b></h4>
                    <button type="button" class="close" onclick="$('#modalInsertUser').hide()" data-dismiss="modal">
                        <span aria-hidden="true">×</span><span class="sr-only">Close</span>
                    </button>
                </div>
                <div class="modal-body" style="overflow-y: auto; max-height:80vh;">
                    <div class="row" id="registerFormDiv">
                        <div class="form-group col-md-12">
                            @csrf
                            <div class="form-group col-md-12">
                                <label class="col-md-2 control-label">Nome</label>
                                <input class="form-control col-md-8" id="name" name="name">
                            </div>
                            <div class="form-group col-md-12">
                                <label class="col-md-2 control-label">Username</label>
                                <input class="form-control col-md-8" id="username" name="username">
                                <label for="username" class="text-muted" style="font-size:10px; margin-left:18%;">*A Senha padrão é: Book2020@lidera</label>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="col-md-2 control-label">Matricula</label>
                                <input class="form-control col-md-8" maxlength="8" type="number" id="matricula" name="matricula">
                            </div>
                            <div class="form-group col-md-12">
                                <label class="col-md-2 control-label">Data de Admissão</label>
                                <input class="form-control col-md-8" type="date" id="data_admissao" name="data_admissao">
                            </div>
                            {{-- <div class="form-group col-md-12">
                                <label class="col-md-2 control-label">CPF</label>
                                <input type="number" class="form-control col-md-8" maxlength="11" id="cpf" name="cpf">
                            </div> --}}
                            <div class="form-group col-md-12">
                                <label class="col-md-2 control-label">Segmento</label>
                                <select data-live-search="true" class="form-control col-md-8" name="carteira_id" id="carteira_id" onchange="onChangeSelect()">
                                    {{-- Carteiras --}}
                                    @foreach($carteiras as $carteira)
                                    <optgroup label="Carteira: {{$carteira->name}}">
                                        {{-- Setores --}}
                                        @foreach($setores as $setor)
                                        {{-- Checa se o setor pertence à carteira --}}
                                        @if($setor->carteira_id === $carteira->id)
                                            <optgroup label="-> Setor: {{$setor->name}}">
                                                @foreach($ilhas as $ilha)
                                                {{-- Checa se a ilha pertence ao setor --}}
                                                @if($ilha->setor_id === $setor->id)
                                                    <option value="{{$ilha->id}}">
                                                        Produto: {{$ilha->name}}
                                                    </option>
                                                @endif
                                                @endforeach
                                            </optgroup>
                                        @endif
                                        @endforeach
                                    </optgroup>

                                    @endforeach
                                </select>
                            </div>
                            {{-- <div class="form-group col-md-12" id="setor_idDiv">
                                <label class="col-md-2 control-label">Setor</label>
                                <select data-live-search="true" class="form-control col-md-8" name="setor_id" id="setor_id" onchange="getIlhas(this)">
                                    <option value="-" id="noMoreSetor">Nenhum Setor Encontrado</option>
                                </select>
                            </div>
                            <div class="form-group col-md-12" id='ilhaDiv'>
                                <label class="col-md-2 control-label">Ilha</label>
                                <select data-live-search="true" class="form-control col-md-8" name="ilha_id" id="ilha_id" onchange="onChangeSelect();">
                                    <option id="noMoreI">Nenhuma Ilha Encontrada</option>
                                </select>
                            </div> --}}
                            <div class="form-group col-md-12" id='cargoDiv'>
                                <label class="col-md-2 control-label">Cargo</label>
                                <select data-live-search="true" class="form-control col-md-8" name="cargo_id" id="cargo_id" onchange="onChangeSelect();">
                                    <option>Selecione um Cargo</option>
                                    @forelse ($cargos as $cargo)
                                    <option value="{{$cargo->id}}">{{$cargo->description}}</option>
                                    @empty
                                    <option value="-">Nenhum Cargo Encontrado</option>
                                    @endforelse
                                </select>
                            </div>
                            <input type="hidden" name="carteira_id" value="1">
                            <div class="form-group col-md-12">
                                <label class="col-md-2 control-label">Supervisor</label>
                                <select data-live-search="true" class="form-control col-md-8" name="superior_id" id="superior_id">
                                    <option id="noMoreSup" value="">Selecione um Supervisor</option>
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="col-md-2 control-label">Coordenador</label>
                                <select data-live-search="true" class="form-control col-md-8" name="coordenador_id" id="coordenador_id">
                                    <option id="noMoreCoord" value="">Selecione um Coordenador</option>
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="col-md-2 control-label">Gerente</label>
                                <select data-live-search="true" class="form-control col-md-8" name="manager_id" id="manager_id">
                                    @forelse ($gerentes as $g)
                                    <option value="{{$g->id}}">{{$g->name}}</option>
                                    @empty
                                    <option value="-">Nenhum Gerente Encontrado</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="col-md-2 control-label">Superintendente</label>
                                <select data-live-search="true" class="form-control col-md-8" name="sup_id" id="sup_id">
                                    @forelse ($superintendentes as $superintendente)
                                    <option value="{{ $superintendente->id }}">{{ $superintendente->name }}</option>
                                    @empty
                                    <option id="noMoreSuper" value="0">Nenhum Superintendente Disponível</option>
                                    @endforelse
                                </select>
                            </div>
                            <input type="hidden" name="id" value="{{Auth::user()->id}}">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="$('#modalInsertUser').hide()">Cancelar</button>
                    <button type="button" id="sendUserBtn" class="btn btn-primary">Salvar</button>
                </div>
            </div>
        </div>
    </div>
</form>
