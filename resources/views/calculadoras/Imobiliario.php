
<!DOCTYPE html>
<html lang="br">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Calculadora</title>
	<link rel="shortcut icon" href="objetos/imagens/favicon.ico" type="image/x-icon">
	<link rel="icon" href="objetos/imagens/favicon.ico" type="image/x-icon">
	<link href="objetos/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="objetos/plugins/awesome/css/font-awesome.min.css" rel="stylesheet">
	<link href="objetos/plugins/notification/bs4.pop.css" rel="stylesheet">
	<link href="objetos/style.css" rel="stylesheet">
</head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.min.js"></script>
<script src="objetos/jquery/jquery.min.js"></script>
<script src="objetos/plugins/popper/popper.min.js"></script>
<script src="objetos/bootstrap/js/bootstrap.min.js"></script>
<script src="objetos/plugins/notification/bs4.pop.js"></script>
<script src="objetos/plugins/priceformat/jquery.price_format.min.js"></script>
<script src="objetos/funcoes.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.js"></script>
<!-- <script src="objetos/funcoes.js"></script> -->
<input id="fatorTotal" value="0" type="hidden">
<div  id="corpototal">
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<ul class="navbar-nav mr-auto">
			<a href="#" class="navbar-brand">
				<img src="objetos/imagens/logo.png" width="30" height="30" alt="">
				<img src="objetos/imagens/Desenvolvimento.png" width="30" height="30" alt="">
				<img src="https://www.meioemensagem.com.br/wp-content/uploads/2018/03/Santander_NovaMarca_575.png" width="100" height="50" alt="">
			</a>
			<li class="navbar-brand float-right">
				<strong>SIMULADOR - RENEGOCIAÇÃO CI</strong>
			</li>
		</ul>
		<div class="btn-group col-md-2">
			<button class="btn btn-xl btn-danger my-2 my-sm-0" data-toggle="modal" data-target="#montreal">MONTREAL</button>
			<button onclick="javascript:window.reload()" class="btn btn-xl btn-danger my-2 my-sm-0">LIMPAR</button>
		</div>
	</nav>
	<div class="page-container">
		<div class="col-md-12">

			<!-- Coluna esquerda  -->
			<div class="col-md-5 float-left">
				<div class="row" style="margin-bottom: 5%">
					<!-- header  -->
					<div class="input-group">
						<p class="btn col-md-6"><b style="color: red">TIPO DA OFERTA</b></p>
						<select name="tpOferta" id="tpOferta" class="form-control select">
							<option value="reneg_ci" selected="true">Renegociação + CI</option>
						</select>
					</div>
					<!-- ./header  -->

				</div>
				<div class="row">
					<p class="btn col-md-12"><b style="color: red">DADOS ATUAIS CLIENTE</b></p>
				</div>
				<div class="row">
					<table class="table">
						<tbody>
							<tr>
								<td>DATA DO CÁLCULO</td>
								<td><p><?php echo date('d/m/Y') ?></p></td>
							</tr>
							<tr>
								<td>Saldo Atual</td>
								<td><input type="text" class="form-control " id="sdAtual"  disabled="disabled"></td>

							</tr>
							<tr>
								<td>PRAZO (meses)</td>
								<td><input type="text" class="form-control " id="prazomeses"  disabled="disabled"></td>
							</tr>
							<tr>
								<td>DIA DO VENCIMENTO</td>
								<td><input type="text" class="form-control " id="vencimentos"  disabled="disabled"></td>
							</tr>
							<tr>
								<td>TAXA DE JUROS a.a. (Montreal)</td>
								<td><input type="text" class="form-control " id="taxajurosmontreas"  disabled="disabled"></td>
							</tr>
							<tr>
								<td><b style="color: red">TAXA DE JUROS a.a. (Efetiva)</b></td>
								<td><input type="text" class="form-control " id="taxaefetiva"  disabled="disabled"></td>
							</tr>
							<tr>
								<td colspan="2"></td>
							</tr>
							<tr>
								<td>SEGURO - <b style="color: red">MIP</b></td>
								<td><input type="text" class="form-control " id="mipseguro"  disabled="disabled"></td>
							</tr>
							<tr>
								<td>SEGURO <b style="color: red">DFI</b></td>
								<td><input type="text" class="form-control " id="dfiseguro"  disabled="disabled"></td>
							</tr>
							<tr>
								<td>TSA</td>
								<td><input type="text" class="form-control " id="tsaseguro"  disabled="disabled"></td>
							</tr>
							<tr>
								<td>PRESTAÇÃO</td>
								<td><input type="text" class="form-control " id="prestacao2"  disabled="disabled"></td>
							</tr>
							<tr>
								<td>SISTEMA DE AMORTIZAÇÃO</td>
								<td id="sistAmt">PRICE</td>
							</tr>
							<tr>
								<td colspan="2"></td>
							</tr>
							<tr>
								<td><strong>ENCARGO ATUAL IMOB</strong></td>
								<td><input type="text" class="form-control" id="imobencargo" disabled="disabled"></td>
							</tr>
							<tr>
								<td colspan="2"></td>
							</tr>
						</table>
					</div>
					<button class="btn btn-danger btn-block btn-xl" data-toggle="modal" data-target="#people">People</button>
				</div>
				<!-- ./Coluna esquerda  -->
				<!-- Coluna direita  -->
				<div class="col-md-6 float-right">
					<div class="row">
						<p class="btn col-md-12"><b style="color: red">RESUMO DA SIMULAÇÃO REORG</b></p>
						<table class="table col-md-12">
							<tr>
								<td><strong>SALDO TOTAL A REFINANCIAR</strong></td>
								<td>
									<div class="input-group mb-3">
										<div class="input-group-prepend">
											<span class="input-group-text">R$</span>
										</div>
										<input  type="number"  id="saldoreorg" onblur="calcular();$('#prazominimo2').trigger('focus');calcTable()" class="form-control">
									</div>
								</td>
							</tr>
							<tr>
								<td><b style="color: red">Parcela Total Inicial (6 meses)</b></td>
								<td><input type="number" id="parcelaTotalIni" READONLY="true" maxlenght="5" class="form-control" ></td>
							</tr>
							<tr>
								<td><strong>VALOR INCREMENTAL (6 meses)</strong></td>
								<td>
									<input type="text" disabled="disabled" id="valorincremental"  class="form-control col-md-6">
								</td>
							</tr>
							<tr>
								<td><b style="color: red" >Prazo Minimo</b></td>
								<td class="input-group">
									<input type="text" class="form-control col-md-6" id="prazominimo1" value="3" disabled="disabled">

									<input type="number" id="prazominimo2" onblur="calcular();calcTable()" class="form-control col-md-6">
								</td>
							</tr>
							<tr>
								<td><b style="color: red">MODALIDADE</b></td>
								<td><input type="text" class="form-control" id="modalidade" disabled="disabled"></td>
							</tr>
						</table>
					</div>
					<div class="row">
						<p class="btn col-md-12">
							<b style="color: red">RESUMO DA SIMULAÇÃO IMOB</b>
						</p>
						<table class="table col-md-12">
							<thead>
								<tr style="font-size: 10px;">
									<td>
										<b style="font-style: italic; color: red">Parcelas Carenciadas</b>
									</td>
									<td>
										<strong>Valor a ser Pago</strong>
									</td>
									<td>
										<strong>Data de Vencimento</strong>
									</td>
								</tr>
							</thead>
							<tbody id="carenciaTable">
								<tr>
									<td class="bg-danger text-white"><b>1 Mês de Carência</b></td>
									<td id="pmtCarencia1">R$ 0,00</td>
									<td id="dataCarencia1"> <?php echo date('d/m/Y') ?></td>
								</tr>
								<tr>
									<td class="bg-danger text-white"><b>2 Mês de Carência</b></td>
									<td id="pmtCarencia2">R$ 0,00</td>
									<td id="dataCarencia2"> <?php echo date('d/m/Y', strtotime('+1 Month')) ?></td>
								</tr>
								<tr>
									<td class="bg-danger text-white"><b>3 Mês de Carência</b></td>
									<td id="pmtCarencia3">R$ 0,00</td>
									<td id="dataCarencia3"> <?php echo date('d/m/Y') ?></td>
								</tr>
								<tr>
									<td class="bg-danger text-white"><b>4 Mês de Carência</b></td>
									<td id="pmtCarencia4">R$ 0,00</td>
									<td id="dataCarencia4"> <?php echo date('d/m/Y') ?></td>
								</tr>
								<tr>
									<td class="bg-danger text-white"><b>5 Mês de Carência</b></td>
									<td id="pmtCarencia5">R$ 0,00</td>
									<td id="dataCarencia5"> <?php echo date('d/m/Y') ?></td>
								</tr>
								<tr>
									<td class="bg-danger text-white"><b>6 Mês de Carência</b></td>
									<td id="pmtCarencia6">R$ 0,00</td>
									<td id="dataCarencia6"> <?php echo date('d/m/Y') ?></td>
								</tr>
							</tbody>
							<tfoot>
								<tr>
									<td><strong>PMT Aproximada Carência</strong></td>
									<td colspan="2"><input id="carenciapmt" type="number" class="form-control" disabled="disabled"></td>

								</tr>
								<tr>
									<td class="bg-danger text-white">Total de Juros Incorporados</td>
									<td colspan="2" id="jurosIncorp"></td>
								</tr>
								<tr>
									<td class="bg-danger text-white">CET (Custo Efetivo total)</td>
									<td colspan="2" id="cet"></td>
								</tr>
								<tr>
									<td class="bg-danger text-white">Razão de Descréscimo</td>
									<td colspan="2"><input id="decres" type="text" class="form-control" disabled="disabled"></td>
								</tr>
								<tr>
									<td colspan="3"></td>
								</tr>
								<tr>
									<td>
										<button class="btn btn-warning btn-sm">PRÓXIMA PARCELA IMOB</button>
									</td>
									<td id="nextPmtImob"></td>
									<td id="nextPmtImobData"></td>
								</tr>
							</tfoot>
						</table>
						<button id="btnEvo" data-toggle="modal" class="btn btn-block btn-danger" data-target="#priceModal" style="">VER EVOLUÇÃO</button>
					</div>
				</div>
				<!-- ./Coluna direita  -->
			</div>
			<!-- Modal tabela Price -->
			<div class="modal fade" id="people" tabindex="-1" role="dialog" aria-labelledby="peopleLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content" style="font-size: 10px">
						<div class="modal-header">
							<ol>
								<li>Essa simulação não considera a atualização do saldo devedor pela TR (Taxa Referencial), logo, poderá sofrer alterações conforme previsto em contrato.</li>
								<li>A Taxa de juros apresentada na Montreal é a taxa anual nominal</li>
							</ol>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<label class="text-muted">PEOPLE SOFT</label>
							<ul type="none">
								<li>DATA: <b class="none-b"> <input style="width: 34%; height: 40px;" readonly="true" value=" <?php echo date('d/m/Y') ?>" type="text" class="form-control"></b></li>
								<li>CPF: <b class="none-b"> <input style="width: 34%; height: 40px;" readonly="true" id="cpf1" type="text" class="form-control"></b></li>
								<li>Produto: <b class="none-b"> <input style="width: 34%; height: 40px;" readonly="true" id="prodct1" type="text" value="Renegociação + CI"  class="form-control"></b></li>
								<li>Num Proposta Contrato: <b class="none-b"> <input style="width: 34%; height: 40px;" readonly="true" id="contratonum" type="text" class="form-control"></b></li>
								<li>Nome: <b class="none-b"> <input style="width: 34%; height: 40px;" readonly="true" id="name1" type="text" class="form-control"></b></li>
								<li>Parcelas: <b class="none-b"> <input style="width: 34%; height: 40px;" readonly="true" id="parpar" type="text" class="form-control"></b></li>
								<?php
								for ($i = 0; $i < 6; $i++) {
									echo '<li>CARÊNCIA MÊS ' . ($i + 1) . ': <b class="none-b" id="bcarencia' . $i . '">0</b></li>';
								}
								?>
								<li>VALOR INCORPORADO: <b class="none-b" id="value1">0</b></li>
								<li>PRAZO ANTIGO: <b class="none-b" id="prAnt1">0</b></li>
								<li>PRAZO ATUAL: <b class="none-b" id="prAt1">0</b></li>
								<li>NOVO PRAZO: <b class="none-b" id="nvPr1">0</b></li>
								<li>PLANO: <b class="none-b" id="plan1">0</b></li>
								<li>CONTRATO CI: <b class="none-b" id="contCi1">0</b></li>
								<li>E-MAIL: <b class="none-b" id="mail1">0</b></li>
							</ul>

						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger">Copiar</button>
						</div>
					</div>
				</div>
			</div>

			<!-- Modal Price  -->
			<div class="modal fade" id="priceModal" tabindex="-1" role="dialog" aria-labelledby="peopleLabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
					<div class="modal-content" style="font-size: 10px">
						<div class="modal-header">
							<div class="col-md-12">
								<button class="btn btn-block btn-danger col-md-12" id="typeTable"> PARCELAS FIXAS (PRICE)</button>
								<!-- data-dismiss="modal"  -->
							</div>
						</div>
						<div class="modal-body">
							<table class="table table-sm table-bordered">
								<thead>
									<tr class="bg-danger text-white">
										<th scope="col">DATA / MÊS</th>
										<th scope="col">Nº PARCELAS</th>
										<th scope="col">SALDO DEVEDOR</th>
										<th scope="col">AMT</th>
										<th scope="col">JUROS</th>
										<th scope="col">PARCELA</th>
										<th scope="col">SEGURO MIP</th>
										<th scope="col">SEGURO DFI</th>
										<th scope="col">TSA</th>
										<th scope="col">PARCELA FINAL</th>
									</tr>
								</thead>
								<tbody id="priceTable" style="overflow-y: scroll">

								</tbody>
							</table>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger" data-dismiss="modal">Voltar</button>
						</div>

					</div>
				</div>
			</div>

			<!-- Modal Montreal -->
			<div class="modal fade"  id="montreal" tabindex="-1" role="dialog" aria-labelledby="peopleLabel" aria-hidden="true">
				<div class="modal-dialog modal-dialog-scrollable modal-SM" role="document">
					<div class="modal-content" style="font-size: 10px">
						<div class="modal-header">
							<div class="col-md-12">
								<p class="btn btn-block btn-danger">Montreal</p>
							</div>
						</div>
						<div class="modal-body ">
							<div class="form-row">
								<div class="col-md-6">
									<label class="label-control">Nº Contrato</label>
									<input class="form-control" value="" type="text" name="EDICAO" id="contract">
								</div>
								<div class="col-md-6">
									<label class="label-control">CPF</label>      
									<input class="form-control" type="number" name="CPF" value="" id="CPF">
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-6">
									<label class="label-control">Nome</label>
									<input class="form-control" type="text" id="NOME_MUTUARIO" value="ALAM DE FIGUEIREDO XAVIER">
								</div>
								<div class="col-md-6">
									<label class="label-control">Plano</label>
									<select class="form-control select" type="text" name="PLANO" id="PLANO">
										<option value="1">PCM/SAC</option>
										<option value="2">PCM/TP</option>
									</select>
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-6">
									<label class="label-control">Taxa de Juros (%)</label>
									<input class="form-control" value="" type="number" id="taxamontreas">
								</div>
								<div class="col-md-6">
									<label class="label-control">Prestação</label>
									<input class="form-control" type="number" value="" id="prestacao" name="prestacao">
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-6">
									<label class="label-control">MIP</label>
									<input class="form-control" type="number" value="" id="MIP" name="MIP">
								</div>
								<div class="col-md-6">
									<label class="label-control">DFI</label>
									<input class="form-control" type="number" value="" id="dfi" name="dfi">
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-6">
									<label class="label-control">Taxa (TSA)</label>
									<input class="form-control" type="number" name="tsa" id="tsa" value="">
								</div>
								<div class="col-md-6">
									<label class="label-control">Saldo devedor</label>
									<input class="form-control" type="number" name="deversaldo" value="" id="deversaldo">
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-6">
									<label class="label-control">Novo Prazo (MESES)</label>
									<input class="form-control" type="number" id="novoprazo" name="novoprazo" value="">
								</div>
								<div class="col-md-6">
									<label class="label-control">Dia do Vencimento</label>
									<input class="form-control" type="date" name="vencimentododia" id="vencimentododia" value="">
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-danger" data-dismiss="modal" onclick="calcular();fator();$('#btnEvo').show()">Calcular</button>
						</div>
					</div>
				</div>
			</div>
		</div>

		<script type="text/javascript">

 var visibilidade = true; //Variável que vai manipular o botão Exibir/ocultar
 

 function ocultarExibir() {
  if (visibilidade) {//Se a variável visibilidade for igual a true, então...
        document.getElementById("testando").style.display = "block";//Ocultamos a div
        document.getElementById("testando").style.display = "block";//Ocultamos a div
        document.getElementById("corpototal").style.display = "none";//Exibimos a div..
        document.getElementById("corpototal").style.display = "none";//Exibimos a div..
        visibilidade = false;//alteramos o valor da variável para falso.
    } else {//ou se a variável estiver com o valor false..
        document.getElementById("testando").style.display = "block";//Ocultamos a div
        document.getElementById("testando").style.display = "block";//Ocultamos a div
        document.getElementById("corpototal").style.display = "none";//Exibimos a div..
        document.getElementById("corpototal").style.display = "none";//Exibimos a div..
        visibilidade = true;//Alteramos o valor da variável para true.
    }
}




