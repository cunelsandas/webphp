<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<style>
body {
    font-family: THsarabunNew,Tahoma, Arial, Sans-Serif;
}
</style>
<div><p>แบบสอบถาม (Questionnaire)</p></div>
<hr>

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include "myfnc.php";
	
	if(isset($_GET['del'])){
		echo "del";
	}
	if(isset($_GET['index'])){
		include "questionnaire_index.php";
	}elseif(isset($_GET['master'])){
		include "questionnaire_master.php";
	}elseif(isset($_GET['submaster'])){
		include "questionnaire_submaster.php";
	}elseif(isset($_GET['detail'])){
		include "questionnaire_detail.php";
	}elseif(isset($_GET['result'])){
		include "questionnaire_result.php";
	}else{
		
?>

<!--<form name='frmproject' method='post' action=''>-->
<!--	-->
<!--		<div class='form-inline'>-->
<!--			<label >สร้างแบบสอบถามใหม่</label>-->
<!--		-->
<!--			<input type='text' name='txtname' class='form-control ml-2'>-->
<!--			<input type='submit' name='btadd' class='btn btn-info ml-2' value='บันทึก'>-->
<!--		</div>-->
<!--	-->
<!--</form>-->
<div>
	<table class='table table-bordered'>
		<tr>
			<th>รายการแบบสอบถาม</th>
<!--			<th></th>-->
		</tr>
		<?php
			$sql="select * from questionnaire_project order by id";
			$rs=newQuery($sql);
			
			if($rs->rowCount()>0){
				while($data = $rs->fetch()){
					$id=$data['id'];
					$name=$data['name'];
//                    echo "<tr><td><a href='main.php?_mod=".$_GET['_mod']."&_modid=".$_GET['_modid']."&index=$id&p_id=$id'>แบบสำรวจความพึงพอใจต่อการให้บริการของ$customer_name</a></td><td><a href='?del=$id'>ลบ</a></td></tr>";
					echo "<tr><td><a href='main.php?_mod=".$_GET['_mod']."&_modid=".$_GET['_modid']."&index=$id&p_id=$id'>แบบสำรวจความพึงพอใจต่อการให้บริการของ$customer_name</a></td></tr>";
				}
			}
		?>
	</table>

</div>
	<?php }?>