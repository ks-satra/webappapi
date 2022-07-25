<?php
    function edit() {
        global $DATABASE, $GLOBAL, $USER;
        $dir = "./files/user/";
        if( isset($_FILES["image"]["name"]) ) {
            RemoveFile($dir, $USER["image"]);
        }
        $upload = UploadFile("image", $dir, time(), $GLOBAL["ALLOW_IMAGE"]);
        if( $upload["status"]==false ) {
            ShowAlert('', $upload["message"], 'error');
            return;
        }
        $field['image'] = $upload["fileName"];
        if( $DATABASE->QueryUpdate("user", $field, "user_id='".$USER['user_id']."'") ) {
            $USER = GetUser();
            ShowAlert('', 'แก้ไขรูปโปรไฟล์สำเร็จ', 'success', './?page=all-profile');
        } else {
            ShowAlert('', 'ไม่สามารถติดต่อฐานข้อมูลได้ !!!', 'error');
        }
    }
    if( isset($_POST['btn-edit-profile']) && $_POST['btn-edit-profile'] == "submit") {
        edit();
    }
?>
<div id="content-title">
    โปรไฟล์ของฉัน
</div>
<div id="content-body">
    <div id="profile" class="row">
        <div class="col-md-auto">
            <div class="profile-image">
                <a href="Javascript:">
                    <img id="profile-image" class="img-thumbnail mb-4" src="./files/user/<?php echo $USER["image"]; ?>"
                        onerror="ImageError(this, './files/user/default.png')" alt="Profile Image">
                </a>
                <div id="edit" class="mb-2">
                    <button type="button" id="btn-edit" class="btn btn-success btn-sm btn-block"><i
                            class="fas fa-pencil-alt mr-2"></i> เปลี่ยนรูปโปรไฟล์</button>
                </div>
                <div id="confirm" class="row mb-2" style="display: none;">
                    <div class="col pr-1">
                        <button type="button" id="btn-confirm" class="btn btn-success btn-sm btn-block"><i
                                class="fas fa-check mr-2"></i> ยืนยัน</button>
                    </div>
                    <div class="col pl-1">
                        <button type="button" id="btn-cancel" class="btn btn-danger btn-sm btn-block"><i
                                class="fas fa-times mr-2"></i> ยกเลิก</button>
                    </div>
                </div>
                <a href="./?page=all-changepass" class="btn btn-light btn-sm border btn-block"><i
                        class="fas fa-key mr-2"></i> เปลี่ยนรหัสผ่าน</a>
                <a href="./?page=all-login" class="btn btn-light btn-sm border btn-block"><i
                        class="fas fa-history mr-2"></i> ประวัติการล็อกอิน</a>
            </div>
        </div>
        <div class="col">
            <div class="mb-4">
                <label>ชื่อ-นามสกุล</label>
                <div class="detail"><?php echo $USER["item_prefix_name"]; ?><?php echo $USER["user_name"]; ?>
                    <?php echo $USER["user_lname"]; ?></div>
            </div>
            <div class="mb-4">
                <label>โทรศัพท์</label>
                <div class="detail"><?php echo $USER["phone"]; ?></div>
            </div>
            <div class="mb-4">
                <label>อีเมล</label>
                <div class="detail"><?php echo $USER["email"]; ?></div>
            </div>
            <div class="mb-4">
                <label>รหัสผ่าน</label>
                <div class="detail">
                    <?php 
                        for ($i=0; $i < strlen($USER["email"]); $i++) { 
                            echo "*";
                        }
                    ?>
                </div>
            </div>
            <div class="mb-4">
                <label>สิทธิ์การใช้งาน</label>
                <div class="detail">
                    <?php
                        $txt = "";
                        $count = 1;
                        $sql = "
                            SELECT
                                `level`.*,
                                user_level.user_id
                            FROM `level`
                                LEFT JOIN user_level ON user_level.level_id=`level`.level_id AND user_level.user_id='".$USER["user_id"]."'
                            ORDER BY `level`.level_id
                        ";
                        $obj = $DATABASE->QueryObj($sql);
                        foreach($obj as $key=>$row) {
                            if( $row["user_id"]!="" ) {
                                $txt .= "<div>".$count.". [".$row["program_code"]."] ".$row["level_name"]."</div>";
                                $count++;
                            }
                        }
                        $sql = "
                            SELECT
                                user_area.is_admin,
                                province.province_name_thai
                            FROM user_area
                                INNER JOIN province ON province.province_id=user_area.province_id
                            WHERE user_area.user_id='".$USER["user_id"]."'
                        ";
                        $obj = $DATABASE->QueryObj($sql);
                        foreach($obj as $key=>$row) {
                            if( $row["is_admin"]=="Y" ) {
                                $txt .= "<div>".$count.". แอดมินพื้นที่จังหวัด".$row["province_name_thai"]."</div>";
                                $count++;
                            } else {
                                $txt .= "<div>".$count.". อาสาบันทึกแบบสอบถามพื้นที่จังหวัด".$row["province_name_thai"]."</div>";
                                $count++;
                            }
                        }

                        if( $count==1 ) {
                            $txt .= "<div>".$count.". [general] ผู้ใช้งานระบบทั่วไป</div>";
                            $count++;
                        }
                        echo $txt;
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>