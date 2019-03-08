<?php
include 'db_config.php';

if (JFactory::getUser()->guest == 0) {
    ?>
    <div class="container" style="margin-top: -30px">
        <div class="span12 text-center">
            <ul class="nav nav-tabs custom-tabs">
                <li><a href='<?= JURI::base(); ?>index.php/cadastrar-curso'>Adicionar Curso</a> </li>
                <li><a href='<?= JURI::base(); ?>index.php/adicionar-acao'>Adicionar Ação</a></li>
                <li><a href='<?= JURI::base(); ?>index.php/adminitracao-de-cursos'>Listagem de Cursos</a> </li>
                <li><a href='<?= JURI::base(); ?>index.php/listar-acoes'>Listagem de Ações</a></li>
            </ul>
            <form method="post" action="<?= JURI::base(); ?>index.php/insert-curso" id="add_cursos" novalidate><br>
                <label>Código Curso</label>
                <input class="i900" type="text" name="CC" required="">
                <br />
                <label>Nome Curso</label>
                <textarea class="tinyedit" form="add_cursos" name="NomeCurso" id="NomeCurso" cols="70" rows="4" wrap="soft" required=""></textarea>
                <br />
                <label>Descrição</label>
                <textarea class="tinyedit" form="add_cursos" name="Contexto" id="Contexto" cols="70" rows="4" wrap="soft" required=""></textarea>
                <br />
                <label>Objetivos do Curso</label>
                <textarea class="tinyedit" form="add_cursos" name="Objectivos" id="Objectivos" cols="70" rows="4" wrap="soft" required=""></textarea>
                <br />
                <label>Conteúdos Programáticos</label>
                <textarea class="tinyedit" form="add_cursos" name="Conteudos" id="Conteudos" cols="70" rows="4" wrap="soft" required=""></textarea>
                <br />
                <label>Requisitos</label>
                <textarea class="tinyedit" form="add_cursos" name="Info" id="Info" cols="70" rows="4" wrap="soft" required=""></textarea>
                <br />
                <label>Destinatários</label>
                <textarea class="tinyedit" form="add_cursos" name="PublicoTarget" id="PublicoTarget" cols="70" rows="4" wrap="soft" required=""></textarea>
                <br />
                <label>Preço</label>
                <textarea class="tinyedit" form="add_cursos" name="Preco" id="Preco" cols="70" rows="4" wrap="soft" required=""></textarea>
                <br />
                <label>Acreditações</label>
                <textarea class="tinyedit" form="add_cursos" name="acreditacoes" id="acreditacoes" required="">
                        <table style="height: 257px; width: 486px;">
                            <tr style="height:279px;">
                                <td style="width: 231px; height: 279px;">
                                    <figure class="image align-left">
                                        <img src="<?= JURI::base(); ?>images/CP.png" alt="" width="200" height="200" />
                                        <figcaption></figcaption>
                                    </figure>
                                </td>
                                <td style="width: 241px; height: 279px;" valign="top">
                                    <ul>
                                        <li style="text-align: left;"></li>
                                        <li style="text-align: left;"></li>
                                    </ul>
                                </td>
                            </tr>
                        </table>
                </textarea>
                <br />
                <label>Requisitos</label>
                <textarea class="tinyedit" form="add_cursos" name="requisitos" id="Preco" cols="70" rows="4" wrap="soft" required=""></textarea>
                <br />
                
                <label>Nova Aba</label>
                <br>
                <input type="text" name="aba_nome" placeholder="Nome da Aba" style="width:30%">
                <input type="checkbox" name="aba_visivel"> Aba Visível<br><br>
                <textarea class="tinyedit" form="add_cursos" name="aba_descricao" id="Preco" cols="70" rows="4" wrap="soft" required=""></textarea>
                
                
                
                <br />
                
                
                <input type="submit" value="Adicionar Curso">
            </form>
        </div>
    </div>
<?php } else { ?>
    <div class="container">
        <div class="span-lg-12" style="text-align: center">
            <h4 class="text-warning">Não tem permissão para aceder a esta página</h4>
        </div>
    </div>
<?php } ?>
