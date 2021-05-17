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

	  $("#txtdatestart").datepicker({ showOn: 'button', changeMonth: true, changeYear: true,dateFormat: 'yy-mm-dd', isBuddhist: true, defaultDate: toDay, dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});


	 $("#txtdateend").datepicker({ showOn: 'button', changeMonth: true, changeYear: true,dateFormat: 'yy-mm-dd', isBuddhist: true, defaultDate: toDay, dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});

	  $("#dateInput").datepicker({ showOn: 'button', changeMonth: true, changeYear: true,dateFormat: 'yy-mm-dd', isBuddhist: true, defaultDate: toDay, dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});
	});
</script>
<div class="content-box">

<?php

empty($_GET['type'])?$type="":$type=$_GET['type'];
$modid=$_GET['_modid'];
$tablename=FindRS("select tablename from tb_mod where modid=$modid","tablename");
$modname=FindRS("select modname from tb_mod where modid=$modid","modname");

echo "<p >$modname</p><hr><br>";

if($type=="addnew"){			 //ตรวจสอบก่อนว่ามีการตั้งค่าของ $_GET['type'] เป็นการเพิ่มข่าวใหม่หรือเปล่า
	include("helpme_add.php");
}elseif($type=="view"){	     //ตรวจสอบก่อนว่ามีการตั้งค่าของ $_GET['type'] เป็นการดูรายละเอียดข่าวสารหรือเปล่า
	include("helpme_view.php");
}elseif($type=="viewtype"){	     //ตรวจสอบก่อนว่ามีการตั้งค่าของ $_GET['type'] เป็นการดูรายละเอียดข่าวสารหรือเปล่า
	include("helpme_type.php");
}elseif($type=="addtype"){	     //ตรวจสอบก่อนว่ามีการตั้งค่าของ $_GET['type'] เป็นการดูรายละเอียดข่าวสารหรือเปล่า
	include("helpme_type_add.php");
}else{
	if(isset($_GET['status'])){
		$sql="UPDATE $tablename SET status='".$_GET['status']."' Where id='".$_GET['no']."'";
		$rs=rsQuery($sql);
		if($rs){
			echo"<script>window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
		}
	}
	if(isset($_GET['del'])){
		$sql="DELETE From $tablename Where id='".$_GET['del']."'";
		$rs=rsQuery($sql);
		if($rs){
				// update table tb_trans บันทึกการเพิ่มข้อมูล
		$updatetran=UpdateTrans('$tablename','delete',$_SESSION['username'],'ID:'.$_GET['del']);
			echo"<script>window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
		}
	}
  if(isset($_GET['deltype'])){
		$sql="DELETE From tb_helpme_type Where id='".$_GET['deltype']."'";
		$rs=rsQuery($sql);
		if($rs){
				// update table tb_trans บันทึกการเพิ่มข้อมูล
		$updatetran=UpdateTrans('$tablename','delete',$_SESSION['username'],'ID:'.$_GET['del']);
			echo"<script>window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
		}
	}
?>

<center>
<!--<p style="right:10%;position:absolute;"><?php echo"<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=addnew\" class='link'>เพิ่มรายการใหม่</a>";?></p>-->
<p style="text-align:left;margin-bottom:3px;margin-left:10px;"><img src="../images/component/02.png"/> = active : <img src="../images/component/01.png" /> = no active </p>
<form name="frmnews" method="POST" action="" enctype="multipart/form-data">
<table class="content-input" width="80%">
	<tr>
		<td>วันที่</td><td><input type="text" name="txtdatestart" id="txtdatestart">&nbsp;&nbsp;ถึงวันที่&nbsp;<input type="text" name="txtdateend" id="txtdateend"></td>
	</tr>
	<tr>
		<td>ประเภท</td><td><select name='cbotype'>
				<option value='0'>ไม่ระบุประเภท/เลือกทั้งหมด</option>
	<?php
		$strtype="select * from tb_helpme_type";
		$rstype=rsQuery($strtype);
		if(mysqli_num_rows($rstype)>0){
			while($datatype=mysqli_fetch_assoc($rstype)){
				echo "<option value='".$datatype['id']."'>".$datatype['name']."</option>";
			}
		}
	?>
</select>
<?php echo  "<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=viewtype\" class=\"link\">จัดการประเภทคำร้อง</a>"; ?>

		</td>
	</tr>
	<tr>
		<td>สถานะ</td><td><select class="txt" name="cboprocess"><option value="0">ไม่ระบุ / เลือกทั้งหมด</option>
		<?php
		$sql="Select * From tb_helpme_process Order by id";
		$rs=rsQuery($sql);
		while($rowprocess=mysqli_fetch_assoc($rs)){
			if($row['process']==$rowprocess['id']){
				echo"<option value=\"".$rowprocess['id']."\" selected>".$rowprocess['name']."</option>";
			}else{
				echo"<option value=\"".$rowprocess['id']."\">".$rowprocess['name']."</option>";
			}
		}
		?>
		</td>
	</tr>
	<tr>
		<td></td><td><input type="submit" name="btsearch" value="ค้นหา"></td>
	</tr>
</table>
</form>
<br>
<table width="100%" class="content-table">
<tr >
	<td width="70">เลขคำร้อง</td>
	<td width="130" align="center">วันที่เขียน</td>
	<td width="330">&nbsp;หัวข้อ</td>
	<td width="100" align="center">ขั้นตอน</td>
	<td width="50" align="center">สถานะ</td>

	<td width="80" align="center">แก้ไข/ลบ</td>
</tr>
<?php
############################# แบ่งหน้าเพื่อให้แสดงผลรวดเร็ว #######################
	$pagelen = 15; //จำนวนที่แสดงผลข้อมูลต่อหน้า
	$range = 4 ; // ใส่จำนวนที่จะแสดงข้าง เลขปัจจุบัน ก็คือ ถ้าใส่ 2 แล้ว ตอนนี้แสดงอยู่หน้า 4 ก็จะเป็น 2 3 4 5 6 จะแสดงข้างเลข 4 อยู่ 2 จำนวน
	if(isset($_GET['page'])){
		$page=EscapeValue($_GET['page']);
	}else{
		$page="1";
	}
	$sql = "select id from $tablename"; //คิวรี่ข้อมูล เพื่อหาจำนวน แถว Comment ควร select แค่ ฟิวส์เดียว จะทำให้ทำงานได้ไวกว่า
	$result = rsQuery($sql);
	if($result){
		$totalrecords= $num_rows = mysqli_num_rows($result); //หาจำนวนแถวของขัอมูลทั้งหมด
	}else{
		$totalrecords= $num_rows = "0";
	}
	$totalpage = ceil($num_rows / $pagelen);
	$goto = ($page-1) * $pagelen; // หาหน้าที่จะกระโดดไป
	$start = $page - $range;
	$end = $page + $range;
	if ($start <= 1) {
		$start = 1;
	}
	if ($end >= $totalpage) {
		$end = $totalpage;
	}

	if(isset($_POST['btsearch'])){
//		if($_POST['cbotype']==0){
//			$type="";
//		}else{
//			$strField="SHOW COLUMNS FROM $tablename Where Field='type'";
//			$rsField=rsQuery($strField);
//			$row2=mysqli_num_rows($rsField);
//				if($row2>0){
//					$type="And type='".$_POST['cbotype']."'";
//				}else{
//					$type="";
//				}
//		}
		if($_POST['cboprocess']==0){
			$process="";
		}else{
			$process="process='".$_POST['cboprocess']."'";
		}
		$sql="select * from $tablename where datepost between '".ChangeYear($_POST['txtdatestart'],"en")."' And '".ChangeYear($_POST['txtdateend'],"en")."'".$process.$type." Limit $goto,$pagelen";
	}else{
	$sql = "select * from $tablename order by id DESC Limit $goto,$pagelen"; //ทำการแสดงผลโดยใช้คำสั่ง Limit เพื่อแสดงจำนวนข้อมูลต่อหน้า
	}
$Query = rsQuery($sql); //คิวรี่คำสั่ง
	$totalp = mysqli_num_rows($Query); // หาจำนวน record ที่เรียกออกมา
	if($totalp==0){
		echo"<tr height=\"30\">";
		echo"<td colspan=\"6\" align=\"center\">- - - - - - - - - - ยังไม่มีข้อมูล - - - - - - - - - -</td>";
		echo"</tr>";
		/*	วนลูปข้อมูล */
	}else{
		$i=$start;
		while($arr=mysqli_fetch_assoc($Query)){
			$processname=FindRS("select * from tb_helpme_process where id=".$arr['process'],"name");
			echo "<tr bgcolor=#FECFEA height=23>";
			echo "<td>".$arr['id']."</td>";
			echo "<td>&nbsp;".DateThai($arr['datepost'])."</td>";
			echo "<td>&nbsp;".$arr['subject']."</td>";
			echo "<td>".$processname."</td>";
			echo "<td align=center>";
			if($arr['status']=="0"){
				echo"<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&status=1&no=".$arr['id']."\"><img src=\"../images/component/01.png\" border=\"0\" /></a>";
			}else{
				echo"<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&status=0&no=".$arr['id']."\"><img src=\"../images/component/02.png\" border=\"0\"  /></a>";
			}
			echo"</td>";
			echo"<td align=\"center\"><a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=view&no=".$arr['id']."\"><img src=\"../images/component/docs_16.gif\" border=\"0\" /></a>&nbsp;&nbsp;&nbsp;<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&del=".$arr['id']."\" onclick=\"return confirm('คุณต้องการลบคำร้องนี้หรือไม่?');\"><img src=\"../images/component/del_16.gif\" border=\"0\"/></a></td>";
			echo"</tr>";
			$i++;
		}
	}
	echo"</table>";

	/* ตัวแบ่งหน้า */
echo "<div id=\"page_count\">";
if ($page > 1) {
	$back = $page - 1;
	echo "<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&page=1\" title=\"หน้าแรก First Page\">|<<img src=\"images/bt_first.png\" style=\"width:50px;height:25px;border:0;vertical-align: text-bottom;\" align=top></a>";
	echo "<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&page=$back\" title=\"ย้อนกลับ Previous Page\"><<<img src=\"images/bt_prev.png\" style=\"width:50px;height:25px;border:0;vertical-align: text-bottom;\"></a>";
	if ($start > 1) { echo "....."; }
}
	$icount=1;
	For ($i=$start ; $i<=$end ; $i++) {
		$bgcolor = sprintf("#%06x",rand(0,16777215)); //แสดงสีสลับเมื่อ ค่า i เพิ่มค่าไปเรื่อย ๆ
		if ($i == $page ) {
			echo "&nbsp;<b><font color=#787a8d><a title=\"ขณะนี้คุณอยู่หน้าที่$i\">".$i."</a></font></b>" ;
		} else {
			echo "<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&page=".$i."\" title=\"ไปหน้าที่ $i\" style=\"color:$bgcolor\">".$i."</a>" ;
		}
		$icount++;
	}
	if ($page < $totalpage) {
	$next = $page +1;
	if ($end < $totalpage) { echo "....."; }
		echo "<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&page=$next\" title=\"หน้าต่อไป Next Page\">>><img src=\"images/bt_next.png\" style=\"width:50px;height:25px;border:0;vertical-align: text-bottom;\"></a>";
		echo "<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&page=$totalpage\" title=\"หน้าสุดท้าย Last Page\">>|<img src=\"images/bt_last.png\" style=\"width:50px;height:25px;border:0;vertical-align: text-bottom;\"></a>";
	}
	echo "<p>ขณะนี้คุณอยู่ที่หน้า $page</p></div>";
}
?>
</div>



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
