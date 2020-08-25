@php
// CHECA PERMISSÔES PARA MONTAR navBar
$permissions = session('permissionsIds');
$webMaster = in_array(1,$permissions);

// Chat
$chat = 0;
foreach([6,7,8,9,10,11] AS $item) {
    if($webMaster) {
        $chat++;
    } elseif(in_array($item,$permissions)) {
        $chat++;
    }
}

// Calculadoras
$calculadora = 0;
foreach([2,3,4,5] AS $item) {
    if($webMaster) {
        $calculadora++;
    } elseif(in_array($item,$permissions)) {
        $calculadora++;
    }
}

// modulos
$modulo = 0;
foreach([16,17] AS $item) {
    if($webMaster) {
        $modulo++;
    } elseif(in_array($item,$permissions)) {
        $modulo++;
    }
}

// LiderReport
if(in_array(17, $permissions) || $webMaster) {
    $cargo = Auth::user()->cargo_id;

    // Area LiderReport
    if(in_array($cargo, [15])) {
        $area = 1;
        $nivel = 2;
    }
    if(in_array($cargo, [4,8,7])) {
        $area = '2';
        $nivel = 3;
    }
    if(in_array($cargo, [7,9,2])) {
        $area = 3;
        $nivel = 3;
    }
    if(in_array($cargo, [1])) {
        $area = '1;2;3;4';
        $nivel = 0;
    } else {
        $area = 0;
        $nivel = NULL;
    }

    $strEnc = implode("|", [Auth::id(),Auth::user()->name,Auth::user()->username,$nivel,$area,date("Y-m-d H:i:s")]);
    $password = date('Ymd');

    $hash = openssl_encrypt($strEnc,"AES-128-ECB",$password);
    
} else {
    $hash = NULL;
}

