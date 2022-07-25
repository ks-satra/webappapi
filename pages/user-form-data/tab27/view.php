<?php
    $sql = "
        SELECT 
            ih.*,
            h.num,
            h.income,
            h.total
        FROM item_help ih
            LEFT JOIN help h ON h.item_help_id=ih.item_help_id 
                AND h.home_id='".$home['home_id']."'
        ORDER BY ih.item_help_id
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
                <i class="fas fa-folder mr-2"></i> แหล่งเงินช่วยเหลือ
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr class="bg-light">
                            <th scope="col" style="min-width: 190px;">แหล่งเงินช่วยเหลือ</th>
                            <th scope="col" class="text-center" style="min-width: 90px; width: 90px;">
                                จำนวนผู้ได้รับเงิน (คน/ปี)
                            </th>
                            <th scope="col" class="text-center" style="min-width: 100px; width: 100px;">จำนวนเงิน
                                (บาท/ปี)
                            </th>
                            <th scope="col" class="text-center" style="min-width: 100px; width: 100px;">รวมเป็นเงิน
                                (บาท/ปี)
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($ObjData as $key=>$row) {
                                $num = isset($row["num"]) ? $row["num"] : "0";
                                $income = isset($row["income"]) ? $row["income"] : "0";
                                $total = isset($row["total"]) ? $row["total"] : "0";
                                echo '
                                    <tr>
                                        <td>'.($key+1).'. '.$row["item_help_name"].'</td>
                                        <td class="p-2"><input type="tel" class="form-control form-control-sm" name="num['.$row["item_help_id"].']" value="'.$num.'" data-input-number="0"></td>
                                        <td class="p-2"><input type="tel" class="form-control form-control-sm" name="income['.$row["item_help_id"].']" value="'.$income.'" data-input-number="0"></td>
                                        <td class="p-2"><input type="tel" class="form-control form-control-sm text-right" name="total['.$row["item_help_id"].']" value="'.number_format($total,0).'" disabled></td>
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