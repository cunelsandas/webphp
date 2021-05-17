

<style>
    * {
        box-sizing: border-box;
    }

     body{
         font-family: THK2DJuly8;
         font-size: 14px;
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
        color: black;
        font-size: 45px;
        cursor: pointer;
    }
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<?php
$sql="Select * From tb_call_for_help Where id='".$_GET['no']."'";
$rs=rsQuery($sql);
$row=mysqli_fetch_array($rs);
$processname=FindRS("select * from tb_status where id=".$row['typewb'],"name");


$sql1="Select * From tb_files_image Where image_key='".$row['image_key']."'";
$rs1=rsQuery($sql1);
?>

<div class="container" style="border: 1px solid #ccc;border-radius: 12px;">
    <div class="panel panel-default col-md-8" style="margin: 0 auto;">
        <h2>ข้อมูลผู้ร้องขอ (กรณีร้องขอด้วยตนเอง)</h2>
        <hr style="border: 1px black solid">
        <div class="panel-body">
            <p>เลขที่ลงทะเบียน : <b style="text-decoration: underline"> <?php echo $row['id'];?></b></p>
            <p>ชื่อ :<b> <?php echo $row['title_name'].$row['firstname'] .'  '. $row['lastname'];?></b></p>
            <p>มีความประสงค์ขอให้ <?php echo $customer_name ?> ดำเนินการช่วยเหลือ ดังนี้ </p>
            <p>ประเภทการช่วยเหลือ : <?php if($row['call_help_type']==1) {
                    echo "<td>".'ด้านสาธารณภัย'."</td>";
                }
                elseif ($row['call_help_type']==2) {
                    echo "<td>".'ด้านการส่งเสริมและพัฒนาคุณภาพชีวิต'."</td>";
                }
                elseif ($row['call_help_type']==3) {
                    echo "<td>".'ด้านการป้องกันและควบคุมโรคติดต่อ'."</td>";
                }
                elseif ($row['call_help_type']==4) {
                    echo "<td>".'อื่น ๆ'."</td>";
                }
                else {
                    echo "<td></td>";
                } ?>
            <p>ปัญหา/ความเดือดร้อนที่เกิดขึ้น : <?php echo $row['detail_call_type'];?></p>
            <p>ความต้องการ/สิ่งที่ขอความช่วยเหลือ: <?php echo $row['detail_call_help'];?></p>
            <hr>
            <p>สถานะงาน: <b><?php echo $processname ?> </b></p>
        </div>
    </div>



    <!-- The four columns -->
<!--    <div class="row col-md-8">-->
<!--        --><?php
//        while ($row1 = $rs1->fetch_assoc()){
//           echo '<div class="column">';
//            //echo '<a href="'.$row1['image_path'].'" target="_blank">';
//            echo '<img onclick="myFunction(this);" style="border: 1px solid #ddd; border-radius: 4px;
//        padding: 5px; width: 100px; height:auto;" src="'.$row1['image_path'].'"></a>';
//            echo '</div>';
//        }
//        ?>
<!--    </div>-->
<!---->
<!---->
<!--    <div class="col-md-8" style="margin: 0 auto">-->
<!--        <span onclick="this.parentElement.style.display='none'" class="closebtn">&times;</span>-->
<!--        <img id="expandedImg" style="width:100%">-->
<!--        <div id="imgtext"></div>-->
<!--    </div>-->


        <div class="col-md-8" style="margin: 0 auto;">
            <br>
            <center><A class="btn btn-primary" HREF="javascript:history.back()">ย้อนกลับ</A></center>
        </div>




</div>


<script>
    function myFunction(imgs) {
        var expandImg = document.getElementById("expandedImg");
        var imgText = document.getElementById("imgtext");
        expandImg.src = imgs.src;
        imgText.innerHTML = imgs.alt;
        expandImg.parentElement.style.display = "block";
    }
</script>
