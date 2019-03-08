var survey;

$(document).ready(function () {
    requestModal();
    saveRegister();
    modalShort();
    selectChange();
    deleteRegister();
    crateTools();
    editElement();
    editTextElement();
    removeElement();
    cancelSurvey();
    editNewSurvey();
    saveEditRegister();
    selectTo();
    selectCompany();
    selectCompany2();
    selectSector();
    selectCompanyFactory();
    defineGroupSurvey();
    SurveyInit();
    SurveyLoad();
    SurveySubmit();
    selectCompanyProfile();
    selectSector2();
    selectSector23();
    saveRegisterImage();
    MudaAno();
    saveDialogRules();
    SendInsecurity();
    SecurityDialogSubmit();
    SurveyLoadAnswer();
    SafetyWalkInit();
    SafetyWalkSubmit();
    dataStart();
    dataEnd();
    dataLimiteStart();
    dataAnsweredStart();
    dataLimiteEnd();
    dataAnsweredEnd();
    MonitorFilterSubmit();
    alertt();
    SurveyView();
    EditSurvey();
    ESurvery();
    ReturnedInsecurity();
    ResolvedInsecurity();
    CancelInsegurity();
    SaveEditSafetyWalk();
    DisabledInsecurity();
    translater();
    exporttables();
    scrollNav();
    askDemo();
    indexFileDownload();
    $(".btn-survey-remove").each(function () {
        $(this).remove();
    });
});

function indexFileDownload() {
    $("#indexFileDownloadForm").validate({
        rules: {
            InputNome: {
                required: true
            },
            InputEmail: {
                required: true,
                email: true
            }
        },
        submitHandler: function (form)
        {
            if ($('input#urlDownload').val().length == 0)
            {
                var Fileform = $('#indexFileDownloadForm');
                var controller = "Index";
                var method = "sendFormDownloadEmail";
                var action = '/' + controller + '/' + method;
                var data = $(this).attr('data-id');
                $.post(action, Fileform.serialize());
                switch ($('#fileType').val().toString()) {
                    case '1':
                        var link = "/assets/files/charlas_de_seguridad.pdf";
                        $("#ficheiro").html("<h2>Download efectuado..</h2> Se o download não começar automaticamente, <a href='" + link + "'> clique aqui.</a>");
                        $("#collapseDownload").collapse();
                        window.location = link;
                        break;
                    case '2':
                        var link = "/assets/files/observaciones_de_seguridad.pdf";
                        $("#ficheiro").html("<h2>Download efectuado..</h2> Se o download não começar automaticamente, <a href='" + link + "'> clique aqui.</a>");
                        $("#collapseDownload").collapse();
                        window.location = link;
                        break;
                    case '3':
                        var link = "/assets/files/charlas_de_seguridad.pdf";
                        $("#ficheiro").html("<h2>Download efectuado..</h2> Si la descarga no se inicia automáticamente, <a href='" + link + "'> haga clic aquí.</a>");
                        $("#collapseDownload").collapse();
                        window.location = link;
                        break;
                    case '4':
                        var link = "/assets/files/observaciones_de_seguridad.pdf";
                        $("#ficheiro").html("<h2>Download efectuado..</h2> Si la descarga no se inicia automáticamente, <a href='" + link + "'> haga clic aquí.</a>");
                        $("#collapseDownload").collapse();
                        window.location = link;
                        break;
                }
            }
        }
    });
    $('#indexFileDownloadForm').valid();
}

function askDemo() {
    $("#demoForm").validate(
            {
                submitHandler: function (form)
                {
                    if ($('input#url').val().length == 0)
                    {
                        $('form#demoForm').attr('action', 'demo');
                        form.submit();
                    }
                }
            });
}

function scrollNav() {
    $('.scr').click(function () {
        //Animate
        $('html, body').stop().animate({
            scrollTop: $($(this).attr('data-goto')).offset().top - 160
        }, 400);
        return false;
    });
}

function translater(data) {
    if (!data) {
    } else {
        return $.ajax({
            type: 'POST',
            url: "/translate/translate_script",
            data: {'string': data},
            dataType: 'json',
        });
    }
}

function requestTypeGroup() {
    $.post('/survey/group', function (response) {
        $('#modal_main').html(response);
    }).done(function () {
        $('#modal_main').modal('show');
    });
}
function requestModal() {
    $('.btn_modal').click(function () {
        var controller = $(this).attr('data-controller');
        var method = $(this).attr('data-method');
        var action = '/' + controller + '/' + method;
        var data = $(this).attr('data-id');
        $.post(action, {data: data}, function (response) {
            $('#modal_main').html(response);
        }).done(function () {
            $('#modal_main').modal('show');
        });
    });
}
function saveRegister() {
    $(document).on('click', '.btn_save', function () {
        var btn = $(this);
        var form = $(this).closest('form');
        var action = '/' + form.attr('name') + '/save';
        $('form').submit(function (e) {
            btn.addClass('disabled');
            e.preventDefault();
            $.post(action, form.serialize(), function (response) {
                btn.addClass('disabled');
            }, 'json').done(function (response) {
                window.location.reload();
            });
        });

    });
}
function saveRegisterImage() {
    $(document).on('click', '.btn_save_img', function () {
        var btn = $(this);
        var form = $(this).closest('form');
        var action = '/' + form.attr('name') + '/save';
        $('form').submit(function (e) {
            btn.addClass('disabled');
            e.preventDefault();
            $.post(action, form.serialize(), function (response) {
                btn.addClass('disabled');
            }, 'json').done(function (response) {
                window.location.reload();
                btn.removeClass('disabled');
            });
        });

    });
}

