
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="js/popper.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<link href="https://cdn.jsdelivr.net/bootstrap.datepicker-fork/1.3.0/css/datepicker3.css" rel="stylesheet"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/bootstrap.datepicker-fork/1.3.0/js/bootstrap-datepicker.js"></script>
<script src="https://cdn.jsdelivr.net/bootstrap.datepicker-fork/1.3.0/js/locales/bootstrap-datepicker.th.js"></script>

<script type="text/javascript">

    $(function(){
        // แทรกโค้ต jquery
        $("#dateInput").datepicker({ dateFormat: 'yy-mm-dd' });
    });


</script>

<style>
    /* Always set the map height explicitly to define the size of the div
     * element that contains the map. */
    body{
        font-family: THK2DJuly8;
        font-size: 14px;
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

if(isset($_POST['sub'])) {
    $check = getimagesize($_FILES["f_image"]["tmp_name"][0]);
    if ($check == false){

        if ($_POST['f_name'] == "") {
            "T1";
        }  else {


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


            $sql = "INSERT INTO tb_pet(id,subject,detail,result,lat,lng,postby,address,email,datepost,ip,typewb,status,updatetime)
						Values('','" .$_POST['f_subject']. "','" .$_POST['f_detail']. "','','" .$_POST['f_lat']. "','" .$_POST['f_lng']. "'
							,'" .$_POST['f_name']. "','" .$_POST['f_address']. "','" .$_POST['f_email']. "','" .$_POST['f_dateInput']. "'
							,'" .$_SERVER['REMOTE_ADDR']. "','1','1','0')";
            $rs = rsQuery($sql);
            if ($rs) {
                echo "<script>alert('การชำระภาษีของคุณเรียบร้อยแล้วค่ะ');window.location.href='index.php?_mod=" . $_GET['_mod'] . "';</script>";//
            }else{
                echo "<script>alert('Err'); </script>" ;
            }
        }

    }else{

        if ($_POST['f_name'] == "") {
            "T1";
        }  else {
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




            for($i=0; $i<count($_FILES['f_image']['name']); $i++){

                $filename = $_FILES["f_image"]["name"][$i];
                $ext = end(explode(".",$filename));
                $newname = "PET_".$_POST['id'].'_'.$i.'.'.$ext;
                $filetmp = $_FILES["f_image"]["tmp_name"][$i];
                $filetype = $_FILES["f_image"]["type"][$i];
                $filepath = "fileupload/pet/".$newname;

                if (move_uploaded_file($filetmp,$filepath)) {

                    $sql = "INSERT INTO tb_files_image(id_image,image_path,image_key) VALUES ('','".$filepath."','".$_POST['f_key']."')";
                    $rs = rsQuery($sql);
                } else {
                    echo "<script>alert('Image not upload.'); </script>";
                }
            }

            for($i=0; $i<count($_FILES['f_image_idcard']['name']); $i++){

                $filename = $_FILES["f_image_idcard"]["name"][$i];
                $ext = end(explode(".",$filename));
                $newname = "PET_idcard_".$_POST['id'].'_'.$i.'.'.$ext;
                $filetmp2 = $_FILES["f_image_idcard"]["tmp_name"][$i];
                $filetype = $_FILES["f_image_idcard"]["type"][$i];
                $filepath2 = "fileupload/pet/idcard/".$newname;

                if (move_uploaded_file($filetmp2,$filepath2)) {

                    $sql = "INSERT INTO tb_files_image_idcard(id_image,image_path_idcard,image_key_idcard) VALUES ('','".$filepath2."','".$_POST['f_key_idcard']."')";
                    $rs = rsQuery($sql);
                } else {
                    echo "<script>alert('Image not upload.'); </script>";
                }
            }

            $sql = "INSERT INTO tb_pet(id,firstname,lastname,id_card,telephone,numhome,moo,soi,petname,image_key,petsex,pettype,petspecies,petcolor,ageyear
 ,agemonth,vaccinehis,vaccinedate,petsterilize,petfrom,petmanner,petplace,
 lat,lng,datepost,ip,typewb,status,updatetime,image_key_idcard) 
 Values('','".$_POST['f_firstname']. "','" .$_POST['f_lastname']. "','" .$_POST['f_idcard']. "'
            ,'" .$_POST['f_telephone']. "','" .$_POST['f_numhome']. "','" .$_POST['f_moo']. "'
            ,'" .$_POST['f_soi']. "','" .$_POST['f_name']. "','" .$_POST['f_key']. "'
            ,'" .$_POST['f_petsex']. "','" .$_POST['f_pettype']. "','" .$_POST['f_species']. "'
            ,'" .$_POST['f_color']. "','" .$_POST['f_age_year']. "','" .$_POST['f_age_month']. "'
            ,'" .$_POST['f_vaccine_his']. "','" .$_POST['f_vaccine']. "','" .$_POST['f_sterilize']. "','" .$_POST['f_petfrom']. "','" .$_POST['f_petmanner']. "','" .$_POST['f_petplace']. "','" .$_POST['f_lat']. "'
            ,'" .$_POST['f_lng']. "','" .$_POST['f_dateInput']. "','" .$_SERVER['REMOTE_ADDR']. "'
            ,'1','1','0','".$_POST['f_key_idcard']."')";
            $rs = rsQuery($sql);
            $num = mysqli_fetch_array($rs);
            $lid = $num['id'];
            if ($rs) {
                $sql2 = "SELECT * FROM tb_pet ORDER BY id DESC LIMIT 0,1";
                $rss = rsQuery($sql2);
                $num = mysqli_fetch_array($rss);
                $lid = $num['id'];
                echo "<script>alert('สามารถตรวจสอบสถานะการลงทะเบียนได้ที่  เลขที่:" .$lid."');window.location.href='index.php?_mod=" . $_GET['_mod'] . "';</script>";//

            }else{
                echo "<script>alert('Err2'); </script>" ;
            }




        }

    }


}

