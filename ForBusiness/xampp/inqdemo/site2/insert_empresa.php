<?php

	include 'db_config.php';


// create a variable
$NomeEmpresa=mysqli_real_escape_string($conn, $_POST['NomeEmpresa']);
$PessoaContacto=mysqli_real_escape_string($conn, $_POST['PessoaContacto']);
$Morada=mysqli_real_escape_string($conn, $_POST['Morada']);
$CodigoPostal=mysqli_real_escape_string($conn, $_POST['CodigoPostal']);
$Localidade=mysqli_real_escape_string($conn, $_POST['Localidade']);
$Email=mysqli_real_escape_string($conn, $_POST['Email']);
$Telemovel=mysqli_real_escape_string($conn, $_POST['Telemovel']);



$sql = "INSERT INTO empresa (NomeEmpresa, PessoaContacto, Morada, CodigoPostal, Localidade, Email, Telemovel)
VALUES ('$NomeEmpresa', '$PessoaContacto', '$Morada', '$CodigoPostal', '$Localidade', '$Email', '$Telemovel')";

if ($conn->query($sql) === TRUE) {
    header("Location:teste3.php"); 
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>