<?php

function conn(){

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
//		PDO::ATTR_EMULATE_PREPARES   => false, // turn off emulation mode for "real" prepared statements
//		PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
//		PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
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
function newQuery($sql,$searchvalue=null){
    try{
        $pdo=conn();
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
        $pdo=conn();
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

?>
