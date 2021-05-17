
<?php

	if(isset($_POST['txtsearch'])){
		
		$search=EscapeValue($_POST['txtsearch']);
		
		if($search<>""){

		$sqlActivity="select * from tb_activity where subject like '".$search."%' Order by datepost DESC";
		$sqlNews="select * from tb_news where subject like '".$search."%' Order by datepost DESC";
		$sqlPurchase="select * from tb_purchase where subject like '".$search."%' Order by datepost DESC";

		$rs=rsQuery($sqlActivity);
		if($rs){
			$mod="activity";
			$tablename=FindRS("select * from tb_mod where modtype='$mod'","tablename");
			$folder=FindRS("select * from tb_mod where modtype='$mod'","foldername");
			$modname=FindRS("select * from tb_mod where modtype='$mod'","modname");
			$bannername=FindRS("select * from tb_mod where modtype='$mod'","bannername");
			$foldername=$gloUploadPath."/".$folder."/";
			while($data=mysqli_fetch_array($rs)){
				$subject=$data['subject'];
				$no=$data['no'];
				$row_number=$data['row_number'];
				$img=SearchImage($tablename,$no,$foldername,"0");
				echo '<div id="<?php echo $row_number; ?>" class="message_box" > ';
				echo "<table>";
				echo "<tr>";
				echo "<td width='30%'>";
				echo "<a href=index.php?_mod=".encode64($mod)."&no=".encode64($no)." ><img src='$showimage' width='200' height='200'>";
				echo "</td>";
				echo "<td width='70%'>$subject</td>";
				echo "</tr></table>";
				echo "</div>";
			}
}


$rs=rsQuery($sqlNews);
		if($rs){
			echo "<hr>";
			$mod="news";
			$tablename=FindRS("select * from tb_mod where modtype='$mod'","tablename");
			$folder=FindRS("select * from tb_mod where modtype='$mod'","foldername");
			$modname=FindRS("select * from tb_mod where modtype='$mod'","modname");
			$bannername=FindRS("select * from tb_mod where modtype='$mod'","bannername");
			$foldername=$gloUploadPath."/".$folder."/";
			while($data=mysqli_fetch_array($rs)){
				$subject=$data['subject'];
				$no=$data['no'];
				$row_number=$data['row_number'];
				$img=SearchImage($tablename,$no,$foldername,"0");
				echo '<div id="<?php echo $row_number; ?>" class="message_box" > ';
				echo "<table>";
				echo "<tr>";
				echo "<td width='30%'>";
				echo "<a href=index.php?_mod=".encode64($mod)."&no=".encode64($no)." ><img src='$showimage' width='200' height='200'>";
				echo "</td>";
				echo "<td width='70%'>$subject</td>";
				echo "</tr></table>";
				echo "</div>";
			}
}

$rs=rsQuery($sqlPurchase);
		if($rs){
			
			echo "<hr>";
			$mod="purchase";
			$tablename=FindRS("select * from tb_mod where modtype='$mod'","tablename");
			$folder=FindRS("select * from tb_mod where modtype='$mod'","foldername");
			$modname=FindRS("select * from tb_mod where modtype='$mod'","modname");
			$bannername=FindRS("select * from tb_mod where modtype='$mod'","bannername");
			$foldername=$gloUploadPath."/".$folder."/";
			while($data=mysqli_fetch_array($rs)){
				$subject=$data['subject'];
				$no=$data['no'];
				$row_number=$data['row_number'];
				$img=SearchImage($tablename,$no,$foldername,"0");
				echo '<div id="<?php echo $row_number; ?>" class="message_box" > ';
				echo "<table>";
				echo "<tr>";
				echo "<td width='30%'>";
				echo "<a href=index.php?_mod=".encode64($mod)."&no=".encode64($no)." ><img src='$showimage' width='200' height='200'>";
				echo "</td>";
				echo "<td width='70%'>$subject</td>";
				echo "</tr></table>";
				echo "</div>";
			}
}
		echo '</div></ul>';
		}else{
			echo "ไม่พบข้อมูล";
		}
	
}

?>
