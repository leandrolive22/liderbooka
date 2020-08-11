@php
// CHECA PERMISSÔES PARA MONTAR navBar
$permissions = session('permissionsIds');
$webMaster = in_array(1,$permissions);

//Medidas disciplinares
$medidas = 0;
foreach([13,14,15] AS $item) {
    if($webMaster) {
        $medidas++;
    } elseif(in_array($item,$permissions)) {
        $medidas++;
    }
}

//Ger. users
$usuario = 0;
foreach([34,35,36,37,45] AS $item) {
    if($webMaster) {
        $usuario++;
    } elseif(in_array($item,$permissions)) {
        $usuario++;
    }
}

// Monitoria
$monitoria = 0;
foreach([18,19,20,21,22,23,24,25,47,50,51,52,53,54,55] AS $item) {
    if($webMaster) {
        $monitoria++;
    } elseif(in_array($item,$permissions)) {
        $monitoria++;
    }
}

// Chat
$chat = 0;
foreach([6,7,8,9,10,11] AS $item) {
    if($webMaster) {
        $chat++;
    } elseif(in_array($item,$permissions)) {
        $chat++;
    }
}

// Quiz
$quiz = 0;
foreach([31,32,33,46] AS $item) {
    if($webMaster) {
        $quiz++;
    } elseif(in_array($item,$permissions)) {
        $quiz++;
    }
}

// Wiki
$wiki = 0;
foreach([38,39,40,41,42,43,44] AS $item) {
    if($webMaster) {
        $wiki++;
    } elseif(in_array($item,$permissions)) {
        $wiki++;
    }
}

// áreas
$area = 0;
$area_type = 0;
foreach([57,58] AS $item) {
    if($webMaster) {
        $area++;
    } elseif(in_array($item,$permissions)) {
        if($item === 58) {
            $area_type++;
        }
        $area++;
    }
}
@endphp
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
        @if($medidas > 0)
        <li @if($current == 'measures') class="active"@else @endif>
            <a href="{{ route('GetMeasuresIndex')}}">
                <span class="fa fa-exclamation"></span>
                <span class="xn-text">Medidas Disciplinares</span>
            </a>
        </li>
        @endif

        @if($area > 0)
        <li @if($current == 'adm') class="active"@else @endif>
            <a href="{{ route('GetAreasIndex', ['area_type' => $area_type])}}">
                <span class="fa fa-sitemap"></span>
                <span class="xn-text">Áreas</span>
            </a>
        </li>
        @endif

        @if($usuario > 0)
        <li @if($current == 'adm') class="active"@else @endif>
            <a href="{{ route('GetUsersManagerUser')}}">
                <span class="fa fa-users"></span>
                <span class="xn-text">Usuários</span>
            </a>
        </li>
        @endif
        @if($monitoria > 0)
        <li @if($current == 'monitor') class="active" @else @endif>
            <div class="informer informer-danger text-danger" id="monitoriaMenuBtn"></div>
            <a href="{{asset('monitoring/manager')}}" title="Monitoria">
                <span class="fa fa-check-square-o"></span>
                <span class="xn-text">Qualidade</span>
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
        @if($chat >0)
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
                <span class="xn-text">Chat</span>
            </a>
        </li>
        @endif
        @if($quiz > 0)
        <li @if($current == 'quiz') class="active" @else @endif>
            <a href="{{ route('GetQuizIndex',[ 'ilha' => Auth::user()->ilha_id, 'id' => Auth::id(), 'skip' => 0, 'take' => 20 ]) }}">
                <span class="fa fa-gamepad"></span>
                <span class="xn-text">Quiz</span>
            </a>
        </li>
        @endif
        @if($wiki > 0)
        <li @if($current == 'wiki') class="active"@else @endif>
            <a href="{{ asset('wiki/' . Auth::user()->ilha_id) }}">
                <span class="fa fa-bar-chart-o"></span>
                <span class="xn-text">Wiki</span>
            </a>
        </li>
        @endif
        <li @if($current == '') class="active"@else @endif>
            <a href="{{route('Faq')}}">
                <span class="fa fa-question-circle"></span>
                <span class="xn-text">FAQ</span>
            </a>
        </li>
        <li @if($current == '') class="active"@else @endif>
            <a href="https://suporte.ativy.com">
                <span class="fa fa-envelope-o"></span>
                <span class="xn-text">Suporte</span>
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
