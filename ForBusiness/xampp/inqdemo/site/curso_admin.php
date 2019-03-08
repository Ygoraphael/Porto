<script>
   jQuery(document).ready(function($){
  	tinymce.init({
	selector: '#acreditacoes',
    theme: 'modern',
    width: 530,
    height: 200,
    plugins: [
             "advlist autolink link image lists charmap print preview hr anchor pagebreak",
             "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
             "table contextmenu directionality emoticons paste textcolor  code"
    ],
    toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
    toolbar2: "|  link unlink anchor | image media | forecolor backcolor  | print preview code | caption",
    image_caption: true,
    image_advtab: true ,
    visualblocks_default_state: true ,
    style_formats_autohide: true,
    style_formats_merge: true,
    });
});
</script>

<?php
if (JFactory::getUser()->guest == 0) {
    // header("Location: http://{$_SERVER['HTTP_HOST']}");
    ?> 
    <div class="container" style="margin-top: -30px">
        <div class="span12 text-center">
            <a href='http://<?= $_SERVER['HTTP_HOST']; ?>/inqdemo/index.php/cadastrar-curso'>Adicionar Cursos</a> |
            <a href='http://<?= $_SERVER['HTTP_HOST']; ?>/inqdemo/index.php/adminitracao-de-cursos'>Lista de Cursos</a> |
            <a href='http://<?= $_SERVER['HTTP_HOST']; ?>/inqdemo/index.php/adicionar-acao'>Adicionar ação</a> 

            <form method="post" action="http://<?= $_SERVER['HTTP_HOST']; ?>/inqdemo/index.php/insert-curso" id="add_cursos" novalidate>
                <label>Código de Família de Produto</label>
                <textarea form ="add_cursos" name="CC" id="CC" cols="70" rows="4" wrap="soft" required=""></textarea>
                <br />
                <label>Nome da Família de Produto</label>
                <textarea form ="add_cursos" name="NomeCurso" id="NomeCurso" cols="70" rows="4" wrap="soft" required=""></textarea>
                <br />
                <label>Descrição</label>
                <textarea form ="add_cursos" name="Contexto" id="Contexto" cols="70" rows="4" wrap="soft" required=""></textarea>
                <br />
                <label>Objetivos do Curso</label>
                <textarea form ="add_cursos" name="Objectivos" id="Objectivos" cols="70" rows="4" wrap="soft" required=""></textarea>
                <br />
                <label>Conteúdos Programáticos</label>
                <textarea form ="add_cursos" name="Conteudos" id="Conteudos" cols="70" rows="4" wrap="soft" required=""></textarea>
                <br />
                <label>Requisitos</label>
                <textarea form ="add_cursos" name="Info" id="Info" cols="70" rows="4" wrap="soft" required=""></textarea>
                <br />
                <label>Destinatários</label>
                <textarea form ="add_cursos" name="PublicoTarget" id="PublicoTarget" cols="70" rows="4" wrap="soft" required=""></textarea>
                <br />
                <label>Valor</label>
                <textarea form ="add_cursos" name="Valor" id="Valor" cols="70" rows="4" wrap="soft" required=""></textarea>
				<br />
				<label>Acreditações</label>
                <textarea form ="add_cursos" name="acreditacoes"  id="acreditacoes"  required="" ><table style="height: 257px; width: 486px;">
								<tbody>
								<tr style="height: 279px;">
								<td style="width: 231px; height: 279px;">
								<figure class="image align-left"><img src="http://localhost/inqdemo/images/CP.png" alt="" width="200" height="200" />
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
								</tbody>
								</table></textarea>
                <br />
                <input type="submit" value="Adicionar Curso">
            </form>
        </div>
    </div>
    <!--
    <br>
     <a href="ler_db.php">Ver lista de Cursos adicionados (raw data)</a>
    <br>  <a href="lista_cursos.php">Ver lista de Cursos adicionados (refinada)</a>
     <br>
     <a href="inscricao.php">Inscrição</a>

     <br><br>
     <a href="tt.php">Criar ações</a>
    -->

<?php } else { ?>
    <div class="container">
        <div class="span-lg-12" style="text-align: center">
            <h4 class="text-warning">Você não tem permissão pra acessar essa pagina, por favor, acesse o painel de controle.</h4>
        </div>
    </div>

<?php } ?>




