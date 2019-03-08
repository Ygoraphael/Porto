<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keywords" content="" />
    <title><?= $this->config->item('nc_name') ?></title>
    <link href="<?= base_url() ?>vendor/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="<?= base_url() ?>vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="<?= base_url() ?>vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
    <link href="<?= base_url() ?>css/sb-admin.css" rel="stylesheet">
    

    <link rel="stylesheet" href="<?= base_url() ?>css/custom.css" >
    <link rel="stylesheet" href="<?= base_url() ?>css/animate.css" type="text/css" media="all">
    <link rel="stylesheet" href="<?= base_url() ?>css/clndr.css" type="text/css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" type="text/css" />
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" type="text/css" />
    <link rel="stylesheet" href="//cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css" type="text/css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">
    <link rel='stylesheet' href="<?= base_url() ?>css/style.css" type='text/css' />
  
    <script src="<?= base_url() ?>js/jquery-1.11.1.min.js"></script>
    <script src="<?= base_url() ?>js/Chart.js"></script>
    <script src="<?= base_url() ?>js/underscore-min.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>js/moment-2.2.1.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>js/metisMenu.min.js"></script>
    <script src="<?= base_url() ?>js/custom.js"></script>
    <script src="<?= base_url() ?>js/modernizr.custom.js"></script>
    <script src="<?= base_url() ?>js/jquery.serializeToJSON.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.3.1/js/buttons.flash.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>
    <script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js"></script>
    <script src="//cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.3.1/js/buttons.print.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.js"></script>
    
    <link rel="stylesheet" href="<?= base_url() ?>css/jqbtk.min.css">
    <script src="<?= base_url() ?>js/jqbtk.min.js"></script>

    <script>
        toastr.options = {
            "positionClass": "toast-top-center",
            "preventDuplicates": true
        }

        function ModalAjax(url, title) {
            $.get(url, function (data) {
                $('#modalResponsive').find('.modal-body').html(data);
                $('#modalResponsive').find('.modal-title').html(title);
                $('#modalResponsive').modal('show');
            });
        }
    </script>

    <script src="<?= base_url() ?>lib/jquery-1.7.1.min.js" type="text/javascript"></script><!-- carga jQuery -->
    <script type="text/javascript" src="<?= base_url() ?>lib/jquery.mousewheel-3.0.6.pack.js"></script>

    <!-- Add fancyBox main JS and CSS files -->
    <script type="text/javascript" src="<?= base_url() ?>source/jquery.fancybox.js?v=2.1.5"></script>
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>source/jquery.fancybox.css?v=2.1.5" media="screen" />

    <!-- Add Button helper (this is optional) -->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>source/helpers/jquery.fancybox-buttons.css?v=1.0.5" />
    <script type="text/javascript" src="<?= base_url() ?>source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>

    <!-- Add Thumbnail helper (this is optional) -->
    <link rel="stylesheet" type="text/css" href="<?= base_url() ?>source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
    <script type="text/javascript" src="<?= base_url() ?>source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>

    <!-- Add Media helper (this is optional) -->
    <script type="text/javascript" src="<?= base_url() ?>source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>
</head> 