function saveEditRegister() {
    $(document).on('click', '.btn_save_edit', function () {
        var btn = $(this);
        var form = $(this).closest('form');
        var action = '/' + form.attr('name') + '/saveedit';
        $('form').submit(function (e) {
            btn.addClass('disabled');
            e.preventDefault();
            $.post(action, form.serialize(), function (response) {
                btn.addClass('disabled');
            }, 'json').done(function (response) {
                window.location.reload();
                btn.removeClass('disabled');
            });
        });

    });
}
function SendInsecurity() {
    $(document).on('click', '.btn-sendInsecurity', function () {
        var btn = $(this);
        var form = $(this).closest('form');
        var action = '/' + form.attr('name') + '/saveInsecurity';
        $('form').submit(function (e) {
            btn.addClass('disabled');
            e.preventDefault();
            $.post(action, form.serialize(), function (response) {
                btn.addClass('disabled');
            }, 'json').done(function (response) {
                window.location.reload();
                btn.removeClass('disabled');
            });
        });

    });
}

function ReturnedInsecurity() {
    $(document).on('click', '.btn-refund', function (e) {
        e.preventDefault();
        $(this).addClass('disabled');
        $.post('/Insecurity/RefundInsecurity', {id: $('#id').val(), id2: $('#id2').val(), comment: $('#comment4').val(), comment2: $('#comment2').val()}, function () {
        }, 'json').done(function (response) {
            if (response['type'] === 1) {
                window.location.href = '/panel/insecuritys';
            } else {
                // alert(response);
            }
        });
    });
}

function SaveEditSafetyWalk() {
    $(document).on('click', '.btn_saveedit_sw', function (e) {
        e.preventDefault();
        $(this).addClass('disabled');
        $.post('/SafetyWalk/saveEdit_sw_resp', {id: $('#id').val(), qtt: $('#qtt').val()}, function () {
        }, 'json').done(function (response) {
            if (response['type'] === 1) {
                window.location.href = '/panel/safetywalks';
            } else {
                // alert(response);
            }
        });
    });
}

function CancelInsegurity() {
    $(document).on('click', '.CancelInsegurity', function (e) {
        e.preventDefault();
        $(this).addClass('disabled');
        window.location.href = '/panel/insecuritys';
    });
}

function ResolvedInsecurity() {
    $(document).on('click', '.btn-resolved', function (e) {
        e.preventDefault();
        $(this).addClass('disabled');
        $.post('/Insecurity/SaveResolved', {id: $('#id').val(), id2: $('#id2').val(), comment: $('#comment4').val(), comment2: $('#comment2').val()}, function () {
        }, 'json').done(function (response) {
            if (response['type'] === 1) {
                window.location.href = '/panel/insecuritys';
            } else {
                // alert(response);
            }
        });
    });
}


