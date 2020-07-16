<!DOCTYPE html>
<html lang="en">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Calculadora Dilatação</title>
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
<!-- <script src="objetos/funcoes.js"></script> -->
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a style="color: red;" class="navbar-brand" href="#">Simulador Renegociação CI</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
            <li class="nav-item float-right">
                    <button style="position: relative; top: 4px; width: 150px;" class="btn btn-danger" data-toggle="modal" data-target="#montreal" type="reset">Montreal</button>
                </li>
                <li class="nav-item float-right">

                </li>
                <li class="nav-item float-right"><a href="https://liderbook.liderancacobrancas.com.br/liderbook/public/">
                    <button style="width: 150px; position:relative; top: 7px; left: 600px; "  class="btn btn-danger" type="reset">Sair</button></a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="page-content">
        <div class="row">
            <div class="card-body col-md-4 padding">
                <div class="btn-group col-md-12">
                <select id="produtooferta" class="browser-default custom-select">
                <option selected>Tipo da Oferta</option>
                <option value="Combo CI">Combo CI</option>
                <option value="Renegociação + CI">Renegociação + CI</option>
                </select>
                </div>
            </div>
       
        </div>
        <div class="row">
            <div  id="painel"  class="card-body col-md-4">
            <h5 style="color: red;" >  Dados dos Proponentes</h5>

                    <div class="form-group">
                        <label class="text-muted" for="">Data Nasc 1 Proponente:</label>
                        <input  id="date1" type="date" class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="text-muted" for="">Data Nasc 2 Proponente:</label>
                        <input id="date2" type="date" class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="text-muted" for="">Prazo Maximo Permitido (MESES):</label>
                        <input id="prazopermitido" readonly="true" min="72" max="72" maxlength="2"  type="number" class="form-control">
                    </div>
<br>

<h5 style="color: red;" > Dados Para Recálculo das Parcelas</h5>

<div class="form-group">
    <label style="color: red;"  class="text-muted" for="">Data do Calculo:</label>
    <input readonly="true" type="text" value="<?php echo date('d/m/Y') ?>" class="form-control">
</div>

<div class="form-group">
    <label style="color: red;"  class="text-muted" for="">Saldo Atual:</label>
    <input id="saldo_atual" readonly="true" type="text" class="form-control">
</div>

<div class="form-group">
    <label  style="color: red;"  class="text-muted" for="">Prazo (Meses) :</label>
    <input type="text" readonly="true" id="prazomeses" class="form-control">
</div>
<div class="form-group">
    <label style="color: red;"  class="text-muted" for="">Dia do Vencimento</label>
    <input id="vencimentos" readonly="true" type="text" class="form-control">
</div>
<div class="form-group">
    <label style="color: red;"  class="text-muted" for="">Taxa de Juros aa (Montreal)</label>
    <input id="taxajurosmontreas" readonly="true" type="text" class="form-control">
</div>
<div class="form-group">
    <label style="color: red;"  class="text-muted" for="">Taxa de Juros aa (Efetiva)</label>
    <input id="taxaefetiva" readonly="true" type="text" class="form-control">
</div>
<div class="form-group">
    <label style="color: red;"  class="text-muted" for="">Seguro Mip</label>
    <input type="text" id="mipseguro" readonly="true" class="form-control">
</div>
<div class="form-group">
    <label style="color: red;"  class="text-muted" for="">TSA</label>
    <input id="tsaseguro" type="text" readonly="true" class="form-control">
</div>
<div class="form-group">
    <label style="color: red;"  class="text-muted" for="">Prestação</label>
    <input id="prestacao2" type="text" readonly="true" class="form-control">
</div>
<div class="form-group">
    <label style="color: red;"  class="text-muted" for="">Sistema de Amortização</label>
    <input id="" type="text" class="form-control">
</div>
<br>
<div class="form-group">
                    <label style="color: red;"  class="text-muted" for="">Período de Carência</label>
                    <select id="periodoDeCarencia" name="periodoDeCarencia" type="text" class="form-control">
                        <option value="0">Selecione o período de Carência</option>
                        <option value="1">1 Mês</option>
                        <option value="2">2 Meses</option>
                        <option value="3">3 Meses</option>
                        <option value="4">4 Meses</option>
                        <option value="5">5 Meses</option>
                        <option value="6">6 Meses</option>
                    </select>
                </div>

            </div>
