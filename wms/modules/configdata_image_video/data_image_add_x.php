<?php
//error_reporting(E_ALL); //สำหรับเช็ค error
//ini_set('error_reporting', E_ALL);
//ini_set('display_errors',1);

function localUpdate($sql, $domainname, $masterid, $foldername, $table)
{
    $server = "localhost";
    $user = "c2itglobal";
    $pw = '#itgl2546#';
    $db = "c2itglobal";
    $con = new mysqli($server, $user, $pw, $db);
    if ($sql == "") {
        return false;
    } else {
        $con->set_charset("utf8");

        $rs = $con->query($sql);
        if ($rs !== false) {
            //	$error=$con->error;
            return $rs;
        } else {
            $error = $con->error;
            return $error;
        }
    }
}

function localUpdateFilename($sql, $domainname, $table, $masterid)
{
    $server = "localhost";
    $user = "c2itglobal";
    $pw = '#itgl2546#';
    $db = "c2itglobal";
    $con = new mysqli($server, $user, $pw, $db);
    if ($sql == "") {
        return false;
    } else {
        $con->set_charset("utf8");

        $rs = $con->query($sql);
        if ($rs !== false) {
            //	$error=$con->error;
            return $rs;
        } else {
            $error = $con->error;
            return $error;
        }
    }
}

//////////////////////ADD-NEW///////////////////////////
function CreateArrayFile($File, $FileName, $dri)
{
    $exfile = [];
    $i = 1;
    foreach ($File as $key => $value) {
        $time = microtime(true);
        $time = explode('.', $time);
        $time = $time[0] . '_' . $time[1];
        foreach ($value as $id => $item) {
            if ($item == 'name' && $exfile[$key]['name'] != '') {
                $exten = explode('.', $exfile[$key]['name']);
                $exten[1] = pathinfo($exfile[$key]['name'], PATHINFO_EXTENSION);
                $exfile[$key]['name'] = $FileName . $time . '.' . $exten[1];
                move_uploaded_file($exfile[$key]['tmp_name'], $dri . $exfile[$key]['name']);
            }
            $exfile[$key][$id] = $item;
        }
        $i++;
    }
    return $exfile;
}

function CreateArrayFileImg($File, $FileName, $dri)
{
    $time = microtime(true);
    $time = explode('.', $time);
    $time = $time[0] . '_' . $time[1];
    $exFile = [];
    foreach ($File as $key => $item) {
        if ($item != '') {
            $item = explode(',', $item);
            $data = base64_decode($item[1]);
            $exten = explode('.', $item[2]);
            $exten = end($exten);
            $fileName = $FileName . $time . $key . '.' . $exten;
            $file = $dri . $fileName;
            $success = file_put_contents($file, $data);
            $exFile[$key]['name'] = $fileName;
        }
    }
    return $exFile;
}

function ChangeDate($_date, $_lang = '')
{
    $newDate = '';
    if ($_lang == 'th') {
        $_date = explode('/', $_date);
        $newDate = ($_date[2] - 543) . '-' . $_date[1] . '-' . $_date[0];
    } else {
        $_date = explode('-', $_date);
        $newDate = $_date[2] . '/' . $_date[1] . '/' . ($_date[0] + 543);
    }
    return $newDate;
}

//////////////////////ADD-NEW///////////////////////////

