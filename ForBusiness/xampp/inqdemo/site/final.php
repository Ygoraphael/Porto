
<?php
include 'db_config.php';

$conn = mysql_connect($servername, $username, $password);

session_start();
if (!$conn) {
    die('Could not connect: ' . mysql_error());
}
$teste2 = $_POST['name'];

$sql = "SELECT * FROM cursos WHERE CC = '$teste2'";
mysql_select_db('acadprof_inqdemo');
$retval = mysql_query($sql, $conn);

if (!$retval) {
    die('Could not get data: ' . mysql_error());
}

while ($row = mysql_fetch_assoc($retval)) {
    $_SESSION['caret'][$row['CC']]['qtd'] = 1;
    $_SESSION['caret'][$row['CC']]['nome'] = $row['NomeCurso'];
    $_SESSION['caret'][$row['CC']]['preco'] = $row['Preco'];
}

mysql_close($conn);


$conn = mysql_connect($servername, $username, $password);

if (!$conn) {
    die('Could not connect: ' . mysql_error());
}

mysql_select_db('acadprof');




$contacts = mysql_query("SELECT * FROM inscricoes ORDER BY nInsc DESC LIMIT 1") or die(mysql_error());

// If results
if (mysql_num_rows($contacts) > 0)
    
    ?>

<table id="contact-list">
    <thead>
        <tr>
            <th>Curso</th>
        </tr>
    </thead>
    <tbody>

        <?php while ($contact = mysql_fetch_array($contacts)) : ?>
            <tr>
                <td class="NomeCurso"><?php echo $contact['Acao']; ?></td>

            </tr>

        <?php endwhile; ?>

    </tbody>
</table>


<?php
include 'db_config.php';

mysql_select_db('cleaning');




$contacts = mysql_query("SELECT * FROM formandos ORDER BY ID DESC LIMIT 1") or die(mysql_error());

// If results
if (mysql_num_rows($contacts) > 0)
    
    ?>

<table id="contact-list" style="width: 100%" class="text-center">
    <thead>
        <tr>
            <th>Nome Faturação</th>
            <th>Data Nascimento</th>
            <th>NIF</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($contact = mysql_fetch_array($contacts)) : ?>
            <tr>
                <td class="CC"><?php echo $contact['NomeFormando']; ?></td>
                <td class="NomeCurso"><?php echo $contact['DataNasc']; ?></td>
                <td class="Objectivos"><?php echo $contact['NIF']; ?></td>
            </tr>

        <?php endwhile; ?>

    </tbody>
</table>



<form action='index.php?option=com_jumi&view=application&fileid=10' method="post">
    <input type="hidden" name="name" value="">
    <input type="hidden" name="acao" value="">
    <br><br>
    <input type="submit" class="btn btn-success pull-right" name="submit" value="Confirmo os meus dados">
    <br><br>
</form>