<?php
$modid=$_GET['_modid'];
$mod=$_GET['_mod'];
$type=$_GET['type'];

?>
<div class='content-input'>
	<table width='100%'>
			<tr>
				<td><?php echo "<a href='main.php?_modid=".$modid."&_mod=".$mod."&type=ita_menu'>หัวข้อหลัก</a>";?></td>
				<td><?php echo "<a href='main.php?_modid=".$modid."&_mod=".$mod."&type=ita_submenu'>หัวข้อย่อย</a>";?></td>
				<td><?php echo "<a href='main.php?_modid=".$modid."&_mod=".$mod."&type=ita_detail'>รายละเอียด</a>";?></td>
	</table>
	
</div>
<?php
if($type=="ita_menu"){
	include ("ita_menu.php");
}elseif($type=="ita_submenu"){
	include ("ita_submenu.php");
}elseif($type=="ita_detail"){
	include ("ita_detail.php");
}
?>
