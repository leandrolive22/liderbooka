
var sWait = '<i class="fa fa-refresh fa-spin"></i>&nbsp;&nbsp;processando...';

//Emite uma mensagem de alerta com plugin bs4pop
// type: primary, secondary, success, danger, warning, info, light, dark
// position: topleft, topcentertopright, center, bottomleft, bottomcenter, bottomright
function alerta(message, type='light', position='center', width='')
  {
  if(width == '')
    {bs4pop.notice(message, {type:type, position:position});}
  else
    {bs4pop.notice(message, {type:type, position:position, width:width});}
  }

//funcoes para cookie (incluindo interface com Android)
function gravarCookie(name,value)
  {
  var date = new Date();
  date.setTime(date.getTime()+(365*24*60*60*1000));
  var expires = "; expires="+date.toGMTString();
  try{document.cookie = name+"="+value+expires+"; path=/";} catch(e){}
  try{Android.gravarCookie(name,value);} catch(e){}
  }
function lerCookie(name)
  {
  var ret = '';
  try
    {
    var strNomeIgual = name + "=";
    var arrCookies = document.cookie.split(';');
    for(var i = 0; i < arrCookies.length; i++)
      {
      var strValorCookie = arrCookies[i];
      while(strValorCookie.charAt(0) == ' '){strValorCookie = strValorCookie.substring(1, strValorCookie.length);}
      if(strValorCookie.indexOf(strNomeIgual) == 0){ret = strValorCookie.substring(strNomeIgual.length, strValorCookie.length); break;}
      }
    }
  catch(e){}
  if(ret == ''){try{ret = Android.lerCookie(name);} catch(e){}}
  return ret;
  }
function excluirCookie(name)
  {
  gravarCookie(name,"",-1);
  try{Android.excluirCookie(name);} catch(e){}
  }

//Evita duplo clique no botao
function botaoBounce(id,enable)
  {
  if(enable)
    {$('#'+id).css('pointer-events','auto'); $('#'+id).prop('disabled',false);}
  else
    {$('#'+id).css('pointer-events','none'); $('#'+id).prop('disabled',true);}
  }

var oldPage = '';
function PrintPage(conteudo){oldPage = document.body.innerHTML; document.body.innerHTML = '<html><head><title>print</title></head><body>' + conteudo + '</body></html>'; setTimeout('PrintPageStep1()', 1000);}
function PrintPageStep1(){window.print(); setTimeout('PrintPageStep2()', 1);}
function PrintPageStep2(){document.body.innerHTML = oldPage;}

// Tranforma formato Moeda em formato Numero e vice-versa - 10.000,00 = 10000.00
function curNum(num)
  {
  if(num == ''){return Number('0.00');}
  var sConv = ''; var sInt = ''; var sDec = ''; var nPos = -1;
  sConv = num.toString();
  sConv = sConv.replace('.','');
  sConv = sConv.replace(',','.');
  sInt = parseInt(sConv);
  nPos = sConv.indexOf('.');
  if (nPos == -1)
    {sDec = '00';}
  else
    {
    nPos = nPos +1;
    sDec = sConv.substring(nPos);
    if (sDec.length > 2){sDec.substring(0,1);}
    if (sDec.length == 1){sDec = sDec + '0';}
    }
  return parseFloat(sInt + '.' + sDec);
  }
function numCur(num)
  {
  if(num == ''){return '';}
  var tmp = num.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
  var ret = tmp.split(".");
  return '' + ret[0].replace(',','.') + ',' + ret[1];
  }