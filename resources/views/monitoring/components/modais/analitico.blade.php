<form method="POST" action="{{ route('PostRelatoriosAnalytics') }}" id="formMonitoringSearch">
    <div class="modal in" id="modalAnaliticoMonitoria" tabindex="-1" role="dialog" aria-labelledby="defModalHead" aria-hidden="false" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defModalHead">Relatório Analítico de Monitorias</h4>
                    <button type="button" class="close" onclick="javascript:$('#modalAnaliticoMonitoria').hide()" data-dismiss="modal">
                        <span aria-hidden="true">×</span><span class="sr-only">Close</span>
                    </button>
                </div>
                <div class="modal-body" style="overflow-y: auto; max-height:400px;">
                        <div class="col-md-12">
                            <div class="form-row col-md-12">
                                <h3 class="panel-title col-md-12">Selecione o Período</h3>
                                {{----}
                                <select  name="periodo" id="periodo" class="form-control select">
                                    @php
                                        $today = date('Y-m-d');
                                        $weekDay = date('w',strtotime($today));
                                        $firstWeekDay = date('Y-m-d 00:00:00',strtotime("-$weekDay Days",strtotime($today)));
                                    @endphp
                                    <option value="{{date('Y-m-1 00:00:00')}}" selected>Este mês</option>
                                    <option value="{{date('Y-m-d 00:00:00',strtotime('-2 Weeks',strtotime(date('Y-m-d'))))}}">Duas últimas Semanas</option>
                                    <option value="{{$firstWeekDay}}">Esta semana</option>
                                    <option value="{{date('Y-m-d 00:00:00')}}">Hoje</option>
                                </select>
                                <input type="hidden" name="duasDatas" id="duasDatas" value="0">
                                {{----}}
                                {{----}}
                                <div class="form-row col-md-6">
                                    <label for="de">De</label>
                                    <input type="date" required name="periodo" id="periodo" value="{{date('Y-m-01')}}" class="form-control">
                                </div>
                                <input type="hidden" name="duasDatas" id="duasDatas" value="1">
                                <div class="form-row col-md-6">
                                    <label for="ate">Até</label>
                                    <input type="date" required name="ate" id="ate" value="{{date('Y-m-d')}}" class="form-control">
                                </div> {{----}}
                            </div>
                        </div>
                        @csrf
                </div>
                <div class="modal-footer">
                    <label for="btnExportsAnaliticy" class="text-dark">Quartis atualizados todos os dias 12h00 e 00h00</label>
                    <button type="submit" class="btn btn-success" id="btnExportAnalitycs">
                        Exportar
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
