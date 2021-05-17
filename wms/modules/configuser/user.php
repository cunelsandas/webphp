<div class="content-box">
<p style="margin-left:10px;">กำหนดผู้ใช้งาน</p><hr><br>
<?php

################## เพิ่มฝ่าย #######################
$modid=$_GET['_modid'];
//if(isset($_POST['btadddep'])){ // เมื่อมีการคลิกปุ่มเพิ่มฝ่าย
//	if($_POST['depname']<>""){
//		$sql="Select * From tb_department Where depname='".$_POST['depname']."'";
//		$rs=rsQuery($sql);
//		if(mysqli_num_rows($rs)==0){
//			$sql="INSERT INTO tb_department(depname) Values('".$_POST['depname']."')";
//			$rssave=rsQuery($sql);
//		}else{
//			echo"<p style=\"margin-left:10px;\">ชื่อ ".$_POST['depname']." นี้มีอยู่แล้วในระบบ</p>";
//		}
//	}
//}
?>

<form name="adddep" method="POST" action="">
<!--<p style="margin-left:10px;">เพิ่มฝ่าย : <input type="text" class="txt" name="depname" autocomplete="off" style="width:250px;" />&nbsp;<input class="bt" type="submit" name="btadddep" value="เพิ่มฝ่าย"/></p> -->
</form>

<!-- ################# จบเพิ่มฝ่าย ######################## -->

<?php
if(isset($_GET['del'])){
	$del=EscapeValue($_GET['del']);
	$sql="Delete From tb_user Where userid='".$del."'";
	$rsdel=rsQuery($sql);
	$sql="Delete From tb_select_mod Where userid='".$del."'";
	$rsdel=rsQuery($sql);
}
if(isset($_GET['edit'])){ // เมื่อมีการแก้ไขข้อมูลของผู้ใช้งาน
		$edit=EscapeValue($_GET['edit']);
		if(isset($_POST['btedituser'])){
			
			$sql="UPDATE tb_user SET 			nameuser='".EscapeValue($_POST['txtnameuser'])."',surname='".EscapeValue($_POST['txtsurname'])."',username='".EscapeValue($_POST['txtusername'])."',pw='".EscapeValue(md5($_POST['txtpassword']))."',pwfix='".EscapeValue($_POST['txtpassword'])."',depid='".EscapeValue($_POST['dep'])."' Where userid='".$edit."'";
			$rssave=rsQuery($sql);
			$sql="Delete From tb_select_mod Where userid='".$edit."'";
			$rsdel=rsQuery($sql);
				for($i=0;$i<count($_POST['mod']);$i++){
					$sql="INSERT INTO tb_select_mod(userid,modid) Values('".$edit."','".$_POST['mod'][$i]."')";
					$rsmod=rsQuery($sql);
				}
				//echo"<script>window.location.href='main.php?_mod=".$_GET['_mod']."';</script>";
		}
	
		$sql="Select * From tb_user Where userid='".$edit."'";
		$rs=rsQuery($sql);
		$ruser=mysqli_fetch_assoc($rs);
		$name=$ruser['nameuser'];
		$surname=$ruser['surname'];
		$username=$ruser['username'];
		$password=$ruser['pwfix'];
		$depid=$ruser['depid'];
		$btname="btedituser";
		$btvalue="แก้ไขข้อมูลผู้ใช้";
}else{
			if(isset($_POST['btadduser'])){
				$sql="Select username From tb_user Where username='".$_POST['txtusername']."'";
				$rs=rsQuery($sql);
				if(mysqli_num_rows($rs)==0){
					$sql="INSERT INTO tb_user(nameuser,surname,username,pw,pwfix,depid) Values('".$_POST['txtnameuser']."','".$_POST['txtsurname']."','".$_POST['txtusername']."','".md5($_POST['txtpassword'])."','".$_POST['txtpassword']."','".$_POST['dep']."')";
					$username=$_POST['txtusername'];
					$rssave=rsQuery($sql);
					if($rssave){
						$strSQL="select * from tb_user where username='".$username."'";
						$re=rsQuery($strSQL);
						$uid=mysqli_result($re,0,"userid");
						for($i=0;$i<count($_POST['mod']);$i++){
							$sqlADD="INSERT INTO tb_select_mod(userid,modid) Values('".$uid."','".$_POST['mod'][$i]."')";
							$rsmod=rsQuery($sqlADD);
						}
					}
								//echo"<script>window.location.href='main.php?_mod=".$_GET['_mod']."';</script>";
				}else{
					echo"<p> User name ซ้ำ</p>";
				}
			}
		$name="";
		$surname="";
		$username="";
		$password="";
		$depid="";
		$btname="btadduser";
		$btvalue="เพิ่มผู้ใช้งาน";
}
	?>
	
	<form name="frmuser" method="POST" action="">
	<table width="50%" class="content-input">
	<tr >
		<td align="right">ชื่อผู้ใช้</td>
		<td><input class="txt" type="text" name="txtnameuser" value="<?php echo $name;?>"/></td>
	</tr>
	<tr >
		<td align="right">นามสกุล</td>
		<td><input class="txt" type="text" name="txtsurname" value="<?php echo $surname;?>" /></td>
	</tr>
	<tr >
		<td align="right">User name</td>
		<td><input class="txt" type="text" name="txtusername" value="<?php echo $username;?>" /></td>
	</tr>
	<tr >
		<td align="right">Password</td>
		<td><input class="txt" type="text" name="txtpassword" value="<?php echo $password;?>" /></td>
	</tr>
	<tr >
		<td align="right">ฝ่าย</td>
		<td><select class="txt" name="dep"><option value="">- - - - กรุณาเลือกฝ่าย - - - -</option>
			
			
		<?php
		if($depid=="0"){
				echo "<option value=\"0\" selected>ผู้ดูแลระบบ</option>";
		}else{
				echo "<option value=\"0\">ผู้ดูแลระบบ</option>";
		}
		$sql="Select * From tb_officertype WHERE listno>0 Order by listno";
		$rs=rsQuery($sql);
		while($row=mysqli_fetch_assoc($rs)){
			if($depid==$row['id']){
				echo"<option value=\"".$row['id']."\" selected>".$row['name']."</option>";
			}else{
				echo"<option value=\"".$row['id']."\">".$row['name']."</option>";
			}
		}
		?>
		</select>
		</td>
	</tr>
	<tr >
		<td align="right" valign="top">กำหนดสิทธิ์การเข้าใช้งาน</td>
		<td valign="top">
		<?php
		$sql="Select * from tb_mod Order by modid";
		$rs=rsQuery($sql);
		while($row=mysqli_fetch_assoc($rs)){
			$sql="Select * From tb_select_mod Where userid='".$_GET['edit']."' And modid='".$row['modid']."'";
			$rsmod=rsQuery($sql);
			if(mysqli_num_rows($rsmod)>0){
				echo"<input type=\"checkbox\" name=\"mod[]\" value=\"".$row['modid']."\" checked/>&nbsp;".$row['modname']."<br />";
			}else{
				echo"<input type=\"checkbox\" name=\"mod[]\" value=\"".$row['modid']."\"/>&nbsp;".$row['modname']."<br />";
			}
		}
		?>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><input class="bt" type="submit" name="<?php echo $btname;?>" value="<?php echo $btvalue;?>"/></td>
	</tr>
	</table>
	</form>
	
	<br>
