<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
<script type="text/javascript" src="js/popper.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.datetimepicker.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="css/mystyle.php">
<?php
  $modname=FindRS("select * from tb_mod where modtype='$mod'",modname);
  $modid=FindRS("select * from tb_mod where modtype='$mod'",modid);
  $table=FindRS("select * from tb_mod where modtype='$mod'",tablename);
  $folder =FindRS("select * from tb_mod where modtype='$mod'",foldername);

  $part = "/fileupload/paytax/";

  if(isset($_POST['Submit'])) {

    /*$province=FindRS("SELECT * FROM province WHERE PROVINCE_ID=".$_POST['frm_province'],PROVINCE_NAME);
    $amphur=FindRS("SELECT * FROM amphur WHERE AMPHUR_ID=".$_POST['frm_amphur'],AMPHUR_NAME);
    $district=FindRS("SELECT * FROM district WHERE DISTRICT_ID=".$_POST['frm_district'],DISTRICT_NAME);
    $moo = $_POST['frm_moo'];
*/
      $check = getimagesize($_FILES["frm_image"]["tmp_name"][0]);

                $sql = "INSERT INTO $table(id,name,tel,email,province,amphur,district,moo,num_home,type_tree,num_tree,location,lat,lng,post_ip,status,active)
                Values('','" .$_POST['frm_name']. "','" .$_POST['frm_tel']. "','" .$_POST['frm_email']. "','" .$_POST['frm_province']. "','" .$_POST['frm_amphur']. "'
                  ,'" .$_POST['frm_district']. "','" .$_POST['frm_moo']. "','" .$_POST['frm_numhome']. "'
                ,'" .$_POST['frm_typetree']. "','" .$_POST['frm_numtree']. "','" .$_POST['frm_location']. "'
                ,'" .$_POST['frm_lat']. "','" .$_POST['frm_lng']. "','" .$_SERVER['REMOTE_ADDR']. "','1','1')";
                $rs = rsQuery($sql);

                  $sql2 = "SELECT * FROM $table ORDER BY id DESC LIMIT 0,1";
                  $rss = rsQuery($sql2);
                  $num = mysqli_fetch_array($rss);
                  $lid = $num['id'];
                  $date = date("Y-m-d H:i:s");
                  $receiveno = "700" . $lid;

//                  $sql = "INSERT INTO tb_request(id,table_name,master_id,modid,receiveno,datein)
//                  Values('','" .$table. "','" .$lid. "','" .$modid. "','" .$receiveno. "','" .$date. "')";
//                  $rs = rsQuery($sql);
//
//                include_once("itgmod/sent_email.php");
//
//                  $sql = "INSERT INTO tb_notification(id,subject,detail,modid,master_id,allstatus,substatus)
//                  Values('','" .$_POST['frm_name']. "','" .$modname. "','" .$modid. "','" .$lid. "','0','0')";
//                  $rs = rsQuery($sql);






                    for($i=0; $i<count($_FILES['f_image']['name']); $i++){

                        $filename = $_FILES["f_image"]["name"][$i];
                        $ext = end(explode(".",$filename));
                        $newname = "Help_Im_".$_POST['id'].'_'.$i.'.'.$ext;
                        $filetmp = $_FILES["f_image"]["tmp_name"][$i];
                        $filetype = $_FILES["f_image"]["type"][$i];
                        $filepath = "fileupload/im_help/".$newname;

                            if (move_uploaded_file($filetmp,$filepath)) {

                                $sql = "INSERT INTO tb_files_image(id_image,image_path,image_key) VALUES ('','".$filepath."','".$_POST['f_key']."')";
                                $rs = rsQuery($sql);
                            } else {
                                echo "<script>alert('Image not upload.'); </script>";
                            }
                        }


  }
  ?>


<style>
    #map2 {
        height: 400px;
        width: 100%;
    }
    body {
        font-family:THSarabunNew;
    }
    h1,h2,h3,h4,h5{
        font-family:THSarabunNew;
    }
</style>

<!-- Heading -->
  <div id="heading" >
    <h1><?php echo $modname; ?></h1>
  </div>
<!-- Main -->
  <section id="main" class="wrapper">
    <div class="inner">
      <div class="content">
        <?php  echo '<img src="/../images/qr.png"/>' ?>
        <div class="row">
          <div class="col-12 col-12-medium">

              <form method="post" action="#" onsubmit="return(validate());" name="myForm" enctype="multipart/form-data">
                <div class="row gtr-uniform">

                  <div class="col-12 col-12-xsmall">
                    <h3>ข้อมูลผู้แจ้ง</h3>
                  </div>
                  <div class="col-6 col-12-xsmall">
                    <input class="form-control" type="text" name="frm_name" id="frm_name" value="" placeholder="ชื่อ-สกุล" />
                  </div>
                  <div class="col-6 col-12-xsmall">
                    <input class="form-control" type="text" name="frm_tel" id="frm_tel" value="" placeholder="โทรศัพท์" />
                  </div>
