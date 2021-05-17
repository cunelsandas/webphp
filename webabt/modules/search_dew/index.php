<?php

error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

include "My_connect.php";
$db = new My_connect();
$mod = EscapeValue(decode64($_GET['_mod']));
$sql_module = "SELECT * FROM tb_mod WHERE modtype = '{$mod}'";
$module = $db->result_row($sql_module);
$table_name = $module['tablename'];
$mod_name = $module['modname'];
$banner_name = $module['bannername'];
$search_table = $db->result_array("SELECT search_id,modname FROM {$table_name} a INNER JOIN  tb_mod b ON a.search_table = b.tablename");
$search_phrase = array(
    array('value' => '0', 'id' => 'searchphraseall', 'name' => 'บางคำ'),
    array('value' => '1', 'id' => 'searchphraseany', 'name' => 'ทั้งประโยค'),
);
$search_order = array(
    array('value' => '0', 'name' => 'ใหม่สุด'),
    array('value' => '1', 'name' => 'เก่าสุด'),
    array('value' => '2', 'name' => 'ตามตัวอักษร'),
);
?>
<div id="head-name">
    <?php if (file_exists("images/{$banner_name}") && $banner_name !== ""): ?>
        <script>ChangeCssBg('purchase', '<?php echo $banner_name;?>');</script>
    <?php else: ?>
        <p class="banner_title"><?php echo $mod_name; ?></p>
    <?php endif; ?>
</div>
<form method="get" id="search-form" style="color: #FFFFFF;">
    <input type="text" name="_mod" id="_mod" value="<?php echo $_GET['_mod']; ?>" hidden>
    <fieldset>
        คำค้นหา : <input type="text" name="text"
                         value="<?php echo isset($_GET['text']) ? $_GET['text'] : ''; ?>">
        <button type="submit" id="btn-search">ค้นหา</button>
    </fieldset>
    <fieldset>
        <legend>เลือกรูปแบบการค้นหา:</legend>
        <div class="phrases-box">
            <?php foreach ($search_phrase as $k => $v): ?>
                <input type="radio" name="searchphrase" id="<?php echo $v['id']; ?>"
                       value="<?php echo $v['value']; ?>"
                    <?php echo isset($_GET['searchphrase']) && $_GET['searchphrase'] == $v['value'] ? 'checked' : $v['value'] == 0 ? 'checked' : ''; ?>>
                <label for="<?php echo $v['id']; ?>"><?php echo $v['name']; ?></label>
            <?php endforeach; ?>
        </div>
        <br>
        <div class="phrases-select">
            การจัดลำดับ : <select name="order" id="order">
                <?php foreach ($search_order as $k => $v): ?>
                    <option value="<?php echo $v['value']; ?>" <?php echo isset($_GET['order']) && $_GET['order'] == $v['value'] ? 'selected' : ''; ?>><?php echo $v['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </fieldset>
    <fieldset class="only">
        <legend>ค้นหาเฉพาะ:</legend>
        <?php foreach ($search_table as $k => $v): ?>
            <input type="checkbox" name="areas-<?php echo $k; ?>"
                   value="<?php echo $v['search_id']; ?>"
                   id="area-<?php echo $v['search_id']; ?>" <?php echo isset($_GET["areas-{$k}"]) ? 'checked' : '' ?>>
            <label for="area-<?php echo $v['search_id']; ?>"><?php echo $v['modname']; ?></label>
        <?php endforeach; ?>
    </fieldset>
    <?php include "search_view.php" ?>
</form>