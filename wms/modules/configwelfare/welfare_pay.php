<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">


<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

<?php

  $sql = 'SELECT b.name AS recname,c.name AS stname,a.id AS idmain,a.*,b.*,c.*
  FROM tb_welfare_request a
  INNER JOIN tb_welfare_type b on a.type = b.id
  INNER JOIN tb_welfare_status c ON a.status = c.id
  INNER JOIN tb_citizen d ON a.personid = d.personid
  WHERE a.status = 2 AND d.status = 2';


if (isset($_POST["btn_save"]) != "") {

  for ($i=0; $i < count($_POST['Chk']) ; $i++) {

  $id = $_POST['Chk'][$i];
  $month = date('Y-m');
  $datepay = date('Y-m-d');
  $amount = FindRS("select amount from tb_welfare_request where id= $id ","amount");

  $sqls = "INSERT INTO tb_welfare_pay(paydate,status,amount,month,request_id)
  VALUES ('$datepay','2','$amount','$month','$id')";

  if (rsQuery($sqls)) {
    echo "<script>alert('บันทึกข้อมูลสำเร็จ');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=welfare_pay'</script>";
  }
}

}

?>


<style>
table .data {
  width: 100%;
}

 .data td, th {
  padding: 2px;
  border: 0px;
}

.data  tr:hover td {
	background-color:#A2AB58;
}

</style>

<fieldset>
	<div class="">
    <h3>บันทึกการจ่ายเบี้ย</h3>
    <hr>
    <br>

<!-- <div class="content-input" style="width:90%;">

  <form name="frmData" method="POST" action="" enctype="multipart/form-data">

  <table class="data">
	<tr>
    <td>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เลขบัตรประชาชน</td><td><input type="text" name="txtpersonid" value="" >
</td>
  </tr>
	<tr>
    <td>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ประเภทเบี้ย</td><td>

    <select name="txttype">
    <?php
      $sqlmoo="select * from tb_welfare_type order by id";
    $rsmoo=rsQuery($sqlmoo);
    if($rsmoo){
      while($dmoo=mysqli_fetch_assoc($rsmoo)){
        $mooid=$dmoo['id'];
        $mooname=$dmoo['name'];
          echo "<option value='$mooid'>$mooname</option>";
      }
    }
    ?>
    </select>

  </td>
</tr>
<tr>
  <td colspan="2"  style="text-align: center;"><input type="submit" name="btsave" value="ค้นหา"></td>
</tr>

</table>
</form>

</div>-->

<form action="" method="post" name="frmMain" id="frmMain" onsubmit="return confirm('ต้องการบันทึกการจ่ายเบี้ยหรือไม่?');">

<table id="example" class="cell-border" style="width: 100%;">
  <thead>
  <tr>
    <th><input type="checkbox"   id="select_all"></th>
    <th>เลขบัตรประชาชน</th>
    <th>ชื่อ - สกุล</th>
    <th>ประเภทเบี้ย</th>
    <th>สถานะ</th>
    <th>จำนวนเงิน</th>
    <th>แสดง</th>
  </tr>
</thead>
<tbody>
  <?php
  $rs=rsQuery($sql);
    $no=0;
    if(mysqli_num_rows($rs)>0){
        while($row=mysqli_fetch_array($rs)){


          $id = $row['idmain'];
          $type = $row['recname'];
          $registerdate=DateThai($row['requestdate']);
          $personid=$row['personid'];
          $status = $row['stname'];
          $detail = $row['detail'];
          $amount = $row['amount'];

          $idprename = FindRS("select prename from tb_citizen where personid= $personid ","prename");
          $prename = FindRS("select name from tb_prename where id = $idprename ","name");
          $name = FindRS("select name from tb_citizen where personid= $personid ","name");
          $surname =FindRS("select surname from tb_citizen where personid= $personid ","surname");
          $fullname = $prename.$name."  ".$surname;

          $monthnow = date('Y-m');

          $sqls = "SELECT * FROM tb_welfare_pay WHERE request_id = '$id' AND month = '$monthnow'";
          $rss = rsQuery($sqls);
          $rows = mysqli_num_rows($rss);

          if ($rows == 0) {
            echo "<tr><td>
            <input type='checkbox' name='Chk[]' class='Chk' value='$id'>
            </td><td>$personid</td><td>$fullname</td><td>$type</td><td>$status</td><td>$amount</td>";
            echo "<td><a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=welfare_pay_view&id=".$id."\"><img src=\"../images/component/docs_16.gif\" border=\"0\" /></td>";
            $no++;
          }

        }
    }else{
      echo "<tr style='text-align: center;'><td colspan='6'>ยังไม่มีข้อมูล</td></tr>";
    }
  ?>
</tbody>
</table>

<br>

<div class="content-input">
  <table style="width:100%">
    <tr><td align="right">เบี้ยประจำเดือน&nbsp;</td><td>
        <?php
        echo MonthThai(date('M'));
        ?>
         ปี
        <?php
        $Yearnow = date('Y')+543;
        echo $Yearnow;
         ?>
  		</td></tr>

</table>
<div style="text-align:center; margin:10px;">
  <input type="submit" name="btn_save" value="จ่ายเบี้ย"/>
</div>
</div>



</form>
</div>
</fieldset>


<script language="JavaScript">

$(document).ready(function() {
    $('#example').DataTable();
} );

$(function(){

  // add multiple select / deselect functionality
  $("#select_all").click(function () {
        $('.Chk').attr('checked', this.checked);
  });

  // if all checkbox are selected, check the selectall checkbox
  // and viceversa
  $(".Chk").click(function(){

      if($(".case").length == $(".case:checked").length) {
          $("#select_all").attr("checked", "checked");
      } else {
          $("#select_all").removeAttr("checked");
      }

  });
});
</script>
