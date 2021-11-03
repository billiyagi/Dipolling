<?php require "template/menu.php";
    $conf = $_GET['conf'];
    $table_name = $_GET['table_name'];


    if (isset($_POST['addsubmit'])) {

        $dipMediaFotoExtension = ['jpg', 'png', 'jpeg'];
        $dipMedia = new dipollingMedia($_FILES, '../assets/img/pollimg/', $dipMediaFotoExtension, 1000000);
        $add_img_item = $dipMedia->addMedia('img');

        // Upload File
        if ($add_img_item) {
            $dipolling->addItemPoll($table_name, $_POST, $add_img_item);
            header("Location: poll?name=$table_name&add=0&add_item=success");
        }else{
            header("Location: poll?name=$table_name&add=0&add_item=0");
        }

        // redirect
        
    }elseif(isset($_POST['editsubmit'])){

        // init image
        $dipMediaEditFotoExtension = ['jpg', 'png', 'jpeg'];
        $dipMedia = new dipollingMedia($_FILES, '../assets/img/pollimg/', $dipMediaEditFotoExtension, 1000000);
        if($_FILES['polimg']['name']){
            //jika kosong berarti ganti baru
            unlink('../assets/img/pollimg/' .  $_POST['oldpolimg']);
            $pol_img = $dipMedia->addMedia('img');
            // Upload File
        }else{
            $pol_img = $_POST['oldpolimg'];
        }
        $dipolling->editItemPoll($table_name, $_POST, $pol_img);
        header("Location: poll?name=$table_name&edit_item=1&add=0");
    }
?>

<!-- cek apakah get conf kosong atau tidak -->
<?php if(!empty($conf)): ?>

    <?php if ($conf === 'add'): ?>

    <h2 class="fw-bold mb-5 text-capitalize"><span class="text-secondary">Add Item :</span> <?php echo str_replace("_", " ", $table_name); ?></h2>
    <hr>
    <p>&nbsp;</p>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="" class="control-label mb-3">Name</label>
        <input type="text" name="polname" class="form-control" placeholder="Poll item name">
        <label for="" class="control-label mb-3 mt-3">Item image</label>
        <input type="file" name="polimg" class="form-control">
        <button type="submit" name="addsubmit" class="btn btn-lg btn-primary mt-4">Add Item</button>
    </form>
    <!-- Delete Page -->
    <?php elseif ($conf === 'delete'): ?>
        <?php
        $id_item = $_GET['id'];
        $img_item = $_GET['img'];
        $show_polling->deleteFetch("DELETE FROM $table_name WHERE id=$id_item");
        unlink('../assets/img/pollimg/'. $img_item);
        header("Location: poll?name=$table_name&add=0&delete_item=1");
        ?>
    <?php elseif ($conf === 'edit'): ?>
        <?php 
            $table_name = $_GET['table_name'];
            $item_id = $_GET['id'];
            $query = "SELECT * FROM $table_name WHERE id=$item_id";
            $result_single = $show_polling->get_Query($query);
            $fetch = $show_polling->singleFetch($result_single);
        ?>
    <!-- Edit Page -->
        <h2 class="fw-bold mb-5 text-capitalize"><span class="text-secondary">Edit Item :</span> <?php echo str_replace("_", " ", $table_name); ?></h2>
        <hr>
        <p>&nbsp;</p>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="polid" value="<?= $fetch['id']; ?>">
            <input type="hidden" name="oldpolimg" value="<?= $fetch['polimg']; ?>">
            <label for="polname" class="control-label mb-3">Name</label>
            <input type="text" name="polname" class="form-control" placeholder="Name" value="<?= $fetch['polname']; ?>" id="polname" required>
            <label for="polimg" class="control-label mb-3 mt-3">Item image</label>
            <input type="file" name="polimg" class="form-control" id="polimg">
            <div class="dip-current-img mt-4" id="current-img">
                <img src="../assets/img/pollimg/<?= $fetch['polimg']; ?>">
                <label for="current-img" class="mt-3 bg-dark text-light w-100 p-2">Current Image</label>
            </div>
            <button type="submit" name="editsubmit" class="btn btn-lg btn-primary mt-4">Edit Poll Item</button>
        </form>


    <?php else: ?>
        <!-- ketika kosong ataupun tidak ada dalam list akan redirect ke halaman polling.php -->
        <?php header("Location: polling"); ?>

    <?php endif; ?>

<?php else: ?>
    <!-- ketika kosong ataupun tidak ada dalam list akan redirect ke halaman polling.php -->
    <?php header("Location: polling"); ?>
<?php endif; ?>

<?php require "template/main.php"; ?>
