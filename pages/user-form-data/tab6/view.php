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
                <i class="fas fa-folder mr-2"></i> น้ำกิน
            </div>
            <div class="mb-3">
                น้ำกิน (ดื่ม/ประกอบอาหาร) เพียงพอสำหรับกินตลอดปี
            </div>
            <?php
                $ch5 = array(
                    "1"=>"1. เพียงพอ",
                    "2"=>"2. ไม่เพียงพอ"
                );
                foreach($ch5 as $k=>$v) {
                    $checked = ($k==$form["ch5"]) ? "checked" :"";
                    echo '
                        <div class="form-inline form-choose">
                            <div class="form-check mb-2 mr-sm-2">
                                <input class="form-check-input" type="radio" id="ch5'.$k.'" name="ch5" value="'.$k.'" '.$checked.' required>
                                <label class="form-check-label" for="ch5'.$k.'">
                                    '.$v.'
                                </label>
                            </div>
                        </div>
                    ';
                }
            ?>
            <div class="mt-3 form-inline">
                <label class="my-1 mr-2" for="ch5_num">
                    น้ำกิน (ดื่ม/ประกอบอาหาร) ไม่เพียงพอ จำนวน
                </label>
                <select class="custom-select my-1 mr-sm-2" id="ch5_num" name="ch5_num" disabled required>
                    <option value="">เลือกจำนวน</option>
                    <?php
                        for($i=1; $i<=12; $i++) {
                            $selected = ($form["ch5_num"]*1==$i) ? "selected" : "";
                            echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
                        }
                    ?>
                </select>
                <label class="my-1 mr-2">
                    เดือน
                </label>
            </div>
            <div class="mt-4 mb-3">
                แหล่งน้ำกิน (ดื่ม/ประกอบอาหาร) ของครัวเรือน (ตอบได้หลายตัวเลือก)
            </div>
            <?php
                $ch6 = array(
                    "1"=>"1. แหล่งกักเก็บน้ำต่างๆ (น้ำบ่อ น้ำห้วย บาดาล อ่างเก็บน้ำ)",
                    "2"=>"2. น้ำฝน กักเก็บไว้ใช้เอง",
                    "3"=>"3. ระบบประปาหมู่บ้าน",
                    "4"=>"4. ซื้อ (น้ำถัง น้ำขวด ตู้กดน้ำ)",
                );
                foreach($ch6 as $k=>$v) {
                    $checked = ($form["ch6_".$k]=="Y") ? "checked" :"";
                    echo '
                        <div class="form-inline form-choose">
                            <div class="form-check mb-2 mr-sm-2">
                                <input class="form-check-input" type="checkbox" id="ch6_'.$k.'" name="ch6[]" value="'.$k.'" '.$checked.' required>
                                <label class="form-check-label" for="ch6_'.$k.'">
                                    '.$v.'
                                </label>
                            </div>
                        </div>
                    ';
                }
            ?>
            <div class="mt-4 mb-3">
                ความสะอาดของน้ำจากแหล่งน้ำกิน
            </div>
            <?php
                $ch7 = array(
                    "1"=>"1. ไม่สะอาด",
                    "2"=>"2. น้อย",
                    "3"=>"3. ปานกลาง",
                    "4"=>"4. มาก"
                );
                foreach($ch7 as $k=>$v) {
                    $checked = ($k==$form["ch7"]) ? "checked" :"";
                    echo '
                        <div class="form-inline form-choose">
                            <div class="form-check mb-2 mr-sm-2">
                                <input class="form-check-input" type="radio" id="ch7'.$k.'" name="ch7" value="'.$k.'" '.$checked.' required>
                                <label class="form-check-label" for="ch7'.$k.'">
                                    '.$v.'
                                </label>
                            </div>
                        </div>
                    ';
                }
            ?>

            <hr>
            <div class="informant">
                <i class="fas fa-folder mr-2"></i> น้ำใช้
            </div>
            <div class="mb-3">
                น้ำใช้ในครัวเรือน เพียงพอสำหรับใช้ตลอดปี
            </div>
            <?php
                $ch8 = array(
                    "1"=>"1. เพียงพอ",
                    "2"=>"2. ไม่เพียงพอ"
                );
                foreach($ch8 as $k=>$v) {
                    $checked = ($k==$form["ch8"]) ? "checked" :"";
                    echo '
                        <div class="form-inline form-choose">
                            <div class="form-check mb-2 mr-sm-2">
                                <input class="form-check-input" type="radio" id="ch8'.$k.'" name="ch8" value="'.$k.'" '.$checked.' required>
                                <label class="form-check-label" for="ch8'.$k.'">
                                    '.$v.'
                                </label>
                            </div>
                        </div>
                    ';
                }
            ?>
            <div class="mt-3 form-inline">
                <label class="my-1 mr-2" for="ch8_num">
                    น้ำใช้ในครัวเรือนไม่เพียงพอ จำนวน
                </label>
                <select class="custom-select my-1 mr-sm-2" id="ch8_num" name="ch8_num" disabled required>
                    <option value="">เลือกจำนวน</option>
                    <?php
                        for($i=1; $i<=12; $i++) {
                            $selected = ($form["ch8_num"]*1==$i) ? "selected" : "";
                            echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
                        }
                    ?>
                </select>
                <label class="my-1 mr-2">
                    เดือน
                </label>
            </div>
            <div class="mt-4 mb-3">
                แหล่งน้ำใช้ในครัวเรือน (ตอบได้หลายตัวเลือก)
            </div>
            <?php
                $ch9 = array(
                    "1"=>"1. แหล่งกักเก็บน้ำต่างๆ (น้ำบ่อ น้ำห้วย บาดาล อ่างเก็บน้ำ)",
                    "2"=>"2. น้ำฝน กักเก็บไว้ใช้เอง",
                    "3"=>"3. ระบบประปาหมู่บ้าน",
                    "4"=>"4. ซื้อ (น้ำถัง น้ำขวด ตู้กดน้ำ)",
                );
                foreach($ch9 as $k=>$v) {
                    $checked = ($form["ch9_".$k]=="Y") ? "checked" :"";
                    echo '
                        <div class="form-inline form-choose">
                            <div class="form-check mb-2 mr-sm-2">
                                <input class="form-check-input" type="checkbox" id="ch9_'.$k.'" name="ch9[]" value="'.$k.'" '.$checked.' required>
                                <label class="form-check-label" for="ch9_'.$k.'">
                                    '.$v.'
                                </label>
                            </div>
                        </div>
                    ';
                }
            ?>
            <div class="mt-4 mb-3">
                ความสะอาดของน้ำใช้ในครัวเรือน
            </div>
            <?php
                $ch10 = array(
                    "1"=>"1. ไม่สะอาด",
                    "2"=>"2. น้อย",
                    "3"=>"3. ปานกลาง",
                    "4"=>"4. มาก"
                );
                foreach($ch10 as $k=>$v) {
                    $checked = ($k==$form["ch10"]) ? "checked" :"";
                    echo '
                        <div class="form-inline form-choose">
                            <div class="form-check mb-2 mr-sm-2">
                                <input class="form-check-input" type="radio" id="ch10'.$k.'" name="ch10" value="'.$k.'" '.$checked.' required>
                                <label class="form-check-label" for="ch10'.$k.'">
                                    '.$v.'
                                </label>
                            </div>
                        </div>
                    ';
                }
            ?>

            <hr>
            <div class="informant">
                <i class="fas fa-folder mr-2"></i> น้ำเพื่อการประกอบอาชีพ
            </div>
            <div class="mt-4 mb-3">
                แหล่งน้ำเพื่อการประกอบอาชีพ เช่น น้ำการเกษตร ปศุสัตว์ ประมง (ตอบได้หลายตัวเลือก)
            </div>
            <?php
                $ch11 = array(
                    "1"=>"1. ลำห้วย ลำเหมือง",
                    "2"=>"2. อ่างเก็บน้ำ สระน้ำหมู่บ้าน",
                    "3"=>"3. บ่อน้ำผิวดิน น้ำบาดาล น้ำใต้ดิน",
                    "4"=>"4. ระบบท่อ",
                    "5"=>"5. ใช้แต่น้ำฝนตามฤดูกาลเท่านั้น",
                    "6"=>"6. คลองชลประทาน",
                    "7"=>"7. ฝาย",
                );
                foreach($ch11 as $k=>$v) {
                    $checked = ($form["ch11_".$k]=="Y") ? "checked" :"";
                    echo '
                        <div class="form-inline form-choose">
                            <div class="form-check mb-2 mr-sm-2">
                                <input class="form-check-input" type="checkbox" id="ch11_'.$k.'" name="ch11[]" value="'.$k.'" '.$checked.' required>
                                <label class="form-check-label" for="ch11_'.$k.'">
                                    '.$v.'
                                </label>
                            </div>
                        </div>
                    ';
                }
            ?>

            <hr>
            <div class="informant">
                <i class="fas fa-folder mr-2"></i> ในฤดูฝน ครัวเรือนมีพื้นที่สำหรับการประกอบอาชีพ จำนวน
                (ไร่/งาน/ตารางวา)
            </div>
            <!-- <div class="mt-4 mb-3">
                ในฤดูฝน ครัวเรือนมีพื้นที่สำหรับการประกอบอาชีพ จำนวน (ไร่/งาน/ตารางวา)
            </div> -->
            <div class="input-group">
                <input type="tel" class="form-control" id="ch12_rai" name="ch12_rai" placeholder="ไร่"
                    data-input-number="0" value="<?php echo $form["ch12_rai"]; ?>" required>
                <input type="tel" class="form-control" id="ch12_ngan" name="ch12_ngan" placeholder="งาน"
                    data-input-number="0" value="<?php echo $form["ch12_ngan"]; ?>" required>
                <input type="tel" class="form-control" id="ch12_wa" name="ch12_wa" placeholder="ตารางวา"
                    data-input-number="0" value="<?php echo $form["ch12_wa"]; ?>" required>
            </div>

            <div class="mt-4 mb-3">
                พื้นที่สำหรับการประกอบอาชีพในฤดูฝน มีน้ำเพียงพอต่อการประกอบอาชีพตลอดปี
            </div>
            <?php
                $ch13 = array(
                    "1"=>"1. เพียงพอตลอดปี",
                    "2"=>"2. เพียงพอในฤดูฝน",
                    "3"=>"3. ไม่เพียงพอตลอดฤดู"
                );
                foreach($ch13 as $k=>$v) {
                    $checked = ($k==$form["ch13"]) ? "checked" :"";
                    echo '
                        <div class="form-inline form-choose">
                            <div class="form-check mb-2 mr-sm-2">
                                <input class="form-check-input" type="radio" id="ch13'.$k.'" name="ch13" value="'.$k.'" '.$checked.' required>
                                <label class="form-check-label" for="ch13'.$k.'">
                                    '.$v.'
                                </label>
                            </div>
                        </div>
                    ';
                }
            ?>
            <div class="mt-3 form-inline">
                <label class="my-1 mr-2" for="ch14_desc">
                    สาเหตุที่น้ำไม่เพียงพอในฤดูฝน
                </label>
                <input type="text" class="form-control my-1 mr-sm-2" id="ch14_desc" name="ch14_desc"
                    placeholder="ระบุสาเหตุ..." value="<?php echo $form["ch14_desc"]; ?>" required>
            </div>

            <hr>
            <div class="informant">
                <i class="fas fa-folder mr-2"></i> ในฤดูแล้ง ครัวเรือนมีพื้นที่สำหรับการประกอบอาชีพ จำนวน
                (ไร่/งาน/ตารางวา)
            </div>
            <!-- <div class="mt-4 mb-3">
                ในฤดูแล้ง ครัวเรือนมีพื้นที่สำหรับการประกอบอาชีพ จำนวน (ไร่/งาน/ตารางวา)
            </div> -->
            <div class="input-group">
                <input type="tel" class="form-control" id="ch15_rai" name="ch15_rai" placeholder="ไร่"
                    data-input-number="0" value="<?php echo $form["ch15_rai"]; ?>" required>
                <input type="tel" class="form-control" id="ch15_ngan" name="ch15_ngan" placeholder="งาน"
                    data-input-number="0" value="<?php echo $form["ch15_ngan"]; ?>" required>
                <input type="tel" class="form-control" id="ch15_wa" name="ch15_wa" placeholder="ตารางวา"
                    data-input-number="0" value="<?php echo $form["ch15_wa"]; ?>" required>
            </div>

            <div class="mt-4 mb-3">
                พื้นที่สำหรับการประกอบอาชีพในฤดูแล้ง มีน้ำเพียงพอต่อการประกอบอาชีพตลอดปี
            </div>
            <?php
                $ch16 = array(
                    "1"=>"1. เพียงพอตลอดปี",
                    "2"=>"2. เพียงพอในฤดูแล้ง",
                    "3"=>"3. ไม่เพียงพอตลอดฤดู"
                );
                foreach($ch16 as $k=>$v) {
                    $checked = ($k==$form["ch16"]) ? "checked" :"";
                    echo '
                        <div class="form-inline form-choose">
                            <div class="form-check mb-2 mr-sm-2">
                                <input class="form-check-input" type="radio" id="ch16'.$k.'" name="ch16" value="'.$k.'" '.$checked.' required>
                                <label class="form-check-label" for="ch16'.$k.'">
                                    '.$v.'
                                </label>
                            </div>
                        </div>
                    ';
                }
            ?>
            <div class="mt-3 form-inline">
                <label class="my-1 mr-2" for="ch17_desc">
                    สาเหตุที่น้ำไม่เพียงพอในฤดูแล้ง
                </label>
                <input type="text" class="form-control my-1 mr-sm-2" id="ch17_desc" name="ch17_desc"
                    placeholder="ระบุสาเหตุ..." value="<?php echo $form["ch17_desc"]; ?>" required>
            </div>

            <hr>




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