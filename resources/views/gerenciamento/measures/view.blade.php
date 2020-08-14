<script type="text/javascript" id="measureJs">
// Pega medida por usuário
function getMeasure() {
        if($("#mId").val() > 0 && Number.isInteger($("#mId").val())) {
                $("modalMeasure").show()
        } else {
                $.ajax({
                        url: '{{ route('GetMeasuresView',[Auth::id()]) }}',
                        method: 'GET',
                        success: function(data) {
                                if(data !== 'vazio' && data.length > 0) {
                                    console.log(data)
                                        modal =  '<div class="modal in" id="modalMeasure" tabindex="-1" z-index="999" role="dialog" aria-labelledby="defModalHead" aria-hidden="false" style="margin-top: 15px; display: block;">'+
                                        '<div class="modal-dialog">'+
                                        '<div class="modal-content">'+
                                        '<div class="modal-header">'+
                                        '<h4 class="modal-title" id="defModalHead">Medida Disciplinar Nº '+data[0].id+'</h4>'+
                                        '</div>'+
                                        '<div class="modal-body">'+
                                        '<input type="hidden" value="'+data[0].id+'" name="mId" id="mId">'+
                                        '<div class="panel panel-default">'+
                                        '<div class="panel-body">'+
                                        '<h4>'+data[0].title+'</h4>'+
                                        '<p>'+data[0].description.replace(':nome','{{Auth::user()->name}}').replace(':nome','{{Auth::user()->cpf}}').replace(/\r?\n/g, "<br />")+
                                        '</p>'+
                                        '<p>'+data[0].obs+'</p>'+
                                        '<div class="panel-body">'+
                                        '<label class="label-control col-md-12">Observações e Comentários</label>'+
                                        '<textarea name="user_obs" id="user_obs" class="form-control col-md-10"></textarea>'+
                                        '</div>'+
                                        '</div>'+
                                        '</div>'+
                                        '<div class="modal-footer">'+
                                        '<button type="button" class="btn btn-outline-danger pull-right" onclick="saveMeasureResp(0)">Discordo</button>'+
                                        '<button type="button" class="btn btn-outline-success pull-right" onclick="saveMeasureResp(1)">Concordo</button>'+
                                        '</div>'+
                                        '</div>'+
                                        '</div>'+
                                        '</div>';

                                        $("body").append(modal)
                                }
                        },
                        error: function(xhr, error, status) {
                                console.log(xhr)
                        }

                });
        }
}

// Salva resposta do usuário
function saveMeasureResp(n) {
       $.ajax({
        url: '{{ route('PostMeasuresSaveResp',[Auth::id()]) }}',
        method: 'POST',
        data: 'n='+n+'&user_obs='+$('#user_obs').val()+'&ip_client={{Request::ip()}}&mId='+$("#mId").val(),
        success: function(data) {
                noty({
                       text: 'Resposta salva',
                       layout: 'topRight',
                       type: 'success',
                       timeout: 3000
               });

                        // fecha modal
                        $("#modalMeasure").hide()
                        $("#modalMeasure").remove()
                },
                error: function (xhr) {
                        console.log(xhr)

                        if(xhr.status == 429) {
                                noty({
                                        text: 'Erro! Recarregue a página e tente novamente (429)',
                                        layout: 'topRight',
                                        type: 'error',
                                        timeout: 3000
                                });
                        }

                        noty({
                                text: 'Erro! Recarregue a página e tente novamente ('+xhr.status+')',
                                layout: 'topRight',
                                type: 'error',
                                timeout: 3000
                        });

                        // fecha modal
                        $("#modalMeasure").hide()
                }
        });
}

//Carrega ao abrir
$(document).ready(function(){
        setInterval(function(){getMeasure()},60*1000*8)
        setTimeout(() => {
            getMeasure()
        }, 240000);
});
</script>
