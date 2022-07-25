<?php
    $sql = "
        SELECT
            province.province_id, 
            province.province_name_thai,
            area.province_code
        FROM area
            INNER JOIN user_area ON area.province_id = user_area.province_id
            INNER JOIN province ON user_area.province_id = province.province_id
        WHERE user_area.user_id='".$USER["user_id"]."'
    ";
    $UserArea = $DATABASE->QueryObj($sql);
?>
<form id="formdata" class="mb-3" autocomplete="off">
    <input type="hidden" name="home_id" value="<?php echo $home["home_id"]; ?>">
    <div class="row">
        <div class="col-lg-6">
            <?php include_once('pages/'.$PAGE.'/tab-menu.php');?>
        </div>
        <div class="col-lg-6">
            <div class="informant" id="first-scroll">
                <i class="fas fa-folder mr-2"></i> ข้อมูลแบบสำรวจ
            </div>
            <div class="form-group row">
                <label for="area_province_id" class="col-md-5 col-form-label">พื้นที่ดูแล</label>
                <div class="col-md-7">
                    <select class="form-control" id="area_province_id" id="area_province_id" disabled>
                        <?php
                            foreach($UserArea as $row) {
                                $selected = ($home["area_province_id"]==$row["province_id"]) ? "selected" : "";
                                echo '<option value="'.$row["province_id"].'" '.$selected.'>['.$row["province_code"].'] จังหวัด'.$row["province_name_thai"].'</option>';
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="area_province_id" class="col-md-5 col-form-label">หมายเลขแบบสำรวจ</label>
                <div class="col-md-7">
                    <input type="text" class="form-control" id="form_code" name="form_code"
                        value="<?php echo $home["form_code"]; ?>" disabled>
                </div>
            </div>
            <div class="informant">
                <i class="fas fa-folder mr-2"></i> ข้อมูลพื้นฐานครัวเรือน
            </div>
            <div class="form-group row">
                <label for="home_code" class="col-md-5 col-form-label">รหัสประจำบ้าน <span
                        class="text-danger">*</span></label>
                <div class="col-md-7">
                    <input type="tel" class="form-control" id="home_code" name="home_code"
                        value="<?php echo $home["home_code"]; ?>" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="item_domination_id" class="col-md-5 col-form-label">เขตการปกครอง <span
                        class="text-danger">*</span></label>
                <div class="col-md-7">
                    <select class="form-control" id="item_domination_id" name="item_domination_id">
                        <?php
                            $sql = "SELECT * FROM item_domination ORDER BY item_domination_id";
                            $obj = $DATABASE->QueryObj($sql);
                            foreach($obj as $row) {
                                $selected = ($home["item_domination_id"]==$row["item_domination_id"]) ? "selected" : "";
                                echo '<option value="'.$row["item_domination_id"].'" '.$selected.'>'.$row["item_domination_id"].'. '.$row["item_domination_name"].'</option>';
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="home_no" class="col-md-5 col-form-label">บ้านเลขที่ <span
                        class="text-danger">*</span></label>
                <div class="col-md-7">
                    <input type="text" class="form-control" id="home_no" name="home_no"
                        value="<?php echo $home["home_no"]; ?>" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="moo" class="col-md-5 col-form-label">หมู่ที่</label>
                <div class="col-md-7">
                    <select class="form-control" id="moo" name="moo">
                        <option value="">ไม่มี</option>
                        <?php
                            for($i=1; $i<=15; $i++) {
                                $selected = ($home["moo"]==$i) ? "selected" : "";
                                echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="village_name" class="col-md-5 col-form-label">ชื่อหมู่บ้าน <span
                        class="text-danger">*</span></label>
                <div class="col-md-7">
                    <input type="text" class="form-control" id="village_name" name="village_name"
                        value="<?php echo $home["village_name"]; ?>" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="tambol_id" class="col-md-5 col-form-label">
                    ค้นหาตำบล <span class="text-danger">*</span></label>
                <div class="col-md-7">
                    <input type="text" class="form-control" id="tambol_id" data-toggle="tooltip"
                        title="โปรดพิมพ์ชื่อตำบล และเลือกจากรายการที่แสดงขึ้นมาเท่านั้น"
                        value="<?php echo $home["tambol_name_thai"]; ?>" required>
                    <small class="form-text text-muted">
                        <span class="fa fa-search form-control-feedback"></span> โปรดพิมพ์ชื่อตำบล
                        และเลือกจากรายการที่แสดงขึ้นมาเท่านั้น</small>
                    <input type="hidden" name="tambol_id" value="<?php echo $home["tambol_id"]; ?>">
                    <input type="hidden" name="amphur_id" value="<?php echo $home["amphur_id"]; ?>">
                    <input type="hidden" name="province_id" value="<?php echo $home["province_id"]; ?>">
                    <input type="hidden" name="zipcode" value="<?php echo $home["zipcode"]; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="amphur_id" class="col-md-5 col-form-label">อำเภอ <span class="text-danger">*</span></label>
                <div class="col-md-7">
                    <input type="text" class="form-control" id="amphur_id"
                        value="<?php echo $home["amphur_name_thai"]; ?>" disabled>
                </div>
            </div>
            <div class="form-group row">
                <label for="amphur_id" class="col-md-5 col-form-label">จังหวัด <span
                        class="text-danger">*</span></label>
                <div class="col-md-7">
                    <input type="text" class="form-control" id="province_id"
                        value="<?php echo $home["province_name_thai"]; ?>" disabled>
                </div>
            </div>
            <div class="form-group row">
                <label for="zipcode" class="col-md-5 col-form-label">รหัสไปรษณีย์ <span
                        class="text-danger">*</span></label>
                <div class="col-md-7">
                    <input type="text" class="form-control" id="zipcode" value="<?php echo $home["zipcode"]; ?>"
                        disabled>
                </div>
            </div>
            <div class="informant">
                <i class="fas fa-folder mr-2"></i> เจ้าของบ้านตามทะเบียนบ้าน
            </div>
            <div class="form-group row">
                <label for="owner_prefix_id" class="col-md-5 col-form-label">คำนำหน้า <span
                        class="text-danger">*</span></label>
                <div class="col-md-7">
                    <select id="owner_prefix_id" name="owner_prefix_id" class="form-control" required>
                        <option value="">-- กรุณาระบุคำนำหน้าชื่อ --</option>
                        <?php
                            $sql = "SELECT * FROM item_prefix ORDER BY item_prefix_id";
                            $obj = $DATABASE->QueryObj($sql);
                            foreach($obj as $row) {
                                $selected = ($home["owner_prefix_id"]==$row["item_prefix_id"]) ? "selected" : "";
                                echo '<option value="'.$row["item_prefix_id"].'" '.$selected.'>'.$row["item_prefix_id"].'. '.$row["item_prefix_name"].'</option>';
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="owner_name" class="col-md-5 col-form-label">ชื่อ <span class="text-danger">*</span></label>
                <div class="col-md-7">
                    <input type="text" class="form-control" id="owner_name" name="owner_name"
                        value="<?php echo $home["owner_name"]; ?>" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="owner_lname" class="col-md-5 col-form-label">นามสกุล <span
                        class="text-danger">*</span></label>
                <div class="col-md-7">
                    <input type="text" class="form-control" id="owner_lname" name="owner_lname"
                        value="<?php echo $home["owner_lname"]; ?>" required>
                </div>
            </div>
            <div class="informant">
                <i class="fas fa-folder mr-2"></i> จำนวนสมาชิกทั้งหมดในครัวเรือน
            </div>
            <div class="form-group row">
                <label class="col-md-5 col-form-label">จำนวนสมาชิก (คน) <span class="text-danger">*</span></label>
                <div class="col-md-7">
                    <input type="text" class="form-control" value="<?php echo $home["home_member_count"]; ?>" disabled>
                    <small class="form-text text-muted">
                        ข้อมูลนี้ดึงมาจากตอนที่ 12
                        ข้อมูลสมาชิกที่อาศัยในปัจจุบัน</small>
                </div>
            </div>
            <div class="form-group row">
                <label for="home_family_count" class="col-md-5 col-form-label">จำนวนครอบครัว (ครอบครัว) <span
                        class="text-danger">*</span></label>
                <div class="col-md-7">
                    <select class="form-control" id="home_family_count" name="home_family_count" required>
                        <?php
                            for($i=1; $i<=10; $i++) {
                                $selected = ($home["home_family_count"]==$i) ? "selected" : "";
                                echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="mt-5">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save mr-2"></i>
                    บันทึกและถัดไป
                    <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </div>
        </div>
    </div>
</form>