<?php
    $login_id = @$_GET["login_id"];
    $sql = "
        SELECT
            login.*,
            user.user_name,
            user.user_lname,
            prefix.prefix_name
        FROM login
            LEFT JOIN user ON user.user_id=login.user
            LEFT JOIN prefix ON prefix.prefix_id=user.prefix_id
        WHERE login.login_id='".$login_id."' 
            AND (login.user='".$USER["user_id"]."' OR login.email='".$USER['email']."' )
    ";
    $obj = $DATABASE->QueryObj($sql);
    if( sizeof($obj)==0 ) {
        ShowAlert('', 'ไม่พบข้อมูล', 'error', './?page=login');
        exit();
    }
    $data = $obj[0];
?>
<div id="content-title">
    <a href="./?page=all-login">ประวัติการล็อกอิน</a>
</div>
<div id="content-body">
    <div class="table-responsive">
        <table class="table table-hover">
            <tbody>
                <tr>
                    <th>วันเวลา</th>
                    <td><?php echo DateTh($data["date"]); ?> น.</td>
                </tr>
                <tr>
                    <th>IP Address</th>
                    <td><?php echo $data["ip_local"]; ?></td>
                </tr>
                <?php
                    $more = json_decode($data["json_ip"], true);
                    foreach ($more as $key => $value) {
                        echo '
                            <tr>
                                <th>'.showKey($key).'</th>
                                <td>'.showValue($key, $value).'</td>
                            </tr>
                        ';
                    }
                ?>
                <?php 
                    function showKey($key) {
                        $ext = array(
                            ""=>"-",
                            "ip"=>"Public IP Address",
                            "city"=>"เมือง",
                            "region"=>"จังหวัด",
                            "country"=>"ประเทศ",
                            "loc"=>"พิกัด",
                            "postal"=>"รหัสไปรษณีย์",
                            "org"=>"องค์กร",
                        );
                        return isset($ext[$key]) ? $ext[$key] : $key;
                    }
                    function showValue($key, $value) {
                        global $countries;
                        if( $key=="country" ) return $countries[$value];
                        return $value;
                    }
                    /*
                    {
                        "ip": "202.29.146.203",
                        "city": "Hat Yai",
                        "region": "Songkhla",
                        "country": "TH",
                        "loc": "7.0084,100.4770",
                        "postal": "90110",
                        "org": "AS9464 Prince of Songkla University (Sritrang'NET)"
                    }
                    */
                ?>
                <tr>
                    <th>Session ID</th>
                    <td><?php echo $data["session"]; ?></td>
                </tr>
                <tr>
                    <th>สถานะ</th>
                    <td>
                        <?php
                            if( $data["status"]=="Y" ) {
                                echo '<span class="text-success mr-3"><i class="fas fa-check mr-2"></i> ล็อกอินสำเร็จ</span>';
                                echo '( '.$data["prefix_name"].''.$data["user_name"].' '.$data["user_lname"].' )';
                            } else {
                                echo '<span class="text-danger mr-3"><i class="fas fa-times mr-2"></i> ล็อกอินไม่สำเร็จ</span>';
                                echo '(อีเมล: '.$data["email"].', รหัสผ่าน: '.$data["password"].')';
                            }
                        ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <input type="hidden" id="data" value="<?php echo htmlspecialchars(json_encode($data)); ?>">
    <div id="map"></div>
</div>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDj6M1di2w83d6BX1zHElY8UH_HbeJf2Ro&callback=initMap" async defer></script>
