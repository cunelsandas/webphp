<style>
    input[type=text], input[type=number] {
        width: 200px;
        padding: 5px;
    }
</style>
<?php

$folder="welfare";
$folderupload= "../fileupload"."/".$folder."/";

/*$id = $_GET['id'];
$sql = "select * from tb_citizen where id=1";
$rs = rsQuery($sql);

// แสดงข้อมูลจากไฟล์ persondata.php
if (mysqli_num_rows($rs) > 0) {
    $data = mysqli_fetch_assoc($rs);
    $id = $data['id'];
    $personid = $data['personid'];
    $password = $data['password'];
    $name = $data['name'];
    $surname = $data['surname'];
    $prename = $data['prename'];
    $birthdate = ChangeYear($data['birthdate'], "th");
    $calage = calage(strtotime($data['birthdate']), time());
    $nationality = $data['nationality'];
    $address = $data['address'];
    $moo = $data['moo'];
    $soi = $data['soi'];
    $road = $data['road'];
    $telephone = $data['telephone'];
    $maritalstatus = $data['maritalstatus'];
    $occupation = $data['occupation'];
    $income = $data['income'];
    $welfare_older = $data['welfare_older'];
    $welfare_handicap = $data['welfare_handicap'];
    $welfare_aids = $data['welfare_aids'];
    $newcitizendate = $data['newcitizendate'];
    $bankname = $data['bankname'];
    $bankbranch = $data['bankbranch'];
    $bankaccount = $data['bankaccount'];
    $bankaccountname = $data['bankaccountname'];
    $status_edit = $data['status_edit'];
    $registerdate = $data['registerdate'];
    $name2 = $data['name2'];
    $personid2 = $data['personid2'];
    $address2 = $data['address2'];
    $relationship = $data['relationship'];
    $telephone2 = $data['telephone2'];

    $handicap_eye = $data['handicap_eye'];
    $handicap_ear = $data['handicap_ear'];
    $handicap_body = $data['handicap_body'];
    $handicap_mind = $data['handicap_mind'];
    $handicap_brain = $data['handicap_brain'];
    $handicap_learn = $data['handicap_learn'];
    $handicap_ortistic = $data['handicap_ortistic'];

    $chkolder = ($welfare_older == 1 ? checked : "");
    $chkhandicap = ($welfare_handicap == 1 ? checked : "");
    $chkaids = ($welfare_aids == 1 ? checked : "");

    $chkhandicap_eye = ($handicap_eye == 1 ? checked : "");
    $chkhandicap_ear = ($handicap_ear == 1 ? checked : "");
    $chkhandicap_body = ($handicap_body == 1 ? checked : "");
    $chkhandicap_mind = ($handicap_mind == 1 ? checked : "");
    $chkhandicap_brain = ($handicap_brain == 1 ? checked : "");
    $chkhandicap_learn = ($handicap_learn == 1 ? checked : "");
    $chkhandicap_ortistic = ($handicap_ortistic == 1 ? checked : "");

}*/

