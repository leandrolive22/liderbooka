@extends('layouts.app', ["current"=>"wiki"])
@section('style')
<style type="text/css">
    /**
    * jQuery Flexdatalist basic stylesheet.
    *
    * Version:
    * 2.2.1
    *
    * Github:
    * https://github.com/sergiodlopes/jquery-flexdatalist/
    *
    */
    .flexdatalist-results {
        position: absolute;
        top: 0;
        left: 0;
        border: 1px solid #444;
        border-top: none;
        background: #fff;
        z-index: 100000;
        max-height: 300px;
        overflow-y: auto;
        box-shadow: 0 4px 5px rgba(0, 0, 0, 0.15);
        color: #333;
        list-style: none;
        margin: 0;
        padding: 0;
    }
    .flexdatalist-results li {
        border-bottom: 1px solid #ccc;
        padding: 8px 15px;
        font-size: 14px;
        line-height: 20px;
    }
    .flexdatalist-results li span.highlight {
        font-weight: 700;
        text-decoration: underline;
    }
    .flexdatalist-results li.active {
        background: #2B82C9;
        color: #fff;
        cursor: pointer;
    }
    .flexdatalist-results li.no-results {
        font-style: italic;
        color: #888;
    }

    /**
    * Grouped items
    */
    .flexdatalist-results li.group {
        background: #F3F3F4;
        color: #666;
        padding: 8px 8px;
    }
    .flexdatalist-results li .group-name {
        font-weight: 700;
    }
    .flexdatalist-results li .group-item-count {
        font-size: 85%;
        color: #777;
        display: inline-block;
        padding-left: 10px;
    }

    /**
    * Multiple items
    */
    .flexdatalist-multiple:before {
        content: '';
        display: block;
        clear: both;
    }
    .flexdatalist-multiple {
        width: 100%;
        margin: 0;
        padding: 0;
        list-style: none;
        text-align: left;
        cursor: text;
    }
    .flexdatalist-multiple.disabled {
        background-color: #eee;
        cursor: default;
    }
    .flexdatalist-multiple:after {
        content: '';
        display: block;
        clear: both;
    }
    .flexdatalist-multiple li {
        display: inline-block;
        position: relative;
        margin: 5px;
        float: left;
    }
    .flexdatalist-multiple li.input-container,
    .flexdatalist-multiple li.input-container input {
        border: none;
        height: auto;
        padding: 0 0 0 4px;
        line-height: 24px;
    }

    .flexdatalist-multiple li.value {
        display: inline-block;
        padding: 2px 25px 2px 7px;
        background: #eee;
        border-radius: 3px;
        color: #777;
        line-height: 20px;
    }
    .flexdatalist-multiple li.toggle {
        cursor: pointer;
        transition: opacity ease-in-out 300ms;
    }
    .flexdatalist-multiple li.toggle.disabled {
        text-decoration: line-through;
        opacity: 0.80;
    }

    .flexdatalist-multiple li.value span.fdl-remove {
        font-weight: 700;
        padding: 2px 5px;
        font-size: 20px;
        line-height: 20px;
        cursor: pointer;
        position: absolute;
        top: 0;
        right: 0;
        opacity: 0.70;
    }
    .flexdatalist-multiple li.value span.fdl-remove:hover {
        opacity: 1;
    }
