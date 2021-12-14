<?php
require "template/menu.php";

// Show all Item Polling
if ( isset($_GET['name']) ) {

     // Cek apakah ada nama tabel di database yang dikirim dari url
     if ( mysqli_num_rows( mysqli_query( DB::$conn, "SELECT * FROM dipolling_list_table WHERE name='" . $_GET['name'] . "'" ) ) == 1 ) {
          $rowsListTable = $showPolling->GetLoopFetch("SELECT * FROM " . $_GET['name']);

     } else {
          header('Location: polling.php');
     }

} else {
     header('Location: polling.php');
}


// Cek polling yang aktif
$resultActivePolling = mysqli_query(DB::$conn, "SELECT * FROM dipolling_list_table WHERE polling_active=1");

if ( mysqli_num_rows($resultActivePolling) != 0 ) {
     $activePolling = $showPolling->GetSingleFetch("SELECT * FROM dipolling_list_table WHERE polling_active=1");

} else {
     $activePolling['name'] = '-';
}

// Cek Polling yang aktif
if ( $_GET['name'] != $activePolling['name'] ) {
     $checkVotePoll = $showPolling->GetSingleFetch("SELECT SUM(polvote) FROM " . $_GET['name']);

} elseif ( $activePolling['name'] !== '-' ) {
     $checkVotePoll = $showPolling->GetSingleFetch("SELECT SUM(polvote) FROM " . $activePolling['name']);

} else {
     $checkVotePoll = false;
}

// Rename Table Name
if (isset($_REQUEST['rename_table_submit'])) {

     // Basic Filter
     $newTable = strtolower(
          strip_tags(
               htmlspecialchars(
                    str_replace( " ", "_", $_REQUEST['rename_table'] )
               )
          )
     );

     $oldTable =  $_GET['name'];

     $sql = "RENAME TABLE `$db_name`.`$oldTable` TO `$db_name`.`$newTable`";

     $sql2 = "UPDATE dipolling_list_table
              SET name='$newTable' WHERE name='$oldTable'";

     $resultUpdateListTable = mysqli_query(DB::$conn, $sql2);
     $resultRenameTable = mysqli_query(DB::$conn, $sql);

     header("Location: poll?name=" . $newTable . "&rename=1");
}

// Notifikasi item berhasil ditambahkan
if ( isset( $_GET['add_item'] ) ) {

     if ( $_GET['add_item'] == 'success' ) {
        echo ShowNotify( true, 'Item successfully added' );

     } else {
        echo ShowNotify( false, 'Item failed to added' );
     }

} elseif ( isset( $_GET['delete_item'] ) ){

    if ( $_GET['delete_item'] == 1 ) {
        echo ShowNotify( true, 'Item successfully deleted' );
    }

} elseif ( isset( $_GET['edit_item'] ) ){

    if ( $_GET['edit_item'] == 'success' ) {
         echo ShowNotify( true,'Item successfully updated' );

    } else{
         echo ShowNotify( false,'Item failed to updated' );
    }
} elseif ( isset( $_GET['rename'] ) ) {
     if ($_GET['rename'] == '1') {
          echo ShowNotify( true,'Table name changed' );
     }
}
?>
<h2 class="mt-4 position-relative">
     <span class="text-secondary">Polling: </span>

     <strong class="text-capitalize">
          <?= str_replace( "_", " ", $_GET['name'] ); ?>
          <span class="dip-edit-table-name bg-primary p-2 position-absolute" id="btnRenameTable">
               <i class="bi bi-pencil"></i>
          </span>
     </strong>

     <form action="<?= PageSelf(); ?>?name=<?= $_GET['name']; ?>" method="post" id="renameTable" class="mt-3 renameTable shadow" onsubmit="FormLoading()">
          <input type="text" name="rename_table" placeholder="Rename table" value="<?= strtolower(str_replace( "_", " ", $_GET['name'] )); ?>" class="form-control">
          <button type="submit" name="rename_table_submit" class="d-none">Submit</button>
     </form>
