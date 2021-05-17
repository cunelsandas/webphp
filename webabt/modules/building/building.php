<?php
  $modname=FindRS("select * from tb_mod where modtype='$mod'",modname);
  $modid=FindRS("select * from tb_mod where modtype='$mod'",modid);
  $table=FindRS("select * from tb_mod where modtype='$mod'",tablename);
  $folder =FindRS("select * from tb_mod where modtype='$mod'",foldername);

  $part = "fileupload/".$folder."/";

  if(isset($_POST['Submit'])) {

    /*$province=FindRS("SELECT * FROM province WHERE PROVINCE_ID=".$_POST['frm_province'],PROVINCE_NAME);
    $amphur=FindRS("SELECT * FROM amphur WHERE AMPHUR_ID=".$_POST['frm_amphur'],AMPHUR_NAME);
    $district=FindRS("SELECT * FROM district WHERE DISTRICT_ID=".$_POST['frm_district'],DISTRICT_NAME);
    $moo = $_POST['frm_moo'];
*/

                  $sql = "INSERT INTO $table(id,name,tel,email,province,amphur,district,moo,num_home,soi,road,nititype,regisday,regisnum,officenum,soiniti,
                  roadniti,mooniti,provinceniti,amphurniti,districtniti,byniti,bynumhome,bysoi,byroad,provinceby,amphurby,districtby,bymoo,
                  buildnum,buildsoi,buildroad,buildmoo,buildprovince,buildamphur,builddistrict,buildowner,buildnoso,landowner,buildtype,buildfloor,builduse,buildwh,buildcarpark,
                  buildengineer,buildcal,buildfinishday,blueprintset,blueprintpaper,calpaper,engineeraccept,deednum,deedset,bookaccept,engineercopy,otherdoc,check_doc,copy_doc1,ask_doc,copy_doc2,etc_doc,supject,post_ip,status,active)
                  Values('','" .$_POST['frm_name']. "','" .$_POST['frm_tel']. "','" .$_POST['frm_email']. "','" .$_POST['frm_province']. "','" .$_POST['frm_amphur']. "'
                    ,'" .$_POST['frm_district']. "','" .$_POST['frm_moo']. "'
                  ,'" .$_POST['frm_numhome']. "','" .$_POST['frm_soi']. "','" .$_POST['frm_road']. "','" .$_POST['frm_nititype']. "','" .$_POST['frm_regisday']. "','" .$_POST['frm_regisnum']. "','" .$_POST['frm_officenum']. "',
                  '" .$_POST['frm_soiniti']. "','" .$_POST['frm_roadniti']. "','" .$_POST['frm_mooniti']. "','" .$_POST['frm_provinceniti']. "','" .$_POST['frm_amphurniti']. "','" .$_POST['frm_districtniti']. "',
                  '" .$_POST['frm_byniti']. "','" .$_POST['frm_bynumhome']. "','" .$_POST['frm_bysoi']. "','" .$_POST['frm_byroad']. "','" .$_POST['frm_provinceby']. "','" .$_POST['frm_amphurby']. "','" .$_POST['frm_districtby']. "','" .$_POST['frm_mooby']. "',
                  '" .$_POST['frm_buildnum']. "','" .$_POST['frm_buildsoi']. "','" .$_POST['frm_buildroad']. "','" .$_POST['frm_buildmoo']. "','" .$_POST['frm_buildprovince']. "','" .$_POST['frm_buildamphur']. "','" .$_POST['frm_builddistrict']. "',
                  '" .$_POST['frm_buildowner']. "','" .$_POST['frm_buildnoso']. "','" .$_POST['frm_landowner']. "','" .$_POST['frm_buildtype']. "','" .$_POST['frm_buildfloor']. "','" .$_POST['frm_builduse']. "',
                  '" .$_POST['frm_buildwh']. "','" .$_POST['frm_buildcarpark']. "','" .$_POST['frm_buildengineer']. "','" .$_POST['frm_buildcal']. "','" .$_POST['frm_buildfinishday']. "',
                  '" .$_POST['frm_blueprintset']. "','" .$_POST['frm_blueprintpaper']. "','" .$_POST['frm_calpaper']. "','" .$_POST['frm_engineeraccept']. "',
                  '" .$_POST['frm_deednum']. "','" .$_POST['frm_deedset']. "','" .$_POST['frm_bookaccept']. "','" .$_POST['frm_engineercopy']. "','" .$_POST['frm_otherdoc']. "','" .$_POST['choice1']. "','" .$_POST['choice2']. "','" .$_POST['choice3']. "'
                ,'" .$_POST['choice4']. "','" .$_POST['choice5']. "','" .$_POST['frm_subject']. "','" .$_SERVER['REMOTE_ADDR']. "','1','1')";
                  $rs = rsQuery($sql);


                  $sql2 = "SELECT * FROM $table ORDER BY id DESC LIMIT 0,1";
                  $rss = rsQuery($sql2);
                  $num = mysqli_fetch_array($rss);
                  $lid = $num['id'];
                  $date = date("Y-m-d H:i:s");
                  $receiveno = "1000" . $lid;

                  $sql = "INSERT INTO tb_request(id,table_name,master_id,modid,receiveno,datein)
                  Values('','" .$table. "','" .$lid. "','" .$modid. "','" .$receiveno. "','" .$date. "')";
                  $rs = rsQuery($sql);

                  $sql = "INSERT INTO tb_notification(id,subject,detail,modid,master_id,allstatus,substatus)
                  Values('','" .$_POST['frm_name']. "','" .$modname. "','" .$modid. "','" .$lid. "','0','0')";
                  $rs = rsQuery($sql);

                  include_once("itgmod/sent_email.php");

                  if ($rs) {
                      echo "<script>alert('เรื่องของคุณได้ถูกส่งไปยังผุ้ที่เกี่ยวข้องแล้วค่ะ  เลขคำร้องของคุณคือ : ".$receiveno."');window.location.href='index.php';</script>";
                  }else{
                      echo "<script>alert('Err'); </script>" ;
                }

  }
  ?>


