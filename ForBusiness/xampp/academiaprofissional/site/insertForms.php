<?php 
    if(!@include_once('db_config.php')) {
        include_once 'db_config.php';
    }
    
    $db = JFactory::getDbo();

    $query = $db->getQuery(true);
    $query->select('w2auh_juform_fields.caption,w2auh_juform_fields.form_id, w2auh_juform_fields.plugin_id, w2auh_juform_plugins.title as Plugin_Title,w2auh_juform_fields.field_name,w2auh_juform_fields.predefined_values, w2auh_juform_forms.title AS Form_Title, w2auh_juform_forms.afterprocess_action_value AS afterprocess, w2auh_juform_forms.afterprocess_action AS afterprocessaction');
    $query->from('w2auh_juform_plugins,w2auh_juform_fields, w2auh_juform_forms');
    $query->where('w2auh_juform_fields.plugin_id = w2auh_juform_plugins.id AND w2auh_juform_fields.form_id = w2auh_juform_forms.id AND w2auh_juform_forms.published=1 AND w2auh_juform_fields.published=1 ORDER BY w2auh_juform_fields.ordering');
    $db->setQuery($query);
    $resultsBAQ = $db->loadAssocList();

    $query = $db->getQuery(true);
    $query->select('*, w2auh_juform_forms.id idform');
    $query->from('w2auh_juform_forms');
    $query->where($db->quoteName('w2auh_juform_forms.published'). ' = 1 ');

    $db->setQuery($query);
    $resultsForms = $db->loadAssocList();
    ///////////////////////////////////////////////////////
    $app = JFactory::getApplication();

    if( is_object($app->getMenu()->getActive()) ) {
        $menu_item = $app->getMenu()->getActive()->id;                                  

        foreach ($resultsForms as $linha) {
            if($linha['local']==4 and $menu_item==$linha['pagina'] ){  
                addForms($linha, $resultsBAQ, 'Página '.$linha['title']);
            }
        }
    }
?>