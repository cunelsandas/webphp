<link rel="stylesheet" type="text/css" href="css/customer.css">
<?php
$mod=decode64($_GET['_mod']);
!empty($_GET['no'])?$no=$_GET['no']:null;

if($no<>""){
  if($no=="addnew"){
    include "addnew.php";
  }else{
    include "view.php";
  }
}else{
  if(isset($_POST['bt_find_year'])){
      $type = $_POST['findtype'];
    if($type == "puc"){
      $year=$_POST['findyear'];
        $term = '7';
        
          $sql="select * from wp_posts where year(post_date)=$year AND ID in(select object_id from wp_term_relationships where term_taxonomy_id=$term) order by date(post_date) ";
           $rs=rsQuery($sql);
      $numrow = mysqli_num_rows($rs);
    }else if($type == "data"){
       $year=$_POST['findyear'];
        $term = '31';
        
          $sql="select * from wp_posts where year(post_date)=$year AND ID in(select object_id from wp_term_relationships where term_taxonomy_id=$term) order by date(post_date) ";
           $rs=rsQuery($sql);
      $numrow = mysqli_num_rows($rs);
    }
        
      }
     
     
      
?>
<div id="main">
<form name="myform" id="myform" action="" method="POST" enctype="multipart/form-data">
<table id="newspaper-b">

      <td style="color: black;font-size: 1.3em;" colspan="4"><?php
            echo "<select name=\"findyear\" style=\"width:200px;\"><option>เลือกปีที่ต้องการดู</option>";

                echo "<option value=2017>2017</option>";
                 echo "<option value=2016>2016</option>";
                  echo "<option value=2015>2015</option>";

            echo "</select>";
          ?>
          <?php
            echo "<select name=\"findtype\" style=\"width:200px;\"><option>เลือกประเภทที่ต้องการดู</option>";
              
                echo "<option value=\"puc\">จัดซื้อจัดจ้าง</option>";
                 echo "<option value=\"data\">แผนงานประกาศ</option>";
                  
              
            echo "</select>";
          ?>
        
        &nbsp;&nbsp;&nbsp;<input type="submit" name="bt_find_year" value="ค้นหา"></td>
    </tr>
    <tr>
     
      <th width="65%">รายการ</th>
      <th width="35%">วันที่</th>
     
    </tr>

    
        <?php
       if ($numrow > 0) {
         
       
      if($rs){
         while($data=mysqli_fetch_array($rs)){
            echo "<tr onclick=\"document.location = 'index.php?_mod=".encode64('yonluang')."&no=".$data['ID']."';\"><td align=\"left\">".$data['post_title']."</td><td align=\"left\">".thaidate($data['post_date'])."</td></tr>";
        }
      }
        } else { 
          echo "<tr><td colspan=\"4\" align=\"center\">กรุณาเลือกปี</td></tr>";
        }
        
       
       
        
    ?>

    </table>

</form>

</div>


            
      


      
      <?php
echo"<p style=\"text-align:center;margin-left:45px;padding-bottom:10px;\">";
echo "";
if ($page > 1) {
$back = $page - 1;
echo "<a href=index.php?_mod=".encode64($mod)."&page=1><img src=\"images/bt_first.png\" style=\"width:50px;height:25px;border:0;vertical-align: text-bottom;\" align=top></a>&nbsp;&nbsp;";
echo "<a href=index.php?_mod=".encode64($mod)."&page=$back><img src=\"images/bt_prev.png\" style=\"width:50px;height:25px;border:0;vertical-align: text-bottom;\"></a>&nbsp;&nbsp;";
if ($start > 1) { echo "....."; }
}
$icount=1;
For ($i=$start ; $i<=$end ; $i++) {
$bgcolor = ($icount% 2)? '#0080ff' : '#ff0000'; //แสดงสีสลับเมื่อ ค่า i เพิ่มค่าไปเรื่อย ๆ
if ($i == $page ) {
echo "&nbsp;<b><font color=#787a8d>[".$i."]</font></b>&nbsp;&nbsp;&nbsp;" ;
} else {
echo "&nbsp;<a href=index.php?_mod=".encode64($mod)."&page=".$i." style=\"color:$bgcolor\"><font color=$bgcolor>".$i."</font></a>&nbsp;&nbsp;&nbsp;" ;
}
$icount++;
}
if ($page < $totalpage) {
$next = $page +1;
if ($end < $totalpage) { echo "....."; }
echo "&nbsp;&nbsp;<a href=index.php?_mod=".encode64($mod)."&page=$next><img src=\"images/bt_next.png\" style=\"width:50px;height:25px;border:0;vertical-align: text-bottom;\"></a>";
echo "&nbsp;<a href=index.php?_mod=".encode64($mod)."&page=$totalpage><img src=\"images/bt_last.png\" style=\"width:50px;height:25px;border:0;vertical-align: text-bottom;\"></a>";
}
echo "</p>";
 
  }
  ?>