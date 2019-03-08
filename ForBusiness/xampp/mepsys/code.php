<!DOCTYPE html>
<html lang="pt">
<head>
	<?php include("header.php"); ?>
</head>

<body>
		<!-- start: Header -->
	<?php include("nav_bar.php"); ?>
	<!-- start: Header -->
	
		<div class="container-fluid-full">
			<div class="row-fluid">
				<!-- start: Main Menu -->
				<?php include("menu.php"); ?>
				<!-- end: Main Menu -->
				
				<noscript>
					<div class="alert alert-block span10">
						<h4 class="alert-heading">Warning!</h4>
						<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
					</div>
				</noscript>
				
				<!-- start: Content -->
				<div id="content" class="span10">
					<?php 
						$current_page = "Enciclopédia";
						include("breadcrumbs.php"); 
					
					?>
					<div class="row-fluid"><div class="box-content">
					<button class="btn btn-primary"><i class="white halflings-icon plus-sign"></i> Novo</button>
					<button class="btn btn-primary" onclick='toggleWiggle("node", ""); toggleRemoveNode(".node");'><i class="white halflings-icon minus-sign"></i> Eliminar</button>
					</div></div>
					<?php
					
						$data = get_main_dic();
						$cur_node = 1;
						$limit = 8;
						
						foreach($data as $node) {
							if( $cur_node == 1 ) { ?> <div class="row-fluid"> <div class="box-content"> <?php }
							?>
							<a class="quick-button green span2 node" href="code2.php?i=<?php echo $node["id"]; ?>">
								<p style="color:white; font-size:0.6vw;"><?php echo $node["nome"] ?></p>
							</a>
							<?php
							$cur_node++;
							if( $cur_node == $limit-1 ) { ?> </div> </div> <?php $cur_node = 1;}
						}
						
					?>
				</div>
			</div><!--/.fluid-container-->
				<!-- end: Content -->
		</div><!--/#content.span10-->	
	<div class="clearfix"></div>
	<script>
		function toggleRemoveNode(obj) {
			$( classe ).on( "click", function() {
				alert( "Handler for .click() called." );
			});
		}
	</script>
	<?php include("footer.php"); ?>
	
	<!-- start: JavaScript-->
	<?php include("footer_code.php"); ?>
	<!-- end: JavaScript-->
</body>
</html>