</h2>
<div class="d-sm-flex justify-content-between">
     <div class="btn-group">

          <a href="poll-item?table_name=<?= $_GET['name']; ?>&conf=add" class="btn btn-lg btn-primary mt-5">
              <i class="bi bi-plus-circle"></i> Add item
          </a>
     <?php if( !$checkVotePoll || $checkVotePoll["SUM(polvote)"] == 0 ): ?>

          <!-- Tombol Modal Hapus Tabel -->
          <a class="btn btn-lg btn-secondary mt-5 text-light disabled"><i class="bi bi-warning"></i> Reset</a>
     </div>

     <?php else: ?>
          <!-- Tombol Modal Hapus Tabel -->
          <a class="btn btn-lg btn-secondary mt-5 text-light" data-bs-toggle="modal" data-bs-target="#modalResetTabel"><i class="bi bi-warning"></i> Reset</a>
     </div>

     <!-- Modal Hapus Tabel -->
     <div class="modal fade" id="modalResetTabel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalHapusTabelLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
               <div class="modal-content">
                    <div class="modal-header bg-light">

                         <h5 class="modal-title fw-bold text-capitalize" id="modalHapusTabelLabel"><span class="text-secondary">Reset table:</span> <?= str_replace('_', ' ', $_GET['name']); ?>?</h5>
                         <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                         </div>

                    <div class="modal-body">
                         <span class="mt-3 mb-3 d-block">Dengan mengklik tombol reset kamu akan <strong>menghapus semua vote(suara)</strong> yang ada didalam tabel, apakah kamu yakin?</span>
                    </div>

                    <div class="modal-footer bg-light">
                         <button type="button" class="btn btn-primary" data-bs-dismiss="modal">No</button>
                         <a href="poll-reset?table_name=<?= $_GET['name']; ?>" class="btn btn-secondary">
                         <i class="bi bi-x-circle"></i> Reset
                         </a>
                    </div>
               </div>
          </div>
     </div>
     <?php endif; ?>



    <!-- Ketika polling sudah aktif dan tombol untuk menonaktifkannya -->
    <?php if($_GET['name'] === $activePolling['name']): ?>

        <div class="btn-group">

            <a href="poll-active?name=<?= $_GET['name']; ?>&stat=nonactive" class="btn btn-lg btn-danger mt-5" onclick="FormLoading()">
                <i class="bi bi-x-circle"></i> Non-Active
            </a>

            <a href="poll-delete?name=<?= $_GET['name']; ?>" class="btn btn-lg btn-secondary mt-5 disabled" onclick="FormLoading()">
                <i class="bi bi-x-circle"></i> Delete
            </a>

        </div>

    <!-- Ketika polling belum ada yang aktif -->
<?php elseif($activePolling['name'] === '-'): ?>


        <div class="btn-group">

            <a href="poll-active?name=<?= $_GET['name']; ?>&stat=active" class="btn btn-lg btn-success mt-5" onclick="FormLoading()">
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
                        <h5 class="modal-title fw-bold text-capitalize" id="modalHapusTabelLabel"><span class="text-secondary">Drop table:</span> <?= str_replace('_', ' ', $_GET['name']); ?>?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <span class="mt-3 mb-3 d-block">Dengan mengklik tombol delete kamu akan <strong>menghapus semua isi</strong> yang ada didalam tabel, apakah kamu yakin?</span>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <a href="poll-delete?name=<?= $_GET['name']; ?>" class="btn btn-danger">
                            <i class="bi bi-x-circle"></i> Delete
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <!-- ketika polling sudah ada yang aktif -->
<?php elseif($_GET['name'] !== $activePolling['name']): ?>
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
                        <h5 class="modal-title fw-bold text-capitalize" id="staticBackdropLabel"><span class="text-secondary">Drop table:</span> <?= str_replace('_', ' ', $_GET['name']); ?>?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <span class="mt-3 mb-3 d-block">Dengan mengklik tombol delete kamu akan <strong>menghapus semua isi</strong> yang ada didalam tabel, apakah kamu yakin?</span>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <a href="poll-delete?name=<?= $_GET['name']; ?>" class="btn btn-danger" onclick="FormLoading()">
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
            <th>Image</th>
            <th>Vote</th>
        </tr>

        <?php $i = 1; ?>

        <!-- Loop Table Item Polling -->
        <?php foreach($rowsListTable as $row) :?>

        <tr>
            <td><?php echo $i; ?></td>
            <td>
                <?php echo $row['polname']; ?>
                <div class="d-flex dip-delete-item">

                    <!-- Edit Poll item button -->
                    <a href="poll-item?conf=edit&table_name=<?= $_GET['name']; ?>&id=<?= $row['id']; ?>" class="me-2">Edit</a>

                    <!-- Delete Poll item button -->
                    <a href="poll-item?conf=delete&table_name=<?= $_GET['name']; ?>&id=<?= $row['id']; ?>&img=<?= $row['polimg']; ?>" class="text-danger" onclick="return confirm('delete item?')">Delete</a>
                </div>
            </td>
            <td>
                <!-- Modal Button See Img -->
                <a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#seeImg_<?= $row['id']; ?>">Img</a>

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
<script type="text/javascript">
     var renameTable = document.getElementById('renameTable');
     var btnRenameTable = document.getElementById('btnRenameTable');
     btnRenameTable.addEventListener('click', function(){
          renameTable.classList.toggle('d-block');
     })
</script>
<?php require "template/main.php"; ?>
