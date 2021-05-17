<?php
$table = FindRS("select tablename from tb_mod where modid=$modid", "tablename");
$folder = FindRS("select foldername from tb_mod where modid=$modid", "foldername");
$foldername = "/" . $gloUploadPath . "/" . $folder . "/";
$file_no = 1000;   // กำหนด array จำนวน file ที่ต้องการ
$limitsize = $gloPicture_filesize;  //กำหนกขนาดไฟล์ที่ต้องการให้อัพโหลด หารด้วย 1000  1k
$SizeInMb = round(($limitsize / $onemb));

$mod= $_GET['_mod'];
$no=$_GET['no'];
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
?>
<link type="text/css" href="../js/datepicker-thai/datepicker.css" rel="stylesheet"/>
<link type="text/css" href="../js/uploadfile/fileupload.css" rel="stylesheet"/>
<?php $fileaa = ' <div data-num="1" data-watermark="' . $domainname . '" data-size="800" class="div-input-file"></div>'; ?>
<script src="../js/uploadfile/fileupload.js"></script>
<!-- datepicker thai year -->
<script type="text/javascript" src="../js/datepicker-thai/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="../js/datepicker-thai/bootstrap-datepicker.th.js"></script>
<script type="text/javascript" src="../js/datepicker-thai/bootstrap-datepicker-thai.js"></script>