function ocultarExibir2() {
  if (visibilidade) {//Se a variável visibilidade for igual a true, então...
        document.getElementById("testando").style.display = "none";//Ocultamos a div
        document.getElementById("testando").style.display = "none";//Ocultamos a div
        document.getElementById("corpototal").style.display = "block";//Exibimos a div..
        document.getElementById("corpototal").style.display = "block";//Exibimos a div..
        visibilidade = false;//alteramos o valor da variável para falso.
    } else {//ou se a variável estiver com o valor false..
        document.getElementById("corpototal").style.display = "none";//Exibimos a div..
        document.getElementById("corpototal").style.display = "none";//Exibimos a div..
        visibilidade = true;//Alteramos o valor da variável para true.
    }
}





function ocultarExibirResultado() {
  if (visibilidade) {//Se a variável visibilidade for igual a true, então...
        document.getElementById("produtos").style.display = "none";//Ocultamos a div
        document.getElementById("produtos").style.display = "block";//Ocultamos a div
        visibilidade = false;//alteramos o valor da variável para falso.
    } else {//ou se a variável estiver com o valor false..
        document.getElementById("produtos").style.display = "none";//Exibimos a div..
        document.getElementById("produtos").style.display = "none";//Exibimos a div..
        visibilidade = true;//Alteramos o valor da variável para true.
    }
}




  // Calcula os resultados ao pressionar as teclas
  // document.body.addEventListener('keyup', function (e){calcular()});

  // Efetua os cálculos
  function calcular()
  {
        //* Saldo Atual *\\ 
        var saldo223 = String($('#deversaldo').val());
        var totalidade = saldo223
        var totalidade =  totalidade;
        var totalidade066 = "R$" + totalidade;
        $('#sdAtual').val(String(totalidade066));


        //* Novo Prazo  *\\ 
        var saldo224 = ($('#novoprazo').val());
        var totalidade1 = saldo224
        $('#prazomeses').val((totalidade1));

        
        //* Data de Vencimento *\\ 
        var saldo225 = String($('#vencimentododia').val());
        var totalidade2 = saldo225
        $('#vencimentos').val(String(totalidade2));

        //* Taxa Montreal *\\ 
        var saldo226 = String($('#taxamontreas').val());
        var totalidade3 = saldo226
        var totalidade3 = totalidade3;
        var lidade3 = totalidade3 + "%";
        $('#taxajurosmontreas').val(String(lidade3));



        //* Taxa Comum *\\ 

        // 1+($D$17/12))^12)-1

        var totalidade4 = parseFloat(Math.pow((1+(parseFloat($("#taxamontreas").val()/100)/12)),12)-1)*100
        var restultotal56 = (totalidade4.toFixed(4));
        var resultado666 = restultotal56 + "%";
        $('#taxaefetiva').val(String(resultado666));


        //* Calculando MIP *\\ 
        var saldo228 = String($('#MIP').val());
        var totalidade5 = saldo228
        var totalidade5 = "R$" + totalidade5;
        $('#mipseguro').val(String(totalidade5));


        //* Calculando DIF *\\ 
        var saldo229 = String($('#dfi').val());
        var totalidade6 = saldo229
        var totalidade6 =  "R$" + totalidade6;
        $('#dfiseguro').val(String(totalidade6));


        //* Calculando TSA *\\ 
        var saldo230 = String($('#tsa').val());
        var totalidade7 = saldo230
        var totalidade7 =  "R$" + totalidade7;
        $('#tsaseguro').val(String(totalidade7));


        //* Calculando Prestação *\\ 
        var saldo231 = String($('#prestacao').val());
        var totalidade8 = saldo231
        var totalidade8 =  "R$" + totalidade8;
        $('#prestacao2').val(String(totalidade8));


        //* Calculando Encargo Atual Imob *\\ 
        var saldoIMOB1 = Number($('#MIP').val());
        var saldoIMOB2 = Number($('#dfi').val());
        var saldoIMOB3 = Number($('#tsa').val());
        var saldoIMOB4 = Number($('#prestacao').val());

        var saldo232 = saldoIMOB1 + saldoIMOB2 + saldoIMOB3 + saldoIMOB4;
        var totalidade9 = saldo232
        var totalidade9 =  "R$" + totalidade9;
        $('#imobencargo').val(String(totalidade9));
		console.log(totalidade9)

        
        //* Calculando CPF PEOPLE *\\ 
        var CPF = ($('#CPF').val());
        var cpfs = CPF
        $('#cpf1').val(String(cpfs));


    //* Calculando NOME PEOPLE *\\ 
    var names = String($('#NOME_MUTUARIO').val());
    var namemutual1 = names
    $('#name1').val(String(namemutual1));

    

    //* Calculando PARCELAS PEOPLE *\\ 
    var parprice = String($('#prestacao').val());
    var pricepar = parprice
    $('#parpar').val(String(pricepar));


    //* Calculando Contrato PEOPLE *\\ 
    var contract = ($('#contract').val());
    var contratos = contract
    $('#contratonum').val((contratos));



     //*  CALCULANDO PRICE SALDO \\*
     var modalidade103 = ($('#deversaldo').val());
     var deversaldos = modalidade103;
     $('#saldo').val(String(deversaldos));

    //*  CALCULANDO PRICE PARCELA TOTAL INICIAL \\ 

    var juros = 2.89;
    var saldo = ($('#saldoreorg').val());
    var prazo = ($('#prazominimo1').val());

    var juroscalculo = juros / 100;
    var juros1 = juros / 100 +1;
    var juros1real = Math.pow(juros1,prazo)*juroscalculo;


    var juros2 = juros / 100 + 1; 
    var juros2real = Math.pow(juros2,prazo)-1;

    var parcelasbreve = juros2real / juros1real;

    var parcelatotalinicial = saldo / parcelasbreve;

    var restultotal1 = (parcelatotalinicial.toFixed(2));

    $('#parcelaTotalIni').val(Number(restultotal1));


    //* Calculando Modalidade  *\\ 
    // var modalidade = ($('#saldoreorg').val());
    // if (modalidade < 271){
    //     var modalidade3 = "NORMAL";
    // }
    // if (modalidade > 271){
    //     var modalidade3 = "ESTENDIDO";
    // }

    // if (modalidade < 1){
    //     var modalidade3 = "Resumo Da Simulação Imob";
    // }
    // $('#modalidade').val(String(modalidade3));


    //* Calculando Razao de Decrescimo  *\\ deversaldo
    var modalidade101 = ($('#taxamontreas').val());
    var saldo_atual = ($('#deversaldo').val());
    var meses_prazo = ($('#prazomeses').val());
    
    var valorz = saldo_atual / meses_prazo;

    var valorzinho = modalidade101 / 100;

    var resultotal = valorz * valorzinho / 12;

    var restultotal1 = (resultotal.toFixed(2));


    $('#decres').val(String(restultotal1));


        //* Calculando Prazo Minimo 2  *\\ 
        var saldopp2 = ($('#prazominimo2').val());
        if (saldopp2 < 6){
        	var totalidade11 = 0;
        }
        if (saldopp2 > 6){
        	var totalidade11 = 239.76;
        }
        if (saldopp2 > 8){
        	var totalidade11 = 212.69;
        }
        if (saldopp2 > 9){
        	var totalidade11 = 191.66;
        }
        if (saldopp2 > 10){
        	var totalidade11 = 174.86;
        }
        if (saldopp2 > 11){
        	var totalidade11 = 161.13 ;
        }
        if (saldopp2 > 12){
        	var totalidade11 = 149.71 ;
        }
        if (saldopp2 > 13){
        	var totalidade11 = 140.05 ;
        }
        if (saldopp2 > 14){
        	var totalidade11 = 131.80 ;
        }
        if (saldopp2 > 15){
        	var totalidade11 = 124.65;
        }
        if (saldopp2 > 16){
        	var totalidade11 = 118.41 ;
        }
        if (saldopp2 > 17){
        	var totalidade11 = 112.92;
        }
        if (saldopp2 > 18){
        	var totalidade11 = 108.05 ;
        }
        if (saldopp2 > 19){
        	var totalidade11 = 103.70 ;
        }
        if (saldopp2 > 20){
        	var totalidade11 = 99.80 ;
        }
        if (saldopp2 > 21){
        	var totalidade11 = 96.28 ;
        }
        if (saldopp2 > 22){
        	var totalidade11 = 93.09 ;
        }
        if (saldopp2 > 23){
        	var totalidade11 = 90.18 ;
        }
        if (saldopp2 > 24){
        	var totalidade11 = 87.52 ;
        }
        if (saldopp2 > 25){
        	var totalidade11 = 85.09  ;
        }
        if (saldopp2 > 26){
        	var totalidade11 = 82.85 ;
        }
        if (saldopp2 > 27){
        	var totalidade11 = 80.78;
        }
        if (saldopp2 > 28){
        	var totalidade11 = 78.87;
        }
        if (saldopp2 > 29){
        	var totalidade11 = 77.09;
        }
        if (saldopp2 > 30){
        	var totalidade11 = 75.44;
        }
        if (saldopp2 > 31){
        	var totalidade11 = 73.91;
        }
        if (saldopp2 > 32){
        	var totalidade11 = 72.47 ;
        }
        if (saldopp2 > 33){
        	var totalidade11 = 71.13;
        }
        if (saldopp2 > 34){
        	var totalidade11 = 69.87;
        }
        if (saldopp2 > 35){
        	var totalidade11 = 29.96 ;
        }
        if (saldopp2 > 36){
        	var totalidade11 = 29.33 ;
        }
        if (saldopp2 > 37){
        	var totalidade11 = 28.74 ;
        }
        if (saldopp2 > 38){
        	var totalidade11 = 28.19 ;
        }
        if (saldopp2 > 39){
        	var totalidade11 = 27.67 ;
        }
        if (saldopp2 > 40){
        	var totalidade11 = 27.19 ;
        }
        if (saldopp2 > 41){
        	var totalidade11 = 26.73 ;
        }
        if (saldopp2 > 42){
        	var totalidade11 = 26.31 ;
        }
        if (saldopp2 > 43){
        	var totalidade11 = 25.91 ;
        }
        if (saldopp2 > 44){
        	var totalidade11 = 25.53;
        }
        if (saldopp2 > 45){
        	var totalidade11 = 25.17;
        }
        if (saldopp2 > 46){
        	var totalidade11 = 24.83;
        }
        if (saldopp2 > 47){
        	var totalidade11 = 24.51;
        }
        if (saldopp2 > 48){
        	var totalidade11 = 24.21;
        }
        if (saldopp2 > 49){
        	var totalidade11 = 23.92;
        }
        if (saldopp2 > 50){
        	var totalidade11 = 23.65;
        }
        if (saldopp2 > 51){
        	var totalidade11 = 23.39;
        }


        var totalidade11 = "R$" + totalidade11;

        $('#valorincremental').val(String(totalidade11));



        //* Calculando PMT Carencia  *\\ 
        var modalidade100 = ($('#parcelaTotalIni').val());
        var resultadinho = modalidade100

        $('#carenciapmt').val(String(resultadinho));

    }


