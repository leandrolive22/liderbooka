@extends('layouts.app', ["current"=>"monitoring"])
<!-- CARDS CSS INICIO -->
@section('css')
<style>
    #c{
     margin-left:10px;
     margin-top:-25px;
    }
#grafico{
    background-color:white;
    margin-left:350px;
    margin-top:-10px;

}
.panel-panel-right{
  margin-left:300px;
}
    body {
  margin: 0;
  overflow: hidden;
  font-size: 14px;
  color:black; 
}

.wrapper {
  display: block;
  margin: 5em auto;
  border: 1px solid #555;
  width: 700px;
  height: 350px;
  position: relative;
}
p{text-align:center;}
.label {
  height: 1em;
  padding: .3em;
  background: rgba(255, 255, 255, .8);
  position: absolute;
  display: none;
  color:#000000;
  
}
</style>
@endsection
<!-- CARDS CSS FIM -->
@section('content')
<!-- START PAGE CONTAINER -->
<div class="page-container">

    <!-- PAGE CONTENT -->
    <div class="page-content">

        @component('assets.components.x-navbar')
        @endcomponent

        <br>

        <!-- START BREADCRUMB -->
        <ul class="breadcrumb">
            <li><a href="{{asset('/home/page')}}">Home</a></li>
            <li><a href="{{asset('monitoring/manager')}}">Monitoria</a></li>
            <li><a href="#">Monitoria e Evolução Por Supervisor</a></li>

        </ul>
        <!-- END BREADCRUMB -->


        <!-- PAGE CONTENT WRAPPER -->
        <div class="page-content-wrap">

            <div class="row">
                <div class="col-md-12">
                                <!-- START TIMELINE -->
                                <div class="col-md-6">
                                <div class="panel panel-default tabs">                            
                                    <ul class="nav nav-tabs" role="tablist">
                                      <li class="active"><a href="#tab-first" role="tab" data-toggle="tab">Buscar Monitoria e Evolução Por Supervisor</a></li>
                                    </ul>
                                    {{-- <li id="tab-fisrt"> --}}
                                    <form id="formSearch" @if(in_array(Auth::user()->cargo_id,[4])))action="{{ route('PostFeedbacksFindMonitoring', ['id'=>Auth::id()]) }}" @endif method="POST">
                                        @csrf
                                            <div class="panel-body">     
                                                
                                                <div class="form-group">
                                                    <label  for="supers">Supervisor</label>
                                                    <select data-live-search="true" name="supers" id="supers" onchange="$('#formSearch').prop('action','{{asset('monitoring/PostFeedbacksEvolutionOperator')}}'+'/'+$(this).val());" placeholder="Selecione o supervisor" class="form-control select">
                                                        <option value="0">Selecione um Supervisor</option>
                                                        @forelse ($supers as $item)
                                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                                        @empty
                                                            <option value="0" disabled>Nenhum Supervisor encontrado</option>
                                                        @endforelse
                                                    </select>
                                                </div>
                                               
                                                <div class="input-group pull-left col-md-8">
                                                <span class="input-group-addon" id="basic-addon1">de</span>
                                                    <input type="date" class="form-control" placeholder="De" id="de" name="de" aria-describedby="basic-addon1">
                                                </div>
                                                <br>
                                                <div class="input-group pull-right col-md-8">
                                                    <input type="date" class="form-control" placeholder="Até" id="ate" name="ate" aria-describedby="basic-addon2">
                                                <span class="input-group-addon" id="basic-addon2">Até</span>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-md-2 col-xs-12 control-label"></label>
                                                    <div class="col-md-12 col-xs-12">                                                                                                                                        
                                                    <label class="check">
                                                        <input type="checkbox" value="{{md5(Auth::id().'Consulta Moniotira')}}" class="icheckbox" name="icheck" id="icheck"/> 
                                                        Eu Concordo Com os Termos de sigilo.
                                                    </label>
                                                        <span class="help-block"><b>Aceite</b> {{md5(Auth::id().'Consulta Monitoria')}} </span>
                                                    </div>
                                                </div>
                                            </div>
                                        {{-- </li> --}}
                                        <div class="panel-footer">                                                                        
                                            <button class="btn btn-primary pull-right" type="button" id="btnSearch">Buscar<span class="fa fa-floppy-o fa-right"></span></button>
                                        </div>
                                    </form>                    
                                   </div>                                        
                               </div>                                
                            </form>   
                {{-- Grafico Por Data / Supervisor --}}
              
                    <div class="panel-panel-right">
                    <div id="grafico" class="wrapper">
                    <canvas id='c'></canvas>                 
                    <div class="label">text</div>
                    </div>
                    </div>           
                            {{-- START DEFAULT DATATABLE --}}
                                 <div class="panel panel-default">
                                    <div class="panel-heading ui-draggable-handle">
                                    <h3 class="panel-title">Média de Operadores Por Período</h3>
                                        <button onclick='$("#exportTable").tableExport({type:"excel",escape:"false"})' class="btn btn-outline-success pull-right"><span class="fa fa-table"></span>Exportar</button>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <table class="table table-bordered" id="exportTable">
                                        <thead>
                                            <tr>
                                                <th>Nome</th>
                                                <th>Média</th>
                                                <th>Qtd. Conforme</th>
                                                <th>Qtd. Não Conforme</th>
                                                <th>Data Monitoria</th>

                                            </tr>
                                        </thead>
                                        <tbody style="overflow-y: auto; max-heigth: 500px;">
                                     
                                           @foreach($result as $results)
    
                                                    <tr>
                                                        <td>{{$results->name}}</td>
                                                        <td>{{$results->media}}%</td>
                                                        <td>{{$results->conf}}</td>
                                                        <td>{{$results->nConf}}</td>
                                                        <td>{{$results->date}}</td>

                                                    </tr>   

                                             @endforeach
                                            </tbody>
                                            <tfoot>
                               
                                                <tr class="bg-secondary text-white">
                                                    <td colspan=""><b>TOTAIS</b></td>
                                                </tr>
                                            </tfoot>                                       
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>                    
                </div>
            <div>    
            {{-- END PAGE CONTENT WRAPPER --}}                                                
      </div>   
  </div>
