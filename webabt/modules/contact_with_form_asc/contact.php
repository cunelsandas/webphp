<?php
$mod = EscapeValue(decode64($_GET['_mod']));
$tablename = FindRS("select * from tb_mod where modtype='$mod'", "tablename");
$folder = FindRS("select * from tb_mod where modtype='$mod'", "foldername");
$modname = FindRS("select * from tb_mod where modtype='$mod'", "modname");
$bannername = FindRS("select * from tb_mod where modtype='$mod'", "bannername");
$foldername = $gloUploadPath . "/" . $folder . "/";
if (file_exists("images/" . $bannername) and $bannername <> "") {
    echo "<script>ChangeCssBg('data_image','" . $bannername . "');</script>";
} else {
    echo "<p class='banner_title'>$modname</p>";
}

?>

    <br>
    <br>




<?php

$sql = "select * from $tablename";
$rs = rsQuery($sql);
if ($rs) {
    $data = mysqli_fetch_array($rs);
    echo $data['detail'];
}

$part = "fileupload/" . $folder . "/";

if (isset($_POST['Submit'])) {

    /*$province=FindRS("SELECT * FROM province WHERE PROVINCE_ID=".$_POST['frm_province'],PROVINCE_NAME);
    $amphur=FindRS("SELECT * FROM amphur WHERE AMPHUR_ID=".$_POST['frm_amphur'],AMPHUR_NAME);
    $district=FindRS("SELECT * FROM district WHERE DISTRICT_ID=".$_POST['frm_district'],DISTRICT_NAME);
    $moo = $_POST['frm_moo'];
*/
    $check = getimagesize($_FILES["frm_image"]["tmp_name"][0]);

    $sql = "INSERT INTO tb_contact_us(id,name,email,tel,subject,detail,img_key,post_ip,status,active)
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
$sql = "select * from tb_contact_us order by id desc LIMIT 1";
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

    <br>
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
                                    <h6 style="color: black">
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
include 'itgmod/connect.inc.php';
if ($customer_lat <> "" and $customer_lng <> "") {
    $google_apikey = "AIzaSyDg49SZLUZdLu8KQ80fEAPJkbdBUqyN-vw";
    ?>


    <br>
    <br>
    <h5 style="text-decoration: underline;text-align: center"> แผนที่<?php echo $customer_name ?></h5>

    <div id="default-map"
         style="border:solid 3px #ffff99;width:90%;height:560px;padding:5px;box-shadow:5px 5px 5px #000000;background-color:#ffffcc"
         valign="center" align="center">
        <div id="googleMap" style="width:100%;height:540px;"></div>
        <BR><BR>
    </div>
    <!--<script src="http://maps.googleapis.com/maps/api/js"></script>-->
    <script
            src="https://maps.googleapis.com/maps/api/js?key=<?php echo $google_apikey; ?>&callback=initMap&libraries=&v=weekly"
            defer
    ></script>

    <script>
        function initMap() {
            const myLatLng = {lat: <?php echo $customer_lat;?>, lng: <?php echo $customer_lng;?> };
            const map = new google.maps.Map(document.getElementById("googleMap"), {
                zoom: 15,
                center: myLatLng,
            });
            new google.maps.Marker({
                position: myLatLng,
                map,
                title: "Hello World!",
            });
        }
    </script>
    <style>
        #tb1 table {
            background: #ccffff;
            color: #006600;
        }

        #tb1 td {
            background: #99cc00;
            color: #990000;
        }

        #tb1 td:hover {
            background: #ffff99;
        }

        #tb2 table {
            background: #ff9900;
            color: #000000;
        }

        #tb2 td:hover {
            background: #ff6600;
        }

        #tb3 table {
            background: #82cace;
            color: #000000;
        }

        #tb3 th {
            background: #214550;
            color: #ffffff;
        }

        #tb3 td {
            background: #428a9f;
            color: #ffffff;
        }

        #tb3 td:hover {
            background: #b1e7c1;
            color: #000000;
        }
    </style>

<?php } ?>