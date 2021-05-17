<?php
error_reporting(0);
if(isset($_GET['p_id'])){
    $tb_mas="";
    $tb_mas2="";
    $p_id=$_GET['p_id'];
    $total_ans=newQuery("select project_id,count(detail_id) as d from questionnaire_result where project_id='$p_id' group 
		by answer_id")->rowCount();
    $totalpoint=$total_ans*5;
    $project_name=rsField("select * from questionnaire_project where id=?","name",array($p_id));
    $sql="select * from questionnaire_master where project_id=?";
    $rs=newQuery($sql,array($p_id));
    if($rs->rowCount()>0){
        while($data = $rs->fetch()){
            $mas_id=$data['id'];
            $mas_name=$data['name'];
            $mas_type=$data['type_id'];
            $mas_type_name=FindRS("select name from questionnaire_type where id=".$mas_type,"name");

            $tb_mas .="<tr><td>$mas_name</td></tr>";
            $tb_mas2 .="$mas_name<br>";
            $sqlsub="select * from questionnaire_submaster where master_id=? and project_id=?";
            $rssub=newQuery($sqlsub,array($mas_id,$p_id));
            if($rssub->rowCount()>0){
                while($dsub = $rssub->fetch()){
                    $sub_id=$dsub['id'];
                    $sub_name=$dsub['name'];
                    $sub_type=$dsub['type_id'];
                    $tb_mas .="<tr><td class='pl-4'>$sub_name</td></tr>";
                    $tb_mas2 .="$sub_name<br>";
                    $sqldetail="select * from questionnaire_detail where master_id=? and submaster_id=?";
                    $rsdetail=newQuery($sqldetail,array($mas_id,$sub_id));
                    if($rsdetail->rowCount()>0){
                        while($ddetail = $rsdetail->fetch()){
                            $detail_id=$ddetail['id'];
                            $detail_name=$ddetail['name'];

                            switch($mas_type_name){
                                case "inputdata":
                                    $strPoint="";
                                    $point="";
                                    break;
                                case "select_one":
                                    $strQ="select id from questionnaire_result where project_id='$p_id' And master_id='$mas_id' And detail_id='$detail_id' And detail_value='checked'";
                                    $point=newQuery($strQ)->rowCount();
                                    break;
                                case "select_multiple":
                                    $strQ="select id from questionnaire_result where project_id='$p_id' And master_id='$mas_id' And detail_id='$detail_id'";
                                    $point=newQuery($strQ)->rowCount();
                                    break;
                                case "point_5choice":
                                    $strQ="select sum(detail_value) as point from questionnaire_result where project_id='$p_id' And master_id='$mas_id' And detail_id='$detail_id' group by project_id";
                                    $rsQ=newQuery($strQ)->fetch();
                                    $point=$rsQ['point']."/".$totalpoint;
                                    $pointcal=$rsQ['point'];
                                    $pointavg = number_format($pointcal/$total_ans,2);
                                    $pointavgpercent = number_format(($pointcal*100)/$totalpoint,2);

                                    break;
                            }

                            $tb_mas .="<tr><td class='pl-5'>$detail_name</td><td>$point คะแนนเฉลี่ย $pointavg คิดเป็น $pointavgpercent %</td></tr>";
                            $tb_mas2 .="$detail_name<bt>$point คะแนนเฉลี่ย <br>$pointavg คิดเป็น <br>$pointavgpercent %";
                        }
                    }
                }
            }else{
                $sqldetail="select * from questionnaire_detail where master_id=?";
                $rsdetail2=newQuery($sqldetail,array($mas_id));
                if($rsdetail2->rowCount()>0){
                    while($ddetail2 = $rsdetail2->fetch()){

                        $detail_id=$ddetail2['id'];
                        $detail_name=$ddetail2['name'];

                        switch($mas_type_name) {
                            case "inputdata":
                                $strPoint="";
                                $point="";
                                break;
                            case "select_one":
                                $strQ = "select id from questionnaire_result where project_id='$p_id' And master_id='$mas_id' And detail_id='$detail_id' And detail_value='checked'";
                                $strQ2 = "select id from questionnaire_result where project_id='$p_id' And master_id='$mas_id' And detail_id='$detail_id' And detail_value='null'";
                                $point = newQuery($strQ)->rowCount();
                                $point2 = newQuery($strQ2)->rowCount();

                                $pointsumcheck = $total_ans-$point;
                                $pointsumnull = $total_ans-$point2;
                                if($pointsum < 0){
                                    $pointsumcheck = ($pointsumcheck)*(-1);
                                }

                                $pointpercent = number_format(($total_ans - $pointsumcheck)*100 / $total_ans,2);

                                $point = $point .' | คิดเป็น '. $pointpercent .' %';

                                break;
                            case "select_multiple":
                                $strQ="select id from questionnaire_result where project_id='$p_id' And master_id='$mas_id' And detail_id='$detail_id' And detail_value='checked'";
                                $point = newQuery($strQ)->rowCount();
                                $point2 = newQuery($strQ2)->rowCount();

                                $pointsumcheck = $total_ans-$point;
                                $pointsumnull = $total_ans-$point2;
                                if($pointsum < 0){
                                    $pointsumcheck = ($pointsumcheck)*(-1);
                                }

                                $pointpercent = number_format(($total_ans - $pointsumcheck)*100 / $total_ans,2);

                                $point = $point .'/'.$total_ans.' | คิดเป็น '. $pointpercent .' %';
                                break;
                            case "point_5choice":
                                $strQ="select sum(detail_value) as point from questionnaire_result where project_id='$p_id' And master_id='$mas_id' And detail_id='$detail_id' group by detail_id";
                                $rsQ=newQuery($strQ)->fetch();
                                $point=$rsQ['point']."/".$totalpoint;
                                break;
                        }
                        $tb_mas .="<tr><td class='pl-5'>$detail_name</td><td>$point</td></tr>";

                        $tb_mas2 .="$detail_name<br>$point<br>";
                    }
                }
            }
        }
    }
}
?>
<div>
    <table class='table table-bordered'>
        <tr>
            <th><?php echo "ผลการสำรวจ ". $project_name;?></th>
        </tr>
        <tr>
            <th>จำนวนผู้ตอบแบบสอบถาม : <?php echo $total_ans;?> คน </th><th>คะแนน</th>
        </tr>
        <?php echo $tb_mas;?>

    </table>
    <?php
    $strPoint = newQuery("SELECT * FROM `questionnaire_result` WHERE project_id = 1 and master_id = 41");
    $n = 0;
    while($data = $strPoint->fetch()) {
        $n = $n+1;
        $detail=$data['detail_value'];
        echo $n.'. '. $detail.'<br>';
    }
    ?>
</div>

<?php //echo $tb_mas2 ?>

<!--tb_mas 2 เอาไว้เก็บค่าไปใช้ในกราฟนะ-->
