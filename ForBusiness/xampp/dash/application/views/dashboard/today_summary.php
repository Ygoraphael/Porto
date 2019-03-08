<div class="row text-center" style="margin-bottom:50px">
    <div class="col-sm-12">
        <h1 class="nctitle">Total Horas Realizadas Hoje</h1>
    </div>
</div>
<div class="row">
    <?php foreach ($tecs as $tec) : ?>

        <div class="col-sm-4">
            <div class="card card-6-6 card-default nopadding">
                <div class="card-heading text-center" style="background-color:#e0e0e0;"><h4><?= $tec["nome"] ?></h4></div>
                <div class="card-body">
                    <div class="card-left text-center">
                        <h3>Total</h3>
                    </div>
                    <div class="card-right text-center">
                        <h3><?= number_format($tec["hora"], 2, ".", "") ?> Horas</h3>
                    </div>
                </div>
            </div>
        </div>

    <?php endforeach; ?>

</div>