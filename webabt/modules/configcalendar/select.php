<?php

/*
 * connection database
 */
include_once "../../../itgmod/connect.php";
/*
 * check POST
 */

if ($_POST['data'] != "") {
  $sql = "SELECT * FROM tb_even WHERE division_id=".$_POST['data'];
  $rs = rsQuery($sql);
  $Rows = mysqli_num_rows($rs);
  if ($Rows > 0) {
      while ($Result = mysqli_fetch_array($rs)) {
          echo "<option value=\"" . $Result['id'] . "\">" . $Result['even'] . "</option>";
      }
  }else{

      echo "<option value=\"\">ไม่มีกิจกรรม</option>";
  }
}
