<script type="text/javascript">
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    var loopVar

    //pula linha na exibição das msgs
    function nl2br (str, is_xhtml) {
        if (typeof str === 'undefined' || str === null) {
            return '';
        }
        var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
        return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
    }

    //
    function getMsgToGroup(argument) {
        // body... 
    }

    /* mensagens grupos */
    function divGroupMsg(m,user,name,photo) {
        // Variáveis
        inClass = '';
        sender = '';
        pic = ''; //futurametnte será a foto do grupo

        //data e hora
        date = (m.created_at).split(' ');
        hora = (date[1]).substring(0, 5);
        setDate = date[0].split('-').reverse()
        showDate = setDate[0]+'/'+setDate[1]

        //verifica quem enviou a msg
        if(m.speaker_id	 == '{{Auth::user()->id}}') {
            inClass += 'in';
            sender += name;
            pic += '<img src="{{asset('/')}}/{{ Auth::user()->avatar }}" alt="'+m.speaker_id+'">'

        } else {

            sender += user;

            pic += '<i class="fa fa-users fa-3x"></i>'
        }

        var linha =
        '<div class="item '+inClass+' item-visible" id="filho">'+
                '<div class="image">'+
                    pic+
                '</div>'+
                '<div class="text">'+
                    '<div class="heading">'+
                        '<a>'+sender+'</a>'+
                    '</div>'+
                    nl2br(m.content)+
                    '<div class="footer pull-right">'+
                        '<div class="heading">'+
                            '<span class="date">Enviada '+showDate+' às '+hora+'</span>'+
                        '</div>'+
                    '</div>'+
                '</div>'+
            '</div>';

        return linha;
    }

    function GetGroupMsg(id,user,name,photo) {
        $("#msgs").hide()
        $("#msgPreLoader").show()
        $(".list-group-item").attr('class','list-group-item active')
        $("#chat"+id).attr('class','list-group-item')
        $("#keyinfo").html('<input type="hidden" value="'+id+'" id="onkey">')
        $("#content").attr('class','form-control')
    
        $.getJSON('{{asset("api/msg/group")}}/'+id+'/{{ Auth::user()->id }}', function(msg) {
            var btnSend = '<button type="button" id="sendMsg" class="btn btn-default" onclick="sendMessage('+id+',1);">Enviar</button>';

            $("#contactInfo").html('<i class="fa fa-users fa-3x" style="color:purple"></i> '+user)
            if(msg.length == 0) {
                $('#chat').remove();
                $("#divMsg > div").remove();
                $('#noMSG').show();
                $("#defaultP").hide();
                $("#noMSGp").show();
                $("#sendMsg").remove();
                $("#sendMsgDivBTN").append(btnSend);
                $("#msgPreLoader").hide()
                $("#msgs").show()
            } else {
                $('#chat').remove();
                $("#divMsg > div").remove();
                linha = '';

                for (i = 0; i < msg.length; i++) {
                    count = (i - 10) * -1;
                    linha += divGroupMsg(msg[i], user, name);
                }
                var div = '<div id="chat">' + linha + '</div>';
                var input = '<input type="hidden" name="id" value=""><input type="hidden" name="group" value="' + id + '">';
                $("#noMSG").hide();
                $("#sendMsg").remove();
                $("#sendMsgDivBTN").append(btnSend);
                $('#divMsg').append(div);
                $("#sendMsgForm").append(input);
                $("#msgPreLoader").hide()
                $("#msgs").show()
                $("#divMsg").scrollTop(99999999999999999999999999999);

            }

        });
    }

    function GetGroupNewMsg(id,user,name) {
        $.getJSON('{{asset("/api/msg/group")}}/'+id+'/{{ Auth::user()->id }}', function(msg) {
            if(msg.length > 0) {

                $("#chat").remove();
                linha = '';
                for (i = 0; i < msg.length; i++) {
                        count = (i - 10) * -1;
                        linha += divGroupMsg(msg[i], user, name);

                    }
                div = '<div id="chat">'+linha+'</div>';
                $('#divMsg').append(div);
                $("#divMsg").scrollTop(99999999999999999999999999999);
            }
        });
    }


    function intervalGetGroupMsg(id,user,name) {
        //variaveis para setar função e jogar em input[type=hidden]
        $("#msgNumber"+id).html('').hide()
                clearTimeout(loopVar);


        GetGroupMsg(id,user,name)
        $("#groupInput").val(id)

        loopVar = window.setTimeout(function() {
            GetGroupNewMsg(id,user,name)
            getMsgNotify()
        },5000);
    }

    /* mensagens individuais */

    function divMsg(m,user,name,photo) {

        date = (m.created_at).split(' ');
        hora = (date[1]).substring(0, 5);
        setDate = date[0].split('-').reverse()
        showDate = setDate[0]+'/'+setDate[1]
        inClass = '';
        sender = '';
        pic = '';

        if(m.speaker_id	 == '{{Auth::user()->id}}') {
            inClass += 'in';
            sender += name;
            pic += "{{Auth::user()->avatar}}";
        } else {
            sender += user;
            pic += photo;
        }

        var linha =
        '<div class="item '+inClass+' item-visible" id="filho">'+
                '<div class="image">'+
                    '<img src="{{asset('/')}}'+pic+'" alt="'+m.speaker_id+'">'+
                '</div>'+
                '<div class="text">'+
                    '<div class="heading">'+
                        '<a>'+sender+'</a>'+
                    '</div>'+
                    nl2br(m.content)+
                    '<div class="footer pull-right">'+
                        '<div class="heading">'+
                            '<span class="date">Enviada '+showDate+' às '+hora+'</span>'+
                        '</div>'+
                    '</div>'+
                '</div>'+
            '</div>';

        return linha;
    }

    function GetMsg(id,user,name,photo) {
        $("#msgs").hide()
        $("#msgPreLoader").show()
        $(".list-group-item").attr('class','list-group-item active')
        $("#chat"+id).attr('class','list-group-item')
        $("#keyinfo").html('<input type="hidden" value="'+id+'" id="onkey">')
        $("#content").attr('class','form-control')

        $.getJSON('{{asset("/")}}api/msg/'+id+'/{{ Auth::user()->id }}', function(msg) {
            var btnSend = '<button type="button" id="sendMsg" class="btn btn-default" onclick="sendMessage('+id+');">Enviar</button>';

            $("#contactInfo").html('<img src="{{asset('/')}}'+photo+'" alt="'+name+'" style="width: 5%;"> '+user)
            if(msg.length == 0) {
                $('#chat').remove();
                $("#divMsg > div").remove();
                $('#noMSG').show();
                $("#defaultP").hide();
                $("#noMSGp").show();
                $("#sendMsg").remove();
                $("#sendMsgDivBTN").append(btnSend);
                $("#msgPreLoader").hide()
                $("#msgs").show()
            } else {
                $('#chat').remove();
                $("#divMsg > div").remove();
                linha = '';

                for (i = 0; i < msg.length; i++) {
                    count = (i - 10) * -1;
                    linha += divMsg(msg[i], user, name,photo);
                }
                var div = '<div id="chat">' + linha + '</div>';
                var input = '<input type="hidden" name="id" value="' + id + '">';
                $("#noMSG").hide();
                $("#sendMsg").remove();
                $("#sendMsgDivBTN").append(btnSend);
                $('#divMsg').append(div);
                $("#sendMsgForm").append(input);
                $("#msgPreLoader").hide()
                $("#msgs").show()
                $("#divMsg").scrollTop(99999999999999999999999999999);

            }

        });
    }

    function GetNewMsg(id,user,name,photo) {
        $.getJSON('{{asset("/")}}api/msg/'+id+'/{{ Auth::user()->id }}', function(msg) {
            if(msg.length > 0) {

                $("#chat").remove();
                linha = '';
                for (i = 0; i < msg.length; i++) {
                        count = (i - 10) * -1;
                        linha += divMsg(msg[i], user, name,photo);

                    }
                div = '<div id="chat">'+linha+'</div>';
                $('#divMsg').html(div);
                if($("#msgNumber"+id).val() > 0) {
                    $("#divMsg").scrollTop(99999999999999999999999999999);
                }
            }
        });
    }


    function intervalGetMsg(id,user,name,photo) {
        //variaveis para setar função e jogar em input[type=hidden]
        clearTimeout(loopVar);
        p =  "'"+photo+"'";
        $("#msgNumber"+id).html('').hide()
        GetMsg(id,user,name,photo)
        $("#groupInput").val('')

        loopVar = window.setInterval(function() {
            GetNewMsg(id,user,name,photo)
            getMsgNotify()
        },5000);
    }

    /******* envia com a tecla enter *******/
    var pressedCtrl = false; //variável de controle

	 $('#content').on('keyup',function (e) {  //O evento Kyeup é acionado quando as teclas são soltas
	 	if(e.which == 16) pressedCtrl=false; //Quando qualuer tecla for solta é preciso informar que Crtl não está pressionada
	 })
	$('#content').on('keydown',function (e) { //Quando uma tecla é pressionada
		if(e.which == 16) {
            pressedCtrl = true;
        } //Informando que Crtl está acionado

        if((e.which == 13|| e.keyCode == 13) && pressedCtrl == false ) {
            sendMessage( $("#onkey").val() )
        }// envia msg quando o enter é pressionado
	});

    function sendMessage(id, type = 0) {
        var mensagens = $("#content").val();
        $("#content").trigger('focusout')
        $("#content").attr('disabled',true)
        if(mensagens == '') {
            $("#content").val('');
        } else {
            var data = $("#sendMsgForm").serialize();
            $("#sendMsg").attr('class','btn btn-default disabled')
            group = ''

            if(type == 1) {
                group += '&groupInput='+id
            }

            $.ajax({
                type: "POST",
                url: "{{asset('/')}}api/msg/save/{{ Auth::user()->id }}/"+id,
                data: 'content='+mensagens+group,
                success: function(xhr)
                {
                    $("#content").val('');
                    linha =
                        '<div class="item in item-visible" id="filho">'+
                        '<div class="image">'+
                        '<img src="{{asset(Auth::user()->avatar)}}" alt="{{Auth::user()->username}}">'+
                        '</div>'+
                        '<div class="text">'+
                        '<div class="heading">'+
                        '<a>{{Auth::user()->name}}</a>'+
                        '<span class="date">{{date("H:i")}}</span>'+
                        '</div>'+
                        mensagens+
                        '</div>'+
                        '</div>';
                    $("#divMsg").append(linha)
                    $("#sendMsg").attr('class','btn btn-default')
                    $("#divMsg").scrollTop(99999999999999999999999999999);
                    $("#content").attr('disabled',false)
                    $("#content").trigger('focus')
                },
                error: function(xhr) {
                    
                    noty({
                        text: "Erro! tente novamente mais tarde",
                        layout: 'topRight',
                        type: 'error',
                        timeout: 3000
                    })

                    $("#sendMsg").attr('class','btn btn-default')
                    $("#content").val(mensagens)
                    $("#content").attr('disabled',false)
                    $("#content").trigger('focus')
                }
            });
        }

    }

    //Filtro de contatos
    $(function(){
        $("#filtro").keyup(function(){
            var texto = $(this).val();

            $("#contacts li").css("display", "block");
            $("#contacts li").each(function(){
                if($(this).text().indexOf(texto) < 0)
                $(this).css("display", "none");
            });
        });
        $("#filtroGroup").keyup(function(){
            var texto = $(this).val();

            $("#groups li").css("display", "block");
            $("#groups li").each(function(){
                if($(this).text().indexOf(texto) < 0)
                $(this).css("display", "none");
            });
        });
    });

    //atualzia lista de contatos
    function newContacts() {
        ids = $("#ids").val()
        $.getJSON('{{ asset("api/msg/contacts/".Auth::id()) }}/'+ids,function(data){
            if(data.length > 0) {
                text = ''
                msgNumber = ''
                $.each(data,function(i,v){
                    func = 'intervalGetMsg('+v.id+',"'+v.name+'","{{Auth::user()->name}}","'+v.avatar+'")';

                    text += '<li id="contactLi'+v.id+'">'+
                                '<a href="javascript:'+func+'" class="list-group-item active" id="chat'+v.id+'">'+
                                    '<img src="{{ asset('/') }}/'+v.avatar+'" class="pull-left" alt="'+v.name+'">'+
                                    '<div class="contacts-title">'+
                                        '<span class="label label-danger" id="msgNumber'+v.id+'"></span>'+
                                        v.name+
                                        '<p class="text-mute" style="font-size: 85%;">'+v.cargo+'</p>'+
                                    '</div>'+
                                '</a>'+
                            '</li>';

                    ids += ','+v.id
                    msgNumber += ','+v.id
                });

                $("#ids").val(ids)
                $(text).insertBefore( $("ul#contacts.panel-body").children()[0] );  // Insert <li> before the first child of <ul>

                forVar = msgNumber.split(',')
                
                for(i=0; i < forVar.length; i++) {
                    msgNumber(forVar[i])
                }
            }
        });
    }

    //Coloca as msgs como prioritárias de acordo com o id
    function contactUp(id) {
        // 
        $('#msgNumber'+id).show();
        $('#msgNumber'+id).html('<span class="fa fa-comment-o fa-sm" style="margin-right: 0px"></span>');
        $($('#contactLi'+id)).insertBefore( $("ul#contacts.panel-body").children()[0] )
    }

    $(window).on('load', function(){
        $('#msgPreLoader').hide()
        $('#msgTop').show()
        $('#contacts').show()        
        getMsgNotify()
        
    })
</script>