// Inserts Rápidos
$inserts = 0;
foreach([38, 34] AS $item) {
    if($webMaster) {
        $inserts++;
    } elseif(in_array($item,$permissions)) {
        $inserts++;
    }
}
@endphp
<!-- START X-NAVIGATION VERTICAL -->
<ul class="x-navigation x-navigation-horizontal x-navigation-panel">
    <!-- TOGGLE NAVIGATION -->
    <li class="xn-icon-button">
        <a href="#" class="x-navigation-minimize"><span class="fa fa-dedent"></span></a>
    </li>
    <!-- END TOGGLE NAVIGATION -->
    <!-- SIGN OUT -->

    <li class="xn-icon-button pull-right">
        <a class="mb-control" id="mb-signoutBTN"><span class="fa fa-sign-out"></span></a>
    </li>

    <!-- END SIGN OUT -->
    @if($chat > 0)
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
    @endif
    <!-- END MESSAGES -->
    <!-- TASKS -->
    {{-- Calculadoras  --}}
    @if($calculadora > 0)
    <li class="xn-icon-button pull-right">
        <a id="CalculadoraTask"><span class="fa fa-tasks"></span></a>
        <div class="panel panel-success animated zoomIn xn-drop-left ">
            <div class="panel-heading">
                <h3 class="panel-title"><span class="fa fa-tasks"></span> Calculadoras</h3>
            </div>
            <div class="panel-body list-group scroll" id='calculadoraJS'>

            </div>
        </div>
    </li>
    {{-- Telefones ùteis --}}
    <li class="xn-icon-button pull-right">
        <a id="getPhones">
            <span class="fa fa-phone"></span>
        </a>
        <div class="panel panel-primary animated zoomIn xn-drop-left">
            <div class="panel-heading">
                <h3 class="panel-title"><span class="fa fa-phone"></span> Telefones Úteis</h3>
            </div>
            <div class="panel-body list-group scroll" id="listPhones" style="overflow-y: scroll; height:500px;">
            </div>
            <div class="panel-footer"></div>
        </div>
    </li>
    @endif
    {{-- Módulos com login via API   --}}
    @if($modulo > 0)
    <li class="xn-icon-button pull-right">
        <a href="#"><span class="fa fa-circle-o"></span></a>
        <div class="panel panel-default  animated zoomIn xn-drop-left">
            <div class="panel-heading list-group-item">
                <div class="panel-title">
                    <h3>Módulos</h3>
                </div>
            </div>
            <div class="panel-body list-group scroll">
                @if(in_array(16, $permissions) || $webMaster)
                <div class="list-group-item">
                    <form method="POST" action="/formTransfer/public/login" id="FormTransfer" class="input-group">
                        <input type="hidden" name="username" id="usernameFormTransfer" value="{{ Auth::user()->username }}">
                        <img src="{{ asset('img/formTransfer.png') }}" alt="FormTransfer" class="col-md-2">
                        <input type="password" name="password" id="passwordFormTransfer" class="form-control col-md-4 btn-rounded" placeholder="Senha">
                        <button class="btn btn-link col-md-2"> Login | FormTransfer </button>
                    </form>
                </div>
                @endif
                @if(in_array(17, $permissions) || $webMaster)
                <div class="list-group-item">
                    <form action="{{url('http://app.liderancacobrancas.com.br:8085/report/index.php?acao=autologin&ori=book')}}" method="POST">
                        <input type="hidden" name="hash_autologin" value="{{$hash}}">
                        @csrf
                        <button class="btn btn-link">
                            <img src="{{ asset('img/favicon.png') }}" alt="FormTransfer" class="col-md-2">
                            Clique aqui para acessar o LiderReport  
                        </button>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </li>
    @endif
    {{-- Monitorias  --}}
    @if($inserts > 0)
    <li class="xn-icon-button pull-right">
        <a href="#"><span class="fa fa-plus"></span></a>
        <div class="panel panel-default animated zoomIn xn-drop-left">
            <div class="panel-heading list-group-item">
                <div class="panel-title">
                    <h3 class="panel-title">Inserções Rápidas</h3>
                </div>
            </div>
            <div class="panel-body list-group border-bottom scroll" id="monitoriaNavBar">
                <a href="{{ route('GetCircularesCreate') }}" class="list-group-item">
                    Circulares
                    <div class="badge badge-primary">&nbsp;
                        <span class="fa fa-plus"></span>
                    </div>
                </a>
                <a href="{{ route('GetMateriaisCreate') }}" class="list-group-item">
                    Materiais
                    <div class="badge badge-primary">&nbsp;
                        <span class="fa fa-plus"></span>
                    </div>
                </a>
                <a href="{{ route('GetRoteirosCreate') }}" class="list-group-item">
                    Roteiros
                    <div class="badge badge-primary">&nbsp;
                        <span class="fa fa-plus"></span>
                    </div>
                </a>
                <a href="{{ route('GetTelefonesCreate') }}" class="list-group-item">
                    Telefones
                    <div class="badge badge-primary">&nbsp;
                        <span class="fa fa-plus"></span>
                    </div>
                </a>
                <a href="{{ route('GetVideosCreate') }}" class="list-group-item">
                    Videos
                    <div class="badge badge-primary">&nbsp;
                        <span class="fa fa-plus"></span>
                    </div>
                </a>
                @if(in_array(34, $permissions) || $webMaster)
                <a style="border-top: solid 1px gray" href="{{ route('GetUsersRegisterUser') }}"  class="list-group-item">
                    Usuários
                    <div class="badge badge-primary">&nbsp;
                        <span class="fa fa-plus"></span>
                    </div>
                </a>
                @endif
            </div>
        </div>
    </li>
    @endif
    {{-- END TASKS --}}
</ul>
<!-- END X-NAVIGATION VERTICAL -->
{{-- Monitoria: Consideracoes (Operador) --}}
@section('modalAll')
    {{-- Modal de Relatório  --}}
    @include('monitoring.components.modais.resultRelatorio')
@endsection
@section('xNavJs')
<script lang="javascript">
// pega monitorias
function getMonitoriasNavBar() {
    $.getJSON( '{{ asset("api/monitoring/get/supervisor/".Auth::id()) }}/'  , function(data){
        if(data > 0) {
            $("#monitoriaMenuBtn").html('.')
        } else {
            $("#monitoriaMenuBtn").html('')
        }
    });
}

