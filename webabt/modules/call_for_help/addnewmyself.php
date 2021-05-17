<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="js/popper.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>

<script type="text/javascript">

    $(function () {
        // แทรกโค้ต jquery
        $("#dateInput").datepicker({dateFormat: 'yy-mm-dd'});
    });


</script>

<style>
    /* Always set the map height explicitly to define the size of the div
     * element that contains the map. */
    body {
        font-family: THK2DJuly8;
        font-size: 14px;
    }

    h1, h2, h3, h4, h5, h6 {
        font-family: THK2DJuly8
    }

    /* Optional: Makes the sample page fill the window. */
    #map2 {
        height: 400px;
        width: 100%;
    }
</style>


<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/vendor/autoload.php';

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

if (isset($_POST['sub'])) {
    $check = getimagesize($_FILES["f_image"]["tmp_name"][0]);
    if ($check == false) {

        if ($_POST['firstname'] == "") {
            "T1";
        } else {


            /*		#EMAIL---------------------------------------------------------------------------------------------------------------------------------------

                    $fm = "admin@itglobal.co.th"; // *** ต้องใช้อีเมล์ @yourdomain.com เท่านั้น  ***
                    $to = "info@".$domainname;//
                    $custemail = "info@".$domainname; // อีเมล์ของผู้ติดต่อที่กรอกผ่านแบบฟอร์ม

                    $subj = $_POST['f_subject'];

                    // -------------------------------------------------------------------
                    $message.= $_POST['f_detail'];

                    // -------------------------------------------------------------------

                    $mesg = $message;

                    $mail = new PHPMailer();
                    $mail->CharSet = "utf-8";

                    $mail->SMTPDebug = 2;
                    $mail->IsSMTP();

                    $mail->Mailer = "smtp";
                    $mail->SMTPAutoTLS = false; //false//true
                    //$mail->SMTPSecure = 'ssl'; // บรรทัดนี้ ให้ Uncomment ไว้ เพราะ Mail Server ของโฮสต์ ไม่รองรับ SSL.
                    $mail->Port = "25"; // หมายเลข Port สำหรับส่งอีเมล์ 25 // 465

                    $mail->Host = "mail.itglobal.co.th"; //ใส่ SMTP Mail Server ของท่าน
                    $mail->Username = "noreply@itglobal.co.th"; //ใส่ Email Username ของท่าน (ที่ Add ไว้แล้วใน Plesk Control Panel)
                    $mail->Password = "456852aB"; //ใส่ Password ของอีเมล์ (รหัสผ่านของอีเมล์ที่ท่านตั้งไว้)
                     //-------------------------------------------------------------------

                    //$mail->From = $fm;
                    $mail->SetFrom($fm);
                    $mail->AddAddress($to);
                    $mail->AddReplyTo($custemail);

                    $mail->Subject = $subj;
                    $mail->MsgHTML($mesg);
                    $mail->WordWrap = 50;
                    //

                    if(!$mail->Send()) {
                    echo "<script>alert('Send Mail ERROR')</script>";
                    echo "<script>console.log('".$mail->ErrorInfo."')</script>";
                    exit;
                }
*/


//            $to = "info@".$domainname;
//            $subject = $_POST['f_subject'];
//            $txt = $_POST['f_detail'];
//
//            $headers = "MIME-Version: 1.0\r\n" ;
//            $headers .= "Content-type: text/html; charset=UTF-8\r\n" ;
//            //$headers .= "From: " . $_POST['femail'] . "\r\n" ."CC: migarl38@hotmail.com";
//            $headers .= "From: ".$_POST['f_email']." <".$_POST['f_email'].">\r\n" ;
//            $headers .= "Reply-to: ".$_POST['f_email']." <".$_POST['f_email'].">\r\n" ;
//            $headers .= "X-Priority: 3\r\n" ;
//            $headers .= "X-Mailer: PHP mailer\r\n" ;
//
//            mail($to,$subject,$txt,$headers);
//            echo "<script>alert('Send Mail OK1')</script>";

            #EMAIL---------------------------------------------------------------------------------------------------------------------------------------


            $sql = "INSERT INTO tb_call_for_help(id,call_ask_type,title_name,firstname,lastname,idcard,home_num,moo,road,tambon,amphoe,province,telephone,title_name_co,firstname_co,lastname_co,call_help_type,detail_call_type,detail_call_help,f_lat,f_lng,datepost,ip,typewb,status,updatetime,image_key) Values('','1','" . $_POST['title_name'] . "','" . $_POST['firstname'] . "','" . $_POST['lastname'] . "','" . $_POST['idcard'] . "','" . $_POST['home_num'] . "','" . $_POST['moo'] . "','" . $_POST['road'] .
                "','" . $_POST['tambon'] . "','" . $_POST['amphoe'] . "','" . $_POST['province'] . "','" . $_POST['telephone'] . "','" . $_POST['title_name_co'] . "','" . $_POST['firstname_co'] . "','" . $_POST['lastname_co'] .
                "','" . $_POST['call_help_type'] . "','" . $_POST['detail_call_type'] . "','" . $_POST['detail_call_help'] . "','" . $_POST['f_lat'] . "','" . $_POST['f_lng'] . "','" . $_POST['f_dateInput'] . "','". $_SERVER['REMOTE_ADDR'] .
                "','" . "','1','1','1','" . $_POST['f_key'] . "')";
            $rs = rsQuery($sql);
            if ($rs) {
                echo "<script>alert('การลงทะเบียนเรียบร้อยแล้วค่ะ');window.location.href='index.php?_mod=" . $_GET['_mod'] . "';</script>";//
            } else {
                echo "<script>alert('Err'); </script>";
            }
        }

    } else {

        if ($_POST['firstname'] == "") {
            "T1";
        } else {
            /*
                                #EMAIL--------------------------------------------------

                                #EMAIL---------------------------------------------------------------------------------------------------------------------------------------

                                $fm = "admin@itglobal.co.th"; // *** ต้องใช้อีเมล์ @yourdomain.com เท่านั้น  ***
                                $to = "info@".$domainname;//
                                $custemail = "info@".$domainname; // อีเมล์ของผู้ติดต่อที่กรอกผ่านแบบฟอร์ม

                                $subj = $_POST['f_subject'];

                                // -------------------------------------------------------------------
                                $message.= $_POST['f_detail'];

                                // -------------------------------------------------------------------

                                $mesg = $message;

                                $mail = new PHPMailer();
                                $mail->CharSet = "utf-8";

                                $mail->SMTPDebug = 2;
                                $mail->IsSMTP();

                                $mail->Mailer = "smtp";
                                $mail->SMTPAutoTLS = false; //false//true
                                //$mail->SMTPSecure = 'ssl'; // บรรทัดนี้ ให้ Uncomment ไว้ เพราะ Mail Server ของโฮสต์ ไม่รองรับ SSL.
                                $mail->Port = "25"; // หมายเลข Port สำหรับส่งอีเมล์ 25 // 465

                                $mail->Host = "mail.itglobal.co.th"; //ใส่ SMTP Mail Server ของท่าน
                                $mail->Username = "noreply@itglobal.co.th"; //ใส่ Email Username ของท่าน (ที่ Add ไว้แล้วใน Plesk Control Panel)
                                $mail->Password = "456852aB"; //ใส่ Password ของอีเมล์ (รหัสผ่านของอีเมล์ที่ท่านตั้งไว้)
                                 //-------------------------------------------------------------------

                                //$mail->From = $fm;
                                $mail->SetFrom($fm);
                                $mail->AddAddress($to);
                                $mail->AddReplyTo($custemail);

                                $mail->Subject = $subj;
                                $mail->MsgHTML($mesg);
                                $mail->WordWrap = 50;
                                //

                                if(!$mail->Send()) {
                                echo "<script>alert('Send Mail ERROR')</script>";
                                echo "<script>console.log('".$mail->ErrorInfo."')</script>";
                                exit;
                            }
            */
//            $to = "info@".$domainname;
//            $subject = $_POST['f_subject'];
//            $txt = $_POST['f_detail'];
//
//            $headers = "MIME-Version: 1.0\r\n" ;
//            $headers .= "Content-type: text/html; charset=UTF-8\r\n" ;
//            //$headers .= "From: " . $_POST['femail'] . "\r\n" ."CC: migarl38@hotmail.com";
//            $headers .= "From: ".$_POST['f_email']." <".$_POST['f_email'].">\r\n" ;
//            $headers .= "Reply-to: ".$_POST['f_email']." <".$_POST['f_email'].">\r\n" ;
//            $headers .= "X-Priority: 3\r\n" ;
//            $headers .= "X-Mailer: PHP mailer\r\n" ;
//
//            mail($to,$subject,$txt,$headers);
//            echo "<script>alert('Send Mail OK')</script>";
            //echo "<script>console.log('".$mail->ErrorInfo."')</script>";
            #EMAIL--------------------------------------------------


            for ($i = 0; $i < count($_FILES['f_image']['name']); $i++) {

                $filename = $_FILES["f_image"]["name"][$i];
                $ext = end(explode(".", $filename));
                $newname = "CFH_" . $_POST['id'] . '_' . $i . '.' . $ext;
                $filetmp = $_FILES["f_image"]["tmp_name"][$i];
                $filetype = $_FILES["f_image"]["type"][$i];
                $filepath = "fileupload/call_for_help/" . $newname;

                if (move_uploaded_file($filetmp, $filepath)) {

                    $sql = "INSERT INTO tb_files_image(id_image,image_path,image_key) VALUES ('','" . $filepath . "','" . $_POST['f_key'] . "')";
                    $rs = rsQuery($sql);
                } else {
                    echo "<script>alert('Image not upload.'); </script>";
                }
            }


            $sql = "INSERT INTO tb_call_for_help(id,call_ask_type,title_name,firstname,lastname,age,idcard,home_num,moo,road,tambon,amphoe,province,telephone,title_name_co,firstname_co,lastname_co,call_help_type,detail_call_type,detail_call_help,f_lat,f_lng,datepost,ip,typewb,status,updatetime,image_key)Values('','1','" . $_POST['title_name'] . "','" . $_POST['firstname'] . "','" . $_POST['lastname'] . "','" . $_POST['age'] . "','" . $_POST['idcard'] . "','" . $_POST['home_num'] . "','" . $_POST['moo'] . "','" . $_POST['road'] .
"','" . $_POST['tambon'] . "','" . $_POST['amphoe'] . "','" . $_POST['province'] . "','" . $_POST['telephone'] . "','" . $_POST['title_name_co'] . "','" . $_POST['firstname_co'] . "','" . $_POST['lastname_co'] .
"','" . $_POST['call_help_type'] . "','" . $_POST['detail_call_type'] . "','" . $_POST['detail_call_help'] . "','" . $_POST['f_lat'] . "','" . $_POST['f_lng'] . "','" .$_POST['f_dateInput']. "','" .$_SERVER['REMOTE_ADDR']. "','1','1','1','".$_POST['f_key']."')";
            $rs = rsQuery($sql);
            echo $rs;
            $num = mysqli_fetch_array($rs);
            $lid = $num['id'];
            if ($rs) {
                $sql2 = "SELECT * FROM tb_call_for_help ORDER BY id DESC LIMIT 0,1";
                $rss = rsQuery($sql2);
                $num = mysqli_fetch_array($rss);
                $lid = $num['id'];
                echo "<script>alert('สามารถตรวจสอบสถานะการลงทะเบียนได้ที่  เลขที่:" . $lid . "');window.location.href='index.php?_mod=" . $_GET['_mod'] . "';</script>";

            } else {
                echo "<script>alert('Err2'); </script>";
            }


        }

    }


}

