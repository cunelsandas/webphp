<?php

/*
 * connection database
 */
include_once("../../itgmod/connect.inc.php");
/*
 * check POST
 */

if ($_POST['data'] != "") {
  $sql = "SELECT * FROM amphur WHERE PROVINCE_ID=".$_POST['data'];
  $rs = rsQuery($sql);
  $Rows = mysqli_num_rows($rs);
  if ($Rows > 0) {
      while ($Result = mysqli_fetch_array($rs)) {
          echo "<option value=\"" . $Result['AMPHUR_ID'] . "\">" . $Result['AMPHUR_NAME'] . "</option>";
      }
  }else{
      echo "<option value=\"\">ไม่มีสินค้าในหมวดหมู่ที่เลือก</option>";
  }
}elseif ($_POST['data2'] != ""){
  $sql = "SELECT * FROM district WHERE AMPHUR_ID=".$_POST['data2'];
  $rs = rsQuery($sql);
  $Rows = mysqli_num_rows($rs);
  if ($Rows > 0) {
      while ($Result = mysqli_fetch_array($rs)) {
          echo "<option value=\"" . $Result['DISTRICT_ID'] . "\">" . $Result['DISTRICT_NAME'] . "</option>";
      }
  }else{
      echo "<option value=\"\">ไม่มีสินค้าในหมวดหมู่ที่เลือก2</option>";
  }
}
