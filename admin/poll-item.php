<?php require "template/menu.php";
    $conf = $_GET['conf'];
    $table_name = $_GET['table_name'];
    if (isset($_POST['addsubmit'])) {
        $dipolling->addItemPoll($table_name, $_POST);
        header("Location: poll.php?name=$table_name&add=0&add_item=success");
    }
?>

<!-- cek apakah get conf kosong atau tidak -->
<?php if(!empty($conf)): ?>

    <?php if ($conf === 'add'): ?>

    <h2 class="fw-bold mb-5 text-capitalize"><span class="text-secondary">Add Item :</span> <?php echo str_replace("_", " ", $table_name); ?></h2>
    <hr>
    <p>&nbsp;</p>
    <form action="" method="post">
        <label for="" class="control-label mb-3">Name</label>
        <input type="text" name="polname" class="form-control" placeholder="Poll item name">
        <label for="" class="control-label mb-3 mt-3">Item image</label>
        <input type="file" name="polimg" class="form-control">
        <!-- <input type="text" name="polimg" class="form-control" placeholder="Name"> -->
        <button type="submit" name="addsubmit" class="btn btn-lg btn-primary mt-4">Add Item</button>
    </form>
    <!-- Delete Page -->
    <?php elseif ($conf === 'delete'): ?>
        <?php
        $id_item = $_GET['id'];
        $show_polling->deleteFetch("DELETE FROM $table_name WHERE id=$id_item");

        header("Location: poll.php?name=$table_name&add=0&delete_item=1");
        ?>
    <?php elseif ($conf === 'edit'): ?>

    <!-- Edit Page -->
        <h2 class="fw-bold mb-5 text-capitalize"><span class="text-secondary">Edit Item :</span> <?php echo str_replace("_", " ", $table_name); ?></h2>
        <hr>
        <p>&nbsp;</p>
        <form action="" method="post">
            <label for="" class="control-label mb-3">Name</label>
            <input type="text" name="polname" class="form-control" placeholder="Name">
            <label for="" class="control-label mb-3 mt-3">Item image</label>
            <!-- <input type="file" name="polimg" class="form-control"> -->
            <input type="text" name="polimg" class="form-control" placeholder="Name">
            <button type="submit" name="addsubmit" class="btn btn-lg btn-primary mt-4">Add Item</button>
        </form>


    <?php else: ?>
        <!-- ketika kosong ataupun tidak ada dalam list akan redirect ke halaman polling.php -->
        <?php header("Location: polling.php"); ?>

    <?php endif; ?>

<?php else: ?>
    <!-- ketika kosong ataupun tidak ada dalam list akan redirect ke halaman polling.php -->
    <?php header("Location: polling.php"); ?>
<?php endif; ?>

<?php require "template/main.php"; ?>
