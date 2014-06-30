// Funções de Carregamento
var valor;
window.windowpop = false;
function calcula_valor() {
    $("#vlr_total").val();
    $("#vlr_total").removeAttr("readonly");
    valor = 0;
    $.each($("input[name='vequipt[]']"), function() {
        valor = valor + parseInt($(this).val());
    });

    var dias = calculaDias($("#dta_locacao").val(), $("#dta_devolucao").val());
    valor_total = parseFloat(str_replace(',', '.', valor));
    valor_calc = parseFloat(((valor_total / 30)) * dias) ? parseFloat(((valor_total / 30)) * dias) : valor;
    valor_calc = number_format(valor_calc, 2, '.', '');
    $("#vlr_total").val(valor_calc);



}
;
function calculaDias(dt1, dt2) {

    d1 = dt1.split("/");
    dt1 = new Date(d1[2], d1[1], d1[0]);
    d2 = dt2.split("/");
    dt2 = new Date(d2[2], d2[1], d2[0]);
    var minuto = 60000;
    var dia = minuto * 60 * 24;
    var horaverao = 0;
    dt1.setHours(0);
    dt1.setMinutes(0);
    dt1.setSeconds(0);
    dt2.setHours(0);
    dt2.setMinutes(0);
    dt2.setSeconds(0);

    var fh1 = dt1.getTimezoneOffset();
    var fh2 = dt2.getTimezoneOffset();

    if (dt2 > dt1) {
        horaverao = (fh2 - fh1) * minuto;
    }
    else {
        horaverao = (fh1 - fh2) * minuto;
    }
    var dif = Math.abs(dt2.getTime() - dt1.getTime()) - horaverao;
    return Math.ceil(dif / dia);
}
;
var touchPresent = hasTouch();
addImageLista = function(valor) {
    $('.imagelist').append("<input type='text' value='" + valor + "' name='imglist[]' id='imglist_x' />");
};
function verificaAgenda() {
    //
}
function showResponse(data) {
    console.log(data);
    $(".calendar").fullCalendar('refetchEvents');
    $("#agenda_dialog").dialog("close");
    $("#agenda_dialog").remove();
}
function hasTouch() {
    try {
        document.createEvent("TouchEvent");
        return true;
    } catch (e) {
        return false;
    }
}