<!--                  <div class="col-6 col-12-xsmall">-->
<!--                    <input class="form-control" type="text" name="frm_email" id="frm_email" value="" placeholder="อีเมล" />-->
<!--                  </div>-->
                  <div class="col-12 col-12-xsmall">
<!--                    <h3>ที่อยู่</h3>-->
<!--                  </div>-->
<!--                  <div class="col-3 col-12-xsmall">-->
<!--                    <select name="frm_province" id="frm_province">-->
<!--                      <option value="">- จังหวัด -</option>-->
<!--                    --><?php
//                      $sql = "SELECT * FROM province";
//                      $rs = rsQuery($sql);
//                      while ($row = mysqli_fetch_array($rs)) {
//                        echo "<option value=".$row['PROVINCE_ID'].">".$row['PROVINCE_NAME']."</option>";
//                      }
//                    ?>
<!--                    </select>-->
<!--                  </div>-->
<!--                  <div class="col-3 col-12-xsmall">-->
<!--                    <select name="frm_amphur" id="frm_amphur">-->
<!--                      <option value="">- อำเภอ -</option>-->
<!--                    </select>-->
<!--                  </div>-->
<!--                  <div class="col-2 col-12-xsmall">-->
<!--                    <select name="frm_district" id="frm_district">-->
<!--                      <option value="">- ตำบล -</option>-->
<!--                    </select>-->
<!--                  </div>-->
<!--                  <div class="col-2 col-12-xsmall">-->
<!--                    <input type="text" name="frm_moo" id="frm_moo" value="" placeholder="หมู่ที่" />-->
<!--                  </div>-->
<!--                  <!-- Break -->
<!--                  <div class="col-2 col-12-xsmall">-->
<!--                    <input type="text" name="frm_numhome" id="frm_numhome" value="" placeholder="บ้านเลขที่" />-->
<!--                  </div>-->
<!--                  <!-- Break -->
<!--                  <div class="col-12 col-12-xsmall">-->
<!--                    <label>ขอยื่นคำร้องขอตัดต้นไม้</label>-->
<!--                  </div>-->
<!--                  <!-- Break -->
<!--
<!--                  <!-- Break -->
<!--                  <div class="col-9 col-12-xsmall">-->
<!--                    <input type="text" name="frm_typetree" id="frm_typetree" value="" placeholder="ชื่อชนิดต้นไม้" />-->
<!--                  </div>-->
<!--                  <div class="col-3 col-12-xsmall">-->
<!--                    <input type="text" name="frm_numtree" id="frm_numtree" value="" placeholder="จำนวน/ต้น" />-->
<!--                  </div>-->
<!--
<!--                  <div class="col-12 col-12-xsmall">-->
<!--                    <textarea id="frm_location" name="frm_location" placeholder="ซึ่งตั้งอยู่บริเวณ (กรุณาระบุจุดให้ชัดเจน)" rows="2"></textarea>-->
<!--                  </div>-->
<!--                  <!-- Break -->
<!--
<!--                  <div class="col-12 col-12-xsmall">-->
<!--                  <p style="font-weight: bold;">เงื่อนไข<br>-->
<!--                  1. ต้นไม้ที่ต้องการตัดดังกล่าวเป็นของท่านเอง<br>-->
<!--                  2. ต้นไม้ที่ต้องการตัดดังกล่าวไม่ได้เป็นไม่หวงห้ามตาม พ.ร.บ. ป่าไม่<br>-->
<!--                  </p>-->
<!--                  </div>-->


                  <!-- Break -->
                      <br>
                  <div class="col-12 col-12-xsmall">
                    <label>สลิปธนาคาร </label>
                    <input type="file" name="frm_image[]" id="frm_image[]" multiple></input>
                  </div>
                  <!-- Break -->



<!--                  <div class="col-12 col-12-xsmall">-->
<!--                    <div class="row">-->
<!--                        <div class="col-4">-->
<!--                        </div>-->
<!--                        <div class="col-4">-->
<!--                          <input class="form-control" type="text" name="mapsearch" placeholder="ค้นหาสถานที่" id="mapsearch">-->
<!--                        </div>-->
<!--                        <div class="col-4">-->
<!--                        </div>-->
<!--                      </div>-->
<!--                    </div>-->
<!---->
<!--                    <div class="col-12 col-12-xsmall" style="padding: 0px; border: solid 1px; border-color: rgba(0, 0, 0, 0.25); margin: 10px 0px 10px 40px;">-->
<!--                    <div id="map2"></div>-->
<!--                  </div>-->
                  <!-- Break -->

