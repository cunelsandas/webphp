<?php

$mod = EscapeValue(decode64($_GET['_mod']));
$tablename = "tb_contact_us";
$folder = FindRS("select * from tb_mod where modtype='$mod'", "foldername");
$modname = FindRS("select * from tb_mod where modtype='$mod'", "modname");
$bannername = FindRS("select * from tb_mod where modtype='$mod'", "bannername");
$foldername = $gloUploadPath . "/" . $folder . "/";
if (file_exists("images/" . $bannername) and $bannername <> "") {
    echo "<script>ChangeCssBg('data_image','" . $bannername . "');</script>";
} else {
    echo "<p class='banner_title' style='width: 50%'>$modname</p>";
}

?>


    <br>
    <br>

    <section id="main" class="wrapper">
        <div class="inner">
            <div class="content">

                <div class="row">
                    <div class="col-12 col-12-medium">

                        <form method="post" action="#" onsubmit="return(validate());" name="myForm"
                              enctype="multipart/form-data">
                            <input type="hidden" name="id" id="id" value="<?php $newid = $row['id'] + 1;
                            echo $newid; ?>">
                            <div class="row gtr-uniform">
                                <!-- Break -->
                                <div class="col-12 col-12-xsmall">
                                    <h6>
                                        ช่องทางรับฟังความคิดเห็น <?php echo $customer_name ?>
                                        ยินดีรับฟังความคิดเห็นของประชาชน เพื่อนำมาปรับปรุงพัฒนาต่อไป</h6>
                                </div>
                                <div class="col-8 col-12-xsmall" style="margin: 0 auto">
                                    <input class="form-control" type="text" name="frm_subject" id="frm_subject"
                                           placeholder="หัวข้อ/เรื่อง"/>
                                </div>
                                <div class="col-8 col-12-xsmall mt-1" style="margin: 0 auto;">
                                    <input class="form-control" type="text" name="frm_name" id="frm_name" value=""
                                           placeholder="ชื่อ-สกุล"/>
                                </div>
                                <div class="col-8 col-12-xsmall mt-1" style="margin: 0 auto">
                                    <input class="form-control" type="text" name="frm_tel" id="frm_tel" value=""
                                           placeholder="เบอร์โทรศัพท์" onkeyup="autoTab2(this,2)"/>
                                </div>
                                <div class="col-8 col-12-xsmall mt-1" style="margin: 0 auto;">
                                    <input class="form-control" type="text" name="frm_address" id="frm_address" value=""
                                           placeholder="อีเมล์"/>
                                </div>
                                <div class="col-8 col-12-xsmall mt-1" style="margin: 0 auto">
                                    <textarea class="form-control" rows="10" name="frm_detail" id="frm_detail"
                                              placeholder="รายละเอียด"></textarea>
                                </div>
                            </div>

                            <div class="col-4" style="margin:2% auto;">
                                <ul class="actions">
                                    <input class="form-control bg-primary" type="submit" name="Submit" value="ส่งเรื่อง"
                                           class="primary"/></li>
                                </ul>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>


<?php

$sql = "select * from $tablename";
$rs = rsQuery($sql);
if ($rs) {
    $data = mysqli_fetch_array($rs);
//    echo $data['detail'];
}

$part = "fileupload/" . $folder . "/";

if (isset($_POST['Submit'])) {

    /*$province=FindRS("SELECT * FROM province WHERE PROVINCE_ID=".$_POST['frm_province'],PROVINCE_NAME);
    $amphur=FindRS("SELECT * FROM amphur WHERE AMPHUR_ID=".$_POST['frm_amphur'],AMPHUR_NAME);
    $district=FindRS("SELECT * FROM district WHERE DISTRICT_ID=".$_POST['frm_district'],DISTRICT_NAME);
    $moo = $_POST['frm_moo'];
*/
    $check = getimagesize($_FILES["frm_image"]["tmp_name"][0]);

    $sql = "INSERT INTO $tablename(id,name,email,tel,subject,detail,img_key,post_ip,status,active)
                  Values('','" . $_POST['frm_name'] . "','" . $_POST['frm_address'] . "','" . $_POST['frm_tel'] . "','" . $_POST['frm_subject'] . "','" . $_POST['frm_detail'] . "','" . $_POST['f_key'] . "'
                ,'" . $_SERVER['REMOTE_ADDR'] . "','1','1')";
    $rs = rsQuery($sql);

    if ($rs) {
        echo "<script>alert('ส่งข้อมูลแล้ว ขอบคุณที่ให้ความร่วมมือค่ะ');</script>";
    } else {
        echo "<script>alert('มีข้อผิดพลาดในการส่งข้อมูล'); </script>";
    }

}
?>