<center>
    <?php
    //ลบภาพ
    if (isset($_GET['del'])) {
        $filenameFordel = FindRS("select * from filename where id=" . $_GET['del'], "filename");
        //echo "File for Delete ".$_SERVER['DOCUMENT_ROOT'].$foldername.$filenameFordel;
        if ($filenameFordel <> "Not Found") {
            unlink($_SERVER['DOCUMENT_ROOT'] . $foldername . $filenameFordel);
        }
        $sql = "DELETE From filename Where id='" . $_GET['del'] . "'";
        $rs = rsQuery($sql);


    }  // end ลบภาพ

    if (isset($_POST['btadd'])) {
        if ($_POST['active'] == "on") {
            $ac = "1";
        } else {
            $ac = "0";
        }

        $sql = "UPDATE $table SET subject='" . EscapeValue($_POST['txtsubject']) . "',detail1='" . $_POST['detail1'] . "',detail2='',datepost='" . ChangeDate($_POST['dateInput'], "th") . "',ip='" . $_SERVER['REMOTE_ADDR'] . "',status='$ac',department='" . $_POST['cbodepartment'] . "',img_filter='" . $_POST['cbofilter'] . "' Where no='" . EscapeValue($_GET['no']) . "'";
        $rs = rsQuery($sql);
        if ($rs) {

            $check = getimagesize($_FILES["frm_img"]["tmp_name"][0]);

              if ($_FILES['frm_img']['size']['0'] <> "0") {
                $sql = "Select * From $table Where no='" . EscapeValue($_GET['no']) . "'";
                $rss = rsQuery($sql);
                $r = mysqli_fetch_assoc($rss);
                $id = $r['no'];


                $sqls = "select * From filename where masterid = ". $id ." ORDER BY id DESC LIMIT 0,1";
                $rsss = rsQuery($sqls);
                $row = mysqli_fetch_assoc($rsss);


                $a = $row['filename'];
                $b = explode($id."_", $a);

                $z = $b[1];
                $x = explode(".", $z);



                $key = $x[0]+1;


          for ($i = 0; $i < count($_FILES['frm_img']['name']); $i++) {
                $filename = $_FILES["frm_img"]["name"][$i];
				$rnd=mt_rand(1111,999999);
				$tmp_date = new DateTime();
				$timestamp = $tmp_date->format('Y-m-d')."_".$rnd ;
                $ext =strtolower(end(explode(".", $filename)));
                $newname = $table .'_'. $id .'_'.$key.'_' .$timestamp. '.' . $ext;
                $filetmp = $_FILES["frm_img"]["tmp_name"][$i];
                $filetype = $_FILES["frm_img"]["type"][$i];
                $filepath = "../".$foldername . $newname;

			$chkimage = isImage($filetmp);  // เช็คว่าเป็นไฟล์รูป ถ้าเป็น
                if ($chkimage == "image") {
                    $uploadimage = resizeimage($filetmp, $newname, $foldername, $domainname, '0', 'true');

//                if (strpos($filetype, 'image') !== false) {
//                  //$images = $_FILES["fileUpload"]["tmp_name"];
//                  //$new_images = $table .'_'. $count .'_' .$i;
//                  $width=800;
//                  $size=GetimageSize($filetmp);
//                  $height=round($width*$size[1]/$size[0]);

//                  switch($filetype){
//                   case "image/jpeg":
//                      $images_orig = imagecreatefromjpeg($filetmp);
//                      break;
//                     case "image/gif":
//                      $images_orig = imagecreatefromgif($filetmp);
//                      break;
//                    case "image/png":
//                      $images_orig = imagecreatefrompng($filetmp);
//                      break;
//                  }


//                  $photoX = ImagesX($images_orig);
//                  $photoY = ImagesY($images_orig);

//                  $images_fin = ImageCreateTrueColor($width, $height);

//                  ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width+1, $height+1, $photoX, $photoY);
//                    switch($filetype){
//                      case "image/jpeg":
//                        ImageJPEG($images_fin,$_SERVER['DOCUMENT_ROOT'].$foldername.$newname);
//                        break;
//                      case "image/gif":
//                        ImageGIF($images_fin,$_SERVER['DOCUMENT_ROOT'].$foldername.$newname);
//                        break;
//                      case "image/png":
//                        ImagePNG($images_fin,$_SERVER['DOCUMENT_ROOT'].$foldername.$newname);
//                        break;
//                    }

//                  ImageDestroy($images_orig);
//                  ImageDestroy($images_fin);



                    }else {
                      move_uploaded_file($filetmp,$filepath);

                    }

                $sql = "INSERT INTO filename(tablename,masterid,filename) Values('" . $table . "','" . $id . "','" . $newname . "')";
                rsQuery($sql);
                $Status = true;
                echo "<script>alert('".$sql."');</script>";



                $key++;
                //move_uploaded_file($filetmp, $filepath);

                /*if (move_uploaded_file($filetmp, $filepath)) {
                    $sql = "INSERT INTO filename(tablename,masterid,filename) Values('" . $table . "','" . $id . "','" . $newname . "')";
                    rsQuery($sql);
                }*/
            }  //end for $i

        }//else {
          //echo "<script>alert('NULL');</script>";
        //}


            // update table tb_trans บันทึกการแก้ไขข้อมูล
            $updatetran = UpdateTrans($table, 'edit', $_SESSION['username'], 'ID:' . $id);
            echo "<script>alert('บันทึกข้อมูลเรียบร้อย');window.location.href='main.php?_modid=" . $modid . "&_mod=" . $_GET['_mod'] . "';</script>";
        }
    }
    $sql = "Select * From $table Where no='" . EscapeValue($_GET['no']) . "'";
    $rs = rsQuery($sql);
    $row = mysqli_fetch_assoc($rs);
    ?>
    <form name="frmnews" method="POST" action="" enctype="multipart/form-data">
        <table class="content-input">
            <tr>
                <td width="20%" style="padding: 10px 0 10px 10px;">ชื่อเรื่อง</td>
                <td width="80%"><input type="text" class="txt" name="txtsubject" value="<?php echo $row['subject']; ?>"
                                       size="70"/></td>
            </tr>
            <tr>
                <td style="padding: 10px 0 10px 10px;">วันที่</td>
                <td><input type="text" name="dateInput" id="dateInput" class="datepick"
                           value="<?php echo ChangeDate($row['datepost']); ?>"/></td>
            </tr>
<!--            <tr>-->
<!--                <td style="padding: 10px 0 10px 10px;">ส่วน/ฝ่าย</td>-->
<!--                <td><select class="txt" name="cbodepartment">-->
<!--                        <option value="0">- - - - ไม่เลือก - - - -</option>-->
<!--                        --><?php
//                        $sql = "Select * From tb_officertype Order by id";
//                        $rs = rsQuery($sql);
//                        while ($row1 = mysqli_fetch_assoc($rs)) {
//                            if ($row1['id'] == $row['department']) {
//                                echo "<option value=\"" . $row1['id'] . "\" selected>" . $row1['name'] . "</option>";
//                            } else {
//                                echo "<option value=\"" . $row1['id'] . "\">" . $row1['name'] . "</option>";
//                            }
//                        }
//                        ?>
<!--                    </select>-->
<!--                </td>-->
<!--            </tr>-->
            <tr>
                <td style="padding: 10px 0 10px 10px;">รายละเอียด1</td>
                <td><textarea name="detail1" id="mytextarea"><?php echo $row['detail1']; ?></textarea>
                </td>
            </tr>
            <!--<tr >
	<td style="padding-top:10px;padding-bottom:10px;">รายละเอียด2</td>
	<td><textarea name="detail2" class="txtarea"><?php echo $row['detail2']; ?></textarea></td>
