<link rel="stylesheet" type="text/css" href="css/jquery.datetimepicker.min.css"/>
<script src="js/jquery.datetimepicker.js"></script>

<link rel="stylesheet" href="../js/fullcalendar/fullcalendar.min.css"/>
<script src="../js/fullcalendar/lib/moment.min.js"></script>
<script src="../js/fullcalendar/fullcalendar.min.js"></script>

<style>
    .fc-today {
        background: #fdfd96 !important;
        border: none !important;
        border-top: 1px solid #ddd !important;
        font-weight: bold;
    }
</style>

<script>


    //SAVE
    function save() {

        dataString = $("#myForm").serialize();
        $.ajax({
            type: 'ajax',
            url: "modules/configcalendar/add-event.php",
            async: false,
            method: 'POST',
            data: dataString,
            success: function (data) {

                $("#Modal").modal('hide');
                window.location.href = 'main.php?_mod=calendar&_modid=73';
                //$("#Calendar").load(location.href + " #Calendar");

            },
            error: function () {
                alert('err');
            }
        });

    }


    //EDIT
    function edit() {

        dataString = $("#myForm2").serialize();
        $.ajax({
            type: 'ajax',
            url: "modules/configcalendar/edit-event.php",
            async: false,
            method: 'POST',
            data: dataString,
            success: function (data) {

                alert("แก้ไขข้อมูลแล้วค่ะ");

                $("#Modal").modal('hide');
                window.location.href = 'main.php?_mod=calendar&_modid=73';
                //$("#Calendar").load(location.href + " #Calendar");
            },
            error: function () {
                alert('err');
            }
        });

    }


    //delete
    function deletel() {

        dataString = $("#myForm2").serialize();
        var deleteMsg = confirm("คุณต้องการลบข้อมูลหรือไม่?");
        if (deleteMsg) {
            $.ajax({
                type: "POST",
                url: "modules/configcalendar/delete-event.php",
                data: dataString,
                success: function (response) {

                    alert("ลบข้อมูลแล้วค่ะ");

                    $("#Modal").modal('hide');
                    window.location.href = 'main.php?_mod=calendar&_modid=73';
                    //$("#Calendar").load(location.href + " #Calendar");
                }
            });
        }
    }


    $(document).ready(function () {
        var calendar = $('#calendar').fullCalendar({

            monthNames: ['มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'],
            monthNamesShort: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],
            dayNames: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัส', 'ศุกร์', 'เสาร์'],
            dayNamesShort: ['อาทิตย์', 'จันทร์', 'อังคาร', 'พุธ', 'พฤหัส', 'ศุกร์', 'เสาร์'],

            editable: true,
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            events: "modules/configcalendar/fetch-event.php",
            displayEventTime: false,
            eventRender: function (event, element, view) {
                if (event.allDay === 'true') {
                    event.allDay = true;
                } else {
                    event.allDay = false;
                }
            },
            eventColor: '#77dd77',
            selectable: true,
            selectHelper: true,
            select: function (start, end, allDay) {

                //$.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
                var start = $.fullCalendar.formatDate(start, "Y-MM-DD");
                var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");

                $('#str_date').val(start);
                $('#datetimepicker2').val(end);
                $("#Modal").modal('show');

                calendar.fullCalendar('unselect');

            },

            editable: true,
            eventDrop: function (event, delta) {
                var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
                var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
                $.ajax({
                    url: "modules/configcalendar/edit-date-event.php",
                    data: 'title=' + event.title + '&start=' + start + '&end=' + end + '&id=' + event.id,
                    type: "POST",
                    success: function (response) {
                        displayMessage("อัพเดทข้อมูลเรียบร้อยค่ะ");
                    }
                });
            },
            eventClick: function (event) {


                var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
                var end;
                if (event.end != "") {
                    end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
                }


                /*$('#id').val(event.id);
                $('#str_date2').val(start);
                $('#datetimepicker4').val(event.start_time);
                $('#datetimepicker3').val(end);
                $("#Modal_Edit").modal('show');*/

                $.ajax({
                    type: "POST",
                    url: "modules/configcalendar/show-data.php",
                    data: "id=" + event.id,
                    success: function (data) {

                        var responsedata = $.parseJSON(data);

                        //console.log(responsedata);


                        document.getElementById("frm_division2").value = responsedata[1].division_id;
                        $('#id').val(responsedata[0].id);
                        $('#frm_even2').html("<option value= " + responsedata[1].even_id + " >-- เลือกกิจกรรม --</option>");
                        $('#frm_detail2').val(responsedata[1].detail);
                        $('#str_date2').val(start);
                        $('#datetimepicker4').val(responsedata[0].start_time);
                        $('#datetimepicker3').val(end);
                        $("#Modal_Edit").modal('show');

                    }
                });


                /*var deleteMsg = confirm("Do you really want to delete?");
                if (deleteMsg) {
                    $.ajax({
                        type: "POST",
                        url: "modules/configcalendar/delete-event.php",
                        data: "&id=" + event.id,
                        success: function (response) {
                            if(parseInt(response) > 0) {

                                $('#calendar').fullCalendar('removeEvents', event.id);
                                displayMessage("Deleted Successfully");
                            }
                        }
                    });
                }*/
            }

        });
    });

    function displayMessage(message) {
        $(".response").html("<div class='success'>" + message + "</div>");
        setInterval(function () {
            $(".success").fadeOut();
        }, 1000);
    }
