<?php require "template/menu.php";
$get_table_name = $_GET['name'];
$get_add_table = $_GET['add'];
$get_activate_table_polling = $_GET['activate'];
$sql = "SELECT * FROM " . $get_table_name;
$show_polling = new dipollingTable($db_host_name, $db_username, $db_password, $db_name);

$result = $show_polling->get_Query($sql);

if(empty($get_table_name)){
   header("Location: polling.php");
}elseif(!$result){
   header("Location: polling.php");
}elseif($get_add_table > 0){
    //Notifikasi error
   echo $notify->showNotify(true, $get_table_name . ' berhasil ditambahkan');
}elseif(isset($get_activate_table_polling)){
    $dipolling->activatePolling($get_table_name);
    if ($get_activate_table_polling > 0) {
        header("Location: polling.php?activate=$get_table_name");
    }
}
$rows_list_table = $show_polling->loopFetch($result);

?>

<h2 class="mt-4"><span class="text-secondary">Polling: </span> <strong class="text-capitalize"><?php echo str_replace("_", " ", $get_table_name); ?></strong></h2>
<div class="d-flex justify-content-between">
    <a href="#" class="btn btn-lg btn-primary mt-5">
        <i class="bi bi-plus-lg"></i> Add Polling item
    </a>
    <a href="poll.php?name=<?= $get_table_name; ?>&add=0&activate=1" class="btn btn-lg btn-success mt-5">
        <i class="bi bi-check-circle"></i> Activate
    </a>
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
        <td><?php echo $row['polling']; ?></td>
        <td><?php echo $row['polvote']; ?></td>
    </tr>

    <?php
    $i++;
     endforeach; ?>
</table>

<?php require "template/main.php"; ?>
