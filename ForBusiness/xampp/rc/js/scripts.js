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

    $(document).on('click', '.modal-footer #modsavebut', function (e) {
        var modal = $('.targetModal');
        var sv_func = modal.find('.modal-footer #modsavebut').attr('data-save');
        eval(sv_func);
        modal.modal('hide');
    });

    $('.ncmodal').on('click', function (event) {
        var button = $(this);
        var controller = button.attr('data-controller');
        var method = button.attr('data-method');
        var title = button.attr('data-title');
        var sv_func = button.attr('data-save');

        var modal = $('.targetModal');
        modal.removeData('bs.modal');

        modal.find('.modal-title').text(title);
        modal.find('.modal-body').css("overflow-y", "scroll");
        modal.find('.modal-body').css("padding-top", "0");
        modal.find('.modal-footer #modsavebut').attr("data-save", sv_func);

        $.ajax({
            url: maindir + controller + '/' + method,
            success: function (data) {
                modal.find('.modal-body').html(data);
                modal.modal('show');
                var h = document.documentElement.clientHeight * 0.7;
                modal.find('.modal-body').height(h)
            }
        });
    })

    $('.docgrid tbody').on('click', '.remgridline', function () {
        var table = $(document).find('.docgrid').DataTable();
        table
                .row($(this).parents('tr'))
                .remove()
                .draw();
        dofttots();
    });

    $('.docgrid tbody').on('keyup change keypress', 'input', function () {
        dofttots();
    });

    $('.docgrid tbody').on('focusout', 'input', function () {
        var celltype = $(this).attr("type");
        if (celltype.toLowerCase() == "number") {
            var cellval = $(this).val();
            $(this).val(f2n(cellval))
        }
    });

    callBoCl();
    newBoCl();
    orderSave();
});

function isNumeric(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}

function callBoCl() {
    if ($(".callBoCl").length) {
        $(document).on('click', '.callBoCl', function (e) {
            $("#nome").attr("disabled", true);
            $("#ncont").attr("disabled", true);
            $("#morada").attr("disabled", true);
            $("#local").attr("disabled", true);
            $("#codpost").attr("disabled", true);
            $("#nome").val("");
            $("#ncont").val("");
            $("#morada").val("");
            $("#local").val("");
            $("#codpost").val("");
            $("#no").val("");
            $("#email").val("");
            $("#telefone").val("");
        });
    }
}

function newBoCl() {
    if ($(".newBoCl").length) {
        $(document).on('click', '.newBoCl', function (e) {
            $("#nome").attr("disabled", false);
            $("#ncont").attr("disabled", false);
            $("#morada").attr("disabled", false);
            $("#local").attr("disabled", false);
            $("#codpost").attr("disabled", false);
            $("#nome").val("");
            $("#ncont").val("");
            $("#morada").val("");
            $("#local").val("");
            $("#codpost").val("");
            $("#no").val("");
            $("#email").val("");
            $("#telefone").val("");
        });
    }
}

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

//funcao para formatar valor em 2cd e arrendondar
function f2n(val) {
    if (isNumeric(val)) {
        return parseFloat(Math.round(parseFloat(val) * 100) / 100).toFixed(2);
    } else {
        return parseFloat(0).toFixed(2);
    }
}

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

function fillcl() {
    var no = $('input[name=no]:checked', '.targetModal').val();
    var no = (no == null ? '' : no);

    $.ajax({
        url: maindir + 'ajax/cliente',
        method: "POST",
        data: {"no": no},
        success: function (data) {
            data = JSON.parse(data);
            if (Object.keys(data).length) {
                $("#nome").val(data["nome"]);
                $("#ncont").val(data["ncont"]);
                $("#no").val(data["no"]);
                $("#estab").val(data["estab"]);
                $("#morada").val(data["morada"]);
                $("#local").val(data["local"]);
                $("#codpost").val(data["codpost"]);
                $("#telefone").val(data["telefone"]);
                $("#email").val(data["email"]);
            }
        }
    });
}

