<?php require "template/menu.php";
$get_table_name = $_GET['name'];

$sql = "SELECT * FROM " . $get_table_name;
$show_polling = new dipollingTable($db_host_name, $db_username, $db_password, $db_name);

$result = $show_polling->get_Query($sql);

if(empty($get_table_name)){
   header("Location: polling.php");
}elseif(!$result){
   header("Location: polling.php");
}
$rows_list_table = $show_polling->loopFetch($result);



// Notification add tabel success
// if (isset) {
//     echo $notify->showNotify(false, 'Isi kolom nama tabel');
// }
?>

<h2 class="dip-title mt-4"><span class="text-secondary">Polling: </span> <strong><?php echo str_replace("_", " ", $get_table_name); ?></strong></h2>
<a href="#" class="btn btn-lg btn-success mt-5"><i class="bi bi-plus-lg"></i> Add Polling item</a>
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
