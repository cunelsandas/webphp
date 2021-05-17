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
    $strupdate="Update tb_contact_us SET status='".$_POST['f_status']."',updatetime='".date("c")."' Where id='".$_GET['no']."'";
    $rsupdate=rsQuery($strupdate);
    if($rsupdate){
        echo"<script>alert('บันทึกข้อมูลเรียบร้อย');window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
    }else{
        echo "<script>alert('Err')</script>";
    }
}


$sql="Select * From tb_contact_us Where id='".$_GET['no']."'";
$rs=rsQuery($sql);
$row=mysqli_fetch_array($rs);
$selected = $row['typewb'];

$sql1="Select * From tb_files_image Where image_key='".$row['image_key']."'";
$rs1=rsQuery($sql1);

?>

<div class="container">
    <div class="col-md-10" style="text-align:center">
        <h2 style="font-family: THK2DJuly8;">ติดต่อเรา - ช่องทางประชาชน</h2>
    </div>
    <div class="row">
        <div class="w3-panel w3-border col-md-10">
            <div class="panel-body">
                <p>เลขที่ : <?php echo $row['id'];?></p>
                <p>วันที่แจ้ง : <?php echo DateTimeThai($row['created_at']);?>&nbsp;&nbsp; IP Address : <?php echo $row['post_ip'];?></p>
                <p>เรื่อง : <?php echo $row['subject'];?></p>
                <p>ชื่อผู้แจ้ง : <?php echo $row['name'];?></p>
                <p>โทรศัพท์ : <?php echo $row['tel'];?></p>
                <p>อีเมล์ : <?php echo $row['email'];?></p>
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
                    $selected = $row['status'];
                    $sqls = "select * from tb_status";
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

        </div>


        <button class="btn btn-info" type="submit" name="btadd">บันทึก</button>&nbsp;&nbsp;

    </form>
</div>




<!--<input class="bt" type="submit" name="btmail" value="ส่งเมล์"/>-->


