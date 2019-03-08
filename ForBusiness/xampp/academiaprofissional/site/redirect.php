<?php
include 'db_config.php';

if (isset($_POST['submit']) && isset($_POST['formid'])) {

    $query = $db->getQuery(true);
    $query->select('*, w2auh_juform_forms.id idform');
    $query->from('w2auh_juform_forms');
    $query->where($db->quoteName('w2auh_juform_forms.published'). ' = 1 ');

    $db->setQuery($query);
    $resultsForms = $db->loadAssocList();
    ///////////////////////////////////////////////////////

    foreach ($resultsForms as $linha) {
        if($_POST['formid']==$linha['idform'] ) {
            
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query->select('w2auh_juform_fields.caption,w2auh_juform_fields.form_id, w2auh_juform_fields.plugin_id, w2auh_juform_plugins.title as Plugin_Title,w2auh_juform_fields.field_name,w2auh_juform_fields.predefined_values, w2auh_juform_forms.title AS Form_Title, w2auh_juform_forms.afterprocess_action_value AS afterprocess, w2auh_juform_forms.afterprocess_action AS afterprocessaction');
            $query->from('w2auh_juform_plugins,w2auh_juform_fields, w2auh_juform_forms');
            $query->where('w2auh_juform_fields.plugin_id = w2auh_juform_plugins.id AND w2auh_juform_fields.form_id = w2auh_juform_forms.id AND w2auh_juform_forms.published=1 AND w2auh_juform_fields.published=1 AND w2auh_juform_fields.form_id=' . $_POST['formid'] . ' ORDER BY w2auh_juform_fields.ordering');
            $db->setQuery($query);
            $resultsBAQ = $db->loadAssocList();
            
            $subHTML = '';
            $afterprocessaction = 0;
            if (!empty($_POST['submit'])) {
                foreach ($resultsBAQ as $BAQ1) {
                    $afterprocessaction = $BAQ1['afterprocessaction'];
                    $subHTML .= '<p>' . $BAQ1['field_name'] . ': ' . $_POST["f_" . $BAQ1['field_name']] . '</p>';
                }
                
                $localizacao = "";
                
                //pagina
                if( $linha['local']==4 ) {
                    $localizacao = "<p>Localização do Formulário: Página " . $linha['title'] . "</p>";
                }
                //novidades
                else if ( $linha['local']==3 ) {
                    $localizacao = "<p>Localização do Formulário: Página Novidades</p>";
                }
                //apresentacao curso
                else if ( $linha['local']==2 ) {
                    $query = $db->getQuery(true);
                    $query->select('*');
                    $query->from($db->quoteName('cursos'));
                    $query->where($db->quoteName('ID') . ' = ' . $linha['curso']);
            
                    $db->setQuery($query);
                    $dadosCursos = $db->loadAssocList();
                    foreach( $dadosCursos as $dadosCurso ) {
                        $localizacao = "Localização do Formulário: Apresentação do Curso -> ".str_replace(array('<p>','</p>'), '', $dadosCurso['NomeCurso']);
                    }
                }
                //nova aba
                else if ( $linha['local']==1 ) {
                    $query = $db->getQuery(true);
                    $query->select('*');
                    $query->from($db->quoteName('cursos'));
                    $query->where($db->quoteName('ID') . ' = ' . $linha['curso']);
            
                    $db->setQuery($query);
                    $dadosCursos = $db->loadAssocList();
                    foreach( $dadosCursos as $dadosCurso ) {
                        $localizacao = "Localização do Formulário: Nova Aba -> ".str_replace(array('<p>','</p>'), '', $dadosCurso['NomeCurso']);
                    }
                }
                
                $html = "<h3>Preenchimento de Formulário</h3><hr>" . $subHTML . $localizacao;
                sendEmail("Preenchimento de Formulário no Site ADP", $html, ADP_EMAIL, "Academia do Profissional", ADP_EMAIL2, "Academia do Profissional");
            ?>
            <script>
                window.location.replace("http://academiadoprofissional.com/<?= 'index.php?option=com_content&view=article&id=' . $afterprocessaction ?>");
            </script>
            <?php
            }
        }
    }
}

?>