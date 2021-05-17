<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title> New Document </title>
  <meta name="Generator" content="EditPlus">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
 </head>
	<?php
			$tablename="tb_menutop";
			$foldername="/images/";
			$btname="addnew";
			if(isset($_GET['del'])){
				$strdel="delete from $tablename Where id=".$_GET['del'];
				$bannername=FindRS("select * from $tablename where id=".$_GET['del'],"bannername");
				$rsdel=rsQuery($strdel);
				if($rsdel){
					unlink($_SERVER['DOCUMENT_ROOT'].$foldername.$bannername);	
				}
			}

			if(isset($_POST['delbanner'])){
				//ลบรูป
				$delid=$_POST['bannerid'];
				$delname=FindRS("select * from $tablename where id=".$delid,"bannername");
				$strdel="Update $tablename SET bannername='' Where id=".$delid;
				$rs=rsQuery($strdel);
				unlink($_SERVER['DOCUMENT_ROOT'].$foldername.$bannername);	
			}
			if(isset($_GET['addnew'])){
				$btname="addnew";
			}

			if(isset($_POST['btsave'])){
				$id=$_POST['id'];
				$name=$_POST['txtname'];
				$modid=$_POST['cbomodules'];
				$listno=$_POST['txtlistno'];
				$filebanner=$_FILES['txtbannername']['name'];
				if(!empty($filebanner)){
						$bannername=$filebanner;
					}else{
						$bannername=$_POST['txtbanner'];
				} 
				switch($_POST['btsave']){
					case "addnew":
						$sql="insert into $tablename (modid,name,listno,bannername) values('$modid','$name','$listno','$bannername')";
						$stralert="บันทึกข้อมูลใหม่แล้ว";
						break;
					case "edit":
						$sql="Update $tablename SET modid='$modid',name='$name',listno='$listno',bannername='$bannername' Where id='$id'";
						$stralert="แก้ไขข้อมูลแล้ว";
						break;
				}
				$rs=rsQuery($sql);
				if($rs){
					copy($_FILES['txtbannername']['tmp_name'],$_SERVER['DOCUMENT_ROOT'].$foldername.$_FILES['txtbannername']['name']);
					echo $stralert;
					echo"<script>window.location.href='main.php?_modid=".$modid.";</script>";
				}
			}
			if(isset($_GET['edit'])){
				$btname="edit";
				$sql="select * from $tablename Where id=".$_GET['edit'];
				$rs=rsQuery($sql);
				if($rs){
					$data=mysqli_fetch_assoc($rs);
					$v_id=$data['id'];
					$v_modid=$data['modid'];
					$v_name=$data['name'];
					$v_listno=$data['listno'];
					$v_bannername=$data['bannername'];
				}
			}
	?>
 <body>
<div class='content-box'>
		<p style="margin-left:10px;">สร้างเมนูด้านบน ( menutop )</p><hr><br>
		<p style="right:12%;position:absolute;"><?php echo"<a href=\"main.php?_modid=".$_GET['_modid']."&_mod=".$_GET['_mod']."&addnew=addnew\"  class='link'>เพิ่มรายการใหม่</a>";?></p><Br><br>
		<form name="frmdata" method="POST" action="" enctype="multipart/form-data">
			<table width="85%" class="content-input">
				<tr>
					<td>id</td><td><?php echo $v_id;?><input type="hidden" name="id" value="<?php echo $v_id;?>"></td>
				</tr>
				<tr>
					<td>modules</td><td>
							<select name="cbomodules">
								<option value="0">หน้าหลัก/home</option>
								<?php
										$sql="select * from tb_mod where typeid<=3 order by modtype "; // เอาเฉพาะ เนื้อหา ส่วนประกอบและบริการออนไลน์
										$rs=rsQuery($sql);
										if($rs){
											while($data=mysqli_fetch_assoc($rs)){
												if($v_modid==$data['modid']){
													echo "<option value='".$data['modid']."' selected>".$data['modtype']."  ".$data['modname']."</option>";
												}else{
													echo "<option value='".$data['modid']."'>".$data['modtype']."  ".$data['modname']."</option>";
												}
											}
										}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td>ชื่อเมนู</td><td><input type="text" name="txtname" value="<?php echo $v_name;?>" placeholder="ชื่อที่ต้องการให้แสดงในเมนูด้านบน menutop" style="width:80%"></td>
					</tr>
					<tr>
						<td>รูปเมนู</td><td><input type="file" name="txtbannername" placeholder="รูปเมนู">&nbsp;&nbsp;
							<?php
								if($v_bannername<>""){
									echo "<input type='text' name='txtbanner' value='".$v_bannername."'><input type='submit' name='delbanner' value='ลบรูป'><input type='hidden' name='bannerid' value='".$v_id."'>";
								}else{
									echo "<input type='text' name='txtbanner' value='".$v_bannername."' placeholder='ยังไม่มีรูป'>";
								}
							?>
						</td>
					</tr>
					<tr>
						<td>ลำดับการแสดงผล จากซ้ายไปขวา</td><td><input type="text" name="txtlistno" value="<?php echo $v_listno;?>"> *ตัวเลขเท่านั้น 0 ไม่แสดง</td>
					</tr>
					<tr>
						<td></td><td><input type="submit" name="btsave" value="<?php echo $btname;?>"></td>
					</tr>
			</table>
		</form>
	</div>
	<br>
	
			<table class="content-table" width="85%">
				<tr>
					<th width="15%">ลำดับการแสดงผล</th>
					<th width='60k%'>ชื่อเมนู</th>
					<th width='15%'>จัดการ</th>
				</tr>
				<?php
					$sql="select * from tb_menutop order by listno";
					$rs=rsQuery($sql);
					if($rs){
						while($data=mysqli_fetch_assoc($rs)){
							echo "<tr>";
							echo "<td align='center'>".$data['listno']."</td>";
							echo "<td align='left'>".$data['name']."</td>";
							echo "<td align=\"center\"><a href=\"main.php?_modid=".$_GET['_modid']."&_mod=".$_GET['_mod']."&edit=".$data['id']."\"><img src=\"../images/component/edit.png\" width=\"18\" border=\"0\" /></a>&nbsp;&nbsp;<a href=\"main.php?_modid=".$_GET['_modid']."&_mod=".$_GET['_mod']."&del=".$data['id']."\" onclick=\"return confirm('คุณต้องการลบใช่หรือไม่?');\"><img src=\"../images/component/del.png\" width=\"18\" border=\"0\" /></a></td>";
							echo "</tr>";
						}
					}
				?>
			</table>
	
 </body>
</html>
