<?php
    $sql = "
        SELECT 
            i.*,
            ip.item_prefix_name,
            hm.name,
            hm.lname
        FROM income13 i
            INNER JOIN home_member hm ON hm.order_id=i.home_order_id
                AND hm.home_id=i.home_id
            INNER JOIN item_prefix ip ON ip.item_prefix_id=hm.item_prefix_id
        WHERE i.home_id='".$home['home_id']."' 
        ORDER BY i.order_id
    ";
    $ObjData = $DATABASE->QueryObj($sql);
    $ExtPlaceId = array(
        "1"=>"ในพื้นที่",
        "2"=>"นอกพื้นที่"
    );
?>
<input type="hidden" id="ObjData" value="<?php echo htmlspecialchars(json_encode($ObjData)); ?>">
<form id="formdata" class="mb-3" autocomplete="off">
    <input type="hidden" name="home_id" value="<?php echo $home["home_id"]; ?>">
    <div class="row">
        <div class="col-lg-6">
            <?php include_once('pages/'.$PAGE.'/tab-menu.php');?>
        </div>
        <div class="col-lg-6">
            <div class="informant" id="first-scroll">
                <i class="fas fa-folder mr-2"></i> รายได้ประจำของสมาชิกในครัวเรือน
            </div>
            <div>
                <?php
                    foreach($ObjData as $key=>$row) {
                ?>
                <table class="table table-bordered table-sm"
                    data-json="<?php echo htmlspecialchars(json_encode($row)); ?>">
                    <tbody>
                        <tr class="bg-light">
                            <th scope="col" style="width: 150px;">ลำดับที่</th>
                            <th scope="col"><?php echo $key+1; ?></th>
                        </tr>
                        <tr>
                            <th scope="col">ชื่อ - นามสกุล</th>
                            <td scope="col">
                                <?php echo $row["item_prefix_name"]; ?><?php echo $row["name"]; ?>
                                <?php echo $row["lname"]; ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="col">อาชีพ</th>
                            <td scope="col">
                                <?php echo $row["occupation"]; ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="col">จำนวนเงิน</th>
                            <td scope="col">
                                <?php echo number_format($row["amount"],0); ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="col">สถานที่ทำงาน</th>
                            <td scope="col">
                                <?php echo $ExtPlaceId[$row["place_id"]]; ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="col">จัดการ</th>
                            <td scope="col">
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
                    เพิ่มรายได้ใหม่
                </a>
            </div>
            <div class="mt-4">
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
                        <th scope="col" class="text-center" style="min-width: 140px; width: 140px;">ระบุ</th>
                        <th scope="col" class="text-center" style="min-width: 140px; width: 140px;">หน่วย</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>ชื่อ-นามสกุล</td>
                        <td class="p-2" colspan="2">
                            <select class="form-control form-control-sm" id="home_order_id" name="home_order_id"
                                required>
                                <option value="">-- โปรดเลือกชื่อสมาชิก --</option>
                                <?php
                                    $sql = "
                                        SELECT
                                            hm.*,
                                            ip.item_prefix_name
                                        FROM home_member hm
                                            INNER JOIN item_prefix ip ON ip.item_prefix_id=hm.item_prefix_id
                                        WHERE hm.home_id='".$home['home_id']."'
                                    ";
                                    $obj = $DATABASE->QueryObj($sql);
                                    foreach($obj as $key=>$row) {
                                        echo '<option value="'.$row["order_id"].'">'.$row["item_prefix_name"].''.$row["name"].' '.$row["lname"].'</option>';
                                    }
                                ?>
                                <select>
                        </td>
                    </tr>
                    <tr>
                        <td>อาชีพ</td>
                        <td class="p-2" colspan="2">
                            <input type="text" class="form-control form-control-sm" id="occupation" name="occupation"
                                placeholder="โปรดระบุอาชีพ..." required>
                        </td>
                    </tr>
                    <tr>
                        <td>จำนวนเงิน</td>
                        <td class="p-2">
                            <input type="tel" class="form-control form-control-sm text-right" id="amount" name="amount"
                                value="0" required>
                        </td>
                        <td class="text-center">บาท/ปี</td>
                    </tr>
                    <tr>
                        <td>สถานที่ทำงาน</td>
                        <td class="pt-3" colspan="2">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="place_id" id="place_id1" value="1"
                                    checked>
                                <label class="form-check-label" for="place_id1">ในพื้นที่</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="place_id" id="place_id2" value="2">
                                <label class="form-check-label" for="place_id2">นอกพื้นที่</label>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <input type="submit" class="submit d-none">
    </form>
</div>