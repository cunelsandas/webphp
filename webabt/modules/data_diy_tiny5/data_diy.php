<?php
	if(isset($_GET['type'])){
			
			$mod=EscapeValue(decode64($_GET['_mod']));
			$tablename=FindRS("select * from tb_mod where modtype='$mod'","tablename");
			$no=EscapeValue(decode64($_GET['type']));
			$sql="select * from $tablename Where no=$no And status=1";
	
		$rs=rsQuery($sql);
		if($rs){
			$data=mysqli_fetch_array($rs);
			$subject=$data['subject'];
			$detail=$data['detail'];
			
			
			echo "<div id=\"diy\" style='padding:20px;'>";
			echo "<span style='font-size: 20px;text-decoration: underline;' class='diy-subject'>$subject</span>";
			echo $detail;
			echo "</div>";
		}else{
			echo $rs;
		}
	}

?>
