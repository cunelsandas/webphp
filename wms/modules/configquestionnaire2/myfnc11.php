<?php
function rsQueryBis($sql,$searchvalue=null){
	$server = "localhost";
	$user ="root";
	$pw = "";
	$db = "c1bis_itglobal";
	$dsn = "mysql:host=".$server.";dbname=".$db.";charset=utf8";
	$options = [
		PDO::ATTR_EMULATE_PREPARES   => false, // turn off emulation mode for "real" prepared statements
		PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
	];
	try {
		$pdo = new PDO($dsn, $user, $pw, $options);
		$stmt = $pdo->prepare($sql);
			if($searchvalue==null){
				$stmt->execute();
			}else{
				$stmt->execute(array($searchvalue));
			}
	
		return $stmt;
		$stmt = null;
	} 
	catch (PDOException $e) {
		error_log($e->getMessage());
		exit('Connection To Bis Error : '.$e->getMessage().''); //something a user can understand
	}
	
}
function connect(){
	
//	$user="c1itglobal";
//	$pw='^_^Itg46*_*';
//	$db="c1bis_itglobal";
	global $g_user;
	global $g_pw;
	global $g_db;

	$server = "localhost";
	$user = $g_user;
	$pw = $g_pw;
	$db = $g_db;
	$dsn = "mysql:host=".$server.";dbname=".$db.";charset=utf8";
	$options = [
		PDO::ATTR_EMULATE_PREPARES   => false, // turn off emulation mode for "real" prepared statements
		PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
	];
	try {
		$pdo = new PDO($dsn, $user, $pw, $options);
		return $pdo;
	} 
	catch (PDOException $e) {
		error_log($e->getMessage());
		exit('Connection Error : '.$e->getMessage().''); //something a user can understand
	}
	
}
	###################### Function Query ลดขั้นตอนการเขียนโค้ด  ##############
function rsQuery($sql,$searchvalue=null){ 
	try{
		$pdo=connect();
		$stmt = $pdo->prepare($sql);
			if($searchvalue==null){
				$stmt->execute();
			}else{
				$stmt->execute($searchvalue);
			}
	
		return $stmt;
		$stmt = null;
	}
	catch (PDOException $e) {
		error_log($e->getMessage());
		exit('rsQuery Error : [ SQL=>'.$sql.' ]<br>'.$e->getMessage().''); //something a user can understand
		
	}

}
########################## จบ Function #############################################################

function rsField($sql,$return_fieldname,$searchvalue=null){
// fetch data 1 field
// return_fieldname = ฟิลที่ต้องการส่งค่ากลับ
// searchvalue = ค่าที่ต้องการ query
	
	try{
		$pdo=connect();
		$stmt=$pdo->prepare($sql);
		if($searchvalue==null){
			$stmt->execute();
		}else{
			$stmt->execute($searchvalue);
		}
		$row=$stmt->fetch();
		if($stmt->rowCount()>0){
			$value=$row[$return_fieldname];
		}else{
			$value="Not Found";
		}
		return $value;
		$stmt = null;
	}
	catch (PDOException $e) {
		error_log($e->getMessage());
		exit('rsField Error :[ SQL=>'.$sql.' ]<br> '.$e->getMessage().''); //something a user can understand
		
	}
}

function FindRS($sql,$return_fieldname,$searchvalue=null){
	try{
		$pdo=connect();
		$stmt=$pdo->prepare($sql);
		if($searchvalue==null){
			$stmt->execute();
		}else{
			$stmt->execute([$searchvalue]);
		}
		$row=$stmt->fetch();
		if($stmt->rowCount()>0){
			$value=$row[$return_fieldname];
		}else{
			$value="Not Found";
		}
		return $value;
		$stmt = null;
	}
	catch (PDOException $e) {
		error_log($e->getMessage());
		exit('FindRS Error : [ SQL=>'.$sql.' ]<br>'.$e->getMessage().''); //something a user can understand
		
	}
}


