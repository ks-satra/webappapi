<?php
    $user_id = @$_GET["user_id"];
    $sql = "
        SELECT
            u1.*, 
            ip.item_prefix_name,
            ip2.item_prefix_name p2_prefix,
            u2.user_name u2_name,
            u2.user_lname u2_lname
        FROM user u1
            INNER JOIN item_prefix ip ON ip.item_prefix_id = u1.item_prefix_id
            INNER JOIN user u2 ON u2.user_id=u1.user
            INNER JOIN item_prefix ip2 ON ip2.item_prefix_id = u2.item_prefix_id
        WHERE u1.user_id='".$user_id."'
    ";
    $obj = $DATABASE->QueryObj($sql);
    if( sizeof($obj)!=1 ) {
        Back();
    }
    $data = $obj[0];
?>
<input type="hidden" id="data" value="<?php echo htmlspecialchars(json_encode($data)); ?>">
<div id="content-title">
    ข้อมูลผู้ใช้งาน
</div>
<div id="content-body">
    <div class="row">
        <div class="col-md-2 text-center mb-5">
            <a class="d-block text-center m-auto" style="max-width: 200px;"
                href="./files/user/<?php echo $data["image"]; ?>" data-image-viewer>
                <img class="img-thumbnail w-100" src="./files/user/<?php echo $data["image"]; ?>" alt="Profile Image"
                    onerror="onError(this)">
            </a>
        </div>
        <div class="col-md-10">
            <div class="mb-4 profile">
                <div class="row">
                    <div class="col-sm-4 col-md-3 col-lg-2 profile-left">ชื่อ - นามสกุล</div>
                    <div class="col-sm-8 col-md-3 col-lg-4 profile-right">
                        <?php echo $data["item_prefix_name"]; ?><?php echo $data["user_name"]; ?>
                        <?php echo $data["user_lname"]; ?>
                    </div>
                    <div class="col-sm-4 col-md-3 col-lg-2 profile-left">โทรศัพท์</div>
                    <div class="col-sm-8 col-md-3 col-lg-4 profile-right">
                        <?php echo $data["phone"]; ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 col-md-3 col-lg-2 profile-left">อีเมล</div>
                    <div class="col-sm-8 col-md-3 col-lg-4 profile-right">
                        <?php echo $data["email"]; ?>
                    </div>
                    <div class="col-sm-4 col-md-3 col-lg-2 profile-left">สถานะ</div>
                    <div class="col-sm-8 col-md-3 col-lg-4 profile-right">
                        <?php 
                            $status = array(
                                "Y"=>"<span data-status='N' class='btn-status text-success'><i class='fas fa-check mr-1'></i> ใช้งาน</span>",
                                "N"=>"<span data-status='Y' class='btn-status text-danger'><i class='fas fa-times mr-1'></i> ไม่ได้ใช้งาน</span>",
                            );
                            echo $status[$data["status"]]; 
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 col-md-3 col-lg-2 profile-left">วันที่อัพเดตล่าสุด</div>
                    <div class="col-sm-8 col-md-3 col-lg-4 profile-right">
                        <?php echo DateTh($data["date"]); ?> น.
                    </div>
                    <div class="col-sm-4 col-md-3 col-lg-2 profile-left">ผู้อัพเดตล่าสุด</div>
                    <div class="col-sm-8 col-md-3 col-lg-4 profile-right">
                        <?php echo $data["p2_prefix"]; ?><?php echo $data["u2_name"]; ?>
                        <?php echo $data["u2_lname"]; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="mb-3">
        ข้อมูลสิทธิ์การใช้งาน
    </div>
    <div class="mb-5">
        <?php
            $sql = "
                SELECT 
                    level.*,
                    user_level.user_id
                FROM level
                    LEFT JOIN user_level ON user_level.level_id=level.level_id 
                        AND user_level.user_id='".$user_id."'
                ORDER BY level.level_id
            ";
            $obj = $DATABASE->QueryObj($sql);
            foreach($obj as $key=>$row) {
                $checked = ($row["user_id"]==$user_id) ? "checked" : "";
                echo '
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="level-'.$row["level_id"].'" value="'.$row["level_id"].'" '.$checked.'>
                        <label class="custom-control-label" for="level-'.$row["level_id"].'">'.$row["level_name"].' ['.$row["level_desc"].']</label>
                    </div>
                ';
            }
        ?>
    </div>
    <div class="mb-3">
        ข้อมูลสิทธิ์การเข้าถึงแต่ละพื้นที่
    </div>
    <div class="mb-5">
        <table class="table">
            <?php
                $sql = "
                    SELECT 
                        area.*,
                        province.province_name_thai,
                        user_area.user_id,
                        user_area.is_admin
                    FROM area
                        INNER JOIN province ON province.province_id=area.province_id
                        LEFT JOIN user_area ON user_area.province_id=area.province_id AND user_area.user_id='".$user_id."'
                    ORDER BY province.province_name_thai
                ";
                $obj = $DATABASE->QueryObj($sql);
                if( sizeof($obj)==0 ) {
                    echo '<tr><td>ไม่พบข้อมูลพื้นที่</td></tr>';
                } else {
                    foreach($obj as $key=>$row) {
                        $checked = ($row["user_id"]==$user_id) ? "checked" : "";
                        $checked2 = ($row["is_admin"]=="Y") ? "checked" : "";
                        $disabled2 = ($row["user_id"]==$user_id) ? "" : "disabled";
                        echo '
                            <tr>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="area-'.$row["province_id"].'" value="'.$row["province_id"].'" '.$checked.'>
                                        <label class="custom-control-label" for="area-'.$row["province_id"].'">'.$row["province_name_thai"].'</label>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="area1-'.$row["province_id"].'" '.$checked.' disabled>
                                        <label class="custom-control-label" for="area1-'.$row["province_id"].'">อาสาเก็บข้อมูล</label>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="area2-'.$row["province_id"].'" value="'.$row["province_id"].'" '.$checked2.' '.$disabled2.'>
                                        <label class="custom-control-label" for="area2-'.$row["province_id"].'">แอดมิน</label>
                                    </div>
                                </td>
                            </tr>
                        ';
                    }
                }
            ?>
        </table>
    </div>
    <div class="card text-center">
        <div class="card-header">
            ลบผู้ใช้งาน
        </div>
        <div class="card-body">
            <button id="btn-del" class="btn btn-danger"><i class="fas fa-trash mr-1"></i> ลบผู้ใช้งานรายนี้</button>
            <div class="p-4 text-danger" style="font-size: 16px;">คำเตือน !!! หากคุณลบผู้ใช้งานรายนี้
                ผู้ใช้งานรายนี้จะไม่สามารถใช้งานได้ และไม่สามารถทำการกู้กลับมาใช้งานอีกได้อีกต่อไป</div>
        </div>
    </div>
</div>