@extends('layouts.app', ["current"=>"monitor"])
@section('style')
<style type="text/css">
	#myTd {
        height: 100%;
        padding: 0px;
    }

    .tdInput {
        width: 100%;
        height: 100%;
        border: 0px;
        padding: 10px;
    }

    #myBtn {
        width: 100%;
        height: 100%;
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
			<div class="page-content-wrap panel-body">
				<div class="page-title">
					<a href="{{ url()->previous() }}">
						<h2 class="page-title">
							<span class="fa fa-arrow-circle-o-left">
                            </span>
                            Criar Modelo de Monitoria
                        </h2>
                    </a>
                </div>
                {{-- START PAGE BODY --}}
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Laudos
                        </h3>
                    </div>
                    <div class="panel-body">
                        {{-- titulo da monitoria  --}}
                        <div class="form-group col-md-12">
                            <div class="input-group col-md-12">
                                <span class="input-group-addon">Título</span>
                                <input type="text" id="title" name="title" class="form-control" placeholder="Escreva o titulo da monitoria">
                            </div>
                            <div class="input-group col-md-12">
                                <span class="input-group-addon">Tipo de Laudo</span>
                                <input type="text" id="type" name="type" class="form-control" placeholder="Escreva o tipo da monitoria">
                            </div>
                        </div>

                        <input type="hidden" id="lines" value="0">
                        {{-- Tabela de itens  --}}
                        <table class="table col-md-12">
                            <thead>
                                <tr>
                                    <th>Nº</th>
                                    <th>Pergunta</th>
                                    <th>Sinalização</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody id="laudosCreate">
                            {{-- o name nos TR é para tratamentos em javascript --}}
                            </tbody>
                            <tfoot>
                                <td colspan="5">
                                    <button class="btn btn-light btn-block" onclick="addLine($('input#lines').val())">
                                        <span class="fa fa-plus"></span>
                                        Adicionar Linha
                                    </button>
                                </td>
                            </tfoot>
                        </table>
                        <div class="form-row" id="btn">
                        </div>
                    </div>
                </div>
                {{-- END PAGE BODY --}}
            </div>

        </div>
        <!-- END CONTENT FRAME TOP -->

    </div>
    <!-- PAGE CONTENT -->

