
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css">

<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>


<div id="helpme">
<?php
!empty($_GET['no'])?$no=$_GET['no']:null;
!empty($_GET['type'])?$type=$_GET['type']:null;

if($type=="addnew"){
	include"modules/helpme/addnew.php";
}elseif($type=="view"){
	include"modules/helpme/view.php";
}else{
	?>
	<div valign="top"><?php echo"<a class='btn btn-info' href=\"index.php?_mod=".$_GET['_mod']."&type=addnew \">แจ้งปัญหา/เรื่องร้องเรียน</a>";?></div><br>

    <br>
    <div>
        <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
            <tr>
                <th>ลำดับ</th>
                <th>วันที่</th>
                <th>เรื่อง</th>
                <th>สถานะ</th>
                <th>แสดงข้อมูล</th>
            </tr>
            </thead>
            <tbody>
                <?php

                $sql = "select * from tb_help_maps WHERE status='1'";
                $rs = rsQuery($sql);
                $n = 0;



                if($rs->num_rows>0){

                    while ($row = $rs->fetch_assoc()){
                        $processname=FindRS("select * from tb_helpme_process where id=".$row['typewb'],"name");
                        $n = $n+1;
                        echo "<tr><td>".$n."</td>";
                        echo "<td>".$row['datepost']."</td>";
                        echo "<td>".$row['subject']."</td>";
                        echo "<td>".$processname."</td>";
                        echo "<td><center><a href='index.php?_mod=".$_GET['_mod']."&type=view&no=".$row['id']."'> >>คลิก<< </a></center></td></tr>";
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
