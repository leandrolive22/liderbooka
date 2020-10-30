<div class="row">
    <div class="form-group col-md-12">
        <select class="form-control" name="filterTag" id="filterTag_{{$tipo_id}}">
            <option value="materiais_apoio.name">Título / Assunto</option>
            <option value="tags">Categoria</option>
            <option value="materiais_apoio.id">Número(#) </option>
        </select>
        <input type="text" onblur="search({{$tipo_id}}, this)" class="form-control" placeholder="Pesquisar" aria-label="Pesquisar" aria-describedby="basic-addon1">
    </div>
</div>
@section('JavascriptSearchWiki')
<script type="text/javascript">
function search(type, element) {
    filter = $(element).parent().parent().children().children()[0].value
    text = $(element).parent().parent().children().children()[1].value

    // checa se valores estão ok
    checkFilter = $.inArray(filter, ['', null, '', 0]) === -1 && typeof filter !== 'undefined'
    checkText = $.inArray(text, ['', null, '', 0]) === -1 && typeof text !== 'undefined'

    if(checkFilter && checkText && text.length >= 3) {
        url = '{{ route("GetMaterialsWiki", ["type" => "tipo_id","haveFilter" => TRUE]) }}'.replace('tipo_id',type)
        data = '_token='+$("input[name=_token]").val()+'&filter='+filter+'&text='+text
        $.ajax({
            url: url,
            method: 'GET',
            data: data,
            success: function(data) {
                if(data.length > 0) {
                    linhas = ''
                    $("#default_page").hide()
                    $("#new_data_page").hide().remove()
                    for(i=0; i<data.length; i++) {
                        @if($tipo_visualizacao === 'manager')
                        linhas += montarItemManagerWiki(data[i])
                        @elseif($tipo_visualizacao === 'videos')
                        linhas += montarVideosWiki(data[i])
                        @endif
                    }
                    $("#list_material_"+type).html(linhas)

                } else {
                    noty({
                        text: 'Nenhum material corresponde à pesquisa!',
                        layout: 'topRight',
                        type: 'warning',
                    });
                    $("#default_page").show();
                }
            },
            error: function(xhr) {
                console.log(xhr)
            }
        })
    }
}

function montarItemManagerWiki(data) {
    id_material = data.id_material
    name = data.name
    file_path = data.file_path
    data_criacao = data.data_criacao


    actions =  '<div class="list-group">';
    actions +=      "<button onclick='seeMaterial("+id_material+")' title='Visualizar' class='list-group-item btn-primary col-md-12'> <span class='fa fa-eye'></span></button>"
    actions +=     "<button onclick='editInfoMaterial("+id_material+")' title='Editar Informações' class='list-group-item btn-warning col-md-12'> <span class='fa fa-warning'></span></button>"
    actions +=     "<button onclick='editFilterMaterial("+id_material+")' title='Editar Filtros' class='list-group-item btn-warning col-md-12'> <span class='fa fa-filter'></span></button>"
    actions +=     "<button onclick='editFileMaterial("+id_material+")' title='Editar Tags' class='list-group-item btn-warning col-md-12'> <span class='fa fa-file'></span></button>"
    actions +=     "<button onclick='deleteMaterial("+id_material+")' title='Excluir' class='list-group-item btn-danger  col-md-12'> <span class='fa fa-trash-o'></span></button>"
    actions += '</div>';


    html = '<button class="list-group-item text-left new_data_page" data-toggle="popover" title="Ações" data-content="'+actions+'" data-html="true">'+
        '<b>#'+id_material+'</b> - '+name+''+
    '</button>'

    return html
}

function montarConteudowiki() {
    id_material = data.id_material
    name = data.name
    file_path = data.file_path
    data_criacao = data.data_criacao

    html = ''
    return html
}
</script>
@endsection
