<?php
	if(isset($_GET['p_id'])){
		$tb_mas="";
		$p_id=$_GET['p_id'];
		$total_ans=newQuery("select project_id,count(detail_id) as d from questionnaire_result where project_id='$p_id' group 
		by answer_id")->rowCount();
		$totalpoint=$total_ans*5;
		$project_name=rsField("select * from questionnaire_project where id=?","name",array($p_id));
		$sql="select * from questionnaire_master where project_id=?";
		$rs=newQuery($sql,array($p_id));
		if($rs->rowCount()>0){
			while($data = $rs->fetch()){
				$mas_id=$data['id'];
				$mas_name=$data['name'];
				$mas_type=$data['type_id'];
				$mas_type_name=FindRS("select name from questionnaire_type where id=".$mas_type,"name");
				
				$tb_mas .="<tr><td>$mas_name</td></tr>";
				$sqlsub="select * from questionnaire_submaster where master_id=? and project_id=?";
				$rssub=newQuery($sqlsub,array($mas_id,$p_id));
				if($rssub->rowCount()>0){
					while($dsub = $rssub->fetch()){
						$sub_id=$dsub['id'];
						$sub_name=$dsub['name'];
						$sub_type=$dsub['type_id'];
						$tb_mas .="<tr><td class='pl-4'>$sub_name</td></tr>";
						$sqldetail="select * from questionnaire_detail where master_id=? and submaster_id=?";
						$rsdetail=newQuery($sqldetail,array($mas_id,$sub_id));
						if($rsdetail->rowCount()>0){
							while($ddetail = $rsdetail->fetch()){
								$detail_id=$ddetail['id'];
								$detail_name=$ddetail['name'];
								
								switch($mas_type_name){
									case "inputdata":
										$strPoint="";
										$point="";
										break;
									case "select_one":
										$strQ="select id from questionnaire_result where project_id='$p_id' And master_id='$mas_id' And detail_id='$detail_id' And detail_value='checked'";
										$point=newQuery($strQ)->rowCount();
										break;
									case "select_multiple":
										$strQ="select id from questionnaire_result where project_id='$p_id' And master_id='$mas_id' And detail_id='$detail_id'";
										$point=newQuery($strQ)->rowCount();
										break;
									case "point_5choice":
										$strQ="select sum(detail_value) as point from questionnaire_result where project_id='$p_id' And master_id='$mas_id' And detail_id='$detail_id' group by project_id";
										$rsQ=newQuery($strQ)->fetch();
										$point=$rsQ['point']."/".$totalpoint;
										break;
								}
								
								$tb_mas .="<tr><td class='pl-5'>$detail_name</td><td>$point</td></tr>";
							}
						}
					}
				}else{
					$sqldetail="select * from questionnaire_detail where master_id=?";
						$rsdetail2=newQuery($sqldetail,array($mas_id));
						if($rsdetail2->rowCount()>0){
							while($ddetail2 = $rsdetail2->fetch()){
								
								$detail_id=$ddetail2['id'];
								$detail_name=$ddetail2['name'];
								
								switch($mas_type_name){
									case "inputdata":
										$strPoint="";
										$point="";
										break;
									case "select_one":
										$strQ="select id from questionnaire_result where project_id='$p_id' And master_id='$mas_id' And detail_id='$detail_id' And detail_value='checked'";
										$point=newQuery($strQ)->rowCount();
										break;
									case "select_multiple":
										$strQ="select id from questionnaire_result where project_id='$p_id' And master_id='$mas_id' And detail_id='$detail_id' And detail_value='checked'";
										$point=newQuery($strQ)->rowCount();
										break;
									case "point_5choice":
										$strQ="select sum(detail_value) as point from questionnaire_result where project_id='$p_id' And master_id='$mas_id' And detail_id='$detail_id' group by detail_id";
										$rsQ=newQuery($strQ)->fetch();
										$point=$rsQ['point']."/".$totalpoint;
										break;
								}
								$tb_mas .="<tr><td class='pl-5'>$detail_name</td><td>$point</td></tr>";
							}
						}
				}
			}
		}
	}
?>
<div>
	<table class='table table-bordered'>
		<tr>
			<th><?php echo "ผลการสำรวจ ". $project_name;?></th>
		</tr>
		<tr>
			<th>จำนวนผู้ตอบแบบสอบถาม : <?php echo $total_ans;?></th><th>คะแนน</th>
		</tr>
		<?php echo $tb_mas;?>
	</table>
</div>