if (isset($_POST['btsave'])) {
//	$id=$_POST['txtid'];
    $personid = $_POST['txtpersonid'];
    $name = $_POST['txtname'];
    $surname = $_POST['txtsurname'];
    $prename = $_POST['cboprename'];
    $otherprename = $_POST['txtotherprename'];
    $birthdate = ChangeYear($_POST['txtbirthdate'], "en");
    $nationality = $_POST['txtnationality'];
    $address = $_POST['txtaddress'];
    $moo = $_POST['cbomoo'];
    $soi = $_POST['txtsoi'];
    $road = $_POST['txtroad'];
    $telephone = $_POST['txttelephone'];
    $tambol = "1";
    $amphur = "1";
    $province = "1";
    $postcode = "1";
    $maritalstatus = $_POST['cbomaritalstatus'];
    $occupation = $_POST['txtoccupation'];
    $income = (!empty($_POST['txtincome']) ? $_POST['txtincome'] : 0);
    $welfare_older = ($_POST['chkwelfare_older'] == 1 ? 1 : 0);
    $welfare_handicap = ($_POST['chkwelfare_handicap'] == 1 ? 1 : 0);
    $welfare_aids = ($_POST['chkwelfare_aids'] == 1 ? 1 : 0);
    $newcitizendate = (empty($_POST['txtnewcitizendate']) ? "" : ChangeYear($_POST['txtnewcitizendate'], "en"));
    $bankname = $_POST['cbobankname'];
    $bankbranch = $_POST['txtbankbranch'];
    $bankaccount = $_POST['txtbankaccount'];
    $bankaccountname = $_POST['txtbankaccountname'];
    $name2 = $_POST['txtname2'];
    $personid2 = (!empty($_POST['txtpersonid2']) ? $_POST['txtpersonid2'] : null);
    $address2 = $_POST['txtaddress2'];
    $relationship = $_POST['cborelationship'];
    $telephone2 = $_POST['txttelephone2'];

    $handicap_eye = ($_POST['chkhandicap_eye'] == 1 ? 1 : 0);
    $handicap_ear = ($_POST['chkhandicap_ear'] == 1 ? 1 : 0);
    $handicap_body = ($_POST['chkhandicap_body'] == 1 ? 1 : 0);
    $handicap_mind = ($_POST['chkhandicap_mind'] == 1 ? 1 : 0);
    $handicap_brain = ($_POST['chkhandicap_brain'] == 1 ? 1 : 0);
    $handicap_learn = ($_POST['chkhandicap_learn'] == 1 ? 1 : 0);
    $handicap_ortistic = ($_POST['chkhandicap_ortistic'] == 1 ? 1 : 0);
    $registerdate = date('Y-m-d h:i:s');
    $status_edit = "0";
    $status = $_POST['cbostatus'];
    $sql = "insert into tb_citizen (personid,prename,otherprename,name,surname,birthdate,nationality,address,moo,soi,road,tambol,amphur,province,postcode,telephone,maritalstatus,income,occupation,welfare_older,welfare_handicap,welfare_aids,newcitizendate,bankname,bankbranch,bankaccount,bankaccountname,name2,personid2,address2,relationship,telephone2,handicap_eye,handicap_ear,handicap_body,handicap_mind,handicap_brain,handicap_learn,handicap_ortistic,registerdate,status_edit,status) values('$personid','$prename','$otherprename','$name','$surname','$birthdate','$nationality','$address','$moo','$soi','$road','$tambol','$amphur','$province','$postcode','$telephone','$maritalstatus','$income','$occupation','$welfare_older','$welfare_handicap','$welfare_aids','$newcitizendate','$bankname','$bankbranch','$bankaccount','$bankaccountname','$name2','$personid2','$address2','$relationship','$telephone2','$handicap_eye','$handicap_ear','$handicap_body','$handicap_mind','$handicap_brain','$handicap_learn','$handicap_ortistic','$registerdate','$status_edit','$status')";

    $rs = rsQuery($sql);
    if ($rs) {
        $id = FindRS("select id from tb_citizen Order by id DESC limit 0,1", "id");
        $file = array();
        $size = array();
        $type = array();
        $images = array();
        $newfile = array();
        $postname = array("file_personcard", "file_address", "file_bank", "file_authrority", "file_authrority_personcard", "file_authrority_address", "file_handicap", "file_aids");
        // วนรับค่าจาก control
        for ($i = 0; $i <= 7; $i++) {
            //	$file[$i]=$_FILES['file'.$i]['name'];
            $file[$i] = $_FILES[$postname[$i]]['name'];
            $size[$i] = $_FILES[$postname[$i]]['size'];
            $type[$i] = strtolower(substr($file[$i], -4));
            $images[$i] = $_FILES[$postname[$i]]['tmp_name'];
            //วนเช็ค file type
            $x = $i + 1;
            $strCheckFile = CheckFileUpload($file[$i], $size[$i], $limitsize, $SizeInMb, $x);
            if ($strCheckFile[0] == "no") {
                echo $strCheckFile[1];
                exit();
            } else {

                if ($file[$i] <> "") {
                    $newfile[$i] = $tablename . '_' . $id . "_" . $postname[$i] . $type[$i];

                    $chkimage = isImage($images[$i]);  // เช็คว่าเป็นไฟล์รูป ถ้าเป็น
                    if ($chkimage == "image") {
                        $uploadimage = resizeimage($images[$i], $newfile[$i], $folderupload, $domainname, '0', 'false');
                    }
                    if ($chkimage == "no") {  //ถ้าไม่ใช่ไฟล์รูปให้copy
                        copy($images[$i], $_SERVER['DOCUMENT_ROOT'] . $folderupload . $newfile[$i]);  // สั่งให้ copy รูปจาก temp ไปยัง พาท ที่เราต้องการ
                    }

                    $filename = "INSERT INTO filename(tablename,masterid,filename) Values('" . $tablename . "','" . $id . "','" . $newfile[$i] . "')";
                    $uppicname = rsQuery($filename);


                }

            }
        }


        echo "<script>alert('บันทึกข้อมูลแล้ว');window.location.href='main.php?_modid=" . $modid . "&_mod=" . $_GET['_mod'] . "&type=persondata'</script>";

    }
}
?>
<link type="text/css" href="css/jquery-ui-1.8.10.custom.css" rel="stylesheet"/>
<script type="text/javascript" src="js/jquery-1.4.4.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.10.offset.datepicker.min.js"></script>
<style type="text/css">
    .ui-datepicker {
        width: 200px;
        font-family: tahoma;
        font-size: 11px;
        text-align: center;
    }
