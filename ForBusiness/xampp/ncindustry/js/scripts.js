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