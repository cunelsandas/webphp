<link rel="stylesheet" type="text/css" href="css/jquery-ui-1.7.2.custom.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.css">

<!-- Include Editor style. -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.8.5/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.8.5/css/froala_style.min.css" rel="stylesheet" type="text/css" />



<style>
    * {
        box-sizing: border-box;
    }
    body{
        font-family: THSarabunNew;
    }

    /* The grid: Four equal columns that floats next to each other */
    .column {
        float: left;
        width: 20%;
        padding: 10px;
    }



    /* Style the images inside the grid */
    .column img {
        opacity: 0.8;
        cursor: pointer;
    }

    .column img:hover {
        opacity: 1;
    }

    /* Clear floats after the columns */
    .row:after {
        content: "";
        display: table;
        clear: both;
    }


    /* Expanding image text */
    #imgtext {
        position: absolute;
        bottom: 15px;
        left: 15px;
        color: white;
        font-size: 20px;
    }

    /* Closable button inside the expanded image */
    .closebtn {
        position: absolute;
        top: 10px;
        right: 15px;
        color: rgb(255, 249, 255);
        font-size: 45px;
        cursor: pointer;
    }
    #map-canvas {
        width: 800px;
        height: 400px;
</style>

<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.7.2.custom.min.js"></script>
<script type="text/javascript">
    $(function(){
	// แทรกโค้ต jquery
	$("#dateInput").datepicker({ dateFormat: 'yy-mm-dd' });
});
</script>

<?php
$timenow=date("Y-m-d");
/*
if(isset($_POST['btmail'])){ //ส่งเมล์
$MailTo = $_REQUEST['email'] ;
$MailFrom = "info@".$domainname;//$_POST['MailFrom'] ;
$MailSubject = "แจ้งผลการดำเนินการแก้ไขเรื่องร้องเรียน";//$_POST['MailSubject'] ;
$MailMessage = $_REQUEST['spaw1'] ;

$Headers = "MIME-Version: 1.0\r\n" ;
$Headers .= "Content-type: text/html; charset=UTF-8\r\n" ;
                          // ส่งข้อความเป็นภาษาไทย ใช้ "windows-874"
$Headers .= "From: ".$MailFrom." <".$MailFrom.">\r\n" ;
$Headers .= "Reply-to: ".$MailFrom." <".$MailFrom.">\r\n" ;
$Headers .= "X-Priority: 3\r\n" ;
$Headers .= "X-Mailer: PHP mailer\r\n" ;

        if(mail($MailTo, $MailSubject , $MailMessage, $Headers, $MailFrom))
        {
        $msg= "Send Mail True" ;  //ส่งเรียบร้อย
        }else{
        $msg= "Send Mail False" ; //ไม่สามารถส่งเมล์ได้
        }

	echo"<script>alert('$msg');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
}*/


if(isset($_POST['btadd'])){
	$strupdate="Update tb_electric_maps SET typewb='".$_POST['f_status']."',updatetime='".date("c")."' Where id='".$_GET['no']."'";
	$rsupdate=rsQuery($strupdate);
	if($rsupdate){
	echo"<script>alert('บันทึกข้อมูลเรียบร้อย');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
	}else{
	    echo "<script>alert('Err')</script>";
    }
}


$sql="Select * From tb_electric_maps Where id='".$_GET['no']."'";
$rs=rsQuery($sql);
$row=mysqli_fetch_array($rs);
$selected = $row['typewb'];

$sql1="Select * From tb_files_image Where image_key='".$row['image_key']."'";
$rs1=rsQuery($sql1);

$sql2="Select * From tb_files_image_idcard Where image_key_idcard='".$row['image_key_idcard']."'";
$rs2=rsQuery($sql2);

?>
<body>
<div class="container">
    <div class="col-md-10" style="text-align:center;">
        <h2>ข้อมูลแจ้งซ่อมไฟฟ้าสาธารณะ</h2>
    </div>
    <div class="row" style="border: solid 1px black;padding: 5px">
    <div class="w3-panel w3-border col-md-10">
        <div class="panel-body">
            <p>เลขที่แจ้งซ่อม : <?php echo $row['id'];?></p>
            <p>วันที่ลงทะเบียน : <?php echo DateTimeThai($row['datepost']);?>&nbsp;&nbsp; IP Address : <?php echo $row['ip'];?></p>