?>


<?php
$sql = "select * from tb_pet order by id desc LIMIT 1";
$rs = rsQuery($sql);
$rs->num_rows;
$row = $rs->fetch_assoc();

?>
<?php // echo '<img src="/../images/qr.png"/>' ?>
<div class="container" style="text-align: left;">
    <div class="col-md-12">

        <form name="form_help" id="form_help" method="POST" action="" enctype="multipart/form-data">

            <input type="hidden"  name="id" id="id" value="<?php $newid = $row['id']+1;  echo $newid; ?>">

            <div class="form-group">
                <div class="col-sm-10">
                    <label class="control-label"><b>วันที่ลงทะเบียน:</b></label>
                    <?php echo date("Y-m-d");?>
                    <input type="hidden" name="f_dateInput" id="f_dateInput" value="<?php echo date("c");?>"
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-10">

                </div>
            </div>
            <h3 style="font-family: THK2DJuly8;">ข้อมูลเจ้าของสัตว์</h3>
            <div class="form-group row">
                <div class="col-sm-5">
                    <label class="control-label"><b>ชื่อ:</b></label>
                    <input type="text" class="form-control" id="f_firstname" name="f_firstname" required>
                </div>
                <div class="col-sm-5">
                    <label class="control-label"><b>นามสกุล:</b></label>
                    <input type="text" class="form-control" id="f_lastname" name="f_lastname" required>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-5">
                    <label class="control-label"><b>หมายเลขบัตรประจำตัวประชาชน:</b></label>
                    <input type="text" class="form-control" id="f_idcard" name="f_idcard" onKeyPress="CheckNum()" onkeyup="autoTab2(this,1)" required>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-5">
                    <label class="control-label"><b>เบอร์โทรศัพท์:</b></label>
                    <input type="text" class="form-control" id="f_telephone" name="f_telephone" onkeyup="autoTab2(this,2)" required>                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-3">
                    <label class="control-label"><b>บ้านเลขที่:</b></label>
                    <input type="text" class="form-control" id="f_numhome" name="f_numhome" required>
                </div>
                <div class="col-sm-3">
                    <label class="control-label"><b>หมู่ที่:</b></label>
                    <input type="text" class="form-control" id="f_moo" name="f_moo" required>
                </div>
                <div class="col-sm-4">
                    <label class="control-label"><b>ซอย:</b></label>
                    <input type="text" class="form-control" id="f_soi" name="f_soi" required>
                </div>
            </div>
            <h3 style="font-family: THK2DJuly8;">ข้อมูลสัตว์เลี้ยง</h3>
            <div class="form-group row">
                <div class="col-sm-10">
                    <label class="control-label"><b>ชื่อสัตว์เลี้ยง/อัตลักษณ์:</b></label>
                    <input type="text" class="form-control" id="f_name" name="f_name" required>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                    <label class="control-label"><b>เพิ่มรูปภาพสัตว์เลี้ยง:</b></label>
                    <input type="file"  name="f_image[]" id="f_image[]" multiple required>
                    <input type="hidden"  name="f_key" id="f_key" value="pet_<?php echo $newid; ?>">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                    <label class="control-label"><b>เพศ:</b></label>
                    <input type="radio" id="f_petsex" name="f_petsex" value="เพศผู้" required>เพศผู้
                    <input type="radio" id="f_petsex" name="f_petsex" value="เพศเมีย">เพศเมีย
                </div>
            </div>
