

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css">

<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>


<style>
	body{
		font-family: THSarabunNew;
	}
    #map2 {
        height: 400px;
        width: 100%;
    }
    #map3 {
        height: 400px;
        width: 100%;
    }
</style>

<div><br><h4><u>ลงทะเบียนร้านอาหาร/โรงแรม</u><h4><br></div>

<?php
$mod = $_GET["_mod"] ;
$modid = $_GET['_modid'];
$modname=FindRS("select modname from tb_mod where modid=$modid","modname");
$folder =FindRS("select foldername from tb_mod where modid=$modid","foldername");
$tablename="tb_restaurantreg";
empty($_GET['type'])?$type="":$type=$_GET['type'];
$modid=$_GET['_modid'];
if($type=="addnews"){
	include("pet_add.php");
}elseif($type=="restuarantview"){
	include("restaurant_view.php");
}elseif($type=="hotelview"){
    include("hotel_view.php");
}
else{

    if(isset($_GET['status'])){
        $sql="UPDATE $tablename SET status='".$_GET['status']."' Where id='".$_GET['no']."'";
        $rs=rsQuery($sql);
        if($rs){
            echo"<script>window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
        }
    }
    if(isset($_GET['delrestaurant'])){
        $sql="DELETE From tb_restaurantreg Where id='".$_GET['delrestaurant']."'";
        $rs=rsQuery($sql);
        if($rs){
            // update table tb_trans บันทึกการลบ
            $updatetran=UpdateTrans('tb_restaurantreg','delete',$_SESSION['username'],'ID:'.$id);
            echo"<script>window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
        }
    }elseif (isset($_GET['delhotel'])){
        $sql="DELETE From tb_hotelreg Where id='".$_GET['delhotel']."'";
        $rs=rsQuery($sql);
        if($rs){
            // update table tb_trans บันทึกการลบ
            $updatetran=UpdateTrans('tb_hotelreg','delete',$_SESSION['username'],'ID:'.$id);
            echo"<script>window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
        }
    }


    ?>

            <br>
    <h3>ร้านอาหาร</h3>
            <div>
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                    <tr>
                        <th>ลำดับ</th>
                        <th>วันที่</th>
                        <th>ชื่อร้านอาหาร</th>
                        <th>ประเภท</th>
                        <th>สถานะลงทะเบียน</th>
                        <th>แก้ไข/ลบ</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    $sql = "select * from tb_restaurantreg";
                    $rs = rsQuery($sql);
                    $n = 0;


                    if($rs->num_rows>0){

                        while ($row = $rs->fetch_assoc()){
                            $processname=FindRS("select * from tb_reshotelreg_status where id=".$row['typewb'],"name");
                            $n = $n+1;
                            echo "<tr><td>".$n."</td>";
                            echo "<td>".DateTimeThai($row['datepost']). " น.</td>";
                            echo "<td>".$row['name']." (".$row['name_eng'].")</td>";
                            if($row['res_type']==1) {
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
                            }
                            echo "<td>".$processname."</td>";

                            echo"<td align=\"center\"><a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=restuarantview&no=".$row['id']."\">
<img src=\"../images/component/docs_16.gif\" border=\"0\" />
</a>&nbsp;&nbsp;&nbsp;<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&delrestaurant=".$row['id']."\" onclick=\"return confirm('คุณต้องการลบคำร้องนี้หรือไม่?');\">
<img src=\"../images/component/del_16.gif\" border=\"0\"/></a></td>";
                        }

                    }
                    ?>
                    </tbody>
                </table>
                <label class="control-label"><b>แผนที่ร้านอาหาร:</b></label>
                <div id="map2"></div>
                <br>
                <h3>โรงแรม</h3>
                <table id="example2" class="table table-striped table-bordered" style="width:100%;background-color: white">
                    <thead>
                    <tr>
                        <th>เลขที่</th>
                        <th>ชื่อโรงแรม</th>
                        <th>ประเภทโรงแรม</th>
                        <th>วันที่</th>
                        <th>สถานะการลงทะเบียน</th>
                        <th>แก้ไข/ลบ</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    $sql = "select * from tb_hotelreg WHERE status='1'";
                    $rs = rsQuery($sql);
                    $n = 0;



                    if($rs->num_rows>0){

                        while ($row = $rs->fetch_assoc()){
                            $processname=FindRS("select * from tb_reshotelreg_status where id=".$row['typewb'],"name");
                            $n = $n+1;
                            echo "<tr><td>".$row['id']."</td>";
                            echo "<td>".$row['name']."</td>";
                            if($row['hotel_type']==1) {
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
                            }
                            echo "<td>".DateTimeThai($row['datepost'])." น.</td>";
                            echo "<td>" . $processname . "</td>";
                            echo"<td align=\"center\"><a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=hotelview&no=".$row['id']."\">
<img src=\"../images/component/docs_16.gif\" border=\"0\" />
</a>&nbsp;&nbsp;&nbsp;<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&delhotel=".$row['id']."\" onclick=\"return confirm('คุณต้องการลบคำร้องนี้หรือไม่?');\">
<img src=\"../images/component/del_16.gif\" border=\"0\"/></a></td>";
                        }

                    }
                    ?>
                    </tbody>
                </table>
                <script>
                    $(document).ready(function() {
                        $('#example2').DataTable();
                    } );
                </script>
                <div id="map3"></div>
                <br>
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row-md-6">
                                <p>ร้านอาหาร : <img style="width: 72px" src="images/marker/rest.png" /></p>
                            </div>
                            <div class="row-md-6">
                                <p>โรงแรม : <img style="width: 72px" src="images/marker/hotel.png" /></p>
                            </div>
                        </div>
                    </div>
                </div>


                <?php
                $selectcount = "SELECT * FROM tb_pet";
                $rscount = rsQuery($selectcount);

                foreach ($rscount as $key) {
                    if($key['pet_type']==1) {
                        $countdog++;

                    }
                    elseif($key['pet_type']==2) {
                        $countcat++;
                    }


                }

                ?>

                <?php
                $selectcountsterilize = "SELECT * FROM tb_pet";
                $rscountsterilize = rsQuery($selectcountsterilize);

                foreach ($rscountsterilize as $key) {
                    if($key['pet_sterilize']=='ทำหมันแล้ว') {
                        $countsterilize++;

                    }
                    elseif($key['pet_sterilize']=='ยังไม่ได้ทำหมัน') {
                        $countnotsterilize++;
                    }


                }

                ?>


            <!--    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                <script type="text/javascript">
                    google.charts.load('current', {'packages':['corechart']});
                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() {

                        var data = google.visualization.arrayToDataTable([
                            ['Task', 'Hours per Day'],
                            ['สุนัข',     <?php echo $countdog; ?>],
                            ['แมว',      <?php echo $countcat; ?> ]
                        ]);

                        var options = {
                            title: 'สัดส่วนสัตว์เลี้ยง',
                            colors: ['#228739', '#e6693e']
                        };

                        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

                        chart.draw(data, options);
                    }
                </script>
                <script type="text/javascript">
                    google.charts.load('current', {'packages':['corechart']});
                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() {

                        var data = google.visualization.arrayToDataTable([
                            ['Task', 'Hours per Day'],
                            ['ทำหมันแล้ว',     <?php echo $countsterilize; ?>],
                            ['ยังไม่ได้ทำ',      <?php echo $countnotsterilize; ?> ]
                        ]);

                        var options = {
                            title: 'สัดส่วนการทำหมัน',
                            colors: ['#e0440e', '#e6693e'],
                            is3D: true
                        };

                        var chart = new google.visualization.PieChart(document.getElementById('piechartsterilize'));

                        chart.draw(data, options);
                    }
                </script>


                <div class="row">
                    <div class="col-sm-6">  <div id="piechart" style="width: 600px; height: 500px;"></div></div>
                    <div class="col-sm-6"> <div id="piechartsterilize" style="width: 600px; height: 500px;"></div></div>
                </div>
                <div class="col-md-12">
                    <div id="piechart" style="width: 450px; height: 500px;"></div>
                    <div id="piechartsterilize" style="width: 450px; height: 500px;"></div>
                </div>

                <div class="form-group">
                    <!--    <div class="col-sm-10">-->
                    <!--        <br>-->
                    <!--        <label><b>ค้นหาสถานที่:</b></label>-->
                    <!--        <input class="form-control" type="text" name="mapsearch" id="mapsearch">-->
                    <!--    </div>-->
                </div>
            </div> -->
            <?php
        }
        ?>

        <script>
            $(document).ready(function() {
                $('#example').DataTable();
            } );
        </script>


