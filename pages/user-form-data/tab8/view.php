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
                <i class="fas fa-folder mr-2"></i> ข้าว
            </div>
            <div class="mb-3">
                ครัวเรือนปลูกข้าวไว้กินเอง
            </div>
            <?php
                $ch = array(
                    "1"=>"1. ปลูก",
                    "2"=>"2. ไม่ปลูก (ซื้อกิน)"
                );
                foreach($ch as $k=>$v) {
                    $checked = ($k==$form["ch18"]) ? "checked" :"";
                    echo '
                        <div class="form-inline form-choose">
                            <div class="form-check mb-2 mr-sm-2">
                                <input class="form-check-input" type="radio" id="ch18_'.$k.'" name="ch18" value="'.$k.'" '.$checked.' required>
                                <label class="form-check-label" for="ch18_'.$k.'">
                                    '.$v.'
                                </label>
                            </div>
                        </div>
                    ';
                }
            ?>
            <div class="mt-4 mb-3">
                ปริมาณข้าวที่ปลูกไว้กินเอง
            </div>
            <?php
                $ch = array(
                    "1"=>"1. เพียงพอตลอดปี",
                    "2"=>"2. ไม่เพียงพอ"
                );
                foreach($ch as $k=>$v) {
                    $checked = ($k==$form["ch19"]) ? "checked" :"";
                    echo '
                        <div class="form-inline form-choose">
                            <div class="form-check mb-2 mr-sm-2">
                                <input class="form-check-input" type="radio" id="ch19_'.$k.'" name="ch19" value="'.$k.'" '.$checked.' required>
                                <label class="form-check-label" for="ch19_'.$k.'">
                                    '.$v.'
                                </label>
                            </div>
                        </div>
                    ';
                }
            ?>
            <div class="mt-3 form-inline">
                <label class="my-1 mr-2" for="ch19_num">
                    กรณีปริมาณข้าวที่ปลูกไว้กินเองไม่เพียงพอ
                </label>
                <select class="custom-select my-1 mr-sm-2" id="ch19_num" name="ch19_num" required>
                    <option value="">เลือกจำนวน</option>
                    <?php
                        for($i=1; $i<=12; $i++) {
                            $selected = ($form["ch19_num"]*1==$i) ? "selected" : "";
                            echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
                        }
                    ?>
                </select>
                <label class="my-1 mr-2">
                    เดือน/ปี
                </label>
            </div>
            <div class="mt-4 mb-3">
                ปริมาณข้าวที่ซื้อกินตลอดปี
            </div>
            <?php
                $ch = array(
                    "1"=>"1. เพียงพอ",
                    "2"=>"2. ไม่เพียงพอ"
                );
                foreach($ch as $k=>$v) {
                    $checked = ($k==$form["ch20"]) ? "checked" :"";
                    echo '
                        <div class="form-inline form-choose">
                            <div class="form-check mb-2 mr-sm-2">
                                <input class="form-check-input" type="radio" id="ch20_'.$k.'" name="ch20" value="'.$k.'" '.$checked.' required>
                                <label class="form-check-label" for="ch20_'.$k.'">
                                    '.$v.'
                                </label>
                            </div>
                        </div>
                    ';
                }
            ?>


            <hr>

            <div class="informant">
                <i class="fas fa-folder mr-2"></i> พืชผักสวนครัว
            </div>
            <div class="mb-3">
                ครัวเรือนปลูกพืชผักสวนครัวไว้กินเอง
            </div>
            <?php
                $ch = array(
                    "1"=>"1. ปลูก",
                    "2"=>"2. ไม่ปลูก (ซื้อกิน)"
                );
                foreach($ch as $k=>$v) {
                    $checked = ($k==$form["ch21"]) ? "checked" :"";
                    echo '
                        <div class="form-inline form-choose">
                            <div class="form-check mb-2 mr-sm-2">
                                <input class="form-check-input" type="radio" id="ch21_'.$k.'" name="ch21" value="'.$k.'" '.$checked.' required>
                                <label class="form-check-label" for="ch21_'.$k.'">
                                    '.$v.'
                                </label>
                            </div>
                        </div>
                    ';
                }
            ?>
            <div class="mt-4 mb-3">
                ปริมาณพืชผักสวนครัวที่ปลูกไว้กินเอง
            </div>
            <?php
                $ch = array(
                    "1"=>"1. เพียงพอตลอดปี",
                    "2"=>"2. ไม่เพียงพอ"
                );
                foreach($ch as $k=>$v) {
                    $checked = ($k==$form["ch22"]) ? "checked" :"";
                    echo '
                        <div class="form-inline form-choose">
                            <div class="form-check mb-2 mr-sm-2">
                                <input class="form-check-input" type="radio" id="ch22_'.$k.'" name="ch22" value="'.$k.'" '.$checked.' required>
                                <label class="form-check-label" for="ch22_'.$k.'">
                                    '.$v.'
                                </label>
                            </div>
                        </div>
                    ';
                }
            ?>
            <div class="mt-3 form-inline">
                <label class="my-1 mr-2" for="ch22_num">
                    กรณีปริมาณพืชผักสวนครัวที่ปลูกไว้กินเองไม่เพียงพอ
                </label>
                <select class="custom-select my-1 mr-sm-2" id="ch22_num" name="ch22_num" required>
                    <option value="">เลือกจำนวน</option>
                    <?php
                        for($i=1; $i<=12; $i++) {
                            $selected = ($form["ch22_num"]*1==$i) ? "selected" : "";
                            echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
                        }
                    ?>
                </select>
                <label class="my-1 mr-2">
                    เดือน/ปี
                </label>
            </div>
            <div class="mt-4 mb-3">
                ปริมาณพืชผักสวนครัวที่ซื้อกินตลอดปี
            </div>
            <?php
                $ch = array(
                    "1"=>"1. เพียงพอ",
                    "2"=>"2. ไม่เพียงพอ"
                );
                foreach($ch as $k=>$v) {
                    $checked = ($k==$form["ch23"]) ? "checked" :"";
                    echo '
                        <div class="form-inline form-choose">
                            <div class="form-check mb-2 mr-sm-2">
                                <input class="form-check-input" type="radio" id="ch23_'.$k.'" name="ch23" value="'.$k.'" '.$checked.' required>
                                <label class="form-check-label" for="ch23_'.$k.'">
                                    '.$v.'
                                </label>
                            </div>
                        </div>
                    ';
                }
            ?>


            <hr>

            <div class="informant">
                <i class="fas fa-folder mr-2"></i> ปศุสัตว์
            </div>
            <div class="mb-3">
                ครัวเรือนทำปศุสัตว์ (ไก่ หมู วัว แพะ ฯลฯ) ไว้กินเอง
            </div>
            <?php
                $ch = array(
                    "1"=>"1. ทำ",
                    "2"=>"2. ไม่ทำ (ซื้อกิน)"
                );
                foreach($ch as $k=>$v) {
                    $checked = ($k==$form["ch24"]) ? "checked" :"";
                    echo '
                        <div class="form-inline form-choose">
                            <div class="form-check mb-2 mr-sm-2">
                                <input class="form-check-input" type="radio" id="ch24_'.$k.'" name="ch24" value="'.$k.'" '.$checked.' required>
                                <label class="form-check-label" for="ch24_'.$k.'">
                                    '.$v.'
                                </label>
                            </div>
                        </div>
                    ';
                }
            ?>
            <div class="mt-4 mb-3">
                ปริมาณการทำปศุสัตว์ไว้กินเอง
            </div>
            <?php
                $ch = array(
                    "1"=>"1. เพียงพอตลอดปี",
                    "2"=>"2. ไม่เพียงพอ"
                );
                foreach($ch as $k=>$v) {
                    $checked = ($k==$form["ch25"]) ? "checked" :"";
                    echo '
                        <div class="form-inline form-choose">
                            <div class="form-check mb-2 mr-sm-2">
                                <input class="form-check-input" type="radio" id="ch25_'.$k.'" name="ch25" value="'.$k.'" '.$checked.' required>
                                <label class="form-check-label" for="ch25_'.$k.'">
                                    '.$v.'
                                </label>
                            </div>
                        </div>
                    ';
                }
            ?>
            <div class="mt-3 form-inline">
                <label class="my-1 mr-2" for="ch25_num">
                    กรณีปริมาณการทำปศุสัตว์ไว้กินเองไม่เพียงพอ
                </label>
                <select class="custom-select my-1 mr-sm-2" id="ch25_num" name="ch25_num" required>
                    <option value="">เลือกจำนวน</option>
                    <?php
                        for($i=1; $i<=12; $i++) {
                            $selected = ($form["ch25_num"]*1==$i) ? "selected" : "";
                            echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
                        }
                    ?>
                </select>
                <label class="my-1 mr-2">
                    เดือน/ปี
                </label>
            </div>
            <div class="mt-4 mb-3">
                ปริมาณปศุสัตว์ (ไก่ หมู วัว แพะ ฯลฯ) ที่ซื้อกินตลอดปี
            </div>
            <?php
                $ch = array(
                    "1"=>"1. เพียงพอ",
                    "2"=>"2. ไม่เพียงพอ"
                );
                foreach($ch as $k=>$v) {
                    $checked = ($k==$form["ch26"]) ? "checked" :"";
                    echo '
                        <div class="form-inline form-choose">
                            <div class="form-check mb-2 mr-sm-2">
                                <input class="form-check-input" type="radio" id="ch26_'.$k.'" name="ch26" value="'.$k.'" '.$checked.' required>
                                <label class="form-check-label" for="ch26_'.$k.'">
                                    '.$v.'
                                </label>
                            </div>
                        </div>
                    ';
                }
            ?>







            <hr>

            <div class="informant">
                <i class="fas fa-folder mr-2"></i> ประมง
            </div>
            <div class="mb-3">
                ครัวเรือนทำประมง (กุ้ง หอย ปู ปลา ฯลฯ) ไว้กินเอง
            </div>
            <?php
                $ch = array(
                    "1"=>"1. ทำ",
                    "2"=>"2. ไม่ทำ (ซื้อกิน)"
                );
                foreach($ch as $k=>$v) {
                    $checked = ($k==$form["ch27"]) ? "checked" :"";
                    echo '
                        <div class="form-inline form-choose">
                            <div class="form-check mb-2 mr-sm-2">
                                <input class="form-check-input" type="radio" id="ch27_'.$k.'" name="ch27" value="'.$k.'" '.$checked.' required>
                                <label class="form-check-label" for="ch27_'.$k.'">
                                    '.$v.'
                                </label>
                            </div>
                        </div>
                    ';
                }
            ?>
            <div class="mt-4 mb-3">
                ปริมาณการทำประมงไว้กินเอง
            </div>
            <?php
                $ch = array(
                    "1"=>"1. เพียงพอตลอดปี",
                    "2"=>"2. ไม่เพียงพอ"
                );
                foreach($ch as $k=>$v) {
                    $checked = ($k==$form["ch28"]) ? "checked" :"";
                    echo '
                        <div class="form-inline form-choose">
                            <div class="form-check mb-2 mr-sm-2">
                                <input class="form-check-input" type="radio" id="ch28_'.$k.'" name="ch28" value="'.$k.'" '.$checked.' required>
                                <label class="form-check-label" for="ch28_'.$k.'">
                                    '.$v.'
                                </label>
                            </div>
                        </div>
                    ';
                }
            ?>
            <div class="mt-3 form-inline">
                <label class="my-1 mr-2" for="ch28_num">
                    กรณีปริมาณการทำประมงไว้กินเองไม่เพียงพอ
                </label>
                <select class="custom-select my-1 mr-sm-2" id="ch28_num" name="ch28_num" required>
                    <option value="">เลือกจำนวน</option>
                    <?php
                        for($i=1; $i<=12; $i++) {
                            $selected = ($form["ch28_num"]*1==$i) ? "selected" : "";
                            echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
                        }
                    ?>
                </select>
                <label class="my-1 mr-2">
                    เดือน/ปี
                </label>
            </div>
            <div class="mt-4 mb-3">
                ปริมาณประมง (กุ้ง หอย ปู ปลา ฯลฯ) ที่ซื้อกินตลอดปี
            </div>
            <?php
                $ch = array(
                    "1"=>"1. เพียงพอ",
                    "2"=>"2. ไม่เพียงพอ"
                );
                foreach($ch as $k=>$v) {
                    $checked = ($k==$form["ch29"]) ? "checked" :"";
                    echo '
                        <div class="form-inline form-choose">
                            <div class="form-check mb-2 mr-sm-2">
                                <input class="form-check-input" type="radio" id="ch29_'.$k.'" name="ch29" value="'.$k.'" '.$checked.' required>
                                <label class="form-check-label" for="ch29_'.$k.'">
                                    '.$v.'
                                </label>
                            </div>
                        </div>
                    ';
                }
            ?>


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