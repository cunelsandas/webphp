<?php
/*error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);*/
include 'My_connect.php';
$db = new My_connect();
$mod = $_GET['_mod'];
$modid = $_GET['_modid'];
$type = isset($_GET['type']) ? $_GET['type'] : "";
$del = isset($_GET['del']) ? $_GET['del'] : "";
$sql_module = "SELECT * FROM tb_mod WHERE modtype = '{$mod}'";
$module = $db->result_row($sql_module);
$table_name = $module['tablename'];
$sql_data = "SELECT * FROM {$table_name}";
$data = $db->result_array($sql_data);
?>
<div class="content-box">
    <p><?php echo $module['modname']; ?></p>
    <hr>
    <br>
    <?php if ($type == "view"):
        include "view.php"; ?>
    <?php elseif ($del != ""): $result = $db->delete($table_name, "search_id = {$del}"); ?>
        <script>window.history.back();</script>
    <?php else: ?>
        <p style="float: right;">
            <a href="main.php?_mod=<?php echo $mod; ?>&_modid=<?php echo $modid; ?>&type=view"
               class="link">เพิ่มรายการใหม่</a>
        </p>
        <table class="content-table">
            <thead>
            <tr>
                <th>ชื่อตาราง</th>
                <th>จัดการ</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($data as $k => $v): ?>
                <tr>
                    <td>&nbsp;<?php echo $v['search_table']; ?></td>
                    <td>
                        <a href="main.php?_mod=<?php echo $mod; ?>&_modid=<?php echo $modid; ?>&type=view&no=<?php echo $v['search_id']; ?>"><img
                                    src="../images/component/docs_16.gif" border="0"></a>
                        &nbsp;&nbsp;&nbsp;
                        <a href="main.php?_mod=<?php echo $mod; ?>&_modid=<?php echo $modid; ?>&del=<?php echo $v['search_id']; ?>"
                           onclick="return confirm('คุณต้องการลบรายการนี้ใช่หรือไม่?');"><img
                                    src="../images/component/del_16.gif" border="0"></a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
