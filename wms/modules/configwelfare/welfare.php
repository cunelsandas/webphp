<?php //error_reporting(0); ?>

<script type="text/javascript" src="js/jquery-1.4.4.min.js"></script>
<link type="text/css" href="css/jquery-ui-1.8.10.custom.css" rel="stylesheet" />
	<script type="text/javascript" src="js/jquery-ui-1.8.10.offset.datepicker.min.js"></script>
	<style type="text/css">
		.ui-datepicker{
			width:200px;
			font-family:tahoma;
			font-size:11px;
			text-align:center;
		}
</style>

<SCRIPT language="javascript" type="text/javascript">

    $(document).ready(function () {
// TOGGLE SCRIPT
        /*$('.menudata').css('cursor', 'pointer');
        $("#toggle").click(function (event) {
            $(this).parents(".menudata").find("#hidedata").slideToggle("fast");
            return false;
        }); // END TOGGLE

				//$(".hidedata3").hide();
        $("#toggle3").click(function (event) {
            $(this).parents(".menudata").find("#hidedata3").slideToggle("fast");
            return false;
        }); // END TOGGLE


        $("#toggle2").click(function (event) {
            $(this).parents(".menudata").find("#hidedata2").slideToggle("fast");
            return false;
        }); // END TOGGLE

        $("#toggle4").click(function (event) {
            $(this).parents(".menudata").find("#hidedata4").slideToggle("fast");
            return false;
        }); // END TOGGLE*/


        /* ทำให้ textbox สลับสี */
        $("input, textarea").addClass("idle");
        $("input, textarea").focus(function () {
            $(this).addClass("activeField").removeClass("idle");
        }).blur(function () {
            $(this).removeClass("activeField").addClass("idle");
        });

    });
</script>
<?php
$mod = $_GET['_mod'];

empty($_GET['type']) ? $type = "" : $type = $_GET['type'];
$modid = EscapeValue($_GET['_modid']);
$modname = FindRS("select modname from tb_mod where modid=$modid", "modname");
echo "<p >$modname</p><hr><br>";
?>