function dofttots() {
    var ettiliq = 0;
    var etotal = 0;
    var desctotal = 0;

    var table = $(document).find('.docgrid').DataTable();
    var curindex = 0;
    table.data().each(function (d) {
        var qtt = parseFloat(table.cell(curindex, 2).nodes().to$().find('input').val());
        var epv = parseFloat(table.cell(curindex, 3).nodes().to$().find('input').val());
        var desconto = parseFloat(table.cell(curindex, 5).nodes().to$().find('input').val());

        var tmpettiliq = qtt * epv;
        var tmpetotal = (desconto > 0) ? tmpettiliq * (1 - (desconto / 100)) : tmpettiliq;

        //calculo dos totais
        ettiliq += tmpettiliq;
        etotal += tmpetotal;
        desctotal += tmpettiliq - tmpetotal;

        //atualizar preco total iliquido na linha
        table.cell(curindex, 4).nodes().to$().html(f2n(tmpettiliq))
        //atualizar preco total liquido na linha
        table.cell(curindex, 6).nodes().to$().html(f2n(tmpetotal))

        curindex++;
    });

    $("#totaldesc").val("€" + f2n(desctotal));
    $("#totalliq").val("€" + f2n(ettiliq));
    $("#totaldocumento").val("€" + f2n(etotal));
}

function fillst() {
    var ref = $('input[name=ref]:checked', '.targetModal').val();
    var ref = (ref == null ? '' : ref);

    $.ajax({
        url: maindir + 'ajax/getartigo',
        method: "POST",
        data: {"ref": ref},
        success: function (data) {
            data = JSON.parse(data);

            if (Object.keys(data).length) {
                var table = $(document).find('.docgrid').DataTable();
                table.row.add([
                    data["ref"],
                    data["design"],
                    "<input class='form-control' type='number' value='1.00' />",
                    "<input class='form-control' type='number' value='" + f2n(data["epv1"]) + "' />",
                    f2n(data["epv1"]),
                    "<input class='form-control' type='number' value='0.00' />",
                    f2n(data["epv1"]),
                    "<a class='btn btn-primary remgridline'><i class='fa fa-times' aria-hidden='true'></i></a>"
                ]).draw();
            }
            dofttots();
        }
    });
}

function toggleLoading(status) {
    if (status == 1) {
        $('#status').css("display", "inline");
        $('#preloader').css("display", "inline");
    } else {
        $('#status').css("display", "none");
        $('#preloader').css("display", "none");
    }
}

function encode_utf8(s) {
    return unescape(encodeURIComponent(s));
}

function decode_utf8(s) {
    return decodeURIComponent(escape(s));
}

function boValidated() {
    var table = $(document).find('.docgrid').DataTable();
    var result = new Array(1,"");

    if( $("#no").val().toString().trim().length == 0) {
        result = new Array(0, "Tem que introduzir um cliente");
    }

    if( table.data().length == 0 ) {
        result = new Array(0, "Não pode criar um documento sem linhas");
    }
    return result;
}

function orderSave() {
    if ($(".saveOrder").length) {
        $(document).on('click', '.saveOrder', function () {
            if (boValidated()[0] == 1) {
                toggleLoading(1);

                var form = $('form');
                var disabled = form.find(':input:disabled').removeAttr('disabled');
                var serialized = form.serializeObject();
                disabled.attr('disabled', 'disabled');

                var bi = [];
                var table = $(document).find('.docgrid').DataTable();
                var curindex = 0;
                table.data().each(function (d) {
                    var ref = table.cell(curindex, 0).nodes().to$().html().toString().trim();
                    var design = table.cell(curindex, 1).nodes().to$().html().toString().trim();
                    var qtt = parseFloat(table.cell(curindex, 2).nodes().to$().find('input').val());
                    var epv = parseFloat(table.cell(curindex, 3).nodes().to$().find('input').val());
                    var desconto = parseFloat(table.cell(curindex, 5).nodes().to$().find('input').val());

                    var bitmp = {
                        "ref": Base64.encode(ref),
                        "design": Base64.encode(design),
                        "qtt": qtt,
                        "epv": epv,
                        "desconto": desconto
                    };

                    bi.push(bitmp);
                    curindex++;
                });

                serialized["bi"] = bi;
                serialized = encode_utf8(JSON.stringify(serialized));

                $.ajax({
                    url: maindir + 'ajax/saveOrder',
                    method: "POST",
                    data: {"data": Base64.encode(serialized)},
                    success: function (data) {
                        data = JSON.parse(data);
                        if (data["sucess"]) {
                            window.location.replace(maindir + "bo/add");
                        } else {
                            toggleLoading(0);
                            toastr.error(data["message"]);
                        }
                    }
                });
            } else {
                toastr.error(boValidated()[1]);
            }
        });
    }
}