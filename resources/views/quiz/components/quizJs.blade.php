{{-- teste --}}
<script type="text/javascript" id="javascript">
    //retorna quantidade de perguntas criadas
    function myRows() {
        v = Number($('#myRows').val())

        $('#myRows').attr('value',v+1)
        n = v+1

        console.log(n)

        return n;
    }

    //cria questão dissertativa
    function makeText(i) {
        id = i+1

        //ativa botão de salvar
        if( $("ul#question"+id+"list > li").length == 0) {
            $("#saveBtn").attr('class', 'list-group-item btn-success');
        }

        n = null;

        //monta linha
        return li =
        '<li id="question'+id+'">'+
            // '<input type="hidden" name="questionHidden'+id+'" value="'+n+'text'+id+'">'+
            '<div class="panel panel-primary" id="questioncontent'+id+'">'+
                '<div class="panel-heading ui-draggable-handle ui-sortable-handle">'+
                    '<textarea class="panel-title col-md-5" name="questionTitle" id="title_dissert" placeholder=" Título da Pergunta - Dissertativa"></textarea>'+
                    '<ul class="panel-controls">'+
                        '<li>'+
                            '<div class="input-group">'+
                                '<button type="button" onclick="select_qUp('+id+','+n+')" class="btn btn-primary btn-sm" id="'+n+'selectBtn_question'+id+'">'+
                                    'Editar o Tipo de Pergunta'+
                                '</button>'+
                                '<select onchange="select_qDown('+id+','+n+'); edit('+id+')" class="form-control select" id="'+n+'select_question'+id+'" style="display:none">'+
                                    '<option>Seleecione o tipo de pergunta</option>'+
                                    '<option value="1">Dissertativa</option>'+
                                    '<option value="2">Multipla Escolha</option>'+
                                    // '<option value="3">Caixa de Seleção</option>'+
                                    // '<option value="4">Hora</option>'+
                                    // '<option value="5">Data</option>'+
                                '</select>'+
                            '</div>'+
                        '</li>'+
                        '<li>'+
                            '<a href="javascript:removeLine('+id+')"'+
                                'id="controlUp">'+
                                '<span class="fa fa-trash-o"></span>'+
                            '</a>'+
                        '</li>'+
                    '</ul>'+
                '</div>'+
                '<div class="panel-body">'+
                    '<textarea rows="5" disabled placeholder="Resposta do participante" class="form-control"></textarea>';
                '</div>'+
            '</div>'+
        '</li>';

    }

    //Criar questão alternativa
    function makeMultiple(i) {

        id = i+1
        n = Number(1);

        if(n == 1) {
            $("#saveBtn").attr('class', 'list-group-item btn-success');
        }


        return li =
            '<li id="question'+id+'">'+
                '<input type="hidden" id="count_'+id+'" value="5">'+
                '<input type="hidden" name="questionHidden'+id+'" id="questionHidden'+id+'">'+
                '<div class="panel panel-primary" id="questioncontent'+id+'">'+
                    '<div class="panel-heading ui-draggable-handle ui-sortable-handle">'+
                        '<textarea class="panel-title col-md-5" name="questionTitle" id="radio'+id+'" placeholder=" Título da Pergunta - Múltipla Escolha"></textarea>'+
                        '<ul class="panel-controls">'+
                            '<li>'+
                                '<div class="input-group">'+
                                    '<button type="button" onclick="makeRadio('+id+')"'+
                                        'class="btn btn-default btn-sm">Adicionar'+
                                        'Alternativa</button>'+
                                    '<button type="button" onclick="select_qUp('+id+','+n+')" class="btn btn-primary btn-sm" id="'+n+'selectBtn_question'+id+'">'+
                                        'Editar o Tipo de Pergunta'+
                                    '</button>'+
                                    '<select onchange="select_qDown('+id+','+n+'); edit('+id+')" class="form-control select" id="'+n+'select_question'+id+'" style="display:none">'+
                                        '<option>Seleecione o tipo de pergunta</option>'+
                                        '<option value="1">Dissertativa</option>'+
                                        '<option value="2">Multipla Escolha</option>'+
                                        // '<option value="3">Caixa de Seleção</option>'+
                                        // '<option value="4">Hora</option>'+
                                        // '<option value="5">Data</option>'+
                                    '</select>'+
                                '</div>'+
                            '</li>'+
                            '<li>'+
                                '<a href="javascript:removeLine('+id+')"'+
                                    'id="controlUp">'+
                                    '<span class="fa fa-trash-o"></span>'+
                                '</a>'+
                            '</li>'+
                        '</ul>'+
                    '</div>'+
                    '<div class="panel-body">'+
                        '<ul type="none" name="" id="question'+id+'list" style="padding: 0;">'+
                            radioBtn(id,n)+
                            radioBtn(id,n+1)+
                            radioBtn(id,n+2)+
                            radioBtn(id,n+3)+
                        '</ul>'+
                    '</div>'+
                '</div>'+
            '</li>';
        // return li;
    }

    //abre select de edição de pergunta
    function select_qUp(id,n) {
        $('#'+n+'select_question'+id).show();
        $('#'+n+'selectBtn_question'+id).hide();
    }

    //fecha select de edição de pergunta
    function select_qDown(id,n) {
        $('#'+n+'select_question'+id).hide();
        $('#'+n+'selectBtn_question'+id).show();
    }

    //exclui questão
    function removeLine(id) {
        if(myRows() == 1) {
            $("#saveBtn").attr('class', 'list-group-item btn-success disabled')
        }
        $('#question'+id).remove();
    }

    //gera html da alternativa com radio button
    function radioBtn(id,n) {
        $('#count_'+id).attr('value',Number(n)+1);
        var div =
        '<li id="radio'+id+'_'+n+'" name="radiobtnLi" class="align-center">'+
            '<div class="form-group col-md-12">'+
                '<label class="check col-md-12">'+
                    '<div class="icheckbox_minimal-grey checked col-md-1" style="position: relative;">'+
                        '<input type="radio" class="iradio" name="iradio" id="iradio'+id+'_'+n+'" checked="checked" style="position: absolute; opacity: 0;">'+
                    '</div>'+
                    '<div class="input-group col-md-11">'+
                        '<input type="text" name="radioBtninput" id="radio'+id+'_'+n+'" placeholder="Escreva a alternativa"'+
                            'class="form-control col-md-11">'+
                        '<a onclick="clearRadio('+id+','+n+')" '+
                            'title="Excluir alternativa" '+
                            'class="btn btn-default col-md-1">'+
                            '<span class="fa fa-trash-o"></span>'+
                        '</a>'+
                    '</div>'+
                '</label>'+
            '</div>'+
        '</li>';
        return div;
    }

    //apagar alternativa
    function clearRadio(id,n) {
        n = $("#radio"+id+"_"+n).remove();
    }

    //Cira altertnativa dentro da pergunta
    function makeRadio(id) {
        //pega número de alternativas que a pergunta já tem
        n = $('#count_'+id).val();

        radio = radioBtn(id,n);
        $("#question"+id+"list").append(radio);
    }

    function edit(id) {

        rows = myRows();

        if(id == 1) {
            $("#questioncontent"+id).remove()
            $("#question"+id).append(makeText(id))
        }
        else if(id == 2) {
            $("#questioncontent"+id).remove()
            $("#question"+id).append(makeMultiple(id))
        } else {
            alert('Erro! Selecione um tipo válido de pergunta!')
        }
        // else if(n === 3) {
        //     $("#questioncontent"+id).remove()
        //     $("#question"+id).append(makeCheckbox(rows))
        // }
        // else if(n === 4) {
        //     $("#questioncontent"+id).remove()
        //     $("#question"+id).append(makeHour(rows))
        // }
        // else if(n === 5) {
        //     $("#questioncontent"+id).remove()
        //     $("#question"+id).append(makeDate(rows))
        // } else {
        //     alert('Erro! Selecione um tipo válido de pergunta!')
        // }
    }

    function make(id) {

        rows = myRows();
        if(id == 0) {
            alert('Erro, contate o suporte')
        }
        else if(id == 1) {
            $("#perguntas").append(makeText(rows))
        }
        else if(id == 2) {
            $("#perguntas").append(makeMultiple(rows))
        } else {
            alert('Erro! Selecione um tipo válido de pergunta!')
        }
        // else if(n === 3) {
        //     $("#questioncontent"+id).remove()
        //     $("#question"+id).append(makeCheckbox(rows))
        // }
        // else if(n === 4) {
        //     $("#questioncontent"+id).remove()
        //     $("#question"+id).append(makeHour(rows))
        // }
        // else if(n === 5) {
        //     $("#questioncontent"+id).remove()
        //     $("#question"+id).append(makeDate(rows))
        // } else {
        //     alert('Erro! Selecione um tipo válido de pergunta!')
        // }
    }

    function deleteQuestions() {
        $.each( $("ul#perguntas > li"), function(index, value) {
            value.remove()
        });

        return false
    }

    function icheck(val) {
        if(val == 'on') {
            $("#icheckbox").val('on')
            $("#myCheck").attr('onclick',"icheck('off')")
            $("div.icheckbox_minimal-grey").attr('class','icheckbox_minimal-grey checked')
        } else if(val == 'off'){
            $("#icheckbox").val('off')
            $("#myCheck").attr('onclick',"icheck('on')")
            $("div.icheckbox_minimal-grey.checked").attr('class','icheckbox_minimal-grey')
        }
    }

    function checkVoid() {
        ok = 0;

        if($("#title").val() == '' || $("#ilhas").val() == null) {
            noty({
                        text: 'Preencha todos os campos corretamente',
                        timeout: 3000,
                        layout: 'topRight',
                        type: 'error',
            })
            ok++
        }

        $.each($('input[name=questionTitle]'),function(index,questions){
            if(questions.value == '') {

                ok++
            }
        })

        $.each($('input[name=radioBtninput]'),function(index,input){
            if(input.value == '') {
                ok++
            }
        })

        if(ok === 0) {
            saveQuiz()
        } else {
            noty({
                text: 'As <b>questões</b> e/ou <b>alternativas</b> não podem estar vazias',
                timeOut: 3000,
                layout: 'topRight',
                type: 'warning',
            })
        }


    }
    function nl2br (str, is_xhtml) {
        if (typeof str === 'undefined' || str === null) {
            return '';
        }
        var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
        return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
    }

    function saveQuiz() {
        //ativa btn preloader
        $(".fa.fa-cloud-upload").hide()
        $("#preloaderBtnsave").show()
        $("#saveBtn").attr('class','list-group-item btn-default disabled')

        //pega dados do form
        token = $("input[name=_token]").val()
        title = $("#title").val()
        descript = $("#descript").val()
        validity = $("#datepicker").val()
        icheckbox = $("#icheckbox").val()
        ilhas = $("#ilhas").val()
        qvalues = '' 
        question = ''

        //concatena questões
        $.each($('input[name=questionTitle]'),function(index,input){
            value = input.value
            id = input.id

            question += id+' _=_=_=_ '+value+'@|||||/*-@'
        })

        //concatena alternativas
        $.each($('input[name=radioBtninput]'),function(index,input){
            id = input.id.split("_")[0]

            value = input.value
            qvalues += id+' _=_=_=_ '+value+'@|||||/*-@'

        })

        data = '_token='+token+'&title='+title+'&descript='+descript+'&validity='+validity+'&icheckbox='+icheckbox+'&ilhas='+ilhas+'&question='+question+'&qvalues='+qvalues;

        $.ajax({
            type: "POST",
            url: "{{ asset( 'api/quiz/save/' ).'/'.Auth::user()->id }}",
            data: data,

            success: function (response) {
                console.log(response)
                //desativa btn preloader
                $(".fa.fa-cloud-upload").show()
                $("#preloaderBtnsave").hide()

                if(response.success) {
                    noty({
                        text: 'Quiz Criado com sucesso',
                        timeout: '2000',
                        layout: 'topRight',
                        type: 'success'
                    })
                }

                $("#viewquiz").show();

                if(response['multiple'].length > 1) {
                    window.location.replace("{{ asset('quiz/view/correct/') }}/"+response['id'])
                }
            },
            error: function(xhr, status) {
                console.log(xhr)

                $.each($(xhr.responseJSON.errors),function(i,text){
                        noty({
                            text: text,
                            timeout: 3000,
                            layout: 'topRight',
                            type: 'error',
                        })
                });

                noty({
                    text: xhr.responseJSON.message,
                    timeout: 3000,
                    layout: 'topRight',
                    type: 'error',
                })


                //desativa btn preloader
                $(".fa.fa-cloud-upload").show()
                $("#preloaderBtnsave").hide()

            }
        });

    }

    $(document).ready(function(){
        @if($errors->any())
            @foreach($errors-all() as $error)
                noty({
                    text: {{$error}},
                    timeout: 3000,
                    layout: 'topRight',
                    type: 'error',
                })
            @endforeach
        @endif
    })
</script>