<div style="float:left;width:300px;">
    <div class='menudata'>
        <div id="toggle" class='toggle'>
            <table cellpadding='0' cellspacing='1' width='100%'>
                <tr>
                    <td><STRONG> ข้อมูลผู้มีสิทธิ์</STRONG></td>
                </tr>
            </table>
        </div>
        <div id="hidedata" class='hidedata' >
            <table cellpadding='0' cellspacing='1' width='100%'>
                <tr>
                    <td><?php echo "<a href=\"main.php?_modid=" . $modid . "&_mod=" . $_GET['_mod'] . "&type=persondata\" >รายชื่อผู้ลงทะเบียน</a>"; ?></td>
                </tr>
                <tr>
                    <td><?php echo "<a href=\"main.php?_modid=" . $modid . "&_mod=" . $_GET['_mod'] . "&type=welfare_confirm\" >คำขอรอการอนุมัติ</a>"; ?></td>
                </tr>
								<tr>
                    <td><?php echo "<a href=\"main.php?_modid=" . $modid . "&_mod=" . $_GET['_mod'] . "&type=persondata_denied\" >จำหน่ายผู้มีสิทธิ์</a>"; ?></td>
                </tr>
            </table>
        </div>

				<div id="toggle3" class='toggle'>
            <table cellpadding='0' cellspacing='1' width='100%'>
                <tr>
                    <td><STRONG> การจ่ายเบี้ย</STRONG></td>
                </tr>
            </table>
        </div>
        <div id="hidedata3" class='hidedata'>
            <table cellpadding='0' cellspacing='1' width='100%'>
							<tr>
									<td><?php echo "<a href=\"main.php?_modid=" . $modid . "&_mod=" . $_GET['_mod'] . "&type=welfare_pay\" >บันทึกการจ่ายเบี้ย</a>"; ?></td>
							</tr>
							<tr>
									<td><?php echo "<a href=\"main.php?_modid=" . $modid . "&_mod=" . $_GET['_mod'] . "&type=welfare_pay_before\" >บันทึกการจ่ายเบี้ยย้อยหลัง</a>"; ?></td>
							</tr>
            </table>
        </div>

        <div id="toggle2" class='toggle'>
            <table cellpadding='0' cellspacing='1' width='100%'>
                <tr>
                    <td><STRONG> รายงานข้อมูลผู้มีสิทธิ์ </STRONG></td>
                </tr>
            </table>
        </div>
        <div id="hidedata2" class='hidedata'>
            <table cellpadding='0' cellspacing='1' width='100%'>
                <tr>
                    <td><?php echo "<a href=\"main.php?_modid=" . $modid . "&_mod=" . $_GET['_mod'] . "&type=report_2\" >รายละเอียดผู้มีสิทธิ์ได้รับเบี้ยยังชีพ</a>"; ?></td>
                </tr>
                <tr>
                    <td><?php echo "<a href=\"main.php?_modid=" . $modid . "&_mod=" . $_GET['_mod'] . "&type=report_1\" >สรุปผลผู้มีสิทธิ์ได้รับเบี้ยยังชีพ</a>"; ?></td>
                </tr>
                <tr>
                    <td><?php echo "<a href=\"main.php?_modid=" . $modid . "&_mod=" . $_GET['_mod'] . "&type=report_3\" >เปรียบเทียบข้อมูลผู้มีสิทธิ์รับเบี้ยยังชีพต่อปี</a>"; ?></td>
                </tr>
								<tr>
                    <td><?php echo "<a href=\"main.php?_modid=" . $modid . "&_mod=" . $_GET['_mod'] . "&type=report_4\" >สรุปการจำหน่ายผู้มีสิทธิ์</a>"; ?></td>
                </tr>
            </table>
        </div>

				<div id="toggle4" class='toggle'>
            <table cellpadding='0' cellspacing='1' width='100%'>
                <tr>
                    <td><STRONG> รายงานการจ่ายเบี้ย</STRONG></td>
                </tr>
            </table>
        </div>
        <div id="hidedata4" class='hidedata'>
            <table cellpadding='0' cellspacing='1' width='100%'>
                <tr>
                    <td><?php echo "<a href=\"main.php?_modid=" . $modid . "&_mod=" . $_GET['_mod'] . "&type=report_pay1\" >รายละเอียดการจ่ายเบี้ย</a>"; ?></td>
                </tr>
                <tr>
                    <td><?php echo "<a href=\"main.php?_modid=" . $modid . "&_mod=" . $_GET['_mod'] . "&type=report_pay2\" >ประวัติการจ่ายเบี้ย</a>"; ?></td>
                </tr>
								<tr>
                    <td><?php echo "<a href=\"main.php?_modid=" . $modid . "&_mod=" . $_GET['_mod'] . "&type=report_pay3\" >สรุปยอดการจ่ายเบี้ยยังชีพ</a>"; ?></td>
                </tr>
            </table>
        </div>


    </div>
</div>

<div id="detail" style="margin-left:310px;width:68%;padding-left:20px;">
    <?php
    if ($type == "persondata") {
        include "persondata.php";
    } elseif ($type == "persondata_view") {
        include "persondata_view.php";
    } elseif ($type == "persondata_add") {
        include "persondata_add.php";
    } elseif ($type == "persondata_denied") {
        include "persondata_denied.php";
    } elseif ($type == "persondata_denied_view") {
        include "persondata_denied_view.php";
    } elseif ($type == "welfare_confirm") {
        include "welfare_confirm.php";
    } elseif ($type == "welfare_confirm_view") {
        include "welfare_confirm_view.php";
    } elseif ($type == "welfare_pay") {
        include "welfare_pay.php";
    } elseif ($type == "welfare_pay_view") {
        include "welfare_pay_view.php";
    } elseif ($type == "welfare_pay_before") {
        include "welfare_pay_before.php";
    } elseif ($type == "report_1") {
        include "report_1.php";
    } elseif ($type == "report_2") {
        include "report_2.php";
    } elseif ($type == "report_3") {
        include "report_3.php";
    } elseif ($type == "report_4") {
        include "report_4.php";
    } elseif ($type == "report_pay1") {
        include "report_pay1.php";
    } elseif ($type == "report_pay2") {
        include "report_pay2.php";
    } elseif ($type == "report_pay3") {
        include "report_pay3.php";
    } else {
			include "persondata.php";
    }
    ?>
</div>