var oldloc = true;
$(function() {
//    $(document).on("change", "form", function() {
//        roda.check_change(true);
//    });
$("a.navigation").bind("click",function(){
    $('body,html').animate({scrollTop:0},600);
});
    $(window).hashchange(function() {


        oldloc = true;
        $(".current").removeClass("current");
        $(".open").removeClass("open");
        $("ul.sub").attr("style", "display:none");
        // --> Mostra a mensagem de Carregando... $('.content-page').html(' <div id="loading-overlay"></div><div id = "loading"><span> Carregando... </span></div>');
        $(".content-page").addClass("animate-show");

        coringa_ajax.load(coringa_route.getRoute(location.hash));


    });
    /**
     * I M P O R T A N T
     */
    /*
     *  e(window).on("resize scroll", function() {
            e(".ui-dialog").position({my: "center", at: "center", of: window
            })
        })
     */
     
    
    
    $(window).on("resize",function(){
       var largura = $(window).width();
//       if(largura < 640){
//           
//             console.log(editor.$main);
//              var conteudo = editor.$main;
//              setTimeout(function(){editor.$main.remove();},1e3);
//editor.$area.insertBefore(editor.$main); // Move the textarea out of the
//           
//       }
    });

    $(document).ajaxComplete(function(e, d, f) {
        if (d.status == 500) {

        }
        window.editor = $(".editor").cleditor()[0];
        $.unblockUI(window);
    });
    // Trigger the event (useful on page load).
    // $(window).hashchange();
    var g = $("#content");
    if (g.data("sort")) {

        g.sortable({
            items: g.find(".box").parent(),
            handle: ".header",
            distance: 5,
            tolerance: "pointer",
            placeholder: "placeholder",
            forcePlaceholderSize: true,
            forceHelperSize: true,
        });

        g.on("sortupdate", function(event, ui) {
            g.sortable('refresh');
            var sorted = g.find(".box").parent().sortable('serialize');
            var sortref = [];
            $.each(sorted, function(e) {
                sortref.push($(this).attr("id"));
            });
            $.ajax({
                url: '/extras/refresh-widget',
                type: 'post',
                data: {item: sortref},
                success: function(data) {
                    //
                }
            });


        });



    }

});
addCategorias = function(cat) {
    console.log(cat);
};
//Funções Ajax
coringa_ajax = {
    load: function(local) {
        $(window).block({message: 'Carregando...', css: {
                border: 'none',
                padding: '15px',
                backgroundColor: '#999',
                '-webkit-border-radius': '10px',
                '-moz-border-radius': '10px',
                opacity: .8,
                color: '#000'
            }});
        $.ajax({
            url: local,
            type: 'get',
            data: {am: true},
            cache: false,
            error: function(a) {

                $('.content-page').html(a.responseText);
                return;
            },
            success: function(data) {
                if (oldloc == true) {
                    oldloc = false;
                    $(".content-page").removeClass("animate-show");
                    $('.content-page').html(data);

                    coringa_registro.forms_extend();
                    $('#tbgrid').table();

                    coringa_registro.butTables();
                    //coringa_uploader.init();

                    // $$.utils.forms.resize();
                }



            }
        }).done(function(data) {
            if (touchPresent === true) {
                $("nav.phone li").bind("click", function() {
                    $("nav.phone").attr("style", "display:none")
                });
                $("input").attr("readonly", "readonly");
                $(".tabletools .right").remove();
                $("th").removeAttr("style");
                $("input[type!='datetime']:not('.date')").bind("mouseenter", function() {
                    $(this).removeAttr("readonly");
                });
            }
        });
    }
};
//Funções de Registro
coringa_registro = {
    butTables: function() {
        var local = location.hash.split('/');
        var tabela;
        if (local.length > 1) {
            if (local[1] !== 'cadastro' && local[1] !== 'listagem') {
                tabela = str_replace('#', '', local[1]);
                local = str_replace('#', '', local[0]) + '/' + local[1] + '-cadastro';
            } else {
                tabela = str_replace('#', '', local[0]);
                local = str_replace('#', '', local[0]) + '/cadastro';
            }
        }
        ;
        $('.assinar-contrato').bind("click", function() {
            window.location = '/pdf/coringa-contrato';
        });
        $('.newbut').bind("click", function() {
            location.hash = local;
        });
        $('.editbut').bind("click", function() {
            var chkbox = $('input:checkbox[checked]');
            if (chkbox.length > 1) {
                coringa_alert.alerta('Somente 1 registro deve estar selecionado para edição.', 'Editar Registro');
                return;
            }
            ;
            if (chkbox.length < 1) {
                coringa_alert.alerta('Selecione 1 registro para edição.', 'Editar Registro');
                return;
            }
            ;
            location.hash = local + '/editar/' + chkbox.val();
        });
        $("#backup_button").bind("click", function() {
            $(this).submit();
            $.ajax({
                url: "/extras/backup-db",
                type: "get",
                success: function(data) {
                    eval(data);
                },
                error: function() {
                    alert("Erro ao gerar o Backup");
                }
            });
        });
        $('.editbutloc').bind("click", function() {
            var chkbox = $('input:checkbox[checked]');
            if (chkbox.length > 1) {
                coringa_alert.alerta('Somente 1 registro deve estar selecionado para edição.', 'Editar Registro');
                return;
            }
            ;
            if (chkbox.length < 1) {
                coringa_alert.alerta('Selecione 1 registro para edição.', 'Editar Registro');
                return;
            }
            ;
            location.hash = 'locacoes/cadastro/editar/' + chkbox.val();
        });
        $(".delbut").bind("click", function() {
            var chkbox = $('input:checkbox[checked]');
            if ($(".delbutall").length > 0) {
                coringa_alert.confirma('Tem certeza que deseja excluir esse registro? <br/><small class="warning error">Atenção! Ao excluir um registro simples, todos os outros registros duplicados são excluídos automáticamente!<small>', 'deletarall', tabela);
                return;
            }
            if ($(".delbutloc").length > 0) {
                coringa_alert.locacao();
                return;
            }
            if (chkbox.length > 1) {
                coringa_alert.confirma('Tem certeza que deseja excluir esses registros?', 'Excluir Registros', tabela);
                return;
            }
            ;
            if (chkbox.length < 1) {
                coringa_alert.alerta('Nenhum registro foi selecionado para exclusão.', 'Falha na Exclusão');
                return;
            }
            coringa_alert.confirma('Tem certeza que deseja excluir esse registro.', 'Excluir Registro', tabela);
        });
        $(".delbutmanutencao").bind("click", function() {
            var chkbox = $('input:checkbox[checked]');

            if (chkbox.length > 1) {
                coringa_alert.confirmaManutencao('Tem certeza que deseja excluir esses registros?', 'Excluir Registros', 'equipamento_manutencaos');
                return;
            }
            ;
            if (chkbox.length < 1) {
                coringa_alert.alerta('Nenhum registro foi selecionado para exclusão.', 'Falha na Exclusão');
                return;
            }
            coringa_alert.confirmaManutencao('Tem certeza que deseja excluir esse registro.', 'Excluir Registro', 'equipamento_manutencaos');
        });
        $(".visualizar-contrato").bind("click", function() {
            var chkbox = $('input:checkbox[checked]');

            if (chkbox.length < 1) {
                coringa_alert.alerta('Selecione 1 registro para visualização.', 'Visualizar Contrato');
                return;
            } else {
                $.each(chkbox, function(key, val) {
                    window.open("/pdf/contrato/id/" + $(val).val(), "", "width=640,height=480");
                });
            }

        });
        $(".renovar").bind("click", function() {
            var chkbox = $('input:checkbox[checked]');

            if (chkbox.length < 1) {
                coringa_alert.alerta('Selecione 1 registro para renovação.', 'Erro ao Renovar Contrato');
                return;
            } else {
                location.hash = 'locacoes/renovar-cadastro/pedido/' + chkbox.val();
            }

        });
        $(".visualizar-comprovante").bind("click", function() {
            var chkbox = $('input:checkbox[checked]');

            if (chkbox.length < 1) {
                coringa_alert.alerta('Selecione 1 registro para visualização.', 'Visualizar Comprovante');
                return;
            } else {
                $.each(chkbox, function(key, val) {
                    window.open("/pdf/comprovante/pedido/" + $(val).val(), "", "width=640,height=480");
                });
            }

        });
        $(".devolver").on("click", function() {
            var chkbox = $('input:checkbox[checked]');
            if (chkbox.length > 1) {
                coringa_alert.alerta('Somente 1 registro deve estar selecionado para devolução.', 'Devolução de Equipamentos');
                return;
            }

            if (chkbox.length < 1) {
                coringa_alert.alerta('Selecione 1 registro para devolução.', 'Devolução de Equipamentos');
                return;
            }
            location.hash = 'locacoes/devolver/pedido/' + chkbox.val();

        });
        $("button").bind("click", function() {
            //  $(this).attr("disabled", "disabled");
        });
    },
    makeBreadcrumb: function(local) {
        $(".breadcrumb").html('');

        if (local === '' || local === '#') {
            $(".breadcrumb").append("<li ><a class='active' href='#'>Dashboard</a></li>");
        } else {

            $(".breadcrumb").append("<li><a href='#'>Dashboard</a></li>");
            var bc = local.split('#');
            var links = bc[1];
            bc = links.split("/");
            for (i = 0; i < bc.length; i++) {

                switch (bc[i]) {
                    case 'locacoes':
                        switch (bc[i + 1]) {
                            case 'ativas':
                                $(".breadcrumb").append("<li><a href='javascript:void(0)' class='active'>Locações Ativas</a></li>");
                                break;
                            case 'concluidas':
                                $(".breadcrumb").append("<li><a href='javascript:void(0)' class='active'>Locações Concluídas</a></li>");
                                break;
                            case 'renovacao':
                                $(".breadcrumb").append("<li><a href='javascript:void(0)' class='active'>Locações Renovação</a></li>");
                                break;
                            case 'renovar-cadastro':
                                $(".breadcrumb").append("<li><a href='#locacoes/renovacao'>Locações Renovação</a></li>");
                                $(".breadcrumb").append("<li><a href='javascript:void(0)' class='active'>Renovar Pedido</a></li>");
                                break;
                            case 'devolucao':
                                $(".breadcrumb").append("<li><a href='javascript:void(0)' class='active'>Locações Devolução</a></li>");
                                break;
                            case 'comprovantes':
                                $(".breadcrumb").append("<li><a href='javascript:void(0)' class='active'>Comprovantes</a></li>");
                                break;
                            case 'devolver':
                                $(".breadcrumb").append("<li><a href='#locacoes/devolucao'>Locações Devolução</a></li>");
                                $(".breadcrumb").append("<li><a href='javascript:void(0)' class='active'>Devolver Pedido</a></li>");
                                break;
                            case 'cadastro':
                                $(".breadcrumb").append("<li><a href='#locacoes/ativas'>Locações Ativas</a></li>");
                                if (bc[i + 2] === 'editar') {

                                    $(".breadcrumb").append("<li><a href='javascript:void(0)' class='active'>Editar Registro</a></li>");
                                } else {

                                    $(".breadcrumb").append("<li><a href='javascript:void(0)' class='active'>Novo Registro</a></li>");
                                }
                                break;

                        }
                        break;
                    case 'clientes':
                        switch (bc[i + 1]) {
                            case 'listagem':
                                $(".breadcrumb").append("<li><a href='javascript:void(0)' class='active'>Clientes</a></li>");
                                break;
                            case 'cobranca':
                                $(".breadcrumb").append("<li><a href='#clientes/listagem' >Clientes</a></li>");
                                $(".breadcrumb").append("<li><a href='javascript:void(0)' class='active'>Cobrança</a></li>");
                                break;
                            case 'cobranca-cadastro':
                                $(".breadcrumb").append("<li><a href='#clientes/listagem'>Clientes</a></li>");
                                $(".breadcrumb").append("<li><a href='#clientes/cobranca'>Cobrança</a></li>");
                                if (bc[i + 2] === 'editar') {
                                    $(".breadcrumb").append("<li><a href='javascript:void(0)' class='active'>Editar Registro</a></li>");
                                } else {
                                    $(".breadcrumb").append("<li><a href='javascript:void(0)' class='active'>Novo Registro</a></li>");
                                }
                                break;
                            case 'co-responsabilidade':
                                $(".breadcrumb").append("<li><a href='#clientes/listagem'>Clientes</a></li>");
                                $(".breadcrumb").append("<li><a href='javascript:void(0)' class='active'>Co-Responsabilidade</a></li>");
                                break;
                            case 'co-responsabilidade-cadastro':
                                $(".breadcrumb").append("<li><a href='#clientes/listagem'>Clientes</a></li>");
                                $(".breadcrumb").append("<li><a href='#clientes/co-responsabilidade' >Co-Responsabilidade</a></li>");
                                if (bc[i + 2] === 'editar') {
                                    $(".breadcrumb").append("<li><a href='javascript:void(0)' class='active'>Editar Registro</a></li>");
                                } else {
                                    $(".breadcrumb").append("<li><a href='javascript:void(0)' class='active'>Novo Registro</a></li>");
                                }
                                break;
                            case 'cadastro':
                                $(".breadcrumb").append("<li><a href='#clientes/listagem'>Clientes</a></li>");
                                if (bc[i + 2] === 'editar') {
                                    $(".breadcrumb").append("<li><a href='javascript:void(0)' class='active'>Editar Registro</a></li>");
                                } else {
                                    $(".breadcrumb").append("<li><a href='javascript:void(0)' class='active'>Novo Registro</a></li>");
                                }
                                break;
                        }
                        break;
                    case 'equipamentos':
                        switch (bc[i + 1]) {
                            case 'listagem':
                                $(".breadcrumb").append("<li><a href='javascript:void(0)' class='active'>Equipamentos</a></li>");
                                break;
                            case 'categorias':
                                $(".breadcrumb").append("<li><a href='#equipamentos/listagem'>Equipamentos</a></li>");
                                $(".breadcrumb").append("<li><a href='javascript:void(0)' class='active'>Categorias</a></li>");

                                break;
                            case 'categorias-cadastro':
                                $(".breadcrumb").append("<li><a href='#equipamentos/listagem'>Equipamentos</a></li>");
                                $(".breadcrumb").append("<li><a href='#equipamentos/categorias'>Categorias</a></li>");
                                if (bc[i + 2] === 'editar') {
                                    $(".breadcrumb").append("<li><a href='javascript:void(0)' class='active'>Editar Registro</a></li>");
                                } else {
                                    $(".breadcrumb").append("<li><a href='javascript:void(0)' class='active'>Novo Registro</a></li>");
                                }
                                break;
                            case 'modelos':
                                $(".breadcrumb").append("<li><a href='#equipamentos/listagem'>Equipamentos</a></li>");
                                $(".breadcrumb").append("<li><a href='javascript:void(0)' class='active'>Modelos</a></li>");

                                break;
                            case 'modelos-cadastro':
                                $(".breadcrumb").append("<li><a href='#equipamentos/listagem'>Equipamentos</a></li>");
                                $(".breadcrumb").append("<li><a href='#equipamentos/modelos'>Modelos</a></li>");
                                if (bc[i + 2] === 'editar') {
                                    $(".breadcrumb").append("<li><a href='javascript:void(0)' class='active'>Editar Registro</a></li>");
                                } else {
                                    $(".breadcrumb").append("<li><a href='javascript:void(0)' class='active'>Novo Registro</a></li>");
                                }
                                break;
                            case 'acessorios':
                                $(".breadcrumb").append("<li><a href='#equipamentos/listagem'>Equipamentos</a></li>");
                                $(".breadcrumb").append("<li><a href='javascript:void(0)' class='active'>Acessórios</a></li>");

                                break;
                            case 'acessorios-cadastro':
                                $(".breadcrumb").append("<li><a href='#equipamentos/listagem'>Equipamentos</a></li>");
                                $(".breadcrumb").append("<li><a href='#equipamentos/acessorios'>Acessórios</a></li>");
                                if (bc[i + 2] === 'editar') {
                                    $(".breadcrumb").append("<li><a href='javascript:void(0)' class='active'>Editar Registro</a></li>");
                                } else {
                                    $(".breadcrumb").append("<li><a href='javascript:void(0)' class='active'>Novo Registro</a></li>");
                                }
                                break;
                            case 'manutencao':
                                $(".breadcrumb").append("<li><a href='#equipamentos/listagem'>Equipamentos</a></li>");
                                $(".breadcrumb").append("<li><a href='javascript:void(0)' class='active'>Manutenção</a></li>");

                                break;
                            case 'manutencao-cadastro':
                                $(".breadcrumb").append("<li><a href='#equipamentos/listagem'>Equipamentos</a></li>");
                                $(".breadcrumb").append("<li><a href='#equipamentos/manutencao'>Manutenção</a></li>");
                                if (bc[i + 2] === 'editar') {
                                    $(".breadcrumb").append("<li><a href='javascript:void(0)' class='active'>Editar Registro</a></li>");
                                } else {
                                    $(".breadcrumb").append("<li><a href='javascript:void(0)' class='active'>Novo Registro</a></li>");
                                }
                                break;
                            case 'estoque':
                                $(".breadcrumb").append("<li><a href='#equipamentos/listagem'>Equipamentos</a></li>");
                                $(".breadcrumb").append("<li><a href='javascript:void(0)' class='active'>Estoque</a></li>");

                                break;
                            case 'cadastro':
                                $(".breadcrumb").append("<li><a href='#equipamentos/listagem'>Equipamentos</a></li>");
                                if (bc[i + 2] === 'editar') {
                                    $(".breadcrumb").append("<li><a href='javascript:void(0)' class='active'>Editar Registro</a></li>");
                                } else {
                                    $(".breadcrumb").append("<li><a href='javascript:void(0)' class='active'>Novo Registro</a></li>");
                                }
                                break;
                        }
                        break;
                    case 'fornecedores':
                        switch (bc[i + 1]) {
                            case 'listagem':
                                $(".breadcrumb").append("<li><a href='javascript:void(0)' class='active'>Fornecedores</a></li>");
                                break;
                            case 'cadastro':
                                $(".breadcrumb").append("<li><a href='#fornecedores/listagem'>Fornecedores</a></li>");
                                if (bc[i + 2] === 'editar') {
                                    $(".breadcrumb").append("<li><a href='javascript:void(0)' class='active'>Editar Registro</a></li>");
                                } else {
                                    $(".breadcrumb").append("<li><a href='javascript:void(0)' class='active'>Novo Registro</a></li>");
                                }
                                break;
                        }
                        break;
                    case 'obras':
                        switch (bc[i + 1]) {
                            case 'listagem':
                                $(".breadcrumb").append("<li><a href='javascript:void(0)' class='active'>Obras</a></li>");
                                break;
                            case 'cadastro':
                                $(".breadcrumb").append("<li><a href='#obras/listagem'>Obras</a></li>");
                                if (bc[i + 2] === 'editar') {
                                    $(".breadcrumb").append("<li><a href='javascript:void(0)' class='active'>Editar Registro</a></li>");
                                } else {
                                    $(".breadcrumb").append("<li><a href='javascript:void(0)' class='active'>Novo Registro</a></li>");
                                }
                                break;
                        }
                        break;
                    case 'usuarios':
                        switch (bc[i + 1]) {
                            case 'listagem':
                                $(".breadcrumb").append("<li><a href='javascript:void(0)' class='active'>Usuários</a></li>");
                                break;
                            case 'grupos':
                                $(".breadcrumb").append("<li><a href='#usuarios/listagem'>Usuários</a></li>");
                                $(".breadcrumb").append("<li><a href='javascript:void(0)' class='active'>Grupos</a></li>");
                                break;
                            case 'grupos-cadastro':
                                $(".breadcrumb").append("<li><a href='#usuarios/listagem'>Usuários</a></li>");
                                $(".breadcrumb").append("<li><a href='#usuarios/grupos'>Grupos</a></li>");
                                if (bc[i + 2] === 'editar') {
                                    $(".breadcrumb").append("<li><a href='javascript:void(0)' class='active'>Editar Registro</a></li>");
                                } else {
                                    $(".breadcrumb").append("<li><a href='javascript:void(0)' class='active'>Novo Registro</a></li>");
                                }
                                break;
                            case 'cadastro':
                                $(".breadcrumb").append("<li><a href='#usuarios/listagem'>Usuários</a></li>");
                                if (bc[i + 2] === 'editar') {
                                    $(".breadcrumb").append("<li><a href='javascript:void(0)' class='active'>Editar Registro</a></li>");
                                } else {
                                    $(".breadcrumb").append("<li><a href='javascript:void(0)' class='active'>Novo Registro</a></li>");
                                }
                                break;
                        }
                        break;
                    case 'relatorios':
                        switch (bc[i + 1]) {
                            case 'clientes':
                                $(".breadcrumb").append("<li><a href='javascript:void(0)' class='active'>Relatório de Clientes</a></li>");
                                break;
                            case 'co-responsabilidades':
                                $(".breadcrumb").append("<li><a href='javascript:void(0)' class='active'>Relatório de Co-Responsabilidades</a></li>");
                                break;
                            case 'cobrancas':
                                $(".breadcrumb").append("<li><a href='javascript:void(0)' class='active'>Relatório de Cobranças</a></li>");
                                break;
                            case 'obras':
                                $(".breadcrumb").append("<li><a href='javascript:void(0)' class='active'>Relatório de Obras</a></li>");
                                break;

                        }
                        break;
                }

            }
        }
    },
    locacao_form: function() {
        //$('.date').datepicker();
        $(".addequip").bind("click", function() {
            $(".addequip").attr("disabled", "disabled");
            $('body').append('<div class="coringa_dialog_equip"></div>');
            $.ajax({
                url: '/extras/show-equipamentos'
            }).done(function(retorno) {
                if (touchPresent) {
                    setTimeout(function() {
                        $(".no-margin-top-phone").removeClass("dynamic");
                        $(".no-margin-top-phone").removeClass("styled");
                        $(".no-margin-top-phone").addClass("table");
                        $(".no-margin-top-phone").attr("style", "padding:10px");
                        $("input").attr("readonly", "readonly");
                        $("input").bind("mouseenter", function() {
                            $(this).removeAttr("readonly");
                        });
                        $("input").bind("mouseleave", function() {
                            $(this).attr("readonly", "readonly");
                        });
                    }, 100);


                }
                $(".coringa_dialog_equip").html(retorno);
                $(".coringa_dialog_equip").dialog({
                    title: 'Adicionar Equipamento para Locação',
                    autoOpen: true,
                    modal: true,
                    width: 400,
                    closeable: false,
                    buttons: {
                        "Adicionar": function() {
                            if ($('#cod_equipamento').val() !== '') {
                                var inputhd;
                                $("#equiplist").val("true");
                                $("#equiplist").parent().find("table").removeClass("error").addClass("valid");
                                $("#equiplist").parent().find(".error").remove();
                                oTable = $('#tbgrid').dataTable();
                                inputhd = '<input type="hidden" name="cequip[]" id="cequip" value="' + $('#cod_equipamento').val() + '" />';
                                inputhd = inputhd + '<input type="hidden" name="qequip[]" id="qequip" value="' + $('#qequipamento').val() + '" />';
                                inputhd = inputhd + '<input type="hidden" name="vequip[]" id="vequip" value="' + $('#vequipamento').val() + '" />';
                                inputhd = inputhd + '<input type="hidden" name="indacessorio[]" id="indacessorio" value="' + $('input:[name="ind_acessorio"]').val() + '" />';
                                inputhd = inputhd + '<input type="hidden" name="vequipt[]" id="vequip" value="' + parseInt(parseInt($('#qequipamento').val()) * parseInt($('#vequipamento').val())) + '" />';
                                oTable.fnAddData(new Array(
                                        "<input type='checkbox' value='" + $('#cequipamento').val() + "' name='codequip[]' id='cod_equip' />",
                                        $('#qequipamento').val(),
                                        $("#cod_equipamento").find('option:[selected]').html(),
                                        $('#vequipamento').val(),
                                        parseInt(parseInt($('#qequipamento').val()) * parseInt($('#vequipamento').val())) + ",00" + inputhd));
                                $(this).dialog("close");
                                $(".coringa_dialog_equip").remove();
                                calcula_valor();
                                $('input:checkbox').checkbox({cls: "checkbox", empty: "/img/alicerce/elements/checkbox/empty.png"});
                                $("#addequip").removeAttr("disabled");
                            } else {
                                alert("É necessário selecionar um equipamento para adicionar");
                            }
                        },
                        "Cancelar": function() {
                            $(this).dialog("close");
                            $(".coringa_dialog_equip").remove();
                            $("#addequip").removeAttr("disabled");
                        }
                    }
                }).parent().find('button').eq(0).addClass('green_confirm').prepend('<span class="icon icon-ok"></span>')
                        .parent().find('button').eq(1).addClass('red_confirm').prepend('<span class="icon icon-remove"></span>')

            });
            return false;
        });
        $(".removeequip").bind('click', function() {

            coringa_alert.locacaoEquip();
            return false;
        });

        $(".clienteobra").bind("change", function() {
            $.getJSON('/extras/cliente-obra/valor/' + $(this).val(), function(data) {
                $("#cod_obra").html('<option></option>');
                if (data !== null) {
                    $.each(data, function(key, val) {
                        $("#cod_obra").append("<option value='" + val.cod_obra + "'>" + val.des_obra + "</option>");

                    });
                    $("select").chosen().trigger("liszt:updated");
                }
            });
        });
        $(".clienteobra").bind("change", function() {
            $.getJSON('/extras/cliente-obra/valor/' + $(this).val(), function(data) {
                $("#cod_obra").html('<option value="0"></option>');
                if (data !== null) {
                    $.each(data, function(key, val) {
                        $("#cod_obra").append("<option value='" + val.cod_obra + "'>" + val.des_obra + "</option>");

                    });
                    $("select").chosen().trigger("liszt:updated");
                }
            });
        });
        $(".clienteresponsavel").bind("change", function() {
            $.getJSON('/extras/cliente-responsavel/valor/' + $(this).val(), function(data) {
                $("#cod_responsabilidade").html('<option value="0"></option>');
                if (data !== null) {
                    $.each(data, function(key, val) {
                        $("#cod_responsabilidade").append("<option value='" + val.cod_cliente + "'>" + val.nom_cliente + "</option>");

                    });
                    $("select").chosen().trigger("liszt:updated");
                }
            });
        });

        $('.money').maskMoney();
        //$(".date").attr("placeholder", "__/__/____");
        $('#fm_locacao').bind("mousemove", function() {
            calcula_valor();

        });
        $(".date").bind("blur", function(e) {
            calcula_valor();

        });
        $("#vlr_total").bind("focus", function() {
            $("#vlr_total").removeAttr("readonly");
            $('#fm_locacao').unbind("mousemove");

        });


    },
    showequip: function() {
        $("select").chosen();
        $(".codcategoriasearch").bind("change", function() {
            var valor = $(this).val();
            $.getJSON('/extras/equipamentos-categoria-json/id/' + valor, function(data) {
                if (data !== null) {
                    $("#cod_equipamento").html('<option></option>');
                    $.each(data, function(key, val) {

                        $("#cod_equipamento").append("<option value='" + val.cod_equipamento + "'>" + val.nom_equipamento + "</option>");
                    });
                }
                $("select").chosen().trigger("liszt:updated");
            });
        });
        $(".codequipamentosearch").bind("change", function() {
            var valor = $(this).val();
            $.getJSON('/extras/equipamentos-dados/cod_equipamento/' + valor, function(data) {
                if (data !== null) {
                    $("#qequipamento").attr("max", data.qtd_estoque_atual);
                    $("#vequipamento").val(data.vlr_locacao);
                }
            });
        });



    },
    forms_extend: function() {
        $(".editor").cleditor({width: '100%'});
        if ($('.showinfos').length > 0) {
            if (windowpop == false) {
                var testpop = window.open("about:blank", "_blank", "width=1, height=1,top=0,left=0");
                if (null == testpop || true == testpop.closed) {
                    $('.showinfos').append('<p class="alert information"><span class = "icon"></span>É necessário habilitar a abertura de páginas pop-up nas configurações do navegador antes de gerar os relatórios.</p>');
                } else {
                    testpop.close();
                    windowpop = true;
                }
            }
        }

        $(".codcategoriasearch").bind("change", function() {
            var valor = $(this).val();
            $.getJSON('/extras/equipamentos-categoria-json/id/' + valor, function(data) {
                if (data !== null) {
                    $("#cod_equipamento").html('<option></option>');
                    $.each(data, function(key, val) {

                        $("#cod_equipamento").append("<option value='" + val.cod_equipamento + "'>" + val.nom_equipamento + "</option>");
                    });
                }
                $("select").chosen().trigger("liszt:updated");
            });
        });
        $(".codequipamentosearch").bind("change", function() {
            var valor = $(this).val();
            $.getJSON('/extras/equipamentos-dados/cod_equipamento/' + valor, function(data) {
                if (data !== null) {
                    $("#qtd_equipamento").attr("max", data.qtd_estoque_atual);

                }
            });
        });
        coringa_uploader.init();
        var mdates = $('.date');
        mdates.eq(0).on('blur', function() {
            mdates.eq(1).val(somaDias($(this).val(), 30));
        });


        $(".numeric").numeric();
        $('input:buscacep').bind("blur", function() {
            $("#des_endereco").val('Pesquisando');
            $.getJSON("http://cep.correiocontrol.com.br/" + ($(this).val()).replace(/[\.-]/g, "") + ".json", function(data) {
                if (data !== null) {
                    $("#des_endereco").val(data.logradouro + ', nº ');
                    $("#des_bairro").val(data.bairro);
                    $("#des_estado").val(data.uf);
                    cidade = data.localidade;
                    $(':estadosearch').change();
                    // console.log(cidade.toUpperCase());
                }
            }).fail(function() {
                $.jGrowl("Nenhum endereço foi localizado com o CEP informado.");
                $("#des_endereco").val('');
            });
        });
        $(".clientedata").bind("change", function() {
            $.getJSON('/extras/cliente-data/valor/' + $(this).val(), function(data) {
                if (data !== null) {
                    $("#des_endereco").val(data.des_endereco);
                    $("#des_bairro").val(data.des_bairro);
                    $("#num_cep").val(data.num_cep);
                    $("#des_estado").val(data.des_estado);
                    cidade = data.des_cidade;
                    $(':estadosearch').change();
                }
            });
        });
        var cidade;
        $(':estadosearch').bind("change", function() {
            $.getJSON("/extras/cidades/uf/" + $(this).val(), function(data) {
                var cidades = [];
                $.each(data, function(key, val) {
                    cidades.push(val);
                });
                var i = 0;
                $("#des_cidade").html('<option></option>');
                $(".des_cidade").removeAttr('original-title');
                while (i in cidades) {
                    $.each(cidades[i], function(key, val) {
                        $("#des_cidade").append("<option value='" + val.nom_cidade + "'>" + val.nom_cidade + "</option>");
                    });
                    i++;
                }
                $("#des_cidade").attr("data-placeholder", "Selecione uma Cidade");
                if (cidade !== undefined) {
                    $("#des_cidade").val(cidade.toUpperCase());
                }
                $("select").chosen().trigger("liszt:updated");
            });
        });
        $("input[name='radio']").on("change", function(e) {

            if ($(this).data('mode') === 1) {
                window.data = this;
                $("#num_cnpj_cpf").unmask().mask('99.999.999/9999-99');
                $("#num_cnpj_cpf").focus();
            } else {
                $("#num_cnpj_cpf").unmask().mask('999.999.999-99');
                $("#num_cnpj_cpf").focus();
            }
        });

        $(".mask").each(function(e) {
            $(this).mask($(this).data("mask"));
        });
        $('.money').maskMoney();

        $('.row:not#fm_login').keypress(function(e) {
            var tecla = (e.keyCode ? e.keyCode : e.which);
            if (tecla == 13) {
                campo = $(this);
                origem = $('.row');
                indice = campo.index();
                if (origem[indice + 3] != null) {
                    proximo = origem[indice + 3];
                    $(proximo).find('input,select,textarea,button,span').focus();
                } else {
                }
                e.preventDefault(e);
                return false;
            }
        });


        coringa_plugins.init();

    },
    devolucao: function() {
        $(".selrows").bind("click", function() {
            $(this).find(".optcheck").attr("checked", !$(this).find(".optcheck").attr("checked"));

        });
        var valor_qtd = '';
        $(".devolveequip").bind("click", function() {
            var chkbox = $('input:checkbox[checked]');
            if (chkbox.length > 1) {
                coringa_alert.alerta('Somente 1 registro deve estar selecionado para devolução.', 'devolver');
                return false;
            }
            if (chkbox.length < 1) {
                coringa_alert.alerta('Selecione 1 registro para devolução.', 'devolver');
                return false;
            } else {
                //coringa_alert.confirma('Tem certeza que deseja devolver o Equipamento selecionado?', 'devolver', $("#cod_locacao").val());
                $("body").append("<div class='coringa_dialog_confirm' style='padding:10px'></div>");
                $(".coringa_dialog_confirm").dialog({
                    autoOpen: true,
                    modal: true,
                    title: "Devolução de Equipamento",
                    width: 400,
                    open: function() {
                        $(this).parent().css('overflow', 'visible');
                        $(this).html('<div class="alert-box alert" ><span class="icon icon-warning-sign"></span>Tem Certeza que deseja devolver o Equipamento selecionado?</div>');
                    },
                    buttons: {
                        "Confirmar": function() {
                            if ($('#qtd_equip_dev').val() === undefined) {

                                $.ajax({
                                    url: '/extras/qtde-equip-dev',
                                    type: 'post',
                                    data: {cod_equip_locacao: $("input:checkbox[checked]").val()}
                                }).done(function(dados) {
                                    $('.coringa_dialog_confirm').html(dados);
                                });


                            } else {
                                $("#fm_devolve").ajaxSubmit({success: function(data) {
                                        eval(data);
                                    }});

                            }
                        },
                        "Cancelar": function() {
                            $(this).dialog("close");
                            $(".coringa_dialog_confirm").remove();
                        }
                    }
                }).parent().find('button').eq(0).addClass('green_confirm').prepend('<span class="icon icon-ok"></span>')
                        .parent().find('button').eq(1).addClass('red_confirm').prepend('<span class="icon icon-remove"></span>')
            }
            return false;
        });
    }
},
coringa_route = {
    getRoute: function(rota) {
        coringa_registro.makeBreadcrumb(rota);
        var new_rote = rota.split('#');
        new_rote = new_rote[1];
        if (new_rote !== undefined) {
            rotas = new_rote.split("/");
            if (rotas.lenght > 1) {
                $('.' + rotas[0]).addClass("current");
            } else {
                $('.' + rotas[0]).addClass("current open");
                $('.' + rotas[0] + " ul.sub").toggle();
                $('.' + rotas[0] + ' ul li.' + rotas[1]).addClass("current");
            }
            return new_rote;
        } else {
            $('.dashboard-menu').addClass("current");
            return '/index/dashboard';
        }
    }
},
//
coringa_plugins = {
    init: function() {

        var e = $;
        e("#content .tabbedBox").tabbedBox2();
//        e(".tabnohash").find("a").bind("click",function(d){
//            d.preventDefault();
//        });
        e("input[type=date]").each(function() {
            var j = e(this);

            j[0].type = "text";
            if (e(this).data('valor') !== undefined)
                j[0].value = e(this).data('valor');

            j.datepicker();
        });
        e("input[type=datetime]").each(function() {
            e(this).datetimepicker().blur(h)
        });

        e("form.validate").each(function() {
            e(this).validate({submitHandler: function(g) {

                    e(this).data("submit") ? e(this).data("submit")() : e(g).ajaxSubmit({beforeSubmit: function() {
                            e("button").attr("disabled", "disabled");

                        }, success: function(data) {
                            //e(":submit").removeAttr("disabled");
                            eval(data);
                        }, error: function() {
                            e("button").removeAttr("disabled");
                            $.jGrowl('Não foi possível salvar o registro. Confira todos os Campos e tente novamente.');
                        }});
                    //e(this).data("submit");

                }})
        });
        if (e('#num_cnpj_cpf').length > 0) {

            e('#num_cnpj_cpf').rules("add", {
                required: true,
                remote: "/extras/valida-doc/valor/",
                messages: {
                    required: "Digite um CPF ou CNPJ.",
                    remote: e.format("CPF ou CNPJ inválido!")

                }
            });
        }
        e("form.validate").on("reset", function() {
            var g = e(this);
            g.validate().resetForm();
            g.find("label.error").remove().end().find(".error-icon").remove().end().find(".valid-icon").remove().end().find(".valid").removeClass("valid").end().find(".customfile.error").removeClass("error")
        });
        if (!("form" in document.createElement("input"))) {
            e("input:submit").each(function() {
                var g = e(this);
                if (g.attr("form")) {
                    g.click(function() {
                        e("#" + g.attr("form")).submit()
                    })
                }
            });
            e("input:reset").each(function() {
                var g = e(this);
                if (g.attr("form")) {
                    g.click(function() {
                        e("#" + g.attr("form"))[0].reset()
                    })
                }
            })
        }
        ;
        e.validator.addMethod("strongpw", function(h, g) {
            return e.pwdStrength(h) > 50
        }, "Sua senha não é segura.");
        e.validator.addMethod("checked", function(h, g) {
            return !!e(g)[0].checked
        }, "Você precisa selecionar a opção.");
        e.validator.setDefaults({
            ignore: ":hidden:not(select.chzn-done):not(input.mirror):not(:checkbox):not(:radio):not(.dualselects),.ignore",
            success: function(g) {
                e(g).prev().filter(".error-icon").removeClass("error-icon").addClass("valid-icon");
                e(g).prev(".customfile").removeClass("error")
            },
            errorPlacement: function(g, i) {
                if (i.hasClass("customfile-input-hidden")) {
                } else {
                    if (i.hasClass("customfile-input-hidden")) {
                        g.insertAfter(i.parent().addClass("error"))
                    } else {
                        if (i.is(":password.meter") || i.is("textarea") || i.is(".ui-spinner-input") || i.is("input.mirror")) {
                            g.insertAfter(i)
                        } else {
                            if (i.is(":checkbox") || i.is(":radio")) {
                                if (i.is(":checkbox")) {
                                    g.insertAfter(i.next().next())
                                } else {
                                    g.insertAfter(e("[name=" + i[0].name + "]").last().next().next())
                                }
                            } else {
                                if (i.is("select.chzn-done") || i.is(".dualselects")) {
                                    g.insertAfter(i.next())
                                } else {
                                    g.insertAfter(i);
                                    var h = e('<div class="error-icon icon" />').insertAfter(i).position({my: "right", at: "right", of: i, offset: "-5 0", overflow: "none", using: function(l) {
                                            var k = e(this).offsetParent().outerWidth();
                                            var j = k - l.left - e(this).outerWidth();
                                            e(this).css({left: "", right: j, top: l.top})
                                        }})
                                }
                            }
                        }
                    }
                }
            }, showErrors: function(i, h) {
                var g = this;
                this.defaultShowErrors();
                h.forEach(function(l) {
                    var k = e(l.element), j = g.errorsFor(l.element);
                    if (k.data("errorType") == "inline" || k.is("select") || k.is("textarea") || k.hasClass("customfile-input-hidden") || k.is("input.mirror") || k.is(":checkbox") || k.is(":radio") || k.is(".dualselect")) {
                        var m;
                        if (k.is("select")) {
                            m = k.next()
                        } else {
                            if (k.is(":checkbox") || k.is(":radio")) {
                                if (k.is(":checkbox")) {
                                    m = k.next()
                                } else {
                                    m = e("[name=" + k[0].name + "]").last().next().next()
                                }
                                j.css("display", "block")
                            } else {
                                if (k.is("input.mirror")) {
                                    m = k.prev()
                                } else {
                                    m = k
                                }
                            }
                        }
                        j.addClass("inline").position({my: "left top", at: "left bottom", of: m, offset: "0 5", collision: "none"});
                        if (!(k.is(":checkbox") && k.is(":radio"))) {
                            j.css("left", "")
                        }
                    } else {
                        j.position({my: "right top", at: "right bottom", of: k, offset: "1 8", using: function(p) {
                                var o = e(this).offsetParent().outerWidth();
                                var n = o - p.left - e(this).outerWidth();
                                e(this).css({left: "", right: n, top: p.top})
                            }})
                    }
                    j.prev().filter(".valid-icon").removeClass("valid-icon").addClass("error-icon");
                    if (k.hasClass("noerror")) {
                        j.hide();
                        k.next(".icon").hide()
                    }
                });
                this.successList.forEach(function(j) {
                    g.errorsFor(j).hide()
                })
            }});
        e("input:checkbox").checkbox({cls: "checkbox", empty: "/img/alicerce/elements/checkbox/empty.png"});
        e("input:radio").checkbox({cls: "radiobutton", empty: "/img/alicerce/elements/checkbox/empty.png"});
        var j = function() {
            e("#content,#login,.ui-dialog:not(:has(#settings))").find("form").each(function() {
                var m = e(this);
                var n = m.find(".row"), k = n.children("label"), l = n.children("div");
                k.css("width", "");
                l.css("height", "");
                l.css("margin-left", "");
                k.equalWidth();
                l.css("margin-left", k.width() + parseInt(k.css("margin-right")));
                k.each(function() {
                    var r = e(this), o = r.next();
                    var p = r.outerHeight(), q = o.height();
                    if (p > q) {
                        o.height(p)
                    }
                });
                if (!m.parents(".box").length && !m.is(".box")) {
                    m.addClass("no-box")
                }
                m.find(":password.meter").each(function() {
                    e(this).data("reposition") && e(this).data("reposition")()
                })
            })
        };
        j();
        var g = e("select").not(".dualselects");
        g.each(function() {
            var k = e(this);
            k.chosen({disable_search_threshold: k.hasClass("search") ? 0 : Number.MAX_VALUE, allow_single_deselect: true, width: k.data("width") || "100%"})
        });
        e(".chzn-done").on("change", function() {
            var k = e(this).parents("form").validate();
            k && k.element(e(this))
        }).each(function() {
            var l = e(this), k = l.parents("form");
            k.on("reset", function() {
                l[0].selectedIndex = -1;
                l.trigger("liszt:updated")
            });
            k.data("chzn-reset", true)
        });
        if (!Modernizr.touch) {
            e("select.dualselects").dualselect()
        }
        e("input:file").fileInput();
        e(":cnpjcpf");

        $$.utils.forms.resize();


    }
},
//Funções de Notificações
coringa_notification = {
    init: function() {
        $.ajax({
            url: '/extras/notificacoes',
            type: 'get'
        }).done(function(data) {
            $(".content-notification").html(data);
        });
    }
},
coringa_alert = {
    locacao: function() {
        $(".coringa_dialog_confirm").remove();
        $(".coringa_dialog_alert").remove();
        $('body').append('<div class="coringa_dialog_confirm" style="padding:10px"></div>');
        var dados = [];
        $.each($('input:checkbox[checked]'), function(val, key) {
            dados.push(key.value);
        });
        if (dados.length == 0) {
            coringa_alert.alerta("Selecione um pedido para Remover", "Falha na Remoção de Pedido");
            return;
        }
        $(".coringa_dialog_confirm").dialog({
            autoOpen: true,
            modal: true,
            title: 'Exclusão de Pedido',
            width: 400,
            open: function() {
                $(this).parent().css('overflow', 'visible');
                $(this).html('<div class="alert-box alert" ><span class="icon icon-warning-sign"></span>Confirma a Exclusão do Pedido?</div>');
            },
            buttons: {
                "Confirmar": function() {
                    $.ajax({
                        url: '/extras/deletar-locacao',
                        type: 'post',
                        data: {
                            'dados': dados
                        }
                    }).done(function(data) {
                        eval(data);
                    });
                },
                "Cancelar": function() {
                    $(this).dialog("close");
                    $(".coringa_dialog_confirm").remove();
                }
            }
        }).parent().find('button').eq(0).addClass('green_confirm').prepend('<span class="icon icon-ok"></span>')
                .parent().find('button').eq(1).addClass('red_confirm').prepend('<span class="icon icon-remove"></span>')


    },
    locacaoEquip: function() {
        $(".coringa_dialog_confirm").remove();
        $(".coringa_dialog_alert").remove();
        $('body').append('<div class="coringa_dialog_confirm" style="padding:10px"></div>');
        var dados = [];
        $.each($('input:checkbox[checked]'), function(val, key) {
            dados.push(key.value);
        });
        if (dados.length == 0) {
            coringa_alert.alerta("Selecione um equipamento para Remover", "Falha na Remoção de Equipamento");
            return;
        }
        $(".coringa_dialog_confirm").dialog({
            autoOpen: true,
            modal: true,
            title: 'Exclusão de Equipamento',
            width: 400,
            open: function() {
                $(this).parent().css('overflow', 'visible');
                $(this).html('<div class="alert-box alert" ><span class="icon icon-warning-sign"></span>Confirma a Exclusão do Equipamento?</div>');
            },
            buttons: {
                "Confirmar": function() {
                    $.ajax({
                        url: '/extras/deletar-equip-list',
                        type: 'post',
                        data: {
                            cod_locacao: $("#cod_locacao").val(),
                            'dados': dados
                        }
                    }).done(function(data) {
                        eval(data);
                    });
                },
                "Cancelar": function() {
                    $(this).dialog("close");
                    $(".coringa_dialog_confirm").remove();
                }
            }
        }).parent().find('button').eq(0).addClass('green_confirm').prepend('<span class="icon icon-ok"></span>')
                .parent().find('button').eq(1).addClass('red_confirm').prepend('<span class="icon icon-remove"></span>')


    },
    manutencao: function(equipamento, cod) {
        console.info('--::>>Equipamento para Manutencao Automatica<<::--' + equipamento);
        $(".coringa_dialog_confirm").remove();
        $(".coringa_dialog_alert").remove();
        $('body').append('<div class="coringa_dialog_confirm" style="padding:10px"></div>');
        $(".coringa_dialog_confirm").dialog({
            autoOpen: true,
            modal: true,
            title: 'Retorno de Equipamento Automático',
            width: 400,
            open: function() {
                $(this).parent().css('overflow', 'visible');
                $(this).html('<div class="alert-box alert" ><span class="icon icon-warning-sign"></span>Confirma o Retorno do Equipamento?<br/>' + equipamento + '</div>');
            },
            buttons: {
                "Confirmar": function() {
                    $.ajax({
                        url: '/extras/manutencao-back',
                        type: 'get'
                    }).done(function(data) {
                        eval(data);
                    });
                },
                "Adiar Retorno": function() {
                    $.ajax({
                        url: '/extras/manutencao-adiar/cod/' + cod,
                        type: 'get'
                    }).done(function(data) {
                        $('.coringa_dialog_confirm').parent().find('button').eq(1).remove();
                        var options = {
                            beforeSubmit: function() {
                                $('.coringa_dialog_confirm').parent().find('button').eq(0).attr("disabled", "disabled");
                            }, // pre-submit callback
                            success: function(data) {
                                eval(data);
                            } // post-submit callback

                        };


                        $('.coringa_dialog_confirm').parent().find('button').eq(0).unbind("click");
                        $('.coringa_dialog_confirm').parent().find('button').eq(0).bind("click", function() {
                            $("#fm_adiar").ajaxSubmit(options);
                        });
                        $('.coringa_dialog_confirm').html(data);
                    });

                    //$(this).dialog("close");
                    //$(".coringa_dialog_confirm").remove();

                },
                "Cancelar": function() {
                    $(this).dialog("close");
                    $(".coringa_dialog_confirm").remove();
                }
            }
        }).parent().find('button').eq(0).addClass('green_confirm').prepend('<span class="icon icon-ok"></span>')
                .parent().find('button').eq(1).prepend('<span class="icon icon-time"></span>')
                .parent().find('button').eq(2).addClass('red_confirm').prepend('<span class="icon icon-remove"></span>')
    },
    alerta: function(val, val1) {
        $(".coringa_dialog_confirm").remove();
        $(".coringa_dialog_alert").remove();
        $('body').append('<div class="coringa_dialog_alert" style="padding:10px"></div>');
        $(".coringa_dialog_alert").dialog({
            autoOpen: true,
            modal: true,
            title: val1,
            width: 400,
            open: function() {
                $(this).parent().css('overflow', 'visible');
                $(this).html('<div class="alert-box error" ><span class="icon icon-info-sign"></span>' + val + '</div>');
            },
            buttons: {
                "Cancelar": function() {
                    $(this).dialog("close");
                    $(".coringa_dialog_alert").remove();
                }
            }
        }).parent().find('button').eq(0).addClass('red_confirm').prepend('<span class="icon icon-remove"></span>')
    },
    confirma: function(a, b, c) {
        $(".coringa_dialog_alert").remove();
        $(".coringa_dialog_confirm").remove();
        $('body').append('<div class="coringa_dialog_confirm" style="padding:10px"></div>');
        var dados = [];
        $.each($('input:checkbox[checked]'), function(val, key) {
            dados.push(key.value);
        });
        $(".coringa_dialog_confirm").dialog({
            autoOpen: true,
            modal: true,
            title: b,
            width: 400,
            open: function() {
                $(this).parent().css('overflow', 'visible');
                $(this).html('<div class="alert-box alert" ><span class="icon icon-warning-sign"></span>' + a + '</div>');
            },
            buttons: {
                "Confirmar": function() {
                    $.ajax({
                        url: '/extras/deleta-registro',
                        type: 'post',
                        data: {cods: dados, tablename: c}
                    }).done(function(data) {
                        eval(data);
                    });
                },
                "Cancelar": function() {
                    $(this).dialog("close");
                    $(".coringa_dialog_confirm").remove();
                }
            }
        }).parent().find('button').eq(0).addClass('green_confirm').prepend('<span class="icon icon-ok"></span>')
                .parent().find('button').eq(1).addClass('red_confirm').prepend('<span class="icon icon-remove"></span>')
    },
    confirmaManutencao: function(a, b, c) {
        $(".coringa_dialog_alert").remove();
        $(".coringa_dialog_confirm").remove();
        $('body').append('<div class="coringa_dialog_confirm" style="padding:10px"></div>');
        var dados = [];
        $.each($('input:checkbox[checked]'), function(val, key) {
            dados.push(key.value);
        });
        $(".coringa_dialog_confirm").dialog({
            autoOpen: true,
            modal: true,
            title: b,
            width: 400,
            open: function() {
                $(this).parent().css('overflow', 'visible');
                $(this).html('<div class="alert-box alert" ><span class="icon icon-warning-sign"></span>' + a + '</div>');
            },
            buttons: {
                "Confirmar": function() {
                    $.ajax({
                        url: '/extras/deleta-registro-manutencao',
                        type: 'post',
                        data: {cods: dados, tablename: c}
                    }).done(function(data) {
                        eval(data);
                    });
                },
                "Cancelar": function() {
                    $(this).dialog("close");
                    $(".coringa_dialog_confirm").remove();
                }
            }
        }).parent().find('button').eq(0).addClass('green_confirm').prepend('<span class="icon icon-ok"></span>')
                .parent().find('button').eq(1).addClass('red_confirm').prepend('<span class="icon icon-remove"></span>')
    }

},
//Funções da Agenda
coringa_agenda = {
    init: function() {
        $(".setAllDay").change(function() {
            $('.dtfim').toggle();
        });
        $("#fm_agenda").validate();
        $('.date').datetimepicker({closeText: 'Fechar',
            prevText: '&#x3c;Anterior',
            nextText: 'Pr&oacute;ximo&#x3e;',
            currentText: 'Agora',
            timeText: 'Horário',
            hourText: 'Horas',
            minuteText: 'Minutos',
            monthNames: ['Janeiro', 'Fevereiro', 'Mar&ccedil;o', 'Abril', 'Maio', 'Junho',
                'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun',
                'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            dayNames: ['Domingo', 'Segunda-feira', 'Ter&ccedil;a-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sabado'],
            dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],
            weekHeader: 'Sm',
            dateFormat: 'dd/mm/yy',
            timeFormat: "hh:mm tt",
            firstDay: 0,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''});
        var options = {
//  target:        '#output1',   // target element(s) to be updated with server response
            beforeSubmit: verificaAgenda, // pre-submit callback
            success: showResponse, // post-submit callback
            // other available options:
            url: '/extras/gravar-evento-agenda', // override for form's 'action' attribute
            //type:      type        // 'get' or 'post', override for form's 'method' attribute
            //dataType:  null        // 'xml', 'script', or 'json' (expected server response type)
            //clearForm: true        // clear all form fields after successful submit
            //resetForm: true        // reset the form after successful submit
            // jQuery.ajax options can be used here too, for example:
            //timeout:   3000
        };
        jQuery('#fm_agenda').ajaxForm(options);
    },
    eventClick: function(e) {
        $.ajax({
            url: '/extras/add-agenda',
            type: 'post',
            data: {dados: e}
        }).done(function(data) {
            $('body').append("<div id='agenda_dialog'></div>");
            $("#agenda_dialog").dialog({
                autoOpen: true,
                modal: true,
                title: "Visualizar Evento",
                width: 400,
                open: function() {
                    $(this).parent().css('overflow', 'visible');
                    $(this).html(data);
                },
                buttons: {
                    "Confirmar": function() {
                        $("#fm_agenda").submit();
                    },
                    "Excluir": function() {
                        a = confirm("Tem certeza que deseja excluir o evento da agenda?");
                        if (a == true) {
                            $.ajax({url: '/extras/deleta-evento-agenda', type: 'post', data: {dados: e}}).done(function(data) {
                                if (data) {
                                    showResponse();
                                }
                            });
                        }
                    },
                    "Cancelar": function() {
                        $(this).dialog("close");
                        $("#agenda_dialog").remove();
                    }
                }
            }).parent().find('button').eq(0).addClass('green_confirm').prepend('<span class="icon icon-ok"></span>')
                    .parent().find('button').eq(1).addClass('yellow_confirm').prepend('<span class="icon icon-trash"></span>')
                    .parent().find('button').eq(2).addClass('red_confirm').prepend('<span class="icon icon-remove"></span>')
        });
    },
    dayClick: function(e) {
        $.ajax({
            url: '/extras/add-agenda',
            type: 'post',
            data: {dataIni: e.toLocaleString()}
        }).done(function(data) {
            $('body').append("<div id='agenda_dialog'></div>");
            $("#agenda_dialog").dialog({
                autoOpen: true,
                modal: true,
                title: "Adicionar evento na Agenda",
                width: 400,
                open: function() {
                    $(this).parent().css('overflow', 'visible');
                    $(this).html(data);
                },
                buttons: {
                    "Confirmar": function() {
                        $("#fm_agenda").submit();
                    },
                    "Cancelar": function() {
                        $(this).dialog("close");
                        $("#agenda_dialog").remove();
                    }
                }
            }).parent().find('button').eq(0).addClass('green_confirm').prepend('<span class="icon icon-ok"></span>')
                    .parent().find('button').eq(1).addClass('red_confirm').prepend('<span class="icon icon-remove"></span>')
        });
    },
    eventDrop: function(e, a, b, c, d) {
        if (e.end !== null) {
            $.ajax({
                url: '/extras/move-evento-agenda',
                type: 'post',
                data: {codagenda: e.id, dtastart: e.start.toLocaleString(), dtaend: e.end.toLocaleString()}
            }).done(function(data) {
                if (data)
                    showResponse();
            });
        } else {
            c();
        }
    }
},
coringa_uploader = {
    init: function() {
        var uploader = new plupload.Uploader({
            runtimes: 'html5,flash,html4',
            drop_element: 'filelist',
            browse_button: 'filelist',
            required_features: 'access_binary',
            container: 'upcontainer',
            max_file_size: '10mb',
            url: '/equipamentos/upload',
            flash_swf_url: '/js/alicerce/forms/uploader/Moxie.swf',
            filters: [
                {title: "Image files", extensions: "jpg,gif,png"}
            ],
            init: {
                FileUploaded: function(up, file, info) {
                    // Called when a file has finished uploading
                    eval(info.response);
                },
                QueueChanged: function(up) {
                    if (up.files.length === 0) {
                        jQuery("#upcontainer").attr("style", "background:url(/img/alicerce/fundo-dialog.png);");
                        jQuery("#uploadfiles").attr("style", "display:none");
                    } else {
                        jQuery("#uploadfiles").removeAttr("style", "display");
                    }
                    ;
                },
                FilesRemoved: function(up, files) {
                    mOxie.each(files, function(file) {
                        jQuery("#" + file.id).remove();
                        up.disableBrowse(false);
                    });
                },
                StateChanged: function(up) {
                    if (up.state === 1) {
                    }
                }
            },
            Error: function(up, args) {
                // Called when a error has occured
                console.log('[error] ', args);
            }
            //resize: {width: 320, height: 240, quality: 90}
        });
        uploader.bind('Init', function(up, params) {
        });
        uploader.init();
        uploader.bind('FilesAdded', function(up, files) {
            //
            mOxie.each(files, function(file) {
                var img = new mOxie.Image();
                img.onload = function() {
                    var dataUrl = img.getAsDataURL();
                    // use dataUrl wherever you like
                    jQuery('#filelist').append(
                            '<div id="' + file.id + '" class="obj">' +
                            '<div class="delete-file icon-remove d_' + file.id + '" data-file="' + file.name + '" data-id="' + file.id + '" ></div>' +
                            '<div class="mask m_' + file.id + '">' +
                            '</div>' +
                            '<img class="preview" src="' + dataUrl + '"/>' +
                            '<small>' + file.name +
                            ' (' + plupload.formatSize(file.size) + ') <b></b>' + '</small>' +
                            '<div class="upload_' + file.id + '" style="height: 10px!important;width: 170px!important;"></div>' +
                            //file.name + ' (' + plupload.formatSize(file.size) + ') <b></b>' +
                            '</div>');
                    jQuery("#upcontainer").attr("style", "background:none");
                };
                img.load(file.getSource());
            });
            up.refresh(); // Reposition Flash/Silverlight
        });
        uploader.bind('UploadProgress', function(up, file) {
            jQuery('#' + file.id + " b").html(file.percent + "%");
            jQuery('.upload_' + file.id).progressbar({value: file.percent});
            jQuery('.m_' + file.id).attr("style", "opacity:" + (1 - (file.percent / 100)) + "");
            jQuery('#' + file.id + " img").attr("style", "opacity:" + (file.percent / 100));
        });
        uploader.bind('Error', function(up, err) {
            jQuery('#filelist').append("<div>Error: " + err.code +
                    ", Message: " + err.message +
                    (err.file ? ", File: " + err.file.name : "") +
                    "</div>"
                    );
            up.refresh(); // Reposition Flash/Silverlight
        });
        jQuery('#uploadfiles').click(function(e) {
            uploader.start();
            e.preventDefault();
        });
        jQuery('.delete-file').bind('mouseover', function() {
            uploader.disableBrowse(true);
        });
        jQuery('.delete-file').bind('mouseout', function() {
            uploader.disableBrowse(false);
        });
        jQuery('.delete-file').bind('click', function() {
            var dados = jQuery(this).data();
            var input_remove = "#" + dados.removeinput;
            $(input_remove).remove();
            if (dados.id != '') {
                uploader.removeFile(dados.id);
                jQuery.ajax({
                    url: '/extras/remove-imagens/',
                    type: 'post',
                    data: {imagem: dados.id}
                }).done(function(e) {
                    eval(e);
                });
            }
        });
        uploader.bind('FileUploaded', function(up, file) {
            jQuery('#' + file.id + " b").html("100%");
            jQuery('.upload_' + file.id).remove();
            jQuery('.d_' + file.id).attr("style", "display:none");
            jQuery("#uploadfiles").attr("style", "display:none");
        });
    }
};



