<head>
    <title>NCIndustry</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="" />
    <link href="<?php echo base_url(); ?>css/bootstrap.css" rel='stylesheet' type='text/css' />
    <link href="<?php echo base_url(); ?>css/bootstrap.min.css" rel='stylesheet' type='text/css' />
    <link href="<?php echo base_url(); ?>css/font-awesome.css" rel="stylesheet"> 
    <link href="<?php echo base_url(); ?>css/custom.css" rel="stylesheet">
    <link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'>
    <link href="<?php echo base_url(); ?>css/animate.css" rel="stylesheet" type="text/css" media="all">
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/clndr.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/toastr.min.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/jquery.dataTables.min.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/buttons.dataTables.min.css" type="text/css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/animate.min.css">
    <link href="<?php echo base_url(); ?>css/style.css" rel='stylesheet' type='text/css' />

    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    <script src="<?php echo base_url(); ?>js/wow.min.js"></script>
    <script>
        new WOW().init();
        var base_url = '<?php echo base_url(); ?>';
    </script>
    <script src="<?php echo base_url(); ?>js/jquery-1.11.1.min.js"></script>
    <script src="<?php echo base_url(); ?>js/Chart.js"></script>
    <script src="<?php echo base_url(); ?>js/underscore-min.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>js/moment-2.2.1.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>js/metisMenu.min.js"></script>
    <script src="<?php echo base_url(); ?>js/custom.js"></script>
    <script src="<?php echo base_url(); ?>js/modernizr.custom.js"></script>
    <script src="<?php echo base_url(); ?>js/jquery.serializeToJSON.js"></script>
    <script src="<?php echo base_url(); ?>js/toastr.min.js"></script>
    <script src="<?php echo base_url(); ?>js/jquery.dataTables.min.js"></script>

    <script src="<?php echo base_url(); ?>js/dataTables.buttons.min.js"></script>
    <script src="<?php echo base_url(); ?>js/buttons.flash.min.js"></script>
    <script src="<?php echo base_url(); ?>js/jszip.min.js"></script>
    <script src="<?php echo base_url(); ?>js/pdfmake.min.js"></script>
    <script src="<?php echo base_url(); ?>js/vfs_fonts.js"></script>
    <script src="<?php echo base_url(); ?>js/buttons.html5.min.js"></script>
    <script src="<?php echo base_url(); ?>js/buttons.print.min.js"></script>
    <script src="<?php echo base_url(); ?>js/jquery.mask.min.js"></script>
    <script src="<?php echo base_url(); ?>js/bootbox.js"></script>

    <!--virtual numeric touch keypad-->

    <link rel="stylesheet" href="<?php echo base_url(); ?>css/jqbtk.min.css">
    <script src="<?php echo base_url(); ?>js/jqbtk.min.js"></script>
    <script src="<?php echo base_url(); ?>js/3.3.6/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>js/jqbtk.js"></script>
    <script src="<?php echo base_url(); ?>js/scripts.js"></script>


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
        
        //Função responsável por inserir um loading screen numa div específica
        //Os parâmetros da função insertBlocker funcionam da seguinte maneira:
        //O primeiro refere-se à String da div a selecionar
        //Os seguintes definem o tamanho e posicionamento do loader no ecrã
        //Sendo eles, respectivamente: width,height,left,top
        
        function insertBlocker(string,width,height,left,top){
            $(string).append('<div id="overlay" style="display:block"><svg style="position:absolute;width:'+width+'%;height:'+height+'%;text-align:center;left:'+left+'%;top:'+top+'%" aria-hidden="true" data-prefix="fas" data-icon="circle-notch" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-circle-notch fa-w-16 fa-spin fa-sm"><path fill="currentColor" d="M288 39.056v16.659c0 10.804 7.281 20.159 17.686 23.066C383.204 100.434 440 171.518 440 256c0 101.689-82.295 184-184 184-101.689 0-184-82.295-184-184 0-84.47 56.786-155.564 134.312-177.219C216.719 75.874 224 66.517 224 55.712V39.064c0-15.709-14.834-27.153-30.046-23.234C86.603 43.482 7.394 141.206 8.003 257.332c.72 137.052 111.477 246.956 248.531 246.667C393.255 503.711 504 392.788 504 256c0-115.633-79.14-212.779-186.211-240.236C302.678 11.889 288 23.456 288 39.056z" class=""></path></svg></div>');  
        }
        
    </script>

    <style>

        
        ::-webkit-scrollbar {
            display: none;
        }

        #overlay{
            position:absolute;
            width:100vw;
            height:100vh;
            background-color:#EFEFEF;
            position: fixed;
            width: 100%;
            height: 100%;
            z-index: 10000;
            top: 0px;
            left: 0px;
            opacity: .8;

        } 

    </style>

    <!-- Popup Cart produto  -->

    <script src<?php echo base_url(); ?>lib/jquery-1.7.1.min.js" type="text/javascript"></script><!-- carga jQuery -->
    <script type="text/javascript" src="<?php echo base_url(); ?>lib/jquery.mousewheel-3.0.6.pack.js"></script>

    <!-- Add fancyBox main JS and CSS files -->
    <script type="text/javascript" src="<?php echo base_url(); ?>source/jquery.fancybox.js?v=2.1.5"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>source/jquery.fancybox.css?v=2.1.5" media="screen" />

    <!-- Add Button helper (this is optional) -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>source/helpers/jquery.fancybox-buttons.css?v=1.0.5" />
    <script type="text/javascript" src="<?php echo base_url(); ?>source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>

    <!-- Add Thumbnail helper (this is optional) -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" />
    <script type="text/javascript" src="<?php echo base_url(); ?>source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>

    <!-- Add Media helper (this is optional) -->
    <script type="text/javascript" src="<?php echo base_url(); ?>source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>

</head> 