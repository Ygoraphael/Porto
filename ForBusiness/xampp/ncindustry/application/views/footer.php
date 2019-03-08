<script src="<?php echo base_url(); ?>js/classie.js"></script>
<script>
    var menuLeft = document.getElementById('cbp-spmenu-s1'),
            showLeftPush = document.getElementById('showLeftPush'),
            body = document.body;

    showLeftPush.onclick = function () {
        classie.toggle(this, 'active');
        classie.toggle(body, 'cbp-spmenu-push-toright');
        classie.toggle(menuLeft, 'cbp-spmenu-open');
        disableOther('showLeftPush');
    };

    function disableOther(button) {
        if (button !== 'showLeftPush') {
            classie.toggle(showLeftPush, 'disabled');
        }
    }

    $('.empty').on('keyup', function () {
        var input = $(this);
        if (input.val().length === 0) {
            input.addClass('empty');
        } else {
            input.removeClass('empty');
        }
    });

    var filterFloat = function (value) {
        if (/^(\-|\+)?([0-9]+(\.[0-9]+)?|Infinity)$/
                .test(value))
            return parseFloat(value).toFixed(2);
        return parseFloat("0").toFixed(2);
    }
    
    $(document).ready(function () {
        $('.decimal_input').on('focusout', function () {
            $(this).val( filterFloat($(this).val()) );
        })


        //$('.decimal_input').mask('#0.00', {reverse: true});
    });

</script>
<script src="<?php echo base_url(); ?>js/jquery.nicescroll.js"></script>
<script src="<?php echo base_url(); ?>js/scripts.js"></script>
<script src="<?php echo base_url(); ?>js/bootstrap.js"></script>