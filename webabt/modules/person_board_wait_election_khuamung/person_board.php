<?php
$mod = EscapeValue(decode64($_GET['_mod']));
$modname = FindRS("select * from tb_mod where modtype='$mod'", "modname");
$tablename = FindRS("select * from tb_mod where modtype='$mod'", "tablename");
$folder = FindRS("select * from tb_mod where modtype='$mod'", "foldername");
$foldername = $gloUploadPath . "/" . $folder . "/";
//	if($device=="Mobile"){
//		$block1_colsno="1"; //ประธาน แสดงจำนวน columnว่าให้แสงดกี่ภาพ
// $block2_colsno="1"; //รองประธาน
//	$block3_colsno="1"; // เลขา
//	$block4_colsno="1"; //สมาชิกเขต 1
//	$block5_colsno="1";
//	$block6_colsno="1";
//	}else{
//	$block1_colsno="1"; //ประธาน แสดงจำนวน columnว่าให้แสงดกี่ภาพ
//	$block2_colsno="3"; //รองประธาน
//	$block3_colsno="3"; // เลขา
//	$block4_colsno="3"; //สมาชิกเขต 1
//	$block5_colsno="3";
//	$block6_colsno="3";
//	}
//	$block4_title="";
//	$block5_title="";
//	$block6_title="";

$blockno = "20";
//กำหนดจำนวนรูปต่อแถว เริ่มจาก 0
if ($device == "Mobile") {
    $block_colno = array("0",
        "1",
        "1",
        "1",
        "1",
        "1",
        "1",
        "1",
        "1",
        "1",
        "1",
        "1",
        "1",
        "1",
        "1",
        "1",
        "1",
        "1",
        "1",
        "1",
        "1");
} else {
    $block_colno = array("0",
        "3",
        "3",
        "3",
        "3",
        "3",
        "3",
        "3",
        "3",
        "3",
        "3",
        "3",
        "3",
        "3",
        "3",
        "3",
        "3",
        "3",
        "3",
        "3",
        "3");
}
//กำหนดตำแหน่งรูป left,center,right เริ่มจาก 0
$align = array("center",
    "center",
    "center",
    "center",
    "center",
    "center",
    "center",
    "center",
    "center",
    "center",
    "center",
    "center",
    "center",
    "center",
    "center",
    "center",
    "center",
    "center",
    "center",
    "center",
    "center");
?>
<script type="text/javascript">
    function open_new_window(URL) {
        NewWindow = window.open(URL, "_blank", "toolbar=no,menubar=0,status=0,copyhistory=0,scrollbars=yes,resizable=1,location=0,Width=600,Height=600");
        NewWindow.location = URL;
    }
