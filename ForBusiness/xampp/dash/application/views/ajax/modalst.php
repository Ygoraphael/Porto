<div class="row sticky-top" style="background:white;">
    <div class="col-sm-12 col-md-10 nopaddingleft">
        <div class="form-group">
            <input type="text" class="form-control" id="keywords">
        </div>
    </div>
    <div class="col-sm-12 col-md-2 nopaddingleft">
        <div class="form-group">
            <button type="button" onclick="filtrast()" class="btn btn-primary col-sm-12" ><i class="fa fa-search-plus"></i></button>
        </div>
    </div>
</div>
<div class="table-responsive sttab">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col">Referência</th>
                <th scope="col">Design</th>
                <th scope="col">PVP</th>
                <th scope="col">Stock</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($st as $s) : ?>
                <tr>
                    <td>
                        <div class="form-check">
                            <input class="position-static" type="radio" name="ref" value="<?= $s["ref"]; ?>">
                        </div>
                    </td>
                    <td><?= $s["ref"]; ?></td>
                    <td><?= $s["design"]; ?></td>
                    <td><?= $s["epv1"]; ?></td>
                    <td><?= $s["stock"]; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="clearfix"></div>
<script>
    function filtrast() {
        $.ajax({
            method: "POST",
            url: maindir + 'ajax/filtrost',
            data: {keywords: $("#keywords").val()},
            success: function (data) {
                $(".sttab tbody").html("");
                JSON.parse(data).forEach(function (entry) {
                    $(".sttab tbody").append("<tr><td><div class='form-check'><input class='position-static' type='radio' name='ref' value='" + entry['ref'] + "'></div></td><td>" + entry['ref'] + "</td><td>" + entry['design'] + "</td><td>" + entry['epv1'] + "</td><td>" + entry['stock'] + "</td></tr>");
                });
            },
        });
    }
</script>
