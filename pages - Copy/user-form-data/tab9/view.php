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
                <i class="fas fa-folder mr-2"></i> สุขภาวะด้านสุขภาพ
            </div>
            <div class="mb-3">
                ในรอบ 1 ปีที่ผ่านมา สมาชิกในครัวเรือนเข้ารับการรักษาพยาบาล
            </div>
            <?php
                $ch = array(
                    "1"=>"1. ไม่เคย",
                    "2"=>"2. เคย"
                );
                foreach($ch as $k=>$v) {
                    $checked = ($k==$form["ch30"]) ? "checked" :"";
                    echo '
                        <div class="form-inline form-choose">
                            <div class="form-check mb-2 mr-sm-2">
                                <input class="form-check-input" type="radio" id="ch30_'.$k.'" name="ch30" value="'.$k.'" '.$checked.' required>
                                <label class="form-check-label" for="ch30_'.$k.'">
                                    '.$v.'
                                </label>
                            </div>
                        </div>
                    ';
                }
            ?>
            <div class="mt-4 mb-3">
                การปฏิบัติตัวเริ่มต้น เมื่อสมาชิกในครัวเรือนไม่สบายหรือเกิดการเจ็บป่วย (ที่ไม่ใช่อุบัติเหตุร้ายแรง)
            </div>
            <?php 
                $sql = "
                    SELECT 
                        ib.*,
                        fb.order_id
                    FROM item_behavior ib
                        LEFT JOIN form_behavior fb ON fb.item_behavior_id=ib.item_behavior_id 
                            AND fb.home_id='".$home["home_id"]."'
                    ORDER BY ib.item_behavior_id
                ";
                $obj = $DATABASE->QueryObj($sql);
                foreach($obj as $key=>$row) {
                    $selected1 = ($row["order_id"]=="1") ? "selected" : "";
                    $selected2 = ($row["order_id"]=="2") ? "selected" : "";
                    $selected3 = ($row["order_id"]=="3") ? "selected" : "";
            ?>
            <div class="mt-3 form-inline">
                <select class="custom-select my-1 mr-sm-2" id="item_behavior_id<?php echo $key; ?>"
                    name="item_behavior_id[<?php echo $row["item_behavior_id"]; ?>]" required>
                    <option value="">เลือกลำดับ</option>
                    <option value="1" <?php echo $selected1; ?>>1</option>
                    <option value="2" <?php echo $selected2; ?>>2</option>
                    <option value="3" <?php echo $selected3; ?>>3</option>
                </select>
                <label class="my-1 mr-2" for="item_behavior_id<?php echo $key; ?>">
                    <?php echo $row["item_behavior_name"]; ?>
                </label>
            </div>
            <?php } ?>

            <div class="mt-4 mb-3">
                สมาชิกในครัวเรือนเจ็บป่วยด้วยโรคติดต่อ
            </div>
            <?php
                $ch = array(
                    "1"=>"1. ไม่มี",
                    "2"=>"2. มี"
                );
                foreach($ch as $k=>$v) {
                    $checked = ($k==$form["ch31"]) ? "checked" :"";
                    echo '
                        <div class="form-inline form-choose">
                            <div class="form-check mb-2 mr-sm-2">
                                <input class="form-check-input" type="radio" id="ch31_'.$k.'" name="ch31" value="'.$k.'" '.$checked.' required>
                                <label class="form-check-label" for="ch31_'.$k.'">
                                    '.$v.'
                                </label>
                            </div>
                        </div>
                    ';
                }
            ?>

            <div class="mt-4 mb-3">
                โรคติดต่อที่เคยเจ็บป่วย (ตอบได้หลายตัวเลือก)
            </div>
            <?php
                $sql = "
                    SELECT 
                        ic.*,
                        fc.home_id
                    FROM item_contagious ic
                        LEFT JOIN form_contagious fc ON fc.item_contagious_id=ic.item_contagious_id AND fc.home_id='".$home["home_id"]."'
                    ORDER BY ic.item_contagious_id
                ";
                $obj = $DATABASE->QueryObj($sql);
                foreach($obj as $key=>$row) {
                    $checked = ($row["home_id"]!="") ? "checked" :"";
                    echo '
                        <div class="form-inline form-choose">
                            <div class="form-check mb-2 mr-sm-2">
                                <input class="form-check-input" type="checkbox" id="item_contagious_id_'.$key.'" name="item_contagious_id[]" value="'.$row["item_contagious_id"].'" '.$checked.' required>
                                <label class="form-check-label" for="item_contagious_id_'.$key.'">
                                    '.$row["item_contagious_id"].'.    
                                    '.$row["item_contagious_name"].'
                                </label>
                            </div>
                        </div>
                    ';
                }
            ?>


            <div class="mt-4 mb-3">
                สมาชิกในครัวเรือนมีผู้พิการ
            </div>
            <?php
                $ch = array(
                    "1"=>"1. ไม่มี",
                    "2"=>"2. มี"
                );
                foreach($ch as $k=>$v) {
                    $checked = ($k==$form["ch32"]) ? "checked" :"";
                    echo '
                        <div class="form-inline form-choose">
                            <div class="form-check mb-2 mr-sm-2">
                                <input class="form-check-input" type="radio" id="ch32_'.$k.'" name="ch32" value="'.$k.'" '.$checked.' required>
                                <label class="form-check-label" for="ch32_'.$k.'">
                                    '.$v.'
                                </label>
                            </div>
                        </div>
                    ';
                }
            ?>



            <div class="mt-4 mb-3">
                ความพิการของสมาชิกในครัวเรือน (ตอบได้หลายตัวเลือก)
            </div>
            <?php
                $sql = "
                    SELECT 
                        id.*,
                        fc.home_id
                    FROM item_disability id
                        LEFT JOIN form_disability fc ON fc.item_disability_id=id.item_disability_id AND fc.home_id='".$home["home_id"]."'
                    ORDER BY id.item_disability_id
                ";
                $obj = $DATABASE->QueryObj($sql);
                foreach($obj as $key=>$row) {
                    $checked = ($row["home_id"]!="") ? "checked" :"";
                    echo '
                        <div class="form-inline form-choose">
                            <div class="form-check mb-2 mr-sm-2">
                                <input class="form-check-input" type="checkbox" id="item_disability_id_'.$key.'" name="item_disability_id[]" value="'.$row["item_disability_id"].'" '.$checked.' required>
                                <label class="form-check-label" for="item_disability_id_'.$key.'">
                                    '.$row["item_disability_id"].'.
                                    '.$row["item_disability_name"].'
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