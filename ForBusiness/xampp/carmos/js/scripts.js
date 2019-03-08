//(function () {
//    "use strict";
//    $("html").niceScroll({styler: "fb", cursorcolor: "#F2B33F", cursorwidth: '6', cursorborderradius: '10px', background: '#424f63', spacebarenabled: false, cursorborder: '0', zindex: '1000'});
//    $(".scrollbar1").niceScroll({styler: "fb", cursorcolor: "rgba(97, 100, 193, 0.78)", cursorwidth: '6', cursorborderradius: '0', autohidemode: 'false', background: '#F1F1F1', spacebarenabled: false, cursorborder: '0'});
//    $(".scrollbar1").getNiceScroll();
//    if ($('body').hasClass('scrollbar1-collapsed')) {
//        $(".scrollbar1").getNiceScroll().hide();
//    }
//})(jQuery);

$(document).ready(function () {

    var AjaxBtn = function (obj) {
        var btn = obj;
        var form = obj.closest('form');

        this.baseUrl = base_url;
        this.controller = form.attr('name');
        this.method = form.attr('data-method');

        this.update = function () {
            $(".loading-overlay").show();
            var item = JSON.stringify(form.serializeToJSON());

            btn.addClass('disabled');
            $.ajax({
                method: "POST",
                url: this.baseUrl + this.controller + "/" + this.method,
                data: {"item": item},
                dataType: "json"
            }).done(function (resp) {
                btn.removeClass('disabled');
                $(".loading-overlay").hide();
                toastr.success(resp.message);
            });
        };
    };

    $(document).on('click', '.saveBtn', function (e) {
        e.preventDefault();
        var aBtn = new AjaxBtn($(this));
        aBtn.update();
    });

    $(document).on('click', '.btnDocAddFilter', function (e) {
        e.preventDefault();
        addFilter();
    });

    $(document).on('click', '.btnDocSearchFilter', function (e) {
        e.preventDefault();
        $('#filterDoc').submit();
    });

    $(document).on('click', '.btnDocRemFilter', function (e) {
        e.preventDefault();
        var btn = $(this);
        removeTR(btn);
    });
});

function PedirQtt(msg, callback) {
    bootbox.prompt({
        title: msg,
        inputType: 'number',
        callback: function (result) {
            callback(parseFloat(result));
        }
    })
}

function DesejaContinuar(msg, yes, no) {
    bootbox.dialog({
        message: msg,
        buttons: {
            confirm: {
                label: 'Sim',
                className: 'btn-success',
                callback: function (result) {
                    yes(parseFloat(result));
                }
            },

            cancel: {
                label: 'Não',
                className: 'btn-danger',
                callback: function (result) {
                    no(parseFloat(result));
                }
            }
        }
    });
}

$(document).ready(function () {
    if ($('.dtinit').length) {
        dtCl = $('.dtinit').DataTable({
            dom: 'lBfrtip',
            buttons: [
                {
                    extend: 'copy',
                    text: '<i class="fa fa-copy"></i> Copiar',
                    titleAttr: 'Copiar'
                },
                {
                    extend: 'csv',
                    text: '<i class="fa fa-file-text-o"></i> CSV',
                    titleAttr: 'CSV'
                },
                {
                    extend: 'excel',
                    text: '<i class="fa fa-file-excel-o"></i> Excel',
                    titleAttr: 'Excel'
                },
                {
                    extend: 'pdf',
                    text: '<i class="fa fa-file-pdf-o"></i> PDF',
                    titleAttr: 'PDF'
                },
                {
                    extend: 'print',
                    text: '<i class="fa fa-print"></i> Imprimir',
                    titleAttr: 'Imprimir'
                }
            ],
            "aaSorting": [[$('.dtinit').attr("tab-ordercol"), $('.dtinit').attr("tab-order")]],
            oLanguage: {
                sSearch: "Procurar:",
                oPaginate: {
                    sFirst: "Primeiro",
                    sLast: "Último",
                    sNext: "Seguinte",
                    sPrevious: "Anterior"
                },
                "sInfo": "A mostrar _START_ até _END_ registos de um total de _TOTAL_ registos",
                "sLengthMenu": "Mostrar _MENU_ registos"
            },
            "iDisplayLength": parseInt($('.dtinit').attr("tab-numrow")),
            sPaginationType: "full_numbers",
            bSort: ((($('.dtinit').attr("tab-sort") == null) ? "true" : $('.dtinit').attr("tab-sort")) == true),
            bPaginate: ((($('.dtinit').attr("tab-paginate") == null) ? "true" : $('.dtinit').attr("tab-paginate")) == true),
            bFilter: ((($('.dtinit').attr("tab-filter") == null) ? "true" : $('.dtinit').attr("tab-filter")) == true),
            bInfo: ((($('.dtinit').attr("tab-info") == null) ? "true" : $('.dtinit').attr("tab-info")) == true)
        });
    }
});

