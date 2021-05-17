	<link rel="stylesheet" type="text/css" href="css/customer.css">
<?php
session_start();
include "itgmod/connect.inc.php";
$id = $_GET['no'];
$mod=decode64($_GET['_mod']);
?>



	<div id="main">
	<table id="newspaper-b">
    <tr>
      
      <th width="45%">รายการ</th>
      <th width="30%">วันที่</th>
      <th width="25%">ดาวน์โหลด</th>
    </tr>
    
        <?php
        //$strsql="select * from $tablename Where active=1 order by no DESC";
       $sql = "select * from wp_posts where id='$id' order by id ";
			$rs = rsQuery($sql);
			if($rs){
				$data = mysqli_fetch_array($rs);


				$text= $data['post_content'];
				$encode=urlencode($text);
				
				$content = $encode;
				$content = str_replace("www.padad.go.th%2Fwp-content%2F","padad.go.th%2F",$content);
				
				$encode= $content;
				$decode =urldecode($encode);

				
				

				
				
//$str = '<a href="https://www.w3schools.com">Go to w3schools.com</a>';
//echo html_entity_decode($str);


            echo "<tr><td align=\"left\">".$data['post_title']."</td><td align=\"left\">".thaidate($data['post_date'])."</td><td align=\"center\">".$decode."</td></tr>";
			}
       
        
    ?>

    </table>
    <center><a href="index.php?_mod=eW9ubHVhbmc">ย้อนกลับ </a></center>
    <?php

    $foldername = "/trash_res/";
    $meta_key = "_wp_attached_file";
    $sqlp = "select * from wp_postmeta where post_id='$id' AND meta_key ='$meta_key' order by meta_id";
    
    $rss1 = rsQuery($sqlp);
	if($rss1){
		$rs_filename=mysqli_fetch_array($rss1);
		
		$cpic=file_exists($foldername.$rs_filename['meta_value']);
		$type=strtolower(substr($rs_filename['meta_value'],-3));
		if($cpic){
			if($type<>"pdf"){
			echo"<img src=..".$foldername.$rs_filename['meta_value']." width=300 height=300>";
			
			}else{
				echo"<a href=".$foldername.$rs_filename['meta_value']." target=\"_blank\"><img src=\"images/pdf.gif\" title=\"ดาวน์โหลดเอกสาร\"></a>&nbsp;&nbsp;";
			}
		}else{
			echo "<tr></tr>";
		}
	




		//$data1 = mysqli_fetch_array($rss1);
			//echo"<img src=..".$foldername.$data1['meta_value']." width=300 height=300>";
		
	}

    ?>
	</div>































	<!--<script language="JavaScript">
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
		$tablename="trash_customer";
		$mod=decode64($_GET['_mod']);
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
			$sql="update $tablename set code='$code',name='$name',bulidingtype='$type',address='$address',phone='$phone',moo='$moo',road='$road',tambol='$tambol',amphur='$amphur',province='$province',price='$price',volum='$volum',remark='$remark',status='$status' Where id=".$_GET['no'];
			$rs=rsQuery($sql);
			if(rs){
				echo"<script>alert('บันทึกข้อมูลเรียบร้อย');window.location.href='main.php?_mod=".encode64($mod)."';</script>";
			}
	}
		if(isset($_GET['no'])){
			$id=$_GET['no'];
			$sql="select * from $tablename where id=$no";
			$rs=rsQuery($sql);
			$data=mysqli_fetch_array($rs);
			$id=$data['id'];
			$code=$data['code'];
			$name=$data['name'];
			$type=$data['bulidingtype'];
			$address=$data['address'];
			$phone=$data['phone'];
			$moo=$data['moo'];
			$road=$data['road'];
			$tambol=$data['tambol'];
			$amphur=$data['amphur'];
			$province=$data['province'];
			$price=$data['price'];
			$volum=$data['volum'];
			$remark=$data['remark'];
			$status=$data['status'];

		}
	?>
	<div id="main">
 <section id="top" class="one dark cover">
	<h3 style="color: black">แก้ไขข้อมูลผู้ขอใช้บริการกำจัดมูลฝอย</h3>
	<form name="form1" id="" action="" method="POST" enctype="multipart/form-data" >
		<table id="table-form">
			<tr>				<th><label>รหัส</label></th><td><input type="text" name="txtid" value="<?php echo $id;?>"></td><th>เลขประจำตัวประชาชน</th><td><input type="text" name="txtcode" value="<?php echo $code;?>"></td>
			</tr>
			<tr>
				<th><label>ประเภทอาคาร</label></th><td>
				
				<?php
				$sql = "select * from tb_buildingtype where id =".$type." ";
				$query1 = rsQuery($sql);
				$result = mysqli_fetch_array($query1);
				$idtype = $result['id'];
				$nametype = $result['type'];
				?>
			<select name="txttype" style="width:60px;" OnChange="resutName(this.value);">
			<option value="<?php echo $id; ?>"><?php echo $nametype; ?></option>
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
					?>
				</td><th>เบอร์โทร</th><td><input type="text" name="txtphone" value="<?php echo $phone; ?>"></td>
			</tr>
			<tr>
				<th>ชื่อ-นามสกุล</th><td colspan="3"><input type="text" name="txtname" value="<?php echo $name;?>"></td>
			</tr>
			<tr>
				<th>ที่อยู่</th><td><input type="text" name="txtaddress"  value="<?php echo $address;?>"></td><th>หมู่ที่</th>
				<td>
					<?php
						echo "<select name=\"txtmoo\" style=\"width:60px;\"><option value=\"$moo\">$moo</option>";
							$i=0;
							for($i=1;$i<=$CustMoo;$i++){
								echo "<option value=$i>$i</option>";
							}
						echo "</select>";
					?>
				</td>
			</tr>
			<tr>
				<th>ถนน</th><td><input type="text" name="txtroad" value="<?php echo $road;?>"></td><th>ตำบล</th><td><input type="text" name="txttambol" value="<?php echo $tambol;?>"></td>
			</tr>
			<tr>
				<th>อำเภอ</th><td><input type="text" name="txtamphur" value="<?php echo $amphur;?>"></td><th>จังหวัด</th><td><input type="text" name="txtprovince" value="<?php echo $province;?>"></td>
			</tr>
			<tr>
				<th><label>อัตราค่าเก็บมูลฝอย</label></th><td><input type="text" name="txtprice" title="จำนวนเงินเป็นตัวเลขเท่านั้น" value="<?php echo $price; ?>"></td><th>ปริมาณขยะ</th><td><input type="text" name="txtvolume" title="ปริมาณขยะ" value="<?php echo $volum; ?>"></td>
			</tr>
			<tr>
				<th>สถานะ</th><td colspan="3">
					<select name="status" style="width: 60px">
						<option value="<?php echo $status; ?>"><?php echo $status; ?></option>
						<option value="ใช้บริการอยู่">ใช้บริการอยู่</option>
						<option value="ยกเลิกใช้บริการแล้ว">ยกเลิกใช้บริการแล้ว</option>
					</select>
				</td>
			</tr>
			<tr>
				<th>หมายเหตุ</th><td colspan="3"><textarea name="txtremark" cols="150" rows="6"><?php echo $remark;?></textarea></td>
			</tr>
			
			<tr>
				<td></td><td colspan="3"><input type="submit" name="btadd" value="บันทึก"></td>
			</tr>
		</table>
		
	</form>
	</section>
	</div>-->