</script>
<div id="person_board">
    <br>
    <span class="banner_title"><?php echo $modname; ?></span>
    <center>
        <br><br>
        <table border="0" width="90%">
            <tr>
                <?php // ประธานสภา  บล๊อกการแสดง 1
                $i = 1;
                $sql = "Select * From $tablename Where sid='1' And status='1' order by nolist";
                $rs = rsQuery($sql);
                $total = $rs->num_rows;
                if ($total == 0) {
                    echo '<h3>"ดำเนินการเลือกตั้งเมื่อวันที่ 28 มีนาคม 2564 </h3>
<h3>อยู่ระหว่างการพิจารณาประกาศรับรองผลการเลือกตั้ง</h3>
<h3>ข้อมูลจะแสดงเมื่อคณะกรรมการเลือกตั้ง ประกาศรับรองผลการเลือกตั้ง"</h3>';
                }
                if ($rs) {
                    while ($row = mysqli_fetch_assoc($rs)) {
                        $filepath = SearchImage($tablename, $row['no'], $foldername, "0");
                        //$history=!empty($row['history'])?"<div class=\"tooltip\"><img src=\"images/document_icon.png\"><span>".$row['history']."</span></div>":"";
                        //$history=!empty($row['history'])?"<br><a href=\"#\" onclick=\"open_new_window('../modules/popup/history_popup.php?no=".encode64($row['no'])."&tb=".encode64('tb_board')."&p=".encode64('board')."');\"><img src=\"images/document_icon.png\"></a>":"";
                        echo "<td valign=\"top\" align=\"center\">";
                        echo "<table height=\"100%\" border=\"0\">";
                        echo "<tr>";
                        echo "<td align=\"center\"><img src=" . $filepath . "?" . rand(1, 32000) . " class=\"photo_border\"><div class='textbg'>" . $row['name'] . "<br/>" . nl2br($row['position']) . "</div>$history";
                        echo "</tr>";
                        echo "</table>";
                        echo "</td>";
                        if ($i == $block1_colsno) {
                            echo "</tr><tr>";
                            $i = 0;
                        }
                        $i++;
                    }
                }
                ?>
            </tr>
        </table>
        <BR>
        <table border="0" width="90%" align="center">
            <tr>
                <?php // รองประธาน  บล๊อกการแสดง 2
                $i = 1;
                $sql = "Select * From $tablename Where sid='2' And status='1' order by nolist";
                $rs = rsQuery($sql);
                if ($rs) {
                    while ($row = mysqli_fetch_assoc($rs)) {
                        $filepath = SearchImage($tablename, $row['no'], $foldername, "0");
                        //$history=!empty($row['history'])?"<br><a href=\"#\" onclick=\"open_new_window('../modules/popup/history_popup.php?no=".encode64($row['no'])."&tb=".encode64('tb_board')."&p=".encode64('board')."');\"><img src=\"images/document_icon.png\"></a>":"";
                        echo "<td valign=\"top\" align=\"center\">";
                        echo "<table height=\"100%\" border=\"0\">";
                        echo "<tr>";
                        echo "<td align=\"center\"><img src=" . $filepath . "?" . rand(1, 32000) . " class=\"photo_border\"><div class='textbg'>" . $row['name'] . "<br/>" . nl2br($row['position']) . "</div>$history";
                        echo "</tr>";
                        echo "</table>";
                        echo "</td>";
                        if ($i == $block2_colsno) {
                            echo "</tr><tr>";
                            $i = 0;
                        }
                        $i++;
                    }
                }
                ?>
            </tr>
        </table>
        <br>
        <!--เลขา-->
        <table border="0" width="90%" align="center">
            <tr>
                <?php // เลขาหรือที่ปรึกษา  บล๊อกการแสดง 3
                $i = 1;
                $sql = "Select * From $tablename Where sid='3' And status='1' order by nolist";
                $rs = rsQuery($sql);
                if ($rs) {
                    while ($row = mysqli_fetch_assoc($rs)) {
                        $filepath = SearchImage($tablename, $row['no'], $foldername, "0");
                        //$history=!empty($row['history'])?"<br><a href=\"#\" onclick=\"open_new_window('../modules/popup/history_popup.php?no=".encode64($row['no'])."&tb=".encode64('tb_board')."&p=".encode64('board')."');\"><img src=\"images/document_icon.png\"></a>":"";
                        echo "<td valign=\"top\"  align=\"center\">";
                        echo "<div class='align-position'>";
                        echo "<table height=\"100%\" >";
                        echo "<tr>";
                        echo "<td align=\"center\"><img src=" . $filepath . "?" . rand(1, 32000) . " class=\"photo_border\"><div class='textbg'>" . $row['name'] . "<br/>" . nl2br($row['position']) . "</div>$history";
                        echo "</tr>";
                        echo "</table>";
                        echo "</div>";
                        echo "</td>";
//								if($i==$block3_colsno){  variable not work
                        if ($i == $block_colno[3]) {
                            echo "</tr><tr>";
                            $i = 0;
                        }
                        $i++;
                    }
                }
                ?>
            </tr>
        </table>
        <br>


        <?php
        // สมาชิกเขตต่างๆ
        for ($x = 4; $x <= $blockno; $x++) {
            echo "<table border=\"0\"  align=\"center\" width=\"95%\">";
            echo "<tr>";
            // พนักงานเจ้าหน้าที่  บล๊อกการแสดง $x
            $i = 1;
            $sql = "Select * From $tablename Where sid='" . $x . "' And status='1' order by nolist";
            $rs = rsQuery($sql);
            if ($rs) {
                while ($row = mysqli_fetch_assoc($rs)) {
                    $filepath = SearchImage($tablename, $row['no'], $foldername, "0");

                    if ($row['position'] == "blank") {
                        $position = "";
                    } else {
                        $position = $row['position'];
                    }
                    if ($row['name'] == "blank") {
                        $name = "";
                        $td = "<span width='100%'>&nbsp;&nbsp;</span>";
                    } else {
                        $name = $row['name'];
                        $td = "<center><img src=" . $filepath . "?" . rand(1, 32000) . " class=\"photo_border\"><div class='textbg'>" . $name . "<br/>" . nl2br($position) . "</div></center><br/><br/>";
                    }
                    $history = !empty($row['history']) ? "<br><a href=\"#\" onclick=\"open_new_window('../modules/popup/history_popup.php?no=" . encode64($row['no']) . "&tb=" . encode64('tb_officer') . "&p=" . encode64('officer') . "');\"><img src=\"images/document_icon.png\"></a>" : "";
                    echo "<td valign=\"top\" align=\"" . $align[$x] . "\" width='33%'>";
                    //	echo"<table height=\"100%\" border=\"0\">";
                    //	echo"<tr>";
                    //	echo "<td>";
                    echo $td;
                    //		echo"</td></tr>";
                    //		echo"</table>";
                    echo "</td>";
                    if ($i == $block_colno[$x]) {
                        echo "</tr><tr>";
                        $i = 0;
                    }
                    $i++;
                }
            }

            echo "</tr>";
            echo "</table>";
        }
        ?>


    </center>
</div>
