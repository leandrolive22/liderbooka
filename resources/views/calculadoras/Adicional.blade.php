<!DOCTYPE html>
<html lang="br">
    <head>
	   <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Calculadora</title>
        <link type="text/css" rel="shortcut icon" href="objetos/imagens/favicon.ico" type="image/x-icon">
        <link type="text/css" rel="icon" href="objetos/imagens/favicon.ico" type="image/x-icon">
        <link type="text/css" href="objetos/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link  type="text/css"  href="objetos/plugins/awesome/css/font-awesome.min.css" rel="stylesheet">
        <link type="text/css"  href="objetos/plugins/notification/bs4.pop.css" rel="stylesheet">
        <link type="text/css"  href="objetos/style.css" rel="stylesheet">
    </head>
    <script type="text/javascript" src="objetos/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="objetos/plugins/popper/popper.min.js"></script>
    <script type="text/javascript" src="objetos/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="objetos/plugins/notification/bs4.pop.js"></script>
    <script type="text/javascript" src="objetos/plugins/priceformat/jquery.price_format.min.js"></script>
    <script type="text/javascript" src="objetos/funcoes.js"></script>
    <body>
        <div class="page-container">
            <form onsubmit="return false">
                <div class="card">
                    <table>
                        <tr>
                          <td align="left"><label>CÁLCULO ADICIONAL</label></td>
                          <td align="right"><button class="btn btn-secondary btn-sm float-right" type="reset">limpar</button></td>
                        </tr>
                        
                    </table>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text vermelho">CSG (R$)</span></div>
                        <input type="text" class="form-control" id="csg" placeholder="R$">
                    </div>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text vermelho">LY (R$)</span></div>
                        <input type="text" class="form-control" id="ly" placeholder="R$">
                    </div>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text vermelho">ADICIONAL 1% (R$)</span></div>
                        <input type="text" class="form-control" id="onePerc" disabled placeholder="R$">
                    </div>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text vermelho">TOTAL (R$)</span></div>
                        <input type="text" class="form-control" id="total" disabled placeholder="R$">
                    </div>
                    <div class="input-group" style="margin-top:10px;">
                        <div class="input-group-prepend"><span class="input-group-text cinza">Valor à ser inserido no CSG (R$)</span></div>
                        <input type="text" class="form-control" id="csgTotal" disabled placeholder="R$">
                    </div>
                </div>
                <div class="rodape">powered by <img src="objetos/imagens/logo.png"> Liderança - Desenvolvimento</div>
            </form>
        </div>
        <script type="text/javascript">
            
            var appVersao = '1.00';
            document.title = 'Calculadora Adicional ' + appVersao;
            document.body.addEventListener('keyup', function (e){calc()});

            $('#csg').priceFormat({prefix:'',centsSeparator:',', thousandsSeparator:'.', centsLimit:2});
            $('#ly').priceFormat({prefix:'',centsSeparator:',', thousandsSeparator:'.', centsLimit:2});

            $('#csg').select();

            function calc() {
                csg = curNum($("#csg").val());
                ly = curNum($("#ly").val());
                tx = 0.01;

                //Soma campos preenchidos
                sum = csg + ly;

                //tira 1% da var sum
                onePerc = sum * tx;

                //Calcula valor do consignado + taxa
                csgTotal = ly + onePerc;

                //calcula total
                total = sum + onePerc;

                //coloca valores no front
                $("#total").val(numCur(total));
                $("#onePerc").val(numCur(onePerc));
                $("#csgTotal").val(numCur(csgTotal));

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
    </body>
</html>