</script>



<script type="text/javascript">
  // document.body.addEventListener('keyup', function (e){calcular()});

  // $('#n1').priceFormat({prefix:'',centsSeparator:',', thousandsSeparator:'.', centsLimit:2});
  // $('#num1').priceFormat({prefix:'',centsSeparator:',', thousandsSeparator:'.', centsLimit:2});
  
  // $('#n1').select();

  function calcular2()
  {

  	var n1 = ($('#Numpar').val());
  	if (n1 < 90){
  		var n2 = 0;
  	}
  	else if (n1 > 91){ 
  		var n2 = 4;
  	}
  	if (n1 > 121){
  		var n2 = 10;
  	}
  	if (n1 > 181){
  		var n2 = 22;
  	}
  	if (n1 > 361){
  		var n2 = 40;
  	}
  	if (n1 > 721){
  		var n2 = 57; 
  	}
  	if (n1 > 1081){
  		var n2 = 75;
  	}

  	var resultado = n2;
  	var resultado = resultado + "%";

  	$('#Desconpar').val(String(resultado)); 

  }



    //* Valor total negociado *\\ 
    var numerodeparcelas = ($('#numparcelas').val());
    var valordasparcelas = ($('#valordasparcelas').val());
    var entrada = ($('#Entradatotal').val());
    var resultado8 = ((numerodeparcelas * valordasparcelas) - entrada);


    //* Produtos Calculando desconto *\\ 
    var datraso = ($('#diasatrasoprodutos').val());
    if (datraso < 120){
    	var descontoproduto = 0;
    }
    if (datraso > 120){
    	var descontoproduto = 5;
    }
    if (datraso > 180){
    	var descontoproduto = 15;
    }
    if (datraso > 360){
    	var descontoproduto = 29;
    }
    if (datraso > 720){
    	var descontoproduto = 44;
    }
    if (datraso > 1080){
    	var descontoproduto = 60;
    }
    var descontoproduto = descontoproduto + "%";
    $('#descontoprodutos').val(String(descontoproduto));


    //* Produtos Calculando desconto *\\ 
    var datraso = ($('#diasatrasoprodutos1').val());
    if (datraso < 120){
    	var descontoproduto = 0;
    }
    if (datraso > 120){
    	var descontoproduto = 5;
    }
    if (datraso > 180){
    	var descontoproduto = 15;
    }
    if (datraso > 360){
    	var descontoproduto = 29;
    }
    if (datraso > 720){
    	var descontoproduto = 44;
    }
    if (datraso > 1080){
    	var descontoproduto = 60;
    }
    var descontoproduto = descontoproduto + "%";
    $('#descontoprodutos2').val(String(descontoproduto));



    //* Calculando  desconto Parcelado *\\ 
    var diasdeatraso3 = ($('#Numpar3').val());
    if (diasdeatraso3 < 120){
    	var descontinho = 0;
    }
    if (diasdeatraso3 > 120){
    	var descontinho = 5;
    }
    if (diasdeatraso3 > 180){
    	var descontinho = 15;
    }
    if (diasdeatraso3 > 360){
    	var descontinho = 29;
    }
    if (diasdeatraso3 > 720){
    	var descontinho = 44;
    }
    if (diasdeatraso3 > 1080){
    	var descontinho = 60;
    }

    var descontinho = descontinho + "%";
    $('#Desconpa3r').val(String(descontinho));



    //* Calculando  Taxa Parcelado *\\ 
    var diasdeatraso4 = ($('#Numpar3').val());
    if (diasdeatraso4 < 60){
    	var descontinho2 = 3;
    }
    if (diasdeatraso4 > 60){
    	var descontinho2 = 1.10;
    }
    if (diasdeatraso4 > 90){
    	var descontinho2 = 1.30;
    }
    if (diasdeatraso4 > 300){
    	var descontinho2 = 1.10;
    }
    if (diasdeatraso4 > 359){
    	var descontinho2 = 1.00;
    }

    var descontinho2 = descontinho2 + "%";
    $('#Taxapar3').val(String(descontinho2));


    //* Campanha calculando desconto a vista *\\ 
    var diasatraso = ($('#atrasodias').val());
    if (diasatraso < 90){
    	var descontoavista = 0;
    }
    if (diasatraso > 90){
    	var descontoavista = 4;
    }
    if (diasatraso > 120){
    	var descontoavista = 10;
    }
    if (diasatraso > 180){
    	var descontoavista = 22;
    }
    if (diasatraso > 360){
    	var descontoavista = 40;
    }
    if (diasatraso > 720){
    	var descontoavista = 57;
    }
    if (diasatraso > 1080){
    	var descontoavista = 75;
    }
    var descontoavista2 = descontoavista + "%";

    $('#avistadesconto').val(String(descontoavista2));


    //* Campanha calculando desconto Parcelado *\\ 
    var diasatraso1 = ($('#atrasodias').val());
    var parcelasnumero1 = ($('#parcelasnumero').val());

    if (diasatraso1 < 120 && parcelasnumero1 < 1 ){
    	var parceladesconto = 1;
    }
    if (diasatraso1 > 120 && parcelasnumero1 > 1 ){
    	var parceladesconto = 8;
    }
    if (diasatraso1 < 120 ){
    	var parceladesconto = 0;
    }
    if (parcelasnumero1 < 2 ){
    	var parceladesconto = 0;
    }
    if (diasatraso1 < 121 && parcelasnumero1 > 1 ){
    	var parceladesconto = 2;
    }
    if (diasatraso1 > 180){
    	var parceladesconto = 15;
    }
    if (diasatraso1 > 180 && parcelasnumero1 > 1 ){
    	var parceladesconto = 18;
    }
    if (diasatraso1 > 360){
    	var parceladesconto = 29;
    }
    if (diasatraso1 > 360 && parcelasnumero1 > 1){
    	var parceladesconto = 29;
    }
    if (diasatraso1 > 720){
    	var parceladesconto = 44;
    }
    if (diasatraso1 > 720 && parcelasnumero1 > 1){
    	var parceladesconto = 44;
    }
    if (diasatraso1 > 1080){
    	var parceladesconto = 60;
    }
    if (diasatraso1 > 1080 && parcelasnumero1 > 1){
    	var parceladesconto = 60;
    }

    var parceladesconto = parceladesconto + "%";
    $('#parceladodesconto').val(String(parceladesconto));


    //* Campanha calculando Taxa  *\\ 
    var numerodeparcelas1 = ($('#parcelasnumero').val());
    if(numerodeparcelas1 > 12){
    	var taxaparcela1 = 1;
    }
    else if (numerodeparcelas1 < 13){
    	var taxaparcela1 = 0;
    }
    var taxaparcela1 = taxaparcela1 + "%";
    $('#campanhataxa').val(String(taxaparcela1));




    //* Parc Intermediarias Calculo  *\\ 
    var parcelasinter  = ($('#parcintermediarias3').val());
    if(parcelasinter < 6000){
    	var parcelairregular = 30;
    }
    else if (parcelasinter > 6000){
    	var parcelairregular = parcelasinter * (0.5/100);
    }
    var parcelairregular =  "R$" + parcelairregular;
    $('#parcintermediarias4').val(String(parcelairregular));




    //* Parc Intermediarias Calculo  *\\ 
    var parcelasinter  = ($('#parcintermediarias7').val());
    if(parcelasinter < 6000){
    	var parcelairregular = 30;
    }
    else if (parcelasinter > 6000){
    	var parcelairregular = parcelasinter * (0.5/100);
    }
    var parcelairregular =  "R$" + parcelairregular;
    $('#parcintermediarias8').val(String(parcelairregular));


    function Camposparc()
    {

    	var n1 = ($('#Numpar').val());
    	if (n1 < 61){
    		var n2 = 3;
    	}
    	if (n1 > 91){ ;
    		var n2 = 4.30;
    	}
    	if (n1 > 301){
    		var n2 = 1.10;
    	}
    	if (n1 > 360){
    		var n2 = 1.00;
    	}

    }