</div>
@endsection
@section('Javascript')
    <script type="text/javascript" src="{{ asset('js/plugins/tableexport/tableExport.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/tableexport/jquery.base64.js') }}"></script>

    
    <script lang="javascript">
var label = document.querySelector(".label");
var c = document.getElementById("c");
var ctx = c.getContext("2d");
var cw = c.width = 700;
var ch = c.height = 350;
var cx = cw / 2,
  cy = ch / 2;
var rad = Math.PI / 180;
var frames = 0;

ctx.lineWidth = 1;
ctx.strokeStyle = "#999";
ctx.fillStyle = "#000000";
ctx.font = "14px monospace";

var grd = ctx.createLinearGradient(0, 0, 0, cy);
grd.addColorStop(0, "hsla(167,72%,60%,1)");
grd.addColorStop(1, "hsla(167,72%,60%,0)");

var oData = {
  @forelse($result as $results)
  "{{date('d/m',strtotime($results->date))}}": "{{$results->media}}",
  @empty   
  <p>N/D</p>
  @endforelse
  "Sem Monitoria": 0,
  @if ($results->date > 20)
  "Sem Monitoria.": 0,
  @endif
};


var valuesRy = [];
var propsRy = [];
for (var prop in oData) {

  valuesRy.push(oData[prop]);
  propsRy.push(prop);
}


var vData = 4;
var hData = valuesRy.length;
var offset = 50.5; //offset chart axis
var chartHeight = ch - 2 * offset;
var chartWidth = cw - 2 * offset;
var t = 1 / 7; // curvature : 0 = no curvature 
var speed = 2; // for the animation

var A = {
  x: 0,
  y: offset
}
var B = {
  x: offset,
  y: offset + chartHeight
}
var C = {
  x: offset + chartWidth,
  y: offset + chartHeight
}