</style>
@endsection
@section('content')
<!-- START PAGE CONTAINER -->
<div class="page-container">


	<!-- PAGE CONTENT -->
	<div class="page-content">

		@component('assets.components.x-navbar')
		@endcomponent

		<!-- START CONTENT FRAME -->
		<div class="content-frame">

			<!-- START CONTENT FRAME TOP -->
			<div class="content-frame-top">
				<div class="page-title">
					<a href="{{ url()->previous() }}">
						<h2><span class="fa fa-arrow-circle-o-left"></span> Wiki</h2>
					</a>
				</div>
				<div class="pull-right">
					<button class="btn btn-default content-frame-right-toggle">
						<span class="fa fa-bars"></span>
					</button>
				</div>
				<!-- END CONTENT FRAME TOP -->

			</div>
			<!-- END CONTENT FRAME TOP-->

			<!-- START CONTENT FRAME RIGHT -->
			@include('assets.components.updates')
			<!-- END CONTENT FRAME RIGHT -->

			<!-- START CONTENT FRAME LEFT -->
			<div class="content-frame-body content-frame-body-left">
				{{-- cabeçalho --}}
				<div class="row">
					<div class="panel panel-colorful">
						<div class="panel-body col-md-1">
							<button class="btn btn-block btn-primary"><span class="fa fa-plus"> </span></button>
						</div>
						<div class="col-md-11">
							@forelse($tipos as $item)
							<div class="panel-body col-md-3">
								<button class="btn btn-block btn-default dropdown-toggle" data-toggle="dropdown">{{$item->name}}</button>
								<ul class="dropdown-menu" role="menu">
									<li role="presentation" class="dropdown-header">Ações</li>
									<li><a href="javascript:insertMaterial({{$item->id}})">Adicionar Material</a></li>
									<li><a href="#">Editar Categoria</a></li>
									<li><a href="#" class="text-danger"><span class="fa fa-warning"></span>Excluir Categoria</a></li>
								</ul>
							</div>

							@empty
							@endforelse
						</div>
					</div>
				</div>

				{{-- materiais --}}
				<div class="row text-center">
					@forelse($tipos as $item)
                    <div class="col-sm-3 p-1">
					<div class="panel panel-light">
						<div class="panel-heading">
							<div class="panel-title">
								{{$item->name}}
								{{-- <button class="btn btn-sm btn-primary"><span class="fa fa-plus"> </span></button> --}}
							</div>
						</div>
						<div class="panel-body">
                            <div class="list-group">
							@forelse($item->materiais->take(10) as $material)
                            @php
                            $actions =  '<div class="list-group">';
                            $actions =      "<button onclick='seeMaterial(".$material->id.")' title='Visualizar' class='list-group-item btn-primary col-md-12'> <span class='fa fa-eye'></span></button>";
                            $actions .=     "<button onclick='editInfoMaterial(".$material->id.")' title='Editar Informações' class='list-group-item btn-warning col-md-12'> <span class='fa fa-warning'></span></button>";
                            $actions .=     "<button onclick='editFilterMaterial(".$material->id.")' title='Editar Filtros' class='list-group-item btn-warning col-md-12'> <span class='fa fa-filter'></span></button>";
                            $actions .=     "<button onclick='editFileMaterial(".$material->id.")' title='Editar Tags' class='list-group-item btn-warning col-md-12'> <span class='fa fa-file'></span></button>";
                            $actions .=     "<button onclick='deleteMaterial(".$material->id.")' title='Excluir' class='list-group-item btn-danger  col-md-12'> <span class='fa fa-trash-o'></span></button>";
                            $actions .= '</div>';
                            @endphp
                            <button class="list-group-item text-left" data-toggle="popover" title="Ações" data-content="@php echo $actions @endphp" data-html="true">
                                <b>#{{$material->id}}</b> - {{$material->name}}
                            </button>
							@empty
							@endforelse
                            </div>
						</div>
					</div>
                    </div>
					@empty
					@endforelse
				</div>
			</div>
		</div>
		<!-- END CONTENT FRAME LEFT -->
	</div>
	<!-- START CONTENT FRAME -->

