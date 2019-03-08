
<style>
    label{display:inline-block;width:100px;margin-bottom:10px;}
</style>

<div class="span12 offset4">
    <a href='http://<?= $_SERVER['HTTP_HOST']; ?>/inqdemo/index.php/cadastrar-curso'>Adicionar Cursos</a> |
    <a href='http://<?= $_SERVER['HTTP_HOST']; ?>/inqdemo/index.php/adminitracao-de-cursos'>Lista de Cursos</a> |
    <a href='http://<?= $_SERVER['HTTP_HOST']; ?>/inqdemo/index.php/listar-acoes'>Lista de ações</a>
    <form method="post" action="http://<?= $_SERVER['HTTP_HOST']; ?>/inqdemo/index.php/cadastro-de-acoes" id="add_acoes">

        <?php
        include 'db_config.php';

        $connect = new connect($servername, $username, $password, $dbname);

        class connect {

            function __construct($host, $user, $password, $db_name) {
                mysql_connect($host, $user, $password) or die("Connection error");
                mysql_select_db($db_name);
                $error = mysql_error();
                if (!empty($error)) {
                    echo $error;
                }
            }

        }

        $query = mysql_query("SELECT ID, NomeCurso FROM cursos ORDER BY ID");
        ?>

        <label>Referente ao curso:</label>
        <?php
        include 'db_config.php';
        ?>

        <select name="RefCurso">
            <?php
            $sql = mysql_query("SELECT ID, NomeCurso, CC FROM cursos");
            while ($row = mysql_fetch_array($sql)) {
                echo "<option value=" . $row['CC'] . ">" . $row['CC'] . ' - ' . $row['NomeCurso'] . "</option>";
            }
            ?>

        </select>    
        <br />
        <label>Nome do Curso</label>
                <select form ="add_acoes" name="NomeAcao" id="NomeAcao" required="">
                    <option value="b"></option>
                    <option value="ADR Base">ADR Base</option>
                    <option value="Cisternas">Cisternas</option>
                    <option value="Explosivos">Explosivos</option>
                    <option value="Reciclagem ADR Base">Reciclagem ADR Base</option>
                    <option value="Reciclagem ADR Base e Cisternas">Reciclagem ADR Base e Cisternas</option>
                    <option value="Reciclagem ADR Base e Explosivos">Reciclagem ADR Base e Explosivos</option>
                    <option value="Conselheiros Segurança – Inicial">Conselheiros Segurança – Inicial</option>
                    <option value="Conselheiros Segurança – Reciclagem">Conselheiros Segurança – Reciclagem</option>
                    <option value="Capacidade Profissional Mercadorias, Nacional e Internacional">Capacidade Profissional Mercadorias, Nacional e Internacional</option>
               </select>
        <br />
        <label>Data Início</label>
        <input type="date" name="DataInicio" required="">
        <br />
        <label>Data Fim</label>
        <input type="date" name="DataFim" required="">
        <br />
        <label>Sessões</label>
        <input form ="add_acoes" name="Sessoes" id="Sessoes" cols="35" rows="4" wrap="soft" required="" type="number">
        <br />
        <label>Cronograma</label>
        <textarea form ="add_acoes" name="Horario" id="Horario" cols="35" rows="4" wrap="soft" required=""></textarea>
        <br />
        <label>Local</label>
        <textarea form ="add_acoes" name="Localidade" id="Localidade" cols="35" rows="4" wrap="soft" required=""></textarea>
        <br />
        <label>Morada</label>
        <textarea form ="add_acoes" name="Morada" id="Morada" cols="35" rows="4" wrap="soft" required=""></textarea>
        <br />
        <label>Formato</label>
        <textarea form ="add_acoes" name="Formato" id="Formato" cols="35" rows="4" wrap="soft" required=""></textarea>
        <br />
        <label>Informações Adicionais (Ação)</label>
        <textarea form ="add_acoes" name="Info" id="Info" cols="35" rows="4" wrap="soft" required=""></textarea>
        <br />
        <br />
        <label>Preço</label>
        <textarea form ="add_acoes" name="preco" id="preco" cols="35" rows="4" wrap="soft" required=""></textarea>
        <br />
        <br />
        <input type="submit" value="Criar Ação" class="btn btn-success">
    </form>

</div>


