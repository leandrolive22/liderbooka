@forelse ($data as $item)
    <tr id="idTr{{$idTr.$item->id ?? ''}}">
        @foreach ($columns as $c)
            @if(isset($item->$c))
                <td>{{$item->$c}}</td>
            @elseif(isset($actions))
                @php
                    echo '<td class="text-center">'.str_replace('_var_',$item->id,$actions).'</td>';
                @endphp
            @endif
        @endforeach
    </tr>
@empty
    <tr>
        <td class="text-center" colspan="{{ count($columns) }}">
            Nenhum dado encontrado
        </td>
    </tr>
@endforelse
