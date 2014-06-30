/**
 * Controle de Cursos e Video Aulas RoDa Sistemas
 * Versão 1.0.0
 * Sistema de Gestão de Cursos On-line
 * Rodrigo Daniel Andrade - 2014
 **/

$(document).ready(function() {
    
    // Seta os checkboxs e radiobuttons para o iCheck
    var checkboxClass = 'icheckbox_flat-' + $.cookie("spage");
    var radioClass = 'iradio_flat-' + $.cookie("spage");
    $('input[type=checkbox],input[type=radio]').iCheck({
        checkboxClass: checkboxClass,
        radioClass: radioClass
    });
    
    // Cria os Select2
    $('select').select2();
    
    // Cria os colorpickers
    $('.colorpicker').colorpicker();
    
    // Cria os datepicker
    $('.datepicker').datepicker({
        language: "pt-BR",
        startView: 1,
        minViewMode: 1
    });
    
    // Atribui evento de click nos botões de reset dos formulários
     $(document).on("click",":reset",function(e){
         e.preventDefault();
            var path = window.location.pathname;
            var oldLocal = path.split("/");
            roda.check_change(false);
            window.location = '/'+oldLocal[1];
     });
     
     // Verifica se o formulário foi alterado para validação de saida de página
    $(document).on("change","form",function(){
        roda.check_change(true);
    });
    
    // Atribui o evento de preenchimento automático de cidades conforme o 
    // select de Estados for selecionado um valor
    // o parametro é passado por JSON e montado no select de Cidades
    // para usar essa funcionalidade os campos precisam ter nomes específicos
    // #ind_estado para o select de Estados
    // #ind_cidade para o select de Cidades
    $(document).on("change", "#ind_estado", function() {
        var uf = $(this).val();
        $.getJSON('/json/get-cidades/uf/' + uf, function(data) {
            if (data !== null && data !== undefined) {
                var content = $("#ind_cidade").html('<option>Selecione um estado para exibir as cidades.</option>');
                $.each(data, function(d) {
                    content.append("<option value='" + data[d].nom_cidade + "'>" + data[d].nom_cidade + "</option>");
                });
            }

        });
    });
    
    // Validação do formulário ao ser enviado.
    $(document).on("submit","#fm_validate",function(e){
        if(!$('#fm_validate').valid()){
            e.preventDefault();
            $('.nav-tabs li:eq(0) a').tab('show');   
            return false;
        }else{
            
            roda.check_change(false);
            return true;
        }
    });

    // Opções da validação dos formulários
    
    // Cria uma instancia de comparação de valores
    jQuery.validator.addMethod("valueNotEquals", function(value, element, param) {
        return this.optional(element) || value != param;
    }, "Please specify a different (non-default) value");
    
    // Campos da validação
    $("#fm_validate").validate({
        ignore : [], 
        rules: {
            "nom_categoria": {
                required: true
            },
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
        // Mensagens de erro da validação
        messages: {
            "nom_categoria": "Digite um nome para a Categoria.",
            "nom_instrutor": "Digite um nome para o Instrutor.",
            "ind_estado": {required: "Selecione seu Estado.", valueNotEquals: "Selecione seu Estado."},
            "ind_cidade": {required: "Selecione sua Cidade.", valueNotEquals: "Selecione sua Cidade."},
            "nom_curso":"Digite um nome de Curso ou Formação",
            "nom_instituicao":"Digite um nome para a instituição ou cidade",
            "dta_inicio":"Informe a data de Início",
            
            "end_email": {
                required: "É necessário informar um email para contato.",
                email: "Digite um endereço de email válido."
            },
            "end_url": {
                url: "Digite uma página web válida."
            },
        },
        // Estilo do alerta de validação
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
        // Evento de envio de dados por Ajax
        
        //Opções do ajax dos cadastros
        var options ={
            beforeSubmit:function(){
                $(":submit").attr("disabled","disabled");
            },
            success:function(data){
                eval(data);
                $(":submit").removeAttr("disabled");
            }
        };
        $(".ajaxform").ajaxForm(options);
});
