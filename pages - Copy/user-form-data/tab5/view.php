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
                <i class="fas fa-folder mr-2"></i> ไฟฟ้า
            </div>
            <div class="mb-3">
                ครัวเรือนมีไฟฟ้าใช้ (ไฟฟ้าของรัฐและทางเลือก)
            </div>
            <?php
                $ch3 = array(
                    "1"=>"1. ไม่มี",
                    "2"=>"2. มี"
                );
                foreach($ch3 as $k=>$v) {
                    $checked = ($k==$form["ch3"]) ? "checked" :"";
                    echo '
                        <div class="form-inline form-choose">
                            <div class="form-check mb-2 mr-sm-2">
                                <input class="form-check-input" type="radio" id="ch3'.$k.'" name="ch3" value="'.$k.'" '.$checked.' required>
                                <label class="form-check-label" for="ch3'.$k.'">
                                    '.$v.'
                                </label>
                            </div>
                        </div>
                    ';
                }
            ?>
            <div class="mt-5 mb-3">
                ครัวเรือนใช้ไฟฟ้าจากแหล่งพลังงานทางเลือก (ตอบได้หลายตัวเลือก)
            </div>
            <?php
                $ch4 = array(
                    "1"=>"1. เครื่องปั่นไฟ",
                    "2"=>"2. แสงอาทิตย์/โซล่าเซลล์",
                    "3"=>"3. ชีวมวล",
                    "4"=>"4. ลม / น้ำ",
                    "5"=>"5. ไม่มี",
                );
                foreach($ch4 as $k=>$v) {
                    $checked = ($form["ch4_".$k]=="Y") ? "checked" :"";
                    echo '
                        <div class="form-inline form-choose">
                            <div class="form-check mb-2 mr-sm-2">
                                <input class="form-check-input" type="checkbox" id="ch4_'.$k.'" name="ch4[]" value="'.$k.'" '.$checked.' required>
                                <label class="form-check-label" for="ch4_'.$k.'">
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