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
                <i class="fas fa-folder mr-2"></i> การจดบันทึกค่าใช้จ่าย
            </div>
            <div class="mb-3">
                มีการจดบันทึกค่าใช้จ่ายรายวันของครัวเรือน
            </div>
            <?php
                $ch33 = array(
                    "1"=>"1. ไม่จดบันทึก",
                    "2"=>"2. จดบันทึก"
                );
                foreach($ch33 as $k=>$v) {
                    $checked = ($k==$form["ch33"]) ? "checked" :"";
                    echo '
                        <div class="form-inline form-choose">
                            <div class="form-check mb-2 mr-sm-2">
                                <input class="form-check-input" type="radio" id="ch33_'.$k.'" name="ch33" value="'.$k.'" '.$checked.' required>
                                <label class="form-check-label" for="ch33_'.$k.'">
                                    '.$v.'
                                </label>
                            </div>
                        </div>
                    ';
                }
            ?>
            <div class="mt-5 mb-3">
                รูปแบบการจดบันทึก
            </div>
            <?php
                $ch34 = array(
                    "1"=>"1. บัญชีครัวเรือน",
                    "2"=>"2. บัญชีต้นทุนการประกอบอาชีพ"
                );
                foreach($ch34 as $k=>$v) {
                    $checked = ($k==$form["ch34"]) ? "checked" :"";
                    echo '
                        <div class="form-inline form-choose">
                            <div class="form-check mb-2 mr-sm-2">
                                <input class="form-check-input" type="radio" id="ch34_'.$k.'" name="ch34" value="'.$k.'" '.$checked.' required>
                                <label class="form-check-label" for="ch34_'.$k.'">
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