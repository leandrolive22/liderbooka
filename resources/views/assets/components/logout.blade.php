<div class="message-box animated fadeIn" id="mb-signout">
    <div class="mb-container">
        <div class="mb-middle">
            <div class="mb-title"><span class="fa fa-sign-out"></span> Log <strong>Out</strong> ?</div>
            <div class="mb-content">
                <p>Tem Certeza que quer Sair?</p>
            </div>
            <div class="mb-footer">
                <div class="pull-right">
                    <form method="post" id="logOutForm" action="{{ route('logout') }}">
                        @csrf
                    </form>
                    <a class="btn btn-success btn-lg" id="logOutbtn">Sim</a>
                    <a class="btn btn-secondary btn-lg" id="closeLogOut">Não</a>
                </div>
            </div>
        </div>
    </div>
</div>

@section('logout')
    <script type="text/javascript" id="logOutJS">
        $('#closeLogOut').click(function () {
            $('#mb-signout').attr('class','message-box animated fadeIn')
        })
        $("#mb-signoutBTN").click(function () {
            $('#mb-signout').attr('class','message-box animated fadeIn open')
        })
        $('#logOutbtn').click(function(){
            $(this).attr('disabled',true)
            $.ajax({
                url: "{{ route('logLogOut',['user' => Auth::user()->id, 'ilha' => Auth::user()->ilha_id ]) }}",
                method: 'POST',
                data: {page: "{{Request::url()}}"},
                success: function () {
                    $("#logOutForm").submit()
                    $(this).attr('disabled',false)
                },
                error: function (xhr,status) {
                    console.log(xhr);
                    $(this).attr('disabled',false)
                    $("#mb-signout").attr('class','me animated fadeIn')
                    if(status == 429 || xhr.status == 429)
                    noty({
                        text: 'Erro! Aguarde alguns instantes para tentar novamente',
                        layout: 'topRight',
                        type: 'error',
                        timeout: 300
                    })
                }
            })
           
        })
    </script>
@endsection
