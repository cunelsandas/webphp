<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title> ข้อมูลเก่า</title>
  <meta name="Generator" content="EditPlus">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
 </head>

 <body>

	<form name="form1" method="POST" action="" autocomplete="off">
		<table width='90%'>
			<tr>
				<td>ประเภท</td><td><select name='cbocat'><option value='0'>เลือกประเภท</option>
					<?php
						$sql="select * from olddata_news_category Order by id";
						$rs=rsQuery($sql);
						if($rs){
							while($data=mysqli_fetch_assoc($rs)){
								$id=$data['id'];
								$name=$data['category_name'];
								echo "<option value='$id'>$name</option>";
							}
						}
						
					?>
					</select>&nbsp;&nbsp;<input type='submit' name='btfind' value='ค้นหา'>
					</td>
			</tr>
		</table>
		</form>
		<br>
		<div id='master-table' width='90%' align='right'>
		<table width='80%'>
			<tr>
				<th>วันที่</th>
				<th>รายการ</th>
				<th>รายละเอียด</th>
				<th>เอกสาร</th>
			</tr>
			<?php
			$mod=EscapeValue(decode64($_GET['_mod']));
			$tablename=FindRS("select * from tb_mod where modtype='$mod'","tablename");
			$folder=FindRS("select * from tb_mod where modtype='$mod'","foldername");
			$modname=FindRS("select * from tb_mod where modtype='$mod'","modname");
			$bannername=FindRS("select * from tb_mod where modtype='$mod'","bannername");
			$foldername=$gloUploadPath."/".$folder."/";

				if(isset($_POST['btfind'])){
					$str="select * from olddata_news where category='".$_POST['cbocat']."' Order by post_date";
					$rs=rsQuery($str);
					if($rs){
						while($data=mysqli_fetch_assoc($rs)){
							$date_eng=date('Y-m-d',$data['post_date']);
							$date=DateThai($date_eng);
							$subject=$data['topic'];
							$detail=$data['headline'];
							$attach=$data['attach'];
							echo "<tr><td>$date</td><td>$subject</td><td>$detail</td><td><a class=\"list\" href=".$foldername.$attach." target='_blank'>Download</a></td></tr>";
						}
					}
				}
			?>
			</table>
			</div>
 </body>
</html>
