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
                <i class="fas fa-folder mr-2"></i> การรับประโยชน์จากโครงการ
            </div>
            <div class="mb-3">
                ประโยชน์ที่ครัวเรือนได้รับจากโครงการฯ และกิจกรรมในชุมชน
            </div>
            <?php
                $ch1 = array(
                    "1"=>"1. ความรู้ (อบรม/ดูงาน/ถ่ายทอดความรู้)",
                    "2"=>"2. น้ำ",
                    "3"=>"3. กิจกรรมการส่งเสริม",
                    "4"=>"4. น้ำและกิจกรรมการส่งเสริม",
                    "5"=>"5. ไม่ได้รับผลประโยชน์",
                );
                foreach($ch1 as $k=>$v) {
                    $checked = ($k==$form["ch1"]) ? "checked" :"";
                    echo '
                        <div class="form-inline form-choose">
                            <div class="form-check mb-2 mr-sm-2">
                                <input class="form-check-input" type="radio" id="ch1'.$k.'" name="ch1" value="'.$k.'" '.$checked.' required>
                                <label class="form-check-label" for="ch1'.$k.'">
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