
 <?php
	$search=$_GET['search'];
  $last_msg_id=$_GET['last_msg_id'];
		$sqlActivity="SELECT * FROM tb_activity  where subject LIKE '".$search."%' AND no< $last_msg_id ORDER BY no DESC LIMIT 5";
		
		$sqlNews="SELECT * from tb_news where subject LIKE '".$search."%' AND no< $last_msg_id ORDER BY no DESC LIMIT 5";
		$sqlPurchase="SELECT * from tb_purchase where subject LIKE '".$search."%'  AND no< $last_msg_id ORDER BY no DESC LIMIT 5";
		$sql="select * from (select 'activity' as modname,datepost,no as n_id,subject as n_name,@n:= @n+1  n				
										from tb_activity, (SELECT @n := 0) m Where subject LIKE '".$search."%'  union all
									select 'news' as modname,datepost,no as n_id,subject as n_name	,@n:= @n+1  n										
										from tb_news, (SELECT @n := 0) m Where subject LIKE '".$search."%' union all
									select 'purchase' as modname,datepost,no as n_id,subject as n_name,@n:= @n+1  n
											from tb_purchase, (SELECT @n := 0) m Where subject LIKE '".$search."%' )a order by n ASC Limit $last_msg_id,5";
		
$last_msg_id="";
	
		$rs=rsQuery($sql);
		if($rs){
		
			
			while($data=mysqli_fetch_array($rs)){
				$subject=$data['n_name'];
				$no=$data['n_id'];
				$id=$data['n'];
				$mod=$data['modname'];
				$tablename=FindRS("select * from tb_mod where modtype='$mod'","tablename");
			$folder=FindRS("select * from tb_mod where modtype='$mod'","foldername");
			$modname=FindRS("select * from tb_mod where modtype='$mod'","modname");
			$bannername=FindRS("select * from tb_mod where modtype='$mod'","bannername");
			$foldername=$gloUploadPath."/".$folder."/";
				$datepost=datethai($data['datepost']);
				$img=SearchImage($tablename,$no,$foldername,"0");
				echo '<div id="'. $id.'" class="message_box" > '.$id;
				echo "<table>";
				echo "<tr>";
				echo "<td width='30%'>";
				echo "<a href=../../index.php?_mod=".encode64($mod)."&no=".encode64($no)." ><img src='$showimage' width='200' height='200'>";
				echo "</td>";
				echo "<td width='70%'>$subject<br>$datepost</td>";
				echo "</tr></table>";
				echo "</div>";
			}
}

/*
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
				
				$img=SearchImage($tablename,$no,$foldername,"0");
				echo '<div id="'. $no.'" class="message_box" > $no';
				echo "<table>";
				echo "<tr>";
				echo "<td width='30%'>";
				echo "<a href=index.php?_mod=".encode64($mod)."&no=".encode64($no)." ><img src='$showimage' width='200' height='200'>";
				echo "</td>";
				echo "<td width='70%'>$no&nbsp;$subject</td>";
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
				
				$img=SearchImage($tablename,$no,$foldername,"0");
				echo '<div id="'. $no.'" class="message_box" > $no';
				echo "<table>";
				echo "<tr>";
				echo "<td width='30%'>";
				echo "<a href=index.php?_mod=".encode64($mod)."&no=".encode64($no)." ><img src='$showimage' width='200' height='200'>";
				echo "</td>";
				echo "<td width='70%'>$no&nbsp;$subject</td>";
				echo "</tr></table>";
				echo "</div>";
			}
}
*/
?>
 </body>
</html>