/*
      A  ^
        |  |  
        + 25
        |
        |
        |
        + 25  
      |__|_________________________________  C
      B
*/

// CHART AXIS -------------------------
ctx.beginPath();
ctx.moveTo(A.x, A.y);
ctx.lineTo(B.x, B.y);
ctx.lineTo(C.x, C.y);
ctx.stroke();

// vertical ( A - B )
var aStep = (chartHeight - 50) / (vData);

var Max = Math.ceil(arrayMax(valuesRy) / 10) * 10;
var Min = Math.floor(arrayMin(valuesRy) / 10) * 10;
var aStepValue = (Max - Min) / (vData);
console.log("aStepValue: " + aStepValue); //8 units
var verticalUnit = aStep / aStepValue;

var a = [];
ctx.textAlign = "right";
ctx.textBaseline = "middle";
for (var i = 0; i <= vData; i++) {

  if (i == 0) {
    a[i] = {
      x: A.x,
      y: A.y + 25,
      val: Max
    }
  } else {
    a[i] = {}
    a[i].x = a[i - 1].x;
    a[i].y = a[i - 1].y + aStep;
    a[i].val = a[i - 1].val - aStepValue;
  }
  drawCoords(a[i], 3, 0);
}

//horizontal ( B - C )
var b = [];
ctx.textAlign = "center";
ctx.textBaseline = "hanging";
var bStep = chartWidth / (hData + 1);

for (var i = 0; i < hData; i++) {
  if (i == 0) {
    b[i] = {
      x: B.x + bStep,
      y: B.y,
      val: propsRy[0]
    };
  } else {
    b[i] = {}
    b[i].x = b[i - 1].x + bStep;
    b[i].y = b[i - 1].y;
    b[i].val = propsRy[i]
  }
  drawCoords(b[i], 0, 3)
}

function drawCoords(o, offX, offY) {
  ctx.beginPath();
  ctx.moveTo(o.x - offX, o.y - offY);
  ctx.lineTo(o.x + offX, o.y + offY);
  ctx.stroke();

  ctx.fillText(o.val, o.x - 2 * offX, o.y + 2 * offY);
}
//----------------------------------------------------------

// DATA
var oDots = [];
var oFlat = [];
var i = 0;

for (var prop in oData) {
  oDots[i] = {}
  oFlat[i] = {}

  oDots[i].x = b[i].x;
  oFlat[i].x = b[i].x;

  oDots[i].y = b[i].y - oData[prop] * verticalUnit - 25;
  oFlat[i].y = b[i].y - 25;

  oDots[i].val = oData[b[i].val];
  
  i++
}



///// Animation Chart ///////////////////////////
//var speed = 3;
function animateChart() {
  requestId = window.requestAnimationFrame(animateChart);
  frames += speed; //console.log(frames)
  ctx.clearRect(60, 0, cw, ch - 60);
  
  for (var i = 0; i < oFlat.length; i++) {
    if (oFlat[i].y > oDots[i].y) {
      oFlat[i].y -= speed;
    }
  }
  drawCurve(oFlat);
  for (var i = 0; i < oFlat.length; i++) {
      ctx.fillText(oDots[i].val, oFlat[i].x, oFlat[i].y - 25);
      ctx.beginPath();
      ctx.arc(oFlat[i].x, oFlat[i].y, 3, 0, 2 * Math.PI);
      ctx.fill();
    }

  if (frames >= Max * verticalUnit) {
    window.cancelAnimationFrame(requestId);
    
  }
}
requestId = window.requestAnimationFrame(animateChart);

/////// EVENTS //////////////////////
c.addEventListener("mousemove", function(e) {
  label.innerHTML = "";
  label.style.display = "none";
  this.style.cursor = "default";

  var m = oMousePos(this, e);
  for (var i = 0; i < oDots.length; i++) {

    output(m, i);
  }

}, false);

