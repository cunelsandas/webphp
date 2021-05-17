<style>
	.head{
	font-size:18px;
	color:black;
}
	.head:hover{
		color:#2b39ea;
	}
	.datestyle{
		font-size:12px;
		color:gray;
		margin-bottom:10px;
	}
	.typename{
		font-size:12px;
		color:#669fb5;
		margin-left:5px;
	}
	.content-table{
		text-align:left;
		background-color:#ffffff;
		padding:15px;
		border-radius:10px;
	}
	.title{
		
	}
</style>
<?php
$mod = EscapeValue(decode64($_GET['_mod']));
$sql_module = "SELECT * FROM tb_mod WHERE modtype = '{$mod}'";
$rs=rsQuery($sql_module);
if($rs){
$module = mysqli_fetch_assoc($sql_module);
$table_name = $module['tablename'];
$mod_name = $module['modname'];
}
$count=0;
$strTableDetail="";
if($_GET['search']=="" || $_GET['search']==null){

	$strTableDetail ="ไม่สามารถค้นหา กรุณป้อนข้อความค้นหา";
}else{

$searchtype=$_GET['searchtype'];
$search=$_GET['search'];
if (strpos($search, '/') !== false) {
    $year1=trim(substr($search, strrpos($search, '/' )+1));
	$findyear=$year1-543;
	$value1=trim(preg_replace('#\/[^/]*$#', '', $search));
	$value="%".$value1."%";
	$sql2=" and year(datepost)='$findyear' Order by datepost DESC";
}else{
	$value1=$search;
	$value="%".$search."%";
	$findyear="all";
	$sql2=" Order by datepost DESC";
}

if($searchtype=="all"){
	$sqltype="select * from tb_searchtype";
	$rsType=rsQuery($sqltype);
	if($rsType){
		while($dType=mysqli_fetch_assoc($rsType)){
			$tablename=$dType['tablename'];
			$typename=$dType['name'];
			$mod=encode64($dType['modname']);
			$sql="select * from $tablename where subject like '$value'" .$sql2;
			$rsFind=rsQuery($sql);
				if($rsFind){
					while($data=mysqli_fetch_assoc($rsFind)){
						$subject=$data['subject'];
						$no=encode64($data['no']);
						$datepost=DateThai($data['datepost']);
						$count +=1;
						$strTableDetail .="<a href='index.php?_mod=".$mod."&no=".$no."'><div class='content-table' ><span class='head'>$subject</span><span class='typename'>หมวด$typename</span><div class='datestyle'>$datepost</div></div></a>";
					}
				}
		}
	}
}else{
	$sqltype="select * from tb_searchtype where id='$searchtype'";
	$rsType=rsQuery($sqltype);
	if($rsType){
		$dType=mysqli_fetch_assoc($rsType);
			$tablename=$dType['tablename'];
			$typename=$dType['name'];
			$mod=encode64($dType['modname']);
			$sql="select * from $tablename where subject like '$value'".$sql2;
			$rsFind=rsQuery($sql);
				if($rsFind){
					while($data=mysqli_fetch_assoc($rsFind)){
						$subject=$data['subject'];
						$no=encode64($data['no']);
						$datepost=DateThai($data['datepost']);
						$count +=1;
						$strTableDetail .="<a href='index.php?_mod=".$mod."&no=".$no."'><div class='content-table' ><span class='head'>$subject</span><span class='typename'>หมวด$typename</span><div class='datestyle'>$datepost</div></div></a>";
					}
				}
	}
}
}
?>
<br><br>

<div class='content-table' style="width:90%;">
<div class='title'>
	<?php echo "คำค้นหา $value1 ค้นหาพบ ".$count ." รายการ";?>
</div>
<br>
	<?php echo $strTableDetail;?>
</div>