<!--            <div class="form-group">-->
<!--                <div class="col-sm-10">-->
<!--                    <label class="control-label"><b>ที่อยู่:</b></label>-->
<!--                    <input type="text" class="form-control" id="f_address" name="f_address">-->
<!--                </div>-->
<!--            </div>-->

            <div class="form-group row">
                <div class="col-sm-10">
                    <label class="control-label"><b>ประเภทสัตว์เลี้ยง:</b></label>
                    <select id="f_pettype" name="f_pettype" class="form-control" required>
                        <option value="" selected>กรุณาเลือก</option>
                        <option <?php if($selected2 == '1'){echo("selected");}?> value="1">หมา</option>
                        <option <?php if($selected2 == '2'){echo("selected");}?> value="2">แมว</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                    <label class="control-label"><b>สายพันธุ์:</b></label>
                    <input type="text" class="form-control" id="f_species" name="f_species" placeholder="เช่น เปอร์เซีย">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                    <label class="control-label"><b>สี/ลักษณะพิเศษ:</b></label>
                    <input type="text" class="form-control" id="f_color" name="f_color" placeholder="เช่น สีส้มขาว มีปลอกคอสีแดง">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-3">
                    <label class="control-label"><b>อายุสัตว์เลี้ยง (ปี):</b></label>
                    <input type="number" min="0" step="1" class="form-control" id="f_age_year" name="f_age_year" required>
                </div>
                <div class="col-sm-3">
                    <label class="control-label"><b>อายุสัตว์เลี้ยง (เดือน):</b></label>
                    <input type="number" min="0" max="11" step="1"  class="form-control" id="f_age_month" name="f_age_month" required>
                </div>
            </div>
            <hr>
            <h3 style="font-family: THK2DJuly8;">ข้อมูลวัคซีนและการทำหมัน</h3>
            <div class="form-group row">
                <div class="col-sm-10">
                    <label class="control-label"><b>ประวัติการฉีดวัคซีนพิษสุนัขบ้า:</b></label>
                    <input type="radio" id="f_vaccine_his" name="f_vaccine_his" value="ฉีดแล้ว">ฉีดแล้ว
                    <input type="radio" id="f_vaccine_his" name="f_vaccine_his" value="ยังไม่ได้ฉีด">ยังไม่ได้ฉีด
                </div>
            </div>
            <div class="form-group Box" style="display: none">
                <div class="col-sm-5">
                    <label class="control-label"><b>วันที่ฉีดวัคซีนพิษสุนัขบ้าครั้งล่าสุดเมื่อ:</b></label>
                    <input class="form-control datepicker" id="f_vaccine" name="f_vaccine">
                </div>
            </div>
            <script type="text/javascript">
                $(document).ready(function(){
                    $.fn.datepicker.defaults.language = 'th';
                    $('.datepicker').datepicker();
                });
            </script>
            <script>
                $('input[type="radio"]').click(function(){
                    if($(this).attr("value")=="ยังไม่ได้ฉีด"){
                        $(".Box").hide('fast');
                    }
                    if($(this).attr("value")=="ฉีดแล้ว"){
                        $(".Box").show('fast');
                    }
                });
                $('input[type="radio"]').trigger('click');
            </script>
            </body>
            <div class="form-group row">
                <div class="col-sm-10">
                    <label class="control-label"><b>การทำหมัน:</b></label>
                    <input type="radio" id="f_sterilize" name="f_sterilize" value="ทำหมันแล้ว" required>ทำหมันแล้ว
                    <input type="radio" id="f_sterilize" name="f_sterilize" value="ยังไม่ได้ทำหมัน">ยังไม่ได้ทำหมัน
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                    <label class="control-label"><b>ที่มาของสัตว์เลี้ยง:</b></label>
                    <input type="radio" id="f_petfrom" name="f_petfrom" value="ซื้อ" required>ซื้อ
                    <input type="radio" id="f_petfrom" name="f_petfrom" value="จรจัด">หมา/แมว จรจัด
                </div>
            </div>
            <hr>
            <h3 style="font-family: THK2DJuly8;">การเลี้ยง</h3>
            <div class="form-group row">
                <div class="col-sm-10">
                    <label class="control-label"><b>ลักษณะการเลี้ยง:</b></label>
                    <textarea type="text" class="form-control" id="f_petmanner" name="f_petmanner"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                    <label class="control-label"><b>สถานที่เลี้ยง:</b></label>
                    <textarea type="text" class="form-control" id="f_petplace" name="f_petplace"></textarea>
                </div>
            </div>
