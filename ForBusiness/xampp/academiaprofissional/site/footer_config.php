
<script src="<?= JURI::base(); ?>includes/js/jquery.dataTables.min.js"></script>
<script src="<?= JURI::base(); ?>includes/js/dataTables.altEditor.free.js"></script>
<script src="<?= JURI::base(); ?>includes/js/dataTables.buttons.min.js"></script>
<script src="<?= JURI::base(); ?>includes/js/dataTables.select.min.js"></script>
<script src="<?= JURI::base(); ?>includes/js/dataTables.select.min.js"></script>
<script src="<?= JURI::base(); ?>includes/js/bootstrap-confirmation.min.js"></script>
<script src="<?= JURI::base(); ?>includes/js/pdfobject.min.js"></script>

<link rel="stylesheet" href="<?= JURI::base(); ?>includes/css/buttons.dataTables.min.css"/>
<link rel="stylesheet" href="<?= JURI::base(); ?>includes/css/select.dataTables.min.css"/>
<link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.6/slick.min.css"/>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.6/slick-theme.css"/>
<script type="text/javascript" src="<?= JURI::base(); ?>/site/js/slick.js"></script>

<style>
    .sidenav {
        height: 100%;
        width: 0;
        position: fixed;
        z-index: 1;
        top: 0;
        left: 0;
        background-color: #111;
        overflow-x: hidden;
        transition: 0.5s;
        padding-top: 60px;
    }

    .sidenav a {
        padding: 8px 8px 8px 32px;
        text-decoration: none;
        font-size: 25px;
        color: #818181;
        display: block;
        transition: 0.3s;
    }

    .sidenav a:hover {
        color: #f1f1f1;
    }

    .sidenav .closebtn {
        position: absolute;
        top: 0;
        right: 25px;
        font-size: 36px;
        margin-left: 50px;
    }

    @media screen and (max-height: 450px) {
        .sidenav {padding-top: 15px;}
        .sidenav a {font-size: 18px;}
    }

    .navbar ul.nav li {
        background: #f8f8f8;
        margin:0;
        border: 1px solid #bad7df;
    }
    
    .navbar ul.nav li.h1:hover {
        background: #e02226;
    }
    
    .navbar ul.nav li.h2:hover {
        background: #008fc0;
    }
    
    .navbar ul.nav li.h1:hover a {
        color:white !important;
    }
    
    .navbar ul.nav li.h2:hover a {
        color:white !important;
    }

    .nopadding {
        padding:0px !important;
    }

    .slick-prev,
    .slick-next{

        color: #cc262b !important;
        top:45% !important;
    }


    .slick-prev{

        left:-2px;

    }

    .slick-next{

        left:95%;

    }

    .slick-prev:before,
    .slick-next:before{

        color: #303030 !important;
        font-size: 40px;

    }

    #jm-bar{
        height: 120px !important;
    }

    .fb-like-BTN{

        position:relative !important;
        width:27px !important;
        top:57px !important;
        right:62% !important;
        float:right !important;
        left:auto !important;

    }

    .googlePlusBTN{
        position:relative !important;
        width:27px !important;
        top:60px !important;
        right:-35.5% !important;
        float:right !important;
        left:auto !important;
    }

    @media only screen and (max-device-width:320px){
        .googlePlusBTN{
            position:absolute !important;
            right:75px !important;
            top:48px !important;
        }
        .fb-like-BTN{
            position:absolute !important;
            right:67px !important;
            top:10px !important;
        }

        #jm-bar{

            height: 145px !important;

        }
        .footerItems{

            width:100% !important;
            text-align: center !important;
        }

        .jm-bottom-box-custom{

            text-align: center !important;
        }
    }


    @media only screen and (min-device-width:321px) and (max-device-width:360px){
        .googlePlusBTN{
            position:absolute !important;
            right:75px !important;
            top:48px !important;
        }
        .fb-like-BTN{
            position:absolute !important;
            right:67px !important;
            top:10px !important;
        }

        #jm-bar{

            height: 145px !important;

        }

        .footerItems{

            width:100% !important;
            text-align: center !important;
        }

        .jm-bottom-box-custom{

            text-align: center !important;
        }
    }

    @media only screen and (min-device-width: 361px) and (max-device-width:480px){

        .googlePlusBTN{
            position:absolute !important;
            right:74px !important;
            top:72px !important; 
        }
        .fb-like-BTN{
            position:absolute !important;
            right:160px !important;
            top:69px !important;
        }
        .footerItems{

            width:100% !important;
            text-align: center !important;
        }

        .jm-bottom-box-custom{

            text-align: center !important;
        }
    }

    /* different techniques for iPad screening */
    @media only screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait) {

        .googlePlusBTN{
            position:absolute !important;
            right:74px !important;
            top:72px !important; 
        }

        .fb-like-BTN{
            position:absolute !important;
            right:158px !important;
            top:69px !important;
        }

    }

    @media only screen and (min-device-width: 481px) and (max-device-width: 1025px) and (orientation:landscape) {

        .googlePlusBTN{
            position:absolute !important;
            right:76px !important;
            top:69px !important;
        }

        .fb-like-BTN{
            position:absolute !important;
            right:160px !important;
            top:69px !important;
        }

    }




    .labelTit {
        display:inline-block;
        width:300px;
        margin-bottom:10px;
    }
    .editmod {
        width: 1000px !important;
        margin-left: -500px !important;
    }
    .editmod .modal-dialog {
        width: 1000px !important;
    }
    .editmod .modal-content {
        width: 1000px !important;
    }
    .i900 {
        width:900px;
    }

    div.modal.fade.in {
        top: 20% !important;
    }

    table.dataTable tbody>tr.selected, table.dataTable tbody>tr>.selected, table.dataTable tbody>tr.selected>td {
        background-color: #A2D3F6 !important;
    }
    .dt-button {
        display: inline-block !important;
        margin-bottom: 15px !important;
        text-align: center !important;
        vertical-align: middle !important;
        cursor: pointer !important;
        line-height: 20px !important;
        text-decoration: none !important;
        border-radius: 0 !important;
        border: none !important;
        background: #cc262b !important;
        box-sizing: border-box !important;
        font-family: inherit !important;
        font-size: 14px !important;
        font-weight: 400 !important;
        padding: 15px 45px !important;
        height: auto !important;
        color: #fff !important;
    }

    .dt-button.disabled {
        display: inline-block !important;
        margin-bottom: 15px !important;
        text-align: center !important;
        vertical-align: middle !important;
        cursor: pointer !important;
        line-height: 20px !important;
        text-decoration: none !important;
        border-radius: 0 !important;
        border: none !important;
        background: #cc262b !important;
        box-sizing: border-box !important;
        font-family: inherit !important;
        font-size: 14px !important;
        font-weight: 400 !important;
        padding: 15px 45px !important;
        height: auto !important;

        color: #999 !important;
        border: 1px solid #d0d0d0 !important;
        cursor: default !important;
        background-color: #f9f9f9 !important;
        background-image: -webkit-linear-gradient(top, #fff 0%, #f9f9f9 100%) !important;
    }
    .btn-space {
        margin-right: 5px;
    }
    .table-responsive {
        width: 100%;
        margin-bottom: 15px;
        overflow-y: hidden;
        -ms-overflow-style: -ms-autohiding-scrollbar;
        border: 1px solid #ddd
    }
    .table-responsive>.table {
        margin-bottom: 0
    }
    .table-responsive>.table>tbody>tr>td,
    .table-responsive>.table>tbody>tr>th,
    .table-responsive>.table>tfoot>tr>td,
    .table-responsive>.table>tfoot>tr>th,
    .table-responsive>.table>thead>tr>td,
    .table-responsive>.table>thead>tr>th {
        white-space: nowrap
    }
    .table-responsive>.table-bordered {
        border: 0
    }
    .table-responsive>.table-bordered>tbody>tr>td:first-child,
    .table-responsive>.table-bordered>tbody>tr>th:first-child,
    .table-responsive>.table-bordered>tfoot>tr>td:first-child,
    .table-responsive>.table-bordered>tfoot>tr>th:first-child,
    .table-responsive>.table-bordered>thead>tr>td:first-child,
    .table-responsive>.table-bordered>thead>tr>th:first-child {
        border-left: 0
    }
    .table-responsive>.table-bordered>tbody>tr>td:last-child,
    .table-responsive>.table-bordered>tbody>tr>th:last-child,
    .table-responsive>.table-bordered>tfoot>tr>td:last-child,
    .table-responsive>.table-bordered>tfoot>tr>th:last-child,
    .table-responsive>.table-bordered>thead>tr>td:last-child,
    .table-responsive>.table-bordered>thead>tr>th:last-child {
        border-right: 0
    }
    .table-responsive>.table-bordered>tbody>tr:last-child>td,
    .table-responsive>.table-bordered>tbody>tr:last-child>th,
    .table-responsive>.table-bordered>tfoot>tr:last-child>td,
    .table-responsive>.table-bordered>tfoot>tr:last-child>th {
        border-bottom: 0
    }
    .col-lg-1,
    .col-lg-10,
    .col-lg-11,
    .col-lg-12,
    .col-lg-2,
    .col-lg-3,
    .col-lg-4,
    .col-lg-5,
    .col-lg-6,
    .col-lg-7,
    .col-lg-8,
    .col-lg-9,
    .col-md-1,
    .col-md-10,
    .col-md-11,
    .col-md-12,
    .col-md-2,
    .col-md-3,
    .col-md-4,
    .col-md-5,
    .col-md-6,
    .col-md-7,
    .col-md-8,
    .col-md-9,
    .col-sm-1,
    .col-sm-10,
    .col-sm-11,
    .col-sm-12,
    .col-sm-2,
    .col-sm-3,
    .col-sm-4,
    .col-sm-5,
    .col-sm-6,
    .col-sm-7,
    .col-sm-8,
    .col-sm-9,
    .col-xs-1,
    .col-xs-10,
    .col-xs-11,
    .col-xs-12,
    .col-xs-2,
    .col-xs-3,
    .col-xs-4,
    .col-xs-5,
    .col-xs-6,
    .col-xs-7,
    .col-xs-8,
    .col-xs-9 {
        position: relative;
        min-height: 1px;
        padding-right: 15px;
        padding-left: 15px
    }
    .col-xs-1,
    .col-xs-10,
    .col-xs-11,
    .col-xs-12,
    .col-xs-2,
    .col-xs-3,
    .col-xs-4,
    .col-xs-5,
    .col-xs-6,
    .col-xs-7,
    .col-xs-8,
    .col-xs-9 {
        float: left
    }
    .col-xs-12 {
        width: 100%
    }
    .col-xs-11 {
        width: 91.66666667%
    }
    .col-xs-10 {
        width: 83.33333333%
    }
    .col-xs-9 {
        width: 75%
    }
    .col-xs-8 {
        width: 66.66666667%
    }
    .col-xs-7 {
        width: 58.33333333%
    }
    .col-xs-6 {
        width: 50%
    }
    .col-xs-5 {
        width: 41.66666667%
    }
    .col-xs-4 {
        width: 33.33333333%
    }
    .col-xs-3 {
        width: 25%
    }
    .col-xs-2 {
        width: 16.66666667%
    }
    .col-xs-1 {
        width: 8.33333333%
    }
    .col-xs-pull-12 {
        right: 100%
    }
    .col-xs-pull-11 {
        right: 91.66666667%
    }
    .col-xs-pull-10 {
        right: 83.33333333%
    }
    .col-xs-pull-9 {
        right: 75%
    }
    .col-xs-pull-8 {
        right: 66.66666667%
    }
    .col-xs-pull-7 {
        right: 58.33333333%
    }
    .col-xs-pull-6 {
        right: 50%
    }
    .col-xs-pull-5 {
        right: 41.66666667%
    }
    .col-xs-pull-4 {
        right: 33.33333333%
    }
    .col-xs-pull-3 {
        right: 25%
    }
    .col-xs-pull-2 {
        right: 16.66666667%
    }
    .col-xs-pull-1 {
        right: 8.33333333%
    }
    .col-xs-pull-0 {
        right: auto
    }
    .col-xs-push-12 {
        left: 100%
    }
    .col-xs-push-11 {
        left: 91.66666667%
    }
    .col-xs-push-10 {
        left: 83.33333333%
    }
    .col-xs-push-9 {
        left: 75%
    }
    .col-xs-push-8 {
        left: 66.66666667%
    }
    .col-xs-push-7 {
        left: 58.33333333%
    }
    .col-xs-push-6 {
        left: 50%
    }
    .col-xs-push-5 {
        left: 41.66666667%
    }
    .col-xs-push-4 {
        left: 33.33333333%
    }
    .col-xs-push-3 {
        left: 25%
    }
    .col-xs-push-2 {
        left: 16.66666667%
    }
    .col-xs-push-1 {
        left: 8.33333333%
    }
    .col-xs-push-0 {
        left: auto
    }
    .col-xs-offset-12 {
        margin-left: 100%
    }
    .col-xs-offset-11 {
        margin-left: 91.66666667%
    }
    .col-xs-offset-10 {
        margin-left: 83.33333333%
    }
    .col-xs-offset-9 {
        margin-left: 75%
    }
    .col-xs-offset-8 {
        margin-left: 66.66666667%
    }
    .col-xs-offset-7 {
        margin-left: 58.33333333%
    }
    .col-xs-offset-6 {
        margin-left: 50%
    }
    .col-xs-offset-5 {
        margin-left: 41.66666667%
    }
    .col-xs-offset-4 {
        margin-left: 33.33333333%
    }
    .col-xs-offset-3 {
        margin-left: 25%
    }
    .col-xs-offset-2 {
        margin-left: 16.66666667%
    }
    .col-xs-offset-1 {
        margin-left: 8.33333333%
    }
    .col-xs-offset-0 {
        margin-left: 0
    }
    @media (min-width: 768px) {
        .col-sm-1,
        .col-sm-10,
        .col-sm-11,
        .col-sm-12,
        .col-sm-2,
        .col-sm-3,
        .col-sm-4,
        .col-sm-5,
        .col-sm-6,
        .col-sm-7,
        .col-sm-8,
        .col-sm-9 {
            float: left
        }
        .col-sm-12 {
            width: 100%
        }
        .col-sm-11 {
            width: 91.66666667%
        }
        .col-sm-10 {
            width: 83.33333333%
        }
        .col-sm-9 {
            width: 75%
        }
        .col-sm-8 {
            width: 66.66666667%
        }
        .col-sm-7 {
            width: 58.33333333%
        }
        .col-sm-6 {
            width: 50%
        }
        .col-sm-5 {
            width: 41.66666667%
        }
        .col-sm-4 {
            width: 33.33333333%
        }
        .col-sm-3 {
            width: 25%
        }
        .col-sm-2 {
            width: 16.66666667%
        }
        .col-sm-1 {
            width: 8.33333333%
        }
        .col-sm-pull-12 {
            right: 100%
        }
        .col-sm-pull-11 {
            right: 91.66666667%
        }
        .col-sm-pull-10 {
            right: 83.33333333%
        }
        .col-sm-pull-9 {
            right: 75%
        }
        .col-sm-pull-8 {
            right: 66.66666667%
        }
        .col-sm-pull-7 {
            right: 58.33333333%
        }
        .col-sm-pull-6 {
            right: 50%
        }
        .col-sm-pull-5 {
            right: 41.66666667%
        }
        .col-sm-pull-4 {
            right: 33.33333333%
        }
        .col-sm-pull-3 {
            right: 25%
        }
        .col-sm-pull-2 {
            right: 16.66666667%
        }
        .col-sm-pull-1 {
            right: 8.33333333%
        }
        .col-sm-pull-0 {
            right: auto
        }
        .col-sm-push-12 {
            left: 100%
        }
        .col-sm-push-11 {
            left: 91.66666667%
        }
        .col-sm-push-10 {
            left: 83.33333333%
        }
        .col-sm-push-9 {
            left: 75%
        }
        .col-sm-push-8 {
            left: 66.66666667%
        }
        .col-sm-push-7 {
            left: 58.33333333%
        }
        .col-sm-push-6 {
            left: 50%
        }
        .col-sm-push-5 {
            left: 41.66666667%
        }
        .col-sm-push-4 {
            left: 33.33333333%
        }
        .col-sm-push-3 {
            left: 25%
        }
        .col-sm-push-2 {
            left: 16.66666667%
        }
        .col-sm-push-1 {
            left: 8.33333333%
        }
        .col-sm-push-0 {
            left: auto
        }
        .col-sm-offset-12 {
            margin-left: 100%
        }
        .col-sm-offset-11 {
            margin-left: 91.66666667%
        }
        .col-sm-offset-10 {
            margin-left: 83.33333333%
        }
        .col-sm-offset-9 {
            margin-left: 75%
        }
        .col-sm-offset-8 {
            margin-left: 66.66666667%
        }
        .col-sm-offset-7 {
            margin-left: 58.33333333%
        }
        .col-sm-offset-6 {
            margin-left: 50%
        }
        .col-sm-offset-5 {
            margin-left: 41.66666667%
        }
        .col-sm-offset-4 {
            margin-left: 33.33333333%
        }
        .col-sm-offset-3 {
            margin-left: 25%
        }
        .col-sm-offset-2 {
            margin-left: 16.66666667%
        }
        .col-sm-offset-1 {
            margin-left: 8.33333333%
        }
        .col-sm-offset-0 {
            margin-left: 0
        }
    }
    @media (min-width: 992px) {
        .col-md-1,
        .col-md-10,
        .col-md-11,
        .col-md-12,
        .col-md-2,
        .col-md-3,
        .col-md-4,
        .col-md-5,
        .col-md-6,
        .col-md-7,
        .col-md-8,
        .col-md-9 {
            float: left
        }
        .col-md-12 {
            width: 100%
        }
        .col-md-11 {
            width: 91.66666667%
        }
        .col-md-10 {
            width: 83.33333333%
        }
        .col-md-9 {
            width: 75%
        }
        .col-md-8 {
            width: 66.66666667%
        }
        .col-md-7 {
            width: 58.33333333%
        }
        .col-md-6 {
            width: 50%
        }
        .col-md-5 {
            width: 41.66666667%
        }
        .col-md-4 {
            width: 33.33333333%
        }
        .col-md-3 {
            width: 25%
        }
        .col-md-2 {
            width: 16.66666667%
        }
        .col-md-1 {
            width: 8.33333333%
        }
        .col-md-pull-12 {
            right: 100%
        }
        .col-md-pull-11 {
            right: 91.66666667%
        }
        .col-md-pull-10 {
            right: 83.33333333%
        }
        .col-md-pull-9 {
            right: 75%
        }
        .col-md-pull-8 {
            right: 66.66666667%
        }
        .col-md-pull-7 {
            right: 58.33333333%
        }
        .col-md-pull-6 {
            right: 50%
        }
        .col-md-pull-5 {
            right: 41.66666667%
        }
        .col-md-pull-4 {
            right: 33.33333333%
        }
        .col-md-pull-3 {
            right: 25%
        }
        .col-md-pull-2 {
            right: 16.66666667%
        }
        .col-md-pull-1 {
            right: 8.33333333%
        }
        .col-md-pull-0 {
            right: auto
        }
        .col-md-push-12 {
            left: 100%
        }
        .col-md-push-11 {
            left: 91.66666667%
        }
        .col-md-push-10 {
            left: 83.33333333%
        }
        .col-md-push-9 {
            left: 75%
        }
        .col-md-push-8 {
            left: 66.66666667%
        }
        .col-md-push-7 {
            left: 58.33333333%
        }
        .col-md-push-6 {
            left: 50%
        }
        .col-md-push-5 {
            left: 41.66666667%
        }
        .col-md-push-4 {
            left: 33.33333333%
        }
        .col-md-push-3 {
            left: 25%
        }
        .col-md-push-2 {
            left: 16.66666667%
        }
        .col-md-push-1 {
            left: 8.33333333%
        }
        .col-md-push-0 {
            left: auto
        }
        .col-md-offset-12 {
            margin-left: 100%
        }
        .col-md-offset-11 {
            margin-left: 91.66666667%
        }
        .col-md-offset-10 {
            margin-left: 83.33333333%
        }
        .col-md-offset-9 {
            margin-left: 75%
        }
        .col-md-offset-8 {
            margin-left: 66.66666667%
        }
        .col-md-offset-7 {
            margin-left: 58.33333333%
        }
        .col-md-offset-6 {
            margin-left: 50%
        }
        .col-md-offset-5 {
            margin-left: 41.66666667%
        }
        .col-md-offset-4 {
            margin-left: 33.33333333%
        }
        .col-md-offset-3 {
            margin-left: 25%
        }
        .col-md-offset-2 {
            margin-left: 16.66666667%
        }
        .col-md-offset-1 {
            margin-left: 8.33333333%
        }
        .col-md-offset-0 {
            margin-left: 0
        }
    }
    @media (min-width: 1200px) {
        .col-lg-1,
        .col-lg-10,
        .col-lg-11,
        .col-lg-12,
        .col-lg-2,
        .col-lg-3,
        .col-lg-4,
        .col-lg-5,
        .col-lg-6,
        .col-lg-7,
        .col-lg-8,
        .col-lg-9 {
            float: left
        }
        .col-lg-12 {
            width: 100%
        }
        .col-lg-11 {
            width: 91.66666667%
        }
        .col-lg-10 {
            width: 83.33333333%
        }
        .col-lg-9 {
            width: 75%
        }
        .col-lg-8 {
            width: 66.66666667%
        }
        .col-lg-7 {
            width: 58.33333333%
        }
        .col-lg-6 {
            width: 50%
        }
        .col-lg-5 {
            width: 41.66666667%
        }
        .col-lg-4 {
            width: 33.33333333%
        }
        .col-lg-3 {
            width: 25%
        }
        .col-lg-2 {
            width: 16.66666667%
        }
        .col-lg-1 {
            width: 8.33333333%
        }
        .col-lg-pull-12 {
            right: 100%
        }
        .col-lg-pull-11 {
            right: 91.66666667%
        }
        .col-lg-pull-10 {
            right: 83.33333333%
        }
        .col-lg-pull-9 {
            right: 75%
        }
        .col-lg-pull-8 {
            right: 66.66666667%
        }
        .col-lg-pull-7 {
            right: 58.33333333%
        }
        .col-lg-pull-6 {
            right: 50%
        }
        .col-lg-pull-5 {
            right: 41.66666667%
        }
        .col-lg-pull-4 {
            right: 33.33333333%
        }
        .col-lg-pull-3 {
            right: 25%
        }
        .col-lg-pull-2 {
            right: 16.66666667%
        }
        .col-lg-pull-1 {
            right: 8.33333333%
        }
        .col-lg-pull-0 {
            right: auto
        }
        .col-lg-push-12 {
            left: 100%
        }
        .col-lg-push-11 {
            left: 91.66666667%
        }
        .col-lg-push-10 {
            left: 83.33333333%
        }
        .col-lg-push-9 {
            left: 75%
        }
        .col-lg-push-8 {
            left: 66.66666667%
        }
        .col-lg-push-7 {
            left: 58.33333333%
        }
        .col-lg-push-6 {
            left: 50%
        }
        .col-lg-push-5 {
            left: 41.66666667%
        }
        .col-lg-push-4 {
            left: 33.33333333%
        }
        .col-lg-push-3 {
            left: 25%
        }
        .col-lg-push-2 {
            left: 16.66666667%
        }
        .col-lg-push-1 {
            left: 8.33333333%
        }
        .col-lg-push-0 {
            left: auto
        }
        .col-lg-offset-12 {
            margin-left: 100%
        }
        .col-lg-offset-11 {
            margin-left: 91.66666667%
        }
        .col-lg-offset-10 {
            margin-left: 83.33333333%
        }
        .col-lg-offset-9 {
            margin-left: 75%
        }
        .col-lg-offset-8 {
            margin-left: 66.66666667%
        }
        .col-lg-offset-7 {
            margin-left: 58.33333333%
        }
        .col-lg-offset-6 {
            margin-left: 50%
        }
        .col-lg-offset-5 {
            margin-left: 41.66666667%
        }
        .col-lg-offset-4 {
            margin-left: 33.33333333%
        }
        .col-lg-offset-3 {
            margin-left: 25%
        }
        .col-lg-offset-2 {
            margin-left: 16.66666667%
        }
        .col-lg-offset-1 {
            margin-left: 8.33333333%
        }
        .col-lg-offset-0 {
            margin-left: 0
        }
    }
    span.numberitems {
        background: #cc262b;
        border-radius: 0.8em;
        -moz-border-radius: 0.8em;
        -webkit-border-radius: 0.8em;
        color: #ffffff;
        display: inline-block;
        font-weight: bold;
        line-height: 1.6em;
        text-align: center;
        width: 1.6em;
    }
    .text-left {
        text-align: left !important;
    }
    .text-right {
        text-align: right !important;
    }
    .text-center {
        text-align: center !important;
    }
    .text-justify {
        text-align: justify !important;
    }
    .text-nowrap {
        white-space: nowrap !important;
    }
    .text-lowercase {
        text-transform: lowercase !important;
    }
    .text-uppercase {
        text-transform: uppercase !important;
    }
    .text-capitalize {
        text-transform: capitalize !important;
    }
    .text-muted {
        color: #777 !important;
    }
    .text-primary {
        color: #337ab7 !important;
    }
    .text-success {
        color: #3c763d !important;
    }
    .text-danger {
        color: #a94442 !important;
    }

    @media only screen and (max-width: 800px) {
        /* Force table to not be like tables anymore */
        .no-more-tables table, 
        .no-more-tables thead, 
        .no-more-tables tbody, 
        .no-more-tables th, 
        .no-more-tables td, 
        .no-more-tables tr { 
            display: block !important; 
        }

        /* Hide table headers (but not display: none;, for accessibility) */
        .no-more-tables thead tr { 
            position: absolute !important;
            top: -9999px !important;
            left: -9999px !important;
        }

        .no-more-tables tr { border-top: 1px solid #ccc !important; border-bottom: 1px solid #ccc !important; }

        .no-more-tables td { 
            /* Behave  like a "row" */
            border: none !important;
            border-bottom: 1px solid #eee !important; 
            position: relative !important;
            padding-left: 40% !important; 
            white-space: normal !important;
            text-align:left !important;
        }

        .no-more-tables td .btn{ 
            /* Behave  like a "row" */
            margin-left: -30%;
        }

        .no-more-tables td:before { 
            /* Now like a table header */
            position: absolute !important;
            /* Top/left values mimic padding */
            top: 1px !important;
            left: 6px !important;
            width: 45% !important; 
            padding-right: 10px !important; 
            white-space: nowrap !important;
            text-align:left !important;
            font-weight: bold !important;
        }

        /*
        Label the data
        */
        .no-more-tables td:before { content: attr(data-title) !important; }
    }
</style>
<script>
    jQuery(document).ready(function () {
        jQuery('#new_emp').click(function () {
            jQuery.post('<?= JURI::base(); ?>index.php/nova-empresa', function () {
            }).done(function () {
                window.location.reload();
            });
        });

        function editAcao() {
            jQuery('.btn-edit-acao').click(function () {
                var acao = jQuery(this).attr('id');
                jQuery.post('<?= JURI::base(); ?>site/edit-acao-adm.php', {acao: acao}, function (res) {
                    jQuery('#content-modal').html(res);
                }).done(function () {
                    // jQuery('#edit-curso-modal').modal('show');
                });
            })
        }
        ;

        function editCurso() {
            jQuery('.btn-edit-curso').click(function () {
                var curso = jQuery(this).attr('id');
                jQuery.post('<?= JURI::base(); ?>site/edit-curso-adm.php', {curso: curso}, function (res) {
                    jQuery('#content-modal').html(res);
                }).done(function () {
                    // jQuery('#edit-curso-modal').modal('show');
                });
            });
        }

        function saveCurso() {
            jQuery("#btn-save-curso").click(function () {
                var vdata = jQuery('#form-edit-curso').serialize();
                jQuery.ajax({
                    type: "POST",
                    cache: false,
                    url: '<?= JURI::base(); ?>index.php/update-curso',
                    data: vdata
                }).done(function (data) {
                    window.location.reload();
                }).fail(function (jqXHR, textStatus) {
                    console.log(jqXHR);
                });


                //jQuery.post('<?= JURI::base(); ?>index.php/update-curso', vdata, function () {
                //}).done(function () {
                //    window.location.reload();
                //});
            });
        }

        function editCursoModal() {
            jQuery("#edit-curso-modal").on('click', '.btn-delete-curso', function () {
                var curso = jQuery('.btn-delete-curso').attr('id');
                jQuery.post('<?= JURI::base(); ?>index.php/delete-curso', {CC: curso}, function () {
                }).done(function () {
                    window.location.reload();
                });
            });
        }

        function saveAcao() {
            jQuery("#btn-save-acao").click(function () {
                jQuery.post('<?= JURI::base(); ?>index.php/atualizar-acao', jQuery('#form-edit-acao').serialize(), function () {
                }).done(function () {
                    window.location.reload();
                });
            });
        }

        function editAcaoModal() {
            jQuery("#edit-acao-modal").on('click', '.btn-delete-acao', function () {
                var acao = jQuery('.btn-delete-acao').attr('id');
                jQuery.post('<?= JURI::base(); ?>index.php/apagar-acao', {acao: acao}, function () {
                }).done(function () {
                    window.location.reload();
                });
            });
        }

        function removeCurso() {
            jQuery('.btn_remove_curso').click(function (e) {
                e.preventDefault();
                jQuery.post('<?= JURI::base(); ?>index.php/remove-curso', {curso: jQuery('.btn_remove_curso').attr('id')}, function () {
                }).done(function () {
                    jQuery(this).parent().parent().fadeOut();
                    window.location.reload();
                });
            });
        }

        function CallAllCalback() {
            editAcao();
            editCurso();
            saveCurso();
            editCursoModal();
            saveAcao();
            editAcaoModal();
            removeCurso();
        }

        CallAllCalback();

        if (jQuery(".initDt").length) {
            jQuery('.initDt').DataTable({"language":
                        {
                            "sProcessing": "A processar...",
                            "sLengthMenu": "Mostrar _MENU_",
                            "sZeroRecords": "Não foram encontrados resultados",
                            "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registos",
                            "sInfoEmpty": "Mostrando de 0 até 0 de 0 registos",
                            "sInfoFiltered": "(filtrado de _MAX_ registos no total)",
                            "sInfoPostFix": "",
                            "sSearch": " Procurar: ",
                            "sUrl": "",
                            "oPaginate": {
                                "sFirst": "Primeiro",
                                "sPrevious": "Anterior",
                                "sNext": "Seguinte",
                                "sLast": "Último"
                            }
                        },
                "drawCallback": function (settings) {
                    CallAllCalback();
                }

            });
        }
        if (jQuery("#contact-list").length) {
            jQuery('#contact-list').DataTable({
                "language":
                        {
                            "sProcessing": "A processar...",
                            "sLengthMenu": "Mostrar _MENU_",
                            "sZeroRecords": "Não foram encontrados resultados",
                            "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registos",
                            "sInfoEmpty": "Mostrando de 0 até 0 de 0 registos",
                            "sInfoFiltered": "(filtrado de _MAX_ registos no total)",
                            "sInfoPostFix": "",
                            "sSearch": " Procurar: ",
                            "sUrl": "",
                            "oPaginate": {
                                "sFirst": "Primeiro",
                                "sPrevious": "< Anterior |",
                                "sNext": "| Seguinte >",
                                "sLast": "Último"
                            }
                        },
                "filter": false,
                "drawCallback": function (settings) {
                    CallAllCalback();
                }
            });
        }

        if (jQuery(".dt").length) {
            jQuery('.dt').DataTable({
                dom: "frtip",
                "language":
                        {
                            "sProcessing": "A processar...",
                            "sLengthMenu": "Mostrar _MENU_",
                            "sZeroRecords": "Não foram encontrados resultados",
                            "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registos",
                            "sInfoEmpty": "Mostrando de 0 até 0 de 0 registos",
                            "sInfoFiltered": "(filtrado de _MAX_ registos no total)",
                            "sInfoPostFix": "",
                            "sSearch": " Procurar: ",
                            "sUrl": "",
                            "oPaginate": {
                                "sFirst": "Primeiro",
                                "sPrevious": "Anterior",
                                "sNext": "Seguinte",
                                "sLast": "Último"
                            }
                        },
                "drawCallback": function (settings) {
                    CallAllCalback();
                }
            });
        }

        if (jQuery(".dt2").length) {
            jQuery('.dt2').DataTable({
                dom: "frti",
                "language":
                        {
                            "sProcessing": "A processar...",
                            "sLengthMenu": "Mostrar _MENU_",
                            "sZeroRecords": "Não foram encontrados resultados",
                            "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registos",
                            "sInfoEmpty": "Mostrando de 0 até 0 de 0 registos",
                            "sInfoFiltered": "(filtrado de _MAX_ registos no total)",
                            "sInfoPostFix": "",
                            "sSearch": " Procurar: ",
                            "sUrl": "",
                            "oPaginate": {
                                "sFirst": "Primeiro",
                                "sPrevious": "Anterior",
                                "sNext": "Seguinte",
                                "sLast": "Último"
                            }
                        },
                paging: false,
                order: [[2, "asc"]],
                "drawCallback": function (settings) {
                    CallAllCalback();
                }
            });
        }

        //table sem search
        if (jQuery(".dt3").length) {
            jQuery('.dt3').DataTable({
                dom: "rti",
                "language":
                        {
                            "sProcessing": "A processar...",
                            "sLengthMenu": "Mostrar _MENU_",
                            "sZeroRecords": "Não foram encontrados resultados",
                            "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registos",
                            "sInfoEmpty": "Mostrando de 0 até 0 de 0 registos",
                            "sInfoFiltered": "(filtrado de _MAX_ registos no total)",
                            "sInfoPostFix": "",
                            "sSearch": " Procurar: ",
                            "sUrl": "",
                            "oPaginate": {
                                "sFirst": "Primeiro",
                                "sPrevious": "Anterior",
                                "sNext": "Seguinte",
                                "sLast": "Último"
                            }
                        },
                paging: false,
                order: [[2, "asc"]],
                "drawCallback": function (settings) {
                    CallAllCalback();
                }
            });
        }
        /*
         var toggleColor=false;
         var count=0;
         jQuery('.jm-module.color2-ms.margin-ms').each(function () {
         
         if(count==0){
         jQuery(this).removeClass("color2-ms");
         jQuery(this).addClass("color1-ms");
         
         }else{
         
         if(window.screen.width>765){
         if(!toggleColor){
         console.log("Azul Grande"); 
         jQuery(this).removeClass("color1-ms");
         jQuery(this).addClass("color2-ms");
         }else if(toggleColor){
         console.log("Vermelho Grande");
         jQuery(this).removeClass("color2-ms");
         jQuery(this).addClass("color1-ms");  
         }
         }else{
         if(!toggleColor){
         console.log("Vermelho Pequeno");
         jQuery(this).removeClass("color2-ms");
         jQuery(this).addClass("color1-ms");
         }else if(toggleColor){
         console.log("Azul Pequeno"); 
         jQuery(this).removeClass("color1-ms");
         jQuery(this).addClass("color2-ms");   
         }   
         }  
         }
         
         toggleColor=!toggleColor; 
         count++;
         });
         */
        jQuery('[data-toggle=confirmation]').confirmation({
            rootSelector: '[data-toggle=confirmation]',
            onConfirm: function () {
                var form = jQuery(this).attr('data-id');
                jQuery("#" + form + " input[name='exameclienteadp']").val('1');
                jQuery("#" + form).submit();
            },
            onCancel: function () {
                var form = jQuery(this).attr('data-id');
                jQuery("#" + form + " input[name='exameclienteadp']").val('0');
                jQuery("#" + form).submit();
            }
        });

        var w = jQuery(window).width();
        var h = jQuery(window).height();
        if (w <= 520) {
            jQuery('#dj-slideshow8m280').hide();
        }
        if (h <= 800) {
            jQuery("#dj-slideshow8m280").before(jQuery('#jm-main'));
        }

        var checkContents = setInterval(function () {
            if (jQuery("input#Escolaridade").length > 0) {
                var attr = jQuery("input#Escolaridade").attr('list');
                if (typeof attr !== typeof undefined && attr !== false) {
                } else {
                    var val = jQuery("input#Escolaridade").val();

                    jQuery("input#Escolaridade").replaceWith('<input type="text" id="Escolaridade" name="Escolaridade" value="' + val + '" class="form-control form-control-sm col-xs-10" list="escola">' +
                            '<datalist id="escola">' +
                            '<option value="4º Ano">' +
                            '<option value="6º Ano">' +
                            '<option value="Secundário">' +
                            '<option value="Bacharelado">' +
                            '<option value="Licenciatura">' +
                            '<option value="Mestrado">' +
                            '</datalist>' +
                            '</select>');
                }
            }
        }, 500);

        //Escolaridade

    });
</script>
<script>
    jQuery(document).ready(function () {
        jQuery(".modal-body").css("max-height", (jQuery(window).height() * 0.5) + "px");
    })
</script>
