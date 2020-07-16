<table>
    <thead>
    <tr>
        @for ($i = 0; $i < $count; $i++)
            <th>{{ $column[$i] }}</th>
        @endfor
    </tr>
    </thead>
    <tbody>
    @foreach($data as $d)
        <tr>
            @for ($i = 0; $i < $count; $i++)
                <td>{{ $d[$column[$i]] }}</td>
            @endfor
        </tr>
    @endforeach
    </tbody>
</table>