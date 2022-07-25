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
                <i class="fas fa-folder mr-2"></i> โอกาสและการประกอบอาชีพ
            </div>
            <div class="mb-3">
                ในปีที่ผ่านมา สมาชิกในครัวเรือนมีโอกาสได้รับการอบรม การศึกษาดูงาน ทำให้รับความรู้ใหม่ๆ จากหน่วยงานราชการ
                เอกชน ฯลฯ
            </div>
            <?php
                $ch35 = array(
                    "1"=>"1. ไม่เคย",
                    "2"=>"2. เคย"
                );
                foreach($ch35 as $k=>$v) {
                    $checked = ($k==$form["ch35"]) ? "checked" :"";
                    echo '
                        <div class="form-inline form-choose">
                            <div class="form-check mb-2 mr-sm-2">
                                <input class="form-check-input" type="radio" id="ch35_'.$k.'" name="ch35" value="'.$k.'" '.$checked.' required>
                                <label class="form-check-label" for="ch35_'.$k.'">
                                    '.$v.'
                                </label>
                            </div>
                        </div>
                    ';
                }
            ?>
            <div class="mt-3 form-inline">
                <label class="my-1 mr-2" for="ch36_num">
                    จำนวนการอบรม การศึกษาดูงาน
                </label>
                <input type="tel" class="form-control form-control-sm mr-2" id="ch36_num" name="ch36_num"
                    data-input-number="0" value="<?php echo $form["ch36_num"]; ?>" required>
                <label class="my-1 mr-2">
                    ครั้ง/ปี
                </label>
            </div>
            <div class="mt-5 mb-3">
                นำความรู้จากการอบรม การศึกษาดูงานมาปรับใช้
            </div>
            <?php
                $ch37 = array(
                    "1"=>"1. ไม่เคย",
                    "2"=>"2. เคย"
                );
                foreach($ch37 as $k=>$v) {
                    $checked = ($k==$form["ch37"]) ? "checked" :"";
                    echo '
                        <div class="form-inline form-choose">
                            <div class="form-check mb-2 mr-sm-2">
                                <input class="form-check-input" type="radio" id="ch37_'.$k.'" name="ch37" value="'.$k.'" '.$checked.' required>
                                <label class="form-check-label" for="ch37_'.$k.'">
                                    '.$v.'
                                </label>
                            </div>
                        </div>
                    ';
                }
            ?>
            <div class="mt-5 mb-3">
                มีความรู้ ทักษะ และความเชี่ยวชาญ ในการทำมาหากินที่ตกทอดมาเป็นภูมิปัญญาสั่งสม
            </div>
            <?php
                $ch38 = array(
                    "1"=>"1. ไม่มี",
                    "2"=>"2. มี"
                );
                foreach($ch38 as $k=>$v) {
                    $checked = ($k==$form["ch38"]) ? "checked" :"";
                    echo '
                        <div class="form-inline form-choose">
                            <div class="form-check mb-2 mr-sm-2">
                                <input class="form-check-input" type="radio" id="ch38_'.$k.'" name="ch38" value="'.$k.'" '.$checked.' required>
                                <label class="form-check-label" for="ch38_'.$k.'">
                                    '.$v.'
                                </label>
                            </div>
                        </div>
                    ';
                }
            ?>
            <div class="mt-5 mb-3">
                มีโอกาสที่จะเพิ่มพูนความรู้ ทักษะ ความเชี่ยวชาญในการทำงาน ประกอบอาชีพ การหารายได้ของตนเอง ของครอบครัว
                ของกลุ่มอย่างต่อเนื่อง
            </div>
            <?php
                $ch39 = array(
                    "1"=>"1. ไม่มี",
                    "2"=>"2. มี"
                );
                foreach($ch39 as $k=>$v) {
                    $checked = ($k==$form["ch39"]) ? "checked" :"";
                    echo '
                        <div class="form-inline form-choose">
                            <div class="form-check mb-2 mr-sm-2">
                                <input class="form-check-input" type="radio" id="ch39_'.$k.'" name="ch39" value="'.$k.'" '.$checked.' required>
                                <label class="form-check-label" for="ch39_'.$k.'">
                                    '.$v.'
                                </label>
                            </div>
                        </div>
                    ';
                }
            ?>
            <div class="mt-5 mb-3">
                มีการปรับเปลี่ยนความรู้ ความเชี่ยวชาญในการทำงาน การประกอบอาชีพ การหารายได้ของตนเอง ของครอบครัว
                ของกลุ่มอย่างต่อเนื่อง
            </div>
            <?php
                $ch40 = array(
                    "1"=>"1. ไม่มี",
                    "2"=>"2. มี"
                );
                foreach($ch40 as $k=>$v) {
                    $checked = ($k==$form["ch40"]) ? "checked" :"";
                    echo '
                        <div class="form-inline form-choose">
                            <div class="form-check mb-2 mr-sm-2">
                                <input class="form-check-input" type="radio" id="ch40_'.$k.'" name="ch40" value="'.$k.'" '.$checked.' required>
                                <label class="form-check-label" for="ch40_'.$k.'">
                                    '.$v.'
                                </label>
                            </div>
                        </div>
                    ';
                }
            ?>
            <div class="mt-5 mb-3">
                ในแต่ละวัน ได้ทำงานเต็มกำลังความสามารถ
            </div>
            <?php
                $ch41 = array(
                    "1"=>"1. ยังไม่เต็มความสามารถ",
                    "2"=>"2. เต็มความสามารถ"
                );
                foreach($ch41 as $k=>$v) {
                    $checked = ($k==$form["ch41"]) ? "checked" :"";
                    echo '
                        <div class="form-inline form-choose">
                            <div class="form-check mb-2 mr-sm-2">
                                <input class="form-check-input" type="radio" id="ch41_'.$k.'" name="ch41" value="'.$k.'" '.$checked.' required>
                                <label class="form-check-label" for="ch41_'.$k.'">
                                    '.$v.'
                                </label>
                            </div>
                        </div>
                    ';
                }
            ?>
            <div class="mt-5 mb-3">
                งาน หรืออาชีพ ที่ทำอยู่ในปัจจุบันมีความมั่นคง ต่อเนื่อง ยั่งยืน
            </div>
            <?php
                $ch42 = array(
                    "1"=>"1. ไม่มี",
                    "2"=>"2. มี"
                );
                foreach($ch42 as $k=>$v) {
                    $checked = ($k==$form["ch42"]) ? "checked" :"";
                    echo '
                        <div class="form-inline form-choose">
                            <div class="form-check mb-2 mr-sm-2">
                                <input class="form-check-input" type="radio" id="ch42_'.$k.'" name="ch42" value="'.$k.'" '.$checked.' required>
                                <label class="form-check-label" for="ch42_'.$k.'">
                                    '.$v.'
                                </label>
                            </div>
                        </div>
                    ';
                }
            ?>
            <div class="mt-5 mb-3">
                คนในครอบครัว มีช่องทางที่จะมีอาชีพใหม่ หรือการทำมาหากินแบบใหม่
            </div>
            <?php
                $ch43 = array(
                    "1"=>"1. ไม่มี",
                    "2"=>"2. มี"
                );
                foreach($ch43 as $k=>$v) {
                    $checked = ($k==$form["ch43"]) ? "checked" :"";
                    echo '
                        <div class="form-inline form-choose">
                            <div class="form-check mb-2 mr-sm-2">
                                <input class="form-check-input" type="radio" id="ch43_'.$k.'" name="ch43" value="'.$k.'" '.$checked.' required>
                                <label class="form-check-label" for="ch43_'.$k.'">
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