

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css">

<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>


<style>
	body{
		font-family: THSarabunNew;
	}
</style>

<div><br><h4><u>ชำระภาษีผ่าน QR Code</u><h4><br></div>
<?php
$tablename="tb_paytax";
empty($_GET['type'])?$type="":$type=$_GET['type'];
$modid=$_GET['_modid'];
if($type=="addnews"){
	include("paytax_add.php");
}elseif($type=="view"){
	include("paytax_view.php");
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
                        <th>ชื่อผู้ชำระ</th>
                        <th>ประเภทภาษี</th>
                        <th>การตรวจสอบ</th>
                        <th>แก้ไข/ลบ</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

                    $sql = "select * from tb_paytax";
                    $rs = rsQuery($sql);
                    $n = 0;


                    if($rs->num_rows>0){

                        while ($row = $rs->fetch_assoc()){
                            $processname=FindRS("select * from tb_paytax_status where id=".$row['typewb'],"name");
                            $n = $n+1;
                            echo "<tr><td>".$n."</td>";
                            echo "<td>".DateTimeThai($row['datepost']). " น.</td>";
                            echo "<td>".$row['postby']."</td>";
                            if($row['tax_type']==0) {
                                echo "<td>" . 'ไม่เลือกประเภท' . "</td>";
                            }
                            elseif ($row['tax_type']==1){
                                echo "<td>" . 'ภาษีที่ดินและสิ่งปลูกสร้าง' . "</td>";
                            }
                            elseif ($row['tax_type']==2){
                                echo "<td>" . 'ภาษีป้าย' . "</td>";
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
            </div>
            <?php
        }
        ?>



        <script>
            $(document).ready(function() {
                $('#example').DataTable();
            } );
        </script>
