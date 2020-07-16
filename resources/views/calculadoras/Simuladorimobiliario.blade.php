<!DOCTYPE html>
<html lang="br">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Calculadora</title>
    <link type="text/css" rel="shortcut icon" href="objetos/imagens/favicon.ico" type="image/x-icon">
    <link type="text/css" rel="icon" href="objetos/imagens/favicon.ico" type="image/x-icon">
    <link type="text/css" href="objetos/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" href="objetos/plugins/awesome/css/font-awesome.min.css" rel="stylesheet">
    <link type="text/css" href="objetos/plugins/notification/bs4.pop.css" rel="stylesheet">
    <link type="text/css" href="objetos/style.css" rel="stylesheet">
  </head>
  <script type="text/javascript" src="objetos/jquery/jquery.min.js"></script>
  <script type="text/javascript" src="objetos/plugins/popper/popper.min.js"></script>
  <script  type="text/javascript"src="objetos/bootstrap/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="objetos/plugins/notification/bs4.pop.js"></script>
  <script  type="text/javascript"src="objetos/plugins/priceformat/jquery.price_format.min.js"></script>
  <script type="text/javascript" src="objetos/funcoes.js"></script>
  <body>
    <form onsubmit="return false">
      <div class="card">
        <table>
          <tr>
            <td align="left"><label>CÁLCULO DE PARCELAS VENCIDAS</label></td>
            <td align="right"><button class="btn btn-secondary" type="reset">limpar</button></td>
          </tr>
        </table>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text azul">VALOR DA PARCELA (R$)</span>
          </div>
          <input type="text" id="txValorParcela" class="form-control" placeholder="R$">
        </div>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text azul">JUROS (R$)</span>
          </div>
          <input type="text" id="txJuros" class="form-control" placeholder="R$">
        </div>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text vermelho">IOF (R$)</span>
          </div>
          <input type="text" id="txIof" class="form-control" placeholder="R$">
        </div>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text vermelho">GCA (R$)</span>
          </div>
          <input type="text" id="txGca" class="form-control" placeholder="R$">
        </div>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text azul">JUROS A PAGAR (R$)</span>
          </div>
          <input type="text" id="txJurosPagar" class="form-control" placeholder="R$">
        </div>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text azul">DESCONTO CONCEDIDO (%)</span>
          </div>
          <input type="text" id="txDescontoConcedido" class="form-control" placeholder="%" disabled>
        </div>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text azul">DESCONTO CONCEDIDO juros (R$)</span>
          </div>
          <input type="text" id="txDescontoJuros" class="form-control" placeholder="R$" disabled>
        </div>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text vermelho">COMISSÃO 6%</span>
          </div>
          <input type="text" id="txComissao" class="form-control" placeholder="R$" disabled>
        </div>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text vermelho">DESCONTO CONCEDIDO ho (R$)</span>
          </div>
          <input type="text" id="txDescontoHo" class="form-control" placeholder="R$" disabled>
        </div>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text marinho">VALOR TOTAL (R$)</span>
          </div>
          <input type="text" id="txValorTotal" class="form-control" placeholder="R$" disabled>
        </div>
        <label>QUITAÇÃO</label>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text azul">VALOR DA PARCELA A VENCER (R$)</span>
          </div>
          <input type="text" id="txValorParcelaVencer" class="form-control" placeholder="R$">
        </div>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text verde">
              <table>
                <tr>
                  <td align="left">VALOR DE DEV. PRÊMIO (R$)</td>
                  <td align="right"><a id="VlPremio" href="javascript: abrirHelp('VlPremio');"><i class="fa fa-question-circle" aria-hidden="true"></i></a></td>
                </tr>
              </table>
            </span>
          </div>
          <input type="text" id="txValorPremio" class="form-control" placeholder="R$">
        </div>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text vermelho">VALOR DA QUITAÇÃO (R$)</span>
          </div>
          <input type="text" id="txValorQuitacao" class="form-control" placeholder="R$" disabled>
        </div>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text cinza">TOTAL DE DESCONTOS (R$)</span>
          </div>
          <input type="text" id="txTotalDescontos" class="form-control" placeholder="R$" disabled>
        </div>
      </div>
      <div class="rodape">powered by <img src="objetos/imagens/logo.png"> Liderança - Desenvolvimento</div>
    </form>
  </body>
