<!DOCTYPE html>
<html lang="en">

<head>
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Calculadora Painel de consulta</title>
    <link type="text/css" rel="shortcut icon" href="objetos/imagens/favicon.ico" type="image/x-icon">
    <link type="text/css" rel="icon" href="objetos/imagens/favicon.ico" type="image/x-icon">
    <link type="text/css" href="objetos/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" href="objetos/plugins/awesome/css/font-awesome.min.css" rel="stylesheet">
    <link type="text/css" href="objetos/plugins/notification/bs4.pop.css" rel="stylesheet">
    <link type="text/css" href="objetos/style.css" rel="stylesheet">
</head>
<script type="text/javascript"  src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.min.js"></script>
<script type="text/javascript"  src="objetos/jquery/jquery.min.js"></script>
<script type="text/javascript"  src="objetos/plugins/popper/popper.min.js"></script>
<script type="text/javascript"  src="objetos/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript"  src="objetos/plugins/notification/bs4.pop.js"></script>
<script type="text/javascript"  src="objetos/plugins/priceformat/jquery.price_format.min.js"></script>
<script type="text/javascript"  src="objetos/funcoes.js"></script>
<body>
<style>
.form-check2{
    padding-left:150px;
    position:relative;
    top:-70px;
}


/* estilo do checkbox Leandro */
[type="checkbox"]:not(:checked),
[type="checkbox"]:checked {
  position: absolute;
  left: -9999px;
}
[type="checkbox"]:not(:checked) + label,
[type="checkbox"]:checked + label {
  position: relative;
  padding-left: 1.95em;
  cursor: pointer;
}

/* checkbox aspect */
[type="checkbox"]:not(:checked) + label:before,
[type="checkbox"]:checked + label:before {
  content: '';
  position: absolute;
  left: 0; top: 0;
  width: 1.25em; height: 1.25em;
  border: 2px solid #ccc;
  background: #fff;
  border-radius: 4px;
  box-shadow: inset 0 1px 3px rgba(0,0,0,.1);
}
/* checked marcar aspect */
[type="checkbox"]:not(:checked) + label:after,
[type="checkbox"]:checked + label:after {
  content: '\2713\0020';
  position: absolute;
  top: .15em; left: .22em;
  font-size: 1.3em;
  line-height: 0.8;
  color: #09ad7e;
  transition: all .2s;
  font-family: 'Lucida Sans Unicode', 'Arial Unicode MS', Arial;
}
/* marcar checkbox */
[type="checkbox"]:not(:checked) + label:after {
  opacity: 0;
  transform: scale(0);
}
[type="checkbox"]:checked + label:after {
  opacity: 1;
  transform: scale(1);
}
/* desabilitar checkbox */
[type="checkbox"]:disabled:not(:checked) + label:before,
[type="checkbox"]:disabled:checked + label:before {
  box-shadow: none;
  border-color: #bbb;
  background-color: #ddd;
}
[type="checkbox"]:disabled:checked + label:after {
  color: #999;
}
[type="checkbox"]:disabled + label {
  color: #aaa;
}
/* checkbox estilo */
[type="checkbox"]:checked:focus + label:before,
[type="checkbox"]:not(:checked):focus + label:before {
  border: 2px dotted blue;
}

/*  */
label:hover:before {
  border: 2px solid #4778d9!important;
}



/* Design Corpo Simulação */

