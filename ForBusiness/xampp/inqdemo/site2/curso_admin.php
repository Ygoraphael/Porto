<html>
<head>

<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.min.css">

<style>
label{display:inline-block;width:100px;margin-bottom:10px;}
</style>

<!--
<script type="text/javascript">
        function empty() {
    var x;
    x = document.getElementById("CC").value;
    if (x == "") {
        alert("Insira um Código para o Curso!");
        return false;
    };
}
</script>
 -->
 
<title>Adicionar Curso</title>
</head>
<body>
 
<form method="post" action="insert_cursos.php" id="add_cursos">
<label>Código do Curso</label>
<textarea form ="add_cursos" name="CC" id="CC" cols="35" rows="4" wrap="soft" required=""></textarea>
<br />
<label>Nome do Curso</label>
<textarea form ="add_cursos" name="NomeCurso" id="NomeCurso" cols="35" rows="4" wrap="soft" required=""></textarea>
<br />
<label>Descrição</label>
<textarea form ="add_cursos" name="Contexto" id="Contexto" cols="35" rows="4" wrap="soft" required=""></textarea>
<br />
<label>Objetivos do Curso</label>
<textarea form ="add_cursos" name="Objectivos" id="Objectivos" cols="35" rows="4" wrap="soft" required=""></textarea>
<br />
<label>Conteúdos Programáticos</label>
<textarea form ="add_cursos" name="Conteudos" id="Conteudos" cols="35" rows="4" wrap="soft" required=""></textarea>
<br />
<label>Requisitos</label>
<textarea form ="add_cursos" name="Info" id="Info" cols="35" rows="4" wrap="soft" required=""></textarea>
<br />
<label>Destinatários</label>
<textarea form ="add_cursos" name="PublicoTarget" id="PublicoTarget" cols="35" rows="4" wrap="soft" required=""></textarea>
<br />
<label>Preço Base</label>
<textarea form ="add_cursos" name="Preco" id="Preco" cols="35" rows="4" wrap="soft" required=""></textarea>
 
<br />
<input type="submit" value="Adicionar Curso">
</form>
 
<!--
<br>
 <a href="ler_db.php">Ver lista de Cursos adicionados (raw data)</a>
<br>  <a href="lista_cursos.php">Ver lista de Cursos adicionados (refinada)</a>
 <br>
 <a href="inscricao.php">Inscrição</a>

 <br><br>
 <a href="tt.php">Criar ações</a>
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