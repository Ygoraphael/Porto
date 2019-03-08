<script src="<?= base_url() ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Core plugin JavaScript-->
<script src="<?= base_url() ?>vendor/jquery-easing/jquery.easing.min.js"></script>
<!-- Page level plugin JavaScript-->
<script src="<?= base_url() ?>vendor/chart.js/Chart.min.js"></script>
<script src="<?= base_url() ?>vendor/datatables/jquery.dataTables.js"></script>
<script src="<?= base_url() ?>vendor/datatables/dataTables.bootstrap4.js"></script>
<!-- Custom scripts for all pages-->
<script src="<?= base_url() ?>js/sb-admin.min.js"></script>
<!-- Custom scripts for this page-->
<script src="<?= base_url() ?>js/sb-admin-datatables.min.js"></script>
<script src="<?= base_url() ?>js/sb-admin-charts.js"></script>
<script src="<?= base_url() ?>js/classie.js"></script>
<script>
    var maindir = '<?= base_url() ?>';
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
            $(this).val(filterFloat($(this).val()));
        })
        //$('.decimal_input').mask('#0.00', {reverse: true});
    });

    $(window).on('load', function () {
        $('#status').fadeOut(); // will first fade out the loading animation 
        $('#preloader').delay(350).fadeOut('slow'); // will fade out the white DIV that covers the website.
        $('body').delay(350).css({'overflow': 'visible'});
    });

</script>
<script src="<?= base_url() ?>js/jquery.nicescroll.js"></script>
<script src="<?= base_url() ?>js/scripts.js"></script>
<div class="modal targetModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="modsavebut">Gravar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>