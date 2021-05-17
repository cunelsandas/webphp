
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css">

<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

<style>
	body{
		font-family: THK2DJuly8;
		font-size: 14px;
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

<div id="helpme">
<?php
!empty($_GET['no'])?$no=$_GET['no']:null;
!empty($_GET['type'])?$type=$_GET['type']:null;

if($type=="addnewconfirm"){
    include "addnew_confirm_request.php";
}
elseif ($type=="addnewcancle"){
    include "addnew_cancle_request.php";
}
elseif($type=="confirmview"){
    include "confirm_view.php";
}
elseif($type=="cancleview"){
    include "cancle_view.php";
}
else{
	?>
	<div valign="top"><?php echo"<a class='btn btn-success' href=\"index.php?_mod=".$_GET['_mod']."&type=addnewconfirm \">แจ้งขอรับบริการจัดเก็บขยะมูลฝอย</a>";?></div><br>
    <div valign="top"><?php echo"<a class='btn btn-danger' href=\"index.php?_mod=".$_GET['_mod']."&type=addnewcancle \">ยกเลิกบริการจัดเก็บขยะมูลฝอย</a>";?></div><br>


    <br>
    <div>
        <p>แผนที่แสดงผู้ขอ<font style="color: green;text-decoration: underline">รับบริการ</font>จัดเก็บขยะมูลฝอย</p>
        <div id="map2"></div>
        <br>
        <p>แผนที่แสดงผู้ขอ<font style="color: red;text-decoration: underline">ยกเลิกบริการ</font>จัดเก็บขยะมูลฝอย</p>
        <div id="map3"></div>

<br>
        <h3>ขอรับบริการจัดเก็บขยะมูลฝอย</h3>

        <table id="example1" class="table table-striped table-bordered" style="width:100%;background-color: white">
            <thead>
            <tr>
                <th>เลขที่</th>
                <th>ชื่อ-นามสกุล ผู้แจ้ง</th>
                <th>วันที่</th>
                <th>สถานะ</th>
                <th>แสดงข้อมูล</th>
            </tr>
            </thead>
            <tbody>
            <?php

            $sql = "select * from tb_garbage_request_confirm WHERE status='1'";
            $rs = rsQuery($sql);
            $n = 0;



            if($rs->num_rows>0){

                while ($row = $rs->fetch_assoc()){
                    $processname=FindRS("select * from tb_status where id=".$row['typewb'],"name");
                    $n = $n+1;
                    echo "<tr><td>".$row['id']."</td>";
                    echo "<td>".$row['name']."</td>";
                    echo "<td>".DateTimeThai($row['datepost'])." น.</td>";
                    echo "<td>" . $processname . "</td>";
                    echo "<td><center><a href='index.php?_mod=".$_GET['_mod']."&type=confirmview&no=".$row['id']."'> >>คลิก<< </a></center></td></tr>";
                }

            }
            ?>
            </tbody>
        </table>
        <script>
            $(document).ready(function() {
                $('#example1').DataTable();
            } );
        </script>
        <h3>ยกเลิกบริการจัดเก็บขยะมูลฝอย</h3>
        <table id="example2" class="table table-striped table-bordered" style="width:100%;background-color: white">
            <thead>
            <tr>
                <th>เลขที่</th>
                <th>ชื่อ-นามสกุล ผู้แจ้ง</th>
                <th>วันที่</th>
                <th>สถานะ</th>
                <th>แสดงข้อมูล</th>
            </tr>
            </thead>
            <tbody>
            <?php

            $sql = "select * from tb_garbage_request_cancle WHERE status='1'";
            $rs = rsQuery($sql);
            $n = 0;



            if($rs->num_rows>0){

                while ($row = $rs->fetch_assoc()){
                    $processname=FindRS("select * from tb_status where id=".$row['typewb'],"name");
                    $n = $n+1;
                    echo "<tr><td>".$row['id']."</td>";
                    echo "<td>".$row['name']."</td>";
                    echo "<td>".DateTimeThai($row['datepost'])." น.</td>";
                    echo "<td>" . $processname . "</td>";
                    echo "<td><center><a href='index.php?_mod=".$_GET['_mod']."&type=cancleview&no=".$row['id']."'> >>คลิก<< </a></center></td></tr>";
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

        <?php
        $select = "SELECT * FROM tb_garbage_request_confirm";
        $rs = rsQuery($select);

        foreach ($rs as $key) {
            if($key['code']==1) {
                $locations[] = array($key['name'], $key['lat'], $key['lng'],$key['code'],$key['fb_page'],$key['id']);
                $locolor = 'trashtruck64.png';
            }
            elseif($key['code']==2) {
                $locations[] = array($key['name'], $key['lat'], $key['lng'],$key['code'],$key['fb_page'],$key['id']);
                $locolor = 'trashnot64.png';
            }


        }

        $selectht = "SELECT * FROM tb_garbage_request_cancle";
        $rsht = rsQuery($selectht);
        foreach ($rsht as $key) {
            if($key['code']==1) {
                $locationsht[] = array($key['name'], $key['lat'], $key['lng'],$key['code'],$key['fb_page'],$key['id'],$key['agoda'],$key['traveloka']);
                $locolor = 'trashtruck64.png';
            }
            elseif($key['code']==2) {
                $locationsht[] = array($key['name'], $key['lat'], $key['lng'],$key['code'],$key['fb_page'],$key['id'],$key['agoda'],$key['traveloka']);
                $locolor = 'trashnot64.png';
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
                        center: {lat: <?php echo $customer_lat ?>, lng: <?php echo $customer_lng ?>},
                        zoom: 11,
                    }

                    var maps = new google.maps.Map(document.getElementById("map2"),mapOptions);
                    var marker, i, info;

                    var maps3 = new google.maps.Map(document.getElementById("map3"),mapOptions);
                    var markerht, iht, infoht;

                    var v_icon='';
                    var v_iconht='';

                    for (i = 0; i < locations.length; i++) {

                        if(locations[i][3]==1){
                            v_icon = 'images/marker/trashtruck64.png';
                        }else if(locations[i][3]==2){
                            v_icon = 'images/marker/trashtruck64.png';
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
                                info.setContent('<div style="font-family:THK2DJuly8"><p style="font-size:16px">ชื่อ:<b> '+locations[i][0]+'</b></p>'

                                    + '<a href=https://maps.google.com/?saddr=Current+Location&daddr='+locations[i][1]+','+locations[i][2]+' target=_blank><img src="images/marker/googlemaps.png" title="นำทางใน Google Maps"></a>'
                                    + '<br><br>ลิงค์: <a href="index.php?_mod=<?php echo encode64($mod) ?>&type=confirmview&no='+locations[i][5]+'">ข้อมูลเพิ่มเติม</a></div>'
                                );

                                info.open(maps, marker);
                            }
                        })(marker, i));

                    }

                    // hotel loop icon map

                    for (i = 0; i < locationsht.length; i++) {

                        if(locations[i][3]==1){
                            v_icon = 'images/marker/trashnot64.png';
                        }else if(locations[i][3]==2){
                            v_icon = 'images/marker/trashnot64.png';
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
                                info.setContent('<div style="font-family:THK2DJuly8"><p style="font-size:16px">ชื่อ:<b> '+locationsht[i][0]+'</b></p>'

                                    + '<a href=https://maps.google.com/?saddr=Current+Location&daddr='+locationsht[i][1]+','+locationsht[i][2]+' target=_blank><img src="images/marker/googlemaps.png" title="นำทางใน Google Maps"></a>'
                                    + '<br><br>ลิงค์: <a href="index.php?_mod=<?php echo encode64($mod) ?>&type=cancleview&no='+locationsht[i][5]+'">ข้อมูลเพิ่มเติม</a></div>'
                                );

                                info.open(maps3, marker);
                            }
                        })(marker, i));

                    }

                }
        </script>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDg49SZLUZdLu8KQ80fEAPJkbdBUqyN-vw&callback=initMap&libraries=places" ></script>
        <script>
    </div>
    <?php
}
?>


    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        } );
    </script>