<?php
    $sql = "
        SELECT 
            ie.*,
            e.amount,
            e.unit_id,
            e.total
        FROM item_expense1 ie
            LEFT JOIN expense1 e ON e.item_expense1_id=ie.item_expense1_id 
                AND e.home_id='".$home['home_id']."'
        ORDER BY ie.item_expense1_id
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
                <i class="fas fa-folder mr-2"></i> ค่าใช้จ่ายเพื่อการบริโภค
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr class="bg-light">
                            <th scope="col" style="min-width: 190px;">ประเภทค่าใช้จ่าย</th>
                            <th scope="col" class="text-center" style="min-width: 90px; width: 90px;">
                                จำนวนเงิน
                            </th>
                            <th scope="col" class="text-center" style="min-width: 100px; width: 100px;">หน่วย
                            </th>
                            <th scope="col" class="text-center" style="min-width: 100px; width: 100px;">รวมเป็นเงิน
                                (บาท/ปี)
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($ObjData as $key=>$row) {
                                $amount = isset($row["amount"]) ? $row["amount"] : "0";
                                $unit_id = isset($row["unit_id"]) ? $row["unit_id"] : "0";
                                $total = isset($row["total"]) ? $row["total"] : "0";
                                echo '
                                    <tr>
                                        <td>'.($key+1).'. '.$row["item_expense1_name"].'</td>
                                        <td class="p-2"><input type="tel" class="form-control form-control-sm" name="amount['.$row["item_expense1_id"].']" value="'.$amount.'" data-input-number="0"></td>
                                        <td class="p-2">
                                            <select class="form-control form-control-sm" name="unit_id['.$row["item_expense1_id"].']">
                                                <option value="1" '.(  ($row["unit_id"]=="1") ? 'selected' : ''  ).'>วัน</option>
                                                <option value="2" '.(  ($row["unit_id"]=="2") ? 'selected' : ''  ).'>เดือน</option>
                                                <option value="3" '.(  ($row["unit_id"]=="3") ? 'selected' : ''  ).'>ปี</option>
                                            </select>
                                        </td>
                                        <td class="p-2"><input type="tel" class="form-control form-control-sm text-right" name="total['.$row["item_expense1_id"].']" value="'.number_format($total,0).'" disabled></td>
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