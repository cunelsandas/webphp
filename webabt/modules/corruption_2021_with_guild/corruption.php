<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="js/popper.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.datetimepicker.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="css/mystyle.php">
<?php
$modname = FindRS("select * from tb_mod where modtype='$mod'", modname);
$modid = FindRS("select * from tb_mod where modtype='$mod'", modid);
$table = FindRS("select * from tb_mod where modtype='$mod'", tablename);
$folder = FindRS("select * from tb_mod where modtype='$mod'", foldername);

$part = "fileupload/" . $folder . "/";

if (isset($_POST['Submit'])) {

    /*$province=FindRS("SELECT * FROM province WHERE PROVINCE_ID=".$_POST['frm_province'],PROVINCE_NAME);
    $amphur=FindRS("SELECT * FROM amphur WHERE AMPHUR_ID=".$_POST['frm_amphur'],AMPHUR_NAME);
    $district=FindRS("SELECT * FROM district WHERE DISTRICT_ID=".$_POST['frm_district'],DISTRICT_NAME);
    $moo = $_POST['frm_moo'];
*/
    $check = getimagesize($_FILES["frm_image"]["tmp_name"][0]);

    $sql = "INSERT INTO tb_corruption_2021(id,name,address,tel,subject,corruption_person,detail,img_key,post_ip,status,active)
                  Values('','" . $_POST['frm_name'] . "','" . $_POST['frm_address'] . "','" . $_POST['frm_tel'] . "','" . $_POST['frm_subject'] . "','" . $_POST['frm_corrupt_person'] . "','" . $_POST['frm_detail'] . "','" . $_POST['f_key'] . "'
                ,'" . $_SERVER['REMOTE_ADDR'] . "','1','1')";
    $rs = rsQuery($sql);

    $sql2 = "SELECT * FROM $table ORDER BY id DESC LIMIT 0,1";
    $rss = rsQuery($sql2);
    $num = mysqli_fetch_array($rss);
    $lid = $num['id'];
    $date = date("Y-m-d H:i:s");
    $receiveno = "400" . $lid;

    for ($i = 0; $i < count($_POST['frm_ojb']); $i++) {
        $ojb_id = $_POST['frm_ojb'][$i];
        $num_ojb = $_POST['frm_num'][$i];
        $sql3 = "INSERT INTO tb_corruption_obj(id,object_name,num_object,queue_id)
                  Values('','" . $ojb_id . "','" . $num_ojb . "','" . $lid . "')";
        $rs = rsQuery($sql3);
    }

//                  $sql = "INSERT INTO tb_request(id,table_name,master_id,modid,receiveno,datein)
//                  Values('','" .$table. "','" .$lid. "','" .$modid. "','" .$receiveno. "','" .$date. "')";
//                  $rs = rsQuery($sql);
//
//                  $sql = "INSERT INTO tb_notification(id,subject,detail,modid,master_id,allstatus,substatus)
//                  Values('','" .$_POST['frm_name']. "','" .$modname. "','" .$modid. "','" .$lid. "','0','0')";
//                  $rs = rsQuery($sql);

//                  include_once("itgmod/sent_email.php");

    if ($rs) {
        echo "<script>alert('คำร้องถูกส่งไปยังหน่วยงานแล้ว ขอบคุณที่ให้ความร่วมมือค่ะ');</script>";
    } else {
        echo "<script>alert('มีข้อผิดพลาดในการส่งข้อมูล'); </script>";
    }


    if ($check !== false) {

        $sql2 = "SELECT * FROM $table ORDER BY id DESC LIMIT 0,1";
        $rss = rsQuery($sql2);
        $num = mysqli_fetch_array($rss);
        $lid = $num['id'];
        $date = date("Y-m-d H:i:s");

        for ($i = 0; $i < count($_FILES['frm_image']['name']); $i++) {

            $filename = $_FILES["frm_image"]["name"][$i];
            $ext = end(explode(".", $filename));
            $newname = $table . '_' . $lid . '_' . $i . '.' . $ext;
            $filetmp = $_FILES["frm_image"]["tmp_name"][$i];
            $filetype = $_FILES["frm_image"]["type"][$i];
            $filepath = $part . $newname;

            if (move_uploaded_file($filetmp, $filepath)) {

                $sql = "INSERT INTO files_image(id,table_name,master_id,file_name,edit_time)
                                VALUES ('','" . $table . "','" . $lid . "','" . $newname . "','" . $date . "')";
                $rs = rsQuery($sql);

            } else {
                echo "<script>alert('มีข้อผิดพลาดจากการอัพรูปภาพ.'); </script>";
            }
        }
    }

}

