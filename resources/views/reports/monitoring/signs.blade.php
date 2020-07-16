@extends('layouts.app', ["current"=>"monitor"])
<!-- CARDS CSS INICIO -->
@section('css')
<style>
    
</style>
@endsection
<!-- CARDS CSS FIM -->
@section('content')
<!-- START PAGE CONTAINER -->
<div class="page-container">

    <!-- START PAGE CONTENT -->
    <div class="page-content">

        @component('assets.components.x-navbar')
        @endcomponent

        <br>

        <!-- START BREADCRUMB -->
        <ul class="breadcrumb">
            <li><a href="{{asset('/home/page')}}">Home</a></li>
            <li><a href="{{asset('monitoring/manager')}}">Monitoria</a></li>
            <li><a href="#">Buscar Analítico</a></li>
        </ul>
        <!-- END BREADCRUMB -->

        <!-- START CONTENT FRAME -->
        <div class="content-frame">

            <!-- START CONTENT FRAME TOP -->
            <div class="content-frame-top">
                <div class="page-title">
                    <a href="{{ url()->previous() }}">
                        <h2>
                            <span class="fa fa-arrow-circle-o-left"></span> Monitoria
                        </h2>
                    </a>
                </div>
                <div class="pull-right">
                    <button class="btn btn-{{Auth::user()->css}} content-frame-right-toggle"><span
                            class="fa fa-bars"></span></button>
                </div>
            </div>
            <!-- END CONTENT FRAME TOP -->

            <!-- START CONTENT FRAME LEFT -->
            <div class="col-md-12">
                <div class="row">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Relatório de Assinaturas</h3>
                            <button class="btn btn-outline-success pull-right" onclick='$("#tabelaMonitoriaAssinaturas").tableExport({type:"excel",escape:"false"})''>
                                <span class="fa fa-table"></span>
                                &nbsp;
                                Exportar
                            </button>
                        </div>
                        <div class="panel-body" style="overflow-x: auto">
                            <table class="table" id="tabelaMonitoriaAssinaturas">
                                <thead>
                                    <tr>
                                        <th>Operador</th>
                                        <th>Supervisor</th>
                                        <th>Feedback Monitor</th>
                                        <th>Data Feedback</th>
                                        <th>Usuário Cliente</th>
                                        <th>Aceite Monitoria</th>
                                        <th>Data Monitoria</th>
                                        <th>Perfil Avaliador</th>
                                        <th>Avaliador Monitoria</th>
                                        <th>Nota</th>
                                        <th>Numero do Laudo</th>
                                        <th>Aplicador Feedback</th>
                                    </tr>
                                </thead>
                                <tbody style="max-height:500px;overflow-y:auto">
                                    @forelse ($search as $item)
                                    <tr>
                                        <td>{{$item->operador}}</td>
                                        <td>{{$item->supervisor}}</td>
                                        <td>{{$item->feedback_monitor}}</td>
                                        <td>{{$item->usuario_cliente}}</td>
                                        @if ($item->aceite === 1)
                                            <td>Aceito</td>
                                        @else 
                                            <td>Não aceito</td>
                                        @endif
                                        <td>{{$item->date_monitoring}}</td>
                                        <td>{{$item->perfil_avaliador}}</td>
                                        <td>{{$item->avaliador_monitor}}</td>
                                        <td>{{$item->nota}}%</td>
                                        <td>{{$item->numero_laudo}}</td>
                                        <td>{{$item->aplicador_feedback}}</td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td class="text-center" colspan="12">Nenhum dado encontrado</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END CONTENT FRAME LEFT -->

        </div>
        <!-- END CONTENT FRAME -->

    </div>
    <!-- END PAGE CONTENT -->

</div>
<!-- END PAGE CONTAINER -->
@endsection
@section('Javascript')
    <script type="text/javascript" src="{{ asset('js/plugins/tableexport/tableExport.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/tableexport/jquery.base64.js') }}"></script>
@endsection