function modalShort() {
    $(document).on('click', '.btn_insert_short', function () {
        var btn = $(this);
        var id = btn.attr('data-controller') + btn.attr('data-method');
        var action = '/' + btn.attr('data-controller') + '/' + btn.attr('data-method');
        var $id = '#' + id;
        $('<div>', {
            id: id,
            class: 'modal fade text-xs-left',
            tabindex: -1,
            role: 'dialog',
            'aria-labelledby': 'myModalLabel4',
            'aria-hidden': 'true'
        }).appendTo('body');
        $.post(action, function (response) {
            $($id).html(response);
        });
        $($id).modal('show');
    });
}
function selectChange() {
    $(document).on('change', '.select_change', function () {
        var select = $(this);
        var id = select.attr('data-controller') + '_' + select.attr('data-method') + '_' + select.attr('data-id');
        var action = '/' + select.attr('data-controller') + '/' + select.attr('data-method');
        var $id = $('#' + id);
        if ($(this).hasClass('combox')) {
            var receiver = '#' + select.attr('data-controller') + '_combox';
            var actionbox = '/' + $(receiver).attr('data-controller') + '/' + $(receiver).attr('data-ext');
            listingCombox(actionbox, $(this).val(), receiver);
        }
        $.post(action, {data: $(this).val()}, function () {
        }).done(function (response) {
            $id.fadeIn('slow');
            $id.html(response);
        });
    }
    );
}
function deleteRegister() {
    $(document).on('click', '.btn_delete', function () {
        var btn = $(this);

        var msj2 = translater('Are you sure you want to delete the registration');
        var msj_cancel = translater('cancel');
        var msj_delete = translater('delete');

        msj2.success(function (res1) {
            var msj = res1;
            var name = btn.parent().parent().find('.name').text();
            var id = btn.attr('data-id');
            var action = '/' + btn.attr('data-controller') + '/delete';

            msj_cancel.success(function (res1) {
                var msg_cancel = res1;
                msj_delete.success(function (res1) {
                    var msg_delete = res1;

                    bootbox.confirm({
                        message: msj,
                        buttons: {
                            confirm: {
                                label: msg_delete,
                                className: 'btn-success ',
                            },
                            cancel: {
                                label: msg_cancel,
                                className: 'btn-danger',
                            }
                        },

                        callback: function (result) {
                            if (result) {
                                $.post(action, {id: id}, function () {
                                }).done(function (response) {
                                    window.location.reload();
                                });
                            }
                        }
                    });
                });
            });
        });
    });

}
function listingCombox(action, value, receiver) {
    $.post(action, {data: value}, function () {
    }).done(function (response) {
        $(receiver).html(response);
    });
}
function crateTools() {
    var status_element;
    var element;
    $("#ul-tools li").draggable({
        helper: "clone",
        revert: "invalid",
        drag: function () {
            element = $(this).attr('id');
            status_element = true;
        },
        stop: function () {
            createElement(element);
        }
    });
    $("ul, li").disableSelection();
}
function editElement() {
    $(function () {
        $("#createInquiry .panel").sortable({
            revert: true
        });
        $("ul, li").disableSelection();
        getInputs();
    });

}
function createElement(element) {
    var countElements = $('#createInquiry .panel .edit').length;
    $("#createInquiry h4").remove();
    $("#btns").html('<button type="button" class="btn btn-warning pull-left" id="btn-survey-cancel"><i class="icon-cross2"></i> Cancel</button>'
            + '<button type="submit" id="save-survey" class="btn btn-primary pull-right"><i class="icon-check2"></i> Save</button>');

    if (element === 'title') {
        $("#createInquiry .panel").append('<div class="edit">'

                + ' <button type="button" class="btn btn-small btn-survey-remove"><i class="icon-minus4"></i></button>'

                + '<h5 class="form-section survey-text" id="' + countElements + '"> Title</h5><br></div>');
    }
    if (element === 'radio') {
        requestTypeGroup();

    }
    if (element === 'checkboox') {
        $("#createInquiry .panel").append('<div class="edit">'
                + '<div class="form-group">'
                + ' <button type="button" class="btn btn-small btn-survey-remove"><i class="icon-minus4"></i></button>'
                + '<div class="checkbox">'
                + '<label>'
                + '<input type="checkbox" name="' + countElements + '"> <span class="survey-text">Check me out</span></label>'
                + '</div>'
                + '</div>'
                + '</div>');
    }
    if (element === 'input-text') {
        $("#createInquiry .panel").append('<div class="edit">'
                + '<div class="form-body">'
                + '<div class="form-group">'
                + ' <button type="button" class="btn btn-small btn-survey-remove"><i class="icon-minus4"></i></button>'
                + '<label for="eventRegInput1" class="survey-text">Field </label>'
                + '<input type="text" id="eventRegInput1" class="form-control" placeholder="Field Input" name="' + countElements + '">'
                + '</div>'
                + '</div>'
                + '</div>');
    }
    getInputs();

}
function defineGroupSurvey() {
    $(document).on('change', '#survey_group', function () {
        var countElements = $('#createInquiry .panel .edit').length;
        $("#createInquiry .panel").append('<div class="edit"><div class="form-group">'
                + '<button type="button" class="btn btn-small btn-survey-remove"><i class="icon-minus4"></i></button>'
                + '<label class="survey-text">Radio Group</label>'
                + '<div class="input-group">'
                + '<label class="display-inline-block custom-control custom-radio ml-1">'
                + '<input type="radio" name="' + countElements + '" value="1" class="custom-control-input">'
                + '<input type="hidden" name="group[' + countElements + ']" value="' + $(this).val() + '" class="group_survey">'
                + '<span class="custom-control-indicator"></span>'
                + '<span class="custom-control-description ml-0 survey-text">Yes</span>'
                + '</label>'
                + '<label class="display-inline-block custom-control custom-radio">'
                + '<input type="radio" name="' + countElements + '" value="0" checked class="custom-control-input">'
                + '<span class="custom-control-indicator"></span>'
                + '<span class="custom-control-description ml-0 survey-text">No</span>'
                + '</label>'
                + '</div>'
                + '</div>'
                + '</div>');
        $('#modal_main').modal('hide');
        getGroups();
        getInputs();
    });

}
function editTextElement() {
    $("#createInquiry").on("dblclick", ".survey-text", function () {
        var text = $(this).text();
        $(this).html('<input type="text" id="edit-input-survey" class="form-control" placeholder="Enter text" value="' + text + '" name="survey-edit">').focusout(function () {
            if ($("#edit-input-survey").val() != '') {
                $(this).text($("#edit-input-survey").val());
            } else {
                $(this).text(text);
            }
            getInputs();
        });

    });
}
function removeElement() {
    getInputs();
    $("#createInquiry").on("click", ".btn-survey-remove", function () {
        $(this).closest('.edit').remove();
        getContent($('.panel').html(), editNewSurvey);
    });
}
function cancelSurvey() {
    $('#createInquiry').on("click", '#btn-survey-cancel', function () {
        window.location.reload();
    });
}
function editNewSurvey() {
    getInputs();
    $('#createInquiry').on('click', '#save-survey', function () {
        var status = equalDate($('#date-expired').val(), $('#date-finish').val());

        if ($("#company").val() !== null && status === true) {
            $(this).addClass('disabled');
            var content = inputs_;
            var company = $("#company").select2("val");
            var group = groups_;
            $.post('/survey/save', {content: content, company: company, validate: $('#validate').val(), start: $('#date-expired').val(), finish: $('#date-finish').val(), group: group}, function () {
            }, 'json').done(function (response) {
                $(this).removeClass('disabled');
                if (response === 1) {
                    window.location.reload();
                } else {
                    // alert(response);
                }
            });
        } else if ($("#company").val() === null) {
            bootbox.alert({
                message: "Field Company is required!",
                size: 'small'
            });
        }
    });
}
function equalDate(start_, finish_) {
    var start = new Date(start_.split('/').reverse().join('/'));
    var finish = new Date(finish_.split('/').reverse().join('/'));
    var today = new Date();
    if (start > finish) {
        bootbox.alert({
            message: "End date must be greater than start date.",
            size: 'small'
        });
        return false;
    } else if (start < today) {
        bootbox.alert({
            message: "Start date must be higher than today's date.",
            size: 'small'
        });
        return false;
    } else {
        return true;
    }

}
function selectTo() {
    $(".js-example-basic-multiple").select2({
        placeholder: "Select your options"
    });
}
var inputs_;
function getInputs() {
    var inputs = [];
    $(".edit").each(function () {
        inputs.push($(this).html());
    });
    inputs_ = inputs;
}
var groups_;
function getGroups() {
    var groups = [];
    $('.group_survey').each(function () {
        groups.push($(this).val());
    });
    groups_ = groups;
}
function selectCompany() {
    $(document).on('change', '#user_type', function () {
        if ($(this).val() == 2 || $(this).val() == 3) {
            $.post('/company/listing', function () {
            }).done(function (response) {
                $('#company_listing_form_user').fadeIn('slow');
                $('#company_listing_form_user').html(response);
            });
        } else {
            $('#company_listing_form_user').html('');
        }
    });
}
function selectCompany() {
    $(document).on('change', '#user_type', function () {
        if ($(this).val() == 2 || $(this).val() == 3) {
            $.post('/company/listing', function () {
            }).done(function (response) {
                $('#company_listing_form_user').fadeIn('slow');
                $('#company_listing_form_user').html(response);
            });
        } else {
            $('#company_listing_form_user').html('');
            $('#factory_listing_form_user').html('');
            $('#profile_listing_form_user').html('');
        }
    });
}