<!--            <p>เรื่อง : --><?php //echo $row['subject'];?><!--</p>-->
            <p>ชื่อผู้แจ้ง : <b style="font-size: 20px"> <?php echo $row['name'];?></b></p>
            <p>อายุ : <?php echo $row['age'];?> ปี</p>
            <p>เลขบัตรประจำตัวประชาชน : <?php echo $row['id_card'];?></p>
            <p>ที่อยู่ : <?php echo $row['address'];?> ม.<?php echo $row['moo_person'];?> ถ.<?php echo $row['road_person'];?> ต.<?php echo $row['moo_person'];?>  จ.<?php echo $row['province'];?></p>
            <p>เบอร์โทรศัพท์ : <?php echo $row['telephone'];?></p>
            <p>อีเมล์/Line ID : <?php echo $row['email'];?></p>
            <hr style="border:1px solid #c3c3c3">

            <h4 style="text-decoration: underline">ข้อมูลแจ้งซ่อม</h4>

            <p>หมู่ที่ : <?php echo $row['moo'];?> หมู่บ้าน : <?php echo $row['mooban'];?></p>
            <p>สถานที่/จุดสังเกต/จุดอ้างอิง : <?php echo $row['placefocus'];?></p>
            <p>ละติจูด/ลองจิจูด + นำทาง: <?php echo $row['lat'];?>,<?php echo $row['lng'];?></p>
            <div class="col-md-4" style="text-align:center">
                <a class="btn btn-info btn-lg active"" href=https://maps.google.com/?saddr=Current+Location&daddr=<?php echo $row['lat']?>,<?php echo $row['lng']?> target=_blank>คลิกเพื่อนำทางใน Google Maps</a>
            </div>
<!--            <p>รายละเอียด :</p>-->
<!--            <blockquote>-->
<!--                &nbsp;--><?php //echo nl2br($row['detail']);?>
<!--            </blockquote>-->
<!--            <p>ประเภทภาษี : --><?php //if($row['tax_type']==0) {
//                    echo "<td>" . '<b style="font-size:14px">ไม่เลือกประเภท</b>' . "</td>";
//                }
//                elseif ($row['tax_type']==1){
//                    echo "<td>" . '<b style="font-size:14px">ภาษีที่ดินและสิ่งปลูกสร้าง</b>' . "</td>";
//                }
//                elseif ($row['tax_type']==2){
//                    echo "<td>" . '<b style="font-size:14px">ภาษีป้าย</b>' . "</td>";
//                } ?><!--</p>-->
<!--            <select id="f_taxtype" name="f_taxtype" class="form-control" readonly="readonly" ">-->
<!--                <option --><?php //if($selected == '1'){echo("selected");}?><!-- value="1">ภาษีที่ดินและสิ่งปลูกสร้าง</option>-->
<!--                <option --><?php //if($selected == '2'){echo("selected");}?><!-- value="2">ภาษีป้าย</option>-->
<!--            </select>-->
        </div>
    </div>
    </div>



<br>
        <div class="col-md-12" style="text-align:center">
            <h2>แผนที่</h2>
        </div>
        <div class="content">
            <div id="map-canvas" style="width: 100%" height="400px"></div>
        </div>
    <br>


    <?php
    if ($rs1->num_rows>0){

        ?>
        <div class="col-md-10" style="text-align:center;margin-top: 5%">
            <h2>รูปภาพบริเวณแจ้งซ่อมไฟฟ้าสาธารณะ</h2>
            <p>(คลิกที่รูปภาพ เพื่อแสดง)</p>
        </div>

<!--        <p>เวลาการโอนเงิน : --><?php //echo  DateTimeThai($row['pay_datetime']);?><!--</p>-->


        <!-- The four columns -->
        <div class="row col-md-10">
            <?php
            while ($row1 = $rs1->fetch_assoc()){
                echo '<div class="column">';
                //echo '<a href="../'.$row1['image_path'].'" target="_blank">';
                echo '<img onclick="myFunction(this);" style="border: 1px solid #ddd; border-radius: 4px;
        padding: 5px; width: 100px; height:auto;" src="../'.$row1['image_path'].'"></a>';
                echo '</div>';
            }
            ?>
        </div>
    <?php }
    ?>


    <?php
    if ($rs2->num_rows>0){

        ?>
        <div class="col-md-10" style="text-align:center;margin-top: 5%">
            <h2>หลักฐานประกอบ (สำเนาบัตรประชาชน,ใบรับรองสายพันธุ์,การฉีดวัคซีน)</h2>
            <p>(คลิกที่รูปภาพ เพื่อแสดง)</p>
        </div>

        <!--        <p>เวลาการโอนเงิน : --><?php //echo  DateTimeThai($row['pay_datetime']);?><!--</p>-->


        <!-- The four columns -->
        <div class="row col-md-10">
            <?php
            while ($row2 = $rs2->fetch_assoc()){
                echo '<div class="column">';
                //echo '<a href="../'.$row1['image_path'].'" target="_blank">';
                echo '<img onclick="myFunction(this);" style="border: 1px solid #ddd; border-radius: 4px;
        padding: 5px; width: 100px; height:auto;" src="../'.$row2['image_path_idcard'].'"></a>';
                echo '</div>';
            }
            ?>
        </div>
    <?php }
    ?>

    <br>
    <br>
    <?php
    $date1=date_create($row['date_vaccine']);
    $date2=date_create(date());
    $diff=date_diff($date1,$date2);
    ?>