<?php
$select = "SELECT * FROM tb_restaurantreg";
$rs = rsQuery($select);

foreach ($rs as $key) {
    if($key['reg_type']==1) {
        $locations[] = array($key['name'], $key['lat'], $key['lng'],$key['reg_type'],$key['fb_page'],$key['id']);
        $locolor = 'rest.png';
    }
    elseif($key['reg_type']==2) {
        $locations[] = array($key['name'], $key['lat'], $key['lng'],$key['reg_type'],$key['fb_page'],$key['id']);
        $locolor = 'hotel.png';
    }


}

$selectht = "SELECT * FROM tb_hotelreg";
$rsht = rsQuery($selectht);
foreach ($rsht as $key) {
    if($key['reg_type']==1) {
        $locationsht[] = array($key['name'], $key['lat'], $key['lng'],$key['reg_type'],$key['fb_page'],$key['id'],$key['agoda'],$key['traveloka']);
        $locolor = 'rest.png';
    }
    elseif($key['reg_type']==2) {
        $locationsht[] = array($key['name'], $key['lat'], $key['lng'],$key['reg_type'],$key['fb_page'],$key['id'],$key['agoda'],$key['traveloka']);
        $locolor = 'hotel.png';
    }


}

$markers = json_encode( $locations );
$markers2 = json_encode( $locationsht );

