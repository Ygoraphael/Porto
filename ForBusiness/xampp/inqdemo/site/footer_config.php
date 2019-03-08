<?php
//session_unset();
?>
<script src="/inqdemo/site/js/jquery.js"></script>
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
   var i =0;
    $('.jm-module.color2-ms').each(function() {
        if(i ==0){
            $(this).removeClass("color2-ms");
            $(this).addClass("color1-ms");
        }
        i++;
    });
    
    $('.btn-edit-curso').click(function () {
        var curso = $(this).attr('id');
        $.post('/inqdemo/site/edit-curso-adm.php', {curso: curso}, function (res) {
            $('#content-modal').html(res);
        }).done(function () {
            // $('#edit-curso-modal').modal('show');
        });
    });
    $("#btn-save-curso").click(function () {
        $.post('/inqdemo/index.php/update-curso', $('#form-edit-curso').serialize(), function () {
        }).done(function () {
            window.location.reload();
        });
    });

    $("#edit-curso-modal").on('click', '.btn-delete-curso', function () {
        var curso = $('.btn-delete-curso').attr('id');
        $.post('/inqdemo/index.php/delete-curso', {CC: curso}, function () {
        }).done(function () {
            window.location.reload();
        });
    });
    $('.btn-edit-acao').click(function () {
        var acao = $(this).attr('id');
        $.post('/inqdemo/site/edit-acao-adm.php', {acao: acao}, function (res) {
            $('#content-modal').html(res);
        }).done(function () {
            // $('#edit-curso-modal').modal('show');
        });
    });
    $("#btn-save-acao").click(function () {
        $.post('/inqdemo/index.php/update-acao', $('#form-edit-acao').serialize(), function () {
        }).done(function () {
            window.location.reload();
        });
    });
    $("#edit-acao-modal").on('click', '.btn-delete-acao', function () {
        var acao = $('.btn-delete-acao').attr('id');
        $.post('/inqdemo/index.php/delete-acao', {acao: acao}, function () {
        }).done(function () {
            window.location.reload();
        });
    });
    $('.btn_remove_curso').click(function (e) {
        e.preventDefault();
        $.post('/inqdemo/index.php/remove-curso', {curso: $('.btn_remove_curso').attr('id')}, function () {
        }).done(function () {

            $(this).parent().parent().fadeOut();
            window.location.reload();
        });
    });
    $(document).ready(function () {
        $('#new_emp').click(function () {
            $.post('/inqdemo/index.php/nova-empresa', function () {
            }).done(function () {
                window.location.reload();
            });
        });
        $('#curso-list').DataTable({"language":
                    {
                        "sProcessing": "A processar...",
                        "sLengthMenu": "Mostrar _MENU_",
                        "sZeroRecords": "Não foram encontrados resultados",
                        "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registos",
                        "sInfoEmpty": "Mostrando de 0 até 0 de 0 registos",
                        "sInfoFiltered": "(filtrado de _MAX_ registos no total)",
                        "sInfoPostFix": "",
                        "sSearch": " Procurar: ",
                        "sUrl": "",
                        "oPaginate": {
                            "sFirst": "Primeiro",
                            "sPrevious": "Anterior",
                            "sNext": "Seguinte",
                            "sLast": "Último"
                        }
                    }

        });
        $('#acao-list').DataTable({"language":
                    {
                        "sProcessing": "A processar...",
                        "sLengthMenu": "Mostrar _MENU_",
                        "sZeroRecords": "Não foram encontrados resultados",
                        "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registos",
                        "sInfoEmpty": "Mostrando de 0 até 0 de 0 registos",
                        "sInfoFiltered": "(filtrado de _MAX_ registos no total)",
                        "sInfoPostFix": "",
                        "sSearch": " Procurar: ",
                        "sUrl": "",
                        "oPaginate": {
                            "sFirst": "Primeiro",
                            "sPrevious": "Anterior",
                            "sNext": "Seguinte",
                            "sLast": "Último"
                        }
                    }

        });
        $('#contact-list').DataTable({
            "language":
                    {
                        "sProcessing": "A processar...",
                        "sLengthMenu": "Mostrar _MENU_",
                        "sZeroRecords": "Não foram encontrados resultados",
                        "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registos",
                        "sInfoEmpty": "Mostrando de 0 até 0 de 0 registos",
                        "sInfoFiltered": "(filtrado de _MAX_ registos no total)",
                        "sInfoPostFix": "",
                        "sSearch": " Procurar: ",
                        "sUrl": "",
                        "oPaginate": {
                            "sFirst": "Primeiro",
                            "sPrevious": "Anterior",
                            "sNext": "Seguinte",
                            "sLast": "Último"
                        }
                    },
            "filter" : false

        });
        var w = $(window).width();
        var h = $(window).height();
        if (w <= 520) {
            $('#dj-slideshow8m280').hide();
        }
        if (h <= 800) {
            $("#dj-slideshow8m280").before($('#jm-main'));
        }
    });
</script>