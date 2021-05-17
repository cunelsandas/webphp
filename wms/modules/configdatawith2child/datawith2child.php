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

	  $("#mas_txtdate").datepicker({ showOn: 'both', changeMonth: true, changeYear: true,dateFormat: 'yy-mm-dd', isBuddhist: true, defaultDate: toDay, dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});


	 $("#sub1_txtdate").datepicker({ showOn: 'both',changeMonth: true, changeYear: true,dateFormat: 'yy-mm-dd', isBuddhist: true, defaultDate: toDay, dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});

	  $("#sub2_txtdate").datepicker({ showOn: 'both', changeMonth: true, changeYear: true,dateFormat: 'yy-mm-dd', isBuddhist: true, defaultDate: toDay, dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
              dayNamesMin: ['อา.','จ.','อ.','พ.','พฤ.','ศ.','ส.'],
              monthNames: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],
              monthNamesShort: ['ม.ค.','ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']});
	});


</script>
<?php
//error_reporting(E_ALL); //สำหรับเช็ค error
	//ini_set('error_reporting', E_ALL);
	//ini_set('display_errors',1);
empty($_GET['type'])?$type="":$type=$_GET['type'];
$modid=$_GET['_modid'];
$modname="เมนูย่อยด้านซ้าย";
$tablename=FindRS("select tablename from wms_module where id=$modid","tablename");
$tablename_sub1="tb_submenu";



$btsub1="Addnew";




// sub1
echo "<br>";

// บันทึก แก้ไข sub1
if(isset($_POST['btsub1'])){
	$id=$_POST['sub1_txtid'];
	$name=$_POST['sub1_txtname'];
	$keyword="null";

	$ip=$_SERVER['REMOTE_ADDR'];
	$detail=$_POST['detail1'];
	$img_filter="";
	$datepost=ChangeYear($_POST['sub1_txtdate'],"en");
	$edittime=date('Y-m-d H:i:s');
	$useredit=$_SESSION['userid'];
	$masterid=$_POST['sub1_cbomasterid'];

	if($_POST['sub1_chkstatus']=="on"){
		$status="1";
	}else{
		$status="0";
	}
	if($_POST['btsub1']=="Addnew"){
		$sqlsub1="INSERT INTO $tablename_sub1(masterid,name,keyword,detail,status,img_filter,datepost,edittime,useredit,ip)";
		$sqlsub1 .="Value";
		$sqlsub1 .="('$masterid','$name','$keyword','$detail','$status','$img_filter','$datepost','$edittime','$useredit','$ip')";
		$updatetran=UpdateTrans($tablename_sub1,'addnew',$_SESSION['username'],'name-'.$name);
		$alert="<script>alert('เพิ่มข้อมูลสำเร็จ');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";

	}else{
		$sqlsub1 ="Update $tablename_sub1 SET";
		$sqlsub1 .=" masterid='$masterid',name='$name',keyword='$keyword',detail='$detail',status='$status',img_filter='$img_filter',datepost='$datepost',edittime='$edittime',useredit='$useredit',ip='$ip'";
		$sqlsub1 .=" Where id=".$id;
		$updatetran=UpdateTrans($tablename_sub1,'edit',$_SESSION['username'],'name-'.$name);
		$alert="<script>alert('แก้ไขข้อมูลสำเร็จ');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
	}
	$rs=rsQuery($sqlsub1);
	if($rs){

		$btsub1="Addnew";
		echo $alert;

	}
}

//แก้ไข sub1
if(isset($_GET['sub1_edit'])){
	$btsub1="Edit";

	$sql="select * from $tablename_sub1 Where id=".$_GET['sub1_edit'];
	$rs=rsQuery($sql);
	if($rs){
		$data=mysqli_fetch_array($rs);
			$sub1_id=$data['id'];
			$sub1_masterid=$data['masterid'];
			$sub1_name=$data['name'];
			$sub1_keyword=$data['keyword'];
			$sub1_date=ChangeYear($data['datepost'],"th");
			$sub1_status=$data['status'];
			if($sub1_status==1){
				$checkvalue="checked";
			}else{
				$checkvalue="";
			}

			$sub1_detail=$data['detail'];

	}

}

