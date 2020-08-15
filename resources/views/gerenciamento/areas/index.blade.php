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
						<div class="col-lg-6 col-md-6 col-sm-6">
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
                        <div class="col-lg-6 col-md-6 col-sm-6">
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
                                    $setoresActions = '<input type="checkbox" disabled name="setores" title="_NAME_" id="setores_var_" class="form-check" value="_var_"><button id="btn_setores_var_" class="btn btn-primary btn-rounded btn-sm" onclick="editIlhas(_var_)">Ilhas</button>';
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

<div class="modal in" id="modalAdd" tabindex="-1" z-index="999" role="dialog" aria-labelledby="defModalHead" aria-hidden="false" style="margin-top: 15px; display: none;">
    <form action="syncIlhas" method="POST">
        @csrf
        <input type="hidden" name="modalSetor" id="modalSetor">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defModalHead">Ilhas do Setor</h4>
                </div>
                <div class="modal-body">
                    <div id="modal_Ilhas" class="list-group scroll" style="overflow-y: scrool">
                        @forelse($ilhas as $item)
                        <div class="list-group-item">
                            <label for="name" class="form-label">{{$item->name}}</label>
                            <input class="form-check pull-right" type="checkbox" id="ilha_{{$item->id}}" name="ilhas_sync" setor="{{$item->setor_id}}" value="{{$item->id}}">
                        </div>
                        @empty
                        N/A
                        @endforelse
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger pull-right" onclick="$('#modalAdd').hide()">Cancelar</button>
                    <button type="button" class="btn btn-outline-success pull-right" onclick="#">Salvar</button>
                </div>
            </div>
        </div>
    </form>
</div>

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
        $("input[name=setores]").attr('checked',false)
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
                    }
                }
            });
            $('input[name=setores][type=checkbox]').attr('disabled',false)
            $('select[name=ilhas]').attr('disabled',false)
        }
    }

    function editIlhas(id) {
        // Desabilita botões
        $("#btn_setores"+id).attr('disabled',true);
        $("#btn_setores"+id).html('<span class="fa fa-spin fa-spinner"></span>')

        // Modal
        $("#modalSetor").val(id)

        try {
            // Url
            url = '{{route("getIlhasEditBySetor","---")}}'.replace('---',id)

            // Busca Ilhas
            $.getJSON(url, function(data){
                len = data.length
                if(len > 0) {
                    linhas = ''
                    for(i=0; i<len; i++) {
                        $("input[setor="+data[i].setor_id+"]").attr('checked',true)
                    }
                    $("#modalAdd").show()
                } else {
                    noty({
                        text: 'Nenhuma ilha encontrada!',
                        layout: 'topRight',
                        type: 'warning',
                    });
                }
            });
        } catch (e) {
            console.log('Error: '+e)
        }

        // Habilita botões
        $("#btn_setores"+id).html('Ilhas')
        $("#btn_setores"+id).attr('disabled',false);
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
