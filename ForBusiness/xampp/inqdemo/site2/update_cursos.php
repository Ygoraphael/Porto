<html>
<head>

<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css">

<style>
label{display:inline-block;width:100px;margin-bottom:10px;}
</style>
 
 
<title>Atualizar Cursos</title>
</head>
<body>
 


<form method="post" action="update_cursos.php" id="update_cursos">


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
<label>Código do Curso</label>
<textarea form ="add_cursos" name="CC" id="CC" cols="35" rows="4" wrap="soft" ></textarea>
<br />
<label>Nome do Curso</label>
<textarea form ="add_cursos" name="NomeCurso" id="NomeCurso" cols="35" rows="4" wrap="soft" ></textarea>
<br />
<label>Descrição</label>
<textarea form ="add_cursos" name="Contexto" id="Contexto" cols="35" rows="4" wrap="soft" ></textarea>
<br />
<label>Objetivos do Curso</label>
<textarea form ="add_cursos" name="Objectivos" id="Objectivos" cols="35" rows="4" wrap="soft" ></textarea>
<br />
<label>Conteúdos Programáticos</label>
<textarea form ="add_cursos" name="Conteudos" id="Conteudos" cols="35" rows="4" wrap="soft" ></textarea>
<br />
<label>Requisitos</label>
<textarea form ="add_cursos" name="Info" id="Info" cols="35" rows="4" wrap="soft" ></textarea>
<br />
<label>Destinatários</label>
<textarea form ="add_cursos" name="PublicoTarget" id="PublicoTarget" cols="35" rows="4" wrap="soft" ></textarea>
<br />
<label>Preço Base</label>
<textarea form ="add_cursos" name="Preco" id="Preco" cols="35" rows="4" wrap="soft" ></textarea>
 
<br />
<input type="submit" value="Atualizar Curso">
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

