<head>
<link type="text/css" href="css/jquery-ui-1.8.10.custom.css" rel="stylesheet" />	
  <!-- datepicker thai year -->
 <script type="text/javascript" src="js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.10.offset.datepicker.min.js"></script>
<style type="text/css">
.ui-datepicker{
	width:200px;
	font-family:tahoma;
	font-size:11px;
	text-align:center;
}
</style>
<script>
	$(function () {
		    var d = new Date();
		     var toDay =(d.getFullYear() + 543)  + '-' + (d.getMonth() + 1) + '-' + d.getDate();

	  $("#txtdate").datepicker({ showOn: 'button', changeMonth: true, changeYear: true,dateFormat: 'yy-mm-dd', isBuddhist: true, defaultDate: toDay, dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});


	 $("#txtdateend").datepicker({ showOn: 'button', changeMonth: true, changeYear: true,dateFormat: 'yy-mm-dd', isBuddhist: true, defaultDate: toDay, dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});

	  $("#txtdateout").datepicker({ showOn: 'button', changeMonth: true, changeYear: true,dateFormat: 'yy-mm-dd', isBuddhist: true, defaultDate: toDay, dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});
	});
</script>
<SCRIPT LANGUAGE="Javascript" SRC="../FusionCharts/FusionCharts.js"></SCRIPT>
</head>
<?php
	$tablename="tb_infoservice";
	//$content="";
	//$spaw=new SpawEditor("spaw1",$content);

	if(isset($_POST['btsave'])){
		$editid=$_POST['editid'];
		$date=ChangeYear($_POST['txtdate'],"en");
		$type=$_POST['cbotype'];
		$moo=$_POST['cbomoo'];
		$address=$_POST['txtaddress'];
		$detail=$_POST['mytextarea'];
		$time=$_POST['cbotime'];
		$sick=$_POST['txtsick'];
		$injure=$_POST['txtinjure'];
		$dead=$_POST['txtdead'];
		
		$strSql="UPDATE $tablename SET date='$date',type='$type',moo='$moo',address='$address',detail='$detail',time='$time',sick='$sick',injure='$injure',dead='$dead' Where id='$editid'";
		$rs=rsQuery($strSql);
		if($rs){
			$updatetran=UpdateTrans($tablename,'add',$_SESSION['username'],'ID:'.$id);
			echo"<script>alert('บันทึกข้อมูลเรียบร้อย');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
		}
	}
	if(isset($_GET['id'])){
		$id=$_GET['id'];
		$sql="select * from $tablename where id=".$id;
		$rs=rsQuery($sql);
		if($rs){
			$data=mysqli_fetch_assoc($rs);
			$v_id=$data['id'];
			$v_date=ChangeYear($data['date'],"th");
			$v_type=$data['type'];
			$v_moo=$data['moo'];
			$v_address=$data['address'];
			$v_detail=$data['detail'];
			$v_time=$data['time'];
			$v_sick=$data['sick'];
			$v_injure=$data['injure'];
			$v_dead=$data['dead'];
		}
	}
?>
 <body>
 <form name="frmnews" method="POST" action="" enctype="multipart/form-data">
	<table class="content-input">
		<tr>
			<th>id</th><td><?php echo $v_id;?></td>
		</tr>
		<tr>
			<th width="20%">วันที่</th><td width="80%"><input type="text" name="txtdate" id="txtdate" value="<?php echo $v_date;?>"></td>
		</tr>
		<tr>
			<th>ประเภท</th><td><select name="cbotype"><option value="0">-- เลือกข้อมูล --</option>
				<?php
					$sql="select * from tb_infoservice_type order by id";
					$rs=rsQuery($sql);
					if($rs){
						while($data=mysqli_fetch_assoc($rs)){
							$id=$data['id'];
							$name=$data['name'];
							if($data['id']==$v_type){
								echo "<option value='$id' selected>$name</option>";
							}else{
							echo "<option value='$id'>$name</option>";
							}
						}
					}
					?>
					</select></td>
			</tr>
			<tr>
				<th>หมู่ที่</th><td><select name="cbomoo"><option value="0">-- เลือกข้อมูล --</option>
					<?php
					$msql="select * from tb_infoservice_moo order by id";
						$mrs=rsQuery($msql);
						while($m=mysqli_fetch_assoc($mrs)){
							$id=$m['id'];
							$name=$m['name'];
							if($id==$v_moo){
								echo "<option value='$id' selected>$name</option>";
							}else{
								echo "<option value='$id'>$name</option>";
							}
					}
						
						?>
						</select></td>
				</tr>
				<tr>
					<th>จำนวนผู้รับบริการ</th><td><input type="text" name="txtaddress" value="<?php echo $v_address;?>" size="60"></td>
				</tr>
<!--				<tr>-->
        <!--					<th>ช่วงเวลา</th><td><select name="cbotime"><option value="0">--เลือกข้อมูล--</option>-->
        <!--						--><?php
        //							$sql="select * from tb_infoservice_time order by id";
        //								$rs=rsQuery($sql);
        //								if($rs){
        //									while($data=mysqli_fetch_assoc($rs)){
        //										$id=$data['id'];
        //										$name=$data['name'];
        //										if($data['id']==$v_time){
        //											echo "<option value='$id' selected>$name</option>";
        //										}else{
        //											echo "<option value='$id'>$name</option>";
        //										}
        //						}
        //					}
        //						?>
        <!--						</select></td>-->
        <!--					</tr>-->
        <!--					<tr>-->
        <!--						<th>ผู้ป่วย</th><td><input type="text" name="txtsick" value="-->
        <?php //echo $v_sick;?><!--"></td>-->
        <!--					</tr>-->
        <!--					<tr>-->
        <!--						<th>ผู้บาดเจ็บ</th><td><input type="text" name="txtinjure" value="-->
        <?php //echo $v_injure;?><!--"></td>-->
        <!--					</tr>-->
        <!--					<tr>-->
        <!--						<th>ผู้เสียชีวิต</th><td><input type="text" name="txtdead" value="-->
        <?php //echo $v_dead;?><!--"></td>-->
        <!--					</tr>-->
				<tr>

					<th>รายละเอียด</th><td>

                        <textarea name="mytextarea" id="mytextarea" > <?php echo $v_detail; ?> </textarea>
                       </td>
				</tr>
				<tr>
				<td></td><td><input type="submit" name="btsave" value="บันทึก"><input type="hidden" name="editid" value="<?php echo $v_id;?>"></td>
				</tr>
				</table>
				
  </form>
 </body>
</html>

<script src='../js/tinymce/tinymce.min.js'></script>
<script>
    tinymce.init({


        selector: '#mytextarea',
        theme: 'modern',
        width: "100%",
        height: 300,
        plugins: [
            'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
            'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
            'save table contextmenu directionality emoticons template paste textcolor'
        ],

        toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons',


        image_title: true,
        // enable automatic uploads of images represented by blob or data URIs
        automatic_uploads: true,
        // add custom filepicker only to Image dialog
        file_picker_types: 'image',
        file_picker_callback: function(cb, value, meta) {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');

            input.onchange = function() {
                var file = this.files[0];
                var reader = new FileReader();

                reader.onload = function () {
                    var id = 'blobid' + (new Date()).getTime();
                    var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                    var base64 = reader.result.split(',')[1];
                    var blobInfo = blobCache.create(id, file, base64);
                    blobCache.add(blobInfo);

                    // call the callback and populate the Title field with the file name
                    cb(blobInfo.blobUri(), { title: file.name });
                };
                reader.readAsDataURL(file);
            };

            input.click();
        }


    });


</script>
