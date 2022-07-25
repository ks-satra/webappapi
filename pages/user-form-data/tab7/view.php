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
                <i class="fas fa-folder mr-2"></i> พื้นที่ทำกิน (ไม่รวมพื้นที่บ้าน)
            </div>
            <div class="form-group row">
                <label for="area_num" class="col-md-5 col-form-label">จำนวนพื้นที่ทำกิน (แปลง)</label>
                <div class="col-md-7">
                    <input type="text" class="form-control" id="area_num" value="<?php echo $form["area_num"]; ?>"
                        disabled>
                </div>
            </div>
            <div class="form-group row">
                <label for="informant_name" class="col-md-5 col-form-label">มีพื้นที่ทำกินรวม (ไร่/งาน/ตารางวา)</label>
                <div class="col-md-7">
                    <div class="input-group">
                        <input type="text" class="form-control" id="area_rai"
                            value="<?php echo number_format($form["area_rai"],0); ?>" disabled>
                        <input type="text" class="form-control" id="area_ngan"
                            value="<?php echo number_format($form["area_ngan"],0); ?>" disabled>
                        <input type="text" class="form-control" id="area_wa"
                            value="<?php echo number_format($form["area_wa"],0); ?>" disabled>
                    </div>
                </div>
            </div>

            <div>
                <?php
                    $sql = "
                        SELECT 
                            fa.*,
                            ias.item_area_status_name
                        FROM form_area fa
                            INNER JOIN item_area_status ias ON ias.item_area_status_id=fa.item_area_status_id
                        WHERE fa.home_id='".$home["home_id"]."' 
                        ORDER BY fa.order_id ";
                    $obj = $DATABASE->QueryObj($sql);
                    foreach($obj as $key=>$row) {
                        $row["form_area_utilization"] = $DATABASE->QueryObj("SELECT * FROM form_area_utilization WHERE home_id='".$home['home_id']."' AND order_id='".$row["order_id"]."' ");
                        $row["form_area_water"] = $DATABASE->QueryObj("SELECT * FROM form_area_water WHERE home_id='".$home['home_id']."' AND order_id='".$row["order_id"]."' ");
                ?>
                <table class="table table-bordered table-sm"
                    data-json="<?php echo htmlspecialchars(json_encode($row)); ?>">
                    <tbody>
                        <tr class="bg-light">
                            <th style="width: 150px;">แปลงที่</th>
                            <th colspan="2"><?php echo $key+1; ?>.</th>
                        </tr>
                        <tr>
                            <th>จำนวนพื้นที่</th>
                            <td><?php echo number_format($row["rai1"],0); ?>/<?php echo number_format($row["ngan1"],0); ?>/<?php echo number_format($row["wa1"],0); ?>
                            </td>
                            <td>ไร/งาน/ตารางวา</td>
                        </tr>
                        <tr>
                            <th>การใช้ประโยชน์พื้นที่</th>
                            <td colspan="2">
                                <?php
                                    $sql = "
                                        SELECT 
                                            fau.*,
                                            iau.item_area_utilization_name
                                        FROM form_area_utilization fau
                                            INNER JOIN item_area_utilization iau ON iau.item_area_utilization_id=fau.item_area_utilization_id
                                        WHERE fau.home_id='".$row["home_id"]."' 
                                            AND fau.order_id='".$row["order_id"]."'
                                        ORDER BY iau.item_area_utilization_id
                                    ";
                                    $obj = $DATABASE->QueryObj($sql);
                                    foreach($obj as $k=>$v) {
                                        echo '<div>'.($k+1).'. '.$v["item_area_utilization_name"].'</div>';
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th>ฤดูฝนน้ำเข้าแปลง</th>
                            <td><?php echo number_format($row["rai2"],0); ?>/<?php echo number_format($row["ngan2"],0); ?>/<?php echo number_format($row["wa2"],0); ?>
                            </td>
                            <td>ไร/งาน/ตารางวา</td>
                        </tr>
                        <tr>
                            <th>ฤดูแล้งน้ำเข้าแปลง</th>
                            <td><?php echo number_format($row["rai3"],0); ?>/<?php echo number_format($row["ngan3"],0); ?>/<?php echo number_format($row["wa3"],0); ?>
                            </td>
                            <td>ไร/งาน/ตารางวา</td>
                        </tr>
                        <tr>
                            <th>แหล่งน้ำที่ใช้ในแปลง</th>
                            <td colspan="2">
                                <?php
                                    $sql = "
                                        SELECT 
                                            faw.*,
                                            iaw.item_area_water_name
                                        FROM form_area_water faw
                                            INNER JOIN item_area_water iaw ON iaw.item_area_water_id=faw.item_area_water_id
                                        WHERE faw.home_id='".$row["home_id"]."' 
                                            AND faw.order_id='".$row["order_id"]."'
                                        ORDER BY iaw.item_area_water_id
                                    ";
                                    $obj = $DATABASE->QueryObj($sql);
                                    foreach($obj as $k=>$v) {
                                        echo '<div>'.($k+1).'. '.$v["item_area_water_name"].'</div>';
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th>สถานะพื้นที่ทำกิน</th>
                            <td colspan="2">
                                <?php
                                    echo $row["item_area_status_id"].". ".$row["item_area_status_name"];
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <th>จัดการ</th>
                            <td>
                                <a href="Javascript:" class="text-warning mr-3 btn-edit"><i class="fas fa-edit"></i>
                                    แก้ไข</a>
                                <a href="Javascript:" class="text-danger btn-del"><i class="fas fa-trash"></i> ลบ</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <?php } ?>
            </div>


            <div class="text-center p-5 border">
                <a id="btn-add" href="Javascript:" class="text-center text-success">
                    <i class="fas fa-plus mb-2" style="font-size: 30px;"></i><br>
                    เพิ่มแปลงใหม่
                </a>
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



<div id="template" class="d-none">
    <form autocomplete="off">
        <input type="hidden" name="home_id" value="<?php echo $home['home_id']; ?>">
        <input type="hidden" name="order_id" value="">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr class="bg-light">
                        <th scope="col" style="min-width: 200px;">รายการ</th>
                        <th scope="col" class="text-center" style="min-width: 250px; width: 250px;">ระบุ</th>
                        <th scope="col" class="text-center" style="min-width: 120px; width: 120px;">หน่วย</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>จำนวนพื้นที่</td>
                        <td class="p-2">
                            <div class="input-group input-group-sm">
                                <input type="tel" class="form-control" id="rai1" name="rai1" required>
                                <div class="input-group-prepend">
                                    <span class="input-group-text">/</span>
                                </div>
                                <input type="tel" class="form-control" id="ngan1" name="ngan1" required>
                                <div class="input-group-prepend">
                                    <span class="input-group-text">/</span>
                                </div>
                                <input type="tel" class="form-control" id="wa1" name="wa1" required>
                            </div>
                        </td>
                        <td class="text-center">ไร่/งาน/ตารางวา</td>
                    </tr>
                    <tr>
                        <td>การใช้ประโยชน์พื้นที่</td>
                        <td class="p-2" colspan="2">
                            <?php
                                $sql = "SELECT * FROM item_area_utilization ORDER BY item_area_utilization_id";
                                $obj = $DATABASE->QueryObj($sql);
                                foreach($obj as $key=>$row) {
                            ?>
                            <div class="form-inline form-choose">
                                <div class="form-check mb-2 mr-sm-2">
                                    <input class="form-check-input" type="checkbox"
                                        id="item_area_utilization_id_<?php echo $key; ?>"
                                        name="item_area_utilization_id[]"
                                        value="<?php echo $row["item_area_utilization_id"]; ?>" required>
                                    <label class="form-check-label" for="item_area_utilization_id_<?php echo $key; ?>">
                                        <?php echo $row["item_area_utilization_id"]; ?>.
                                        <?php echo $row["item_area_utilization_name"]; ?>
                                    </label>
                                </div>
                            </div>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td>ฤดูฝนน้ำเข้าแปลง</td>
                        <td class="p-2">
                            <div class="input-group input-group-sm">
                                <input type="tel" class="form-control" id="rai2" name="rai2" required>
                                <div class="input-group-prepend">
                                    <span class="input-group-text">/</span>
                                </div>
                                <input type="tel" class="form-control" id="ngan2" name="ngan2" required>
                                <div class="input-group-prepend">
                                    <span class="input-group-text">/</span>
                                </div>
                                <input type="tel" class="form-control" id="wa2" name="wa2" required>
                            </div>
                        </td>
                        <td class="text-center">ไร่/งาน/ตารางวา</td>
                    </tr>
                    <tr>
                        <td>ฤดูแล้งน้ำเข้าแปลง</td>
                        <td class="p-2">
                            <div class="input-group input-group-sm">
                                <input type="tel" class="form-control" id="rai3" name="rai3" required>
                                <div class="input-group-prepend">
                                    <span class="input-group-text">/</span>
                                </div>
                                <input type="tel" class="form-control" id="ngan3" name="ngan3" required>
                                <div class="input-group-prepend">
                                    <span class="input-group-text">/</span>
                                </div>
                                <input type="tel" class="form-control" id="wa3" name="wa3" required>
                            </div>
                        </td>
                        <td class="text-center">ไร่/งาน/ตารางวา</td>
                    </tr>
                    <tr>
                        <td>แหล่งน้ำที่ใช้ในแปลง</td>
                        <td class="p-2" colspan="2">
                            <?php
                                $sql = "SELECT * FROM item_area_water ORDER BY item_area_water_id";
                                $obj = $DATABASE->QueryObj($sql);
                                foreach($obj as $key=>$row) {
                            ?>
                            <div class="form-inline form-choose">
                                <div class="form-check mb-2 mr-sm-2">
                                    <input class="form-check-input" type="checkbox"
                                        id="item_area_water_id_<?php echo $key; ?>" name="item_area_water_id[]"
                                        value="<?php echo $row["item_area_water_id"]; ?>" required>
                                    <label class="form-check-label" for="item_area_water_id_<?php echo $key; ?>">
                                        <?php echo $row["item_area_water_id"]; ?>.
                                        <?php echo $row["item_area_water_name"]; ?>
                                    </label>
                                </div>
                            </div>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td>สถานะพื้นที่ทำกิน</td>
                        <td class="p-2" colspan="2">
                            <select class="form-control form-control-sm" id="item_area_status_id"
                                name="item_area_status_id">
                                <?php
                                    $sql = "SELECT * FROM item_area_status ORDER BY item_area_status_id";
                                    $obj = $DATABASE->QueryObj($sql);
                                    foreach($obj as $row) {
                                        echo '
                                        <option value="'.$row["item_area_status_id"].'">
                                            '.$row["item_area_status_id"].'.
                                            '.$row["item_area_status_name"].'
                                        </option>';
                                    }
                                ?>
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <input type="submit" class="submit d-none">
    </form>
</div>