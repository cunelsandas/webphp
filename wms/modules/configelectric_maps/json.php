<?php
include '../../myfnc.php'
header('Content-Type: application/json');
global $g_user;
global $g_pw;
global $g_db;

$server="localhost";
$user=$g_user;
$pw=$g_pw;
$db=$g_db;
$conn = new mysqli($server, $user, $pw, $db);
mysql_query("SET NAMES UTF8");

$strSQL = "SELECT * FROM tb_pet  ";

$objQuery = mysql_query($strSQL);
$resultArray = array();
while($obResult = mysql_fetch_array($objQuery))
{
    array_push($resultArray,$obResult);
}

mysql_close($objConnect);

echo json_encode($resultArray);
?>