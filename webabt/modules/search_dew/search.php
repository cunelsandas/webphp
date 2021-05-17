<html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<head>
<?php
	error_reporting(E_ALL);
	ini_set('error_reporting', E_ALL);
	ini_set('display_errors',1);
include('../../itgmod/connect.inc.php');

		$search=EscapeValue($_POST['txtsearch']);
		
		

$last_msg_id=$_GET['last_msg_id'];
$action=$_GET['action'];
echo "last_msg_id=".$last_msg_id;
echo "action=".$action;
if($action <> "get")
{
?>

<script type="text/javascript" src="jquery-1.2.6.pack.js"></script>
<script type="text/javascript">
$(document).ready(function()
{
function last_msg_funtion()
{
var ID=$(".message_box:last").attr("id");
$('div#last_msg_loader').html('<img src="bigLoader.gif">');

$.post("<?php echo $_SERVER["PHP_SELF"];?>?action=get&search=<?php echo $search;?>&last_msg_id="+ID,

function(data){
if (data != "") {
$(".message_box:last").after(data);
}
$('div#last_msg_loader').empty();
});
};

$(window).scroll(function(){
if ($(window).scrollTop() == $(document).height() - $(window).height()){
last_msg_funtion();
}
});
});
</script>
</head>
<body>
<?php
include('load_first.php'); //Include load_first.php
echo '<div id="last_msg_loader"></div>';
echo '</body>
</html>';
}else{
include('load_second.php'); //include load_second.php

}


		


?>
