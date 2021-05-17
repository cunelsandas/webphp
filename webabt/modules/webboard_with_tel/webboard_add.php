<center>
    <style>
        td {
            color: black;
        }
    </style>
    <?php
    session_start();
    if (isset($_POST['btwb'])) {
        $chkver = $_SESSION['vervalue'];
        if ($chkver <> $_POST['txtver']) {
            echo "<p style='color: red'>คุณกรอกรหัสยืนยันไม่ตรงกับภาพ กรุณาพิมพ์ให้ตรงกับภาพ</p>";
        } else {
            $dt = date("Y-m-d H:i:s");
            $dt2 = date("Y-m-d");
            $subject = EscapeValue($_POST['txtsubject']);
            $detail1 = EscapeValue($_POST['txtdetail1']);
            $postby = EscapeValue($_POST['txtnamepost']);
            $telephone = EscapeValue($_POST['txttel']);
            $email = EscapeValue($_POST['txtemail']);

            $sql = "INSERT INTO tb_wb_mas(subject,detail,postby,telephone,email,datepost,ip,status,deleted,createdate) Values('$subject','$detail1','$postby','$telephone','$email','$dt2','" . $_SERVER['REMOTE_ADDR'] . "','1','0','$dt')";
            $rs = rsQuery($sql);
            if ($rs) {
                echo "<script>alert('บันทึกข้อมูลเรียบร้อย');window.location.href='index.php?_mod=" . $_GET['_mod'] . "';</script>";
            }
        }
    }
    ?>

    <form name="frmnews" method="POST" action="" enctype="multipart/form-data">
        <table class="content-input">
            <tr>
                <td width="20%">ชื่อเรื่อง*</td>
                <td width="80%" align=left><input type="text" name="txtsubject" id="txtsubject" size="50" required  oninvalid="this.setCustomValidity('โปรดกรอกชื่อเรื่อง')"
                                                  oninput="setCustomValidity('')"/></td>
            </tr>

            <input type="hidden" name="dateInput" id="dateInput" value="<?php echo date("Y-m-d"); ?>"/>

            <tr>
                <td>รายละเอียด*</td>
                <td align=left><textarea name="txtdetail1" class="txtarea" cols=50 rows=5 id="txtdetail1"></textarea>
                </td>
            </tr>
            <tr>
                <td>ชื่อ*</td>
                <td align=left><input type="text" name="txtnamepost" size="30" id="txtnamepost" required oninvalid="this.setCustomValidity('โปรดกรอกชื่อ')"
                                      oninput="setCustomValidity('')"/></td>
            </tr>
            <tr>
                <td>เบอร์โทรศัพท์</td>
                <td align=left><input type="text" name="txttel" size="30" id="txttel" oninvalid="this.setCustomValidity('โปรดกรอกเบอร์โทรศัพท์')"
                                      oninput="setCustomValidity('')" required/></td>
            </tr>
            <tr>
                <td>อีเมล</td>
                <td align=left><input type="text" name="txtemail" size="30" id="txtemail"/></td>
            </tr>
            <tr>
                <td valign="top" align="right">ป้อนรหัสยืนยัน :</td>
                <td>เงื่อนไข<br>
                    1. กรุณาป้อนข้อมูลให้ครบทุกช่อง มิฉะนั้นจะไม่สามารถบันทึกได้<br>
                    2. กรุณาใช้คำที่สุภาพและไม่เป็นการหมิ่นประมาท ใส่ร้ายผู้อื่น<br>
                    3. ทางทีมงานขอสงวนสิทธิ์ในการลบข้อความไม่เหมาะสมใดๆโดยมิต้องแจ้งล่วงหน้า <br>
                    ข้าพเจ้าขอยืนยันที่จะปฏิบัติตามเงื่อนไข <br>
                    <img src="itgmod/verify_image.php">(กรุณาพิมพ์อักษรให้เหมือนดังภาพ)<br>
                    <input type="text" name="txtver">
                </td>
            </tr>

            <tr>
                <td></td>
                <td align="left"><input class="bt" type="submit" name="btwb" value="บันทึก"
                                        onclick="return checkdetail();"/></td>
            </tr>
        </table>
        <center>
            <A HREF="javascript:history.back()">ย้อนกลับ</A>
        </center>
    </form>
</center>
<BR><BR>
