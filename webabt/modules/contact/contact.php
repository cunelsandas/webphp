<?php
	$mod=EscapeValue(decode64($_GET['_mod']));
	$tablename=FindRS("select * from tb_mod where modtype='$mod'","tablename");
	$folder=FindRS("select * from tb_mod where modtype='$mod'","foldername");
	$modname=FindRS("select * from tb_mod where modtype='$mod'","modname");
	$bannername=FindRS("select * from tb_mod where modtype='$mod'","bannername");
	$foldername=$gloUploadPath."/".$folder."/";
	if(file_exists("images/".$bannername) and $bannername<>""){
			echo "<script>ChangeCssBg('data_image','".$bannername."');</script>";
		}else{
			echo "<p class='banner_title'>$modname</p>";
	}
	$sql="select * from $tablename";
	$rs=rsQuery($sql);
	if($rs){
		$data=mysqli_fetch_array($rs);
		echo $data['detail'];
	}

if($customer_lat<>"" and $customer_lng<>""){
	$google_apikey="AIzaSyDg49SZLUZdLu8KQ80fEAPJkbdBUqyN-vw";
?>
<div id="default-map" style="border:solid 3px #ffff99;width:90%;height:560px;padding:5px;box-shadow:5px 5px 5px #000000;background-color:#ffffcc" valign="center" align="center">
			<div id="googleMap" style="width:100%;height:540px;"></div><BR><BR>
			</div>
  <!--<script src="http://maps.googleapis.com/maps/api/js"></script>-->
    <script
            src="https://maps.googleapis.com/maps/api/js?key=<?php echo $google_apikey;?>&callback=initMap&libraries=&v=weekly"
            defer
    ></script>

  <script>
      function initMap() {
          const myLatLng = { lat: <?php echo $customer_lat;?>, lng: <?php echo $customer_lng;?> };
          const map = new google.maps.Map(document.getElementById("googleMap"), {
              zoom: 15,
              center: myLatLng,
          });
          new google.maps.Marker({
              position: myLatLng,
              map,
              title: "Hello World!",
          });
      }
</script>
	<style>
			#tb1 table{
				background:#ccffff;
				color:#006600;
			}
			#tb1 td{
				background:#99cc00;
				color:#990000;
			}
			#tb1 td:hover{
				background:#ffff99;
			}
				#tb2 table{
				background:#ff9900;
				color:#000000;
				}
				#tb2 td:hover{
				background:#ff6600;
			}
				#tb3 table{
				background:#82cace;
				color:#000000;
				}

				#tb3 th{
				background:#214550;
				color:#ffffff;
				}
				#tb3 td{
				background:#428a9f;
				color:#ffffff;
				}
				#tb3 td:hover{
				background:#b1e7c1;
				color:#000000;
			}
	</style>

	<?php }?>