<!-- <div id="dvConteudo">Div css. -->
        <div class="card-body col-md-6" id="dvConteudo">
            <h4 style="left:200px; position: relative; color:red;"> <strong>Dados dos Proponentes</strong></h4>
            <br>

 
                <div class="card-body col-md-12 float-right border rounded">
                    <div class="form-row">
                        <div  class="col-md-3">
                            <div class="form-group">
                                <label style="color: red;" for="">Renda Final</label>
                                <input id="rendafinall" type="text" class="form-control">
                            </div>
                        </div>

                        <div style="top:0px;" class="col-md-3">
                            <div class="form-group">
                                <label style="color: red;" for="">Parcela Máxima Suge</label>
                                <input type="number" id="parcelmaxx" readonly="true" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label style="color: red;" for="">Saldo total a Refinanciar</label>
                                <input name="saldoTotalaRefinanciar" id="saldoTotalaRefinanciar" type="text" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label style="color: red;" for="">Parcela Intermediaria</label>
                                <input type="text" id="" disabled class="form-control">
                            </div>
                        </div>



          <div class="card-body col-md-6" style=""  id="dvConteudo">

            <h4 style="left:160px; position: relative; font-color: red;"> <strong style="color: red;" >Resumo Da Simulação</strong></h4>
            <br>
            <h6 style="position:relative; right: -40px; color: red;"  >Parcelas Concedidas</h6>
            <h6 style="position:relative; top:-25px; right: -260px; color: red;" >Valor a ser Pago</h6> 
            <h6 style="position:relative; top:-50px; right: -414px; color: red;" >Data de Vencimento</h6>
            <div  style="position: relative; top: -39px; left: -10px; color: red;" >
            <button style="height: 30px; width: 250px;" class="btn btn-danger btn-sm">1 Mês de Carência </button>
            <br>
            <br>
            <button style="height: 30px; width: 250px;" class="btn btn-danger btn-sm">2 Mês de Carência </button>
            <br>
            <br>
            <button style="height: 30px; width: 250px;" class="btn btn-danger btn-sm">3 Mês de Carência </button>
            <br>
            <br>
            <button style="height: 30px; width: 250px;" class="btn btn-danger btn-sm">4 Mês de Carência </button>
           </div>

           <div style="position: relative; top: -231px; right: -245px;">
           <div class="col-md-6">
                            <div class="form-group">
                                <input readonly="true"  name="" id="" type="text" class="form-control">
                            </div>
           </div>
           <div style="position: relative; top: 24px;" class="col-md-6">
                            <div class="form-group">
                                <input readonly="true"  name="" id="" type="text" class="form-control">
                            </div>
           </div>

           <div style="position: relative; top: 48px;" class="col-md-6">
                            <div class="form-group">
                                <input readonly="true"  name="" id="" type="text" class="form-control">
                            </div>
           </div>

           <div style="position: relative; top: 72px;" class="col-md-6">
                            <div class="form-group">
                                <input readonly="true"  name="" id="" type="text" class="form-control">
                            </div>
           </div>
           

           </div>
       
           <div style="position: relative; top: -351px; right: -400px;">
           <div class="col-md-6">
                            <div class="form-group">
                                <input readonly="true"  name="" id="" type="text" class="form-control">
                            </div>
           </div>
           <div style="position: relative; top: 24px;" class="col-md-6">
                            <div class="form-group">
                                <input readonly="true"  name="" id="" type="text" class="form-control">
                            </div>
           </div>

           <div style="position: relative; top: 48px;" class="col-md-6">
                            <div class="form-group">
                                <input readonly="true"  name="" id="" type="text" class="form-control">
                            </div>
           </div>

           <div style="position: relative; top: 72px;" class="col-md-6">
                            <div class="form-group">
                                <input readonly="true"  name="" id="" type="text" class="form-control">
                            </div>
           </div>
           
   <div  style="position: relative; top: 130px; left: -380px; color: red;" >
            <button style="height: 30px; width: 250px;" class="btn btn-danger btn-sm">Total de Juros Incorporados </button>
            <br>
            <br>
            <button style="height: 30px; width: 250px;" class="btn btn-danger btn-sm">CET (Custo Efetivo Total) </button>
            <br>
            <br>
            <button style="height: 30px; width: 250px;" class="btn btn-danger btn-sm">Razão Descrescimo </button>
            <br>
            <br>
            <button style="height: 30px; width: 250px;" class="btn btn-danger btn-sm">Proxima Parcela </button>
           </div>

           <div style="position: relative; top: -62px; right: 140px;">
           <div class="col-md-8">
                            <div class="form-group">
                                <input readonly="true"   type="text" class="form-control">
                            </div>
           </div>
           <div style="position: relative; top: 24px;" class="col-md-8">
                            <div class="form-group">
                                <input readonly="true"   type="text" class="form-control">
                            </div>
           </div>

           <div style="position: relative; top: 48px;" class="col-md-8">
                            <div class="form-group">
                                <input readonly="true"  id="decres" type="text" class="form-control">
                            </div>
           </div>

           <div style="position: relative; top: 72px;" class="col-md-8">
                            <div class="form-group">
                                <input readonly="true"  type="text" class="form-control">
                            </div>
           </div>
           <div  style="position: relative; top: 95px; right:130px; color: red;" >
            <button style="height: 45px; width: 290px;"  data-toggle="modal" data-target="#people" class="btn btn-danger btn-sm"><strong> PEOPLE </strong> </button>
            <br>
            <br>
            <button id="btnEvo" style="position:relative; right: 1px;" data-toggle="modal" class="btn btn-block btn-danger" data-target="#priceModal" style="">VER EVOLUÇÃO</button>
       
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
                                <p class="btn btn-block btn-danger"> PARCELAS FIXAS (PRICE)</p>
                            </div>
                        </div>
                        <div class="modal-body ">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label class="label-control">Nº Contrato</label>
                                    <input class="form-control" type="number" name="EDICAO" id="contract">
                                </div>
                                <div class="col-md-6">
                                    <label class="label-control">CPF</label>      
                                    <input class="form-control" type="number" name="CPF" id="CPF">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label class="label-control">Nome</label>
                                    <input class="form-control" type="text" id="NOME_MUTUARIO" name="NOME_MUTUARIO">
                                </div>
                                <div class="col-md-6">
                                    <label class="label-control">Plano</label>
                                    <select class="form-control select" type="text" name="PLANO" id="PLANO">
                                        <option value="PCM/SAC">PCM/SAC</option>
                                        <option value="PCM/SAC">PCM/TP</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label class="label-control">Taxa de Juros(%)</label>
                                    <input class="form-control" step="0.01" max="200" maxlength="3" type="text" id="taxamontreas">
                                </div>
                                <div class="col-md-6">
                                    <label class="label-control">Prestação</label>
                                    <input class="form-control" type="number"  id="prestacao">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label class="label-control">MIP</label>
                                    <input class="form-control" type="number"  id="MIP">
                                </div>
                                <div class="col-md-6">
                                    <label class="label-control">DFI</label>
                                    <input class="form-control" type="number" id="dfi">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label class="label-control">Taxa</label>
                                    <input class="form-control" type="number"  id="tsa">
                                </div>
                                <div class="col-md-6">
                                    <label class="label-control">Saldo devedor</label>
                                    <input class="form-control" type="number" name="deversaldo"  id="deversaldo">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label class="label-control">Novo Prazo (MESES)</label>
                                    <input class="form-control" type="number" id="novoprazo">
                                </div>
                                <div class="col-md-6">
                                    <label class="label-control">Dia do Vencimento</label>
                                    <input class="form-control" type="date"  id="vencimentododia">
                                </div>
                                <div class="col-md-6">
                                    <label class="label-control">TSA</label>
                                    <input class="form-control" type="number" id="tsa">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger" data-dismiss="modal" onclick="calcular();$('#btnEvo').show()">Calcular</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <script type="text/javascript">
 
 var visibilidade = true; //Variável que vai manipular o botão Exibir/ocultar
 
 function exibir() {
     document.getElementById("dvConteudo").style.display = "block";
 }

 function ocultar() {
     document.getElementById("dvConteudo").style.display = "none";
 }

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




 
 
 $("#check1").change(function() {
  if ($(this).prop("checked") == true) {
    alert("Checkbox Ativo!!!.");
    }
});