<!--                  <input type="hidden" name="frm_lat" id="frm_lat"/>-->
<!--                  <input type="hidden" name="frm_lng" id="frm_lng"/>-->

                      <div class="col-4" style="margin:2% auto;" >
                          <ul class="actions">
                              <input class="form-control bg-success" type="submit" name="Submit" value="ยืนยันการชำระภาษี" class="primary" /></li>
                              <input class="form-control bg-warning" type="reset" value="ล้างข้อมูล" /></li>
                          </ul>
                      </div>
                </div>
              </form>


          </div>
        </div>

        </div>
    </div>
  </section>



  <script type = "text/javascript">

        function validate() {

           if( document.myForm.frm_name.value == "" ) {
              alert( "กรุณากรอก ชื่อ-สกุล!" );
              document.myForm.frm_name.focus() ;
              return false;
           }
           if( document.myForm.frm_tel.value == "" ) {
              alert( "กรุณากรอก เบอร์โทรศัพท์ !" );
              document.myForm.frm_tel.focus() ;
              return false;
           }
           // if( document.myForm.frm_email.value == "" ) {
           //    alert( "กรุณากรอก อีเมล!" );
           //    document.myForm.frm_email.focus() ;
           //    return false;
           // }
           // if( document.myForm.frm_province.value == "" ) {
           //    alert( "กรุณาเลือก จังหวัด!" );
           //    document.myForm.frm_province.focus() ;
           //    return false;
           // }
           // if( document.myForm.frm_amphur.value == "" ) {
           //    alert( "กรุณาเลือก อำเภอ!" );
           //    document.myForm.frm_amphur.focus() ;
           //    return false;
           // }
           // if( document.myForm.frm_district.value == "" ) {
           //    alert( "กรุณาเลือก ตำบล!" );
           //    document.myForm.frm_district.focus() ;
           //    return false;
           // }
           // if( document.myForm.frm_moo.value == "" ) {
           //    alert( "กรุณากรอก หมู่ที่!" );
           //    document.myForm.frm_moo.focus() ;
           //    return false;
           // }
           // if( document.myForm.frm_numhome.value == "" ) {
           //    alert( "กรุณากรอก บ้านเลขที่!" );
           //    document.myForm.frm_numhome.focus() ;
           //    return false;
           // }
           // if( document.myForm.frm_typetree.value == "" ) {
           //    alert( "กรุณาระบุ ประเภทข้อต้นไม้!" );
           //    document.myForm.frm_typetree.focus() ;
           //    return false;
           // }
           // if( document.myForm.frm_numtree.value == "" ) {
           //    alert( "กรุณาระบุ จำนวนต้นไม้!" );
           //    document.myForm.frm_numtree.focus() ;
           //    return false;
           // }
           // if( document.myForm.frm_location.value == "" ) {
           //    alert( "กรุณากรอก สถานที่!" );
           //    document.myForm.frm_location.focus() ;
           //    return false;
           // }


           return( true );
        }

  </script>


  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDg49SZLUZdLu8KQ80fEAPJkbdBUqyN-vw&callback=initMap&libraries=places" ></script>
  <script>
      function initMap(){
          myLatLng = {lat: <?php echo $lat_main; ?>, lng: <?php echo $lng_main; ?>};
          var map = new google.maps.Map(document.getElementById('map2'), {
              center: myLatLng,
              zoom: 18
          });

          var marker = new google.maps.Marker({
              position: myLatLng,
              map: map,
              draggable:true
          });

          google.maps.event.addListener(marker,'dragend',function () {
              var lat = marker.getPosition().lat();
              var lng = marker.getPosition().lng();

              document.getElementById("frm_lat").value = lat.toFixed(5);
              document.getElementById("frm_lng").value = lng.toFixed(5);

          });

          var searchBox = new google.maps.places.SearchBox(document.getElementById('mapsearch'));

          google.maps.event.addListener(searchBox, 'places_changed',function () {
              var places = searchBox.getPlaces();

              var bounds = new google.maps.LatLngBounds();
              var i, place;
              for(i=0;place=places[i];i++){
                  console.log(places);
                  bounds.extend(place.geometry.location);
                  marker.setPosition(place.geometry.location);
                  var item_lat = place.geometry.location.lat();
                  var item_lng = place.geometry.location.lng();
              }

              document.getElementById("frm_lat").value = item_lat.toFixed(5);
              document.getElementById("frm_lng").value = item_lng.toFixed(5);

              google.maps.event.addListener(marker,'dragend',function () {
                  var lat = marker.getPosition().lat();
                  var lng = marker.getPosition().lng();

                  document.getElementById("frm_lat").value = lat.toFixed(5);
                  document.getElementById("frm_lng").value = lng.toFixed(5);
              });

              map.fitBounds(bounds);
              map.setZoom(15);

          });
      }

  </script>



  <script src="js/jquery-3.3.1.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#frm_province').change(function() {
                    $.ajax({
                        type: 'POST',
                        data: {data: $(this).val()},
                        url: 'modules/test/select.php',
                        success: function(data) {
                            $('#frm_amphur').html(data);
                        }
                    });
                    return false;
                });

                $('#frm_amphur').change(function() {
                    $.ajax({
                        type: 'POST',
                        data: {data2: $(this).val()},
                        url: 'modules/test/select.php',
                        success: function(data) {
                            $('#frm_district').html(data);
                        }
                    });
                    return false;
                });

            });
        </script>
