<script type="text/javascript">
    function openMaterial(id,path,type) {
        $("#btnOpen"+id).prop('disabled',true)
        if($("tr#linhaWiki89").attr("class") === 'trGreen') {
            let addModal = modal(id, path, type, '', 0)
            $('body').append(addModal)
            return $("#btnOpen"+id).prop('disabled',false)

        } else {
            $.getJSON('{{asset("api/sign/".Auth::id()."/".Auth::user()->ilha_id)}}/'+id+'/'+type,function(data){
                console.log(data)
                if(data === 0) {
                    return noty({
                        text: 'Erro Desconhecido!',
                        type: 'error',
                        layout: 'topRight',
                        timeout: 3000,
                    });
                } else {
                    atv = 1; 
                    if(data[0].action === 'undefined' && type === 'CIRCULAR' && atv === 0) {
                        check = 1
                    } else {
                        check = 0
                    }
                    $("#linhaWiki"+id).attr('class','trGreen')
                    let addModal = modal(id, path, type, data[0].hash, check)
                    $('body').append(addModal)
                }
            });
            return $("#btnOpen"+id).prop('disabled',false)
        }
    }

    //salva log de eu li e concordo com material
    function saveHash(id, hash, type){
        $.ajax({
            url: "{{asset('/')}}api/sign/circular/"+hash+"/{{Auth::user()->id}}/{{Auth::user()->ilha_id}}/"+id,
            type: "POST",
            data: "text="+$("textarea#text"+id).val(),
            success: function(response) {
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
    }

    function modal(id, path, type, hash, check) {
        let modal = '<div class="modal in" id="modalMaterial'+id+'" tabindex="-1" z-index="999" role="dialog" aria-labelledby="defModalHead" aria-hidden="false" style="display: block;">'+
                    '<div class="modal-dialog modal-lg">'+
                        '<div class="modal-content">'+
                            '<div class="modal-body" style="height:100%; min-height:400px;">'+
                                '<embed src="'+path+'" frameborder="0" style="width:100%;height:100%; min-height:398px;">'+
                            '</div>'+
                            '<div class="modal-footer">'+
                            '<label class="text-muted col-md-12 pull-left" style="font-size: 10px">Assinatura automática: '+hash+'</label>';
        if(type === 'CIRCULAR' && check === 1) {
            modal += '<textarea class="form-control" name="text'+id+'" id="text'+id+'" maxlenght="255" placeholder="Escreve aqui o que você entendeu da circular"></textarea>'+
                    '<button type="button" class="btn btn-dark" id="save'+id+'" onclick="saveHash('+id+','+"'"+hash+"'"+','+"'"+type+"'"+')">Fechar</button>';
        } else {
            modal += '<button type="button" class="btn btn-dark" id="save'+id+'" onclick="$('+"'#modalMaterial"+id+"'"+').hide().remove()">Fechar</button>';
        }
        modal +=  '</div>'+
                '</div>'+
            '</div>'+
        '</div>';
        return modal
    }
</script>
