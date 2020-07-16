<script type="text/javascript">
    function getIlhaName(id,local,name) {
            $.getJSON('{{asset("/")}}api/data/ilha/'+id,function(data){
                $("#"+name+"ilhaName"+local).html(data[0].name);
            });
        }

        function getSetorName(id,local,name) {
            $.getJSON('{{asset("/")}}api/data/setores/'+id,function(data){
                $("#"+name+"getSetorName"+local).html(data.name);
            });
        }

        function getSubName(ilha,local,name) {
            $.getJSON('{{asset("/")}}api/data/sub_locais/byid/'+ilha,function(data){
                $("#"+name+"subLocal"+local).html(data.name);
            });
        }

</script>
<script type="text/javascript" id="notyJs">
    function notyConfirm(id,type){
            //Verifica qual o tipo arquivo (material, circular, roteiro, calculadora e video)
            if(type == 'script') {
                token = $("input[type=hidden][name=_token]").val();
                name = $("#nameScript"+id).val();
                sublocal = $("#sub_local_idScript"+id).val();
                ilha_id = $("#ilha_idScript"+id).val();
                setor_id = $("#setor_idScript"+id).val();

                data = '_token='+token+'&name='+name+'&sub_local_id='+sublocal+'&ilha_id='+ilha_id+'&setor_id='+setor_id+'&';
                noty({
                    text: 'Deseja alterar o Arquivo do Roteiro?',
                    layout: 'topRight',
                    buttons: [
                            {addClass: 'btn btn-success', text: 'Alterar Arquivo <span class="fa fa-file-text"></span>', onClick: function($noty) {
                                    $("#changescript"+id).attr('value','1');
                                    data += 'change="'+$("#changescript"+id).val();
                                    $.ajax({
                                        type: 'POST',
                                        url: "{{asset('/manager/script/edit')}}/"+id+"/{{ Auth::user()->id }}",
                                        data: data,
                                        success: function(xhr) {
                                            window.location.href = "{{asset('/manager/script/edit')}}/"+id;
                                        },
                                        error: function(xhr,status) {
                                            alert(status)
                                            myErrors = xhr.responseJSON.errors;
                                            console.log(xhr)
                                            console.log('data abaixo')
                                            console.log(data)
                                        }
                                    });

                                    $noty.close();
                                    noty({text: 'Salvo. Redirecionando...', layout: 'topRight', type: 'success', timeout: '3000'});
                                }
                            },
                            {addClass: 'btn btn-info btn-clean', text: 'Salvar', onClick: function($noty) {
                                $("#changescript"+id).attr('value','0');
                                    data += 'change="'+$("#changescript"+id).val();
                                    $.ajax({
                                        type: 'POST',
                                        url: "{{asset('/manager/script/edit')}}/"+id+"/{{ Auth::user()->id }}",
                                        data: data,
                                        success: function() {
                                        $("#succesAlert").show()
                                        setTimeout(function(){$("#succesAlert").hide()},5000)
                                        },
                                        error: function(xhr,status) {
                                            alert(status)
                                        console.log(xhr)
                                        }
                                    });

                                    $noty.close();
                                    noty({text: 'Salvo', layout: 'topRight', type: 'success', timeout: '3000'});
                                }
                            },
                            {addClass: 'btn btn-danger btn-clean', text: 'Cancelar', onClick: function($noty) {
                                $noty.close();
                                }
                            },
                        ]
                });
            } else if (type == 'circular') {
                token = $("input[type=hidden][name=_token]").val();
                name = $("#nameCirc"+id).val();
                number = $("#numberCirc"+id).val();
                year = $("#yearCirc"+id).val();
                segment = $("#segmentCirc"+id).val();
                ilha_id = $("#ilha_idCirc"+id).val();
                setor_id = $("#setor_idCirc"+id).val();
                status = $("#statusCirc"+id).val();

                data = '_token='+token+'&name='+name+'&number='+number+'&year='+year+'&segment='+segment+'&ilha_id='+ilha_id+'&setor_id='+setor_id+'&status='+status+'&';
                noty({
                    text: 'Deseja alterar o Arquivo da Circular?',
                    layout: 'topRight',
                    buttons: [
                                {addClass: 'btn btn-success', text: 'Alterar Arquivo <span class="fa fa-file-text"></span>', onClick: function($noty) {
                                    $("#changeCirc"+id).attr('value','1');
                                    data += 'change="'+$("#changeCirc"+id).val();
                                    $.ajax({
                                        type: 'POST',
                                        url: "{{asset('/manager/circular/edit')}}/"+id+"/{{ Auth::user()->id }}",
                                        data: data,
                                        success: function(xhr) {
                                            window.location.href = "{{asset('/manager/circular/edit')}}/"+id;
                                        },
                                        error: function(xhr,status) {
                                            alert(status)
                                            myErrors = xhr.responseJSON.errors;
                                            console.log(xhr)
                                            console.log('data abaixo')
                                            console.log(data)
                                        }
                                    });
                                    $noty.close();
                                    noty({text: 'Salvo. Redirecionando...', layout: 'topRight', type: 'success', timeout: '3000'});
                                    }
                                },//addClass
                                {addClass: 'btn btn-info btn-clean', text: 'Salvar', onClick: function($noty) {
                                    $("#changeCirc"+id).attr('value','0');
                                    data += 'change="'+$("#changeCirc"+id).val();
                                    $.ajax({
                                        type: 'POST',
                                        url: "{{asset('/manager/circular/edit')}}/"+id+"/{{ Auth::user()->id }}",
                                        data: data,
                                        success: function() {
                                        $("#succesAlert").show()
                                        setTimeout(function(){$("#succesAlert").hide()},5000)
                                        },
                                        error: function(xhr,status) {
                                            console.log(xhr)
                                        }
                                    });//ajax
                                    $noty.close();
                                    noty({text: 'Salvo', layout: 'topRight', type: 'success', timeout: '3000'});
                                    }//function($noty)
                                },
                                {addClass: 'btn btn-danger btn-clean', text: 'Cancelar', onClick: function($noty) {
                                    $noty.close();
                                    }
                                },//addClass
                            ]//buttons
                })//noty({})
            } else if(type == 'calculator') {
                token = $("input[type=hidden][name=_token]").val();
                name = $("#nameCalc"+id).val();
                sublocal = $("#sub_local_idCalc"+id).val();
                ilha_id = $("#ilha_idCalc"+id).val();
                setor_id = $("#setor_idCalc"+id).val();

                data = '_token='+token+'&name='+name+'&sub_local_id='+sublocal+'&ilha_id='+ilha_id+'&setor_id='+setor_id+'&';
                noty({
                    text: 'Deseja alterar o Arquivo da Calculadora?',
                    layout: 'topRight',
                    buttons: [
                                {addClass: 'btn btn-success', text: 'Alterar Arquivo <span class="fa fa-file-text"></span>', onClick: function($noty) {
                                        $("#changeCalc"+id).attr('value','1');
                                        data += 'change="'+$("#changeCalc"+id).val();
                                        $.ajax({
                                            type: 'POST',
                                            url: "{{asset('/manager/calculator/edit')}}/"+id+"/{{ Auth::user()->id }}",
                                            data: data,
                                            success: function(xhr) {
                                                window.location.href = "{{asset('/manager/calculator/edit')}}/"+id;
                                                $noty.close();
                                                noty({text: 'Salvo. Redirecionando...', layout: 'topRight', type: 'success', timeout: '3000'});
                                            },
                                            error: function(xhr,status) {

                                                $noty.close();
                                                noty({
                                                    text: 'Erro ao salvar.<br> Tente novamente mais tarde',
                                                    layout: 'topRight',
                                                    type: 'error',
                                                    timeout: '3000'
                                                });

                                                console.log(xhr)
                                                console.log('data abaixo')
                                                console.log(data)
                                            }
                                        });
                                    }
                                },//addClass
                                {addClass: 'btn btn-info btn-clean', text: 'Salvar', onClick: function($noty) {
                                    $("#changeCalc"+id).attr('value','0');
                                    data += 'change="'+$("#changeCalc"+id).val();
                                    $.ajax({
                                        type: 'POST',
                                        url: "{{asset('/manager/calculator/edit')}}/"+id+"/{{ Auth::user()->id }}",
                                        data: data,
                                        success: function() {
                                        $("#succesAlert").show()
                                        setTimeout(function(){$("#succesAlert").hide()},5000)
                                        },
                                        error: function(xhr,status) {
                                            alert(status)
                                            console.log(xhr)
                                        }
                                    });//ajax
                                    $noty.close();
                                    noty({text: 'Salvo', layout: 'topRight', type: 'success', timeout: '3000'});
                                    }//function($noty)
                                }//addClass
                                ,
                                {addClass: 'btn btn-danger btn-clean', text: 'Cancelar', onClick: function($noty) {
                                        $noty.close();
                                    }
                                },
                            ]//buttons
                })//noty({})
            } else if(type == 'material') {
                token = $("input[type=hidden][name=_token]").val();
                name = $("#nameMat"+id).val();
                sublocal = $("#sub_local_idMat"+id).val();
                ilha_id = $("#ilha_idMat"+id).val();
                setor_id = $("#setor_idMat"+id).val();

                data = '_token='+token+'&name='+name+'&sub_local_id='+sublocal+'&ilha_id='+ilha_id+'&setor_id='+setor_id+'&';
                noty({
                    text: 'Deseja alterar o Arquivo da Material?',
                    layout: 'topRight',
                    buttons: [
                                {addClass: 'btn btn-success', text: 'Alterar Arquivo <span class="fa fa-file-text"></span>', onClick: function($noty) {
                                        $("#changeMat"+id).attr('value','1');
                                        data += 'change="'+$("#changeMat"+id).val();
                                        $.ajax({
                                            type: 'POST',
                                            url: "{{asset('/manager/material/edit')}}/"+id+"/{{ Auth::user()->id }}",
                                            data: data,
                                            success: function(xhr) {
                                                window.location.href = "{{asset('/manager/material/edit')}}/"+id;
                                                $noty.close();
                                                noty({text: 'Salvo. Redirecionando...', layout: 'topRight', type: 'success', timeout: '3000'});
                                            },
                                            error: function(xhr,status) {

                                                $noty.close();
                                                noty({
                                                    text: 'Erro ao salvar.<br> Tente novamente mais tarde',
                                                    layout: 'topRight',
                                                    type: 'error',
                                                    timeout: '3000'
                                                });

                                                console.log(xhr)
                                                console.log('data abaixo')
                                                console.log(data)
                                            }
                                        });
                                    }
                                },//addClass
                                {addClass: 'btn btn-info btn-clean', text: 'Salvar', onClick: function($noty) {
                                    $("#changeMat"+id).attr('value','0');
                                    data += 'change="'+$("#changeMat"+id).val();
                                    $.ajax({
                                        type: 'POST',
                                        url: "{{asset('/manager/material/edit')}}/"+id+"/{{ Auth::user()->id }}",
                                        data: data,
                                        success: function() {
                                        $("#succesAlert").show()
                                        setTimeout(function(){$("#succesAlert").hide()},5000)
                                        },
                                        error: function(xhr,status) {
                                            alert(status)
                                            console.log(xhr)
                                        }
                                    });//ajax
                                    $noty.close();
                                    noty({text: 'Salvo', layout: 'topRight', type: 'success', timeout: '3000'});
                                    }//function($noty)
                                }//addClass
                                ,
                                {addClass: 'btn btn-danger btn-clean', text: 'Cancelar', onClick: function($noty) {
                                        $noty.close();
                                    }
                                },
                            ]//buttons
                })//noty({})
            } else if(type == 'video') {
                token = $("input[type=hidden][name=_token]").val();
                name = $("#nameVid"+id).val();
                sublocal = $("#sub_local_idVid"+id).val();
                ilha_id = $("#ilha_idVid"+id).val();
                setor_id = $("#setor_idVid"+id).val();

                data = '_token='+token+'&name='+name+'&sub_local_id='+sublocal+'&ilha_id='+ilha_id+'&setor_id='+setor_id+'&';
                noty({
                    text: 'Deseja alterar o Arquivo da Video?',
                    layout: 'topRight',
                    buttons: [
                                {addClass: 'btn btn-success', text: 'Alterar Arquivo <span class="fa fa-file-text"></span>', onClick: function($noty) {
                                        $("#changeVid"+id).attr('value','1');
                                        data += 'change="'+$("#changeVid"+id).val();
                                        $.ajax({
                                            type: 'POST',
                                            url: "{{asset('/manager/video/edit')}}/"+id+"/{{ Auth::user()->id }}",
                                            data: data,
                                            success: function(xhr) {
                                                window.location.href = "{{asset('/manager/video/edit')}}/"+id;
                                                $noty.close();
                                                noty({text: 'Salvo. Redirecionando...', layout: 'topRight', type: 'success', timeout: '3000'});
                                            },
                                            error: function(xhr,status) {

                                                $noty.close();
                                                noty({
                                                    text: 'Erro ao salvar.<br> Tente novamente mais tarde',
                                                    layout: 'topRight',
                                                    type: 'error',
                                                    timeout: '3000'
                                                });

                                                console.log(xhr)
                                                console.log('data abaixo')
                                                console.log(data)
                                            }
                                        });
                                    }
                                },//addClass
                                {addClass: 'btn btn-info btn-clean', text: 'Salvar', onClick: function($noty) {
                                    $("#changeVid"+id).attr('value','0');
                                    data += 'change="'+$("#changeVid"+id).val();
                                    $.ajax({
                                        type: 'POST',
                                        url: "{{asset('/manager/video/edit')}}/"+id+"/{{ Auth::user()->id }}",
                                        data: data,
                                        success: function() {
                                        $("#succesAlert").show()
                                        setTimeout(function(){$("#succesAlert").hide()},5000)
                                        },
                                        error: function(xhr,status) {
                                            alert(status)
                                            console.log(xhr)
                                        }
                                    });//ajax
                                    $noty.close();
                                    noty({text: 'Salvo', layout: 'topRight', type: 'success', timeout: '3000'});
                                    }//function($noty)
                                }//addClass
                                ,
                                {addClass: 'btn btn-danger btn-clean', text: 'Cancelar', onClick: function($noty) {
                                        $noty.close();
                                    }
                                },
                            ]//buttons
                })//noty({})
            }//end if de verificação de tipo

        }//notyConfirm(id,type)

        //apaga material
        function notyDelete(id,type){
            if(type == 'circular') {
                noty({
                    text: 'Deseja excluir o Arquivo?',
                    layout: 'topRight',
                    buttons: [
                            {addClass: 'btn btn-success', text: 'Excluir', onClick: function($noty) {
                                $("#changescript"+id).attr('value','1');
                                $.ajax({
                                    type: 'DELETE',
                                    url: "{{asset('/manager/circular/delete')}}/"+id+"/{{ Auth::user()->id }}",
                                    success: function(xhr) {
                                        $("#trCircular"+id).remove()
                                        $noty.close();
                                        noty({text: 'Circular excluído com sucesso.', layout: 'topRight', type: 'success', timeout: '3000'});
                                    },
                                    error: function(xhr,status) {
                                        $noty.close();
                                        noty({text: 'Erro ao excluir circular. <br>Tente novamente mais tarde', layout: 'topRight', type: 'error', timeout: '3000'});
                                        console.log(xhr)
                                    }
                                })

                            }
                            },
                            {addClass: 'btn btn-danger btn-clean', text: 'Cancelar', onClick: function($noty) {
                                $noty.close();
                                }
                            },
                        ]
                });
            } else if (type == 'script') {
                noty({
                    text: 'Deseja excluir o Arquivo?',
                    layout: 'topRight',
                    buttons: [
                            {addClass: 'btn btn-success', text: 'Excluir', onClick: function($noty) {
                                $.ajax({
                                    type: 'DELETE',
                                    url: "{{asset('/manager/script/delete')}}/"+id+"/{{ Auth::user()->id }}",
                                    success: function(xhr) {
                                        $("#trroteiro"+id).remove()
                                        $noty.close();
                                        noty({text: 'Roteiro excluído com sucesso.', layout: 'topRight', type: 'success', timeout: '3000'});
                                    },
                                    error: function(xhr,status) {
                                        $noty.close();
                                        noty({text: 'Erro ao excluir roteiro. <br>Tente novamente mais tarde', layout: 'topRight', type: 'error', timeout: '3000'});
                                        console.log(xhr)
                                    }
                                })

                            }
                            },
                            {addClass: 'btn btn-danger btn-clean', text: 'Cancelar', onClick: function($noty) {
                                $noty.close();
                                }
                            }
                        ]
                });
            } else if (type == 'calculator') {
                noty({
                    text: 'Deseja excluir o Arquivo?',
                    layout: 'topRight',
                    buttons: [
                            {addClass: 'btn btn-success', text: 'Excluir', onClick: function($noty) {
                                $.ajax({
                                    type: 'DELETE',
                                    url: "{{asset('/manager/calculator/delete')}}/"+id+"/{{ Auth::user()->id }}",
                                    success: function(xhr) {
                                        $("#trcalculadora"+id).remove()
                                        $noty.close();
                                        noty({text: 'Calculadora excluída com sucesso.', layout: 'topRight', type: 'success', timeout: '3000'});
                                    },
                                    error: function(xhr,status) {
                                        $noty.close();
                                        noty({text: 'Erro ao excluir calculadora. <br>Tente novamente mais tarde', layout: 'topRight', type: 'error', timeout: '3000'});
                                        console.log(xhr)
                                    }
                                })

                            }
                            },
                            {addClass: 'btn btn-danger btn-clean', text: 'Cancelar', onClick: function($noty) {
                                $noty.close();
                                }
                            }
                        ]
                });
            } else if(type == 'material') {
                noty({
                    text: 'Deseja excluir o Arquivo?',
                    layout: 'topRight',
                    buttons: [
                            {addClass: 'btn btn-success', text: 'Excluir', onClick: function($noty) {
                                $.ajax({
                                    type: 'DELETE',
                                    url: "{{asset('/manager/material/delete')}}/"+id+"/{{ Auth::user()->id }}",
                                    success: function(xhr) {
                                        $("#trmaterial"+id).remove()
                                        $noty.close();
                                        noty({text: 'Material excluído com sucesso.', layout: 'topRight', type: 'success', timeout: '3000'});
                                    },
                                    error: function(xhr,status) {
                                        $noty.close();
                                        noty({text: 'Erro ao excluir Material. <br>Tente novamente mais tarde', layout: 'topRight', type: 'error', timeout: '3000'});
                                        console.log(xhr)
                                    }
                                })

                            }
                            },
                            {addClass: 'btn btn-danger btn-clean', text: 'Cancelar', onClick: function($noty) {
                                $noty.close();
                                }
                            }
                        ]
                });
            } else if(type == 'video') {
                noty({
                    text: 'Deseja excluir o Arquivo?',
                    layout: 'topRight',
                    buttons: [
                            {addClass: 'btn btn-success', text: 'Excluir', onClick: function($noty) {
                                $.ajax({
                                    type: 'DELETE',
                                    url: "{{asset('/manager/video/delete')}}/"+id+"/{{ Auth::user()->id }}",
                                    success: function(xhr) {
                                        $("#trvideo"+id).remove()
                                        $noty.close();
                                        noty({text: 'Video excluído com sucesso.', layout: 'topRight', type: 'success', timeout: '3000'});
                                    },
                                    error: function(xhr,status) {
                                        $noty.close();
                                        noty({text: 'Erro ao excluir Video. <br>Tente novamente mais tarde', layout: 'topRight', type: 'error', timeout: '3000'});
                                        console.log(xhr)
                                    }
                                })

                            }
                            },
                            {addClass: 'btn btn-danger btn-clean', text: 'Cancelar', onClick: function($noty) {
                                $noty.close();
                                }
                            }
                        ]
                });
            }//end if de verificação de tipo

        }
</script>
