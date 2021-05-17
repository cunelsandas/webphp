<?php
$no = isset($_GET['no']) ? $_GET['no'] : "";
$where = $no != "" ? " WHERE search_id = {$no} " : "";
$sql_data = "SELECT * FROM {$table_name} {$where} ";
$data = $db->result_row($sql_data);
if ($no == "") :
    foreach ($data as $k => $v) {
        $data[$k] = '';
    }
endif;
if (isset($_POST['btadd'])):
    $set_data = array(
        'search_table' => $_POST['table_name'],
        'search_no' => $_POST['field'],
        'search_name' => $_POST['name'],
        'search_detail' => $_POST['detail'],
        'search_date' => $_POST['date'],
        'search_status' => $_POST['status'],
    );
    if ($no == ""):
        $result = $db->insert($table_name, $set_data);
    else:
        $result = $db->update($table_name, "search_id = {$no}", $set_data);
    endif;
    $mg = $result ? "บันทึกสำเร็จ" : "พบข้อผิดพลาด";
    echo "<script>alert('{$mg}');window.location.href='main.php?_mod={$_GET['_mod']}&_modid={$_GET['_modid']}';</script>";
endif;
?>
<form name="frmnews" method="POST" action="" enctype="multipart/form-data">
    <table class="content-input" style="width: 100%;">
        <tbody>
        <tr>
            <td width="20%" style="padding: 10px 0 10px 10px;">ชื่อตาราง</td>
            <td width="80%">
                <input type="text" class="txt" name="table_name" id="table_name" size="70"
                       value="<?php echo $data['search_table']; ?>" required autocomplete="off">
            </td>
        </tr>
        <tr>
            <td width="20%" style="padding: 10px 0 10px 10px;">Field (id)</td>
            <td width="80%">
                <input type="text" class="txt" name="field" id="field" size="50"
                       value="<?php echo $data['search_no']; ?>" required autocomplete="off">
            </td>
        </tr>
        <tr>
            <td width="20%" style="padding: 10px 0 10px 10px;">Field (ชื่อ)</td>
            <td width="80%">
                <input type="text" class="txt" name="name" id="name" size="50"
                       value="<?php echo $data['search_name']; ?>" required autocomplete="off">
            </td>
        </tr>
        <tr>
            <td width="20%" style="padding: 10px 0 10px 10px;">Field (รายละเอียด)</td>
            <td width="80%">
                <input type="text" class="txt" name="detail" id="detail" size="50"
                       value="<?php echo $data['search_detail']; ?>" required autocomplete="off">
            </td>
        </tr>
        <tr>
            <td width="20%" style="padding: 10px 0 10px 10px;">Field (วันที่)</td>
            <td width="80%">
                <input type="text" class="txt" name="date" id="date" size="50"
                       value="<?php echo $data['search_date']; ?>" required autocomplete="off">
            </td>
        </tr>
        <tr>
            <td width="20%" style="padding: 10px 0 10px 10px;">Field (สถานะ)</td>
            <td width="80%">
                <input type="text" class="txt" name="status" id="status" size="50"
                       value="<?php echo $data['search_status']; ?>" required autocomplete="off">
            </td>
        </tr>
        <tr>
            <td width="20%">&nbsp;</td>
            <td width="80%" style="padding: 10px 0 10px 10px;">
                <input class="bt" type="submit" name="btadd" value="<?php echo $no == "" ? "เพิ่ม" : "แก้ไข"; ?>">
            </td>
        </tr>
        </tbody>
    </table>
</form>
