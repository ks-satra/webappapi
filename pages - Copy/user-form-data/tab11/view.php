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
                <i class="fas fa-folder mr-2"></i> สุขภาวะด้านสภาพทางสังคมในชุมชน
            </div>
            <div>
                ระดับ : 1 ไม่มี | 2 น้อย | 3 ปานกลาง | 4 มาก
            </div>
            <table class="table">
                <tr>
                    <td>รายการ</td>
                    <td>1</td>
                    <td>2</td>
                    <td>3</td>
                    <td>4</td>
                </tr>
                <?php
                    $sql = "
                        SELECT 
                            `is`.*,
                            fs.level
                        FROM item_society `is`
                            LEFT JOIN form_society fs ON fs.item_society_id=`is`.item_society_id
                                AND fs.home_id='".$home["home_id"]."'
                        ORDER BY `is`.item_society_id
                    ";
                    $obj = $DATABASE->QueryObj($sql);
                    foreach($obj as $key=>$row) {
                        $checked1 = ($row["level"]=="1") ? "checked" : "";
                        $checked2 = ($row["level"]=="2") ? "checked" : "";
                        $checked3 = ($row["level"]=="3") ? "checked" : "";
                        $checked4 = ($row["level"]=="4") ? "checked" : "";
                ?>
                <tr>
                    <td><?php echo $key+1; ?>. <?php echo $row["item_society_name"]; ?></td>
                    <td><input type="radio" name="level[<?php echo $row["item_society_id"]; ?>]" value="1"
                            <?php echo $checked1; ?> required>
                    </td>
                    <td><input type="radio" name="level[<?php echo $row["item_society_id"]; ?>]" value="2"
                            <?php echo $checked2; ?> required>
                    </td>
                    <td><input type="radio" name="level[<?php echo $row["item_society_id"]; ?>]" value="3"
                            <?php echo $checked3; ?> required>
                    </td>
                    <td><input type="radio" name="level[<?php echo $row["item_society_id"]; ?>]" value="4"
                            <?php echo $checked4; ?> required>
                    </td>
                </tr>
                <?php } ?>
            </table>


            <!-- <div class="mb-3">
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
            ?>-->
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