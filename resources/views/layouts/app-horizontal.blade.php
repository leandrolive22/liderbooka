<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <link rel="icon" href="{{ asset('img/favicon.png') }}" type="image/x-icon" />
    @include('assets.title.title')
    @include('assets.meta')
    @include('assets.css.app')
    @if(Auth::check())
    @include("assets.css.".Auth::user()->css)
    @else
    @include("assets.css.default")
    @endif
    @include('assets.css.scroll')
</head>

@hasSection('modal')
@yield('modal')
@endif

<body>
    {{-- <div class="d-flex justify-content-center" id="preLoaderApp">
        <div class="spinner-grow" role="status" style="width: 10rem; height: 10rem; margin-top: 20%; margin-bottom: 20%;">
            <span class="sr-only">Loading...</span>
        </div>
    </div> --}}
    <div class="page-container page-navigation-top" id="app" style="display:;">
        @yield('content')
    </div>



@component('assets.components.alert')
@endcomponent
@component('assets.components.logout')
@endcomponent

@include('assets.js.jQueryJoli') <!-- jQuery JS -->
<script type="text/javascript" src="{{ asset('js/jquery.maskedinput-1.1.4.pack.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/plugins.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/actions.js') }}"></script>
<script type='text/javascript' src="{{ asset('js/plugins/icheck/icheck.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/plugins/bootstrap/bootstrap-datepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/plugins/bootstrap/bootstrap-timepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/plugins/bootstrap/bootstrap-select.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/plugins/push/bin/push.js') }}"></script>

{{-- alerts noty  --}}
@include('assets.js.alerts')

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function carregarCargo(id) {
        $.getJSON('{{ route('GetCargoData', [ 'id' => Auth::user()->cargo_id ])  }}', function(data){
            for(i = 0; i < 1; i++) {
                $('#cargoScript').append(data.description);
                $('#cargoScript2').append(data.description);
            }
        });
    }

    $(document).ready(function(){
        carregarCargo( {{Auth::user()->cargo_id}} );

    });
    $(window).on('load',function(){

        $("#preLoaderApp").remove()
        $("#app").show()
    });

</script>
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-157308339-1"></script>
<script async src="{{asset('js/plugins/googleAnalitics.js')}}"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());

    gtag('config', 'UA-157308339-1');
</script>

@hasSection('Javascript')
    @yield('Javascript')
@endif

@hasSection('logout')
    @yield('logout')
@endif

</body>
</html>











