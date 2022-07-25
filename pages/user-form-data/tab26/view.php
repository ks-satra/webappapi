<?php
    $sql = "
        SELECT 
            `is`.*,
            s.total
        FROM item_saving `is`
            LEFT JOIN saving s ON s.item_saving_id=`is`.item_saving_id 
                AND s.home_id='".$home['home_id']."'
        ORDER BY `is`.item_saving_id
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
                <i class="fas fa-folder mr-2"></i> เงินออม
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr class="bg-light">
                            <th scope="col" style="min-width: 200px;">ประเภทเงินออม</th>
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
                                        <td>'.($key+1).'. '.$row["item_saving_name"].'</td>
                                        <td class="p-2"><input type="tel" class="form-control form-control-sm" name="total['.$row["item_saving_id"].']" value="'.$total.'" data-input-number="0"></td>
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