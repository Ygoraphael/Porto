<!DOCTYPE html>
<html>
<head>
  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>navBar Mobile</title>
  <style>
  .pen .navbar-toggle {
	border: none;
	background: transparent !important;
}

.pen .navbar-toggle:hover {
	background: transparent !important;
}

.pen .navbar-toggle .icon-bar {
	width: 22px;
	-webkit-transition: all 0.2s;
	transition: all 0.2s;
}

/* ANIMATED X */
.navbar-toggle.x .icon-bar:nth-of-type(1) {
	-webkit-transform: rotate(45deg);
	-ms-transform: rotate(45deg);
	transform: rotate(45deg);
	-webkit-transform-origin: 10% 10%;
	-ms-transform-origin: 10% 10%;
	transform-origin: 10% 10%;
}

.navbar-toggle.x .icon-bar:nth-of-type(2) {
	opacity: 0;
	filter: alpha(opacity=0);
}

.navbar-toggle.x .icon-bar:nth-of-type(3) {
	-webkit-transform: rotate(-45deg);
	-ms-transform: rotate(-45deg);
	transform: rotate(-45deg);
	-webkit-transform-origin: 10% 90%;
	-ms-transform-origin: 10% 90%;
	transform-origin: 10% 90%;
}

/* ANIMATED X COLLAPSED */
.navbar-toggle.x.collapsed .icon-bar:nth-of-type(1) {
	-webkit-transform: rotate(0);
	-ms-transform: rotate(0);
	transform: rotate(0);
}

.navbar-toggle.x.collapsed .icon-bar:nth-of-type(2) {
	opacity: 1;
	filter: alpha(opacity=100);
}

.navbar-toggle.x.collapsed .icon-bar:nth-of-type(3) {
	-webkit-transform: rotate(0);
	-ms-transform: rotate(0);
	transform: rotate(0);
}
/* END ANIMATED X */

/* ANIMATED RIGHT ARROW */
.navbar-toggle.rarr.collapsed .icon-bar:nth-of-type(1) {
	transform: translate3d(0,0,0) rotate(0deg);
	transform-origin: right top;
	width: 22px;
}

.navbar-toggle.rarr.collapsed .icon-bar:nth-of-type(2) {
	transform: translate3d(0,0,0) rotate(0deg);
}

.navbar-toggle.rarr.collapsed .icon-bar:nth-of-type(3) {
	transform: translate3d(0,0,0) rotate(0deg);
	transform-origin: right bottom;
	width: 22px;
}

.navbar-toggle.rarr .icon-bar:nth-of-type(1) {
	transform: translate3d(11px,6px,0) rotate(45deg);
	transform-origin: right top;
	width: 11px;
}

.navbar-toggle.rarr .icon-bar:nth-of-type(2) {
	/* transform: scale(0.75); */;
}

.navbar-toggle.rarr .icon-bar:nth-of-type(3) {
	transform: translate3d(11px,-6px,0) rotate(-45deg);
	transform-origin: right bottom;
	width: 11px;
}
/* END ANIMATED RIGHT ARROW */

/* ANIMATED LEFT ARROW */
.navbar-toggle.larr.collapsed .icon-bar:nth-of-type(1) {
	transform: translate3d(0,0,0) rotate(0deg);
	width: 22px;
}

.navbar-toggle.larr.collapsed .icon-bar:nth-of-type(2) {
	transform: translate3d(0,0,0) rotate(0deg);
}

.navbar-toggle.larr.collapsed .icon-bar:nth-of-type(3) {
	transform: translate3d(0,0,0) rotate(0deg);
	width: 22px;
}

.navbar-toggle.larr .icon-bar:nth-of-type(1) {
	transform: translate3d(0px,6px,0) rotate(45deg);
	transform-origin: left top;
	width: 11px;
}

.navbar-toggle.larr .icon-bar:nth-of-type(3) {
	transform: translate3d(0px,-6px,0) rotate(-45deg);
	transform-origin: left bottom;
	width: 11px;
}
/* END ANIMATED LEFT ARROW */

/* ANIMATED UP ARROW */
.navbar-toggle.uarr.collapsed .icon-bar:nth-of-type(1) {
	transform: translate3d(0,0,0) rotate(0deg);
	width: 22px;
}

.navbar-toggle.uarr.collapsed .icon-bar:nth-of-type(2) {
	transform: translate3d(0,0,0) rotate(0deg);
}

