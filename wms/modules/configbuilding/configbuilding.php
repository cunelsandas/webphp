<?php

$mod = $_GET["_mod"] ;
$modid = $_GET['_modid'];
$modname=FindRS("select modname from tb_mod where modid=$modid","modname");
$tablename=FindRS("select tablename from tb_mod where modid=$modid","tablename");
$folder =FindRS("select foldername from tb_mod where modid=$modid","foldername");

$modpath =FindRS("select modpath from tb_mod where modid=$modid","modpath");
$pathmod =FindRS("select wms_path from tb_modpath where id=$modpath","wms_path");
$fdmod = explode("/", $pathmod);
$foldermod = $fdmod[0]."/".$fdmod[1]."/";
$foderreport = "report/".$fdmod[1]."/";

empty($_GET['type'])?$type="":$type=$_GET['type'];


$part = "../fileupload/".$folder."/";

if($type == "Add") {
    include "view.php";
    }else if ($type == "View"){
    include "configbuilding_view.php";
}else {


?>

<div class="content" name="content">
    <div class="col-md-12">
      <h1><?php echo $modname;?></h1>
      <div class="panel panel-default">
        <div class="panel-body">
        <div  class="col-md-12">
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                <tr>
                    <th>ลำดับ</th>
                    <th>ชื่อผู้แจ้ง</th>
                    <th>สถานะ</th>
                    <th>จัดการข้อมูล</th>
                </tr>
                </thead>
                <tbody>

                  <?php
                  $sql = "SELECT * FROM $tablename ORDER BY id DESC";
                  $rs = rsQuery($sql);
                  $n=1;

                  while ($row = mysqli_fetch_array($rs)){
                    $status = FindRS("select * from tb_status where id=".$row['status'],"status");
                      echo '<tr>
                              <td style="width:10%">'.$n.'</td>
                              <td style="width:50%">'.$row["name"].'</td>
                              <td style="width:20%">'.$status.'</td>
                              <td style="width:20%">
                              <a class="btn btn-success" href="main.php?_mod='.$mod.'&_modid='.$modid.'&type=View&id='.$row["id"].'"><i class="fas fa-eye"></i></a>
                              <a class="btn btn-danger" onclick="btn_delete('.$row["id"].')"><i class="fas fa-trash-alt"></i></a>
                              </td>
                            </tr>';
                      $n++;
                  }
                  ?>

                </tbody>
            </table>
        </div>
</div>
</div>
    </div>

</div>

<?php } ?>



<script type = "text/javascript">

function btn_delete(id) {
    var action = "remove_file_ask";
    if(confirm("ต้องการลบรูปภาพหรือไม่")){
        $.ajax({
            url : "../itgmod/action.php?_modid=<?php echo $modid ?>",
            method : "POST",
            data : {
                action : action,
                id : id
            },
            success: function (data) {
                alert(data);
                $("#example").load(location.href + " #example");
            },error: function (data){
              alert(url);
            }
        });
    }else {
        return false;
    }
}

</script>
