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
            <tr>
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
            </tr>
            <tr>
                <td style="padding: 10px 0 10px 10px;">รายละเอียด</td>
                <td><textarea name="detail1" id="mytextarea"><?php echo $row['detail1']; ?></textarea>
                </td>
            </tr>
            <!--<tr >
	<td style="padding-top:10px;padding-bottom:10px;">รายละเอียด2</td>
	<td><textarea name="detail2" class="txtarea"><?php echo $row['detail2']; ?></textarea></td>
</tr>-->
            <tr>
<!--                <td style="padding: 10px 0 10px 10px;">image filter</td>-->
<!--                <td>-->
<!--                    <select name="cbofilter">-->
<!--                        --><?php
//                        $sqlfilter = "select * from tb_filter";
//                        $rsfilter = rsQuery($sqlfilter);
//                        if ($rsfilter) {
//                            while ($filter = mysqli_fetch_assoc($rsfilter)) {
//                                if ($row['img_filter'] == $filter['name']) {
//                                    echo "<option value='" . $filter['name'] . "' selected>" . $filter['name'] . "</option>";
//                                } else {
//                                    echo "<option value='" . $filter['name'] . "'>" . $filter['name'] . "</option>";
//                                }
//                            }
//                        }
//                        ?>
<!--                    </select>&nbsp;* ใส่ Effect ให้กับรูปภาพ-->
<!--            </tr>-->
            <tr>
                <td valign="top" style="padding: 10px 0 10px 10px;">
              <!--      <?php echo ShowAllowedFileUpload($gloUploadFileType); ?>
                    ไฟล์ขนาดไม่เกิน <?php echo $SizeInMb; ?> Mb  -->
                </td>

            </tr>
                <tr>
                  <td style="text-align: right; padding-right: 10px;">อัพโหลดวีดีโอ</td>
                  <td ><input type="file" name="frm_img[]" id="frm_img[]" multiple></input></td>
                </tr>
                <tr>
