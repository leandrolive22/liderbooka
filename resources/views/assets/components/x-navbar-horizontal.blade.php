<!-- START X-NAVIGATION VERTICAL -->
<ul class="x-navigation x-navigation-horizontal x-navigation-panel">
    <!-- TOGGLE NAVIGATION -->
    <li class="xn-logo">
        <a href="{{ asset('/home') }}" style='width:100%;  text-align:center; padding:0%;'>
            <img src='{{ asset('img/logo-topo21-white_pqno.png') }}' alt='Logo Liderança' style='width:45%;'>
        </a>
    </li>
    <li class="xn-openable">
        <a href="{{ asset('/home') }}"><span class="fa fa-home"></span><span class="xn-text">Home Page</span></a>
    </li>
    <li class="xn-openable">
        <a href="/gerenciamento">
            <span class="fa fa-cogs"></span>
            Administração
        </a>
    </li>
    <li class="xn-openable">
        <a href="{{ route('GetQuizIndex') }}">
            <span class="fa fa-gamepad"></span>
            Quizzes
        </a>
    </li>
    <!-- END TOGGLE NAVIGATION -->
    <!-- SIGN OUT -->

    <li class="xn-icon-button pull-right">
        <a class="mb-control" id="mb-signoutBTN"><span class="fa fa-sign-out"></span></a>
    </li>


    <!-- END SIGN OUT -->
    <!-- MESSAGES -->
    <li class="xn-icon-button pull-right" id="MessagesTaskDiv">

        @if(in_array(Auth::user()->cargo_id,[5,11,12,13,14]))
        <a href="{{route('GetUsersMsgOpe')}}" id="MessagesTaskBtn">
            {{-- MSG OPERATOR  --}}
            @elseif(in_array(Auth::user()->cargo_id,[7]))
            <a href="{{route('GetUsersMsgCoord')}}" id="MessagesTaskBtn">
                {{-- MSG COORD --}}
                @elseif(in_array(Auth::user()->cargo_id,[1,2,9]))
                <a href="{{route('GetUsersMsgAdm')}}" id="MessagesTaskBtn">
                    {{-- MSG ADM  --}}
                    @elseif(in_array(Auth::user()->cargo_id,[4]))
                    <a href="{{route('GetUsersMsgSup')}}" id="MessagesTaskBtn">
                        {{-- MSG SUPERVISOR  --}}
                        @elseif(in_array(Auth::user()->cargo_id,[10,18,19,8,6,8]))
                        <a href="{{route('GetUsersMsgOpeSup')}}" id="MessagesTaskBtn">
                            {{-- MSG ANOTHERS  --}}
                            @elseif(in_array(Auth::user()->cargo_id,[3]))
                            <a href="{{route('GetUsersMsgTraining')}}" id="MessagesTaskBtn">
                                {{-- MSG TRAINING  --}}
                                @elseif(in_array(Auth::user()->cargo_id,[15]))
                                <a href="{{route('GetUsersMsgMonit')}}" id="MessagesTaskBtn">
                                    {{-- MSG Monitor  --}}
                                    @else
                                    <a href="{{route('GetUsersMsgOpe')}}" id="MessagesTaskBtn">
                                        {{-- MSG ELSE  --}}
                                        @endif
                                        <span class="fa fa-comments"></span>
                                    </a>
                                </li>
                                <!-- END MESSAGES -->
                            </ul>
<!-- END X-NAVIGATION VERTICAL -->