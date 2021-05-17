

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
</style>

<div><br><h4><u>ลงทะเบียนศูนย์พัฒนาเด็กเล็ก</u><h4><br></div>

<?php
$mod = $_GET["_mod"] ;
$modid = $_GET['_modid'];
$modname=FindRS("select modname from tb_mod where modid=$modid","modname");
$folder =FindRS("select foldername from tb_mod where modid=$modid","foldername");
$tablename="tb_childcenter_reg";
empty($_GET['type'])?$type="":$type=$_GET['type'];
$modid=$_GET['_modid'];
if($type=="addnews"){
	include("child_add.php");
}elseif($type=="view"){
	include("child_view.php");
}else{

    if(isset($_GET['status'])){
        $sql="UPDATE $tablename SET status='".$_GET['status']."' Where id='".$_GET['no']."'";
        $rs=rsQuery($sql);
        if($rs){
            echo"<script>window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
        }
    }
    if(isset($_GET['del'])){
        $sql="DELETE From $tablename Where id='".$_GET['del']."'";
        $rs=rsQuery($sql);
        if($rs){
            // update table tb_trans บันทึกการลบ
            $updatetran=UpdateTrans('tb_childcenter','delete',$_SESSION['username'],'ID:'.$id);
            echo"<script>window.location.href='main.php?_modid=".$modid."&_mod=".$_GET['_mod']."';</script>";
        }
    }


    ?>

            <br>
            <div>
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                    <tr>
                        <th>ลำดับ</th>
                        <th>วันที่</th>
                        <th>ชื่อ</th>
                        <th>อายุ</th>
                        <th>เพศ</th>
                        <th>สถานะลงทะเบียน</th>
                        <th>แก้ไข/ลบ</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    $sql = "select * from tb_childcenter_reg";
                    $rs = rsQuery($sql);
                    $n = 0;


                    if($rs->num_rows>0){

                        while ($row = $rs->fetch_assoc()){
                            $processname=FindRS("select * from tb_petreg_status where id=".$row['typewb'],"name");
                            $n = $n+1;
                            echo "<tr><td>".$n."</td>";
                            echo "<td>".DateTimeThai($row['datepost']). " น.</td>";
                            echo "<td>".$row['child_name'].' '.$row['child_surname']."</td>";
                            echo "<td>".$row['child_age']." </td>";
                            if($row['child_sex']=='boy') {
                              echo "<td>" . 'ชาย' . "</td>";
                            }
                            else {
                               echo "<td>" . 'หญิง' . "</td>";
                            }
                            echo "<td>".$processname."</td>";

                            echo"<td align=\"center\"><a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&type=view&no=".$row['id']."\">
<img src=\"../images/component/docs_16.gif\" border=\"0\" />
</a>&nbsp;&nbsp;&nbsp;<a href=\"main.php?_modid=".$modid."&_mod=".$_GET['_mod']."&del=".$row['id']."\" onclick=\"return confirm('คุณต้องการลบคำร้องนี้หรือไม่?');\">
<img src=\"../images/component/del_16.gif\" border=\"0\"/></a></td>";
                        }

                    }
                    ?>
                    </tbody>
                </table>
                <label class="control-label"><b>แผนที่ศูนย์เด็ก:</b></label>
                <div id="map2"></div>

                <br>
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row-md-6">
                                <p>เพศชาย : <img style="width: 72px" src="images/markerchild/boy.png" /></p>
                            </div>
                            <div class="row-md-6">
                                <p>เพศหญิง : <img style="width: 72px" src="images/markerchild/girl.png" /></p>
                            </div>
                        </div>
                    </div>
                </div>


                <?php
                $selectcount = "SELECT * FROM tb_childcenter_reg";
                $rscount = rsQuery($selectcount);

                foreach ($rscount as $key) {
                    if($key['child_sex']=='boy') {
                        $countboy++;

                    }
                    elseif($key['child_sex']=='girl') {
                        $countgirl++;
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


                <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                <script type="text/javascript">
                    google.charts.load('current', {'packages':['corechart']});
                    google.charts.setOnLoadCallback(drawChart);

                    function drawChart() {

                        var data = google.visualization.arrayToDataTable([
                            ['Task', 'Hours per Day'],
                            ['ชาย',     <?php echo $countboy; ?>],
                            ['หญิง',      <?php echo $countgirl; ?> ]
                        ]);

                        var options = {
                            title: 'สัดส่วนเพศ',
                            colors: ['#228739', '#e6693e'],
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
            </div>
            <?php
        }
        ?>

        <script>
            $(document).ready(function() {
                $('#example').DataTable();
            } );
        </script>


    <?php
    $select = "SELECT * FROM tb_childcenter_reg";
    $rs = rsQuery($select);

    foreach ($rs as $key) {
        if($key['child_sex']=='boy') {
            $locations[] = array($key['child_name'], $key['lat'], $key['lng'],$key['child_sex'],$key['id'],$key['child_surname']);
            $locolor = '';
        }
        elseif($key['child_sex']=='girl') {
            $locations[] = array($key['child_name'], $key['lat'], $key['lng'],$key['child_sex'],$key['id'],$key['child_surname']);
            $locolor = '';
        }


    }

    $markers = json_encode( $locations );

    ?>

<!--    --><?php //echo $markers ?>


    <script>

        var locations =
            <?php echo $markers; ?>




    function initMap() {
        var mapOptions = {
            center: {lat: <?php echo $customer_lat ?>, lng: <?php echo $customer_lng ?>},
            zoom: 14,
        }

        var maps = new google.maps.Map(document.getElementById("map2"),mapOptions);

        var marker, i, info;


        var v_icon='';

        for (i = 0; i < locations.length; i++) {

            if(locations[i][3]=='boy'){
                v_icon = 'images/markerchild/boy32.png';
            }else if(locations[i][3]=='girl'){
                v_icon = 'images/markerchild/girl32.png';
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
                    info.setContent('<div>ชื่อ:<b> '+locations[i][0]+'</b></div>' + 'นามสกุล: '+locations[i][5]+'</a><br>'
                        + 'ลิงค์: <a href="main.php?_modid=<?php echo $modid ?>&_mod=pet&type=view&no='+locations[i][4]+'">ข้อมูลเพิ่มเติม</a>'
                    + '<br /><a href=https://maps.google.com/?saddr=Current+Location&daddr='+locations[i][1]+','+locations[i][2]+' target=_blank>คลิกเพื่อหาเส้นทางใน Google Maps</a>');
                    info.open(maps, marker);
                }
            })(marker, i));

        }

    }
</script>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDg49SZLUZdLu8KQ80fEAPJkbdBUqyN-vw&callback=initMap&libraries=places" ></script>
<script>
</body>
</html>