<!--                  <td style="text-align: right; padding-right: 10px;"> กดปุ่ม ctrl+A เลือกทั้งหมด <br> กดปุ่ม ctrl เลือกรูปภาพทีละรูป   </td>-->
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
            } elseif ($filetype === 'pdf') {
                echo '<a href="..' . $foldername . $arr['filename'] . '" target="_blank">
                        <img  width="80" src="../images/icon_pdf.gif" alt="pdf"></a>';
            } elseif ($filetype === 'xls') {
                echo '<a href="..' . $foldername . $arr['filename'] . '" target="_blank">
                        <img  width="80" src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDUxMiA1MTIiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDUxMiA1MTI7IiB4bWw6c3BhY2U9InByZXNlcnZlIiB3aWR0aD0iNTEycHgiIGhlaWdodD0iNTEycHgiPgo8Zz4KCTxwYXRoIHN0eWxlPSJmaWxsOiM0Q0FGNTA7IiBkPSJNMjk0LjY1NiwxMy4wMTRjLTIuNTMxLTIuMDU2LTUuODYzLTIuODQyLTkuMDQ1LTIuMTMzbC0yNzcuMzMzLDY0ICAgQzMuMzk3LDc2LjAwMy0wLjA0Nyw4MC4zNjksMCw4NS4zNzd2MzYyLjY2N2MwLjAwMiw1LjI2MywzLjg0Myw5LjczOSw5LjA0NSwxMC41MzlsMjc3LjMzMyw0Mi42NjcgICBjNS44MjMsMC44OTUsMTEuMjY5LTMuMDk5LDEyLjE2NC04LjkyMWMwLjA4Mi0wLjUzNSwwLjEyNC0xLjA3NiwwLjEyNC0xLjYxN1YyMS4zNzdDMjk4LjY3NiwxOC4xMjQsMjk3LjE5OSwxNS4wNDUsMjk0LjY1NiwxMy4wMTQgICB6Ii8+Cgk8cGF0aCBzdHlsZT0iZmlsbDojNENBRjUwOyIgZD0iTTUwMS4zMzQsNDU4LjcxSDI4OGMtNS44OTEsMC0xMC42NjctNC43NzYtMTAuNjY3LTEwLjY2N2MwLTUuODkxLDQuNzc2LTEwLjY2NywxMC42NjctMTAuNjY3ICAgaDIwMi42NjdWNzQuNzFIMjg4Yy01Ljg5MSwwLTEwLjY2Ny00Ljc3Ni0xMC42NjctMTAuNjY3UzI4Mi4xMDksNTMuMzc3LDI4OCw1My4zNzdoMjEzLjMzM2M1Ljg5MSwwLDEwLjY2Nyw0Ljc3NiwxMC42NjcsMTAuNjY3ICAgdjM4NEM1MTIsNDUzLjkzNSw1MDcuMjI1LDQ1OC43MSw1MDEuMzM0LDQ1OC43MXoiLz4KPC9nPgo8Zz4KCTxwYXRoIHN0eWxlPSJmaWxsOiNGQUZBRkE7IiBkPSJNMjAyLjY2NywzNTIuMDQ0Yy0zLjY3OCwwLTcuMDk2LTEuODk1LTkuMDQ1LTUuMDEzTDg2Ljk1NSwxNzYuMzY0ICAgYy0zLjI3OS00Ljg5NC0xLjk2OS0xMS41MiwyLjkyNS0xNC43OTlzMTEuNTItMS45NjksMTQuNzk5LDIuOTI1YzAuMTI5LDAuMTkyLDAuMjUxLDAuMzg4LDAuMzY3LDAuNTg4bDEwNi42NjcsMTcwLjY2NyAgIGMzLjExLDUuMDAzLDEuNTc2LDExLjU4LTMuNDI3LDE0LjY5MUMyMDYuNTk5LDM1MS40ODQsMjA0LjY1MywzNTIuMDQxLDIwMi42NjcsMzUyLjA0NHoiLz4KCTxwYXRoIHN0eWxlPSJmaWxsOiNGQUZBRkE7IiBkPSJNOTYsMzUyLjA0NGMtNS44OTEtMC4wMTItMTAuNjU3LTQuNzk3LTEwLjY0NS0xMC42ODhjMC4wMDQtMS45OTIsMC41NjYtMy45NDMsMS42MjEtNS42MzIgICBsMTA2LjY2Ny0xNzAuNjY3YzIuOTU0LTUuMDk3LDkuNDgxLTYuODM0LDE0LjU3Ny0zLjg4YzUuMDk3LDIuOTU0LDYuODM0LDkuNDgxLDMuODgsMTQuNTc3Yy0wLjExNiwwLjItMC4yMzgsMC4zOTYtMC4zNjcsMC41ODggICBMMTA1LjA2NywzNDcuMDA5QzEwMy4xMTksMzUwLjE0Miw5OS42OSwzNTIuMDQ3LDk2LDM1Mi4wNDR6Ii8+CjwvZz4KPGc+Cgk8cGF0aCBzdHlsZT0iZmlsbDojNENBRjUwOyIgZD0iTTM3My4zMzQsNDU4LjcxYy01Ljg5MSwwLTEwLjY2Ny00Ljc3Ni0xMC42NjctMTAuNjY3di0zODRjMC01Ljg5MSw0Ljc3Ni0xMC42NjcsMTAuNjY3LTEwLjY2NyAgIGM1Ljg5MSwwLDEwLjY2Nyw0Ljc3NiwxMC42NjcsMTAuNjY3djM4NEMzODQsNDUzLjkzNSwzNzkuMjI1LDQ1OC43MSwzNzMuMzM0LDQ1OC43MXoiLz4KCTxwYXRoIHN0eWxlPSJmaWxsOiM0Q0FGNTA7IiBkPSJNNTAxLjMzNCwzOTQuNzFIMjg4Yy01Ljg5MSwwLTEwLjY2Ny00Ljc3Ni0xMC42NjctMTAuNjY3YzAtNS44OTEsNC43NzYtMTAuNjY3LDEwLjY2Ny0xMC42NjcgICBoMjEzLjMzM2M1Ljg5MSwwLDEwLjY2Nyw0Ljc3NiwxMC42NjcsMTAuNjY3QzUxMiwzODkuOTM1LDUwNy4yMjUsMzk0LjcxLDUwMS4zMzQsMzk0LjcxeiIvPgoJPHBhdGggc3R5bGU9ImZpbGw6IzRDQUY1MDsiIGQ9Ik01MDEuMzM0LDMzMC43MUgyODhjLTUuODkxLDAtMTAuNjY3LTQuNzc2LTEwLjY2Ny0xMC42NjdjMC01Ljg5MSw0Ljc3Ni0xMC42NjcsMTAuNjY3LTEwLjY2NyAgIGgyMTMuMzMzYzUuODkxLDAsMTAuNjY3LDQuNzc2LDEwLjY2NywxMC42NjdDNTEyLDMyNS45MzUsNTA3LjIyNSwzMzAuNzEsNTAxLjMzNCwzMzAuNzF6Ii8+Cgk8cGF0aCBzdHlsZT0iZmlsbDojNENBRjUwOyIgZD0iTTUwMS4zMzQsMjY2LjcxSDI4OGMtNS44OTEsMC0xMC42NjctNC43NzYtMTAuNjY3LTEwLjY2N2MwLTUuODkxLDQuNzc2LTEwLjY2NywxMC42NjctMTAuNjY3ICAgaDIxMy4zMzNjNS44OTEsMCwxMC42NjcsNC43NzYsMTAuNjY3LDEwLjY2N0M1MTIsMjYxLjkzNSw1MDcuMjI1LDI2Ni43MSw1MDEuMzM0LDI2Ni43MXoiLz4KCTxwYXRoIHN0eWxlPSJmaWxsOiM0Q0FGNTA7IiBkPSJNNTAxLjMzNCwyMDIuNzFIMjg4Yy01Ljg5MSwwLTEwLjY2Ny00Ljc3Ni0xMC42NjctMTAuNjY3czQuNzc2LTEwLjY2NywxMC42NjctMTAuNjY3aDIxMy4zMzMgICBjNS44OTEsMCwxMC42NjcsNC43NzYsMTAuNjY3LDEwLjY2N1M1MDcuMjI1LDIwMi43MSw1MDEuMzM0LDIwMi43MXoiLz4KCTxwYXRoIHN0eWxlPSJmaWxsOiM0Q0FGNTA7IiBkPSJNNTAxLjMzNCwxMzguNzFIMjg4Yy01Ljg5MSwwLTEwLjY2Ny00Ljc3Ni0xMC42NjctMTAuNjY3YzAtNS44OTEsNC43NzYtMTAuNjY3LDEwLjY2Ny0xMC42NjcgICBoMjEzLjMzM2M1Ljg5MSwwLDEwLjY2Nyw0Ljc3NiwxMC42NjcsMTAuNjY3QzUxMiwxMzMuOTM1LDUwNy4yMjUsMTM4LjcxLDUwMS4zMzQsMTM4LjcxeiIvPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+Cjwvc3ZnPgo=" alt="xls"></a>';
            } else {
                echo "<video controls src=.." . $foldername . $arr['filename'] . " width='300'>&nbsp; </video>" ;
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