$file_no = ($gloActivity_fileno - 1);   // กำหนด array จำนวน file ที่ต้องการ  $glo...มาจากไฟล์ connect.ini.php
$limitsize = $gloPicture_filesize;  //กำหนกขนาดไฟล์ที่ต้องการให้อัพโหลด หารด้วย 1000  1k
$SizeInMb = round(($limitsize / $onemb));
$table = FindRS("select tablename from tb_mod where modid=$modid", "tablename");
$folder = FindRS("select foldername from tb_mod where modid=$modid", "foldername");
$foldername = "/" . $gloUploadPath . "/" . $folder . "/";
$content = "";
?>
<!--<link type="text/css" href="css/jquery-ui-1.8.10.custom.css" rel="stylesheet"/>-->
<link type="text/css" href="../js/datepicker-thai/datepicker.css" rel="stylesheet"/>
<link type="text/css" href="../js/uploadfile/fileupload.css" rel="stylesheet"/>
<?php $fileaa = ' <div data-num="1" data-watermark="' . $domainname . '" data-size="800" class="div-input-file"></div>'; ?>
<script src="../js/uploadfile/fileupload.js"></script>
<!-- datepicker thai year -->
<script type="text/javascript" src="../js/datepicker-thai/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="../js/datepicker-thai/bootstrap-datepicker.th.js"></script>
<script type="text/javascript" src="../js/datepicker-thai/bootstrap-datepicker-thai.js"></script>
<script src='../js/tinymce/tinymce.min.js'></script>
<script>
    tinymce.init({

        selector: '#mytextarea',
        theme: 'modern',
        width: 600,
        height: 300,
        plugins: [
            'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
            'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
            'save table contextmenu directionality emoticons template paste textcolor'
        ],

        toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons',

        images_upload_url: '../js/tinymce/tiny_upload_image.php',

        images_upload_credentials: true
    });