<style>
    #map2 {
        height: 400px;
        width: 100%;
    }
</style>

<!-- Heading -->
  <div id="heading" >
    <h1><?php echo $modname; ?></h1>
  </div>

<!-- Main -->
  <section id="main" class="wrapper">
    <div class="inner">
      <div class="content">

        <div class="row">
          <div class="col-12 col-12-medium">

              <form method="post" action="#" onsubmit="return(validate());" name="myForm" enctype="multipart/form-data">
                <div class="row gtr-uniform">
                  <div class="col-12 col-12-xsmall">
                    <h3>ข้อมูลผู้ขออนุญาตก่อสร้าง</h3>
                  </div>
                  <div class="col-6 col-12-xsmall">
                    <input type="text" name="frm_name" id="frm_name" value="" placeholder="ชื่อ-สกุล" />
                  </div>
                  <div class="col-6 col-12-xsmall">
                    <input type="text" name="frm_tel" id="frm_tel" value="" placeholder="โทรศัพท์" />
                  </div>
                  <div class="col-6 col-12-xsmall">
                    <input type="email" name="frm_email" id="frm_email" value="" placeholder="อีเมล" />
                  </div>
                  <div class="col-12 col-12-xsmall">
                  </div>
                  <!-- Break -->
                  <div class="col-12 col-12-xsmall">
                    <label>มีความประสงค์ ขออนุญาตก่อสร้างอาคาร (เลือกอย่างใดอย่างนึง) </label>
                  </div>
                  <!-- Break -->
                  <div class="col-6 col-12-small">
                     <input type="checkbox" value="1" id="choice1" name="choice1"/>
                    <label for="choice1">เป็นบุคคลธรรมดา</label>
                      <div class="col-2 col-12-xsmall">
                          <input type="text" name="frm_numhome" id="frm_numhome" value="" placeholder="บ้านเลขที่" />
                      </div>
                      <br>
                      <div class="col-2 col-12-xsmall">
                          <input type="text" name="frm_soi" id="frm_soi" value="" placeholder="ตรอก/ซอย" />
                      </div>
                      <br>
                      <div class="col-2 col-12-xsmall">
                          <input type="text" name="frm_road" id="frm_road" value="" placeholder="ถนน" />
                      </div>
                      <br>
                      <div class="col-2 col-12-xsmall">
                          <input type="text" name="frm_moo" id="frm_moo" value="" placeholder="หมู่ที่" />
                      </div>
                      <br>
                      <div class="col-3 col-12-xsmall">
                          <select name="frm_province" id="frm_province">
                              <option value="">- จังหวัด -</option>
                              <?php
                              $sql = "SELECT * FROM province";
                              $rs = rsQuery($sql);
                              while ($row = mysqli_fetch_array($rs)) {
                                  echo "<option value=".$row['PROVINCE_ID'].">".$row['PROVINCE_NAME']."</option>";
                              }
                              ?>
                          </select>
                      </div>
                      <br>
                      <div class="col-3 col-12-xsmall">
                          <select name="frm_amphur" id="frm_amphur">
                              <option value="">- อำเภอ -</option>
                          </select>
                      </div>
                      <br>
                      <div class="col-3 col-12-xsmall">
                          <select name="frm_district" id="frm_district">
                              <option value="">- ตำบล -</option>
                          </select>
                      </div>
                      <br>

                  </div>

                  <div class="col-6 col-12-small">
                     <input type="checkbox" value="1" id="choice2" name="choice2"/>
                    <label for="choice2">เป็นนิติบุคคล</label>
                      <div class="col-2 col-12-xsmall">
                          <input type="text" name="frm_nitytype" id="frm_nititype" value="" placeholder="ประเภทนิติบุคคล" />
                      </div>
                      <br>
                      <div class="col-2 col-12-xsmall">
                          <input type="text" name="frm_regisday" id="frm_regisday" value="" placeholder="จดทะเบียนเมื่อ" />
                      </div>
                      <br>
                      <div class="col-2 col-12-xsmall">
                          <input type="text" name="frm_regisnum" id="frm_regisnum" value="" placeholder="เลขทะเบียน" />
                      </div>
                      <br>
                      <div class="col-2 col-12-xsmall">
                          <input type="text" name="frm_officenum" id="frm_officenum" value="" placeholder="มีสำนักงานตั้งอยู่เลขที่" />
                      </div>
                      <br>
                      <div class="col-2 col-12-xsmall">
                          <input type="text" name="frm_soiniti" id="frm_soiniti" value="" placeholder="ตรอก/ซอย" />
                      </div>
                      <br>
                      <div class="col-2 col-12-xsmall">
                          <input type="text" name="frm_roadniti" id="frm_roadniti" value="" placeholder="ถนน" />
                      </div>
                      <br>
                      <div class="col-2 col-12-xsmall">
                          <input type="text" name="frm_mooniti" id="frm_mooniti" value="" placeholder="หมู่ที่" />
                      </div>
                      <br>
                      <div class="col-3 col-12-xsmall">
                          <select name="frm_provinceniti" id="frm_provinceniti">
                              <option value="">- จังหวัด -</option>
                              <?php
                              $sql = "SELECT * FROM province";
                              $rs = rsQuery($sql);
                              while ($row = mysqli_fetch_array($rs)) {
                                  echo "<option value=".$row['PROVINCE_ID'].">".$row['PROVINCE_NAME']."</option>";
                              }
                              ?>
                          </select>
                      </div>
                      <br>
                      <div class="col-3 col-12-xsmall">
                          <select name="frm_amphurniti" id="frm_amphurniti">
                              <option value="">- อำเภอ -</option>
                          </select>
                      </div>
                      <br>
                      <div class="col-3 col-12-xsmall">
                          <select name="frm_districtniti" id="frm_districtniti">
                              <option value="">- ตำบล -</option>
                          </select>
                      </div>
                      <br>
                      <label>โดย (ผู้มีอำนาจลงชื่อแทนนิติบุคคลผู้ขออนุญาต)</label>
                      <div class="col-3 col-12-xsmall">
                          <input type="text" name="frm_byniti" id="frm_byniti" value="" placeholder="ชื่อ-นามสกุล" />
                      </div>
                      <br>
                      <div class="col-3 col-12-xsmall">
                          <input type="text" name="frm_bynumhome" id="frm_bynumhome" value="" placeholder="บ้านเลขที่" />
                      </div>
                      <br>
                      <div class="col-3 col-12-xsmall">
                          <input type="text" name="frm_bysoi" id="frm_bysoi" value="" placeholder="ตรอก/ซอย" />
                      </div>
                      <br>
                      <div class="col-3 col-12-xsmall">
                          <input type="text" name="frm_byroad" id="frm_byroad" value="" placeholder="ถนน" />
                      </div>
                      <br>
                      <div class="col-3 col-12-xsmall">
                          <input type="text" name="frm_mooby" id="frm_mooby" value="" placeholder="หมู่ที่" />
                      </div>
                      <br>
                      <div class="col-3 col-12-xsmall">
                          <select name="frm_provinceby" id="frm_provinceby">
                              <option value="">- จังหวัด -</option>
                              <?php
                              $sql = "SELECT * FROM province";
                              $rs = rsQuery($sql);
                              while ($row = mysqli_fetch_array($rs)) {
                                  echo "<option value=".$row['PROVINCE_ID'].">".$row['PROVINCE_NAME']."</option>";
                              }
                              ?>
                          </select>
                      </div>
                      <br>
                      <div class="col-3 col-12-xsmall">
                          <select name="frm_amphurby" id="frm_amphurby">
                              <option value="">- อำเภอ -</option>
                          </select>
                      </div>
                      <br>
                      <div class="col-3 col-12-xsmall">
                          <select name="frm_districtby" id="frm_districtby">
                              <option value="">- ตำบล -</option>
                          </select>
                      </div>
                  </div>

                  <div class="col-12 col-12-small" style="padding:0px">
                      <hr></div>
                  <!-- Break -->

                  <div class="col-12 col-12-xsmall">
                    <label>ขอยื่นคำขอใบอนุญาต ก่อสร้าง ดักแปลง รื้อถอน ต่อเจ้าพนักงานท้องถิ่นดังต่อไปนี้ </label>
                  </div>
                    <div class="col-12 col-12-xsmall">
                        <label>ข้อ ๑ </label>
                    </div>
                  <!-- Break -->
                  <div class="col-6 col-12-xsmall">
                    <input type="text" name="frm_buildnum" id="frm_buildnum" value="" placeholder="บ้านเลขที่" />
                  </div>
                    <div class="col-6 col-12-xsmall">
                        <input type="text" name="frm_buildsoi" id="frm_buildsoi" value="" placeholder="ตรอก/ซอย" />
                    </div>
                    <div class="col-6 col-12-xsmall">
                        <input type="text" name="frm_buildroad" id="frm_buildroad" value="" placeholder="ถนน" />
                    </div>
                    <div class="col-6 col-12-xsmall">
                        <input type="text" name="frm_buildmoo" id="frm_buildmoo" value="" placeholder="หมู่ที่" />
                    </div>
                    <div class="col-3 col-12-xsmall">
                        <select name="frm_buildprovince" id="frm_buildprovince">
                            <option value="">- จังหวัด -</option>
                            <?php
                            $sql = "SELECT * FROM province";
                            $rs = rsQuery($sql);
                            while ($row = mysqli_fetch_array($rs)) {
                                echo "<option value=".$row['PROVINCE_ID'].">".$row['PROVINCE_NAME']."</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-3 col-12-xsmall">
                        <select name="frm_buildamphur" id="frm_buildamphur">
                            <option value="">- อำเภอ -</option>
                        </select>
                    </div>
                    <div class="col-3 col-12-xsmall">
                        <select name="frm_builddistrict" id="frm_builddistrict">
                            <option value="">- ตำบล -</option>
                        </select>
                    </div>
                    <div class="col-6 col-12-xsmall">
                        <input type="text" name="frm_buildowner" id="frm_buildowner" value="" placeholder="ชื่อ - สกุลเจ้าของอาคารในโฉนดที่ดิน" />
                    </div>
                    <div class="col-6 col-12-xsmall">
                        <input type="text" name="frm_buildnoso" id="frm_buildnoso" value="" placeholder="เลขที่/น.ส.๓/ เลขที่/ส.ค.๑" />
                    </div>
                    <div class="col-6 col-12-xsmall">
                        <input type="text" name="frm_landowner" id="frm_landowner" value="" placeholder="ชื่อ - สกุลเจ้าของที่ดิน" />
                    </div>
                    <div class="col-12 col-12-xsmall">
                        <label>ข้อ ๒ </label>
                    </div>
                    <div class="col-4 col-12-xsmall">
                        <input type="text" name="frm_buildtype" id="frm_buildtype" value="" placeholder="ชนิดอาคาร" />
                    </div>
                    <div class="col-4 col-12-xsmall">
                        <input type="text" name="frm_buildfloor" id="frm_buildfloor" value="" placeholder="จำนวนชั้น" />
                    </div>
                    <div class="col-4 col-12-xsmall">
                        <input type="text" name="frm_builduse" id="frm_builduse" value="" placeholder="เพื่อใช้เป็น (เช่น ที่พักอาศัย เป็นต้น)" />
                    </div>
                    <div class="col-4 col-12-xsmall">
                        <input type="text" name="frm_buildwh" id="frm_buildwh" value="" placeholder="พื้นที่/ความยาว อาคาร" />
                    </div>
                    <div class="col-4 col-12-xsmall">
                        <input type="text" name="frm_buildcarpark" id="frm_buildcarpark" value="" placeholder="จำนวนที่จอดรถ" />
                    </div>
                    <div class="col-12 col-12-xsmall">
                        <label>ข้อ ๓ </label>
                    </div>
                    <div class="col-6 col-12-xsmall">
                        <input type="text" name="frm_buildengineer" id="frm_buildengineer" value="" placeholder="ชื่อ - นามสกุลผู้ควบคุมงาน" />
                    </div>
                    <div class="col-6 col-12-xsmall">
                        <input type="text" name="frm_buildcal" id="frm_buildcal" value="" placeholder="ชื่อ - นามสกุลผู้ออกแบบและคำนวณ" />
                    </div>
                    <div class="col-12 col-12-xsmall">
                        <label>ข้อ ๔ </label>
                    </div>
                    <div class="col-6 col-12-xsmall">
                        <input type="text" name="frm_buildfinishday" id="frm_buildfinishday" value="" placeholder="กำหนดแล้วเสร็จ (วัน)" />
                    </div>
                    <div class="col-12 col-12-xsmall">
                        <label>ข้อ ๕ ข้าพเจ้าได้แนบเอกสารหลักญานต่างๆมาด้วยแล้ว คือ </label>
                    </div>

                        <label>แผนผังบริเวณ แบบแปลน รายการประกอบแบบแปลน </label>

                    <div class="col-3 col-12-xsmall">
                        <input type="text" name="frm_blueprintset" id="frm_blueprintset" value="" placeholder="จำนวน (ชุด)" />
                    </div>
                    <div class="col-3 col-12-xsmall">
                        <input type="text" name="frm_blueprintpaper" id="frm_blueprintpaper" value="" placeholder="ชุดละ (แผ่น)" />
                    </div>

                    <label>รายการคำนวณ ๑ ชุด <br>(กรณีที่เป็นอาคารสาธารณะ อาคารพิเศษหรืออาคารที่ก่อสร้างด้วยวัตถุถาวรและวัตถุทนไฟเป็นส่วนใหญ่) </label>

                    <div class="col-3 col-12-xsmall">
                        <input type="text" name="frm_calpaper" id="frm_calpaper" value="" placeholder="จำนวน (แผ่น)" />

                    </div>

                    <label>หนังสือแสดงความยินยอมและรับรองของผู้ออกแบบและคำนวณอาคาร </label>

                    <div class="col-3 col-12-xsmall">
                        <input type="text" name="frm_engineeraccept" id="frm_engineeraccept" value="" placeholder="จำนวน (ฉบับ)" />
                    </div>

                    <label>สำเนาหรือภาพถ่ายโฉนดที่ดิน น.ส.๓ , ส.ค.๑ </label>

                    <div class="col-3 col-12-xsmall">
                        <input type="text" name="frm_deednum" id="frm_deednum" value="" placeholder="เลขที่" />
                    </div>
                    <div class="col-3 col-12-xsmall">
                        <input type="text" name="frm_deedset" id="frm_deedset" value="" placeholder="จำนวน (ฉบับ)" />
                    </div>
                    <label>หนังสือแสดงความยินยอมของผู้ควบคุมงานตามข้อ ๓</label>

                    <div class="col-3 col-12-xsmall">
                        <input type="text" name="frm_bookaccept" id="frm_bookaccept" value="" placeholder="จำนวน (ฉบับ)" />
                    </div>

                    <label>สำเนาหรือภาพถ่ายใบอนุญาตเป็นผู้ประกอบวิชาชีพวิศวกรรมควบคุมหรือวิชาชีพสถาปัตยกรรมควบคุมของผู้ควบคุมงาน <br>(เฉพาะกรณีที่เป็นอาคารที่เป็นลักษณะ ขนาด อยู่ในประเภทเป็นวิชาชีพวิศวกรรมควบคุม หรือวิชาชีพสถาปัตยกรรมควบคุม แล้วแต่กรณี)</label>
                    <div class="col-3 col-12-xsmall">
                        <input type="text" name="frm_engineercopy" id="frm_engineercopy" value="" placeholder="จำนวน (ฉบับ)" />
                    </div>
                    <div class="col-12 col-12-xsmall">
                        <label>เอกสารอื่น ๆ (ถ้ามี) </label>
                    </div>
                    <div class="col-3 col-12-xsmall">
                        <input type="text" name="frm_otherdoc" id="frm_otherdoc" value="" placeholder="จำนวน (ฉบับ)" />
                    </div>




                    <!-- Break -->


                  <div class="col-12" >
                    <ul class="actions">
                      <li><input type="submit" name="Submit" value="Submit Form" class="primary" /></li>
                      <li><input type="reset" value="Reset" /></li>
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

           if( document.myForm.frm_name.value == "" ) {
              alert( "กรุณากรอก ชื่อ-สกุล!" );
              document.myForm.frm_name.focus() ;
              return false;
           }
           if( document.myForm.frm_tel.value == "" ) {
              alert( "กรุณากรอก เบอร์โทรศัพท์ !" );
              document.myForm.frm_tel.focus() ;
              return false;
           }
           if( document.myForm.frm_email.value == "" ) {
              alert( "กรุณากรอก อีเมล!" );
              document.myForm.frm_email.focus() ;
              return false;
           }
           if( document.myForm.frm_province.value == "" ) {
              alert( "กรุณาเลือก จังหวัด!" );
              document.myForm.frm_province.focus() ;
              return false;
           }
           if( document.myForm.frm_amphur.value == "" ) {
              alert( "กรุณาเลือก อำเภอ!" );
              document.myForm.frm_amphur.focus() ;
              return false;
           }
           if( document.myForm.frm_district.value == "" ) {
              alert( "กรุณาเลือก ตำบล!" );
              document.myForm.frm_district.focus() ;
              return false;
           }
           if( document.myForm.frm_moo.value == "" ) {
              alert( "กรุณากรอก หมู่ที่!" );
              document.myForm.frm_moo.focus() ;
              return false;
           }
           if( document.myForm.frm_numhome.value == "" ) {
              alert( "กรุณากรอก บ้านเลขที่!" );
              document.myForm.frm_numhome.focus() ;
              return false;
           }
           if( document.myForm.frm_subject.value == "" ) {
              alert( "กรุณากรอก เรื่องที่ต้องการขอข้อมูล!" );
              document.myForm.frm_subject.focus() ;
              return false;
           }


           return( true );
        }

  </script>


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

              document.getElementById("frm_lat").value = lat.toFixed(5);
              document.getElementById("frm_lng").value = lng.toFixed(5);

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

              document.getElementById("frm_lat").value = item_lat.toFixed(5);
              document.getElementById("frm_lng").value = item_lng.toFixed(5);

              google.maps.event.addListener(marker,'dragend',function () {
                  var lat = marker.getPosition().lat();
                  var lng = marker.getPosition().lng();

                  document.getElementById("frm_lat").value = lat.toFixed(5);
                  document.getElementById("frm_lng").value = lng.toFixed(5);
              });

              map.fitBounds(bounds);
              map.setZoom(15);

          });
      }

  </script>



  <script src="js/jquery-3.3.1.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#frm_province').change(function() {
                    $.ajax({
                        type: 'POST',
                        data: {data: $(this).val()},
                        url: '../../itgmod/select.php',
                        success: function(data) {
                            $('#frm_amphur').html(data);
                        }
                    });
                    return false;
                });

                $('#frm_amphur').change(function() {
                    $.ajax({
                        type: 'POST',
                        data: {data2: $(this).val()},
                        url: '../../itgmod/select.php',
                        success: function(data) {
                            $('#frm_district').html(data);
                        }
                    });
                    return false;
                });

            });
        </script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#frm_provinceniti').change(function() {
            $.ajax({
                type: 'POST',
                data: {data: $(this).val()},
                url: '../../itgmod/select.php',
                success: function(data) {
                    $('#frm_amphurniti').html(data);
                }
            });
            return false;
        });

        $('#frm_amphurniti').change(function() {
            $.ajax({
                type: 'POST',
                data: {data2: $(this).val()},
                url: '../../itgmod/select.php',
                success: function(data) {
                    $('#frm_districtniti').html(data);
                }
            });
            return false;
        });

    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#frm_provinceby').change(function() {
            $.ajax({
                type: 'POST',
                data: {data: $(this).val()},
                url: '../../itgmod/select.php',
                success: function(data) {
                    $('#frm_amphurby').html(data);
                }
            });
            return false;
        });

        $('#frm_amphurby').change(function() {
            $.ajax({
                type: 'POST',
                data: {data2: $(this).val()},
                url: '../../itgmod/select.php',
                success: function(data) {
                    $('#frm_districtby').html(data);
                }
            });
            return false;
        });

    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#frm_buildprovince').change(function() {
            $.ajax({
                type: 'POST',
                data: {data: $(this).val()},
                url: '../../itgmod/select.php',
                success: function(data) {
                    $('#frm_buildamphur').html(data);
                }
            });
            return false;
        });

        $('#frm_buildamphur').change(function() {
            $.ajax({
                type: 'POST',
                data: {data2: $(this).val()},
                url: '../../itgmod/select.php',
                success: function(data) {
                    $('#frm_builddistrict').html(data);
                }
            });
            return false;
        });

    });
</script>