<!--            <div class="form-group">-->
<!--                <div class="col-sm-10">-->
<!--                    <label class="control-label"><b>เลขบัตรประจำตัวประชาชน:</b></label>-->
<!--                    <input type="text" class="form-control" id="f_idcard" name="f_idcard" onKeyPress="CheckNum()" onkeyup="autoTab2(this,1)" required>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="form-group">-->
<!--                <div class="col-sm-10">-->
<!--                    <label class="control-label"><b>เบอร์ติดต่อ:</b></label>-->
<!--                    <input type="text" class="form-control" id="f_telephone" name="f_telephone" onkeyup="autoTab2(this,2)" required>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="form-group">-->
<!--                <div class="col-sm-10">-->
<!--                    <label class="control-label"><b>อีเมล/Line ID:</b></label>-->
<!--                    <input type="text" class="form-control" id="f_email" name="f_email" required>-->
<!--                </div>-->
<!--            </div>-->


<!--            <h5>ขอยื่นคำร้อง/แจ้งปัญหา</h5>-->
<!---->
<!--            <div class="form-group">-->
<!--                <div class="col-sm-10">-->
<!--                    <label class="control-label"><b>เรื่อง:</b></label>-->
<!--                    <input type="text" class="form-control" id="f_subject" name="f_subject" >-->
<!--                </div>-->
<!--            </div>-->
<!---->
<!--            <div class="form-group">-->
<!--                <div class="col-sm-10">-->
<!--                    <label class="control-label"><b>รายละเอียด:</b></label>-->
<!--                    <textarea type="text" class="form-control" id="f_detail" name="f_detail" ></textarea>-->
<!--                </div>-->
<!--            </div>-->
<!---->
<!--                        <div class="form-group">-->
<!--                            <div class="col-sm-10">-->
<!--                                <label class="control-label"><b>ที่อยู่:</b></label>-->
<!--                                <input type="text" class="form-control" id="f_address" name="f_address" placeholder="เลขที่ ถนน ซอย หมู่ ตำบล อำเภอ จังหวัด">-->
<!--                            </div>-->
<!--                        </div>-->

            <input type="hidden"  name="f_lat" id="f_lat">
            <input type="hidden"  name="f_lng" id="f_lng">