?>


<style>
    #map2 {
        height: 400px;
        width: 100%;
    }

    body {
        font-family: THSarabunNew;
    }

    h1, h2, h3, h4, h5 {
        font-family: THSarabunNew;
    }
</style>

<!-- Heading -->
<div id="heading">
    <h3 style="text-decoration: underline"><?php echo $modname; ?></h3>
</div>


<?php
$sqlfileguild = "select * from tb_filestype where groupid=999";
$rss = rsQuery($sqlfileguild);
$rss->num_rows;
$rowguild = $rss->fetch_assoc();

$sqlfileguild2 = "select * from tb_filestype where groupid=1000";
$rsss = rsQuery($sqlfileguild2);
$rsss->num_rows;
$rowguild2 = $rsss->fetch_assoc();
?>

<a target="_blank" href="index.php?_mod=<?php echo encode64('files').'&type='.encode64($rowguild['fid'])?>"><button type="button" class="btn btn-outline-info" style="width: 250px;">คู่มือ/แนวทางการดำเนินการ</button></a><br>
<a target="_blank" href="index.php?_mod=<?php echo encode64('files').'&type='.encode64($rowguild2['fid'])?>"><button style="margin-top: 1%;width: 250px;" type="button" class="btn btn-outline-info">วิธีการขั้นตอนการร้องเรียน</button></a>

<?php
$sql = "select * from tb_corruption_2021 order by id desc LIMIT 1";
$rs = rsQuery($sql);
$rs->num_rows;
$row = $rs->fetch_assoc();
?>

