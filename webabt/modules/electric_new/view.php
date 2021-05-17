 	  <!-- Arquivos utilizados pelo jQuery lightBox plugin -->
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/jquery.lightbox-0.5.js"></script>
    <link rel="stylesheet" type="text/css" href="css/jquery.lightbox-0.5.css" media="screen" />
<script type="text/javascript">
    $(function() {
        $('#gallery a').lightBox();
    });
    </script>
<?php
	$tablename="tb_electric";
	$picfolder="fileupload/electric/";
	$picstyle="photo_border";
	$no=$_GET['no'];
	
	$sql="select * from $tablename Where no='$no'";
	$rs=rsQuery($sql);
	$data=mysqli_fetch_array($rs);
	$datecreate=DateTimeThai($data['datecreate']);
	$name=$data['name'];
	$subject=$data['subject'];
	
	$array=explode(';',$data['fix_with_code']);

	$result=$data['result'];
	$moo=$data['moo'];
	$status=FindRS("Select * from tb_status where id=".$data['status'],name);
	
?>
<div id="electric">
<fieldset>
	<table id="tb-view">
		<tr><th>เลขที่ : </th><td><?php echo $no;?></td></tr>
		<tr><th>วันที่แจ้ง : </th><td><?php echo $datecreate;?></td></tr>
		<tr><th>เรื่อง :</th><td><?php echo $subject;?></td></tr>
		<tr><th valign="top">รายการ :</th><td><?php 
				foreach($array as $fixwithcode){
					$i+="1";
					echo $i.'. '.$fixwithcode."<br>";
				}
			?>
			</td></tr>
			<tr><th>สถานะงาน : </th><td><?php echo $status;?></td></tr>
			<tr><th>ผลการดำเนินงาน</th><td><?php echo $result;?></td></tr>
			<tr><th></th><td>
			<div id="gallery">
				<?php
					$strSql="select * from filename where tablename='$tablename' AND masterid='".$no."' Order by id DESC";	
					$rs2=mysqli_query($strSql);
					$rs2_row=mysqli_num_rows($rs2);
					//ถ้า rs2 มีข้อมูลให้แสดงภาพแบบใหม่ ถ้าเป็น0ให้แสดงภาพตาม code เก่า
					if($rs2_row>0){ 
						//$i=0;
						while($rs_filename=mysqli_fetch_array($rs2)){
		
							$cpic=file_exists($picfolder.$rs_filename['filename']);
							$type=strtolower(substr($rs_filename['filename'],-3));
							if($cpic){
								if($type<>"pdf"){
										echo"<a href=".$picfolder.$rs_filename['filename']." target=\"_blank\"><img src=".$picfolder.$rs_filename['filename']." id='$picstyle' /></a>";
								}
							}
						}
					}
				?>
				</div>
				</td>
				</tr>
</table>
</fieldset>
</div>