function selectCompanyFactory() {
    $(document).on('change', '#company_combox', function () {
        if ($('#user_type').val() == 3) {
            $.post('/factory/listing', {data: $(this).val()}, function () {
            }).done(function (response) {
                $('#factory_listing_form_user').fadeIn('slow');
                $('#factory_listing_form_user').html(response);

            });
        } else {
            $('#factory_listing_form_user').html('');
        }
    });
}
function selectCompany2() {
    $(document).on('change', '#company_combox2', function () {
        if ($(this).val()) {
            $.post('/factory/listing', {data: $(this).val()}, function () {
            }).done(function (response) {
                $('#factory_listing_form_user2').fadeIn('slow');
                $('#factory_listing_form_user2').html(response);

            });
        } else {
            $('#factory_listing_form_user2').html('');
        }
    });
}
function selectSector() {
    $(document).on('change', '#factory_combox2', function () {
        if ($(this).val()) {
            var idCompany = ($('#company_input2').val());
            var idFactory = ($('#factory_combox2').val());

            $.post('/Sector/listing2', {'idCompany': idCompany, 'idFactory': idFactory}, function () {
            }).done(function (response) {
                $('#sector_listing_form_user').fadeIn('slow');
                $('#sector_listing_form_user').html(response);
            });
        } else {
            $('#sector_listing_form_user').html('');
        }
    });
}
function selectSector2() {
    $(document).on('change', '#factory_combox3', function () {
        if ($(this).val()) {
            var CompanyFactory = ($('#factory_combox3').val());
            $.post('/Sector/listing3', {'CompanyFactory': CompanyFactory}, function () {
            }).done(function (response) {
                $('#sector_listing_form_user2').fadeIn('slow');
                $('#sector_listing_form_user2').html(response);
            });
        } else {
            $('#sector_listing_form_user2').html('');
        }
    });
}
function selectSector23() {
    $(document).on('change', '#factory_combox4', function () {
        if ($(this).val()) {
            var CompanyFactory = ($('#factory_combox4').val());
            $.post('/Sector/listing3', {'CompanyFactory': CompanyFactory}, function () {
            }).done(function (response) {
                $('#sector_listing_form_user3').fadeIn('slow');
                $('#sector_listing_form_user3').html(response);
            });
        } else {
            $('#sector_listing_form_user3').html('');
        }
    });
}
function selectCompanyProfile() {
    $(document).on('change', '#company_combox', function () {
        if ($('#user_type').val() == 2 || $('#user_type').val() == 3) {
            var idcompany = ($('#company_combox').val());
            $.post('/Profile/listing', {data: idcompany}, function () {
            }).done(function (response) {
                $('#profile_listing_form_user').fadeIn('slow');
                $('#profile_listing_form_user').html(response);

            });
        } else {
            $('#profile_listing_form_user').html('');
        }
    });
}

