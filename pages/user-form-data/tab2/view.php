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
                <i class="fas fa-folder mr-2"></i> ผู้ให้ข้อมูล
            </div>
            <div class="form-group row">
                <label for="informant_prefix_id" class="col-md-5 col-form-label">คำนำหน้า <span
                        class="text-danger">*</span></label>
                <div class="col-md-7">
                    <select id="informant_prefix_id" name="informant_prefix_id" class="form-control" required>
                        <option value="">-- กรุณาระบุคำนำหน้าชื่อ --</option>
                        <?php
                            $sql = "SELECT * FROM item_prefix ORDER BY item_prefix_id";
                            $obj = $DATABASE->QueryObj($sql);
                            foreach($obj as $row) {
                                $selected = ($home["informant_prefix_id"]==$row["item_prefix_id"]) ? "selected" : "";
                                echo '<option value="'.$row["item_prefix_id"].'" '.$selected.'>'.$row["item_prefix_id"].'. '.$row["item_prefix_name"].'</option>';
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="informant_name" class="col-md-5 col-form-label">ชื่อ <span
                        class="text-danger">*</span></label>
                <div class="col-md-7">
                    <input type="text" class="form-control" id="informant_name" name="informant_name"
                        value="<?php echo $home["informant_name"]; ?>" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="informant_lname" class="col-md-5 col-form-label">นามสกุล <span
                        class="text-danger">*</span></label>
                <div class="col-md-7">
                    <input type="text" class="form-control" id="informant_lname" name="informant_lname"
                        value="<?php echo $home["informant_lname"]; ?>" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="informant_phone" class="col-md-5 col-form-label">โทรศัพท์ (บ้าน/มือถือ)</label>
                <div class="col-md-7">
                    <input type="tel" class="form-control" id="informant_phone" name="informant_phone"
                        value="<?php echo $home["informant_phone"]; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="informant_line" class="col-md-5 col-form-label">ไลน์/ไอดี</label>
                <div class="col-md-7">
                    <input type="text" class="form-control" id="informant_line" name="informant_line"
                        value="<?php echo $home["informant_line"]; ?>">
                </div>
            </div>
            <div class="form-group row">
                <label for="informant_email" class="col-md-5 col-form-label">อีเมล </label>
                <div class="col-md-7">
                    <input type="email" class="form-control" id="informant_email" name="informant_email"
                        value="<?php echo $home["informant_email"]; ?>">
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