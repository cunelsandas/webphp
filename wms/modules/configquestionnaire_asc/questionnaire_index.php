
<?php
	if(isset($_GET['delete'])){
		$delid=$_GET['delid'];
		switch($_GET['delete']){
			case "master":
			$sql="delete from questionnaire_master where id=?";
			$sql2="delete from questionnaire_submaster where master_id=?";
			$sql3="delete from questionnaire_detail where master_id=?";
			$rs=newQuery($sql,array($delid));
			$rs2=newQuery($sql2,array($delid));
			$rs3=newQuery($sql3,array($delid));
			break;

			case "submaster":
			$sql2="delete from questionnaire_submaster where id=?";
			$sql3="delete from questionnaire_detail where submaster_id=?";

			$rs2=newQuery($sql2,array($delid));
			$rs3=newQuery($sql3,array($delid));
			break;
			case "detail":
			$sql3="delete from questionnaire_detail where id=?";

			$rs3=newQuery($sql3,array($delid)); //edit TON 15/5/2563
			break;
		}
		echo "<script>alert('ลบข้อมูลสำเร็จ');</script>";
	}
	if(isset($_GET['p_id'])){
		$tb_mas="";
		$p_id=$_GET['p_id'];
		$project_name=rsField("select * from questionnaire_project where id=?","name",array($p_id));
		$project_link ="index.php?_mod=". encode64($_GET['_mod'])."&p_id=$p_id";
		$sql="select * from questionnaire_master where project_id=?";
		$rs=newQuery($sql,array($p_id));
		if($rs->rowCount()>0){
			while($data = $rs->fetch()){
				$mas_id=$data['id'];
				$mas_name=$data['name'];
				$mas_type=$data['type_id'];
				$tb_mas .="<tr><td><a href='main.php?_mod=".$_GET['_mod']."&_modid=".$_GET['_modid']."&p_id=".$p_id."&master=edit&id=$mas_id' title='หัวข้อหลัก (master)'>$mas_name</a></td><td><a href='main.php?_mod=".$_GET['_mod']."&_modid=".$_GET['_modid']."&p_id=".$p_id."&index=".$p_id."&delete=master&delid=".$mas_id."'>ลบ</a></td></tr>";
				$sqlsub="select * from questionnaire_submaster where master_id=? and project_id=?";
				$rssub=newQuery($sqlsub,array($mas_id,$p_id));
				if($rssub->rowCount()>0){
					while($dsub = $rssub->fetch()){
						$sub_id=$dsub['id'];
						$sub_name=$dsub['name'];
						$sub_type=$dsub['type_id'];
						$tb_mas .="<tr><td class='pl-4'><a href='main.php?_mod=".$_GET['_mod']."&_modid=".$_GET['_modid']."&p_id=".$p_id."&submaster=edit&id=$sub_id' title='หัวข้อรอง  (submaster)'>$sub_name</a></td><td><a href='main.php?_mod=".$_GET['_mod']."&_modid=".$_GET['_modid']."&p_id=".$p_id."&index=".$p_id."&delete=submaster&delid=".$sub_id."'>ลบ</a></td></tr>";
						$sqldetail="select * from questionnaire_detail where master_id=? and submaster_id=?";
						$rsdetail=newQuery($sqldetail,array($mas_id,$sub_id));
						if($rsdetail->rowCount()>0){
							while($ddetail = $rsdetail->fetch()){
								$detail_id=$ddetail['id'];
								$detail_name=$ddetail['name'];
								$tb_mas .="<tr><td class='pl-5'><a href='main.php?_mod=".$_GET['_mod']."&_modid=".$_GET['_modid']."&p_id=".$p_id."&detail=edit&id=$detail_id' title='หัวข้อย่อย (detail)'>$detail_name</a></td><td><a href='main.php?_mod=".$_GET['_mod']."&_modid=".$_GET['_modid']."&p_id=".$p_id."&index=".$p_id."&delete=detail&delid=".$detail_id."'>ลบ</a></td></tr>";
							}
						}
					}
				}else{
					$sqldetail="select * from questionnaire_detail where master_id=? order by id asc";
						$rsdetail2=newQuery($sqldetail,array($mas_id));
						if($rsdetail2->rowCount()>0){
							while($ddetail2 = $rsdetail2->fetch()){
								$detail_id=$ddetail2['id'];
								$detail_name=$ddetail2['name'];
								$tb_mas .="<tr><td class='pl-5'><a href='main.php?_mod=".$_GET['_mod']."&_modid=".$_GET['_modid']."&p_id=".$p_id."&detail=edit&id=$detail_id' title='หัวข้อย่อย (detail)'>$detail_name</a></td><td><a href='main.php?_mod=".$_GET['_mod']."&_modid=".$_GET['_modid']."&p_id=".$p_id."&index=".$p_id."&delete=detail&delid=".$detail_id."'>ลบ</a></td></tr>";
							}
						}
				}
			}
		}
	}
?>
<div class='row'>
	<div class='col-2'>
	<a href='main.php?_mod=<?php echo $_GET['_mod'];?>&_modid=<?php echo $_GET['_modid'];?>&p_id=<?php echo $p_id;?>&master=add'>หัวข้อหลัก (master)</a>
	</div>
	<div class='col-2'>
	<a href='main.php?_mod=<?php echo $_GET['_mod'];?>&_modid=<?php echo $_GET['_modid'];?>&p_id=<?php echo $p_id;?>&submaster=add'>หัวข้อรอง (sub)</a>
	</div>
	<div class='col-2'>
	<a href='main.php?_mod=<?php echo $_GET['_mod'];?>&_modid=<?php echo $_GET['_modid'];?>&p_id=<?php echo $p_id;?>&detail=add'>หัวข้อย่อย (detail)</a>
	</div>
	<div class='col-2'>
	<a href='main.php?_mod=<?php echo $_GET['_mod'];?>&_modid=<?php echo $_GET['_modid'];?>&p_id=<?php echo $p_id;?>&result=add'>สรุปผล</a>
	</div>
</div>
<div>
	<table class='table table-bordered'>
		<tr>
			<th><div  class='row'><div class='col-8'><?php echo 'แบบสำรวจความพึงพอใจต่อการให้บริการของ'.$customer_name.'';?></div><div class='col-4' title='copy link สำหรับทำ banner'><?php echo $project_link;?></div></div></th>
		</tr>
		<?php echo $tb_mas;?>
	</table>
</div>