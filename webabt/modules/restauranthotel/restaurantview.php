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
$sql="Select * From tb_restaurantreg Where id='".$_GET['no']."'";
$rs=rsQuery($sql);
$row=mysqli_fetch_array($rs);
$processname=FindRS("select * from tb_reshotelreg_status where id=".$row['typewb'],"name");


$sql1="Select * From tb_files_image Where image_key='".$row['image_key']."'";
$rs1=rsQuery($sql1);
?>

<div class="container">
    <div class="panel panel-default col-md-8">
        <h2>ข้อมูลร้านอาหาร</h2>
        <hr style="border: 1px black solid">
        <div class="panel-body">
            <p>เลขที่ลงทะเบียนร้านอาหาร: <b style="text-decoration: underline"> <?php echo $row['id'];?></b></p>
            <p>ชื่อร้านอาหาร :<b> <?php echo $row['name'];?></b></p>
            <p>ชื่อร้านอาหารภาษาอังกฤษ :<b> <?php echo $row['name_eng'];?></b></p>
            <p>ประเภทร้านอาหาร : <?php if($row['res_type']==1) {
                    echo "<td>".'อาหารทั่วไป อาหารตามสั่ง อาหารจานเดียว'."</td>";
                }
                elseif ($row['res_type']==2) {
                    echo "<td>".'ก๋วยเตี๋ยว ก๋วยจั๊บ'."</td>";
                }
                elseif ($row['res_type']==3) {
                    echo "<td>".'ชาบู สุกี้ยากี้ หม้อไฟ'."</td>";
                }
                elseif ($row['res_type']==4) {
                    echo "<td>".'ปิ้งย่าง หมูกะทะ'."</td>";
                }
                elseif ($row['res_type']==5) {
                    echo "<td>".'ของหวาน ไอศกรีม เบเกอรี่ เครื่องดื่ม'."</td>";
                }
                elseif ($row['res_type']==6) {
                    echo "<td>".'้านขายผลไม้ / ร้านขายผัก'."</td>";
                }
                elseif ($row['res_type']==7) {
                    echo "<td>".'ร้านอาหารอีสาน'."</td>";
                }
                elseif ($row['res_type']==8) {
                    echo "<td>".'ร้านอาหารญี่ปุ่น'."</td>";
                }
                elseif ($row['res_type']==9) {
                    echo "<td>".'คาราโอเกะ'."</td>";
                }
                elseif ($row['res_type']==10) {
                    echo "<td>".'บุฟเฟ่ต์'."</td>";
                }
                elseif ($row['res_type']==11) {
                    echo "<td>".'บุฟเฟ่ต์โรงแรม'."</td>";
                }
                elseif ($row['res_type']==12) {
                    echo "<td>".'พิซซ่า ฟาสต์ฟู้ด จานด่วน'."</td>";
                }
                elseif ($row['res_type']==13) {
                    echo "<td>".'อาหารเกาหลี'."</td>";
                }
                elseif ($row['res_type']==14) {
                    echo "<td>".'อาหารจีน'."</td>";
                }
                elseif ($row['res_type']==15) {
                    echo "<td>".'อาหารเจ มังสวิรัติ สุขภาพ'."</td>";
                }
                elseif ($row['res_type']==16) {
                    echo "<td>".'อาหารใต้'."</td>";
                }
                elseif ($row['res_type']==17) {
                    echo "<td>".'อาหารทะเล'."</td>";
                }
                elseif ($row['res_type']==18) {
                    echo "<td>".'อาหารนานาชาติ'."</td>";
                }
                elseif ($row['res_type']==19) {
                    echo "<td>".'อาหารมุสลิม อิสลาม'."</td>";
                }
                elseif ($row['res_type']==20) {
                    echo "<td>".'อาหารเวียดนาม'."</td>";
                }
                elseif ($row['res_type']==21) {
                    echo "<td>".'อาหารอินเดีย'."</td>";
                }
                elseif ($row['res_type']==22) {
                    echo "<td>".'อาหารเหนือ'."</td>";
                }
                elseif ($row['res_type']==23) {
                    echo "<td>".'อาหารว่าง ขนม ของกินเล่น'."</td>";
                }
                elseif ($row['res_type']==24) {
                    echo "<td>".'อื่นๆ'."</td>";
                }
                else {
                    echo "<td></td>";
                } ?>
            <p>ช่วงราคา : <?php echo $row['price_range'];?> บาท</p>
            <p>ช่วงเวลาเปิด-ปิด: <?php echo $row['time_start'].' -  '.$row['time_end'].' น.';?></p>
            <p>วันที่เปิด :
                <?php
                    if($row['open_date_range']==1) {
                        echo  "<b>" . 'เปิดทุกวัน' . "</b>";
                    }
                    elseif ($row['open_date_range']==1) {
                        echo  "<b" . 'จันทร์ - ศุกร์' . "</b>";
                    }
                    else {
                        echo  "<b>" . 'จันทร์ - เสาร์' . "</b>";
                    }

                    ?>

            </p>
            <p>ที่ตั้งร้าน : <?php echo $row['address']; ?>
            <p>เบอร์ติดต่อ: <?php echo $row['telephone'].' Line ID: '.$row['line_id'].'';?></p>
            <p>พาร์ทเนอร์/เดลิเวอรี่:
                <?php
                if($row['partnergrab']==1) {
                    echo "<img src='images/grab.jpg' width='120' height='50'>";
                }
                if ($row['partnerfp']==1){
                    echo "<img src='images/foodpanda.jpg' width='80' height='50'>";
                }
                if ($row['partnerlm']==1){
                    echo "<img src='images/lineman.png' width='80' height='50' style='margin-left:3%'>";
                }
                ?>
            </p>
            <p style="text-decoration: underline">การบริการ</p>
                <ul>
                <?php
                if($row['serv_alcohol']==1) {
                    echo ' - บริการแอลกอฮอล์';
                }
                if ($row['serv_queue']==1){
                    echo ' - บริการจองคิวล่วงหน้า';
                }
                if ($row['serv_government']==1){
                    echo ' - เข้าร่วมโครงการรัฐบาล';
                }
                ?>
            </ul>
            <hr>
            <p>สถานะการลงทะเบียน : <b><?php echo $processname ?> </b></p>
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