?>


<!--    --><?php //echo $markers ?>


<script>

    var locations = <?php echo $markers; ?>;
    var locationsht = <?php echo $markers2; ?>;




    function initMap() {
        var mapOptions = {
            center: {lat: 18.76991, lng: 98.97723},
            zoom: 12,
        }

        var maps = new google.maps.Map(document.getElementById("map2"),mapOptions);
        var marker, i, info;

        var maps3 = new google.maps.Map(document.getElementById("map3"),mapOptions);
        var markerht, iht, infoht;

        var v_icon='';
        var v_iconht='';

        for (i = 0; i < locations.length; i++) {

            if(locations[i][3]==1){
                v_icon = 'images/marker/rest32.png';
            }else if(locations[i][3]==2){
                v_icon = 'images/marker/hotel32.png';
            }


            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                map: maps,
                icon: {
                    url: v_icon
                },
                title: locations[i][0]
            });

            info = new google.maps.InfoWindow();

            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    info.setContent('<div style="font-family:THK2DJuly8"><p style="font-size:16px">ชื่อร้านอาหาร:<b> '+locations[i][0]+'</b></p>' + '<a href='+locations[i][4]+' target="_blank"><img src="images/marker/facebook.png" title="Facebook"></a> '+'</a>'

                        + '<a href=https://maps.google.com/?saddr=Current+Location&daddr='+locations[i][1]+','+locations[i][2]+' target=_blank><img src="images/marker/googlemaps.png" title="นำทางใน Google Maps"></a>'
                        + '<br><br>ลิงค์: <a href="main.php?_modid=<?php echo $modid; ?>&_mod=<?php echo $mod; ?>&type=restuarantview&no='+locationsht[i][5]+'">ข้อมูลเพิ่มเติม</a></div>'
                    );

                    info.open(maps, marker);
                }
            })(marker, i));

        }

        // hotel loop icon map

        for (i = 0; i < locationsht.length; i++) {

            if(locationsht[i][3]==1){
                v_icon = 'images/marker/rest32.png';
            }else if(locationsht[i][3]==2){
                v_icon = 'images/marker/hotel32.png';
            }


            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locationsht[i][1], locationsht[i][2]),
                map: maps3,
                icon: {
                    url: v_icon
                },
                title: locationsht[i][0]
            });

            infoht = new google.maps.InfoWindow();

            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    info.setContent('<div style="font-family:THK2DJuly8"><p style="font-size:16px">ชื่อโรงแรม:<b> '+locationsht[i][0]+'</b></p>' + '<a href='+locationsht[i][4]+' target="_blank"><img src="images/marker/facebook.png" title="Facebook"></a> '+'</a>'

                        + '<a href=https://maps.google.com/?saddr=Current+Location&daddr='+locationsht[i][1]+','+locationsht[i][2]+' target=_blank><img src="images/marker/googlemaps.png" title="นำทางใน Google Maps"></a>'
                        + '<a href='+locationsht[i][6]+' target="_blank"><img src="images/marker/agoda.png" width="40" title="จองกับ Agoda"></a>'
                        + '<a href='+locationsht[i][7]+' target="_blank"><img src="images/marker/traveloka.png" width="48" title="จองกับ Traveloka"></a>'
                        + '<br><br>ลิงค์: <a href="main.php?_modid=<?php echo $modid; ?>&_mod=<?php echo $mod; ?>&type=hotelview&no='+locationsht[i][5]+'">ข้อมูลเพิ่มเติม</a></div>'
                    );

                    info.open(maps3, marker);
                }
            })(marker, i));

        }

    }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDg49SZLUZdLu8KQ80fEAPJkbdBUqyN-vw&callback=initMap&libraries=places" ></script>
<script>
</body>
</html>