function thaidate($vardate="") { 
	$_month_name = array("01"=>"มกราคม",  "02"=>"กุมภาพันธ์",  "03"=>"มีนาคม",  
    "04"=>"เมษายน",  "05"=>"พฤษภาคม",  "06"=>"มิถุนายน",  
    "07"=>"กรกฎาคม",  "08"=>"สิงหาคม",  "09"=>"กันยายน",  
    "10"=>"ตุลาคม", "11"=>"พฤศจิกายน",  "12"=>"ธันวาคม");
	/*
	$yy =substr($vardate,0,4);
	$mm =substr($vardate,5,2);
	$dd =substr($vardate,8,2);
	*/
	$yy=substr($vardate,0,4);
	$mm=substr($vardate,5,2);
	$dd=substr($vardate,8,2);

	$yy += 543;
	if ($yy==543){
		$dateT = "-";
	}else{
		$dateT=$dd ." ".$_month_name[$mm]."  ".$yy;
	 }
  return $dateT;
} 

#############################
function calage($pbday){
	$today=date("d/m/Y");
	list($bday,$bmonth,$byear)=explode("/",$pbday);
	list($tday,$tmonth,$tyear)=explode("/",$today);
	 if($byear<1970){
		 $yearad=(1970-$byear);
		 $byear=1970;
		}else{
		$yearad=0;
		}
  $mbirth=mktime(0,0,0,$bmonth,$bday,$byear);
  $mnow=mktime(0,0,0,$tmonth,$tday,$tyear);

  $mage=($mnow-$mbirth);
  $age = (date("Y",$mage)-1970+$yearad)."ปี".(date("m", $mage)-1)."เดือน".(date("d", $mage)-1)."วัน"; return($age);
  }


#########################################
function calyearage($pbday){
	$today=date("d/m/Y");
	list($bday,$bmonth,$byear)=explode("/",$pbday);
	list($tday,$tmonth,$tyear)=explode("/",$today);
	 if($byear<1970){
		 $yearad=(1970-$byear);
		 $byear=1970;
		}else{
		$yearad=0;
		}
  $mbirth=mktime(0,0,0,$bmonth,$bday,$byear);
  $mnow=mktime(0,0,0,$tmonth,$tday,$tyear);

  $mage=($mnow-$mbirth);
  $age = (date("Y",$mage)-1970+$yearad)."ปี"; 
  return($age);
  }

#########################################
function calworktime($pbday,$today){
	//$today = date("d/m/Y");
	list($bady , $bmonth , $byear) = explode("/" , $pbday);
	list($tday , $tmonth , $tyear) = explode("/" , $today);

	 if($byear < 1970){

	 $yearad=1970-$byear;
	 $byear =1970;
 }else{
  $yearad = 0;}
 
  $mbirth = mktime(0,0,0,$bmonth,$bday,$byear);
  $mnow = mktime(0,0,0,$tmonth,$tday,$tyear);


  $mage=($mnow-$mbirth);
  $age = (date("Y",$mage)-1970 + $yearad)."ปี".(date("m", $mage)-1)."เดือน".(date(“d”, $mage)-1)."วัน" ; return($age);
  }

#########################################

function thaimonthyear($vardate="") { 
	$_month_name = array("01"=>"มกราคม",  "02"=>"กุมภาพันธ์",  "03"=>"มีนาคม",  
    "04"=>"เมษายน",  "05"=>"พฤษภาคม",  "06"=>"มิถุนายน",  
    "07"=>"กรกฎาคม",  "08"=>"สิงหาคม",  "09"=>"กันยายน",  
    "10"=>"ตุลาคม", "11"=>"พฤศจิกายน",  "12"=>"ธันวาคม");
	/*
	$yy =substr($vardate,0,4);
	$mm =substr($vardate,5,2);
	$dd =substr($vardate,8,2);
	*/
	$yy=substr($vardate,0,4);
	$mm=substr($vardate,5,2);
	$dd=substr($vardate,8,2);

	$yy += 543;
	if ($yy==543){
		$dateT = "-";
	}else{
		$dateT=$_month_name[$mm]."  ".$yy;
	 }
  return $dateT;
} 



