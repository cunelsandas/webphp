
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

if(isset($_POST['sub'])) {
    $check = getimagesize($_FILES["f_image"]["tmp_name"][0]);
    if ($check == false){

        if ($_POST['f_subject'] == "") {
            "T1";
        }  

    }else{

        if ($_POST['f_subject'] == "") {
            "T1";
        }  else {
            
                                #EMAIL--------------------------------------------------

                                #EMAIL---------------------------------------------------------------------------------------------------------------------------------------

                                $fm = "admin@itglobal.co.th"; // *** ต้องใช้อีเมล์ @yourdomain.com เท่านั้น  ***
                                $to = "info@tazala.go.th";//   **ต้องมี mail ในระบบไม่งั้น error
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
            
            $to = "info@".$domainname;
            $subject = $_POST['f_subject'];
            $txt = $_POST['f_detail'];

            $headers = "MIME-Version: 1.0\r\n" ;
            $headers .= "Content-type: text/html; charset=UTF-8\r\n" ;
            //$headers .= "From: " . $_POST['femail'] . "\r\n" ."CC: migarl38@hotmail.com";
            $headers .= "From: ".$_POST['f_email']." <".$_POST['f_email'].">\r\n" ;
            $headers .= "Reply-to: ".$_POST['f_email']." <".$_POST['f_email'].">\r\n" ;
            $headers .= "X-Priority: 3\r\n" ;
            $headers .= "X-Mailer: PHP mailer\r\n" ;

            mail($to,$subject,$txt,$headers);
            echo "<script>alert('Send Mail OK3')</script>";
            echo "<script>console.log('".$mail->ErrorInfo."')</script>";
            #EMAIL--------------------------------------------------




            for($i=0; $i<count($_FILES['f_image']['name']); $i++){

                $filename = $_FILES["f_image"]["name"][$i];
                $ext = end(explode(".",$filename));
                $newname = "Help_Im_".$_POST['id'].'_'.$i.'.'.$ext;
                $filetmp = $_FILES["f_image"]["tmp_name"][$i];
                $filetype = $_FILES["f_image"]["type"][$i];
                $filepath = "fileupload/im_help/".$newname;

                if (move_uploaded_file($filetmp,$filepath)) {

                    $sql = "INSERT INTO tb_files_image(id_image,image_path,image_key) VALUES ('','".$filepath."','".$_POST['f_key']."')";
                    $rs = rsQuery($sql);
                } else {
                    echo "<script>alert('Image not upload.'); </script>";
                }
            }

            $sql = "INSERT INTO tb_help_maps(id,subject,detail,result,lat,lng,postby,address,email,datepost,ip,typewb,status,updatetime,image_key) Values('','" .$_POST['f_subject']. "','" .$_POST['f_detail']. "','','" .$_POST['f_lat']. "','" .$_POST['f_lng']. "','" .$_POST['f_name']. "','" .$_POST['f_address']. "','" .$_POST['f_email']. "','" .$_POST['f_dateInput']. "','" .$_SERVER['REMOTE_ADDR']. "','1','1','0','".$_POST['f_key']."')";
            $rs = rsQuery($sql);
            if ($rs) {
                echo "<script>alert('เรื่องของคุณได้ถูกส่งไปยังผุ้ที่เกี่ยวข้องแล้วค่ะ');window.location.href='index.php?_mod=" . $_GET['_mod'] . "';</script>";

            }else{
                echo "<script>alert('Err2'); </script>" ;
            }




        }

    }


}

?>


<?php
$sql = "select * from tb_help_maps order by id desc LIMIT 1";
$rs = rsQuery($sql);
$rs->num_rows;
$row = $rs->fetch_assoc();

?>

<div class="container" style="text-align: left;">
    <div class="col-md-12">

        <form name="form_help" id="form_help" method="POST" action="" enctype="multipart/form-data">

            <input type="hidden"  name="id" id="id" value="<?php $newid = $row['id']+1;  echo $newid; ?>">

            <div class="form-group">
                <div class="col-sm-10">
                    <label class="control-label"><b>วันที่:</b></label>
                    <?php echo date("Y-m-d");?>
                    <input type="hidden" name="f_dateInput" id="f_dateInput" value="<?php echo date("c");?>"
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-10">
                    <label class="control-label"><b>เรียน:</b></label>
                    <?php echo $nayok_position;?>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-10">
                    <label class="control-label"><b>ข้าพเจ้าชื่อ:</b></label>
                    <input type="text" class="form-control" id="f_name" name="f_name">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-10">
                    <label class="control-label"><b>ที่อยู่:</b></label>
                    <input type="text" class="form-control" id="f_address" name="f_address">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-10">
                    <label class="control-label"><b>อีเมล์/เบอร์ติดต่อ:</b></label>
                    <input type="text" class="form-control" id="f_email" name="f_email">
                </div>
            </div>

            <h5>ขอยื่นคำร้อง/แจ้งปัญหา</h5>

            <div class="form-group">
                <div class="col-sm-10">
                    <label class="control-label"><b>เรื่อง:</b></label>
                    <input type="text" class="form-control" id="f_subject" name="f_subject" required>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-10">
                    <label class="control-label"><b>รายละเอียด:</b></label>
                    <textarea type="text" class="form-control" id="f_detail" name="f_detail" required></textarea>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-10">
                    <label class="control-label"><b>รูปภาพ:</b></label>
                    <input type="file"  name="f_image[]" id="f_image[]" multiple>
                    <input type="hidden"  name="f_key" id="f_key" value="300<?php echo $newid; ?>">
                </div>
            </div>

            <input type="hidden"  name="f_lat" id="f_lat">
            <input type="hidden"  name="f_lng" id="f_lng">

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


            <div id="map2"></div>

            <div class="form-group">
                <div class="col-sm-10">
                    <br>
                    <label><b>ค้นหาสถานที่:</b></label>
                    <input class="form-control" type="text" name="mapsearch" id="mapsearch">
                </div>
            </div>

    </div>

    <center><button type="submit" name="sub" class="btn btn-default">บันทึก</button></center>
    </form>

</div>


<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDg49SZLUZdLu8KQ80fEAPJkbdBUqyN-vw&callback=initMap&libraries=places" ></script>
<script>
    function initMap(){
        myLatLng = {lat: 18.76991, lng: 98.97723};
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
