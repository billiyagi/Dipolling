<?php
require "template/menu.php";

// Get Table Name
$get_table_name = $_GET['name'];

// Get add Status
$get_add_table = $_GET['add'];

// Query & Init Show All Table Item
$sql = "SELECT * FROM " . $get_table_name;
$show_polling = new dipollingTable($db_host_name, $db_username, $db_password, $db_name);

// Result dari query Table Item
$result = $show_polling->get_Query($sql);

// Kondisi jika Nama table kosong
if(empty($get_table_name)){
   header("Location: polling");

// Kondisi jika Result dari show polling null/false
}elseif(!$result){
   header("Location: polling");

// Kondisi jika fungsi tambah tabel berhasil
}elseif($get_add_table > 0){
    //Notifikasi error
   echo $notify->showNotify(true, str_replace('_', ' ', $get_table_name ) . ' berhasil ditambahkan');
}
$rows_list_table = $show_polling->loopFetch($result);

// Cek polling yang aktif
$check_active_polling = $show_polling->get_Query("SELECT * FROM list_table WHERE polling_active=1");
if (mysqli_num_rows($check_active_polling)) {
    $name_active_polling = $show_polling->singleFetch($check_active_polling);
    $name_active_polling_s = $name_active_polling['name'];
}else{
    $name_active_polling_s = 0;
}

// Notifikasi item berhasil ditambahkan
if (isset($_GET['add_item'])) {
    if ($_GET['add_item'] == 'success') {
        echo $notify->showNotify(true, 'Item berhasil ditambahkan');
    }else{
        echo $notify->showNotify(false, 'Item gagal ditambahkan');
    }
}elseif(isset($_GET['delete_item'])){
    if ($_GET['delete_item'] == 1) {
        echo $notify->showNotify(true, 'Item berhasil dihapus');
    }
}elseif(isset($_GET['edit_item'])){
    echo $notify->showNotify(true,'Item berhasil di edit');
}
?>

<h2 class="mt-4"><span class="text-secondary">Polling: </span> <strong class="text-capitalize"><?php echo str_replace("_", " ", $get_table_name); ?></strong></h2>
<div class="d-sm-flex justify-content-between">
    <a href="poll-item?table_name=<?= $get_table_name; ?>&conf=add" class="btn btn-lg btn-primary mt-5">
        <i class="bi bi-plus-lg"></i> Add Polling item
    </a>

    <!-- Ketika polling sudah aktif dan tombol untuk menonaktifkannya -->
    <?php if($get_table_name === $name_active_polling_s): ?>
        <div class="btn-group">
            <a href="poll-active?name=<?= $get_table_name; ?>&stat=nonactive" class="btn btn-lg btn-danger mt-5">
                <i class="bi bi-x-circle"></i> Non-Active
            </a>
            <a href="poll-delete?name=<?= $get_table_name; ?>" class="btn btn-lg btn-secondary mt-5 disabled">
                <i class="bi bi-x-circle"></i> Delete
            </a>
        </div>

    <!-- Ketika polling belum ada yang aktif -->
    <?php elseif($name_active_polling_s === 0): ?>


        <div class="btn-group">
            <a href="poll-active?name=<?= $get_table_name; ?>&stat=active" class="btn btn-lg btn-success mt-5">
                <i class="bi bi-check-circle"></i> Activate
            </a>
            <!-- Tombol Modal Hapus Tabel -->
            <a class="btn btn-lg btn-danger mt-5" data-bs-toggle="modal" data-bs-target="#modalHapusTabel"><i class="bi bi-x-circle"></i> Delete</a>
        </div>

        <!-- Modal Hapus Tabel -->
        <div class="modal fade" id="modalHapusTabel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalHapusTabelLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title fw-bold text-capitalize" id="modalHapusTabelLabel"><span class="text-secondary">Drop table:</span> <?= str_replace('_', ' ', $get_table_name); ?>?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <span class="mt-3 mb-3 d-block">Dengan mengklik tombol delete kamu akan <strong>menghapus semua isi</strong> yang ada didalam tabel, apakah kamu yakin?</span>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <a href="poll-delete?name=<?= $get_table_name; ?>" class="btn btn-danger">
                            <i class="bi bi-x-circle"></i> Delete
                        </a>
                    </div>
                </div>
            </div>
        </div>


    <!-- ketika polling sudah ada yang aktif -->
    <?php elseif($get_table_name !== $name_active_polling_s): ?>
        <div class="btn-group">
            <a href="#" class="btn btn-lg btn-secondary mt-5 disabled">
                <i class="bi bi-check-circle"></i> Active
            </a>
            <a class="btn btn-lg btn-danger mt-5" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="bi bi-x-circle"></i> Delete</a>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title fw-bold text-capitalize" id="staticBackdropLabel"><span class="text-secondary">Drop table:</span> <?= str_replace('_', ' ', $get_table_name); ?>?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <span class="mt-3 mb-3 d-block">Dengan mengklik tombol delete kamu akan <strong>menghapus semua isi</strong> yang ada didalam tabel, apakah kamu yakin?</span>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <a href="poll-delete?name=<?= $get_table_name; ?>" class="btn btn-danger">
                            <i class="bi bi-x-circle"></i> Delete
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

</div>

<!-- Loop Table Item Polling -->
<div class="table-responsive">
    <table class="table mt-5">
        <tr class="table-dark">
            <th>No</th>
            <th>Name</th>
            <th>Gambar</th>
            <th>Vote</th>
        </tr>

        <?php $i = 1; ?>

        <!-- Loop Table Item Polling -->
        <?php foreach($rows_list_table as $row) :?>

        <tr>
            <td><?php echo $i; ?></td>
            <td>
                <?php echo $row['polname']; ?>
                <div class="d-flex dip-delete-item">

                    <!-- Edit Poll item button -->
                    <a href="poll-item?conf=edit&table_name=<?= $get_table_name; ?>&id=<?= $row['id']; ?>" class="me-2">Edit</a>

                    <!-- Delete Poll item button -->
                    <a href="poll-item?conf=delete&table_name=<?= $get_table_name; ?>&id=<?= $row['id']; ?>&img=<?= $row['polimg']; ?>" class="text-danger">Delete</a>
                </div>
            </td>
            <td>
                <!-- Modal Button See Img -->
                <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#seeImg_<?= $row['id']; ?>"> See img</a>

                <!-- Modal See Img-->
                <div class="modal fade" id="seeImg_<?= $row['id']; ?>" tabindex="-1" aria-labelledby="seeImgLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-light">
                                <h5 class="modal-title text-capitalize" id="seeImgLabel">

                                    <!-- Modal See Img Title -->
                                    <strong class="text-dark"><?php echo $row['polname']; ?></strong>

                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                                <!-- Modal See Img Content -->
                                <img src="../assets/img/pollimg/<?php echo $row['polimg']; ?>" width="100%">
                        </div>
                    </div>
                </div>        
            </td>
            <td>
                <?php echo $row['polvote']; ?>
            </td>
        </tr>

        <?php
        $i++;
        endforeach; ?>
    </table>
</div>
<?php require "template/main.php"; ?>