if(isset($_GET['sub1_status'])){
	$sql="Update $tablename_sub1 SET status='".$_GET['sub1_status']."' Where id=".$_GET['sub1_id'];
	$rs=rsQuery($sql);
}
if(isset($_GET['sub1_del'])){
	$sql="Delete from $tablename_sub1 Where id=".$_GET['sub1_del'];
	$rs=rsQuery($sql);
}

echo "<div class='content-box'>";
echo "<span >$modname (sub1-data)</span><span style='position:absolute;right:100px;'><input type='button' onclick=\"showForm('inputSub1','btnSub1');\"  id='btnSub1' value='ซ่อมแบบฟอร์ม' ></span><hr><br>";
echo "<form name='frmsub1' action='' method='post'>";
echo "<div class='content-input' id='inputSub1'>";
echo "<table width='100%'>";
echo "<tr><td width='20%'>id</td><td width='80%'>$sub1_id<input type='hidden' name='sub1_txtid' value='$sub1_id' ></td></tr>";
echo "<tr>	<td>วันที่</td><td><input type='text' name='sub1_txtdate' id='sub1_txtdate' value='$sub1_date' autocomplete='off'></td>	</tr>";
echo "<tr>	<td>ชื่อ (name)</td><td><input type='text' name='sub1_txtname' value='$sub1_name' class='widthauto' autocomplete='off'></td></tr>";

echo "<tr>	<td>รายละเอียด (detail)</td><td>";
echo "<textarea name='detail1' id='mytextarea'></textarea>";
echo "</td></tr>";

echo "<tr><td>สถานะ</td><td><input type='checkbox' name='sub1_chkstatus' $checkvalue/>&nbsp;Active (Active : แสดงข้อมูลในหน้าเว็บ)</td></tr>";
echo "<tr><td>master-data</td><td>";
echo "<select name='sub1_cbomasterid'><option value='0'>--เลือกกลุ่มข้อมูล--</option>";
	$sql="select * from tb_filestype order by name";
	$rs=rsQuery($sql);
	if($rs){
		while($data=mysqli_fetch_array($rs)){
			if($sub1_masterid==$data['fid']){
				echo "<option value='".$data['fid']."' selected>".$data['name']."</option>";
			}else{
				echo "<option value='".$data['fid']."'>".$data['name']."</option>";
			}
		}
	}
