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
                                                $setoresActions = '<input type="checkbox" disabled name="setores" id="setores_var_" class="form-check" value="_var_">';
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
                                                $ilhasActions = '<input type="checkbox" disabled name="ilhas" id="ilhas_var_" class="form-check" value="_var_">';
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
                                <button class="btn btn-primary btn-block">Sincronizar</button>
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
                break;
            case 'S':
                url = "{{ __('') }}"
                tbody = 'bodysetorest'
                idTr = 'setores'
                break;

            case 'I':
                url = "{{ __('') }}"
                tbody = 'bodyilhast'
                idTr = 'ilhas'
                break;
            default:
                noty({
                    text: 'Erro! Contate o suporte!',
                    layout: 'topRight',
                    type: 'warning',
                })
                break;
        }

        n = $("#"+tbody+" tr").length
        newIdTr = "idTr"+idTr

        linha = '<tr id="'+newIdTr+'">'+
            '<td>#ID Automático</td>'+
            '<td><input name="newAdd" id="newAdd'+n+'"></td>'+
            '<td></td>'+
        '</tr>';

        $("#"+tbody).append(linhas)
    }

    function changeCart(id) {
        if(!in_array($("input#carteiras"+id+"[name=carteiras][type=radio]"))) {
            $.getJSON(getUrl, function (data) {
                if(data['setores'].length > 0 && data['ilhas'].length > 0) {
                    $('input[name=setores][type=checkbox]').attr('disabled',false)
                    $('input[name=ilhas][type=checkbox]').attr('disabled',false)
                }

            });
        }
    }
</script>
@endsection