<!--    <p><b style="font-size: 16px">วันที่ฉีดวัคซีนพิษสุนัขบ้าครั้งล่าสุด : <font color="red">--><?php //echo DateThai($row['date_vaccine']);?><!--</font> --><?php //echo '('.$diff->format("%R%a วันที่แล้ว").')'; ?><!--</b></p>-->



    <div class="row col-md-10">
        <span onclick="this.parentElement.style.display='none'" class="closebtn">&times;</span>
        <img id="expandedImg" style="width:100%">
        <div id="imgtext"></div>
    </div>



    <form name="form_help" id="form_help" method="POST" action="" enctype="multipart/form-data">

        <div class="row">
        <div class="col-md-4">
            <br>
<!--            <label style="color: red">*กรุณาตรวจสอบชื่อ เวลา และวันที่จากสลิปให้มีข้อมูลที่ตรงกัน*</label>-->
            <label><b>สถานะงาน</b></label>
            <select id="f_status" name="f_status" class="form-control">
                <option selected>กรุณาเลือก</option>
                <option <?php if($selected == '1'){echo("selected");}?> value="1">อยู่ระหว่างการตรวจสอบ</option>
                <option <?php if($selected == '2'){echo("selected");}?> value="2">กำลังดำเนินการ</option>
                <option <?php if($selected == '3'){echo("selected");}?> value="3">ตรวจสอบแล้วไม่มีมูล</option>
                <option <?php if($selected == '4'){echo("selected");}?> value="4">ดำเนินการเสร็จแล้ว</option>
                <option <?php if($selected == '5'){echo("selected");}?> value="5">ดำเนินการและส่งเมล์ตอบกลับแล้ว</option>
            </select>
            <br>
        </div>

        <div class="form-group col-md-10">
        </div>
        </div>


<button class="btn btn-info" type="submit" name="btadd">บันทึก</button>&nbsp;&nbsp;
        <i class="fa fa-print" aria-hidden="true"></i><a class="btn btn-default"  href="report/electric/html_form01.php?id=<?php echo $row['id'];?>" target="_Blank">พิมพ์</a>&nbsp;&nbsp;
       <a class="btn btn-success"  href="//<?php echo  $domainname ?>/roundcube/"<!--" target="_Blank">ส่งอีเมล</a>&nbsp;&nbsp;



    </form>
</div>




<!--<input class="bt" type="submit" name="btmail" value="ส่งเมล์"/>-->

<script  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDg49SZLUZdLu8KQ80fEAPJkbdBUqyN-vw&libraries=places" ></script>

<script>

    var Lat = parseFloat(<?php echo $row['lat'];?>);
    var Lng = parseFloat(<?php echo $row['lng'];?>);
    //alert(Lat+" "+Lng);
    console.log(Lat+","+Lng);

    myLatLng = {lat: Lat, lng: Lng};
    var map = new google.maps.Map(document.getElementById('map-canvas'), {
        center: myLatLng,
        zoom: 17
    });

    var marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
    });

</script>


<script>
    function myFunction(imgs) {
        var expandImg = document.getElementById("expandedImg");
        var imgText = document.getElementById("imgtext");
        expandImg.src = imgs.src;
        imgText.innerHTML = imgs.alt;
        expandImg.parentElement.style.display = "block";
    }
</script>

</body>

<script type="text/javascript">
    if (location.href.indexOf('reload')==-1)
    {
        location.href=location.href+'?reload';
    }
</script>

<!--Refresh 1 time for clear cache & fix maps-->

