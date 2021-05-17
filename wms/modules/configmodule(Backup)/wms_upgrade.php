<?php
	error_reporting(E_ALL);
	ini_set('error_reporting', E_ALL);
	ini_set('display_errors',1);
	$modname=$_GET['_mod'];
	$modid=$_GET['_modid'];
	$upgrade=$_GET['upgrade'];
	$strMsg="";
	if(isset($_POST['btsave'])){
		$item=$_POST['item'];
		if($item<>"0"){
			switch($item){
				case "websearch":
					$strSQL="SHOW TABLES LIKE 'tb_searchtype'";
					$rs1=rsQuery($strSQL);
					if(mysqli_num_rows($rs1)>0){
						$strMsg="<script>alert('มีฐานข้อมูลแล้ว ไม่สามารถเพิ่มซ้ำได้ สามารถใช้งานระบบได้โดยเพิ่มโค้ดที่ index.php');</script>";
					}else{
						$sql="CREATE TABLE IF NOT EXISTS tb_searchtype (id int(11) NOT NULL AUTO_INCREMENT,name varchar(255) NOT NULL,tablename varchar(255) NOT NULL,modname varchar(255) NOT NULL,PRIMARY KEY (id)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
						$rs=rsQuery($sql);
						if($rs){
							
									$sql="INSERT INTO tb_searchtype (id, name, tablename, modname) VALUES(1, 'กิจกรรม', 'tb_activity', 'activity'),(2, 'ข่าวประชาสัมพันธ์', 'tb_news', 'news'),(3, 'จัดซื้อจัดจ้าง', 'tb_purchase', 'purchase'),(4, 'ไฟล์เอกสาร', 'tb_files', 'files'),(5, 'ดาวน์โหลดเอกสาร', 'tb_download', 'download')";
									$rs=rsQuery($sql);
									if($rs){
											$strMsg= "<script>alert('อัพเกรดระบบ Search สำเร็จ กรุณาเพิ่มโด้ดใน index.php');window.location.href='main.php?_modid=".$_GET['_modid']."&_mod=".$_GET['_mod']."';</script>";
									}

								
						}
					} // endif mysqli_num_rows
						echo $strMsg;
						
					break;
					
					case "ita":
					//เพิ่ม modpath & modid
						$sql="select * from tb_modpath where wms_path='modules/configita/ita.php'";
						$rs=rsQuery($sql);
						if(!$rs || mysqli_num_rows($rs)==0){
							$sqlMod="insert into tb_modpath(name,wms_path,web_path,server_path,create_table) values('M_ประเมิน ITA','modules/configita/ita.php','modules/ita/ita.php','/var/www/share/webabt/','')";
							$rsMod=rsQuery($sqlMod);
							$modpathid=FindRS("select * from tb_modpath where name='M_ประเมิน ITA'","id");
							echo $modpathid;
							$sql2="select * from tb_mod where modtype='ita'";
							$rs2=rsQuery($sql2);
							echo $sql2;
							if(!$rs2 || mysqli_num_rows($rs2)==0){
								$strMod="insert into tb_mod(modname,modtype,moddetail,modpath,typeid,tablename,foldername,bannername,groupid,listno) values('ประเมินITA','ita','แบบประเมินITA','$modpathid','3','tb_ita_menu','','','0','0')";
								$rsMod=rsQuery($strMod);
								echo $strMod;
							}
						}

					$strSQL="SHOW TABLES LIKE 'tb_ita_menu'";
					$rs1=rsQuery($strSQL);
					if(mysqli_num_rows($rs1)>0){
						$strMsg="<script>alert('มีฐานข้อมูลแล้ว ไม่สามารถเพิ่มซ้ำได้ สามารถใช้งานระบบได้เลย กำหนดสิทธิผู้ใช้งานเปิดเมนูบริการออนไลน์');</script>";
					}else{
						$sql="CREATE TABLE IF NOT EXISTS tb_ita_menu (id int(11) NOT NULL AUTO_INCREMENT,name varchar(255) NOT NULL,listno int(11) NOT NULL,
  PRIMARY KEY (id)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
						$rs=rsQuery($sql);
						$sql2="CREATE TABLE IF NOT EXISTS tb_ita_submenu (id int(11) NOT NULL AUTO_INCREMENT,menuid int(11) NOT NULL,name varchar(255) NOT NULL,listno int(11) NOT NULL,
  PRIMARY KEY (id)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
						$rs2=rsQuery($sql2);

						$sql3="CREATE TABLE IF NOT EXISTS tb_ita_detail (id int(11) NOT NULL AUTO_INCREMENT,menuid int(11) NOT NULL,submenuid int(11) NOT NULL,name varchar(255) NOT NULL,listno int(11) NOT NULL,modname varchar(255) NOT NULL,link text NOT NULL,
  PRIMARY KEY (id)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
						$rs3=rsQuery($sql3);
						if($rs){
							
									$sql="INSERT INTO tb_ita_menu (id, name,listno) VALUES";
									$sql .="(1, '9.1 ข้อมูลพื้นฐาน', '1'),(2, '9.2 การบริหารงาน', '2'),";
									$sql .="(3, '9.3 การบริหารเงินงบประมาณ', '3'),";
									$sql .="(4, '9.4 การบริหารและพัฒนาทรัพยากรบุคคล', '4'),";
									$sql .="(5, '9.5 การส่งเสริมความโปรงใส', '5'),";
									$sql .="(6, '10.6 การดำเนินการเพื่อป้องกันการทุจริต', '6'),";
									$sql .="(7, '10.2 มาตรการภายในเพื่อป้องกันการทุจริต', '7')";

									$sql2 = "insert into tb_ita_submenu(id,menuid,name,listno) values";
									$sql2 .="(1,1,'ข้อมูลพื้นฐาน',1),";
									$sql2 .="(2,1,'ข่าวประชาสัมพันธ์',2),";
									$sql2 .="(3,1,'การปฏิสัมพันธ์ข้อมูล',3),";
									$sql2 .="(4,2,'แผนดำเนินงาน',1),";
									$sql2 .="(5,2,'การปฏิบัติงาน',2),";
									$sql2 .="(6,2,'การให้บริการ',3),";
									$sql2 .="(7,3,'แผนการใช้จ่ายงบประมาณประจำปี',1),";
									$sql2 .="(8,3,'การจัดซื้อจัดจ้างหรือการจัดหาพัสดุ',2),";
									$sql2 .="(9,4,'การบริหารและพัฒนาทรัพยากรบุคคล',1),";
									$sql2 .="(10,5,'การจัดการเรื่องร้องเรียนการทุจริต',1),";
									$sql2 .="(11,5,'การเปิดโอกาสให้เกิดการมีส่วนร่วม',2),";
									$sql2 .="(12,6,'เจตจำนงสุจริตของผู้บริหาร',1),";
									$sql2 .="(13,6,'การประเมินความเสี่ยงเพื่อการป้องกันการทุจริต',2),";
									$sql2 .="(14,6,'การส่งเสริมวัฒนธรรมองค์กร',3),";
									$sql2 .="(15,6,'แผนปฏิบัติการป้องกันการทุจริต',4),";
									$sql2 .="(16,7,'มาตรการภายในเพื่อส่งเสริมความโปร่งใสและป้องกันการทุจริต',1)";

									$sql3 = "insert into tb_ita_detail(menuid,submenuid,name,listno,modname,link) values";
									$sql3 .="(1,1,'โครงสร้าง',1,'',''),";
									$sql3 .="(1,1,'ข้อมูลผู้บริหาร',2,'',''),";
									$sql3 .="(1,1,'อำนาจหน้าที่',3,'',''),";
									$sql3 .="(1,1,'แผนยุทธศาสตร์หรือแผนพัฒนาหน่วยงาน',4,'',''),";
									$sql3 .="(1,1,'ข้อมูลการติดต่อ',5,'',''),";
									$sql3 .="(1,1,'กฏหมายที่เกี่ยวข้อง',6,'',''),";
									$sql3 .="(1,2,'ข่าวประชาสัมพันธ์',1,'',''),";
									$sql3 .="(1,3,'Q & A',1,'',''),";
									$sql3 .="(1,3,'Social Network',2,'',''),";
									$sql3 .="(2,4,'แผนดำเนินงานประจำปี',1,'',''),";
									$sql3 .="(2,4,'รายงานการกำกับติดตามการดำเนินงานประจำปี รอบ6เดือน',2,'',''),";
									$sql3 .="(2,4,'รายงานผลการดำเนินงานประจำปี',3,'',''),";
									$sql3 .="(2,5,'คู่มือหรือมาตรฐานการปฏิบัติงาน',1,'',''),";
									$sql3 .="(2,6,'คู่มือหรือมาตรฐานการให้บริการ',1,'',''),";
									$sql3 .="(2,6,'ข้อมูลเชิงสถิติการให้บริการ',2,'',''),";
									$sql3 .="(2,6,'รายงานผลการสำรวจความพึงพอใจการให้บริการ',3,'',''),";
									$sql3 .="(2,6,'E-Service',4,'',''),";
									$sql3 .="(3,7,'แผนการใช้จ่ายงบประมาณประจำปี',1,'',''),";
									$sql3 .="(3,7,'รายงานการกำกับติดตามการใช้จ่ายงบประมาณประจำปี รอบ 6 เดือน',2,'',''),";
									$sql3 .="(3,7,'รายงานผลการใช้จ่ายงบประมาณประจำปี',3,'',''),";
									$sql3 .="(3,8,'แผนการจัดซื้อจัดจ้างหรือแผนการจัดหาพัสดุ',1,'',''),";
									$sql3 .="(3,8,'ประกาศต่างๆเกี่ยวกับการจัดซื้อจัดจ้างหรือการจัดหาพัสดุ',2,'',''),";
									$sql3 .="(3,8,'สรุปผลการจัดซื้อจัดจ้างหรือการจัดหาพัสดุรายเดือน',3,'',''),";
									$sql3 .="(3,8,'สรุปผลการจัดซื้อจัดจ้างหรือการจัดหาพัสดุประจำปี',4,'',''),";
									$sql3 .="(4,9,'นโยบายการบริหารทรัพยากรบุคคล',1,'',''),";
									$sql3 .="(4,9,'การดำเนินการตามนโยบายการบริหารทรัพยากรบุคคล',2,'',''),";
									$sql3 .="(4,9,'หลักเกณฑ์การบริหารและพัฒนาทรัพยากรบุคคล',3,'',''),";
									$sql3 .="(4,9,'รายงานการบริหารและพัฒนาทรัพยากรบุคคลประจำปี',4,'',''),";
									$sql3 .="(5,10,'แนวปฏิบัติการจัดการเรื่องร้องเรียนการทุจริต',1,'',''),";
									$sql3 .="(5,10,'ช่องทางแจ้งเรื่องร้องเรียนการทุจริต',2,'',''),";
									$sql3 .="(5,10,'ข้อมูลเชิงสถิติเรื่องร้องเรียนการทุจริตประจำปี',3,'',''),";
									$sql3 .="(5,11,'ช่องทางการรับฟังความคิดเห็น',1,'',''),";
									$sql3 .="(5,11,'การเปิดโอกาสให้เกิดการมีส่วนร่วม',2,'',''),";
									$sql3 .="(6,12,'เจตจำนงสุจริตของผู้บริหาร',1,'',''),";
									$sql3 .="(6,12,'การมีส่วนร่วมของผู้บริหาร',2,'',''),";
									$sql3 .="(6,13,'การประเมินความเสี่ยงการทุจริตประจำปี',1,'',''),";
									$sql3 .="(6,13,'การดำเนินการเพื่อจัดการความเสี่ยงการทุจริต',2,'',''),";
									$sql3 .="(6,14,'การเสริมสร้างวัฒนธรรมองค์กร',1,'',''),";
									$sql3 .="(6,15,'แผนปฏิบัติการป้องกันการทุจริตประจำปี',1,'',''),";
									$sql3 .="(6,15,'รายงานการกำกับติดตามการดำเนินการป้องกันการทุจริตประจำปี รอบ6เดือน',2,'',''),";
									$sql3 .="(6,15,'รายงานผลการดำเนินการป้องกันการทุจริตประจำปี',3,'',''),";
									$sql3 .="(7,16,'มาตรการเผยแพร่ข้อมูลต่อสาธารณะ',1,'',''),";
									$sql3 .="(7,16,'มาตรการให้ผู้มีส่วนได้ส่วนเสียมีส่วนร่วม',2,'',''),";
									$sql3 .="(7,16,'มาตรการส่งเสริมความโปร่งใสในการจัดซื้อจัดจ้าง',3,'',''),";
									$sql3 .="(7,16,'มาตรการจัดการเรื่องร้องเรียนการทุจริต',4,'',''),";
									$sql3 .="(7,16,'มาตรการป้องกันการรับสินบน',5,'',''),";
									$sql3 .="(7,16,'มาตรการป้องกันการขัดกันระหว่างผลประโยชน์ส่วนตนกับผลประโยชน์ส่วนรวม',6,'','')";

									$rs=rsQuery($sql);
									$rs2=rsQuery($sql2);
									$rs3=rsQuery($sql3);
									
									if($rs){
											$strMsg= "<script>alert('อัพเกรดระบบ ITA สำเร็จ กำหนดสิทธิ์ผู้ใช้งานเมนูบริการออนไลน์');window.location.href='main.php?_modid=".$_GET['_modid']."&_mod=".$_GET['_mod']."';</script>";
									}

								
						}
					} // endif mysqli_num_rows
							echo $strMsg;

						break;
			}// end switch

		} //end if item
			
	} // endif post btsave

?>
<form name="frmUpgrade" method="POST" action="" enctype="multipart/form-data">
<div class='content-box'>
	<p>อัพเกรดระบบ WMSi</p><hr>
		<div class='content-input'>
			<div>
				เลือกระบบที่ต้องการ 
				<select name='item'>
					<option value="0">เลือกรายการที่ต้องการอัพเกรด</option>
					<option value='websearch'>ระบบ search ข้อมูลภายในเว็บ</option>
					<option value='ita'>ระบบประเมิน ITA</option>
				</select>
				&nbsp;
				<input type='submit' name='btsave' value='บันทึก'>
		</div>
		</div>


</div>
</form>
