<?php
    $sql = "
        SELECT 
            iio.*,
            i.total
        FROM item_income_other iio
            LEFT JOIN income12 i ON i.item_income_other_id=iio.item_income_other_id 
                AND i.home_id='".$home['home_id']."'
        ORDER BY iio.item_income_other_id
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
                <i class="fas fa-folder mr-2"></i> รายได้จากแหล่งรายได้อื่น
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr class="bg-light">
                            <th scope="col" style="min-width: 200px;">แหล่งรายได้</th>
                            <th scope="col" class="text-center" style="min-width: 125px; width: 125px;">รายได้ (บาท/ปี)
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($ObjData as $key=>$row) {
                                $total = isset($row["total"]) ? $row["total"] : "0";
                                echo '
                                    <tr>
                                        <td>'.($key+1).'. '.$row["item_income_other_name"].'</td>
                                        <td class="p-2"><input type="tel" class="form-control form-control-sm" name="total['.$row["item_income_other_id"].']" value="'.$total.'" data-input-number="0"></td>
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