echo "</select>";
echo "</td></tr>";
echo "<tr><td></td><td><input type='submit' name='btsub1' value='$btsub1'></td></tr>";
echo "</table>";
echo "</div>";
echo "</form>";
echo "<br>";
echo "<div id='sub1table'>";
echo "<table class='content-table'>";
echo "<tr>";
echo "<th width='10%'>วันที่</th>";
echo "<th width='30%'>ชื่อ</th>";
echo "<th width='30%'>รายละเอียด</th>";
echo "<th width='10%'>สถานะ</th>";
echo "<th width='10%'>จัดการ</th>";
echo "</tr>";
	$pagelen = 100; //จำนวนที่แสดงผลข้อมูลต่อหน้า
	$range = 4 ; // ใส่จำนวนที่จะแสดงข้าง เลขปัจจุบัน ก็คือ ถ้าใส่ 2 แล้ว ตอนนี้แสดงอยู่หน้า 4 ก็จะเป็น 2 3 4 5 6 จะแสดงข้างเลข 4 อยู่ 2 จำนวน
	$page=EscapeValue($_GET['pagesub1']);
	if(empty($page)){
		$page="1";
	}
	$sqlrow = "select id from $tablename_sub1"; //คิวรี่ข้อมูล เพื่อหาจำนวน แถว Comment ควร select แค่ ฟิวส์เดียว จะทำให้ทำงานได้ไวกว่า
	$result = rsQuery($sqlrow);
	if($result){
		$totalrecords= $num_rows = mysqli_num_rows($sqlrow); //หาจำนวนแถวของขัอมูลทั้งหมด
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
$sqlsub1="select * from $tablename_sub1 order by id Limit $goto,$pagelen";
$rs=rsQuery($sqlsub1);
if($rs){
	while($data=mysqli_fetch_array($rs)){
		$id=$data['id'];
		$name=$data['name'];
		$keyword=$data['detail'];
		$datepost=thaidate($data['datepost']);

		if($data['status']=="0"){
				$status ="<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&sub1_status=1&sub1_id=".$data['id']."\"><img src=\"../images/component/01.png\" border=\"0\" /></a>";
			}else{
				$status ="<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&sub1_status=0&sub1_id=".$data['id']."\"><img src=\"../images/component/02.png\" border=\"0\"  /></a>";
			}
		echo "<tr><td>$datepost</td>";
		echo "<td>$name</td>";
		echo "<td>$keyword</td>";
		echo "<td>$status</td>";
		echo "<td>";
		echo "<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&sub1_edit=".$data['id']."\" title='แก้ไขข้อมูล'><img src=\"../images/component/docs_16.gif\" border=\"0\" /></a>";
		echo "&nbsp;&nbsp;&nbsp;";
		echo "<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&sub1_del=".$data['id']."\" onclick=\"return confirm('คุณต้องการลบรายการนี้ใช่หรือไม่?');\" title='ลบข้อมูล'><img src=\"../images/component/del_16.gif\" border=\"0\"/></a>";
		echo "</td></tr>";
	}
}
echo "</table>";
echo "<div id=\"page_count\" align='center'>";
if ($page > 1) {
	$back = $page - 1;
	echo "<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&pagesub1=1\" title=\"หน้าแรก First Page\">|<<img src=\"images/bt_first.png\" style=\"width:50px;height:25px;border:0;vertical-align: text-bottom;\" align=top></a>";
	echo "<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&pagesub1=$back\" title=\"ย้อนกลับ Previous Page\"><<<img src=\"images/bt_prev.png\" style=\"width:50px;height:25px;border:0;vertical-align: text-bottom;\"></a>";
	if ($start > 1) { echo "....."; }
}
	$icount=1;
	For ($i=$start ; $i<=$end ; $i++) {
		$bgcolor = sprintf("#%06x",rand(0,16777215)); //แสดงสีสลับเมื่อ ค่า i เพิ่มค่าไปเรื่อย ๆ
		if ($i == $page ) {
			echo "&nbsp;<b><font color=#787a8d><a title=\"ขณะนี้คุณอยู่หน้าที่$i\">".$i."</a></font></b>" ;
		} else {
			echo "<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&pagesub1=".$i."\" title=\"ไปหน้าที่ $i\" style=\"color:$bgcolor\">".$i."</a>" ;
		}
		$icount++;
	}
	if ($page < $totalpage) {
	$next = $page +1;
	if ($end < $totalpage) { echo "....."; }
		echo "<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&pagesub1=$next\" title=\"หน้าต่อไป Next Page\">>><img src=\"images/bt_next.png\" style=\"width:50px;height:25px;border:0;vertical-align: text-bottom;\"></a>";
		echo "<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&pagesub1=$totalpage\" title=\"หน้าสุดท้าย Last Page\">>|<img src=\"images/bt_last.png\" style=\"width:50px;height:25px;border:0;vertical-align: text-bottom;\"></a>";
	}
	echo "<p>ขณะนี้คุณอยู่ที่หน้า $page</p></div>";

echo "</div>";

echo "</div>";



echo "</div>";
?>
<script type="text/javascript" src="../js/js01.js"></script>
<script>
function ajaxCall(select_id,displayid,tablename){
		var data="select_id="+select_id+"&tablename="+tablename;
		var URL="../itgmod/ajaxdata2sub.php";
		ajaxLoad("get",URL,data,displayid);
}

	function ajaxShowTable(select_id,displayid,tablename,modid){
		var data="select_id="+select_id+"&tablename="+tablename+"&modid="+modid+"&displayid="+displayid;
		var URL="../itgmod/ajaxdata2sub.php";
		ajaxLoad("get",URL,data,displayid);
}

function showForm(name,btn) {
    var x = document.getElementById(name);
	var y= document.getElementById(btn);
    if (x.style.display === 'none') {
        x.style.display = 'block';
		y.value='ซ่อนแบบฟอร์ม';
    } else {
        x.style.display = 'none';
		y.value='แสดงแบบฟอร์ม';
    }
}
</script>

<script>
    tinymce.init({

        selector: '#mytextarea',
        theme: 'modern',
        width: 600,
        height: 300,
        plugins: [
            'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
            'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
            'save table contextmenu directionality emoticons template paste textcolor'
        ],

        toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons',

        images_upload_url: '../js/tinymce/tiny_upload_image.php',

        images_upload_credentials: true
    });
</script>
