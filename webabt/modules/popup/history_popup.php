<?php include_once "../../itgmod/connect.inc.php"; ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
 <head>
  <title>ประวัติบุคลากร<?php echo $customer_name;?> </title>
  <meta name="Generator" content="EditPlus">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <style>
		body{
			background-color:#3091a5;
			font-family:angsana new,tahoma;
			font-size:20px;
			color:#FFFFFF;
			text-shadow: black 0.1em 0.1em 0.2em;
			padding:10px;
			border-color:#ffffff;
}
.photo_border{
	background-color:#FFFFFF;
	border:1px solid #ccc;
	padding:5px;
	width:150px;
	max-height:185px;
	box-shadow:5px 5px 5px #616161;
	
}
	td{
		padding:5px;
	}
			
	</style>
 </head>

 <body>
  <?php
		
		$foldername="../../fileupload/".decode64($_GET['p'])."/";
		$table=EscapeValue(decode64($_GET['tb']));
		$no=EscapeValue(decode64($_GET['no']));
		$sql="select * from $table Where no=$no";
		$rs=rsQuery($sql);
		$data=mysqli_fetch_array($rs);
		$filepath=SearchImage($table,$no,$foldername,"0");
		$history=$data['history'];
		echo "<table><tr><td width=\"30%\"><img src=\"$filepath\" class=\"photo_border\"></td><td width=\"70%\" align=\"left\">".$data['name']."<br>".$data['position']."</td></tr>";
		echo "<tr><td colspan=\"2\">$history</td></tr></table>";

  ?>
 </body>
</html>
