<!doctype html>
<html>
   <head>
      <title>FULLWEAR | SHOP</title>
      <!-- Required meta tags -->
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <!-- custom CSS -->
      <link rel="stylesheet" href="css/customCSS.css">
      <link rel="stylesheet" href="css/animations.css">
      <!-- Bootstrap CSS & scripts -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
      <!-- font awesome -->
      <link rel="stylesheet" href="css/font-awesome.css" rel="stylesheet" type="text/css">
      <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css" media="all">
      <style>
         .rcorners1 {
         border-radius: 100%;
         background: #73AD21;
         width: 6px;
         height: 6px;
         margin:3px;
         }
         .rcorners2 {
         border-radius: 100%;
         background: red;
         width: 6px;
         height: 6px;
         margin:3px;
         }
         .cenas{
         font-size:8px;
         }
         body{
         margin: 0;
         padding: 0;
         -webkit-touch-callout: none; /* iOS Safari */
         -webkit-user-select: none; /* Safari */
         -   khtml-user-select: none; /* Konqueror HTML */
         -moz-user-select: none; /* Firefox */
         -ms-user-select: none; /* Internet Explorer/Edge */
         user-select: none; /* Non-prefixed version, currently
         supported by Chrome and Opera */
         }
         ul>li{
         padding-left: 15px;
         font-size: 12px;
         }

         .badge {
         -webkit-border-radius: 100%;
         -moz-border-radius: 100%;
         border-radius: 100%;
         }
         .cart-badge {
         font-family:Helvetica, sans-serif;
         font-weight: bold;
         font-size: 10px;
         color: black;
         padding: 5px 8px;
         margin-left:-8px;
         margin-top: -8px;
         vertical-align: top;
         }
         .card-header .collapsed .fa {
         transform: rotate(90deg);
         transition: .3s transform ease-in-out;
         }
         .card{
         border-style:none;
         border-radius:0;
         }
         .right-tab {
         background-color: black;
         position: fixed;
         right: -30px;
         top:-38px;
         -webkit-transform: rotate(-45deg);
         -moz-transform: rotate(-45deg);
         -o-transform: rotate(-45deg);
         -ms-transform: rotate(-45deg);
         transform: rotate(-s45deg);
         border: 1px solid grey;
         width: 5%;
         height:11%;
         z-index: 9999;
         padding: 27px 4px;
         bottom:0;
         font-size: 14px;
         }
         .right-tab:hover{
         background: grey;
         }
         .langBar{
         position:fixed;
         top:0px;
         width: 100%;
         height:50px;
         background-color:red;
         }
         .langBar{
         z-index: 998;
         }
         .navBorder{
         border-bottom: 1px solid red;
         }
         .colors{
         background:#343a40!important;
         }
         .linkColor{
         color:#ccc;
         }
         .linkColor:hover{
         color:white;
         text-decoration: none;
         }
         /* dropdown menu */
         nav ul {
         list-style:none;
         margin: 0;
         }
         nav ul li {
         display: inline-block;
         }
         nav ul li a {
         color:white;
         display:block;
         padding:0px;
         text-decoration:none;
         float: left;
         }
         nav ul li:hover {
         background: #343a40!important;
         }
         nav ul li:hover > a{
         color:white;
         }
         nav ul li:hover > ul {
         display:block;
         }
         nav ul ul {
         border-bottom:1px solid red;
         background: #343a40!important;
         color:white;
         padding:20px;
         display:none;
         width: 100%;
         position: absolute;
         top: 33px;
         min-height: 280px;
         left: 0px;
         z-index: 999;
         }
         .menuFontSize{
         font-size: 14px;
         margin-top: 20px;
         text-align: left;
         }
         .menuFontSize a{
         text-decoration: none;
         padding-left: 2px;
         }
         .menuFontSize a:hover{
         color:red;
         }
         .titleFont{
         font-size: 16px;
         }
         .titleFont a{
         text-decoration: none;
         }
         .titleFont a:hover{
         color:red;
         }
         #div2-1,
         #div2-2 {
         width: 100%;
         height: 50%;
         padding: 3px;
         }
         #div1{
         padding: 3px;
         margin-top: 10px;
         }
         #div2{
         margin-top: 10px;
         max-width:224px;
         }
         .widget-box {
         padding: 15px;
         position:relative;
         margin-top:10px;
         min-height:300px;
         height:100%;
         cursor:pointer;
         }
         .widget-random {
         margin-top:10px;
         min-width: 250px;
         height:150px;
         }
         .banner-widget {
         margin-top:10px;
         min-width: 250px;
         min-height:460px;
         max-height:460px;
         }
         .slider-widget {
         padding: 0 !important;
         margin-top:10px;
         width: 100%;
         height:300px;
         }
         .btn-absolute{
         text-align: center;
         width: 25%;
         position:absolute;
         bottom:15px;
         right:35px;
         cursor:pointer !important;
         padding: 5px;
         border-radius: 5px;
         font-size: 12px;
         }
         .btn-absolute a{
         text-decoration: none;
         color:white;
         }
         .btn-destaques{
         text-align: center;
         width: 80%;
         float:right;
         cursor:pointer !important;
         padding: 1px;
         border-radius: 5px;
         font-size: 12px;
         top: 2px;
         }
         .widget-box a{
         text-decoration: none;
         color:white;
         }
         .hide{
         display:none;
         position:absolute;
         bottom:10px;
         }
         .hidden-sizes{
         left:0;
         right:0;
         }
         .hidden-sizes{
         text-decoration: none !important;
         }
         .hidden-sizes ul{
         text-align: center;
         padding: 0 !important;
         }
         .hidden-sizes li{
         display:inline-block;
         width: 24px !important;
         height: 20px !important;
         padding: 0 !important;
         }
         p{
         margin-bottom:1px;
         }
         .drop-shadow{
         -webkit-box-shadow: 0px 5px 49px -10px rgba(0,0,0,0.33);
         -moz-box-shadow: 0px 5px 49px -10px rgba(0,0,0,0.33);
         box-shadow: 0px 5px 49px -10px rgba(0,0,0,0.33);
         }
         /* footer */
         #customFOO {
         background-color: #343a40!important;;
         color: white;
         padding-top: 20px;
         }
         #map-container {
         height: 240px;
         width: 100%;
         margin-top: 30px;
         margin-bottom: 10px;
         }
         #customFOO .row {
         right: 30px;
         margin: 0 auto !important;
         }
         #customFOO .footer-copyright {
         background-color: #343a40!important;
         padding-top: 3px;
         padding-bottom: 3px;
         text-align: center;

         }
         #customFOO .footer-copyright p {
         font-size: 12px;
         color: #d2d1d1;
         }
         #customFOO .footer-copyright p:hover {
         cursor:pointer;
         color: white;
         }
         #customFOO .container {
         }
         #customFOO ul {
         list-style-type: none;
         padding-left: 0;
         line-height: 2.7;
         }
         #customFOO h5 {
         font-size: 18px;
         color: white;
         font-weight: bold;
         margin-top: 30px;
         }
         #customFOO a {
         color: #d2d1d1;
         text-decoration: none;
         }
         #customFOO a:hover,
         #customFOO a:focus {
         text-decoration: none;
         color: white;
         }
         #customFOO .social-networks {
         text-align: center;
         padding-bottom: 10px;
         }
         #customFOO .fa {
         font-size: 20px;
         margin-right: 15px;
         margin-left: 20px;
         color: #ccc;
         border-radius: 51%;
         padding: 10px;
         height: 50px;
         width: 50px;
         text-align: center;
         line-height: 31px;
         text-decoration: none;
         transition: color 0.2s;
         }
         @media screen and (max-width: 767px) {
         #customFOO {
         text-align: center;
         }
         #customFOO .row {
         margin: 0;
         }
         }
         .content{
         flex: 1 0 auto;
         -webkit-flex: 1 0 auto;
         min-height: 200px;
         }
         #customFOO{
         flex: 0 0 auto;
         -webkit-flex: 0 0 auto;
         }
         #customFOO h5{
         }
         .carousel-item{
         width: 100%;
         height:300px;
         }
         .carousel-top-text{
           width: 30%;
           background-color: yellow !important;
           position:absolute;
           left:10%;
           top:10%;
           color:white;
         }
      </style>
   </head>
   <body>
      <!-- navbar -->
      <nav class="navbar navbar-expand-md navbar-dark bg-dark" style="padding:0;">
         <div class="container" >
            <div class="card colors" style="width:100%;">
               <div id="langBar" class="collapse" aria-labelledby="heading-collapsed">
                  <div class="card-body">
                     <ul style="float:right;">
                        <li><a class="linkColor" href="#"> Português</a></li>
                        <li><a class="linkColor" href="#">Español</a></li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </nav>
      <div class="right-tab">
         <a href="#langBar" class="globe linkColor" data-toggle="collapse" href="#langBar" aria-expanded="true" aria-controls="langBar">
         <i id="globe" class="awesome-color fa fa-globe fa-2x" aria-hidden="true"></i></a>
      </div>
      <nav class="navbar navbar-expand-md navbar-dark bg-dark" style="padding:0;">
         <div class="container">
            <a href="#"><img src="../../imagens/layout/logo_fw.png" class="img-fluid"></a>
         </div>
      </nav>
      <nav id="header" class="navbar navbar-expand-md navbar-dark bg-dark navBorder">
         <div class="container" style="padding:0;">
            <!-- hamburguer button -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <!-- hamburguer button -->
            <div class="collapse navbar-collapse" id="navbarsExampleDefault">
               <!--dropdown menu end -->
               <ul class="navbar-nav mr-auto">
                  <li>
                     <div class="titleFont">
                        <a href="#">INÍCIO</a>
                     </div>
                  </li>
                  <!-- Title 1 -->
                  <li>
                     <div class="titleFont">
                        <a href="#">HOMEM</a>
                     </div>
                     <ul>
                        <div class="container">
                           <div class="row">
                              <!-- sub menu 1 -->
                              <div class="col-sm-2 menuFontSize">
                                 <div><b>Title</b></div>
                                 <div><a href="#">link 1</a></div>
                                 <br>
                                 <div><a href="#">link 2</a></div>
                                 <br>
                                 <div><a href="#">link 3</a></div>
                                 <br>
                              </div>
                              <!-- sub menu 2 -->
                              <div class="col-sm-2 menuFontSize">
                                 <div><b>Title</b></div>
                                 <div><a href="#">link 1</a></div>
                                 <br>
                                 <div><a href="#">link 2</a></div>
                                 <br>
                                 <div><a href="#">link 3</a></div>
                                 <br>
                              </div>
                              <!-- sub menu 3 -->
                              <div class="col-sm-2 menuFontSize">
                                 <div><b>Title</b></div>
                                 <div><a href="#">link 1</a></div>
                                 <br>
                                 <div><a href="#">link 2</a></div>
                                 <br>
                                 <div><a href="#">link 3</a></div>
                                 <br>
                              </div>
                              <!-- sub menu 4 -->
                              <div class="col-sm-2 menuFontSize">
                                 <div><b>Title</b></div>
                                 <div><a href="#">link 1</a></div>
                                 <br>
                                 <div><a href="#">link 2</a></div>
                                 <br>
                                 <div><a href="#">link 3</a></div>
                                 <br>
                              </div>
                              <!-- images holder -->
                              <div class="col-md-2" id="div2" style="padding:0px !important;">
                                 <div id="div2-1">
                                    <a href="#">
                                    <img class="img-fluid" src="https://dummyimage.com/224x165/000/fff">
                                    </a>
                                 </div>
                                 <div id="div2-2">
                                    <a href="#">
                                    <img class="img-fluid" src="https://dummyimage.com/224x165/000/fff">
                                    </a>
                                 </div>
                              </div>
                              <div class="col-md-2" id="div1">
                                 <img class="img-fluid" src="https://dummyimage.com/224x340/000/fff">
                              </div>
                              <!-- images holder -->
                           </div>
                        </div>
                     </ul>
                  </li>
                  <!-- title 2 -->
                  <li>
                     <div class="titleFont">
                        <a href="#">MULHER</a>
                     </div>
                     <ul>
                        <div class="container">
                           <div class="row">
                              <!-- sub menu 1 -->
                              <div class="col-sm-2 menuFontSize">
                                 <div><b>Title</b></div>
                                 <div><a href="#">link 1</a></div>
                                 <br>
                                 <div><a href="#">link 2</a></div>
                                 <br>
                                 <div><a href="#">link 3</a></div>
                                 <br>
                              </div>
                              <!-- sub menu 2 -->
                              <div class="col-sm-2 menuFontSize">
                                 <div><b>Title</b></div>
                                 <div><a href="#">link 1</a></div>
                                 <br>
                                 <div><a href="#">link 2</a></div>
                                 <br>
                                 <div><a href="#">link 3</a></div>
                                 <br>
                              </div>
                              <!-- sub menu 3 -->
                              <div class="col-sm-2 menuFontSize">
                                 <div><b>Title</b></div>
                                 <div><a href="#">link 1</a></div>
                                 <br>
                                 <div><a href="#">link 2</a></div>
                                 <br>
                                 <div><a href="#">link 3</a></div>
                                 <br>
                              </div>
                              <!-- sub menu 4 -->
                              <div class="col-sm-2 menuFontSize">
                                 <div><b>Title</b></div>
                                 <div><a href="#">link 1</a></div>
                                 <br>
                                 <div><a href="#">link 2</a></div>
                                 <br>
                                 <div><a href="#">link 3</a></div>
                                 <br>
                              </div>
                              <!-- images holder -->
                              <div class="col-md-2" id="div2" style="padding:0px !important;">
                                 <div id="div2-1">
                                    <a href="#">
                                    <img class="img-fluid" src="https://dummyimage.com/224x165/000/fff">
                                    </a>
                                 </div>
                                 <div id="div2-2">
                                    <a href="#">
                                    <img class="img-fluid" src="https://dummyimage.com/224x165/000/fff">
                                    </a>
                                 </div>
                              </div>
                              <div class="col-md-2" id="div1">
                                 <a href="#">
                                 <img class="img-fluid" src="https://dummyimage.com/224x340/000/fff">
                                 </a>
                              </div>
                              <!-- images holder -->
                           </div>
                        </div>
                     </ul>
                  </li>
                  <!-- title 3 -->
                  <li>
                     <div class="titleFont">
                        <a href="#">COLEÇÕES</a>
                     </div>
                     <ul>
                        <div class="container">
                           <div class="row">
                              <!-- sub menu 1 -->
                              <div class="col-sm-2 menuFontSize">
                                 <div><b>Title</b></div>
                                 <div><img class="img-fluid" src="https://dummyimage.com/224x125/000/fff"></div>
                                 <div><a href="#">link 2</a></div>
                                 <br>
                                 <div><a href="#">link 3</a></div>
                                 <br>
                              </div>
                              <!-- sub menu 2 -->
                              <div class="col-sm-2 menuFontSize">
                                 <div><b>Title</b></div>
                                 <div><img class="img-fluid" src="https://dummyimage.com/224x125/000/fff"></div>
                                 <div><a href="#">link 2</a></div>
                                 <br>
                                 <div><a href="#">link 3</a></div>
                                 <br>
                              </div>
                              <!-- sub menu 3 -->
                              <div class="col-sm-2 menuFontSize">
                                 <div><b>Title</b></div>
                                 <div><img class="img-fluid" src="https://dummyimage.com/224x125/000/fff"></div>
                                 <div><a href="#">link 2</a></div>
                                 <br>
                                 <div><a href="#">link 3</a></div>
                                 <br>
                              </div>
                              <!-- sub menu 4 -->
                              <div class="col-sm-2 menuFontSize">
                                 <div><b>Title</b></div>
                                 <div><img class="img-fluid" src="https://dummyimage.com/224x125/000/fff"></div>
                                 <div><a href="#">link 2</a></div>
                                 <br>
                                 <div><a href="#">link 3</a></div>
                                 <br>
                              </div>
                              <!-- sub menu 5 -->
                              <div class="col-sm-2 menuFontSize">
                                 <div><b>Title</b></div>
                                 <div><img class="img-fluid" src="https://dummyimage.com/224x125/000/fff"></div>
                                 <div><a href="#">link 2</a></div>
                                 <br>
                                 <div><a href="#">link 3</a></div>
                                 <br>
                              </div>
                              <!-- sub menu 6 -->
                              <div class="col-sm-2 menuFontSize">
                                 <div><b>Title</b></div>
                                 <div><img class="img-fluid" src="https://dummyimage.com/224x125/000/fff"></div>
                                 <div><a href="#">link 2</a></div>
                                 <br>
                                 <div><a href="#">link 3</a></div>
                                 <br>
                              </div>
                           </div>
                        </div>
                     </ul>
                  </li>
                  <!-- title 3 -->
                  <li>
                     <div class="titleFont">
                        <a href="#">PERSONALIZAÇÃO</a>
                     </div>
                  </li>
               </ul>
               <!--dropdown menu end -->
               <ul class="nav navbar-nav navbar-right">
                  <li id="search">
                     <a class="linkColor d-block awesome-color fa fa-search fa-2x" data-toggle="collapse" href="#searchStuff" aria-expanded="true" aria-controls="searchStuff">
                     </a>
                  </li>
                  <li>
                     <a class="linkColor" href="#"><i class="awesome-color fa fa-user fa-2x" aria-hidden="true"></i></a>
                  </li>
                  <li>
                     <a class="linkColor" href="#"><i class="awesome-color fa fa-2x fa-shopping-cart"></i></a>
                     <label class="badge cart-badge badge-warning">0</label>
                  </li>
               </ul>
            </div>
         </div>
      </nav>
      <!-- /navbar -->
      <div class="container">
         <div class="card">
            <div id="searchStuff" class="collapse" aria-labelledby="heading-collapsed">
               <div class="card-body">
                  <form autocomplete="off">
                     <input id="searchBar" class="animateSearch" type="text" name="search" value="ESCREVA E PRESSIONE 'ENTER' PARA PESQUISAR">
                  </form>
               </div>
            </div>
         </div>
      </div>
      <br>
      <main id="content" role="main" style="padding:0 15px 150px 15px;">
         <div class="container">
            <div class="row">
               <div class="col-md-8" style="padding-right:0;">
                  <div class="col-md-12" style="padding-left:0; padding-right:0; ">
                     <div class="slider-widget drop-shadow">
                        <!--carousel -->
                        <div class="container">
                           <div class="row">
                              <div id="carousel" class="carousel slide" data-ride="carousel">
                                 <div class="carousel-inner" role="listbox">
                                    <div class=" carousel-item active">
                                      <img class="img-fluid" src="http://fullwear.pt/fw2016/wp-content/uploads/2016/09/fundo-carneiras.jpg" alt="First">
                                      <div class="carousel-caption fadeInRight">
                                        <div style="position:absolute; right:0px; bottom:0;">
                                          <a href="#" class="btn btn-success">SHOP NOW</a>
                                        </div>
                                    </div>
                                    <div class="carousel-top-text">
                                        <h4>Texto</h4>
                                    </div>
                                    </div>
                                    <div class=" carousel-item">
                                      <img class="img-fluid" src="http://fullwear.pt/fw2016/wp-content/uploads/2016/06/bike.jpg" alt="Second">
                                    </div>
                                    <div class=" carousel-item">
                                      <img class="img-fluid" src="http://fullwear.pt/fw2016/wp-content/uploads/2016/09/running-1.jpg" alt="Third">
                                    </div>
                                 </div>
                                 <a class="carousel-control-prev" href="#carousel" role="button" data-slide="prev" style="top:10%;">
                                 <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                 <span class="sr-only">Previous</span>
                                 </a>
                                 <a class="carousel-control-next" href="#carousel" role="button" data-slide="next" style="top:10%;">
                                 <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                 <span class="sr-only">Next</span>
                                 </a>
                              </div>
                           </div>
                        </div>
                        <!--carousel -->
                     </div>
                  </div>
                  <div class="row">
                     <div class="col-md-6">
                        <div class="widget-random drop-shadow">
                          <img class="img-fluid" style="height:100%;" src="https://dummyimage.com/371x150/fff/000">
                        </div>
                        <div class="btn-absolute btn-danger">
                           <a href="#">SHOP NOW</a>
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="widget-random drop-shadow"><img class="img-fluid" style="height:100%;" src="https://dummyimage.com/371x150/fff/000"></div>
                        <div class="btn-absolute btn-danger">
                           <a href="#">SHOP NOW</a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="banner-widget drop-shadow"><img class="img-fluid" style="height:100%;" src="https://dummyimage.com/350x459/fff/000"></div>
               </div>
            </div>
         </div>
         <br>
         <!-- Destaques -->
         <div class="container">
            <h4 class="" style="text-align:center; border-bottom:2px solid black; padding:10px;">Destaques</h4>
            <div class="container-fluid">
               <div class="row">
                  <div class="col-md-3 col-md-offset-1 anim">
                     <!-- widget-box interior content -->
                     <div class="widget-box drop-shadow hvr-grow">
                        <a href="#">
                           <img class="img-fluid" src="https://dummyimage.com/248x270/fff/000">
                           <p style="text-align:center; color:black;"><br>TECHNODRY<br>€23.95<br></p>
                        </a>
                        <div class="hide hidden-sizes">
                           <ul>
                              <li class="btn-danger">XS</li>
                              <li class="btn-success">S</li>
                              <li class="btn-success">M</li>
                              <li class="btn-danger">L</li>
                              <li class="btn-danger">XL</li>
                              <li class="btn-danger">2XL</li>
                              <li class="btn-danger">3XL</li>
                              <li class="btn-danger">4XL</li>
                           </ul>
                           <div class="container">
                              <div class="row ">
                                 <div class="col-md-6">
                                    <div style="margin-left:10px;">
                                       <div class="row">
                                          <div class="rcorners1"></div>
                                          <div class="cenas">EM STOCK</div>
                                       </div>
                                       <div class="row">
                                          <div class="rcorners2"></div>
                                          <div class="cenas">FORA DE STOCK</div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-6">
                                    <div class="btn-destaques btn-danger">
                                       <a href="#">SHOP NOW</a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- widget-box interior content -->
                  </div>
                  <div class="col-md-3 col-md-offset-1 anim">
                     <!-- widget-box interior content -->
                     <div class="widget-box drop-shadow hvr-grow">
                        <a href="#">
                           <img class="img-fluid" src="http://cdn.shopify.com/s/files/1/1441/5702/products/M_slime_grande.jpg?v=1509116353">
                           <p style="text-align:center; color:black;"><br>TECHNODRY<br>€23.95<br></p>
                        </a>
                        <div class="hide hidden-sizes">
                           <ul>
                              <li class="btn-danger">XS</li>
                              <li class="btn-success">S</li>
                              <li class="btn-success">M</li>
                              <li class="btn-danger">L</li>
                              <li class="btn-danger">XL</li>
                              <li class="btn-danger">2XL</li>
                              <li class="btn-danger">3XL</li>
                              <li class="btn-danger">4XL</li>
                           </ul>
                           <div class="container">
                              <div class="row ">
                                 <div class="col-md-6">
                                    <div style="margin-left:10px;">
                                       <div class="row">
                                          <div class="rcorners1"></div>
                                          <div class="cenas">EM STOCK</div>
                                       </div>
                                       <div class="row">
                                          <div class="rcorners2"></div>
                                          <div class="cenas">FORA DE STOCK</div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-6">
                                    <div class="btn-destaques btn-danger">
                                       <a href="#">SHOP NOW</a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- widget-box interior content -->
                  </div>
                  <div class="col-md-3 col-md-offset-1 anim">
                     <!-- widget-box interior content -->
                     <div class="widget-box drop-shadow hvr-grow">
                        <a href="#">
                           <img class="img-fluid" src="http://fullwear.pt/fw2016/wp-content/uploads/2016/11/SHIRTRUNNINGPRO-3.jpg">
                           <p style="text-align:center; color:black;"><br>TECHNODRY<br>€23.95<br></p>
                        </a>
                        <div class="hide hidden-sizes">
                           <ul>
                              <li class="btn-danger">XS</li>
                              <li class="btn-success">S</li>
                              <li class="btn-success">M</li>
                              <li class="btn-danger">L</li>
                              <li class="btn-danger">XL</li>
                              <li class="btn-danger">2XL</li>
                              <li class="btn-danger">3XL</li>
                              <li class="btn-danger">4XL</li>
                           </ul>
                           <div class="container">
                              <div class="row ">
                                 <div class="col-md-6">
                                    <div style="margin-left:10px;">
                                       <div class="row">
                                          <div class="rcorners1"></div>
                                          <div class="cenas">EM STOCK</div>
                                       </div>
                                       <div class="row">
                                          <div class="rcorners2"></div>
                                          <div class="cenas">FORA DE STOCK</div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-6">
                                    <div class="btn-destaques btn-danger">
                                       <a href="#">SHOP NOW</a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- widget-box interior content -->
                  </div>
                  <div class="col-md-3 col-md-offset-1 anim">
                     <!-- widget-box interior content -->
                     <div class="widget-box drop-shadow hvr-grow">
                        <a href="#">
                           <img class="img-fluid" src="https://dummyimage.com/248x270/fff/000">
                           <p style="text-align:center; color:black;"><br>TECHNODRY<br>€23.95<br></p>
                        </a>
                        <div class="hide hidden-sizes">
                           <ul>
                              <li class="btn-danger">XS</li>
                              <li class="btn-success">S</li>
                              <li class="btn-success">M</li>
                              <li class="btn-danger">L</li>
                              <li class="btn-danger">XL</li>
                              <li class="btn-danger">2XL</li>
                              <li class="btn-danger">3XL</li>
                              <li class="btn-danger">4XL</li>
                           </ul>
                           <div class="container">
                              <div class="row ">
                                 <div class="col-md-6">
                                    <div style="margin-left:10px;">
                                       <div class="row">
                                          <div class="rcorners1"></div>
                                          <div class="cenas">EM STOCK</div>
                                       </div>
                                       <div class="row">
                                          <div class="rcorners2"></div>
                                          <div class="cenas">FORA DE STOCK</div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-md-6">
                                    <div class="btn-destaques btn-danger">
                                       <a href="#">SHOP NOW</a>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <!-- widget-box interior content -->
                  </div>
               </div>
            </div>
         </div>
         <!-- Destaques -->
      </main>
      <!-- footer -->
      <footer id="customFOO" class="bg-dark">
         <div class="container">
            <div class="row">
               <div class="col-sm-4 custom-border">
                  <h5>Loja</h5>
                  <ul>
                     <li><a href="#"><i class="fa fa-male" aria-hidden="true"></i>Homem</a></li>
                     <li><a href="#"><i class="fa fa-female" aria-hidden="true"></i>Mulher</a></li>
                     <li><a href="#"><i class="fa fa-users" aria-hidden="true"></i>Coleções</a></li>
                     <li><a href="#"><i class="fa fa-scissors" aria-hidden="true"></i>Personalização</a></li>
                  </ul>
               </div>
               <div class="col-sm-4 custom-border">
                  <h5>Sobre nós</h5>
                  <ul>
                     <li><a href="#"><i class="fa fa-file" aria-hidden="true"></i>Termos de Serviço</a></li>
                     <li><a href="#"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Maquetas</a></li>
                     <li><a href="#"><i class="fa fa-comments" aria-hidden="true"></i>Comunidade</a></li>
                     <li><a href="#"><i class="fa fa-exchange" aria-hidden="true"></i>Testemunhos</a></li>
                  </ul>
               </div>
               <div class="col-sm-4">
                  <h5>Contactos</h5>
                  <ul>
                     <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i>facebook.com/fullwear</a></li>
                     <li><a href="#"><i class="fa fa-youtube" aria-hidden="true"></i>youtube.com/fullwear</a></li>
                     <li><a href="#"><i class="fa fa-envelope-o" aria-hidden="true"></i>geral@fullwear.pt</a></li>
                     <li><a href="#"><i class="fa fa-phone" aria-hidden="true"></i>0351 256 305 309 </a></li>
                  </ul>
               </div>
            </div>
            <!-- Google Embed MAPS API -->
            <iframe id="map-container" frameborder="0" style="border:0"
               src="https://www.google.com/maps/embed?pb=!1m22!1m11!1m3!1d906.305544829084!2d-8.56218811893967!3d40.96108673750441!2m2!1f0!2f0!3m2!1i1024!2i768!4f13.1!4m8!3e6!4m0!4m5!1s0xd2380a86c8c1f0d%3A0x4d4d60f6c3e28a15!2sfullwear!3m2!1d40.961341999999995!2d-8.562078999999999!5e1!3m2!1spt-PT!2spt!4v1510762236309" >
            </iframe>
         </div>
         <div class="social-networks">
         </div>
         <div class="footer-copyright">
            <p>© 2017 Copyright FULLWEAR.PT </p>
         </div>
      </footer>
      <!--/Footer-->
      <script type="text/javascript">
         //grow Destaques
          $('.anim').mouseenter(function() {
            var elem = $(this).closest('.anim').find('.widget-box');
             if (elem.data('state')) {
                elem.data('state', false).animate({height:'100%'});
            }else{
                elem.data('state', true).animate({height:'120%'});
            }
         });
          $('.anim').mouseleave(function() {
            var elem = $(this).closest('.anim').find('.widget-box');
            if (elem.data('state')) {
                elem.data('state', false).animate({height:'100%'});
            }else{
                elem.data('state', true).animate({height:'120%'});
            }
         });
          $('.widget-box').mouseenter(function() {
              var elemCSS = $(this).closest('.widget-box').find('.hide');
              if (elemCSS.data('state')) {
                elemCSS.data('state', false).css({display:'none'});
            }else{
               elemCSS.data('state', false).fadeIn(1000).css({display:'block'});
            }
         });
            $('.widget-box').mouseleave(function() {
              var elemCSS = $(this).closest('.widget-box').find('.hide');
              if (elemCSS.data('state')) {
                elemCSS.data('state', false).css({display:'block'});
            }else{
               elemCSS.data('state', false).css({display:'none'});
            }
         });
            //grow search bar
          $(document).ready(function(){
            $("#search").click(function(){
              setTimeout(function(){ $('#searchBar').css({'width': '100%'});  }, 200);
            });
          });
          //clear default value
          $(document).ready(function(){
            $("#searchBar").click(function(){
              $(this).val('');
            });
          });
          // function to flush footer to bottom
          // function autoHeight() {
          // $('#content').css('min-height', (
          // $(document).height()
          // - $('#header').height()
          // - $('#footer').height()
          // ));
          // }
          // $(document).ready(function() {
          // autoHeight();
          // });
          // $(window).resize(function() {
          // autoHeight();
          // });
      </script>
   </body>
</html>