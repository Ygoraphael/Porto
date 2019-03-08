<div class="row sticky-top" style="background:white;">
    <div class="col-sm-12 col-md-10 nopaddingleft">
        <div class="form-group">
            <input type="text" class="form-control" id="keywords">
        </div>
    </div>
    <div class="col-sm-12 col-md-2 nopaddingleft">
        <div class="form-group">
            <button type="button" onclick="filtra()" class="btn btn-primary col-sm-12" ><i class="fa fa-search-plus"></i></button>
        </div>
    </div>
</div>
<div class="table-responsive cltab">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col">#</th>
                <th scope="col">Nome</th>
                <th scope="col">Nº Contribuinte</th>
                <th scope="col">País</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cl as $c) : ?>
                <tr>
                    <td>
                        <div class="form-check">
                            <input class="position-static" type="radio" name="no" value="<?= $c["no"]; ?>">
                        </div>
                    </td>
                    <td><?= $c["no"]; ?></td>
                    <td><?= $c["nome"]; ?></td>
                    <td><?= $c["ncont"]; ?></td>
                    <td><?= $c["pncont"]; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="clearfix"></div>
<script>
    function filtra() {
        $.ajax({
            method: "POST",
            url: maindir + 'ajax/filtrocl',
            data: {keywords: $("#keywords").val()},
            success: function (data) {
                $(".cltab tbody").html("");
                JSON.parse(data).forEach(function (entry) {
                    $(".cltab tbody").append("<tr><td><div class='form-check'><input class='position-static' type='radio' name='no' value='" + entry['no'] + "'></div></td><td>" + entry['no'] + "</td><td>" + entry['nome'] + "</td><td>" + entry['ncont'] + "</td><td>" + entry['pncont'] + "</td></tr>");
                });
            },
        });
    }
</script>
