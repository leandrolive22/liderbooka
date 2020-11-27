<tr id="trAplicarLaudos">
    <td>
        <p>
            {{$item->laudo->numero}}
        </p>
    </td>
    <td>
        <p>
            {{$item->laudo->questao}}
        </p>
    </td>
    <td>
        <p>
            {{$item->laudo->sinalizacao}}
        </p>
    </td>
    <td class="procedimentos" id="{{$item->laudo->id}}">
        <label class="check btn btn-success">
            <input required  onchange="changeMedia()" type="radio" value="Conforme"  @if($item->value === "Conforme")  checked="true" @endif id="procedimento_{{$item->laudo->id}}" valor="{{round($item->laudo->valor*100,2)}}" name="procedimento_{{$item->laudo->id}}" title="Conforme"/>
            {{-- Conforme --}}
        </label>
        @if($item->laudo->valor < 1)
        <label class="check btn btn-dark">
            <input required  onchange="changeMedia()" type="radio" value="Não Conforme"  @if($item->value === "Não Conforme") checked="true" @endif id="procedimento_{{$item->laudo->id}}" valor="{{round($item->laudo->valor*100,2)}}" name="procedimento_{{$item->laudo->id}}" title="Não Conforme"/>
            {{-- Não Conforme --}}
        </label>
        @endif
        <label class="check btn btn-danger">
            <input required  onchange="changeMedia()" type="radio" @if($item->value === "NCG") checked="true" @endif value="NCG" id="procedimento_{{$item->laudo->id}}" valor="{{round($item->laudo->valor*100,2)}}" name="procedimento_{{$item->laudo->id}}" title="NCG"/>
            {{-- NCG --}}
        </label>
        <label class="check btn btn-secondary">
            <input required  onchange="changeMedia()" type="radio" @if($item->value !== "Não Conforme" && $item->value !== "Conforme") checked="true" @endif value="Não Avaliado" id="procedimento_{{$item->laudo->id}}" valor="{{round($item->laudo->valor*100,2)}}" name="procedimento_{{$item->laudo->id}}" title="Não Avaliado"/>
            {{-- Não Avaliado --}}
        </label>
        {{-- Comentários em itens escobs --}}
        @if(Auth::user()->carteira_id > 1)
        <label class="check btn btn-default label-group"onclick="if($('input#obs_{{$item->id}}').prop('see') == 1)
            {
                $('input#obs_{{$item->id}}').prop('see',0);
                $('input#obs_{{$item->id}}').hide()
            } else {
                $('input#obs_{{$item->id}}').prop('see',1);
                $('input#obs_{{$item->id}}').show();
                $('input#obs_{{$item->id}}').trigger('focus')
            }">
            <a>
                <span class="fa fa-comment"></span>
            </a>
            {{-- <span class="fa fa-times"></span> Não Avaliado --}}
        </label>
        <input type="text" @if(is_null($item->obs)) style="display: none;" @endif value="{{$item->obs}}" placeholder="Observação" class="btn btn-default" id="obs_{{$item->id}}" @if(is_null($item->obs)) see="0" @else see="1" @endif>
        @endif
    </td>
</tr>
