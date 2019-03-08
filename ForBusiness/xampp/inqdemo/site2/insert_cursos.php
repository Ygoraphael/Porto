<?php

	include 'db_config.php';


// create a variable
$CC=mysqli_real_escape_string($conn, $_POST['CC']);
$Contexto=mysqli_real_escape_string($conn, $_POST['Contexto']);
$Info=mysqli_real_escape_string($conn, $_POST['Info']);
$NomeCurso=mysqli_real_escape_string($conn, $_POST['NomeCurso']);
$Objectivos=mysqli_real_escape_string($conn, $_POST['Objectivos']);
$Preco=mysqli_real_escape_string($conn, $_POST['Preco']);
$PublicoTarget=mysqli_real_escape_string($conn, $_POST['PublicoTarget']);
$Conteudos=mysqli_real_escape_string($conn, $_POST['Conteudos']);


$sql = "INSERT INTO cursos (CC, Contexto, Info, NomeCurso, Objectivos, Preco, PublicoTarget, Conteudos)
VALUES ('$CC', '$Contexto', '$Info', '$NomeCurso', '$Objectivos', '$Preco', '$PublicoTarget', '$Conteudos')";

if ($conn->query($sql) === TRUE) {
    echo "Curso adicionado com sucesso";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>