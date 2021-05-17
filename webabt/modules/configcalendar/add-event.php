<?php
include_once "../../../itgmod/connect.php";


$division  =  $_POST['frm_division'];
$even  =  $_POST['frm_even'];
$detail  =  $_POST['frm_detail'];
$str_date  =  $_POST['str_date'];
$str_time =  $_POST['str_time'];
$end_date  =  $_POST['end_date'];


$sql = "SELECT * FROM tb_even WHERE id = $even";
$rsl = rsQuery($sql);
$row = mysqli_fetch_array($rsl);


$sqlInsert = "INSERT INTO tbl_events (title,start,start_time,end) VALUES ('".$str_time." ".$row['even']."','".$str_date."','".$str_time."','".$end_date ."')";
$rs = rsQuery($sqlInsert);

$sql2 = "SELECT * FROM tbl_events ORDER BY id DESC LIMIT 0,1";
$rss = rsQuery($sql2);
$num = mysqli_fetch_array($rss);
$lid = $num['id'];


$sqlInsert2 = "INSERT INTO tbl_detail_events (id,division_id,even_id,detail,tbl_event_id) VALUES
('','".$division."','".$even."','".$detail ."','".$lid ."')";
$rs = rsQuery($sqlInsert2);

echo "CPADD ";

/*$sqlInsert = "INSERT INTO tb_detail_events (id,division,even,detail,start,str_time,end) VALUES ('','".$division."','".$even ."'
  ,'".$detail."','".$str_date ."','".$str_time."','".$end_date ."')";
$rs = rsQuery($sqlInsert);*/


/*
$sql = "INSERT INTO tb_even (id,even,division_id) VALUES ('','".$_POST['frm_detail']."','".$_POST['frm_division']."')";
$rs = rsQuery($sql);
*/


?>