######################
function DateThai($strDate)
{
$strYear = date("Y",strtotime($strDate))+543;
$strYearShort = (date("Y",strtotime($strDate))+543)-2500;
$strMonth= date("n",strtotime($strDate));
$strDay= date("j",strtotime($strDate));
$strHour= date("H",strtotime($strDate));
$strMinute= date("i",strtotime($strDate));
$strSeconds= date("s",strtotime($strDate));
$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
$strMonthThai=$strMonthCut[$strMonth];
return "$strDay $strMonthThai $strYearShort"; //, $strHour:$strMinute";
} 


function DateTimeThai($strDate)
{
$strYear = date("Y",strtotime($strDate))+543;
$strYearShort = (date("Y",strtotime($strDate))+543)-2500;
$strMonth= date("n",strtotime($strDate));
$strDay= date("j",strtotime($strDate));
$strHour= date("H",strtotime($strDate));
$strMinute= date("i",strtotime($strDate));
$strSeconds= date("s",strtotime($strDate));
$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
$strMonthThai=$strMonthCut[$strMonth];
return "$strDay $strMonthThai $strYearShort $strHour:$strMinute:$strSeconds";
} 



######################
function MyGetDate($strDate,$Type)
{
	if($strDate==""){
		return "";
	}else{
		$tmpdate=explode("-",$strDate);
		list($tmpyear,$tmpmonth,$tmpday)=$tmpdate;
		if($Type=="m"){
			return "$tmpmonth";
		}
		if($Type=="d"){
			return "$tmpday";
		}
		if($Type=="y"){
			return "$tmpyear";
		}
	}
}
function MonthName($strMonth,$Type){
	if($strMonth==""){
		return "no month";
	}
	if($Type=="th"){
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		return $strMonthCut[$strMonth];
	}

}
function DateEng($strDate)
{
	if ($strDate==""){
		return "";
	}
	else {
	$tmpdate=explode("/",$strDate);
	list($tmpDate,$tmpMonth,$tmpYear)=$tmpdate;
	$engYear=$tmpYear-543;
	return "$engYear-$tmpMonth-$tmpDate";
	//$strYear=date("Y",strtotime($strDate));
	//$strMonth=date("n",strtotime($strDate));
	//$strDay=date("j",strtotime($strDate));
	//return "$strYear-$strMonth-$strDay";
	}
}
######################
function FirstDayOfMonth($strDate){
	if($strDate==""){
		return "";
	}else{
		$tmpdate=explode("-",$strDate);
		list($tmpYear,$tmpMonth,$tmpDate)=$tmpdate;
		return "$tmpYear-$tmpMonth-1";
	}
}
function LastDayOfMonth($strDate){
		if($strDate==""){
			return "";
		}else{
			$lastday = date('t',strtotime($strDate));
			$tmpdate=explode("-",$strDate);
			list($tmpYear,$tmpMonth,$tmpDate)=$tmpdate;
			return "$tmpYear-$tmpMonth-$lastday";
		}
}
function ThaiYear($strDate)
{
	if($strDate==""){
		return"";
		}
		else {
			$tmpdate=explode("-",$strDate);
			list($tmpYear,$tmpMonth,$tmpDate)=$tmpdate;
			$ThaiYear=$tmpYear+543;
			return "$tmpDate/$tmpMonth/$ThaiYear";
		}
}
function YearThai($strDate)
{
	if($strDate==""){
		return"";
		}
		else {
			$tmpdate=explode("-",$strDate);
			list($tmpYear,$tmpMonth,$tmpDate)=$tmpdate;
			$ThaiYear=$tmpYear+543;
			return "$ThaiYear";
		}
}
/*$timedate=date("m-d-Y");*/



/*$configpath=$_SERVER['DOCUMENT_ROOT']."/web"; // ตัวกำหนด PATH ของ ที่เก็บไฟล์
$dochkpath=file_exists($configpath);
if(!$dochkpath){
	echo"<p style=\"font-size:14px;font-weight:bold;color:red;\">กรุณาตรวจสอบ ตัวแปร \$configpath ใน connect.inc.php ด้วยค่ะ มีการกำหนดไม่ถูกต้อง</p>";
	echo"<p style=\"font-size:14px;font-weight:bold;color:red;\">ตัวแปร \$configpath คือ $configpath </p>";
	exit();
}*/

