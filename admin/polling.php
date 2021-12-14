<?php
require "template/menu.php";

$rows = $showPolling->GetLoopFetch( "SELECT * FROM dipolling_list_table ORDER BY polling_active DESC" );

// Tambah Tabel polling
if( isset( $_REQUEST['submit'] ) ) {
     // Filter
     $table_name = $_REQUEST['tablename'];

     // Buat karakter menjadi lowcase
     $name_lower = strtolower( $table_name );

     // Ganti spasi jadi underscore ( _ )
     $name_replace = str_replace( " ", "_", $name_lower );

     // Hapus Tag HTML
     $table_name_result = strip_tags( $name_replace );

     // Jika nama tabel tidak kosong
     if( !empty( $table_name_result ) ) {

          // kueri tambah tabel
          $addTableSql = 'CREATE TABLE '. $table_name_result .' (id INT AUTO_INCREMENT PRIMARY KEY, polimg VARCHAR(150), polname VARCHAR(200), polvote INT)';

          //eksekusi query tambah tabel
          mysqli_query( DB::$conn, $addTableSql );

          if ( mysqli_num_rows( mysqli_query( DB::$conn, "SELECT * FROM dipolling_list_table WHERE name='$table_name_result'" ) ) == 0 ) {
               // Kueri tambah item di list tabel
               $addListTableItem = "INSERT INTO dipolling_list_table VALUES(NULL, '$table_name_result', -1)";
               mysqli_query( DB::$conn, $addListTableItem );

               // Redirect
               header( "Location: poll?name=" . $table_name_result . "&add=1" );

          } else {
               // Notifikasi error table telah digunakan
               header( "Location: polling?table=already" );
          }

     } else {
        //Notifikasi error table kosong
       echo ShowNotify( false, 'Table name empty' );
       header( "Location: polling?table=empty" );
     }
}

if ( mysqli_num_rows( mysqli_query( DB::$conn, "SELECT * FROM dipolling_list_table WHERE polling_active=1" ) ) != 0 ) {
     $activePolling = $showPolling->GetSingleFetch( "SELECT * FROM dipolling_list_table WHERE polling_active=1" );

     $nameActivePolling = $activePolling['name'];
} else {
     $nameActivePolling = '-';
}

