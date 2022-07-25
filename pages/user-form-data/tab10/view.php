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
                <i class="fas fa-folder mr-2"></i> สุขภาวะด้านสภาพสิ่งแวดล้อมในชุมชน
            </div>
            <div class="mb-3">
                ระดับ : 1 ไม่มี | 2 น้อย | 3 ปานกลาง | 4 มาก
            </div>
            <table class="table">
                <tr class="bg-light">
                    <td>รายการ</td>
                    <td>1</td>
                    <td>2</td>
                    <td>3</td>
                    <td>4</td>
                </tr>
                <?php
                    $sql = "
                        SELECT 
                            ie.*,
                            fe.level
                        FROM item_environment ie
                            LEFT JOIN form_environment fe ON fe.item_environment_id=ie.item_environment_id
                                AND fe.home_id='".$home["home_id"]."'
                        ORDER BY ie.item_environment_id
                    ";
                    $obj = $DATABASE->QueryObj($sql);
                    foreach($obj as $key=>$row) {
                        $checked1 = ($row["level"]=="1") ? "checked" : "";
                        $checked2 = ($row["level"]=="2") ? "checked" : "";
                        $checked3 = ($row["level"]=="3") ? "checked" : "";
                        $checked4 = ($row["level"]=="4") ? "checked" : "";
                ?>
                <tr>
                    <td><?php echo $key+1; ?>. <?php echo $row["item_environment_name"]; ?></td>
                    <td><input type="radio" name="level[<?php echo $row["item_environment_id"]; ?>]" value="1"
                            <?php echo $checked1; ?> required>
                    </td>
                    <td><input type="radio" name="level[<?php echo $row["item_environment_id"]; ?>]" value="2"
                            <?php echo $checked2; ?> required>
                    </td>
                    <td><input type="radio" name="level[<?php echo $row["item_environment_id"]; ?>]" value="3"
                            <?php echo $checked3; ?> required>
                    </td>
                    <td><input type="radio" name="level[<?php echo $row["item_environment_id"]; ?>]" value="4"
                            <?php echo $checked4; ?> required>
                    </td>
                </tr>
                <?php } ?>
            </table>

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