body {
  font-family: "Open sans", "Segoe UI", "Segoe WP", Helvetica, Arial, sans-serif;
  color: #777;
}
h1, h2 {
  margin-bottom: .25em;
  font-weight: normal;
  text-align: center;
}
h2 {
  margin: .25em 0 2em;
  color: #aaa;
}
form {
  width: 7em;
  margin: 0 auto;
}
.txtcenter {
  margin-top: 4em;
  font-size: .9em;
  text-align: center;
  color: #aaa;
}
.copy {
 margin-top: 2em; 
}
.copy a {
 text-decoration: none;
 color: #4778d9;
}
</style>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a style="color:;" class="navbar-brand" href="#">Busca De Ofertas Over PF</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
       
                <li class="nav-item active">
                    <a class="nav-link" href="#">Painel <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a id="btnExibeOculta" onclick="ocultarExibir();" class="nav-link" href="#">Simulador</a>
                </li>
               <li class="nav-item float-left">
                    <img class="rounded float-right" style=" " >
                </li>
                <li class="nav-item float-right">
                    <button class="btn btn-secondary" style=" position:relative; right: -700px; " type="button">Pesquisar</button>
                </li>
                <li class="nav-item float-right"><a href="https://liderbook.liderancacobrancas.com.br/liderbook/public/">
                    <button class="btn btn-secondary" style=" width: 10%; margin-right: 780px; position:relative; right: -700px;" type="reset">Sair</button>
                    </a>
                </li>
            </ul>
        </div>
       
    </nav>
    <div class="page-content">
        <div class="row">
            <div class="card-body col-md-4 padding">
                <div class="input-group col-md-12">
                    <div class="input-group-prepend">
                        <span class="input-group-text azul">CPF</span>
                    </div>

                    <input maxlength="14" onfocus="javascript: retirarFormatacao(this);" onblur="javascript: formatarCampo(this);" onfocus="javascript: retirarFormatacao(this);" type="text" class="form-control" name="cpfajax" id="cpfajax" placeholder="Digite o CPF">
                    </form>
               </div>

               <div class="btn-group col-md-12">
               <label class="btn btn-outline-danger">
                    <input name="pagamentotipo" value="debito" type="radio" >Débito
               </label>
               <label class="btn btn-outline-danger">
                    <input name="pagamentotipo" value="boleto" type="radio" >Boleto
               </label>
                </div>
              

            </div>
            <div class="card-body col-md-3">
                <h5 class="text-muted text-center">Forma de Pagamento</h5>
                <div class="btn-group col-md-12">
                  <label class="btn btn-outline-primary">
                    <input onclick="ocultarExibirAvista();" checked="true" name="pagamento" value="avista" type="radio">Á Vista
                  </label>
                  <label class="btn btn-outline-primary">
                    <input onclick="ocultarExibirParcelado();" name="pagamento" value="parcelado" type="radio" > Parcelado
                  </label>
                </div>
            </div>
            <div class="card-body col-md-3">
                <h5 class="text-muted text-center">Utilizar a campanha</h5>
                <div class="btn-group col-md-12">
                <label class="btn btn-outline-success">
                    <input onclick="ocultarExibirCampanhanao();" checked="true"  name="campanha" value="nao" type="radio">Não
                </label>
                <label class="btn btn-outline-success">
                    <input onclick="ocultarExibirCampanha();"  name="campanha" value="sim" type="radio">Sim
                </label>
                </div>
            </div>
            <div class="card-body col-md-2">
                    <div class="custom-control custom-checkbox">
                    <input type="checkbox" id="test1" />
                    <label for="test1" onclick="ocultarExibirIntermediarias();">Parc Intermediárias</label>
                </div> 
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="customCheck1">
                    <input type="checkbox" id="test2"/>
                    <label for="test2" onclick="ocultarExibirResultado();">+ de 1 produto </label>
                </div>
            </div>
        </div>
        <div class="row">
            <div  id="painel" class="card-body col-md-4">
                    <div class="form-group">
                        <label class="text-muted" for="">Num Max de Parcelas:</label>
                        <input readonly="true" type="text" class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="text-muted" for="">Qtd de dias de atraso:</label>
                        <input id="Numpar" type="text" class="form-control">
                        <input id="Numpar2" style="display: none;" type="text" class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="text-muted" for="">Num de Parcelas:</label>
                        <input id="Parcelas" min="72" max="72" maxlength="2"  type="number" class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="text-muted" for="">(%) Taxa:</label>
                        <input type="text" id="Taxapar" readonly="true" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="text-muted" for="">(%) Desconto:</label>
                        <input type="text"  id="Desconpar" id="taxa" readonly="true" class="form-control">
                    </div>


                    <div id="minentrada" style="display: none;" class="form-group">
                        <label class="text-muted" for="">Valor min. de entrada:</label>
                        <input type="text" value="1 PMT" readonly="true" class="form-control">
                    </div>
                    <div id="parcintermediarias" style="display: none;" class="form-group">
                        <label class="text-muted" for="">Saldo Total devedor:</label>
                        <input type="text" id="parcintermediarias3"  class="form-control">
                    </div>
                    <div id="parcintermediarias2" style="display: none;" class="form-group">
                        <label class="text-muted" for="">Valor minimo de parcela irregular:</label>
                        <input type="text" id="parcintermediarias4" readonly="true"  class="form-control">
                    </div>
            </div>
