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
                <i class="fas fa-folder mr-2"></i> ที่อยู่อาศัย
            </div>
            <div class="mb-3">ครัวเรือนมีบ้านเป็นของตนเอง</div>

            <div class="form-inline form-choose">
                <div class="form-check mb-2 mr-sm-2">
                    <input class="form-check-input" type="checkbox" id="ch2_1" name="ch2_1" value="Y"
                        <?php if($form["ch2_1"]=="Y") echo "checked"; ?> required>
                    <label class="form-check-label" for="ch2_1">
                        1. ไม่มี เช่าบ้านอยู่
                    </label>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-3 mb-3">
                    <label for="ch2_1_num">จำนวนบ้าน (หลัง)</label>
                    <input type="tel" class="form-control" id="ch2_1_num" name="ch2_1_num" placeholder="จำนวนบ้าน"
                        data-input-number="0" value="<?php echo $form["ch2_1_num"]; ?>" required>
                </div>
                <div class="col-md-9 mb-3">
                    <label>จำนวนพื้นที่ (ไร่/งาน/ตารางวา)</label>
                    <div class="input-group">
                        <input type="tel" class="form-control" id="ch2_1_rai" name="ch2_1_rai" placeholder="ไร่"
                            data-input-number="0" value="<?php echo $form["ch2_1_rai"]; ?>" required>
                        <input type="tel" class="form-control" id="ch2_1_ngan" name="ch2_1_ngan" placeholder="งาน"
                            data-input-number="0" value="<?php echo $form["ch2_1_ngan"]; ?>" required>
                        <input type="tel" class="form-control" id="ch2_1_wa" name="ch2_1_wa" placeholder="ตารางวา"
                            data-input-number="0" value="<?php echo $form["ch2_1_wa"]; ?>" required>
                    </div>
                </div>
            </div>

            <div class="form-inline form-choose">
                <div class="form-check mb-2 mr-sm-2">
                    <input class="form-check-input" type="checkbox" id="ch2_2" name="ch2_2" value="Y"
                        <?php if($form["ch2_2"]=="Y") echo "checked"; ?> required>
                    <label class="form-check-label" for="ch2_2">
                        2. มีและอาศัยอยู่
                    </label>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-3 mb-3">
                    <label for="ch2_2_num">จำนวนบ้าน (หลัง)</label>
                    <input type="tel" class="form-control" id="ch2_2_num" name="ch2_2_num" placeholder="จำนวนบ้าน"
                        data-input-number="0" value="<?php echo $form["ch2_2_num"]; ?>" required>
                </div>
                <div class="col-md-9 mb-3">
                    <label>จำนวนพื้นที่ (ไร่/งาน/ตารางวา)</label>
                    <div class="input-group">
                        <input type="tel" class="form-control" id="ch2_2_rai" name="ch2_2_rai" placeholder="ไร่"
                            data-input-number="0" value="<?php echo $form["ch2_2_rai"]; ?>" required>
                        <input type="tel" class="form-control" id="ch2_2_ngan" name="ch2_2_ngan" placeholder="งาน"
                            data-input-number="0" value="<?php echo $form["ch2_2_ngan"]; ?>" required>
                        <input type="tel" class="form-control" id="ch2_2_wa" name="ch2_2_wa" placeholder="ตารางวา"
                            data-input-number="0" value="<?php echo $form["ch2_2_wa"]; ?>" required>
                    </div>
                </div>
            </div>

            <div class="form-inline form-choose">
                <div class="form-check mb-2 mr-sm-2">
                    <input class="form-check-input" type="checkbox" id="ch2_3" name="ch2_3" value="Y"
                        <?php if($form["ch2_3"]=="Y") echo "checked"; ?> required>
                    <label class="form-check-label" for="ch2_3">
                        3. มีบ้านให้คนอื่นเช่า
                    </label>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-3 mb-3">
                    <label for="ch2_3_num">จำนวนบ้าน (หลัง)</label>
                    <input type="tel" class="form-control" id="ch2_3_num" name="ch2_3_num" placeholder="จำนวนบ้าน"
                        data-input-number="0" value="<?php echo $form["ch2_3_num"]; ?>" required>
                </div>
                <div class="col-md-9 mb-3">
                    <label>จำนวนพื้นที่ (ไร่/งาน/ตารางวา)</label>
                    <div class="input-group">
                        <input type="tel" class="form-control" id="ch2_3_rai" name="ch2_3_rai" placeholder="ไร่"
                            data-input-number="0" value="<?php echo $form["ch2_3_rai"]; ?>" required>
                        <input type="tel" class="form-control" id="ch2_3_ngan" name="ch2_3_ngan" placeholder="งาน"
                            data-input-number="0" value="<?php echo $form["ch2_3_ngan"]; ?>" required>
                        <input type="tel" class="form-control" id="ch2_3_wa" name="ch2_3_wa" placeholder="ตารางวา"
                            data-input-number="0" value="<?php echo $form["ch2_3_wa"]; ?>" required>
                    </div>
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