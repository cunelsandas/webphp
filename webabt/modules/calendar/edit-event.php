<?php
include_once "../../itgmod/connect.php";

$id = $_POST['id'];
$division  =  $_POST['frm_division'];
$even  =  $_POST['frm_even'];
$detail  =  $_POST['frm_detail'];
$str_date  =  $_POST['str_date'];
$str_time =  $_POST['str_time'];
$end_date  =  $_POST['end_date'];


$sql = "SELECT * FROM tb_even WHERE id = $even";
$rsl = rsQuery($sql);
$row = mysqli_fetch_array($rsl);

$sqlUpdate1 = "UPDATE tbl_events SET title='".$str_time." ".$row['even']."',start='" . $str_date . "',start_time='" . $str_time . "',end='" . $end_date . "' WHERE id=" . $id;
$rs = rsQuery($sqlUpdate1);

$sqlUpdate = "UPDATE tbl_detail_events SET division_id='" . $division . "',even_id='" . $even . "',detail='" . $detail . "' WHERE tbl_event_id=" . $id;
$rs = rsQuery($sqlUpdate);

echo $end_date;
?>
