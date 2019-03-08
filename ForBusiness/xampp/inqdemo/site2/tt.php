<html>
<head>

<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css">

<style>
label{display:inline-block;width:100px;margin-bottom:10px;}
</style>
 
 
<title>Adicionar Ação</title>
</head>
<body>
 


<form method="post" action="insert_acoes.php" id="add_acoes">


<?php

    include 'db_config.php';

$connect=new connect($servername,$username,$password,$dbname);

class connect{
     function __construct($host,$user,$password,$db_name){
        mysql_connect($host,$user,$password) or die("Connection error");
        mysql_select_db($db_name);
        $error=mysql_error();
        if (!empty($error))
        {
            echo $error;
        }
    }
}
$query=mysql_query("SELECT ID, NomeCurso FROM cursos ORDER BY ID");         
?>

<label>Referente ao curso:</label>
<?php
    include 'db_config.php';
?>

<select name="RefCurso">
    <?php 
    $sql = mysql_query("SELECT ID, NomeCurso, CC FROM cursos");
    while ($row = mysql_fetch_array($sql)){
    echo "<option value=".$row['CC'].">" . $row['ID'] . '.' . $row['NomeCurso']."</option>";}
    ?>

</select>    
<br />
<label>Código da Ação</label>
<textarea form ="add_acoes" name="NomeAcao" id="NomeAcao" cols="35" rows="4" wrap="soft" required=""></textarea>
<br />
<label>Data Inicio</label>
<input type="date" name="DataInicio" required="">
<br />
<label>Data Fim</label>
<input type="date" name="DataFim" required="">
<br />
<label>Sessões</label>
<textarea form ="add_acoes" name="Sessoes" id="Sessoes" cols="35" rows="4" wrap="soft" required=""></textarea>
<br />
<label>Cronograma</label>
<textarea form ="add_acoes" name="Horario" id="Horario" cols="35" rows="4" wrap="soft" required=""></textarea>
<br />
<label>Local</label>
<textarea form ="add_acoes" name="Localidade" id="Localidade" cols="35" rows="4" wrap="soft" required=""></textarea>
<br />
<label>Morada</label>
<textarea form ="add_acoes" name="Morada" id="Morada" cols="35" rows="4" wrap="soft" required=""></textarea>
<br />
<label>Formato</label>
<textarea form ="add_acoes" name="Formato" id="Formato" cols="35" rows="4" wrap="soft" required=""></textarea>
<br />
<label>Informações Adicionais (Ação)</label>
<textarea form ="add_acoes" name="Info" id="Info" cols="35" rows="4" wrap="soft" required=""></textarea>
 
<br />
<input type="submit" value="Criar Ação">
</form>
 
<!--
<br>
 <a href="ler_db.php">Ver lista de Cursos adicionados (raw data)</a>
<br>  <a href="lista_cursos.php">Ver lista de Cursos adicionados (refinada)</a>
 <br>
 <a href="inscricao.php">Inscrição</a>
 -->

  <br>
 <br>
 <br>
 <a href="curso_admin.php">Adicionar Cursos</a>
 <br>
<a href="lista_cursos.php">Lista de Cursos</a>
<br>
<a href="tt.php">Adicionar Ação</a>

</body>
</html>

