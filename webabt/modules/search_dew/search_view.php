<?php
/*function get_tables($post)
{
    $tables = "";
    $i = 0;
    foreach ($post as $k => $v) {
        $ex = explode('areas-', $k);
        if (isset($ex[1])) {
            if ($i != 0):
                $tables .= ",";
            endif;
            $tables .= $v;
            $i++;
        }
    }
    return $tables;
}

$tables = get_tables($_GET);
$sql_tables = "SELECT * FROM {$table_name} WHERE search_id IN ({$tables}) AND search_table != ''";
$my_tables = $tables != '' ? $db->result_array($sql_tables) : array();*/

function get_data($table_name, $imp)
{
    $db = new My_connect();
    $my_tables = "";
    $my_data = array();
    $i = 0;
    foreach ($imp as $k => $v) {
        $ex = explode('areas-', $k);
        if (isset($ex[1])) {
            if ($i != 0):
                $my_tables .= ",";
            endif;
            $my_tables .= $v;
            $i++;
        }
    }
    $sql_tables = "SELECT * FROM {$table_name} WHERE search_id IN ({$my_tables}) AND search_table != ''";
    $tables = $my_tables != '' ? $db->result_array($sql_tables) : array();
    $sql = "";
    $search = isset($imp['searchphrase']) ? $imp['searchphrase'] != 0 ? " = '{$imp['text']}'" : " LIKE '%{$imp['text']}%'" : "";
    $order = isset($imp['order']) ? $imp['order'] : 0;
    $page = isset($imp['page']) ? $imp['page'] : 1;
    $limit = 10;
    $offset = ($page - 1) * $limit;
    foreach ($tables as $k => $v) {
        $name = $v['search_name'] ? $v['search_name'] : "''";
        $detail = $v['search_detail'] ? $v['search_detail'] : "''";
        $date = $v['search_date'] ? $v['search_date'] : "''";
        $no = $v['search_no'] ? $v['search_no'] : "''";
        $status = $v['search_status'] ? $v['search_status'] : "''";
        $table = $v['search_table'];

        $sql .= $k != 0 ? " UNION " : "";
        $sql .= "SELECT {$name} as name,{$detail} as detail,{$date} as date,{$no} as no,'{$table}' as table_name";
        $sql .= " FROM {$table} ";
        $sql .= $search != "" ? " WHERE {$name} {$search} " : "";
        $sql .= $status != "" ? " AND {$status} = 1 " : "";
    }
    if ($my_tables != ''):
        $sql .= $order == 0 ? " ORDER BY date DESC " : "";
        $sql .= $order == 1 ? " ORDER BY date ASC " : "";
        $sql .= $order == 2 ? " ORDER BY name ASC " : "";
        $pages = count($db->result_array($sql));
        $sql .= " LIMIT {$offset},{$limit} ";
        $my_data = $db->result_array($sql);
    endif;
    $data['data'] = $my_data;
    $data['page'] = !isset($pages) ? 1 : $pages == 0 ? 1 : ceil($pages / $limit);
    $data['offset'] = $offset;
    return $data;
}

$my_data = get_data($table_name, $_GET);

$pages = $my_data['page'];
?>
<style>
    .page {
        color: white;
        padding: 4px 10px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        background-color: #ff8a3c;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        margin-right: 4px;
    }

    .page:hover {
        background-color: #dfe3e3;
        color: #099df7;
    }
</style>
<br>
<fieldset>
    <legend>ข้อมูลทั้งหมด</legend>
    <table width="100%">
        <tbody>
        <?php if (count($my_data['data']) > 0): ?>
            <?php foreach ($my_data['data'] as $k => $v):
                $sql_mod = "SELECT modtype FROM tb_mod WHERE tablename = '{$v['table_name']}'";
                $mod = $db->result_row($sql_mod);
                ?>
                <tr>
                    <td>
                        <a href="index.php?_mod=<?php echo encode64($mod['modtype']) ?>&no=<?php echo encode64($v['no']) ?>"
                           target="_blank">
                            <b><?php echo $k + 1 + $my_data['offset']; ?>. </b><?php echo $v['name']; ?>
                            <b>(<?php echo thaidate($v['date']); ?>)</b>
                        </a>
                        <br>
                        <?php echo $v['detail'] ?>
                        <hr>
                        <br>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td style="text-align: center;">
                    <b>ไม่พบข้อมูล</b>
                </td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</fieldset>
<div id="page_count">
    <?php for ($I = 1; $I <= $pages; $I++): ?>
        <button type="submit" name="page" class="page" value="<?php echo $I; ?>"><?php echo $I; ?></button>
    <?php endfor; ?>
</div>