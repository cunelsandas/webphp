<div class="content-box">
<?php

empty($_GET['type'])?$type="":$type=$_GET['type'];
$modid=$_GET['_modid'];
$modname=FindRS("select modname from tb_mod where modid=$modid","modname");
$tablename=FindRS("select tablename from tb_mod where modid=$modid","tablename");

echo "<p >$modname</p>";


$btname="addnew";
	if(isset($_GET['del'])){
		$sql="DELETE From $tablename Where fid='".EscapeValue($_GET['del'])."'";
		$rs=rsQuery($sql);
		if($rs){
				// update table tb_trans บันทึกการเพิ่มข้อมูล
		$updatetran=UpdateTrans('$tablename','delete',$_SESSION['username'],'ID:'.$_GET['del']);
			echo"<script>window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
		}
	}

if(isset($_GET['type'])){
	$type=$_GET['type'];
	if($type=="addnew"){
	$v_name="";
	$v_listno="";
	$btname="addnew";
	$v_groupid="0";
	}
}

if(isset($_GET['id'])){
	$id=$_GET['id'];
	$sql="select * from $tablename where fid='$id'";
	$rs1=rsQuery($sql);
	if($rs1){
		$data=mysqli_fetch_assoc($rs1);
		$v_id=$data['fid'];
		$v_name=$data['name'];
		$v_listno=$data['listno'];
		$v_groupid=$data['groupid'];
		$btname="edit";
	}
}

if(isset($_POST['btsave'])){
	$btname=$_POST['btsave'];
	$fid=EscapeValue($_POST['txtid']);
	$name=EscapeValue($_POST['txtname']);
	$listno=EscapeValue(empty($_POST['txtlistno'])?"0":$_POST['txtlistno']);
	$groupid=$_POST['cbogroupid'];
	if($btname=="addnew"){
		$strsql="insert into $tablename(name,listno,groupid)values('$name','$listno','$groupid')";
		$alert="เพิ่มข้อมูลเรียบร้อย";
	}
	if($btname=="edit"){
		$strsql="update $tablename SET name='$name',listno='$listno',groupid='$groupid' Where fid='$fid'";
		$alert="แก้ไขข้อมูลเรียบร้อย";
	}
	$rsupdate=rsQuery($strsql);
		if($rsupdate){
			echo"<script>alert('".$alert."');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
		}
	
}
?>





<form name="frmnews" method="POST" action="" enctype="multipart/form-data">
<table width="100%" class="content-input">
	<tr><td width="20%">id=<?php echo $v_id;?><input type="hidden" name="txtid" value="<?php echo $v_id;?>"></td><td></td></tr>
	<tr><td>กลุ่มเมนู (menu group)</td><td><select name="cbogroupid"><option value='0'>ไม่เลือกกลุ่มเมนู</option>
		<?php
			$sql="select * from tb_menugroup order by id";
			$rs=rsQuery($sql);
			if($rs){
				while($data=mysqli_fetch_assoc($rs)){
					$name=$data['name'];
					$id=$data['id'];
					if($v_groupid==$id){
						echo "<option value='$id' selected>$name</option>";
					}else{
						echo "<option value='$id'>$name</option>";
					}
			}
			}
		?>
		</select>
		</td></tr>
	<tr><td>ชื่อ</td><td><input type="text" name="txtname" value="<?php echo $v_name;?>" size="100"></td></tr>
	<tr><td>ลำดับการแสดงผล(0=ไม่แสดง)</td><td><input type="text" name="txtlistno" value="<?php echo $v_listno;?>">
		<br><p>สำหรับประเภทไฟล์เอกสารที่ต้องการสร้างแบนเนอร์ ให้กำหนดลำดับการแสดงเป็น 0 </p></td></tr>
	<tr><td></td><td><input type="submit" name="btsave" value="<?php echo $btname;?>"></td></tr>
</table>
</form>
<br>
<center>
<span style="right:12%;position:absolute;"><?php echo"<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=addnew\" class='link'>เพิ่มรายการใหม่</a>";?></span>
<p style="text-align:left;margin-bottom:3px;margin-left:10px;"><img src="../images/component/02.png"/> = active : <img src="../images/component/01.png" /> = not active </p>
<br>
<table class="content-table">

<thead>
		<tr>
			<th width="30%" class="topleft">กลุ่มเมนู (menu group)</th>
			<th width="40%" >ชื่อ</th>
			
			<th width="15%" align="center">เรียงลำดับ</th>
			
			<th width="15%" align="center" class="topright">ปรับปรุง</th>
		</tr>
	</thead>
	  <tfoot>
    	<tr>
        	<td colspan="3" class="botleft"><em></em></td>
        	<td class="botright">&nbsp;</td>
        </tr>
    </tfoot>
<?php
############################# แบ่งหน้าเพื่อให้แสดงผลรวดเร็ว #######################

	
	
$sql="select * from $tablename order by groupid,listno";

$Query = rsQuery($sql); //คิวรี่คำสั่ง
	$totalp = mysqli_num_rows($Query); // หาจำนวน record ที่เรียกออกมา
	if($totalp==0){
		echo"<tr height=\"30\">";
		echo"<td colspan=\"5\" align=\"center\">- - - - - - - - - - ยังไม่มีข้อมูล - - - - - - - - - -</td>";
		echo"</tr>";
		/*	วนลูปข้อมูล */
	}else{
		$i=$start;
		while($arr = mysqli_fetch_assoc($Query)){
			$groupid=$arr['groupid'];
			$groupname=FindRS("select * from tb_menugroup where id='$groupid'","name");
			echo"<tr >";
			echo "<td>$groupname</td>";
		
			echo"<td>".$arr['name']."</td>";
			echo"<td>".$arr['listno']."</td>";
			
			echo"<td align=\"center\"><a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=view&id=".$arr['fid']."\"><img src=\"../images/component/docs_16.gif\" border=\"0\" /></a>&nbsp;&nbsp;&nbsp;<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&del=".$arr['fid']."\" onclick=\"return confirm('คุณต้องการลบหัวข้อนี้หรือไม่?');\"><img src=\"../images/component/del_16.gif\" border=\"0\"/></a></td>";
			echo"</tr>";			
			$i++;
		}
	}
	echo"</table>";
?>
</div>