.navbar-toggle.uarr.collapsed .icon-bar:nth-of-type(3) {
	transform: translate3d(0,0,0) rotate(0deg);
	width: 22px;
}

.navbar-toggle.uarr .icon-bar:nth-of-type(1) {
	transform: translate3d(1px,0,0) rotate(-45deg);
	transform-origin: center center;
	width: 11px;
}

.navbar-toggle.uarr .icon-bar:nth-of-type(2) {
	transform: rotate(-90deg);
	transform-origin: center center;
}

.navbar-toggle.uarr .icon-bar:nth-of-type(3) {
	transform: translate3d(0px,-14px,0) rotate(-135deg);
	transform-origin: right top;
	width: 11px;
}
/* END ANIMATED UP ARROW */

/* ANIMATED PLUS */
.navbar-toggle.plus.collapsed .icon-bar:nth-of-type(1) {
	transform: translate3d(0,0,0) rotate(0deg);
}

.navbar-toggle.plus.collapsed .icon-bar:nth-of-type(2) {
	transform: translate3d(0,0,0) rotate(0deg);
}

.navbar-toggle.plus.collapsed .icon-bar:nth-of-type(3) {
	transform: translate3d(0,0,0) rotate(0deg);
}

.navbar-toggle.plus .icon-bar:nth-of-type(1) {
	transform: translate3d(0px,6px,0) rotate(90deg);
	transform-origin: center center;
}

.navbar-toggle.plus .icon-bar:nth-of-type(3) {
	transform: translate3d(0px,-6px,0) rotate(-90deg);
	transform-origin: center center;
}
/* END ANIMATED PLUS */

/* ANIMATED MINUS */
.navbar-toggle.minus.collapsed .icon-bar:nth-of-type(1) {
	transform: translate3d(0,0,0) rotate(0deg);
}

.navbar-toggle.minus.collapsed .icon-bar:nth-of-type(2) {
	transform: translate3d(0,0,0) rotate(0deg);
}

.navbar-toggle.minus.collapsed .icon-bar:nth-of-type(3) {
	transform: translate3d(0,0,0) rotate(0deg);
}

.navbar-toggle.minus .icon-bar:nth-of-type(1) {
	transform: translate3d(0,6px,0);
}

.navbar-toggle.minus .icon-bar:nth-of-type(3) {
	transform: translate3d(0,-6px,0);
}
/* END ANIMATED MINUS */

/* FORCE NAVBAR-TOGGLE */

.pen .navbar-header {
	float: none;
}

.pen .navbar-toggle {
	display: block;
}

.pen .navbar-collapse {
	border-top: 1px solid transparent;
	box-shadow: inset 0 1px 0 rgba(255,255,255,0.1);
}

.pen .navbar-collapse.collapse {
	display: none !important;
}

.pen .navbar-nav {
	float: none !important;
	margin: 7.5px -15px;
}

.pen .navbar-nav > li {
	float: none;
}

.pen .navbar-nav > li > a {
	padding-top: 10px;
	padding-bottom: 10px;
}

.pen .navbar-collapse.collapse.in {
	display: block !important;
}

.pen .navbar-brand {
  font-size:14px;
}
  </style>
