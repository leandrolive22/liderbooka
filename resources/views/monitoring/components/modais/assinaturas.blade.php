<form id="searchSignsForm" method="POST" action="{{ route('PostRelatoriosSign') }}">
    <div class="modal in" id="modalMonitoringSign" tabindex="-1" role="dialog" aria-labelledby="defModalHead" aria-hidden="false" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="defModalHead">Pesquisar Assinaturas</h4>
                    <button type="button" class="close" onclick="javascript:$('#modalMonitoringSign').hide()" data-dismiss="modal">
                        <span aria-hidden="true">×</span><span class="sr-only">Close</span>
                    </button>
                </div>
                <div class="modal-body" style="overflow-y: auto; max-height:500px;">
                    <div class="form-group">
                        <div class="col-md-6">
                            <label for="de">De</label>
                            <input type="date" name="de" id="de" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="ate">ate</label>
                            <input type="date" name="ate" id="ate" class="form-control">
                        </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <p>
                            Limite de 3 meses
                        </p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success">Pesquisar</button>
                </div>
            </div>
        </div>
    </div>
    </form>