</script>
<?php
if (isset($_POST['btadd'])) {
    // วนรับค่าจาก control
//    for ($i = 0; $i <= $file_no; $i++) {
//        $file[$i] = $_FILES['file' . $i]['name'];
//        $size[$i] = $_FILES['file' . $i]['size'];
//        $type[$i] = strtolower(substr($file[$i], -4));
//        $images[$i] = $_FILES['file' . $i]['tmp_name'];
//    }
//    //วนเช็ค file type
//    for ($i = 0; $i <= $file_no; $i++) {
//        $x = $i + 1;
//        $strCheckFile = CheckFileUpload($file[$i], $size[$i], $limitsize, $SizeInMb, $x);
//        if ($strCheckFile[0] == "no") {
//            echo $strCheckFile[1];
//            exit();
//        }
//    }

    if ($_POST['active'] == "on") {
        $ac = "1";
    } else {
        $ac = "0";
    }
    $subject = EscapeValue($_POST['txtsubject']);
    $detail = $_POST['detail1'];
    $datepost = ChangeDate($_POST['dateInput'], "th");
    $ip = $_SERVER['REMOTE_ADDR'];
    $department = $_POST['cbodepartment'];
    $img_filter = $_POST['cbofilter'];
    $sql = "INSERT INTO $table(subject,detail1,detail2,datepost,ip,status,department,img_filter) Values('$subject','$detail','','$datepost','$ip','$ac','$department','$img_filter')";


    $rs = rsQuery($sql);
    if ($rs) {
        $sql1 = "Select * From $table Order by no DESC limit 0,1";
        $rss = rsQuery($sql1);
        $r = mysqli_fetch_assoc($rss);
        $id = $r['no'];

        //	$local_sql="INSERT INTO tb_local_feed(subject,detail1,detail2,datepost,ip,status,department,img_filter,domainname,masterid,foldername,tablename) Values('$subject','$detail','','$datepost','$ip','$ac','$department','$img_filter','$domainname','$id','$foldername','$table')";

        //	$local_update=localUpdate($local_sql,$domainname,$id,$foldername,$table);

        // loop insert ชื่อไฟล์และcopy ไฟล์
//        $newfile = array();
//        for ($i = 0; $i <= $file_no; $i++) {
//            $x = $i + 1;
//            if ($file[$i] <> "") {
//                $newfile[$i] = $table . '_' . $id . "_" . $x . $type[$i];
//
//                $chkimage = isImage($images[$i]);  // เช็คว่าเป็นไฟล์รูป ถ้าเป็น
//                if ($chkimage == "image") {
//                    $uploadimage = resizeimage($images[$i], $newfile[$i], $foldername, $domainname, '0', 'true');
//                }
//                if ($chkimage == "no") {  //ถ้าไม่ใช่ไฟล์รูปให้copy
//                    copy($images[$i], $_SERVER['DOCUMENT_ROOT'] . $foldername . $newfile[$i]);  // สั่งให้ copy รูปจาก temp ไปยัง พาท ที่เราต้องการ
//                }
//
//                $filename = "INSERT INTO filename(tablename,masterid,filename) Values('" . $table . "','" . $id . "','" . $newfile[$i] . "')";
//                $uppicname = rsQuery($filename);
//
//                //		$local_filename="INSERT INTO tb_local_filename(tablename,masterid,filename,domainname,foldername) Values('".$table."','".$id."','".$newfile[$i]."','$domainname','$foldername')";
//                //		$local_upload_filename=localUpdateFilename($local_filename,$domainname,$table,$id);
//
//            }
//        }


        $check = getimagesize($_FILES["frm_img"]["tmp_name"][0]);
        if ($check !== false) {


          $sqlsl = 'SELECT * FROM '.$table.' ORDER BY no DESC LIMIT 0,1';
          $rssl = rsQuery($sqlsl);
          $num = mysqli_fetch_array($rssl);
          $count = $num['no'];
          //$id = $num['no'];

          for ($i = 0; $i < count($_FILES['frm_img']['name']); $i++) {
                $filename = $_FILES["frm_img"]["name"][$i];
                $ext = end(explode(".", $filename));
                $newname = $table .'_'. $count .'_' .$i. '.' . $ext;
                $filetmp = $_FILES["frm_img"]["tmp_name"][$i];
                $filetype = $_FILES["frm_img"]["type"][$i];
                $filepath = "../".$foldername . $newname;



                //$images = $_FILES["fileUpload"]["tmp_name"];
                /*$new_images = "Thumbnails_".$_FILES["fileUpload"]["name"];
                copy($_FILES["fileUpload"]["tmp_name"],"MyResize/".$_FILES["fileUpload"]["name"]);
                $width=800;
                $size=GetimageSize($filetmp);
                $height=round($width*$size[1]/$size[0]);
                $images_orig = ImageCreateFromJPEG($filetmp);

                $height=round($width*$size[1]/$size[0]);
        				switch($filetype){
        					case "image/jpeg":
        						$images_orig = imagecreatefromjpeg($images);
        						break;
        					 case "image/gif":
        						$images_orig = imagecreatefromgif($images);
        						break;
        					case "image/png":
        						$images_orig = imagecreatefrompng($images);
        						break;
        				}


                $photoX = ImagesX($images_orig);
                $photoY = ImagesY($images_orig);

                $images_fin = ImageCreateTrueColor($width, $height);

                ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width+1, $height+1, $photoX, $photoY);
          				switch($filetype){
          					case "image/jpeg":
          						ImageJPEG($images_fin,$_SERVER['DOCUMENT_ROOT'].$foldername.$newfile);
          						break;
          					case "image/gif":
          						ImageGIF($images_fin,$_SERVER['DOCUMENT_ROOT'].$foldername.$newfile);
          						break;
          					case "image/png":
          						ImagePNG($images_fin,$_SERVER['DOCUMENT_ROOT'].$foldername.$newfile);
          						break;
          				}

                ImageJPEG($images_fin,"MyResize/".$new_images);

                ImageDestroy($images_orig);
                ImageDestroy($images_fin);*/




                //move_uploaded_file($filetmp, $filepath);

                if (move_uploaded_file($filetmp, $filepath)) {
                    $sql = "INSERT INTO filename(tablename,masterid,filename) Values('" . $table . "','" . $id . "','" . $newname . "')";
                    rsQuery($sql);
                    $Status = true;
                    echo "<script>alert('".$sql."');</script>";
                } else {
                    $Status = false;
                    echo "<script>alert('".$foldername."');</script>";
                }
            }

        }else {
          //echo "<script>alert('NULL');</script>";
        }



        // update table tb_trans บันทึกการเพิ่มข้อมูล
        $updatetran = UpdateTrans($table, 'add', $_SESSION['username'], 'ID:' . $id);
        echo "<script>alert('บันทึกข้อมูลเรียบร้อย');window.location.href='main.php?_modid=" . $modid . "&_mod=" . $_GET['_mod'] . "';</script>";


    }
}
?>

