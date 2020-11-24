<form id="formToApply" method="POST">
    @csrf
    <div class="modal in" tabindex="-1" role="dialog" aria-labelledby="defModalHead" aria-hidden="false"  style="display:none;" id="formToApplyModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="max-height:500px;">
                <div class="modal-header">
                    <h4 class="modal-title" id="defModalHead">Monitoria</h4>
                    <button type="button" class="close" onclick="javascript:$('#formToApplyModal').hide()" data-dismiss="modal">
                        <span aria-hidden="true">×</span><span class="sr-only">Close</span>
                    </button>
                </div>
                {{-- dados do modal --}}
                <div class="modal-body" style="overflow-y: auto; max-height: 300px">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label class="form-label col-md-4" for="searchIpt">Pesquise pelo Nome</label>
                            <input type="text" name="searchIpt" id="searchIpt" placeholder="Pesquise aqui!" class="form-control col-md-8">
                        </div>
                        <p class="col-md-12">Caso não encontre o usuário, registro-o <a href="{{route('GetUsersRegisterUser')}}">aqui</a></p>
                    </div>
                    <div class="row">
                    <table class="table table-bordered" id="userToApplyTable">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Usuário</th>
                                <th>Username</th>
                                <th>Matrícula</th>
                                <th>Monitorias neste Mês</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!is_int($usersFiltering))
                                @forelse($usersFiltering as $item)
                                    <tr id="">
                                        <td>
                                            <input onchange="selectUserToApply()" type="radio" name="userToApply" required="true" id="userToApply" class="icheck" value="{{$item->id}}">
                                        </td>
                                        <td>
                                            {{strtoupper($item->name)}}
                                        </td>
                                        <td>
                                            {{strtoupper($item->username)}}
                                        </td>
                                        <td>
                                            {{$item->matricula}}
                                        </td>
                                        <td>
                                            {{$item->ocorrencias}}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center"  value="0">Nenhum usuário encontrado</td>
                                    </tr>
                                @endforelse
                            @endif
                        </tbody>
                    </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" id="userToApplyBtn" disabled="true">Aplicar</button>
                </div>
            </div>
        </div>
    </div>
</form>