/**** DAQUI PRA BAIXO - GUSTAVO ****/


//EXCEl Preenchimento!J13=SE(J9="";"";Apoio!O104) =>
// => EXCEL Apoio!O104=SE(E(N104<>"";M103<>"");$N$104;" ") =>
// => EXCEL Apoio!N104=SE(D100>0;"Estendido";"Normal") =>
// pagamento de juros acumulados em um determinado periodo
function pgtojuracum(taxa, n, vp, inicio_periodo, final_periodo) {
	if(taxa < 0 || n < 0 || vp < 0 || inicio_periodo < 0 || final_periodo < 0 ) {
		return 0
	}

	tp_pgto = 0
	inicio_periodo -= 1
	final_periodo -= 1

    // Converte taxa
    tx = taxa/100;
    jurosAcumulados = 0;

    // Potenciação da taxa 
    potenciacao = parseFloat(Math.pow(1+tx,n));
    pmt = vp*parseFloat((potenciacao*tx)/(potenciacao-1));
    while(vp > 0) {
    	juros =  vp*tx;
    	amt = pmt-juros;
    	vp -= amt;
    	if(vp > 0) {
            // calculo dos juros acumulados
            if(tp_pgto >= inicio_periodo && tp_pgto <= final_periodo) {
            	jurosAcumulados += juros;
            }

            //retorno da funçã
            if(final_periodo === tp_pgto) {
            	return jurosAcumulados.toFixed(2)
            }
            tp_pgto++
        }
    }
    return jurosAcumulados.toFixed(2);
}

