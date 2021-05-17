<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="exampleModalLabel">ลงทะเบียนเพื่อเข้าใช้งานระบบ</h2>
            </div>
            <div class="modal-body">
                <form method="post" action="">
                    <div class="form-group">
                        <label for="exampleInputEmail1">ชื่อผู้ใช้งาน</label>
                        <input name="personid" type="text" class="form-control" id="personid"
                               placeholder="เลขบัตรประชาชน"
                               autocomplete="off" maxlength="13" value="" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">รหัสผ่าน</label>
                        <input name="password" type="password" class="form-control" id="password"
                               placeholder="รหัสผ่าน 8 หลัก" minlength="8"
                               autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">วันเกิด</label>
                        <input name="birthday" type="text" class="form-control datepick" id="birthday"
                               autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label for="prename">คำนำหน้าชื่อ</label>
                        <select name="prename"
                                class="form-control"
                                id="prename">
                            <option value="0">เลือก</option>
                            <?php
                            $sqlSelect = 'SELECT a.id,a.name FROM tb_prename a INNER JOIN tb_citizen b ON a.id = b.prename WHERE b.prename = \'' . $data[0]['prename'] . '\'';
                            $sql = 'SELECT * FROM tb_prename';
                            $prename = result_array($sqlSelect);
                            $prename2 = result_array($sql);
                            foreach ($prename as $item => $value) {
                                echo '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
                            }
                            foreach ($prename2 as $item => $value) {
                                if ($value['id'] != $prename[0]['id']) {
                                    echo '<option value="' . $value['id'] . '">' . $value['name'] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputEmail4">ชื่อ</label>
                            <input type="text" class="form-control" name="name" id="inputEmail4" placeholder="ชื่อ"
                                   required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="inputPassword4">นามสกุล</label>
                            <input type="text" class="form-control" name="surname" id="inputPassword4"
                                   placeholder="นามสกุล" required>
                        </div>
                    </div>
                    <div style="float: right">
                        <button type="submit" name="register" value="register" class="btn btn-primary" id="register">
                            ลงทะเบียน
                        </button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                        onclick="window.location.href ='welfare_index.php?r=login'">
                    ปิด
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    $('#birthday').datepicker({
        todayBtn: "linked",
        autoclose: true,
        todayHighlight: true,
        language: "th-th"
    });
    $(document).ready(function () {
        $('#exampleModal2').modal({backdrop: 'static', keyboard: false}, 'show');
    });
    $('#exampleModal2').on('shown.bs.modal', function () {
        $('#personid').focus();
        $('#personid').focusout(function () {
            if ($('#personid').val().length < 13 || !$.isNumeric($('#user').val())) {
                serachID();
            }
        });
    });
    $('#register').on('click', function () {
        if ($('#password').val() != '' && $('#birthday').val() != '' && $('#name').val() != '' && $('#surname').val() != '' && $('#prename').val() != 0) {
            $('#exampleModal2').modal('hide');
        }
    });

    function serachID() {
        $.ajax({
            url: 'asset/ajaxid.php',
            type: 'POST',
            data: {id: $('#personid').val()},
            dataType: 'JSON',
            success: function (result) {
                console.log(result);
                if (result['data'].length == 0 && $('#personid').val() != '' && $('#personid').val().length == 13 && result['chk'] != 'false') {
                    $('#personid').css('border-color', 'rgb(52, 179, 52)');
                    $('#register').removeAttr('disabled');
                } else {
                    alert('เลขบัตรประชาชนไม่ถูกต้อง!');
                    $('#personid').val('');
                    $('#personid').css('border-color', 'red');
                    $('#register').attr('disabled', 'true');
                }
            },
            error: function (result) {
                console.log(result);
            }
        });
    }
</script>
