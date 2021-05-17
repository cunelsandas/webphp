<link rel="stylesheet" type="text/css" href="css/jquery-ui-1.7.2.custom.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.25.0/codemirror.min.css">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">



<!-- Include Editor style. -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.8.5/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/froala-editor/2.8.5/css/froala_style.min.css" rel="stylesheet" type="text/css" />

<style>

@import url("../font/th_k2d_july8.css");

body{
  font-family: THK2DJuly8;
  font-size: 14px;
}

    * {
        box-sizing: border-box;
    }

    #containner{
      background-color: #FFFFFF;
    }

    /* The grid: Four equal columns that floats next to each other */
    .column {
        float: left;
        width: 20%;
        padding: 10px;
    }



    /* Style the images inside the grid */
    .column img {
        opacity: 0.8;
        cursor: pointer;
    }

    .column img:hover {
        opacity: 1;
    }

    /* Clear floats after the columns */
    .row:after {
        content: "";
        display: table;
        clear: both;
    }


    /* Expanding image text */
    #imgtext {
        position: absolute;
        bottom: 15px;
        left: 15px;
        color: white;
        font-size: 20px;
    }

    /* Closable button inside the expanded image */
    .closebtn {
        position: absolute;
        top: 10px;
        right: 15px;
        color: rgb(255, 249, 255);
        font-size: 45px;
        cursor: pointer;
    }
</style>

<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.7.2.custom.min.js"></script>
<script type="text/javascript">
    $(function(){
	// แทรกโค้ต jquery
	$("#dateInput").datepicker({ dateFormat: 'yy-mm-dd' });
});
</script>

<?php
$timenow=date("Y-m-d");
/*
if(isset($_POST['btmail'])){ //ส่งเมล์
$MailTo = $_REQUEST['email'] ;
$MailFrom = "info@".$domainname;//$_POST['MailFrom'] ;
$MailSubject = "แจ้งผลการดำเนินการแก้ไขเรื่องร้องเรียน";//$_POST['MailSubject'] ;
$MailMessage = $_REQUEST['spaw1'] ;

$Headers = "MIME-Version: 1.0\r\n" ;
$Headers .= "Content-type: text/html; charset=UTF-8\r\n" ;
                          // ส่งข้อความเป็นภาษาไทย ใช้ "windows-874"
$Headers .= "From: ".$MailFrom." <".$MailFrom.">\r\n" ;
$Headers .= "Reply-to: ".$MailFrom." <".$MailFrom.">\r\n" ;
$Headers .= "X-Priority: 3\r\n" ;
$Headers .= "X-Mailer: PHP mailer\r\n" ;

        if(mail($MailTo, $MailSubject , $MailMessage, $Headers, $MailFrom))
        {
        $msg= "Send Mail True" ;  //ส่งเรียบร้อย
        }else{
        $msg= "Send Mail False" ; //ไม่สามารถส่งเมล์ได้
        }

	echo"<script>alert('$msg');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
}*/


if(isset($_POST['btadd'])){
  $text = $_POST['mytextarea'];
	$strupdate="Update tb_help_maps SET typewb='".$_POST['f_status']."',result='$text',updatetime='".date("c")."' Where id='".$_GET['no']."'";
	$rsupdate=rsQuery($strupdate);
	if($rsupdate){
	echo"<script>alert('บันทึกข้อมูลเรียบร้อย');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
	}else{
	    echo "<script>alert('Err')</script>";
    }
}


$sql="Select * From tb_help_maps Where id='".$_GET['no']."'";
$rs=rsQuery($sql);
$row=mysqli_fetch_array($rs);
$selected = $row['typewb'];

$sql1="Select * From tb_files_image Where image_key='".$row['image_key']."'";
$rs1=rsQuery($sql1);

?>