######################

function UpdateTrans($tablename,$event,$username,$value1,$value2){
	
	$sql="INSERT INTO systemlog(tablename,event,username,value1,value2) VALUES('".$tablename."','".$event."','".$username."','".$value1."','".$value2."')";
	
	$rs=rsQuery($sql);

}
######################
function UpdateTransWeb($tablename,$event,$username,$value1,$value2){
	
	$sql="INSERT INTO weblog(tablename,event,username,value1,value2) VALUES('".$tablename."','".$event."','".$username."','".$value1."','".$value2."')";
	
	$rs=rsQuery($sql);
	
}
function getBrowser()
{
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";
	$device="";
	
	if (preg_match('/mobile/i', $u_agent)) {
        $device = 'Mobile';

    }else{
		$device="Computer";
	}
    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'Linux';
    }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'Mac';
    }
    elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'Windows';
    }
	elseif(preg_match('/Android/i',$u_agent)){
		$platform='Android';
	}
   
    // Next get the name of the useragent yes seperately and for good reason
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    }
    elseif(preg_match('/Firefox/i',$u_agent))
    {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    }
    elseif(preg_match('/Chrome/i',$u_agent))
    {
        $bname = 'Google Chrome';
        $ub = "Chrome";
    }
    elseif(preg_match('/Safari/i',$u_agent))
    {
        $bname = 'Apple Safari';
        $ub = "Safari";
    }
    elseif(preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Opera';
        $ub = "Opera";
    }
    elseif(preg_match('/Netscape/i',$u_agent))
    {
        $bname = 'Netscape';
        $ub = "Netscape";
    }
   
    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }
   
    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }
        else {
            $version= $matches['version'][1];
        }
    }
    else {
        $version= $matches['version'][0];
    }
   
    // check if we have a number
    if ($version==null || $version=="") {$version="?";}
   
    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'   => $pattern,
		'device'	=> $device
    );
}
######################
function getbrowser_old(){
$agent = $_SERVER['HTTP_USER_AGENT'];
if(eregi("Netcaptor", $agent)){ $browser = "Netcaptor";
} elseif(eregi("(opera) ([0-9]{1,2}.[0-9]{1,3}){0,1}", $agent, $ver) || eregi("(opera/)([0-9]{1,2}.[0-9]{1,3}){0,1}", $agent, $ver)){ $browser = "Opera $ver[2]";
} elseif(eregi("(konqueror)/([0-9]{1,2}.[0-9]{1,3})", $agent, $ver)){ $browser = "Konqueror $ver[2]";
} elseif(eregi("(lynx)/([0-9]{1,2}.[0-9]{1,2}.[0-9]{1,2})", $agent, $ver)){ $browser = "Lynx $ver[2]";
} elseif(eregi("(msie) ([0-9]{1,2}.[0-9]{1,3})", $agent, $ver)){ $browser = "IE$ver[2]";
} elseif(eregi("Links", $agent)){ $browser = "Lynx";
} elseif(eregi("(Firebird/)([0-9]{1,2}.[0-9]{1,3}){0,1}", $agent, $ver)){ $browser = "Firebird $ver[2]";
} elseif(eregi("(Firefox/)([0-9]{1,2}.[0-9]{1,2}.[0-9]{1,2})", $agent, $ver)){ $browser = "FireFox";
} elseif(eregi("Mozilla/5",$agent)){$browser = "Netscape 5";
} elseif(eregi("Gecko", $agent)){ $browser = "Mozilla";
} elseif(eregi("Safari",$agent)){ $browser = "OS-X Safari";
} elseif(eregi("(netscape6)/(6.[0-9]{1,3})", $agent, $ver)){ $browser = "Netscape $ver[2]";
} elseif(eregi("(Mozilla)/([0-9]{1,2}.[0-9]{1,3})", $agent, $ver)){ $browser = "Netscape $ver[2]";
} elseif(eregi("Galeon", $agent)){ $browser = "Galeon";
} elseif(eregi("(lynx)/([0-9]{1,2}.[0-9]{1,2}.[0-9]{1,2})", $agent, $ver) ){$browser = "Lynx $ver[2]";
} elseif(eregi("Avant Browser", $agent)){ $browser = "Avant";
} elseif(eregi("(omniweb/)([0-9]{1,2}.[0-9]{1,3})", $agent, $ver) ){$browser = "OmniWeb $ver[2]";
} elseif(eregi("ZyBorg|WebCrawler|Slurp|Googlebot|MuscatFerret|ia_archiver", $agent)){ $browser = "Web indexing robot";
} elseif(eregi("(webtv/)([0-9]{1,2}.[0-9]{1,3})", $agent, $ver) ){$browser = "WebTV $ver[2]";
} else {$browser = "Unknown";}
return $browser;
}
######################