</style>
<script>
    $(function () {
        var d = new Date();
        var toDay = (d.getFullYear() + 543) + '-' + (d.getMonth() + 1) + '-' + d.getDate();

        $("#txtbirthdate").datepicker({
            showOn: 'focus',
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd',
            isBuddhist: true,
            defaultDate: toDay,
            dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
            dayNamesMin: ['อา.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.'],
            monthNames: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
            monthNamesShort: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.']
        });


        $("#txtnewcitizendate").datepicker({
            showOn: 'focus',
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd',
            isBuddhist: true,
            defaultDate: toDay,
            dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัสบดี', 'ศุกร์', 'เสาร์'],
            dayNamesMin: ['อา.', 'จ.', 'อ.', 'พ.', 'พฤ.', 'ศ.', 'ส.'],
            monthNames: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
            monthNamesShort: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.']
        });


    });

</script>
<div class="content-input" style="width:90%;">
    <form name="frmData" method="POST" action="" enctype="multipart/form-data">
        <div align="left"><input type="hidden" name="txtid" value="<?php echo $id; ?>">

            <br>
            <fieldset>
                <table width='90%'>
                    <legend>กำหนกรหัสและสิทธิ</legend>
                    <tr>
                        <td>
                            สถานะ
                        </td>
                        <td>
                            <select name="cbostatus">
                                <?php
                                $sqlmoo = "select * from tb_citizen_status order by id";
                                $rsmoo = rsQuery($sqlmoo);
                                if ($rsmoo) {
                                    while ($dmoo = mysqli_fetch_assoc($rsmoo)) {
                                        $mooid = $dmoo['id'];
                                        $mooname = $dmoo['name'];
                                        if ($mooid == $status) {
                                            echo "<option value='$mooid' selected>$mooname</option>";
                                        } else {
                                            echo "<option value='$mooid'>$mooname</option>";
                                        }
                                    }
                                }
                                ?>
                            </select>
                            &nbsp;&nbsp;&nbsp;&nbsp;แก้ไขข้อมูลตนเอง&nbsp;<select name="cbostatus_edit">
                                <option value="0" >อนุญาตให้แก้ไขข้อมูล</option>
                                <option value="1" >ไม่อนุญาตให้แก้ไขข้อมูล</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            เลขบัตรประชาชน
                        </td>
                        <td><input type="text" name="txtpersonid" placeholder="เลขบัตรประชาชน ตัวเลขเท่านั้น"
                                   maxlength="13">
                            &nbsp;รหัสผ่าน<input type="text" name="txtpassword"></td>
                    </tr>
                    <tr>
                        <td colspan='2'>เลขบัตรประชาชนใช้เป็น user name สำหรับเข้าระบบ
                            <br>แก้ไขข้อมูลตนเอง หากไม่อนุญาต ผู้ลงทะเบียนจะไม่สามารถแก้ไขข้อมูลส่วนบุคคลได้เองหน้าเว็บ
                        </td>
                    </tr>
                </table>
            </fieldset>
            <br>
            <fieldset>
                <legend>ข้อมูลส่วนบุคคล</legend>
                <br>
                <label>วันที่สมัครใช้งานระบบ :
                    <?php echo DateTimeThai(date('Y-m-d h:i:s')); ?>
                </label>
                <table>

                    <tr>
                        <td>
                            คำนำหน้าชื่อ
                        </td>
                        <td><select name="cboprename" onchange="otherPrename(this.value);">
                                <option value='0'>คำนำหน้าชื่อ</option>
                                <?php
                                $sqlmoo = "select * from tb_prename order by id";
                                $rsmoo = rsQuery($sqlmoo);
                                if ($rsmoo) {
                                    while ($dmoo = mysqli_fetch_assoc($rsmoo)) {
                                        $mooid = $dmoo['id'];
                                        $mooname = $dmoo['name'];
                                        if ($mooid == $prename) {
                                            echo "<option value='$mooid' selected>$mooname</option>";
                                        } else {
                                            echo "<option value='$mooid'>$mooname</option>";
                                        }
                                    }
                                }
                                ?>
                            </select>&nbsp;
                            ระบุ&nbsp;<input type="text" name="txtotherprename" id="txtotherprename"
                                             style="visibility:hidden;" placeholder="ระบุ คำนำหน้าชื่อ">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            ชื่อ
                        </td>
                        <td><input type="text" name="txtname" id="txtname" placeholder="ชื่อ"
                                   value=""></td>
                    </tr>
                    <tr>
                        <td>

                            นามสกุล
                        </td>
                        <td><input type="text" name="txtsurname" id="txtsurname" placeholder="นามสกุล"
                                   value="">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            วันเกิด
                        </td>
                        <td><input type="text" name="txtbirthdate" id="txtbirthdate" placeholder="วันเกิด"
                                   value="" onchange="calAge(this.value,'calage');"><span
                                    id='calage'>&nbsp;อายุ :&nbsp;</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            สัญชาติ
                        </td>
                        <td><input type="text" name="txtnationality" id="txtnationality" placeholder="สัญญาติ"
                                   value="">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            ที่อยู่
                        </td>
                        <td><input type="text" name="txtaddress" id="txtaddress" placeholder="บ้านเลขที่"
                                   value="">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            หมู่
                        </td>
                        <td><select name="cbomoo">
                                <option value="0">เลือก</option>
                                <?php
                                $sqlmoo = "select * from tb_moo order by name";
                                $rsmoo = rsQuery($sqlmoo);
                                if ($rsmoo) {
                                    while ($dmoo = mysqli_fetch_assoc($rsmoo)) {
                                        $mooid = $dmoo['id'];
                                        $mooname = $dmoo['name'];
                                        if ($mooid == $moo) {
                                            echo "<option value='$mooid' selected>$mooname</option>";
                                        } else {
                                            echo "<option value='$mooid'>$mooname</option>";
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            ซอย
                        </td>
                        <td><input type="text" name="txtsoi" placeholder="ซอย / ชุมชน" value=""></td>
                    </tr>
                    <tr>
                        <td>ถนน</td>
                        <td><input type="text" name="txtroad" placeholder="ถนน" value="">
                        </td>
                    </tr>
                    <tr>
                        <td colspan='2'>
                            <label>ตำบล<?php echo $customer_tambon . "&nbsp;อำเภอ" . $customer_amphur . "&nbsp;จังหวัด" . $customer_province; ?></label>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            หมายเลขโทรศัพท์
                        </td>
                        <td><input type="text" name="txttelephone" placeholder="หมายเลขโทรศัพท์ ตัวเลขเท่านั้น"
                                   value="">
                        </td>
                    </tr>
                    <tr>
                        <td>

                            สถานภาพการสมรส
                        </td>
                        <td><select name="cbomaritalstatus">
                                <option value='0'>สถานภาพสมรส</option>
                                <?php
                                $sqlmoo = "select * from tb_maritalstatus order by id";
                                $rsmoo = rsQuery($sqlmoo);
                                if ($rsmoo) {
                                    while ($dmoo = mysqli_fetch_assoc($rsmoo)) {
                                        $mooid = $dmoo['id'];
                                        $mooname = $dmoo['name'];
                                        if ($mooid == $maritalstatus) {
                                            echo "<option value='$mooid' selected>$mooname</option>";
                                        } else {
                                            echo "<option value='$mooid'>$mooname</option>";
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            อาชีพ
                        </td>
                        <td><input type="text" name="txtoccupation" placeholder="อาชีพ"
                                   value="">&nbsp;รายได้ต่อเดือน&nbsp;<input type="number"
                                                                                                       name="txtincome"
                                                                                                       placeholder="รายได้ต่อเดือน (ตัวเลขเท่านั้น)"
                                                                                                       value="">
                        </td>
                    </tr>
                    <tr>
                        <td colspan='2'>
                            &nbsp;<label>กรณีต้องการให้โอนเงิน กรุณาระบุชื่อธนาคาร สาขา เลขบัญชี และชื่อเจ้าของบัญชี
                        </td>
                    </tr>
                    <tr>
                        <td>ชื่อธนาคาร</td>
                        <td>
                            <select name="cbobankname">
                                <option value="0">เลือก</option>
                                <?php
                                $sqlmoo = "select * from tb_bankname order by id";
                                $rsmoo = rsQuery($sqlmoo);
                                if ($rsmoo) {
                                    while ($dmoo = mysqli_fetch_assoc($rsmoo)) {
                                        $mooid = $dmoo['id'];
                                        $mooname = $dmoo['name'];
                                        if ($mooid == $bankname) {
                                            echo "<option value='$mooid' selected>$mooname</option>";
                                        } else {
                                            echo "<option value='$mooid'>$mooname</option>";
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            ชื่อสาขา
                        </td>
                        <td><input type="text" name="txtbankbranch" placeholder="ชื่อสาขา"
                                   value="">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            เลขบัญชี
                        </td>
                        <td><input type="text" name="txtbankaccount" placeholder="เลขบัญชีธนาคาร"
                                   value="">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            ชื่อบัญชี
                        </td>
                        <td><input type="text" name="txtbankaccountname" placeholder="ชื่อบัญชี"
                                   value="">
                        </td>
                    </tr>
                </table>
            </fieldset>

            <br>

            <fieldset>
                <legend>บุคคลอ้างอิงที่สามารถติดต่อได้</legend>
                <table>
                    <tr>
                        <td>
                            ชื่อ-นามสกุล
                        </td>
                        <td><input type="text" name="txtname2" placeholder="ชื่อ-นามสกุล" value="">
                        </td>
                    </tr>
                    <tr>
                        <td>หมายเลขโทรศัพท์</td>
                        <td><input type="text" name="txttelephone2" placeholder="โทรศัพท์"
                                   value="">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            เลขบัตรประชาชน
                        </td>
                        <td><input type="text" name="txtpersonid2" placeholder="เลขประจำตัวประชาชน ของบุคคลอ้างอิง"
                                   maxlength="13" value="">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            ที่อยู่
                        </td>
                        <td><input type="text" name="txtaddress2"
                                   placeholder="ที่อยู่ผู้อ้างอิง บ้านเลขที่ ตำบล อำเภอ จังหวัด"
                                   value="">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            ความเกี่ยวข้อง
                        </td>
                        <td><select name="cborelationship">
                                <option value="0">เลือก</option>
                                <?php
                                $sqlmoo = "select * from tb_relationship order by id";
                                $rsmoo = rsQuery($sqlmoo);
                                if ($rsmoo) {
                                    while ($dmoo = mysqli_fetch_assoc($rsmoo)) {
                                        $mooid = $dmoo['id'];
                                        $mooname = $dmoo['name'];
                                        if ($mooid == $relationship) {
                                            echo "<option value='$mooid' selected>$mooname</option>";
                                        } else {
                                            echo "<option value='$mooid'>$mooname</option>";
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                </table>
            </fieldset>
            <br>
            <fieldset>
                <legend>สถานภาพการรับสวัสดิการภาครัฐ</legend>
                <br>
                &nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="chkwelfare_older"
                                               value="1" >&nbsp;เคยได้รับเบี้ยผู้สูงอายุ
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="checkbox" name="chkwelfare_handicap" value="1" >&nbsp;เคยได้รับเบี้ยผู้พิการ
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="checkbox" name="chkwelfare_aids" value="1" >&nbsp;เคยได้รับเบี้ยยังชีพผู้ป่วยเอดส์
                <br><br>
                <label>เคยได้รับ ย้ายภูมิลำเนาเข้ามาอยู่ใหม่ เมื่อวันที่<label>&nbsp;<input type="text"
                                                                                            name="txtnewcitizendate"
                                                                                            id="txtnewcitizendate"
                                                                                            value="">
            </fieldset>

            <br>
            <fieldset>
                <legend>สำหรับผู้พิการ</legend>

                ประเภทความพิการ (เลือกได้มากกว่า 1 ข้อ)
                <br>
                <table width='90%'>
                    <tr>
                        <td width='50%'>
                            <input type="checkbox" name="chkhandicap_eye" value="1">&nbsp;ความพิการทางการเห็น
                            <br><br>
                            <input type="checkbox" name="chkhandicap_ear" value="1">&nbsp;ความพิการทางการได้ยินหรือสื่อความหมาย
                            <br><br>
                            <input type="checkbox" name="chkhandicap_body" value="1" >&nbsp;ความพิการทางการเคลื่อนไหวหรือทางร่างกาย
                            <br><br>
                            <input type="checkbox" name="chkhandicap_mind" value="1" >&nbsp;ความพิการทางการจิตใจหรือพฤติกรรม
                        </td>
                        <td width='50%' valign='top'>

                            <input type="checkbox" name="chkhandicap_brain" value="1" >&nbsp;ความพิการทางสติปัญญา
                            <br><br>
                            <input type="checkbox" name="chkhandicap_learn" value="1" >&nbsp;ความพิการทางการเรียนรู้
                            <br><br>
                            <input type="checkbox" name="chkhandicap_ortistic"
                                   value="1">&nbsp;ความพิการทางออทิสติก
                            <br><br>
                        </td>
                    </tr>
                </table>
            </fieldset>
            <br>
            <fieldset>
                <legend>ส่งเอกสาร (ไฟล์ jpg หรือ pdf )</legend>
                <br>

                <input type="file" name="file_personcard"/>&nbsp;สำเนาบัตรประชาชน
                <br>

                <input type="file" name="file_address"/>&nbsp;สำเนาทะเบียนบ้าน
                <br>

                <input type="file" name="file_bank"/>&nbsp;สำเนาสมุดเงินฝาก บัญชีที่ต้องการให้โอนเงินเข้า
                <br>

                <input type="file" name="file_authrority"/>&nbsp; หนังสือมอบอำนาจ กรณีให้ผู้อื่นรับเงินแทน
                <br>
                <input type="file" name="file_authrority_personcard"/>&nbsp;สำเนาบัตรประชาชน ผู้รับมอบอำนาจ
                <br>

                <input type="file" name="file_authrority_address"/>&nbsp;สำเนาบัตรทะเบียนบ้านผู้รับมอบอำนาจ
                <br>

                <input type="file" name="file_handicap"/>&nbsp;(สำหรับผู้พิการ) สำเนาบัตรคนพิการ
                <br>

                <input type="file" name="file_aids"/>&nbsp; (สำหรับผู้ป่วยเอดส์) ใบรับรองแพทย์ ออกโดยสถานพยาบาลของรัฐ
                ยืนยันว่าป่วยเป็นโรคเอดส์จริง
                <br>
            </fieldset>
            <br>

            <br>

                <input type="submit" name="btsave" value="บันทึก">

    </form>
</div></div>

<script type="text/javascript" src="../js/js01.js"></script>

<script>
    function calAge(select_id, displayid) {
        var data = "select_id=" + select_id;
        var URL = "../itgmod/ajaxcalage.php";
        ajaxLoad("get", URL, data, displayid);
    }


    function checkdetail() {
        if (document.getElementById('txtpersonid').value == "" || document.getElementById('txtpassword').value == "" || document.getElementById('txtname').value == "" || document.getElementById('txtsurname').value == "") {
            alert("กรุณากรอกข้อมูลที่ให้ครบทุกช่อง!!!");
            return false;
        }
        return true;

    }

    function otherPrename(id) {
        var prenameid = id;
        if (prenameid == 6) {
            document.getElementById('txtotherprename').style.visibility = "visible";
        } else {
            document.getElementById('txtotherprename').style.visibility = "hidden";
            document.getElementById('txtotherprename').value = '';
        }
    }


</script>
