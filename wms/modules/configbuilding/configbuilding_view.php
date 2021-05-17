
<?php
$id = $_GET['id'];
$sql = 'SELECT * FROM '.$tablename.' WHERE id = '.$id;
$rs = rsQuery($sql);
$row = mysqli_fetch_array($rs);



//------------------------------------------------------
$receiveno = FindRS("SELECT * FROM tb_request WHERE table_name='$tablename' AND master_id = '$id'",receiveno);
$datein = FindRS("SELECT * FROM tb_request WHERE table_name='$tablename' AND master_id = '$id'",datein);
//------------------------------------------------------
$province=FindRS("SELECT * FROM province WHERE PROVINCE_ID=".$row['province'],PROVINCE_NAME);
$amphur=FindRS("SELECT * FROM amphur WHERE AMPHUR_ID=".$row['amphur'],AMPHUR_NAME);
$district=FindRS("SELECT * FROM district WHERE DISTRICT_ID=".$row['district'],DISTRICT_NAME);
$moo = $row['moo'];
$numhome = $row['num_home'];

$addrass = "บ้านเลขที่ ".$numhome." หมู่ที่ ".$moo." ตำบล ".$district." อำเภอ ".$amphur." จังหวัด ".$province;
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
        <p> เลขที่คำร้อง : <?php echo $receiveno ?> </p>
        <p> วันที่แจ้ง &nbsp;&nbsp;&nbsp;&nbsp;: <?php echo DateTimeThai($datein) ?> </p>
        <p> ชื่อผู้แจ้ง &nbsp;&nbsp;&nbsp;&nbsp;: <?php echo $row['name'] ?> </p>
        <p> อีเมล &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?php echo $row['email'] ?> </p>
        <p> โทรศัพท์ &nbsp;&nbsp;&nbsp;: <?php echo $row['tel'] ?> </p>
        <p> ที่อยู่ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?php echo $addrass ?></p>
      </div>
      <div class="col-md-6 col-sm-9">
      <h4><u>รายละเอียด</u></h4>
      <p> ขออนุญาตก่อสร้างอาคาร ดัดแปลงอาคารหรือรื้อถอนอาคาร :
      <?php if ($row['check_doc'] == "1"){
          echo "บุคคลธรรม ";
      }
      if ($row['copy_doc1'] == "1") {
        echo "นิติบุคคล ";
      }
      ?>
    </p>
      <p> เรื่อง : <?php echo $row['supject'] ?> </p>
    </div>
</div>
  </div>

<div class="col-md-12" style="margin-bottom: 50px">
    <form name="form_help" id="form_help" method="POST" action="" enctype="multipart/form-data">

        <div class="row">
        <div class="col-md-4">
            <br>
            <label for="f_status"><b>การดำเนินงาน</b></label>
            <select id="f_status" name="f_status" class="form-control">
                <?php
                  $selected = $row['status'];
                  $sqls = "select * from tb_status";
                  $rss = rsQuery($sqls);
                  while ($rows = mysqli_fetch_array($rss)) {
                    ?>
                    <option <?php if($selected == $rows['id']){echo("selected");}?> value="<?php echo $rows['id']; ?>"><?php echo $rows['status']; ?></option>

                    <?php
                  }
                ?>
            </select>
            <br>
        </div>
        </div>


        <div class="row">
        <div class="col-md-6">
            <label for="f_status"><b>ผลการดำเนินงาน</b></label>
            <textarea class="form-control" rows="4" name="frm_result" ><?php echo $row['result']; ?></textarea>
            <br>
        </div>
        </div>

<button class="btn btn-info" type="submit" name="btadd">บันทึก</button>&nbsp;&nbsp;
<a class="btn btn-default"  href="<?php echo $foderreport; ?>report.php?id=<?php echo $row['id'];?>" target="_Blank">พิมพ์คำร้อง</a>&nbsp;&nbsp;

    </form>
  </div>


</div>
</div>


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