function SurveyView() {
    if ($('#editorElement2').length) {
        var cats = Array();
        if (jQuery("#cats").val()) {
            cats = jQuery.parseJSON(decodeURIComponent(jQuery("#cats").val()));
        }
        Survey.defaultBootstrapCss.navigationButton = "btn btn-green";
        Survey.JsonObject.metaData.addProperty("matrix", {name: "Categoria", choices: cats});
        Survey.JsonObject.metaData.removeProperty("page", "visibleIf");
        SurveyEditor.editorLocalization.currentLocale = "pt";


        var editorOptions = {questionTypes: ["text", "checkbox", "radiogroup", "dropdown", "comment", "rating", "html", "panel"]};
        var editor = new SurveyEditor.SurveyEditor("editorElement2", editorOptions);
        editor.saveSurveyFunc = function () {
            // console.log(editor.text);
            if ($("#company").val() !== null) {
                $(this).addClass('disabled');
                var content = editor.text;
                var company = $("#company").select2("val");
                $.post('/survey/editsurvey', {content: content, company: company, start: $('#date-expired').val(), profile: $('#profile').val(), qtt: $('#qtt').val(), type: $('#type').val(), id: $('#id').val(), disabled: $('#disabled').val()}, function () {
                    // console.log(group);
                }, 'json').done(function (response) {
                    $(this).removeClass('disabled');
                    if (response['type'] === 1) {
                        window.location.reload();
                    } else {
                        // alert(response);
                    }
                });
            } else if ($("#company").val() === null) {
                bootbox.alert({
                    message: "Field Company is required!",
                    size: 'small'
                });
            }
        }

        editor.onCanShowProperty.add(function (sender, options) {
            if (options.obj.getType() == "text") {
                if (['commentText', 'enableIf', 'indent', 'requiredErrorText', 'size', 'startWithNewLine', 'validators', 'visibleIf', 'width'].indexOf(options.property.name) >= 0) {
                    options.canShow = false;
                }
            } else if (options.obj.getType() == "checkbox") {
                if (['choicesByUrl', 'choicesOrder', 'colCount', 'commentText', 'enableIf', 'hasComment', 'hasOther', 'indent', 'otherErrorText', 'otherText', 'readOnly', 'requiredErrorText', 'startWithNewLine', 'storeOthersAsComment', 'validators', 'visible', 'visibleIf', 'width'].indexOf(options.property.name) >= 0) {
                    options.canShow = false;
                }
            } else if (options.obj.getType() == "radiogroup") {
                if (['choicesByUrl', 'choicesOrder', 'colCount', 'requiredErrorText', 'startWithNewLine', 'commentText', 'enableIf', 'hasComment', 'hasOther', 'indent', 'otherErrorText', 'otherText', 'readOnly', 'validators', 'storeOthersAsComment', 'visibleIf', 'visible', 'width'].indexOf(options.property.name) >= 0) {
                    options.canShow = false;
                }
            } else if (options.obj.getType() == "dropdown") {
                if (['choicesByUrl', 'choicesOrder', 'hasComment', 'commentText', 'enableIf', 'indent', 'hasOther', 'otherErrorText', 'otherText', 'readOnly', 'storeOthersAsComment', 'visibleIf', 'validators', 'requiredErrorText', 'startWithNewLine', 'visible', 'width', 'storeOthersAsComment'].indexOf(options.property.name) >= 0) {
                    options.canShow = false;
                }
            } else if (options.obj.getType() == "comment") {
                if (['choicesByUrl', 'choicesOrder', 'colCount', 'commentText', 'enableIf', 'hasComment', 'hasOther', 'indent', 'otherErrorText', 'otherText', 'readOnly', 'requiredErrorText', 'startWithNewLine', 'storeOthersAsComment', 'validators', 'visible', 'visibleIf', 'width'].indexOf(options.property.name) >= 0) {
                    options.canShow = false;
                }
            } else if (options.obj.getType() == "rating") {
                if (['maxRateDescription', 'minRateDescription', 'choicesByUrl', 'choicesOrder', 'colCount', 'commentText', 'enableIf', 'hasComment', 'hasOther', 'indent', 'otherErrorText', 'otherText', 'readOnly', 'requiredErrorText', 'startWithNewLine', 'storeOthersAsComment', 'validators', 'visible', 'visibleIf', 'width'].indexOf(options.property.name) >= 0) {
                    options.canShow = false;
                }
            } else if (options.obj.getType() == "html") {
                if (['commentText', 'enableIf', 'indent', 'requiredErrorText', 'size', 'startWithNewLine', 'validators', 'visibleIf', 'width'].indexOf(options.property.name) >= 0) {
                    options.canShow = false;
                }
            } else if (options.obj.getType() == "matrix") {
                if (['isAllRowRequired', 'choicesByUrl', 'choicesOrder', 'colCount', 'commentText', 'enableIf', 'hasComment', 'hasOther', 'indent', 'otherErrorText', 'otherText', 'readOnly', 'requiredErrorText', 'startWithNewLine', 'storeOthersAsComment', 'validators', 'visible', 'visibleIf', 'width'].indexOf(options.property.name) >= 0) {
                    options.canShow = false;
                }
            } else if (options.obj.getType() == "panel") {
                if (['visible', 'innerIndent'].indexOf(options.property.name) >= 0) {
                    options.canShow = false;
                }
            }
        });

        editor.toolbox.addItem({
            name: "matrix1",
            iconName: "icon-matrix",
            title: "Matriz",
            json: {"type": "matrix", "columns": [{value: "1", text: "Conforme"}, {value: "0", text: "Não Conforme"}], "rows": [{value: "1", text: "Linha 1"}, {value: "1", text: "Linha 2"}]}
        });

        if ($('#survey_content').length) {
            editor.text = decodeURIComponent(jQuery("#survey_content").val());
            jQuery("#qtt").val(jQuery("#survey_qtt").val());
            jQuery("#type").val(jQuery("#survey_type").val());
        }
    }
}

function ESurvery() {
    if ($('#surveyContainer').length) {
        $.getScript("/assets/js/surveyjs.js", function () {
            if ($('#survey_content').length) {
                Survey.Survey.cssType = "bootstrap";
                var surveyJSON = decodeURIComponent(jQuery("#survey_content").val());
                var myCss = {
                    row: "marginBottom25",
                    navigation: {
                        complete: "hidden"
                    }
                };
                survey = new Survey.Model(surveyJSON);
                $("#surveyContainer2").Survey({
                    model: survey, css: myCss
                });
                survey.locale = 'pt';
                survey.render();
            }
        });
    }
}

function EditSurvey() {
    $(document).on('click', '.EditSurvey', function (e) {
        e.preventDefault();
        $(this).addClass('disabled');
        $.post('/Survey/UpdateSurvey', {qtt: $('#qtt').val(), id: $('#id').val()}, function () {
        }, 'json').done(function (response) {
            if (response['type'] === 1) {
                $(this).removeClass('disabled');
                window.location.reload();
            } else {
                // alert(response);
            }
        });
    });
}

