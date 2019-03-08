<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Buttons</title>
  <style media="screen">
  .custom-btn {
    background-color: #eb4800;
    max-height:20px;
}
.custom-btn .round {
background-color: #f59965;
}

.custom-a {
text-decoration: none;
-moz-border-radius: 30px;
-webkit-border-radius: 30px;
border-radius: 30px;
padding: 12px 53px 12px 23px;
color: #fff;
text-transform: uppercase;
font-family: sans-serif;
font-weight: bold;
position: relative;
-moz-transition: all 0.3s;
-o-transition: all 0.3s;
-webkit-transition: all 0.3s;
transition: all 0.3s;
display: inline-block;
}
.custom-a span {
position: relative;
z-index: 3;
}
.custom-a .round {
-moz-border-radius: 50%;
-webkit-border-radius: 50%;
border-radius: 50%;
width: 38px;
height: 38px;
position: absolute;
right: 3px;
top: 3px;
-moz-transition: all 0.3s ease-out;
-o-transition: all 0.3s ease-out;
-webkit-transition: all 0.3s ease-out;
transition: all 0.3s ease-out;
z-index: 2;
}
.custom-a .round i {
position: absolute;
top: 50%;
margin-top: -8px;
left: 50%;
margin-left: -5px;
-moz-transition: all 0.3s;
-o-transition: all 0.3s;
-webkit-transition: all 0.3s;
transition: all 0.3s;
}
.txt {
font-size: 14px;
line-height: 1.45;
}
.btn-holder .custom-a:hover {
padding-left: 48px;
padding-right: 28px;
}
.btn-holder .custom-a:hover .round {
width: calc(100% - 6px);
-moz-border-radius: 30px;
-webkit-border-radius: 30px;
border-radius: 30px;
}
.btn-holder .custom-a:hover .round i {
left: 12%;
}
  </style>
  <link rel="stylesheet" href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>


<div class="btn-holder">
  <div>
    <a href="" class="custom-a custom-btn">
      <span class="round"><i class="fa fa-chevron-left"></i></span>
      <span class="txt">Voltar</span>
    </a>
  </div>
  <br>
    <div>
    <a href="" class="custom-a custom-btn">
      <span class="round"><i class="fa fa-shopping-cart" style="margin-left:-7px;"></i></span>
      <span class="txt">Adicionar ao carrinho</span>
    </a>
  </div>
  <div>
    <br>
  <a href="" class="custom-a custom-btn">
    <span class="round"><i class="fa fa-ban"></i></span>
    <span class="txt">cancelar</span>
  </a>
</div>
<br>
<div>
  <a href="" class="custom-a custom-btn">
    <span class="round"><i class="fa fa-chevron-right"></i></span>
    <span class="txt">Continuar</span>
  </a>
</div>
<br>
<div>
  <a href="" class="custom-a custom-btn">
    <span class="round"><i class="fa fa-plus-circle"></i>
</span>
    <span class="txt">Filtrar</span>
  </a>
</div>
</div>
</body>
</html>