// GRavar feedback de monitoria
function saveFeedbackOperatorMonitoring(option,hash) {
    $("#btnMo"+option).html('<span class="fa fa-spinner fa-spin"></span>')
    id = $("#idModal").val()
    $.ajax({
        url: "{{asset('api/monitoring/operator/feedback')}}/"+id+"/"+option,
        data: "hash="+hash+"&feedback="+$("textarea#feedback_operador").val(),
        method: "PUT",
        success: function (response) {
            console.log(response)
            noty({
                text: response.msg,
                timeout: 3000,
                layout: 'topRight',
                type: 'success',
            })
            $("#modalMonitoring").hide().remove()

        },
        error: function (xhr) {
                $("#btnMo"+option).html('Tentar Novamente')
                console.log(xhr)
                $("#deleteMonitoria"+id).html('Excluir')
                if(xhr.responseJSON.errors) {
                    // Caso seja erro Laravel, mostra esses erros em alertas
                    $.each(xhr.responseJSON.errors,function(i,v){
                        noty({
                            text: v,
                            timeout: 3000,
                            layout: 'topRight',
                            type: 'error',
                        });
                    });
                } else if(xhr.status == 429){
                    noty({
                        text: 'Erro de Conexão! Tente novamente mais tarde.',
                        timeout: 3000,
                        layout: 'topRight',
                        type: 'error',
                    });
                } else {
                    noty({
                        text: 'Erro! Tente novamente mais tarde.',
                        timeout: 3000,
                        layout: 'topRight',
                        type: 'error',
                    });
                }

            }
    })

}

//Abre modal de monitoria para operadores
function openModalSupOpeMonitoria() {
    $.getJSON('{{ route( "GetMonitoriasOperador", [ Auth::id()] ) }}',function(data){
        console.log(data)
        if(data.length > 0) {
            // Monta linhas da tabela com os laudos
                    linhas = ''
                    for ( i = 0; i < data.length; i++) {
                        linhas += '<tr>'+
                                    '<td>'+data[i].numero+'</td>'+
                                    '<td>'+data[i].questao+'</td>'+
                                    '<td>'+data[i].sinalizacao+'</td>'+
                                    '<td>'+data[i].value+'</td>'+
                                '</tr>';
                    }
                    $("#idModal").val(data[0].id)

                    // trata datas
                    dateCall = data[0].data_ligacao//.split('-');
                    // dateCall.reverse();
                    // dateCall.join('/');

                    datelaudo = data[0].created_at//.split('-');
                    // datelaudo.reverse();
                    // datelaudo.join('/');

                    // coloca campos
                    $("#operador").val(data[0].operador)
                    $("p#operador").html(data[0].operador)
                    $("#userCli").val(data[0].usuario_cliente)
                    $("p#userCli").html(data[0].usuario_cliente)
                    $("#supervisor").val(data[0].supName)
                    $("p#supervisor").html(data[0].supName)
                    $("#monitor").val(data[0].moniName)
                    $("p#monitor").html(data[0].moniName)
                    $("#produto").val(data[0].produto)
                    $("p#produto").html(data[0].produto)
                    $("#cliente").val(data[0].cliente)
                    $("p#cliente").html(data[0].cliente)
                    $("#cpf").val(data[0].cpf_cliente)
                    $("p#cpf").html(data[0].cpf_cliente)
                    $("#id_audio").val(data[0].id_audio)
                    $("p#id_audio").html(data[0].id_audio)
                    $("#tipo_ligacao").val(data[0].tipo_ligacao)
                    $("p#tipo_ligacao").html(data[0].tipo_ligacao)
                    $("#tempo_ligacao").val(data[0].tempo_ligacao)
                    $("p#tempo_ligacao").html(data[0].tempo_ligacao)
                    $("#data_call").val(data[0].data_ligacao+' '+data[0].hora_ligacao)
                    $("p#data_call").html(data[0].data_ligacao+' '+data[0].hora_ligacao)
                    $("#pontos_positivos").val(data[0].pontos_positivos)
                    $("p#pontos_positivos").html(data[0].pontos_positivos)
                    $("#pontos_desenvolver").val(data[0].pontos_desenvolver)
                    $("p#pontos_desenvolver").html(data[0].pontos_desenvolver)
                    $("#pontos_atencao").val(data[0].pontos_atencao)
                    $("p#pontos_atencao").html(data[0].pontos_atencao)
                    $("#hash_monitoria").val(data[0].hash_monitoria)
                    $("p#hash_monitoria").html(data[0].hash_monitoria)
                    $("#ncg").val(data[0].ncg)
                    $("p#ncg").html(data[0].ncg)
                    $("#feedback_monitor").val(data[0].feedback_monitor)
                    $("p#feedback_monitor").html(data[0].feedback_monitor)
                    $("#feedback_supervisor").val(data[0].feedback_supervisor)
                    $("p#feedback_supervisor").html(data[0].feedback_supervisor)
                    $("#feedback_operador").val(data[0].feedback_operador)
                    $("p#feedback_operador").html(data[0].feedback_operador)
                    $("#datelaudo").val(data[0].created_at)
                    $("p#datelaudo").html(data[0].created_at)
                    $("#conf").val(data[0].conf)
                    $("p#conf").html(data[0].conf)
                    $("#nConf").val(data[0].nConf)
                    $("p#nConf").html(data[0].nConf)
                    $("#nAV").val(data[0].nAv)
                    $("p#nAV").html(data[0].nAv)
                    $("#media").val(data[0].media)
                    $("p#media").html(data[0].media)

                    if(data[0].feedback_supervisor !== null) {
                        $("textarea#feedback_supervisor").attr('style','border-color: #95B75D')
                    }

                    //tabela de laudos
                    $("tbody#laudos").html(linhas)
                    $("#modalMonitoring").show()
        }
    });
}

