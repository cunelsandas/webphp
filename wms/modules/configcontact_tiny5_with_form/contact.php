

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css">

<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

<style>

    @import url("../font/th_k2d_july8.css");

    body{
        font-family: THK2DJuly8;
        font-size: 14px;
    }
    #containner{
        background-color: #FFFFFF;
    }
</style>
<?php

$mod = $_GET["_mod"] ;
$modid = $_GET['_modid'];
$modname=FindRS("select modname from tb_mod where modid=$modid","modname");
$tablename=FindRS("select tablename from tb_mod where modid=$modid","tablename");
$folder =FindRS("select foldername from tb_mod where modid=$modid","foldername");

$modpath =FindRS("select modpath from tb_mod where modid=$modid","modpath");
$pathmod =FindRS("select wms_path from tb_modpath where id=$modpath","wms_path");

empty($_GET['type'])?$type="":$type=$_GET['type'];
$modid=$_GET['_modid'];
if($type=="addnews"){			 //ตรวจสอบก่อนว่ามีการตั้งค่าของ $_GET['type'] เป็นการเพิ่มข่าวใหม่หรือเปล่า
    include("contact_add.php");
}elseif($type=="view"){	     //ตรวจสอบก่อนว่ามีการตั้งค่าของ $_GET['type'] เป็นการดูรายละเอียดข่าวสารหรือเปล่า
    include("contact_view.php");
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

    <div><br><h4><u><?php echo $modname ?></u><h4><br></div>
    <br>
    <div>
        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
            <tr>
                <th width="2%">ลำดับ</th>
                <th width="20%">วันที่</th>
                <th width="20%">หัวข้อติดต่อ</th>
                <th width="20%">ชื่อ</th>
                <th width="20%">เบอร์โทร</th>
                <th width="10%">ขั้นตอน</th>
                <th width="8%">แก้ไข/ลบ</th>
            </tr>
            </thead>
            <tbody>
            <?php

            $sql = "select * from $tablename ORDER BY id DESC";
            $rs = rsQuery($sql);
            $n = 0;


            if($rs->num_rows>0){

                while ($row = $rs->fetch_assoc()){
                    $processname=FindRS("select * from tb_status where id=".$row['status'],"name");
                    $n = $n+1;
                    echo "<tr><td>".$n."</td>";
                    echo "<td>".DateTimeThai($row['created_at'])."</td>";
                    echo "<td>".$row['subject']."</td>";
                    echo "<td>".$row['name']."</td>";
                    echo "<td>".$row['tel']."</td>";
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
    </div>
    <?php
}
?>

<script>
    $(document).ready(function() {
        $('#example').DataTable();
    } );
</script>
