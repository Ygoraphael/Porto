
  <script>
  jQuery(document).ready(function($){
  	tinymce.init({
	selector: '#acreditacoes2',
    theme: 'modern',
    width: 500,
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
include 'db_config.php';
$curso = $_POST['curso'];
$sql = "SELECT * FROM cursos WHERE CC='{$curso}'";
$retval = $conn->query($sql);
if ($retval->num_rows > 0) {
    while ($row_curso = $retval->fetch_row()) {
        $curso = $row_curso;
        // $sql = "SELECT * FROM cursos WHERE CC = '$row_curso[9]'";
        //  $curso = $conn->query($sql);
        //while ($row_c = $curso->fetch_row()) {
        // }
    }
}
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<form id='form-edit-curso' novalidate>
    <div class="span6">
        <span>Código</span><br>
        <input type="text" name="CC"  disabled="" class=" input-large" style="width: 100%;" value="<?= $curso[1]; ?>">
        <input type="hidden" name="CC"  class=" input-large" style="width: 100%;" value="<?= $curso[1]; ?>">
    </div>
    <div class="span6">
        <span>Valor</span><br>
        <input type="text"  name="Valor"   class="input-large" style="width: 100%;" value="<?= $curso[7]; ?>">
    </div>
    <div class="span12">
        <span>Nome do Curso</span><br>
        <input type="text" name="NomeCurso"  class="input-large" style="width: 100%;"  value="<?= $curso[2]; ?>">
    </div>
    <div class="span12">
        <span>Public Alvo</span><br>
        <input type="text"   name="PublicoTarget"  class="input-large" style="width: 100%;"  value="<?= $curso[5]; ?>">
    </div>
    <div class="span12">
        <span>Conteudo</span><br>
        <input type="text" name="Conteudos"  class="input-large" style="width: 100%;"  value="<?= $curso[8]; ?>">
    </div>
    <div class="span12">
        <span>Objetivo</span><br>
        <input type="text" name="Objectivos"  class="input-large" style="width: 100%;"  value="<?= $curso[3]; ?>">
    </div>
    <div class="span12">
        <span>Contexto</span><br>
        <input type="text" name="Contexto"  class="input-large" style="width: 100%;"  value="<?= $curso[4]; ?>">
    </div> 
	<div class="span12" >
        <span>Acreditações</span><br>
        <textarea rows="4" name="acreditacoes"  id="acreditacoes2"   style='width: 100%; '><?= $curso[9]; ?></textarea>

    </div>
    <div class="span12">
        <span>Info</span><br>
        <textarea rows="4" name="Info"  style='width: 100%;'><?= $curso[6]; ?></textarea>
    </div>



</form>
<div class="clearfix"></div>
<br><br>
<div class="span12">
    <button type="button" class="btn-xs btn-danger btn-delete-curso" id="<?= $curso[1] ?>"><i class="icon-trash"></i> deletar</button>
</div>