</div>
@endsection
@section('modal')
<div class="modal in" id="modalTrue" tabindex="-1" z-index="999" role="dialog" aria-labelledby="defModalHead" aria-hidden="false" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title" id="defModalHead">Sucesso!</div>
                <button type="button" class="pull-right btn btn-outline-default" onclick="$('#modalTrue').hide()" data-dismiss="modal"><span class="fa fa-times"></span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="alert alert-success" id="response"></div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <a href="#" id="applyBtn" class="btn btn-block btn-primary">
                            <span class="fa fa-flag"></span>
                            Aplicar Monitoria?
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{ asset('monitoring/manager') }}" class="btn btn-block btn-dark">
                            <span class="fa fa-home"></span>
                            Voltar ao Menu Monitoria
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('Javascript')
    <script type="text/javascript">
        // Adiciona linhas
        function addLine(n) {
            // monta linha
            linha = '<tr name="linhas" id="'+n+'">'+
                        '<td id="myTd">'+
                            '<input class="tdInput" name="tdInput" id="number_'+n+'" placeholder="0.0.0" type="text">'+
                        '</td>'+
                        '<td id="myTd">'+
                            '<input class="tdInput" name="tdInput" id="pergunta_'+n+'" placeholder="Escreva aqui sua pergunta" type="text">'+
                        '</td>'+
                        '<td id="myTd">'+
                            '<input class="tdInput" name="tdInput" id="sinal_'+n+'" placeholder="Tipo de sinalização" type="text">'+
                        '</td>'+
                        '<td id="myTd">'+
                            '<button id="myBtn" class="btn btn-danger btn-block" onclick="deleteLine('+n+')">'+
                                '<span class="fa fa-trash-o"></span>'+
                            '</button>'+
                        '</td>'+
                    '</tr>'

            // soa numero de linhas
            newNumber = Number(n)+1

            // Coloca nova contagem de linhas
            $("input#lines").val(newNumber)

            // Coloca linha na tabela
            $("tbody#laudosCreate").append(linha)

            vrfBtn()
        }

        // verifica se existem linhas na tabela
        function vrfBtn() {
            // Se tabela tem linha, disponibiliza botão salvar, senão, exclui botão
            if($("tbody#laudosCreate > tr").length > 0) {
                $("#btn").html('<button class="btn btn-success btn-block" id="btnSave" onclick="saveMonitoring()">Salvar</button>')
            } else {
                $("#btn").html('')
            }
        }

        // Remove linha
        function deleteLine(n) {
            $("tr#"+n).hide().remove()
            vrfBtn()
        }

        // registra modelos
        function saveMonitoring() {
            $("#btnSave").html('<span class="fa fa-spinner fa-spin"></span>')
            // Variavel de controles de errors
            error = Number(0)

            // Instancia array
            laudos = ''

            //pega linhas
            $.each($("tr[name=linhas]"),function(i,v){
                // id da linha
                id = v.id

                // dados dos inputs
                number = $("input#number_"+id+".tdInput").val()

                pergunta = $("input#pergunta_"+id+".tdInput").val()

                sinal = $("input#sinal_"+id+".tdInput").val()

                // Verifica campos vazios
                if($.inArray(number,[null,'',' ']) > -1 || $.inArray(pergunta,[null,'',' ']) > -1 || $.inArray(sinal,[null,'',' ']) > -1) {
                    error += Number(1)
                }

                // Instancia array
                linha = new Array()

                // Numero
                linha.push(number)

                // Pergunta
                linha.push(pergunta)

                // Sinalização
                linha.push(sinal)

                // Laudos de monitoria
                laudos += linha+'_______________'
            })

            if($.inArray($("input#type").val(),[null,'',' ','undefined']) > -1) {
                noty({
                    text: 'Preecha o campo Tipo de Laudo corretamente',
                    layout: 'topRight',
                    type: 'warning',
                    timeout: 3000,
                    timeOut: 3000
                });
            }

            // em caso de erro, lança notificação
            if(error > 0) {
                noty({
                    text: 'Por favor, preencha todos os campos corretamente!',
                    layout: 'topRight',
                    type: 'warning',
                    timeout: 3000,
                    timeOut: 3000
                });
            } else {
                dados = 'laudos='+laudos+'&title='+$("#title").val()+'&tipo_monitoria='+$("#type").val()+'&valor='+((1/$("tbody#laudosCreate > tr").length).toFixed(6))
                console.log(dados)
                $.ajax({
                    url: "{{ route('PostLaudosStore',['user' => Auth::id()]) }}",
                    data: dados,
                    method: "POST",
                    success: function (response) {
                        console.log(response)
                        $("div#response").html(response.msg)
                        $("#applyBtn").attr('href','{{asset("monitoring/toApply")}}/'+response.id+'/')
                        $("#modalTrue").show()
                        $("#btnSave").html('Salvar')

                    },
                    error: function (xhr) {
                        $("#btnSave").html('Salvar')
                        console.log(xhr)
                        if(xhr.responseJSON.errors) {
                            // Caso seja erro Laravel, mostra esses erros em alertas
                            $.each(xhr.responseJSON.errors,function(i,v){
                                noty({
                                    text: v,
                                    timeout: 3000,
                                    layout: 'topRight',
                                    type: 'error',
                                });
                            });
                        } else if(xhr.status == 429){
                            noty({
                                text: 'Erro de Conexão!',
                                timeout: 3000,
                                layout: 'topRight',
                                type: 'error',
                            });
                        } else {
                            noty({
                                text: 'Erro! Tente novamente mais tarde.',
                                timeout: 3000,
                                layout: 'topRight',
                                type: 'error',
                            });
                        }
                    }
                })
            }
        }
    </script>
@endsection
