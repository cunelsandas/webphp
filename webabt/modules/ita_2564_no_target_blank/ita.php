<style>
	.body-bg_ita{
		margin-top:20px;
		padding:20px;
		background-color:white;
}
	.submenu_ita{
	margin-left:30px;
	padding:5px;
	color:#3e9f40;
}
	.detail_ita{
	margin-left:50px;
	padding:5px;
	font-size:13px;

	}
	.itgtoggle{
		padding:10px;
		color:#0000ff;
		background-color:#e2e2e2;
		border:solid 0.5px #8d8d8d;
		font-size:16px;

	}
	.itgtoggle:hover{
		color:#ff0000;
	}
	.header_ita{
		color:#000080;
	}
    a{
    color: black;
    }
</style>
<div class='body-bg_ita'><p class='header_ita'>แบบประเมิน ITA (Integrity and Transparency Assessment) พ.ศ. 2564</p><p class='header_ita'><?php echo $customer_name;?></p><br>
<?php
	$sql="select * from tb_ita_menu_2564 Order by listno ASC";
	$rs=rsQuery($sql);
	if($rs){
		$strTable .="<dl >";
		while($data=mysqli_fetch_assoc($rs)){
			$id=$data['id'];
			$name=$data['name'];
			$strTable .="<div class='itgmenudata'><div class='itgtoggle'><dt>$name</dt>";
			$sql_sub="select * from tb_ita_submenu_2564 where menuid=$id Order by listno ASC";
				$rsSub=rsQuery($sql_sub);
				if($rsSub){
					$strTable .="</div><ul class='itghidedata' style='display:none;'>";
					while($dataSub=mysqli_fetch_assoc($rsSub)){
						$submenuid=$dataSub['id'];
						$subname=$dataSub['name'];
						$strTable .="<li class='submenu_ita'>$subname</li>";
						$sql_detail="select * from tb_ita_detail_2564 where submenuid=$submenuid Order by listno ASC";
						$rsDetail=rsQuery($sql_detail);
						if($rsDetail){
							$strTable .="<ul>";
							while($dataDetail=mysqli_fetch_assoc($rsDetail)){
								$detailid=$dataDetail['id'];
								$detailname=$dataDetail['name'];
								$modid=$dataDetail['modid'];
								$modname=$dataDetail['modname'];
								$link=$dataDetail['link'];
								if($link<>null || $link<>""){
									$strTable .="<li class='detail_ita'><a href='$link'>$detailname</a></li>";
								}else{
									$strTable .="<li class='detail_ita' style='color:#589a80;'>$detailname</li>";
								}
							}
							$strTable .="</ul>";
						}

					}
					$strTable .="</ul></div>";
				}

		}
		$strTable .="</dl>";
	}
		echo "<div style='text-align:left;'>";
		echo $strTable;
		echo "</div>";

		//http://songkwae.go.th/index.php?_mod=aXRh
?>
</div>

<SCRIPT language="javascript" type="text/javascript">
$(document).ready(function(){
// TOGGLE SCRIPT
	$('.itghidedata').hide();
	$('.itgmenudata').css('cursor', 'pointer');
 	$('div.itgtoggle').click(function(event){
	$(this).parents('.itgmenudata').find('.itghidedata').slideToggle("fast");
		return false;
	}); // END TOGGLE
 });
</script>
