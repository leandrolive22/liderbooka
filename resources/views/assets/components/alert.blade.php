@if(session("errorAlert"))
    <!-- default -->
    <div class="message-box message-box-danger animated fadeIn open" id="message-box-danger">
        <div class="mb-container" style="width:80%; margin-left: 10%;">
            <div class="mb-middle">
                <div class="mb-title"><span class="fa fa-times"></span> <strong>Hi... Algo deu errado.</strong></div>
                <div class="mb-content">
                    <p>{{session("errorAlert")}}</p>
                </div>
                <div class="mb-footer">
                    <button onclick="$('#message-box-danger').hide()" class="btn btn-default btn-lg pull-right mb-control-close" id="ErrorModalBtn">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end default -->
    @else
    <div class="message-box message-box-danger animated fadeIn open" id="message-box-danger" style="display: none">
        <div class="mb-container" style="width:80%; margin-left: 10%;">
            <div class="mb-middle">
                <div class="mb-title"><span class="fa fa-times"></span> <strong>Hi... Algo deu errado.</strong></div>
                <div class="mb-content">
                    <p id="tagPerror"></p>
                </div>
                <div class="mb-footer">
                    <button onclick="$('#message-box-danger').hide()" class="btn btn-default btn-lg pull-right mb-control-close" id="ErrorModalBtn">Fechar</button>
                </div>
            </div>
        </div>
    </div>
@endif
@if(session("successAlert"))
    <!-- default -->
    <div class="message-box message-box-success animated fadeIn open" id="message-box-success">
        <div class="mb-container" style="width:80%; margin-left: 10%;">
            <div class="mb-middle">
                <div class="mb-title"><span class="fa fa-check"></span> <strong>Sucesso</strong></div>
                <div class="mb-content">
                    <p>{{session("successAlert")}}</p>
                </div>
                <div class="mb-footer">
                    <button onclick="$('#message-box-success').hide()" class="btn btn-default btn-lg pull-right mb-control-close" id="SuccessModalBtn">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- end default -->
    @else
    <div class="message-box message-box-success animated fadeIn open" id="message-box-success" style="display: none">
        <div class="mb-container" style="width:80%; margin-left: 10%;">
            <div class="mb-middle">
                <div class="mb-title"><span class="fa fa-check"></span> <strong>Sucesso</strong></div>
                <div class="mb-content">
                    <p id="tagPsuccess"></p>
                </div>
                <div class="mb-footer">
                    <button onclick="$('#message-box-success').hide()" class="btn btn-default btn-lg pull-right mb-control-close" id="SuccessModalBtn">Fechar</button>
                </div>
            </div>
        </div>
    </div>
@endif

