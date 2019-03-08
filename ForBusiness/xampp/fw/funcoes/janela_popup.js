<!--
function HideContent(d) {
	if(d.length < 1) { return; }
	document.getElementById(d).style.display = "none";
}

function ShowContent(d,larg,alt) {
if(d.length < 1) { return; }
	//var p_left = (document.body.offsetWidth-larg)/2;
	//var p_top = (document.body.offsetHeight-alt)/2;
	document.getElementById(d).style.width = larg;
	document.getElementById(d).style.height = alt;
	document.getElementById(d).style.display = "block";
	//document.getElementById(d).style.left = p_left + "px";
	//document.getElementById(d).style.top = p_top + "px";
}
function ReverseContentDisplay(d) {
	if(d.length < 1) { return; }
	if(document.getElementById(d).style.display == "none") { document.getElementById(d).style.display = "block"; }
	else { document.getElementById(d).style.display = "none"; }
}

<!-- COM abertura progressiva !-->

var hh = 0;
var inter;
	if (navigator.userAgent.indexOf('MSIE') !=-1)
	{
		var velocidade = 10;
	}else{
		var velocidade = 10;	
	}
function deteta_estado(alt, id) {
	obj = document.getElementById("div_"+id);
	if (obj.style.display == "none") {
		hh = 0;
		inter=setInterval('ShowBox('+alt+', '+id+')','1');return false;
	}else{
		hh = parseInt(alt);
		inter=setInterval('HideBox('+alt+', '+id+')','1');return false;
	}
}
function ShowBox(alt, id) {
		if (hh == alt) { clearInterval(inter); return; }
		obj = document.getElementById("div_"+id);
		obj.style.display = "block";
		hh+=velocidade;
		obj.style.height = hh + 'px';
		
}
function HideBox(alt, id)
{
		obj = document.getElementById("div_"+id);
		if (hh < 1) { obj.style.display = "none"; clearInterval(inter); return; }
		
		hh-=velocidade*2;
		obj.style.height = hh + 'px';

}
//-->