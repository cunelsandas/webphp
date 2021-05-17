<?php
$no = EscapeValue(decode64($_GET['no']));
$mod = EscapeValue(decode64($_GET['_mod']));
$tablename = FindRS("select * from tb_mod where modtype='$mod'", "tablename");
$folder = FindRS("select * from tb_mod where modtype='$mod'", "foldername");
$foldername = $gloUploadPath . "/" . $folder . "/";
$sql = "Select * from $tablename where no=$no";
$rs = rsQuery($sql);
$row = mysqli_fetch_array($rs);

?>
<center>
    <div id="master-table">
        <table width="100%">
            <tr>
                <td colspan="2" align="left" style="padding:8px;">
                    &nbsp;ชื่อเอกสาร&nbsp;:&nbsp;<?php echo $row['subject']; ?>&nbsp;
                    <?php
                    if ($showdate == "yes") {
                        echo "&nbsp;[&nbsp;" . thaidate($row['datepost']) . "&nbsp;]";
                    }

                    ?>
                    <!-- Load Facebook SDK for JavaScript -->
                    <div id="fb-root"></div>
                    <script>
                        (function (d, s, id) {
                            var js, fjs = d.getElementsByTagName(s)[0];
                            if (d.getElementById(id)) return;
                            js = d.createElement(s);
                            js.id = id;
                            js.src = "//connect.facebook.net/th_TH/sdk.js#xfbml=1&version=v2.6";
                            fjs.parentNode.insertBefore(js, fjs);
                        }(document, 'script', 'facebook-jssdk'));
                    </script>

                    <div class="fb-share-button"
                         data-href="http://<?php echo $domainname; ?>/index.php?_mod=<?php echo encode64($mod); ?>&no=<?php echo encode64($no); ?>"
                         data-layout="button"
                         data-size="small"
                         data-mobile-iframe="true">
                        <a class="fb-xfbml-parse-ignore" target="_blank"
                           href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse">แชร์</a>
                    </div>
    </div>
    <div class="line-it-button" data-lang="en" data-type="share-a" data-ver="3" data-url="http://<?php echo $domainname;?>/index.php?_mod=<?php echo encode64($mod);?>&no=<?php echo encode64($no);?>" data-color="default" data-size="small" data-count="false" style="display: none;"></div>
    <script src="https://d.line-scdn.net/r/web/social-plugin/js/thirdparty/loader.min.js" async="async" defer="defer"></script>

                </td>
            </tr>
            <tr>
                <td width="20%" valign="top">รายละเอียดเอกสาร</td>
                <td valign="top"><?php echo nl2br($row['detail']); ?></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <?php
                    $strSql = "select * from filename where tablename='$tablename' AND masterid='" . $no . "' Order by id DESC";
                    $rs2 = rsQuery($strSql);

                    if ($rs2) {
                        //$i=0;
                        while ($rs_filename = mysqli_fetch_array($rs2)) {

                            $cpic = file_exists($foldername . $rs_filename['filename']);
                            $type = strtolower(substr($rs_filename['filename'], -3));
                            $type = explode('.', $rs_filename['filename']);
                            $type = end($type);
                            if ($cpic) {
                                /*if ($type <> "pdf") {
                                    echo "<a href=" . $foldername . $rs_filename['filename'] . " target=\"_blank\"><img src=" . $foldername . $rs_filename['filename'] . " width=\"150\" height=150 id='$borderpic' /></a>&nbsp;&nbsp;";

                                } else {
                                    echo "<a href=" . $foldername . $rs_filename['filename'] . " target=\"_blank\"><img src=\"images/pdf.gif\" title=\"ดาวน์โหลดเอกสาร\"></a>&nbsp;&nbsp;";
                                }*/
                                if ($type === 'xls' || $type === 'xlsx' || $type === 'XLS' || $type === 'XLSX') {
                                    echo '<a href="' . $foldername . $rs_filename['filename'] . '" target="_blank"><img width="80" height="80" src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDUxMiA1MTIiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDUxMiA1MTI7IiB4bWw6c3BhY2U9InByZXNlcnZlIiB3aWR0aD0iNTEycHgiIGhlaWdodD0iNTEycHgiPgo8Zz4KCTxwYXRoIHN0eWxlPSJmaWxsOiM0Q0FGNTA7IiBkPSJNMjk0LjY1NiwxMy4wMTRjLTIuNTMxLTIuMDU2LTUuODYzLTIuODQyLTkuMDQ1LTIuMTMzbC0yNzcuMzMzLDY0ICAgQzMuMzk3LDc2LjAwMy0wLjA0Nyw4MC4zNjksMCw4NS4zNzd2MzYyLjY2N2MwLjAwMiw1LjI2MywzLjg0Myw5LjczOSw5LjA0NSwxMC41MzlsMjc3LjMzMyw0Mi42NjcgICBjNS44MjMsMC44OTUsMTEuMjY5LTMuMDk5LDEyLjE2NC04LjkyMWMwLjA4Mi0wLjUzNSwwLjEyNC0xLjA3NiwwLjEyNC0xLjYxN1YyMS4zNzdDMjk4LjY3NiwxOC4xMjQsMjk3LjE5OSwxNS4wNDUsMjk0LjY1NiwxMy4wMTQgICB6Ii8+Cgk8cGF0aCBzdHlsZT0iZmlsbDojNENBRjUwOyIgZD0iTTUwMS4zMzQsNDU4LjcxSDI4OGMtNS44OTEsMC0xMC42NjctNC43NzYtMTAuNjY3LTEwLjY2N2MwLTUuODkxLDQuNzc2LTEwLjY2NywxMC42NjctMTAuNjY3ICAgaDIwMi42NjdWNzQuNzFIMjg4Yy01Ljg5MSwwLTEwLjY2Ny00Ljc3Ni0xMC42NjctMTAuNjY3UzI4Mi4xMDksNTMuMzc3LDI4OCw1My4zNzdoMjEzLjMzM2M1Ljg5MSwwLDEwLjY2Nyw0Ljc3NiwxMC42NjcsMTAuNjY3ICAgdjM4NEM1MTIsNDUzLjkzNSw1MDcuMjI1LDQ1OC43MSw1MDEuMzM0LDQ1OC43MXoiLz4KPC9nPgo8Zz4KCTxwYXRoIHN0eWxlPSJmaWxsOiNGQUZBRkE7IiBkPSJNMjAyLjY2NywzNTIuMDQ0Yy0zLjY3OCwwLTcuMDk2LTEuODk1LTkuMDQ1LTUuMDEzTDg2Ljk1NSwxNzYuMzY0ICAgYy0zLjI3OS00Ljg5NC0xLjk2OS0xMS41MiwyLjkyNS0xNC43OTlzMTEuNTItMS45NjksMTQuNzk5LDIuOTI1YzAuMTI5LDAuMTkyLDAuMjUxLDAuMzg4LDAuMzY3LDAuNTg4bDEwNi42NjcsMTcwLjY2NyAgIGMzLjExLDUuMDAzLDEuNTc2LDExLjU4LTMuNDI3LDE0LjY5MUMyMDYuNTk5LDM1MS40ODQsMjA0LjY1MywzNTIuMDQxLDIwMi42NjcsMzUyLjA0NHoiLz4KCTxwYXRoIHN0eWxlPSJmaWxsOiNGQUZBRkE7IiBkPSJNOTYsMzUyLjA0NGMtNS44OTEtMC4wMTItMTAuNjU3LTQuNzk3LTEwLjY0NS0xMC42ODhjMC4wMDQtMS45OTIsMC41NjYtMy45NDMsMS42MjEtNS42MzIgICBsMTA2LjY2Ny0xNzAuNjY3YzIuOTU0LTUuMDk3LDkuNDgxLTYuODM0LDE0LjU3Ny0zLjg4YzUuMDk3LDIuOTU0LDYuODM0LDkuNDgxLDMuODgsMTQuNTc3Yy0wLjExNiwwLjItMC4yMzgsMC4zOTYtMC4zNjcsMC41ODggICBMMTA1LjA2NywzNDcuMDA5QzEwMy4xMTksMzUwLjE0Miw5OS42OSwzNTIuMDQ3LDk2LDM1Mi4wNDR6Ii8+CjwvZz4KPGc+Cgk8cGF0aCBzdHlsZT0iZmlsbDojNENBRjUwOyIgZD0iTTM3My4zMzQsNDU4LjcxYy01Ljg5MSwwLTEwLjY2Ny00Ljc3Ni0xMC42NjctMTAuNjY3di0zODRjMC01Ljg5MSw0Ljc3Ni0xMC42NjcsMTAuNjY3LTEwLjY2NyAgIGM1Ljg5MSwwLDEwLjY2Nyw0Ljc3NiwxMC42NjcsMTAuNjY3djM4NEMzODQsNDUzLjkzNSwzNzkuMjI1LDQ1OC43MSwzNzMuMzM0LDQ1OC43MXoiLz4KCTxwYXRoIHN0eWxlPSJmaWxsOiM0Q0FGNTA7IiBkPSJNNTAxLjMzNCwzOTQuNzFIMjg4Yy01Ljg5MSwwLTEwLjY2Ny00Ljc3Ni0xMC42NjctMTAuNjY3YzAtNS44OTEsNC43NzYtMTAuNjY3LDEwLjY2Ny0xMC42NjcgICBoMjEzLjMzM2M1Ljg5MSwwLDEwLjY2Nyw0Ljc3NiwxMC42NjcsMTAuNjY3QzUxMiwzODkuOTM1LDUwNy4yMjUsMzk0LjcxLDUwMS4zMzQsMzk0LjcxeiIvPgoJPHBhdGggc3R5bGU9ImZpbGw6IzRDQUY1MDsiIGQ9Ik01MDEuMzM0LDMzMC43MUgyODhjLTUuODkxLDAtMTAuNjY3LTQuNzc2LTEwLjY2Ny0xMC42NjdjMC01Ljg5MSw0Ljc3Ni0xMC42NjcsMTAuNjY3LTEwLjY2NyAgIGgyMTMuMzMzYzUuODkxLDAsMTAuNjY3LDQuNzc2LDEwLjY2NywxMC42NjdDNTEyLDMyNS45MzUsNTA3LjIyNSwzMzAuNzEsNTAxLjMzNCwzMzAuNzF6Ii8+Cgk8cGF0aCBzdHlsZT0iZmlsbDojNENBRjUwOyIgZD0iTTUwMS4zMzQsMjY2LjcxSDI4OGMtNS44OTEsMC0xMC42NjctNC43NzYtMTAuNjY3LTEwLjY2N2MwLTUuODkxLDQuNzc2LTEwLjY2NywxMC42NjctMTAuNjY3ICAgaDIxMy4zMzNjNS44OTEsMCwxMC42NjcsNC43NzYsMTAuNjY3LDEwLjY2N0M1MTIsMjYxLjkzNSw1MDcuMjI1LDI2Ni43MSw1MDEuMzM0LDI2Ni43MXoiLz4KCTxwYXRoIHN0eWxlPSJmaWxsOiM0Q0FGNTA7IiBkPSJNNTAxLjMzNCwyMDIuNzFIMjg4Yy01Ljg5MSwwLTEwLjY2Ny00Ljc3Ni0xMC42NjctMTAuNjY3czQuNzc2LTEwLjY2NywxMC42NjctMTAuNjY3aDIxMy4zMzMgICBjNS44OTEsMCwxMC42NjcsNC43NzYsMTAuNjY3LDEwLjY2N1M1MDcuMjI1LDIwMi43MSw1MDEuMzM0LDIwMi43MXoiLz4KCTxwYXRoIHN0eWxlPSJmaWxsOiM0Q0FGNTA7IiBkPSJNNTAxLjMzNCwxMzguNzFIMjg4Yy01Ljg5MSwwLTEwLjY2Ny00Ljc3Ni0xMC42NjctMTAuNjY3YzAtNS44OTEsNC43NzYtMTAuNjY3LDEwLjY2Ny0xMC42NjcgICBoMjEzLjMzM2M1Ljg5MSwwLDEwLjY2Nyw0Ljc3NiwxMC42NjcsMTAuNjY3QzUxMiwxMzMuOTM1LDUwNy4yMjUsMTM4LjcxLDUwMS4zMzQsMTM4LjcxeiIvPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+Cjwvc3ZnPgo="></a>&nbsp;&nbsp;';
                                } elseif ($type === 'doc' || $type === 'docx' || $type === 'DOC' || $type === 'DOCX') {
                                    echo '<a href="' . $foldername . $rs_filename['filename'] . '" target="_blank"><img width="80" height="80" src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTkuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDUxMiA1MTIiIHN0eWxlPSJlbmFibGUtYmFja2dyb3VuZDpuZXcgMCAwIDUxMiA1MTI7IiB4bWw6c3BhY2U9InByZXNlcnZlIiB3aWR0aD0iNTEycHgiIGhlaWdodD0iNTEycHgiPgo8cGF0aCBzdHlsZT0iZmlsbDojRUNFRkYxOyIgZD0iTTQ5Niw0MzIuMDA0SDI3MmMtOC44MzIsMC0xNi03LjEzNi0xNi0xNnMwLTMxMS4xNjgsMC0zMjBzNy4xNjgtMTYsMTYtMTZoMjI0ICBjOC44MzIsMCwxNiw3LjE2OCwxNiwxNnYzMjBDNTEyLDQyNC44NjgsNTA0LjgzMiw0MzIuMDA0LDQ5Niw0MzIuMDA0eiIvPgo8Zz4KCTxwYXRoIHN0eWxlPSJmaWxsOiMxOTc2RDI7IiBkPSJNNDMyLDE3Ni4wMDRIMjcyYy04LjgzMiwwLTE2LTcuMTM2LTE2LTE2czcuMTY4LTE2LDE2LTE2aDE2MGM4LjgzMiwwLDE2LDcuMTY4LDE2LDE2ICAgUzQ0MC44MzIsMTc2LjAwNCw0MzIsMTc2LjAwNHoiLz4KCTxwYXRoIHN0eWxlPSJmaWxsOiMxOTc2RDI7IiBkPSJNNDMyLDI0MC4wMDRIMjcyYy04LjgzMiwwLTE2LTcuMTM2LTE2LTE2czcuMTY4LTE2LDE2LTE2aDE2MGM4LjgzMiwwLDE2LDcuMTY4LDE2LDE2ICAgUzQ0MC44MzIsMjQwLjAwNCw0MzIsMjQwLjAwNHoiLz4KCTxwYXRoIHN0eWxlPSJmaWxsOiMxOTc2RDI7IiBkPSJNNDMyLDMwNC4wMDRIMjcyYy04LjgzMiwwLTE2LTcuMTM2LTE2LTE2YzAtOC44NjQsNy4xNjgtMTYsMTYtMTZoMTYwYzguODMyLDAsMTYsNy4xNjgsMTYsMTYgICBTNDQwLjgzMiwzMDQuMDA0LDQzMiwzMDQuMDA0eiIvPgoJPHBhdGggc3R5bGU9ImZpbGw6IzE5NzZEMjsiIGQ9Ik00MzIsMzY4LjAwNEgyNzJjLTguODMyLDAtMTYtNy4xMzYtMTYtMTZzNy4xNjgtMTYsMTYtMTZoMTYwYzguODMyLDAsMTYsNy4xNjgsMTYsMTYgICBTNDQwLjgzMiwzNjguMDA0LDQzMiwzNjguMDA0eiIvPgo8L2c+CjxwYXRoIHN0eWxlPSJmaWxsOiMxNTY1QzA7IiBkPSJNMjgyLjIwOCwxOS43MTZjLTMuNjQ4LTMuMDcyLTguNTQ0LTQuMzUyLTEzLjE1Mi0zLjQyNGwtMjU2LDQ4QzUuNTA0LDY1LjcsMCw3Mi4zMjQsMCw4MC4wMDR2MzUyICBjMCw3LjY4LDUuNDcyLDE0LjMwNCwxMy4wNTYsMTUuNzEybDI1Niw0OGMwLjk5MiwwLjE5MiwxLjk1MiwwLjI4OCwyLjk0NCwwLjI4OGMzLjcxMiwwLDcuMzI4LTEuMjgsMTAuMjA4LTMuNjggIGMzLjY4LTMuMDQsNS43OTItNy41NTIsNS43OTItMTIuMzJ2LTQ0OEMyODgsMjcuMjM2LDI4NS44ODgsMjIuNzU2LDI4Mi4yMDgsMTkuNzE2eiIvPgo8cGF0aCBzdHlsZT0iZmlsbDojRkFGQUZBOyIgZD0iTTIwNy45MDQsMzM3Ljc5NmMtMC44MzIsNy4zMjgtNi41OTIsMTMuMTg0LTEzLjkyLDE0LjA4Yy0wLjY3MiwwLjA5Ni0xLjMxMiwwLjEyOC0xLjk4NCwwLjEyOCAgYy02LjU5MiwwLTEyLjYwOC00LjA5Ni0xNC45NzYtMTAuMzY4TDE0NCwyNTMuNTcybC0zMy4wMjQsODguMDY0Yy0yLjU2LDYuODQ4LTkuMjgsMTEuMDQtMTYuNzA0LDEwLjI3MiAgYy03LjI2NC0wLjc2OC0xMy4wODgtNi40LTE0LjExMi0xMy42NjRsLTE2LTExMmMtMS4yNDgtOC43MDQsNC44MzItMTYuODMyLDEzLjU2OC0xOC4wOGM4Ljc2OC0xLjI4LDE2Ljg2NCw0LjgzMiwxOC4xMTIsMTMuNTY4ICBsNy4xMzYsNTAuMDQ4bDI2LjAxNi02OS40MDhjNC42NzItMTIuNDgsMjUuMjgtMTIuNDgsMjkuOTg0LDBsMjQuNTEyLDY1LjM0NGw4LjYwOC03Ny41MDRjMC45OTItOC43NjgsOS4xMi0xNS4wNzIsMTcuNjY0LTE0LjE0NCAgYzguOCwxLjAyNCwxNS4xMDQsOC45MjgsMTQuMTQ0LDE3LjY5NkwyMDcuOTA0LDMzNy43OTZ6Ii8+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+CjxnPgo8L2c+Cjwvc3ZnPgo="></a>&nbsp;&nbsp;';
                                } elseif ($type === 'pdf' || $type === 'PDF' ) {
                                    echo '<a href="' . $foldername . $rs_filename['filename'] . '" target="_blank"><img width="80" height="80" src="images/pdf.gif"></a>&nbsp;&nbsp;';
                                } else {
                                    echo "<a href=" . $foldername . $rs_filename['filename'] . " target=\"_blank\"><img src=" . $foldername . $rs_filename['filename'] . " width=\"150\" height=150 id='$borderpic' /></a>&nbsp;&nbsp;";
                                }
                            }
                        }
                    }
                    //echo "<iframe id='".$rs_filename['filename']."' width='600' height='800' src='".$foldername.$rs_filename['filename']."'></iframe>";
                    //echo "<object src='".$foldername.$rs_filename['filename']."' width='700px' height='700px'>";
                    //echo "<embed src='".$foldername.$rs_filename['filename']."' width='700px' height='700px'></embed>";
                    //echo "</object>";
                    ?>

                </td>
            </tr>
        </table>
    </div>
    <?php
    $strSql = "select * from filename where tablename='$tablename' AND masterid='" . $no . "' Order by id DESC";
    $rs2 = rsQuery($strSql);
    if ($rs2) {
        //$i=0;
        while ($rs_filename = mysqli_fetch_array($rs2)) {
            $cpic = file_exists($foldername . $rs_filename['filename']);
            $type = strtolower(substr($rs_filename['filename'], -3));
            $type = explode('.', $rs_filename['filename']);
            $type = end($type);
            if ($cpic) {
                if ($type === 'pdf') { ?>
                    <br>
                    <embed src="<?php echo $foldername . $rs_filename['filename']; ?>" width="80%" height="700px"
                           pluginspage="http://www.adobe.com/products/acrobat/readstep2.html">
                <?php }
            }
        }
    } ?>
    <br>
    <br>
    <A HREF="javascript:history.back()">ย้อนกลับ</A>
</center>
</div>