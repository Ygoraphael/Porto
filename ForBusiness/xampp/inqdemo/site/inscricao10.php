<?php
require_once 'db_config.php';
$teste3 = $_POST['name'];
$teste4 = $_POST['acao'];

echo "Está a inscrever-se no curso";
echo "   $teste3";
echo "Está a inscrever-se na ação";
echo "   $teste4";
?>

<?php
$servername = "localhost";
$username = "acadprof_nc";
$password = "28^e6u_m*P0%";
$dbname = "acadprof_inqdemo";


// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO inscricoes (Acao, Curso)
VALUES ('$teste3', '$teste4')";

if ($conn->query($sql) === TRUE) {
    echo "sucesso";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>




<form action='inscricao.php?name="<?php echo $teste3; ?>"' method="post">
    <input type="hidden" name="name" value="<?php echo $teste3; ?>">
    <input type="submit" name="submit" value="Inscrever">
</form>