<script src="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.js"></script>
<link href="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.css" rel="stylesheet"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">


<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

<style>
    body{
        font-family: THSarabunNew;
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
$fdmod = explode("/", $pathmod);
$foldermod = $fdmod[0]."/".$fdmod[1]."/";
$foderreport = "report/".$fdmod[1]."/";

empty($_GET['type'])?$type="":$type=$_GET['type'];


$part = "../fileupload/".$folder."/";

if($type == "Add") {
    include "view.php";
    }else if ($type == "View"){
    include "configqueue_view.php";
}else {

if(isset($_POST['btn_khru'])) {
  $sql = "INSERT INTO tb_object(id,object)
  Values('','" .$_POST['frm_khru']. "')";
  $rs = rsQuery($sql);
  if ($rs) {
    echo "<script>alert('เพิ่มข้อมูล เรื่องรับบริการ เรียบร้อยแล้วค่ะ!');window.location.href='main.php?_mod=".$mod."&_modid=".$modid."'; </script>";
  }
}

if(isset($_POST['btn_time'])) {
    $sql2 = "INSERT INTO tb_time(id,time)
  Values('','" .$_POST['frm_time']. "')";
        $rs = rsQuery($sql2);
        if ($rs) {
            echo "<script>alert('เพิ่มข้อมูล เวลา เรียบร้อยแล้วค่ะ!');window.location.href='main.php?_mod=".$mod."&_modid=".$modid."'; </script>";
        }
    }


?>

<div class="content" name="content">
    <div class="col-md-12">
      <h1><?php echo $modname;?></h1>
      <div style="text-align: right; margin: 20px"><button type="button" class="btn btn-secondary btn-lg" data-toggle="modal" data-target="#Modal"><i class="fa fa-plus-circle"></i> เพิ่มหัวข้อบริการ</button>
          <button type="button" class="btn btn-secondary btn-lg" data-toggle="modal" data-target="#Modal2"><i class="fa fa-plus-circle"></i> แก้ไขเวลา</button></div>
      <div class="panel panel-default">
        <div class="panel-body">
        <div  class="col-md-12">
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                <tr>
                    <th>ลำดับ</th>
                    <th>ชื่อผู้จอง</th>
                    <th>เรื่อง</th>
                    <th>วันที่</th>
                    <th>เวลา</th>
                    <th>จัดการข้อมูลคิว</th>
                </tr>
                </thead>
                <tbody>

                  <?php
                  $sql = "SELECT * FROM tb_queue join tb_queue_obj ON tb_queue.id = tb_queue_obj.id ORDER BY start_date DESC";
                  $rs = rsQuery($sql);
                  $n=1;

                  while ($row = mysqli_fetch_array($rs)){
                    $status = FindRS("select * from tb_status where id=".$row['status'],"status");
                      echo '<tr>
                              <td style="width:10%">'.$n.'</td>
                              <td style="width:30%">'.$row["name"].'</td>
                              <td style="width:20%">'.$row["object_name"].'</td>
                              <td style="width:10%">'.thaidate($row["start_date"]).'</td>
                              <td style="width:10%">'.$row["end_date"].'</td>
                              <td style="width:20%">
                              <a class="btn btn-success" href="main.php?_mod='.$mod.'&_modid='.$modid.'&type=View&id='.$row["id"].'"><i class="fa fa-pencil-square-o"></i></a>
                              <a class="btn btn-danger" onclick="btn_delete('.$row["id"].')"><i class="fa fa-trash-o"></i></a>
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
<!-- Modal -->
<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">เพิ่มหัวข้อบริการ</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" id="myForm" name="myForm" action="#" enctype="multipart/form-data" onsubmit="return(validate());">
        <input type="text" class="form-control" id="frm_khru" name="frm_khru" placeholder="ชื่อ">

        <table class="table table-striped" name="table_object" id="table_object">
  <thead>
    <tr>
      <th scope="col" style="text-align: center;">#</th>
      <th scope="col" style="text-align: center;">ชื่อหัวข้อบริการ</th>
      <th scope="col" style="text-align: center;">จัดการ</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $sql = "SELECT * FROM tb_object ORDER BY id";
    $rs = rsQuery($sql);
    $n=1;

    while ($row = mysqli_fetch_array($rs)){
        echo '<tr>
                <td scope="row" style="text-align: center;">'.$n.'</td>
                <td align="center">'.$row['object'].'</td>
                <td align="center">
                    <a class="btn btn-danger" onclick="btn_delete_obj('.$row["id"].')">ลบ</a>
                </td>
              </tr>';
        $n++;
    }
    ?>
  </tbody>
</table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
        <button type="submit" class="btn btn-primary" name="btn_khru">ตกลง</button>
      </form>
      </div>
    </div>
  </div>
</div>
    <!-- Modal2 -->
    <div class="modal fade" id="Modal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">แก้ไขเวลา</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="myForm" name="myForm" action="#" enctype="multipart/form-data" onsubmit="return(validate2());">
                        <input type="time" class="form-control" id="frm_time" name="frm_time" placeholder="เวลา">

                        <table class="table table-striped" name="table_object" id="table_object">
                            <thead>
                            <tr>
                                <th scope="col" style="text-align: center;">#</th>
                                <th scope="col" style="text-align: center;">เวลา</th>
                                <th scope="col" style="text-align: center;">จัดการ</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $sql2 = "SELECT * FROM tb_time ORDER BY id";
                            $rs = rsQuery($sql2);
                            $n=1;

                            while ($row = mysqli_fetch_array($rs)){
                                echo '<tr>
                <td scope="row" style="text-align: center;">'.$n.'</td>
                <td align="center">'.$row['time'].'</td>
                <td align="center">
                    <a class="btn btn-danger" onclick="btn_delete_obj2('.$row["id"].')">ลบ</a>
                </td>
              </tr>';
                                $n++;
                            }
                            ?>
                            </tbody>
                        </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary" name="btn_time">ตกลง</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div style="text-align: center">
    <a class="btn btn-success"  href="report/queue/html_form01.php?id=<?php echo $row['id'];?>" target="_Blank"><i class="fa fa-print"></i> พิมพ์คิววันที่ปัจจุบัน</a>&nbsp;&nbsp;
    <a class="btn btn-success"  href="report/queue/html_form02.php?id=<?php echo $row['id'];?>" target="_Blank"><i class="fa fa-print"></i> พิมพ์คิวล่วงหน้า 7 วัน</a>&nbsp;&nbsp;
    </div>
<?php } ?>


<script type = "text/javascript">


function btn_delete(id) {
    var action = "remove_queue";
    if(confirm("ต้องการลบข้อมูลหรือไม่")){
        $.ajax({
            url : "../../itgmod/action.php?_modid=<?php echo $modid ?>",
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


function btn_delete_obj(id) {
    var action = "remove_file_queue_ojb";
    if(confirm("ต้องการลบข้อมูลหรือไม่")){
        $.ajax({
            url : "../../itgmod/action.php?_modid=<?php echo $modid ?>",
            method : "POST",
            data : {
                action : action,
                id : id
            },
            success: function (data) {
                alert(data);
                $('#Modal').modal('hide');
                $("#table_object").load(location.href + " #table_object");
            },error: function (data){
              alert(url);
            }
        });
    }else {
        return false;
    }
}

function btn_delete_obj2(id) {
    var action = "remove_file_queue_ojb2";
    if(confirm("ต้องการลบข้อมูลหรือไม่")){
        $.ajax({
            url : "../../itgmod/action.php?_modid=<?php echo $modid ?>",
            method : "POST",
            data : {
                action : action,
                id : id
            },
            success: function (data) {
                alert(data);
                $('#Modal2').modal('hide');
                $("#table_object2").load(location.href + " #table_object2");
            },error: function (data){
                alert(url);
            }
        });
    }else {
        return false;
    }
}

function validate() {

   if( document.myForm.frm_khru.value == "" ) {
      alert( "กรุณากรอก ชื่อบริการ!" );
      document.myForm.frm_khru.focus() ;
      return false;
   }

   return( true );
}
function validate2() {

    if( document.myForm.frm_time.value == "" ) {
        alert( "กรุณากรอก เวลา!" );
        document.myForm.frm_time.focus() ;
        return false;
    }

    return( true );
}

</script>
<script>
    $(document).ready(function() {
        $('#example').DataTable();
    } );
</script>