function SurveyInit() {
    if ($('#editorElement').length) {
        var cats = Array();
        if (jQuery("#cats").val()) {
            cats = jQuery.parseJSON(decodeURIComponent(jQuery("#cats").val()));
        }
        Survey.defaultBootstrapCss.navigationButton = "btn btn-green";
        Survey.JsonObject.metaData.addProperty("matrix", {name: "Categoria", choices: cats});
        Survey.JsonObject.metaData.removeProperty("page", "visibleIf");
        SurveyEditor.editorLocalization.currentLocale = "pt";

        var editorOptions = {questionTypes: ["text", "checkbox", "radiogroup", "dropdown", "comment", "rating", "html", "panel"]};
        var editor = new SurveyEditor.SurveyEditor("editorElement", editorOptions);
        editor.saveSurveyFunc = function () {
            // console.log(editor.text);
            if ($("#company").val() !== null) {
                $(this).addClass('disabled');
                var content = editor.text;
                var company = $("#company").select2("val");
                $.post('/survey/save', {content: content, company: company, start: $('#date-expired').val(), profile: $('#profile').val(), qtt: $('#qtt').val(), type: $('#type').val()}, function () {
                    // console.log(group);
                }, 'json').done(function (response) {
                    $(this).removeClass('disabled');
                    if (response['type'] === 1) {
                        window.location.reload();
                    } else {
                        // alert(response);
                    }
                });
            } else if ($("#company").val() === null) {
                bootbox.alert({
                    message: "O Campo Company é obrigatório!",
                    size: 'small'
                });
            }
        }

        editor.onCanShowProperty.add(function (sender, options) {
            if (options.obj.getType() == "text") {
                if (['commentText', 'enableIf', 'indent', 'requiredErrorText', 'size', 'startWithNewLine', 'validators', 'visibleIf', 'width'].indexOf(options.property.name) >= 0) {
                    options.canShow = false;
                }
            } else if (options.obj.getType() == "checkbox") {
                if (['choicesByUrl', 'choicesOrder', 'colCount', 'commentText', 'enableIf', 'hasComment', 'hasOther', 'indent', 'otherErrorText', 'otherText', 'readOnly', 'requiredErrorText', 'startWithNewLine', 'storeOthersAsComment', 'validators', 'visible', 'visibleIf', 'width'].indexOf(options.property.name) >= 0) {
                    options.canShow = false;
                }
            } else if (options.obj.getType() == "radiogroup") {
                if (['choicesByUrl', 'choicesOrder', 'colCount', 'requiredErrorText', 'startWithNewLine', 'commentText', 'enableIf', 'hasComment', 'hasOther', 'indent', 'otherErrorText', 'otherText', 'readOnly', 'validators', 'storeOthersAsComment', 'visibleIf', 'visible', 'width'].indexOf(options.property.name) >= 0) {
                    options.canShow = false;
                }
            } else if (options.obj.getType() == "dropdown") {
                if (['choicesByUrl', 'choicesOrder', 'hasComment', 'commentText', 'enableIf', 'indent', 'hasOther', 'otherErrorText', 'otherText', 'readOnly', 'storeOthersAsComment', 'visibleIf', 'validators', 'requiredErrorText', 'startWithNewLine', 'visible', 'width', 'storeOthersAsComment'].indexOf(options.property.name) >= 0) {
                    options.canShow = false;
                }
            } else if (options.obj.getType() == "comment") {
                if (['choicesByUrl', 'choicesOrder', 'colCount', 'commentText', 'enableIf', 'hasComment', 'hasOther', 'indent', 'otherErrorText', 'otherText', 'readOnly', 'requiredErrorText', 'startWithNewLine', 'storeOthersAsComment', 'validators', 'visible', 'visibleIf', 'width'].indexOf(options.property.name) >= 0) {
                    options.canShow = false;
                }
            } else if (options.obj.getType() == "rating") {
                if (['maxRateDescription', 'minRateDescription', 'choicesByUrl', 'choicesOrder', 'colCount', 'commentText', 'enableIf', 'hasComment', 'hasOther', 'indent', 'otherErrorText', 'otherText', 'readOnly', 'requiredErrorText', 'startWithNewLine', 'storeOthersAsComment', 'validators', 'visible', 'visibleIf', 'width'].indexOf(options.property.name) >= 0) {
                    options.canShow = false;
                }
            } else if (options.obj.getType() == "html") {
                if (['commentText', 'enableIf', 'indent', 'requiredErrorText', 'size', 'startWithNewLine', 'validators', 'visibleIf', 'width'].indexOf(options.property.name) >= 0) {
                    options.canShow = false;
                }
            } else if (options.obj.getType() == "matrix") {
                if (['isAllRowRequired', 'choicesByUrl', 'choicesOrder', 'colCount', 'commentText', 'enableIf', 'hasComment', 'hasOther', 'indent', 'otherErrorText', 'otherText', 'readOnly', 'requiredErrorText', 'startWithNewLine', 'storeOthersAsComment', 'validators', 'visible', 'visibleIf', 'width'].indexOf(options.property.name) >= 0) {
                    options.canShow = false;
                }
            } else if (options.obj.getType() == "panel") {
                if (['visible', 'innerIndent'].indexOf(options.property.name) >= 0) {
                    options.canShow = false;
                }
            }
        });

        editor.toolbox.addItem({
            name: "matrix1",
            iconName: "icon-matrix",
            title: "Matriz",
            json: {"type": "matrix", "columns": [{value: "1", text: "Conforme"}, {value: "0", text: "Não Conforme"}], "rows": [{value: "1", text: "Linha 1"}, {value: "1", text: "Linha 2"}]}
        });

        if ($('#survey_content').length) {
            editor.text = decodeURIComponent(jQuery("#survey_content").val());
            jQuery("#qtt").val(jQuery("#survey_qtt").val());
            jQuery("#type").val(jQuery("#survey_type").val());
        }
    }
}
function SurveySubmit() {
    $(document).on('click', '.surveySubmit', function (e) {
        e.preventDefault();

        var msj2 = translater("You must indicate survey's answer location");
        msj2.success(function (res1) {
            var msj = res1;
            if (jQuery("#sector").val()) {
                $.post('/surveyanswer/save', {content: encodeURIComponent(JSON.stringify(survey.data)), notification_id: jQuery("#id").val(), sector_id: jQuery("#sector").val()}, function () {
                }, 'json').done(function (response) {
                    $(this).removeClass('disabled');
                    if (response === 1) {
                        window.location.replace("/survey/surveystoanswer");
                    } else {
                    }
                });
            } else {
                bootbox.alert({
                    message: msj,
                    size: 'small'
                });
                return false;
            }
        });
    });
}
function SurveyLoad() {
    $.getScript("/assets/js/surveyjs.js", function () {
        if ($('#survey_content_answer').length) {
            Survey.Survey.cssType = "bootstrap";
            var surveyJSON = decodeURIComponent(jQuery("#survey_content_answer").val());
            var myCss = {
                row: "marginBottom25",
                navigation: {
                    complete: "hidden"
                }
            };
            survey = new Survey.Model(surveyJSON);
            $("#surveyContainer").Survey({
                model: survey, css: myCss
            });
            survey.locale = 'pt';
            survey.render();
        }
    });
}
function MudaAno() {
    $(document).on('click', '.muda_ano', function () {
        var controller = $(this).attr('data-controller');
        var method = $(this).attr('data-method');
        var arg = $(this).attr('data-id');
        arg = $("#" + arg).val();

        var action = '/' + controller + '/' + method + '/' + arg;
        window.location.replace(action);
    });
}
function readURL(input) {
    if (input.files && input.files[0]) {
        var file = input.files[0];
        var filename = file.name;
        var reader = new FileReader();
        reader.onload = function (e) {
            if ($('#blah').length) {
                $('#blah').attr('src', e.target.result);
            }
            if ($('#blah2').length) {
                $('#blah2').attr('src', e.target.result);
            }
        }
        reader.readAsDataURL(input.files[0]);
    }
}


