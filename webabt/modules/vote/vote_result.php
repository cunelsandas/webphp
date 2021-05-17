<?php
			include_once("../../itgmod/connect.inc.php");
			$logo="../../images/logo.jpg";

			$masterid=EscapeValue(decode64($_GET['m']));
			$totalvote=FindRS("select count(id) as countid,masterid from vote_result where masterid='$masterid' group by masterid","countid");
			$graphtotalwidth=500;
			
			$sql="select * from vote_detail where masterid=$masterid Order by name ASC";
			$rs=rsQuery($sql);
			$master_name=FindRS("select * from tb_vote where id=$masterid","name");
			$master_date=FindRS("select * from tb_vote where id=$masterid","date");
			$startdate=datethai($master_date);
			$enddate=datethai(date('Y-m-d'));		
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title> <?php echo $customer_name."  ".$customer_tambon."  ".$customer_amphur."  ".$customer_province;?>  </title>
  <meta name="Keywords" content="<?php echo $customer_name."  ".$customer_tambon."  ".$customer_amphur."  ".$customer_province;?>">
  <meta name="Description" content="<?php echo $customer_name."  ".$customer_tambon."  ".$customer_amphur."  ".$customer_province;?>">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <style>
			@import url(../../font/thsarabunnew.css);
    * {
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }

	
    .page {
	font-family:THSarabunNew,THBaijam,THK2DJuly8,THChakraPetch,THNiramitAS,Tahoma ,sans-serif;
	font-size:12px;
        width: 21cm;
        min-height: 29.7cm;
        padding: 2cm;
        margin: 1cm auto;
        border: 1px #D3D3D3 solid;
        border-radius: 5px;
        background: white;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
		
    }
    .subpage {
	
        padding: 0.5cm;
        
        height: 245mm;
        outline: 2cm;
		/*background:url("../../../images/krut.jpg") no-repeat top center; */
    }
	#thfont {
		font-family: THSarabunNew,Tahoma ,sans-serif;
		
	}
	#thfont table td{
		font-size:12px;
	}
    #thfont td{
		border-radius:5px;
		border:1px solid black;
		background-color:#ffff9d;
		padding:3px;
	}
    @page {
		
        size: A4;
        margin: 0;
    }
    @media print {
		
		
		.page {
			font-family:THSarabunNew,THBaijam,THK2DJuly8,THChakraPetch,THNiramitAS,Tahoma ,sans-serif;
			font-size:12px;
            margin: 0;
            border: initial;
            border-radius: initial;
            width: initial;
            min-height: initial;
            box-shadow: initial;
            background: initial;
            page-break-after: always;
        }
		 .subpage {
	
        padding: 0.5cm;
        
        height: 240mm;
        outline: 2cm;
		/*background:url("http://www.sunpukwan.go.th/images/krut.jpg") no-repeat top center; */
    }
	#thfont {
		font-family:THSarabunNew,THBaijam,THK2DJuly8,THChakraPetch,THNiramitAS,Tahoma ,sans-serif;
	font-size:12px;
	}
	#thfont table td{
		font-size:12px;
	}
	#thfont td{
		border-radius:5px;
		border:1px solid black;
		background-color:#ffff9d;
		padding:5px;
	}
    }
  </style>
 </head>

 <body>
  <?php
		if($rs){
				echo "<div class='page'>";
				echo "<div class='subpage'>";
				echo "<div id='thfont'>";
				echo "<center><img src=$logo><br><br>";
				echo "<table width='90%' class='content-input'>";
				echo "<tr><th colspan='2'>ผลการแสดงความเห็นในหัวข้อ<BR>$master_name</th></tr>";
				echo "<tr><th colspan='2'>ตั้งแต่วันที่ $startdate &nbsp;&nbsp;ถึงวันที่&nbsp;$enddate</td></tr>";
				echo "<tr><th>รายการ</th><th>คะแนน</th></tr>";
				
				while($detail=mysqli_fetch_assoc($rs)){
					$detail_name=$detail['name'];
					$detail_id=$detail['id'];
					$countid=FindRS("select count(id) as countid,detailid from vote_result where detailid=$detail_id group by detailid","countid");
					$graph.=GraphHorizon($graphtotalwidth,$totalvote,$countid,$detail_id,$detail_name,"0","0");
					$percent=round(($countid/$totalvote)*100,2)." %";
					echo "<tr ><td >$detail_name</td><td align='right'>$countid&nbsp;[$percent]</tr>";
				
				}
				
				echo "<tr><td>จำนวนผู้ลงคะแนนทั้งหมด</td><td align='right'>$totalvote</td></tr>";
				echo "</table>";
				echo "<br>";
				
				$gWidth=$graphtotalwidth+40;
				echo "<div style='background-color:#dfdfdf;width:".$gWidth."px;padding:10px;border-radius:10px;'>";	
				echo "<ul style='list-style:none;width:".$graphtotalwidth."px;padding:0px;'>";
				echo $graph;
				echo "</ul></center>";
				echo "</div>";
				echo "</div>";
				echo "</div>";
			}else{
				echo "ยังไม่มีข้อมูล";
			}
  ?>
 </body>
</html>
