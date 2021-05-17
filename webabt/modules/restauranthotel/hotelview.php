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
$sql="Select * From tb_hotelreg Where id='".$_GET['no']."'";
$rs=rsQuery($sql);
$row=mysqli_fetch_array($rs);
$processname=FindRS("select * from tb_reshotelreg_status where id=".$row['typewb'],"name");


$sql1="Select * From tb_files_image Where image_key='".$row['image_key']."'";
$rs1=rsQuery($sql1);
?>

<div class="container">
    <div class="panel panel-default col-md-8">
        <h2>ข้อมูลโรงแรม</h2>
        <hr style="border: 1px black solid">
        <div class="panel-body">
            <p>เลขที่ลงทะเบียนโรงแรม : <b style="text-decoration: underline"> <?php echo $row['id'];?></b></p>
            <p>ชื่อโรงแรม :<b> <?php echo $row['name'];?></b></p>
            <p>ชื่อโรงแรมภาษาอังกฤษ :<b> <?php echo $row['name_eng'];?></b></p>
            <p>ประเภทโรงแรม : <?php if($row['hotel_type']==1) {
                    echo "<td>".'โรงแรม'."</td>";
                }
                elseif ($row['hotel_type']==2) {
                    echo "<td>".'เกสต์เฮาส์'."</td>";
                }
                elseif ($row['hotel_type']==3) {
                    echo "<td>".'รีสอร์ต'."</td>";
                }
                elseif ($row['hotel_type']==4) {
                    echo "<td>".'อพาร์ตเมนต์'."</td>";
                }
                elseif ($row['hotel_type']==5) {
                    echo "<td>".'วิลลา'."</td>";
                }
                elseif ($row['hotel_type']==6) {
                    echo "<td>".'บีแอนด์บี'."</td>";
                }
                elseif ($row['hotel_type']==7) {
                    echo "<td>".'บ้านพักส่วนตัว'."</td>";
                }
                elseif ($row['hotel_type']==8) {
                    echo "<td>".'แคมป์'."</td>";
                }
                elseif ($row['hotel_type']==9) {
                    echo "<td>".'โฮสเทล'."</td>";
                }
                elseif ($row['hotel_type']==10) {
                    echo "<td>".'โฮมสเตย์'."</td>";
                }
                elseif ($row['hotel_type']==11) {
                    echo "<td>".'อื่นๆ'."</td>";
                }
                else {
                    echo "<td></td>";
                } ?>
            <p>ช่วงราคา : <b><?php echo $row['price_range'];?></b> บาท</p>
            <p>เวลาเช็คอิน: <b><?php echo $row['time_start'].'</b> เวลาเช็คเอ้าท์: <b>'.$row['time_end'].'</b> น.';?></p>
<!--            <p>วันที่เปิด :-->
<!--                --><?php
//                    if($row['open_date_range']==1) {
//                        echo  "<b>" . 'เปิดทุกวัน' . "</b>";
//                    }
//                    elseif ($row['open_date_range']==1) {
//                        echo  "<b" . 'จันทร์ - ศุกร์' . "</b>";
//                    }
//                    else {
//                        echo  "<b>" . 'จันทร์ - เสาร์' . "</b>";
//                    }
//
//                    ?>
<!---->
<!--            </p>-->
            <p>ที่ตั้งโรงแรม : <?php echo $row['address']; ?>
            <p>Facebook Fanpage: <?php echo $row['fb_page'];?></p>
            <p>เบอร์ติดต่อ: <?php echo $row['telephone'].' Line ID: '.$row['line_id'].'';?></p>
<!--            <p>พาร์ทเนอร์/เดลิเวอรี่:-->
<!--                --><?php
//                if($row['partnergrab']==1) {
//                    echo "<img src='images/grab.jpg' width='120' height='50'>";
//                }
//                if ($row['partnerfp']==1){
//                    echo "<img src='images/foodpanda.jpg' width='80' height='50'>";
//                }
//                if ($row['partnerlm']==1){
//                    echo "<img src='images/lineman.png' width='80' height='50' style='margin-left:3%'>";
//                }
//                ?>
<!--            </p>-->
            <p style="text-decoration: underline">การบริการ</p>
                <ul>
                <?php
                if($row['air_condition']==1) {
                    echo '<img src="images/marker/air.png" width="64px" title="เครื่องปรับอากาศ">';
                }
                if ($row['food_center']==1){
                    echo '<img src="images/marker/food.png" width="64px" title="ห้องอาหาร">';
                }
                if ($row['car_parking']==1){
                    echo '<img src="images/marker/parking.png" width="64px" title="ที่จอดรถ">';
                }
                if ($row['wifi']==1){
                    echo '<img src="images/marker/wifi.png" width="64px" title="บริการ Wi-Fi">';
                }
                if ($row['pool']==1){
                    echo '<img src="images/marker/pool.png" width="64px" title="สระว่ายน้ำ">';
                }
                if ($row['spa']==1){
                    echo '<img src="images/marker/spa.png" width="64px" title="สปา">';

                }
                ?>
            </ul>
            <?php
            if($row['air_condition']==1) {
                echo '- เครื่องปรับอากาศ';
            }
            if ($row['food_center']==1){
                echo '- ห้องอาหาร';
            }
            if ($row['car_parking']==1){
                echo '- ที่จอดรถ';
            }
            if ($row['wifi']==1){
                echo '- บริการ Wi-Fi';
            }
            if ($row['pool']==1){
                echo '- สระว่ายน้ำ';
            }
            if ($row['spa']==1){
                echo '- สปา';

            }
            ?>
            <br>
            <br>
                        <p style="text-decoration: underline">พาร์ทเนอร์ <br>
                            <?php
                            if($row['agoda']!=null) {
                                echo "<a target='_blank' href=".$row['agoda']."><img src='images/marker/agoda.png' width='60' height='60'></a><br>";
                            }
                            if ($row['traveloka']!=null){
                                echo "<a target='_blank' href=".$row['traveloka']."><img src='images/marker/traveloka.png' width='60' height='60'></a>";
                            }
                            ?>
                        </p>
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
