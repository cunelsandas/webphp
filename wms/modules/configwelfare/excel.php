<?php
/*$filename  = 'report_1.xls';
header('Content-Type: application/vnd.ms-excel');
header('Cintent-Disposition: attachment; filename = '.$filename);
echo $_GET['data'];*/

$file="report.xls";
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=$file");

echo $_POST['frm_code'];
?>
