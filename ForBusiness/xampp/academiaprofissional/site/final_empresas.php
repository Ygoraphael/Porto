



<?php
include 'db_config.php';





$contacts = mysqli_query($conn, "SELECT * FROM inscricoes ORDER BY nInsc DESC LIMIT 1") or die(mysqli_error());

// If results
if (mysqli_num_rows($contacts) > 0)
    
    ?>

<table id="contact-list">
    <thead>
        <tr>
            <th>Curso</th>
            <th>Ação</th>




        </tr>
    </thead>
    <tbody>

        <?php while ($contact = mysqli_fetch_array($contacts)) : ?>



            <tr>
                <td class="CC"><?php echo $contact['Curso']; ?></td>
                <td class="NomeCurso"><?php echo $contact['Acao']; ?></td>
                <td class="Objectivos"><?php echo $contact['Nome']; ?></td>
                <td class="Contexto"><?php echo $contact['Morada']; ?></td>
                <td class="PublicoTarget"><?php echo $contact['NIF']; ?></td>

            </tr>

        <?php endwhile; ?>

    </tbody>
</table>


<?php
$contacts = mysqli_query($conn, "
                        SELECT * FROM empresa ORDER BY ID DESC LIMIT 1") or die(mysqli_error());

// If results
if (mysqli_num_rows($contacts) > 0)
    
    ?>

<table id="contact-list">
    <thead>
        <tr>
            <th>Nome Faturação</th>
            <th>Morada</th>
            <th>NIF</th>



        </tr>
    </thead>
    <tbody>

<?php while ($contact = mysqli_fetch_array($contacts)) : ?>



            <tr>
                <td class="CC"><?php echo $contact['NomeEmpresa']; ?></td>
                <td class="NomeCurso"><?php echo $contact['Morada']; ?></td>
                <td class="Objectivos"><?php echo $contact['NIF']; ?></td>

            </tr>

<?php endwhile; ?>

    </tbody>
</table>



<form action='email.php' method="post">
    <input type="hidden" name="name" value="">
    <input type="hidden" name="acao" value="">
    <input type="submit" name="submit" value="Confirmo os meus dados">
</form>




<?php
$contacts = mysqli_query($conn, "SELECT * FROM formandos ORDER BY ID DESC LIMIT 1") or die(mysqli_error());

// If results
if (mysqli_num_rows($contacts) > 0)
    
    ?>

<table id="contact-list">
    <thead>
        <tr>
            <th>Nome Formando</th>




        </tr>
    </thead>
    <tbody>

<?php while ($contact = mysqli_fetch_array($contacts)) : ?>



            <tr>
                <td class="CC"><?php echo $contact['NomeFormando']; ?></td>


            </tr>

<?php endwhile; ?>

    </tbody>
</table>




