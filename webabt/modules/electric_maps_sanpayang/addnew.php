
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="js/popper.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>

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
include 'itgmod/connect.inc.php';

//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

$modname=FindRS("select * from tb_mod where modtype='$mod'",modname);
$modid=FindRS("select * from tb_mod where modtype='$mod'",modid);
$table=FindRS("select * from tb_mod where modtype='$mod'",tablename);
$folder =FindRS("select * from tb_mod where modtype='$mod'",foldername);


if(isset($_POST['sub'])) {

    $idwms = $_POST['id'];
    $name = $_POST['f_name'];
    $idcard = $_POST['f_idcard'];
    $telephone = $_POST['f_telephone'];
    $moo = $_POST['f_moo'];
    $poleid = $_POST['f_poleid'];
    $lat = $_POST['f_lat'];
    $lng = $_POST['f_lng'];
    $linkwms = $domainname.'/wms/main.php?_mod='.$mod.'%26_modid='.$modid;

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


            $sql = "INSERT INTO tb_electric_maps(id,name,id_card,telephone,email,address,road_person,moo_person,tambon_person,amphoe_person,province,moo,mooban,placefocus,lat,lng,datepost,ip,typewb,status,updatetime,image_key) Values('','".$_POST['f_name']. "','" .$_POST['f_idcard']. "','" .$_POST['f_telephone']. "','" .$_POST['f_email']. "','" .$_POST['f_address']. "','" .$_POST['f_road_person']. "','" .$_POST['f_moo_person']. "','" .$_POST['f_tambon_person']. "','" .$_POST['f_amphoe_person']. "','" .$_POST['f_province']. "','" .$_POST['f_moo']. "','" .$_POST['f_mooban']. "','" .$_POST['f_placefocus']. "','" .$_POST['f_lat']. "','" .$_POST['f_lng']. "','" .$_POST['f_dateInput']. "','" .$_SERVER['REMOTE_ADDR']. "','1','1','0','".$_POST['f_key']."')";

            $rs = rsQuery($sql);

            if ($rs) {
                echo "<script>alert('แจ้งซ่อมไฟฟ้าสาธารณะเรียบร้อยแล้วค่ะ');window.location.href='index.php?_mod=" . $_GET['_mod'] . "';</script>";//
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
                $newname = "ELE_".$_POST['id'].'_'.$i.'.'.$ext;
                $filetmp = $_FILES["f_image"]["tmp_name"][$i];
                $filetype = $_FILES["f_image"]["type"][$i];
                $filepath = "fileupload/electric_maps/".$newname;

                if (move_uploaded_file($filetmp,$filepath)) {

                    $sql = "INSERT INTO tb_files_image(id_image,image_path,image_key) VALUES ('','".$filepath."','".$_POST['f_key']."')";
                    $rs = rsQuery($sql);
                } else {
                    echo "<script>alert('Image not upload.'); </script>";
                }
            }

            $sql = "INSERT INTO tb_electric_maps(id,name,age,id_card,telephone,email,address,road_person,moo_person,tambon_person,amphoe_person,province,moo,mooban,placefocus,lat,lng,datepost,ip,typewb,status,updatetime,image_key) Values('','".$_POST['f_name']. "','".$_POST['f_age']. "','" .$_POST['f_idcard']. "','" .$_POST['f_telephone']. "','" .$_POST['f_email']. "','" .$_POST['f_address']. "','" .$_POST['f_road_person']. "','" .$_POST['f_moo_person']. "','" .$_POST['f_tambon_person']. "','" .$_POST['f_amphoe_person']. "','" .$_POST['f_province']. "','" .$_POST['f_moo']. "','" .$_POST['f_mooban']. "','" .$_POST['f_placefocus']. "','" .$_POST['f_lat']. "','" .$_POST['f_lng']. "','" .$_POST['f_dateInput']. "','" .$_SERVER['REMOTE_ADDR']. "','1','1','0','".$_POST['f_key']."')";
            $rs = rsQuery($sql);
            $num = mysqli_fetch_array($rs);
            $lid = $num['id'];
            if ($rs) {
                $sql2 = "SELECT * FROM tb_electric_maps ORDER BY id DESC LIMIT 0,1";
                $rss = rsQuery($sql2);
                $num = mysqli_fetch_array($rss);
                $lid = $num['id'];

                $url        = 'https://notify-api.line.me/api/notify';
                $token      = $ltoken;
                $headers    = [
                    'Content-Type: application/x-www-form-urlencoded',
                    'Authorization: Bearer ' . $token
                ];
                $fields     = "message=มีคนแจ้งซ่อมไฟฟ้าสาธารณะในชื่อ $name เลขบัตร $idcard เบอร์โทร $telephone 
                \n แผนที่นำทาง https://maps.google.com/?q=$lat,$lng \n ดูรายละเอียด $linkwms ";

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $result = curl_exec($ch);
                curl_close($ch);

                //var_dump($result);
                //$result = json_decode($result, TRUE);

                echo "<script>alert('สามารถตรวจสอบสถานะแจ้งซ่อมไฟฟ้าได้ที่ เลขที่:" .$lid."');window.location.href='index.php?_mod=" . $_GET['_mod'] . "';</script>";

            }else{
                echo "<script>alert('Err2'); </script>" ;
            }




        }

    }


}

?>


