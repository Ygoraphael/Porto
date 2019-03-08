<?php

include_once 'db_config.php';

if( isset($_POST['CC']) ) {

    $db = JFactory::getDbo();
    $query = $db->getQuery(true);
    $fields = array();
    $fields_cursos = array('CC', 'Preco', 'NomeCurso', 'PublicoTarget', 'Conteudos', 'Objectivos', 'Contexto', 'acreditacoes', 'Info', 'requisitos', 'aba_nome', 'aba_descricao');
    
    foreach ($_POST as $key => $value) {
        if (in_array($key, $fields_cursos)) {
            $fields[] = $db->quoteName($key) . ' = ' . $db->quote($db->escape($value));
        }
    }
    
    if (isset($_POST['aba_visivel'])) {
        $fields[] = '`aba_visivel` = 1 ';
    } 
    else {
        $fields[] = '`aba_visivel` = 0 ';
    }

    $conditions = array(
        $db->quoteName('CC') . ' = ' . $db->quote($_POST['CC'])
    );
    $query->update($db->quoteName('cursos'))->set($fields)->where($conditions);
    
    $db->setQuery($query);
    
    $result = $db->execute();
    
    if ($result) {
        $_SESSION['msg']['type'] = 'alert-success';
        $_SESSION['msg']['msg'] = "Curso atualizado com sucesso!";
    } else {
        $_SESSION['msg']['type'] = 'alert-danger';
        $_SESSION['msg']['msg'] = "Nè´™o foi possivel atualizar esse curso";
    }
}