<style>
	.bt-purchase {
	border:1px solid #1a2fee;
	background-color:#1298af;
	color:white;
	padding:2px;
	border-radius:5px;

}
	.bt-purchase:hover{

	background-color:#0a4f5a;
	color:#ffff00;
}
</style>
<div class="content-box">
<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
empty($_GET['type'])?$type="":$type=$_GET['type'];
$modid=$_GET['_modid'];
$modname=FindRS("select modname from tb_mod where modid=$modid","modname");
$tablename=FindRS("select tablename from tb_mod where modid=$modid","tablename");

echo "<p >$modname</p><hr><br>";

if($type=="addnew"){			 //ตรวจสอบก่อนว่ามีการตั้งค่าของ $_GET['type'] เป็นการเพิ่มข่าวใหม่หรือเปล่า
	include"purchase_add.php";
}elseif($type=="view"){	     //ตรวจสอบก่อนว่ามีการตั้งค่าของ $_GET['type'] เป็นการดูรายละเอียดข่าวสารหรือเปล่า
	include"purchase_view.php";
}else{
	if(isset($_GET['status'])){
		$sql="UPDATE $tablename SET status='".$_GET['status']."' Where no='".$_GET['no']."'";
		$rs=rsQuery($sql);
		if($rs){
			echo"<script>window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
		}
	}
if(isset($_GET['del'])){
    $folder = FindRS("select foldername from tb_mod where modid=$modid", "foldername");
    $foldername = "/" . $gloUploadPath . "/" . $folder . "/";
    $sqldel="select * from filename where masterid=".$_GET['del'];
    $rsdel=rsQuery($sqldel);
    if($rsdel){
        while($delfile=mysqli_fetch_assoc($rsdel)){
            $filenameFordel = $delfile['filename'];
            //echo "File for Delete ".$_SERVER['DOCUMENT_ROOT'].$foldername.$filenameFordel;
            if ($filenameFordel <> "Not Found") {
                unlink($_SERVER['DOCUMENT_ROOT'] . $foldername . $filenameFordel);
                echo"<script>window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
            }
        }
        $sql = "DELETE From filename Where masterid='" . $_GET['del'] . "'";
        $rs = rsQuery($sql);
    }

    $sql = "DELETE From $tablename Where no='" . $_GET['del'] . "'";
    $rs=rsQuery($sql);
    if($rs){
        // update table tb_trans บันทึกการลบ
        $updatetran=UpdateTrans($tablename,'delete',$_SESSION['username'],'ID:'.$_GET['del']. '/' . $foldername . '/' . $filenameFordel.' IP: '.$_SERVER['REMOTE_ADDR'] .' /'. get_browser_name($_SERVER['HTTP_USER_AGENT']));
        echo"<script>window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
    }
}
?>
<p style="right:10%;position:absolute;"><?php echo"<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=addnew\" class='link'>เพิ่มรายการใหม่</a>";?></p><br>
<center>
<p style="text-align:left;margin-bottom:3px;margin-left:10px;"><img src="../images/component/02.png"/> = active : <img src="../images/component/01.png" /> =not active </p>
<p>
<?php
	$sqlg="select * from tb_purchase_group";
	$rsg=rsQuery($sqlg);
	if($rsg and mysqli_num_rows($rsg)>0){
		echo "<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&page=1&groupid=0\" title=\"ทั้งหมด\" class='bt-purchase'>ทั้งหมด</a>&nbsp;&nbsp;";
		while($gdata=mysqli_fetch_assoc($rsg)){
			$gname=$gdata['name'];
			$gid=$gdata['id'];
			echo "<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&page=1&groupid=".$gid."\" title=\"$gname\" class='bt-purchase'>$gname</a>&nbsp;&nbsp;";
		}
	}
?>
</p><br>
<table class="content-table">
	<thead>
		<tr>
			<th width="65%" class="topleft">&nbsp;รายการ</th>
			<th width="15%" align="center">วันที่</th>
			<th width="10%" align="center">สถานะ</th>
			<th width="10%" align="center" class="topright">ปรับปรุง</th>
		</tr>
	</thead>
	  <tfoot>
    	<tr>
        	<td colspan="3" class="botleft"><em></em></td>
        	<td class="botright">&nbsp;</td>
        </tr>
    </tfoot>
<?php
	$pagelen = 15; //จำนวนที่แสดงผลข้อมูลต่อหน้า
	$range = 4 ; // ใส่จำนวนที่จะแสดงข้าง เลขปัจจุบัน ก็คือ ถ้าใส่ 2 แล้ว ตอนนี้แสดงอยู่หน้า 4 ก็จะเป็น 2 3 4 5 6 จะแสดงข้างเลข 4 อยู่ 2 จำนวน
    $page = (isset($_GET['page'])) ? $_GET['page'] : ''; //รับค่าตัวแปร page แบบ get
    $groupid = (isset($_GET['groupid'])) ? $_GET['groupid'] : '';
	if(empty($page)){ $page=1; } //ถ้าตัวแปรเพจยังไม่มี ให้ค่าเริ่มต้นของ $page เป็น 1
	if($groupid==0){
		$colname="ทั้งหมด";
		$sql = "select no from $tablename"; //คิวรี่ข้อมูล เพื่อหาจำนวน แถว Comment ควร select แค่ ฟิวส์เดียว จะทำให้ทำงานได้ไวกว่า
	}else{
		$colname=$gname;
		$sql="select no from $tablename where groupid=".$groupid;
	}
	$result = rsQuery($sql)or die(mysqli_error());
	$totalrecords= $num_rows = mysqli_num_rows($result); //หาจำนวนแถวของขัอมูลทั้งหมด
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
	if($groupid==0){
		$sql = "select * from $tablename order by datepost DESC Limit $goto,$pagelen"; //ทำการแสดงผลโดยใช้คำสั่ง Limit เพื่อแสดงจำนวนข้อมูลต่อหน้า
	}else{
		$sql = "select * from $tablename Where groupid=".$groupid." order by datepost DESC Limit $goto,$pagelen"; //ทำการแสดงผลโดยใช้คำสั่ง Limit เพื่อแสดงจำนวนข้อมูลต่อหน้า
	}
$modid=$_GET['_modid'];
/*คิวรี่ข้อมูลออกมาเพื่อแสดงผล */
$Query = rsQuery($sql); //คิวรี่คำสั่ง
	$totalp = mysqli_num_rows($Query); // หาจำนวน record ที่เรียกออกมา
	if($totalp==0){
		echo"<tr height=\"30\">";
		echo"<td colspan=\"5\" align=\"center\">- - - - - - - - - - ยังไม่มีข้อมูล - - - - - - - - - -</td>";
		echo"</tr>";
		/*	วนลูปข้อมูล */
	}else{
		$i=$start;
		echo "<tr><th colspan='4' align='left'>ประเภท $colname&nbsp;จำนวน $totalrecords รายการ</th></tr>";
		while($arr = mysqli_fetch_assoc($Query)){
			echo"<tr >";
			echo"<td>&nbsp;".$arr['subject']."</td>";
			echo"<td>&nbsp;".thaidate($arr['datepost'])."</td>";
			echo"<td align=\"center\">";
			if($arr['status']=="0"){
				echo"<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&status=1&no=".$arr['no']."\"><img src=\"../images/component/01.png\" border=\"0\" /></a>";
			}else{
				echo"<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&status=0&no=".$arr['no']."\"><img src=\"../images/component/02.png\" border=\"0\"  /></a>";
			}
			echo"</td>";
			echo"<td align=\"center\"><a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=view&no=".$arr['no']."\"><img src=\"../images/component/docs_16.gif\" border=\"0\" /></a>&nbsp;&nbsp;&nbsp;<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&del=".$arr['no']."\" onclick=\"return confirm('คุณต้องการลบหัวข้อข่าวนี้หรือไม่?');\"><img src=\"../images/component/del_16.gif\" border=\"0\"/></a></td>";
			echo"</tr>";
			$i++;
		}
	}
	echo"</table>";

echo "<div id=\"page_count\">";
if ($page > 1) {
	$back = $page - 1;
	echo "<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&page=1&groupid=".$_GET['groupid']."\" title=\"หน้าแรก First Page\">|<<img src=\"images/bt_first.png\" style=\"width:50px;height:25px;border:0;vertical-align: text-bottom;\" align=top></a>";
	echo "<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&page=$back&groupid=".$_GET['groupid']."\" title=\"ย้อนกลับ Previous Page\"><<<img src=\"images/bt_prev.png\" style=\"width:50px;height:25px;border:0;vertical-align: text-bottom;\"></a>";
	if ($start > 1) { echo "....."; }
}
	$icount=1;
	For ($i=$start ; $i<=$end ; $i++) {
		$bgcolor = sprintf("#%06x",rand(0,16777215)); //แสดงสีสลับเมื่อ ค่า i เพิ่มค่าไปเรื่อย ๆ
		if ($i == $page ) {
			echo "&nbsp;<b><font color=#787a8d><a title=\"ขณะนี้คุณอยู่หน้าที่$i\">".$i."</a></font></b>" ;
		} else {
			echo "<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&page=".$i."&groupid=".$_GET['groupid']."\" title=\"ไปหน้าที่ $i\" style=\"color:$bgcolor\">".$i."</a>" ;
		}
		$icount++;
	}
	if ($page < $totalpage) {
	$next = $page +1;
	if ($end < $totalpage) { echo "....."; }
		echo "<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&page=$next&groupid=".$_GET['groupid']."\" title=\"หน้าต่อไป Next Page\">>><img src=\"images/bt_next.png\" style=\"width:50px;height:25px;border:0;vertical-align: text-bottom;\"></a>";
		echo "<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&page=$totalpage&groupid=".$_GET['groupid']."\" title=\"หน้าสุดท้าย Last Page\">>|<img src=\"images/bt_last.png\" style=\"width:50px;height:25px;border:0;vertical-align: text-bottom;\"></a>";
	}
	echo "<p>ขณะนี้คุณอยู่ที่หน้า $page &nbsp;จากทั้งหมด $totalpage หน้า($totalrecords รายการ)</p></div>";
}

?>
</table>
</center>
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
