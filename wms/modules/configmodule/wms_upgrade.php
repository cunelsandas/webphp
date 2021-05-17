<?php
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
$modname = $_GET['_mod'];
$modid = $_GET['_modid'];
$strMsg = "";
if (isset($_POST['btsave'])) {
    $item = $_POST['item'];
    if ($item <> "0") {
        switch ($item) {
            case "websearch":
                $strSQL = "SHOW TABLES LIKE 'tb_searchtype'";
                $rs1 = rsQuery($strSQL);
                if (mysqli_num_rows($rs1) > 0) {
                    $strMsg = "<script>alert('มีฐานข้อมูลแล้ว ไม่สามารถเพิ่มซ้ำได้ สามารถใช้งานระบบได้โดยเพิ่มโค้ดที่ index.php');</script>";
                } else {
                    $sql = "CREATE TABLE IF NOT EXISTS tb_searchtype (id int(11) NOT NULL AUTO_INCREMENT,name varchar(255) NOT NULL,tablename varchar(255) NOT NULL,modname varchar(255) NOT NULL,PRIMARY KEY (id)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
                    $rs = rsQuery($sql);
                    if ($rs) {

                        $sql = "INSERT INTO tb_searchtype (id, name, tablename, modname) VALUES(1, 'กิจกรรม', 'tb_activity', 'activity'),(2, 'ข่าวประชาสัมพันธ์', 'tb_news', 'news'),(3, 'จัดซื้อจัดจ้าง', 'tb_purchase', 'purchase'),(4, 'ไฟล์เอกสาร', 'tb_files', 'files'),(5, 'ดาวน์โหลดเอกสาร', 'tb_download', 'download')";
                        $rs = rsQuery($sql);
                        if ($rs) {
                            $strMsg = "<script>alert('อัพเกรดระบบ Search สำเร็จ กรุณาเพิ่มโด้ดใน index.php');window.location.href='main.php?_modid=" . $_GET['_modid'] . "&_mod=" . $_GET['_mod'] . "';</script>";
                        }


                    }
                } // endif mysqli_num_rows
                echo $strMsg;

                break;

            case "ita":
                //เพิ่ม modpath & modid
                $sql = "select * from tb_modpath where wms_path='modules/configita/ita.php'";
                $rs = rsQuery($sql);
                if (!$rs || mysqli_num_rows($rs) == 0) {
                    $sqlMod = "insert into tb_modpath(name,wms_path,web_path,server_path,create_table) values('M_ประเมิน ITA','modules/configita/ita.php','modules/ita/ita.php','/var/www/share/webabt/','')";
                    $rsMod = rsQuery($sqlMod);
                    $modpathid = FindRS("select * from tb_modpath where name='M_ประเมิน ITA'", "id");
                    echo $modpathid;
                    $sql2 = "select * from tb_mod where modtype='ita'";
                    $rs2 = rsQuery($sql2);
                    echo $sql2;
                    if (!$rs2 || mysqli_num_rows($rs2) == 0) {
                        $strMod = "insert into tb_mod(modname,modtype,moddetail,modpath,typeid,tablename,foldername,bannername,groupid,listno) values('ประเมินITA','ita','แบบประเมินITA','$modpathid','3','tb_ita_menu','','','0','0')";
                        $rsMod = rsQuery($strMod);
                        echo $strMod;
                    }
                }

                $strSQL = "SHOW TABLES LIKE 'tb_ita_menu'";
                $rs1 = rsQuery($strSQL);
                if (mysqli_num_rows($rs1) > 0) {
                    $strMsg = "<script>alert('มีฐานข้อมูลแล้ว ไม่สามารถเพิ่มซ้ำได้ สามารถใช้งานระบบได้เลย กำหนดสิทธิผู้ใช้งานเปิดเมนูบริการออนไลน์');</script>";
                } else {
                    $sql = "CREATE TABLE IF NOT EXISTS tb_ita_menu (id int(11) NOT NULL AUTO_INCREMENT,name varchar(255) NOT NULL,listno int(11) NOT NULL,
  PRIMARY KEY (id)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
                    $rs = rsQuery($sql);
                    $sql2 = "CREATE TABLE IF NOT EXISTS tb_ita_submenu (id int(11) NOT NULL AUTO_INCREMENT,menuid int(11) NOT NULL,name varchar(255) NOT NULL,listno int(11) NOT NULL,
  PRIMARY KEY (id)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
                    $rs2 = rsQuery($sql2);

                    $sql3 = "CREATE TABLE IF NOT EXISTS tb_ita_detail (id int(11) NOT NULL AUTO_INCREMENT,menuid int(11) NOT NULL,submenuid int(11) NOT NULL,name varchar(255) NOT NULL,listno int(11) NOT NULL,modname varchar(255) NOT NULL,link text NOT NULL,
  PRIMARY KEY (id)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
                    $rs3 = rsQuery($sql3);
                    if ($rs) {

                        $sql = "INSERT INTO tb_ita_menu (id, name,listno) VALUES";
                        $sql .= "(1, '9.1 ข้อมูลพื้นฐาน', '1'),(2, '9.2 การบริหารงาน', '2'),";
                        $sql .= "(3, '9.3 การบริหารเงินงบประมาณ', '3'),";
                        $sql .= "(4, '9.4 การบริหารและพัฒนาทรัพยากรบุคคล', '4'),";
                        $sql .= "(5, '9.5 การส่งเสริมความโปรงใส', '5'),";
                        $sql .= "(6, '10.6 การดำเนินการเพื่อป้องกันการทุจริต', '6'),";
                        $sql .= "(7, '10.2 มาตรการภายในเพื่อป้องกันการทุจริต', '7')";

                        $sql2 = "insert into tb_ita_submenu(id,menuid,name,listno) values";
                        $sql2 .= "(1,1,'ข้อมูลพื้นฐาน',1),";
                        $sql2 .= "(2,1,'ข่าวประชาสัมพันธ์',2),";
                        $sql2 .= "(3,1,'การปฏิสัมพันธ์ข้อมูล',3),";
                        $sql2 .= "(4,2,'แผนดำเนินงาน',1),";
                        $sql2 .= "(5,2,'การปฏิบัติงาน',2),";
                        $sql2 .= "(6,2,'การให้บริการ',3),";
                        $sql2 .= "(7,3,'แผนการใช้จ่ายงบประมาณประจำปี',1),";
                        $sql2 .= "(8,3,'การจัดซื้อจัดจ้างหรือการจัดหาพัสดุ',2),";
                        $sql2 .= "(9,4,'การบริหารและพัฒนาทรัพยากรบุคคล',1),";
                        $sql2 .= "(10,5,'การจัดการเรื่องร้องเรียนการทุจริต',1),";
                        $sql2 .= "(11,5,'การเปิดโอกาสให้เกิดการมีส่วนร่วม',2),";
                        $sql2 .= "(12,6,'เจตจำนงสุจริตของผู้บริหาร',1),";
                        $sql2 .= "(13,6,'การประเมินความเสี่ยงเพื่อการป้องกันการทุจริต',2),";
                        $sql2 .= "(14,6,'การส่งเสริมวัฒนธรรมองค์กร',3),";
                        $sql2 .= "(15,6,'แผนปฏิบัติการป้องกันการทุจริต',4),";
                        $sql2 .= "(16,7,'มาตรการภายในเพื่อส่งเสริมความโปร่งใสและป้องกันการทุจริต',1)";

                        $sql3 = "insert into tb_ita_detail(menuid,submenuid,name,listno,modname,link) values";
                        $sql3 .= "(1,1,'โครงสร้าง',1,'',''),";
                        $sql3 .= "(1,1,'ข้อมูลผู้บริหาร',2,'',''),";
                        $sql3 .= "(1,1,'อำนาจหน้าที่',3,'',''),";
                        $sql3 .= "(1,1,'แผนยุทธศาสตร์หรือแผนพัฒนาหน่วยงาน',4,'',''),";
                        $sql3 .= "(1,1,'ข้อมูลการติดต่อ',5,'',''),";
                        $sql3 .= "(1,1,'กฏหมายที่เกี่ยวข้อง',6,'',''),";
                        $sql3 .= "(1,2,'ข่าวประชาสัมพันธ์',1,'',''),";
                        $sql3 .= "(1,3,'Q & A',1,'',''),";
                        $sql3 .= "(1,3,'Social Network',2,'',''),";
                        $sql3 .= "(2,4,'แผนดำเนินงานประจำปี',1,'',''),";
                        $sql3 .= "(2,4,'รายงานการกำกับติดตามการดำเนินงานประจำปี รอบ6เดือน',2,'',''),";
                        $sql3 .= "(2,4,'รายงานผลการดำเนินงานประจำปี',3,'',''),";
                        $sql3 .= "(2,5,'คู่มือหรือมาตรฐานการปฏิบัติงาน',1,'',''),";
                        $sql3 .= "(2,6,'คู่มือหรือมาตรฐานการให้บริการ',1,'',''),";
                        $sql3 .= "(2,6,'ข้อมูลเชิงสถิติการให้บริการ',2,'',''),";
                        $sql3 .= "(2,6,'รายงานผลการสำรวจความพึงพอใจการให้บริการ',3,'',''),";
                        $sql3 .= "(2,6,'E-Service',4,'',''),";
                        $sql3 .= "(3,7,'แผนการใช้จ่ายงบประมาณประจำปี',1,'',''),";
                        $sql3 .= "(3,7,'รายงานการกำกับติดตามการใช้จ่ายงบประมาณประจำปี รอบ 6 เดือน',2,'',''),";
                        $sql3 .= "(3,7,'รายงานผลการใช้จ่ายงบประมาณประจำปี',3,'',''),";
                        $sql3 .= "(3,8,'แผนการจัดซื้อจัดจ้างหรือแผนการจัดหาพัสดุ',1,'',''),";
                        $sql3 .= "(3,8,'ประกาศต่างๆเกี่ยวกับการจัดซื้อจัดจ้างหรือการจัดหาพัสดุ',2,'',''),";
                        $sql3 .= "(3,8,'สรุปผลการจัดซื้อจัดจ้างหรือการจัดหาพัสดุรายเดือน',3,'',''),";
                        $sql3 .= "(3,8,'สรุปผลการจัดซื้อจัดจ้างหรือการจัดหาพัสดุประจำปี',4,'',''),";
                        $sql3 .= "(4,9,'นโยบายการบริหารทรัพยากรบุคคล',1,'',''),";
                        $sql3 .= "(4,9,'การดำเนินการตามนโยบายการบริหารทรัพยากรบุคคล',2,'',''),";
                        $sql3 .= "(4,9,'หลักเกณฑ์การบริหารและพัฒนาทรัพยากรบุคคล',3,'',''),";
                        $sql3 .= "(4,9,'รายงานการบริหารและพัฒนาทรัพยากรบุคคลประจำปี',4,'',''),";
                        $sql3 .= "(5,10,'แนวปฏิบัติการจัดการเรื่องร้องเรียนการทุจริต',1,'',''),";
                        $sql3 .= "(5,10,'ช่องทางแจ้งเรื่องร้องเรียนการทุจริต',2,'',''),";
                        $sql3 .= "(5,10,'ข้อมูลเชิงสถิติเรื่องร้องเรียนการทุจริตประจำปี',3,'',''),";
                        $sql3 .= "(5,11,'ช่องทางการรับฟังความคิดเห็น',1,'',''),";
                        $sql3 .= "(5,11,'การเปิดโอกาสให้เกิดการมีส่วนร่วม',2,'',''),";
                        $sql3 .= "(6,12,'เจตจำนงสุจริตของผู้บริหาร',1,'',''),";
                        $sql3 .= "(6,12,'การมีส่วนร่วมของผู้บริหาร',2,'',''),";
                        $sql3 .= "(6,13,'การประเมินความเสี่ยงการทุจริตประจำปี',1,'',''),";
                        $sql3 .= "(6,13,'การดำเนินการเพื่อจัดการความเสี่ยงการทุจริต',2,'',''),";
                        $sql3 .= "(6,14,'การเสริมสร้างวัฒนธรรมองค์กร',1,'',''),";
                        $sql3 .= "(6,15,'แผนปฏิบัติการป้องกันการทุจริตประจำปี',1,'',''),";
                        $sql3 .= "(6,15,'รายงานการกำกับติดตามการดำเนินการป้องกันการทุจริตประจำปี รอบ6เดือน',2,'',''),";
                        $sql3 .= "(6,15,'รายงานผลการดำเนินการป้องกันการทุจริตประจำปี',3,'',''),";
                        $sql3 .= "(7,16,'มาตรการเผยแพร่ข้อมูลต่อสาธารณะ',1,'',''),";
                        $sql3 .= "(7,16,'มาตรการให้ผู้มีส่วนได้ส่วนเสียมีส่วนร่วม',2,'',''),";
                        $sql3 .= "(7,16,'มาตรการส่งเสริมความโปร่งใสในการจัดซื้อจัดจ้าง',3,'',''),";
                        $sql3 .= "(7,16,'มาตรการจัดการเรื่องร้องเรียนการทุจริต',4,'',''),";
                        $sql3 .= "(7,16,'มาตรการป้องกันการรับสินบน',5,'',''),";
                        $sql3 .= "(7,16,'มาตรการป้องกันการขัดกันระหว่างผลประโยชน์ส่วนตนกับผลประโยชน์ส่วนรวม',6,'','')";

                        $rs = rsQuery($sql);
                        $rs2 = rsQuery($sql2);
                        $rs3 = rsQuery($sql3);

                        if ($rs) {
                            $strMsg = "<script>alert('อัพเกรดระบบ ITA สำเร็จ กำหนดสิทธิ์ผู้ใช้งานเมนูบริการออนไลน์');window.location.href='main.php?_modid=" . $_GET['_modid'] . "&_mod=" . $_GET['_mod'] . "';</script>";
                        }


                    }
                } // endif mysqli_num_rows
                echo $strMsg;

                break;

            case "ita63":
                //เพิ่ม modpath & modid
                $sql = "select * from tb_modpath where wms_path='modules/configita/ita.php'";
                $rs = rsQuery($sql);
                if (!$rs || mysqli_num_rows($rs) == 0) {
                    $sqlMod = "insert into tb_modpath(name,wms_path,web_path,server_path,create_table) values('M_ประเมิน ITA','modules/configita/ita.php','modules/ita/ita.php','/var/www/share/webabt/','')";
                    $rsMod = rsQuery($sqlMod);
                    $modpathid = FindRS("select * from tb_modpath where name='M_ประเมิน ITA'", "id");
                    echo $modpathid;
                    $sql2 = "select * from tb_mod where modtype='ita'";
                    $rs2 = rsQuery($sql2);
                    echo $sql2;
                    if (!$rs2 || mysqli_num_rows($rs2) == 0) {
                        $strMod = "insert into tb_mod(modname,modtype,moddetail,modpath,typeid,tablename,foldername,bannername,groupid,listno) values('ประเมินITA','ita','แบบประเมินITA','$modpathid','3','tb_ita_menu','','','0','0')";
                        $rsMod = rsQuery($strMod);
                        echo $strMod;
                    }
                }

                $strSQL = "SHOW TABLES LIKE 'tb_ita_menu'";
                $rs1 = rsQuery($strSQL);
                if (mysqli_num_rows($rs1) > 0) {
                    $strMsg = "<script>alert('มีฐานข้อมูลแล้ว ไม่สามารถเพิ่มซ้ำได้ สามารถใช้งานระบบได้เลย กำหนดสิทธิผู้ใช้งานเปิดเมนูบริการออนไลน์');</script>";
                } else {
                    $sql = "CREATE TABLE IF NOT EXISTS tb_ita_menu (id int(11) NOT NULL AUTO_INCREMENT,name varchar(255) NOT NULL,listno int(11) NOT NULL,
  PRIMARY KEY (id)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
                    $rs = rsQuery($sql);
                    $sql2 = "CREATE TABLE IF NOT EXISTS tb_ita_submenu (id int(11) NOT NULL AUTO_INCREMENT,menuid int(11) NOT NULL,name varchar(255) NOT NULL,listno int(11) NOT NULL,
  PRIMARY KEY (id)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
                    $rs2 = rsQuery($sql2);

                    $sql3 = "CREATE TABLE IF NOT EXISTS tb_ita_detail (id int(11) NOT NULL AUTO_INCREMENT,menuid int(11) NOT NULL,submenuid int(11) NOT NULL,name varchar(255) NOT NULL,listno int(11) NOT NULL,modname varchar(255) NOT NULL,link text NOT NULL,
  PRIMARY KEY (id)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
                    $rs3 = rsQuery($sql3);
                    if ($rs) {

                        $sql = "INSERT INTO tb_ita_menu (id, name,listno) VALUES";


                        $sql2 = "insert into tb_ita_submenu(id,menuid,name,listno) values";


                        $sql3 = "insert into tb_ita_detail(menuid,submenuid,name,listno,modname,link) values";


                        $rs = rsQuery($sql);
                        $rs2 = rsQuery($sql2);
                        $rs3 = rsQuery($sql3);

                        if ($rs) {
                            $strMsg = "<script>alert('อัพเกรดระบบ ITA สำเร็จ กำหนดสิทธิ์ผู้ใช้งานเมนูบริการออนไลน์');window.location.href='main.php?_modid=" . $_GET['_modid'] . "&_mod=" . $_GET['_mod'] . "';</script>";
                        }


                    }
                } // endif mysqli_num_rows
                echo $strMsg;

                break;

            case "ita64":
                //เพิ่ม modpath & modid
                $sql = "select * from tb_modpath where wms_path ='modules/configita_2564/ita.php'";
                $rs = rsQuery($sql);
                if (!$rs || mysqli_num_rows($rs) == 0) {
                    $sqlMod = "insert into tb_modpath(name,wms_path,web_path,server_path,create_table) values('M_ประเมิน ITA 2564','modules/configita_2564/ita.php','modules/ita_2564/ita.php','/var/www/share/webabt/','')";
                    $rsMod = rsQuery($sqlMod);
                    $modpathid = FindRS("select * from tb_modpath where name='M_ประเมิน ITA 2564'", "id");
                    echo $modpathid;
                    $sql2 = "select * from tb_mod where modtype='ita2564'";
                    $rs2 = rsQuery($sql2);
                    echo $sql2;
                    if (!$rs2 || mysqli_num_rows($rs2) == 0) {
                        $strMod = "insert into tb_mod(modname,modtype,moddetail,modpath,typeid,tablename,foldername,bannername,groupid,listno) values('การประเมินคุณธรรมและ ความโปร่งใสของ อปท. (ITA) 2564','ita2564','แบบประเมินITA2564','$modpathid','1','tb_ita_menu_2564','','','0','0')";
                        $rsMod = rsQuery($strMod);
                        echo $strMod;
                    }
                }

                $strSQL = "SHOW TABLES LIKE 'tb_ita_menu_2564'";
                $rs1 = rsQuery($strSQL);
                if (mysqli_num_rows($rs1) > 0) {
                    $strMsg = "<script>alert('มีฐานข้อมูลแล้ว ไม่สามารถเพิ่มซ้ำได้ สามารถใช้งานระบบได้เลย กำหนดสิทธิผู้ใช้งานเปิดเมนูบริการออนไลน์');</script>";
                } else {
                    $sql = "CREATE TABLE IF NOT EXISTS tb_ita_menu_2564 (id int(11) NOT NULL AUTO_INCREMENT,name varchar(255) NOT NULL,listno int(11) NOT NULL,
  PRIMARY KEY (id)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
                    $rs = rsQuery($sql);
                    $sql2 = "CREATE TABLE IF NOT EXISTS tb_ita_submenu_2564 (id int(11) NOT NULL AUTO_INCREMENT,menuid int(11) NOT NULL,name varchar(255) NOT NULL,listno int(11) NOT NULL,
  PRIMARY KEY (id)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
                    $rs2 = rsQuery($sql2);

                    $sql3 = "CREATE TABLE IF NOT EXISTS tb_ita_detail_2564 (id int(11) NOT NULL AUTO_INCREMENT,menuid int(11) NOT NULL,submenuid int(11) NULL,name varchar(255) NULL,listno int(11) NULL,modname varchar(255) NULL,link text NULL,
  PRIMARY KEY (id)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
                    $rs3 = rsQuery($sql3);
                    if ($rs) {

                        $sql = "INSERT INTO tb_ita_menu_2564 (id, name,listno) VALUES";
                        $sql .= "(1, '9.1 ข้อมูลพื้นฐาน', '1'),(2, '9.2 การบริหารงาน', '2'),";
                        $sql .= "(3, '9.3 การบริหารเงินงบประมาณ', '3'),";
                        $sql .= "(4, '9.4 การบริหารและพัฒนาทรัพยากรบุคคล', '4'),";
                        $sql .= "(5, '9.5 การส่งเสริมความโปรงใส', '5'),";
                        $sql .= "(6, '10.1 การดำเนินการเพื่อป้องกันการทุจริต', '6'),";
                        $sql .= "(7, '10.2 มาตรการภายในเพื่อป้องกันการทุจริต', '7')";


                        $sql2 = "insert into tb_ita_submenu_2564(id,menuid,name,listno) values";
                        $sql2 .= "(1,1,'ข้อมูลพื้นฐาน',1),";
                        $sql2 .= "(2,1,'การประชาสัมพันธ์',2),";
                        $sql2 .= "(3,1,'การปฏิสัมพันธ์ข้อมูล',3),";
                        $sql2 .= "(4,2,'การดำเนินงาน',1),";
                        $sql2 .= "(5,2,'การปฏิบัติงาน',2),";
                        $sql2 .= "(6,2,'การให้บริการ',3),";
                        $sql2 .= "(7,3,'แผนการใช้จ่ายงบประมาณประจำปี',1),";
                        $sql2 .= "(8,3,'การจัดซื้อจัดจ้างหรือการจัดหาพัสดุ',2),";
                        $sql2 .= "(9,4,'การบริหารและพัฒนาทรัพยากรบุคคล',1),";
                        $sql2 .= "(10,5,'การจัดการเรื่องร้องเรียนการทุจริตและประพฤติมิชอบ',1),";
                        $sql2 .= "(11,5,'การเปิดโอกาสให้เกิดการมีส่วนร่วม',2),";
                        $sql2 .= "(12,6,'เจตจำนงสุจริตของผู้บริหาร',1),";
                        $sql2 .= "(13,6,'การประเมินความเสี่ยงเพื่อการป้องกันการทุจริต',2),";
                        $sql2 .= "(14,6,'การเสริมสร้างวัฒนธรรมองค์กร',3),";
                        $sql2 .= "(15,6,'แผนป้องกันการทุจริต',4),";
                        $sql2 .= "(16,7,'มาตรการส่งเสริมความโปร่งใสและป้องกันการทุจริตภายในหน่วยงาน',1)";

                        $sql3 = "insert into tb_ita_detail_2564(id,menuid,submenuid,name,listno,modname,link) values";
                        $sql3 .= "(1,1,1,'โครงสร้าง',1,'โครงสร้างหน่วยงาน','index.php?_mod=ZmlsZXM&type=MzI'),";
                        $sql3 .= "(2,1,1,'ข้อมูลผู้บริหาร',2,'คณะผู้บริหาร','index.php?_mod=aGVhZA'),";
                        $sql3 .= "(3,1,1,'อำนาจหน้าที่',3,'อำนาจหน้าที่','index.php?_mod=ZmlsZXM&type=MzE'),";
                        $sql3 .= "(4,1,1,'แผนยุทธศาสตร์หรือแผนพัฒนาหน่วยงาน',4,'แผนยุทธศาสตร์หรือแผนพัฒนาหน่วยงาน','index.php?_mod=ZmlsZXM&type=Mw'),";
                        $sql3 .= "(5,1,1,'ข้อมูลการติดต่อ',5,'ติดต่อเรา','index.php?_mod=Y29udGFjdA'),";
                        $sql3 .= "(6,1,1,'กฏหมายที่เกี่ยวข้อง',6,'ระเบียบ/กฎหมายที่เกี่ยวข้อง','index.php?_mod=ZmlsZXM&type=MzM'),";
                        $sql3 .= "(7,1,2,'ข่าวประชาสัมพันธ์',1,'ข่าวประชาสัมพันธ์','index.php?_mod=bmV3cw'),";
                        $sql3 .= "(8,1,3,'Q & A',1,'การด่านข่าว ถาม-ตอบ','index.php?_mod=d2ViYm9hcmQ'),";
                        $sql3 .= "(9,1,3,'Social Network',2,'',''),";
                        $sql3 .= "(10,2,4,'แผนดำเนินงานประจำปี',1,'แผนการดำเนินงาน','index.php?_mod=ZmlsZXM&type=Mzc'),";
                        $sql3 .= "(11,2,4,'รายงานการกำกับติดตามการดำเนินงานประจำปี รอบ6เดือน',2,'รายงานการกำกับติดตามการดำเนินงานประจำปี รอบ6เดือน','index.php?_mod=ZmlsZXM&type=Nzk'),";
                        $sql3 .= "(12,2,4,'รายงานผลการดำเนินงานประจำปี',3,'รายงานผลการดำเนินงาน','index.php?_mod=ZmlsZXM&type=Ng'),";
                        $sql3 .= "(13,2,5,'คู่มือหรือมาตรฐานการปฏิบัติงาน',1,'คู่มือหรือมาตรฐานการปฏิบัติงาน','index.php?_mod=ZmlsZXM&type=NDA'),";
                        $sql3 .= "(14,2,6,'คู่มือหรือมาตรฐานการให้บริการ',1,'คู่มือหรือมาตรฐานการให้บริการ','index.php?_mod=ZmlsZXM&type=NDE'),";
                        $sql3 .= "(15,2,6,'ข้อมูลเชิงสถิติการให้บริการ',2,'ข้อมูลเชิงสถิติการให้บริการ','index.php?_mod=ZmlsZXM&type=NDU'),";
                        $sql3 .= "(16,2,6,'รายงานผลการสำรวจความพึงพอใจการให้บริการ',3,'รายงานผลการสำรวจความพึงพอใจการให้บริการ','index.php?_mod=ZmlsZXM&type=NjQ'),";
                        $sql3 .= "(17,2,6,'E-Service',4,'E-Service','index.php?_mod=ZGl5&type=OA'),";
                        $sql3 .= "(18,3,7,'แผนการใช้จ่ายงบประมาณประจำปี',1,'แผนการใช้จ่ายงบประมาณประจำปี','index.php?_mod=ZmlsZXM&type=NDY'),";
                        $sql3 .= "(19,3,7,'รายงานการกำกับติดตามการใช้จ่ายงบประมาณประจำปี รอบ 6 เดือน',2,'รายงานการกำกับติดตามการใช้จ่ายงบประมาณประจำปี','index.php?_mod=ZmlsZXM&type=Mzk'),";
                        $sql3 .= "(20,3,7,'รายงานผลการใช้จ่ายงบประมาณประจำปี',3,'รายงานผลการใช้จ่ายงบประมาณประจำปี','index.php?_mod=ZmlsZXM&type=NDI'),";
                        $sql3 .= "(21,3,8,'แผนการจัดซื้อจัดจ้างหรือแผนการจัดหาพัสดุ',1,'แผนจัดหาพัสดุ','index.php?_mod=ZmlsZXM&type=Nw'),";
                        $sql3 .= "(22,3,8,'ประกาศต่างๆเกี่ยวกับการจัดซื้อจัดจ้างหรือการจัดหาพัสดุ',2,'ข่าวจัดซื้อจัดจ้าง','index.php?_mod=cHVyY2hhc2U'),";
                        $sql3 .= "(23,3,8,'สรุปผลการจัดซื้อจัดจ้างหรือการจัดหาพัสดุรายเดือน',3,'ข่าวจัดซื้อจัดจ้าง','index.php?_mod=cHVyY2hhc2U'),";
                        $sql3 .= "(24,3,8,'รายงานผลการจัดซื้อจัดจ้างหรือการจัดหาพัสดุประจำปี',4,'สรุปผลการจัดซื้อจัดจ้างหรือการจัดหาพัสดุประจำปี','index.php?_mod=ZmlsZXM&type=NDM'),";
                        $sql3 .= "(25,4,9,'นโยบายการบริหารทรัพยากรบุคคล',1,'นโยบายการบริหารทรัพยากรบุคคล','index.php?_mod=ZmlsZXM&type=NDQ'),";
                        $sql3 .= "(26,4,9,'การดำเนินการตามนโยบายการบริหารทรัพยากรบุคคล',2,'การดำเนินการตามนโยบายการบริหารทรัพยากรบุคคล','index.php?_mod=ZmlsZXM&type=ODA'),";
                        $sql3 .= "(27,4,9,'หลักเกณฑ์การบริหารและพัฒนาทรัพยากรบุคคล',3,'หลักเกณฑ์การบริหารและพัฒนาทรัพยากรบุคคล','index.php?_mod=ZmlsZXM&type=NDc'),";
                        $sql3 .= "(28,4,9,'รายงานการบริหารและพัฒนาทรัพยากรบุคคลประจำปี',4,'รายงานการบริหารและพัฒนาทรัพยากรบุคคลประจำปี','index.php?_mod=ZmlsZXM&type=NDg'),";
                        $sql3 .= "(29,5,10,'แนวปฏิบัติการจัดการเรื่องร้องเรียนการทุจริตและประพฤติมิชอบ',1,'แนวปฏิบัติการจัดการเรื่องร้องเรียนการทุจริต','index.php?_mod=ZmlsZXM&type=ODE'),";
                        $sql3 .= "(30,5,10,'ช่องทางแจ้งเรื่องร้องเรียนการทุจริตและประพฤติมิชอบ',2,'สายด่วนผู้บริหาร','index.php?_mod=bmF5b2s'),";
                        $sql3 .= "(31,5,10,'ข้อมูลเชิงสถิติเรื่องร้องเรียนการทุจริตและประพฤติมิชอบ',3,'ข้อมูลเชิงสถิติเรื่องร้องเรียนการทุจริตประจำปี','index.php?_mod=ZmlsZXM&type=ODI'),";
                        $sql3 .= "(32,5,11,'ช่องทางการรับฟังความคิดเห็น',1,'กระดานข่าว ถาม-ตอบ','index.php?_mod=d2ViYm9hcmQ'),";
                        $sql3 .= "(33,5,11,'การเปิดโอกาสให้เกิดการมีส่วนร่วม',2,'การเปิดโอกาสให้เกิดการมีส่วนร่วม','index.php?_mod=ZmlsZXM&type=ODM'),";
                        $sql3 .= "(34,6,12,'เจตจำนงสุจริตของผู้บริหาร',1,'เจตจํานงสุจริตของผู้บริหาร','index.php?_mod=ZmlsZXM&type=NDk'),";
                        $sql3 .= "(35,6,12,'การมีส่วนร่วมของผู้บริหาร',2,'การมีส่วนร่วมของผู้บริหาร','index.php?_mod=ZmlsZXM&type=ODQ'),";
                        $sql3 .= "(36,6,13,'การประเมินความเสี่ยงการทุจริตประจำปี',1,'การประเมินความเสี่ยงการทุจริตประจำปี','index.php?_mod=ZmlsZXM&type=ODU'),";
                        $sql3 .= "(37,6,13,'การดำเนินการเพื่อจัดการความเสี่ยงการทุจริต',2,'การดำเนินการเพื่อจัดการความเสี่ยงการทุจริต','index.php?_mod=ZmlsZXM&type=ODY'),";
                        $sql3 .= "(38,6,14,'การเสริมสร้างวัฒนธรรมองค์กร',1,'การเสริมสร้างวัฒนธรรมองค์กร','index.php?_mod=ZmlsZXM&type=NTA'),";
                        $sql3 .= "(39,6,15,'แผนปฏิบัติการป้องกันการทุจริต',1,'แผนป้องกันการทุจริตประจําปี','index.php?_mod=ZmlsZXM&type=MzY'),";
                        $sql3 .= "(40,6,15,'รายงานการกำกับติดตามการดำเนินการป้องกันการทุจริตประจำปี รอบ6เดือน',2,'รายงานการกำกับติดตามการดำเนินการป้องกันการทุจริตประจำปี','index.php?_mod=ZmlsZXM&type=NTE'),";
                        $sql3 .= "(41,6,15,'รายงานผลการดำเนินการป้องกันการทุจริตประจำปี',3,'รายงานผลการดำเนินการป้องกันการทุจริตประจำปี','index.php?_mod=ZmlsZXM&type=NTM'),";
                        $sql3 .= "(42,7,16,'มาตรการส่งเสริมคุณธรรมและความโปร่งใสภายในหน่วยงาน',1,'การดำเนินการตามมาตรการส่งเสริมคุณธรรมและความโปร่งใสภายในหน่วยงาน','index.php?_mod=ZmlsZXM&type=ODc'),";
                        $sql3 .= "(43,7,16,'การดำเนินการตามมาตรการส่งเสริมคุณธรรมและความโปร่งใสภายในหน่วยงาน',2,'มาตรการส่งเสริมคุณธรรมและความโปร่งใสภายในหน่วยงาน','index.php?_mod=ZmlsZXM&type=ODg')";

                        $rs = rsQuery($sql);
                        $rs2 = rsQuery($sql2);
                        $rs3 = rsQuery($sql3);

                        if ($rs) {
                            $strMsg = "<script>alert('อัพเกรดระบบ ITA 2564 สำเร็จ กำหนดสิทธิ์ผู้ใช้งานเมนูบริการออนไลน์');</script>";
                        }


                    }
                } // endif mysqli_num_rows
                echo $strMsg;

                break;

            case "centerdocument":
                //เพิ่ม modpath & modid
                $sql = "select * from tb_modpath where web_path='modules/center_doc/center_document.php'";
                $rs = rsQuery($sql);
                if (!$rs || mysqli_num_rows($rs) == 0) {
                    $sqlMod = "insert into tb_modpath(name,wms_path,web_path,server_path,create_table) values('M_center_document','','modules/center_doc/center_document.php','/var/www/share/webabt/','')";
                    $rsMod = rsQuery($sqlMod);
                    $modpathid = FindRS("select * from tb_modpath where name='M_center_document'", "id");
                    echo $modpathid;
                    $sql2 = "select * from tb_mod where modtype='centerdocument'";
                    $rs2 = rsQuery($sql2);
                    echo $sql2;
                    if (!$rs2 || mysqli_num_rows($rs2) == 0) {
                        $strMod = "insert into tb_mod(modname,modtype,moddetail,modpath,typeid,tablename,foldername,bannername,groupid,listno) values('มาตรฐานการปฏิบัติงาน','centerdocument','มาตรฐานการปฏิบัติงาน','$modpathid','','','','','0','0')";
                        $rsMod = rsQuery($strMod);
                        echo $strMod;
                    }
                }

                $rs = rsQuery($sql);
                $rs2 = rsQuery($sql2);

                if ($rs) {
                    $strMsg = "<script>alert('อัพเกรดระบบ มาตรฐานการปฏิบัติงาน สำเร็จ');window.location.href='main.php?_modid=" . $_GET['_modid'] . "&_mod=" . $_GET['_mod'] . "';</script>";
                }
                echo $strMsg;

                break;

            case "centerdocument_law":
                //เพิ่ม modpath & modid
                $sql = "select * from tb_modpath where web_path='modules/center_doc/center_law.php'";
                $rs = rsQuery($sql);
                if (!$rs || mysqli_num_rows($rs) == 0) {
                    $sqlMod = "insert into tb_modpath(name,wms_path,web_path,server_path,create_table) values('M_center_document_กฎหมาย','','modules/center_doc/center_law.php','/var/www/share/webabt/','')";
                    $rsMod = rsQuery($sqlMod);
                    $modpathid = FindRS("select * from tb_modpath where name='M_center_document_กฎหมาย'", "id");
                    echo $modpathid;
                    $sql2 = "select * from tb_mod where modtype='centerlaws'";
                    $rs2 = rsQuery($sql2);
                    echo $sql2;
                    if (!$rs2 || mysqli_num_rows($rs2) == 0) {
                        $strMod = "insert into tb_mod(modname,modtype,moddetail,modpath,typeid,tablename,foldername,bannername,groupid,listno) values('กฎหมายที่เกี่ยวข้อง(พรบ./พรก.)','centerlaws','กฎหมายที่เกี่ยวข้อง(พรบ./พรก.)','$modpathid','','','','','0','0')";
                        $rsMod = rsQuery($strMod);
                        echo $strMod;
                    }
                }

                $rs = rsQuery($sql);
                $rs2 = rsQuery($sql2);

                if ($rs) {
                    $strMsg = "<script>alert('อัพเกรดระบบ กฎหมายที่เกี่ยวข้อง(พรบ./พรก.) สำเร็จ');window.location.href='main.php?_modid=" . $_GET['_modid'] . "&_mod=" . $_GET['_mod'] . "';</script>";
                }
                echo $strMsg;

                break;

            case "centerdocument_law_ministry":
                //เพิ่ม modpath & modid
                $sql = "select * from tb_modpath where web_path='modules/center_doc/center_law_ministry.php'";
                $rs = rsQuery($sql);
                if (!$rs || mysqli_num_rows($rs) == 0) {
                    $sqlMod = "insert into tb_modpath(name,wms_path,web_path,server_path,create_table) values('M_center_document_กฎระเบียบกระทรวง','','modules/center_doc/center_law_ministry.php','/var/www/share/webabt/','')";
                    $rsMod = rsQuery($sqlMod);
                    $modpathid = FindRS("select * from tb_modpath where name='M_center_document_กฎระเบียบกระทรวง'", "id");
                    echo $modpathid;
                    $sql2 = "select * from tb_mod where modtype='centerlawsministry'";
                    $rs2 = rsQuery($sql2);
                    echo $sql2;
                    if (!$rs2 || mysqli_num_rows($rs2) == 0) {
                        $strMod = "insert into tb_mod(modname,modtype,moddetail,modpath,typeid,tablename,foldername,bannername,groupid,listno) values('กฎระเบียบกระทรวง','centerlawsministry','กฎระเบียบกระทรวง','$modpathid','','','','','0','0')";
                        $rsMod = rsQuery($strMod);
                        echo $strMod;
                    }
                }

                $rs = rsQuery($sql);
                $rs2 = rsQuery($sql2);

                if ($rs) {
                    $strMsg = "<script>alert('อัพเกรดระบบ กฎระเบียบกระทรวง สำเร็จ');window.location.href='main.php?_modid=" . $_GET['_modid'] . "&_mod=" . $_GET['_mod'] . "';</script>";
                }
                echo $strMsg;

                break;

            case "corruption_2021":
                //เพิ่ม modpath & modid
                $sql = "select * from tb_modpath where web_path='modules/corruption_2021/corruption.php'";
                $rs = rsQuery($sql);
                if (!$rs || mysqli_num_rows($rs) == 0) {
                    $sqlMod = "insert into tb_modpath(name,wms_path,web_path,server_path,create_table) values('M_ทุจริต_2021','modules/configcorruption_2021/corruption.php','modules/corruption_2021/corruption.php','/var/www/share/webabt/','')";
                    $rsMod = rsQuery($sqlMod);
                    $modpathid = FindRS("select * from tb_modpath where name='M_ทุจริต_2021'", "id");
                    echo $modpathid;
                    $sql2 = "select * from tb_mod where modtype='corruption2021'";
                    $rs2 = rsQuery($sql2);
                    echo $sql2;
                    if (!$rs2 || mysqli_num_rows($rs2) == 0) {
                        $strMod = "insert into tb_mod(modname,modtype,moddetail,modpath,typeid,tablename,foldername,bannername,groupid,listno) values('ร้องเรียนการทุจริต_New','corruption2021','ร้องเรียนการทุจริต_New','$modpathid','','','','','0','0')";
                        $rsMod = rsQuery($strMod);
                        echo $strMod;
                    }
                }

                $rs = rsQuery($sql);
                $rs2 = rsQuery($sql2);

                if ($rs) {
                    $strMsg = "<script>alert('อัพเกรดระบบ ร้องเรียนทุจริต_2021 สำเร็จ (ถ้าไม่สามารถ เพิ่ม ลบ แก้ไขข้อมูล สไตล์เพี้ยน ติดต่อโปรแกรมเมอร์เลยจ้า)');window.location.href='main.php?_modid=" . $_GET['_modid'] . "&_mod=" . $_GET['_mod'] . "';</script>";
                }
                echo $strMsg;

                break;


            case "people_opinion":
                //เพิ่ม modpath & modid
                $sql = "select * from tb_modpath where web_path='modules/people_opinion_2021/people_opinion.php'";
                $rs = rsQuery($sql);
                if (!$rs || mysqli_num_rows($rs) == 0) {
                    $sqlMod = "insert into tb_modpath(name,wms_path,web_path,server_path,create_table) values('M_ช่องทางการรับฟังความคิดเห็นของประชาชน','modules/configpeople_opinion_2021/people_opinion.php','modules/people_opinion_2021/people_opinion.php','/var/www/share/webabt/','')";
                    $rsMod = rsQuery($sqlMod);
                    $modpathid = FindRS("select * from tb_modpath where name='M_ช่องทางการรับฟังความคิดเห็นของประชาชน'", "id");
                    echo $modpathid;
                    $sql2 = "select * from tb_mod where modtype='peopleopinion'";
                    $rs2 = rsQuery($sql2);
                    echo $sql2;
                    if (!$rs2 || mysqli_num_rows($rs2) == 0) {
                        $strMod = "insert into tb_mod(modname,modtype,moddetail,modpath,typeid,tablename,foldername,bannername,groupid,listno) values('ช่องทางการรับฟังความคิดเห็นของประชาชน',' peopleopinion','ช่องทางการรับฟังความคิดเห็นของประชาชน','$modpathid','','','','','0','0')";
                        $rsMod = rsQuery($strMod);
                        echo $strMod;
                    }
                }

                $strSQL = "SHOW TABLES LIKE 'tb_contact_us'";
                $rs1 = rsQuery($strSQL);
                if (mysqli_num_rows($rs1) > 0) {
                    $strMsg = "<script>alert('มีฐานข้อมูลแล้ว ไม่สามารถเพิ่มซ้ำได้ สามารถใช้งานระบบได้เลย กำหนดสิทธิผู้ใช้งานเปิดเมนูบริการออนไลน์');</script>";
                } else {
                    $sql = "CREATE TABLE IF NOT EXISTS tb_contact_us (`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` text DEFAULT NULL,
  `tel` varchar(50) NOT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `detail` text DEFAULT NULL,
  `img_key` varchar(255) DEFAULT NULL,
  `post_ip` varchar(50) NOT NULL,
  `status` int(11) NOT NULL COMMENT 'ขั้นตอนการทำงาน',
  `active` int(11) NOT NULL,
  `result` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updatetime` datetime DEFAULT NULL) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
                    $rs = rsQuery($sql);
                }

                $rs = rsQuery($sql);
                $rs2 = rsQuery($sql2);

                if ($rs) {
                    $strMsg = "<script>alert('อัพเกรดระบบ ช่องทางแสดงความคิดเห็นของประชาชน สำเร็จ (ถ้าไม่สามารถ เพิ่ม ลบ แก้ไข ข้อมูล สไตล์เพี้ยน ติดต่อโปรแกรมเมอร์เลยจ้า)');window.location.href='main.php?_modid=" . $_GET['_modid'] . "&_mod=" . $_GET['_mod'] . "';</script>";
                }
                echo $strMsg;

                break;

            case "electric_maps":
                //เพิ่ม modpath & modid
                $sql = "select * from tb_modpath where web_path='modules/electric_maps/index.php'";
                $rs = rsQuery($sql);
                if (!$rs || mysqli_num_rows($rs) == 0) {
                    $sqlMod = "insert into tb_modpath(name,wms_path,web_path,server_path,create_table) values('M_แจ้งซ่อมไฟฟ้า[แผนที่]','modules/configelectric_maps/electric.php','modules/electric_maps/index.php','/var/www/share/webabt/','')";
                    $rsMod = rsQuery($sqlMod);
                    $modpathid = FindRS("select * from tb_modpath where name='M_แจ้งซ่อมไฟฟ้า[แผนที่]'", "id");
                    echo $modpathid;
                    $sql2 = "select * from tb_mod where modtype='electric_maps'";
                    $rs2 = rsQuery($sql2);
                    echo $sql2;
                    if (!$rs2 || mysqli_num_rows($rs2) == 0) {
                        $strMod = "insert into tb_mod(modname,modtype,moddetail,modpath,typeid,tablename,foldername,bannername,groupid,listno) values('แจ้งซ่อมไฟฟ้าสาธารณะ','electric_maps','แจ้งซ่อมไฟฟ้าสาธารณะ[แผนที่]','$modpathid','','','','','0','0')";
                        $rsMod = rsQuery($strMod);
                        echo $strMod;
                    }
                }

                $strSQL = "SHOW TABLES LIKE 'tb_electric_maps'";
                $rs1 = rsQuery($strSQL);
                if (mysqli_num_rows($rs1) > 0) {
                    $strMsg = "<script>alert('มีฐานข้อมูลแล้ว ไม่สามารถเพิ่มซ้ำได้ สามารถใช้งานระบบได้เลย กำหนดสิทธิผู้ใช้งานเปิดเมนูบริการออนไลน์');</script>";
                } else {
                    $sql = "CREATE TABLE IF NOT EXISTS tb_electric_maps (`id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `id_card` varchar(20) DEFAULT NULL,
  `telephone` varchar(20) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `moo` varchar(20) DEFAULT NULL,
  `mooban` varchar(255) DEFAULT NULL,
  `placefocus` text DEFAULT NULL,
  `pole_id` varchar(255) DEFAULT NULL,
  `lat` varchar(255) DEFAULT NULL,
  `lng` varchar(255) DEFAULT NULL,
  `datepost` datetime DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `typewb` int(10) DEFAULT NULL,
  `status` int(10) DEFAULT NULL,
  `process` varchar(100) DEFAULT NULL,
  `updatetime` datetime NOT NULL,
  `image_key` varchar(255) DEFAULT NULL) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
                    $rs = rsQuery($sql);

                    $sql10 = "CREATE TABLE IF NOT EXISTS tb_electric_status ( `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255) NOT NULL) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
                    $rs10 = rsQuery($sql10);

                    if ($rs10) {

                        $sql = "INSERT INTO tb_electric_status (id, name) VALUES";
                        $sql .= "(1, 'อยู่ระหว่างการตรวจสอบ'),";
                        $sql .= "(2, 'กำลังดำเนินการ'),";
                        $sql .= "(3, 'ตรวจสอบแล้วไม่มีมูล'),";
                        $sql .= "(4, 'ดำเนินการเสร็จแล้ว'),";
                        $sql .= "(5, 'ดำเนินการและส่งเมล์ตอบกลับแล้ว')";

                        $rs10 = rsQuery($sql10);
                    }
                }

                $rs = rsQuery($sql);
                $rs2 = rsQuery($sql2);

                if ($rs) {
                    $strMsg = "<script>alert('อัพเกรดระบบ แจ้งซ่อมไฟฟ้า[แผนที่] สำเร็จ เพิ่ม tb_electric_maps / tb_electric_status (ถ้าไม่สามารถ เพิ่ม ลบ แก้ไข ข้อมูล สไตล์เพี้ยน ติดต่อโปรแกรมเมอร์เลยจ้า)');window.location.href='main.php?_modid=" . $_GET['_modid'] . "&_mod=" . $_GET['_mod'] . "';</script>";
                }
                echo $strMsg;

                break;

            case
            "lpa":
                //เพิ่ม modpath & modid
                $sql = "select * from tb_modpath where wms_path='modules/configlpa/lpa.php'";
                $rs = rsQuery($sql);
                if (!$rs || mysqli_num_rows($rs) == 0) {
                    $sqlMod = "insert into tb_modpath(name,wms_path,web_path,server_path,create_table) values('M_ประเมิน LPA','modules/configlpa/lpa.php','modules/lpa/lpa.php','/var/www/share/webabt/','')";
                    $rsMod = rsQuery($sqlMod);
                    $modpathid = FindRS("select * from tb_modpath where name='M_ประเมิน LPA'", "id");
                    echo $modpathid;
                    $sql2 = "select * from tb_mod where modtype='lpa'";
                    $rs2 = rsQuery($sql2);
                    echo $sql2;
                    if (!$rs2 || mysqli_num_rows($rs2) == 0) {
                        $strMod = "insert into tb_mod(modname,modtype,moddetail,modpath,typeid,tablename,foldername,bannername,groupid,listno) values('ประเมินLPA','lpa','แบบประเมินLPA','$modpathid','3','tb_lpa_menu','','','0','0')";
                        $rsMod = rsQuery($strMod);
                        echo $strMod;
                    }
                }

                $strSQL = "SHOW TABLES LIKE 'tb_lpa_menu'";
                $rs1 = rsQuery($strSQL);
                if (mysqli_num_rows($rs1) > 0) {
                    $strMsg = "<script>alert('มีฐานข้อมูลแล้ว ไม่สามารถเพิ่มซ้ำได้ สามารถใช้งานระบบได้เลย กำหนดสิทธิผู้ใช้งานเปิดเมนูบริการออนไลน์');</script>";
                } else {
                    $sql = "CREATE TABLE IF NOT EXISTS tb_lpa_menu (id int(11) NOT NULL AUTO_INCREMENT,name varchar(255) NOT NULL,listno int(11) NOT NULL,
  PRIMARY KEY (id)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
                    $rs = rsQuery($sql);
                    $sql2 = "CREATE TABLE IF NOT EXISTS tb_lpa_submenu (id int(11) NOT NULL AUTO_INCREMENT,menuid int(11) NOT NULL,name varchar(255) NOT NULL,listno int(11) NOT NULL,
  PRIMARY KEY (id)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
                    $rs2 = rsQuery($sql2);

                    $sql3 = "CREATE TABLE IF NOT EXISTS tb_lpa_detail (id int(11) NOT NULL AUTO_INCREMENT,menuid int(11) NOT NULL,submenuid int(11) NOT NULL,name varchar(255) NOT NULL,listno int(11) NOT NULL,modname varchar(255) NOT NULL,link text NOT NULL,
  PRIMARY KEY (id)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
                    $rs3 = rsQuery($sql3);
                    $sql4 = "CREATE TABLE IF NOT EXISTS tb_lpa_detail2 (id int(11) NOT NULL AUTO_INCREMENT,menuid int(11) NOT NULL,submenuid int(11) NOT NULL,detailid int(11) NOT NULL,name varchar(255) NOT NULL,listno int(11) NOT NULL,modname varchar(255) NOT NULL,link text NOT NULL,
  PRIMARY KEY (id)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1";
                    $rs4 = rsQuery($sql4);
                    if ($rs) {

                        $rs = rsQuery($sql);
                        $rs2 = rsQuery($sql2);
                        $rs3 = rsQuery($sql3);
                        $rs4 = rsQuery($sql4);

                        if ($rs) {
                            $strMsg = "<script>alert('อัพเกรดระบบ LPA สำเร็จ กำหนดสิทธิ์ผู้ใช้งานเมนูบริการออนไลน์');window.location.href='main.php?_modid=" . $_GET['_modid'] . "&_mod=" . $_GET['_mod'] . "';</script>";
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
        <p>อัพเกรดระบบ WMSi</p>
        <hr>
        <div class='content-input'>
            <div>
                เลือกระบบที่ต้องการ
                <select name='item'>
                    <option value="0">เลือกรายการที่ต้องการอัพเกรด</option>
                    <option value='websearch'>ระบบ search ข้อมูลภายในเว็บ</option>
                    <option value='centerdocument'>เอกสารกลาง - มาตรฐานการปฏิบัติงาน</option>
                    <option value='centerdocument_law'>เอกสารกลาง - พรบ./พรก.(กฎหมายที่เกี่ยวข้อง)</option>
                    <option value='centerdocument_law_ministry'>เอกสารกลาง - กฎระเบียบกระทรวง</option>
                    <option value='ita'>ระบบประเมิน ITA</option>
                    <option value='lpa'>ระบบประเมิน LPA</option>
                    <option value='ita63'>ระบบประเมิน ITA 2563</option>
                    <option value='ita64'>ระบบประเมิน ITA 2564</option>
                    <option value='corruption_2021'>ร้องเรียนทุจริต_2021</option>
                    <option value='people_opinion'>ช่องทางการรับฟังความคิดเห็นของประชาชน</option>
                    <option value='electric_maps'>แจ้งซ่อมไฟฟ้า[แผนที่]</option>
                </select>
                &nbsp;
                <input type='submit' name='btsave' value='บันทึก'>
            </div>
        </div>


    </div>
</form>
