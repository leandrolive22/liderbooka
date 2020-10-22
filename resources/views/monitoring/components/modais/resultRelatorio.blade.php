@php
$motivosText = '<option disabled>Selecione um motivo</option>';
foreach($motivos as $item) {
    $motivosText .= '<option value="'.$item->id.'">'.$item->name.'</option>';
}
$popoverHtml = "
<div id='contestarPopover' class='scroll' style='max-height: 250px; overflow-y: auto; overflow-x: auto'>
<button type='button' class='close' onclick='$(this).parent().parent().parent().hide()'>
<span aria-hidden='true'>×</span>
<span class='sr-only'>Close</span>
</button>
<div>
<div class='text-center' id='preLoaderContestar'>
<div class='spinner-grow' role='status'>
<span class='sr-only'>Loading...</span>
</div>
</div>
<div class='form-group'>
</div>
<form method='POST' action='".route('login')."'>
".csrf_field()."
<div class='form-group'>
<label for='contestarSelect'>Motivo:</label>
<select id='contestarSelect' name='contestarSelect' class='form-control' required>
$motivosText
</select>
</div>
<div class='form-group'>
<label for='contestarSelect'>Status:</label>
<select id='status' name='status' class='form-control' required>
<option value='2'>Improcedente</option>
<option value='1'>Procedente</option>
</select>
</div>
<div class='form-group'>
<label for='contestarTextarea'>Obs:</label>
<input id='contestarTextarea' name='contestarTextarea' max-length='255' class='form-control' placeholder='Observações'>
</div>
<div class='text-center'>
<button class='btn btn-block btn-danger'>Contestar</button>
</div>
</form>
</div>
</div>";
@endphp
<div class="modal in" id="modalMonitoring" tabindex="-1" role="dialog" aria-labelledby="defModalHead" aria-hidden="false" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="overflow-y: scroll;">
            <div class="modal-header">
                <h4 class="modal-title" id="defModalHead">Monitoria</h4>
                <button type="button" class="close" onclick="javascript:$('#modalMonitoring').hide()" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">Close</span>
                </button>
            </div>
            {{-- dados do modal --}}
            @include('monitoring.components.modais.monitoriaView')
            {{-- <div class="modal-footer">
                @if(in_array(1,session('permissionsIds')) || in_array(19, session('permissionsIds')) || Auth::user()->cargo_id == 4)
                <button type="button" id="closeModal" onclick="$('#modalMonitoring').hide()" class="btn btn-dark">Fechar</button>
                {{-- BTNS SUPERVISOR --}
                @if(in_array(21,session('permissionsIds')))
                <button type="button" id="ContestSupModal" data-container="body" data-toggle="popover" data-placement="top" data-content="{{$popoverHtml}}" data-html="true" class="btn btn-danger">Contestar</button>
                @endif
                @if(Auth::user()->cargo_id == 4)
                <button type="button" id="GravarSupModal" onclick="saveFeedbackSupervisorMonitoring()" class="btn btn-success">Gravar FeedBack</button>
                @endif
                @elseif(in_array(1,session('permissionsIds')) || in_array(21, session('permissionsIds')) || Auth::user()->cargo_id === 5)
                @php
                $hash2 = md5('Eu, '.Auth::user()->name.' discordo com a monitoria acima').date('Ymd').'-'.'2';
                $hash1 = md5('Eu, '.Auth::user()->name.' discordo com a monitoria acima').date('Ymd').'-'.'1';
                @endphp

                {{-- BTNS Resposta Operador --}
                <button type="button" id="closeModal" id="btnMo2" onclick="saveFeedbackOperatorMonitoring(2,'{{$hash2}}')" class="btn btn-danger"
                data-toggle="tooltip" data-placement="top"
                data-original-title="Eu, {{Auth::user()->name}} discordo com a monitoria acima / Hash: {{ $hash2 }}">Discordar</button>

                <button type="button" id="closeModal" id="btnMo1" onclick="saveFeedbackOperatorMonitoring(1,'{{$hash1}}')" class="btn btn-success"
                data-toggle="tooltip" data-placement="top"
                data-original-title="Eu, {{Auth::user()->name}} concordo com a monitoria acima / Hash: {{ $hash1 }}">Concordar</button>
                @endif
            </div> --}}
        </div>
    </div>
</div>
