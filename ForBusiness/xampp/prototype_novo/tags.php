<div class="col-lg-12 nopadding">
	<a class="list-group-item" style='background:#fee202; margin-bottom: -10px; border-radius: 0px;'><span class="ftype01">Tags</span></a>
</div>
<div class="tags" >
	<?php
		$lang = JFactory::getLanguage();
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('*');
		$query->from($db->quoteName('#__content'));
		$query->where($db->quoteName('catid') . ' = 11');
		$query->where($db->quoteName('state') . ' = 0');
		$query->where($db->quoteName('language') . ' = ' . $db->quote($lang->getTag()));
		$query->order('created DESC');
		$db->setQuery($query,0,1);
		$results = $db->loadObjectList();
		foreach( $results as $tags ) {
			$tags_text = str_replace('<p>', '', $tags->introtext);
			$tags_text = str_replace('</p>', '', $tags_text);
			$tags_text = str_replace('<br>', '', $tags_text);
			$tags_text = str_replace('</br>', '', $tags_text);
			$tags_text = str_replace('<br/>', '', $tags_text);
			$tags_text = str_replace('<p> </p>', '', $tags_text);
			$tags_text = str_replace('<p></p>', '', $tags_text);
			
			$tags_text_ar = explode("\n",$tags_text);
			foreach( $tags_text_ar as $tags ) {
				$tmp = explode('|',$tags);
			?>
				 <a class="primary" href="<?php echo $tmp[1]; ?>"><?php echo $tmp[0]; ?></a> 
			<?php
			}
		}
	?>
	<div class="clearfix"> </div>

</div>

            