/**
 * Unicorn Admin Template
 * Version 2.0.1
 * Diablo9983 -> diablo9983@gmail.com
 **/

$(document).ready(function() {

    var checkboxClass = 'icheckbox_flat-' + $.cookie("spage");
    var radioClass = 'iradio_flat-' + $.cookie("spage");
    $('input[type=checkbox],input[type=radio]').iCheck({
        checkboxClass: checkboxClass,
        radioClass: radioClass
    });

    $('select').select2();
    $('.colorpicker').colorpicker();
    $('.datepicker').datepicker();

    $(document).on("change", "#ind_estado", function() {
        var uf = $(this).val();
        $.getJSON('/json/get-cidades/uf/' + uf, function(data) {
            if (data !== null && data !== undefined) {
                var content = $("#ind_cidade").html('<option>Selecione uma Cidade</option>');
                $.each(data, function(d) {
                    content.append("<option value='" + data[d].nom_cidade + "'>" + data[d].nom_cidade + "</option>");
                });
            }

        });
    });
    $(document).on("submit","#fm_validate",function(e){
        if(!$(this).find("input").valid()){
            
            
            
            e.preventDefault();
            
            return false;
            
        }else{
            return true;
        }
        
    });
    jQuery.validator.addMethod("valueNotEquals", function(value, element, param) {
        return this.optional(element) || value != param;
    }, "Please specify a different (non-default) value");

    $("#fm_validate").validate({
        rules: {
            "nom_instrutor": {
                required: true
            },
            "end_email": {
                required: true,
                email: true
            },
            "ind_estado": {
                required: true,
                valueNotEquals: 'Selecione um Estado'
            },
            "ind_cidade": {
                required: true,
                valueNotEquals: 'Selecione um estado para exibir as cidades.'
            },
            "end_url": {
                required: false,
                url: true
            }
        },
        messages: {
            "nom_instrutor": "Digite um nome para o Instrutor.",
            "ind_estado": {required: "Selecione seu Estado.", valueNotEquals: "Selecione seu Estado."},
            "ind_cidade": {required: "Selecione sua Cidade.", valueNotEquals: "Selecione sua Cidade."},
            "end_email": {
                required: "É necessário informar um email para contato.",
                email: "Digite um endereço de email válido."
            },
            "end_url": {
                url: "Digite uma página web válida."
            },
        },
        errorClass: "help-inline",
        errorElement: "span",
        highlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').addClass('has-error');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).parents('.form-group').removeClass('has-error');
            $(element).parents('.form-group').addClass('has-success');
        }
    });
});