//retorna prazo minimo
function iptPrMin(car,mdldd) { 
    prestacao = 8701.24;$('#prestacao').val(); // trata
    saldoReorg = 50000;$("#saldoreorg").val();
    prazominimo2 = 9;$("#prazominimo2").val(); // Number
    juracum = pgtojuracum(2.89,prazominimo2-6,saldoReorg,1,6)
    
    compromC13 = (saldoReorg-((prestacao*6)+juracum)).toFixed(2);
    prazoMinimoSemCarencia = prazominimo2-6
    potenciacao = Math.pow(1.0289,prazoMinimoSemCarencia)
    pmt = compromC13*((potenciacao*0.0289) /(potenciacao-1))

    compromC14 = parseFloat(pmt)

    compromC16 = ((prestacao-compromC14)/prestacao).toFixed(2)
    //compromC17
    if(compromC16 > 0.5) {
    	compromC17 = 1;
    } else {
    	compromC17 = 0;
    }

    compromC18 = parseInt(saldoReorg/prestacao)

    // compromK5
    if(compromC18 <= 35) {
    	compromK5 = 30;
    } else {
    	compromK5 = 72;
    }

    // compromF17
    if(compromC17 == 1 || compromC18 < 16) {
    	compromF17 = xPmt(compromC18)
    } else {
    	compromF17 = 0
    }

    // compromK17
    if(compromF17 = 0) {
        compromK17 = compromK5 //criada - prazo 2
    } else  {
    	compromK17 = 0
    }

    if(mdldd == 'ESTENDIDO' && compromC18 <= 15) {
    	result = xPmt(compromC18)

    } else if(mdldd == 'ESTENDIDO' && compromC18 > 15) {
    	result = compromK17

    } else {
    	result = car

    }

    $("#prazominimo1").val(result)
    return result
}