<!-- <div id="dvConteudo">Div css. -->
        <div class="card-body col-md-6" style="display: none;" id="dvConteudo">
            <h4 style=""> <strong>Simulação de Ofertas Over PF S/ CAMPANHA</strong></h4>
            <br>
                <div class="col-md-2 float-left">
                    <div class="form-group">
                        <label class="text-muted" for="">Taxa:</label>
                        <input type="text" id="taxaentrada" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="text-muted" for="">Entrada:</label>
                        <input id="Entrada" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label class="text-muted" for="">Num de Parcelas:</label>
                        <input type="text" id="numparcelas" class="form-control">
                    </div>
                </div>
              
 
                <div class="card-body col-md-10 float-right border rounded">
                    <div class="form-row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Saldo Operação</label>
                                <input id="Saldoope" type="text" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Dias de Atraso</label>
                                <input type="number" id="dataatraso"  class="form-control">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">%Desconto</label>
                                <input name="desconto" id="desconto" type="text" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">%Desc Maximo</label>
                                <input type="text" id="maximodesconto" disabled class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Vlr.Desc.Concedido</label>
                                <input type="text" id="concedidodes" disabled class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Dias Atraso</label>
                                <input type="text" id="Diasatraso" disabled class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                </div>
                <br>
                
             <div style="top: 40px; left: 100px; display: none;" id="semcampanha" class="card-body col-md-10 float-right border rounded">
               <h4><strong> Simulação Para Clientes Sem Campanha </strong></h4>
                    <div class="form-row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Valor Negociado</label>
                                <input id="negociadovalor" type="text" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">N de Parcelas</label>
                                <input  id="parcelasnumero"  class="form-control">
                            </div>
                        </div>
                      
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Dias de Atraso</label>
                                <input  id="atrasodias" type="text" class="form-control">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">(%) Desconto á vista</label>
                                <input type="avistadesconto" id="avistadesconto" disabled class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">(%) Desconto parcelado</label>
                                <input type="text" id="parceladodesconto" disabled class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">(%) Taxa</label>
                                <input type="text" id="campanhataxa" disabled class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                
            <div class="col-md-2" style="display: none;" id="dvConteudo2">
                <div class="card-body">
                    <div class="form-group">
                        <label for="">
                            Saldo Atual
                        </label>
                        <input type="text" readonly="true" id="valoratual" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">
                            Vl. Negociado C / Desconto
                        </label>
                        <input type="text" id="descontonegociado" readonly="true" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">
                            Qnt. Parcelas
                        </label>
                        <input id="Qntparcelas" type="text" readonly="true" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">
                            Taxa Juros
                        </label>
                        <input type="text" id="taxatotal" readonly="true" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">
                            Vl. Parcelas
                        </label>
                        <input type="text" readonly="true" id="valordasparcelas" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">
                            Entrada
                        </label>
                        <input type="text" id="Entradatotal" readonly="true" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">
                            Vlr Total Negociado
                        </label>
                        <input type="text" readonly="true" id="totalnegociado" class="form-control">
                    </div>
                </div>
                </div>

                <div id="produtos" style="top: -10px; margin-left: 130px; display:none;" class="card-body col-md-4 float-left border rounded">
                     <h5 style="margin-left: 185px;"><strong> Produtos </strong></h5>
                      <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Dias Atraso</label> 
                                <input type="text" id="diasatrasoprodutos"  class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Desconto</label>
                                <input type="text" id="descontoprodutos" readonly="true" disabled class="form-control">
                            </div>
                        </div>
                        <br>
                        <h5 style="margin-left: 190px;"><strong> Produtos </strong></h5>
                      <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Dias Atraso</label>
                                <input type="text" id="diasatrasoprodutos1"  class="form-control">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="">Desconto</label>
                                <input type="text" id="descontoprodutos2" readonly="true" disabled class="form-control">
                            </div>
                        </div>
                   <div style="display: none;"   id="produtos1" style="margin-right: 420px; top: -210px;"  class="card-body col-md-6 float-right border rounded">
                   </div>
             </div>
            </div>
            <div class="row">
            <div style="display: none;" id="painel2" class="card-body col-md-4">
                    <div class="form-group">
                        <label class="text-muted" for="">Num Max de Parcelas:</label>
                        <input readonly="true" type="text" class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="text-muted" for="">Qtd de dias de atraso:</label>
                        <input id="Numpar3"  type="text" class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="text-muted" for="">Num de Parcelas:</label>
                        <input id="Parcelas3" min="72" max="72" maxlength="2"  type="number" class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="text-muted" for="">(%) Taxa Parcelado:</label>
                        <input type="text" id="Taxapar3" readonly="true" class="form-control">
                    </div>

                    <div class="form-group">
                        <label class="text-muted" for="">(%) Desconto Parcelado:</label>
                        <input type="text" id="Desconpa3r"  readonly="true" class="form-control">
                    </div>
                    <div id="parcintermediarias5"  class="form-group">
                        <label class="text-muted" for="">Valor min. de entrada:</label>
                        <input type="text"  value="1 PMT" readonly="true" class="form-control">
                    </div>
                    <div id="parcintermediarias6" class="form-group">
                        <label class="text-muted" for="">Saldo Total devedor:</label>
                        <input type="text" id="parcintermediarias7"  class="form-control">
                    </div>
                    <div id="parcintermediarias2" style="display: none;" class="form-group">
                        <label class="text-muted" for="">Valor minimo de parcela irregular:</label>
                        <input type="text" id="parcintermediarias4" readonly="true"  class="form-control">
                    </div>
            </div>
        </div>
