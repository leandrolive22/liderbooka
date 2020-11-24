<div class="col-md-10">
    <label class="mr-sm-8 sr-only" for="inlineFormCustomSelect">Campos</label>
    <label class="icheck">
        <input class="campo" name="campo" type="radio" class="icheck" value="name">
        Nome
    </label>
    <label class="icheck">
        <input class="campo" name="campo" type="radio" class="icheck" value="username">
        Usuário
    </label>
    <label class="icheck">
        <input class="campo" name="campo" type="radio" class="icheck" value="matricula">
        Matricula
    </label>

    <div class="input-group mb-3 col-md-9 text-center">
        <input type="text" class="form-control col-md-6" name="searchInTable" id="searchInTable" placeholder="Pesquise aqui" aria-label="Pesquisar">
        <div class="input-group-append">
            <button type="button" class="input-group-text bg-dark text-white btn-dark"  onclick="searchInTable();" id="pesquisarFiltro">Pesquisar</button>
        </div>
    </div>

</div>
@section('filter')
<script type="text/javascript">
    function searchInTable() {
        $(".input-group-addon.fa.fa-search.btn").attr('class','input-group-addon fa fa-spin fa-spinner btn')
        val = $("#searchInTable").val()
        input = $("input[name=campo]:checked").val()

        if(val.length > 0) {
            data = 'str='+val+'&input='+input

            @if(Route::current()->getName() === 'GetUsersManagerUserDeleted') data += '&deleted_at=1' @endif

            $.ajax({
                url: '{{route("searchInTableUser")}}',
                data: data,
                success: function(data) {

                    if(data.length > 0) {
                        $("#usersTable > tbody tr").hide()
                        linhas = ''
                        for(i=0;i<data.length;i++) {
                            linhas += montarLinhaFiltro(data[i])
                        }

                        $("#usersTable >tbody").append(linhas)
                    } else {
                        noty({
                            text: 'Nenhum dado encontrado',
                            layout: 'topRight',
                            type: 'warning'
                        })
                        $("#usersTable > tbody tr").show()
                    }
                    $(".input-group-addon.fa.fa-spin.fa-spinner.btn").attr('class','input-group-addon fa fa-search btn')
                }
            });// end Ajax
        } else {
            $("#usersTable > tbody tr").show()
            $(".input-group-addon.fa.fa-spin.fa-spinner.btn").attr('class','input-group-addon fa fa-search btn')
        }
    }

    function montarLinhaFiltro(data) {
        return '<tr id="usersTr'+data.id+'">'+
                                '<form id="retoreUserForm'+data.id+'" method="POST" action="'+"{{route('PostRestoreUser',['userAction' => Auth::id(), 'user' => '---'])}}".replace('---',data.id)+'">@csrf</form>'+
                                '<form id="formEditDelete'+data.id+'" method="POST">'+
                                '@csrf'+
                                '<input type="hidden" name="user" value="{{ Auth::id() }}">'+
                                '<input type="hidden" name="id" value="'+data.id+'">'+
                                '</form>'+
                                '<td>'+
                                data.name+
                                '</td>'+
                                '<td>'+
                                data.username+
                                '</td>'+
                                '<td>'+
                                '<!-- Formata matricula  -->'+
                                data.matricula+
                                '</td>'+
                                @if(!in_array(34, session('permissionsIds')) || in_array(35, session('permissionsIds')) || in_array(36, session('permissionsIds')) || in_array(37, session('permissionsIds')) || in_array(45, session('permissionsIds')) || in_array(1, session('permissionsIds')) )
                                '<td>'+
                                    '<div class="input-group btn">'+
    "{{-- Se a Consulta traz usuários deletados --}}"+
                                                @if(Route::current()->getName() === 'GetUsersManagerUserDeleted')
                                                @php $titleDelete = 'Clique aqui para excluir de vez o usuário'; @endphp
                                                '<button type="button" class="btn btn-success btn-sm" title="Clique aqui para restaurar o usuário" onclick="$('+"'form#retoreUserForm"+data.id+"'"+').submit();">'+
                                                    '<span id="btnPencil'+data.id+'" class="fa fa-mail-reply"></span>'+
                                                '</button>'+
    "{{-- Se a Consulta traz usuários ativos --}}"+
                                                @else
                                                @php $titleDelete = 'Clique aqui para desativar usuário'; @endphp
                                                {{-- Editar --}}
                                                @if(in_array(35, session('permissionsIds')) || in_array(1,session('permissionsIds')))
                                                '<button type="button" class="btn btn-default btn-sm" title="Clique aqui para salvar alterações" onclick="updateUser('+data.id+');">'+
                                                    '<span id="btnPencil'+data.id+'" class="fa fa-pencil"></span>'+
                                                '</button>'+
                                                {{-- editar senha --}}
                                                '<button type="button" onclick="resetPassword('+data.id+')" title="Clique aqui para redefinir senha de usuário" class="btn btn-warning btn-sm">'+
                                                    '<span class="fa fa-lock"></span>'+
                                                '</button>'+
                                                @endif
                                                {{-- PERMISSAO --}}
                                                @if(in_array(45, session('permissionsIds')) || in_array(1,session('permissionsIds')))
                                                '<button type="button" onclick="window.location.href = '+"'{{ route('GetPermissionsIndexUser', '---') }}'".replace('---',data.id)+'" class="btn btn-dark btn-sm">'+
                                                    '<span class="fa fa-sitemap"></span>'+
                                                '</button>'+
                                                @endif
                                                @endif
                                                @if(in_array(36, session('permissionsIds')) || in_array(1,session('permissionsIds')))
                                                {{-- Excluir --}}
'                                                <button type="button" class="btn btn-danger btn-sm" title="{{$titleDelete}}" onclick="deleteUser('+data.id+');">'+
                                                    '<span class="fa fa-times"></span>'+
                                                '</button>'+
                                                @endif
                                            '</div>'+
                                '</td>'+
                                @endif
                                '</tr>';
    }
</script>
@endsection