//หาวันแรกของเดือน
function firstOfMonth() {
return date("Y-m-d", strtotime(date('m').'/01/'.date('Y').' 00:00:00'));
}
######################

//หาวันสุดท้ายของเดือน
function lastOfMonth() {
return date("Y-m-d", strtotime('-1 second',strtotime('+1 month',strtotime(date('m').'/01/'.date('Y').' 00:00:00'))));
}

function DateDiff($strDate1,$strDate2)
	{
		return (strtotime($strDate2) - strtotime($strDate1))/ ( 60 * 60 * 24 ); // 1 day = 60*60*24
	}

function TimeDiff($strTime1,$strTime2)
{
return (strtotime($strTime2) - strtotime($strTime1))/ ( 60 * 60 ); // 1 Hour = 60*60
}

function DateTimeDiff($strDateTime1,$strDateTime2)
{
return (strtotime($strDateTime2) - strtotime($strDateTime1))/ ( 60 * 60 ); // 1 Hour = 60*60
}

//คำนวณอายุ วัน เวลา
function timespan($seconds = 1, $time = '')
{
	if ( ! is_numeric($seconds))
	{
		$seconds = 1;
	}
 
	if ( ! is_numeric($time))
	{
		$time = time();
	}
 
	if ($time <= $seconds)
	{
		$seconds = 1;
	}
	else
	{
		$seconds = $time - $seconds;
	}
 
	$str = '';
	$years = floor($seconds / 31536000);
 
	if ($years > 0)
	{	
		$str .= $years.' ปี, ';
	}	
 
	$seconds -= $years * 31536000;
	$months = floor($seconds / 2628000);
 
	if ($years > 0 OR $months > 0)
	{
		if ($months > 0)
		{	
			$str .= $months.' เดือน, ';
		}	
 
		$seconds -= $months * 2628000;
	}
 
	$weeks = floor($seconds / 604800);
 
	if ($years > 0 OR $months > 0 OR $weeks > 0)
	{
		if ($weeks > 0)
		{	
			$str .= $weeks.' สัปดาห์, ';
		}
 
		$seconds -= $weeks * 604800;
	}			
 
	$days = floor($seconds / 86400);
 
	if ($months > 0 OR $weeks > 0 OR $days > 0)
	{
		if ($days > 0)
		{	
			$str .= $days.' วัน, ';
		}
 
		$seconds -= $days * 86400;
	}
 
	$hours = floor($seconds / 3600);
 
	if ($days > 0 OR $hours > 0)
	{
		if ($hours > 0)
		{
			$str .= $hours.' ชั่วโมง, ';
		}
 
		$seconds -= $hours * 3600;
	}
 
	$minutes = floor($seconds / 60);
 
	if ($days > 0 OR $hours > 0 OR $minutes > 0)
	{
		if ($minutes > 0)
		{	
			$str .= $minutes.' นาที, ';
		}
 
		$seconds -= $minutes * 60;
	}
 
	if ($str == '')
	{
		$str .= $seconds.' วินาที';
	}
 
	return substr(trim($str), 0, -1);
}
// ตัวอย่างการใช้งาน
// $birthdate = strtotime( '1973-11-13' );
// $today = time();
 
