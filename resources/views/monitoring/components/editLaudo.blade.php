@if(is_null($item->deleted_at))
<tr name="linhas" id="id_{{$item->id}}">
    <td id="myTd">
        <input autocomplete="off" class="tdInput" name="tdInput" id="number_{{$item->id}}" placeholder="0.0.0" type="text" value="{{$item->numero}}">
    </td>
    <td id="myTd">
        <input autocomplete="off" class="tdInput" name="tdInput" id="pergunta_{{$item->id}}" placeholder="Escreva aqui sua pergunta" value="{{$item->questao}}">
    </td>
    <td id="myTd">
        <input autocomplete="off" class="tdInput" name="tdInput" id="sinal_{{$item->id}}" placeholder="Tipo de sinalização" type="text" value="{{$item->sinalizacao}}">
    </td>
    <td id="myTd">
        <input autocomplete="off" class="tdInput" name="tdInput" id="value_{{$item->id}}" placeholder="0 Para CallCenter" type="number" value="{{round($item->valor*100,6)}}">
    </td>
    <td id="myTd">
        <button id="myBtn" class="btn btn-danger btn-block" onclick="deleteLine('id_{{$item->id}}')">
            <span class="fa fa-trash-o"></span>
        </button>
    </td>
</tr>
@endif