?>


<?php
$sql = "select * from tb_call_for_help order by id desc LIMIT 1";
$rs = rsQuery($sql);
$rs->num_rows;
$row = $rs->fetch_assoc();

?>
<?php // echo '<img src="/../images/qr.png"/>' ?>
<div class="container" style="text-align: left;">
    <div class="col-md-12">

        <form name="form_help" id="form_help" method="POST" action="" enctype="multipart/form-data">

            <input type="hidden" name="id" id="id" value="<?php $newid = $row['id'] + 1;
            echo $newid; ?>">

            <div class="form-group">
                <div class="col-sm-10">
                    <label class="control-label"><b>วันที่ลงทะเบียน:</b></label>
                    <?php echo DateThai(date("d-m-Y")); ?>
                    <input type="hidden" name="f_dateInput" id="f_dateInput" value="<?php echo date("c"); ?>"
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-10">

                </div>
            </div>
            <h4 style="text-decoration: underline">แบบลงทะเบียนขอรับความช่วยเหลือของประชาชน (กรณีร้องขอด้วยตนเอง)</h4>
            <h5>ข้อมูลผู้ร้องขอ</h5>
            <div class="form-group row">
                <div class="col-sm-2">
                    <label class="control-label"><b>คำนำหน้า:</b></label>
                    <select class="form-control" id="title_name" name="title_name">
                        <option value="">กรุณาเลือก</option>
                        <option value="นาย">นาย</option>
                        <option value="นาง">นาง</option>
                        <option value="นางสาว">นางสาว</option>
                    </select>
                </div>
                <div class="col-sm-5">
                    <label class="control-label"><b>ชื่อ:</b></label>
                    <input type="text" class="form-control" id="firstname" name="firstname" required>
                </div>
                <div class="col-sm-5">
                    <label class="control-label"><b>นามสกุล:</b></label>
                    <input type="text" class="form-control" id="lastname" name="lastname" required>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-2">
                    <label class="control-label"><b>อายุ:</b></label>
                    <input class="form-control" type="text" name="age" id="age">
                </div>
                <div class="col-5">
                    <label class="control-label"><b>เลขบัตรประชาชน:</b></label>
                    <input class="form-control" type="text" name="idcard" id="idcard"
                           placeholder="เลขบัตรประชาชน" onKeyPress="CheckNum()" onkeyup="autoTab2(this,1)">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-2">
                    <label class="control-label"><b>บ้านเลขที่:</b></label>
                    <input type="text" class="form-control" id="home_num" name="home_num">
                </div>
                <div class="col-sm-2">
                    <label class="control-label"><b>หมู่ที่:</b></label>
                    <input type="text" class="form-control" id="moo" name="moo">
                </div>
                <div class="col-sm-4">
                    <label class="control-label"><b>ถนน:</b></label>
                    <input type="text" class="form-control" id="road" name="road">
                </div>
                <div class="col-sm-4">
                    <label class="control-label"><b>ตำบล:</b></label>
                    <input type="text" class="form-control" id="tambon" name="tambon">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-4">
                    <label class="control-label"><b>อำเภอ:</b></label>
                    <input type="text" class="form-control" id="amphoe" name="amphoe">
                </div>
                <div class="col-sm-4">
                    <label class="control-label"><b>จังหวัด:</b></label>
                    <input type="text" class="form-control" id="province" name="province">
                </div>
                <div class="col-sm-4">
                    <label class="control-label"><b>โทรศัพท์:</b></label>
                    <input type="text" class="form-control" id="telephone" name="telephone">
                </div>
            </div>
            <h5>บุคคลที่สามารถติดต่อได้</h5>
            <div class="form-group row">
                <div class="col-sm-2">
                    <label class="control-label"><b>คำนำหน้า:</b></label>
                    <select class="form-control" id="title_name_co" name="title_name_co">
                        <option value="">กรุณาเลือก</option>
                        <option value="นาย">นาย</option>
                        <option value="นาง">นาง</option>
                        <option value="นางสาว">นางสาว</option>
                    </select>
                </div>
                <div class="col-sm-5">
                    <label class="control-label"><b>ชื่อ:</b></label>
                    <input type="text" class="form-control" id="firstname_co" name="firstname_co" required>
                </div>
                <div class="col-sm-5">
                    <label class="control-label"><b>นามสกุล:</b></label>
                    <input type="text" class="form-control" id="lastname_co" name="lastname_co" required>
                </div>
            </div>
            <h5>มีความประสงค์ขอให้ <?php echo $customer_name ?> ดำเนินการช่วยเหลือ ดังนี้</h5>
            <div class="form-group row">
                <div class="col-sm-7">
                    <label class="control-label"><b>1.ประเภทการช่วยเหลือ:</b></label>
                    <select id="call_help_type" name="call_help_type" class="form-control" required>
                        <option value="" selected>กรุณาเลือก</option>
                        <option value="1">1.1 ด้านสาธารณภัย</option>
                        <option value="2">1.2 ด้านการส่งเสริมและพัฒนาคุณภาพชีวิต</option>
                        <option value="3">1.3 ด้านการป้องกันและควบคุมโรคติดต่อ </option>
                        <option value="4">1.4 ด้านอื่น ๆ</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-12">
                    <textarea rows="5" class="form-control" id="detail_call_type" name="detail_call_type" required
                              placeholder="ระบุปัญหา/ความเดือดร้อนที่เกิดขึ้น"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-12">
                    <label class="control-label"><b>2.ข้าพเจ้าจึงขอความช่วยเหลือ</b></label>
                    <textarea rows="5" class="form-control" id="detail_call_help" name="detail_call_help" required
                              placeholder="ระบุความต้องการ/สิ่งที่ขอความช่วยเหลือ"></textarea>
                </div>
            </div>

            <br>
            <div class="form-group row">
                <div class="col-sm-10">
                    <label class="control-label"><b>แนบหลักฐาน:</b></label>
                    <input type="file" name="f_image[]" id="f_image[]" multiple required>
                    <input type="hidden" name="f_key" id="f_key" value="CFH_<?php echo $newid; ?>">
                </div>
            </div>

            <br>
            <input type="hidden" name="f_lat" id="f_lat">
            <input type="hidden" name="f_lng" id="f_lng">

            <label class="control-label"><b>กรุณาระบุตำแหน่งของท่าน:</b></label>
            <div id="map2"></div>

            <div class="form-group">
                <div class="col-sm-10">
                    <br>
                    <label><b>ค้นหาสถานที่:</b></label>
                    <input class="form-control" type="text" name="mapsearch" id="mapsearch">
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-10">
                    เงื่อนไข<br>
                    1. กรุณาป้อนข้อมูลให้ครบทุกช่อง มิฉะนั้นจะไม่สามารถบันทึกได้<br>
                    2. กรุณาใช้คำที่สุภาพและไม่เป็นการหมิ่นประมาท ใส่ร้ายผู้อื่น<br>
                    3. ทางทีมงานขอสงวนสิทธิ์ในการลบข้อความไม่เหมาะสมใดๆโดยมิต้องแจ้งล่วงหน้า<br>
                    **รายละเอียดและชื่อของท่านจะไม่ถูกเปิดเผย <br>
                    ข้าพเจ้าขอยืนยันข้อความทั้งหมดเป็นความจริง <br>
                </div>
            </div>

    </div>

    <center>
        <button type="submit" name="sub" class="btn btn-success">ลงทะเบียนขอรับความช่วยเหลือ</button>
    </center>
    </form>

