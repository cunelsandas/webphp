<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<style>
    body {
        font-family:THK2DJuly8;
        font-size:14px;
    }
    .table-bordered td, .table-bordered th  {
        border: 2px solid black;
        background-color: white;
    }

</style>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
    include "myfnc.php";

	if(isset($_POST['btsave'])){
		$random=rand();
		$date=date('Y-m-d');
		$answer_id=$date."-".$random;
		$ip=$_SERVER['REMOTE_ADDR'];
		$project_id=$_POST['project_id'];
		$sqlmaster="select * from questionnaire_master where project_id=?"; //ton 7/8/20
		$rsmaster=newQuery($sqlmaster,array($project_id))->fetchAll();
		if($rsmaster){
			foreach($rsmaster as $data){
				$master_id=$data['id'];
				$type_id=$data['type_id'];
				$type_name=rsField("select * from questionnaire_type where id=".$type_id,"name");
				//echo 'master_id='.$master_id.'<br>';
				$sqlsubmaster="select * from questionnaire_submaster where master_id=?";
				$rssubmaster=newQuery($sqlsubmaster,array($master_id))->fetchAll();
				if($rssubmaster){
					foreach($rssubmaster as $datasub){
						$submaster_id=$datasub['id'];
						$subtype_id=$datasub['type_id'];
						$subtype_name=rsField("select * from questionnaire_type where id=?","name",array($subtype_id));
						//echo 'submaster_id='.$submaster_id.'<br>';
						$sqldetail="select * from questionnaire_detail where project_id=? and master_id=? and submaster_id=?";
						$rsdetail=newQuery($sqldetail,array($project_id,$master_id,$submaster_id))->fetchAll();
						if($rsdetail){
							foreach($rsdetail as $datadetail){
								$detail_id=$datadetail['id'];
								//echo 'detail_id='.$detail_id.'<br>';
								switch($subtype_name){
									case "inputdata":
										$detail_value=$_POST['text_'.$detail_id];
										break;
									case "select_one":
										if(isset($_POST['radio_sub_'.$submaster_id])){
											$postvalue=$_POST['radio_sub_'.$submaster_id];
											if($detail_id==$postvalue){
												$detail_value="checked";
											}else{
												$detail_value="null";
											}
										}			//$detail_value=isset($_POST['radio_sub_'.$detail_id])?$_POST['radio_sub_'.$detail_id]:null;
										break;
									case "select_multiple":

										$detail_value=isset($_POST['chk_'.$detail_id])?$_POST['chk_'.$detail_id]:null;
										break;
									case "point_5choice":
										$detail_value=isset($_POST['radio_sub_'.$detail_id])?$_POST['radio_sub_'.$detail_id]:null;
										break;
								}
								$sqlUp="insert into questionnaire_result(project_id,master_id,submaster_id,detail_id,detail_value,date,ip,answer_id) values($project_id,$master_id,$submaster_id,$detail_id,'$detail_value','$date','$ip','$answer_id')";
								$rsUp=newQuery($sqlUp);
							}
						}
					}
				}else{
					$sqldetail="select * from questionnaire_detail where project_id=? and master_id=? and submaster_id=0";
						$rsdetail=newQuery($sqldetail,array($project_id,$master_id))->fetchAll();
						if($rsdetail){
							foreach($rsdetail as $datadetail){
								$detail_id=$datadetail['id'];
								//echo 'detail_id='.$detail_id.'<br>';
								switch($type_name){
									case "inputdata":
										$detail_value=$_POST['text_'.$detail_id];
										break;
									case "select_one":
										if(isset($_POST['radio_mas_'.$master_id])){
											$postvalue=$_POST['radio_mas_'.$master_id];
											if($detail_id==$postvalue){
												$detail_value="checked";
											}else{
												$detail_value="null";
											}
										}											//$detail_value=isset($_POST['radio_mas_'.$master_id])?$_POST['radio_mas_'.$master_id]:"no";
										break;
									case "select_multiple":
										$detail_value=isset($_POST['chk_'.$detail_id])?$_POST['chk_'.$detail_id]:null;
										break;
									case "point_5choice":
										$detail_value=isset($_POST['radio_mas_'.$detail_id])?$_POST['radio_mas_'.$detail_id]:null;
										break;
								}
								$sqlUp="insert into questionnaire_result(project_id,master_id,submaster_id,detail_id,detail_value,date,ip,answer_id) values($project_id,$master_id,0,$detail_id,'$detail_value','$date','$ip','$answer_id')";
								$rsUp=newQuery($sqlUp);
							}
						}

				}


			}
		}

		echo "<script>alert('ขอบคุณมากค่ะ ข้อมูลของท่านถูกบันทึกเรียบร้อยแล้ว');</script>";
	}

	$project_id=$_GET['p_id'];
	$project_name=rsField("select name from questionnaire_project where id=".$project_id,"name");
	$sql="select *  from questionnaire_master where project_id=?";
	$rs=newQuery($sql,array($project_id))->fetchAll();
	$point_title="";