<div class="container">
    <div class="col-md-10" style="text-align:center">
        <h2>ข้อมูลคำร้องทุกข์</h2>
    </div>
    <div class="row">
    <div class="w3-panel w3-border col-md-10">
        <div class="panel-body">
            <p>เลขที่คำร้อง : <?php echo $row['id'];?></p>
            <p>วันที่แจ้ง : <?php echo DateTimeThai($row['datepost']);?>&nbsp;&nbsp; IP Address : <?php echo $row['ip'];?></p>
            <p>เรื่อง : <?php echo $row['subject'];?></p>
            <p>ชื่อผู้แจ้ง : <?php echo $row['postby'];?></p>
            <?php
            if ($row['number'] != "") {
              echo "<p>เลขบัตรประชาชน : ".$row['number']." </p>";
            }
            ?>
            <p>ที่อยู่ : <?php echo $row['address'];?></p>
            <p>อีเมล์/โทรศัพท์ : <?php echo $row['email'];?></p>
            <p>รายละเอียด :</p>
            <blockquote>
                &nbsp;<?php echo nl2br($row['detail']);?>
            </blockquote>
        </div>
    </div>
    </div>



    <?php
        if ($row['lng']==""){

        }else{?>
            <div class="col-md-10" style="text-align:center">
                <h2>แผนที่</h2>
            </div>
                <div class="form-group col-md-10 ">
                <div id="map" class="w3-panel w3-border" style="height: 400px; width: 100%;"></div>
            </div>
       <?php }
    ?>


    <?php
    if ($rs1->num_rows>0){

        ?>
        <div class="col-md-10" style="text-align:center">
            <h2>รูปภาพ</h2>
            <p>(คลิกที่รูปภาพ เพื่อแสดง)</p>
        </div>


        <!-- The four columns -->
        <div class="row col-md-10">
            <?php
            while ($row1 = $rs1->fetch_assoc()){
                echo '<div class="column">';
                //echo '<a href="../'.$row1['image_path'].'" target="_blank">';
                echo '<img onclick="myFunction(this);" style="border: 1px solid #ddd; border-radius: 4px;
        padding: 5px; width: 100px; height:auto;" src="../'.$row1['image_path'].'"></a>';
                echo '</div>';
            }
            ?>
        </div>
    <?php }
    ?>




    <div class="row col-md-10">
        <span onclick="this.parentElement.style.display='none'" class="closebtn">&times;</span>
        <img id="expandedImg" style="width:100%">
        <div id="imgtext"></div>
    </div>



    <form name="form_help" id="form_help" method="POST" action="" enctype="multipart/form-data">

        <div class="row">
        <div class="col-md-4">
            <br>
            <label for="f_status"><b>การดำเนินงาน</b></label>
            <select id="f_status" name="f_status" class="form-control">
              <?php
                $selected = $row['typewb'];
                $sqls = "select * from tb_helpme_process";
                $rss = rsQuery($sqls);
                while ($rows = mysqli_fetch_array($rss)) {
                  ?>
                  <option <?php if($selected == $rows['id']){echo("selected");}?> value="<?php echo $rows['id']; ?>"><?php echo $rows['name']; ?></option>

                  <?php
                }
              ?>


            </select>
            <br>
        </div>

        <div class="form-group col-md-10">
            <textarea id="mytextarea" name="mytextarea"><?php echo $row['result'];?></textarea>
        </div>
        </div>


<button class="btn btn-info" type="submit" name="btadd">บันทึก</button>&nbsp;&nbsp;
<a class="btn btn-default"  href="report/helpme_map/html_form01.php?id=<?php echo $row['id'];?>" target="_Blank">พิมพ์คำร้อง</a>&nbsp;&nbsp;


    </form>
</div>




<!--<input class="bt" type="submit" name="btmail" value="ส่งเมล์"/>-->

<script  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDg49SZLUZdLu8KQ80fEAPJkbdBUqyN-vw&libraries=places" ></script>

<script>

        var Lat = parseFloat(<?php echo $row['lat'];?>);
        var Lng = parseFloat(<?php echo $row['lng'];?>);
        //alert(Lat+" "+Lng);
        //console.log(Lat+Lng);

        myLatLng = {lat: Lat, lng: Lng};
        var map = new google.maps.Map(document.getElementById('map'), {
            center: myLatLng,
            zoom: 17
        });

        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map,
        });

</script>

<script>
    function myFunction(imgs) {
        var expandImg = document.getElementById("expandedImg");
        var imgText = document.getElementById("imgtext");
        expandImg.src = imgs.src;
        imgText.innerHTML = imgs.alt;
        expandImg.parentElement.style.display = "block";
    }
</script>


<script src='../js/tinymce/tinymce.min.js'></script>
<script>
    tinymce.init({


        selector: '#mytextarea',
        theme: 'modern',
        width: "100%",
        height: 300,
        convert_urls: false,
        plugins: [
            'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
            'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
            'save table contextmenu directionality emoticons template paste textcolor'
        ],

        toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons',


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
