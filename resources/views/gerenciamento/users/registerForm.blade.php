<div class="col-md-12" id="registerFormDiv">
    <div class="panel panel-secondary">
        <div class="panel-body">
            <h3 class="panel-title"><b>Registrar usuário</b></h3>
            <div class="form-group col-md-12">
                <form role="form" id="createUserForm">
                    @csrf
                    <div class="form-group col-md-12">
                        <label class="col-md-2 control-label">Nome</label>
                        <input class="form-control col-md-8" id="name" name="name">
                    </div>
                    <div class="form-group col-md-12">
                        <label class="col-md-2 control-label">Username</label>
                        <input class="form-control col-md-8" id="username" name="username">
                        <label for="username" class="text-muted" style="font-size:10px; margin-left:18%;">*A Senha padrão é: 3 primeiros digitos do CPF + Primeiro nome com a primeira letra maiúscula</label>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="col-md-2 control-label">CPF</label>
                        <input type="text" class="form-control col-md-8" maxlength="14" id="cpf" name="cpf">
                    </div>
                    <div class="form-group col-md-12">
                        <label class="col-md-2 control-label">Carteira</label>
                        <select class="form-control col-md-8" name="carteira_id" id="carteira_id" onchange="getSetores(this);$('#setor_idDiv').show()">
                            <option>Selecione uma Carteira</option>
                        @foreach($carteiras as $carteira)
                            <option value="{{ $carteira->id }}">{{ $carteira->name }}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-12" style="display:none" id="setor_idDiv">
                        <label class="col-md-2 control-label">Setor</label>
                        <select class="form-control col-md-8" name="setor_id" id="setor_id" onchange="getIlhas(this);$('#ilhaDiv').show()">
                            <option id="noMoreSetor">Nenhum Setor Encontrado</option>

                        </select>
                    </div>
                    <div class="form-group col-md-12" id='ilhaDiv' style="display:none;">
                        <label class="col-md-2 control-label">Ilha</label>
                        <select class="form-control col-md-8" name="ilha_id" id="ilha_id" onchange="$('#cargoDiv').show()">
                            <option id="noMoreI">Nenhuma Ilha Encontrada</option>
                        </select>
                    </div>
                    <div class="form-group col-md-12" id='cargoDiv' style="display:none;">
                        <label class="col-md-2 control-label">Cargo</label>
                        <select class="form-control col-md-8" name="cargo_id" id="cargo_id" onchange="getSup();$('#supDiv').show()">
                                <option>Selecione um Cargo</option>
                            @forelse ($cargos as $cargo)
                                <option value="{{$cargo->id}}">{{$cargo->description}}</option>
                            @empty
                                <option>Nenhum Cargo Encontrado</option>
                            @endforelse
                        </select>
                    </div>
                    <input type="hidden" name="carteira_id" value="1">
                    <div class="form-group col-md-12" id='supDiv' style="display:none;">
                        <label class="col-md-2 control-label">Superior</label>
                        <select class="form-control col-md-8" name="superior_id" id="superior_id">
                            <option id="noMoreSup">Selecione um Superior</option>
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <button type="button" id="sendUserBtn" class="btn btn-primary col-md-12">Salvar</button>
                    </div>
                    <input type="hidden" name="id" value="{{Auth::user()->id}}">
                </form>
            </div>
        </div>
    </div>
</div>
@section('Javascript')
    <script type="text/javascript">
        $('#sendUserBtn').click(function() {

            var dados = $('#createUserForm').serialize();
            console.log(dados)

            $.ajax({
                type: "POST",
                url: "{{ route('PostUsersStore', ['id' =>Auth::user()->id]) }}",
                data: dados,
                success: function( xhr,status )
                {
                    $("#name").val('')
                    $("#username").val('')
                    $("#cpf").val('')
                    $("#ilha_id").val('')
                    $("#cargo_id").val('')
                    $("#carteira_id").val('')

                    noty({
                        text: "{{ __('Usuário registrado com sucesso!') }}",
                        layout: 'topRight',
                        type: 'success',
                        timeout: '3000'
                    })

                },
                error: function(xhr,error,status) {
                    noty({
                        text: 'Não foi possível registrar usuário, tente novamente mais tarde.<br>'+
                        'se o erro persistir, contate o suporte. (error: '+xhr.status+')',
                        layout: 'topRight',
                        type: 'error',
                        timeout: '3000'
                    })
                    console.log(xhr);
                }
            });


        });

       function ModalBtnmodal(id){
            $("#message-box"+id).hide()
        };

        $('#cargo').change(function(){
            var cargo = $("#cargo").val();
            var ilha = $("#ilha").val();
             $.getJSON('api/forms/superiores/'+cargo+'/'+ilha, function(data) {
                console.log(data)
                for(i=0; i< data.length; i++) {
                    alert(data[i])
                    linha = "<option value='"+data[i].id+"'>"+data[i].name+"</option>";
                    $("#superior").append(linha);
                }
             })
        })

        function getIlhas(setor_id){
            $.getJSON('{{ asset("api/data/") }}/'+setor_id.value+'/ilha', function(ilha){

                l = ilha.length;
                if(l > 0) {
                    linha = '<option>Selecione a Ilha</option>'
                    for(i=0; i< l; i++) {
                        linha += '<option value="'+ilha[i].id+'">'+ilha[i].name+'</option>'
                    }
                    $("#noMoreI").hide();
                    $("#ilha_id").html(linha)
                } else {
                    option = '<option id="noMoreI">Nenhum Ilha Encontrada</option>'
                    $("#ilha_id").html(option)
                }
            });
        }

        function getSetores(element) {
            $.getJSON('{{ asset("api/data/setores/json/byCarteira/") }}/'+element.value,function(data){
                l = data.length;
                if(l > 0) {
                    linha = '<option>Selecione o Setor</option>'
                    for(i=0; i<l; i++) {
                        linha += '<option value="'+data[i].id+'">'+data[i].name+'</option>'
                    }
                    $("#noMoreSetor").hide();
                    $("#setor_id").html(linha)
                }
            });
        }

        function getSup(){
            cargo_id = $("#cargo_id").val();
            ilha_id = $("#ilha_id").val();

            $.getJSON('{{ asset("api/data/superior/list") }}/'+ilha_id+'/'+cargo_id, function(ilha){

                l = ilha.length;
                console.log(l)
                if(l > 0) {
                    linha = '<option>Selecione o Superior</option>'
                    for(i=0; i< l; i++) {
                        linha += '<option value="'+ilha[i].id+'">'+ilha[i].name+'</option>'
                    }
                    $("#noMoreSup").hide();
                    $("#superior_id").html(linha)
                } else {
                    option = '<option id="noMoreSup" value="1">Nenhum Superior Encontrado, superior padrão adicionado</option>'
                    $("#superior_id").html(option)
                }
            });
        }

    </script>
<<<<<<< HEAD
@endsections

=======
@endsection
>>>>>>> 36abefa189dc82985c63044e4e7d08011368d59d
