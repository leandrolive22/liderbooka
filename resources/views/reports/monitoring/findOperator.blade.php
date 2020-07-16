@extends('layouts.app', ["current"=>"monitoring"])
<!-- CARDS CSS INICIO -->
@section('css')
<style>
    
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
            <li><a href="#">Buscar Monitoria Por Operador</a></li>

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
                                        <li class="active"><a href="#tab-first" role="tab" data-toggle="tab">Buscar Monitoria Por Operador</a></li>
                                    </ul>
                                    {{-- <li id="tab-fisrt"> --}}
                                        <form id="formSearch" @if(in_array(Auth::user()->cargo_id,[4])))action="{{ route('PostFeedbacksFindMonitoring', ['id'=>Auth::id()]) }}" @endif method="POST">
                                        @csrf
                                            <div class="panel-body">     
                                                @if($mode == 'mon')
                                                <div class="form-group">
                                                    <label for="supers">Operador</label>
                                                    <select data-live-search="true" name="supers" id="supers" onchange="$('#formSearch').prop('action','{{asset('monitoring/findmonitoring')}}'+'/'+$(this).val());" placeholder="Selecione o supervisor" class="form-control select">
                                                        <option value="0">Selecione um Operador</option>
                                                        @forelse ($supers as $item)
                                                            <option value="{{$item->id}}">{{$item->name}}</option>
                                                        @empty
                                                            <option value="0" disabled>Nenhum Operador encontrado</option>
                                                        @endforelse
                                                    </select>
                                                </div>
                                                @endif
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
                                                        <span class="help-block"><b>Aceite</b> {{md5(Auth::id().'Consulta Moniotira')}} </span>
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
                                                <th>Supervisor</th>
                                                @for($i=1; $i<=$maiorNNotas; $i++)
                                                <th>Nota {{$i}}</th>
                                                @endfor
                                                <th>Média</th>
                                                <th>Qtd. Conforme</th>
                                                <th>Qtd. Não Conforme</th>
                                            </tr>
                                        </thead>
                                        <tbody style="overflow-y: auto; max-heigth: 500px;">
                                            @php
                                                // Totais 
                                                $rows = 0;
                                                $confTotais = 0;
                                                $nConfTotais = 0;
                                                $nAvTotais = 0;
                                                $mediasTotais = 0;

                                                if($maiorNNotas < 1) {
                                                    unset($maiorNNotas);
                                                    $maiorNNotas = 0;
                                                }
                                                $count = intval(count($forData));
                                            @endphp
                                            @if($count === 0)
                                                @php
                                                    $rows++;
                                                @endphp
                                                <tr>
                                                    <td class="text-center" colspan="6">
                                                        Nenhum dado encontrado
                                                    </td>
                                                </tr>
                                            @else
                                            
                                                {{-- Laço da tabela --}}
                                                @for($i=0; $i < $count; $i++)
                                                @php
                                                    // Variaveis utilizadas + de 1 vez no laço
                                                    $media = $forData[$i]['media'];
                                                    $conf = $forData[$i]['conf'];
                                                    $nAv = $forData[$i]['nAv'];
                                                    $nConf = $forData[$i]['nConf'];

                                                    //Soma totais
                                                    $confTotais += $conf;
                                                    $nConfTotais += $nConf;
                                                    $nAvTotais += $nAv;
                                                    $mediasTotais += $media;
                                                @endphp
                                                    <tr>
                                                        <td>{{$forData[$i]['nome']}}</td>
                                                        <td>{{$forData[$i]['nameSup']}}</td>

                                                        {{-- Start Notas  --}}
                                                        @php
                                                            $rows++;
                                                            // Notas
                                                            $notas = explode('|',$forData[$i]['notas'])
                                                        @endphp

                                                        {{-- Monta notas  --}}
                                                        @for($c=0; $c<$maiorNNotas; $c++)
                                                            {{-- Verifica  --}}
                                                            @if(isset( $notas[$c] ))
                                                                <td>{{$notas[$c]}}%</td>
                                                            @else
                                                                <td>-</td>
                                                            @endif
                                                        @endfor
                                                        {{-- End Notas  --}}
                                                        <td>{{$media}}%</td>
                                                        <td>{{$conf}}</td>
                                                        <td>{{$nConf}}</td>
                                                    </tr>    
                                                @endfor
                                            </tbody>
                                            <tfoot>
                                                @php
                                                    $mediaTotais = round(($mediasTotais/$rows),2);
                                                @endphp
                                                {{-- TOTAIS  --}}
                                                <tr class="bg-secondary text-white">
                                                    <td colspan="{{$maiorNNotas+1}}"><b>TOTAIS</b></td>
                                                    <td><b> {{$mediaTotais}}%</b></td>
                                                    <td><b>Média {{$mediaTotais}}%</b></td>
                                                    <td><b>{{$confTotais}}</b></td>
                                                    <td><b>{{$nConfTotais}}</b></td>
                                                </tr>
                                            </tfoot>
                                            @endif
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
                $("#formSearch").attr("action","{{ asset('manager/report/monitoring/supervisor/findoperator/') }}/"+$("select#supers").val())
            }

            if(error === 0) {
                $("#formSearch").submit()
            } else {
                $("#btnSearch").html('Buscar<span class="fa fa-floppy-o fa-right"></span>')
            }
        });
    </script>
@endsection