function numDias(mes, ano) {
    if ((mes < 8 && mes % 2 == 1) || (mes > 7 && mes % 2 == 0))
        return 31;
    if (mes != 2)
        return 30;
    if (ano % 4 == 0)
        return 29;
    return 28;
}
function somaDias(data, dias) {
    data = data.split("/");
    futuro = parseInt(data[0]) + dias;
    mes = parseInt(data[1]);
    ano = parseInt(data[2]);
    while (futuro > numDias(mes, ano)) {
        futuro -= numDias(mes, ano);
        mes++;
        if (mes > 12) {
            mes = 1;
            ano++;
        }
    }
    if (futuro < 10)
        futuro = '0' + futuro;
    if (mes < 10)
        mes = '0' + mes;
    return futuro + '/' + mes + '/' + ano;
}
setInterval(function() {
    $.ajax({
        url: '/extras/jobs',
        type: 'get',
        success: function(data) {
            eval(data);
        }
    });
}, 60000);
addCategoria = function(dado) {
    console.log(dado);
};
roda = {
    check_change: function(mode) {
        if (mode === true) {
            $( window ).unload(function() { 
            ConfirmExit();    //Handling the event 
            }); 
            

        } else {
            $( window ).unload(function() { 
                return;             
            });
        }
    }

};
function ConfirmExit() { //Pode se utilizar um window.confirm aqui também...
    return "Você fez alterações na página que ainda não foram salvas.";
}
addOption = function(func_call, campo_call, res, campo_fixo, campo_ref, option) {
    if (campo_ref !== undefined) {
        var cref = campo_ref.split(":");
        var cherd = cref[0];
        var cnamed = cref[1];
        var vref = $("#" + cherd).val();
        console.log(campo_ref);
        $.ajax({
            url: '/ajax/add-option',
            type: 'post',
            data: {tabela: func_call, campo: campo_call, valor: res.val(), campofixo: campo_fixo, value_ref: vref, camponamed: cnamed, camporef: option},
            success: function(data) {
                eval(data);
            }
        });
    }else{
        $.ajax({
            url: '/ajax/add-option',
            type: 'post',
            data: {tabela: func_call, campo: campo_call, valor: res.val(),camporef: option},
            success: function(data) {
                eval(data);
            }
        });
    }
};