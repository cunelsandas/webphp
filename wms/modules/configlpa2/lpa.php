<?php
$modid=$_GET['_modid'];
$mod=$_GET['_mod'];
$type=$_GET['type'];

?>
<div class='content-input'>
	<table width='100%'>
			<tr>
				<td><?php echo "<a href='main.php?_modid=".$modid."&_mod=".$mod."&type=lpa_menu'>หัวข้อหลัก</a>";?></td>
				<td><?php echo "<a href='main.php?_modid=".$modid."&_mod=".$mod."&type=lpa_submenu'>หัวข้อรอง</a>";?></td>
				<td><?php echo "<a href='main.php?_modid=".$modid."&_mod=".$mod."&type=lpa_detail'>หัวข้อย่อย";?></td>
				<td><?php echo "<a href='main.php?_modid=".$modid."&_mod=".$mod."&type=lpa_detail2'>รายละเอียด";?></td>
	</table>
	
</div>
<?php
if($type=="lpa_menu"){
	include ("lpa_menu.php");
}elseif($type=="lpa_submenu"){
	include ("lpa_submenu.php");
}elseif($type=="lpa_detail"){
	include ("lpa_detail.php");
}elseif($type=="lpa_detail2"){
	include ("lpa_detail2.php");
}

?>