//pega nome do supervisor
function getUserNameById(id,type) {
    $.getJSON("{{asset('api/data/user/json')}}/"+id,function(user){
        if(type == 'mon') {
            $("#monitor").val(user[0].name)
        } else {
            $("#supervisor").val(user[0].name)
        }

    })
}

// funçaõ para mostrar msg na navbar
function getMsgNotify() {
    if($('#MsgNotifyX').html() !== '.') {
        $.getJSON('{{ route('GetChatsNotify', [ 'id' => Auth::user()->id ])  }}', function(data) {
            if(data['n'] > 0) {
                console.log('Buscando mensagens...')
                //pesquisa apenas quem enviou a msg e indica ao usuario, caso esteja dentro das view chat.*
                @if( in_array(Route::current()->getName(),['GetUsersMsgAdm','GetUsersMsgCoord','GetUsersMsgOpe','GetUsersMsgSup','GetUsersMsgTraining','GetUsersMsgOpeSup ','GetUsersMsgMonit']))
                    //mostra icone de msgs
                    $.each(data['ids'],function(i,v) {
                        contactUp(v.speaker_id)
                    });
                @endif

                $("#MsgNotifyX").remove();

                $("#msgVal").attr('value',data['n'])

                div = '<div class="informer informer-danger" style="color: #E04B4A;" id="MsgNotifyX">.</div>';

                $("#MessagesTaskDiv").append(div);

                // document.title = data['n']+' novas mensagens - LiderBook'
                if(noty === 0) {
                    pushNoty('LiderBook',"Você tem novas mensagens no ChatBook, Venha conferir!",$('#MessagesTaskBtn').attr('href'))
                }
                $('#msgNotIptHidden').val('_')

            } else {
                console.log('Nenhuma mensagem encontrada')
                $("#msgVal").attr('value','0');
                $("#MsgNotifyX").remove();
                // document.title = 'LiderBook 2.0 - {{ isset($title) ? $title : "Login" }}'
            }
        });
    }
}

//lista calculadoras ao clicar
$("#CalculadoraTask").click(function() {
    $('#calculadoraJS').html('<div class="col-md-12 text-center"><span class="fa fa-spinner fa-spin fa-3x"></span></div>');
    try {
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
                    '<a class="list-group-item" href="{{ asset('api/download/calculator') }}/'+ data[i].id +'/{{ Auth::user()->id }}" onclick="notifyCalculator('+nameAspas+')" >' +

                    '<span class="fa fa-paperclip"></span>'+
                    '<strong> ' + data[i].name + '</strong>' +
                    '</a>'+
                    '</div>';
                }
                div += calc + '</div>'
                $('#calculadoraJS').html(div);
            } else {
                $('#calculadoraJS').html('<div class="col-md-12 text-center">Nenhuma calculadora encontrada</div>')
            }
        });
    } catch(e) {
        console.log(e)
        setTimeout(function (){
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
                    '<a class="list-group-item" href="{{ asset('api/download/calculator') }}/'+ data[i].id +'/{{ Auth::user()->id }}" onclick="notifyCalculator('+nameAspas+')" >' +
                    '<span class="fa fa-paperclip"></span>'+
                    '<strong> ' + data[i].name + '</strong>' +
                    '</a>'+
                    '</div>';
                }
                div += calc + '</div>'
                $('#calculadoraJS').html(div);
            } else {
                $('#calculadoraJS').html('<div class="col-md-12 text-center">Nenhuma calculadora encontrada</div>')
            }
        });
        },5000)
    }
});

