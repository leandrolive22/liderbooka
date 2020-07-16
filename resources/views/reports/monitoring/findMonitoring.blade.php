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
    margin-left:340px;
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
                                        <form id="formSearch" @if(in_array(Auth::user()->cargo_id,[4])))action="{{ route('findmonitoringByDateOperator', ['id'=>Auth::id()]) }}" @endif method="POST">
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
