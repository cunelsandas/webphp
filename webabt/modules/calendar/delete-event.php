<?php

include_once "../../itgmod/connect.php";

$id = $_POST['id'];

$sqlDelete1 = "DELETE from tbl_events WHERE id=".$id;
$rs = rsQuery($sqlDelete1);


$sqlDelete2 = "DELETE from tbl_detail_events WHERE tbl_event_id=".$id;
$rs = rsQuery($sqlDelete2)


/*
$server="localhost";
$user="root";
$pw='12345678';
$db="b1onestop";

$conn = mysqli_connect($server, $user, $pw, $db);

$id = $_POST['id'];
$sqlDelete1 = "DELETE from tbl_detail_events WHERE tbl_event_id=".$id;

mysqli_query($conn, $sqlDelete1);

$id = $_POST['id'];
$sqlDelete = "DELETE from tbl_events WHERE id=".$id;

mysqli_query($conn, $sqlDelete);

echo mysqli_affected_rows($conn);

mysqli_close($conn);*/

?>
