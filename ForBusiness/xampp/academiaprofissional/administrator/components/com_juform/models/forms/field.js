jQuery(document).ready(function ($) {
    document.formvalidator.setHandler('value',
        function (value) {
            var unique = getUniqueValues();
            if (jQuery.inArray(value, unique) > -1) {
                return false;
            }

            if (value.indexOf("|") > -1 || value.indexOf(",") > -1) {
                return false;
            }

            return true;
        });

    document.formvalidator.setHandler('fieldname',
        function (value) {
            regex = /^[\w]+$/i;
            return regex.test(value);
        });
});

jQuery(document).ready(function ($) {
    $('#jform_predefined_values_type').change(function () {
        if ($(this).val() == '1') {
            $('[name="jform[predefined_values]"], #jform_predefined_values').closest('li').show();
            $('[name="jform[php_predefined_values]"], #jform_php_predefined_values').closest('li').hide();
            $('[name="jform[predefined_values]"], #jform_predefined_values').closest('.control-group').show();
            $('[name="jform[php_predefined_values]"], #jform_php_predefined_values').closest('.control-group').hide();
        } else {
            $('[name="jform[predefined_values]"], #jform_predefined_values').closest('li').hide();
            $('[name="jform[php_predefined_values]"], #jform_php_predefined_values').closest('li').show();
            $('[name="jform[predefined_values]"], #jform_predefined_values').closest('.control-group').hide();
            $('[name="jform[php_predefined_values]"], #jform_php_predefined_values').closest('.control-group').show();
        }
    });

    $('#jform_predefined_values_type').trigger('change');
});