function EnviaEmail(email) {
    window.location = "mailto:" + email;
}

function AbreMaps(address) {
    var win = window.open("https://www.google.pt/maps/search/" + address, '_blank');
    win.focus();
}

function removeTR(obj) {
    obj.parent().parent().remove();
    $('#log_op').val("");
    $('#val1').val("");
    $('#comp_op').val("");
    $('#val2').val("");

    var tmp_qr = getFilter();
    $('#tabFilterData').val(encodeURIComponent(tmp_qr));
}

function addFilter() {
    var linha = "<td>" + $('#log_op').find(":selected").text() + " " + $('#val1').find(":selected").text() + " " + $('#comp_op').find(":selected").text() + " '" + $('#val2').val() + "'</td>";
    linha += "<td class='hidden'>" + jQuery("#log_op").val() + "</td>";
    linha += "<td class='hidden'>" + jQuery("#val1").val() + "</td>";
    linha += "<td class='hidden'>" + jQuery("#comp_op").val() + "</td>";
    linha += "<td class='hidden'>" + jQuery("#val2").val() + "</td>";
    $('#TabFiltro tr:last').after('<tr>' + linha + '<td><a class="btn btn-success btnDocRemFilter"><i class="fa fa-trash white"></i></a></td></tr>');

    $('#log_op').val("");
    $('#val1').val("");
    $('#comp_op').val("");
    $('#val2').val("");

    var tmp_qr = getFilter();
    $('#tabFilterData').val(encodeURIComponent(tmp_qr));
}

function getFilter() {
    var tmp_str = "";

    $('#TabFiltro tr').not(':first').each(function () {
        if ($(this).children().eq(3).html() == "=") {
            tmp_log = "= '" + $(this).children().eq(4).html() + "'";
        } else if ($(this).children().eq(3).html() == "&gt;=") {
            tmp_log = ">= '" + $(this).children().eq(4).html() + "'";
        } else if ($(this).children().eq(3).html() == "&lt;=") {
            tmp_log = "<= '" + $(this).children().eq(4).html() + "'";
        } else if ($(this).children().eq(3).html() == "&lt;&gt;") {
            tmp_log = "<> '" + $(this).children().eq(4).html() + "'";
        } else if ($(this).children().eq(3).html() == "%x%") {
            tmp_log = "LIKE '%" + $(this).children().eq(4).html() + "%'";
        } else if ($(this).children().eq(3).html() == "n%x%") {
            tmp_log = "NOT LIKE '%" + $(this).children().eq(4).html() + "%'";
        } else if ($(this).children().eq(3).html() == "x%") {
            tmp_log = "LIKE '" + $(this).children().eq(4).html() + "%'";
        } else if ($(this).children().eq(3).html() == "%x") {
            tmp_log = "LIKE '%" + $(this).children().eq(4).html() + "'";
        }

        tmp_str += $(this).children().eq(1).html() + "  " + $(this).children().eq(2).html() + " " + tmp_log + "\n"
    });

    return tmp_str;
}