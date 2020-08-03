<script type='text/javascript' id="homeJs">

    //Conta posts na página
    function contarLinha() {
        return document.body.querySelectorAll('#Posts > li').length;
    }

    //Carrega Ilhas do POST
    function carregarIlha(id) {
            $.getJSON('{{asset("/")}}api/data/ilha/'+id, function(data){
                return (data[0].name)

            });
    }

    //carrega posts
    function carregarPosts() {
        var n = contarLinha();
        $.getJSON("{{asset('/')}}api/post/{{Auth::user()->ilha_id}}/" + n +"/{{ Auth::id().'/'.Auth::user()->cargo_id }}", function(publicacao){
            l = publicacao.length
            if(l > 0) {
                for(i=0; i < l; i++) {
                    linha = montarLinha(publicacao[i]);
                    reaction_n(publicacao[i].react_id, publicacao[i].id_post);
                    $('#Posts').append(linha);
                }
                $("#loading_posts").hide()
                $("#content_loading").show()
            } else {
                $("#loading_posts").hide()
                $("#content_loading").show()
                noty({
                    text: 'Nenhuma nova publicação',
                    type: 'information',
                    layout: 'topRight',
                    timeout: '2000'
                })
            }
        });

    }

    // Coloca nome do arqvui à mostra
    $("#file_pathPOST").on('change',function(){
        file = $("#file_pathPOST").val().split('\\').reverse();

        $("#file_pathPOSTName").html(file[0]);
    })


    //Monta Posts
    function montarLinha(p){

        var date = (p.date).split(' ');
        var hifen = date[0].split('-');
        var data = hifen[2]+'/'+hifen[1]+'/'+hifen[0];
        var hora = (date[1]).substring(0, 5);
        var img = '';
        var icon = '';

        if(p.file_path) {

            if(p.file_path.split('.')[1] == 'mp4') {
                img += '<video width="100%" controls>'+
                    '<source src="{{ asset("/") }}'+p.file_path+'" type="video/mp4">'+
                    'Seu Navegador não é compatível com este formato de video'+
                '</video>';
                icon += 'youtube-play'
            } else if(p.file_path.split('.')[1] == 'pdf') {
                img += '<embed src="{{ asset("/") }}'+p.file_path+'" style="width:100%; height:500px;">';
                icon += 'file-text-o'
            } else {
                img += '<img src="{{ asset("/") }}'+p.file_path+'" style="background-color:black; width:100%; text-align:left" class="img-text" />';
                icon += 'photo'
            }

        } else {

            if(p.ilha_id == 1) {
                icon += 'users';
            } else {
                icon += 'reply';
            }
        }

        // verifica se usuário que publicou video está logado
        logado = ''
        if(p.last_login >= '{{date("Y-m-d H:i:s",strtotime("-10 Minutes"))}}') {
            logado += '<span class="fa fa-circle text-success"></span>'
        }

        var linha =
                '<li id="post'+p.id_post+'"><div id="number_posts" style="background-color:RGBA(0,0,0,0); z-index: ;">'+
                        '<div class="timeline-item timeline-item-right">'+
                            '<div class="timeline-item-info">'+data+' '+hora+'</div>'+
                                '<div class="timeline-item-icon"><span class="fa fa-'+icon+'"></span></div>'+
                                    '<div class="timeline-item-content" style="margin-bottom:1rem;">'+
                                        '<div class="timeline-heading padding-bottom-0">'+
                                            '<img src="{{ asset("/") }}'+p.avatar+'" style="background-color:black"/> Publicado Por <b>'+logado+'<a  href="#post'+p.id_post+'" class="text-dark">'+p.userPost.split(' ')[0]+'</a></b>'+

                                                @if(in_array(29,$permissions) || in_array(30,$permissions) || $webMaster)
                                                '<ul class="panel-controls pull-right">'+
                                                    '<li class="dropdown">'+
                                                        '<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-cog"></span></a>'+
                                                        '<ul class="dropdown-menu">'+
                                                        @if(in_array(29,$permissions) || in_array(1,$permissions))
                                                            '<li><a onclick="deletePost('+p.id_post+')" class="panel-collapse"><span class="fa fa-trash-o"></span></span> Excluir</a></li>'+
                                                        @endif
                                                        @if(in_array(30,$permissions) || in_array(1,$permissions))
                                                            '<li><a onclick="" class="panel-collapse"><span class="fa fa-bar-chart-o"></span></span> Relatório</a></li>'+
                                                        @endif
                                                        '</ul>'+
                                                    '</li>'+
                                                '</ul>'+
                                                @endif

                                            '</div>'+
                                        '<div class="timeline-body">'+
                                            img;
                                    if({{Auth::id()}} === 37 && p.descript == 'https://us04web.zoom.us/j/6011900691?pwd=OEVOZmhLQnVpdi9hcExoM1dwZXNsUT09'){linha += '<embed src="https://meet.google.com/erp-sjhw-nka" style="width:100%; height:500px;">'}else if(p.descript !== null){linha += '<p>'+createTextLinks_(hashtag(p.descript))+'</p>';}
                                    linha +='</div>'+
                                        '<div class="timeline-footer">'+
                                            '<div class="input-group">'+
                                                '<div class="pull-left">'+
                                                    '<a onclick="reactLike('+p.id_post+')" id="like'+p.id_post+'" class="btn btn-{{Auth::user()->css}}">' +
                                                        '&nbsp<span id="LikeFalse'+p.id_post+'" class="fa fa-thumbs-o-up"> <b id="likeNumFalse'+p.id_post+'"></b></span>'+
                                                        '&nbsp<span id="LikeTrue'+p.id_post+'" style="display:none; color: #10254d;" class="fa fa-thumbs-up"> <b id="likeNumTrue'+p.id_post+'"></b></span>'+
                                                        '<div class="text-center" id="LikePreloader'+p.id_post+'" style="display:none">'+
                                                            '<div class="spinner-grow text-dark" role="status" style="width:1.5rem; height:1.5rem;">'+
                                                                '<span class="sr-only"></span>'+
                                                            '</div>'+
                                                        '</div>'+
                                                    '</a>'+
                                                    '<a onclick="reactDislike('+p.id_post+')" id="dislike'+p.id_post+'" class="btn btn-{{Auth::user()->css}}">'+
                                                        '&nbsp<span id="DislikeFalse'+p.id_post+'"  class="fa fa-thumbs-o-down"> <b id="dislikeNumFalse'+p.id_post+'"></b></span>'+
                                                        '&nbsp<span id="DislikeTrue'+p.id_post+'" style="display:none; color: #8a0808;" class="fa fa-thumbs-down"> <b id="dislikeNumTrue'+p.id_post+'"></b></span>'+
                                                        '<div class="text-center" id="DislikePreloader'+p.id_post+'" style="display:none">'+
                                                            '<div class="spinner-grow text-dark" role="status" style="width:1.5rem; height:1.5rem;">'+
                                                                '<span class="sr-only"></span>'+
                                                            '</div>'+
                                                        '</div>'+
                                                    '</a>'+
                                                '</div>'+
                                                '<div class="pull-right">'+
                                                    '<a><span class="fa fa-eye"> '+p.view_number+'</span></a>'+
                                                '</div>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                '</div></li>';
                reactionNumbers(p.id_post)
        return linha;
    }

    /******************* Reações *******************/

    //Retorna o numero de reações por post
    function reactionNumbers(id) {
        $.getJSON('{{ asset("api/reaction/") }}/'+id,function(data){
            //Like Number
            $("#likeNumTrue"+id).html(data[0])
            $("#likeNumFalse"+id).html(data[0])
            //Dislike Number
            $("#dislikeNumTrue"+id).html(data[1])
            $("#dislikeNumFalse"+id).html(data[1])
        })
    }

    //Carrega reação que o usuário já fez
    function reaction_n(react_id,post_id) {
        if(react_id === 1) {
            $("#LikeFalse"+post_id).hide()
            $("#LikeTrue"+post_id).show()
            $("#DislikeTrue"+post_id).hide()
            $("#DislikeFalse"+post_id).show()

        }
        if(react_id === 2) {
            $("#LikeTrue"+post_id).hide()
            $("#LikeFalse"+post_id).show()
            $("#DislikeFalse"+post_id).hide()
            $("#DislikeTrue"+post_id).show()
        }
    }

    //Reage ao post (LIKE)
    function reactLike(post) {
        $("#LikeFalse"+post).hide()
        $("#LikePreloader"+post).show()
        $.ajax({
            url: '{{asset("/")}}api/reaction/insert/'+post+'/1/'+{{ Auth::user()->id  }},
            type: 'POST',
            data: null,
            success: function(response) {
                $("#LikeFalse"+post).hide()
                $("#LikeTrue"+post).show()
                $("#DislikeTrue"+post).hide()
                $("#DislikeFalse"+post).show()
                $("#LikePreloader"+post).hide()
                $('#like'+post).attr('onclick','reactLikeDelete(' + post + ')');
                $('#dislike'+post).attr('onclick','reactDislike(' + post + ')');
                //atualiza numero de likes
                reactionNumbers(post)
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                $("#LikePreloader"+post).hide()
                $("#LikeFalse"+post).show()
                //atualiza numero de likes
                reactionNumbers(post)
            }
        });
    }

    //deleta like
    function reactLikeDelete(post) {
        $("#LikeTrue"+post).hide()
        $("#LikePreloader"+post).show()
        $.ajax({
            url: '{{asset("/")}}api/reaction/delete/'+post+'/1/'+{{ Auth::user()->id  }},
            type: 'POST',
            data: null,
            success: function(response) {
                $("#LikeFalse"+post).show()
                $("#LikeTrue"+post).hide()
                $("#DislikeTrue"+post).hide()
                $("#DislikeFalse"+post).show()
                $("#LikePreloader"+post).hide()
                $('#like'+post).attr('onclick','reactLike(' + post + ')');
                $('#dislike'+post).attr('onclick','reactDislike(' + post + ')');
                //atualiza numero de likes
                reactionNumbers(post)
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);
                $("#LikePreloader"+post).hide()
                $("#LikeTrue"+post).show()
                //atualiza numero de likes
                reactionNumbers(post)
            }
        });
    }

    //Reage ao post (DISLIKE)
    function reactDislike(post) {
        $("#DislikeFalse" + post).hide()
        $("#DislikePreloader" + post).show()
        $.ajax({
            url: '{{asset("/")}}api/reaction/insert/' + post + '/2/' + "{{ Auth::user()->id  }}",
            type: 'POST',
            data: null,
            success: function (response) {
                $("#LikeTrue" + post).hide()
                $("#LikeFalse" + post).show()
                $("#DislikeFalse" + post).hide()
                $("#DislikeTrue" + post).show()
                $("#DislikePreloader" + post).hide()
                $('#dislike' + post).attr('onclick', 'reactDislikeDelete(' + post + ')');
                $('#like'+post).attr('onclick','reactLike(' + post + ')');
                //atualiza numero de likes
                reactionNumbers(post)
            },
            error: function (xhr, status, error) {
                console.log(error + "\n" + xhr.responseText);
                $("#DislikePreloader" + post).hide()
                $("#DislikeFalse" + post).hide()
                //atualiza numero de likes
                reactionNumbers(post)
            }
        });
    }
    //Deleta reação ao post (DISLIKE)
    function reactDislikeDelete(post) {
        $("#DislikeTrue"+post).hide()
        $("#DislikePreloader"+post).show()
        $.ajax({
            url: '{{asset("/")}}api/reaction/delete/'+post+'/2/'+{{ Auth::user()->id  }},
            type: 'POST',
            data: null,
            success: function(response) {
                $("#LikeTrue"+post).hide()
                $("#LikeFalse"+post).show()
                $("#DislikeFalse"+post).show()
                $("#DislikeTrue"+post).hide()
                $("#DislikePreloader"+post).hide()
                $('#like'+post).attr('onclick','reactLike(' + post + ')');
                $('#dislike'+post).attr('onclick','reactDislike(' + post + ')');
                //atualiza numero de likes
                reactionNumbers(post)
            },
            error: function(xhr, status, error) {
                console.log(error);
                $("#DislikePreloader"+post).hide()
                $("#DislikeTrue"+post).show()
                //atualiza numero de likes
                reactionNumbers(post)
            }
        });

    }

    /******************* ./Reações *******************/

    function deletePost(id) {

        $.ajax({
            type: "POST",
            url: "{{asset('/')}}api/post/delete/" + id + '/{{Auth::user()->id}}',
            success: function (xhr) {

                noty({
                    text: 'Publicação excluída com sucesso',
                    type: 'success',
                    timeout: '2000',
                    layout: 'topRight'
                })
                $("#post"+id).remove();
            },
            error: function (xhr) {
                noty({
                        text: "Erro ao excluir publicação!<br>Recarregue a página e tente novamente",
                        timeout: 3000,
                        layout: 'topRight',
                        type: 'error',
                    })
                console.log(xhr);
            }
        });
    }

    function montarlinhaNewPost(p) {
        var date = (p.created_at).split(' ');
        var hifen = date[0].split('-');
        var data = hifen[2]+'/'+hifen[1]+'/'+hifen[0];
        var hora = (date[1]).substring(0, 5);
        var img = '';
        var icon = '';
        var ilha_name = p.ilha_name[0].name

        if(p.file_path) {

            if(p.file_path.split('.')[1] == 'mp4') {
                img += '<video width="100%" controls>'+
                    '<source src="{{ asset("/") }}'+ p.file_path +'" type="video/mp4">'
                '</video>';
                icon += 'youtube-play'
            } else if(p.file_path.split('.')[1] == 'pdf') {
                img += '<embed src="{{ asset("/") }}'+p.file_path+'" style="width:100%; height:500px;">';
                icon += 'file-text-o'
            } else {
                img += '<img src="{{ asset("/") }}'+ p.file_path +'" style="background-color:black; width:100%; text-align:left" class="img-text" />';
                icon += 'photo'
            }

        } else {

            if(p.ilha_id == 1) {
                icon += 'users';
            } else {
                icon += 'reply';
            }
        }

        linha = '<li id="post'+p.id+'"><div id="number_posts" style="background-color:RGBA(0,0,0,0); z-index: ;">'+
                        '<div class="timeline-item timeline-item-right">'+
                            '<div class="timeline-item-info">'+data+' '+hora+'</div>'+
                                '<div class="timeline-item-icon"><span class="fa fa-'+icon+'"></span></div>'+
                                    '<div class="timeline-item-content" style="margin-bottom:1rem;">'+
                                        '<div class="timeline-heading padding-bottom-0">'+
                                            '<img src="{{ asset("/".Auth::user()->avatar) }}" style="background-color:black"/> Publicado Por <b><a  href="#post'+p.id_post+'" class="text-dark">{{ explode(' ',Auth::user()->name)[0] }}</a></b>'+

                                                @if(in_array(29,$permissions) || in_array(30,$permissions) || $webMaster)
                                                '<ul class="panel-controls pull-right">'+
                                                    '<li class="dropdown">'+
                                                        '<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="fa fa-cog"></span></a>'+
                                                        '<ul class="dropdown-menu">'+
                                                        @if(in_array(29,$permissions) || in_array(1,$permissions))
                                                            '<li><a onclick="deletePost('+p.id_post+')" class="panel-collapse"><span class="fa fa-trash-o"></span></span> Excluir</a></li>'+
                                                        @endif
                                                        @if(in_array(30,$permissions) || in_array(1,$permissions))
                                                            '<li><a onclick="" class="panel-collapse"><span class="fa fa-bar-chart-o"></span></span> Relatório</a></li>'+
                                                        @endif
                                                        '</ul>'+
                                                    '</li>'+
                                                '</ul>'+
                                                @endif

                                            '</div>'+
                                        '<div class="timeline-body">'+
                                            img;
                                    if(p.descript !== null){linha += '<p>'+createTextLinks_(hashtag(p.descript))+'</p>';}
                                    linha +='</div>'+
                                        '<div class="timeline-footer">'+
                                            '<div class="input-group">'+
                                                '<div class="pull-left">'+
                                                    '<a onclick="reactLike('+p.id+')" id="like'+p.id+'" class="btn btn-{{Auth::user()->css}}">' +
                                                        '&nbsp<span id="LikeFalse'+p.id+'" class="fa fa-thumbs-o-up"> <b id="likeNumFalse'+p.id+'"></b></span>'+
                                                        '&nbsp<span id="LikeTrue'+p.id+'" style="display:none; color: #10254d;" class="fa fa-thumbs-up"> <b id="likeNumTrue'+p.id+'"></b></span>'+
                                                        '<div class="text-center" id="LikePreloader'+p.id+'" style="display:none">'+
                                                            '<div class="spinner-grow text-dark" role="status" style="width:1.5rem; height:1.5rem;">'+
                                                                '<span class="sr-only"></span>'+
                                                            '</div>'+
                                                        '</div>'+
                                                    '</a>'+
                                                    '<a onclick="reactDislike('+p.id+')" id="dislike'+p.id+'" class="btn btn-{{Auth::user()->css}}">'+
                                                        '&nbsp<span id="DislikeFalse'+p.id+'"  class="fa fa-thumbs-o-down"> <b id="dislikeNumFalse'+p.id+'"></b></span>'+
                                                        '&nbsp<span id="DislikeTrue'+p.id+'" style="display:none; color: #8a0808;" class="fa fa-thumbs-down"> <b id="dislikeNumTrue'+p.id+'"></b></span>'+
                                                        '<div class="text-center" id="DislikePreloader'+p.id+'" style="display:none">'+
                                                            '<div class="spinner-grow text-dark" role="status" style="width:1.5rem; height:1.5rem;">'+
                                                                '<span class="sr-only"></span>'+
                                                            '</div>'+
                                                        '</div>'+
                                                    '</a>'+
                                                '</div>'+
                                                '<div class="pull-right">'+
                                                    '<a><span class="fa fa-eye"> '+p.view_number+'</span></a>'+
                                                '</div>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>'+
                '</div></li>';
                reactionNumbers(p.id)

        return linha;
    }

    //envia Formulário de POST
    $("#submitPostForm").click(function () {
        //exibe preloader
        $('#newPOSTForm').hide();
        $('#POSTPreloader').show();

        data = new FormData()
        data.append('_token',$('input[name=_token]').val());
        data.append('descript',$('#descriptPOST').val());
        data.append('priority',$('#priorityPOST').val());
        data.append('ilha_id',$('#ilha_idPOST').val());
        data.append('cargo_id',$('#cargo_idPOST').val());
        data.append('file_path',$('#file_pathPOST')[0].files[0]);

        $.ajax({
            type: "POST",
            url: "{{ asset( 'api/post/insert/' . Auth::id() ) }}",
            data: data,
            processData: false,
            contentType: false,
            success: function (response) {
                console.log(response)
                $('#POSTPreloader').hide();
                $('#newPOSTForm').show();

                noty({
                    text: 'Arquivo inserido com sucesso!',
                    timeout: 3000,
                    layout: 'topRight',
                    type: 'success',
                })

                newLine = montarlinhaNewPost(response)
                $(newLine).insertAfter( $("#Posts > li") )

                $("#newPOSTForm").trigger('reset')



            },
            error: function(xhr, status) {
                $('#POSTPreloader').hide();
                $('#newPOSTForm').show();

                console.log(xhr)
                if(xhr.responseJSON.errors.length > 0)
                $.each(xhr.responseJSON.errors,function(i,v){
                    noty({
                        text: v,
                        timeout: 3000,
                        layout: 'topRight',
                        type: 'error',
                    })
                })

            }
        });
    });

   //Chama função via JQuery quando a página abre
    $(function(){
        $.getJSON("{{asset('/')}}api/post/{{Auth::user()->ilha_id}}/0/{{ Auth::id().'/'.Auth::user()->cargo_id }}"  , function(publicacao){
            for(i=0; i < publicacao.length; i++) {
                linha = montarLinha(publicacao[i]);
                reaction_n(publicacao[i].react_id, publicacao[i].id_post);
                $('#Posts').append(linha);
            }
        });
    });

    $(window).on('load',function () {
        $('#homePage').show()
        $('#preloaderPage').hide()
        $.each($("li"),function(i,v){
            $(v).attr('style','z-index: 9999;')
        })
    });
</script>
