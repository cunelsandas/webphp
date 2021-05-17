<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

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
        color: rgb(255, 249, 255);
        font-size: 45px;
        cursor: pointer;
    }
</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<?php
$sql="Select * From tb_pet Where id='".$_GET['no']."'";
$rs=rsQuery($sql);
$row=mysqli_fetch_array($rs);
$processname=FindRS("select * from tb_petreg_status where id=".$row['typewb'],"name");


$sql1="Select * From tb_files_image Where image_key='".$row['image_key']."'";
$rs1=rsQuery($sql1);
?>

<div class="container">
    <div class="panel panel-default col-md-8">
        <h2>ข้อมูลการลงทะเบียนสัตว์เลี้ยง</h2>
        <div class="panel-body">
            <p>เลขที่ลงทะเบียนสัตว์เลี้ยง : <?php echo $row['id'];?></p>
            <p>วันที่แจ้ง : <?php echo DateTimeThai($row['datepost']);?> น.</p>
<!--            <p>ประเภทภาษี : --><?php //if($row['tax_type']==0) {
//                    echo "<td>" . 'ไม่เลือกประเภท' . "</td>";
//                }
//                elseif ($row['tax_type']==1){
//                    echo "<td>" . 'ภาษีที่ดินและสิ่งปลูกสร้าง' . "</td>";
//                }
//                elseif ($row['tax_type']==2){
//                    echo "<td>" . 'ภาษีป้าย' . "</td>";
//                } ?><!--</p>-->
            <p>ชื่อเจ้าของสัตว์เลี้ยง : <?php echo $row['firstname'] .' '. $row['lastname'];?></p>
            <p>ชื่อสัตว์เลี้ยง : <?php echo $row['petname'];?></p>
            <p>อายุสัตว์เลี้ยง: <?php echo $row['ageyear'].' ปี  '.$row['agemonth'].' เดือน';?></p>
            <p>สถานะการฉีดวัคซีน : <?php echo $row['vaccinehis'];?></p>
            <p>สถานะการทำหมัน : <?php echo $row['petsterilize'];?></p>
            <p>สถานะการลงทะเบียน : <?php echo $processname ?>
        </div>
    </div>



    <!-- The four columns -->
    <div class="row col-md-8">
        <?php
        while ($row1 = $rs1->fetch_assoc()){
           echo '<div class="column">';
            //echo '<a href="'.$row1['image_path'].'" target="_blank">';
            echo '<img onclick="myFunction(this);" style="border: 1px solid #ddd; border-radius: 4px;
        padding: 5px; width: 100px; height:auto;" src="'.$row1['image_path'].'"></a>';
            echo '</div>';
        }
        ?>
    </div>


    <div class="row col-md-8">
        <span onclick="this.parentElement.style.display='none'" class="closebtn">&times;</span>
        <img id="expandedImg" style="width:100%">
        <div id="imgtext"></div>
    </div>


        <div class="col-md-8">
            <br>
            <center><A class="btn btn-default" HREF="javascript:history.back()">ย้อนกลับ</A></center>
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
