<?php
	function clean($string) {
	   $string = str_replace(' ', '_', $string); // Replaces all spaces with hyphens.

	   return preg_replace('/[^A-Za-z0-9-]/', '', $string); // Removes special chars.
	}
?>

<script>
	var barra_init = jQuery(".breadcrumbs").html() + ' &#8226; <a href="index.php">Home</a>';
	var barra_mod= "";
	var barra_gen= "";
</script>

<?php
	$lang = JFactory::getLanguage();
	$db = JFactory::getDbo();
	$query = $db->getQuery(true);
	$query->select('distinct genero');
	$query->from($db->quoteName('#__fastseller_product_type_4'));
	$query->order('genero ASC');
	$db->setQuery($query);
	$results = $db->loadObjectList();

	echo '<div class="ajaxcall">';
	echo '<div class="grid_maincat cat_genero clear clearfix">';

	foreach ($results as $row) {

		if ( $lang->getTag() == "en-GB" ) {
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('en_gb')));
			$query->from($db->quoteName('#__filtros'));
			$query->where($db->quoteName('pt_pt') . ' = '. $db->quote($row->genero) . ' AND ' . $db->quoteName('nome') . ' = ' . $db->quote('genero'));

			$db->setQuery($query);
			$db->execute();
			$num_rows = $db->getNumRows();

			if( $num_rows > 0 ) {
				$result = $db->loadRowList();
				?>
					<figure class="effect-honey hvr-grow" onclick="ModChoose('<?php echo $row->genero; ?>');">
						<img src="imagens/cats/<?php echo clean($row->genero); ?>.jpg" alt="<?php echo $result[0][0]; ?>"/>
						<figcaption>
							<h2><?php echo $result[0][0]; ?></h2>
						</figcaption>
					</figure>
				<?php
			}
			else {
				?>
					<figure class="effect-honey hvr-grow" onclick="ModChoose('<?php echo $row->genero; ?>');">
						<img src="imagens/cats/<?php echo clean($row->genero); ?>.jpg" alt="<?php echo $row->genero; ?>"/>
						<figcaption>
							<h2><?php echo $row->genero; ?></h2>
						</figcaption>
					</figure>
				<?php
			}
		}
	/*	end of if en */
						elseif ( $lang->getTag() == "es-ES" ) {
							$query = $db->getQuery(true);
							$query->select($db->quoteName(array('es_es')));
							$query->from($db->quoteName('#__filtros'));
							$query->where($db->quoteName('pt_pt') . ' = '. $db->quote($row->genero) . ' AND ' . $db->quoteName('nome') . ' = ' . $db->quote('genero'));

							$db->setQuery($query);
							$db->execute();
							$num_rows = $db->getNumRows();

							if( $num_rows > 0 ) {
								$result = $db->loadRowList();
								?>
									<figure class="effect-honey hvr-grow" onclick="ModChoose('<?php echo $row->genero; ?>');">
										<img src="imagens/cats/<?php echo clean($row->genero); ?>.jpg" alt="<?php echo $result[0][0]; ?>"/>
										<figcaption>
											<h2><?php echo $result[0][0]; ?></h2>
										</figcaption>
									</figure>
								<?php
							}
							else {
								?>
									<figure class="effect-honey hvr-grow" onclick="ModChoose('<?php echo $row->genero; ?>');">
										<img src="imagens/cats/<?php echo clean($row->genero); ?>.jpg" alt="<?php echo $row->genero; ?>"/>
										<figcaption>
											<h2><?php echo $row->genero; ?></h2>
										</figcaption>
									</figure>
								<?php
							}
						}
		else {
			?>
			<figure class="effect-honey hvr-grow" onclick="ModChoose('<?php echo $row->genero; ?>');">
				<img src="imagens/cats/<?php echo clean($row->genero); ?>.jpg" alt="<?php echo $row->genero; ?>"/>
				<figcaption>
					<h2><?php echo $row->genero; ?></h2>
				</figcaption>
			</figure>
			<?php
		}
	}

	echo '</div>';
	echo '</div>';
?>

	<script>
		function ModChoose( obj ) {

			barra_mod = obj;
			jQuery(".breadcrumbs").html( barra_init + ' >> ' + obj);

			jQuery.ajax({
				url : "<?php echo JURI::base(); ?>menu_filter.php",
				type: "POST",
				data : {"genero": obj },
				success: function(data, textStatus, jqXHR) {
					jQuery( ".ajaxcall" ).html( data );
				},
				error: function (jqXHR, textStatus, errorThrown) {
				}
			});

			// jQuery('.cat_genero').hide( "slow", function() {});
			// jQuery('.cat_genero').show( "slow", function() {});
			// jQuery('.cat_genero').addClass( "clear clearfix" )
		}

		function GenChoose( obj, text ) {

			barra_gen = obj;
			jQuery(".breadcrumbs").html( barra_init + ' >> ' + '<a onclick="ModChoose(barra_mod)" class="pathway">' + barra_mod + '</a>' + ' >> ' + text);

			jQuery.ajax({
				url : "<?php echo JURI::base(); ?>menu_filter.php",
				type: "POST",
				data : {"genero" : jQuery(" input[name='genero_val'] ").val(), "genero" : obj },
				success: function(data, textStatus, jqXHR) {
					jQuery( ".ajaxcall" ).html( data );
				},
				error: function (jqXHR, textStatus, errorThrown) {
				}
			});
			// jQuery('.cat_genero').hide( "slow", function() {});
			// jQuery('.cat_linha').show( "slow", function() {});
			// jQuery('.cat_linha').addClass( "clear clearfix" )
		}

		function CatChoose( obj ) {

			<?php
			$lang = JFactory::getLanguage();
			if ( $lang->getTag() == "en-GB" ){
			?>
				window.location.replace("products/search?genero=" + jQuery(" input[name='genero_val'] ").val().toUpperCase() + "&Genero=" + jQuery(" input[name='genero_val'] ").val().toUpperCase() + "&Categoria=" + obj.toUpperCase() );
			<?php
			}
			elseif ($lang->getTag() == "es-ES") {
				?>
				window.location.replace("productos/search?genero=" + jQuery(" input[name='genero_val'] ").val().toUpperCase() + "&Genero=" + jQuery(" input[name='genero_val'] ").val().toUpperCase() + "&Categoria=" + obj.toUpperCase() );
			<?php
			}
			else {
			?>
				window.location.replace("produtos/search?genero=" + jQuery(" input[name='genero_val'] ").val().toUpperCase() + "&Genero=" + jQuery(" input[name='genero_val'] ").val().toUpperCase() + "&Categoria=" + obj.toUpperCase() );
			<?php
			}
			?>
		}
	</script>
