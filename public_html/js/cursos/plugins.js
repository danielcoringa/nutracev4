// DataGrid personalizado com Toolbuttons e funções especiais
// Adaptado do dataTable jQuery para o Bootstrap e jQueryUI
// Impressão da lista em CSV, PDF e Excel
(function(d, c, a) {
    var b = "table";
    d.fn[b] = function(e) {
        var f = d(this);
        return d(this).each(function() {
            var dt = d(this);
            var tn = '/grid/list/t/' + dt.data("table") + '/';
            d.fn[b].defaults = {
                sDom: '<"filters"<"toolbuttons"fl>>t<"F"ip>',
                filterBar: "toggle",
                showFilterBar: true,
                bJQueryUI: true,
                maxItemsPerPage: 10,
                dataTable: {
                    sAjaxSource: tn,
                    bProcessing: false,
                    bServerSide: false,
                    aoColumnDefs: [
                        {"bSortable": false, "aTargets": [0]}
                    ],
                    fnInitComplete: function() {
                        $(this).find("tr:not('.nocheck')").addClass("selrows");
                        $.each($(".inactive"), function(e) {

                            
                                var vdata = ($(".inactive").eq(e));
                                $(vdata).parent().parent('tr').addClass("alert").attr("title", "Registro Inativo");
                                //$('.tooltip').tipsy();
                            
                        });
                        $(document).on("dblclick", ".selrows", function() {

                            var cod = $(this).find(':checkbox').val();
                            var table = $(this).parent().parent().data("table");
                            window.location = '/' + table + '/cadastro/editar/' + cod;
                        });


                        $('input[type=checkbox],input[type=radio]').iCheck({
                            checkboxClass: 'icheckbox_flat-' + $.cookie("spage"),
                            radioClass: 'iradio_flat-' + $.cookie("spage")
                        });
                        $("#checker").on('ifChecked || ifUnchecked', function(event) {
                            var checkboxClass = 'icheckbox_flat-' + $.cookie("spage");
                            var radioClass = 'iradio_flat-' + $.cookie("spage");
                            var checkedStatus = this.checked;
                            if(checkedStatus===true){
                            var model = 'check';
                            
                        }else{
                            var model = 'uncheck';
                            
                        }
                            
                            var checkbox = $('.optcheck:not("#checker")');
                            
                            checkbox.each(function() {
                                
                                if (model!=='check') {
                                     $(this).closest("tr:not('.nocheck')").removeClass("active"); 
                                      $(this).iCheck('uncheck');
                                      $(this).removeAttr("checked");

                                }else {
                                     $(this).closest("tr:not('.nocheck')").addClass("active");
                                      $(this).iCheck('check');
                                      $(this).attr("checked","checked");
                                      
                                }
                            });

                        });
                    },
                    aaSorting: [],
                    "oLanguage": {
                        "sZeroRecords": "Nenhum registro encontrado",
                        "sProcessing": "Carregando registros"
                    }

                },
                tableTools: {
                    display: true,
                    buttons: ["csv", "xls", "pdf"],
                    pos: "left",
                    swfUrl: "/extra/datatables/copy_csv_xls_pdf.swf",
                    extras: {}
                },
                lang: {
                    SHOW_ENTRIES: "Nº Rgs:",
                    SEARCH: "Pesquisar:",
                    NEXT: "Próximo"

                }
            }
            var h = d(this), l = d.extend(true, {}, d.fn[b].defaults, e, h.data());



            if (h.data("tableTools")) {
                h.data("tableTools", d.parseJSON(h.data("tableTools")));
            }
            h.dataTable(d.extend(true, {
                sDom: '<"filters"<"toolbuttons"fl>>t<"F"ip>',
                bJQueryUI: true,
                sPaginationType: "full_numbers",
                iDisplayLength: l.maxItemsPerPage,
                oLanguage: {
                    sLengthMenu: "<span class=text>" + l.lang.SHOW_ENTRIES + "</span> _MENU_",
                    sSearch: "<span class=text>" + l.lang.SEARCH + "</span> _INPUT_"
                },
                aLengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Todos"]]
            }, l.dataTable)).parent().find(".dataTables_length select").data("width", "auto");
            var k = h.parent(), j = k.find(".filters");
            ["with-prev-next", "full"].forEach(function(n) {
                h.hasClass(n) && k.addClass(n);
            });
            h.removeClass("full");

            k.prev(".tabletools").insertBefore(h);
            if (l.tableTools.display || k.find(".tabletools").length) {
                if (l.tableTools.display) {
                    var g = new TableTools(h.dataTable(), d.extend(true, {
                        sSwfPath: l.tableTools.swfUrl,
                        aButtons: l.tableTools.buttons
                    }, l.tableTools.extras));
                }
                var m = k.find(".tabletools");
                if (m.length) {

                    //  m = d("<div class=tabletools><div class=left></div><div class=right></div></div>").insertBefore(h);
                } else {
                    var r = k.find(".filters div");
                    m = d("<div class='tabletools'><div class=left></div><div class=right></div></div>").insertAfter(r);


                }
                if (l.tableTools.display) {

                    m.find("." + l.tableTools.pos).append(g.dom.container);
                    $(".tabletools").eq(0).remove();
                    $(".toolbuttons div").eq(1).append("&nbsp;<p class='butreg btr' data-local='" + h.data("table") + "'></p>");
                    $(".btr").append("&nbsp;<button class='btn-person btn-mini btn-success' title='Adicionar Registro' data-action='add' type='button'><i class='glyphicon glyphicon-plus'></i> Novo Registro</button>");
                    $(".btr").append("&nbsp;<button class='btn-person btn-mini btn-primary' title='Editar Registro' data-action='edit' type='button'><i class='glyphicon glyphicon-edit'></i> Alterar Registro</button>");
                    $(".btr").append("&nbsp;<button class='btn-person btn btn-mini btn-danger' title='Excluir Registro' data-action='remove' type='button'><i class='glyphicon glyphicon-remove'></i> Remover Registro</button>");




                }
            }
            if (l.filterBar != "none") {
                if (l.filterBar == "toggle") {
                    var i = d("<div class=toggleFilter></div>").insertBefore(k).click(function() {
                        j.slideToggle(10 * 2 / 3);
                        i.toggleClass("active");
                    });
                    if (l.showFilterBar) {
                        i.addClass("active");
                    }
                }
                if (l.filterBar == "always" || l.showFilterBar) {
                    k.find(".filters").show();
                }
            }
            window.tbgrid = h;
        });

    };

})(jQuery, this, document);