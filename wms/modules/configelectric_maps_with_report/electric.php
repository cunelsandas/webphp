

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

<div><br><h4><u>แจ้งซ่อมไฟฟ้าสาธารณะ</u><h4><br></div>

<?php
$mod = $_GET["_mod"] ;
$modid = $_GET['_modid'];
$modname=FindRS("select modname from tb_mod where modid=$modid","modname");
$folder =FindRS("select foldername from tb_mod where modid=$modid","foldername");
$tablename="tb_electric_maps";
empty($_GET['type'])?$type="":$type=$_GET['type'];
$modid=$_GET['_modid'];
if($type=="addnews"){
	include("electric_add.php");
}elseif($type=="view"){
	include("electric_view.php");
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
            $updatetran=UpdateTrans('$tablename','delete',$_SESSION['username'],'ID:'.$id);
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
                        <th>ชื่อผู้แจ้ง</th>
                        <th>หมู่ที่</th>
                        <th>บริเวณแจ้งซ่อม</th>
                        <th>สถานะงาน</th>
                        <th>แก้ไข/ลบ</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    $sql = "select * from tb_electric_maps";
                    $rs = rsQuery($sql);
                    $n = 0;


                    if($rs->num_rows>0){

                        while ($row = $rs->fetch_assoc()){
                            $processname=FindRS("select * from tb_electric_status where id=".$row['typewb'],"name");
                            $n = $n+1;
                            echo "<tr><td>".$n."</td>";
                            echo "<td>".DateTimeThai($row['datepost']). " น.</td>";
                            echo "<td>".$row['name']."</td>";
                            echo "<td>".$row['moo']."</td>";
                            echo "<td>".$row['placefocus']."</td>";
//                            if($row['pet_type']==1) {
//                                echo "<td>" . 'สุนัข' . "</td>";
//                            }
//                            elseif ($row['tax_type']==2){
//                                echo "<td>" . 'แมว' . "</td>";
//                            }
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
                <label class="control-label"><b>แผนที่แจ้งซ่อมไฟฟ้าสาธารณะ:</b></label>
                <div id="map2"></div>

                <br>
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row-md-6">
                                <p>สถานที่แจ้งซ่อม : <img style="width: 72px" src="images/marker/electric64.png" /></p>
                            </div>
                        </div>
                    </div>
                </div>
                <a class="btn btn-info"  href="report/electric/html_form_electric.php?id=<?php echo $row['id'];?>" target="_Blank">พิมพ์รายงาน</a>&nbsp;&nbsp;
                <a class="btn btn-warning"  href="report/electric/qr_electric.php" target="_Blank">พิมพ์ QR Code</a>&nbsp;&nbsp;
                <a class="btn btn-primary" href="http://chart.apis.google.com/chart?cht=qr&chs=500x500&choe=UTF-8&chl=<?php echo $domainname ?>/index.php?_mod=<?php echo encode64($mod)?>%26type=addnew&choe=UTF-8" title="QR Code" target="_blank" download>บันทึกภาพ QR Code</a>
                <td style="border-left: dashed 2px black;border-top:dashed 2px black; ">
                    <img src="http://chart.apis.google.com/chart?cht=qr&chs=190x190&choe=UTF-8&chl=<?php echo $domainname ?>/index.php?_mod=<?php echo encode64($mod)?>%26type=addnew&choe=UTF-8" title="QR Code" />
                </td>

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
    $select = "SELECT * FROM tb_electric_maps";
    $rs = rsQuery($select);

    foreach ($rs as $key) {
        if($key['status']==1) {
            $locations[] = array($key['name'], $key['lat'], $key['lng'],$key['id'],$key['status'],$key['moo'],$key['mooban']);
            $locolor = 'electric64.png';
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

            if(locations[i][4]==1){
                v_icon = 'images/marker/electric32.png';
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
                    info.setContent('<div>ชื่อผู้แจ้ง:<b> '+locations[i][0]+'</b></div>' + 'หมู่ที่: '+locations[i][5]+'</a><br>' + 'หมู่บ้าน: '+locations[i][6]+'</a><br>'
                        + 'ลิงค์: <a target="_blank" href="main.php?_modid=<?php echo $modid ?>&_mod=pet&type=view&no='+locations[i][3]+'">ข้อมูลเพิ่มเติม</a>'
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
