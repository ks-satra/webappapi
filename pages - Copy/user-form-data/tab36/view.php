<?php
    
?>
<form id="formdata" class="mb-3" autocomplete="off">
    <input type="hidden" name="home_id" value="<?php echo $home["home_id"]; ?>">
    <div class="row">
        <div class="col-lg-6">
            <?php include_once('pages/'.$PAGE.'/tab-menu.php');?>
        </div>
        <div class="col-lg-6">
            <div class="informant" id="first-scroll">
                <i class="fas fa-folder mr-2"></i> สำหรับเจ้าหน้าที่
            </div>
            <div class="mb-3">
                <?php
                    if( $form["staff_image"]=="" ) $staff_image = "images/camera.jpg";
                    else $staff_image = "files/form/".$form["staff_image"];
                ?>
                <img src="<?php echo $staff_image; ?>" alt="staff_image" id="staff_image_show" class="w-100 border">
            </div>
            <div class="form-group row">
                <label for="staff_image" class="col-md-3 col-form-label">อัพโหลดภาพ</label>
                <div class="col-md-9">
                    <input type="file" class="w-100 border p-1" id="staff_image" name="staff_image"
                        accept="<?php echo AcceptImplode($GLOBAL["ALLOW_IMAGE"]); ?>">
                </div>
            </div>
            <div class="mt-5 form-group row">
                <label for="staff_date" class="col-md-3 col-form-label">วันที่สำรวจข้อมูล <span
                        class="text-danger">*</span></label>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="staff_date" name="staff_date"
                        value="<?php echo DateTh($form["staff_date"]); ?>" data-datepicker required>
                </div>
            </div>
            <div class="mt-5 informant">
                <i class="fas fa-hand-point-right mr-2"></i> ผู้สำรวจข้อมูล คนที่ 1
            </div>
            <div class="form-group row">
                <label for="staff1_prefix_id" class="col-md-3 col-form-label">คำนำหน้า <span
                        class="text-danger">*</span></label>
                <div class="col-md-9">
                    <select id="staff1_prefix_id" name="staff1_prefix_id" class="form-control" required>
                        <option value="">-- กรุณาระบุคำนำหน้าชื่อ --</option>
                        <?php
                            $sql = "SELECT * FROM item_prefix ORDER BY item_prefix_id";
                            $obj = $DATABASE->QueryObj($sql);
                            foreach($obj as $row) {
                                $selected = ($form["staff1_prefix_id"]==$row["item_prefix_id"]) ? "selected" : "";
                                echo '<option value="'.$row["item_prefix_id"].'" '.$selected.'>'.$row["item_prefix_id"].'. '.$row["item_prefix_name"].'</option>';
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="staff1_name" class="col-md-3 col-form-label">ชื่อ <span class="text-danger">*</span></label>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="staff1_name" name="staff1_name"
                        value="<?php echo $form["staff1_name"]; ?>" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="staff1_lname" class="col-md-3 col-form-label">นามสกุล <span
                        class="text-danger">*</span></label>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="staff1_lname" name="staff1_lname"
                        value="<?php echo $form["staff1_lname"]; ?>" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="staff1_phone" class="col-md-3 col-form-label">โทรศัพท์ <span
                        class="text-danger">*</span></label>
                <div class="col-md-9">
                    <input type="tel" class="form-control" id="staff1_phone" name="staff1_phone"
                        value="<?php echo $form["staff1_phone"]; ?>" required>
                </div>
            </div>

            <div class="mt-5 informant">
                <i class="fas fa-hand-point-right mr-2"></i> ผู้สำรวจข้อมูล คนที่ 2
            </div>
            <div class="form-group row">
                <label for="staff2_prefix_id" class="col-md-3 col-form-label">คำนำหน้า</label>
                <div class="col-md-9">
                    <select id="staff2_prefix_id" name="staff2_prefix_id" class="form-control">
                        <option value="">-- กรุณาระบุคำนำหน้าชื่อ --</option>
                        <?php
                            $sql = "SELECT * FROM item_prefix ORDER BY item_prefix_id";
                            $obj = $DATABASE->QueryObj($sql);
                            foreach($obj as $row) {
                                $selected = ($form["staff2_prefix_id"]==$row["item_prefix_id"]) ? "selected" : "";
                                echo '<option value="'.$row["item_prefix_id"].'" '.$selected.'>'.$row["item_prefix_id"].'. '.$row["item_prefix_name"].'</option>';
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="staff2_name" class="col-md-3 col-form-label">ชื่อ</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="staff2_name" name="staff2_name"
                        value="<?php echo $form["staff2_name"]; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="staff2_lname" class="col-md-3 col-form-label">นามสกุล</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="staff2_lname" name="staff2_lname"
                        value="<?php echo $form["staff2_lname"]; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="staff2_phone" class="col-md-3 col-form-label">โทรศัพท์</label>
                <div class="col-md-9">
                    <input type="tel" class="form-control" id="staff2_phone" name="staff2_phone"
                        value="<?php echo $form["staff2_phone"]; ?>">
                </div>
            </div>

            <div class="mt-5 informant">
                <i class="fas fa-hand-point-right mr-2"></i> ผู้บันทึกข้อมูล
            </div>
            <div class="form-group row">
                <label for="staff3_prefix_id" class="col-md-3 col-form-label">คำนำหน้า <span
                        class="text-danger">*</span></label>
                <div class="col-md-9">
                    <select id="staff3_prefix_id" name="staff3_prefix_id" class="form-control" required>
                        <option value="">-- กรุณาระบุคำนำหน้าชื่อ --</option>
                        <?php
                            $sql = "SELECT * FROM item_prefix ORDER BY item_prefix_id";
                            $obj = $DATABASE->QueryObj($sql);
                            foreach($obj as $row) {
                                $selected = ($form["staff3_prefix_id"]==$row["item_prefix_id"]) ? "selected" : "";
                                echo '<option value="'.$row["item_prefix_id"].'" '.$selected.'>'.$row["item_prefix_id"].'. '.$row["item_prefix_name"].'</option>';
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="staff3_name" class="col-md-3 col-form-label">ชื่อ <span class="text-danger">*</span></label>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="staff3_name" name="staff3_name"
                        value="<?php echo $form["staff3_name"]; ?>" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="staff3_lname" class="col-md-3 col-form-label">นามสกุล <span
                        class="text-danger">*</span></label>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="staff3_lname" name="staff3_lname"
                        value="<?php echo $form["staff3_lname"]; ?>" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="staff3_phone" class="col-md-3 col-form-label">โทรศัพท์ <span
                        class="text-danger">*</span></label>
                <div class="col-md-9">
                    <input type="tel" class="form-control" id="staff3_phone" name="staff3_phone"
                        value="<?php echo $form["staff3_phone"]; ?>" required>
                </div>
            </div>

            <div class="mt-5 informant">
                <i class="fas fa-hand-point-right mr-2"></i> สรุปผลการสัมภาษณ์
            </div>
            <?php
                $staff_ch = array(
                    "1"=>"1. ผู้ตอบให้ข้อมูลครบถ้วน",
                    "2"=>"2. ผู้ตอบให้ข้อมูลไม่ครบถ้วน",
                    "3"=>"3. เก็บข้อมูลไม่ได้ เพราะผู้ตอบไม่ให้ความร่วมมือ",
                    "4"=>"4. เก็บข้อมูลไม่ได้ เพราะไม่พบผู้ตอบสัมภาษณ์",
                    "5"=>"5. อื่นๆ นอกเหนือจากที่กำหนด",
                );
                foreach($staff_ch as $k=>$v) {
                    $checked = ($k==$form["staff_ch"]) ? "checked" :"";
                    echo '
                        <div class="form-inline form-choose">
                            <div class="form-check mb-2 mr-sm-2">
                                <input class="form-check-input" type="radio" id="staff_ch_'.$k.'" name="staff_ch" value="'.$k.'" '.$checked.' required>
                                <label class="form-check-label" for="staff_ch_'.$k.'">
                                    '.$v.'
                                </label>
                            </div>
                        </div>
                    ';
                }
            ?>
            <div class="mt-5 informant">
                <i class="fas fa-hand-point-right mr-2"></i> บันทึกข้อมูลเพิ่มเติม
            </div>
            <textarea class="form-control" name="staff_desc" id="staff_desc"
                rows="3"><?php echo $form["staff_desc"]; ?></textarea>

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