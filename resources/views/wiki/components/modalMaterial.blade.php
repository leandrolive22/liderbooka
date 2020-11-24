<!-- Modal Materials  -->

<div class="modal in" id="materialmodal" tabindex="-1" role="dialog" aria-labelledby="editFileMaterialdefModalHead" aria-hidden="false" style="display:  @if(session('src')) block; @else none; @endif">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="editFileMaterialName">Material</h4>

            </div>
            <div class="modal-body" style="max-height: 75vh; overflow-y: auto;">
                <div class="embed-responsive embed-responsive-4by3">
                    <iframe class="embed-responsive-item" id="materialmodalframe" allowfullscreen></iframe>
                </iframe>   
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="editFileMaterial();">Fechar</button>
            </div>
        </div>
    </div>
</div>

<!-- Fim Modal -->