</div>
<!-- END PAGE CONTENT -->
</div>
<!-- END PAGE CONTAINER -->
@endsection
@section('Javascript')
<script src="{{ asset('js/plugins/flexdatalist/jquery.flexdatalist.js') }}"></script>
<script type="text/javascript" id="pageJs">
    // abre modal para inserir material
	function insertMaterial(tipo_id, id = 0, text = 'Inserir Material') {
		$("input#insertUpdateMaterialId").val(id)
		$("input#insertUpdatetipo_id").val(tipo_id)
        $("input#title").val('')
        $("input#tags").val('')
        $("input#material_file").val('')
        $("h4#insertUpdatedefModalHead.modal-title").html(text)
		$("div#insertUpdateMaterial").show()
	}

    function seeMaterial(id) {
        $.getJSON(url, function(data) {
            
        })
    }
    

    function editInfoMaterial(id) {
        $.getJSON(url, function(data) {
            
        })
    }
    
    
    function editFilterMaterial(id) {
        $.getJSON(url, function(data) {
            
        })
    }

    
    function editFileMaterial(id) {
        $.getJSON(url, function(data) {
            
        })
    }

    
    function deleteMaterial(id) {
        $.getJSON(url, function(data) {
            
        })
    }

    function syncFiltros(id) {
        // altera botão
        $("#setFiltrosModalBtn").html('<span class="fa fa-spinner fa-spin"></span>')
        $("#setFiltrosModalBtn").prop('disabled',true)
        $("#setFiltrosModalBtn").prop('enabled',false)

        // pega dados filtros
        $.each()

        console.log(formdata)

        // Envia dados para o controller
        $.ajax({
            url: '{{ route("syncMaterial") }}',
            data: formdata,
            method: "POST",
            processData: false,
            contentType: false,
            success: function(data) {
                msg = xhr.responseJSON

                if(msg) {
                    noty({
                        text: msg.successAlert,
                        layout: 'topRight',
                        type: 'success'
                    });
                    

                    noty({
                        text: msg.errorAlert,
                        layout: 'topRight',
                        type: 'error'
                    })
                }
            },
            error: function(xhr) {
                console.log(xhr)
                msg = xhr.responseJSON.errorAlert
                if(msg) {
                    noty({
                        text: msg,
                        layout: 'topRight',
                        type: 'error'
                    })
                }
            }
        });

        // Restaura botão e mostra modal
        $("#setFiltrosModalBtn").html('Salvar')
        $("div#setFiltrosModal").hide()
        $("#setFiltrosModalBtn").prop('disabled',false)
        $("#setFiltrosModalBtn").prop('enabled',true)
    }

    // sincroniza permissões de ilhas
    function syncFiltro(id, type) {
        $("#setFiltrosModalBtnilhas"+type).html('<span class="fa fa-spinner fa-spin"></span>')
        $("#setFiltrosModalBtnilhas"+type).prop('disabled',true)
        $("#setFiltrosModalBtnilhas"+type).prop('enabled',false)
        if(type === 'ilhas') {
            todos = $("input#ilha_0:checked").val()
            idAll = 'ilha'
        } else if(type === 'cargos') {
            todos = $("input#cargo_0:checked").val()
            idAll = 'cargo'
        }

        
        if(typeof todos !== 'undefined') {
            $("input[name="+type+"]:checked").prop('checked',false)
            $("input#"+idAll+"_0").prop('checked',true)
            data='todos=1'
        } else {
            data='todos=0'
            ids = '&ids='

            // Pega ids das ilhas 
            $.each($("input[name="+type+"]:checked"), (i,v) => {
                value = v.value
                console.log(value)
                ids += value+','
            })

            data += ids
        }   

        data += '&type='+type
        data += '&material_id='+id

        $.ajax({
            url: '{{ route("syncFiltros") }}',
            method: 'PUT',
            data: data,
            success: function(data) {
                noty({
                    text: data.successAlert,
                    layout: 'topRight',
                    type:'success'
                });

                try {
                    noty({
                        text: data.warningAlert,
                        layout: 'topRight',
                        type:'warning'
                    });
                } finally {
                    console.log(data)
                }
            },
            error: function(xhr) {
                try {
                    noty({
                        text: xhr.responseJSON.errorAlert,
                        layout: 'topRight',
                        type:'warning'
                    });
                } finally {
                    console.log(xhr)
                }
            }
        })

        $("#setFiltrosModalBtnilhas"+type).html('Salvar')
        $("#setFiltrosModalBtnilhas"+type).prop('disabled',false)
        $("#setFiltrosModalBtnilhas"+type).prop('enabled',true)

    }

    // Datalist
    $('.flexdatalist').flexdatalist({
        selectionRequired: false,
        minLength: 1
    });

    $(() => {
        @if(session('material_id_success'))
            $("#setFiltrosModalId").val({{session('material_id_success')}})
            $("div#setFiltrosModal").show()
            noty({
                text: 'Material sincronizado com successo!',
                layout: 'topRight',
                type:'success'
            });
        @endif
    })