$("#check1").trigger("change");


function ocultarExibirIntermediarias() {
  if (visibilidade) {//Se a variável visibilidade for igual a true, então...
        document.getElementById("parcintermediarias").style.display = "block";//Ocultamos a div
        document.getElementById("parcintermediarias2").style.display = "block";//Ocultamos a div
        visibilidade = false;//alteramos o valor da variável para falso.
    } else {//ou se a variável estiver com o valor false..
        document.getElementById("parcintermediarias").style.display = "none";//Exibimos a div..
        document.getElementById("parcintermediarias2").style.display = "none";//Exibimos a div..

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
 

 function ocultarExibirCampanha() {
  if (visibilidade) {//Se a variável visibilidade for igual a true, então...
        document.getElementById("painel").style.display = "none";//Ocultamos a div
        document.getElementById("produtos").style.display = "none";//Ocultamos a div
        document.getElementById("produtos1").style.display = "none";//Ocultamos a div
        document.getElementById("dvConteudo").style.display = "none";//Ocultamos a div
        document.getElementById("semcampanha").style.display = "block";//Exibimos a div..

        visibilidade = false;//alteramos o valor da variável para falso.
    } else {//ou se a variável estiver com o valor false..
        document.getElementById("painel").style.display = "block";//Exibimos a div..
        document.getElementById("produtos").style.display = "none";//Ocultamos a div
        document.getElementById("produtos1").style.display = "none";//Ocultamos a div
        document.getElementById("dvConteudo").style.display = "none";//Ocultamos a div
        document.getElementById("semcampanha").style.display = "none";//Ocultamos a div


        visibilidade = false;//alteramos o valor da variável para falso.
    }
 }
 


 function ocultarExibirCampanhanao() {
  if (visibilidade) {//Se a variável visibilidade for igual a true, então...
        document.getElementById("painel").style.display = "block";//Exibimos a div..
        document.getElementById("produtos").style.display = "none";//Ocultamos a div
        document.getElementById("produtos1").style.display = "none";//Ocultamos a div
        document.getElementById("dvConteudo").style.display = "none";//Ocultamos a div
        document.getElementById("semcampanha").style.display = "none";//Ocultamos a div


        visibilidade = false;//alteramos o valor da variável para falso.
    } else {//ou se a variável estiver com o valor false..
        document.getElementById("painel").style.display = "block";//Exibimos a div..
        document.getElementById("produtos").style.display = "none";//Ocultamos a div
        document.getElementById("produtos1").style.display = "none";//Ocultamos a div
        document.getElementById("dvConteudo").style.display = "none";//Ocultamos a div
        document.getElementById("semcampanha").style.display = "none";//Ocultamos a div

        visibilidade = true;//Alteramos o valor da variável para true.
    }
 }


 function ocultarExibirParcelado() {
  if (visibilidade) {//Se a variável visibilidade for igual a true, então...
        document.getElementById("painel2").style.display = "block";//Exibimos a div..
        document.getElementById("painel").style.display = "none";//Ocultamos a div



        visibilidade = false;//alteramos o valor da variável para falso.
    } else {//ou se a variável estiver com o valor false..
        document.getElementById("painel2").style.display = "none";//Exibimos a div..
        document.getElementById("painel").style.display = "block";//Ocultamos a div

        visibilidade = true;//Alteramos o valor da variável para true.
    }
 }


 function ocultarExibirAvista() {
  if (visibilidade) {//Se a variável visibilidade for igual a true, então...
    document.getElementById("painel2").style.display = "block";//Exibimos a div..
        document.getElementById("painel").style.display = "none";//Ocultamos a div



        visibilidade = false;//alteramos o valor da variável para falso.
    } else {//ou se a variável estiver com o valor false..
        document.getElementById("painel2").style.display = "none";//Exibimos a div..
        document.getElementById("painel").style.display = "block";//Ocultamos a div

        visibilidade = true;//Alteramos o valor da variável para true.
    }
 }



  // Calcula os resultados ao pressionar as teclas
  document.body.addEventListener('keyup', function (e){calcular();parcelasIntermediarias();});
  function parcelasIntermediarias() {
    // Preenchimento pelo usuário
    PreenchimentoJ11 = parseFloat($('#parcelmaxx').val()) // Input hidden
    PreenchimentoJ12 = parseFloat($('#saldoTotalaRefinanciar').val()) // Input 
    PreenchimentoE31 = parseInt($('#periodoDeCarencia').val())// Select

    //  PGTO(taxa, nper, vp, [vf], [tipo])
    //Apoio!F86
    if( PreenchimentoJ11 > (PreenchimentoJ12*1.0129068)*((Math.pow(1.0289,0)*0.0289)/(Math.pow(1.0289,0)-1))) {
        ApoioF86 = 0
    } else {
        ApoioF86 = 1
    }

    ApoioH94 = PreenchimentoJ11 
    ApoioH99 = 0 // Calcular carencia
    ApoioD99 = 0 // Calculá-lo
    pmtInicial = PreenchimentoJ11
    car = PreenchimentoE31
    pmtAnterior = 0

    // Saldo Devedor inicial
    sdAnterior = PreenchimentoJ12

    for(i=0; i <= 6; i++) {
        // é carencia?
        if(car > i) {
            carencia = 1
        } else {
            carencia = 0
        }

        // calcula PMT
        if(i === 0) {
            pmt = pmtInicial
        } else if(carencia === 0) {
            pmt = (sdAnterior*((Math.pow(1.0289,(72-PreenchimentoE31))*0.0289)/(Math.pow(1.0289,(72-PreenchimentoE31))-1)))
        } else {
            pmt = pmtAnterior
        }

        // pmt anterior
        if(pmtAnterior > 0) {
            pmtAnterior += pmt-pmtAnterior
        } else {
            pmtAnterior += pmt
        }
 
        juros = 0.0289 * sdAnterior;
        amt = pmt - juros
        sdAnterior -= amt

        // Pega Valor na célula Apoio!H99 e Apoio!D99
        if(i === 5) {
            ApoioH99 += pmt
            ApoioD99 += sdAnterior
        }
        if(i === 6) {
        	if(carencia >= i) {
        		ApoioC100 = 1
        	} else {
        		ApoioC100 = 0
        	}
        }
    }

    // Apoio!H100
    if(ApoioC100 == 1) {
        ApoioH100 = ApoioH99
    } else {
        ApoioH100 = (ApoioD99*((Math.pow(1.0289,(72-PreenchimentoE31))*0.0289)/(Math.pow(1.0289,(72-PreenchimentoE31))-1)))
    }

    // Apoio!F87
    ApoioF87 = ApoioH94-0

    if(ApoioF86 == 1 && ApoioH100 > 5) {
        console.log(ApoioF87)
        return $('#maximodesconto').val(Number(ApoioF87));

    } else {
        return $('#maximodesconto').val(0);
    }
}
  // Efetua os cálculos
  function calcular()
    {
 //* Saldo Atual *\\ 
 var saldo223 = curNum($('#deversaldo').val());
    var totalidade = saldo223
    var totalidade = "R$" + totalidade;
    $('#saldo_atual').val(String(totalidade));

  //* Calculando Produto Oferta PEOPLE *\\ 
    var produtosof = String($('#produtooferta').val());
    var ofproduct = produtosof
    $('#prodct1').val(String(ofproduct));


    //* Novo Prazo  *\\ 
    var saldo224 = curNum($('#novoprazo').val());
    var totalidade1 = saldo224
    $('#prazomeses').val(curNum(totalidade1));

    
    //* Data de Vencimento *\\ 
    var saldo225 = String($('#vencimentododia').val());
    var totalidade2 = saldo225
    $('#vencimentos').val(String(totalidade2));
    $('#vencimentos').val().substr(0, 2)

     //* Taxa Montreal *\\ 
    var saldo226 = curNum($('#taxamontreas').val());
    var totalidade3 = saldo226
    var totalidade3 = totalidade3 + "%";
    $('#taxajurosmontreas').val(String(totalidade3));

    

     //* Taxa Comum *\\ 
    var saldo227 = curNum($('#tsa').val());
    var totalidade4 = saldo227
    var totalidade4 = totalidade4 + "%";
    $('#taxaefetiva').val(String(totalidade4));


   //* Calculando MIP *\\ 
   var saldo228 = curNum($('#MIP').val());
    var totalidade5 = saldo228
    var totalidade5 = "R$" + totalidade5;
    $('#mipseguro').val(String(totalidade5));
console.log(totalidade5)

   //* Calculando DIF *\\ 
    var saldo229 = curNum($('#dfi').val());
    var totalidade6 = saldo229
    var totalidade6 =  "R$" + totalidade6;
    $('#dfiseguro').val(String(totalidade6));


   //* Calculando TSA *\\ 
    var saldo230 = curNum($('#tsa').val());
    var totalidade7 = saldo230
    var totalidade7 =  "R$" + totalidade7;
    $('#tsaseguro').val(String(totalidade7));


   //* Calculando Prestação *\\ 
    var saldo231 = curNum($('#prestacao').val());
    var totalidade8 = saldo231
    var totalidade8 =  "R$" + totalidade8;
    $('#prestacao2').val(String(totalidade8));

     //* Calculando PRAZO MESES *\\ 
    var saldo231 = curNum($('#novoprazo').val());
    var totalidade8 = saldo231
    var totalidade8 =  "R$" + totalidade8;
    $('#prazomeses').val(String(totalidade8));


    //* Calculando Parcela Maxima Sugerida *\\ 
    var rendafinal = curNum($('#rendafinall').val());
    if(rendafinal < 250){
    var parcelamaxsug = 100;
    }
    if (rendafinal > 250){
    var parcelamaxsug = rendafinal * 0.4;    
    }

    $('#parcelmaxx').val(String(parcelamaxsug));
    
    
    //* Calculando CPF PEOPLE *\\ 
    var CPF = curNum($('#CPF').val());
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
    var contract = curNum($('#contract').val());
    var contratos = contract
    $('#contratonum').val(curNum(contratos));


 //* Calculando PRAZO MAXIMO PERMITIDO MESES *\\ 
 var datinha = curNum($('#date1').val());
    console.log(datinha)
    if(datinha > 1974){
        var dataprazo = 420;
    }
    else if(datinha >= 1974){
        var dataprazo = 412;
    }
    else if(datinha >= 1973){
        var dataprazo = 400;
    }
    else if(datinha >= 1972){
        var dataprazo = 388;
    }
    else if(datinha >= 1971){
        var dataprazo = 376;
    }
    else if(datinha >= 1970){
        var dataprazo = 364;
    }
    else if(datinha >= 1969){
        var dataprazo = 352;
    }
    else if(datinha >= 1968){
        var dataprazo = 340;
    }
    else if(datinha >= 1967){
        var dataprazo = 328;
    }
    else if(datinha >= 1966){
        var dataprazo = 316;
    }
    else if(datinha >= 1965){
        var dataprazo = 304;
    }
    else if(datinha >= 1964){
        var dataprazo = 292;
    }
    else if(datinha >= 1963){
        var dataprazo = 280;
    }
    else if(datinha >= 1962){
        var dataprazo = 268;
    }
    else if(datinha >= 1961){
        var dataprazo = 256;
    }
    else if(datinha >= 1960){
        var dataprazo = 244;
    }
    else if(datinha >= 1959){
        var dataprazo = 232;
    }
    else if(datinha >= 1958){
        var dataprazo = 220;
    }
    else if(datinha >= 1957){
        var dataprazo = 208;
    }
    else if(datinha >= 1956){
        var dataprazo = 196;
    }
    else if(datinha >= 1955){
        var dataprazo = 184;
    }
    else if(datinha >= 1954){
        var dataprazo = 172;
    }
    else if(datinha >= 1953){
        var dataprazo = 160;
    }
    else if(datinha >= 1952){
        var dataprazo = 148;
    }
    else if(datinha >= 1951){
        var dataprazo = 136;
    }
    else if(datinha >= 1950){
        var dataprazo = 124;
    }
    else if(datinha >= 1949){
        var dataprazo = 112;
    }
    else if(datinha >= 1948){
        var dataprazo = 100;
    }
    else if(datinha >= 1947){
        var dataprazo = 88;
    }
    else if(datinha >= 1946){
        var dataprazo = 76;
    }
    else if(datinha >= 1945){
        var dataprazo = 64;
    }
    else if(datinha >= 1944){
        var dataprazo = 52;
    }
    else if(datinha >= 1943){
        var dataprazo = 40;
    }
    else if(datinha >= 1942){
        var dataprazo = 28;
    }
    else if(datinha >= 1941){
        var dataprazo = 16;
    }
    else if(datinha >= 1940){
        var dataprazo = 4;
    }
    else if(datinha >= 1939){
        var dataprazo = -7;
    }
    else if(datinha >= 1938){
        var dataprazo = -19;
    }
    else if(datinha >= 1937){
        var dataprazo = -31;
    }
    else if(datinha >= 1936){
        var dataprazo = -43;
    }
    else if(datinha >= 1935){
        var dataprazo = -55;
    }
    else if(datinha >= 1934){
        var dataprazo = -67;
    }
    else if(datinha >= 1933){
        var dataprazo = -79;
    }
    else if(datinha >= 1932){
        var dataprazo = -91;
    }
    else if(datinha >= 1931){
        var dataprazo = -103;
    }
    else if(datinha >= 1930){
        var dataprazo = -115;
    }
    else if(datinha >= 1929){
        var dataprazo = -127;
    }
    else if(datinha >= 1928){
        var dataprazo = -129;
    }
    else if(datinha >= 1927){
        var dataprazo = -151;
    }
    else if(datinha >= 1926){
        var dataprazo = -163;
    }
    else if(datinha >= 1925){
        var dataprazo = -175;
    }
    else if(datinha >= 1924){
        var dataprazo = -187;
    }
    else if(datinha >= 1925){
        var dataprazo = -175;
    }
    else if(datinha >= 1924){
        var dataprazo = -187;
    }
    else if(datinha >= 1923){
        var dataprazo = -199;
    }
    else if(datinha >= 1922){
        var dataprazo = -211;
    }
    else if(datinha >= 1921){
        var dataprazo = -223;
    }
    else if(datinha >= 1920){
        var dataprazo = -235;
    }
    else if(datinha >= 1919){
        var dataprazo = -247;
    }
    else if(datinha >= 1918){
        var dataprazo = -259;
    }
  
    
 
    console.log(datinha)

    $('#prazopermitido').val(curNum(dataprazo));





   //* Calculando Razao de Decrescimo  *\\ 
        var modalidade101 = curNum($('#taxamontreas').val());
        
        var valorz = 1;
        var valorzinho = modalidade101 / 100;

        var resultotal = valorz * valorzinho / 12;

        var restultotal1 = (resultotal.toFixed(2));


        $('#decres').val(String(restultotal1));


}






 
  //* Calculando Prazo Minimo 1  *\\ 
    var saldopp = curNum($('#saldoreorg').val());
    if (saldopp < 48){
        var totalidade10 = 1;
    }
    if (saldopp > 48){
        var totalidade10 = 2;
    }
    if (saldopp > 114){
        var totalidade10 = 3;
    }
    if (saldopp > 170){
        var totalidade10 = 4;
    }
    if (saldopp > 223){
        var totalidade10 = 5;
    }
    if (saldopp > 170){
        var totalidade10 = 4;
    }
    if (saldopp > 223){
        var totalidade10 = 5;
    }
    if (saldopp > 229){
        var totalidade10 = 6;
    }
    if (saldopp > 271){
        var totalidade10 = 8;
    }
    if (saldopp > 299){
        var totalidade10 = 10;
    }
    if (saldopp > 349){
        var totalidade10 = 12;
    }
    if (saldopp > 399){
        var totalidade10 = 14;
    }
    if (saldopp > 449){
        var totalidade10 = 17;
    }
    if (saldopp > 499){
        var totalidade10 = 20;
    }
    if (saldopp > 549){
        var totalidade10 = 24;
    }
    if (saldopp > 599){
        var totalidade10 = 28;
    }
    if (saldopp > 650){
        var totalidade10 = 32;
    }
    if (saldopp > 699){
        var totalidade10 = 38;
    }
    if (saldopp > 749){
        var totalidade10 = 45;
    }
    if (saldopp > 750){
        var totalidade10 = 30;
    }
    if (saldopp > 1759){
        var totalidade10 = 72;
    }


    $('#prazominimo113').val(String(totalidade10));



  //* Calculando Prazo Minimo 2  *\\ 
  var saldopp2 = curNum($('#prazominimo2').val());
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



  //* Calculando Modalidade  *\\ 
  var modalidade = curNum($('#saldoreorg').val());
  if (modalidade < 271){
        var modalidade3 = "NORMAL";
    }
  if (modalidade > 271){
        var modalidade3 = "ESTENDIDO";
    }

  if (modalidade < 1){
        var modalidade3 = "Resumo Da Simulação Imob";
    }
  $('#modalidade').val(String(modalidade3));


  //* Calculando PMT Carencia  *\\ 
  var modalidade100 = curNum($('#parcelaTotalIni').val());
  var resultadinho = modalidade100

  $('#carenciapmt').val(String(resultadinho));


  //* Calculando Razao de Decrescimo  *\\ 
  var modalidade101 = curNum($('#taxamontreas').val());
  if (modalidade101 < 5){
        var decrescimo3 =  0;
    }
  if (modalidade101 > 5){
        var decrescimo3 =  0.01;
    }
  if (modalidade101 > 19){
        var decrescimo3 =  0.02;
    }
  if (modalidade101 > 29){
        var decrescimo3 =  0.03;
    }
  if (modalidade101 > 39){
        var decrescimo3 =  0.04;
    }
  if (modalidade101 > 59){
        var decrescimo3 =  0.05;
    }
  if (modalidade101 > 69){
        var decrescimo3 =  0.06;
    }
  if (modalidade101 > 79){
        var decrescimo3 =  0.07;
    }
  if (modalidade101 > 89){
        var decrescimo3 =  0.08;
    }
  if (modalidade101 > 99){
        var decrescimo3 =  0.08;
    }
  if (modalidade101 > 109){
        var decrescimo3 =  0.09;
    }
  if (modalidade101 > 119){
        var decrescimo3 =  0.10;
    }
  if (modalidade101 > 129){
        var decrescimo3 =  0.11;
    }
  if (modalidade101 > 139){
        var decrescimo3 =  0.12;
    }
  if (modalidade101 > 149){
        var decrescimo3 =  0.13;
    }
  if (modalidade101 > 159){ 
        var decrescimo3 =  0.14;
    }
  if (modalidade101 > 179){ 
        var decrescimo3 =  0.15;
    }
  if (modalidade101 > 189){ 
        var decrescimo3 =  0.16 ;
    }

  $('#decres').val(String(decrescimo3));

  //*  CALCULANDO PRICE SALDO \\*
  var modalidade103 = curNum($('#deversaldo').val());
  var deversaldos = modalidade103;
  $('#saldo').val(String(deversaldos));

  //*  CALCULANDO PRICE PARCELA TOTAL INICIAL \\ 

    var juros = 2.89;
    var saldo = curNum($('#saldoreorg').val());
    var prazo = curNum($('#prazominimo1').val());
    
    var juroscalculo = juros / 100;
    var juros1 = juros / 100 +1;
    var juros1real = Math.pow(juros1,prazo)*juroscalculo;


    var juros2 = juros / 100 + 1; 
    var juros2real = Math.pow(juros2,prazo)-1;

    var parcelasbreve = juros2real / juros1real;

    var parcelatotalinicial = saldo / parcelasbreve;
    console.log(parcelatotalinicial)
    $('#parcelaTotalIni').val(String(parcelatotalinicial));

</script>



<script type="text/javascript">
  document.body.addEventListener('keyup', function (e){calcular()});

  $('#n1').priceFormat({prefix:'',centsSeparator:',', thousandsSeparator:'.', centsLimit:2});
  $('#num1').priceFormat({prefix:'',centsSeparator:',', thousandsSeparator:'.', centsLimit:2});
  
  $('#n1').select();

  function calcular()
    {

        calculoGGG()
    
    var n1 = curNum($('#Numpar').val());
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
   var numerodeparcelas = curNum($('#numparcelas').val());
   var valordasparcelas = curNum($('#valordasparcelas').val());
   var entrada = curNum($('#Entradatotal').val());
   var resultado8 = ((numerodeparcelas * valordasparcelas) - entrada);


   //* Produtos Calculando desconto *\\ 
   var datraso = curNum($('#diasatrasoprodutos').val());
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
   var datraso = curNum($('#diasatrasoprodutos1').val());
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
  var diasdeatraso3 = curNum($('#Numpar3').val());
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
 var diasdeatraso4 = curNum($('#Numpar3').val());
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






   $('#totalnegociado').val(numCur(resultado8));
     }
     

    
   //* Campanha calculando desconto a vista *\\ 
   var diasatraso = curNum($('#atrasodias').val());
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
 var diasatraso1 = curNum($('#atrasodias').val());
 var parcelasnumero1 = curNum($('#parcelasnumero').val());

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
 var numerodeparcelas1 = curNum($('#parcelasnumero').val());
 if(numerodeparcelas1 > 12){
     var taxaparcela1 = 1;
 }
 else if (numerodeparcelas1 < 13){
     var taxaparcela1 = 0;
 }
 var taxaparcela1 = taxaparcela1 + "%";
 $('#campanhataxa').val(String(taxaparcela1));

 


  //* Parc Intermediarias Calculo  *\\ 
  var parcelasinter  = curNum($('#parcintermediarias3').val());
 if(parcelasinter < 6000){
     var parcelairregular = 30;
 }
 else if (parcelasinter > 6000){
     var parcelairregular = parcelasinter * (0.5/100);
 }
 var parcelairregular =  "R$" + parcelairregular;
 $('#parcintermediarias4').val(String(parcelairregular));




  //* Parc Intermediarias Calculo  *\\ 
  var parcelasinter  = curNum($('#parcintermediarias7').val());
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
    
    var n1 = curNum($('#Numpar').val());
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
    console.log(taxaefetiva)
    ApoioF22 = (Math.pow((1+taxaefetiva),(1/12))-1)
    ApoioF24 = parseFloat($('#MIP').val())/parseFloat($('#deversaldo').val())

    car -= 1
    i = 0;
    nextPmtImob = 0
    tr = ''

    var dateInput = ($('input[type=date]').val()).split('-')
    var dataPgto = new Date(dateInput[0], dateInput[1], dateInput[2])

    linha = ''
	fator = new Map();
	fatorTotal = 0
    for(n=0; n <= prazo; n++) {
    	if(n === 0 ) {
    		fator.set(n,1)
    	}
    	if(n > car) {
    		fator.set(n, 1*(1/(Math.pow((1+ApoioF22),n))) )
    		fatorTotal = parseFloat(fatorTotal + parseFloat(1/(Math.pow((1+ApoioF22),n))))
    	}
    	
    }
    console.log(fatorTotal)   

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
            parcelafinal = (amt + juros + mip + dfi + tsa);
            

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
	        sdAnterior = sdAnterior - sdAnterior;
	        sdAnterior = saldoDevedor;
	    }
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
            console.log(amt)

            //Parcelas
            pmt = amt + juros;

            //Saldo Devedor
            saldoDevedor = sdAnterior - amt;

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

        if(carencia == true) {
        	tr +=   '<tr>'+
        	'<td class="bg-danger text-white"><b>'+(i)+' Mês de Carência</b></td>'+
        	'<td id="pmtCarencia1">R$' + parcelafinal + '</td>'+
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
	if(saldo > 0 && prazo > 0) {
		var car = parseInt(carencia()) 
		var mdldd = modalidade(car)
		iptPrMin(car,mdldd)

		// verifica qual plano calcular
		if(parseInt($('#PLANO').val()) === 1) {
			sac(car)
		} else if(parseInt($('#PLANO').val()) === 1) {
			price(car)
		}

    }

    }


   // var now = new Date(); // Data de hoje
    //var past = new Date($('#dataatraso').val());
    //var diff = Math.abs(now.getTime() - past.getTime()); // Subtrai uma data pela outra
    //var days = Math.ceil(diff / (1000 * 60 * 60 * 24)); // Divide o total pelo total de milisegundos correspondentes a 1 dia. (1000 milisegundos = 1 segundo).
    // Mostra a diferença em dias
   // $('#Diasatraso').val(numCur(days));



    //console.log('Entre 07/07/2014 até agora já se passaram ' + days + ' dias');
    
    //function dateToEN(date)
//{	   
	//return date.split('/').reverse().join('-');
//}



</script>

</html>