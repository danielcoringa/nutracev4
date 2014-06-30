$(document).ready(function() {
    if ($.cookie("spage") === undefined) {
        $.cookie("spage", "blue");
    }
    $('.data-table').table();



    var checkboxClass = 'icheckbox_flat-' + $.cookie("spage");
    var radioClass = 'iradio_flat-' + $.cookie("spage");
    $('input[type=checkbox],input[type=radio]').iCheck({
        checkboxClass: checkboxClass,
        radioClass: radioClass
    });

    $('select').select2();


    
    $("#dialog").dialog({
        autoOpen: false,
        modal: true,
        width: 600,
        show: {
            effect: "fade",
            duration: 500
        },
        hide: {
            effect: "fade",
            duration: 500
        }
    });
    $(document).on("click", ".butreg button", function() {
        
        var mode = $(this).data('action');
        
        var local = $(this).parent().data('local');
        switch (mode) {
            case 'add':
                window.location = local + '/cadastro';
                break;
            case 'edit':
                vCheck('edit', local);
                break;
            case 'remove':
                console.log(mode);
                vCheck('exclude', local);
                break;
            default:
                break;
        }
    });
});
function delReg(local, checks) {
    var ids = new Array();
    $.each(checks, function(i) {

        ids.push(checks[i].value);
    });


    $.ajax({
        url: '/grid/remove',
        type: 'post',
        data: {'ids': ids, 'table': local},
        success: function(data) {
            eval(data);
        }
    });


}
function updateReg(local, checks) {
    var ids = new Array();
    $.each(checks, function(i) {

        ids.push(checks[i].value);
    });


    $.ajax({
        url: '/grid/update',
        type: 'post',
        data: {'ids': ids, 'table': local},
        success: function(data) {
            eval(data);
        }
    });


}
;
function removeSelRows() {
    var content = $('.data-table').find(":checkbox:not('#checker')");
    var rowdel = new Array();
    $.each(content, function(i) {
        if (content[i].checked) {
            rowdel.push(i);
        }
    });
    var rowdeldesc = rowdel.sort(function(a, b) {
        return b - a;
    });
    $.each(rowdel, function(i) {
        tbgrid.fnDeleteRow(rowdel[i]);
    });

}
function updateSelRows(mode,elm) {
    var content = $('.data-table').find(":checkbox:checked:not('#checker')");
    if (mode === 'ativo') {
        content.eq(elm).parent().parent().parent().removeClass('alert').find('.inactive').html('<span class="icon-ok-circle"></span>&nbsp;Ativo').removeClass("inactive").addClass("active");
        console.log('ativo');
        window.rowsel =content.eq(elm).parent().parent().parent();
    } else {
        content.eq(elm).parent().parent().parent().addClass('alert').find('.active').html('<span class="icon-ban-circle"></span>&nbsp;Inativo').removeClass("active").addClass("inactive");
        console.log('inativo');
        window.rowsel =content.eq(elm).parent().parent().parent();
    }
//    var rowdel = new Array();
//    $.each(content, function(i) {
//        $(content).find(".inactive").html("Ativo");
//    });
//    var rowdeldesc = rowdel.sort(function(a, b) {
//        return b - a;
//    });
//    $.each(rowdel, function(i) {
//        tbgrid.fnDeleteRow(rowdel[i]);
//    });

}