<!-- Main -->
<section id="main" class="wrapper" style="margin-top: 3%">
    <div class="inner">
        <div class="content">

            <div class="row">
                <div class="col-12 col-12-medium">

                    <form method="post" action="#" onsubmit="return(validate());" name="myForm"
                          enctype="multipart/form-data">
                        <input type="hidden" name="id" id="id" value="<?php $newid = $row['id'] + 1;
                        echo $newid; ?>">
                        <div class="row gtr-uniform">
                            <!-- Break -->
                            <div class="col-12 col-12-xsmall">
                                <h4>ข้อมูลผู้ร้องเรียน</h4>
                            </div>
                            <div class="col-8 col-12-xsmall mt-1" style="margin: 0 auto;">
                                <input class="form-control" type="text" name="frm_name" id="frm_name" value=""
                                       placeholder="ชื่อ-สกุล"/>
                            </div>
                            <div class="col-8 col-12-xsmall mt-1" style="margin: 0 auto;">
                                <input class="form-control" type="text" name="frm_address" id="frm_address" value=""
                                       placeholder="ที่อยู่ บ้านเลขที่ ตำบล/แขวง อำเภอ/เขต จังหวัด"/>
                            </div>
                            <div class="col-8 col-12-xsmall mt-1" style="margin: 0 auto">
                                <input class="form-control" type="text" name="frm_tel" id="frm_tel" value=""
                                       placeholder="เบอร์โทรศัพท์" onkeyup="autoTab2(this,2)"/>
                            </div>
                            <!--                  <div class="col-12 col-12-xsmall">-->
                            <!--                    <h3>เลขบัตรประชาชน</h3>-->
                            <!--                  </div>-->

                            <div class="col-10 col-10-xsmall" style="margin:2% auto">
                                <h4>ข้อมูลผู้ถูกร้องเรียน (เจ้าหน้าที่ในสังกัด)</h4>
                            </div>
                            <div class="col-12 col-12-xsmall" style="margin: 0 auto">
                                <input class="form-control" type="text" name="frm_subject" id="frm_subject"
                                       placeholder="เรื่องที่ต้องการร้องเรียน"/>
                            </div>
                            <div class="col-4 col-12-small mt-1" style="margin: 0 auto">
                                <select class="form-control" name="frm_ojb[0]" id="frm_ojb[0]">
                                    <option value="">- กรุณาเลือกหน่วยงาน -</option>
                                    <?php
                                    $sql = "SELECT * FROM tb_division_corruption";
                                    $rs = rsQuery($sql);
                                    while ($row = mysqli_fetch_array($rs)) {
                                        echo "<option value=" . $row['object'] . ">" . $row['object'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-8 col-12-xsmall mt-1" style="margin: 0 auto">
                                <input class="form-control" type="text" name="frm_corrupt_person"
                                       id="frm_corrupt_person"
                                       placeholder="ชื่อ-นามสกุล หรือรายละเอียดบุคคลที่ท่านร้องเรียน">
                            </div>
                            <div class="col-12 col-12-xsmall mt-1" style="margin: 0 auto">
                                <textarea class="form-control" rows="10" name="frm_detail" id="frm_detail"
                                          placeholder="รายละเอียด"></textarea>
                            </div>

                            <div class="col-12 col-12-xsmall mt-2">
                                <label>รูปภาพ</label>
                                <input type="file" name="frm_image[]" id="frm_image[]" multiple>
                                <input type="hidden" name="f_key" id="f_key" value="corupt_<?php echo $newid; ?>">
                            </div>

                            <!-- Break -->
                            <!--                  <div class="col-2 col-12-xsmall">-->
                            <!--                    <input type="text" name="frm_num[0]" id="frm_num[0]" placeholder="จำนวน"/>-->
                            <!--                  </div>-->
                            <!--                  <div class="col-12 col-12-small" style="padding:0px"></div>-->
                            <!---->
                            <!--                  <div class="col-4 col-12-small">-->
                            <!--                    <select name="frm_ojb[1]" id="frm_ojb[1]">-->
                            <!--                      <option value="">- กรุณาเลือก -</option>-->
                            <!--                    --><?php
                            //                      $sql = "SELECT * FROM tb_object";
                            //                      $rs = rsQuery($sql);
                            //                      while ($row = mysqli_fetch_array($rs)) {
                            //                        echo "<option value=".$row['object'].">".$row['object']."</option>";
                            //                      }
                            //                    ?>
                            <!--                    </select>-->
                            <!--                  </div>-->
                            <!--                  <div class="col-2 col-12-xsmall">-->
                            <!--                    <input type="text" name="frm_num[1]" id="frm_num[1]" placeholder="จำนวน"/>-->
                            <!--                  </div>-->
                            <!--                  <div class="col-12 col-12-small" style="padding:0px"></div>-->
                            <!---->
                            <!--                  <div class="col-4 col-12-small">-->
                            <!--                    <input type="text" name="frm_ojb[2]" id="frm_ojb[2]" placeholder="อื่น ๆ"/>-->
                            <!--                  </div>-->
                            <!--                  <div class="col-2 col-12-xsmall">-->
                            <!--                    <input type="text" name="frm_num[2]" id="frm_num[2]" placeholder="จำนวน"/>-->
                            <!--                  </div>-->
                            <!--                  <div class="col-12 col-12-small" style="padding:0px"></div>-->
                            <!-- Break -->

                            <!-- Break -->
                            <!--                  <div class="col-12 col-12-small mt-2" style="padding:0px"></div>-->
                            <!--                  <div class="col-6 col-12-xsmall">-->
                            <!--                    <label>วันที่มารับบริการ</label>-->
                            <!--                    <input class="form-control" type="date" name="frm_date_str" id="frm_date_str" format="MM/DD/YYYY" placeholder="MM/DD/YYYY" value="-->
                            <?php //echo date("Y-m-j"); ?><!--"/>-->
                            <!--                  </div>-->
                            <!--                      <div class="col-6 col-12-small" style="margin: 0 auto">-->
                            <!--                          <label>เวลา</label>-->
                            <!--                          <select class="form-control" name="frm_date_end" id="frm_date_end">-->
                            <!--                              <option value="">- กรุณาเลือก -</option>-->
                            <!--                              --><?php
                            //                              $sql = "SELECT * FROM tb_time";
                            //                              $rs = rsQuery($sql);
                            //                              while ($row = mysqli_fetch_array($rs)) {
                            //                                      echo "<option disable value=" . $row['time'] . ">" . $row['time'] . "</option>";
                            //                              }
                            //
                            //
                            //                              ?>
                            <!--                              <script>-->
                            <!--                                  const picker = document.getElementById('frm_date_str');-->
                            <!--                                  picker.addEventListener('input', function(e){-->
                            <!--                                      var day = new Date(this.value).getUTCDay();-->
                            <!--                                      if([6,0].includes(day)){-->
                            <!--                                          e.preventDefault();-->
                            <!--                                          this.value = '';-->
                            <!--                                          alert('ปิดทำการวันเสาร์-อาทิตย์ กรุณาเลือกวัน-เวลาราชการ');-->
                            <!--                                      }-->
                            <!--                                  });-->
                            <!--                              </script>-->
                            <!--                          </select>-->
                            <!--                      </div>-->
                            <!--                    <input class="form-control" type="time" name="frm_date_end" id="frm_date_end" />-->
                        </div>

                        <div class="form-group mt-1" style="text-align: left">
                            <div class="col-sm-10" style="font-size: 13px;">
                                เงื่อนไข<br>
                                1. กรุณาป้อนข้อมูลให้ครบทุกช่อง เพื่อความสะดวกในการดำเนินการ<br>
                                2. กรุณาใช้คำที่สุภาพและไม่เป็นการหมิ่นประมาท ใส่ร้ายผู้อื่น<br>
                                3. ทางทีมงานขอสงวนสิทธิ์ในการลบข้อความไม่เหมาะสมใดๆโดยมิต้องแจ้งล่วงหน้า<br>
                                **รายละเอียดและชื่อของท่านจะไม่ถูกเปิดเผย <br>
                                ข้าพเจ้าขอยืนยันข้อความทั้งหมดเป็นความจริง <br>
                            </div>
                        </div>

                        <div class="col-4" style="margin:2% auto;">
                            <ul class="actions">
                                <input class="form-control bg-primary" type="submit" name="Submit" value="ยืนยัน"
                                       class="primary"/></li>
                                <input class="form-control bg-warning" type="reset" value="ล้างข้อมูล"/></li>
                            </ul>
                        </div>
                </div>
                </form>
            </div>
        </div>
        <!--        <div class="col-10 col-10-xsmall" style="margin:2% auto">-->
        <!--            <h3>คิวจองวันที่ --><?php //echo thaidate(date('Y,m,d')) ?><!--</h3>-->
        <!--        </div>-->
        <!--        <table id="example" class="table table-striped table-bordered col-12" style="width:100%">-->
        <!--            <thead>-->
        <!--            <tr>-->
        <!--                <th>ลำดับ</th>-->
        <!--                <th>ชื่อผู้จอง</th>-->
        <!--                <th>วันที่</th>-->
        <!--                <th>เวลา</th>-->
        <!--            </tr>-->
        <!--            </thead>-->
        <!--            <tbody>-->
        <!---->
        <!--            --><?php
        //            $sql = "SELECT * FROM tb_queue WHERE start_date = CURRENT_DATE ORDER BY id DESC";
        //            $rs = rsQuery($sql);
        //            $n=1;
        //
        //            while ($row = mysqli_fetch_array($rs)){
        //                $status = FindRS("select * from tb_status where id=".$row['status'],"status");
        //                echo '<tr>
        //                              <td style="width:10%">'.$n.'</td>
        //                              <td style="width:50%">'.$row["name"].'</td>
        //                              <td style="width:10%">'.thaidate($row["start_date"]).'</td>
        //                              <td style="width:10%">'.$row["end_date"].'</td>
        //                     </tr>';
        //                $n++;
        //            }
        //            ?>
        <!---->
        <!--            </tbody>-->
        <!--        </table>-->
        <!--        <div class="col-10 col-10-xsmall" style="margin:2% auto">-->
        <!--            <h3>คิวจองวันที่ -->
        <?php //$date = strtotime("+1 day"); echo thaidate(date('Y,m,d', $date)); ?><!--</h3>-->
        <!--        </div>-->
        <!--        <table id="example" class="table table-striped table-bordered col-12" style="width:100%">-->
        <!--            <thead>-->
        <!--            <tr>-->
        <!--                <th>ลำดับ</th>-->
        <!--                <th>ชื่อผู้จอง</th>-->
        <!--                <th>วันที่</th>-->
        <!--                <th>เวลา</th>-->
        <!--            </tr>-->
        <!--            </thead>-->
        <!--            <tbody>-->
        <!---->
        <!--            --><?php
        //            $sql = "SELECT * FROM tb_queue WHERE start_date = curdate()+interval 1 day ORDER BY id DESC";
        //            $rs = rsQuery($sql);
        //            $n=1;
        //
        //            while ($row = mysqli_fetch_array($rs)){
        //                $status = FindRS("select * from tb_status where id=".$row['status'],"status");
        //                echo '<tr>
        //                              <td style="width:10%">'.$n.'</td>
        //                              <td style="width:50%">'.$row["name"].'</td>
        //                              <td style="width:10%">'.thaidate($row["start_date"]).'</td>
        //                              <td style="width:10%">'.$row["end_date"].'</td>
        //                     </tr>';
        //                $n++;
        //            }
        //            ?>
        <!---->
        <!--            </tbody>-->
        <!--        </table>-->
        <!--        <div class="col-10 col-10-xsmall" style="margin:2% auto">-->
        <!--            <h3>คิวจองวันที่ -->
        <?php //$date = strtotime("+2 day"); echo thaidate(date('Y,m,d', $date)); ?><!--</h3>-->
        <!--        </div>-->
        <!--        <table id="example" class="table table-striped table-bordered col-12" style="width:100%">-->
        <!--            <thead>-->
        <!--            <tr>-->
        <!--                <th>ลำดับ</th>-->
        <!--                <th>ชื่อผู้จอง</th>-->
        <!--                <th>วันที่</th>-->
        <!--                <th>เวลา</th>-->
        <!--            </tr>-->
        <!--            </thead>-->
        <!--            <tbody>-->
        <!---->
        <!--            --><?php
        //            $sql = "SELECT * FROM tb_queue WHERE start_date = curdate()+interval 2 day ORDER BY id DESC";
        //            $rs = rsQuery($sql);
        //            $n=1;
        //
        //            while ($row = mysqli_fetch_array($rs)){
        //                $status = FindRS("select * from tb_status where id=".$row['status'],"status");
        //                echo '<tr>
        //                              <td style="width:10%">'.$n.'</td>
        //                              <td style="width:50%">'.$row["name"].'</td>
        //                              <td style="width:10%">'.thaidate($row["start_date"]).'</td>
        //                              <td style="width:10%">'.$row["end_date"].'</td>
        //                     </tr>';
        //                $n++;
        //            }
        //            ?>
        <!---->
        <!--            </tbody>-->
        <!--        </table>-->
        <!--        <div class="col-10 col-10-xsmall" style="margin:2% auto">-->
        <!--            <h3>คิวจองวันที่ -->
        <?php //$date = strtotime("+3 day"); echo thaidate(date('Y,m,d', $date)); ?><!--</h3>-->
        <!--        </div>-->
        <!--        <table id="example" class="table table-striped table-bordered col-12" style="width:100%">-->
        <!--            <thead>-->
        <!--            <tr>-->
        <!--                <th>ลำดับ</th>-->
        <!--                <th>ชื่อผู้จอง</th>-->
        <!--                <th>วันที่</th>-->
        <!--                <th>เวลา</th>-->
        <!--            </tr>-->
        <!--            </thead>-->
        <!--            <tbody>-->
        <!---->
        <!--            --><?php
        //            $sql = "SELECT * FROM tb_queue WHERE start_date = curdate()+interval 3 day ORDER BY id DESC";
        //            $rs = rsQuery($sql);
        //            $n=1;
        //
        //            while ($row = mysqli_fetch_array($rs)){
        //                $status = FindRS("select * from tb_status where id=".$row['status'],"status");
        //                echo '<tr>
        //                              <td style="width:10%">'.$n.'</td>
        //                              <td style="width:50%">'.$row["name"].'</td>
        //                              <td style="width:10%">'.thaidate($row["start_date"]).'</td>
        //                              <td style="width:10%">'.$row["end_date"].'</td>
        //                     </tr>';
        //                $n++;
        //            }
        //            ?>
        <!---->
        <!--            </tbody>-->
        <!--        </table>-->
        <!--        <div class="col-10 col-10-xsmall" style="margin:2% auto">-->
        <!--            <h3>คิวจองวันที่ -->
        <?php //$date = strtotime("+4 day"); echo thaidate(date('Y,m,d', $date)); ?><!--</h3>-->
        <!--        </div>-->
        <!--        <table id="example" class="table table-striped table-bordered col-12" style="width:100%">-->
        <!--            <thead>-->
        <!--            <tr>-->
        <!--                <th>ลำดับ</th>-->
        <!--                <th>ชื่อผู้จอง</th>-->
        <!--                <th>วันที่</th>-->
        <!--                <th>เวลา</th>-->
        <!--            </tr>-->
        <!--            </thead>-->
        <!--            <tbody>-->
        <!---->
        <!--            --><?php
        //            $sql = "SELECT * FROM tb_queue WHERE start_date = curdate()+interval 4 day ORDER BY id DESC";
        //            $rs = rsQuery($sql);
        //            $n=1;
        //
        //            while ($row = mysqli_fetch_array($rs)){
        //                $status = FindRS("select * from tb_status where id=".$row['status'],"status");
        //                echo '<tr>
        //                              <td style="width:10%">'.$n.'</td>
        //                              <td style="width:50%">'.$row["name"].'</td>
        //                              <td style="width:10%">'.thaidate($row["start_date"]).'</td>
        //                              <td style="width:10%">'.$row["end_date"].'</td>
        //                     </tr>';
        //                $n++;
        //            }
        //            ?>
        <!---->
        <!--            </tbody>-->
        <!--        </table>-->
        <!--        </div>-->
    </div>
</section>

<script type="text/javascript">
    jQuery('#datetimepicker').datetimepicker();

    function checkID(id) {
        var cid = id.replace(/-/g, '');
        if (cid.length != 13) return false;
        for (i = 0, sum = 0; i < 12; i++)
            sum += parseFloat(cid.charAt(i)) * (13 - i);
        if ((11 - sum % 11) % 10 != parseFloat(cid.charAt(12)))
            return false;
        return true;
    }

    function validate() {

        if (document.myForm.frm_name.value == "") {
            alert("กรุณากรอก ชื่อ-สกุล!");
            document.myForm.frm_name.focus();
            return false;
        }
        if (document.myForm.frm_tel.value == "") {
            alert("กรุณากรอก เบอร์โทรศัพท์ !");
            document.myForm.frm_tel.focus();
            return false;
        }
        // if( document.myForm.frm_email.value == "" ) {
        //    alert( "กรุณากรอก อีเมล!" );
        //    document.myForm.frm_email.focus() ;
        //    return false;
        // }
        // if( document.myForm.frm_province.value == "" ) {
        //    alert( "กรุณาเลือก จังหวัด!" );
        //    document.myForm.frm_province.focus() ;
        //    return false;
        // }
        // if( document.myForm.frm_amphur.value == "" ) {
        //    alert( "กรุณาเลือก อำเภอ!" );
        //    document.myForm.frm_amphur.focus() ;
        //    return false;
        // }
        // if( document.myForm.frm_district.value == "" ) {
        //    alert( "กรุณาเลือก ตำบล!" );
        //    document.myForm.frm_district.focus() ;
        //    return false;
        // }
        // if( document.myForm.frm_moo.value == "" ) {
        //    alert( "กรุณากรอก หมู่ที่!" );
        //    document.myForm.frm_moo.focus() ;
        //    return false;
        // }
        // if( document.myForm.frm_numhome.value == "" ) {
        //    alert( "กรุณากรอก บ้านเลขที่!" );
        //    document.myForm.frm_numhome.focus() ;
        //    return false;
        // }
        if (document.myForm.frm_number.value == "") {
            alert("กรุณากรอก เลขบัตรประชาชน!");
            document.myForm.frm_number.focus();
            return false;
        } else {
            if (!checkID(document.myForm.frm_number.value)) {
                alert('รหัสประชาชนไม่ถูกต้อง');
                document.myForm.frm_number.focus();
                return false;
            }
        }
        // if( document.myForm.frm_date_str.value == "" ) {
        //    alert( "กรุณาเลือก วันที่มารับ!" );
        //    document.myForm.frm_date_str.focus() ;
        //    return false;
        // }
        // if( document.myForm.frm_date_end.value == "" ) {
        //    alert( "กรุณาเลือก วันที่นำส่งคืน!" );
        //    document.myForm.frm_date_end.focus() ;
        //    return false;
        // }
        // if( document.myForm.frm_for.value == "" ) {
        //    alert( "กรุณากรอก จุดประสงค์ในการใช้งาน!" );
        //    document.myForm.frm_for.focus() ;
        //    return false;
        // }
        // if( document.myForm.frm_location.value == "" ) {
        //    alert( "กรุณากรอก สถานที่ในการรับบริการ!" );
        //    document.myForm.frm_location.focus() ;
        //    return false;
        // }


        return (true);
    }

</script>


<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDg49SZLUZdLu8KQ80fEAPJkbdBUqyN-vw&callback=initMap&libraries=places"></script>
<script>
    function initMap() {
        myLatLng = {lat: <?php echo $lat_main; ?>, lng: <?php echo $lng_main; ?>};
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

            document.getElementById("frm_lat").value = lat.toFixed(5);
            document.getElementById("frm_lng").value = lng.toFixed(5);

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

            document.getElementById("frm_lat").value = item_lat.toFixed(5);
            document.getElementById("frm_lng").value = item_lng.toFixed(5);

            google.maps.event.addListener(marker, 'dragend', function () {
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
    $(document).ready(function () {
        $('#frm_province').change(function () {
            $.ajax({
                type: 'POST',
                data: {data: $(this).val()},
                url: 'modules/test/select.php',
                success: function (data) {
                    $('#frm_amphur').html(data);
                }
            });
            return false;
        });

        $('#frm_amphur').change(function () {
            $.ajax({
                type: 'POST',
                data: {data2: $(this).val()},
                url: 'modules/test/select.php',
                success: function (data) {
                    $('#frm_district').html(data);
                }
            });
            return false;
        });

    });
</script>


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
