<?php
	$lang = JFactory::getLanguage();
	$db = JFactory::getDbo();
	$query = $db->getQuery(true);
	$query->select('distinct modalidade');
	$query->from($db->quoteName('#__fastseller_product_type_4'));
	$query->order('modalidade ASC');
	$db->setQuery($query);
	$results = $db->loadObjectList();

	echo '<div class="grid_maincat cat_modalidade">';
/*for each en */
	foreach ($results as $row) {

		if ( $lang->getTag() == "en-GB"s) {
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('en_gb')));
			$query->from($db->quoteName('#__filtros'));
			$query->where($db->quoteName('pt_pt') . ' = '. $db->quote($row->modalidade) . ' AND ' . $db->quoteName('nome') . ' = ' . $db->quote('modalidade'));

			$db->setQuery($query);
			$db->execute();
			$num_rows = $db->getNumRows();

			if( $num_rows > 0 ) {
				$result = $db->loadRowList();
				?>
					<figure class="effect-honey" onclick="ModChoose('<?php echo $row->modalidade; ?>');">
						<img src="imagens/cats/4.jpg" alt="<?php echo $result[0][0]; ?>"/>
						<figcaption>
							<h2><?php echo $result[0][0]; ?></h2>
						</figcaption>
					</figure>
				<?php
			}
			else {
				?>
					<figure class="effect-honey" onclick="ModChoose('<?php echo $row->modalidade; ?>');">
						<img src="imagens/cats/4.jpg" alt="<?php echo $row->modalidade; ?>"/>
						<figcaption>
							<h2><?php echo $row->modalidade; ?></h2>
						</figcaption>
					</figure>
				<?php
			}
		}
		/* end of if gb */
		else {
			?>
			<figure class="effect-honey" onclick="ModChoose('<?php echo $row->modalidade; ?>');">
				<img src="imagens/cats/4.jpg" alt="<?php echo $row->modalidade; ?>"/>
				<figcaption>
					<h2><?php echo $row->modalidade; ?></h2>
				</figcaption>
			</figure>
			<?php
		}
	}

	echo '</div>';
	?>

	<div class="grid_maincat cat_genero">
		<figure class="effect-honey" onclick="GenChoose('Male');">
			<img src="imagens/cats/4.jpg" alt="Male"/>
			<figcaption>
				<h2>Male</h2>
			</figcaption>
		</figure>
		<figure class="effect-honey" onclick="GenChoose('Female');">
			<img src="imagens/cats/4.jpg" alt="Female"/>
			<figcaption>
				<h2>Female</h2>
			</figcaption>
		</figure>
		<figure class="effect-honey" onclick="GenChoose('Male%7CFemale');">
			<img src="imagens/cats/4.jpg" alt="Unisex"/>
			<figcaption>
				<h2>Unisex</h2>
			</figcaption>
		</figure>
	</div>

<?php
	$query = $db->getQuery(true);
	$query->select('distinct categoria');
	$query->from($db->quoteName('#__fastseller_product_type_4'));
	$query->order('categoria ASC');
	$db->setQuery($query);
	$results = $db->loadObjectList();

	echo '<div class="grid_maincat cat_linha">';

	foreach ($results as $row) {

		if ( $lang->getTag() == "en-GB" ) {
			$query = $db->getQuery(true);
			$query->select($db->quoteName(array('en_gb')));
			$query->from($db->quoteName('#__filtros'));
			$query->where($db->quoteName('pt_pt') . ' = '. $db->quote($row->categoria) . ' AND ' . $db->quoteName('nome') . ' = ' . $db->quote('categoria'));

			$db->setQuery($query);
			$db->execute();
			$num_rows = $db->getNumRows();

			if( $num_rows > 0 ) {
				$result = $db->loadRowList();
				?>
					<figure class="effect-honey" onclick="LinChoose('<?php echo $row->categoria; ?>');">
						<img src="imagens/cats/4.jpg" alt="<?php echo $result[0][0]; ?>"/>
						<figcaption>
							<h2><?php echo $result[0][0]; ?></h2>
						</figcaption>
					</figure>
				<?php
			}
			else {
				?>
					<figure class="effect-honey" onclick="LinChoose('<?php echo $row->categoria; ?>');">
						<img src="imagens/cats/4.jpg" alt="<?php echo $row->categoria; ?>"/>
						<figcaption>
							<h2><?php echo $row->categoria; ?></h2>
						</figcaption>
					</figure>
				<?php
			}
		}
		else {
			?>
			<figure class="effect-honey" onclick="LinChoose('<?php echo $row->categoria; ?>');">
				<img src="imagens/cats/4.jpg" alt="<?php echo $row->categoria; ?>"/>
				<figcaption>
					<h2><?php echo $row->categoria; ?></h2>
				</figcaption>
			</figure>
			<?php
		}
	}

	echo '</div>';
?>

	<input type="hidden" id="mod_val" value=""/>
	<input type="hidden" id="gen_val" value=""/>

	<script>
		function ModChoose( obj ) {
			jQuery('#mod_val').val( obj );
			jQuery('.cat_modalidade').hide( "slow", function() {});
			jQuery('.cat_genero').show( "slow", function() {});
		}

		function GenChoose( obj ) {
			jQuery('#gen_val').val( obj );
			jQuery('.cat_genero').hide( "slow", function() {});
			jQuery('.cat_linha').show( "slow", function() {});
		}

		function LinChoose( obj ) {
			<?php
			$lang = JFactory::getLanguage();
			if ( $lang->getTag() == "en-GB" ){
			?>
				window.location.replace("products/search?Modalidade=" + jQuery('#mod_val').val().toUpperCase() + "&Genero=" + jQuery('#gen_val').val().toUpperCase() + "&Categoria=" + obj.toUpperCase() );
			<?php
			}
			else {
			?>
				window.location.replace("produtos/search?Modalidade=" + jQuery('#mod_val').val().toUpperCase() + "&Genero=" + jQuery('#gen_val').val().toUpperCase() + "&Categoria=" + obj.toUpperCase() );
			<?php
			}
			?>
		}
	</script>
