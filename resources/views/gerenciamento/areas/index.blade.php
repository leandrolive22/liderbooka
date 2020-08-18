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
        @include('assets.components.preloaderdefault')
        <div class="content-frame" style="display: none;" id="content">

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
                        <a href="javascript:addCarteira()"><span class="fa fa-plus"></span></a>
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
                    <a href="javascript:addSetores()"><span class="fa fa-plus"></span></a>
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
                        $setoresActions = '
                        <input type="checkbox" disabled name="setores" title="_NAME_" id="setores_var_" class="form-check" value="_var_">
                        <button id="btn_setores_var_" class="btn btn-primary btn-rounded btn-sm" disabled onclick="editIlhas(_var_)">Ilhas</button>';
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
                <button class="btn btn-danger btn-block" onclick="sync('{{ route("DeleteSyncAreas") }}','DELETE')">Excluir</button>
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
{{-- ADD/SELET ISLANDS --}}
<div class="modal in" id="modalAdd" tabindex="-1" z-index="999" role="dialog" aria-labelledby="defModalHead" aria-hidden="false" style="margin-top: 15px; display: none;">
    <form onsubmit="return false;">
        @csrf
        <input type="hidden" name="modalSetor" id="modalSetor">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defModalHead">Ilhas do Setor</h4>
                    <button class="btn btn-default btn-sm pull-right" type="button" onclick="$('#typeAddModalIlha').show()"><span class="fa fa-plus"></span></button>
                </div>
                <div class="modal-body">
                    <div id="modal_Ilhas" class="list-group scroll" style="max-height: 500px;">
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
                    <button type="button" class="btn btn-secondary pull-right" onclick="$('#modalAdd').hide();$('input[name=ilhas_sync]').prop('checked',false);">Cancelar</button>
                    <button type="button" class="btn btn-success pull-right" onclick="syncIlha()">Salvar Ilhas</button>
                </div>
            </div>
        </div>
    </form>
</div>
{{-- ADD Carteira --}}
<div class="modal in" id="typeAddModal" tabindex="-1" z-index="999" role="dialog" aria-labelledby="defModalHead" aria-hidden="false" style="margin-top: 15px; display: none;">
    <form method="POST" action="{{ route('PostCreateCarteira') }}">
        @csrf
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defModalHead">Adicionar Carteiras</h4>
                </div>
                <div class="modal-body">
                    <div class="input-group">
                        <input class="form-control" name="carteira" maxlength="250" placeholder="Carteira">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary pull-right" onclick="$('#typeAddModal').hide();">Cancelar</button>
                    <button type="submit" class="btn btn-success pull-right">Salvar</button>
                </div>
            </div>
        </div>
    </form>