</div>


<!--<script type = "text/javascript">-->
<!--    jQuery('#datetimepicker').datetimepicker();-->
<!---->
<!--    function checkID(id) {-->
<!--        var cid = id.replace(/-/g, '');-->
<!--        if(cid.length != 13) return false;-->
<!--        for(i=0, sum=0; i < 12; i++)-->
<!--            sum += parseFloat(cid.charAt(i))*(13-i); if((11-sum%11)%10!=parseFloat(cid.charAt(12)))-->
<!--            return false; return true;-->
<!--    }-->
<!---->
<!--    function validate() {-->
<!---->
<!--        if( document.form_help.f_name.value == "" ) {-->
<!--            alert( "กรุณากรอก ชื่อ-สกุล!" );-->
<!--            document.form_help.f_name.focus() ;-->
<!--            return false;-->
<!--        }-->
<!--        if( document.myForm.frm_tel.value == "" ) {-->
<!--            alert( "กรุณากรอก เบอร์โทรศัพท์ !" );-->
<!--            document.myForm.frm_tel.focus() ;-->
<!--            return false;-->
<!--        }-->
<!--        // if( document.myForm.frm_email.value == "" ) {-->
<!--        //    alert( "กรุณากรอก อีเมล!" );-->
<!--        //    document.myForm.frm_email.focus() ;-->
<!--        //    return false;-->
<!--        // }-->
<!--        // if( document.myForm.frm_province.value == "" ) {-->
<!--        //    alert( "กรุณาเลือก จังหวัด!" );-->
<!--        //    document.myForm.frm_province.focus() ;-->
<!--        //    return false;-->
<!--        // }-->
<!--        // if( document.myForm.frm_amphur.value == "" ) {-->
<!--        //    alert( "กรุณาเลือก อำเภอ!" );-->
<!--        //    document.myForm.frm_amphur.focus() ;-->
<!--        //    return false;-->
<!--        // }-->
<!--        // if( document.myForm.frm_district.value == "" ) {-->
<!--        //    alert( "กรุณาเลือก ตำบล!" );-->
<!--        //    document.myForm.frm_district.focus() ;-->
<!--        //    return false;-->
<!--        // }-->
<!--        // if( document.myForm.frm_moo.value == "" ) {-->
<!--        //    alert( "กรุณากรอก หมู่ที่!" );-->
<!--        //    document.myForm.frm_moo.focus() ;-->
<!--        //    return false;-->
<!--        // }-->
<!--        // if( document.myForm.frm_numhome.value == "" ) {-->
<!--        //    alert( "กรุณากรอก บ้านเลขที่!" );-->
<!--        //    document.myForm.frm_numhome.focus() ;-->
<!--        //    return false;-->
<!--        // }-->
<!--        if( document.form_help.f_idcard.value == "" ) {-->
<!--            alert( "กรุณากรอก เลขบัตรประชาชน!" );-->
<!--            document.form_help.f_idcard.focus() ;-->
<!--            return false;-->
<!--        }else {-->
<!--            if(!checkID(document.form_help.f_idcard.value)){-->
<!--                alert('รหัสประชาชนไม่ถูกต้อง');-->
<!--                document.form_help.f_idcard.focus() ;-->
<!--                return false;-->
<!--            }-->
<!--        }-->
<!--        // if( document.myForm.frm_date_str.value == "" ) {-->
<!--        //    alert( "กรุณาเลือก วันที่มารับ!" );-->
<!--        //    document.myForm.frm_date_str.focus() ;-->
<!--        //    return false;-->
<!--        // }-->
<!--        // if( document.myForm.frm_date_end.value == "" ) {-->
<!--        //    alert( "กรุณาเลือก วันที่นำส่งคืน!" );-->
<!--        //    document.myForm.frm_date_end.focus() ;-->
<!--        //    return false;-->
<!--        // }-->
<!--        // if( document.myForm.frm_for.value == "" ) {-->
<!--        //    alert( "กรุณากรอก จุดประสงค์ในการใช้งาน!" );-->
<!--        //    document.myForm.frm_for.focus() ;-->
<!--        //    return false;-->
<!--        // }-->
<!--        // if( document.myForm.frm_location.value == "" ) {-->
<!--        //    alert( "กรุณากรอก สถานที่ในการรับบริการ!" );-->
<!--        //    document.myForm.frm_location.focus() ;-->
<!--        //    return false;-->
<!--        // }-->
<!---->
<!---->
<!--        return( true );-->
<!--    }-->
<!---->
<!--</script>-->


