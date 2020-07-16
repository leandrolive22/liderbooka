<!DOCTYPE html>
<html lang="pt-BR">
<head>
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

    // funçaõ para mostrar msg na navbar
    function getMsgNotify() {
        $.getJSON('{{ route('GetChatsNotify', [ 'id' => Auth::user()->id ])  }}', function(data) {
            if(data['n'] > 0) {
                $("#MsgNotifyX").remove();

                $("#msgVal").attr('value',data['n'])

                div = '<div class="informer informer-danger" id="MsgNotifyX">'+data['n']+'</div>';

                $("#MessagesTaskDiv").append(div);

                //pesquisa apenas quem enviou a msg e indica ao usuario, caso esteja dentro das view chat.*
                @if( in_array(Route::current()->getName(),['GetUsersMsgAdm','GetUsersMsgCoord','GetUsersMsgOpe','GetUsersMsgSup','GetUsersMsgTraining','GetUsersMsgOpeSup ','GetUsersMsgMonit']))
                    // Pesquisa novos contatos
                    newContacts()

                    //mostra icone de msgs
                    $.each(data['ids'],function(index, value){
                        msgNumber(value);
                    })
                @else
                @endif
                document.title = '('+data['n']+') Novas mensagens - LiderBook'
                pushNoty('ChatBook',"Você tem novas mensagens no ChatBook, Venha conferir!",$('#MessagesTaskBtn').attr('href'))


            } else {
                $("#msgVal").attr('value','0');
                $("#MsgNotifyX").remove();
                document.title = 'LiderBook 2.0 - {{ isset($title) ? $title : "Login" }}'
            }
        });
    }

    //Abre modal Calculadora
    //lista calculadoras ao clicar
    $("#CalculadoraTask").click(function() {
        $.getJSON('{{ route("GetMaterialsCalculadoras", ['ilha' => Auth::user()->ilha_id ])  }}',function(data){
            n = data.length;
            if(n > 0) {
                $("#calcXnav").remove()
                div = "<div id='calcXnav'>";
                calc = '';
                for(i=0; i< n; i++){
                    nameAspas = "'"+data[i].name+"'";
                    calc +=
                    '<div class="card">'+
                    '<a class="list-group-item" onCLick="window.open('{{ asset('api/download/calculator') }}/'+ data[i].id +'/{{ Auth::user()->id }}'','_blank');"  onclick="notifyCalculator('+nameAspas+')" >' +

                    '<span class="fa fa-paperclip"></span>'+
                    '<strong> ' + data[i].name + '</strong>' +
                    '</a>'+
                    '</div>';
                }
                div += calc + '</div>'
                $('#calculadoraJS').append(div);
            }
        })
    });

    $("#CalculadoraTask").click(function() {
        $.getJSON('{{ route("GetMaterialsCalculadoras", ['ilha' => Auth::user()->ilha_id ])  }}',function(data){
            n = data.length;
            if(n > 0) {
                $("#calcXnav").remove()
                div = "<div id='calcXnav'>";
                calc = '';
                for(i=0; i< n; i++){
                    nameAspas = "'"+data[i].name+"'";
                    calc +=
                    '<div class="card">'+
                    '<a class="list-group-item" onCLick="window.open('{{ asset('api/download/calculator') }}/'+ data[i].id +'/{{ Auth::user()->id }}'','_blank');"  onclick="notifyCalculator('+nameAspas+')" >' +
                    '<span class="fa fa-paperclip"></span>'+
                    '<strong> ' + data[i].name + '</strong>' +
                    '</a>'+
                    '</div>';
                }
                div += calc + '</div>'
                $('#calculadoraJS').append(div);
            }
        })
    });

    function myTimer() {
        var d = new Date();
        var t = d.toLocaleTimeString();
        $("#Clock").remove();
        clock = '<div id="Clock">'+t+'</div>';

        $("#myClock").append(clock);
    }

    var myVar = setInterval(myTimer, 1000);
    var msg = setInterval(getMsgNotify, 300000)

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











