<?php
	function clean($string) {
	   $string = str_replace(' ', '_', $string); // Replaces all spaces with hyphens.

	   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
	}
?>

<?php

define( '_JEXEC', 1 ); 
define( '_VALID_MOS', 1 ); 
define( 'JPATH_BASE', realpath(dirname(__FILE__))); 
define( 'DS', DIRECTORY_SEPARATOR ); 
require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' ); 
require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' ); 
$mainframe =& JFactory::getApplication('site'); 
$mainframe->initialise(); 

$jinput = JFactory::getApplication()->input;
$lang = JFactory::getLanguage();
$db = JFactory::getDbo();

$modalidade = $jinput->post->get('modalidade', '', 'STRING');
$genero = $jinput->post->get('genero', '', 'STRING');
$categoria = $jinput->post->get('categoria', '', 'STRING');

if( $modalidade <> '' and $genero == '' and $categoria == '' ) {	
	$query = $db->getQuery(true);
	$query->select('distinct genero');
	$query->from($db->quoteName('#__fastseller_product_type_4'));
	$query->where($db->quoteName('Modalidade') . ' = '. $db->quote($modalidade));
	$db->setQuery($query);
	$results = $db->loadObjectList();
	
	$unis=0;
	foreach ($results as $row) {
		if( $row->genero == "MASCULINO;FEMININO" )
			$unis = 1;
	}
	
	echo '<div class="grid_maincat cat_genero clear clearfix">';
	
	if( $unis ) {
		if ( $lang->getTag() == "en-GB" ) {
		?>
			<figure class="effect-honey" onclick="GenChoose('MASCULINO', 'MALE');">
				<img src="<?php echo JURI::base(); ?>imagens/cats/MASCULINO.jpg" alt="MALE"/>
				<figcaption>
					<h2>MALE</h2>
				</figcaption>
			</figure>
			<figure class="effect-honey" onclick="GenChoose('FEMININO', 'FEMALE');">
				<img src="<?php echo JURI::base(); ?>imagens/cats/FEMININO.jpg" alt="FEMALE"/>
				<figcaption>
					<h2>FEMALE</h2>
				</figcaption>
			</figure>
		<?php
		}
		else {
		?>
			<figure class="effect-honey" onclick="GenChoose('MASCULINO', 'MASCULINO');">
				<img src="<?php echo JURI::base(); ?>imagens/cats/MASCULINO.jpg" alt="MASCULINO"/>
				<figcaption>
					<h2>MASCULINO</h2>
				</figcaption>
			</figure>
			<figure class="effect-honey" onclick="GenChoose('FEMININO', 'FEMININO');">
				<img src="<?php echo JURI::base(); ?>imagens/cats/FEMININO.jpg" alt="FEMININO"/>
				<figcaption>
					<h2>FEMININO</h2>
				</figcaption>
			</figure>
		<?php
		}
	}
	else {
		foreach ($results as $row) {
			
			if ( $lang->getTag() == "en-GB" ) {
				$query = $db->getQuery(true);
				$query->select($db->quoteName(array('en_gb')));
				$query->from($db->quoteName('#__filtros'));
				$query->where($db->quoteName('pt_pt') . ' LIKE "%'. $row->genero . '%" AND ' . $db->quoteName('nome') . ' = ' . $db->quote('genero'));
				
				$db->setQuery($query);
				$db->execute();
				$num_rows = $db->getNumRows();
				
				if( $num_rows > 0 ) {
					$result = $db->loadRowList();
					?>
						<figure class="effect-honey" onclick="GenChoose('<?php echo $row->genero; ?>', '<?php echo $result[0][0]; ?>');">
							<img src="<?php echo JURI::base(); ?>imagens/cats/<?php echo clean($row->genero); ?>.jpg".jpg" alt="<?php echo $result[0][0]; ?>"/>
							<figcaption>
								<h2><?php echo $result[0][0]; ?></h2>
							</figcaption>
						</figure>
					<?php
				}
				else {
					?>
						<figure class="effect-honey" onclick="GenChoose('<?php echo $row->genero; ?>', '<?php echo $row->genero; ?>');">
							<img src="<?php echo JURI::base(); ?>imagens/cats/<?php echo clean($row->genero); ?>.jpg" alt="<?php echo $row->genero; ?>"/>
							<figcaption>
								<h2><?php echo $row->genero; ?></h2>
							</figcaption>
						</figure>
					<?php
				}
			}
			else {
				?>
				<figure class="effect-honey" onclick="GenChoose('<?php echo $row->genero; ?>', '<?php echo $row->genero; ?>');">
					<img src="<?php echo JURI::base(); ?>imagens/cats/<?php echo clean($row->genero); ?>.jpg" alt="<?php echo $row->genero; ?>"/>
					<figcaption>
						<h2><?php echo $row->genero; ?></h2>
					</figcaption>
				</figure>
				<?php
			}
		}
	}
	echo '<input type="hidden" value="'.$modalidade.'" name="modalidade_val" />';
	
	echo '</div>';
}
else if( $modalidade <> '' and $genero <> '' and $categoria == '' ) {
	$query = $db->getQuery(true);
	$query->select('distinct categoria');
	$query->from($db->quoteName('#__fastseller_product_type_4'));
	$query->where($db->quoteName('Modalidade') . ' = '. $db->quote($modalidade) . ' AND ' . $db->quoteName('Genero') . ' = '. $db->quote($genero));
	$db->setQuery($query);
	$results = $db->loadObjectList();
	
	echo '<div class="grid_maincat cat_categoria clear clearfix">';
	
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
					<figure class="effect-honey" onclick="CatChoose('<?php echo $row->categoria; ?>');">
						<img src="<?php echo JURI::base(); ?>imagens/cats/<?php echo clean($row->categoria); ?>.jpg" alt="<?php echo $result[0][0]; ?>"/>
						<figcaption>
							<h2><?php echo $result[0][0]; ?></h2>
						</figcaption>
					</figure>
				<?php
			}
			else {
				?>
					<figure class="effect-honey" onclick="CatChoose('<?php echo $row->categoria; ?>');">
						<img src="<?php echo JURI::base(); ?>imagens/cats/<?php echo clean($row->categoria); ?>.jpg" alt="<?php echo $row->categoria; ?>"/>
						<figcaption>
							<h2><?php echo $row->categoria; ?></h2>
						</figcaption>
					</figure>
				<?php
			}
		}
		else {
			?>
			<figure class="effect-honey" onclick="CatChoose('<?php echo $row->categoria; ?>');">
				<img src="<?php echo JURI::base(); ?>imagens/cats/<?php echo clean($row->categoria); ?>.jpg" alt="<?php echo $row->categoria; ?>"/>
				<figcaption>
					<h2><?php echo $row->categoria; ?></h2>
				</figcaption>
			</figure>
			<?php
		}
	}
	
	echo '<input type="hidden" value="'.$modalidade.'" name="modalidade_val" />';
	if( $genero == "MASCULINO;FEMININO" ) {
		echo '<input type="hidden" value="MASCULINO%7CFEMININO" name="genero_val" />';
	}
	else {
		echo '<input type="hidden" value="'.$genero.'" name="genero_val" />';
	}
	
	echo '</div>';
}

?>