<form name="frmnews" method="POST" action="" enctype="multipart/form-data">
    <table class="content-input">
        <tr>
            <td width="25%" style="padding: 10px 0 10px 10px;">ชื่อเรื่อง</td>
            <td width="75%"><input type="text" size="70" class="txt" name="txtsubject" size="70"/></td>
        </tr>
        <tr>
            <td style="padding: 10px 0 10px 10px;">วันที่</td>
            <td><input type="text" name="dateInput" id="dateInput" class="datepick"
                       value="<?php echo ChangeDate(date("Y-m-d")); ?>"/></td>
        </tr>
        <tr>
            <td style="padding: 10px 0 10px 10px;">ฝ่าย/ส่วน</td>
            <td><select class="txt" name="cbodepartment">
                    <option value="0">- - - - ไม่เลือกเลือก - - - -</option>
                    <?php
                    $sql = "Select * From tb_officertype Order by id";
                    $rs = rsQuery($sql);
                    while ($row1 = mysqli_fetch_assoc($rs)) {
                        if ($row1['id'] == $row['department']) {
                            echo "<option value=\"" . $row1['id'] . "\" selected>" . $row1['name'] . "</option>";
                        } else {
                            echo "<option value=\"" . $row1['id'] . "\">" . $row1['name'] . "</option>";
                        }
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td style="padding: 10px 0 10px 10px;">รายละเอียด</td>
            <td><textarea name="detail1" id="mytextarea"></textarea></td>
        </tr>

        <tr>
            <td style="padding: 10px 0 10px 10px;">image filter</td>
            <td>
                <select name="cbofilter">
                    <?php
                    $sqlfilter = "select * from tb_filter";
                    $rsfilter = rsQuery($sqlfilter);
                    if ($rsfilter) {
                        while ($filter = mysqli_fetch_assoc($rsfilter)) {
                            echo "<option value='" . $filter['name'] . "'>" . $filter['name'] . "</option>";
                        }
                    }
                    ?>
                </select>&nbsp;* ใส่ Effect ให้กับรูปภาพ
        </tr>
        <tr>
            <td valign="top" style="padding: 10px 0 10px 10px;">
                <?php echo ShowAllowedFileUpload($gloUploadFileType); ?>
                ขนาดไม่เกิน <?php echo $SizeInMb; ?> Mb
            </td>
            <!--            <td><br>-->
            <!--                --><?php ////วนลูปสร้าง file control เพื่อรับไฟล์ที่จะทำการอัพโหลด
            //                for ($i = 0; $i <= $file_no; $i++) {
            //                    echo "ไฟล์ที่&nbsp;" . ($i + 1) . '&nbsp;&nbsp;<input type=file name=file' . $i . ' size=50 /><br />';
            //                }
            //                ?>
            <!--            </td>-->
            <td></td>
        </tr>
        <tr>
          <td style="text-align: right; padding-right: 10px;">อัพโหลดรูปภาพ (เลือกได้มากกว่า 1 รูป) </td>
          <td>
          <input type="file" name="frm_img[]" id="frm_img[]" multiple></input>
        </td>
        </tr>
        <tr>
          <td style="text-align: right; padding-right: 10px;"> กดปุ่ม ctrl+A เลือกทั้งหมด <br> กดปุ่ม ctrl เลือกรูปภาพทีละรูป   </td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><input type="checkbox" name="active"/>&nbsp;Active</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td><input class="bt" type="submit" name="btadd" value="เพิ่ม"/></td>
        </tr>
    </table>
</form>
<script src="../js/datepicker-thai/datepicker.js"></script>
