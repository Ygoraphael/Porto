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