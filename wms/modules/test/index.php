<?php
  $modname=FindRS("select * from tb_mod where modtype='$mod'",modname);
  $modid=FindRS("select * from tb_mod where modtype='$mod'",modid);
  $table=FindRS("select * from tb_mod where modtype='$mod'",tablename);
  $folder =FindRS("select * from tb_mod where modtype='$mod'",foldername);



  if(isset($_POST['Submit'])) {

    $sql = "SELECT * FROM tb_request WHERE receiveno = ".$_POST['frm_key'];
    $rs = rsQuery($sql);
    $row = mysqli_num_rows($rs);
    if ($row != 0) {
      include_once("view_data.php");
    }else {
      echo "<script>alert('เลขคำร้องของท่านไม่ถูกต้อง กรุณาตรวจสอบค่ะ')</script>";
    }

  }else {?>


    <style>
        #map2 {
            height: 400px;
            width: 100%;
        }
    </style>

    <!-- Heading -->
      <div id="heading" >
        <h1 class="thai-font" ><?php echo $modname; ?></h1>
      </div>

    <!-- Main -->
      <section id="main" class="wrapper thai-font">
        <div class="inner">
          <div class="content">

            <div class="row">
              <div class="col-12 col-12-medium">

                  <form method="post" action="#" onsubmit="return(validate());" name="myForm" enctype="multipart/form-data">
                    <div class="row gtr-uniform">


                      <div class="col-12 col-12-xsmall">
                        <h3>กรุณากรอกรหัสคำร้อง</h3>
                      </div>
                      <div class="col-6 col-12-xsmall">
                        <input type="text" name="frm_key" id="frm_key" value="" placeholder="ตัวอย่าง: 1001" />
                      </div>
                      <div class="col-6 col-12-xsmall">
                        <p>*เลขที่คำร้องจะถูกส่งไปยังอีเมลของท่าน หลังจากท่านได้ส่งคำร้องเข้ามา</p>
                      </div>


                      </div>
                      <!-- Break -->

                      <div class="col-12" style="margin-top: 20px">
                        <ul class="actions">
                          <li><input type="submit" name="Submit" value="ค้นหา" class="primary" /></li>
                        </ul>
                      </div>
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





  <?php } ?>
