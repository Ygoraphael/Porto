jQuery(document).ready(function ($) {
    $(".toggle-check-all-row-view, .toggle-check-all-row-manage, .toggle-check-all-row-delete").click(function () {
        if ($(this).is(":checked")) {
            $(".group-permission").find("input[type='checkbox'][class~='" + $(this).attr("id") + "']").prop("checked", true);
        } else {
            $(".group-permission").find("input[type='checkbox'][class~='" + $(this).attr("id") + "']").prop("checked", false);
        }
    });
    $(".toggle-check-all-col-view, .toggle-check-all-col-manage, .toggle-check-all-col-delete").click(function () {
        if ($(this).hasClass("unchecked")) {
            $(".group-permission").find("input[type='checkbox'][class~='" + $(this).attr("id") + "']").prop("checked", true);
            $(this).removeClass("unchecked");
        } else {
            $(".group-permission").find("input[type='checkbox'][class~='" + $(this).attr("id") + "']").prop("checked", false);
            $(this).addClass("unchecked");
        }
    });

    Joomla.submitbutton = function (pressbutton) {
        if (pressbutton == "backendPermission.apply" || pressbutton == "backendPermission.save") {
            dataSave(pressbutton);
            return false;
        }
        Joomla.submitform(pressbutton);
    };

    function dataSave(pressbutton) {
        var permission = {};
        $('.group-permission').find("input[class*='permission']").each(function () {
            value = $(this).is(':checked') ? 1 : 0;
            name = $(this).attr('name');
            part = name.split('-');
            if (typeof permission[part[0]] != 'object') {
                permission[part[0]] = {}
            }
            if (typeof permission[part[0]][part[1]] != 'object') {
                permission[part[0]][part[1]] = {};
            }
            permission[part[0]][part[1]][part[2]] = value;

        });
        if (!$.isEmptyObject(permission)) {
            $.ajax({
                url: "index.php?option=com_juform&tmpl=component&task=" + pressbutton,
                type: 'POST',
                data: "permission=" + JSON.stringify(permission) + "&" + token + "=1",
                beforeSend: function (xhr) {
                }
            }).done(function (data) {
                if (pressbutton == "backendPermission.apply") {
                    window.location.reload(true);
                } else {
                    window.location.href = "index.php?option=com_juform&view=dashboard";
                }
            });
        }
    }
});