?>
<div>
<form name='frmQuestionnaire' method='post' action='' autocomplete='off'>
	<p><b style="text-decoration: underline"><?php echo 'แบบสำรวจความพึงพอใจต่อการให้บริการของ'.$customer_name.'';?></b></p>
	<?php
		foreach($rs as $data){
			$master_id=$data['id'];
			$type_id=$data['type_id'];
			$type_name=rsField("select * from questionnaire_type where id=".$type_id,"name");
			$master_name=$data['name'];
			echo "<table class='table table-bordered'>";
			echo "<tr>";
			echo "<th colspan='6' class='table-color'>$master_name</th>";
			echo "</tr>";
			$sqlsub="select * from questionnaire_submaster where master_id=? And project_id=?";
			$rssub=newQuery($sqlsub,array($master_id,$project_id));
			if($rssub->rowCount()>0){
				while($sub=$rssub->fetch()){
					$subtype_name=rsField("select * from questionnaire_type where id=".$sub['type_id'],"name");
					$submaster_id=$sub['id'];
					switch($subtype_name){
						case "point_5choice":
							$point_title="<td>มากทีสุด</td><td>มาก</td><td>ปานกลาง</td><td>น้อย</td><td>ควรปรับปรุง</td>";
							break;
						default:
							$point_title="<td colspan='5'></td>";
							break;
					}


						echo "<tr class='table-color'><td>".$sub['name']."</td>".$point_title."</tr>";
						$sqlsubdetail="select * from questionnaire_detail where project_id=$project_id and submaster_id=$submaster_id";
						$rssubdetail=newQuery($sqlsubdetail)->fetchAll();
						if($rssubdetail){
						$gensubdetail="";
						switch($type_name){
							case "inputdata":
								foreach($rssubdetail as $subdetail){
									$detail_id=$subdetail['id'];
									$detail_name=$subdetail['name'];
									$gensubdetail .= "<tr><td>".$subdetail['name']."</td><td><input type='text' name='$detail_id' class='form-control'></td></tr>";
								}
								break;
							case "select_one":
								$gensubdetail="<tr><td>";
								foreach($rssubdetail as $subdetail){
									$detail_id=$subdetail['id'];
									$detail_name=$subdetail['name'];
									$gensubdetail .="<div class='row'><div class='col-10'><input type='radio' name='radio_sub_".$master_id."' value='$detail_id'><label class='ml-2'>$detail_name</label></div></div>";
								}
								$gensubdetail.="</td></tr>";
								break;
							case "select_multiple":
								$gensubdetail="<tr><td>";
								foreach($rssubdetail as $subdetail){
									$detail_id=$subdetail['id'];
									$detail_name=$subdetail['name'];
									$gensubdetail .="<div class='form-check-inline ml-4'><label class='form-check-label'><input type='checkbox' class='form-check-input' name='chk_".$detail_id."' value='checked'>$detail_name</label></div><br>";

								//	$gensubdetail .="<div class='form-check-inline mb-3'><input type='checkbox' class='form-check-input' name='chk_".$detail_id."' value='checked'><label class='custom-control-label'>$detail_name</label></div>";
								}
								$gensubdetail.="</td></tr>";
								break;
							case "point_5choice":
								foreach($rssubdetail as $subdetail){
									$detail_id=$subdetail['id'];
									$detail_name=$subdetail['name'];
									$gensubdetail .="<tr><td>".$detail_name."</td>";
									$gensubdetail .="<td><input type='radio' name='radio_sub_".$detail_id."' value='5'></td>";
									$gensubdetail .="<td><input type='radio' name='radio_sub_".$detail_id."' value='4'></td>";
									$gensubdetail .="<td><input type='radio' name='radio_sub_".$detail_id."' value='3'></td>";
									$gensubdetail .="<td><input type='radio' name='radio_sub_".$detail_id."' value='2'></td>";
									$gensubdetail .="<td><input type='radio' name='radio_sub_".$detail_id."' value='1'></td></tr>";
								}
						}

						echo $gensubdetail;
						}
				}
			}

			$sqldetail="select * from questionnaire_detail where project_id=$project_id and master_id=$master_id";
			$rsdetail=newQuery($sqldetail)->fetchAll();

			$gendetail="";
			switch($type_name){
				case "inputdata":
					foreach($rsdetail as $detail){
						$detail_id=$detail['id'];
						$detail_name=$detail['name'];
						$gendetail .= "<tr><td>".$detail['name']."</td><td><input type='text' name='text_".$detail_id."' class='form-control'></td></tr>";
					}
					break;
				case "select_one":
					$gendetail="<tr><td>";
					foreach($rsdetail as $detail){
						$detail_id=$detail['id'];
						$detail_name=$detail['name'];
						$gendetail .="<div class='row'><div class='col-10'><input type='radio' name='radio_mas_".$master_id."' value='$detail_id'><label class='ml-2'>$detail_name</label></div></div>";
					}

					$gendetail.="</td></tr>";
					break;
				case "select_multiple":
					$gendetail="<tr><td>";
					foreach($rsdetail as $detail){
						$detail_id=$detail['id'];
						$detail_name=$detail['name'];
						$gendetail .="<div class='form-check-inline ml-4'><label class='form-check-label'><input type='checkbox' class='form-check-input' name='chk_".$detail_id."' value='checked'>$detail_name</label></div><br>";
					}
					$gendetail .="</td></tr>";
					break;
				case "point_5choice":
					foreach($rssubdetail as $subdetail){
					$detail_id=$subdetail['id'];
					$detail_name=$subdetail['name'];
					$gensubdetail .="<tr><td>".$detail_name."</td>";
					$gensubdetail .="<td><input type='radio' name='radio_mas_".$detail_id."' value='5'></td>";
					$gensubdetail .="<td><input type='radio' name='radio_mas_".$detail_id."' value='4'></td>";
					$gensubdetail .="<td><input type='radio' name='radio_mas_".$detail_id."' value='3'></td>";
					$gensubdetail .="<td><input type='radio' name='radio_mas_".$detail_id."' value='2'></td>";
					$gensubdetail .="<td><input type='radio' name='radio_mas_".$detail_id."' value='1'></td></tr>";
					}
			}
			echo $gendetail;


			echo "</table>";

		}
	?>
	<div><input type='submit' name='btsave' value='บันทึก'><input type='hidden' name='project_id' value='<?php echo $project_id;?>'></div>
</form>
</div>