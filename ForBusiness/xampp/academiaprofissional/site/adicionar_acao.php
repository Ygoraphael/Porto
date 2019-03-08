<?php include 'db_config.php'; ?>

<div class="container" style="margin-top: -30px">
    <div class="span12 text-center">
        <div class="text-center">
          <ul class="nav nav-tabs custom-tabs">
            <li><a href='<?= JURI::base(); ?>index.php/cadastrar-curso'>Adicionar Curso</a> </li>
            <li><a href='<?= JURI::base(); ?>index.php/adicionar-acao'>Adicionar Ação</a></li>
            <li><a href='<?= JURI::base(); ?>index.php/adminitracao-de-cursos'>Listagem de Cursos</a> </li>
            <li><a href='<?= JURI::base(); ?>index.php/listar-acoes'>Listagem de Ações</a></li>
            </ul>
        </div>
        <form method="post" action="<?= JURI::base(); ?>index.php/cadastro-de-acoes" id="add_acoes">
            <?php
            $query = $db->getQuery(true);
            $query->select("*");
            $query->from($db->quoteName('cursos'));
            $query->order('ID ASC');
            $db->setQuery($query);
            $results = $db->loadAssocList();
            ?>
            <br />
            <label class="labelTit">Referente ao curso:</label><br />
            <select class="i900" name="RefCurso">
                <?php
                    foreach ($results as $row) {
                        echo "<option value=" . $row['CC'] . ">" . $row['CC'] . ' - ' . $row['NomeCurso'] . "</option>";
                    }
                ?>
            </select>
            <br /><br />
            <label class="labelTit">É exame?</label><br />
            <select name="exame" class="i900">
                <option value="0">Não</option>
                <option value="1">Sim</option>
            </select>
            <label class="labelTit">Código Interno</label><br />
            <input class="i900" type="text" name="CodigoInterno" required="">
            <br /><br />
            <label class="labelTit">Nome do Curso</label><br />
            <select class="i900" form="add_acoes" name="NomeAcao" id="NomeAcao" required="">
                <option value="b"></option>
                <option value="ADR Base">ADR Base</option>
                <option value="ADR Base e Cisternas">ADR Base e Cisternas</option>
                <option value="Cisternas">Cisternas</option>
                <option value="Explosivos">Explosivos</option>
                <option value="Reciclagem ADR Base">Reciclagem ADR Base</option>
                <option value="Reciclagem ADR Base e Cisternas">Reciclagem ADR Base e Cisternas</option>
                <option value="Reciclagem ADR Base e Explosivos">Reciclagem ADR Base e Explosivos</option>
                <option value="Conselheiros Segurança – Inicial">Conselheiros Segurança – Inicial</option>
                <option value="Conselheiros Segurança – Reciclagem">Conselheiros Segurança – Reciclagem</option>
                <option value="Capacidade Profissional Mercadorias, Nacional e Internacional">Capacidade Profissional Mercadorias, Nacional e Internacional</option>
                <option value="Capacidade Profissional Passageiros, Nacional e Internacional">Capacidade Profissional Passageiros, Nacional e Internacional</option>
                <option value="CAM - Formação Contínua">CAM - Formação Contínua</option>
            </select>
            <br /><br />
            <label class="labelTit">Data Início</label><br />
            <input class="i900" type="date" name="DataInicio" required="">
            <br /><br />
            <label class="labelTit">Data Fim</label><br />
            <input class="i900" type="date" name="DataFim" required="">
            <br /><br />
            <label class="labelTit">Sessões</label><br />
            <input class="i900" form="add_acoes" name="Sessoes" id="Sessoes" cols="35" rows="4" wrap="soft" required="" type="number">
            <br />
            <label class="labelTit">Preço</label>
            <input class="i900" form="add_acoes" name="preco" id="preco" cols="35" rows="4" wrap="soft" required="" type="number">
            <br />
            <label class="labelTit">Preço 2</label>
            <input class="i900" form="add_acoes" name="preco2" id="preco2" cols="35" rows="4" wrap="soft" required="" type="number">
            <br />
            <label class="labelTit">Nº Dias Preço 2</label>
            <input class="i900" form="add_acoes" name="diaspreco2" id="diaspreco2" cols="35" rows="4" wrap="soft" required="" type="number">
            <br />
            <br />
            <label class="labelTit">Cronograma</label>
            <textarea class="tinyedit" form ="add_acoes" name="Horario" id="Horario" cols="70" rows="4" wrap="soft" required=""></textarea>
            <br />
            <label class="labelTit">Localidade</label>
            <input class="i900" type="text" id="Localidade" name="Localidade" required="">
            <br />
            <label class="labelTit">Morada</label>
            <textarea class="tinyedit" form ="add_acoes" name="Morada" id="Morada" cols="70" rows="4" wrap="soft" required=""></textarea>
            <br />
            <label class="labelTit">Formato</label>
            <textarea class="tinyedit" form ="add_acoes" name="Formato" id="Formato" cols="70" rows="4" wrap="soft" required=""></textarea>
            <br />
            <label class="labelTit">Informações Adicionais (Ação)</label>
            <textarea class="tinyedit" form ="add_acoes" name="Info" id="Info" cols="70" rows="4" wrap="soft" required=""></textarea>
            <br />
            <br />
            <input type="submit" value="Criar Ação" class="btn btn-success">
        </form>
    </div>
</div>