// Prazo
function xPmt(index) {
	if(index >= 5 && index <= 15) {
		x = {
			5: "8",
			6: "10",
			7: "12",
			8: "14",
			9: "17",
			10: "20",
			11: "24",
			12: "28",
			13: "32",
			14: "38",
			15: "45"
		}

		result = x[index]

		if(typeof result === 'undefined') {
			return 0
		} 

		return result
	}
	return 0
}

function fator() {
	car = carencia()
	taxaefetiva = parseFloat(parseFloat(Math.pow((1+(parseFloat($("#taxamontreas").val()/100)/12)),12)-1))
	ApoioF22 = parseFloat(Math.pow((1+taxaefetiva),(1/12))-1)
	prazo = parseInt($("#novoprazo").val())

	fatorTotal = 0
	for(n=0; n < prazo; n++) {
    	if(n > car && n > 0) {
			fatorTotal += parseFloat(1/(Math.pow((1+ApoioF22),n)))
			console.log(fatorTotal)
		}
	}
	console.log('Total '+fatorTotal)
	
	$("#fatorTotal").val(fatorTotal);
}

//monta tabela price
function price(car) {
	$("#carenciaTable").html('')
	$("#typeTable").html('PARCELAS FIXAS (PRICE)')
	saldoIincial = parseFloat($("#deversaldo").val()).toFixed(2)
	saldo = parseFloat(saldoIincial)
	sdAnterior = parseFloat(saldoIincial)
	prazo = parseInt($("#novoprazo").val())
    txJuros = parseFloat(0.0289) //2,89%
    taxaefetiva = parseFloat(parseFloat(Math.pow((1+(parseFloat($("#taxamontreas").val()/100)/12)),12)-1))
    ApoioF22 = (Math.pow((1+taxaefetiva),(1/12))-1)
    ApoioF24 = parseFloat($('#MIP').val())/parseFloat($('#deversaldo').val())

    car -= 1;
    i = 0;
    nextPmtImob = 0;
    tr = '';

    let dateInput = ($('input[type=date]').val()).split('-');
    let dataPgto = new Date(dateInput[0], dateInput[1], dateInput[2]);

	linha = '';
	fatorTotal = $("#fatorTotal").val();

    while (sdAnterior > 0) {
    	if (i > car) {
    		carencia = false;
    	} else {
    		carencia = true;
    	}

    	if (carencia == true) {
            // Valor dos Juros
            juros = 0;
            //Parcelas
            pmt = 0;
            //amortização
            amt = 0;
            //Juros Incorporados por carencia
            if (i > 0) {
            	jurosIncorporados = parseFloat(sdAnterior * ApoioF22);
            	saldoIincial = (parseFloat(saldoIincial)  + parseFloat(jurosIncorporados))
            } else {
            	jurosIncorporados = 0;
            }
            //Saldo Devedor
            saldoDevedor = sdAnterior + jurosIncorporados;
            
            //seguros
            dfi = parseFloat($("#dfi").val());
            tsa = parseFloat($("#tsa").val());
            mip = parseFloat(saldoDevedor*ApoioF24);

            //parcela final
            if (i > 0) {
            	parcelafinal = (amt + juros + mip + dfi + tsa);

            } else {
            	parcelafinal = 0
            }
        } else {
            // Valor dos Juros
            juros = sdAnterior * ApoioF22;
            potenciacao = Math.pow((1 + txJuros), (prazo));

			//Parcelas
			console.log('fatorTotal '+fatorTotal)
            pmt = parseFloat(saldo / fatorTotal);

            //amortização
            amt = parseFloat(pmt - juros);

            //Saldo Devedor
            saldoDevedor = parseFloat(sdAnterior - amt);

            //seguros 
            dfi = parseFloat($("#dfi").val());
            tsa = parseFloat($("#tsa").val());
            mip = parseFloat(saldoDevedor*ApoioF24);

            //parcela final
			parcelafinal = parseFloat(amt + juros + mip + dfi + tsa);

            //pmt imob
            if(nextPmtImob == 0) {
            	$("#nextPmtImob").html(' R$ ' + my_number_format(pmt.toFixed(2), 2, ',', '.'))
            	$("#nextPmtImobData").html(dataPgto.getDate() + '/' + dataPgto.getMonth() + '/' + dataPgto.getFullYear() )
            	nextPmtImob += 1
            }
        }
        
        dataPgto.setMonth(dataPgto.getMonth()+1 ); //cria um objeto de data com o valor inserido no input
        data = dataPgto.getDate()+'/'+(dataPgto.getMonth()+1)+'/'+dataPgto.getFullYear(); // converte em uma string de data no formato pt-BR
        //DAta de carencia, se houver
        if(typeof $("#dataCarencia"+i).html() !== 'undefined') {
        	$("#dataCarencia"+1).html(data)
        }

        if(carencia == true && i > 0) {
        	tr +=   '<tr>'+
        	'<td class="bg-danger text-white"><b>'+(i+1)+' Mês de Carência</b></td>'+
        	'<td id="pmtCarencia1">R$' + parseFloat(parcelafinal).toFixed(2) + '</td>'+
        	'<td id="dataCarencia1">'+data+'</td>'+
        	'</tr>';
		}
		
        if(saldoDevedor > 0) {
	        linha += '<tr>' +
	        '<td scope="row">' + data + '</td>' +
	        '<td scope="row">' + i + '</td>' +
	        '<td scope="row">R$ ' + my_number_format(saldoDevedor, 2, ',', '.') + '</td>' +
	        '<td scope="row">R$ ' + my_number_format(amt, 2, ',', '.') + '</td>' +
	        '<td scope="row">R$ ' + my_number_format(juros, 2, ',', '.') + '</td>' +
	        '<td scope="row">R$ ' + my_number_format(pmt, 2, ',', '.') + '</td>' +
	        '<td scope="row">R$ ' + my_number_format(mip, 2, ',', '.') + '</td>' +
	        '<td scope="row">R$ ' + my_number_format(dfi, 2, ',', '.') + '</td>' +
	        '<td scope="row">R$ ' + my_number_format(tsa, 2, ',', '.') + '</td>' +
	        '<td scope="row">R$ ' + my_number_format(parcelafinal, 2, ',', '.') + '</td>' +
	        '</tr>';
		}
		
		sdAnterior = sdAnterior - sdAnterior;
	    sdAnterior = saldoDevedor;
	    
        i++;
    }
    $("#carenciaTable").html(tr)
    return  $("#priceTable").html(linha)
}

