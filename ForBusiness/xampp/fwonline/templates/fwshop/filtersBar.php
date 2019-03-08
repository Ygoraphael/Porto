<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Hamburger Menu</title>
  <style>
  .hidden-filter-panel {
  background:#181818;
  color:#FFF;
  position: absolute;
  top: -250px;
  left: 0;
  width: 100%;
  height: 250px;
  padding: 20px;
  transition: top 300ms cubic-bezier(0.17, 0.04, 0.03, 0.94);
  overflow: hidden;
  box-sizing: border-box;
  }
  #toggle {
    position:absolute;
    appearance:none;
    cursor:pointer;
    left:-100%;
    top:-100%;
  }
  #toggle + label {
     position:absolute;
      width: 90px;
      height: 30px;
      display: inline-block;
      margin-top: 10%;
      margin-left: 50%;
      border-radius: 14px;
      -webkit-background-clip: padding-box;
      -moz-background-clip: padding-box;
      background-clip: padding-box;
      background: rgb(138,138,138);
      background: -webkit-linear-gradient(top, rgba(138,138,138,1) 0%, rgba(140,140,140,1) 14%, rgba(159,159,159,1) 72%, rgba(164,164,164,1) 100%);
      background: -moz-linear-gradient(top, rgba(138,138,138,1) 0%, rgba(140,140,140,1) 14%, rgba(159,159,159,1) 72%, rgba(164,164,164,1) 100%);
      background: -o-linear-gradient(top, rgba(138,138,138,1) 0%, rgba(140,140,140,1) 14%, rgba(159,159,159,1) 72%, rgba(164,164,164,1) 100%);
      background: -ms-linear-gradient(top, rgba(138,138,138,1) 0%, rgba(140,140,140,1) 14%, rgba(159,159,159,1) 72%, rgba(164,164,164,1) 100%);
      background: linear-gradient(top, rgba(138,138,138,1) 0%, rgba(140,140,140,1) 14%, rgba(159,159,159,1) 72%, rgba(164,164,164,1) 100%);
      box-shadow: inset 0 2px 5px 0 rgba(0, 0, 0, 0.1), inset 0 -1px 0 0 rgba(0, 0, 0, 0.1);
      line-height: 30px;
      font-style: normal;
      color: #fff;
      text-shadow: 0 1px 1px rgba(0,0,0,0.1);
      font-weight: bold;
      -webkit-box-reflect: below 0px
        -webkit-gradient(linear, left top, left bottom,
        color-stop(0.5, transparent),
        to(rgba(255, 255, 255, 0.3)));
      -moz-transition: all 1s ease-in;
      -webkit-transition: all 1s ease-in;
      -o-transition: all 1s ease-in;
      transition: all 1s ease-in;
      cursor: pointer;
      z-index: 999;
  }
  #toggle + label:after {
    font-family: raleway, sans-serif;
    content:"Filtros";
    margin-left: 15%;
    top: 0;
    color:red;
  }
  #toggle:checked ~ .hidden-filter-panel {
    top: 0;
  }
  #toggle:checked ~ .cont {
    margin-top: 250px;
  }
  #toggle:checked + label {
    background: rgb(141,173,51);
  	background: -webkit-radial-gradient(center, ellipse cover, rgba(141,173,51,1) 0%, rgba(146,178,55,1) 24%, rgba(157,187,64,1) 55%, rgba(166,194,78,1) 100%);
  	background: -moz-radial-gradient(center, ellipse cover, rgba(141,173,51,1) 0%, rgba(146,178,55,1) 24%, rgba(157,187,64,1) 55%, rgba(166,194,78,1) 100%);
  	background: -o-radial-gradient(center, ellipse cover, rgba(141,173,51,1) 0%, rgba(146,178,55,1) 24%, rgba(157,187,64,1) 55%, rgba(166,194,78,1) 100%);
  	background: -ms-radial-gradient(center, ellipse cover, rgba(141,173,51,1) 0%, rgba(146,178,55,1) 24%, rgba(157,187,64,1) 55%, rgba(166,194,78,1) 100%);
  	background: radial-gradient(center, ellipse cover, rgba(141,173,51,1) 0%, rgba(146,178,55,1) 24%, rgba(157,187,64,1) 55%, rgba(166,194,78,1) 100%);
  }
  input[type=checkbox]:checked ~ label.attention:hover:before  {
  	content: "on";
  	font-size: 10px;
  }

  label i:before {
  	content: "";
  	display: block;
  	position: absolute;
  	top: 50%;
  	left: 50%;
  	width: 18px;
  	height: 18px;
  	margin: -9px 0 0 -9px;
  	border-radius: 18px;
  	background: rgb(239,239,239);
  	background: -webkit-linear-gradient(top, rgba(239,239,239,1) 0%, rgba(225,225,225,1) 6%, rgba(225,225,225,1) 24%, rgba(229,229,229,1) 94%, rgba(242,242,242,1) 100%);
  	background: -moz-linear-gradient(top, rgba(239,239,239,1) 0%, rgba(225,225,225,1) 6%, rgba(225,225,225,1) 24%, rgba(229,229,229,1) 94%, rgba(242,242,242,1) 100%);
  	background: -o-linear-gradient(top, rgba(239,239,239,1) 0%, rgba(225,225,225,1) 6%, rgba(225,225,225,1) 24%, rgba(229,229,229,1) 94%, rgba(242,242,242,1) 100%);
  	background: -ms-linear-gradient(top, rgba(239,239,239,1) 0%, rgba(225,225,225,1) 6%, rgba(225,225,225,1) 24%, rgba(229,229,229,1) 94%, rgba(242,242,242,1) 100%);
  	background: linear-gradient(top, rgba(239,239,239,1) 0%, rgba(225,225,225,1) 6%, rgba(225,225,225,1) 24%, rgba(229,229,229,1) 94%, rgba(242,242,242,1) 100%);
  	box-shadow: inset 0 1px 0 0 rgba(0, 0, 0, 0.1);
  }
  label:hover i {
  	box-shadow: inset 0 -3px 3px 0 rgba(0, 0, 0, 0.1), inset 0 -1px 1px 0 rgba(255, 255, 255, 0.4), 0 2px 0 0 rgba(0, 0, 0, 0.3);
  }
  label:active i:before {
  	box-shadow: inset 0 1px 0 0 rgba(0, 0, 0, 0.3);
  }
  label i {
  	position: absolute;
  	top: -4px;
  	right:60px;
  	width: 36px;
  	height: 36px;
  	display: block;
  	border-radius: 36px;
  	background: rgb(255,255,255);
  	background: -webkit-linear-gradient(top, rgba(255,255,255,1) 0%, rgba(252,252,252,1) 11%, rgba(228,228,228,1) 50%, rgba(221,221,221,1) 53%, rgba(205,205,205,1) 97%, rgba(191,191,191,1) 100%);
  	background: -moz-linear-gradient(top, rgba(255,255,255,1) 0%, rgba(252,252,252,1) 11%, rgba(228,228,228,1) 50%, rgba(221,221,221,1) 53%, rgba(205,205,205,1) 97%, rgba(191,191,191,1) 100%);
  	background: -o-linear-gradient(top, rgba(255,255,255,1) 0%, rgba(252,252,252,1) 11%, rgba(228,228,228,1) 50%, rgba(221,221,221,1) 53%, rgba(205,205,205,1) 97%, rgba(191,191,191,1) 100%);
  	background: -ms-linear-gradient(top, rgba(255,255,255,1) 0%, rgba(252,252,252,1) 11%, rgba(228,228,228,1) 50%, rgba(221,221,221,1) 53%, rgba(205,205,205,1) 97%, rgba(191,191,191,1) 100%);
  	background: linear-gradient(top, rgba(255,255,255,1) 0%, rgba(252,252,252,1) 11%, rgba(228,228,228,1) 50%, rgba(221,221,221,1) 53%, rgba(205,205,205,1) 97%, rgba(191,191,191,1) 100%);
  	box-shadow: inset 0 -3px 3px 0 rgba(0, 0, 0, 0.1), inset 0 -1px 1px 0 rgba(255, 255, 255, 0.4), 0 2px 0 0 rgba(0, 0, 0, 0.2);
  	-webkit-transition: all 200ms ease;
  	-moz-transition: all 200ms ease;
  	-o-transition: all 200ms ease;
  	-ms-transition: all 200ms ease;
  	transition: all 200ms ease;
  }

  label i:before {
  	content: "";
  	display: block;
  	position: absolute;
  	top: 50%;
  	left: 50%;
  	width: 18px;
  	height: 18px;
  	margin: -9px 0 0 -9px;
  	border-radius: 18px;
  	background: rgb(239,239,239);
  	background: -webkit-linear-gradient(top, rgba(239,239,239,1) 0%, rgba(225,225,225,1) 6%, rgba(225,225,225,1) 24%, rgba(229,229,229,1) 94%, rgba(242,242,242,1) 100%);
  	background: -moz-linear-gradient(top, rgba(239,239,239,1) 0%, rgba(225,225,225,1) 6%, rgba(225,225,225,1) 24%, rgba(229,229,229,1) 94%, rgba(242,242,242,1) 100%);
  	background: -o-linear-gradient(top, rgba(239,239,239,1) 0%, rgba(225,225,225,1) 6%, rgba(225,225,225,1) 24%, rgba(229,229,229,1) 94%, rgba(242,242,242,1) 100%);
  	background: -ms-linear-gradient(top, rgba(239,239,239,1) 0%, rgba(225,225,225,1) 6%, rgba(225,225,225,1) 24%, rgba(229,229,229,1) 94%, rgba(242,242,242,1) 100%);
  	background: linear-gradient(top, rgba(239,239,239,1) 0%, rgba(225,225,225,1) 6%, rgba(225,225,225,1) 24%, rgba(229,229,229,1) 94%, rgba(242,242,242,1) 100%);
  	box-shadow: inset 0 1px 0 0 rgba(0, 0, 0, 0.1);
  }
  label:hover i {
  	box-shadow: inset 0 -3px 3px 0 rgba(0, 0, 0, 0.1), inset 0 -1px 1px 0 rgba(255, 255, 255, 0.4), 0 2px 0 0 rgba(0, 0, 0, 0.3);
  }
  label:active i:before {
  	box-shadow: inset 0 1px 0 0 rgba(0, 0, 0, 0.3);
  }

  label:before {
  	content: "off";
  	margin-left: 40px;
  	text-transform: uppercase;
  	-webkit-transition: all 200ms ease;
  	-moz-transition: all 200ms ease;
  	-o-transition: all 200ms ease;
  	-ms-transition: all 200ms ease;
  	transition: all 200ms ease;
  }
  input[type=checkbox]:checked ~ label:before {
  	content: "on";
  	text-transform: uppercase;
  	margin-right: 30px;
  	margin-left: 19px;
  }
  input[type=checkbox]:checked ~ label{
  	background: rgb(141,173,51);
  	background: -webkit-radial-gradient(center, ellipse cover, rgba(141,173,51,1) 0%, rgba(146,178,55,1) 24%, rgba(157,187,64,1) 55%, rgba(166,194,78,1) 100%);
  	background: -moz-radial-gradient(center, ellipse cover, rgba(141,173,51,1) 0%, rgba(146,178,55,1) 24%, rgba(157,187,64,1) 55%, rgba(166,194,78,1) 100%);
  	background: -o-radial-gradient(center, ellipse cover, rgba(141,173,51,1) 0%, rgba(146,178,55,1) 24%, rgba(157,187,64,1) 55%, rgba(166,194,78,1) 100%);
  	background: -ms-radial-gradient(center, ellipse cover, rgba(141,173,51,1) 0%, rgba(146,178,55,1) 24%, rgba(157,187,64,1) 55%, rgba(166,194,78,1) 100%);
  	background: radial-gradient(center, ellipse cover, rgba(141,173,51,1) 0%, rgba(146,178,55,1) 24%, rgba(157,187,64,1) 55%, rgba(166,194,78,1) 100%);
  }
  input[type=checkbox]:checked ~ label i {
  	right: -6px;
  }
  </style>
</head>
<body>
  <!-- filters panel -->
  <input type="checkbox" name="toggle" id="toggle" />
  <label for="toggle"><i></i></label>
  <div class="hidden-filter-panel">
    <h1> hello, I'm a hidden hidden-filter-panel. You found it.</h1>
</div>
  <!-- filters panel -->
</body>
</html>
