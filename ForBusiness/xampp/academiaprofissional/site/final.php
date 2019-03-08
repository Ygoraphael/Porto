
<?php
include 'db_config.php';

session_start();

$teste2 = $_POST['name'];

$sql = "SELECT * FROM cursos WHERE CC = '$teste2'";

$retval = mysqli_query($conn, $sql);

if (!$retval) {
    die('Could not get data: ' . mysqli_error());
}

while ($row = mysqli_fetch_assoc($retval)) {
    $_SESSION['caret'][$row['CC']]['qtd'] = 1;
    $_SESSION['caret'][$row['CC']]['nome'] = $row['NomeCurso'];
    $_SESSION['caret'][$row['CC']]['preco'] = $row['Preco'];
}

$contacts = mysqli_query($conn, "SELECT * FROM inscricoes ORDER BY nInsc DESC LIMIT 1") or die(mysqli_error());

// If results
if (mysqli_num_rows($contacts) > 0)
    
    ?>

<table id="contact-list">
    <thead>
        <tr>
            <th>Curso</th>
        </tr>
    </thead>
    <tbody>

        <?php while ($contact = mysqli_fetch_array($contacts)) : ?>
            <tr>
                <td class="NomeCurso"><?php echo $contact['Acao']; ?></td>

            </tr>

        <?php endwhile; ?>

    </tbody>
</table>


<?php

$contacts = mysqli_query($conn, "SELECT * FROM formandos ORDER BY ID DESC LIMIT 1") or die(mysqli_error());

// If results
if (mysqli_num_rows($contacts) > 0)
    
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
        <?php while ($contact = mysqli_fetch_array($contacts)) : ?>
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