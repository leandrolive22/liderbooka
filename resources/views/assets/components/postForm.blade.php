<div class="content-frame-top" style="z-index: 1;">
    <!-- START NEW RECORD -->
    <div class="panel panel-primary panel-toggled">
        <div class="panel-heading ui-draggable-handle">
            <div class="panel-title-box">
                <h3>Publicações</h3>
            </div>
            <ul class="panel-controls">
                <li><a href="#" class="panel-collapse"><span class="fa fa-angle-up"></span></a></li>
            </ul>
        </div>
        <div class="panel-body" >
            <form class="form-horizontal" id="newPOSTForm" onsubmit="return false">
                @csrf
                <div class="form-group">
                    <div class="col-md-12">
                        {{-- <label class="text-danger" style="font-size: 10px">Por motivos de manutenção, os uploads devem ser feitos via chamado <a target="_blank" href="https://suporte.ativy.com">neste link</a></label> --}}
                        <label class="row">Conteúdo</label>
                        <div class="input-group row" style="min-height: 70px">
                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                            <textarea class="form-control"  style="min-height: 70px" name="descript" id="descriptPOST" maxlength="500" placeholder="Fale com a Liderança!"></textarea>
                            {{-- EMOJIS <span class="input-group-addon bg-light text-dark"> <a data-container="body" data-toggle="popover" data-placement="bottom" data-content="" ><span class="fa fa-smile-o fa-3x"></span></a></span> --}}
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-4">
                        <label class="row">Ilhas</label>
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-group"></span></span>
                            <button class="btn form-control" onclick="$('#modalUpdate').show()">Selecionar Ilhas</button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="row">Cargos</label>
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-group"></span></span>
                            <button class="btn form-control" onclick="$('#modalUpdate').show()">Selecionar Cargos</button>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="col-md-6">Prioridade</label>
                        <div class="input-group">
                            <span class="input-group-addon"><span class="fa fa-exclamation-circle"></span></span>
                            <select class="form-control  select" name="priority" id="priorityPOST">
                                <option value="3">Prioridade Regular</option>
                                <option value="2">Prioridade Alta</option>
                                <option value="1">Prioridade Extrema</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-12">
                        <label class="row">Imagens ou Vídeos</label>
                        <a class="file-input-wrapper btn btn-{{Auth::user()->css}} fileinput btn-primary col-md-1" style='text-align:center; margin-right: 1%;'>
                            <span class="fa fa-camera" style='color:white'></span>
                            <input type="file" name="file_path" id="file_pathPOST">
                            <span class='file-input-name'></span>
                        </a>
                        <p id="file_pathPOSTName" class="form-control">Selecione o arquivo para a publicação (imagens ou Vídeos)</p>
                        <br>
                        <div class="pull-right">
                            <button type="submit" id="submitPostForm" class="btn btn-primary"><span class="fa fa-share"></span> Enviar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Preloader Post -->
        <div class="panel-body text-center" id="POSTPreloader" style="display:none">
            <p class="text center">Publicando...</p>
            <div class="spinner-grow text-dark" role="status"style="width: 5rem; height: 5rem;">
                <span class="sr-only"></span>
            </div>
            <br>
            <br>
        </div>
    </div>
    <!-- END NEW RECORD -->

</div>
@section('modal')
<div class="modal in" id="modalUpdate" tabindex="-1" z-index="999" role="dialog" aria-labelledby="defModalHead" aria-hidden="false" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defModalHead">Selecionar ilhas e cargos</h4>
            </div>
            <div class="modal-body">

                <div class="col-md-6">
                    <label class="row">Ilhas</label>
                    <div class="input-group">
                        <span class="input-group-addon"><span class="fa fa-group"></span></span>
                        <select multiple="true" class="form-control select" multiple name="ilha_id" id="ilha_idPOST" data-live-search="true">
                            <option value="0">Nenhuma</option>
                            <option value="1">Para toda a Empresa</option>
                            @forelse ($ilhas as $ilha)
                            <option value="{{ $ilha->id }}" z-index="99">{{ $ilha->name }}</option>
                            @empty
                            <option>Nenhuma Ilha Disponível</option>
                            @endforelse
                        </select>
                    </div>
                </div>
                <div class="col-md-4">
                    <label class="row">Cargos</label>
                    <div class="input-group">
                        <span class="input-group-addon"><span class="fa fa-group"></span></span>
                        <select multiple="true" class="form-control select" multiple name="cargo_id" id="cargo_idPOST" data-live-search="true">
                            <option value="0">Nenhum</option>
                            @forelse ($cargos as $data)
                            <option value="{{ $data->id }}" z-index="99">{{ $data->name }}</option>
                            @empty
                            <option>Nenhuma Ilha Disponível</option>
                            @endforelse
                        </select>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="$('#modalUpdate').hide()" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
@endsection