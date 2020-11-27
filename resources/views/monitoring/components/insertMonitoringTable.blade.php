@if(is_null($item->deleted_at))
    <tr id="trAplicarLaudos">
        <td>
            <p>
                {{$item->numero}}
            </p>
        </td>
        <td>
            <p>
                {{$item->questao}}
            </p>
        </td>
        <td>
            <p>
                {{$item->sinalizacao}}
            </p>
        </td>
        <td class="procedimentos" id="{{$item->id}}">
            <div class="btn-group col-md-12">
                @if($item->valor < 1 || Auth::user()->carteira_id == 1)
                <label class="check btn btn-success label-group" title="Conforme">
                    <input required onchange="changeMedia()" type="radio" value="Conforme" @if(isset($monitoria) && $monitoria->itens === "Conforme") checked="true" @endif id="procedimento_{{$item->id}}" valor="{{round($item->valor*100,2)}}" name="procedimento_{{$item->id}}" title="Conforme" />
                    {{-- <span class="fa fa-check"></span> Conforme --}}
                </label>
                @endif
                @if($item->valor < 1)
                <label class="check btn btn-dark label-group" title="Não Conforme">
                    <input required onchange="changeMedia()" type="radio" value="Não Conforme"  @if(isset($monitoria) && $monitoria->itens === "Não Conforme") checked="true" @endif id="procedimento_{{$item->id}}" valor="{{round($item->valor*100,2)}}" name="procedimento_{{$item->id}}" title="Não Conforme" />
                    {{-- <span class="fa fa-times"></span> Não Conforme --}}
                </label>
                @endif
                @if($item->valor == 1 || Auth::user()->carteira_id == 1)
                <label class="check btn btn-danger label-group">
                    <input required onchange="changeMedia()" type="radio" @if(isset($monitoria)) @if($monitoria->itens === "NCG") checked="true" @endif  @endif value="NCG" id="procedimento_{{$item->id}}" valor="{{round($item->valor*100,2)}}" name="procedimento_{{$item->id}}" class="NCG_{{$item->id}}" title="NCG" />
                    {{-- <span class="fa fa-times"></span> NCG --}}
                </label>
                @endif
                <label class="check btn btn-secondary label-group">
                    <input required onchange="changeMedia()" type="radio" @if(isset($monitoria)) @if($monitoria->itens === "Não Avaliado") checked="true" @endif @else checked="true"  @endif value="Não Avaliado" id="procedimento_{{$item->id}}" valor="{{round($item->valor*100,2)}}" name="procedimento_{{$item->id}}" title="Não Avaliado" />
                    {{-- <span class="fa fa-times"></span> Não Avaliado --}}
                </label>
                {{-- Comentários em itens escobs --}}
                @if(Auth::user()->carteira_id > 1)
                <label class="check btn btn-default label-group" onclick="if($('input#obs_{{$item->id}}').prop('see') == 1)
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
                <input type="text" style="display: none;" placeholder="Observação" class="btn btn-default" id="obs_{{$item->id}}" see="0">
                @endif
            </div>
        </td>
    </tr>
    @if(Auth::id() === 37)
    <tr>
        <td colspan="4">

        </td>
    </tr>
    @endif
@endif