//Lista telefones ao clicar
$("#getPhones").click(function () {
    $.getJSON("{{ asset('api/phone/json/' . Auth::user()->ilha_id) }}",function(data){
        lines = ''
        for(i = 0; i < data.length; i++) {
            lines += linePhones(data[i]);
        }
        return $("#listPhones").html(lines)
    })
})

function linePhones(phone){
    id = ''
    name = ''
    description = ''
    tel1 = ''
    desc1 = ''
    tel2 = ''
    desc2 = ''
    days = ''
    obs = ''
    email = ''

    if(phone.id != null) {
        id += phone.id
    }
    if(phone.name != null) {
        name += phone.name
    }
    if(phone.description != null) {
        description += phone.description
    }
    if(phone.tel1 != null) {
        tel1 += phone.tel1
    }
    if(phone.desc1 != null) {
        desc1 += phone.desc1
    }
    if(phone.tel2 != null) {
        tel2 += phone.tel2
    }
    if(phone.desc2 != null) {
        desc2 += phone.desc2
    }
    if(phone.days != null) {
        days += phone.days
    }
    if(phone.obs != null) {
        obs += phone.obs
    }
    if(phone.email != null) {
        email += phone.email
    }

    line =  ''+
                '<div id="phone'+id+'">'+
                    '<div class="card">'+
                        '<div class="list-group-item" style="max-width:100%;">'+
                            @if(in_array(40,$permissions))
                            '<a onclick="deletePhone('+id+')" class="btn pull-right"><span class="fa fa-times"></span></a>'+
                            @endif
                            '<p style="max-width:100%;">'+
                                '<strong style="color:black"><i class="fa fa-phone"></i> '+name+' - </strong>'+
                                description+
                            '</p>'+
                            '<div>'+
                                '<p><b style="color:red">'+tel1+'</b> '+desc1+' / <b style="color:red">'+tel2+'</b> '+desc2+'</p>'+
                                '<p><strong>'+days+'</strong></p>'+
                                '<p>'+obs+'</p>'+
                                '<p>'+email+'</p>'+
                            '</div>'+
                        '</div>'+
                    '</div>'+
                '</div>';
    return line;
}

$(function(){
    try {
        //busca mensagens à cada i segundos
        getMsgNotify()
        i = 60*5

        setTimeout(function() {getMsgNotify()}, (i*1000));

        //If supervisor, carrega notificação de monitoria (Permission - Monitoria: Aplicar Feedback)
        @if(in_array(19,$permissions))
             getMonitoriasNavBar()


             setTimeout(() => {
                getMonitoriasNavBar()
            }, 70*1000);

        // If operador, carrega modal monitoria feedback
        @elseif(in_array(Auth::user()->cargo_id,[5]))
            openModalSupOpeMonitoria()

            setTimeout(() => {
                openModalSupOpeMonitoria()
            }, 7*60*1000);
        @endif

    } catch(e) {
        noty({
            text: 'Erro de conexão',
            layout: 'topRight',
            timeout: 3000,
            type: 'error'
        });

        //If supervisor, carrega notificação de monitoria
        setTimeout( function() {getMsgNotify()}, (60*1000))
        @if(in_array(19,$permissions))
        setTimeout(() => {
            getMonitoriasNavBar()
        }, 2000);
        setTimeout(() => {
            getMonitoriasNavBar()
        }, 1800*1000);

        // If operador, carrega modal monitoria feedback
        @elseif(in_array(20,$permissions))
        setTimeout(() => {
            openModalSupOpeMonitoria()
        }, 2000);
        setTimeout(() => {
            openModalSupOpeMonitoria()
        }, 180*1000);
        @endif
    }
});
</script>
@endsection
