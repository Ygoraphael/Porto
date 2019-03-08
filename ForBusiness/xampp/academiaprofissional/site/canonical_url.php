<?php

$uri = JURI::getInstance();

//[uri:protected] => http://localhost/academiaprofissional/index.php/adrbase 
//[scheme:protected] => http 
//[host:protected] => localhost 
//[port:protected] => 
//[user:protected] => 
//[pass:protected] => 
//[path:protected] => /academiaprofissional/index.php/adrbase 
//[query:protected] => 
//[fragment:protected] => 
//[vars:protected] => Array ( ) )
//http://localhost/academiaprofissional/index.php?option=com_content&view=article&id=143
//print_r($uri);

define("SEP", "/");
define("INT", "?");

$cur_option = $uri->getVar('option');
$cur_view = $uri->getVar('view');
$cur_path = substr($uri->getPath(), 1);
$cur_query = $uri->getQuery();

if (strlen(trim($cur_query)) > 0) {
    $cur_query = INT . $cur_query;
}

$current_url = $uri->toString();
$new_url = "http://www.";
$main_domain = "academiadoprofissional.com";

$strtofind_A = "index.php";
$strtofind_B = "/";
//$strtofind_A = "academiaprofissional/index.php";
//$strtofind_B = "academiaprofissional";

if (substr($cur_path, 0, strlen($strtofind_A)) == $strtofind_A) {
    $main_domain_processed = $main_domain . substr($cur_path, strlen($strtofind_A), strlen($cur_path));
} //else if (substr($cur_path, 0, strlen($strtofind_B)) == $strtofind_B) {
    //$main_domain_processed = $main_domain . substr($cur_path, strlen($strtofind_B), strlen($cur_path));
//} 
else {
    $main_domain_processed = $main_domain . SEP . $cur_path;
}

//verificar se nao é SEF
if (trim($cur_option) == "") {
    $new_url = $new_url . $main_domain_processed . $cur_query;
} else {
    if (strtoupper(trim($cur_option)) == "COM_CONTENT") {
        if (strtoupper(trim($cur_view)) == "ARTICLE") {
            $cur_id = $uri->getVar('id');

            //get alias
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query->select($db->quoteName(array('alias')));
            $query->from($db->quoteName('#__content'));
            $query->where($db->quoteName('id') . ' = ' . $cur_id);
            $db->setQuery($query);
            $results = $db->loadObjectList();

            if (count($results)) {
                $new_url = $new_url . $main_domain . SEP . $results[0]->alias;
            } else {
                $new_url = $new_url . $main_domain_processed . $cur_query;
            }
        } else {
            $new_url = $new_url . $main_domain_processed . $cur_query;
        }
    } else if (strtoupper(trim($cur_option)) == "COM_JUMI") {
        if (strtoupper(trim($cur_view)) == "APPLICATION") {
            $cur_id = $uri->getVar('fileid');

            //get alias
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
            $query->select($db->quoteName(array('alias')));
            $query->from($db->quoteName('#__menu'));
            $query->where($db->quoteName('link') . ' LIKE ' . $db->quote('%option=com_jumi%'));
            $query->where($db->quoteName('link') . ' LIKE ' . $db->quote('%view=application%'));
            $query->where($db->quoteName('link') . ' LIKE ' . $db->quote('%fileid=' . $cur_id . '%'));
            $db->setQuery($query);
            $results = $db->loadObjectList();

            if (count($results)) {
                $new_url = $new_url . $main_domain . SEP . $results[0]->alias;
            } else {
                $new_url = $new_url . $main_domain_processed . $cur_query;
            }
        } else {
            $new_url = $new_url . $main_domain_processed . $cur_query;
        }
    } else {
        $new_url = $new_url . $main_domain_processed . $cur_query;
    }
}

$document = JFactory::getDocument();
$document->addHeadLink(htmlspecialchars($new_url), 'canonical');

//print_r($new_url);

//links demo
//http://localhost/academiaprofissional/index.php/component/search/?searchword=teste&searchphrase=all&Itemid=835
//http://localhost/academiaprofissional/index.php/inscricao-individual
//http://localhost/academiaprofissional/index.php?option=com_content&view=article&id=143
//http://localhost/academiaprofissional/index.php/esclarecimentos-gerais-capacidade-profissional
//http://localhost/academiaprofissional/esclarecimentos-gerais-capacidade-profissional
//http://localhost/academiaprofissional/?option=com_jumi&view=application&fileid=10 --nao existe
//http://localhost/academiaprofissional/?option=com_jumi&view=application&fileid=18 -- existe

