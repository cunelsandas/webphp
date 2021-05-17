<?php
    include_once "../../../itgmod/connect.php";

    $json = array();
    $sqlQuery = "SELECT * FROM tbl_events ORDER BY id";
    $rs = rsQuery($sqlQuery);

    $eventArray = array();
    while ($row = mysqli_fetch_assoc($rs)) {
        array_push($eventArray, $row);
    }
    

    echo json_encode($eventArray);
?>