<!-- รหัสบัตรประชาชน -->
    
<script type="text/javascript">
    function autoTab2(obj, typeCheck) {
        /* กำหนดรูปแบบข้อความโดยให้ _ แทนค่าอะไรก็ได้ แล้วตามด้วยเครื่องหมาย
                หรือสัญลักษณ์ที่ใช้แบ่ง เช่นกำหนดเป็น  รูปแบบเลขที่บัตรประชาชน
                4-2215-54125-6-12 ก็สามารถกำหนดเป็น  _-____-_____-_-__
                รูปแบบเบอร์โทรศัพท์ 08-4521-6521 กำหนดเป็น __-____-____
                หรือกำหนดเวลาเช่น 12:45:30 กำหนดเป็น __:__:__
                ตัวอย่างข้างล่างเป็นการกำหนดรูปแบบเลขบัตรประชาชน
                */
        if (typeCheck == 1) {
            var pattern = new String("_-____-_____-__-_"); // กำหนดรูปแบบในนี้
            var pattern_ex = new String("-"); // กำหนดสัญลักษณ์หรือเครื่องหมายที่ใช้แบ่งในนี้    
        } else {
            var pattern = new String("___-___-____"); // กำหนดรูปแบบในนี้
            var pattern_ex = new String("-"); // กำหนดสัญลักษณ์หรือเครื่องหมายที่ใช้แบ่งในนี้                
        }
        var returnText = new String("");
        var obj_l = obj.value.length;
        var obj_l2 = obj_l - 1;
        for (i = 0; i < pattern.length; i++) {
            if (obj_l2 == i && pattern.charAt(i + 1) == pattern_ex) {
                returnText += obj.value + pattern_ex;
                obj.value = returnText;
            }
        }
        if (obj_l >= pattern.length) {
            obj.value = obj.value.substr(0, pattern.length);
        }
    }

    function CheckNum() {
        if (event.keyCode < 48 || event.keyCode > 57) {
            event.returnValue = false;
        }
    }
