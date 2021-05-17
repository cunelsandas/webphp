<div class="content-box">
<p style="margin-left:10px;">ประเภทคำร้อง</p><hr><br>
<?php
//$tablename="tb_officertype";
empty($_GET['type'])?$type="":$type=$_GET['type'];
$modid=$_GET['_modid'];
$tablename=FindRS("select tablename from tb_mod where modid=$modid","tablename");

if($type=="addnews"){			 //ตรวจสอบก่อนว่ามีการตั้งค่าของ $_GET['type'] เป็นการเพิ่มข่าวใหม่หรือเปล่า
	include"helpme_type_add.php";
}elseif($type=="view"){	     //ตรวจสอบก่อนว่ามีการตั้งค่าของ $_GET['type'] เป็นการดูรายละเอียดข่าวสารหรือเปล่า
	include"officertype_view.php";
}else{
	if(isset($_GET['status'])){
		$sql="UPDATE $tablename SET status='".$_GET['status']."' Where id='".$_GET['id']."'";
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
?>

<p style="right:10%;position:absolute;"><?php echo"<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=addnews\" class=\"link\">เพิ่มประเภทคำร้อง</a>";?></p>

<center>
<p style="text-align:left;margin-bottom:3px;margin-left:10px;"><img src="../images/component/02.png"/> = active : <img src="../images/component/01.png" /> = not active </p>
<table width="100%" class="content-table">
<tr >
	<td width="70%" align="center">ประเภท</td>
	<td width="10%" align="center">ปรับปรุง</td>
</tr>
<?php
	$pagelen = 15; //จำนวนที่แสดงผลข้อมูลต่อหน้า
	$range = 4 ; // ใส่จำนวนที่จะแสดงข้าง เลขปัจจุบัน ก็คือ ถ้าใส่ 2 แล้ว ตอนนี้แสดงอยู่หน้า 4 ก็จะเป็น 2 3 4 5 6 จะแสดงข้างเลข 4 อยู่ 2 จำนวน
	$page = EscapeValue($_GET['page']); //รับค่าตัวแปร page แบบ get
	if(empty($page)){ $page=1; } //ถ้าตัวแปรเพจยังไม่มี ให้ค่าเริ่มต้นของ $page เป็น 1
	$officertype=$_GET['type'];

	$sql = "select id from $tablename order by listno ASC"; //คิวรี่ข้อมูล เพื่อหาจำนวน แถว Comment ควร select แค่ ฟิวส์เดียว จะทำให้ทำงานได้ไวกว่า
	$result = rsQuery($sql);
	if($result){
		$totalrecords= $num_rows = mysqli_num_rows($result); //หาจำนวนแถวของขัอมูลทั้งหมด
	}else{
		$totalrecords = $num_rows ="0";
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
	$sql1 = "select * from $tablename order by id"; //ทำการแสดงผลโดยใช้คำสั่ง Limit เพื่อแสดงจำนวนข้อมูลต่อหน้า
	//$sql="Select tb_officer.*,tb_officertype.oid as oid,tb_officertype.nametype From tb_officer INNER JOIN tb_officertype ON tb_officer.offid=tb_officertype.oid $offtype  order by tb_officer.offid, no Limit $goto,$pagelen";
############################# แบ่งหน้าเพื่อให้แสดงผลรวดเร็ว #######################

$Query = rsQuery($sql1); //คิวรี่คำสั่ง
	$totalp = mysqli_num_rows($Query); // หาจำนวน record ที่เรียกออกมา
	if($totalp==0){
		echo"<tr height=\"30\">";
		echo"<td colspan=\"5\" align=\"center\">- - - - - - - - - - ยังไม่มีข้อมูล - - - - - - - - - -</td>";
		echo"</tr>";
		/*	วนลูปข้อมูล */
	}else{
		$i=$start;
		while($arr = mysqli_fetch_assoc($Query)){
			echo"<tr >";
			//echo"<td>&nbsp;(".$arr['nolist'].")&nbsp;".$arr['name']."</td>";
			//echo"<td>&nbsp;".thaidate($arr['date'])."</td>";
			echo"<td>".$arr['name']."</td>";

			echo"<td align=\"center\">&nbsp;&nbsp;<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&del=".$arr['id']."\" onclick=\"return confirm('คุณต้องการลบหัวข้อข่าวนี้หรือไม่?');\"><img src=\"../images/component/del_16.gif\" border=\"0\"/></a></td>";
			echo"</tr>";
			$i++;
		}
	}
	echo"</table>";

	/* ตัวแบ่งหน้า */
	echo "<div id=\"page_count\">";

echo "";
if ($page > 1) {
$back = $page - 1;
echo "<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&page=1\" title=\"หน้าแรก First Page\">|<<img src=\"images/bt_first.png\" style=\"width:50px;height:25px;border:0;vertical-align: text-bottom;\" align=top></a>&nbsp;&nbsp;";
echo "<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&page=$back\" title=\"ย้อนกลับ Previous Page\"><<<img src=\"images/bt_prev.png\" style=\"width:50px;height:25px;border:0;vertical-align: text-bottom;\"></a>&nbsp;&nbsp;";
if ($start > 1) { echo "....."; }
}
$icount=1;
For ($i=$start ; $i<=$end ; $i++) {
//$bgcolor = ($icount% 2)? '#0080f$i' : '#ff000$i'; //แสดงสีสลับเมื่อ ค่า i เพิ่มค่าไปเรื่อย ๆ
$bgcolor = sprintf("#%06x",rand(0,16777215));
if ($i == $page ) {
echo "&nbsp;<b><font color=#787a8d><a title=\"ขณะนี้คุณอยู่หน้าที่$i\">".$i."</a></font></b>" ;
} else {
echo "&nbsp;<a href=main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&page=".$i."  title=\"ไปหน้า $i\" style=\"color:$bgcolor\">".$i."</a>" ;
}
$icount++;
}
if ($page < $totalpage) {
$next = $page +1;
if ($end < $totalpage) { echo "....."; }
echo "&nbsp;&nbsp;<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&page=$next\" title=\"หน้าต่อไป Next Page\">>><img src=\"images/bt_next.png\" style=\"width:50px;height:25px;border:0;vertical-align: text-bottom;\"></a>";
echo "&nbsp;<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&page=$totalpage\" title=\"หน้าสุดท้าย Last Page\">>|<img src=\"images/bt_last.png\" style=\"width:50px;height:25px;border:0;vertical-align: text-bottom;\"></a>";
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
