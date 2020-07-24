<!-- START X-NAVIGATION VERTICAL -->
<ul class="x-navigation x-navigation-horizontal x-navigation-panel">
    <!-- SIGN OUT -->

    <li class="xn-icon-button pull-right">
        <a class="mb-control" id="mb-signoutBTN"><span class="fa fa-sign-out"></span></a>
    </li>

    <!-- END SIGN OUT -->
    <!-- TOGGLE NAVIGATION -->
    <li class="xn-logo">
        <a href="{{ asset('/home') }}" style='width:100%;  text-align:center; padding:0%;'>
            @if(Auth::user()->css == 'white')
            <img src='{{ asset('img/logo-lcinza.png') }}' alt='Logo Branco - Liderança' id="logoMenu" style='max-width:15%;'>
            @else
            <img src='{{ asset('img/logo-topo21-white_pqno.png') }}' alt='Logo Preto - Liderança' style='max-width:45%;'>
            @endif
        </a>
    </li>
    <li class="xn-openable pull-right">
        <a href="{{ asset('/home') }}">
            <span class="fa fa-home"></span>
            <span class="xn-text @if(Auth::user()->css == 'white') text-dark @endif">Home</span>
        </a>
    </li>
    <li class="xn-openable pull-right">
        <a href="{{ route('GetQuizIndex',[ 'ilha' => Auth::user()->ilha_id, 'id' => Auth::id(), 'skip' => 0, 'take' => 20 ]) }}">
            <span class="fa fa-reply"></span>
            <span class="xn-text @if(Auth::user()->css == 'white') text-dark @endif">Quizzes</span>
        </a>
    </li>
    <!-- END TOGGLE NAVIGATION -->
<!-- END X-NAVIGATION VERTICAL -->