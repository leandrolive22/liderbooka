@php
    $col = 0;
	if(isset($carteiras)) {
		$col += 4;
	}
	else if(isset($carteiras) && isset($setores)) {
		$col += 4;
	}
	else if(isset($carteiras) && isset($setores) && isset($ilhas)) {
		$col += 4;
	}
@endphp

@extends('layouts.app', ["current"=>"area"])
@section('style')
<style type="text/css">

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
					<h2>
						<a href="{{ url()->previous() }}">
							<span class="fa fa-arrow-circle-o-left"></span>
						</a>
						Áreas
					</h2>
				</div>
				<div class="pull-right">
					<button class="btn btn-default content-frame-right-toggle">
						<span class="fa fa-bars"></span>
					</button>
				</div>
				<!-- END CONTENT FRAME TOP -->

			</div>
			<!-- END CONTENT FRAME TOP-->

			<!-- START CONTENT FRAME LEFT -->
			<div class="col-lg-12 col-md-12 col-sm-12">
				<div class="row">
					<div class="panel panel-dark">
						<div class="col-lg-{{$col}} col-md-{{$col}} col-sm-{{$col}}">
							<div class="panel-heading">
								<div class="panel-title">
                                    Carteiras
                                </div>
                                <ul class="panel-controls">
                                    <li>
                                        <a href="javascript:add('C')"><span class="fa fa-plus"></span></a>
                                    </li>
                                </ul>
							</div>
							<div class="panel-body">
                                <div style="max-height: 300px; overflow-y: auto">
                                    <table class="table table-bordered" >
                                        <thead>
                                            <tr>
                                                <th>
                                                    ID
                                                </th>
                                                <th>
                                                    Nome
                                                </th>
                                                <th>
                                                    Selecionar
                                                </th>
                                            </tr>
                                        </thead>
                                        @php
                                            $carteirasActions = '<input type="radio" onchange="changeCart(_var_)" name="carteiras" id="carteiras_var_" class="form-check" value="_var_">';
                                        @endphp
                                        <tbody id="bodycarteirast">
                                            @if(isset($carteiras))
                                                @component('assets.components.tableObj',['actions' => $carteirasActions, 'columns' => ['id','name',''], 'data' => $carteiras, 'idTr' => 'carteiras'])
                                                @endcomponent
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
							</div>
						</div>
						<div class="col-lg-{{$col}} col-md-{{$col}} col-sm-{{$col}}">
							<div class="panel-heading">
								<div class="panel-title">
									Setores
                                </div>
                                <ul class="panel-controls">
                                    <li>
                                        <a href="javascript:add('S')"><span class="fa fa-plus"></span></a>
                                    </li>
                                </ul>
							</div>
							<div class="panel-body">
                                <div style="max-height: 300px; overflow-y: auto">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>
                                                    ID
                                                </th>
                                                <th>
                                                    Nome
                                                </th>
                                                <th>
                                                    Selecionar
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="bodysetorest">
                                            @php
                                                $setoresActions = '<input type="checkbox" disabled name="setores" title="_NAME_" id="setores_var_" class="form-check" value="_var_">';
                                            @endphp
                                            @if(isset($setores))
                                                @component('assets.components.tableObj',['actions' => $setoresActions, 'columns' => ['id','name',''], 'data' => $setores, 'idTr' => 'setores'])
                                                @endcomponent
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
							</div>
						</div>
						<div class="col-lg-{{$col}} col-md-{{$col}} col-sm-{{$col}}">
							<div class="panel-heading">
								<div class="panel-title">
									Ilhas
                                </div>
                                <ul class="panel-controls">
                                    <li>
                                        <a href="javascript:add('I')"><span class="fa fa-plus"></span></a>
                                    </li>
                                </ul>
							</div>
							<div class="panel-body">
                                <div style="max-height: 300px; overflow-y: auto">
                                    <table class="table table-bordered" >
                                        <thead>
                                            <tr>
                                                <th>
                                                    ID
                                                </th>
                                                <th>
                                                    Nome
                                                </th>
                                                <th>
                                                    Selecionar
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody id="bodyilhast">
                                            @php
                                                $ilhasActions = '<select multiple size="2" name="ilhas" id="ilhas_var_" disabled class="form-check"></select>';
                                            @endphp
                                            @if(isset($ilhas))
                                                @component('assets.components.tableObj',['actions' => $ilhasActions, 'columns' => ['id','name',''], 'data' => $ilhas, 'idTr' => 'ilhas'])
                                                @endcomponent
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
							</div>
						</div>
					</div>
                </div>
                <div class="row">
                    <div class="panel panel-dark">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                Ações
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="col-md-6">
                                <button class="btn btn-danger btn-block">Excluir</button>
                            </div>
                            <div class="col-md-6">
                                <button class="btn btn-primary btn-block" onclick="sync()">Sincronizar</button>
                            </div>
                        </div>
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

