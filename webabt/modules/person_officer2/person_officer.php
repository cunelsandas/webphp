<?php
$mod = EscapeValue(decode64($_GET['_mod']));
$modname = FindRS("select * from tb_mod where modtype='$mod'", 'modname');
$tablename = FindRS("select * from tb_mod where modtype='$mod'", 'tablename');
$folder = FindRS("select * from tb_mod where modtype='$mod'", 'foldername');
$foldername = $gloUploadPath . "/" . $folder . "/";
$id = EscapeValue(decode64($_GET['type']));
$sql = "Select * From tb_officertype Where id='" . $id . "'";
$rs = rsQuery($sql);
$row = mysqli_fetch_assoc($rs);
$detail = $row['detail'];
$depname = $row['name'];
echo "<span class=\"banner_title\">โครงสร้างบุคลากร " . $depname . "</span><br><br>";
echo "<a href=\"#detail\"  style='right:30%;position:absolute;'>อำนาจหน้าที่ " . $depname . "</a>";
echo "<br>";
echo "<div class='tree' id='orgchart'>";


if (isset($_GET['type'])) {
    $type = decode64($_GET['type']);

    $sqlChkWorkGroup = "select * from tb_officer_subworkgroup where offid=$type order by listno";
    $rsChk = rsQuery($sqlChkWorkGroup);
    if ($rsChk) {
        $ChkRow = mysqli_num_rows($rsChk);  // จำนวนสายงานย่อย
    }


    $strWg = "select * from $tablename where offid=$type and workgroupid=0 and status>0 order by nolist";
    $rsWg = rsQuery($strWg);
    if ($rsWg) {

        $numrow1 = mysqli_num_rows($rsWg);
        if ($numrow1 > 0) {
            $i = 0;
            echo "<ul>";  //หัวหน้าส่วน
            while ($dataWg = mysqli_fetch_assoc($rsWg)) {
                $i += 1;
                $filepath = SearchImage($tablename, $dataWg['no'], $foldername, "0");
                $no = $dataWg['no'];
                $name = $dataWg['name'];
                $position = $dataWg['position'];
                $workgroup = $dataWg['workgroup'];
                $history = !empty($row['history']) ? "<br><a href=\"#\" onclick=\"open_new_window('../modules/popup/history_popup.php?no=" . encode64($no) . "&tb=" . encode64('tb_officer') . "&p=" . encode64('officer') . "');\"><img src=\"images/document_icon.png\"></a>" : "";
                //echo "<li>";
                echo "<div class='picbox'>" . $workgroup . "<br>";
                echo "<img src='$filepath?".rand(1,32000)."'>";
                echo "<br>$name<br>".nl2br($position)."<br>";
                echo "</div>";
                echo $history;
                //echo "</li><br>";
                if ($i < $numrow1) {
                    echo "<span class='line'></span>";
                }
            }
            $sqlworkgroup = "select * from tb_officer_workgroup where offid=$type order by listno";
            $rsw = rsQuery($sqlworkgroup);

            if ($rsw) {
                $numrow2 = mysqli_num_rows($rsw);
                if ($numrow2 > 0) {
                    echo "<ul>";

                    while ($dWorkGroup = mysqli_fetch_assoc($rsw)) {

                        $workgroup_id = $dWorkGroup['id'];
                        $workgroup_name = $dWorkGroup['name'];
                        echo "<li><span class='org_title'>$workgroup_name</span>";   //หัวหน้าฝ่าย
                        $sqlWK = "select * from $tablename where offid=$type and workgroupid=$workgroup_id and subworkgroupid=0 and status>0 Order by nolist";
                        $rs = rsQuery($sqlWK);
                        $numrow3 = mysqli_num_rows($rs);
                        if ($numrow3 > 0) {
                            $y = 0;
                            while ($dataWg = mysqli_fetch_assoc($rs)) {
                                $y += 1;
                                $filepath = SearchImage($tablename, $dataWg['no'], $foldername, "0");
                                $no = $dataWg['no'];
                                $name = $dataWg['name'];
                                $position = $dataWg['position'];
                                $workgroup = $dataWg['workgroup'];
                                $history = !empty($row['history']) ? "<br><a href=\"#\" onclick=\"open_new_window('../modules/popup/history_popup.php?no=" . encode64($no) . "&tb=" . encode64('tb_officer') . "&p=" . encode64('officer') . "');\"><img src=\"images/document_icon.png\"></a>" : "";
                                echo "<div class='picbox'>" . $workgroup . "<br>";
                                echo "<img src='$filepath?".rand(1,32000)."'>";
                                echo "<br>$name<br>$position<br>";
                                echo "</div>";
                                echo $history;
                                if ($y < $numrow3) {
                                    echo "<span class='line'></span>";
                                }
                            }
                        }

                        $sqlSub = "select * from tb_officer_subworkgroup where workgroupid=$workgroup_id order by listno";
                        $rsSub = rsQuery($sqlSub);

                        echo "<ul>";
                        while ($dSub = mysqli_fetch_assoc($rsSub)) {
                            $subworkgroup_id = $dSub['id'];
                            $subworkgroup_name = $dSub['name'];
                            echo "<li><span class='org_title'>$subworkgroup_name</span>";  //<a href="#">หัวหน้างาน</a>
                            $sqlOff = "select * from $tablename where offid=$type and workgroupid=$workgroup_id and subworkgroupid=$subworkgroup_id and status>0 order by nolist";
                            $rsOff = rsQuery($sqlOff);
                            $numrow4 = mysqli_num_rows($rsOff);
                            if ($numrow4 > 0) {
                                echo "<ul>";
                                echo "<li>"; //<a href="#">พนักงาน</a></li>
                                $z = 0;

                                while ($dOff = mysqli_fetch_assoc($rsOff)) {
                                    $z += 1;
                                    $filepath = SearchImage($tablename, $dOff['no'], $foldername, "0");
                                    $no = $dOff['no'];
                                    $name = $dOff['name'];
                                    $position = $dOff['position'];
                                    $workgroup = $dOff['workgroup'];

                                    $history = !empty($row['history']) ? "<br><a href=\"#\" onclick=\"open_new_window('../modules/popup/history_popup.php?no=" . encode64($dOff['no']) . "&tb=" . encode64('tb_officer') . "&p=" . encode64('officer') . "');\"><img src=\"images/document_icon.png\"></a>" : "";
                                    echo "<div class='picbox'>" . $workgroup . "<br>";
                                    echo "<img src='$filepath?".rand(1,32000)."'>";
                                    echo "<br>$name<br>$position<br>";
                                    echo "</div>";
                                    echo $history;
                                    if ($z < $numrow4) {
                                        echo "<span class='line'></span>";
                                    }

                                }
                                echo "</li>";
                                echo "</ul>";
                            }
                            echo "</li>";
                        }
                        echo "</ul>";
                        echo "</li>";
                    }
                    echo "</ul>";
                }
            }
            echo "</li>";
            echo "</ul>";
        }
    }
    echo "</div>";
    echo "<div style=\"clear:both;padding:10px;width:85%;\" >";
    echo "<a name='detail'><p>อำนาจหน้าที่ $depname</p></a>";
    echo $detail;
    echo "</div>";

}  //end if บนสุด

?>
<script>    $(document).ready(function () {
        var Row = "<?php echo $ChkRow;?>";
        var dwidth = document.getElementById("orgchart").offsetWidth;
        var picboxWidth = ((dwidth * 0.75) / Row);
        if (Row > 4) {
            if (picboxWidth > 130) {
                picboxWidth = 130;
            }
            var imgWidth = picboxWidth - 10;
            $('.picbox').css('width', picboxWidth + 'px');
            $('.picbox img').css('width', imgWidth + 'px');
        }
    });
</script>