</body>
<script>
$(document).ready(function(){

fetch_customer_data();

function fetch_customer_data(query = '')
{
 $.ajax({
  url:"{{asset('Calculadoras/painel/getBase/Auth::id()/Auth::user()->ilha_id')}}"+$("#cpfajax").val(),
  method:'GET',
  data:{query:query},
  dataType:'json',
  success:function(data)
  {
      linha = ""
      for(i=0; i < data.length; i++) 
          linha += '<tr>'+
                       '<td>'+data[i].desconto_avista+'</td>'+
                   '</tr>';
    $('#Desconpar').html(linha);
   console.log(data)
      }
 

   //$('#cpfajax').text(data.cpf);
  }
 })
}

$(document).on('keyup', '#cpfajax', function(){
 var query = $(this).val();
 fetch_customer_data(query);
});
});
</script>


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
        document.getElementById("dvConteudo").style.display = "block";//Ocultamos a div
        document.getElementById("dvConteudo2").style.display = "block";//Ocultamos a div
        visibilidade = false;//alteramos o valor da variável para falso.
    } else {//ou se a variável estiver com o valor false..
        document.getElementById("dvConteudo").style.display = "none";//Exibimos a div..
        document.getElementById("dvConteudo2").style.display = "none";//Exibimos a div..
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
  document.body.addEventListener('keyup', function (e){calcular()});

  // Define os campos com a máscara de moeda
  $('#Entrada').priceFormat({prefix:'',centsSeparator:',', thousandsSeparator:'.', centsLimit:2});
  $('#Saldoope').priceFormat({prefix:'',centsSeparator:',', thousandsSeparator:'.', centsLimit:2});
  $('#txValorParcelaVencer').priceFormat({prefix:'',centsSeparator:',', thousandsSeparator:'.', centsLimit:2});
  $('#txValorParcela').select();

  // Efetua os cálculos
  function calcular()
    {
    var ValorParcela = curNum($('#txValorParcela').val());
    var Juros = curNum($('#txJuros').val());
    var Iof = curNum($('#txIof').val());
    var Gca = curNum($('#txGca').val());
    var JurosPagar = curNum($('#txJurosPagar').val());
    var ValorParcelaVencer = curNum($('#txValorParcelaVencer').val());
    var ValorPremio = curNum($('#txValorPremio').val());
    var TaxaComissao = 0.06;
    }

</script>
<script type="text/javascript">
  document.body.addEventListener('keyup', function (e){calcular()});

  $('#n1').priceFormat({prefix:'',centsSeparator:',', thousandsSeparator:'.', centsLimit:2});
  $('#num1').priceFormat({prefix:'',centsSeparator:',', thousandsSeparator:'.', centsLimit:2});
  
  $('#n1').select();

  function calcular()
    {

        calculoGGG()
        
        $(document).ready(function(){

        fetch_customer_data();
        var cpfajax =  curNum($('#cpfajax').val());

        function fetch_customer_data(cpfajax)
        {
        $.ajax({
        url:"{{ route('cpf') }}",
        method:'GET',
        data:{cpfajax},
        dataType:'json',
        success:function(data)
        {
        var desconto_cpf = JSON.parse(JSON.stringify(data[0].desconto_avista));        
        var desconto_parceladocpf2 = JSON.parse(JSON.stringify(data[0].desconto_avista2a4x));
           var taxa_avistabd = JSON.parse(JSON.stringify(data[0].taxa_avista));
            if(taxa_avistabd < 1){
            taxaavistabol = "FALSO";
            }
            $('#Taxapar').val(String(taxaavistabol)); 
            console.log(taxaavistabol)
        }
        })
        }

        $(document).on('keyup', '#cpfajax', function(){
        var query = $(this).val();
        fetch_customer_data(query);
        });
        });


        var cpfcalculos = curNum($('#cpfajax').val());
        var n1 = curNum($('#Numpar').val());
        if (n1 < 90 && cpfcalculos < 1){
            var n2 = 0;
        }
        else if (n1 > 91 && cpfcalculos < 1){ 
            var n2 = 4;
        }
        if (n1 > 121 && cpfcalculos < 1){
            var n2 = 10;
        }
        if (n1 > 181 && cpfcalculos < 1){
            var n2 = 22;
        }
        if (n1 > 361 && cpfcalculos < 1){
            var n2 = 40;
        }
        if (n1 > 721 && cpfcalculos < 1){
            var n2 = 57; 
        }
        if (n1 > 1081 && cpfcalculos < 1){
            var n2 = 75;
        }
        if (cpfcalculos > 1){
            var n2 = desconto_cpf;
        }
        if (cpfcalculos > 1 && n1 < 1){
            var n2 = desconto_cpf;
        }
        if (n1 < 1 && cpfcalculos < 1){
            var n2 = 0;
        }
        if (n1 < 1 && cpfcalculos > 1){
            var n2 = desconto_cpf;
        }

         resultado = n2;
         resultado = resultado + "%";

        $('#Desconpar').val(String(resultado)); 
    


    //*  Parcelas Valor  *\\
    var parcelas = curNum($('#numparcelas').val());
    var quantidade = (parcelas);
    var resultado = quantidade;
    $('#Qntparcelas').val((resultado));


     //*  Parcelas Valor  *\\
     var entrada = curNum($('#Entrada').val());
    var quantidade2 = (entrada);
    var resultado2 = quantidade2;
    $('#Entradatotal').val(numCur(resultado2));


    //*  Taxa Valor  *\\
    var entradataxa = curNum($('#taxaentrada').val());
    var quantidade3 = (entradataxa);
    var resultado3 = quantidade3;
    $('#taxatotal').val(numCur(resultado3));

   
   //* Calcula Valor dos dias *\\ 
    var data1 = curNum($('#dataatraso').val());
    var data = (data1);
    var resultado4 = data;
    $('#Diasatraso').val(numCur(resultado4));

   //* Calcula Valor desconto dos dias *\\ 
    var cpfcalculos = curNum($('#cpfajax').val());
    var data1 = curNum($('#dataatraso').val());
    if(data1 < 120){
    var descontos = 0;
    }
    if(data1 > 120){
    var descontos = 5;
    }
    if(data1 > 188){
    var descontos = 15;
    }
    if(data1 > 364){
    var descontos = 29;
    }
    if(data1 > 729){
    var descontos = 44;
    }
    if(data1 > 1095){
    var descontos = 60;
    }
    var descontos = descontos + "%";
    $('#maximodesconto').val(String(descontos));



   //* Calcula Valor do desconto *\\ 
    var saldo1 = curNum($('#Saldoope').val());
    var saldo = (saldo1);
    var desconto = curNum($('#desconto').val());
    var resultado5 = saldo - (saldo * (desconto/100));
    $('#descontonegociado').val(numCur(resultado5));



   //* Calcula Valor do desconto concedido*\\ 
    var desconto = curNum($('#desconto').val());
    var resultado6 = desconto;
    var resultado6 = resultado6 + "%";
    $('#concedidodes').val(String(resultado6));



   //* Saldo Atual *\\ 
    var saldo3 = curNum($('#Saldoope').val());
    var saldooperacao = (saldo3);
    var resultado7 = saldooperacao;
    $('#valoratual').val(numCur(resultado7));



   //* Calcular valor das parcelas *\\ 

    function calculoGGG() {
        var taxa = curNum($('#taxaentrada').val());
        var pv = curNum($('#Entrada').val());
        var n = curNum($('#numparcelas').val());

        i = (taxa/100)
        potenciacao = Math.pow(1+(i),n)
        pmt = pv * ((potenciacao * i)/(potenciacao-1))
        $('#valordasparcelas').val(numCur(pmt));

        

    //* Valor total negociado *\\ 
    var numerodeparcelas = curNum($('#numparcelas').val());
    var valordasparcelas = curNum($('#valordasparcelas').val());
    var entrada = curNum($('#Entradatotal').val());
    var resultado8 = ((numerodeparcelas * valordasparcelas) - entrada);


    //* Produtos Calculando desconto *\\ 
    var cpfcalculos = curNum($('#cpfajax').val());
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
    if (datraso < 120 && cpfcalculos < 1){
        var descontoproduto = 0;
    }
    if (datraso > 120 && cpfcalculos < 1){
        var descontoproduto = 5;
    }
    if (datraso > 180 && cpfcalculos < 1){
        var descontoproduto = 15;
    }
    if (datraso > 360 && cpfcalculos < 1){
        var descontoproduto = 29;
    }
    if (datraso > 720 && cpfcalculos < 1){
        var descontoproduto = 44;
    }
    if (datraso > 1080 && cpfcalculos < 1){
        var descontoproduto = 60;
    }
    var descontoproduto = descontoproduto + "%";
    $('#descontoprodutos2').val(String(descontoproduto));

    

    //* Calculando  desconto Parcelado *\\ 
    var diasdeatraso3 = curNum($('#Numpar3').val());
    if (diasdeatraso3 < 120 && cpfcalculos < 1){
        var descontinho = 0;
    }
    if (diasdeatraso3 > 120 && cpfcalculos < 1){
        var descontinho = 5;
    }
    if (diasdeatraso3 > 180 && cpfcalculos < 1){
        var descontinho = 15;
    }
    if (diasdeatraso3 > 360 && cpfcalculos < 1){
        var descontinho = 29;
    }
    if (diasdeatraso3 > 720 && cpfcalculos < 1){
        var descontinho = 44;
    }
    if (diasdeatraso3 > 1080 && cpfcalculos < 1){
        var descontinho = 60;
    }
    if (cpfcalculos > 1){
        var descontinho = desconto_parceladocpf2;
    }
    if (diasdeatraso3 < 1 && cpfcalculos < 1){
        var descontinho = 0;
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
        if (n1 > 91){ ;;;;;;;;;;;;;;;;;;;;
            var n2 = 4.30;
        }
        if (n1 > 301){
            var n2 = 1.10;
        }
        if (n1 > 360){
            var n2 = 1.00;
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
$(document).ready(function(){

    fetch_customer_data();
    var cpfajax =  curNum($('#cpfajax').val());

        function fetch_customer_data(cpfajax)
        {
        $.ajax({
        url:"{{ route('cpf') }}",
        method:'GET',
        data:{cpfajax},
        dataType:'json',
        success:function(data)
        {
        var desconto_cpf = JSON.parse(JSON.stringify(data[0].desconto_avista));
        $('#Desconpar').val(String(desconto_cpf));

        var desconto_parceladocpf2 = JSON.parse(JSON.stringify(data[0].taxa_2a4x));
        $('#Desconpa3r').val(String(desconto_parceladocpf2));

        var taxa_avistabd = JSON.parse(JSON.stringify(data[0].taxa_avista));
            if(taxa_avistabd < 1){
            taxaavistabol = "FALSO";
            }
            $('#Taxapar').val(String(taxaavistabol)); 
            console.log(taxaavistabol)

        }
        })
        }

    $(document).on('keyup', '#cpfajax', function(){
    var query = $(this).val();
    fetch_customer_data(query);
    });
});

</script>

</html>