<?php
$sql = "select * from tb_electric_maps order by id desc LIMIT 1";
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
                    <label class="control-label"><b>วันที่แจ้งซ่อมไฟฟ้าสาธารณะ:</b></label>
                    <?php echo date(DateThaiFullM('d'));?>
                    <input type="hidden" name="f_dateInput" id="f_dateInput" value="<?php echo date("c");?>"
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-10">

                </div>
            </div>
            <div class="col-sm-10">
                <label class="control-label"><b>เรื่อง แจ้งซ่อมไฟฟ้าสาธารณะ</b></label>
            </div>
            <div class="col-sm-10">
                <label class="control-label"><b>เรียน นายกเทศมนตรี<?php echo $customer_name ?></b></label>
            </div>
            <h3 style="font-family: THK2DJuly8;">ข้อมูลผู้แจ้ง</h3>
            <div class="form-group row">
                <div class="col-sm-10">
                    <label class="control-label"><b>ชื่อ-นามสกุล ผู้แจ้ง:</b></label>
                    <input type="text" class="form-control" id="f_name" name="f_name" required>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-2">
                    <label class="control-label"><b>อายุ:</b></label>
                    <input type="number" min="0" max="99" step="1" class="form-control" id="f_age" name="f_age" onKeyPress="CheckNum()" required>
                </div>
                <div class="col-sm-8">
                    <label class="control-label"><b>เลขบัตรประจำตัวประชาชน:</b></label>
                    <input type="text" class="form-control" id="f_idcard" name="f_idcard" onKeyPress="CheckNum()" onkeyup="autoTab2(this,1)" required>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-3">
                    <label class="control-label"><b>ภูมิลำเนาอยู่ บ้านเลขที่:</b></label>
                    <input type="text" class="form-control" id="f_address" name="f_address" placeholder="เลขที่">
                </div>
                <div class="col-sm-5">
                    <label class="control-label"><b>ถนน:</b></label>
                    <input type="text" class="form-control" id="f_road_person" name="f_road_person" placeholder="ถนน">
                </div>
                <div class="col-sm-2">
                    <label class="control-label"><b>หมู่ที่:</b></label>
                    <input type="number" min="1" max="99" step="1" class="form-control" id="f_moo_person" name="f_moo_person" placeholder="หมู่">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-3">
                    <label class="control-label"><b>ตำบล:</b></label>
                    <input type="text" class="form-control" id="f_tambon_person" name="f_tambon_person" placeholder="ตำบล">
                </div>
                <div class="col-sm-3">
                    <label class="control-label"><b>อำเภอ:</b></label>
                    <input type="text" class="form-control" id="f_amphoe_person" name="f_amphoe_person" placeholder="อำเภอ">
                </div>
                <div class="col-sm-4">
                    <label class="control-label"><b>จังหวัด:</b></label>
                    <select class="form-control" name="f_province" id="f_province">
                        <option value="<?php echo $customer_province; ?>"><?php echo $customer_province; ?></option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                    <label class="control-label"><b>หมายเลขโทรศัพท์:</b></label>
                    <input type="text" class="form-control" id="f_telephone" name="f_telephone" onkeyup="autoTab2(this,2)" required>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-10">
                    <label class="control-label"><b>อีเมล/Line ID:</b></label>
                    <input type="text" class="form-control" id="f_email" name="f_email" required>
                </div>
            </div>
            <hr style="border: 1px solid black">

            <h3 style="font-family: THK2DJuly8;">มีความประสงค์</h3>
            <br>
            <h6 style="font-family: THK2DJuly8;">ข้าพเจ้ามีความประสงค์ให้ <?php echo $customer_name ?> ซ่อมแซมไฟฟ้าสาธารณะ</h6>
            <div class="form-group row">
                <div class="col-sm-3">
                    <label class="control-label"><b>หมู่ที่:</b></label>
                    <select class="form-control" name="f_moo" id="f_moo">
                        <option name="">กรุณาเลือกหมู่</option>
                        <?php
                        for($i=1; $i<=20; $i++)
                        {
                            echo "<option value=".$i.">หมู่ ".$i."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-sm-7">
                    <label class="control-label"><b>ชื่อหมู่บ้าน:</b></label>
                    <input type="text" class="form-control" id="f_mooban" name="f_mooban" placeholder="ชื่อหมู่บ้าน">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-10">
                    <label class="control-label"><b>หมายเลขเสา(ถ้ามี):</b></label>
                    <input type="text" class="form-control" id="f_poleid" name="f_poleid">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-10">
                    <label class="control-label"><b>สถานที่ จุดสังเกต หรือจุดอ้างอิง:</b></label>
                    <input type="text" class="form-control" id="f_placefocus" name="f_placefocus" required placeholder="เช่น บริเวณโรงเรียน...">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-10">
                    <label class="control-label"><b>เพิ่มรูปจุดที่ต้องการซ่อมไฟฟ้าสาธารณะ:</b></label>
                    <input type="file"  name="f_image[]" id="f_image[]" multiple>
                    <input type="hidden"  name="f_key" id="f_key" value="electric_<?php echo $newid; ?>">
                </div>
            </div>

            <input type="hidden"  name="f_lat" id="f_lat">
            <input type="hidden"  name="f_lng" id="f_lng">


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
    <div class="form-group row">
        <div class="col-sm-10">
            <label style="color: red">***กรุณากรอกข้อมูลให้ครบถ้วนที่สุด เพื่อความสะดวกต่อผู้แจ้งและหน่วยงาน</label><br>
        </div>
    </div>


    <center><button type="submit" name="sub" class="btn btn-success">ส่งคำร้อง</button></center>
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
            var pattern=new String("_-____-_____-__-_"); // กำหนดรูปแบบในนี้
            var pattern_ex=new String("-"); // กำหนดสัญลักษณ์หรือเครื่องหมายที่ใช้แบ่งในนี้    
        }else{
            var pattern=new String("___-___-____"); // กำหนดรูปแบบในนี้
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