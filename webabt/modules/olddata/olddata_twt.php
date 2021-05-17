<form name="form1" method="POST" action="" autocomplete="off">
    <table width='80%'>
        <tr>
            <td>ประเภท</td>
            <td><select name='cbocat'>
                    <option value='0'>เลือกประเภท</option>
                    <?php
                    $sql = "select * from tb_old_type";
                    $rs = rsQuery($sql);
                    if ($rs) {
                        while ($data = mysqli_fetch_assoc($rs)) {
                            $id = $data['type_name'];
                            $name = $data['type_detail'];
                            echo "<option value='$id'>$name</option>";
                        }
                    }

                    ?>
                </select>&nbsp;&nbsp;<input type='submit' name='btfind' value='ค้นหา'>
            </td>
        </tr>
    </table>
</form>
<br>
<div id='master-table' width='100%' align='right' style="overflow-x: auto;max-height: 500px;width: 100%!important;">
    <table width='100%'>
        <tr>
            <th>ลำดับ</th>
            <th>วันที่</th>
            <th>รายการ</th>
            <th>รายละเอียด</th>
            <th>เอกสาร</th>
        </tr>
        <?php
        $mod = EscapeValue(decode64($_GET['_mod']));
        $tablename = FindRS("select * from tb_mod where modtype='$mod'", "tablename");
        $folder = FindRS("select * from tb_mod where modtype='$mod'", "foldername");
        $modname = FindRS("select * from tb_mod where modtype='$mod'", "modname");
        $bannername = FindRS("select * from tb_mod where modtype='$mod'", "bannername");
        $foldername = $gloUploadPath . "/" . $folder . "/";
        function create_link($file, $foldername)
        {
            $i = 1;
            foreach ($file as $k => $v) {
                if ($v !== ''):
                    echo '<a href="' . $foldername . $v . '" target="_blank"> ไฟล์ที่' . $i . '</a><br>';
                    $i++;
                endif;
            }
        }

        if (isset($_POST['btfind'])) {
            $str = "select * from tb_old_data where cat='" . $_POST['cbocat'] . "' Order by id DESC";
            $rs = rsQuery($str);
            if ($rs) {
                $i = 1;
                while ($data = mysqli_fetch_assoc($rs)): $file = array(); ?>
                    <tr>
                        <td style="text-align: center;"><?php echo $i; ?></td>
                        <td><?php echo $data['dateregist']; ?></td>
                        <td><?php echo $data['topic']; ?></td>
                        <td><?php echo $data['message']; ?></td>
                        <td>
                            <?php $file = array(
                                'p1' => $data['photo1'],
                                'p2' => $data['photo2'],
                                'p3' => $data['photo3'],
                                'f1' => $data['file1'],
                                'f2' => $data['file2'],
                                'f3' => $data['file3']); ?>
                            <?php create_link($file, $foldername) ?>
                        </td>
                    </tr>
                    <?php
                    $i++;
                endwhile;
            }
        }
        ?>
    </table>
</div>
