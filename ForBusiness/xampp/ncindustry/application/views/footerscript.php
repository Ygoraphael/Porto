<script>
    // Método que força a fancybox a ser redimensionada 
    //cada vez que uma página é carregada
    $(document).ready(function () {
        try {
            parent.jQuery.fancybox.update();
        } catch (err) {
        }
    })
</script>