function dataStart(s) {
    if (($('#date-start').val())) {
        var date = ($('#date-start').val());
        $('#date-end').attr('min', date);
    } else {
        $('#date-end').removeAttr('min');
    }
}
function dataEnd(e) {
    if (($('#date-end').val())) {
        var date = ($('#date-end').val());
        $('#date-start').attr('max', date);
    } else {
        $('#date-start').removeAttr('max');
    }
}

function dataLimiteStart(s2) {
    if (($('#date-start2').val())) {
        var date = ($('#date-start2').val());
        $('#date-end2').attr('min', date);
    } else {
        $('#date-end2').removeAttr('min');
    }
}

function dataLimiteEnd(e2) {
    if (($('#date-end2').val())) {
        var date = ($('#date-end2').val());
        $('#date-start2').attr('max', date);
    } else {
        $('#date-start2').removeAttr('max');
    }
}

function dataAnsweredStart(s3) {
    if (($('#date-start3').val())) {
        var date = ($('#date-start3').val());
        $('#date-end3').attr('min', date);
    } else {
        $('#date-end3').removeAttr('min');
    }
}

function dataAnsweredEnd(e3) {
    if (($('#date-end3').val())) {
        var date = ($('#date-end3').val());
        $('#date-start3').attr('max', date);
    } else {
        $('#date-start3').removeAttr('max');
    }
}

