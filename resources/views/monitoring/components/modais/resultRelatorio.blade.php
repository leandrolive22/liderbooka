<div class="modal in" @if(Auth::user()->cargo_id === 5) id="modalMonitoringFeedBack" @else id="modalMonitoring" @endif tabindex="-1" role="dialog" aria-labelledby="defModalHead" aria-hidden="false" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="overflow-y: auto; max-height:500px;">
            <div class="modal-header">
                <h4 class="modal-title" id="defModalHead">Monitoria</h4>
                <button type="button" class="close" onclick="javascript:$('#modalMonitoring').hide()" data-dismiss="modal">
                    <span aria-hidden="true">×</span><span class="sr-only">Close</span>
                </button>
            </div>
            {{-- dados do modal --}}
            @include('monitoring.components.modais.monitoriaView')
            <div class="modal-body">

            </div>
            <div class="modal-footer">
            @if(Auth::user()->cargo_id == 4)
                <button type="button" id="closeModal" onclick="$('#modalMonitoring').hide()" class="btn btn-dark">Fechar</button>
                <button type="button" id="GravarSupModal" onclick="saveFeedbackSupervisorMonitoring()" class="btn btn-success">Gravar FeedBack</button>
            @elseif(Auth::user()->cargo_id == 5)
                @php
                $hash2 = md5('Eu, '.Auth::user()->name.' discordo com a monitoria acima').date('Ymd').'-'.'2';
                $hash1 = md5('Eu, '.Auth::user()->name.' discordo com a monitoria acima').date('Ymd').'-'.'1';
                @endphp

                {{-- BTNS Resposta --}}
                <button type="button" id="closeModal" id="btnMo2" onclick="saveFeedbackOperatorMonitoring(2,'{{$hash2}}')" class="btn btn-danger"
                    data-toggle="tooltip" data-placement="top"
                    data-original-title="Eu, {{Auth::user()->name}} discordo com a monitoria acima / Hash: {{ $hash2 }}">Discordar</button>

                <button type="button" id="closeModal" id="btnMo1" onclick="saveFeedbackOperatorMonitoring(1,'{{$hash1}}')" class="btn btn-success"
                    data-toggle="tooltip" data-placement="top"
                    data-original-title="Eu, {{Auth::user()->name}} concordo com a monitoria acima / Hash: {{ $hash1 }}">Concordar</button>
            @endif
            </div>
        </div>
    </div>
</div>
