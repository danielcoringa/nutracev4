jQuery(document).ready(function($) {
    var options = {
//  target:        '#output1',   // target element(s) to be updated with server response
        beforeSubmit: validacao, // pre-submit callback
        success: showDialog, // post-submit callback
        uploadProgress: function(event, position, total, percentComplete) {
            $(".percent-status").html(percentComplete + '% salvo.');
            // $('.envio_bar').html(percentVal);
            $('.percent').progressbar({value: percentComplete});
            $(".envio_bar").attr("style", "width:" + percentComplete + "%");
        },
        complete: function() {
            $('.envio_bar').html('Concluído!');
            $(".percent-status").html('Registro salvo com sucesso.');
            $('.percent').progressbar({value: 100});
            $(".envio_bar").attr("style", "width:100%");
        },
        // other available options:
        // url: '/anuncios/novo/tipo/vender', // override for form's 'action' attribute
        //type:      type        // 'get' or 'post', override for form's 'method' attribute
        //dataType:  null        // 'xml', 'script', or 'json' (expected server response type)
        //clearForm: true        // clear all form fields after successful submit
        //resetForm: true        // reset the form after successful submit
        // jQuery.ajax options can be used here too, for example:
        //timeout:   3000
    };
    $(document).ajaxComplete(function(e,d,f) {
        if(d.status==500){
            if(f.url==="/artigos/flickr"){
                callFlickr();
            }
            if(f.url==="/artigos/soundcloud"){
                callSoundCloud();
            }
            if(f.url==="/artigos/vimeo"){
                callVimeo();
            }
            if(f.url==="/artigos/youtube"){
                callYoutube();
            }
        }
        $(".scroller").slimScroll();
    });
    $(document).on("click", ":submit", function() {
        $("#fmartigo").unbind('submit');
        $("#fmartigo").validate();
        $('.ajax-form').ajaxForm(options);
    })
    $('.ajax-form').ajaxForm(options);
    $(".controle").append("<button class='btn btn-primary new-reg'><i class='fa fa-plus'></i> Novo Registro</button>&nbsp;");
    $(".controle").append("<button class='btn btn-default edit-reg'><i class='fa fa-pencil'></i> Editar Registro</button>&nbsp;");
    $(".controle").append("<button class='btn btn-danger del-reg'><i class='fa fa-trash-o'></i> Excluir Registro</button>&nbsp;");
    $("form").validate();
    //Hack para o CKEditor
    $("form").bind("mousemove", function() {
        $('.ckeditor').each(function() {
            var $textarea = $(this);
            $(this).html(CKEDITOR.instances[$textarea.attr('name')].getData());
            $(this).val(CKEDITOR.instances[$textarea.attr('name')].getData());
        });
    });
    $(".select").select2({placeholder: "Selecione uma Opção", allowClear: !0});
    $(".tags").select2({tags: ["red", "green", "blue"]});
    $("#img_artigo").bind("change", function() {
        setTimeout(function() {
            var imgtmp = $(".fileinput-preview").find("img");
            $("#widget-image-pv img").attr("src", imgtmp.attr("src"));
        }, 100);
    });
    $(".format input:radio").bind("change", function() {
        $(".widget").hide("highlight");
        var ctrl = $(this).val();
        $('#widget-' + ctrl).toggle('fast');
        if (ctrl === 'video') {
            $.ajax({
                url: '/artigos/youtube',
                type: 'get',
                success: function(data) {
                    $("#box_tab1").html(data);
                    callVimeo();
                }
            });
        }
        setTimeout(function() {
            $('#' + ctrl).addClass('highlight');
        }, 400);
        setTimeout(function() {
            $('#' + ctrl).removeClass('highlight');
        }, 800);
        $('#widget-' + ctrl + '-pv').toggle('fast');
        scrollto('#' + ctrl);
    });
    $("#bttag").bind("click", function() {
        var valor = $("#e8").val();
        if (valor !== '') {
            $("#e8").val(valor + ',' + $("#edtag").val());
        } else {
            $("#e8").val($("#edtag").val());
        }
        $("#e8").select2({tags: []});
        $("#edtag").val('');
        //$(".select2-choices").prepend("<li class='select2-search-choice'><div>"+$("#edtag").val()+"</div><a href='#' onclick='return false;' class='select2-search-choice-close' tabindex='-1'></a></li>");
    });
    $("#edtag").bind("keypress", function(e) {
        var tecla = (e.keyCode ? e.keyCode : e.which);
        if (tecla === 13) {
            var valor = $("#e8").val();
            if (valor !== '') {
                $("#e8").val(valor + ',' + $("#edtag").val());
            } else {
                $("#e8").val($("#edtag").val());
            }
            $("#e8").select2({tags: []});
            $("#edtag").val('');
            e.preventDefault(e);
            return false;
        }
    });
    $(".deleteimg").bind("click", function(e) {
        e.preventDefault();
        var dados = $(this).data("cod");
        bootbox.dialog(
                {
                    message: "Tem certeza que deseja excluir a imagem da galeria?",
                    title: "Excluir Imagem",
                    buttons: {
                        success: {
                            label: "Sim",
                            className: "btn-success",
                            callback: function() {
                                var trs = $(".deleteimg");
                                $.ajax({
                                    url: '/artigos/galeria-exclude',
                                    type: 'post',
                                    data: {codimg: dados}
                                }).done(function() {
                                    $.each(trs, function(e, d) {
                                        if ($(d).data('cod') === dados) {
                                            $(d).parent().parent().hide("slow")
                                        }
                                    });
                                    $(".bootbox").modal("hide");
                                });
                            }
                        },
                        cancel: {
                            label: "Não",
                            className: "btn-warning",
                            callback: function() {
                                $(".bootbox").modal("hide");
                                return false;
                            }
                        }
                    }
                });
    });
    $(document).on("click", '.reload', function() {
        var content = $(this).parent().parent().parent().parent();
        var url = $(this).data('url');
        $.ajax({
            url: '/artigos/refresh',
            type: 'post',
            data: {'url': url},
            success: function(data) {
                content.html(data);
            }
        });
    });
});
validacao = function() {
    $(":submit").attr("disabled", "disabled");
    if ($("form").valid() !== false) {
        if ($('#v_gallery').lenght > 0) {
            var val = $("#v_gallery").val();
            if (val === '') {
                bootbox.alert("É necessário enviar as imagens para a galeria antes de continuar.");
                $(":submit").removeAttr("disabled");
                scrollto('#gallery');
                return false;
            } else {
                bootbox.alert("Aguarde... Salvando o Registro.<br/>" +
                        "<h4 class='percent-status'></h4>" +
                        "<div class='progress progress-striped active'>" +
                        "<span class='sr-only percent'></span>" +
                        "<div class='progress-bar bar envio_bar'  role='progressbar' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100'>" +
                        "</div></div>");
                return true;
            }
        } else {
            bootbox.alert("Aguarde... Salvando o Registro.<br/>" +
                    "<h4 class='percent-status'></h4>" +
                    "<div class='progress progress-striped active'>" +
                    "<span class='sr-only percent'></span>" +
                    "<div class='progress-bar bar envio_bar'  role='progressbar' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100'>" +
                    "</div></div>");
            return true;
        }
    } else {
        $(":submit").removeAttr("disabled");
        return false;
    }
};
showDialog = function(data) {
    $(":submit").removeAttr("disabled");
    bootbox.dialog(
            {
                message: "Registro Salvo com Sucesso! Deseja cadastrar outro Registro?",
                title: "Novo Registro",
                buttons: {
                    success: {
                        label: "Sim!",
                        className: "btn-success",
                        callback: function() {
                            $("form")[0].reset();
                            location = '/' + data + '/cadastro/novo';
                        }
                    },
                    cancel: {
                        label: "Não",
                        className: "btn-warning",
                        callback: function() {
                            $(".bootbox").modal("hide");
                            location = '/' + data;
                            return false;
                        }
                    }
                }
            });
    setTimeout(function() {
        $(".bootbox").modal("hide");
        //  location = '/' + data + '/cadastro/novo';
    }, 3000);
};
// Codigos Personalizados
coringa = {
    buttons: function() {
        $(".new-reg").bind("click", function() {
            location = '/' + mode_buttons + '/cadastro/novo';
        });
        $(".edit-reg").bind("click", function() {
            var checks = $(".optcheck:checked");
            if (checks.length < 1) {
                bootbox.alert("Selecione um registro para edição");
            } else {
                location = '/' + mode_buttons + '/cadastro/editar/' + $(checks[0]).val();
            }
        });
        $(".del-reg").bind("click", function() {
            var checks = $(".optcheck:checked");
            if (checks.length < 1) {
                bootbox.alert("Selecione um ou mais registros para exclusão");
            } else {
                bootbox.dialog({
                    message: "Tem certeza que deseja excluir os registros selecionados?",
                    title: "Excluir Registros",
                    buttons: {
                        success: {
                            label: "Sim",
                            className: "btn-success",
                            callback: function() {
                                var dados = new Array();
                                for (i = 0; i < checks.length; i++) {
                                    dados.push($(checks[i]).val());
                                }
                                $.ajax({
                                    url: '/lixeira/excluir/',
                                    type: 'post',
                                    data: {tbl: mode_buttons, ids: dados},
                                    success: function(retorno) {
                                        eval(retorno);
                                    }
                                });
                            }
                        },
                        danger: {
                            label: "Não",
                            className: "btn-danger",
                            callback: function() {
                                $(".bootbox").modal("hide");
                            }}
                    }
                });
            }
        });
    },
    youtube: function() {
        $(".scroller").slimScroll();
        $("#yt-search").bind("keypress", function(e) {
            var tecla = (e.keyCode ? e.keyCode : e.which);
            if (tecla === 13) {
                $("#youtube_result").html('<h3 class="loading">Aguarde! Carregando resultados do Youtube...</h3>');
                $.ajax({
                    url: '/artigos/search-yt/busca/' + $("#yt-search").val(),
                    type: 'get',
                    success: function(data) {
                        $("#youtube_result").html(data);
                    }
                });
                e.preventDefault(e);
                return false;
            }
        });
        $(".btn-search-yt").bind("click", function() {
            $.ajax({
                url: '/artigos/search-yt/busca/' + $("#yt-search").val(),
                type: 'get',
                success: function(data) {
                    $("#youtube_result").html(data);
                }
            });
        });
        $(".timeago").timeago();
        $('.accordion.blue a').bind("click", function() {
            $(".accordion.blue .active").removeClass("active");
        });
        $.ajax({
            url: '/artigos/upload-yt',
            type: 'get',
            success: function(data) {
                $("#fm-yt-ajx").html(data);
            }
        });
        $(".del-video").bind("click", function() {
            var id = $(this).parent().parent().data("id");
            bootbox.dialog(
                    {
                        message: "Deseja excluir o vídeo selecionado do Youtube? Essa Ação não tem retorno.",
                        title: "Excluir Vídeo",
                        buttons: {
                            success: {
                                label: "Sim",
                                className: "btn-danger",
                                callback: function() {
                                    $(".bootbox").modal("hide");
                                    $.ajax({
                                        url: '/artigos/delete-yt',
                                        type: 'post',
                                        data: {video_id: id},
                                        success: function(data) {
                                            eval(data);
                                        }
                                    });
                                    return false;
                                }
                            },
                            cancel: {
                                label: "Fechar",
                                className: "btn-default",
                                callback: function() {
                                    $(".bootbox").modal("hide");
                                    return false;
                                }
                            }
                        }
                    });
        });
        $(".edit-yt").bind("click", function() {
            var id = $(this).parent().parent().data("id");
            bootbox.dialog(
                    {
                        message: "<div id='fm_edit_yt'>Carregando Informações</div>",
                        title: "Editar Informações do Vídeo",
                        buttons: {
                            success: {
                                label: "Salvar",
                                className: "btn-success",
                                callback: function() {
                                    //$(".bootbox").modal("hide");
                                    $("#fm_youtube").ajaxForm({complete: function() {
                                            $(".bootbox").modal("hide");
                                            $.ajax({
                                                url: '/artigos/youtube',
                                                type: 'get',
                                                success: function(data) {
                                                    $("#box_tab1").html(data);
                                                }
                                            })
                                        }});
                                    $("#fm_youtube").submit();
                                    return false;
                                }
                            },
                            cancel: {
                                label: "Cancelar",
                                className: "btn-danger",
                                callback: function() {
                                    $(".bootbox").modal("hide");
                                    return false;
                                }
                            }
                        }
                    });
            setTimeout(function() {
                $.ajax({
                    url: '/artigos/form-edit-yt',
                    type: 'post',
                    data: {video_id: id},
                    success: function(data) {
                        $("#fm_edit_yt").html(data);
                    }
                });
            }, 300);
        });
        $(".preview-yt").bind("click", function() {
            $(".bootbox").modal("hide");
            //console.log($(this).parent().parent().data("link"));
            var id = $(this).parent().parent().data("id");
            bootbox.dialog(
                    {
                        message: "<div id='player'></div>",
                        title: "Previsualizar Vídeo",
                        buttons: {
                            cancel: {
                                label: "Fechar",
                                className: "btn-warning",
                                callback: function() {
                                    $(".bootbox").modal("hide");
                                    return false;
                                }
                            }
                        }
                    });
            setTimeout(function() {
                var link = $(this).parent().parent().data("link");
                $(".modal-body").addClass("remove-padding");
                $("#player").html('<embed width="100%" height="320" src="http://www.youtube.com/v/' + id + '&autoplay=1&rel=0&showinfo=0" type="application/x-shockwave-flash" allowFullScreen="true"> </embed>')
            }, 200);
        });
        $(".use-video").bind("click", function() {
            var idfile = $(this).parent().parent().data("idfile");
            var id = $(this).parent().parent().data("id");
            $("#player-video").html('<embed width="100%" height="320" src="http://www.youtube.com/v/' + id + '&autoplay=0&rel=0&showinfo=0" type="application/x-shockwave-flash" allowFullScreen="true"> </embed>');
            $("#video_artigo").append("<input type='text' name='id_video' id='id_video' value='" + id + "' />");
            $("#video_artigo").append("<input type='text' name='id_file' id='id_file' value='" + idfile + "' />");
            $("#video_artigo").append("<input type='text' name='tipo_video' id='tipo_video' value='youtube' />");
        });
    },
    enterForTab: function() {
        $("form:input").bind("keydown", function(e) {
            var tecla = (e.keyCode ? e.keyCode : e.which);
            /* verifica se a tecla pressionada foi o ENTER */
            if (tecla === 13) { /* guarda o seletor do campo que foi pressionado Enter */
                campo = $('input'); /* pega o indice do elemento*/
                indice = campo.index(this); /*soma mais um ao indice e verifica se não é null *se não for é porque existe outro elemento */
                if (campo[indice + 1] != null) { /* adiciona mais 1 no valor do indice */
                    proximo = campo[indice + 1]; /* passa o foco para o proximo elemento */
                    proximo.focus();
                }
            }
            e.preventDefault(e);
            return false;
        });
    },
    vimeo: function() {
        $(".timeago").timeago();
        $(".scroller").slimScroll();
        //coringa.youtube();
        $(".btn-search-vm").bind("click", function() {
            $("#vimeo_result").html('<h3 class="loading">Aguarde! Carregando resultados do Vimeo...</h3>');
            $.ajax({
                url: '/artigos/search-vm/busca/' + $("#vm-search").val(),
                type: 'get',
                success: function(data) {
                    $("#vimeo_result").html(data);
                }
            });
        });
        $("#vm-search").bind("keypress", function(e) {
            var tecla = (e.keyCode ? e.keyCode : e.which);
            if (tecla === 13) {
                $("#vimeo_result").html('<h3 class="loading">Aguarde! Carregando resultados do Vimeo...</h3>');
                $.ajax({
                    url: '/artigos/search-vm/busca/' + $("#vm-search").val(),
                    type: 'get',
                    success: function(data) {
                        $("#vimeo_result").html(data);
                    }
                });
                e.preventDefault(e);
                return false;
            }
        });
        $(".edit-vm").bind("click", function() {
            var id = $(this).parent().parent().data("id");
            bootbox.dialog(
                    {
                        message: "<div id='fm_edit_vm'>Carregando Informações</div>",
                        title: "Editar Informações do Vídeo",
                        buttons: {
                            success: {
                                label: "Salvar",
                                className: "btn-success",
                                callback: function() {
                                    //$(".bootbox").modal("hide");
                                    $("#fm_vimeo").ajaxForm({complete: function() {
                                            $(".bootbox").modal("hide");
                                            callVimeo();
                                        }});
                                    $("#fm_vimeo").submit();
                                    return false;
                                }
                            },
                            cancel: {
                                label: "Cancelar",
                                className: "btn-danger",
                                callback: function() {
                                    $(".bootbox").modal("hide");
                                    return false;
                                }
                            }
                        }
                    });
            setTimeout(function() {
                $.ajax({
                    url: '/artigos/form-edit-vm',
                    type: 'post',
                    data: {video_id: id},
                    success: function(data) {
                        $("#fm_edit_vm").html(data);
                    }
                });
            }, 300);
        });
        $(".preview-vm").bind("click", function() {
            //console.log($(this).parent().parent().data("link"));
            var id = $(this).parent().parent().data("id");
            $(".bootbox").modal("hide");
            bootbox.dialog(
                    {
                        message: "<div id='player'></div>",
                        title: "Previsualizar Vídeo",
                        buttons: {
                            cancel: {
                                label: "Fechar",
                                className: "btn-warning",
                                callback: function() {
                                    $(".bootbox").modal("hide");
                                    return false;
                                }
                            }
                        }
                    });
            setTimeout(function() {
                var link = $(this).parent().parent().data("link");
                $(".modal-body").addClass("remove-padding");
                $("#player").html('<iframe src="//player.vimeo.com/video/' + id + '?autoplay=1" width="100%" height="320" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>')
            }, 200);
        });
        $('#fm_vm').ajaxForm({
            beforeSend: function() {
                $('#but_vm_enviar').attr('disabled', 'disabled');
                //$('#status').empty();
                var percentVal = '0%';
                $('#prgb-vm').show('slow');
                //  $('.envio_bar').html(percentVal);
                $(".percent-status-vm").html('Aguardando envio para o Vimeo.');
                $('.percent-vm').progressbar({value: 0});
            },
            uploadProgress: function(event, position, total, percentComplete) {
                var percentVal = percentComplete + '%';
                $(".percent-status-vm").html(percentComplete + '% enviados para o Vimeo.');
                // $('.envio_bar').html(percentVal);
                $('.percent-vm').progressbar({value: percentComplete});
                $(".envio_bar-vm").attr("style", "width:" + percentComplete + "%");
            },
            complete: function() {
                $('.envio_bar-vm').html('Concluído!');
                $(".percent-status-vm").html('Vídeo enviado para o Vimeo com sucesso.');
                $('.percent-vm').progressbar({value: 100});
                $(".envio_bar-vm").attr("style", "width:100%");
                $.ajax({
                    url: '/artigos/vimeo',
                    type: 'get',
                    success: function(data) {
                        $("#box_tab2").html(data);
                    }
                });
            }
        });
        $(".del-video-vm").bind("click", function() {
            var id = $(this).parent().parent().data("id");
            bootbox.dialog(
                    {
                        message: "Deseja excluir o vídeo selecionado do Vimeo? Essa Ação não tem retorno.",
                        title: "Excluir Vídeo",
                        buttons: {
                            success: {
                                label: "Sim",
                                className: "btn-danger",
                                callback: function() {
                                    $(".bootbox").modal("hide");
                                    $.ajax({
                                        url: '/artigos/delete-vm',
                                        type: 'post',
                                        data: {video_id: id},
                                        success: function(data) {
                                            eval(data);
                                        }
                                    });
                                    return false;
                                }
                            },
                            cancel: {
                                label: "Fechar",
                                className: "btn-default",
                                callback: function() {
                                    $(".bootbox").modal("hide");
                                    return false;
                                }
                            }
                        }
                    });
        });
        $(".use-video-vm").bind("click", function() {
            var idfile = $(this).parent().parent().data("idfile");
            var id = $(this).parent().parent().data("id");
            $("#player-video").html('<iframe src="//player.vimeo.com/video/' + id + '?autoplay=1" width="100%" height="320" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>');
            $("#video_artigo").append("<input type='text' name='id_video' id='id_video' value='" + id + "' />");
            $("#video_artigo").append("<input type='text' name='id_file' id='id_file' value='" + idfile + "' />");
            $("#video_artigo").append("<input type='text' name='tipo_video' id='tipo_video' value='vimeo' />");
        });
    },
    soundcloud: function() {
        $(".timeago").timeago();
        $(".scroller").slimScroll();
        $(".btn-search-sc").bind("click", function() {
            $("#sc_result").html('<h3 class="loading">Aguarde! Carregando resultados do SoundCloud...</h3>');
            $.ajax({
                url: '/artigos/search-sc/busca/' + $("#sc-search").val(),
                type: 'get',
                success: function(data) {
                    $("#sc_result").html(data);
                }
            });
        });
        $("#sc-search").bind("keypress", function(e) {
            var tecla = (e.keyCode ? e.keyCode : e.which);
            if (tecla === 13) {
                $("#sc_result").html('<h3 class="loading">Aguarde! Carregando resultados do SoundCloud...</h3>');
                $.ajax({
                    url: '/artigos/search-sc/busca/' + $("#sc-search").val(),
                    type: 'get',
                    success: function(data) {
                        $("#sc_result").html(data);
                    }
                });
                e.preventDefault(e);
                return false;
            }
        });
        $(".preview-sc").bind("click", function() {
            //console.log($(this).parent().parent().data("link"));
            var id = $(this).parent().parent().data("id");
            $(".bootbox").modal("hide");
            bootbox.dialog(
                    {
                        message: "<div id='player'></div>",
                        title: "Previsualizar Audio",
                        buttons: {
                            cancel: {
                                label: "Fechar",
                                className: "btn-warning",
                                callback: function() {
                                    $(".bootbox").modal("hide");
                                    return false;
                                }
                            }
                        }
                    });
            setTimeout(function() {
                var link = $(this).parent().parent().data("link");
                $(".modal-body").addClass("remove-padding");
                $("#player").html('<iframe width="100%" height="166" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/' + id + '&amp;color=ff6600&amp;auto_play=true&amp;show_artwork=true"></iframe>')
            }, 200);
        });
        $(".edit-sc").bind("click", function() {
            var id = $(this).parent().parent().data("id");
            bootbox.dialog(
                    {
                        message: "<div id='fm_edit_sc'>Carregando Informações</div>",
                        title: "Editar Informações do Audio",
                        buttons: {
                            success: {
                                label: "Salvar",
                                className: "btn-success",
                                callback: function() {
                                    //$(".bootbox").modal("hide");
                                    $("#fm_audio").ajaxForm({complete: function() {
                                            $(".bootbox").modal("hide");
                                            callSoundCloud();
                                        }});
                                    $("#fm_audio").submit();
                                    return false;
                                }
                            },
                            cancel: {
                                label: "Cancelar",
                                className: "btn-danger",
                                callback: function() {
                                    $(".bootbox").modal("hide");
                                    return false;
                                }
                            }
                        }
                    });
            setTimeout(function() {
                $.ajax({
                    url: '/artigos/form-edit-sc',
                    type: 'post',
                    data: {audio_id: id},
                    success: function(data) {
                        $("#fm_edit_sc").html(data);
                    }
                });
            }, 300);
        });
        $('#fm_sc').ajaxForm({
            beforeSend: function() {
                $('#but_sc_enviar').attr('disabled', 'disabled');
                //$('#status').empty();
                var percentVal = '0%';
                $('#prgb-sc').show('slow');
                //  $('.envio_bar').html(percentVal);
                $(".percent-status-sc").html('Aguardando envio para o SoundCloud.');
                $('.percent-sc').progressbar({value: 0});
            },
            uploadProgress: function(event, position, total, percentComplete) {
                var percentVal = percentComplete + '%';
                if (percentComplete < 100) {
                    $(".percent-status-sc").html(percentComplete + '% enviados para o SoundCloud.');
                } else {
                    $(".percent-status-sc").html('Convertendo arquivo enviado. Aguarde...');
                }
                // $('.envio_bar').html(percentVal);
                $('.percent-sc').progressbar({value: percentComplete});
                $(".envio_bar-sc").attr("style", "width:" + percentComplete + "%");
            },
            complete: function() {
                $('.envio_bar-sc').html('Concluído!');
                $(".percent-status-sc").html('Vídeo enviado para o SoundCloud com sucesso.');
                $('.percent-sc').progressbar({value: 100});
                $(".envio_bar-sc").attr("style", "width:100%");
                callSoundCloud();
            }
        });
        $(".del-audio").bind("click", function() {
            var id = $(this).parent().parent().data("id");
            bootbox.dialog(
                    {
                        message: "Deseja excluir o audio selecionado do SoundCloud? Essa Ação não tem retorno.",
                        title: "Excluir Vídeo",
                        buttons: {
                            success: {
                                label: "Sim",
                                className: "btn-danger",
                                callback: function() {
                                    $(".bootbox").modal("hide");
                                    $.ajax({
                                        url: '/artigos/delete-sc',
                                        type: 'post',
                                        data: {audio_id: id},
                                        success: function(data) {
                                            eval(data);
                                        }
                                    });
                                    return false;
                                }
                            },
                            cancel: {
                                label: "Fechar",
                                className: "btn-default",
                                callback: function() {
                                    $(".bootbox").modal("hide");
                                    return false;
                                }
                            }
                        }
                    });
        });
        $(".use-audio").bind("click", function() {
            var nomusica = $(this).parent().parent().data("title");
            var id = $(this).parent().parent().data("id");
            $("#player-audio").html('<iframe width="100%" height="166" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/' + id + '&amp;color=ff6600&amp;auto_play=true&amp;show_artwork=true"></iframe>');
            $("#audio_artigo").append("<input type='text' name='id_audio' id='id_audio' value='" + id + "' />");
            $("#audio_artigo").append("<input type='text' name='nom_musica' id='nom_musica' value='" + nomusica + "' />");
        });
    }
};
scrollto = function(obj) {
    $('html, body').animate({
        scrollTop: $(obj).offset().top
    }, 2000);
};
callVimeo = function() {
    $.ajax({
        url: '/artigos/vimeo',
        type: 'get',
        success: function(data) {
            $("#box_tab2").html(data);
        }
    });
};
callYoutube = function() {
    $.ajax({
        url: '/artigos/youtube',
        type: 'get',
        success: function(data) {
            $("#box_tab1").html(data);
        }
    });
};
callSoundCloud = function() {
    $.ajax({
        url: '/artigos/sound-cloud',
        type: 'post',
        success: function(data) {
            $("#box_audio").html(data);
        }
    });
};
function format(state) {
    if (!state.id)
        return state.text; // optgroup
    return "<img class='pattern' src='/img/blog/bg/" + state.id + "'/>" + state.text;
}