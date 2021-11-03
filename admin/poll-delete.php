<?php
require '../core/server.php';

$table_name = $_GET['name'];
$query = "DROP TABLE " . $table_name;

$query_item = "SELECT * FROM $table_name";

$result_item = $show_polling->get_Query($query_item);
$rows_item = $show_polling->loopFetch($result_item);

foreach ($rows_item as $row) {
    unlink('../assets/img/pollimg/' . $row['polimg']);
}

if ($ex = $show_polling->dropTable($query) > 0) {
    $query2 = "DELETE FROM list_table WHERE name='$table_name'";
    $show_polling->deleteFetch($query2);
    header("Location: polling?table_name=$table_name&table_delete=1");
}