</head>
<body>
  <div class="container-fluid">
  <div class="page-header">
    <h1>Bootstrap <small>3.3.7</small> Navbar Toggle Animations</h1>
    <p class="lead">Based on <a href="https://codepen.io/bennettfeely/pen/twbyA" target="_blank">Navicon Transformicons</a> by <a href="https://codepen.io/bennettfeely/" target="_blank">Bennett Feely</a>.</p>
    </div>

    <div class="row">
  <div class="col-sm-4">

  <nav class="navbar navbar-default" role="navigation">
  <div class="navbar-header">
  <button type="button" class="navbar-toggle x collapsed" data-toggle="collapse" data-target="#navbar-collapse-x">
  <span class="icon-bar"></span>
  <span class="icon-bar"></span>
  <span class="icon-bar"></span>
  </button>
  <a class="navbar-brand" href="#top">.navbar-toggle.x</a>
  </div>

  <div class="collapse navbar-collapse" id="navbar-collapse-x">
  <ul class="nav navbar-nav navbar-right">
  <li data-toggle="collapse" data-target="#navbar-collapse.in"><a href="#top">Link</a></li>
  <li data-toggle="collapse" data-target="#navbar-collapse.in"><a href="#top">Link</a></li>
  </ul>
  </div><!-- .navbar-collapse -->
  </nav>

  </div><div class="col-sm-4">

  <nav class="navbar navbar-default" role="navigation">
  <div class="navbar-header">
  <button type="button" class="navbar-toggle uarr collapsed" data-toggle="collapse" data-target="#navbar-collapse-uarr">
  <span class="icon-bar"></span>
  <span class="icon-bar"></span>
  <span class="icon-bar"></span>
  </button>
  <a class="navbar-brand" href="#top">.navbar-toggle.uarr</a>
  </div>

  <div class="collapse navbar-collapse" id="navbar-collapse-uarr">
  <ul class="nav navbar-nav navbar-right">
  <li data-toggle="collapse" data-target="#navbar-collapse.in"><a href="#top">Link</a></li>
  <li data-toggle="collapse" data-target="#navbar-collapse.in"><a href="#top">Link</a></li>
  </ul>
  </div><!-- .navbar-collapse -->
  </nav>

  </div><div class="col-sm-4">

  <nav class="navbar navbar-default" role="navigation">
  <div class="navbar-header">
  <button type="button" class="navbar-toggle larr collapsed" data-toggle="collapse" data-target="#navbar-collapse-larr">
  <span class="icon-bar"></span>
  <span class="icon-bar"></span>
  <span class="icon-bar"></span>
  </button>
  <a class="navbar-brand" href="#top">.navbar-toggle.larr</a>
  </div>

  <div class="collapse navbar-collapse" id="navbar-collapse-larr">
  <ul class="nav navbar-nav navbar-right">
  <li data-toggle="collapse" data-target="#navbar-collapse.in"><a href="#top">Link</a></li>
  <li data-toggle="collapse" data-target="#navbar-collapse.in"><a href="#top">Link</a></li>
  </ul>
  </div><!-- .navbar-collapse -->
  </nav>

  </div></div><div class="row">

  <div class="col-sm-4">

  <nav class="navbar navbar-default" role="navigation">
  <div class="navbar-header">
  <button type="button" class="navbar-toggle rarr collapsed" data-toggle="collapse" data-target="#navbar-collapse-rarr">
  <span class="icon-bar"></span>
  <span class="icon-bar"></span>
  <span class="icon-bar"></span>
  </button>
  <a class="navbar-brand" href="#top">.navbar-toggle.rarr</a>
  </div>

  <div class="collapse navbar-collapse" id="navbar-collapse-rarr">
  <ul class="nav navbar-nav navbar-right">
  <li data-toggle="collapse" data-target="#navbar-collapse.in"><a href="#top">Link</a></li>
  <li data-toggle="collapse" data-target="#navbar-collapse.in"><a href="#top">Link</a></li>
  </ul>
  </div><!-- .navbar-collapse -->
  </nav>

  </div><div class="col-sm-4">

  <nav class="navbar navbar-default" role="navigation">
  <div class="navbar-header">
  <button type="button" class="navbar-toggle plus collapsed" data-toggle="collapse" data-target="#navbar-collapse-plus">
  <span class="icon-bar"></span>
  <span class="icon-bar"></span>
  <span class="icon-bar"></span>
  </button>
  <a class="navbar-brand" href="#top">.navbar-toggle.plus</a>
  </div>

  <div class="collapse navbar-collapse" id="navbar-collapse-plus">
  <ul class="nav navbar-nav navbar-right">
  <li data-toggle="collapse" data-target="#navbar-collapse.in"><a href="#top">Link</a></li>
  <li data-toggle="collapse" data-target="#navbar-collapse.in"><a href="#top">Link</a></li>
  </ul>
  </div><!-- .navbar-collapse -->
  </nav>

  </div><div class="col-sm-4">

  <nav class="navbar navbar-default" role="navigation">
  <div class="navbar-header">
  <button type="button" class="navbar-toggle minus collapsed" data-toggle="collapse" data-target="#navbar-collapse-minus">
  <span class="icon-bar"></span>
  <span class="icon-bar"></span>
  <span class="icon-bar"></span>
  </button>
  <a class="navbar-brand" href="#top">.navbar-toggle.minus</a>
  </div>

  <div class="collapse navbar-collapse" id="navbar-collapse-minus">
  <ul class="nav navbar-nav navbar-right">
  <li data-toggle="collapse" data-target="#navbar-collapse.in"><a href="#top">Link</a></li>
  <li data-toggle="collapse" data-target="#navbar-collapse.in"><a href="#top">Link</a></li>
  </ul>
  </div><!-- .navbar-collapse -->
  </nav>

  </div></div></div>
</body>
</html>