<table width="50%" class="content-table">	
<tr height="30">
	<td width="70%" align="center">ชื่อผู้ใช้งาน</td>
	<td width="30%" align="center">ปรับปรุง</td>
</tr>

<?php
$sql="Select * from tb_user Order by userid";
$rs=rsQuery($sql);
if(mysqli_num_rows($rs)==0){
	echo"<tr ><td colspan=\"2\" align=\"center\">- - - - - ยังไม่มีการเพิ่มผู้ใช้ - - - - -</td></tr>";
}else{
	empty($_GET['_mod'])?$mod="":$mod=$_GET['_mod'];
	while($row=mysqli_fetch_assoc($rs)){
		echo"<tr >";
		echo"<td>&nbsp;".$row['nameuser']."</td>";
		echo"<td align=\"center\"><a href=\"main.php?_modid=".$modid."&_mod=$mod&edit=".$row['userid']."\"><img src=\"../images/component/edit.png\" width=\"18\" border=\"0\" /></a>&nbsp;&nbsp;<a href=\"main.php?_modid=".$modid."&_mod=$mod&del=".$row['userid']."\" onclick=\"return confirm('คุณต้องการลบผู้ใช้งานนี้หรือไม่ค่ะ ?');\"><img src=\"../images/component/del.png\" width=\"18\" border=\"0\" /></a></td>";
		echo"</tr>";
	}
}
?>
</table>
</div>