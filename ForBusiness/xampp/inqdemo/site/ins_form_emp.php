<?php

include 'db_config.php';


// create a variable 1
$NomeFormando1 = mysqli_real_escape_string($conn, $_POST['NomeFormando1']);
$DataNasc1 = mysqli_real_escape_string($conn, $_POST['DataNasc1']);
$Morada1 = mysqli_real_escape_string($conn, $_POST['Morada1']);
$CodigoPostal1 = mysqli_real_escape_string($conn, $_POST['CodigoPostal1']);
$Localidade1 = mysqli_real_escape_string($conn, $_POST['Localidade1']);
$Email1 = mysqli_real_escape_string($conn, $_POST['Email1']);
$Telemovel1 = mysqli_real_escape_string($conn, $_POST['Telemovel1']);

$CartaoCidadao1 = mysqli_real_escape_string($conn, $_POST['CartaoCidadao1']);
$Validade1 = mysqli_real_escape_string($conn, $_POST['Validade1']);
$nCartaConducao1 = mysqli_real_escape_string($conn, $_POST['nCartaConducao1']);
$LocalEmissao1 = mysqli_real_escape_string($conn, $_POST['LocalEmissao1']);
$DataEmissao1 = mysqli_real_escape_string($conn, $_POST['DataEmissao1']);
$DataValidade1 = mysqli_real_escape_string($conn, $_POST['DataValidade1']);
$Categoria1 = mysqli_real_escape_string($conn, $_POST['Categoria1']);
$NIF1 = mysqli_real_escape_string($conn, $_POST['NIF1']);
$DataRenovADR1 = mysqli_real_escape_string($conn, $_POST['DataRenovADR1']);
$DataRenovCAM1 = mysqli_real_escape_string($conn, $_POST['DataRenovCAM1']);


$NomeFormando2 = mysqli_real_escape_string($conn, $_POST['NomeFormando2']);
$DataNasc2 = mysqli_real_escape_string($conn, $_POST['DataNasc2']);
$Morada2 = mysqli_real_escape_string($conn, $_POST['Morada2']);
$CodigoPostal2 = mysqli_real_escape_string($conn, $_POST['CodigoPostal2']);
$Localidade2 = mysqli_real_escape_string($conn, $_POST['Localidade2']);
$Email2 = mysqli_real_escape_string($conn, $_POST['Email2']);
$Telemovel2 = mysqli_real_escape_string($conn, $_POST['Telemovel2']);

$CartaoCidadao2 = mysqli_real_escape_string($conn, $_POST['CartaoCidadao2']);
$Validade2 = mysqli_real_escape_string($conn, $_POST['Validade2']);
$nCartaConducao2 = mysqli_real_escape_string($conn, $_POST['nCartaConducao2']);
$LocalEmissao2 = mysqli_real_escape_string($conn, $_POST['LocalEmissao2']);
$DataEmissao2 = mysqli_real_escape_string($conn, $_POST['DataEmissao2']);
$DataValidade2 = mysqli_real_escape_string($conn, $_POST['DataValidade2']);
$Categoria2 = mysqli_real_escape_string($conn, $_POST['Categoria2']);
$NIF2 = mysqli_real_escape_string($conn, $_POST['NIF2']);
$DataRenovADR2 = mysqli_real_escape_string($conn, $_POST['DataRenovADR2']);
$DataRenovCAM2 = mysqli_real_escape_string($conn, $_POST['DataRenovCAM2']);



$sql = "INSERT INTO formandos (NomeFormando, DataNasc, Morada, CodigoPostal, Localidade, Email, Telemovel, CartaoCidadao, Validade, nCartaConducao, LocalEmissao, DataEmissao, DataValidade, Categoria, NIF, DataRenovADR, DataRenovCAM)
VALUES 
('$NomeFormando1', '$DataNasc1', '$Morada1', '$CodigoPostal1', '$Localidade1', '$Email1', '$Telemovel1', '$CartaoCidadao1', '$Validade1', '$nCartaConducao1', '$LocalEmissao1', '$DataEmissao1', '$DataValidade1', '$Categoria1', '$NIF1', '$DataRenovADR1', '$DataRenovCAM1') ,
('$NomeFormando2', '$DataNasc2', '$Morada2', '$CodigoPostal2', '$Localidade2', '$Email2', '$Telemovel2', '$CartaoCidadao2', '$Validade2', '$nCartaConducao2', '$LocalEmissao2', '$DataEmissao2', '$DataValidade2', '$Categoria2', '$NIF', '$DataRenovADR2', '$DataRenovCAM2')";


if ($conn->query($sql) === TRUE) {
    header("Location:final_empresas.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
