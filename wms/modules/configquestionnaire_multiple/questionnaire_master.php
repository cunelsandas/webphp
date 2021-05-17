<?php
	$id=isset($_GET['id'])?$_GET['id']:null;
	$p_id=$_GET['p_id'];
	$btname=$_GET['master'];
	if(!empty($id)){
		$sql="select * from questionnaire_master where id=? and project_id=?";
		$rs=newQuery($sql,array($id,$p_id));
		$data=$rs->fetch();
		$name=$data['name'];
		$type_id=$data['type_id'];
	}else{
		$name="";
		$type_id="";
	}
	if(isset($_POST['btsave'])){
		$p_id=$_POST['project_id'];
		$name=$_POST['name'];
		$master_id=$_POST['master_id'];
		$type_id=$_POST['type_id'];
		switch($_POST['btsave']){
			case "add":
				$sql="insert into questionnaire_master(project_id,name,type_id)values($p_id,'$name',$type_id)";
				$msg="เพิ่มหัวข้อหลัก สำเร็จ";
				break;
			case "edit":
				$sql="update questionnaire_master set name='$name',type_id='$type_id' where id=$master_id";
				$msg="แก้ไขข้อมูล สำเร็จ";
				break;
		}
		$rs=newQuery($sql);
		if($rs){
			echo "<script>alert('".$msg."');window.location.href='main.php?_modid=" . $_GET['_modid'] . "&_mod=" . $_GET['_mod'] . "&p_id=$p_id&index=$p_id';</script>";
		}
	}
?>

	<form name='frmmaster' method='post' action='' class="form-horizontal">
		<div class='form-group row'>
			<label class='col-sm-2 col-form-label'>หัวข้อหลัก</label>
			<div class='col-sm-8'>
			<input type='text' name='name' value='<?php echo $name;?>' class='form-control mx-1' >
			</div>
		</div>
		<div class='form-group row'>
			<label class='col-sm-2 col-form-label'>ประเภทข้อมูล</label>
			<div class='col-sm-8'>
			<select name='type_id' class='form-control mx-1'>
				<?php
					$sql="select * from questionnaire_type";
					$rs=newQuery($sql);
					while($data=$rs->fetch()){
						$tid=$data['id'];
						$tname=$data['name'];
						$tdetail=$data['detail'];
						if($tid==$type_id){
							echo "<option value='$tid' selected>$tname  $tdetail</option>";
						}else{
							echo "<option value='$tid'>$tname  $tdetail</option>";
						}
					}
				?>
			</select>
			</div>
		</div>
		<div class='form-group row'>
			<label class='col-form-label col-sm-2'>id :<?php echo $id;?></label>
			<div class='col-sm-8'>
				<input type='submit' name='btsave' value='<?php echo $btname;?>' class='btn btn-primary'>
				<input type='hidden' name='project_id' value='<?php echo $p_id;?>'>
				<input type='hidden' name='master_id' value='<?php echo $id;?>'>
			</div>
			
		</div>
	</form>
