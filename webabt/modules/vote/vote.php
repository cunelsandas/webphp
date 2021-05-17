<?php
$mod=EscapeValue(decode64($_GET['_mod']));
!empty($_GET['no'])?$no=EscapeValue(decode64($_GET['no'])):null;
!empty($_GET['type'])?$type=EscapeValue(decode64($_GET['type'])):null;

$modname=FindRS("select * from tb_mod where modtype='$mod'","modname");
$bannername=FindRS("select * from tb_mod where modtype='$mod'","bannername");
//			session_start();

			echo "<span class='link'>".$modname."</span>";
			if(isset($_POST['btsave'])){
				$chkver=$_SESSION['vervalue'];
				if($chkver<>$_POST['txtver']){
					echo"คุณกรอกรหัสยืนยันไม่ตรงกับภาพ กรุณาตรวจสอบ";
				}else{
				$masterid=$_POST['txtmasterid'];
				$detailid=$_POST['txtdetail'];
				$browser=getBrowser();
				$device=$browser['device'];
				$platform=$browser['platform'];
				$ip=$_SERVER['REMOTE_ADDR'];
				$session=session_id();
				$sql="insert into vote_result(masterid,detailid,ip,device,platform,session)values('$masterid','$detailid','$ip','$device','$platform','$session')";

				if(empty($detailid)){
					echo "<script>alert('ท่านยังไม่ได้เลือกรายการใดๆ')</script>";
				}else{
					$rs=rsQuery($sql);
					if($rs){
						$_SESSION[$masterid]="1";
						$showvote=<<<showvote
								<script>
									alert('ขอบคุณที่ร่วมแสดงความคิดเห็น เราบันทึกข้อมูลของท่านแล้ว');
								</script>
showvote;
					echo $showvote;
					}
				}
				}
			}
		if(isset($_GET['t'])){
			$masterid=EscapeValue(decode64($_GET['id']));
			$totalvote=FindRS("select count(id) as countid,masterid from vote_result where masterid='$masterid' group by masterid","countid");
			$graphtotalwidth=500;

			$sql="select * from vote_detail where masterid=$masterid Order by id ASC";
			$rs=rsQuery($sql);
			$master_name=FindRS("select * from tb_vote where id=$masterid","name");
			$v_session=session_id();

			$vote=FindRS("select * from vote_result where session='$v_session' and masterid=$masterid","masterid");


			if($vote==$masterid){
				$style="show";
				$enable="disabled";
			}else{
				$style="";
				$enable="";

			}
			if($rs){
				echo '<form name="frmvote" method="POST" action="" enctype="multipart/form-data">';
				echo "<table width='90%' class='content-input'>";
				echo "<tr><th colspan='2'>ขอเชิญร่วมแสดงความเห็นในหัวข้อ&nbsp;&nbsp;$master_name</th></tr>";


				while($detail=mysqli_fetch_assoc($rs)){
					$detail_name=$detail['name'];
					$detail_id=$detail['id'];
					$countid=FindRS("select count(id) as countid,detailid from vote_result where detailid=$detail_id group by detailid","countid");
					$graph.=GraphHorizon($graphtotalwidth,$totalvote,$countid,$detail_id,$detail_name,0,"0");
					echo "<tr><td style='padding-left:5%;padding:20px;'><input type='radio' name='txtdetail' value='$detail_id'>$detail_name</td></tr>";

				}

				echo '<tr><td><img src="itgmod/verify_image.php" style="width:100px;height:30px;"><br><input type="text" name="txtver" style="margin:2px;border:1px solid;height:23px;width:100px;"/></td></tr>';
				echo "<tr><td><input type='hidden' name='txtmasterid' value='$masterid'><input type='submit' name='btsave' value='บันทึก / Vote' $enable></td></tr>";
				echo "</table>";
				echo "</form>";
				echo "<br>";

			}
				if($style=="show"){
				echo "<div id='vote_result' align='center'>";
				echo "<p>ผลการแสดงความคิดเห็น</p>";
				echo "<ul style='list-style:none;width:".$graphtotalwidth."px;background-color:white;'>";
				echo $graph;
				echo "</ul>";
					echo "</div>";
					echo "<a href=\"javascript:history.back()\">ย้อนกลับ</a>";
				}
		}else{


	$sql="select * from tb_vote where status=1 Order by id ASC";
	$rs=rsQuery($sql);
	if($rs){
		echo "<table id='master-table' width='90%'>";
		echo "<tr><th width='70%'>หัวข้อ</th><th width='15%'>วันที่</th><th width='15%'>ผลการแสดงความเห็น</th></tr>";
		while($data=mysqli_fetch_assoc($rs)){
			$name=$data['name'];
			$id=$data['id'];
			$date=thaidate($data['date']);
			echo "<tr><td style='cursor:default;'><a href='index.php?_mod=".encode64('vote')."&t=".encode64('view_vote')."&id=".encode64($id)."' title='ร่วมแสดงความเห็น'>$name</a></td><td style='cursor:default;'>$date</td><td style='cursor:default;'><a href='modules/vote/vote_result.php?m=".encode64($id)."' target='_blank'>ผลสำรวจ</a></td></tr>";
		}
		echo "</table>";

	}
		}
?>
