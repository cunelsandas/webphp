<link rel="stylesheet" type="text/css" href="css/customer.css">
<script language="JavaScript">
  function resutName(CusID)
  {
    switch(CusID)
    {
      <?php
      $strSQL = "SELECT * FROM tb_buildingtype ORDER BY id ASC";
      $objQuery = rsQuery($strSQL);
      while($objResult = mysqli_fetch_array($objQuery))
      {
      ?>
        case "<?php echo $objResult["id"];?>":
        form1.txtprice.value = "<?php echo $objResult["price"];?>";
        break;
      <?php
      }
      ?>
      default:
       form1.txtprice.value = "";
    }
  }
</script>
  <?php
    $mod=decode64($_GET['_mod']);
    $tablename="trash_customer";
    if($_POST['btadd']){
      $code=$_POST['txtcode'];
      $name=$_POST['txtname'];
      $type=$_POST['txttype'];
      $address=$_POST['txtaddress'];
      $phone=$_POST['txtphone'];
      $moo=$_POST['txtmoo'];
      $road=$_POST['txtroad'];
      $tambol=$_POST['txttambol'];
      $amphur=$_POST['txtamphur'];
      $province=$_POST['txtprovince'];
      $price=$_POST['txtprice'];
      $volum=$_POST['txtvolume'];
      $remark=$_POST['txtremark'];
      $status=$_POST['status'];
      $sql="insert into $tablename(code,name,bulidingtype,address,phone,moo,road,tambol,amphur,province,price,volum,remark,status) value('$code','$name','$type','$address','$phone','$moo','$road','$tambol','$amphur','$province','$price','$volum','$remark','$status')";
      $rs=rsQuery($sql);
      if(rs){
        echo"<script>alert('บันทึกข้อมูลเรียบร้อย');window.location.href='main.php?_mod=".encode64($mod)."';</script>";
      }
  }
  ?>
<div id="main">
 <section id="top" class="one dark cover">
  <h3 style="color: black">ลงทะเบียนผู้ขอใช้บริการกำจัดมูลฝอย</h3>
  <form name="form1" id="" action="" method="POST" enctype="multipart/form-data" >
    <table id="table-form">
      <tr>
        <th><label>รหัส</label></th><td><input type="text" name="txtid"></td><th>เลขประจำตัวประชาชน</th><td><input type="text" name="txtcode"></td>
      </tr>
      
      <tr>
        <th><label>ประเภทอาคาร</label></th><td>
        <select name="txttype" style="width:60px;" OnChange="resutName(this.value);">
      <option value=""><-- เลือก --></option>
      <?php
      $strSQL = "SELECT * FROM tb_buildingtype ORDER BY id ASC";
      $objQuery = rsQuery($strSQL);
      while($objResult = mysqli_fetch_array($objQuery))
      {
      ?>
      <option value="<?php echo $objResult["id"];?>"><?php echo $objResult["type"];?></option>
      <?php
      }
      ?>
      </select>

          <!--<?php
            $sql = "";
            $query = rsQuery($sql);
            if ($query) {
              
                echo "<select name=\"txttype\" ><option value=\"\">เลือก</option>";
              while ($data = mysqli_fetch_array($query)) {
                  
                echo "<option value=".$data['id']." >".$data['type']."</option>";
              }
            echo "</select>";
              
            }
          ?>-->
        </td><th>เบอร์โทร</th><td><input type="text" name="txtphone"></td>
      </tr>
      <tr>
        <th><label>ชื่อ-นามสกุล</label></th><td colspan="3"><input type="text" name="txtname" style="width: 34%"></td>
      </tr>
      <tr>
        <th><label>ที่อยู่</label></th><td><input type="text" name="txtaddress"></td><th>หมู่ที่</th>
        <td>
          <?php
            echo "<select name=\"txtmoo\" style=\"width:60px;\"><option value=\"\">เลือก</option>";
              $i=0;
              for($i=1;$i<=$CustMoo;$i++){
                echo "<option value=$i>$i</option>";
              }
            echo "</select>";
          ?>
        </td>
      </tr>
      <tr>
        <th><label>ถนน</label></th><td><input type="text" name="txtroad"></td><th>ตำบล</th><td><input type="text" name="txttambol" value="<?php echo $CustTambol;?>"></td>
      </tr>
      <tr>
        <th><label>อำเภอ</label></th><td><input type="text" name="txtamphur" value="<?php echo $CustAmphur;?>"></td><th>จังหวัด</th><td><input type="text" name="txtprovince" value="<?php echo $CustProvince;?>"></td>
      </tr>
      
      <tr>
        <th><label>อัตราค่าเก็บมูลฝอย</label></th><td><input type="text" name="txtprice" title="จำนวนเงินเป็นตัวเลขเท่านั้น" value=""></td><th>ปริมาณขยะ</th><td><input type="text" name="txtvolume" title="ปริมาณขยะ"></td>
      </tr>
      <tr>
        <th><label>สถานะ</label></th><td colspan="3">
          <select name="status" style="width: 60px">
            <option value="ใช้บริการอยู่">ใช้บริการอยู่</option>
            <option value="ยกเลิกใช้บริการแล้ว">ยกเลิกใช้บริการแล้ว</option>
          </select>
        </td>
      </tr>
      <tr>
        <th><label>หมายเหตุ</label></th><td colspan="3"><textarea name="txtremark" cols="150" rows="6"></textarea></td>
      </tr>
      
      <tr>
        <td></td><td colspan="3"><input type="submit" name="btadd" value="บันทึก"></td>
      </tr>
    </table>
    
  </form>
  </section>
</div>