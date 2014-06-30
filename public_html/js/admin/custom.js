/* 
 * ROTINAS DE TRATAMENTO DO CONTROLE DE ARTIGOS
 * =*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=*=
 * Criado por Rodrigo Daniel em Jan/2014
 */
artigos = {
    init: function() {
        $(".datepicker").datetimepicker({
            language: 'pt-BR'
        }).inputmask();
        // Botão de Reload dos Box e Widgets
        $(document).on("click", '.reload', function() {
            var content = $(this).parent().parent().parent().parent();
            var url = $(this).data('url');
            var bodyloading = $(content).find(".box-body");
            bodyloading.block({message: '<img src="/img/admin/loaders/12.gif" align="absmiddle">', css: {border: "none", padding: "2px", backgroundColor: "none"}, overlayCSS: {backgroundColor: "#ccc", opacity: .50, cursor: "wait"}}), window.setTimeout(function() {
                $.unblockUI(bodyloading);
            }, 400);
            $.ajax({
                url: '/artigos/refresh',
                type: 'post',
                data: {'url': url},
                success: function(data) {
                    content.html(data);
                }
            });
        });

        // Botões Box Imagens
        $(document).on("click", ".btn-imgs>button", function(e) {
            var url = $(this).data("tipo") + 'Func()';
            eval(url);
            $('.btn-imgs>button').removeClass("active");
            $('.btn-imgs>button').removeClass("btn-primary");
            $(this).addClass("active");
            $(this).addClass("btn-primary");
        });
        $(document).on("click", ".btn-categoria", function(e) {
            e.preventDefault();
            newForm('/configuracoes/add-categoria', true);
            $(this).submit();
        });
        $(document).on("change", ".format :radio", function(e) {
            $(".widget").hide("highlight");
            var ctrl = $(this).val();
            switch (ctrl) {
                case "image":
                    imagem.init();
                    serverFunc();
                    break;
                case "audio":
                    soundcloud.call();
                    break;
                default:
                    break;
            }
            $('#widget-' + ctrl).toggle('fast');
            setTimeout(function() {
                $('#' + ctrl).addClass('highlight');
            }, 400);
            setTimeout(function() {
                $('#' + ctrl).removeClass('highlight');
            }, 800);
            $('#widget-' + ctrl + '-pv').toggle('fast');
            scrollto('#' + ctrl);

        });

        $("form").bind("mousemove", function() {
            $('.ckeditor').each(function() {
                var $textarea = $(this);
                $(this).html(CKEDITOR.instances[$textarea.attr('name')].getData());
                $(this).val(CKEDITOR.instances[$textarea.attr('name')].getData());
            });
        });
        // Variáveis dos formulários Ajax
        var options = {
            resetForm: true,
            beforeSubmit: function(a, b, c) {

                if (b.data('noprogress') !== true) {
                    var controle = '#' + b.attr('id');
                    $(controle + " .progress-box").show("fast");
                    $(controle + " .percent").progressbar({value: 0});
                    $(controle + " .envio_bar").attr("style", "width:0px");
                    $(controle + " .envio_bar").html('');

                }
                $(":submit").attr("disabled", "disabled");
            },
            success: function(data) {
                $(":submit").removeAttr("disabled");
                eval(data);
            },
            uploadProgress: function(event, position, total, percentComplete) {

                // $('.envio_bar').html(percentVal);
                $('.percent').progressbar({value: percentComplete});
                $(".envio_bar").attr("style", "width:" + percentComplete + "%");
            },
            complete: function() {
                //$('.envio_bar').html('Concluído!');

                $('.percent').progressbar({value: 100});
                $(".envio_bar").attr("style", "width:100%");
                setTimeout(function() {
                    $("#box-config").modal("hide");
                    $(".progress-box").hide("slow");
                }, 1e3);
            }
        };
        $(".ajax-form").ajaxForm(options);
        // Botão de Configurações dos Box e Widgets
        $(document).on("click", '.config', function() {
            var titulo = getTitulo($(this).data("conf"));
            var tipo = $(this).data("conf") + '-conf';
            var content = $(".content-config");
            $.ajax({
                url: '/configuracoes/' + tipo,
                type: 'get'
            }).done(function(data) {
                content.html(data);
                $(".nom-tipo").html(titulo);
                $(".ajax-form").ajaxForm(options);
            });
        });

        getTitulo = function(valor) {
            var titulos = {image: "Imagem do Artigo", basic: "Dados do Artigo"};
            return titulos[valor];
        };


        scrollto = function(obj) {
            $('html, body').animate({
                scrollTop: $(obj).offset().top
            }, 2000);
        };
    },
    basic: function() {
        CKEDITOR.replace($(".ckeditor").attr('id'), {});
        $(document).on("click", ".submit-cadastro", function(e) {
            var container = $('#error_ct');
            // validate the form when it is submitted
            $("#fmartigo").validate({
                messages: {
                    nom_artigo: {required: 'Título do Artigo necessita ser informado.'},
                    des_artigo: {required: 'Conteúdo do Artigo necessita ser informado.'},
                    img_artigo: {required: 'Selecione uma imagem para o formato escolhido do artigo.'},
                    "cod_categoria[]": {required: 'Pelo menos uma categoria precisa ser informada.'},
                    nom_review: {required: 'Preencha o Título da Revisão'},
                    criterio_one: {required: 'Preencha o Primeiro Critério da Revisão'},
                    criterio_two: {required: 'Preencha o Segundo Critério da Revisão'},
                    criterio_three: {required: 'Preencha o Terceiro Critério da Revisão'},
                    criterio_four: {required: 'Preencha o Quarto Critério da Revisão'},
                    criterio_five: {required: 'Preencha o Quinto Critério da Revisão'},
                    score_one: {required: 'Escolha a Primeira Nota'},
                    score_two: {required: 'Escolha a Segunda Nota'},
                    score_three: {required: 'Escolha a Terceira Nota'},
                    score_four: {required: 'Escolha a Quarta Nota'},
                    score_five: {required: 'Escolha a Quinta Nota'},
                    des_review: {required: 'Preencha o Resumo da Revisão'},
                    v_gallery: {required: 'Envie as imagens da Galeria.'},
                    "img_description[]": {required: 'Preencha a descrição da imagem da Galeria'},
                },
                errorContainer: container,
                errorLabelContainer: $("ol", container),
                wrapper: 'li'
            });
            e.preventDefault();
            $("#fmartigo").attr("action", "");
            $(".submit-cadastro").attr("disabled", "disabled");
            bootbox.alert("<div class='dialog-alert'>Aguarde... Salvando o Registro.<br/>" +
                    "<h4 class='percent-status'></h4>" +
                    "<div class='progress progress-striped active'>" +
                    "<span class='sr-only percent'></span>" +
                    "<div class='progress-bar bar envio_bar'  role='progressbar' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100'>" +
                    "</div></div></div>");
            var container = $(".dialog-alert");
            if ($("#fmartigo").valid()) {
                $("#fmartigo").submit();
            } else {
                $(".dialog-alert").html($("#error_ct").html());
                $(".submit-cadastro").removeAttr("disabled");
            }
        });

    },
    loading: function(content) {
        var bodyloading = $(content);
        bodyloading.block({message: '<img src="/img/admin/loaders/12.gif" align="absmiddle">', css: {border: "none", padding: "2px", backgroundColor: "none"}, overlayCSS: {backgroundColor: "#ccc", opacity: .50, cursor: "wait"}});
    },
    bgbox: function() {
        $(".select").select2({placeholder: "Selecione uma Opção"});
        $(".color-picker").colorpicker().on("changeColor", function(t) {
            var e = $(this).parent().find('.colorpikerpv');
            var color = "rgba(" + t.color.toRGB().r + "," + t.color.toRGB().g + "," + t.color.toRGB().b + "," + t.color.toRGB().a + ")";
            e.attr("style", "background-color:" + color);
        });
        $(".btn-upload-bg").bind("click", function(e) {

            $("#tipo").val("upload");
            newForm('/configuracoes/upload-bg', true, '#pgbar-bg');
            e.preventDefault();
            $(this).submit();

        });
        $("#bg_pattern").select2({
            formatResult: format,
            formatSelection: format,
            escapeMarkup: function(m) {
                return m;
            }
        });
        function format(state) {
            if (!state.id)
                return state.text; // optgroup
            return "<img class='pattern' src='/img/blog/bg/" + state.id + "'/>" + state.text;
        }
    }
};
imagem = {
    init: function() {
        // Atribuir os Popovers
        $(".validacao").html("<input type='text' name='img_artigo' class='required' id='img_artigo' value='' />");
        $(".pop-hover").popover({trigger: "hover"});
        // Click das Pastas da Galeria
        $(document).on("click", ".folder-box", function(e) {
            listaGallery('img', $(this).data("folder"));
            e.preventDefault();
        });
        // Atribuir os ScrollerSlim
        $(".scroller").slimScroll();
        $(".color-box").colorbox({rel: "a", maxWidth: "95%", maxHeight: "95%"});
        $(".dropdown-menu").siblings(".dropdown-toggle").dropdown();
        // Fechar os alertas
        setTimeout(function() {
            $(".close-alert").click();
        }, 5000);
        flickrFunc = function() {
            $(".btn-search").unbind("click");
            $(".btn-upload").unbind("click");
            $(".btn-search").bind("click", function(e) {
                e.preventDefault();
                $("#tipo").val("search");
                var novo = newForm('/configuracoes/flickr', 'content-flickr');
                $(this).submit();

            });
            $(".btn-upload").bind("click", function(e) {
                newForm('/configuracoes/flickr', true);
                $("#tipo").val("upload");
                e.preventDefault();
                $(this).submit();
            });
            artigos.loading('.img-body');
            $.ajax({
                url: '/configuracoes/image-widget',
                type: 'post',
                data: {tipo: 'flickr'}
            }).done(function(data) {
                $('.img-body').html(data);
                $.unblockUI($(".img-body"));
            });
        };
        searchFkHelp = function(dados) {
            artigos.loading('.img-body');
            $.ajax({
                url: '/configuracoes/flickr',
                type: 'post',
                data: {search: dados}
            }).done(function(dado) {
                $('.blockUI').remove();
                $(":submit").removeAttr("disabled");
                $('.content-flickr').html(dado);
                artigos.image();
            });
        }
        serverFunc = function() {
            $(".btn-search").unbind("click");
            $(".btn-upload").unbind("click");
            $(".btn-search").bind("click", function(e) {
                $("#tipo").val("search");
                newForm('/configuracoes/google', true);
                e.preventDefault();
                $(this).submit();

            });
            $(".btn-upload").bind("click", function(e) {
                $("#tipo").val("upload");
                newForm('/configuracoes/upload', true);
                e.preventDefault();
                $(this).submit();
            });
            artigos.loading('.img-body');
            $.ajax({
                url: '/configuracoes/image-widget',
                type: 'post',
                data: {tipo: 'server'}
            }).done(function(data) {
                $('.img-body').html(data);
                $.unblockUI($(".img-body"));


            });
        };

        // Listar a Galeria de Fotos do Servidor
        listaGallery = function(tipo, pasta) {

            $.ajax({url: "/json/get-media",
                type: 'post',
                dataType: "json",
                cache: false,
                data: {'type': tipo, 'folder': pasta}
            }).done(function(data) {
                $('.content-img').html('');
                $.each(data.folders, function(e, d) {
                    if (d['back'] === true) {
                        $('.content-img').append('<div class="col-sm-2">' +
                                '<div class="box-widget">' +
                                '<span class="btn btn-warning btn-icon input-block-level folder-box" data-folder="' + d['path'] + '">' +
                                '<i class="fa fa-arrow-left fa-2x"></i>' +
                                '<div>' + d['nome'] + '</div></span> ' +
                                '</div></div>');
                    } else {
                        $('.content-img').append('<div class="col-sm-2 box-widget">' +
                                '<span class="btn btn-success btn-icon input-block-level folder-box" data-folder="' + d['path'] + '">' +
                                '<i class="fa fa-folder fa-2x"></i>' +
                                '<div class="">' + d['nome'] + '</div></span> ' +
                                '</div>');
                    }
                });
                $.each(data.files, function(f, d) {
                    if ($.cookie("selected") === d['real_path']) {
                        selec = 'active';
                    } else {
                        selec = '';
                    }
                    $('.content-img').append('<div class="col-sm-2">' +
                            '<div class="box-container dropdown">' +
                            '   <div class="box dropdown-toggle  btn btn-icon ' + selec + '" data-toggle="dropdown">' +
                            '       <div class="img-library">' +
                            '           <img src="/' + d['path'] + '" class="col-sm-12 " />' +
                            '       </div>' +
                            '       <div class="center-title center ellipse blue">' + d['nome'] + '</div>' +
                            '   </div>' +
                            '   <ul class="dropdown-menu">' +
                            '       <li><a href="javascript:;" onclick="addImgEditor(\'' + d['real_path'] + '\',\'s\', $(this).parent())"><i class="fa fa-edit"></i> Anexar Imagem no Editor</a></li>' +
                            '       <li><a href="/' + d['real_path'] + '" class="color-box" title="' + d['nome'] + '"><i class="fa fa-eye"></i> Previsualizar</a></li>' +
                            '       <li><a href="javascript:delImg(\'' + d['real_path'] + '\');"><i class="fa fa-trash-o"></i> Excluir</a></li>' +
                            '   </ul>' +
                            '</div>');
                });
                $(".color-box").colorbox({rel: "a", maxWidth: "95%", maxHeight: "95%"});
                $(".dropdown-menu").siblings(".dropdown-toggle").dropdown();
            });
        };
        listaGoogle = function(query) {
            artigos.loading('.img-body');
            $.ajax({url: "/json/get-google",
                type: 'post',
                dataType: "json",
                cache: false,
                data: {'query': query, 'qtd': 5}
            }).done(function(data) {
                $('.content-img').html('');
                $('.blockUI').remove();
                $.each(data, function(d, e) {
                    if ($.cookie("selected") === d['real_path']) {
                        selec = 'active';
                    } else {
                        selec = '';
                    }
                    $('.content-img').append('<div class="col-sm-2">' +
                            '<div class="box-container dropdown">' +
                            '   <div class="box dropdown-toggle  btn btn-icon ' +
                            selec +
                            '" data-toggle="dropdown">' +
                            '       <div class="img-library">' +
                            '           <img src="' + e['thumb'] + '" class="col-sm-12 " />' +
                            '       </div>' +
                            '       <div class="center-title center ellipse blue">' + e['title'] + '</div>' +
                            '   </div>' +
                            '   <ul class="dropdown-menu">' +
                            '       <li><a href="javascript:;" onclick="addImgEditor(\'' + e['real_path'] + '\',\'g\',$(this).parent(),\'' + e['thumb'] + '\');"><i class="fa fa-edit"></i> Anexar Imagem no Editor</a></li>' +
                            '       <li><a href="' + e['real_path'] + '" class="color-box" title="' + e['title'] + '"><i class="fa fa-eye"></i> Previsualizar</a></li>' +
                            '       <li><a href="javascript:copyImg(\'' + e['real_path'] + '\');"><i class="fa fa-download"></i> Salvar no Server</a></li>' +
                            '   </ul>' +
                            '</div>');
                    $(".color-box").colorbox({rel: "a", maxWidth: "95%", maxHeight: "95%"});
                    $(".dropdown-menu").siblings(".dropdown-toggle").dropdown();
                });
            });
        };
        addImgEditor = function(image, t, elm, thumb) {
            oEditor = CKEDITOR.instances.des_artigo;
            switch (t) {
                case 's':
                    $('.dropdown>.active').removeClass("active");
                    $.cookie("selected", image);
                    elm.parent().parent().find(".dropdown-toggle").addClass("active");

                    thumb = image.replace(".", "_medium.");
                    var img;
                    img = '<a href="/' + image + '" data-rel="prettyPhoto" rel="prettyPhoto" style="border: 0px none;">';
                    img += "<img src='/" + thumb + "' class='dinamic' style='margin:4px;padding:2px'/>";
                    img += '</a>';
                    $(".fileinput-preview").attr("src", "/" + thumb);
                    oEditor.insertHtml(img);
                    $(".validacao").html("<input type='text' name='img_name' id='img_name' value='" + image + "' />" +
                            "<input type='text' name='img_tipo' id='img_tipo' value='server' />" +
                            "<input type='text' name='img_thumb' id='img_thumb' value='" + thumb + "' /><input type='text' name='img_artigo' id='img_artigo' value='0' />"
                            );
                    break;
                case 'f':
                    $('.dropdown>.active').removeClass("active");
                    $.cookie("selected", image);
                    elm.parent().parent().find(".dropdown-toggle").addClass("active");
                    $(".validacao").html("<input type='text' name='img_name' id='img_name' value='" + image + "' />" +
                            "<input type='text' name='img_tipo' id='img_tipo' value='flickr' />" +
                            "<input type='text' name='img_thumb' id='img_thumb' value='" + thumb + "' /><input type='text' name='img_artigo' id='img_artigo' value='0' />"
                            );
                    $(".fileinput-preview").attr("src", thumb);
                    img = '<a href="' + image + '" data-rel="prettyPhoto" rel="prettyPhoto" style="border: 0px none;">';
                    img += "<img src='" + thumb + "' class='dinamic' style='margin:4px;padding:2px'/>";
                    img += '</a>';
                    oEditor.insertHtml(img);
                    break;
                case 'g':
                case 'fc':
                    $('.dropdown>.active').removeClass("active");
                    $.cookie("selected", image);
                    elm.parent().parent().find(".dropdown-toggle").addClass("active");
                    var img;
                    bootbox.alert("Aguarde... anexando imagem ao artigo.");
                    $.ajax({
                        url: '/configuracoes/thumb',
                        type: 'post',
                        data: {url: image, size: 'medium'}
                    }).done(function(data) {
                        img = '<a href="' + image + '" data-rel="prettyPhoto" rel="prettyPhoto" style="border: 0px none;">';
                        var imge = data;
                        img += "<img src='/" + imge + "' class='dinamic' style='margin:4px;padding:2px'/>";
                        img += '</a>';
                        oEditor.insertHtml(img);
                        $(".validacao").html("<input type='text' name='img_name' id='img_name' value='" + image + "' />" +
                                "<input type='text' name='img_tipo' id='img_tipo' value='google' />" +
                                "<input type='text' name='img_thumb' id='img_thumb' value='" + imge + "' />"
                                );
                        $(".fileinput-preview").attr("src", imge);
                        $(".bootbox").modal("hide");
                    });
                    break;
            }
        };
        copyImg = function(image) {
            artigos.loading('.img-body');
            $.ajax({
                url: '/configuracoes/copy-img',
                type: 'post',
                data: {imagem: image}
            }).done(function(data) {
                eval(data);
                $('.blockUI').remove();
            });
        };
        delImg = function(image) {
            bootbox.dialog(
                    {
                        message: "Tem certeza que deseja excluir a imagem do servidor?",
                        title: "Excluir Imagem",
                        buttons: {
                            success: {
                                label: "Sim",
                                className: "btn-success",
                                callback: function() {
                                    $.ajax({
                                        url: '/configuracoes/exclude-img',
                                        type: 'post',
                                        data: {arquivo: image}
                                    }).done(function(data) {
                                        eval(data);
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
        };
        delImgF = function(image) {
            bootbox.dialog(
                    {
                        message: "Tem certeza que deseja excluir a imagem do Flickr?",
                        title: "Excluir Imagem",
                        buttons: {
                            success: {
                                label: "Sim",
                                className: "btn-success",
                                callback: function() {
                                    $('#' + image).hide("slow");
                                    $.ajax({
                                        url: '/configuracoes/flickr',
                                        type: 'post',
                                        data: {delete: image}
                                    }).done(function(data) {
                                        eval(data);
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
        };


    }
};

review = {
    init: function() {

        $(".select-scores").select2({placeholder: "Selecione uma Nota"})
        $(".color-picker").colorpicker().on("changeColor", function(t) {
            var e = $(this).parent().find('.colorpikerpv');
            var cor = t.color.toRGB();
            e.attr("style", "background-color:rgba(" + cor.r + "," + cor.g + "," + cor.b + "," + cor.a);
        });
        switchReview = function(e) {
            var cname = $(e).parent().attr('class');
            if (cname === 'switch-on switch-animate') {
                $(".review").html('<input type="text" name="ind_review" id="ind_review" value="A"/>');
                var content = $(".review-div");
                var inputs = content.find("input,select,textarea");
                $.each(inputs, function(a, b, c) {
                    if ($(this).attr("name") !== undefined) {
                        console.log($(this).attr("name"));
                        $(this).addClass('required');
                    }
                });

            } else {
                $(".review").html('<input type="text" name="ind_review" id="ind_review" value="I"/>');
                var content = $(".review-div");
                var inputs = content.find("input,select,textarea");
                $.each(inputs, function(a, b, c) {
                    $(this).removeClass('required');
                });
            }

        };
    }
}
soundcloud = {
    call: function() {
        artigos.loading('#box_audio');
        $.ajax({
            url: '/configuracoes/sound-cloud',
            type: 'post',
            success: function(data) {
                location.hash = '#';
                setTimeout(function() {
                    location.hash = '#asc1'
                }, 1e3);
                $("#box_audio").html(data);

            }
        });
    },
    init: function() {
        $(".timeago").timeago();
        $(".scroller").slimScroll();
        $(".btn-search-sc").bind("click", function() {
            artigos.loading('#sc_result');
            $.ajax({
                url: '/configuracoes/search-sc/busca/' + $("#sc-search").val(),
                type: 'get',
                success: function(data) {
                    $("#sc_result").html(data);
                }
            });
        });
        $("#sc-search").bind("keypress", function(e) {
            var tecla = (e.keyCode ? e.keyCode : e.which);
            if (tecla === 13) {
                $('.btn-search-sc').click();
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
                    url: '/configuracoes/form-edit-sc',
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
                                        url: '/configuracoes/delete-sc',
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
            var ifaudio = '<iframe data-type="scloud" width="100%" height="166" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/' + id + '&amp;color=ff6600&amp;auto_play=false&amp;show_artwork=true"></iframe>';
            $("#player-audio").html(ifaudio);
            oEditor = CKEDITOR.instances.des_artigo;
            oEditor.insertHtml(ifaudio);
            $("#id_audio").val(id);
            $("#nom_musica").val(nomusica);
        });
        $("#but_sc_enviar").on("click", function(e) {
            $("#but_sc_enviar").attr("disabled", "disabled");
            $("#tipo").val("upload");
            newForm('/configuracoes/upload-sc', true, '#prgb-sc');
            e.preventDefault();
            $(this).submit();

        });

    },
    codifica: function(file, title) {
        $("#but_sc_enviar").attr("disabled", "disabled");
        $('.sc-info').html("<label class='control-label'>Codificando música no SoundCloud. Aguarde, esse processo pode levar vários minutos.");
        $.ajax({
            url: '/configuracoes/codifica-sc',
            type: 'post',
            data: {'file': file, 'titulo': title},
            success:function(){
                soundcloud.call();
                $("#but_sc_enviar").removeAttr("disabled");
            },
            error:function(){
                 
            }
        });
    }
}


//Funções Gerais
$(document).ready(function() {

    $(".countable").simplyCountable({
        counter: '#counter',
        countable: 'characters',
        maxCount: 250,
        countDirection: 'down',
        safeClass: 'badge safe',
        overClass: 'badge over',
        onSafeCount: function() {
            $(".countable").unbind("keypress");
        },
        onOverCount: function() {
            $(".countable").bind("keypress", function(e) {
                e.preventDefault();
                return false;
            });
        }
    }).autosize();
    $(document).ajaxComplete(function(e, d, f) {
        if (d.status == 500 || d.status== 504) {
            if(f.url==="/configuracoes/sound-cloud"){
                soundcloud.call();
                return;
            }
            if(f.url==="/configuracoes/codifica-sc"){
                var dados = f.data;
                var file = dados[0].split("=");
                var titulo = dados[1].split("=");
                Messenger().post({message: "Erro ao Codificar a música no Sound Cloud. Tentando novamente", type: "error"});
                soundcloud.codifica(file[1],titulo[1]);
                return;
            }
            if (f.data.lenght>1){
            var dados = f.data.split("&");
            if (dados.length > 1) {
                var dt = dados[1];
                var file = dados[0].split("=");
                if (file[0] == 'file') {
                    $.ajax({url: f.url+'/'+f.data});
                    return false;
                }
            } else {
                var query = dados[0].split("=");
                if (query[0] == 'delete') {
                    var dt = query[0];
                }
                
            }
            console.log(dt);
            switch (dt) {
                case 'delete':
                    Messenger().post({message: "Erro ao Excluir imagem do Flickr!", type: "danger"});
                    flickrFunc();
                    break;
                case 'search-from=flickr':
                    var query = dados[0].split("=");
                    console.info("Erro ao pesquisar no Flickr. Reconectando...");
                    searchFkHelp(query[1]);
                    break;
                case 'tipo=flickr':
                    flickrFunc();
                    console.info("Erro ao abrir Flickr. Reconectando...");
                    break;
            }
        }
        }
        $(".scroller").slimScroll();
    });
});
newForm = function(acao, vevl, xup) {
    console.log(acao);
    $("#fmartigo").unbind("submit");
    $("#fmartigo").attr("action", acao);
    $("#fmartigo").ajaxForm({
        beforeSubmit: function(a, b, c) {
            artigos.loading('.img-body');
            if (xup !== true) {
                var controle = xup;
                $(xup).toggle();
                $(controle + " .progress-box").show("fast");
                $(controle + " .percent").progressbar({value: 0});
                $(controle + " .envio_bar").attr("style", "width:0px");
                $(controle + " .envio_bar").html('');
            }
        },
        success: function(data) {
            $('.blockUI').remove();
            $(":submit").removeAttr("disabled");
            if (vevl === true) {
                eval(data);
            } else {
                $("." + vevl).html(data);
                //imagem.init();
            }

        },
        uploadProgress: function(event, position, total, percentComplete) {
            if (xup !== true) {
                $('.percent').progressbar({value: percentComplete});
                $(".envio_bar").attr("style", "width:" + percentComplete + "%");
            }
        },
        complete: function() {
            //$('.envio_bar').html('Concluído!');
            if (xup !== true) {
                $('.percent').progressbar({value: 100});
                $(".envio_bar").attr("style", "width:100%");
                setTimeout(function() {
                    $("#box-config").modal("hide");
                    $(xup).toggle();
                }, 1e3);
            }
        }
    });
};