/*
     Notifikasi yang akan dimunculkan dari nilai $_GET pada Url
     menggunakan fungsi ShowNotify() untuk menjalankannya dengan membutuhkan 2
     parameter wajib yaitu ShowNotify( bool [True | False], string [pesan umpan balik] )
*/
// Notifikasi aktivasi polling
if ( isset( $_GET['activate'] ) ) {
    echo ShowNotify( true,'Table ' . str_replace( '_', ' ', $_GET['table_name'] ) . ' activated' );

// Notifikasi aktivasi polling
} elseif ( isset( $_GET['nonactivate'] ) ) {
    echo ShowNotify( true,'Table ' . str_replace( '_', ' ', $_GET['table_name'] ) . ' disabled' );

// Notifikasi hapus tabel polling
} elseif ( isset( $_GET['table_delete'] ) ) {
    echo ShowNotify( true,'Table ' . str_replace( '_', ' ', $_GET['table_name'] ) . ' deleted' );

// Notifikasi reset polling
} elseif ( isset( $_GET['reset'] ) ) {
     // Kondisi true (Hijau)
     if ( $_GET['reset'] == 1 ) {
          echo ShowNotify( true,'Table ' . str_replace( '_', ' ', $_GET['table_name'] ) . ' successfully reset' );

     // Kondisi false (Merah)
     } elseif( $_GET['reset'] == 0 ){
          echo ShowNotify( false,'Table ' . str_replace('_', ' ', $_GET['table_name'] ) . ' Failed to reset');
     }
} elseif ( isset( $_GET['table'] ) ) {

     if ( $_GET['table'] == 'already' ) {
          echo ShowNotify( false,'Table name has been used');

     } elseif ( $_GET['table'] == 'empty' ) {
          echo ShowNotify( false,'Fill the table name');
     }
}
?>

    <div class="dib-admin-page-title fs-4 text-dark fw-bold">
        <i class="bi bi-bar-chart-line"></i> Polling
    </div>
    <div class="row d-flex justify-content-between">
          <div class="dip-admin-box text-dark col-sm-5 mt-5">
               <p class="text-dark">Total table</p>
               <span>
                    <!-- Total tabel yang ada di dalam database -->
                    <?php echo mysqli_num_rows( mysqli_query( DB::$conn, "SELECT * FROM dipolling_list_table" )  );?>
               </span>
          </div>
        <div class="dip-admin-box text-dark col-sm-5 mt-5">
               <p class="text-dark">Polling active <i class="bi bi-patch-check-fill text-success"></i></p>
               <span class="text-capitalize">
                 <?php
                   if ( !isset( $nameActivePolling ) ) {
                         echo '-';
                   }else{
                         echo str_replace('_', ' ', $nameActivePolling);
                   }
                 ?>
               </span>
               <div class="dip-float-total-polling">
                    <strong class="fs-3 d-block">
                        <?php
                         if ( $nameActivePolling !== "-" ) {
                            // Fetch row polvote dan jumlahkan
                            $single = $showPolling->GetSingleFetch("SELECT SUM(polvote) FROM " . $nameActivePolling);

                              if ( $single == NULL ){
                                 echo 0;
                              } else {
                                 echo $single['SUM(polvote)'];
                              }
                         }
                         ?>
                    </strong>
               </div>
          </div>
    </div>

    <!-- Add Polling button -->
     <a href="#" class="btn btn-lg btn-success mt-5" data-bs-toggle="modal" data-bs-target="#addPollings"><i class="bi bi-journals"></i> Add Polling</a>

     <!-- Add Polling Modal -->
     <div class="modal fade" id="addPollings" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
               <div class="modal-content">
                    <form class="<?= PageSelf(); ?>" action="" method="post" onsubmit="FormLoading()">
                         <div class="modal-body">

                              <label for="tabel-name" class="mb-3 fs-5">Make your polling table</label>
                              <input type="text" id="tabel-name" name="tablename" placeholder="Table name" class="form-control-lg w-100 border border-1">
                              <small class="text-secondary mt-1 d-block"><span class="text-danger">*</span> Setelah polling dibuat, nama polling tidak dapat di ubah</small>
                              <br>
                              <button type="submit" name="submit" class="btn btn-success">
                                   <i class="bi bi-journals"></i> Add Polling
                              </button>

                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                         </div>
                    </form>
               </div>
          </div>
     </div>
<?php if (!$rows): ?>
    <div class="dip-empty-polling mt-5 mb-5">
        <img src="../assets/img/mg/undraw_no_data_re_kwbl.svg" alt="No data">
        <span class="fw-bold fs-4 text-secondary mt-3 d-block">Create your Polling now!</span>
    </div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table mt-5">
            <tr class="table-dark">
                <th>No</th>
                <th>Polling Table</th>
                <th class="text-center">Total Vote</th>
                <th class="text-center">Status</th>
            </tr>
            <?php $i = 1; ?>
            <?php foreach ( $rows as $row ) :?>
            <tr>
                <th><?php echo $i; ?></th>
                <td>
                    <a href="poll?name=<?php echo $row['name']; ?>" class="text-decoration-none text-capitalize text-dark dip-see"><?php echo str_replace("_", " ", $row['name']); ?>
                        <i class="bi bi-box-arrow-in-up-right text-primary"></i>
                    </a>
                </td>
                <td class="text-center">
                    <?php
                         // Fetch row polvote dari tabel foreach dan jumlahkan
                         $single = $showPolling->GetSingleFetch("SELECT SUM(polvote) FROM " . $row['name']);
                         if ($single['SUM(polvote)'] == ""){
                            echo 0;
                         } else {
                            echo $single['SUM(polvote)'];
                         }
                    ?>
                </td>
                <td class="text-center">
                    <?php
                    if ( $row['polling_active'] > 0 ) {
                        echo '<i class="bi bi-check-circle text-success" id="activeTable"></i>';
                    } else {
                        echo '<span class="text-secondary">-</span>';
                    }
                    ?>
                </td>
            </tr>

            <?php
            $i++;
             endforeach; ?>
    </table>
    </div>
<?php endif; ?>
<?php require "template/main.php"; ?>
