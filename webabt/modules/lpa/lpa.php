<style>
    body{
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -khtml-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }
	.body-bg_lpa{
		margin-top:20px;
		padding:20px;
		background-color:white;
}
	.submenu_lpa{
	margin-left:30px;
	padding:5px;
	color:#3e9f40;
}
	.detail_lpa{
	margin-left:50px;
	padding:5px;
	font-size:13px;
	
	}
		
	.detail_lpa2{
	margin-left:80px;
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
	.header_lpa{
		color:#000080;
	}
</style>
<div class='body-bg_lpa'><p class='header_lpa'>แบบประเมิน LPA (Local Performance Assessment)</p><p class='header_lpa'><?php echo $customer_name;?></p><br>
<?php
	$sql="select * from tb_lpa_menu Order by listno ASC";
	$rs=rsQuery($sql);
	if($rs){
		$strTable .="<dl >";
		while($data=mysqli_fetch_assoc($rs)){
			$id=$data['id'];
			$name=$data['name'];
			$strTable .="<div class='itgmenudata'><div class='itgtoggle'><dt>$name</dt>";
			$sql_sub="select * from tb_lpa_submenu where menuid=$id Order by listno ASC";
				$rsSub=rsQuery($sql_sub);
				if($rsSub){
					$strTable .="</div><ul class='itghidedata' style='display:none;'>";
					while($dataSub=mysqli_fetch_assoc($rsSub)){
						$submenuid=$dataSub['id'];
						$subname=$dataSub['name'];
						$strTable .="<li class='submenu_lpa'>$subname</li>";
						$sql_detail="select * from tb_lpa_detail where submenuid=$submenuid Order by listno ASC";
						$rsDetail=rsQuery($sql_detail);
						$sql_detail2="select * from tb_lpa_detail2 where detailid=$detailid2 Order by listno ASC";
						$rsDetail2=rsQuery($sql_detail2);
						if($rsDetail){
							$strTable .="<ul>";
							while($dataDetail=mysqli_fetch_assoc($rsDetail)){
								$detailid=$dataDetail['id'];
								$detailname=$dataDetail['name'];
								$modid=$dataDetail['modid'];
								$modname=$dataDetail['modname'];
								$link=$dataDetail['link'];
								if($link<>null || $link<>""){
									$strTable .="<li class='detail_lpa'><a href='$link' target='_blank'>$detailname</a></li>";
								$sql_detail2="select * from tb_lpa_detail2 where detailid=$detailid Order by listno ASC";
								$rsDetail2=rsQuery($sql_detail2);
								if($rsDetail2){
									$strTable .="<ul>";
									while($dataDetail2=mysqli_fetch_assoc($rsDetail2)){
										$detail2id=$dataDetail2['id'];
										$detail2name=$dataDetail2['name'];
										$mod2id=$dataDetail2['modid'];
										$mod2name=$dataDetail2['modname'];
										$link2=$dataDetail2['link'];
										if($link2<>null || $link2<>""){
											$strTable .="<li class='detail_lpa2'><a href='$link2' target='_blank'>$detail2name</a></li>";
										}else{
											$strTable .="<li class='detail_lpa2' style='color:#FF7F50;'>$detail2name</li>";
										}

								}
									$strTable .="</ul>";
									
								}
								}else{
								$strTable .="<li class='detail_lpa' style='color:#589a80;'>$detailname</li>";
								$sql_detail2="select * from tb_lpa_detail2 where detailid=$detailid Order by listno ASC";
								$rsDetail2=rsQuery($sql_detail2);
								if($rsDetail2){
									$strTable .="<ul>";
									while($dataDetail2=mysqli_fetch_assoc($rsDetail2)){
										$detail2id=$dataDetail2['id'];
										$detail2name=$dataDetail2['name'];
										$mod2id=$dataDetail2['modid'];
										$mod2name=$dataDetail2['modname'];
										$link2=$dataDetail2['link'];
										if($link2<>null || $link2<>""){
											$strTable .="<li class='detail_lpa2'><a href='$link2' target='_blank'>$detail2name</a></li>";
										}else{
											$strTable .="<li class='detail_lpa2' style='color:#FF7F50;'>$detail2name</li>";
											}
											}
										$strTable .="</ul>";
										}
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

        //disable select text / copy/paste on css and script Ton 15/8/20
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

$(document).ready(function() {
    $('div').bind('cut copy', function(e) {
        e.preventDefault();
    });
});

</script>
