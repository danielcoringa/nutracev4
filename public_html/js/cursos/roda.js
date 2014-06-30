// Funções padrão do Aplicativo


$('#add-event-submit').click(function(e) {
    roda.add_event();
});
var oa_geral = {
    target: '#bdformacao', // target element(s) to be updated with server response
    //beforeSubmit: validacao, // pre-submit callback
    //success: showDialog, // post-submit callback
    uploadProgress: function(event, position, total, percentComplete) {

    },
    success: function() {
        $('#modal-add-event').modal('hide');
        $("#formacao-body input").removeAttr("required");
        $("#formacao-body input").val('');
        $("#formacao-body textarea").html('');
        $("#formacao-body textarea").val('');
        $("#fm_validate").attr("action", "/instrutores/cadastro");
    },
    // other available options:
    // url: '/anuncios/novo/tipo/vender', // override for form's 'action' attribute
    // type:      type        // 'get' or 'post', override for form's 'method' attribute
    // dataType:  null        // 'xml', 'script', or 'json' (expected server response type)
    // clearForm: true        // clear all form fields after successful submit
    // resetForm: true        // reset the form after successful submit
    // jQuery.ajax options can be used here too, for example:
    // timeout:   3000
};

roda = {
    add_event: function() {
        if ($("#fm_validate").valid() && $(".codid").val()!=='') {
            $("#fm_validate").attr("action", "/instrutores/formacao");
            $("#formacao-body input:not('.ignore')").attr("required", "required");
            if ($("#fm_validate").valid()) {
                $("#fm_validate").ajaxSubmit(oa_geral);
            }
        } else {
            this.show_error();
        }
    },
    // === Show error if no event name is provided === //
    show_error: function() {
        $('#modal-error').remove();

        $('<div style="border-radius: 5px; top: 70px; font-size:14px; left: 50%; margin-left: -150px; position: absolute;width: 300px; background-color: #f00; text-align: center; padding: 5px; color: #ffffff;" id="modal-error">É preciso salvar os dados pessoais antes de criar uma formação.</div>').appendTo('#modal-add-event .modal-body');
        $('#modal-error').delay('1500').fadeOut(700, function() {
            $(this).remove();
            $('#modal-error').remove();
            $('#modal-add-event').modal('hide');
            $('.nav-tabs li:eq(0) a').tab('show');
        });
    },
    // === Prevent page reload or exit if a form change === //
    check_change: function(mode) {
        if (mode === true) {
            window.onbeforeunload = ConfirmExit;

        } else {
            window.onbeforeunload = '';
        }
    }

};
function ConfirmExit() {
    return "Você fez alterações na página que ainda não foram salvas.";
}
var clique = true;
$(document).ready(function() {
  
    // Controla os clicks nas rows da Grid
    $(document).on("click", ".selrows", function(e) {
           e.preventDefault();
           clique = true;
           checkStatus($(this));
           return;
    });
    $(document).on("mousedown", ".selrows", function(e) {
            e.preventDefault();
            if(clique===true){
                clique = false;
                return;
            }
                $(this).find(":checkbox").iCheck('check');
                $(this).find(":checkbox").attr("checked", "checked");
                $(this).addClass("active");
            
    });
    // Função para checar status das linhas da grid
    checkStatus = function(elm){
        
        
        if (elm.find(":checkbox").attr("checked") === "checked") {
                elm.find(":checkbox").iCheck('uncheck');
                elm.find(":checkbox").removeAttr("checked");
                elm.removeClass("active");
            } else {
                elm.find(":checkbox").iCheck('check');
                elm.find(":checkbox").attr("checked", "checked");
                elm.addClass("active");
            }
        
        
    };

    // Cria o Menu de Contexto das Grids
    context.init({preventDoubleContext: true});
    context.settings({compress: true});
    context.attach('.data-table', [
        //{header: 'Opções da Listagem'},
        {text: 'Editar Registro', action: function(e) {
                e.preventDefault();
                var local = $('.butreg button').parent().data('local');
                vCheck('edit', local);
            }},
        {text: 'Excluir Registro', action: function(e) {
                e.preventDefault();
                var local = $('.butreg button').parent().data('local');
                vCheck('exclude', local);
            }},
        {text: 'Alterar Status', action: function(e) {
                e.preventDefault();
                var local = $('.butreg button').parent().data('local');
                vCheck('update', local);
            }},
        {divider: true},
        {text: 'Novo Registro', action: function(e) {
                e.preventDefault();
                var local = $('.butreg button').parent().data('local');
                window.location = local + '/cadastro';
            }},
        {divider: true},
        {text: 'Selecionar Todos', action: function(e) {
                e.preventDefault();
                this.innerHTML = 'Remover Seleção';
                var checkboxClass = 'icheckbox_flat-' + $.cookie("spage");

                if ($("#checker").closest('.' + checkboxClass).hasClass("checked")) {
                    var checkedStatus = false;
                    $("#checker").iCheck('uncheck');
                    this.innerHTML = 'Selecionar Todos';
                } else {
                    var checkedStatus = true;
                    $("#checker").iCheck('check');
                    this.innerHTML = 'Remover Seleção';
                }

                var checkbox = $('.optcheck');
                checkbox.each(function() {
                    if (checkedStatus) {
                        $(this).iCheck('check');
                        $(this).attr("checked", "checked");
                        $(this).parent().parent().parent().addClass("active");
                    } else {
                        $(this).iCheck('uncheck');
                        $(this).removeAttr("checked");
                        $(this).parent().parent().parent().removeClass("active");
                    }
                });
            }},
    ]);




});
// Checka se existem registros selecionados para manipulação
vCheck = function(mode, local) {
    var checks = $(".optcheck:checked");
    var total = checks.length;
    switch (mode) {
        case 'edit':
            if (total === 0) {
                sDialog('alerta', 'É necessário selecionar um registro para Edição.');
            } else {
                if (total > 1) {
                    sDialog('alerta', 'É necessário selecionar apenas 1 registro para Edição.');
                } else {
                    window.location = local + '/cadastro/editar/' + checks.val();
                }
            }
            break;
        case 'exclude':
            if (total < 1) {
                sDialog('alerta', 'É necessário selecionar um registro para Excluir.');
                return false;
            } else {
                if (total > 1) {
                    sDialog('confirma', 'Tem certeza que deseja excluir os registros selecionados?', function() {
                        delReg(local, checks);
                    }, 'Excluir');
                } else {
                    sDialog('confirma', 'Tem certeza que deseja excluir o registro selecionados?', function() {
                        delReg(local, checks);
                    }, 'Excluir');
                }
            }
            break;
        case 'update':
            if (total < 1) {
                sDialog('alerta', 'É necessário selecionar um registro para Atualizar o Status.');
                return false;
            } else {
                if (total > 1) {
                    sDialog('confirma', 'Tem certeza que deseja atualizar os registros selecionados?', function() {
                        updateReg(local, checks);
                    }, 'Atualizar');
                } else {
                    sDialog('confirma', 'Tem certeza que deseja atualizar o registro selecionados?', function() {
                        updateReg(local, checks);
                    }, 'Atualizar');
                }
            }
            break;
    }
};
sDialog = function(mode, msg, func, butOk) {
    switch (mode) {
        case 'confirma':
            $("#dialog").html('<div class="text-center"><h3 class="alert-heading">Atenção!</h3><p class="big">' + msg + '</p></div>')
                    .dialog({
                        title: "Confirmar Ação",
                        autoOpen: true,
                        buttons: {
                            "ok": {
                                text: butOk,
                                class: 'btn btn-small btn-danger',
                                click: function() {
                                    func();
                                    $(this).dialog("close");
                                }},
                            "cancel": {
                                text: 'Cancelar',
                                class: 'btn btn-small btn-person',
                                click: function() {
                                    $(this).dialog("close");
                                }
                            }

                        }
                    });
            break;
        default:
            $("#dialog").html('<div class="text-center"><h3 class="alert-heading">Atenção!</h3><p class="big">' + msg + '</p></div>')
                    .dialog({
                        title: "Alerta do Sistema",
                        autoOpen: true,
                        buttons: {
                            "cancel": {
                                text: 'Cancelar',
                                class: 'btn btn-small btn-danger',
                                click: function() {
                                    $(this).dialog("close");
                                }
                            }
                        }
                    });
            break;
    }
};





//
SyntaxHighlighter.config.bloggerMode = false;
SyntaxHighlighter.all();
//
$(document).ajaxComplete(function(e, d, f) {
    if (d.status == 500) {

    }

});

// 
 