//  echo timespan( $birthdate , $today );
//36 ปี, 2 เดือน, 3 สัปดาห์, 2 วัน, 4 ชั่วโมง, 51 นาท

//คำนวณอายุ วัน 
function AgeSpan($seconds = 1, $time = '')
{
	if ( ! is_numeric($seconds))
	{
		$seconds = 1;
	}
 
	if ( ! is_numeric($time))
	{
		$time = time();
	}
 
	if ($time <= $seconds)
	{
		$seconds = 1;
	}
	else
	{
		$seconds = $time - $seconds;
	}
 
	$str = '';
	$years = floor($seconds / 31536000);
 
	if ($years > 0)
	{	
		$str .= $years.' ปี, ';
	}	
 
	$seconds -= $years * 31536000;
	$months = floor($seconds / 2628000);
 
	if ($years > 0 OR $months > 0)
	{
		if ($months > 0)
		{	
			$str .= $months.' เดือน, ';
		}	
 
		$seconds -= $months * 2628000;
	}
 
	$weeks = floor($seconds / 604800);
 
	if ($years > 0 OR $months > 0 OR $weeks > 0)
	{
		//if ($weeks > 0)
	//	{	
	//		$str .= $weeks.' สัปดาห์, ';
	//	}
 
	//	$seconds -= $weeks * 604800;
	}			
 
	$days = floor($seconds / 86400);
 
	if ($months > 0 OR $weeks > 0 OR $days > 0)
	{
		if ($days > 0)
		{	
			$str .= $days.' วัน, ';
		}
 
		$seconds -= $days * 86400;
	}
 
	$hours = floor($seconds / 3600);
 
	if ($days > 0 OR $hours > 0)
	{
//		if ($hours > 0)
//		{
	//		$str .= $hours.' ชั่วโมง, ';
	//	}
 
		$seconds -= $hours * 3600;
	}
 
	$minutes = floor($seconds / 60);
 
	if ($days > 0 OR $hours > 0 OR $minutes > 0)
	{
//		if ($minutes > 0)
	//	{	
	//		$str .= $minutes.' นาที, ';
	//	}
 
		$seconds -= $minutes * 60;
	}
 

	return substr(trim($str), 0, -1);
}


function DateEngToThai($strDate)
{
	if($strDate==""){
		return"";
		}
		else {
			$tmpdate=explode("-",$strDate);
			list($tmpYear,$tmpMonth,$tmpDate)=$tmpdate;
			$ThaiYear=$tmpYear+543;
			return "$tmpDate/$tmpMonth/$ThaiYear";
		}
}

function DateThaiToEng($strDate)
{
	if ($strDate==""){
		return "";
	}
	else {
	$tmpdate=explode("/",$strDate);
	list($tmpDate,$tmpMonth,$tmpYear)=$tmpdate;
	$engYear=$tmpYear-543;
	return "$engYear-$tmpMonth-$tmpDate";
	//$strYear=date("Y",strtotime($strDate));
	//$strMonth=date("n",strtotime($strDate));
	//$strDay=date("j",strtotime($strDate));
	//return "$strYear-$strMonth-$strDay";
	}
}

function ChangeYear_ori($strDate,$strType){
	// $strType คือประเภท en คศ , th พศ
	if ($strDate==""){
		return "";
	}
	if($strDate=="0000-00-00"){
		return "0000-00-00";
	}
	else {
		
	$tmpdate=explode("-",$strDate);
	list($tmpYear,$tmpMonth,$tmpDate)=$tmpdate;
	if($strType=="en"){
		$engYear=$tmpYear-543;
	}elseif($strType=="th"){
		$engYear=$tmpYear+543;
	}else{
		$engYear="0000";
	}
	return "$engYear-$tmpMonth-$tmpDate";
	
	}
}
function ChangeYear($strDate,$strType){
	// $strType คือประเภท en คศ , th พศ
	
	if($strDate=="0000-00-00" || $strDate==null ||$strDate==""){
		return null;
	}else {
		if($strType=="en"){
				$tmpdate=explode("/",$strDate);
				list($tmpDate,$tmpMonth,$tmpYear)=$tmpdate;
				$newYear=$tmpYear-543;
				$newvalue=$newYear."-".$tmpMonth."-".$tmpDate;
		}
			if($strType=="th"){
				$tmpdate=explode("-",$strDate);
				list($tmpYear,$tmpMonth,$tmpDate)=$tmpdate;
				$newYear=$tmpYear+543;
				$newvalue=$tmpDate."/".$tmpMonth."/".$newYear;
	
	}
	return $newvalue;
	
	}
}