</script>

<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDg49SZLUZdLu8KQ80fEAPJkbdBUqyN-vw&callback=initMap&libraries=places"></script>
<script>
    function initMap() {
        myLatLng = {lat: <?php echo $customer_lat ?>, lng: <?php echo $customer_lng ?>};
        var map = new google.maps.Map(document.getElementById('map2'), {
            center: myLatLng,
            zoom: 18
        });

        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            draggable: true
        });

        google.maps.event.addListener(marker, 'dragend', function () {
            var lat = marker.getPosition().lat();
            var lng = marker.getPosition().lng();

            document.getElementById("f_lat").value = lat.toFixed(5);
            document.getElementById("f_lng").value = lng.toFixed(5);

        });

        var searchBox = new google.maps.places.SearchBox(document.getElementById('mapsearch'));

        google.maps.event.addListener(searchBox, 'places_changed', function () {
            var places = searchBox.getPlaces();

            var bounds = new google.maps.LatLngBounds();
            var i, place;
            for (i = 0; place = places[i]; i++) {
                console.log(places);
                bounds.extend(place.geometry.location);
                marker.setPosition(place.geometry.location);
                var item_lat = place.geometry.location.lat();
                var item_lng = place.geometry.location.lng();
            }

            document.getElementById("f_lat").value = item_lat.toFixed(5);
            document.getElementById("f_lng").value = item_lng.toFixed(5);

            google.maps.event.addListener(marker, 'dragend', function () {
                var lat = marker.getPosition().lat();
                var lng = marker.getPosition().lng();

                document.getElementById("f_lat").value = lat.toFixed(5);
                document.getElementById("f_lng").value = lng.toFixed(5);
            });

            map.fitBounds(bounds);
            map.setZoom(15);

        });
    }

</script>