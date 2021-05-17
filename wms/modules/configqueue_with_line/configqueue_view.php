
<?php
$tablename = 'tb_queue';
$id = $_GET['id'];
$sql = 'SELECT * FROM tb_queue WHERE id = '.$id;
$rs = rsQuery($sql);
$row = mysqli_fetch_array($rs);



//------------------------------------------------------
$receiveno = FindRS("SELECT * FROM tb_request WHERE table_name='$tablename' AND master_id = '$id'",receiveno);
$datein = FindRS("SELECT * FROM tb_request WHERE table_name='$tablename' AND master_id = '$id'",datein);
//------------------------------------------------------
//$province=FindRS("SELECT * FROM province WHERE PROVINCE_ID=".$row['province'],PROVINCE_NAME);
//$amphur=FindRS("SELECT * FROM amphur WHERE AMPHUR_ID=".$row['amphur'],AMPHUR_NAME);
//$district=FindRS("SELECT * FROM district WHERE DISTRICT_ID=".$row['district'],DISTRICT_NAME);
//$moo = $row['moo'];
//
//$addrass = "หมู่ที่ ".$moo." ตำบล ".$district." อำเภอ ".$amphur." จังหวัด ".$province;
//------------------------------------------------------
if(isset($_POST['btadd'])) {

  $sql = "UPDATE $tablename SET status='".$_POST['f_status']."',result='".$_POST['frm_result']."' WHERE id=".$id;

    if (rsQuery($sql)) {
      echo "<script>alert('บันทึกข้อมูลเรียบร้อยค่ะ !'); window.location.href='main.php?_mod=".$mod."&_modid=".$modid."';</script>";
    }

}
?>

<style>
    #map2 {
        height: 400px;
        width: 100%;
    }
</style>

<link type="text/css" rel="stylesheet" href="css/style_image.css">
<link rel="stylesheet" href="css/hes-gallery.css">

<div class="container">
  <div class="col-md-12">
    <h1 style="text-align:center"><?php echo $modname; ?></h1>
    <div class="panel panel-default">
      <div class="panel-body">
        <div class="col-md-6 col-sm-12">
        <h4><u>ข้อมูลผู้แจ้ง</u></h4>
        <p> เลขที่จอง : <?php echo $row['id'] ?> </p>
<!--        <p> วันที่จอง &nbsp;&nbsp;&nbsp;&nbsp;: --><?php //echo DateTimeThai($datein) ?><!-- </p>-->
        <p> ชื่อผู้จอง &nbsp;&nbsp;&nbsp;&nbsp;: <?php echo $row['name'] ?> </p>
<!--        <p> อีเมล &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: --><?php //echo $row['email'] ?><!-- </p>-->
        <p> โทรศัพท์ &nbsp;&nbsp;&nbsp;: <?php echo $row['tel'] ?> </p>
<!--        <p> ที่อยู่ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: --><?php //echo $addrass ?><!--</p>-->
      </div>
      <div class="col-md-6 col-sm-9">
      <h4><u>รายละเอียด</u></h4>

      <p> เรื่องที่รับบริการ</p>
      <?php
        $sql2 = "select * from tb_queue_obj where id = $id";
        $rs2 = rsQuery($sql2);

        while ($row2 = mysqli_fetch_array($rs2)) {
          if ($row2['object_name'] != "") {
            echo "&nbsp;&nbsp;&nbsp;&nbsp;".$row2['object_name']. "<br>";
          }
        }
       ?>
       <br>
      <p> วันที่จอง &nbsp;&nbsp;&nbsp; : <?php echo DateThai($row['start_date']) ?> </p>
      <p> เวลาที่จอง &nbsp;&nbsp;&nbsp;&nbsp;: <?php echo ($row['end_date']) ?> น. </p>
    </div>