</script>

<style>

    #calendar {
        width: 1000px;
        margin: 20px auto;

    }

    .Calendar {
        text-align: center;
    }

    .response {
        height: 60px;
    }

    .success {
        background: #cdf3cd;
        padding: 10px 60px;
        border: #c3e6c3 1px solid;
        display: inline-block;
    }
</style>

<div class="Calendar" name="Calendar">
    <h2>ปฎิทินกิจกรรม</h2>

    <div class="response"></div>
    <div id='calendar'></div>

</div>

<!-- Modal -->
<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">เพิ่มกิจกรรม</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


                <form method="post" id="myForm" name="myForm" action="" onsubmit="validate()"
                      enctype="multipart/form-data">

                    <div class="row">

                        <div class="form-group col-md-8">
                            <label>แผนกที่รักผิดชอบ</label>
                            <select class="form-control" name="frm_division" id="frm_division">
                                <option value="">- เลือกกอง -</option>
                                <?php
                                //onsubmit="return(validate());"
                                $sql = "SELECT * FROM tb_division ORDER BY liston";
                                $rs = rsQuery($sql);
                                while ($row = mysqli_fetch_array($rs)) {
                                    echo "<option value=" . $row['division'] . ">" . $row['division'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group col-md-8">
                            <label>กิจกรรม</label>
                            <input type="text" class="form-control" name="frm_even" id="frm_even">
                        </div>


                        <div class="form-group col-md-8">
                            <label>รายละเอียด</label>
                            <textarea class="form-control" id="frm_detail" name="frm_detail" placeholder="รายละเอียด"
                                      rows="3"></textarea>
                        </div>

                        <div class="form-group col-md-8">
                            <label>สถานที่</label>
                            <input type="text" class="form-control" name="frm_place" id="frm_place">
                        </div>

                        <div class="form-group col-md-8">
                            <label>กลุ่มเป้าหมาย</label>
                            <input type="text" class="form-control" name="frm_person" id="frm_person">
                        </div>

                        <div class="form-group col-md-8">
                            <label>เริ่มวันที่</label>
                            <input data-format="dd/MM/yyyy" type="text" class="form-control" id="str_date"
                                   name="str_date" placeholder="เริ่มวันที่">
                        </div>


                        <div class="form-group col-md-8">
                            <label>เวลา</label>
                            <input type="text" id="datetimepicker1" name="str_time" class="form-control"/>
                        </div>

                        <div class="form-group col-md-8">
                            <label>สิ้นสุดวันที่</label>
                            <input data-format="dd/MM/yyyy" type="text" class="form-control" id="datetimepicker2"
                                   name="end_date" placeholder="สิ้นสุดวันที่">
                        </div>


                    </div>


            </div>
            <div class="modal-footer">
                <a onclick="save()" class="btn btn-primary" name="btn_addeven">ตกลง</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal Edit -->
<div class="modal fade" id="Modal_Edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">จัดการข้อมูลกิจกรรม</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">


                <form method="post" id="myForm2" name="myForm" action="" enctype="multipart/form-data">

                    <div class="row">

                        <div class="form-group col-md-8">
                            <label>แผนกที่รักผิดชอบ</label>
                            <select class="form-control" name="frm_division" id="frm_division2">
                                <option value="">- เลือกกอง -</option>
                                <?php
                                //onsubmit="return(validate());"
                                $sql = "SELECT * FROM tb_division ORDER BY liston";
                                $rs = rsQuery($sql);
                                while ($row = mysqli_fetch_array($rs)) {
                                    echo "<option value=" . $row['division'] . ">" . $row['division'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="form-group col-md-8">
                            <label>กิจกรรม</label>
                            <input type="text" class="form-control" name="frm_even" id="frm_even2">
                        </div>


                        <div class="form-group col-md-8">
                            <label>รายละเอียด</label>
                            <textarea class="form-control" id="frm_detail2" name="frm_detail" placeholder="รายละเอียด"
                                      rows="3"></textarea>
                        </div>


                        <div class="form-group col-md-8">
                            <label>เริ่มวันที่</label>
                            <input data-format="dd/MM/yyyy" type="text" class="form-control" id="str_date2"
                                   name="str_date" placeholder="เริ่มวันที่">
                        </div>


                        <div class="form-group col-md-8">
                            <label>เวลา</label>
                            <input type="text" id="datetimepicker4" name="str_time" class="form-control"/>
                        </div>

                        <div class="form-group col-md-8">
                            <label>สิ้นสุดวันที่</label>
                            <input data-format="dd/MM/yyyy" type="text" class="form-control" id="datetimepicker3"
                                   name="end_date" placeholder="สิ้นสุดวันที่">
                        </div>

                        <input type="hidden" id="id" name="id">


                    </div>


            </div>
            <div class="modal-footer">
                <a onclick="edit()" class="btn btn-primary" name="btn_editeven">ตกลง</a>
                <a onclick="deletel()" class="btn btn-danger" name="btn_editeven">ลบ</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">ปิด</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">

    $(document).ready(function () {
        $('#frm_division').change(function () {
            $.ajax({
                type: 'POST',
                data: {data: $(this).val()},
                url: 'modules/configcalendar/select.php',
                success: function (data) {
                    $('#frm_even').html(data);
                }
            });
            return false;
        });

        $('#frm_division2').change(function () {
            $.ajax({
                type: 'POST',
                data: {data: $(this).val()},
                url: 'modules/configcalendar/select.php',
                success: function (data) {
                    $('#frm_even2').html(data);
                }
            });
            return false;
        });


    });

    function validate() {

        if (document.myForm.frm_division.value == "") {
            alert("กรุณาเลือก กอง!");
            document.myForm.frm_division.focus();
            return false;
        }
        if (document.myForm.frm_even.value == "") {
            alert("กรุณาเลือก กิจกรรม!");
            document.myForm.frm_even.focus();
            return false;
        }
        if (document.myForm.frm_detail.value == "") {
            alert("กรุณากรอกรายละเอียด กอง!");
            document.myForm.frm_detail.focus();
            return false;
        }
        if (document.myForm.str_date.value == "") {
            alert("กรุณาเลือก วันที่เริ่มกิจกรรม!");
            document.myForm.str_date.focus();
            return false;
        }
        if (document.myForm.str_time.value == "") {
            alert("กรุณาเลือก เวลาเริ่มกิจกรรม!");
            document.myForm.str_time.focus();
            return false;
        }

        return (true);
    }
</script>


<script type="text/javascript">
    $(function () {
        $('#datetimepicker').datetimepicker();

    });

    //TimePicke Example
    $('#datetimepicker1').datetimepicker({
        datepicker: false,
        format: 'H:i'
    });


    $(function () {
        $('#datetimepicker2').datetimepicker();

    });

    $(function () {
        $('#datetimepicker3').datetimepicker();

    });

    //TimePicke Example
    $('#datetimepicker4').datetimepicker({
        datepicker: false,
        format: 'H:i'
    });


</script>
