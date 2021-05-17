<?php
//	error_reporting(E_ALL);
//	ini_set('error_reporting', E_ALL);
//	ini_set('display_errors',1);
session_start();
include_once"itgmod/connect.inc.php";
include_once"spaw2/spaw.inc.php";
?>
<style>

    @font-face {
        font-family: 'THK2DJuly8';
        src: url('../th_k2d_july8_bold-webfont.eot');
        src: url('../th_k2d_july8_bold-webfont.eot?#iefix') format('embedded-opentype'),
        url('../th_k2d_july8_bold-webfont.woff') format('woff'),
        url('../th_k2d_july8_bold-webfont.ttf') format('truetype');
        font-weight: bold;
        font-style: normal;

    }

</style>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


<div class="container" style="font-family: 'THK2DJuly8'">

<?php

    $modid=10;
    $modname=FindRS("select modname from tb_mod where modid=$modid","modname");
    $tablename=FindRS("select tablename from tb_mod where modid=$modid","tablename");



            $sql1 = "Select * FROM tb_filestype order by fid";
            $rs1 = rsQuery($sql1); //คิวรี่คำสั่ง



            if($rs1) {

                echo "<div class='col-md-8' style='text-align: left'><h2>ศูนย์ข้อมูลข่าวสาร".$customer_name." </h2></div>";

                while ($data = mysqli_fetch_assoc($rs1)) {
                    $key = $data['fid'];
                    $sql = "Select * FROM tb_files where filetypeid= ".$key." order by datepost";
                    $Query = rsQuery($sql);
                    $totalp = mysqli_num_rows($Query); // หาจำนวน record ที่เรียกออกมา

                    if (!$Query) {
                        echo "Error";
                    } else {

                        if ($totalp == 0){

                        }else{
                            echo "
                                <div class='panel-group col-md-8'>
                                <div class='panel panel-info'>
                                    <div class='panel-heading'><h4>". $data['name'] ."</h4></div>";

                            while($arr = mysqli_fetch_assoc($Query)) {
                                echo "<div class='panel-body' style='text-align: left'><a href=\"index.php?_mod=".encode64('files')."&no=".encode64($arr['no'])."\">
".$arr['subject']."</a><br></div>";
                            }
                            echo "</div>                     
                            </div>";
                        }



                    }

                    }
                }



                ?>

</div>