</html>
<script type="text/javascript">
 
  var appVersao = '6_14.11.19';
  document.title = 'Calculadora PF ' + appVersao;

  // Calcula os resultados conforme o pressionamento de teclas
  document.body.addEventListener('keyup', function (e){calcular()});

  // Define os campos com a máscara de moeda
  $('#txValorParcela').priceFormat({prefix:'',centsSeparator:',', thousandsSeparator:'.', centsLimit:2});
  $('#txJuros').priceFormat({prefix:'',centsSeparator:',', thousandsSeparator:'.', centsLimit:2});
  $('#txIof').priceFormat({prefix:'',centsSeparator:',', thousandsSeparator:'.', centsLimit:2});
  $('#txGca').priceFormat({prefix:'',centsSeparator:',', thousandsSeparator:'.', centsLimit:2});
  $('#txJurosPagar').priceFormat({prefix:'',centsSeparator:',', thousandsSeparator:'.', centsLimit:2});
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

    // Checa validade dos campos
    if(JurosPagar > Juros)
      {
      alert('O "juros a pagar" não pode ser maior que o "juros"');
      $('#txJurosPagar').val('');
      JurosPagar = curNum($('#txJurosPagar').val());
      }

    var DescontoConcedido = 100.0 - (JurosPagar / Juros * 100.0);
    DescontoConcedido = (Number.isNaN(DescontoConcedido) || Juros==0 ? 0 : Number(DescontoConcedido));

    var DescontoJuros = Juros - JurosPagar;
    DescontoJuros = (Number.isNaN(DescontoJuros) ? 0 : Number(DescontoJuros));

    var Comissao =  (ValorParcela + JurosPagar) * TaxaComissao;
    var ValorTotal =  (ValorParcela + Juros + Iof + Gca + Comissao) - DescontoJuros;
    var ValorQuitacao = ValorTotal + ValorParcelaVencer - ValorPremio;

    //Exibe os resultados dos cálculos
    $('#txDescontoConcedido').val(DescontoConcedido.toFixed(2) + '%');
    $('#txDescontoJuros').val(numCur(DescontoJuros));
    $('#txComissao').val(Comissao);
    $('#txValorTotal').val(numCur(ValorTotal));
    $('#txValorQuitacao').val(numCur(ValorQuitacao));

    //mudar para cor vermelha caso 0 número for negativo
    $('#txDescontoConcedido').css('color',(DescontoConcedido < 0 ? 'red' : '#333333'))
    $('#txDescontoJuros').css('color',(DescontoJuros < 0 ? 'red' : '#333333'))
    $('#txComissao').css('color',(Comissao < 0 ? 'red' : '#333333'))
    }

  // Exibe om popover com uma mensagem de explicação do campo
  function abrirHelp(id)
    {
    var msg = '';
    if(id=='VlPremio'){msg = 'Você irá obter este valor após selecionar todas as parcelas';}

    $('#'+id).popover({
            trigger: 'manual',
            placement: 'right',
            trigger: 'focus',
            title: 'Ajudas <a href="javascript:" class="close">&times;</a>',
            content: msg,
            html: true
        });
    $('#'+id).popover("show");
    }

  // Muda o foco do objeto input ao teclar enter ou esc
  $("input,select").bind("keydown", function (e) {
     var keyCode = e.keyCode || e.which;
     if(keyCode === 13) //enter
        {
        e.preventDefault();
        $('input, select, textarea')[$('input,select,textarea').index(this)+1].focus();
        }
     if(keyCode === 27) //esc
        {
        e.preventDefault();
        $('input, select, textarea')[$('input,select,textarea').index(this)-1].focus();
        }
    });

</script>