<?php
$sql = "select * from $tablename order by id desc LIMIT 1";
$rs = rsQuery($sql);
$rs->num_rows;
$row = $rs->fetch_assoc();

?>

    <!-- Main -->

    <script type="text/javascript">
        jQuery('#datetimepicker').datetimepicker();

        function checkID(id) {
            var cid = id.replace(/-/g, '');
            if (cid.length != 13) return false;
            for (i = 0, sum = 0; i < 12; i++)
                sum += parseFloat(cid.charAt(i)) * (13 - i);
            if ((11 - sum % 11) % 10 != parseFloat(cid.charAt(12)))
                return false;
            return true;
        }

        function validate() {

            if (document.myForm.frm_name.value == "") {
                alert("กรุณากรอก ชื่อ-สกุล!");
                document.myForm.frm_name.focus();
                return false;
            }
            if (document.myForm.frm_tel.value == "") {
                alert("กรุณากรอก เบอร์โทรศัพท์ !");
                document.myForm.frm_tel.focus();
                return false;
            }
            // if( document.myForm.frm_email.value == "" ) {
            //    alert( "กรุณากรอก อีเมล!" );
            //    document.myForm.frm_email.focus() ;
            //    return false;
            // }
            // if( document.myForm.frm_province.value == "" ) {
            //    alert( "กรุณาเลือก จังหวัด!" );
            //    document.myForm.frm_province.focus() ;
            //    return false;
            // }
            // if( document.myForm.frm_amphur.value == "" ) {
            //    alert( "กรุณาเลือก อำเภอ!" );
            //    document.myForm.frm_amphur.focus() ;
            //    return false;
            // }
            // if( document.myForm.frm_district.value == "" ) {
            //    alert( "กรุณาเลือก ตำบล!" );
            //    document.myForm.frm_district.focus() ;
            //    return false;
            // }
            // if( document.myForm.frm_moo.value == "" ) {
            //    alert( "กรุณากรอก หมู่ที่!" );
            //    document.myForm.frm_moo.focus() ;
            //    return false;
            // }
            // if( document.myForm.frm_numhome.value == "" ) {
            //    alert( "กรุณากรอก บ้านเลขที่!" );
            //    document.myForm.frm_numhome.focus() ;
            //    return false;
            // }
            if (document.myForm.frm_number.value == "") {
                alert("กรุณากรอก เลขบัตรประชาชน!");
                document.myForm.frm_number.focus();
                return false;
            } else {
                if (!checkID(document.myForm.frm_number.value)) {
                    alert('รหัสประชาชนไม่ถูกต้อง');
                    document.myForm.frm_number.focus();
                    return false;
                }
            }
            // if( document.myForm.frm_date_str.value == "" ) {
            //    alert( "กรุณาเลือก วันที่มารับ!" );
            //    document.myForm.frm_date_str.focus() ;
            //    return false;
            // }
            // if( document.myForm.frm_date_end.value == "" ) {
            //    alert( "กรุณาเลือก วันที่นำส่งคืน!" );
            //    document.myForm.frm_date_end.focus() ;
            //    return false;
            // }
            // if( document.myForm.frm_for.value == "" ) {
            //    alert( "กรุณากรอก จุดประสงค์ในการใช้งาน!" );
            //    document.myForm.frm_for.focus() ;
            //    return false;
            // }
            // if( document.myForm.frm_location.value == "" ) {
            //    alert( "กรุณากรอก สถานที่ในการรับบริการ!" );
            //    document.myForm.frm_location.focus() ;
            //    return false;
            // }


            return (true);
        }

    </script>