function output(m, i) {
  ctx.beginPath();
  ctx.arc(oDots[i].x, oDots[i].y, 20, 0, 2 * Math.PI);
  if (ctx.isPointInPath(m.x, m.y)) {
    //console.log(i);
    label.style.display = "block";
    label.style.top = (m.y + 10) + "px";
    label.style.left = (m.x + 10) + "px";
    label.innerHTML = "<strong>" + propsRy[i] + "</strong>: " + valuesRy[i] + "%";
    c.style.cursor = "pointer";
  }
}

// CURVATURE
function controlPoints(p) {
  // given the points array p calculate the control points
  var pc = [];
  for (var i = 1; i < p.length - 1; i++) {
    var dx = p[i - 1].x - p[i + 1].x; // difference x
    var dy = p[i - 1].y - p[i + 1].y; // difference y
    // the first control point
    var x1 = p[i].x - dx * t;
    var y1 = p[i].y - dy * t;
    var o1 = {
      x: x1,
      y: y1
    };

    // the second control point
    var x2 = p[i].x + dx * t;
    var y2 = p[i].y + dy * t;
    var o2 = {
      x: x2,
      y: y2
    };

    // building the control points array
    pc[i] = [];
    pc[i].push(o1);
    pc[i].push(o2);
  }
  return pc;
}

function drawCurve(p) {

  var pc = controlPoints(p); // the control points array

  ctx.beginPath();
  //ctx.moveTo(p[0].x, B.y- 25);
  ctx.lineTo(p[0].x, p[0].y);
  // the first & the last curve are quadratic Bezier
  // because I'm using push(), pc[i][1] comes before pc[i][0]
  ctx.quadraticCurveTo(pc[1][1].x, pc[1][1].y, p[1].x, p[1].y);

  if (p.length > 2) {
    // central curves are cubic Bezier
    for (var i = 1; i < p.length - 2; i++) {
      ctx.bezierCurveTo(pc[i][0].x, pc[i][0].y, pc[i + 1][1].x, pc[i + 1][1].y, p[i + 1].x, p[i + 1].y);
    }
    // the first & the last curve are quadratic Bezier
    var n = p.length - 1;
    ctx.quadraticCurveTo(pc[n - 1][0].x, pc[n - 1][0].y, p[n].x, p[n].y);
  }

  //ctx.lineTo(p[p.length-1].x, B.y- 25);
  ctx.stroke();
  ctx.save();
  ctx.fillStyle = grd;
  ctx.fill();
  ctx.restore();
}

function arrayMax(array) {
  return Math.max.apply(Math, array);
};

function arrayMin(array) {
  return Math.min.apply(Math, array);
};

function oMousePos(canvas, evt) {
  var ClientRect = canvas.getBoundingClientRect();
  return { //objeto
    x: Math.round(evt.clientX - ClientRect.left),
    y: Math.round(evt.clientY - ClientRect.top)
  }
}




        $("#btnSearch").click(function(){
            error = Number(0)
            $("#btnSearch").html('<span class="fa fa-spinner fa-spin"></span>')
            if($("#de").val() == "" || $("#ate").val() == "") {
                noty({
                    text: 'Preencha os campos de data corretamente!',
                    layout: 'topRight',
                    type: 'warning',
                    timeout: 3000,
                    timeOut: 3000
                });
                
                error += Number(1)
            }

            if($("#icheck").prop('checked') === false) {
                noty({
                    text: 'Não é possível buscar resultados sem termo de sigilo',
                    layout: 'topRight',
                    type: 'warning',
                    timeout: 3000,
                    timeOut: 3000
                });

                error += Number(1)
            }

            if({{Auth::user()->cargo_id}} !== 5) {
                $("#formSearch").attr("action","{{ asset('manager/report/monitoring/supervisor/find/') }}/"+$("select#supers").val())
            }

            if(error === 0) {
                $("#formSearch").submit()
            } else {
                $("#btnSearch").html('Buscar<span class="fa fa-floppy-o fa-right"></span>')
            }
        });
    </script>
@endsection
