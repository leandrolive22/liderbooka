<div  class="page-sidebar mCustomScrollbar _mCS_1 mCS-autoHide page-sidebar-fixed scroll">
    <!-- START X-NAVIGATION -->
    <ul  class="x-navigation" >
        <li  class="xn-logo">
            <a href="{{ asset('/home') }}" style='width:100%;  text-align:center; padding:0%;'>
                @if(Auth::user()->css == 'white')
                <img src='{{ asset('img/logo-lcinza.png') }}' alt='Logo Branco - Liderança' id="logoMenu">
                @else
                <img src='{{ asset('img/logo-topo21-white_pqno.png') }}' alt='Logo Preto - Liderança' id="logoMenu">
                @endif
            </a>
        </li>
        <li class="xn-profile">
            <a class="profile-mini" href="{{ asset('profile/'.base64_encode(Auth::user()->id) ) }}">
                <img src="{{ asset(Auth::user()->avatar) }}" alt="{{ Auth::user()->username }}"/>
            </a>
            <div class="profile">
                <div class="profile-image">
                    <img src="{{ asset(Auth::user()->avatar) }}" alt=""/>
                </div>
                <div class="profile-data">
                    <div class="profile-data-name">{{ Auth::user()->name }}</div>
                    <div class="profile-data-title" id="cargoScript"></div>
                    {{-- Edita Ilhas --}}
                    @if (!in_array(Auth::user()->cargo_id,[4,5]))
                    <div class="profile-data-title" id="editIsland" style="display:none">
                        <form action="{{ route('PostEditIlha', ['id' => Auth::id()] ) }}" method="POST">
                            @csrf
                            <label for="form-label">Alterar Ilha</label>
                            <select name="ilha_id" id="ilha_idEdit" class="form-control"></select>
                            <button class="btn-xs btn btn-primary">Salvar</button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </li>
        <li class="xn-title">Menu de Navegação</li>
        <li @if($current == 'home') class="active"@else @endif>
            <a href="{{ asset('/home') }}">
                <span class="fa fa-home"></span>
                <span class="xn-text">Home Page</span>
            </a>
        </li>
        @if(in_array(Auth::user()->cargo_id,[1,2,3,7,9,15,21]) || in_array(Auth::id(),[37,1711,1712,1746]) /*Medidas disciplinares*/)
        <li @if($current == 'adm') class="active"@else @endif>
            <a href="{{ asset('/gerenciamento') }}">
                <span class="fa fa-cogs"></span>
                <span class="xn-text">Administração </span>
            </a>
        </li>
        @else
        @endif
        @if(in_array(Auth::user()->cargo_id,[1,4,15]) )
        <li @if($current == 'monitor') class="active" @else @endif>
            <div class="informer informer-danger text-danger" id="monitoriaMenuBtn"></div>
            <a href="{{asset('monitoring/manager')}}">
                <span class="fa fa-check-square-o"></span>
                <span class="xn-text">Monitoria</span>
            </a>
        </li>
        @endif
        @if(in_array(Auth::user()->id,[37]))
        <li @if($current == 'tabulador') class="active" @endif>
            @php
                if(in_array(Auth::user()->cargo_id,[1,15])) {

                    $link = 'GetTabsBackOffice';
                }
                elseif(in_array(Auth::user()->cargo_id,[4])) {
                    $link = 'GetTabsSupervisor';
                }
                elseif(in_array(Auth::user()->cargo_id,[5])) {
                    $link = 'GetTabsOperador';
                }
            @endphp
            <a href="{{route($link)}}">
                <span class="fa fa-dot-circle-o"></span>
                <span class="xn-text">LiderTab (MD)</span>
            </a>
        </li>
        @endif
        {{-- Para todos  --}}
        <li @if($current == 'profile') class="active"@else @endif>
            <a href="{{route('GetUserProfile',['id' => base64_encode(Auth::user()->id)])}}">
                <span class="fa fa-user"></span>
                <span class="xn-text">Perfil</span>
            </a>
        </li>
        <li @if($current == 'msgs') class="active"@else @endif>
            @if(in_array(Auth::user()->cargo_id,[5,11,12,13,14]))
            <a href="{{route('GetUsersMsgOpe')}}"id="MessagesTaskBtnMenu">
            {{-- MSG OPERATOR  --}}
            @elseif(in_array(Auth::user()->cargo_id,[7]))
            <a href="{{route('GetUsersMsgCoord')}}"id="MessagesTaskBtnMenu">
            {{-- MSG COORD --}}
            @elseif(in_array(Auth::user()->cargo_id,[1,2,9]))
            <a href="{{route('GetUsersMsgAdm')}}"id="MessagesTaskBtnMenu">
            {{-- MSG ADM  --}}
            @elseif(in_array(Auth::user()->cargo_id,[4]) || Auth::user()->ilha_id == 48)
            <a href="{{route('GetUsersMsgSup')}}"id="MessagesTaskBtnMenu">
            {{-- MSG SUPERVISOR  --}}
            @elseif(in_array(Auth::user()->cargo_id,[10,18,19,8,6,8]))
            <a href="{{route('GetUsersMsgOpeSup')}}"id="MessagesTaskBtnMenu">
            {{-- MSG ANOTHERS  --}}
            @elseif(in_array(Auth::user()->cargo_id,[3]))
            <a href="{{route('GetUsersMsgTraining')}}"id="MessagesTaskBtnMenu">
            {{-- MSG TRAINING  --}}
            @elseif(in_array(Auth::user()->cargo_id,[15]))
            <a href="{{route('GetUsersMsgMonit')}}" id="MessagesTaskBtnMenu">
            {{-- MSG Monitor  --}}
            @else
            <a href="{{route('GetUsersMsgOpe')}}"id="MessagesTaskBtnMenu">
                {{-- MSG ELSE  --}}
                @endif
                <span class="fa fa-comments"></span>
                <span class="xn-text">Chat<strong>Book</strong></span>
            </a>
        </li>
        <li @if($current == 'quiz') class="active" @else @endif>
            <a href="{{ route('GetQuizIndex',[ 'ilha' => Auth::user()->ilha_id, 'id' => Auth::id(), 'skip' => 0 ]) }}">
                <span class="fa fa-gamepad"></span>
                <span class="xn-text">Quizzes</span>
            </a>
        </li>
        <li @if($current == 'wiki') class="active"@else @endif>
            <a href="{{ asset('wiki/' . Auth::user()->ilha_id) }}">
                <span class="fa fa-bar-chart-o"></span>
                <span class="xn-text">Wiki</span>
            </a>
        </li>
        <li @if($current == '') class="active"@else @endif>
            <a href="{{route('Faq')}}">
                <span class="fa fa-question-circle"></span>
                <span class="xn-text">FAQ</span>
            </a>
        </li>
        <li @if($current == '') class="active"@else @endif>
            <a href="https://suporte.ativy.com">
                <span class="fa fa-envelope-o"></span>
                <span >Suporte</span>
            </a>
        </li>
    </ul>
    <!-- END X-NAVIGATION -->
</div>

@section('menuJs')
<script type="text/javascript">
    $("#formTransferLogin > a").click(function(){
        $.ajax({
            type: "POST",
            url: $("#formTransferLogin").attr('action'),
            data: $("#formTransferLogin").serialize(),
            dataType: "application/json",
            success: function (response) {
                console.log(response)
            },
            error: function (xhr, status) {
                console.log(xhr)
                alert(status)
            }
        });
    });

    setTimeout(() => {
        $.getJSON("{{route('getIlhasEditBySetor', ['setor' => Auth::user()->setor_id] )}}", function(data) {
            if(data.lenght > 0) {
                linhas = ''
                for(i=0; i<data.lenght; i++) {
                    linhas += '<option value="'+data.id+'">'+data.setor+' | '+data.name+'</option>'
                }

                $("select#ilha_idEdit").html(linhas)
                $("div#editIsland").show()
            }
        });
    },5000);
</script>
@endsection