<!--            <div class="form-group">-->
<!--                <div class="col-sm-10">-->
<!--                    เงื่อนไข<br>-->
<!--                    1. กรุณาป้อนข้อมูลให้ครบทุกช่อง มิฉะนั้นจะไม่สามารถบันทึกได้<br>-->
<!--                    2. กรุณาใช้คำที่สุภาพและไม่เป็นการหมิ่นประมาท ใส่ร้ายผู้อื่น<br>-->
<!--                    3. ทางทีมงานขอสงวนสิทธิ์ในการลบข้อความไม่เหมาะสมใดๆโดยมิต้องแจ้งล่วงหน้า<br>-->
<!--                    **รายละเอียดและชื่อของท่านจะไม่ถูกเปิดเผย <br>-->
<!--                    ข้าพเจ้าขอยืนยันข้อความทั้งหมดเป็นความจริง <br>-->
<!--                </div>-->
<!--            </div>-->


            <label class="control-label"><b>กรุณาระบุตำแหน่งที่อยู่บนแผนที่:</b></label>
            <div id="map2"></div>

            <div class="form-group">
                <div class="col-sm-10">
                    <br>
                    <label><b>ค้นหาสถานที่:</b></label>
                    <input class="form-control" type="text" name="mapsearch" id="mapsearch">
                </div>
            </div>

    </div>

    <hr style="height: 1px;color: black">
    <label class="control-label"><b>หลักฐานประกอบ:</b></label>
    <div class="form-group">
        <div class="col-sm-10">
            <label class="control-label"><b>สำเนาบัตรประจำตัวประชาชน:</b></label>
            <input type="file"  name="f_image_idcard[]" id="f_image_idcard[]" multiple required>
            <input type="hidden"  name="f_key_idcard" id="f_key_idcard" value="Evidence_<?php echo $newid; ?>">
        </div>
        <div class="col-sm-12">
            <label class="control-label"><b>ใบรับรองสัตว์ เช่น ใบเพ็ดดีกรี ใบรับรองสายพันธุ์ (Certificate) (ถ้ามี):</b></label>
            <input type="file"  name="f_image_idcard[]" id="f_image_idcard[]" multiple>
            <input type="hidden"  name="f_key_idcard" id="f_key_idcard" value="Evidence_<?php echo $newid; ?>">
        </div>
    </div>
    <hr style="height: 1px;color: black">
    <label class="control-label"><b>ประวัติการรับวัคซีนของสัตว์เลี้ยง:</b></label>
    <div class="form-group">
        <div class="col-sm-10">
            <label class="control-label"><b>หนังสือรับรองการฉีดวัคซีนโรคพิษสุนัขบ้ามาไม่เกิน1ปี ระบุหมายเลขวัคซีน และลงชื่อสัตวแพทย์ พร้อมเลขใบอนุญาตประกอบวิชาชีพการสัตวแพทย์:</b></label>
            <input type="file"  name="f_image_idcard[]" id="f_image_idcard[]" multiple>
            <input type="hidden"  name="f_key_idcard" id="f_key_idcard" value="Evidence_<?php echo $newid; ?>">
        </div>
    <br>
    </div>
    <center><button type="submit" name="sub" class="btn btn-success">ลงทะเบียน</button></center>
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
    function autoTab2(obj,typeCheck){
        /* กำหนดรูปแบบข้อความโดยให้ _ แทนค่าอะไรก็ได้ แล้วตามด้วยเครื่องหมาย
                หรือสัญลักษณ์ที่ใช้แบ่ง เช่นกำหนดเป็น  รูปแบบเลขที่บัตรประชาชน
                4-2215-54125-6-12 ก็สามารถกำหนดเป็น  _-____-_____-_-__
                รูปแบบเบอร์โทรศัพท์ 08-4521-6521 กำหนดเป็น __-____-____
                หรือกำหนดเวลาเช่น 12:45:30 กำหนดเป็น __:__:__
                ตัวอย่างข้างล่างเป็นการกำหนดรูปแบบเลขบัตรประชาชน
                */
        if(typeCheck==1){
            var pattern=new String("_____________"); // กำหนดรูปแบบในนี้
            var pattern_ex=new String("-"); // กำหนดสัญลักษณ์หรือเครื่องหมายที่ใช้แบ่งในนี้    
        }else{
            var pattern=new String("__________"); // กำหนดรูปแบบในนี้
            var pattern_ex=new String("-"); // กำหนดสัญลักษณ์หรือเครื่องหมายที่ใช้แบ่งในนี้                
        }
        var returnText=new String("");
        var obj_l=obj.value.length;
        var obj_l2=obj_l-1;
        for(i=0;i<pattern.length;i++){
            if(obj_l2==i && pattern.charAt(i+1)==pattern_ex){
                returnText+=obj.value+pattern_ex;
                obj.value=returnText;
            }
        }
        if(obj_l>=pattern.length){
            obj.value=obj.value.substr(0,pattern.length);
        }
    }

    function CheckNum(){
        if (event.keyCode < 48 || event.keyCode > 57){
            event.returnValue = false;
        }
    }
</script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDg49SZLUZdLu8KQ80fEAPJkbdBUqyN-vw&callback=initMap&libraries=places" ></script>
<script>
    function initMap(){
        myLatLng = {lat: <?php echo $customer_lat ?>, lng: <?php echo $customer_lng ?>};
        var map = new google.maps.Map(document.getElementById('map2'), {
            center: myLatLng,
            zoom: 18
        });

        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            draggable:true
        });

        google.maps.event.addListener(marker,'dragend',function () {
            var lat = marker.getPosition().lat();
            var lng = marker.getPosition().lng();

            document.getElementById("f_lat").value = lat.toFixed(5);
            document.getElementById("f_lng").value = lng.toFixed(5);

        });

        var searchBox = new google.maps.places.SearchBox(document.getElementById('mapsearch'));

        google.maps.event.addListener(searchBox, 'places_changed',function () {
            var places = searchBox.getPlaces();

            var bounds = new google.maps.LatLngBounds();
            var i, place;
            for(i=0;place=places[i];i++){
                console.log(places);
                bounds.extend(place.geometry.location);
                marker.setPosition(place.geometry.location);
                var item_lat = place.geometry.location.lat();
                var item_lng = place.geometry.location.lng();
            }

            document.getElementById("f_lat").value = item_lat.toFixed(5);
            document.getElementById("f_lng").value = item_lng.toFixed(5);

            google.maps.event.addListener(marker,'dragend',function () {
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