</tr>-->
            <tr>
                <td style="padding: 10px 0 10px 10px;">image filter</td>
                <td>
                    <select name="cbofilter">
                        <?php
                        $sqlfilter = "select * from tb_filter";
                        $rsfilter = rsQuery($sqlfilter);
                        if ($rsfilter) {
                            while ($filter = mysqli_fetch_assoc($rsfilter)) {
                                if ($row['img_filter'] == $filter['name']) {
                                    echo "<option value='" . $filter['name'] . "' selected>" . $filter['name'] . "</option>";
                                } else {
                                    echo "<option value='" . $filter['name'] . "'>" . $filter['name'] . "</option>";
                                }
                            }
                        }
                        ?>
                    </select>&nbsp;* ใส่ Effect ให้กับรูปภาพ
            </tr>
            <tr>
                <td valign="top" style="padding: 10px 0 10px 10px;">
              <!--      <?php echo ShowAllowedFileUpload($gloUploadFileType); ?>
                    ไฟล์ขนาดไม่เกิน <?php echo $SizeInMb; ?> Mb  -->
                </td>

            </tr>
                <tr>
                  <td style="text-align: right; padding-right: 10px;">อัพโหลดรูปภาพ</td>
                  <td ><input type="file" name="frm_img[]" id="frm_img[]" multiple></input></td>
                </tr>
                <tr>
                  <td style="text-align: right; padding-right: 10px;"> กดปุ่ม ctrl+A เลือกทั้งหมด <br> กดปุ่ม ctrl เลือกรูปภาพทีละรูป   </td>
                </tr>
            <tr>
                <td>&nbsp;</td>
                <td style="padding: 10px 0 10px 10px;">
                    <?php
                    if ($row['status'] == "0") {
                        ?>
                        <input type="checkbox" name="active"/>&nbsp;Active
                        <?php
                    } else {
                        ?>
                        <input type="checkbox" name="active" checked/>&nbsp;Active
                        <?php
                    }
                    ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td style="padding: 10px 0 10px 10px;">
                    <input class="bt" type="submit" name="btadd" value="แก้ไข"/>
					<!-- Load Facebook SDK for JavaScript -->
						<span id="fb-root"></span>
							<script>
								(function(d, s, id) {
									var js, fjs = d.getElementsByTagName(s)[0];
									if (d.getElementById(id)) return;
										  js = d.createElement(s); js.id = id;
										  js.src = "//connect.facebook.net/th_TH/sdk.js#xfbml=1&version=v2.6";
										  fjs.parentNode.insertBefore(js, fjs);
								}(document, 'script', 'facebook-jssdk'));
						</script>
						<span class="fb-share-button"
							data-href="http://<?php echo $domainname;?>/index.php?_mod=<?php echo encode64($mod);?>&no=<?php echo encode64($no);?>"
							data-layout="button"
							data-size="small"
							data-mobile-iframe="true">
							<a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse">แชร์</a>
						</span>
				</td>
            </tr>
        </table>
       <p>QR Code</p>
        <td><img src="http://chart.apis.google.com/chart?cht=qr&chs=200x200&choe=UTF-8&chl=<?php echo $domainname;?>/index.php?_mod=<?php echo encode64($mod);?>%26no=<?php echo encode64($no);?>&choe=UTF-8" title="QR Code" />
        </td> <br>
        <br>

        <?php
        $strpicture = "Select * from filename Where tablename='" . $table . "' AND masterid='" . $_GET['no'] . "' Order by id";
        $rs = rsQuery($strpicture);
        $i = 1;
        /*while ($arr = mysqli_fetch_assoc($rs)) {
            $fileno = substr($arr['filename'], -5, 1);
            $filetype = substr($arr['filename'], -3);
            if ($filetype == "jpg" or $filetype == "png" or $filetype == "gif" or $filetype == "bmp") {
                echo "<img src=.." . $foldername . $arr['filename'] . " width='300' height='300' class='" . $row['img_filter'] . "'>&nbsp;&nbsp;ไฟล์ที่ " . $i . "&nbsp;" . $arr['filename'] . "&nbsp;<a href=\"main.php?_modid=" . $modid . "&_mod=" . $_GET['_mod'] . "&type=view&no=" . $_GET['no'] . "&del=" . $arr['id'] . "\" onclick=\"return confirm('คุณต้องการลบภาพนี้หรือไม่?');\">[ลบ]</a><br><br>";
            } else {
                echo "<a href=.." . $foldername . $arr['filename'] . " target='_blank'><img src='../images/icon_pdf.gif' ></a>&nbsp;&nbsp;ไฟล์ที่ " . $i . "&nbsp;" . $arr['filename'] . "&nbsp;<a href=\"main.php?_modid=" . $modid . "&_mod=" . $_GET['_mod'] . "&type=view&no=" . $_GET['no'] . "&del=" . $arr['id'] . "\" onclick=\"return confirm('คุณต้องการลบภาพนี้หรือไม่?');\">[ลบ]</a><br><br>";
            }
            $i++;
        }*/
        while ($arr = mysqli_fetch_assoc($rs)) {
            $fileno = substr($arr['filename'], -5, 1);
            $filetype = substr($arr['filename'], -3);
            $filetype = explode('.', $arr['filename']);
            $filetype = end($filetype);
            /*if ($filetype == "jpg" or $filetype == "png" or $filetype == "gif" or $filetype == "bmp") {
                echo "<img src=.." . $foldername . $arr['filename'] . " width='300' height='300' class='" . $row['img_filter'] . "'>&nbsp;&nbsp;ไฟล์ที่ " . $i . "&nbsp;" . $arr['filename'] . "&nbsp;<a href=\"main.php?_modid=" . $modid . "&_mod=" . $_GET['_mod'] . "&type=view&no=" . $_GET['no'] . "&del=" . $arr['id'] . "\" onclick=\"return confirm('คุณต้องการลบภาพนี้หรือไม่?');\">[ลบ]</a><br><br>";
            } else {
                echo "<a href=.." . $foldername . $arr['filename'] . " target='_blank'><img src='../images/icon_pdf.gif' ></a>&nbsp;&nbsp;ไฟล์ที่ " . $i . "&nbsp;" . $arr['filename'] . "&nbsp;<a href=\"main.php?_modid=" . $modid . "&_mod=" . $_GET['_mod'] . "&type=view&no=" . $_GET['no'] . "&del=" . $arr['id'] . "\" onclick=\"return confirm('คุณต้องการลบภาพนี้หรือไม่?');\">[ลบ]</a><br><br>";
            }*/
            if ($filetype === 'docx' || $filetype === 'doc') {
                echo '<a href="..' . $foldername . $arr['filename'] . '" target="_blank">
                        <img  width="80" src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDUxMiA1MTIiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDUxMiA1MTI7IiB4bWw6c3BhY2U9InByZXNlcnZlIiB3aWR0aD0iNTEycHgiIGhlaWdodD0iNTEycHgiPgo8cGF0aCBzdHlsZT0iZmlsbDojRUNFRkYxOyIgZD0iTTQ5Niw0MzIuMDA0SDI3MmMtOC44MzIsMC0xNi03LjEzNi0xNi0xNnMwLTMxMS4xNjgsMC0zMjBzNy4xNjgtMTYsMTYtMTZoMjI0ICBjOC44MzIsMCwxNiw3LjE2OCwxNiwxNnYzMjBDNTEyLDQyNC44NjgsNTA0LjgzMiw0MzIuMDA0LDQ5Niw0MzIuMDA0eiIvPgo8Zz4KCTxwYXRoIHN0eWxlPSJmaWxsOiMxOTc2RDI7IiBkPSJNNDMyLDE3Ni4wMDRIMjcyYy04LjgzMiwwLTE2LTcuMTM2LTE2LTE2czcuMTY4LTE2LDE2LTE2aDE2MGM4LjgzMiwwLDE2LDcuMTY4LDE2LDE2ICAgUzQ0MC44MzIsMTc2LjAwNCw0MzIsMTc2LjAwNHoiLz4KCTxwYXRoIHN0eWxlPSJmaWxsOiMxOTc2RDI7IiBkPSJNNDMyLDI0MC4wMDRIMjcyYy04LjgzMiwwLTE2LTcuMTM2LTE2LTE2czcuMTY4LTE2LDE2LTE2aDE2MGM4LjgzMiwwLDE2LDcuMTY4LDE2LDE2ICAgUzQ0MC44MzIsMjQwLjAwNCw0MzIsMjQwLjAwNHoiLz4KCTxwYXRoIHN0eWxlPSJmaWxsOiMxOTc2RDI7IiBkPSJNNDMyLDMwNC4wMDRIMjcyYy04LjgzMiwwLTE2LTcuMTM2LTE2LTE2YzAtOC44NjQsNy4xNjgtMTYsMTYtMTZoMTYwYzguODMyLDAsMTYsNy4xNjgsMTYsMTYgICBTNDQwLjgzMiwzMDQuMDA0LDQzMiwzMDQuMDA0eiIvPgoJPHBhdGggc3R5bGU9ImZpbGw6IzE5NzZEMjsiIGQ9Ik00MzIsMzY4LjAwNEgyNzJjLTguODMyLDAtMTYtNy4xMzYtMTYtMTZzNy4xNjgtMTYsMTYtMTZoMTYwYzguODMyLDAsMTYsNy4xNjgsMTYsMTYgICBTNDQwLjgzMiwzNjguMDA0LDQzMiwzNjguMDA0eiIvPgo8L2c+CjxwYXRoIHN0eWxlPSJmaWxsOiMxNTY1QzA7IiBkPSJNMjgyLjIwOCwxOS43MTZjLTMuNjQ4LTMuMDcyLTguNTQ0LTQuMzUyLTEzLjE1Mi0zLjQyNGwtMjU2LDQ4QzUuNTA0LDY1LjcsMCw3Mi4zMjQsMCw4MC4wMDR2MzUyICBjMCw3LjY4LDUuNDcyLDE0LjMwNCwxMy4wNTYsMTUuNzEybDI1Niw0OGMwLjk5MiwwLjE5MiwxLjk1MiwwLjI4OCwyLjk0NCwwLjI4OGMzLjcxMiwwLDcuMzI4LTEuMjgsMTAuMjA4LTMuNjggIGMzLjY4LTMuMDQsNS43OTItNy41NTIsNS43OTItMTIuMzJ2LTQ0OEMyODgsMjcuMjM2LDI4NS44ODgsMjIuNzU2LDI4Mi4yMDgsMTkuNzE2eiIvPgo8cGF0aCBzdHlsZT0iZmlsbDojRkFGQUZBOyIgZD0iTTIwNy45MDQsMzM3Ljc5NmMtMC44MzIsNy4zMjgtNi41OTIsMTMuMTg0LTEzLjkyLDE0LjA4Yy0wLjY3MiwwLjA5Ni0xLjMxMiwwLjEyOC0xLjk4NCwwLjEyOCAgYy02LjU5MiwwLTEyLjYwOC00LjA5Ni0xNC45NzYtMTAuMzY4TDE0NCwyNTMuNTcybC0zMy4wMjQsODguMDY0Yy0yLjU2LDYuODQ4LTkuMjgsMTEuMDQtMTYuNzA0LDEwLjI3MiAgYy03LjI2NC0wLjc2OC0xMy4wODgtNi40LTE0LjExMi0xMy42NjRsLTE2LTExMmMtMS4yNDgtOC43MDQsNC44MzItMTYuODMyLDEzLjU2OC0xOC4wOGM4Ljc2OC0xLjI4LDE2Ljg2NCw0LjgzMiwxOC4xMTIsMTMuNTY4ICBsNy4xMzYsNTAuMDQ4bDI2LjAxNi02OS40MDhjNC42NzItMTIuNDgsMjUuMjgtMTIuNDgsMjkuOTg0LDBsMjQuNTEyLDY1LjM0NGw4LjYwOC03Ny41MDRjMC45OTItOC43NjgsOS4xMi0xNS4wNzIsMTcuNjY0LTE0LjE0NCAgYzguOCwxLjAyNCwxNS4xMDQsOC45MjgsMTQuMTQ0LDE3LjY5NkwyMDcuOTA0LDMzNy43OTZ6Ii8+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+Cjwvc3ZnPgo=" alt="doc"></a>';
            } elseif ($filetype === 'pdf' || $filetype === 'PDF') {
                echo '<a href="..' . $foldername . $arr['filename'] . '" target="_blank">
                        <img  width="80" src="../images/icon_pdf.gif" alt="pdf"></a>';
            } elseif ($filetype === 'xls' || $filetype === 'xlsx' || $filetype === 'xlsm') {
                echo '<a href="..' . $foldername . $arr['filename'] . '" target="_blank">
                        <img  width="80" src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDUxMiA1MTIiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDUxMiA1MTI7IiB4bWw6c3BhY2U9InByZXNlcnZlIiB3aWR0aD0iNTEycHgiIGhlaWdodD0iNTEycHgiPgo8Zz4KCTxwYXRoIHN0eWxlPSJmaWxsOiM0Q0FGNTA7IiBkPSJNMjk0LjY1NiwxMy4wMTRjLTIuNTMxLTIuMDU2LTUuODYzLTIuODQyLTkuMDQ1LTIuMTMzbC0yNzcuMzMzLDY0ICAgQzMuMzk3LDc2LjAwMy0wLjA0Nyw4MC4zNjksMCw4NS4zNzd2MzYyLjY2N2MwLjAwMiw1LjI2MywzLjg0Myw5LjczOSw5LjA0NSwxMC41MzlsMjc3LjMzMyw0Mi42NjcgICBjNS44MjMsMC44OTUsMTEuMjY5LTMuMDk5LDEyLjE2NC04LjkyMWMwLjA4Mi0wLjUzNSwwLjEyNC0xLjA3NiwwLjEyNC0xLjYxN1YyMS4zNzdDMjk4LjY3NiwxOC4xMjQsMjk3LjE5OSwxNS4wNDUsMjk0LjY1NiwxMy4wMTQgICB6Ii8+Cgk8cGF0aCBzdHlsZT0iZmlsbDojNENBRjUwOyIgZD0iTTUwMS4zMzQsNDU4LjcxSDI4OGMtNS44OTEsMC0xMC42NjctNC43NzYtMTAuNjY3LTEwLjY2N2MwLTUuODkxLDQuNzc2LTEwLjY2NywxMC42NjctMTAuNjY3ICAgaDIwMi42NjdWNzQuNzFIMjg4Yy01Ljg5MSwwLTEwLjY2Ny00Ljc3Ni0xMC42NjctMTAuNjY3UzI4Mi4xMDksNTMuMzc3LDI4OCw1My4zNzdoMjEzLjMzM2M1Ljg5MSwwLDEwLjY2Nyw0Ljc3NiwxMC42NjcsMTAuNjY3ICAgdjM4NEM1MTIsNDUzLjkzNSw1MDcuMjI1LDQ1OC43MSw1MDEuMzM0LDQ1OC43MXoiLz4KPC9nPgo8Zz4KCTxwYXRoIHN0eWxlPSJmaWxsOiNGQUZBRkE7IiBkPSJNMjAyLjY2NywzNTIuMDQ0Yy0zLjY3OCwwLTcuMDk2LTEuODk1LTkuMDQ1LTUuMDEzTDg2Ljk1NSwxNzYuMzY0ICAgYy0zLjI3OS00Ljg5NC0xLjk2OS0xMS41MiwyLjkyNS0xNC43OTlzMTEuNTItMS45NjksMTQuNzk5LDIuOTI1YzAuMTI5LDAuMTkyLDAuMjUxLDAuMzg4LDAuMzY3LDAuNTg4bDEwNi42NjcsMTcwLjY2NyAgIGMzLjExLDUuMDAzLDEuNTc2LDExLjU4LTMuNDI3LDE0LjY5MUMyMDYuNTk5LDM1MS40ODQsMjA0LjY1MywzNTIuMDQxLDIwMi42NjcsMzUyLjA0NHoiLz4KCTxwYXRoIHN0eWxlPSJmaWxsOiNGQUZBRkE7IiBkPSJNOTYsMzUyLjA0NGMtNS44OTEtMC4wMTItMTAuNjU3LTQuNzk3LTEwLjY0NS0xMC42ODhjMC4wMDQtMS45OTIsMC41NjYtMy45NDMsMS42MjEtNS42MzIgICBsMTA2LjY2Ny0xNzAuNjY3YzIuOTU0LTUuMDk3LDkuNDgxLTYuODM0LDE0LjU3Ny0zLjg4YzUuMDk3LDIuOTU0LDYuODM0LDkuNDgxLDMuODgsMTQuNTc3Yy0wLjExNiwwLjItMC4yMzgsMC4zOTYtMC4zNjcsMC41ODggICBMMTA1LjA2NywzNDcuMDA5QzEwMy4xMTksMzUwLjE0Miw5OS42OSwzNTIuMDQ3LDk2LDM1Mi4wNDR6Ii8+CjwvZz4KPGc+Cgk8cGF0aCBzdHlsZT0iZmlsbDojNENBRjUwOyIgZD0iTTM3My4zMzQsNDU4LjcxYy01Ljg5MSwwLTEwLjY2Ny00Ljc3Ni0xMC42NjctMTAuNjY3di0zODRjMC01Ljg5MSw0Ljc3Ni0xMC42NjcsMTAuNjY3LTEwLjY2NyAgIGM1Ljg5MSwwLDEwLjY2Nyw0Ljc3NiwxMC42NjcsMTAuNjY3djM4NEMzODQsNDUzLjkzNSwzNzkuMjI1LDQ1OC43MSwzNzMuMzM0LDQ1OC43MXoiLz4KCTxwYXRoIHN0eWxlPSJmaWxsOiM0Q0FGNTA7IiBkPSJNNTAxLjMzNCwzOTQuNzFIMjg4Yy01Ljg5MSwwLTEwLjY2Ny00Ljc3Ni0xMC42NjctMTAuNjY3YzAtNS44OTEsNC43NzYtMTAuNjY3LDEwLjY2Ny0xMC42NjcgICBoMjEzLjMzM2M1Ljg5MSwwLDEwLjY2Nyw0Ljc3NiwxMC42NjcsMTAuNjY3QzUxMiwzODkuOTM1LDUwNy4yMjUsMzk0LjcxLDUwMS4zMzQsMzk0LjcxeiIvPgoJPHBhdGggc3R5bGU9ImZpbGw6IzRDQUY1MDsiIGQ9Ik01MDEuMzM0LDMzMC43MUgyODhjLTUuODkxLDAtMTAuNjY3LTQuNzc2LTEwLjY2Ny0xMC42NjdjMC01Ljg5MSw0Ljc3Ni0xMC42NjcsMTAuNjY3LTEwLjY2NyAgIGgyMTMuMzMzYzUuODkxLDAsMTAuNjY3LDQuNzc2LDEwLjY2NywxMC42NjdDNTEyLDMyNS45MzUsNTA3LjIyNSwzMzAuNzEsNTAxLjMzNCwzMzAuNzF6Ii8+Cgk8cGF0aCBzdHlsZT0iZmlsbDojNENBRjUwOyIgZD0iTTUwMS4zMzQsMjY2LjcxSDI4OGMtNS44OTEsMC0xMC42NjctNC43NzYtMTAuNjY3LTEwLjY2N2MwLTUuODkxLDQuNzc2LTEwLjY2NywxMC42NjctMTAuNjY3ICAgaDIxMy4zMzNjNS44OTEsMCwxMC42NjcsNC43NzYsMTAuNjY3LDEwLjY2N0M1MTIsMjYxLjkzNSw1MDcuMjI1LDI2Ni43MSw1MDEuMzM0LDI2Ni43MXoiLz4KCTxwYXRoIHN0eWxlPSJmaWxsOiM0Q0FGNTA7IiBkPSJNNTAxLjMzNCwyMDIuNzFIMjg4Yy01Ljg5MSwwLTEwLjY2Ny00Ljc3Ni0xMC42NjctMTAuNjY3czQuNzc2LTEwLjY2NywxMC42NjctMTAuNjY3aDIxMy4zMzMgICBjNS44OTEsMCwxMC42NjcsNC43NzYsMTAuNjY3LDEwLjY2N1M1MDcuMjI1LDIwMi43MSw1MDEuMzM0LDIwMi43MXoiLz4KCTxwYXRoIHN0eWxlPSJmaWxsOiM0Q0FGNTA7IiBkPSJNNTAxLjMzNCwxMzguNzFIMjg4Yy01Ljg5MSwwLTEwLjY2Ny00Ljc3Ni0xMC42NjctMTAuNjY3YzAtNS44OTEsNC43NzYtMTAuNjY3LDEwLjY2Ny0xMC42NjcgICBoMjEzLjMzM2M1Ljg5MSwwLDEwLjY2Nyw0Ljc3NiwxMC42NjcsMTAuNjY3QzUxMiwxMzMuOTM1LDUwNy4yMjUsMTM4LjcxLDUwMS4zMzQsMTM4LjcxeiIvPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+Cjwvc3ZnPgo=" alt="xls"></a>';
            } elseif ($filetype === 'rar' || $filetype === 'zip') {
                echo '<a href="..' . $foldername . $arr['filename'] . '" target="_blank">
                        <img  width="80" src="data:image/png;base64,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CoBEtBvcE0AqpS4ACCHUFeJXs/eQiBKMewJIldQFACKipOFyAKnAAEBEFAMMAdRvDABERDHBEED9xABARBQjDAHULwwAREQxwxBA/cAAQEQUQwwBFDUGACKimGIIoCgxABARxRhDAEWFAYCIKOYYAigKDABERAnAEEBhYwAgIkoIhgAKEwMAEVGCMARQWBgAiIgShiGAwsAAQESUQAwBFBQDABFRQjEEUBAMAERECcYQQHvFAEBElHAMAbQXDABERCnAEEC7xQBARJQSDAG0GwwAREQpwhBAO8UAQESUMgwBtBMMAEREKcQQQLfCAEBElFIMAXQzDABERCnGEEA3wgBARJRyDAF0PQwAREQZwBBAV2MAICLKCIYAuhIDABFRhjAE0DYGACKijGEIIIABgIgokxgCiAGAiCijGAKyjQGAiCjDGAKyiwGAiCjjGAKyiQGAiIgYAjKIAYCIiAAwBGQNAwAREb2JISA7GACIiOgtGAKygQGAiIiuwRCQfgwARER0XQwB6cYAQEREN8QQkF4MAEREdFMMAenEAEBERLfEEJA+DABERLQjDAHpwgBAREQ7xhCQHgwARES0KwwB6cAAQEREu8YQkHwMAEREtCcMAcnGAEBERHvGEJBcDABERBQIQ0AyMQAQEVFgDAHJwwBAREShYAhIFgYAIiIKDUNAcjAAEBFRqBgCkoEBgIiIQscQEH8MAEREFAmGgHhjACAiosgwBMQXAwAREUWKISCeGACIiChyDAHxwwBARER9wRAQLwwARETUNwwB8cEAQEREfcUQEA8MAERE1HcMAeoxABARkRIMAWoxABARkTIMAeowABARkVIMAWowABARkXIMAf3HAEBERLHAENBfDABERBQbDAH9wwBARESxwhDQHwwAREQUOwwB0WMAICKiWGIIiBYDABERxRZDQHQYAIgoPYTqDlAUtkPAsadn/1p1X9KEAYCIQiWEurewpjEBpJWUEvOnWx/mTEB4GACIKDV0nQEgzbgcEC4GACIKlcoZAKEDCpunPuByQHgYAIgodJpQ89UihICR05W0Tf3D5YBwMAAQUeiEwql4q8ApgCz47kzA+b9V3ZekYgAgotCpmgEAgHyRMwBZcXkmYPPxY0/Pfll1X5KIAYCIQqcb6r5aCgOGsrap/95YDvgIZwJ2jwGAiEKnaepG4cUaA0DWfHcmgCFg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" alt="xls"></a>';
            }
            elseif ($filetype === 'mp4' || $filetype === 'm4v' || $filetype === 'mov') {
                echo "<video controls src=.." . $foldername . $arr['filename'] . " width='300' class='" . $row['img_filter'] . "'></video>&nbsp;";
            }
            elseif ($filetype === 'mp3' || $filetype === 'wav')  {
                echo "<audio controls src=.." . $foldername . $arr['filename'] . " width='300' class='" . $row['img_filter'] . "'></audio>&nbsp;";
            }
            else {
                echo "<img src=.." . $foldername . $arr['filename'] . " width='300' class='" . $row['img_filter'] . "'>&nbsp;";
            }
            echo "&nbsp;&nbsp;ไฟล์ที่ " . $i . "&nbsp;" . $arr['filename'] . "&nbsp;<a href=\"main.php?_modid=" . $modid . "&_mod=" . $_GET['_mod'] . "&type=view&no=" . $_GET['no'] . "&del=" . $arr['id'] . "\" onclick=\"return confirm('คุณต้องการลบภาพนี้หรือไม่?');\">[ลบ]</a><br><br>";
            $i++;
        }
        ?>
    </form>
