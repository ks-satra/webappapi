<?php
    $sql = "
        SELECT 
            i.*
        FROM income9 i
        WHERE i.home_id='".$home['home_id']."' 
        ORDER BY i.order_id
    ";
    $ObjData = $DATABASE->QueryObj($sql);
?>
<input type="hidden" id="ExtUnit" value="<?php echo htmlspecialchars(json_encode($ExtUnit)); ?>">
<form id="formdata" class="mb-3" autocomplete="off">
    <input type="hidden" name="home_id" value="<?php echo $home["home_id"]; ?>">
    <div class="row">
        <div class="col-lg-6">
            <?php include_once('pages/'.$PAGE.'/tab-menu.php');?>
        </div>
        <div class="col-lg-6">
            <div class="informant" id="first-scroll">
                <i class="fas fa-folder mr-2"></i> รายได้จากการทำงานหัตถกรรม
            </div>

            <div>
                <?php
                    foreach($ObjData as $key=>$row) {
                        $row["income9_market"] = $DATABASE->QueryObj("SELECT * FROM income9_market WHERE home_id='".$home['home_id']."' AND order_id='".$row["order_id"]."' ");
                ?>
                <table class="table table-bordered table-sm"
                    data-json="<?php echo htmlspecialchars(json_encode($row)); ?>">
                    <tbody>
                        <tr class="bg-light">
                            <th scope="col" style="width: 235px;">ลำดับที่</th>
                            <th scope="col"><?php echo $key+1; ?></th>
                        </tr>
                        <tr>
                            <th scope="col">ผลิตภัณฑ์</th>
                            <td scope="col">
                                <?php echo $row["product_name"]; ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="col">มูลค่าผลิตภัณฑ์ใช้ในครัวเรือน</th>
                            <td scope="col">
                                <?php echo number_format($row["kg1"],0); ?> บาท/ปี
                            </td>
                        </tr>
                        <tr>
                            <th scope="col">มูลค่าผลิตภัณฑ์ขาย</th>
                            <td scope="col">
                                <?php echo number_format($row["kg2"],0); ?> บาท/ปี
                            </td>
                        </tr>
                        <tr>
                            <th scope="col">รายได้รวม</th>
                            <td scope="col">
                                <?php echo number_format($row["income"],0); ?> บาท/ปี
                            </td>
                        </tr>
                        <tr>
                            <th scope="col">ต้นทุนการผลิต</th>
                            <td scope="col">
                                <?php echo number_format($row["cost"],0); ?> บาท/ปี
                            </td>
                        </tr>
                        <tr>
                            <th scope="col">กำไรสุทธิ</th>
                            <td scope="col">
                                <?php echo number_format($row["total"],0); ?> บาท/ปี
                            </td>
                        </tr>
                        <tr>
                            <th scope="col">ลักษณะการขาย</th>
                            <td scope="col">
                                <?php
                                    $sql = "
                                        SELECT 
                                            im.*,
                                            imk.item_market_name
                                        FROM income9_market im
                                            INNER JOIN item_market imk ON imk.item_market_id=im.item_market_id
                                        WHERE im.home_id='".$row["home_id"]."' 
                                            AND im.order_id='".$row["order_id"]."'
                                        ORDER BY imk.item_market_id
                                    ";
                                    $obj = $DATABASE->QueryObj($sql);
                                    foreach($obj as $k=>$v) {
                                        echo '<div>'.($k+1).'. '.$v["item_market_name"].'</div>';
                                    }
                                ?>
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
                        <th scope="col" class="text-center" style="min-width: 130px; width: 130px;">หน่วย</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>ผลิตภัณฑ์</td>
                        <td class="p-2" colspan="2">
                            <input type="text" class="form-control form-control-sm" id="product_name"
                                name="product_name" required>
                        </td>
                    </tr>
                    <tr>
                        <td>มูลค่าผลิตภัณฑ์ใช้ในครัวเรือน</td>
                        <td class="p-2">
                            <input type="tel" class="form-control form-control-sm text-right" id="kg1" name="kg1"
                                value="0" required>
                        </td>
                        <td class="text-center">บาท/ปี</td>
                    </tr>
                    <tr>
                        <td>มูลค่าผลิตภัณฑ์ขาย</td>
                        <td class="p-2">
                            <input type="tel" class="form-control form-control-sm text-right" id="kg2" name="kg2"
                                value="0" required>
                        </td>
                        <td class="text-center">บาท/ปี</td>
                    </tr>
                    <tr>
                        <td>รายได้รวม</td>
                        <td class="p-2">
                            <input type="tel" class="form-control form-control-sm text-right" id="income" name="income"
                                value="0" disabled>
                        </td>
                        <td class="text-center">บาท/ปี</td>
                    </tr>
                    <tr>
                        <td>ต้นทุนการผลิต</td>
                        <td class="p-2">
                            <input type="tel" class="form-control form-control-sm text-right" id="cost" name="cost"
                                value="0" required>
                        </td>
                        <td class="text-center">บาท/ปี</td>
                    </tr>
                    <tr>
                        <td>กำไรสุทธิ</td>
                        <td class="p-2">
                            <input type="tel" class="form-control form-control-sm text-right" id="total" name="total"
                                value="0" disabled>
                        </td>
                        <td class="text-center">บาท/ปี</td>
                    </tr>
                    <tr>
                        <td>ลักษณะการขาย</td>
                        <td class="p-2" colspan="2">
                            <?php
                                $sql = "SELECT * FROM item_market ORDER BY item_market_id";
                                $obj = $DATABASE->QueryObj($sql);
                                foreach($obj as $key=>$row) {
                            ?>
                            <div class="form-inline form-choose">
                                <div class="form-check mb-2 mr-sm-2">
                                    <input class="form-check-input" type="checkbox"
                                        id="item_market_id_<?php echo $key; ?>" name="item_market_id[]"
                                        value="<?php echo $row["item_market_id"]; ?>">
                                    <label class="form-check-label" for="item_market_id_<?php echo $key; ?>">
                                        <?php echo $row["item_market_id"]; ?>. <?php echo $row["item_market_name"]; ?>
                                    </label>
                                </div>
                            </div>
                            <?php } ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <input type="submit" class="submit d-none">
    </form>
</div>