// ทำการ escape string ป้องกัน injection
function EscapeValue($string){
	//$value=$con->real_escape_string(strip_tags($string));
	$string1=strip_tags($string);
	$value=($string1);
	return $value;
	

}


// ทำfunction แทน mysql_result  ใน mysqli
	function mysqli_result($result, $row, $field = 0) {
    // Adjust the result pointer to that specific row
    $result->data_seek($row);
    // Fetch result array
    $data = $result->fetch_assoc();
 
    return $data[$field];
	$result->free();
}

function SystemValue($field){
	$con=connect();
	$sql="select * from system where name='$field'";
	$rs=$con->query($sql);
	if($rs){
		$row=$rs->fetch_assoc();
		return $row['data'];
	}
}

$gloUploadFileType=array('jpeg','jpg','gif','png','bmp','pdf');

	function CheckFileUpload($strFileName,$strFileSize,$strLimitSize,$strSizeInMb,$str_x){
		$gloUploadFileType=array('jpeg','jpg','gif','png','bmp','pdf');
	//วนเช็ค file type
		$allowed=$gloUploadFileType;
		$filename=strtolower($strFileName);
		$x=$str_x;
		$SizeInMb=$strSizeInMb;
		$limitsize=$strLimitSize;
		$size=$strFileSize;
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		
		if($filename<>""){
			if( ! in_array( $ext, $allowed ) ) {
				$strHtml="<p>ไฟล์ที่ ".$x." ". $filename." ไม่ตรงกับไฟล์ ";
				for ($i = 0; $i < count($allowed); $i++){
					  $strHtml.= $allowed[$i] . ",";
				}
				$strHtml.= " ไม่สามารถอัพโหลดได้</p>";
				$strHtml.="<a href=\"javascript:window.history.back();\">ย้อนกลับ</a>";
				
				return array("no",$strHtml);
				exit();
			}
			if($size>$limitsize){
				$strHtml="<p>ไฟล์ที่ ".$x." มีขนาดใหญ่เกินกว่า". $SizeInMb." Mb</p>";
				$strHtml.="<a href=\"javascript:window.history.back();\">ย้อนกลับ</a>";
				
				return array("no",$strHtml);
				exit();
			}
		}
			
	}
function ShowAllowedFileUpload($strFileAllowed){
			for ($i = 0; $i < count($strFileAllowed); $i++){
			   $strFileType.= $strFileAllowed[$i] . ",";
			}
			return $strFileType;
}

function isImage($filename){
	$img = getimagesize($filename);
	if($img!== false){
			return "image";
	}else{
		return "no";
	}
}

