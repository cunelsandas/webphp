<?php
	$id=isset($_GET['id'])?$_GET['id']:null;
	$p_id=$_GET['p_id'];
	$btname=$_GET['detail'];
	if(!empty($id)){
		$sql="select * from questionnaire_detail where id=? and project_id=?";
		$rs=newQuery($sql,array($id,$p_id));
		$data=$rs->fetch();
		$name=$data['name'];
		$submaster_id=$data['submaster_id'];
		$master_id=$data['master_id'];
	}else{
		$name="";
		$submaster_id="";
		$master_id="";
	}
	if(isset($_POST['btsave'])){
		$p_id=$_POST['project_id'];
		$name=$_POST['name'];
		$detail_id=$_POST['detail_id'];
		$master_id=$_POST['master_id'];

		$submaster_id=$_POST['submaster_id'];

		switch($_POST['btsave']){
			case "add":
				$sql="insert into questionnaire_detail(project_id,name,submaster_id,master_id)values($p_id,'$name',$submaster_id,$master_id)";
				$msg="เพิ่มหัวข้อหลัก สำเร็จ";
				break;
			case "edit":
				$sql="update questionnaire_detail set name='$name',submaster_id='$submaster_id',master_id='$master_id' where id=$detail_id";
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
			<select name='master_id' class='form-control mx-1' onchange="showData(this.value,'submaster');">
				<?php
					$sql="select * from questionnaire_master";
					$rs=newQuery($sql);
					while($data=$rs->fetch()){
						$tid=$data['id'];
						$tname=$data['name'];

						if($tid==$master_id){
							echo "<option value='$tid' selected>$tname</option>";
						}else{
							echo "<option value='$tid'>$tname</option>";
						}
					}
				?>
			</select>
			</div>
		</div>
		<div class='form-group row'>
			<label class='col-sm-2 col-form-label'>หัวข้อรอง</label>
			<div class='col-sm-8' id='submaster'>
			<select name='submaster_id' class='form-control mx-1'>
				<option value='0'>ไม่มีข้อมูล / ไม่เลือก</option>
				<?php
					$sql="select * from questionnaire_submaster";
					$rs=newQuery($sql);
					while($data=$rs->fetch()){
						$tid=$data['id'];
						$tname=$data['name'];
						$tmas_id=$data['master_id'];
						$tmas_name=FindRS("select name from questionnaire_master where id='$tmas_id'","name");
						if($tmas_name<>"Not Found"){
							$masname="[ หัวข้อหลัก $tmas_name ]";
						}else{
							$masname="";
						}
						if($tid==$submaster_id){
							echo "<option value='$tid' selected>$masname $tname</option>";
						}else{
							echo "<option value='$tid' class='pl-4'>$masname $tname</option>";
						}
					}
				?>
			</select>

			</div>
		</div>
		<div class='form-group row'>
			<label class='col-sm-2 col-form-label'>หัวข้อย่อย (detail)</label>
			<div class='col-sm-8'>
			<input type='text' name='name' value='<?php echo $name;?>' class='form-control mx-1' >
			</div>
		</div>
		<div class='form-group row'>
			<label class='col-form-label col-sm-2'>id :<?php echo $id;?></label>
			<div class='col-sm-8'>
				<input type='submit' name='btsave' value='<?php echo $btname;?>' class='btn btn-primary'>
				<input type='hidden' name='project_id' value='<?php echo $p_id;?>'>

				<input type='hidden' name='detail_id' value='<?php echo $id;?>'>
			</div>

		</div>
	</form>
	 <script type="text/javascript" src="js/myjava.js"></script>
	<script >
		function showData(datavalue,dispalyid){
			var data="displayid="+displayid+"&data="+datavalue;
			var URL="ajax/ajax_showdata.php";
			ajaxLoad("get",URL,data,displayid);

		}
	</script>

