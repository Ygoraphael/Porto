<!DOCTYPE html>
<html lang="en">
<head>
	<?php include("header.php"); ?>
</head>

<?php
$code = get_code_data($_GET['id']);
?>
<script type="text/javascript" src="js/ace/ace.js" charset="utf-8"></script>
<div style="padding-left:10px; padding-right:10px; padding-top:10px; padding-bottom:30px;">
<style>
/* PurelyCSS Elegance Buttons
-------------------------------------------------------------- */
.purelycss_elegance_button{
font-family:Arial,Helvetica,sans-serif;
text-transform:uppercase;
text-decoration:none;
display:inline-block;
text-align:center;
margin:0 5px 5px 0;
padding:10px 50px;
font-size:12px;
line-height:15px;
letter-spacing:2px;
border:2px solid #111;
background:#111;
color:#f8f8f8;
background-image:-webkit-gradient(linear,left top,left bottom,color-stop(0,rgba(255,255,255,0.15)),color-stop(1,rgba(0,0,0,0.1)));
background-image:-webkit-linear-gradient(top,rgba(255,255,255,0.15),rgba(255,255,255,0.01));
background-image:-moz-linear-gradient(top,rgba(255,255,255,0.15),rgba(255,255,255,0.01));
background-image:-o-linear-gradient(top,rgba(255,255,255,0.15),rgba(255,255,255,0.01));
background-image:linear-gradient(top,rgba(255,255,255,0.15),rgba(255,255,255,0.01));
-webkit-box-shadow:1px 1px 0 rgba(255,255,255,0.4) inset,-1px -1px 0 rgba(255,255,255,0.4) inset,1px 0 0 rgba(0,0,0,.1);
-moz-box-shadow:1px 1px 0 rgba(255,255,255,0.4) inset,-1px -1px 0 rgba(255,255,255,0.4) inset,1px 0 0 rgba(0,0,0,.1);
box-shadow:1px 1px 0 rgba(255,255,255,0.4) inset,-1px -1px 0 rgba(255,255,255,0.4) inset,1px 0 0 rgba(0,0,0,.1);
-webkit-transition:all .5s ease;
-moz-transition:all .5s ease;
-o-transition:all .5s ease;
transition:all .5s ease;
-webkit-border-radius:2px;
-moz-border-radius:2px;
border-radius:2px;}
.purelycss_elegance_button.size_small{font-size:10px;padding:6px 25px;}
.purelycss_elegance_button.size_large{font-size:15px;padding:15px 70px;}
.purelycss_elegance_button:hover{text-decoration:none;cursor:pointer;color:#fff;opacity:.7;}
.purelycss_elegance_button:active{position:relative;top:1px;}
 
/* Sizes / Alignments
-------------------------------------------------------------- */
.size_small{padding:8px 20px;font-size:10px;line-height:10px;}
.size_large{padding:15px 40px;font-size:17px;line-height:20px;}
.align_left{float:left;margin:0 15px 5px 0;}
.align_right{float:right;margin:0 0 5px 15px;}
.align_full{clear:both;display:block;margin:5px 0;}
 
/* Colors / Hovers
-------------------------------------------------------------- */
.color_red,.hover_red:hover{background-color:#700;border-color:#700;opacity:1;}
.color_orange,.hover_orange:hover{background-color:#e98813;border-color:#e98813;opacity:1;}
.color_yellow,.hover_yellow:hover{background-color:#f7c808;border-color:#f7c808;opacity:1;}
.color_green,.hover_green:hover{background-color:#74941f;border-color:#74941f;opacity:1;}
.color_olive,.hover_olive:hover{background-color:#3a491a;border-color:#3a491a;opacity:1;}
.color_teal,.hover_teal:hover{background-color:#089;border-color:#089;opacity:1;}
.color_blue,.hover_blue:hover{background-color:#00437f;border-color:#00437f;opacity:1;}
.color_deepblue,.hover_deepblue:hover{background-color:#092334;border-color:#092334;opacity:1;}
.color_purple,.hover_purple:hover{background-color:#4b2c5a;border-color:#4b2c5a;opacity:1;}
.color_hotpink,.hover_hotpink:hover{background-color:#bc006e;border-color:#bc006e;opacity:1;}
.color_slategrey,.hover_slategrey:hover{background-color:#3b424a;border-color:#3b424a;opacity:1;}
.color_mauve,.hover_mauve:hover{background-color:#625b56;border-color:#625b56;opacity:1;}
.color_pearl,.hover_pearl:hover{background-color:#ab998f;border-color:#ab998f;opacity:1;}
.color_steelblue,.hover_steelblue:hover{background-color:#788794;border-color:#788794;opacity:1;}
.color_mossgreen,.hover_mossgreen:hover{background-color:#717a75;border-color:#717a75;opacity:1;}
.color_wheat,.hover_wheat:hover{background-color:#79745d;border-color:#79745d;opacity:1;}
.color_coffee,.hover_coffee:hover{background-color:#372e25;border-color:#372e25;opacity:1;}
.color_copper,.hover_copper:hover{background-color:#6b3c02;border-color:#6b3c02;opacity:1;}
.color_silver,.hover_silver:hover{background-color:#666;border-color:#666;opacity:1;}
.color_black,.hover_black:hover{background-color:#111;border-color:#111;opacity:1;}

#editor {
        position: absolute;
        width: 99%;
        height: 90%;
    }
</style>

<script language="javascript" type="text/javascript">
	function grava_node()
	{
		$.ajax({
			type: "POST",
			url: "funcoes_gerais.php",
			data: { "action" : "update_code('<?php echo $_GET['id']; ?>', '" + editor.getValue() + "','" + jQuery("#syntax_option").val() + "');"}, 
			success: function(msg) {
				alert("Alteração efectuada com sucesso!");
			}
		});
	}
</script>

	<div id="topo">
		<img onclick="grava_node();" src="img/save_icon.png" />
		<select id='syntax_option'>
			<option></option>
			<option value="c_cpp">C/C++</option>
			<option value="csharp">C#</option>
			<option value="css">CSS</option>
			<option value="haskell">Haskell</option>
			<option value="html">HTML</option>
			<option value="ini">Ini</option>
			<option value="java">Java</option>
			<option value="javascript">Javascript</option>
			<option value="json">Json</option>
			<option value="mysql">MySQL</option>
			<option value="perl">Perl</option>
			<option value="php">PHP</option>
			<option value="prolog">Prolog</option>
			<option value="properties">Propriedades</option>
			<option value="python">Python</option>
			<option value="sql">SQL</option>
			<option value="vbscript">VBScript</option>
			<option value="xml">XML</option>
		</select>
		
		<script>
			jQuery("#syntax_option").change(function(){
				editor.getSession().setMode("ace/mode/" + jQuery(this).val());
			});
		</script>
		
		<button type="submit" style="float:right;" class="btn btn-primary" onclick="window.history.go(-1); return false;"><i class="white halflings-icon circle-arrow-left"></i> Voltar</button>
	</div>
	<?php
		if( sizeof($code) > 0) {
			echo "
				<div id='editor'>".base64_decode($code["text"])."</div>";
		}
		else {
			echo "<center><span style='font-size:20px;'>Não existem dados para apresentar.</span></center>";
		}

	?>
	<script language="javascript" type="text/javascript">
		var editor = ace.edit("editor");
		editor.setTheme("ace/theme/eclipse");
		editor.getSession().setMode("ace/mode/<?php echo $code["syntax"]; ?>");
		
		jQuery("#syntax_option").val('<?php echo $code["syntax"]; ?>');
		</script>
</div>
</body>
</html>
