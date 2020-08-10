<form action="{{ $urlPut }}" method="POST" class="form-horizontal" id="formWikiUpdate" enctype="multipart/form-data">
	@csrf
	@method('PUT')
	<input type="hidden" name="idEdit" id="idEdit">
	<div class="modal in" id="modalupdateWiki" tabindex="-1" z-index="999" role="dialog" aria-labelledby="defModalHead" aria-hidden="false" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="defModalHead">
						Editar 
						<b id="tipeEdit"></b>
					</h4>
				</div>
				<div class="modal-body">
					<div class="panel panel-dark tabs">
						<ul class="nav nav-tabs" role="tablist">
							<li class="active">
								<a href="#tab-first" role="tab" data-toggle="tab">Dados do Material</a>
							</li>
							<li>
								<a href="#tab-second" role="tab" data-toggle="tab">Visualizações</a>
							</li>
						</ul>
						<div class="panel-body tab-content">
							<div class="tab-pane active" id="tab-first">
								<div class="form-group">
									<label class="form-label" for="nameEdit">
										Nome
									</label>
									<input class="form-control" id="nameEdit" name="nameEdit">
								</div>
								<div class="form-group">
									<label class="form-label" for="tagsEdit">
										Tags
									</label>
									<input class="tagsinput" id="tagsEdit" name="tagsEdit" placeholder="HashTags do material">
								</div>
								
								@if(strtoupper($type) === 'CIRCULAR')
								<div class="form-group">
									<label class="form-label" for="yearEdit">
										Ano
									</label>
									<select class="form-control" id="yearEdit" name="yearEdit">
										@for($i=date('Y'); $i >= 2017; $i--)
										<option value="{{$i}}">{{$i}}</option>
										@endfor
									</select>
								</div>
								<div class="form-group">
									<label class="form-label" for="yearEdit">
										Status
									</label>
									<select class="form-control" id="statusEdit" name="statusEdit">
										@php
										$option = ['Vigente', 'Revisada'];
										@endphp

										@for($i=0; $i < count($option); $i++)
										<option value="{{$option[$i]}}">{{$option[$i]}}</option>
										@endfor
									</select>
								</div>
								@endif
								<div class="form-group">
									<label class="form-label" for="fileEdit">
										Arquivo
									</label>
									<input type="file" class="form-control" id="fileEdit" name="fileEdit">
								</div>
							</div>
							<div class="tab-pane" id="tab-second">
								<div class="form-group">
									<label class="form-label" for="islandEdit">
										Ilhas
									</label>
									<select class="form-control select" data-live-search="true" multiple="true" id="islandEdit" name="islandEdit">
										<option value="N_A" selected="">Não Alterar</option>
										@forelse ($ilhas as $ilha)
										<option class="island_{{ $ilha->id }}" value="{{ $ilha->setor_id }}|{{ $ilha->id }}">{{ $ilha->setor->name }} | {{ $ilha->name }}</option>
										@empty
										<option value="0">Nenhuma ilha encontrada</option>
										@endforelse
									</select>
								</div>
								<div class="form-group">
									<label for="cargo_idEdit">Cargos</label>
									<select multiple required class="form-control select" id="cargo_idEdit" name="cargo_idEdit">
										<option value="N_A" selected="">Não Alterar</option>
										<option value="all">Todos</option>
										@forelse($cargos as $cargo)
										<option value="{{$cargo->id}}">{{$cargo->description}}</option>
										@empty
										<option class="cargo_{{ $cargo->id }}" value="0">Nenhum Cargo Encontrada</option>
										@endforelse
									</select>
								</div>
							</div>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" onclick="$('#modalupdateWiki').hide()" data-dismiss="modal">Cancelar</button>
				<button class="btn btn-success" id="saveChangesBtn">Salvar</button>
			</div>
		</div>
	</div>
</div>
</form>