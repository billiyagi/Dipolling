<?php
require "template/menu.php";
    $conf = $_GET['conf'];
    $table_name = $_GET['table_name'];

    if ( isset( $_GET['table_name'] ) ) {
         if ( mysqli_num_rows( mysqli_query( DB::$conn, "SELECT * FROM dipolling_list_table WHERE name='{$_GET['table_name']}'" ) ) !== 1 ) {
               header( 'Location: polling' );
         }
     } else {
         header( 'Location: polling' );
     }

    if ( isset( $_REQUEST['addsubmit'] ) ) {
         //cek kondisi field
          if ( $_REQUEST['polname'] == "" && $_FILES['pollimgadd']['error'] > 0 ) {
              header( "Location: poll?name=$table_name&add_item=fail" );
          }

        $dipMedia = new MediaFiles( $_FILES, '../assets/img/pollimg/', ['jpg', 'png', 'jpeg'], 1000000, 'pollimgadd' );
        $addImgItem = $dipMedia->SetAddMedia( 'img' );
        // Upload File
          if ( $addImgItem ) {
               $dipollingItem = new PollingItem( $table_name, DB::$conn );
               if ( $dipollingItem->SetAddItemPoll( $_REQUEST, $addImgItem ) > 0 ) {
                 header( "Location: poll?name=$table_name&add_item=success" );
               }
          } else {
               // redirect
               header( "Location: poll?name=$table_name&add_item=0" );
          }
    } elseif ( isset( $_REQUEST['editsubmit'] ) ) {

          //cek kondisi field
          if ( $_REQUEST['polname'] == "" && $_FILES['pollimgedit']['error'] > 0 ) {
               header( "Location: poll?name=$table_name&edit_item=fail" );
          }

        // init image
        $dipMedia = new MediaFiles( $_FILES, '../assets/img/pollimg/', ['jpg', 'png', 'jpeg'], 1000000, 'pollimgedit' );

        // cek kondisi file kosong/tidak
        if( $_FILES['pollimgedit']['name'] ){
             $editImgItem = $dipMedia->SetAddMedia( 'img' );
               if ( $editImgItem !== false ) {
                    //jika kosong berarti ganti baru
                    unlink( '../assets/img/pollimg/' .  $_REQUEST['oldpolimg'] );
               }
          } else {
               // gunakan gambar lama
               $editImgItem = $_REQUEST['oldpolimg'];
          }

          // Tambah item ke database
          $dipollingItem = new PollingItem( $table_name, DB::$conn );
          $dipollingItem->SetEditItemPoll( $_REQUEST, $editImgItem );

          // cek apakah ada perubahan dalam database
          if ( mysqli_affected_rows( DB::$conn ) == 1 ) {
               header( "Location: poll?name=$table_name&edit_item=success" );
          } else {
               header( "Location: poll?name=$table_name&edit_item=fail" );
          }
    }
?>

<!-- cek apakah get conf kosong atau tidak -->
<?php if( !empty( $conf ) ): ?>

    <?php if ( $conf === 'add' ): ?>
     <!-- Add page -->
    <h2 class="fw-bold mb-5 text-capitalize"><span class="text-secondary">Add Item :</span> <?php echo str_replace( "_", " ", $table_name ); ?></h2>
    <hr>
    <p>&nbsp;</p>
    <form action="<?= PageSelf(); ?>?table_name=<?= $table_name ?>&conf=add" method="post" enctype="multipart/form-data" onsubmit="FormLoading()">
        <label for="" class="control-label mb-3">Name</label>
        <input type="text" name="polname" class="form-control" placeholder="Poll item name" required>
        <label for="" class="control-label mb-3 mt-3">Item image</label> <small class="text-secondary">Max 1MB ( .jpg, .png, .jpeg )</small>
        <input type="file" name="pollimgadd" class="form-control" required>
        <button type="submit" name="addsubmit" class="btn btn-lg btn-primary mt-4">Add Item</button>
    </form>
    <?php elseif ($conf === 'edit'): ?>
         <!-- Edit item Page -->
        <?php
          if ($_GET['id'] !== "") {
             $table_name = $_GET['table_name'];
             $item_id = $_GET['id'];
             $fetch = $showPolling->GetSingleFetch("SELECT * FROM $table_name WHERE id=$item_id");
        }else{
             header("Location: polling");
        }
        ?>
    <!-- Edit Page -->
        <h2 class="fw-bold mb-5 text-capitalize"><span class="text-secondary">Edit Item :</span> <?php echo str_replace("_", " ", $table_name); ?></h2>
        <hr>
        <p>&nbsp;</p>
        <form action="<?= PageSelf() ?>?conf=edit&table_name=<?= $table_name; ?>&id=<?= $item_id; ?>" method="post" enctype="multipart/form-data" onsubmit="FormLoading()">
            <input type="hidden" name="polid" value="<?= $fetch['id']; ?>">
            <input type="hidden" name="oldpolimg" value="<?= $fetch['polimg']; ?>">


            <label for="polname" class="control-label mb-3">Name</label>
            <input type="text" name="polname" class="form-control" placeholder="Name" value="<?= $fetch['polname']; ?>" id="polname" required>

            <label for="pollimgedit" class="control-label mb-3 mt-3">Item image</label> <small class="text-secondary">Max 1MB ( .jpg, .png, .jpeg )</small>
            <input type="file" name="pollimgedit" class="form-control" id="pollimgedit">

            <div class="dip-current-img mt-4" id="current-img">
                <img src="../assets/img/pollimg/<?= $fetch['polimg']; ?>">
                <label for="current-img" class="mt-3 bg-dark text-light w-100 p-2">Current Image</label>
            </div>

            <button type="submit" name="editsubmit" class="btn btn-lg btn-primary mt-4">Edit Poll Item</button>
        </form>

        <!-- Delete Page -->
     <?php elseif ($conf === 'delete'): ?>
          <?php
          $id_item = $_GET['id'];
          $img_item = $_GET['img'];
          mysqli_query(DB::$conn, "DELETE FROM $table_name WHERE id=$id_item");
          unlink('../assets/img/pollimg/'. $img_item);
          header("Location: poll?name=$table_name&delete_item=1");
          ?>
    <?php else: ?>

        <!-- ketika get conf kosong ataupun tidak ada dalam list akan redirect ke halaman polling.php -->
        <?php header("Location: polling"); ?>

    <?php endif; ?>

<?php else: ?>

    <!-- ketika kosong ataupun tidak ada dalam list akan redirect ke halaman polling.php -->
    <?php header("Location: polling"); ?>

<?php endif; ?>

<?php require "template/main.php"; ?>
