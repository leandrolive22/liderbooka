<!DOCTYPE html>
<style>
h4{
  color:white;text-align:center;
}
#corpo{
  background-color:#303030;
}
label{
  color:white;
}
</style>
<html lang="br">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
  <body id="corpo" >
    <form name="cal" onsubmit="return false" >
     <h4> Calculadora Reneg Cartões </h4>
     <div class="text-center">
     <a href="#" style="width:30%;" class="btn btn-secondary" type="button" >Condições de Oferta</a>
     </div>
     <div class="text-center">
     <a href="#" style="width:30%;" class="btn btn-primary" type="button" >Até</a>
     <a href="#" style="width:30%;" class="btn btn-danger" type="button" >Acima De</a>
     </div>
     <br>

     <div class="text-center">
      <a href="#" style="width:20%; height:40%;background-color:#5A6268;" class="btn btn-info" type="button" >Valor a Parcelar</a>
      <input name="valorparcelarate" id="valorparcelarate" style="width:30%;"> 
     </div>

     <br>

      <a href="#" style="width:20%; height:40%;background-color:#5A6268;" class="btn btn-info" type="button" >Entrada</a>
      <input id="entradaate" name="entradaate" style="width:30%;"> 
      <input id="entradaacima" name="entradaacima" style="width:30%;"> 

     <br>
     <br>
     <br>

      <a href="#" style="width:20%; height:40%;background-color:#5A6268;" class="btn btn-info" type="button" >Parcelas</a>
      <input id="parcelaate" name="parcelaate" style="width:30%;"> 
      <input id="parcelaacima" name="parcelaacima" style="width:30%;"> 

     <br>
     <br>

      <a href="#" style="width:20%; height:40%;background-color:#5A6268;" class="btn btn-info" type="button" >Taxa de Juros (%)</a>
      <input id="taxajurosate" name="taxajurosate" style="width:30%;"> 
      <input id="taxajurosacima" name="taxajurosacima" style="width:30%;"> 

     <br>
     <br>

      <a href="#" style="width:20%; height:40%;background-color:#5A6268;" class="btn btn-info" type="button" >Novo saldo a parcelar</a>
      <input id="novosaldoate" name="novosaldoate" style="width:30%;" readonly="true"> 
      <input id="novosaldoacima" name="novosaldoacima" style="width:30%;" readonly="true"> 

     <br>
     <br>
     <br>

      <a href="#" style="width:20%; height:40%;background-color:#5A6268;" class="btn btn-info" type="button" >Parcela</a>
      <input id="parcelaatefinal" name="parcelaatefinal" style="width:30%;" readonly="true"> 
      <input  id="parcelaacimafinal" name="parcelaacimafinal" style="width:30%;" readonly="true"> 
     <br>
     <br>
      <a href="#" style="width:20%; height:40%;background-color:#5A6268;" class="btn btn-info"type="button" >Dívida Total</a>
      <input name="dividatotalate" id="dividatotalate" style="width:30%;" readonly="true" > 
      <input name="dividatotalacima" id="dividatotalacima"style="width:30%;" readonly="true"> 

     <br>
     <br>
     <div class="text-center">
      <a href="#" style="width:40%; height:50%;" class="btn btn-success" type="button" readonly>Desconto</a>
      <input id="descontototal" name="descontototal" style="width:30%;"  readonly="true" > 
     </div>

      <div class="rodape">powered by <img src="objetos/imagens/logo.png"> Liderança - Desenvolvimento</div>
    </form>

  </body>
</html>
<script type="text/javascript">

  var appVersao = '1.2.3';
  document.title = 'Calculadora Reneg Cartões ' + appVersao;
  document.body.addEventListener('keyup', function (e){calcular()});

  $('#valorparcelarate').priceFormat({prefix:'',centsSeparator:',', thousandsSeparator:'.', centsLimit:2});
  $('#entradaate').priceFormat({prefix:'',centsSeparator:',', thousandsSeparator:'.', centsLimit:2});
  $('#entradaacima').priceFormat({prefix:'',centsSeparator:',', thousandsSeparator:'.', centsLimit:2});
  $('#valorparcelarate').priceFormat({prefix:'',centsSeparator:',', thousandsSeparator:'.', centsLimit:2});

  $('#n1').select();

  function calcular()
    {
          /// Inicio Calculos Até \\\
      
          // Calculando Novo saldo Até \\
      var valorparcelarate = curNum($('#valorparcelarate').val());
      var entradaate = curNum($('#entradaate').val());
      console.log(valorparcelarate)

      var novosaldoateoriginal = valorparcelarate - entradaate

      $('#novosaldoate').val(numCur(novosaldoateoriginal));

        // Calculando Parcela Com juros até \\

      var taxa = curNum($('#taxajurosate').val());
      var pv = curNum($('#novosaldoate').val());
      var n = curNum($('#parcelaate').val());

        i = (taxa/100)
        potenciacao = Math.pow(1+(i),n)
        pmt = pv * ((potenciacao * i)/(potenciacao-1))


      $('#parcelaatefinal').val(numCur(pmt));


      // Calculando Divida total Price intermedia Com juros até  \\
      var entradaate = curNum($('#entradaate').val());
      var n = curNum($('#parcelaate').val());

        dividatotal = pmt * n + entradaate
  
      $('#dividatotalate').val(numCur(dividatotal));

       ///  Fim Calculos até \\\

       ///  Inicio Calculos Acima \\\

       // Calculando Novo saldo Acima \\
        var entradaacima = curNum($('#entradaacima').val());
        var valorparcelarate = curNum($('#valorparcelarate').val());
        console.log(entradaacima)
        console.log(valorparcelarate)

        var novosaldoacimaoriginal =  valorparcelarate - entradaacima
       
      
       $('#novosaldoacima').val(numCur(novosaldoacimaoriginal));


      //  Calculando Parcela Com juros Acima  \\

      var taxaacima = curNum($('#taxajurosacima').val());
      var pvacima = novosaldoacimaoriginal
      var nacima = curNum($('#parcelaacima').val());
   
        i = (taxaacima/100)
        potenciacao = Math.pow(1+(i),nacima)
        pmtacima = pvacima * ((potenciacao * i)/(potenciacao-1))
        console.log(pmtacima)

      $('#parcelaacimafinal').val(numCur(pmtacima));

     // Calculando Divida total Price intermediá Com juros Acima  \\
      var entradaacima = curNum($('#entradaacima').val());
      var n = curNum($('#parcelaacima').val());
      dividatotalacima = pmtacima * n + entradaacima

      $('#dividatotalacima').val(numCur(dividatotalacima));

     // Calculando Desconto Total \\

     descontototal = dividatotalacima - dividatotal
     $('#descontototal').val(numCur(descontototal));


     ///  Fim Calculos Acima \\\
    }

</script>


