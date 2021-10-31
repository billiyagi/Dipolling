<?php include "template/menu.php"; ?>
    <div class="dib-admin-page-title fs-4 text-dark fw-bold">
        <i class="bi bi-speedometer2"></i> Dashboard
    </div>
    <div class="row d-flex justify-content-between">
        <div class="dip-admin-box text-dark col-sm-5">
            <p class="text-dark">Total table</p>
            <span>120</span>
        </div>
        <div class="dip-admin-box text-dark col-sm-5">
            <p class="text-dark">Polling active <i class="bi bi-patch-check-fill text-success"></i></p>
            <span>Example pol</span>
        </div>
    </div>
    <script src="path/to/chartjs/dist/chart.js"></script>
    <script>
        const myChart = new Chart(ctx, {...});
    </script>

<?php include "template/main.php"; ?>
