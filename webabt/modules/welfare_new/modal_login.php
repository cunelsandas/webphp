<?php //session_destroy();?>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="exampleModalLabel">กรุณาเข้าสู่ระบบ</h2>
            </div>
            <div class="modal-body">
                <form method="post" action="">
                    <div class="form-group">
                        <label for="exampleInputEmail1">ชื่อผู้ใช้งาน</label>
                        <input name="user" type="text" class="form-control" id="user"
                               placeholder="เลขบัตรประชาชน"
                               autocomplete="off" maxlength="13" value="3100900461539">
                        <small id="userHelp" class="form-text text-muted">กรุณากรอกเลขบัตรประชาชน.</small>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">รหัสผ่าน</label>
                        <input name="password" type="password" class="form-control" id="password"
                               placeholder="รหัสผ่าน" value="11111111"
                               autocomplete="off">
                    </div>
                    <div style="float: right">
                        <button type="submit" name="login" value="login" class="btn btn-primary" id="login"
                                disabled="disabled">เข้าสู่ระบบ
                        </button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <a href="welfare_index.php?r=register" class="btn btn-light">ลงทะเบียน</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="window.location.href ='index.php'">
                    ปิด
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#exampleModal').modal({backdrop: 'static', keyboard: false}, 'show');
    });
    $('#exampleModal').on('shown.bs.modal',function () {
        $('#user').focus();
    });
    $('#login').on('click', function () {
        $('#exampleModal').modal('hide');
    });
    $('#user').focusout(function () {
        if ($('#user').val().length < 13 || !$.isNumeric($('#user').val())) {
            $('#userHelp').text('');
            $('#userHelp').append('<b style="color: red">รูปแบบเลขบัตรประชาชนผิดพลาด</b>');
            $('#login').attr('disabled', 'true');
            $('#user').css('border-color', 'red');
        } else {
            $('#userHelp').text('');
            $('#userHelp').append('<b style="color: #34b334">รูปแบบเลขบัตรประชาชนถูกต้อง</b>');
            $('#login').removeAttr('disabled');
            $('#user').css('border-color', '#34b334');
        }
    });
</script>