</center>
<script src="../js/datepicker-thai/datepicker.js"></script>
<script src='../js/tinymce/tinymce.min.js'></script>
<script>
    tinymce.init({

        selector: '#mytextarea',
        theme: 'modern',
        width: "100%",
        height: 300,
        plugins: [
            'advlist autolink link lists charmap print preview hr anchor pagebreak spellchecker',
            'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
            'save table contextmenu directionality emoticons template paste textcolor'
        ],
		// toolbar with image picker
      //  toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons',
		// toolbar with out image picker
		 toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | print preview  fullpage | forecolor backcolor emoticons',

        image_title: true,
        // enable automatic uploads of images represented by blob or data URIs
        automatic_uploads: true,
        // add custom filepicker only to Image dialog
        file_picker_types: 'image',
        file_picker_callback: function(cb, value, meta) {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');

            input.onchange = function() {
                var file = this.files[0];
                var reader = new FileReader();

                reader.onload = function () {
                    var id = 'blobid' + (new Date()).getTime();
                    var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                    var base64 = reader.result.split(',')[1];
                    var blobInfo = blobCache.create(id, file, base64);
                    blobCache.add(blobInfo);

                    // call the callback and populate the Title field with the file name
                    cb(blobInfo.blobUri(), { title: file.name });
                };
                reader.readAsDataURL(file);
            };

            input.click();
        }

    });
</script>