</script>
@endsection
@section('modal')
{{-- Inserir materiais --}}
<form method="POST" id="insertUpdateMaterialForm" enctype="multipart/form-data" method="POST" action="{{ route("syncMaterial") }}">
	@csrf
	<input type="hidden" required name="id" id="insertUpdateMaterialId" value="0">
	<input type="hidden" required name="tipo_id" id="insertUpdatetipo_id" value="3">
	<div class="modal in" id="insertUpdateMaterial" tabindex="-1" role="dialog" aria-labelledby="insertUpdatedefModalHead" aria-hidden="false" style="display: none;">
		<div class="modal-dialog modal-lg">
			<div class="modal-content" style="overflow-y: scroll;">
				<div class="modal-header">
					<h4 class="modal-title" id="insertUpdatedefModalHead">Monitoria</h4>
					<button type="button" class="close" onclick="javascript:$('#insertUpdateMaterial').hide()" data-dismiss="modal">
						<span aria-hidden="true">×</span>
						<span class="sr-only">Close</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="title">Título / Assunto</label>
						<input required required type="text" name="title" class="form-control" id="title" placeholder="Título / Assunto">
					</div>
                    <div class="form-group">
                        <label for="description">Descrição</label>
                        <input required required type="text" name="description" class="form-control" id="description" placeholder="Descrição / use '#' para hashtags">
                    </div>
					<div class="form-group">
						<label for="tags">Categorias em Tags</label>
						<input required type='text'
                            placeholder='Tags'
                            class='flexdatalist'
                            data-min-length='1'
                            multiple
                            data-selection-required='0'
                            list='tagsdataList'
                            name='tags'
                            id="tags">

                        <datalist id="tagsdataList">
                            <option value="$item->id">$item->name</option>
                            @foreach ($tags as $item)
                            <option value="{{$item->name}}">{{$item->name}}</option>
                            @endforeach
                        </datalist>
					</div>
					<div class="panel panel-default form-group">
						<div class="panel-body">
							<h3><span class="fa fa-mail-forward"></span> Selecionar Material</h3>
							<div class="form-group">
								<div class="col-md-12">
									<label>Selecione a Material</label>
									<input required type="file" name="material_file" id="material_file"/>
								</div>
							</div>
						</div>
					</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="$('#insertUpdateMaterial').hide()">Fechar</button>
                    <button type="button" onclick="$('form#insertUpdateMaterialForm').submit();$('#insertUpdateMaterialBtnB').hide();$('#insertUpdateMaterialBtnSpan').show();" class="btn btn-success" id="insertUpdateMaterialBtn">
                        <b id="insertUpdateMaterialBtnB">Salvar</b>
                        <span class="fa fa-spinner fa-spin" style="display: none;" id="insertUpdateMaterialBtnSpan"></span>
                    </button>
                </div>
			</div>
		</div>
	</div>
</form>

{{-- Configurar filtros --}}
<form onsubmit="return false" method="POST" id="setFiltrosModalForm" enctype="multipart/form-data">
	@csrf
	<input type="hidden" name="material_id" id="setFiltrosModalId" value="{{ !is_null(session('material_id_success')) ? session('material_id_success') : 0}}">
	<div class="modal in" id="setFiltrosModal" tabindex="-1" role="dialog" aria-labelledby="setFiltrosModaldefModalHead" aria-hidden="false" style="display: none;">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
                    <div class="alert alert-success" role="alert">
                        Material #{{session('material_id_success')}} incluído com sucesso! Selecione seus Filtros:
                    </div>
                    {{-- <h4 class="modal-title" id="setFiltrosModaldefModalHead"> para o {{session('material_id_success')}} </h4> --}}
					<button type="button" class="close" onclick="javascript:$('#setFiltrosModal').hide()" data-dismiss="modal">
						<span aria-hidden="true">×</span>
						<span class="sr-only">Close</span>
					</button>
				</div>
				<div class="modal-body">
                    {{-- cargos --}}
					<div class="form-group col-sm-6" style="overflow-y: scroll; max-height: 60vh">
                        <label for="cargo_0" class="form-label">Cargos</label>
                        <div class="list-group">
                            <div class="list-group-item">Todos <input checked type="checkbox" class="form-check pull-right" name="cargos" id="cargo_0" value="0"></div>
                            @foreach ($cargos as $item)
                            <div class="list-group-item">{{$item->description}} <input type="checkbox" class="form-check pull-right" name="cargos" id="cargo_{{$item->id}}" value="{{$item->id}}"></div>
                            @endforeach
                            <button class="list-group-item btn btn-primary" id="setFiltrosModalBtncargos" onclick="syncFiltro({{session('material_id_success')}}, 'cargos')">Salvar</button>
                        </div>
                    </div>
                    {{-- Ilhas --}}
                    <div class="form-group col-sm-6" style="overflow-y: scroll; max-height: 60vh">
                        <label for="ilha_0" class="form-label">Ilhas</label>
                        <div class="list-group">
                            <div class="list-group-item">Todos <input checked type="checkbox" class="form-check pull-right" name="ilhas" id="ilha_0" value="0"></div>
                            @foreach ($ilhas as $item)
                            <div class="list-group-item">{{$item->name}} <input type="checkbox" class="form-check pull-right" name="ilhas" id="ilha_{{$item->id}}" value="{{$item->id}}"></div>
                            @endforeach
                            <button class="list-group-item btn btn-primary" id="setFiltrosModalBtnilhas" onclick="syncFiltro({{session('material_id_success')}}, 'ilhas')">Salvar</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="$('#setFiltrosModal').hide()">Fechar</button>
                </div>
			</div>
		</div>
	</div>
</form>
@endsection