@section('modal')
{{--
<div class="modal in" id="modalAdd" tabindex="-1" z-index="999" role="dialog" aria-labelledby="defModalHead" aria-hidden="false" style="margin-top: 15px; display: block;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defModalHead">Inserir</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="name"></label>
                    <input type="text" id="name">
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger pull-right" onclick="$('#modalAdd').hide()">Cancelar</button>
                <button type="button" class="btn btn-outline-success pull-right" onclick="#">Salvar</button>
            </div>
        </div>
    </div>
</div>
--}}
@endsection

@section('Javascript')
<script type="text/javascript">
    function add(type) {
        switch (type) {
            case 'C':
                url = "{{ __('') }}"
                tbody = 'bodycarteirast'
                idTr = 'carteiras'
                input = '<input type="radio" onchange="changeCart(_var_)" name="carteiras" id="new_carteiras_var_" class="form-check" value="_var_">'
                break;
            case 'S':
                url = "{{ __('') }}"
                tbody = 'bodysetorest'
                idTr = 'setores'
                input = '<input type="checkbox" name="setores" id="new_setores_var_" class="form-check" value="_var_">'
                break;

            case 'I':
                url = "{{ __('') }}"
                tbody = 'bodyilhast'
                idTr = 'ilhas'
                input = '<input type="checkbox" name="ilhas" id="new_ilhas_var_" class="form-check" value="_var_">'
                break;
            default:
                noty({
                    text: 'Erro! Contate o suporte!',
                    layout: 'topRight',
                    type: 'warning',
                })
                break;
        }

        n = 'newAdd_'+$("#"+tbody+" tr").length
        newIdTr = "idTr"+idTr

        linhas = '<tr id="'+newIdTr+'">'+
                    '<td>#</td>'+
                    '<td><input name="newAdd" id="'+n+'"></td>'+
                    '<td>'+input.replace('_var_',$("#"+tbody+" tr").length)+'</td>'+
                '</tr>';


        linhas += $("#"+tbody).html()

        $("#"+tbody).html(linhas)
    }

    function changeCart(id) {
        explode = String(id).split('_')
        if(typeof explode[1] !== 'undefined') {
            id = explode[1]
        }
        if(!in_array($("input[name=carteiras][type=radio]:checked").val())) {
            getUrl = '{{ route("GetAreasgetSetoresIlhasByCart", ["carteira" => "---"]) }}'.replace('---',id)
            $.getJSON(getUrl, function (data) {
                len = data.length
                if(len > 0) {
                    for(i=0; i<len; i++) {
                        $("input#setores"+data[i].setor).attr('checked',true)
                        $("select#ilhas"+data[i].ilha).attr('disabled',false)
                        $("select#ilhas"+data[i].ilha).append('<option> value="'+data[i].setor+'">'+$("select#ilhas"+data[i].ilha).attr('title')+'</option>')

                    }
                }
            });
            $('input[name=setores][type=checkbox]').attr('disabled',false)
            $('select[name=ilhas]').attr('disabled',false)
        }
    }

    function sync() {
        error = 0
        carteira = $("input[name=carteiras][type=radio]:checked").val()
        if(typeof carteira === undefined) {
            noty({
                    text: 'Nenhuma Carteira Selecionada!',
                    layout: 'topRight',
                    type: 'warning',
            })
        } else {
            ilhas = ''
            setores = ''
            $.each($("input[name=setores][type=checkbox]:checked"),function (i,v) {
                value = $(v).val()
                setores += value+'|'
            })

            $.each($("input[name=ilhas][type=checkbox]:checked"),function (i,v) {
                value = $(v).val()
                ilhas += value+'|'
            })

            data = 'carteira='+carteira+'&setores='+setores+'&ilhas='+ilhas
            console.log(data)
        }
    }
</script>
@endsection
