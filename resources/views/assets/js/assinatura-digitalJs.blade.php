<script type="text/javascript">
    function check(element) {
        if($('#'+element.id).is(':checked')) {
        $("#assinatura"+element.value).show()
        } else {
        $("#assinatura"+element.value).hide()
        }
    }

    function signatureHash(id,hash) {
        h = "'"+hash+"'";
        type = $("#typeMaterials"+id).val()

        text = '<input class="form-check-input" type="checkbox" id="defaultCheck'+id+'" value="'+id+'" onchange="check(this)">'+
        '<input type="hidden" value="'+hash+'">'+
        '<label class="form-check-label" for="defaultCheck'+id+'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Li e Concordo com o conteúdo acima</label>'+
        '<button id="assinatura'+id+'" class="btn btn-primary mb-2 pull-right" style="display: none;" onclick="javascript:saveHash('+id+','+h+')">Fechar</button>'+
        '<br>'+
        '<label for="defaultCheck'+id+'" class="text-muted">'+hash+'</label>';

        $.getJSON('{{ asset("/api/sign/check/" . Auth::user()->id . "") }}/'+id+'/'+type,function(data){
            console.log(data)
            if(data.length == 0) {
                $("#material"+id).html(text)
            } else {
                value = data[0].value
                $("#material"+id).html('<button onclick="hideModal('+id+')" class="btn btn-primary mb-2 pull-right">Fechar</button><label class="text-muted">'+value+'</label>')
            }
        });
    }

    function hideModal(id) {
        $("#id"+id).hide()
    }

    //salva log de eu li e concordo com material
    function saveHash(id,hash){
        type = $("#typeMaterials"+id).val()
        console.log(type)
        $.getJSON('{{ asset("api/sign/") }}/{{Auth::user()->id}}/'+id,function(data){
        $.ajax({
            url: "{{asset('/')}}api/sign/"+hash+"/{{Auth::user()->id}}/{{Auth::user()->ilha_id}}/"+id+'/'+type,
            type: "POST",
            success: function(response) {
                console.log(response)
                $("#id"+id).hide();
                $("#material"+id).html('<label class="text-muted">'+hash+'</label>')
            },
            error: function(xhr, status) {
                console.log(xhr)
                noty({
                    text: 'Erro ao Salvar assinatura',
                    type: 'error',
                    layout: 'topRight',
                    timeout: 3000,
                });
            }
        })
        })
    }
</script>