</div>
{{-- ADD Setores --}}
<div class="modal in" id="typeAddModalSet" tabindex="-1" z-index="999" role="dialog" aria-labelledby="defModalHead" aria-hidden="false" style="margin-top: 15px; display: none;">
    <form method="POST" action="{{ route('PostCreateSetor') }}" id="PostCreateSetor">
        @csrf
        <input type="hidden" name="setores" id="setoresH">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defModalHead">Adicionar Setores</h4>
                    <button class="btn btn-default btn-sm pull-right" type="button" id="addSetores"><span class="fa fa-plus"></span></button>
                </div>
                <div class="modal-body" id="typeModalBodySet">
                    <div class="form-group"id="carteiras_div">
                        <select name="carteira_id" class="form-control select" data-live-search="true">
                            @forelse($carteiras as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                            @empty
                            <option value="0">Nenhuma carteira encontrada</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="input-group">
                        <input class="form-control" name="setor" maxlength="250" placeholder="Setor">
                        <span class="input-group-addon bg-danger" onclick="$(this).parent().remove()">
                            <span class="fa fa-trash-o"></span>
                        </span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary pull-right" onclick="$('#typeAddModalSet').hide();">Cancelar</button>
                    <button type="button" onclick="setAndSubmit('S')" class="btn btn-success pull-right">Salvar</button>
                </div>
            </div>
        </div>
    </form>
</div>

{{-- ADD Ilhas --}}
<div class="modal in" id="typeAddModalIlha" tabindex="-1" z-index="999" role="dialog" aria-labelledby="defModalHead" aria-hidden="false" style="margin-top: 15px; display: none;">
    <form method="POST" action="{{ route('PostCreateIlha') }}" id="PostCreateIlha">
        @csrf
        <input type="hidden" name="ilhas" id="ilhasH">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defModalHead">Adicionar Ilhas</h4>
                    <button class="btn btn-default btn-sm pull-right" type="button" id="addIlhas"><span class="fa fa-plus"></span></button>
                </div>
                <div class="modal-body" id="typeModalBodyIlha">
                    <div class="form-group">
                        <select name="setores" class="form-control select" data-live-search="true">
                            @forelse($setores as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                            @empty
                            <option value="0">Nenhuma carteira encontrada</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="input-group">
                        <input class="form-control" name="ilha" maxlength="250" placeholder="Ilha">
                        <span class="input-group-addon bg-danger" onclick="$(this).parent().remove()">
                            <span class="fa fa-trash-o"></span>
                        </span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary pull-right" onclick="$('#typeAddModalIlha').hide();">Cancelar</button>
                    <button type="button" class="btn btn-success pull-right" onclick="setAndSubmit('I')">Salvar</button>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@section('Javascript')
<script type="text/javascript">
    function addCarteira() {
        $("#typeAddModal").show()
    }
    function addSetores() {
        $("#typeAddModalSet").show()
    }

    $("#addSetores").click(() => {
        $("#typeModalBodySet").append('<div class="input-group">'+
            '<input class="form-control" name="setor" maxlength="250" placeholder="Setor">'+
            '<span class="input-group-addon bg-danger" onclick="$(this).parent().remove()">'+
            '<span class="fa fa-trash-o"></span>'+
            '</span>'+
            '</div>')
    })

    $("#addIlhas").click(() => {
        $("#typeModalBodyIlha").append('<div class="input-group">'+
            '<input class="form-control" name="ilha" maxlength="250" placeholder="Ilha">'+
            '<span class="input-group-addon bg-danger" onclick="$(this).parent().remove()">'+
            '<span class="fa fa-trash-o"></span>'+
            '</span>'+
            '</div>')
    })

    function addInputType(type,auto = 1) {
        switch (type) {
            case 'C':
            linha = '<div class="input-group">'+
            '<input class="form-control" name="carteiras" id="carteiras'+$("#typeModalBody div").length+'" maxlength="250" placeholder="Carteiras">'+
            '<span class="input-group-addon bg-danger" onclick="$(this).parent().remove()">'+
            '<span class="fa fa-trash-o"></span>'+
            '</span>'+
            '</div>'
            break;
            case 'S':
            '<div class="input-group">'+
            '<input class="form-control" name="carteiras" id="setores'+$("#typeModalBody div").length+'" maxlength="250" placeholder="setores">'+
            '<span class="input-group-addon bg-danger" onclick="$(this).parent().remove()">'+
            '<span class="fa fa-trash-o"></span>'+
            '</span>'+
            '</div>'
            break;
            default:
            noty({
                text: 'Erro! Contate o suporte!',
                layout: 'topRight',
                type: 'warning',
            })
            break;
        }

        if(auto === 1) {
            return $("#typeModalBody").append(linha)
        }

        return linha
    }

    // Altera carteiras
    function changeCart(id) {
        $("input[name=ilhas_sync]").prop('checked',false)
        $("input[name=setores]").attr('checked',false)
        explode = String(id).split('_')
        if(typeof explode[1] !== 'undefined') {
            id = explode[1]
        }
        if(!in_array($("input[name=carteiras][type=radio]:checked").val())) {
            $('input[name=setores][type=checkbox]').attr('checked',false)
            getUrl = '{{ route("GetAreasgetSetoresIlhasByCart", ["carteira" => "---"]) }}'.replace('---',id)
            $.getJSON(getUrl, function (data) {
                len = data.length
                if(len > 0) {
                    for(i=0; i<len; i++) {
                        $("input#setores"+data[i].setor).prop('checked',true)
                    }
                }
            });
            $('input[name=setores][type=checkbox]').attr('disabled',false)
            $("button.btn-rounded").attr('disabled',false);
        }
    }

    // carrega ilhas
    function editIlhas(id) {
        // Desabilita botões
        $("#btn_setores"+id).attr('disabled',true);
        $("#btn_setores"+id).html('<span class="fa fa-spin fa-spinner"></span>')

        // Modal
        $("#modalSetor").val(id)
        $("input[name=ilhas_sync]").prop('checked',false)

        try {
            // Url
            url = '{{route("getIlhasEditBySetor","---")}}'.replace('---',id)

            // Busca Ilhas
            $.getJSON(url, function(data){
                len = data.length
                if(len > 0) {
                    linhas = ''
                    for(i=0; i<len; i++) {
                        $("input[setor="+data[i].setor_id+"]").prop('checked',true)
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

    // Sincroniza Ilhas
    function syncIlha() {
        ilhas = ''
        setor = $("#modalSetor").val()

        $.each($("input[name=ilhas_sync][type=checkbox]:checked"),function (i,v) {
            value = $(v).val()
            ilhas += value+'|'
        })

        if(typeof setor === 'undefined' || in_array(setor)) {
            return noty({
                text: 'Setor inválido, contate o suporte',
                layout: 'topRight',
                type: 'warning',
            })
        } else {
            data = 'ilhas='+ilhas+'&setor='+setor

            $.ajax({
                url: "{{ route('PutSyncIlhas') }}",
                method: "PUT",
                data: data,
                success: function(resp) {
                    console.log(resp)
                    try {
                        noty({
                            text: resp.successAlert,
                            layout: 'topRight',
                            type: 'success',
                        })
                    } catch (e) {
                        noty({
                            text: 'Sincronizado com sucesso',
                            layout: 'topRight',
                            type: 'success',
                        })
                        console.log(e)
                    }
                    $("#modalAdd").hide()
                },
                error: function(xhr) {
                    console.log(xhr)
                    if(typeof xhr.responseJSON.errorAlert !== 'undefined') {
                       noty({
                        text: xhr.responseJSON.errorAlert,
                        layout: 'topRight',
                        type: 'error',
                    })
                   }
                   if(typeof xhr.responseJSON.errors.setor !== 'undefined') {
                    noty({
                        text: xhr.responseJSON.errors.setor,
                        layout: 'topRight',
                        type: 'error',
                    })
                }
            }})
        }
    }


    // sincroniza carteiras e setores
    function sync(url = "{{ route('PutSyncAreas') }}",method = 'PUT') {
        error = 0
        carteira = $("input[name=carteiras][type=radio]:checked").val()
        if(typeof carteira === 'undefined') {
            return noty({
                text: 'Nenhuma Carteira Selecionada!',
                layout: 'topRight',
                type: 'warning',
            })
        } else {
            setores = ''
            if(typeof $("input[name=setores][type=checkbox]:checked").val() === 'undefined') {
                return noty({
                    text: 'Nenhum Setor Selecionado!',
                    layout: 'topRight',
                    type: 'warning',
                })
            }

            $.each($("input[name=setores][type=checkbox]:checked"),function (i,v) {
                value = $(v).val()
                setores += value+'|'
            })

            // $.each($("input[name=ilhas_sync][type=checkbox]:checked"),function (i,v) {
            //     value = $(v).val()
            //     ilhas += value+'|'
            // })

            data = 'carteira='+carteira+'&setores='+setores

            $.ajax({
                url: url,
                method: method,
                data: data,
                success: function(resp) {
                    noty({
                        text: 'Sincronizado com sucesso',
                        layout: 'topRight',
                        type: 'success'
                    })

                    if(method == "DELETE") {
                        $.each($("input[name=setores][type=checkbox]:checked"),function (i,v) {
                            $(v).parent().parent().hide().remove()
                        })
                        $("input[name=carteiras][type=radio]:checked").parent().parent().hide().remove()
                    }

                    console.log(resp)
                },
                error: function(xhr) {
                    console.log(xhr)
                    if(typeof xhr.responseJSON.errors !== 'undefined') {
                        $.each(xhr.responseJSON.errors,function(i,v) {
                            noty({
                                text: v,
                                layout: 'topRight',
                                type: 'error',
                            })
                        })
                    }
                    if(typeof xhr.responseJSON.errorAlert !== 'undefined') {
                        noty({
                            text: xhr.responseJSON.errorAlert,
                            layout: 'topRight',
                            type: 'error',
                        })
                    }
                }
            });
        }
    }

    function setAndSubmit(type) {
        if(type == 'S') {
            value = ''
            $.each($('input.form-control[name=setor]'),(i,v) => {
                value += $(v).val()+'|'
            })
            $("#setoresH").val(value)
            $("#PostCreateSetor").submit()
        } else if (type == 'I') {
            value = ''
            $.each($('input.form-control[name=ilha]'),(i,v) => {
                value += $(v).val()+'|'
            })
            $("#ilhasH").val(value)
            $("#PostCreateIlha").submit()
        }
    }

    $(() => {
        $("#preloaderDefault").hide().remove()
        $("#content").show()

    })
</script>
@endsection
