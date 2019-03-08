<?php

include 'db_config.php';

// create a variable
$RefCurso = mysqli_real_escape_string($conn, $_POST['RefCurso']);
$NomeAcao = mysqli_real_escape_string($conn, $_POST['NomeAcao']);
$DataInicio = mysqli_real_escape_string($conn, $_POST['DataInicio']);
$DataFim = mysqli_real_escape_string($conn, $_POST['DataFim']);
$Sessoes = mysqli_real_escape_string($conn, $_POST['Sessoes']);
$Horario = mysqli_real_escape_string($conn, $_POST['Horario']);
$Localidade = mysqli_real_escape_string($conn, $_POST['Localidade']);
$Morada = mysqli_real_escape_string($conn, $_POST['Morada']);
$Formato = mysqli_real_escape_string($conn, $_POST['Formato']);
$Info = mysqli_real_escape_string($conn, $_POST['Info']);
$Preco = mysqli_real_escape_string($conn, $_POST['preco']);

$sql = "INSERT INTO acoes (RefCurso, DataFim, DataInicio, NomeAcao, Sessoes, Horario, Localidade, Morada, Formato, Info, preco)
VALUES ('$RefCurso', '$DataFim', '$DataInicio', '$NomeAcao', '$Sessoes', '$Horario', '$Localidade', '$Morada', '$Formato', '$Info', '$Preco')";

if ($conn->query($sql) === TRUE) {
    echo "Ação criada com sucesso";
    echo "o codigo do curso é: ";
    echo $RefCurso;
    echo $DataInicio;
    echo " <br><a href='http://{$_SERVER['HTTP_HOST']}/inqdemo/index.php/adicionar-acao'>Voltar</a>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
