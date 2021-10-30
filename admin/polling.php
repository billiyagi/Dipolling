<?php

require "template/menu.php";

$sql = "SELECT * FROM list_table";
$show_polling = new dipollingTable($db_host_name, $db_username, $db_password, $db_name);

$result = $show_polling->get_Query($sql);
$rows_list_table = $show_polling->loopFetch($result);

if(isset($_POST['submit'])){
    $table_name = $_POST['tablename'];

    if(!empty($table_name)){

        $add_table_query = 'CREATE TABLE '. $table_name .' (id INT AUTO_INCREMENT PRIMARY KEY, polimg VARCHAR(150), polname VARCHAR(200), polvote INT)';
        $add_table_query .= "INSERT INTO list_table VALUES (NULL, 'oke')";
        $dipolling->add_table($add_table_query, 'multi');

        die();
        header("Location: poll.php?name=" . $table_name . "&add=1");

    }else{

       echo $notify->showNotify(false, 'Isi kolom nama tabel');

    }
}

?>

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
    <a href="#" class="btn btn-lg btn-success mt-5" data-bs-toggle="modal" data-bs-target="#addPollings"><i class="bi bi-plus-lg"></i> Add Polling</a>
    <!-- Modal -->
    <div class="modal fade" id="addPollings" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Polling</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form class="" action="" method="post">
                <label for="tabel-name" class="mb-3">Nama Tabel</label>
                <input type="text" id="tabel-name" name="tablename" placeholder="Enter Table name" class="form-control mb-4">
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" name="submit" class="btn btn-success">Add Polling</button>
              </div>
          </form>
        </div>
      </div>
    </div>
    <table class="table mt-5">
        <tr class="table-dark">
            <th>No</th>
            <th>Name</th>
            <th>Total Vote</th>
        </tr>
        <?php $i = 1; ?>
        <?php foreach($rows_list_table as $row) :?>

            <?php
            // Ambil total keseluruhan dari tabel polling target
            $name_source_table = $row['name'];
            $name_source_query = "SELECT SUM(polvote) FROM " . $name_source_table;
            $res = $show_polling->get_Query($name_source_query);
             ?>

        <tr>
            <td><?php echo $i; ?></td>
            <td><a href="poll.php?name=<?php echo $row['name']; ?>"><?php echo str_replace("_", " ", $row['name']); ?></a></td>
            <td><?php $single = $show_polling->singleFetch($res);
            echo $single['SUM(polvote)'];?></td>
        </tr>

        <?php
        $i++;
         endforeach; ?>
    </table>

<?php require "template/main.php"; ?>
