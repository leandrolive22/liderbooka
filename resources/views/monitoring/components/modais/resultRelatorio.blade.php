@php
$popoverHtml = "
                <div id='contestarPopover' class='scroll' style='max-height: 250px; overflow-y: auto; overflow-x: auto'>
                    <button type='button' class='close' onclick='$(this).parent().parent().parent().hide().remove()'>
                        <span aria-hidden='true'>×</span>
                        <span class='sr-only'>Close</span>
                    </button>
                    <div>
                        <table class='table table-hover table-responsive'>
                            <thead>
                                <tr>
                                    <th>Data</th>
                                    <th>Motivo</th>
                                    <th>Grupo</th>
                                    <th>OBS</th>
                                    <th>Nome</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>25/08/2020</td>
                                    <td>Monitoria OK</td>
                                    <td>Procedente</td>
                                    <td>What is Lorem Ipsum Lorem Ipsum is simply dummy text of the printing and typesetting industry Lorem Ipsum has been the industry's standard dummy text ever since the 1500s when an unknown printer took a galley of type and scrambled it to make a type specimen book it has?</td>
                                    <td>Mariana</td>
                                </tr>
                            </tbody>
                        </table>
                    <div class='form-group'>
                        </div>
                        <form method='POST' action='".route('login')."'>
                        ".csrf_field()."
                            <div class='form-group'>
                                <label for='contestarSelect'>Motivo:</label>
                                <select id='contestarSelect' name='contestarSelect' class='form-control' required>
                                    <option>Monitoria OK</option>
                                </select>
                            </div>
                            <div class='form-group'>
                                <label for='contestarTextarea'>Obs:</label>
                                <input id='contestarTextarea' name='contestarTextarea' max-length='255' class='form-control' placeholder='Observações'>
                            </div>
                            <div class='text-center'>
                                <button onclick='$(this).parent().parent().parent().parent().parent().parent().hide().remove()' class='btn btn-secondary col-md-5'>Cancelar</button>
                                <button class='btn btn-danger col-md-5'>Contestar</button>
                            </div>
                        </form>
                    </div>
                </div>";
@endphp
<div class="modal in" id="modalMonitoring" tabindex="-1" role="dialog" aria-labelledby="defModalHead" aria-hidden="false" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="defModalHead">Monitoria</h4>
                <button type="button" class="close" onclick="javascript:$('#modalMonitoring').hide()" data-dismiss="modal">
                    <span aria-hidden="true">×</span>
                    <span class="sr-only">Close</span>
                </button>
            </div>
            {{-- dados do modal --}}
            @include('monitoring.components.modais.monitoriaView')
            <div class="modal-footer">
            @if(in_array(1,session('permissionsIds')) || in_array(19, session('permissionsIds')))
                <button type="button" id="closeModal" onclick="$('#modalMonitoring').hide()" class="btn btn-dark">Fechar</button>
                {{-- BTNS SUPERVISOR --}}
                <button type="button" id="ContestSupModal" data-container="body" data-toggle="popover" data-placement="top" data-content="{{$popoverHtml}}" data-html="true" class="btn btn-danger">Contestar</button>
                @if(Auth::user()->cargo_id === 4)
                    <button type="button" id="GravarSupModal" onclick="saveFeedbackSupervisorMonitoring()" class="btn btn-success">Gravar FeedBack</button>
                @endif
            @elseif(in_array(1,session('permissionsIds')) || in_array(21, session('permissionsIds')) || Auth::user()->cargo_id === 5)
                @php
                $hash2 = md5('Eu, '.Auth::user()->name.' discordo com a monitoria acima').date('Ymd').'-'.'2';
                $hash1 = md5('Eu, '.Auth::user()->name.' discordo com a monitoria acima').date('Ymd').'-'.'1';
                @endphp

                {{-- BTNS Resposta Operador --}}
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
