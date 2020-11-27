<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <link rel="icon" href="{{ asset('img/bookLogo.png') }}" type="image/x-icon" />

    @include('assets.title.title')
    @include('assets.meta')
    @if (!isset($wiki))
        @include('assets.css.app')
    @endif
    @if(Auth::check())
        @include("assets.css.".Auth::user()->css)
    @else
        @include("assets.css.default")
    @endif
    @hasSection ('style')
        @yield('style')
    @endif
    @hasSection ('css')
        @yield('css')
    @endif
    @include('assets.css.scroll')

    @if(Auth::user()->css === 'black')
    <style type="text/css">
    body {
        text-color: #ffffff;
    }
    </style>
    @endif

    <style type="text/css">
        .myParagraph{
            min-height: 20px;
            padding: 2px;
            border: solid 0.5px gray;
            border-radius: 5px;
        }

        .label-group {
            margin:0;
        }
    </style>

</head>
@hasSection ('modal')
    @yield('modal')
@endif

@hasSection ('modalMoni')
    @yield('modalAll')
@endif

@hasSection ('modalAll')
    @yield('modalAll')
@endif

<body>
    @hasSection('basicDatatableExcel')
        @yield('basicDatatableExcel')
    @endif
    <div class="page-container page-navigation-top-fixed" style="max-height: 100%" id="app">
        <input type="hidden" name="hasMonitoria" id="hasMonitoria">
        <input type="hidden" name="hasContestacoes" id="hasContestacoes">
        <!-- MENU -->
        @if(!isset($lgpd))
        @component('assets.components.menu',["current"=>$current ])
        @endcomponent
        @endif
        <!-- /MENU -->

        {{-- Conteúdo  --}}
            @yield('content')
        {{-- /Conteúdo  --}}
    </div>
    @component('assets.components.logout')
    @endcomponent

    <!-- Conta mensagens para não mostrar notificações à toda hora  -->
    <input type="hidden" name="msgNotIptHidden" id="msgNotIptHidden" value="0">

    @include('assets.js.jQueryJoli')
    <!-- jQuery JS -->
    <script type='text/javascript' src="{{ asset('js/plugins/icheck/icheck.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js') }}">
    </script>
    <script type="text/javascript" src="{{ asset('js/jquery.maskedinput-1.1.4.pack.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/actions.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/bootstrap/bootstrap-datepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/bootstrap/bootstrap-timepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/bootstrap/bootstrap-select.js') }}"></script>

    {{-- alerts noty  --}}
    @include('assets.js.alerts')

    @hasSection('PostsScript')
        @yield('PostsScript')
    @endif

    @hasSection('Javascript')
        @yield('Javascript')
    @endif

    @hasSection('xNavJs')
        @yield('xNavJs')
    @endif

    @hasSection('logout')
        @yield('logout')
    @endif

    @hasSection('msg')
        @yield('msg')
    @endif

    @hasSection('assinatura')
        @yield('assinatura')
    @endif

    @hasSection('wikiCount')
        @yield('wikiCount')
    @endif

    @hasSection ('ChartsUpdates')
        @yield('ChartsUpdates')
    @endif

    @hasSection ('Exports')
        @yield('Exports')
    @endif

    @hasSection('menuJs')
        @yield('menuJs')
    @endif

    @hasSection('JavascriptSearchWiki')
        @yield('JavascriptSearchWiki')
    @endif

    {{-- Medidas Disciplinares  --}}
    @include('gerenciamento.measures.view')

    <script type="text/javascript" id="AppJs">
        $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // coloca link em Hashtag
    function hashtag(text){
        try {
            var repl = text.replace(/#(\w+)/g, '<a href="javascript:clickTag('+"'$1'"+')">#$1</a>');
            return repl;
        } catch (e) {
            console.log(e)
        }
    }

    // coloca link em texto plano
    function createTextLinks_(text) {

      return (text || "").replace(
        /([^\S]|^)(((https?\:\/\/)|(www\.))(\S+))/gi,
        function(match, space, url){
          var hyperlink = url;
          if (!hyperlink.match('^https?:\/\/')) {
            hyperlink = 'http://' + hyperlink;
          }

          newUrl = url.split('/')[0]+'//'+url.split('/')[2]
          return space + '<a target="_blank" onclick="clickLink('+"'"+hyperlink+"'"+')" href="' + hyperlink + '">' + newUrl + '...</a>';
        }
      );
    };

    //Pesquisa tudo o que possui a mesma HashTag
    function clickTag(tag) {
        $.ajax({
            url: "{{ route('PostLogsClickTag') }}",
            data: "ilha={{Auth::user()->ilha_id}}&user={{Auth::id()}}&page={{ Request::url() }}&tag="+tag,
            method: 'POST',
            error: function(xhr) {
                console.log(xhr)
            }
        })
    }

    // Salva cliques no link
    function clickLink(url) {
        $.ajax({
            url: "{{ route('PostLogsClicklink') }}",
            data: "ilha={{Auth::user()->ilha_id}}&user={{Auth::id()}}&page={{ Request::url() }}&url="+url,
            method: 'POST',
            error: function(xhr) {
                console.log(xhr)
            }
        })
    }

    // Notificações Push
    function pushNoty(title,body,link) {
        if (!window.Notification) {
            console.log('Browser does not support notifications.');
        } else {
            // check if permission is already granted
            if (Notification.permission === 'granted') {
                // show notification here
                var notify = new Notification(title, {
                    body: body,
                    icon: "{{ asset('img/favicon.png') }}",
                    onclick: function() {
                        window.open(link)
                    }
                });
            } else {
                // request permission from user
                Notification.requestPermission().then(function (p) {
                    if (p === 'granted') {
                        // show notification here
                        var notify = new Notification(title, {
                            body  : body,
                            icon  : "{{ asset('img/favicon.png') }}",
                            click : function(){
                                window.open(link)
                            }
                        });
                    } else {
                        console.log('User blocked notifications.');
                    }
                }).catch(function (err) {
                    console.error(err);
                });
            }
        }
    }



    function carregarCargo(id) {
        $.getJSON('{{ route('GetCargoData', [ 'id' => Auth::user()->cargo_id ])  }}', function(data){
            for(i = 0; i < 1; i++) {
                $('#cargoScript').append(data.description);
                $('#cargoScript2').append(data.description);
            }
        });
    }


    // grava reação de humor diario no banco`
    function saveHumour(reaction_number) {
        $.ajax({
            type: "GET",
            url: "{{asset('/')}}api/reaction/humour/"+reaction_number+"/{{ Auth::user()->id }}/{{ Auth::user()->ilha_id }}",
            success: function() {
                $("#feedbackHumour").show();
                $("#time").hide();
                feedback
            },
            error: function(xhr) {
                alert(xhr.status)
                console.log(xhr)
            }
        })
    }

    var feedback = setTimeout(function(){
        $("#feedbackHumour").hide()
        $("#time").show()
    },20000)

    function deletePhone(id) {
        $.ajax({
            type: "DELETE",
            url: "{{ asset('api/phone/delete/' . Auth::user()->id . '/' . Auth::user()->ilha_id) }}/" + id,
            success: function (response) {
                noty({
                    text: 'Telefone excluído com sucesso!',
                    layout: 'topRight',
                    type: 'success',
                    timeout: '3000',
                })
                $("#phone"+id).hide()
                $("#phone"+id).remove()
            },
            error: function (xhr,status) {
                noty({
                    text: 'Erro ao excluir telefone (' + xhr.status + ')',
                    layout: 'topRight',
                    type: 'error',
                    timeOut: '3000',
                })
                console.log(xhr)
            }
        });
    }

    function in_array(val, arr = ['',' ',null,undefined,'undefined']) {
        if($.inArray(val,arr) > -1) {
            return true
        }

        return false
    }

    // Grava feedback de Monitoria junto ao opeador (escobs)
    function feedbackMonitoringEscobs() {
        monitoria_id = $("#idModal").val()
        passwd = $("input#passwdEscobs").val()
        feedback = $("textarea#feedback_operador").val()
        url = "{{ route('MonitFeedBackEscobs', ['id' => '-99999999']) }}".replace('-99999999',monitoria_id)
        method = 'PUT'
        data = "feedback="+feedback+"&passwd="+passwd+"&monitoria_id="+monitoria_id

        if($.inArray(feedback,['',' ',null,undefined,'undefined']) === -1 && $.inArray(passwd, ['',' ',null,undefined,'undefined']) === -1) {
            $.ajax({
                url: url,
                method: method,
                data: data,
                success: function(xhr) {
                    // Exibe mensagem
                    noty({
                        text: xhr.successAlert,
                        layout: 'topRight',
                        type: 'success'
                    })

                    $("textarea#feedback_operador").prop('style','border-color: green')
                },
                error: function(xhr) {
                    // Trata mensagens de retorno
                    if(typeof xhr.responseJSON.errorAlert !== 'undefined'){
                        msg = xhr.responseJSON.errorAlert
                    } else if(typeof xhr.responseJSON !== 'undefined') {
                        if(typeof xhr.responseJSON.message !== 'undefined') {
                            msg = xhr.responseJSON.message
                        }
                        if(typeof xhr.responseJSON.errors !== 'undefined') {
                            $.each(xhr.responseJSON.errors, (i,v) => {
                                noty({
                                    text: v,
                                    layout: 'topRight',
                                    type: 'error'
                                })
                            })
                        }
                    } else if(typeof xhr.responseJSON.warningAlert !== 'undefined') {
                        msg = xhr.responseJSON.warningAlert
                    }

                    // Exibe mensagem
                    noty({
                        text: msg,
                        layout: 'topRight',
                        type: 'error'
                    })
                }
            })
        }
    }

    // Transforma Data em Data Br
    function dataBr(dataEn) {
        data = dataEn.split(' ')
        data2 = data[0].split('-')
        data3 = data2.reverse()
        data4 = data3.join('/')

        return data4+' '+data[1]
    }

    // contesta monitoria
    function contestar() {
        data = {
            monitoria_id: $("#idModal").val(),
            motivo_id: $("#contestarSelect").val(),
            obs: $("#contestarTextarea").val()
        }

        $.ajax({
            type: "POST",
            url: $("#form_constestar").prop('action'),
            data: data,
            dataType: 'json',
            success: function (response) {
                msg = response.successAlert
                noty({
                    text: msg,
                    type: 'success',
                    layout: 'topRight'
                })
            },
            error: function(xhr) {
                console.log(xhr)
                try {
                    // Trata mensagens de retorno
                    if(typeof xhr.responseJSON.errorAlert !== 'undefined'){
                            msg = xhr.responseJSON.errorAlert
                        } else if(typeof xhr.responseJSON !== 'undefined') {
                            if(typeof xhr.responseJSON.message !== 'undefined') {
                                msg = xhr.responseJSON.message
                            }
                            if(typeof xhr.responseJSON.errors !== 'undefined') {
                                $.each(xhr.responseJSON.errors, (i,v) => {
                                    noty({
                                        text: v,
                                        layout: 'topRight',
                                        type: 'error'
                                    })
                                })
                            }
                        } else if(typeof xhr.responseJSON.warningAlert !== 'undefined') {
                            msg = xhr.responseJSON.warningAlert
                        }

                        // Exibe mensagem
                        noty({
                            text: msg,
                            layout: 'topRight',
                            type: 'error'
                        })
                } catch (error) {
                    // Exibe mensagem
                    noty({
                        text: 'Erro ao contestar',
                        layout: 'topRight',
                        type: 'error'
                    })
                    console.log(error)
                }

            }
        });
    }

    function checkContestacoes(){
        $.ajax({
            type: "GET",
            url: "{{route('GetContestacaoCheck')}}",
            success: function(response) {
                if(response > 0) {
                    $("#monitoriaMenuBtn").html('.')
                    $("#notifyContestacao").show()
                    $("#hasContestacoes").val(1)
                } else {
                    if($("#hasMonitoria").val() == 0) {
                        $("#monitoriaMenuBtn").html('')
                    }
                    $("#notifyContestacao").hide()
                    $("#hasContestacoes").val(0)
                }
            },
            error: function(xhr) {
                console.log(xhr)
            }
        });
    }

    @include('assets.components.notify');

    $(() => {
        @if(in_array(Auth::user()->cargo_id,[4,15,7,2,9]) || in_array(66, Session::get('permissionsIds')))
        checkContestacoes()
        @endif
    })

    </script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-157308339-1"></script>
    <script async src="{{asset('js/plugins/googleAnalitics.js')}}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-157308339-1');
    </script>

</body>

</html>
