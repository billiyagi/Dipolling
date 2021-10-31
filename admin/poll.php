<?php require "template/menu.php";
$get_table_name = $_GET['name'];
$get_add_table = $_GET['add'];
$sql = "SELECT * FROM " . $get_table_name;
$show_polling = new dipollingTable($db_host_name, $db_username, $db_password, $db_name);

$result = $show_polling->get_Query($sql);

if(empty($get_table_name)){
   header("Location: polling.php");
}elseif(!$result){
   header("Location: polling.php");
}elseif($get_add_table > 0){
    //Notifikasi error
   echo $notify->showNotify(true, str_replace('_', ' ', $get_table_name ) . ' berhasil ditambahkan');
}
$rows_list_table = $show_polling->loopFetch($result);


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
}
?>

<h2 class="mt-4"><span class="text-secondary">Polling: </span> <strong class="text-capitalize"><?php echo str_replace("_", " ", $get_table_name); ?></strong></h2>
<div class="d-flex justify-content-between">
    <a href="poll-item.php?table_name=<?= $get_table_name; ?>&conf=add" class="btn btn-lg btn-primary mt-5">
        <i class="bi bi-plus-lg"></i> Add Polling item
    </a>
    <?php if($get_table_name == $name_active_polling_s): ?>
        <a href="poll-edit.php?name=<?= $get_table_name; ?>&stat=nonactive" class="btn btn-lg btn-danger mt-5">
            <i class="bi bi-x-circle"></i> Non-Active
        </a>
    <?php elseif($name_active_polling_s == 0): ?>
        <a href="poll-edit.php?name=<?= $get_table_name; ?>&stat=active" class="btn btn-lg btn-success mt-5">
            <i class="bi bi-check-circle"></i> Activate
        </a>
    <?php elseif($get_table_name !== $name_active_polling_s): ?>
        <a href="#" class="btn btn-lg btn-secondary mt-5 disabled">
            <i class="bi bi-check-circle"></i> Active
        </a>
    <?php endif; ?>

</div>
<table class="table mt-5">
    <tr class="table-dark">
        <th>No</th>
        <th>Name</th>
        <th>Gambar</th>
        <th>Vote</th>
    </tr>
    <?php $i = 1; ?>
    <?php foreach($rows_list_table as $row) :?>

    <tr>
        <td><?php echo $i; ?></td>
        <td><?php echo $row['polname']; ?></td>
        <td><?php echo $row['polimg']; ?></td>
        <td><?php echo $row['polvote']; ?></td>
        <td class="dip-delete-item">
            <a href="poll-item.php?conf=delete&table_name=<?= $get_table_name; ?>&id=<?= $row['id']; ?>" class="btn-danger pt-2 pb-2 ps-3 pe-3 rounded"><i class="bi bi-x-circle"></i></a>
        </td>
    </tr>

    <?php
    $i++;
     endforeach; ?>
</table>

<?php require "template/main.php"; ?>
