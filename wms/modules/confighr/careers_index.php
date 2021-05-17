<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title> New Document </title>
 <meta http-equiv="content-type" content="text/html; charset=utf-8" />
 </head>

 <body>
	<?php
			$modid=$_GET['_modid'];
			$modname=FindRS("select modname from tb_mod where modid=$modid","modname");
			$tablename=FindRS("select tablename from tb_mod where modid=$modid","tablename");

			echo "<p >$modname</p><hr><br>";
			!empty($_GET['id'])?$id=$_GET['id']:null;
			if($id<>""){
				include"careers_application.php";
			}else{	
			$sql="select * from $tablename Order by dateregis DESC";
			$rs=rsQuery($sql);
			if($rs){
				echo "<table class='content-table' width='90%'>";
				echo "<tr>";
				echo "<th width='15%'>วันที่สมัคร</th>";
				echo "<th width='20%'>ชื่อ-นามสกุล</th>";
				echo "<th width='15%'>ตำแหน่งที่สมัคร</th>";
				echo "<th width='10%'>เงินเดือนคาดหวัง</th>";
				echo "<th width='15%'>อีเมล์</th>";
				echo "<th width='15%'>หมายเลขโทรศัพท์</th>";
				echo "</tr>";
				while($data=mysqli_fetch_assoc($rs)){
					$dateregis=DateThai($data['dateregis']);
					$nameth=$data['nameth'];
					$position=$data['position'];
					$salary=$data['salary'];
					$email=$data['email'];
					$telephone=$data['telephone'];
					$mobile=$data['mobile'];
					echo "<tr style='cursor:pointer;' onclick=\"window.location='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&id=".$data['id']."'\">";
					echo "<td>$dateregis</td><td>$nameth</td><td>$position</td><td>$salary</td><td>$email</td><td>$telephone , $mobile</td>";
					echo "</tr>";
				}
				echo "</table>";
			}else{
				echo "ยังไม่มีข้อมูล";
			}
			}
	?>
 </body>
</html>