function saveDialogRules() {
    $(document).on('click', '.btn_rules', function (e) {
        e.preventDefault();
        btn = jQuery('.btn_rules');
        btn.addClass('disabled');
        var action = '/dialog/rulessave';
        var dialog_week = new Array();
        $(".week").each(function (index, element) {
            tmp = {id: jQuery(element).attr("data-id"), value: jQuery(element).val()};
            dialog_week.push(tmp);
        });
        waitingDialog.show('A gravar dados')
        $.post(action, {year: jQuery("#anoval").val(), securitydialogs: encodeURIComponent(JSON.stringify(dialog_week))}, function () {
        }, 'json').done(function (response) {
            if (response === 1) {
                window.location.reload();
            } else {
            }
        });
    });
}
function SecurityDialogSubmit() {
    $(document).on('click', '.securityDialogSubmit', function (e) {
        e.preventDefault();
        btn = jQuery('.securityDialogSubmit');
        btn.addClass('disabled');
        $.post('/securitydialoganswer/save', {notification_id: jQuery("#notification_id").val(), presencas: jQuery("#presencas").val()}, function () {
        }, 'json').done(function (response) {
            $(this).removeClass('disabled');
            if (response === 1) {
                window.location.replace("/panel/securitydialogs/");
            } else {
            }
        });
    })
}
function SurveyLoadAnswer() {
    $.getScript("/assets/js/surveyjs.js", function () {
        if ($('#survey_content_viewanswer').length) {
            Survey.Survey.cssType = "bootstrap";
            var surveyJSON = decodeURIComponent(jQuery("#survey_content_viewanswer").val());

            var myCss = {
                row: "marginBottom25",
                navigation: {
                    complete: "hidden"
                }
            };
            survey = new Survey.Model(surveyJSON);

            survey.data = JSON.parse(decodeURIComponent(jQuery("#survey_answercontent_viewanswer").val()));
            survey.mode = 'display';

            $("#surveyContainer").Survey({
                model: survey, css: myCss
            });
            survey.locale = 'pt';
            survey.render();
        }
    });
}
function SafetyWalkInit() {
    var counter = 0;


    $("#addrow_phone").on("click", function () {
        var newRow = $("<tr>");
        var cols = "";

        cols += '<td class="col-xs-7"><input type="text" class="form-control" name="text' + counter + '"/></td>';
        cols += '<td class="col-xs-2"><div class="pretty primary"><input type="checkbox" name="check' + counter + '" checked /><label><i class="mdi mdi-check"></i></label></div></td>';
        cols += '<td class="col-xs-2"><input type="button" class="ibtnDel btn btn-md btn-danger" value="X"></td>';
        newRow.append(cols);
        $("table.order-list").append(newRow);
        counter++;
    });


    $("#addrow").on("click", function () {
        var newRow = $("<tr>");
        var cols = "";

        cols += '<td class="col-xs-6"><input type="text" class="form-control" name="text' + counter + '"/></td>';
        cols += '<td class="col-xs-3"><div class="pretty primary"><input type="checkbox" name="check' + counter + '" checked /><label><i class="mdi mdi-check"></i></label></div></td>';
        cols += '<td class="col-xs-3"><input type="button" class="ibtnDel btn btn-md btn-danger" value="Apagar"></td>';
        newRow.append(cols);
        $("table.order-list").append(newRow);
        counter++;
    });

    $("table.order-list").on("click", ".ibtnDel", function (event) {
        $(this).closest("tr").remove();
        counter -= 1
    });

    $(document).on('click', '.btn_save_sw', function (e) {
        e.preventDefault();
        btn = jQuery('.btn_save_sw');
        btn.addClass('disabled');

        var company = $("#company").select2("val");
        var safetywalkquestions = new Array();
        $("#safetywalkquestions > tbody > tr").each(function (index, element) {
            if (jQuery(element).find("input").eq(1).is(':checked')) {
                cbox = 1;
            } else {
                cbox = 0;
            }
            safetywalkquestions.push({"text": jQuery(element).find("input").eq(0).val(), "checkbox": cbox, "ord": index})
        });

        if ($('#qtt').val() === '') {
            var msj2 = translater('You must enter Qtt');
            msj2.success(function (res1) {
                var msj = res1;
                bootbox.alert({
                    message: msj + "!",
                    size: 'small'
                });
                btn.removeClass('disabled');
                return false;
            });

        } else {
            if (safetywalkquestions.length) {
                $.post('/safetywalk/save', {content: encodeURIComponent(JSON.stringify(safetywalkquestions)), company: company, start: $('#date-expired').val(), profile: $('#profile').val(), qtt: $('#qtt').val(), type: $('#type').val()}, function () {
                }, 'json').done(function (response) {
                    $(this).removeClass('disabled');
                    if (response['type'] === 1) {
                        window.location.href = "/panel/safetywalks/";
                    } else {
                    }
                });
            } else {
                var msj2 = translater('No rows with data');
                msj2.success(function (res1) {
                    var msj = res1;
                    bootbox.alert({
                        message: msj + "!",
                        size: 'small'
                    });
                    btn.removeClass('disabled');
                    return false;
                });
            }
        }
    })

    $(document).on('click', '.btn_save_edit_sw', function (e) {
        e.preventDefault();
        btn = jQuery('.btn_save_sw');
        btn.addClass('disabled');

        var company = $("#company").select2("val");
        var safetywalkquestions = new Array();
        $("#safetywalkquestions > tbody > tr").each(function (index, element) {
            if (jQuery(element).find("input").eq(1).is(':checked')) {
                cbox = 1;
            } else {
                cbox = 0;
            }
            safetywalkquestions.push({"text": jQuery(element).find("input").eq(0).val(), "checkbox": cbox, "ord": index})
        });

        if ($('#qtt').val() === '') {
            var msj2 = translater('You must enter Qtt');
            msj2.success(function (res1) {
                var msj = res1;
                bootbox.alert({
                    message: msj + "!",
                    size: 'small'
                });
                btn.removeClass('disabled');
                return false;
            });

        } else {
            if (safetywalkquestions.length) {

                $.post('/safetywalk/saveEdit_sw', {content: encodeURIComponent(JSON.stringify(safetywalkquestions)), id: $('#id').val(), qtt: $('#qtt').val()}, function () {
                }, 'json').done(function (response) {
                    $(this).removeClass('disabled');
                    if (response['type'] === 1) {
                        window.location.href = "/panel/safetywalks/";
                    } else {
                    }
                });
            } else {
                var msj2 = translater('No rows with data');
                msj2.success(function (res1) {
                    var msj = res1;
                    bootbox.alert({
                        message: msj + "!",
                        size: 'small'
                    });
                    btn.removeClass('disabled');
                    return false;
                });
            }
        }
    })


}
function SafetyWalkSubmit() {
    $(document).on('click', '.safetyWalkSubmit', function (e) {
        e.preventDefault();
        var msj2 = translater('You must indicate the place of completion of the Safety Walk');
        msj2.success(function (res1) {
            var msj = res1;
            var safetywalkquestions = new Array();
            $(".question_check").each(function (index, element) {
                if (jQuery(element).is(':checked')) {
                    cbox = 1;
                } else {
                    cbox = 0;
                }
                safetywalkquestions.push({"id": jQuery(element).attr("data-id"), "checked": cbox})
            });

            if (jQuery("#sector").val()) {
                $.post('/safetywalkanswer/save', {questions: encodeURIComponent(JSON.stringify(safetywalkquestions)), notification_id: jQuery("#not_id").val(), sector_id: jQuery("#sector").val(), comment: jQuery("#tarobs").val(), userfollow: jQuery("#userfollow").val()}, function () {
                }, 'json').done(function (response) {
                    $(this).removeClass('disabled');
                    if (response === 1) {
                        window.location.replace("/safetywalk/swtoanswer");
                    } else {
                    }
                });
            } else {
                bootbox.alert({
                    message: msj,
                });
                return false;
            }
        });
    });
}

function MonitorFilterSubmit() {
    $(document).on('click', '.btn_filter_mon', function (e) {
        e.preventDefault();
        var btn = $(this);

        var action = '/panel';
        btn.addClass('disabled');

        window.location.href = '/panel/dash/' + $("form").serialize();

    });
}

function alertt() {
    window.setTimeout(function () {
        $(".alert").fadeTo(500, 0).slideUp(500, function () {
            $(this).remove();
        });
    }, 3000);
}

function DisabledInsecurity() {
    $(document).on('click', '.btn-Insecurity', function (e) {
        e.preventDefault();
        $(this).attr('disabled', 'disabled');
        $(this).parents('form').submit();
    });
}

function exporttables() {
    if ($('.exporttable').length) {
        $('.exporttable').DataTable({
            dom: 'B',
            buttons: [
                'csv', 'excel', 'pdf'
            ]
        });
    }
}