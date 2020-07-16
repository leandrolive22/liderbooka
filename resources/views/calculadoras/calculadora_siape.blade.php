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
  <script src="objetos/jquery/jquery.min.js"></script>
  <script src="objetos/plugins/popper/popper.min.js"></script>
  <script src="objetos/bootstrap/js/bootstrap.min.js"></script>
  <script src="objetos/plugins/notification/bs4.pop.js"></script>
  <script src="objetos/plugins/priceformat/jquery.price_format.min.js"></script>
  <script src="objetos/funcoes.js"></script>
  <body>
    <form name="cal" onsubmit="return false" >
      <div class="card">
        <table>
          <tr>
            <td align="left"><label>CALCULADORA SIAPE NÃO FOLHA</label></td>
            <td align="right"><button class="btn btn-secondary btn-sm float-right" type="reset">limpar</button></td>
          </tr>
        </table>
        <div  class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text vermelho">Margem SIGAC (R$)</span>
          </div>
          <input type="text" id="n1" class="form-control" placeholder="R$">
        </div>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text vermelho">MARGEM CSG (%)</span>
          </div>
          <input type="text" id="n2" value="20" class="form-control" disabled>
        </div>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text cinza">Valor a ser informado (R$)</span>
          </div>
          <input type="text" id="resultado" class="form-control" placeholder="R$" disabled>
        </div>
      </div>
      <div class="rodape">powered by <img src="objetos/imagens/logo.png"> Liderança - Desenvolvimento</div>
    </form>

  </body>
</html>
<script type="text/javascript">

  var appVersao = '1.00';
  document.title = 'Simulador Consignado Limites ' + appVersao;
  document.body.addEventListener('keyup', function (e){calcular()});

  $('#n1').priceFormat({prefix:'',centsSeparator:',', thousandsSeparator:'.', centsLimit:2});
  $('#num1').priceFormat({prefix:'',centsSeparator:',', thousandsSeparator:'.', centsLimit:2});
  
  $('#n1').select();

  function calcular()
    {

    var n1 = curNum($('#n1').val());
    var n2 = curNum($('#n2').val());
    var resultado = n1 - (n1 * (n2/100));
    $('#resultado').val(numCur(resultado));

    var num1 = curNum($('#num1').val());
    var num2 = curNum($('#num2').val());
    var resultado2 = num1 - (num1 * (num2/100));
    $('#resultado2').val(numCur(resultado2));

    }

</script>


