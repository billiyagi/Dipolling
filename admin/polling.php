<?php include "template/menu.php"; ?>

    <div class="dib-admin-page-title fs-4 text-dark fw-bold">
        <i class="bi bi-bar-chart-line"></i> Polling
    </div>
    <div class="row d-flex justify-content-between">
        <div class="dip-admin-box text-dark col-sm-5 mt-2">
            <p class="text-dark">Total table</p>
            <span>120</span>
        </div>
        <div class="dip-admin-box text-dark col-sm-5 mt-2">
            <p class="text-dark">Polling active <i class="bi bi-patch-check-fill text-success"></i></p>
            <span>Example pol</span>
        </div>
    </div>
    <a href="#" class="btn btn-lg btn-success mt-5"><i class="bi bi-plus-lg"></i> Add Polling</a>
    <table class="table mt-5">
        <tr class="table-dark">
            <th>No</th>
            <th>Name</th>
            <th>Polling</th>
            <th>Total</th>
        </tr>
        <?php for ($i=1; $i <= 7; $i++) :?>
        <tr>
            <td><?php echo $i; ?></td>
            <td>Example Table</td>
            <td>4</td>
            <td>19</td>
        </tr>
        <?php endfor; ?>
    </table>

<?php include "template/main.php"; ?>
