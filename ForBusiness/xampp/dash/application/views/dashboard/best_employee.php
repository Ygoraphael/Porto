<div class="row text-center" style="margin-bottom:50px">
    <div class="col-sm-12">
        <h1 class="nctitle">Funcionário do Mês <?= date('m-Y', strtotime('first day of last month')) ?> </h1>
    </div>
</div>
<div class="row text-center">
    <table class="table table-striped dtinit" tab-ordercol="1" tab-order="asc" tab-numrow="100">
        <th>Nome</th>
        <th>Projeto NC</th>
        <th>Projeto Externo</th>
        <th>Contrato</th>
        <th>Assistência Esp.</th>
        <th>Assistência Fat.</th>
        <th>Trabalho Possíveis</th>
        <th>Trabalhadas</th>
        <th>Faturadas</th>
    <?php foreach($tecs as $tec) : ?>
    <tr>
        <td><?= $tec["nome"] ?></td>
        <td><?= number_format($tec["projeto"] - $tec["projeto_externo"],2,'.','') ?></td>
        <td><?= number_format($tec["projeto_externo"],2,'.','') ?></td>
        <td><?= number_format($tec["contrato"],2,'.','') ?></td>
        <td><?= number_format($tec["espontanea"],2,'.','') ?></td>
        <td><?= number_format($tec["espontanea_faturado"],2,'.','') ?></td>
        <td><?= number_format($tec["horas_trabalho"],2,'.','') ?></td>
        <td><?= number_format($tec["projeto"] + $tec["contrato"] + $tec["espontanea"],2,'.','') ?></td>
        <td><?= number_format($tec["horas_faturadas"],2,'.','') ?></td>
    </tr>
    <?php endforeach;?>
    </table>
</div>    