function resizeimage($tmp_images,$tmp_newfile,$tmp_foldername,$tmp_text,$tmp_width,$tmp_showwatermark){  // $images ไฟล์ต้นฉบับ , $newfile ชื่อไฟล์ใหม่ , $foldername ที่เก็บไฟล์ , $tmp_text ลายน้ำ , $tmp_width ผู้ใช้กำหนดความกว้างเอง ค่าdefault=0ระบบกำหนดให้,$tmp_showwatermark ให้แสดง่ลายน้ำหรือไม่ true แสดง false ไม่แสดง default=true
				$images=$tmp_images;
				$newfile=$tmp_newfile;
				$foldername=$tmp_foldername;
				if($tmp_showwatermark=='false'){
					$watermark="";
				}else{
					$watermark=$tmp_text;
				}
				if($tmp_width=='0'){
					$width=640;   // กำหนดความกว้างของรูปใหม่
				}else{
					$width=$tmp_width;  // ถ้ามีการส่งค่ามาให้ใช้ค่าที่ส่งมา
				}
				$size=getimagesize($images);  // $size[0]=width , [1]=height ,[2]=imagetype ค่า 1=gif ,2=jpg ,3=png ,4=swf,5=psd,6=bmp
				//$images_orig = ImageCreateFromJPEG($images);
				if($size[0]<$width){  // ถ้าขนาดรูปเล็กกว่าค่าที่กำหนด ให้ใช้ขนาดรูปแทนค่าที่กำหนด
						$width=$size[0];
				}
				$height=round($width*$size[1]/$size[0]);  // [1]=height , [0]=width
				switch($size["mime"]){
					case "image/jpeg":
						$images_orig = imagecreatefromjpeg($images); //jpeg file
						break;
					 case "image/gif":
						$images_orig = imagecreatefromgif($images); //gif file
						break;
					case "image/png":
						$images_orig = imagecreatefrompng($images); //png file
						break;	
				}

				//พิมพ์ลายน้ำ
				$scale=$size[0]/$width; //หาขนาดอัตราส่วนความยาวfont ให้เต็มขนาดความกว้างของรูป
				$fontsize=60*$scale;  //กำหนดขนาด font
				$textposition=$fontsize*1.15;  //กำหนดตำแหน่ง x,y
				$font = 'font/angsaz.ttf';  //ให้วางไว้ใน wms
				//$textcolor = imagecolorallocate($images_orig,245,245,245); // สีตัวอักษรwhite smoke  light blue(173,216,230)   gray(190,190,190)  snow3(205,201,201)
				$textcolor = imagecolorallocatealpha($images_orig,245,245,245,75);
				imagettftext($images_orig, $fontsize, 0, $textposition,$textposition, $textcolor, $font, $watermark);
				//จบ พิมพ์ลายน้ำ

				$photoX = ImagesX($images_orig);
				$photoY = ImagesY($images_orig);
				$images_fin = ImageCreateTrueColor($width, $height);

				ImageCopyResampled($images_fin, $images_orig, 0, 0, 0, 0, $width+1, $height+1, $photoX, $photoY);
				switch($size["mime"]){
					case "image/jpeg":
						ImageJPEG($images_fin,$_SERVER['DOCUMENT_ROOT'].$foldername.$newfile);
						break;
					case "image/gif":
						ImageGIF($images_fin,$_SERVER['DOCUMENT_ROOT'].$foldername.$newfile);
						break;
					case "image/png":
						ImagePNG($images_fin,$_SERVER['DOCUMENT_ROOT'].$foldername.$newfile);
						break;
				}
				ImageDestroy($images_orig);
				ImageDestroy($images_fin);
				return "Upload Image Complete";
	}		

function encode64($data) {
  return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function decode64($data) {
  return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
}

function SearchImage($tablename,$masterid,$foldername,$default_image){
	//สำหรับค้นหาภาพ ถ้าเป็น pdf ให้แสดงไฟล์ pdf.jpg ถ้าไม่พบไฟล์ให้แสดงไฟล์ notfound.jpg
	// ค่า default_image ถ้าส่งมาเป็น 0 แสดงว่าให้ใช้ค่าdefault หรือสามารถกำหนดชื่อไฟล์ที่ต้องการให้แสดงได้เอง
					
					$strSql="select * from filename where tablename='".$tablename."' AND masterid='".$masterid."' Order by Rand() limit 1";
					$rs2=rsQuery($strSql);
					$rs_filename=$rs2->fetch();
					$type=strtolower(substr($rs_filename['filename'],-3));
					$cpic=file_exists($foldername.$rs_filename['filename']);
				if(!empty($rs_filename)){
					if($cpic){
						if($type=='pdf'){
							$filepath="images/pdf.gif";
						}else{
							$filepath=$foldername.$rs_filename['filename'];
						}
					}else{
						if($default_image=="0"){
						$filepath="images/notfound.jpg";
						}else{
							$filepath="images/".$default_image;
						}
					}
				}else{
					$filepath="images/notfound.jpg";
				}

					return $filepath;
					
}

?>