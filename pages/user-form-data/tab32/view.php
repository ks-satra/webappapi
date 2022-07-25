<?php
    $sql = "
        SELECT 
            ia.*,
            a.num,
            a.total
        FROM item_asset ia
            LEFT JOIN asset a ON a.item_asset_id=ia.item_asset_id 
                AND a.home_id='".$home['home_id']."'
        ORDER BY ia.item_asset_id
    ";
    $ObjData = $DATABASE->QueryObj($sql);
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
                <i class="fas fa-folder mr-2"></i> ทรัพย์สินสำหรับการประกอบอาชีพ
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr class="bg-light">
                            <th scope="col" style="min-width: 190px;">รายการทรัพย์สิน</th>
                            <th scope="col" class="text-center" style="min-width: 90px; width: 90px;">
                                จำนวน
                            </th>
                            <th scope="col" class="text-center" style="min-width: 100px; width: 100px;">หน่วย
                            </th>
                            <th scope="col" class="text-center" style="min-width: 100px; width: 100px;">รวมเป็นเงิน
                                (บาท)
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($ObjData as $key=>$row) {
                                $num = isset($row["num"]) ? $row["num"] : "0";
                                $total = isset($row["total"]) ? $row["total"] : "0";
                                echo '
                                    <tr>
                                        <td>'.($key+1).'. '.$row["item_asset_name"].'</td>
                                        <td class="p-2"><input type="tel" class="form-control form-control-sm" name="num['.$row["item_asset_id"].']" value="'.$num.'" data-input-number="0"></td>
                                        <td class="p-2 text-center">'.$row["unit"].'</td>
                                        <td class="p-2"><input type="tel" class="form-control form-control-sm" name="total['.$row["item_asset_id"].']" value="'.$total.'" data-input-number="0"></td>
                                    </tr>
                                ';
                            }
                        ?>
                    </tbody>
                </table>
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