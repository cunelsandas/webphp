
<?php
include_once "../../../itgmod/connect.php";

$id = $_POST['id'];
$title = $_POST['title'];
$start = $_POST['start'];
$end = $_POST['end'];

$sqlUpdate = "UPDATE tbl_events SET title='" . $title . "',start='" . $start . "',end='" . $end . "' WHERE id=" . $id;
$rs = rsQuery($sqlUpdate);

?>