//monta tabela sac
function sac(car) {
	$("#typeTable").html('PARCELAS ATUALIZÁVEIS (SAC)')
	$("#carenciaTable").html('')
	saldoIincial = parseFloat($("#deversaldo").val()).toFixed(2)
	sdAnterior = parseFloat(saldoIincial)
	prazo = $("#novoprazo").val()
    txJuros = 0.0289 //2,89%
    ApoioF22 = parseFloat($("#taxaefetiva").val().replace('%','')/100)
    ApoioF24 = parseFloat($('#MIP').val())/parseFloat($('#deversaldo').val())
    car -= 1
    txJurosMontreal = (parseFloat($("#taxamontreas").val())/100)/12
    i = 0;
    nextPmtImob = 0
    tr = ''

    var dateInput = ($('input[type=date]').val()).split('-')
    var dataPgto = new Date(dateInput[0], dateInput[1], dateInput[2])
    var JurosIncorporadosTotal = 0

    linha = ''

    while (sdAnterior > 0) {
    	if (i > car) {
    		carencia = false;
    	} else {
    		carencia = true;
    	}

    	if (carencia == true) {
            // Valor dos Juros
            juros = 0;
            //Parcelas
            pmt = 0;
            //amortização
            amt = 0;
            //Juros Incorporados por carencia
            if (i > 0) {
            	jurosIncorporados = sdAnterior * txJurosMontreal;

            	saldoIincial += jurosIncorporados;
            	JurosIncorporadosTotal += jurosIncorporados
            } else {
            	jurosIncorporados = 0;
            }
            //Saldo Devedor
            saldoDevedor = sdAnterior + jurosIncorporados;
            
            //seguros 
            dfi = $("#dfi").val();
            tsa = $("#tsa").val();
            mip = saldoDevedor*ApoioF24;

            //parcela final
            if (i > 0) {
            	parcelafinal = (amt + juros + mip + dfi + tsa);

            } else {
            	parcelafinal = 0
            }
        } else {

            // Valor dos Juros
            juros = sdAnterior * txJurosMontreal;

            potenciacao = Math.pow((1 + txJuros), (prazo));

            //amortização
            if($('#modalidade').val() == "ESTENDIDO"){ 
            	modalidade = 6
            } else { 
            	modalidade = $('#prazoMinimo1').val() 
            }

            amt = (parseFloat(parseFloat(saldoIincial)+parseFloat(JurosIncorporadosTotal))/parseFloat(prazo-modalidade));

            //Parcelas
            pmt = amt + juros;

            //Saldo Devedor
            saldoDevedor = sdAnterior - amt;

            //seguros 
            dfi = $("#dfi").val();
            tsa = $("#tsa").val();
            mip = parseFloat(saldoDevedor*ApoioF24);

            //parcela final
            parcelafinal = parseFloat(amt + juros + mip + dfi + tsa);
           

            //pmt imob
            if(nextPmtImob == 0) {
            	$("#nextPmtImob").html(' R$ ' + my_number_format(pmt.toFixed(2), 2, ',', '.'))
            	$("#nextPmtImobData").html(dataPgto.getDate() + '/' + (dataPgto.getMonth()+1) + '/' + dataPgto.getFullYear() )
            	nextPmtImob += 1
            }
        }
        
        dataPgto.setMonth(dataPgto.getMonth()+1 ); //cria um objeto de data com o valor inserido no input
        data = dataPgto.getDate()+'/'+(dataPgto.getMonth()+1)+'/'+dataPgto.getFullYear(); // converte em uma string de data no formato pt-BR
        //DAta de carencia, se houver
        if(typeof $("#dataCarencia"+i).html() !== 'undefined') {
        	$("#dataCarencia"+1).html(data)
        }

        if(carencia == true && i > 0) {
        	tr +=   '<tr>'+
        	'<td class="bg-danger text-white"><b>'+(i)+' Mês de Carência</b></td>'+
        	'<td id="pmtCarencia1">R$ ' + parseFloat(parcelafinal).toFixed(2) + '</td>'+
        	'<td id="dataCarencia1">'+data+'</td>'+
        	'</tr>';
        }

        if(saldoDevedor < 0 && saldoDevedor > -0.01) {
        	delete saldoDevedor
        	saldoDevedor = 0.00
        }

        linha += '<tr>' +
        '<td scope="row">' + data + '</td>' +
        '<td scope="row">' + i + '</td>' +
        '<td scope="row">R$ ' + my_number_format(saldoDevedor, 2, ',', '.') + '</td>' +
        '<td scope="row">R$ ' + my_number_format(amt, 2, ',', '.') + '</td>' +
        '<td scope="row">R$ ' + my_number_format(juros, 2, ',', '.') + '</td>' +
        '<td scope="row">R$ ' + my_number_format(pmt, 2, ',', '.') + '</td>' +
        '<td scope="row">R$ ' + my_number_format(mip, 2, ',', '.') + '</td>' +
        '<td scope="row">R$ ' + my_number_format(dfi, 2, ',', '.') + '</td>' +
        '<td scope="row">R$ ' + my_number_format(tsa, 2, ',', '.') + '</td>' +
        '<td scope="row">R$ ' + my_number_format(parcelafinal, 2, ',', '.') + '</td>' +
        '</tr>';
        sdAnterior = sdAnterior - sdAnterior;
        sdAnterior = saldoDevedor;
        i++;
    }
    $("#carenciaTable").html(tr)
    return  $("#priceTable").html(linha)
}

