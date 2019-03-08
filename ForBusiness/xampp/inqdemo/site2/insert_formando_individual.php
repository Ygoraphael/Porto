<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "acadprof_inqdemo";


$NomeFormando5=$_POST['NomeFormando5'];
$DataNasc5=$_POST['DataNasc5'];
$Morada5=$_POST['Morada5'];
$CodigoPostal5=$_POST['CodigoPostal5'];
//$Localidade5=$_POST['Localidade5'];
$Email5=$_POST['Email5'];
$Telemovel5=$_POST['Telemovel5'];

$CartaoCidadao5=$_POST['CartaoCidadao5'];
$Validade5=$_POST['Validade5'];
$nCartaConducao5=$_POST['nCartaConducao5'];
//$LocalEmissao5=$_POST['LocalEmissao5'];
$DataEmissao5=$_POST['DataEmissao5'];
//$DataValidade5=$_POST['DataValidade5'];
//$Categoria5=$_POST['Categoria5'];
$NIF5=$_POST['NIF5'];
$DataRenovADR5=$_POST['DataRenovADR5'];
$DataRenovCAM5=$_POST['DataRenovCAM5'];





// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "INSERT INTO formandos (NomeFormando, DataNasc, Morada, CodigoPostal, Email, Telemovel, CartaoCidadao, Validade, nCartaConducao, DataEmissao, NIF, DataRenovADR, DataRenovCAM)
VALUES 
('$NomeFormando5', '$DataNasc5', '$Morada5', '$CodigoPostal5', '$Email5', '$Telemovel5', '$CartaoCidadao5', '$Validade5', '$nCartaConducao5', '$DataEmissao5', '$NIF5', '$DataRenovADR5', '$DataRenovCAM5')";




if ($conn->query($sql) === TRUE) {
     
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}



$sql2 = "INSERT INTO inscricoes (NomeFormando, DataNasc, Morada, CodigoPostal, Email, Telemovel, CartaoCidadao, Validade, nCartaConducao, DataEmissao, NIF, DataRenovADR, DataRenovCAM)
VALUES 
('$NomeFormando5', '$DataNasc5', '$Morada5', '$CodigoPostal5', '$Email5', '$Telemovel5', '$CartaoCidadao5', '$Validade5', '$nCartaConducao5', '$DataEmissao5', '$NIF5', '$DataRenovADR5', '$DataRenovCAM5')";

if ($conn->query($sql) === TRUE) {
    header("Location:final.php"); 
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}


$conn->close();

?>




