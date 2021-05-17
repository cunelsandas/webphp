
<div id="data_image" style="padding-top: 150px">
    <!--<div id="data_image">-->
<?php
$mod = EscapeValue(decode64($_GET['_mod']));
$tablename = FindRS("select * from tb_mod where modtype='$mod'", 'tablename');
$folder = FindRS("select * from tb_mod where modtype='$mod'", 'foldername');
$modname = FindRS("select * from tb_mod where modtype='$mod'", 'modname');
$bannername = FindRS("select * from tb_mod where modtype='$mod'", 'bannername');
$foldername = $gloUploadPath . "/" . $folder . "/";
if ($mod == "travel") {
    if (file_exists("images/header_travel.jpg")) {
        echo '<div class="wrapper2">';
        echo '<img style="max-width: 800px !important;max-height: 500px !important;" src=images/header_travel.jpg>';
        echo '</div>';
    }
}
echo "<center>";
if ($device <> "Mobile") {
    if (file_exists("images/" . $bannername) and $bannername <> "") {
        echo "<script>ChangeCssBg('data_image','" . $bannername . "');</script>";
    } else {
        echo "<p class='banner_title'>$modname</p>";
    }
} else {
    echo "<p class='banner_title'>$modname</p>";
}
echo "</center>";
$no = !empty($_GET['no']) ? $_GET['no'] : null;

if ($no <> "") {
    include "data_image_view.php";
} else {

    $pagelen = 15; //จำนวนที่แสดงผลข้อมูลต่อหน้า
    $range = 4; // ใส่จำนวนที่จะแสดงข้าง เลขปัจจุบัน ก็คือ ถ้าใส่ 2 แล้ว ตอนนี้แสดงอยู่หน้า 4 ก็จะเป็น 2 3 4 5 6 จะแสดงข้างเลข 4 อยู่ 2 จำนวน
    //รับค่าตัวแปร page แบบ get
    if (isset($_GET['page'])) {
        $page = EscapeValue($_GET['page']);
    } else {
        $page = "1";
    }
    $sql = "select no from $tablename Where status='1'"; //คิวรี่ข้อมูล เพื่อหาจำนวน แถว Comment ควร select แค่ ฟิวส์เดียว จะทำให้ทำงานได้ไวกว่า
    $result = rsQuery($sql);
    if ($result) {
        $totalrecords = $num_rows = mysqli_num_rows($result); //หาจำนวนแถวของขัอมูลทั้งหมด
    } else {
        $totalrecords = $num_rows = "0";
    }
    $totalpage = ceil($num_rows / $pagelen);
    $goto = ($page - 1) * $pagelen; // หาหน้าที่จะกระโดดไป
    $start = $page - $range;
    $end = $page + $range;
    if ($start <= 1) {
        $start = 1;
    }
    if ($end >= $totalpage) {
        $end = $totalpage;
    }
    $sql1 = "select * from $tablename Where status='1' order by datepost DESC Limit $goto,$pagelen"; //ทำการแสดงผลโดยใช้คำสั่ง Limit เพื่อแสดงจำนวนข้อมูลต่อหน้า


    /*คิวรี่ข้อมูลออกมาเพื่อแสดงผล */
    //$sql="Select * From ".$tablename." Where status='1'  Order by no DESC Limit $start1,$limit";

    $Query = rsQuery($sql1); //คิวรี่คำสั่ง
//	$totalp = mysqli_num_rows($Query); // หาจำนวน record ที่เรียกออกมา
    if ($totalrecords == 0) {
        echo "<p align=\"center\">- - - - - - - - - - ยังไม่มีข้อมูล- - - - - - - - - -</p><BR><BR><BR><BR>";
        /*	วนลูปข้อมูล */
    } else {


        while ($arr = mysqli_fetch_assoc($Query)) {
            $showimage = SearchImage($tablename, $arr['no'], $foldername, "0");
            $msg = $arr['detail1'];
            $subject = "<a href=\"index.php?_mod=" . encode64($mod) . "&no=" . encode64($arr['no']) . "\">" . $arr['subject'] . "</a>";
            if ($showdate == "yes") {
                $datepost = "<div class=\"showdatepost\">" . thaidate($arr['datepost']) . "</div>";
            } else {
                $datepost = "";
            }
            echo "<table width=\"100%\">";
            echo "<tr>";
            echo "<td valign=\"top\" >";
            echo "<img src='" . $showimage . "' alt='" . $arr['subject'] . ',' . $customer_name . ',' . $domainname . "'>";
            echo "</td>";
            echo "<td  valign=\"top\">";
            echo "<div class=\"subject\">$subject</div>";
            echo "<div class=\"detail150\">$msg</div>";
            echo $datepost;
            echo "</td>";
            echo "</tr>";
            echo "</table><br>";

        }
    }
//$i = 1;
//	while($fetch_pro = mysqli_fetch_assoc($result_reply)){
//		$bgcolor = ($i % 2)? '#EAF1FF' : '#fafafa'; //แสดงสีสลับเมื่อ ค่า i เพิ่มค่าไปเรื่อย ๆ
//		$i++;
//	}
    echo "<div id=\"page_count\">";
    if ($page > 1) {
        $back = $page - 1;
        echo "<a href=\"index.php?_mod=" . encode64($mod) . "&page=1\" title=\"หน้าแรก First Page\">|<</a>";
        echo "<a href=\"index.php?_mod=" . encode64($mod) . "&page=$back\" title=\"ย้อนกลับ Previous Page\"><<</a>";
        if ($start > 1) {
            echo ".....";
        }
    }
    $icount = 1;
    for ($i = $start; $i <= $end; $i++) {
        $bgcolor = sprintf("#%06x", rand(0, 16777215)); //แสดงสีสลับเมื่อ ค่า i เพิ่มค่าไปเรื่อย ๆ
        if ($i == $page) {
            echo "<a title=\"ขณะนี้คุณอยู่หน้าที่$i\">" . $i . "</a>";
        } else {
            echo "<a href=\"index.php?_mod=" . encode64($mod) . "&page=" . $i . "\" title=\"ไปหน้าที่ $i\" >" . $i . "</a>";
        }
        $icount++;
    }
    if ($page < $totalpage) {
        $next = $page + 1;
        if ($end < $totalpage) {
            echo ".....";
        }
        echo "<a href=\"index.php?_mod=" . encode64($mod) . "&page=$next\" title=\"หน้าต่อไป Next Page\">>></a>";
        echo "<a href=\"index.php?_mod=" . encode64($mod) . "&page=$totalpage\" title=\"หน้าสุดท้าย Last Page\">>|</a>";
    }
    echo "<p>ขณะนี้คุณอยู่ที่หน้า $page / $totalpage &nbsp;($totalrecords รายการ)</p>";
    echo "</div>";
    echo "</div>";

}
?>