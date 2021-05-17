

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css">

<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>


<style>
	body{
		font-family: THSarabunNew;
	}
</style>


<?php include('phpqrcode/qrlib.php');
if(isset($_REQUEST['submit']) and $_REQUEST['submit']!=""){
    $PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR;



    //html PNG location prefix
    $PNG_WEB_DIR = '../fileupload/qrgen/';

    if(!file_exists($PNG_TEMP_DIR)){
        mkdir($PNG_TEMP_DIR);
    }



    $filename	=	$PNG_WEB_DIR.time().uniqid('-QR-').'.png';

    //processing form input
    //remember to sanitize user input in real-life solution !!!
    $errorCorrectionLevel = $_REQUEST['level'];
    $matrixPointSize = $_REQUEST['size'];
    //default data

    $link	=	$_REQUEST['userdata'];

    QRcode::png($link, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
}
?>
<div class="container my-1">
</div>

<div class="container">
    <div class="row justify-content-md-center">
        <div class="ml-2 col-sm-6">
            <?php if(isset($link) and $link!=""){?>
                <div class="alert alert-success">สร้าง QR ไปที่ <strong>[<?php echo $link;?>]</strong></div>
                <div class="text-center"><img src="<?php echo $PNG_WEB_DIR.basename($filename); ?>" /></div>
            <?php } ?>
            <form method="post">
                <div class="form-group">
                    <label>QR Code Generator</label>
                    <input type="text" name="userdata" id="userdata" class="form-control" placeholder="ใส่ URL ที่ต้องการสร้าง QR" required="" oninvalid="this.setCustomValidity('กรุณากรอก URL')"
                           oninput="setCustomValidity('')">
                </div>
                <div class="form-group">
                    <label>QR Code เลเวล</label>
                    <select name="level" class="form-control">
                        <option value="L">L - คุณภาพต่ำ</option>
                        <option value="M" selected="">M - คุณภาพมาตรฐาน</option>
                        <option value="Q">Q - คุณภาพดี</option>
                        <option value="H">H - คุณภาพดีที่สุด</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>ขนาด QR Code</label>
                    <select name="size" class="form-control">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4" selected>4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" value="สร้าง QR Code" class="btn btn-danger">
                </div>
            </form>
        </div>
    </div>
</div>


<!--Only these JS files are necessary-->
<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
</script>
