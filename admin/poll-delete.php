<?php
require '../core/server.php';

$table_name = $_GET['name'];
$query = "DROP TABLE " . $table_name;

if ($ex = $show_polling->dropTable($query) > 0) {
    $query2 = "DELETE FROM list_table WHERE name='$table_name'";
    $show_polling->deleteFetch($query2);
    header("Location: polling.php?table_name=$table_name&table_delete=1");
}