//formata numero
function my_number_format (number, decimals, dec_point, thousands_sep) {
    // Strip all characters but numerical ones.
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function (n, prec) {
    	var k = Math.pow(10, prec);
    	return '' + Math.round(n * k) / k;
    };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
    	s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
    	s[1] = s[1] || '';
    	s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}

//modalidade
function modalidade(car) {
	if(car <= 5) {
		$('#modalidade').val('NORMAL')
		return 'NORMAL'
	} else {
		$('#modalidade').val('ESTENDIDO')
		return 'ESTENDIDO'
	}
}

// Cálculos
function calcTable() {
	saldo = parseInt($("#saldoreorg").val())
	prazo = parseInt($("#prazominimo2").val())
	plano = parseInt($('#PLANO').val())

	if(saldo > 0 && prazo > 0) {
		let car = parseInt(carencia());
		let mdldd = modalidade(car);
		iptPrMin(car,mdldd);

		// verifica qual plano calcular
		if(plano === 1) {
			sac(car);
		} else if(plano === 2) {
			price(car);
		}
	}
}

//Adaptação de Apoio PARC INTERMEDIARIA 32.1076
function carencia() {
	auxiliarCarencia = 0;
	saldo = parseFloat($('#saldoreorg').val());//PreenchimentoJ9
    pmt = parseFloat($('#prestacao').val());//PreenchimentoD23
    jurosAm = parseFloat(2.89);
    n = 1;
    saldoAnt = saldo
    for (i = 0; i < 7; i++) {
        // Calcula juros
        newJuros = saldoAnt * (jurosAm/100)
        //pós carencia
        if(i === 6) {

        	potenciacao = Math.pow((1 + (jurosAm/100)), (72-6));

            //Parcelas
            newPmt = (saldoAnt * ((potenciacao * jurosAm) / (potenciacao - 1)));
            saldoAnt -= newPmt - newJuros //pmt - juros

        } else {
            saldoAnt -= pmt - newJuros //pmt - juros

        }
        if(saldoAnt < 0) {
        	pot = Math.pow((1 + (jurosAm/100)), n);

            //Parcelas
            pmtAux = (saldo * ((pot * jurosAm) / (pot - 1)));

            auxiliarCarencia += pmtAux - auxiliarCarencia
            return n;

        } 

        n++
    }
    return 6;

}

</script>

</html>