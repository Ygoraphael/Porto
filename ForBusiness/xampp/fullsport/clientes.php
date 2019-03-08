<?php 
	include("classes.php");
?>
<?php 
	$query = "
		select * from cl where nome like '%".$_GET["s"]."%' or no like '%".$_GET["s"]."%' or ncont like '%".$_GET["s"]."% and estab = 0'
	";
	$dados = $SqlServer->GetData($query);
	echo "<ul>";
	foreach($dados as $linha) {
		?>
		<li onclick="PreencheCliente('<?php echo rawUrlEncode(json_encode($linha)); ?>')" class="search_line">
			<a href="#" style="color:black; font-weight:bold; font-size:0.8rem;">
				<img width="320" height="320" src="http://andreaslagerkvist.com/wp-content/uploads/2015/03/bw-mk-working-320x320.jpg" class="attachment-post-thumbnail wp-post-image" alt=""> 
				<?php echo $linha["nome"]; ?>
			</a>
			<a style="color:gray; font-size:0.8rem;">
				<?php echo $linha["morada"]; ?>, <?php echo $linha["codpost"]; ?>, <?php echo $linha["local"]; ?>
			</a>
		</li>
		<?php
	}
	echo "</ul>";
?>