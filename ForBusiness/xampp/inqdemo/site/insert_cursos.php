<?php
include 'db_config.php';


// create a variable
$CC = mysqli_real_escape_string($conn, $_POST['CC']);
$Contexto = mysqli_real_escape_string($conn, $_POST['Contexto']);
$Info = mysqli_real_escape_string($conn, $_POST['Info']);
$NomeCurso = mysqli_real_escape_string($conn, $_POST['NomeCurso']);
$Objectivos = mysqli_real_escape_string($conn, $_POST['Objectivos']);
$Valor = mysqli_real_escape_string($conn, $_POST['Valor']);
$PublicoTarget = mysqli_real_escape_string($conn, $_POST['PublicoTarget']);
$Conteudos = mysqli_real_escape_string($conn, $_POST['Conteudos']);
$acreditacoes = mysqli_real_escape_string($conn, $_POST['acreditacoes']);

$sql = "INSERT INTO cursos (CC, Contexto, Info, NomeCurso, Objectivos, Preco, PublicoTarget, Conteudos, acreditacoes)
VALUES ('$CC', '$Contexto', '$Info', '$NomeCurso', '$Objectivos', '$Valor', '$PublicoTarget', '$Conteudos', '$acreditacoes')";

if ($conn->query($sql) === TRUE) {
    echo "Curso adicionado com sucesso ";
    ?>
    <a href='http://<?= $_SERVER['HTTP_HOST']; ?>/index.php/adminitracao-de-cursos'>Voltar</a>
    <?php
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
