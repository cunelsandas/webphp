
<style>
    #map2 {
        height: 400px;
        width: 100%;
    }
    p{
        margin: 5px
    }
</style>

<!-- Heading -->
  <div id="heading" >
    <h1 class="thai-font" >ข้อมูลการดำเนินงาน</h1>
  </div>

<!-- Main -->
  <section id="main" class="wrapper thai-font">
    <div class="inner">
      <div class="content">

        <div class="row">
          <div class="col-12 col-12-medium">

              <form method="post" action="#" onsubmit="return(validate());" name="myForm" enctype="multipart/form-data">
                <!-- Break -->
                <div class="row gtr-uniform">

                  <?php
                      $sql = "SELECT * FROM tb_request WHERE receiveno = ".$_POST['frm_key'];
                      $rs = rsQuery($sql);
                      $row = mysqli_fetch_array($rs);

                      $sqll = "SELECT * FROM ".$row['table_name']." WHERE id =".$row['master_id'];
                      $rsl = rsQuery($sqll);
                      $rowl = mysqli_fetch_array($rsl);


                      $datework = DateThai($row['date']);
                  //------------------------------------------------------------------
                      $province=FindRS("SELECT * FROM province WHERE PROVINCE_ID=".$rowl['province'],PROVINCE_NAME);
                      $amphur=FindRS("SELECT * FROM amphur WHERE AMPHUR_ID=".$rowl['amphur'],AMPHUR_NAME);
                      $district=FindRS("SELECT * FROM district WHERE DISTRICT_ID=".$rowl['district'],DISTRICT_NAME);
                      $moo = $rowl['moo'];
                      $numhome = $rowl['num_home'];

                      $addrass = "บ้านเลขที่ ".$numhome." หมู่ที่ ".$moo." ตำบล ".$district." อำเภอ ".$amphur." จังหวัด ".$province;

                  ?>
                  <div class="col-12 col-12-xsmall">
                    <h2>ข้อมูลการดำเนินงาน</h2>
                  </div>

                  <div class="col-12 col-12-xsmall">
                    <?php $modname = FindRS("SELECT * FROM tb_mod WHERE modid =".$row['modid'],modname) ?>

                    <p><b>เลขที่แจ้ง :</b> <?php echo $row['receiveno']; ?></p>
                    <p><b>ชื่อผู้แจ้ง : </b><?php echo $rowl['name']; ?></p>
                    <p><b>เบอร์โทรศัพท์ : </b><?php echo $rowl['tel']; ?></p>
                    <p><b>อีเมล : </b><?php echo $rowl['email']; ?></p>
                    <p><b>ที่อยู่ : </b><?php echo $addrass; ?></p>
                    <p><b>ยืนคำร้องในหัวข้อ : </b><?php echo $modname; ?></p>
                    <p><b>ผลการดำเนินงาน : </b><?php echo $rowl['result']; ?></p>

                  </div>

                  <div class="col-12 col-12-xsmall">
                    <center>

                      <?php $status = FindRS("SELECT * FROM tb_status WHERE id =".$rowl['status'],status) ?>


                    <h2>สถานะการดำเนินงาน</h2>
                    <h2 style="color: green;"><?php echo $status; ?></h2>
                  </center>
                  </div>



                  </div>
                  <!-- Break -->
                </div>
              </form>


          </div>
        </div>

        </div>
    </div>
  </section>










  <script type = "text/javascript">

        function validate() {

          if( document.myForm.frm_key.value == "" ) {
             alert( "กรุณากรอก เรื่องที่ต้องการแจ้ง!" );
             document.myForm.frm_key.focus() ;
             return false;
          }

           return( true );
        }

  </script>
