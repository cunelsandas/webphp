<?php
////////////////////////////////////////login-logout///////////////////////////////////////////////////////
if (isset($_POST['login'])) {

    if ($data = Login($_POST['user'], $_POST['password'])) {
        $_SESSION['ID'] = $data[0]['id'];
        $_SESSION['PID'] = $data[0]['personid'];
        echo '<script>window.location.href = \'welfare_index.php?r=index\';</script>';
    } else {
        session_destroy();
        echo '<script>window.location.href = \'welfare_index.php?r=login\';</script>';
    }
} else if (isset($_POST['logout'])) {
    session_destroy();
    echo '<script>window.location.href = \'welfare_index.php?r=login\';</script>';
}
////////////////////////////////////////login-logout///////////////////////////////////////////////////////
// TODO Login
////////////////////////////////////////update/////////////////////////////////////////////////////////////
if (isset($_POST['btnSave'])) {
    $id = $_POST['id'];
    $no = [
        'btnSave',
        'id',
    ];
    $_POST['birthdate'] = ExpoldDate($_POST['birthdate']);
    $_POST['newcitizendate'] = ExpoldDate($_POST['newcitizendate']);
    $_POST['welfare_older'] = CheckSave(isset($_POST['welfare_older']));
    $_POST['welfare_handicap'] = CheckSave(isset($_POST['welfare_handicap']));
    $_POST['welfare_aids'] = CheckSave(isset($_POST['welfare_aids']));
    $_POST['handicap_eye'] = CheckSave(isset($_POST['handicap_eye']));
    $_POST['handicap_ear'] = CheckSave(isset($_POST['handicap_ear']));
    $_POST['handicap_body'] = CheckSave(isset($_POST['handicap_body']));
    $_POST['handicap_mind'] = CheckSave(isset($_POST['handicap_mind']));
    $_POST['handicap_brain'] = CheckSave(isset($_POST['handicap_brain']));
    $_POST['handicap_learn'] = CheckSave(isset($_POST['handicap_learn']));
    $_POST['handicap_ortistic'] = CheckSave(isset($_POST['handicap_ortistic']));
    $_POST['status'] = 1;
    $post = $_POST;
    $data = CreateArray($no, $post);
    $update = Update('tb_citizen', $id, $data);
    ////////////////////////////////UploadFile////////////////////////////////////
    $MasterID = $_SESSION['ID'];
    $TableName = 'tb_citizen';
    $foder = 'welfare';
    $dri = $gloUploadPath . '/' . $foder . '/';
    $font = __DIR__;
    $file = CreateArrayFile($_FILES, $TableName, $dri, $MasterID, 640, 'asdasdasdasdasdasd', $font);
    $i = 0;
    if ($file) {
        foreach ($file as $value) {
            $FileName[$i]['filename'] = $value['name'];
            $FileName[$i]['masterid'] = $MasterID;
            $FileName[$i]['tablename'] = $TableName;
            if ($value['name'] != '') {
                Insert('filename', $FileName[$i]);
            }
            $i++;
        }
    }
    ////////////////////////////////UploadFile////////////////////////////////////
    if ($update || $Insert) {
        echo '<script>alert(\'บันทึกข้อมูลสำเร็จ\'); window.location.href=\'welfare_index.php?r=index\'</script>';
    }
    if ($update == false) {
        echo '<script>alert(\'ผิดพลาด\'); window.location.href=\'welfare_index.php?r=index\'</script>';
    }

}
////////////////////////////////////////update/////////////////////////////////////////////////////////////
//TODO Save
////////////////////////////////////////register/////////////////////////////////////////////////////////////
if (isset($_POST['register'])) {
    if (isset($_POST['personid']) != '' || isset($_POST['prename']) != '' || isset($_POST['otherprename']) != '' || isset($_POST['name']) != '' || isset($_POST['password']) != '' || isset($_POST['surname']) != '' || isset($_POST['birthday']) != '') {
        $data = [
            'personid' => $_POST['personid'],
            'prename' => $_POST['prename'],
            'name' => $_POST['name'],
            'password' => $_POST['password'],
            'surname' => $_POST['surname'],
            'birthdate' => ExpoldDate($_POST['birthday']),
            'registerdate' => date("Y-m-d h:i:sa"),
            'status' => '1'
        ];

        $insert = Insert('tb_citizen', $data);
        if ($insert) {
            echo '<script>alert(\'ลงทะเบียนสำเร็จ\');window.location.href = \'welfare_index.php?r=login\';</script>';
        }
    } else {
        echo '<script>alert(\'ข้อมูลไม่ถูกต้อง\');window.location.href = \'welfare_index.php?r=register\';</script>';
    }

}
////////////////////////////////////////register/////////////////////////////////////////////////////////////
//TODO Register
///////////////////////////////////////request//////////////////////////////////////////////////////////////
if (isset($_POST['btRequest'])) {
    $today = date('Y-m-d');
    $data = [
        'receivetype' => $_POST['receivetype'],
        'year' => $_POST['year'],
        'personid' => $_POST['personid'],
        'status' => 1,
        'requestdate' => $today,
        'process' => 0,
    ];
    if (isset($_POST['aids'])) {
        $data['type'] = 3;
        $data['amount'] = $_POST['aids'];
        Insert('tb_welfare_request', $data);
    }
    if (isset($_POST['handicap'])) {
        $data['type'] = 2;
        $data['amount'] = $_POST['handicap'];
        Insert('tb_welfare_request', $data);
    }
    if (isset($_POST['olderpay'])) {
        $data['type'] = 1;
        $data['amount'] = $_POST['olderpay'];
        Insert('tb_welfare_request', $data);
    }
    echo '<script>alert(\'บันทึกข้อมูลสำเร็จ\'); window.location.href = \'welfare_index.php?r=index\'</script>';
}
///////////////////////////////////////request//////////////////////////////////////////////////////////////
?>