</div>
</div>
  </div>

  <?php
  $sqls  =  "select * from files_image where table_name='$tablename' and master_id='$id' ";
  $rss = rsQuery($sqls);
  $num = mysqli_num_rows($rss);
  $count = 1;
  if ($num > 0){

  ?>
  <div class="col-md-12" style="text-align:center">
      <h2>รูปภาพ</h2>
      <p>(คลิกที่รูปภาพ เพื่อแสดง)</p>
  </div>

  <div class="col-md-12" style="text-align:center">
    <div class="hes-gallery">
            <?php

            while ($rows = mysqli_fetch_array($rss)){
                echo "<div style='height: 200px ; margin-top: 10px'>";
                echo "<img class=\"hover-shadow cursor\" alt=\"image".$count."\" style=\"border: 1px solid #ddd; border-radius: 4px;
            padding: 5px; width: 100%; height:180px;\"  src=".$part.$rows['file_name'].">";
                echo "</div>";
                $count++;
            }
            ?>
    </div>
</div>
<?php }?>

<?php // if ($row['lat'] != 0){ ?>
<!--  <div class="col-md-12" style="text-align:center">-->
<!--      <h2>แผนที่</h2>-->
<!--  </div>-->
<!--  <div class="col-md-12">-->
<!--    <div style="margin:20px 0px 20px 0px; border: 1px solid #ddd;">-->
<!--      <div id="map2"></div>-->
<!--    </div>-->
<!--    </div>-->
<?php //}?>
<!---->
<!--<div class="col-md-12" style="margin-bottom: 50px">-->
<!--    <form name="form_help" id="form_help" method="POST" action="" enctype="multipart/form-data">-->
<!---->
<!--        <div class="row">-->
<!--        <div class="col-md-4">-->
<!--            <br>-->
<!--            <label for="f_status"><b>การดำเนินงาน</b></label>-->
<!--            <select id="f_status" name="f_status" class="form-control">-->
<!--                --><?php
//                  $selected = $row['status'];
//                  $sqls = "select * from tb_status";
//                  $rss = rsQuery($sqls);
//                  while ($rows = mysqli_fetch_array($rss)) {
//                    ?>
<!--                    <option --><?php //if($selected == $rows['id']){echo("selected");}?><!-- value="--><?php //echo $rows['id']; ?><!--">--><?php //echo $rows['status']; ?><!--</option>-->
<!---->
<!--                    --><?php
//                  }
//                ?>
<!--            </select>-->
<!--            <br>-->
<!--        </div>-->
<!--        </div>-->
<!---->
<!--        <div class="row">-->
<!--        <div class="col-md-6">-->
<!--            <label for="f_status"><b>ผลการดำเนินงาน</b></label>-->
<!--            <textarea class="form-control" rows="4" name="frm_result" >--><?php //echo $row['result']; ?><!--</textarea>-->
<!--            <br>-->
<!--        </div>-->
<!--        </div>-->


<!--<button class="btn btn-info" type="submit" name="btadd">บันทึก</button>&nbsp;&nbsp;-->
<!--<a class="btn btn-default"  href="--><?php //echo $foderreport; ?><!--report.php?id=--><?php //echo $row['id'];?><!--" target="_Blank">พิมพ์คำร้อง</a>&nbsp;&nbsp;-->

    </form>
  </div>


</div>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDg49SZLUZdLu8KQ80fEAPJkbdBUqyN-vw&callback=initMap&libraries=places" ></script>

<script>
    function initMap(){


        myLatLng = {lat: <?php echo $row['lat']; ?>, lng: <?php echo $row['lng']; ?>};
        var map = new google.maps.Map(document.getElementById('map2'), {
            center: myLatLng,
            zoom: 18
        });

        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
            //draggable:true
        });

        google.maps.event.addListener(marker,'dragend',function () {
            var lat = marker.getPosition().lat();
            var lng = marker.getPosition().lng();

            document.getElementById("frm_lat").value = lat.toFixed(5);
            document.getElementById("frm_lng").value = lng.toFixed(5);

        });


    }

</script>

<script src="js/hes-gallery.js"></script>
<script>
  HesGallery.setOptions({
          disableScrolling: false,
          hostedStyles: false,
          animations: true,
          minResolution: 1000,

          showImageCount: true,
          wrapAround: true
      });
</script>
