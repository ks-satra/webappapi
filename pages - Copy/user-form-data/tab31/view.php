<?php
    $sql = "
        SELECT 
            idb.*,
            d.total
        FROM item_debt_borrow idb
            LEFT JOIN debt d ON d.item_debt_borrow_id=idb.item_debt_borrow_id 
                AND d.home_id='".$home['home_id']."'
        ORDER BY idb.item_debt_borrow_id
    ";
    $ObjData = $DATABASE->QueryObj($sql);

    $sql = "
        SELECT 
            idp.*
        FROM item_debt_purpose idp
        ORDER BY idp.item_debt_purpose_id
    ";
    $ObjItemDabtPurpose = $DATABASE->QueryObj($sql);
    $sql = "
        SELECT 
            dp.*
        FROM debt_purpose dp
        WHERE dp.home_id='".$home['home_id']."'
    ";
    $ObjDebtPurpost = $DATABASE->QueryObj($sql);
    function GetPurpose($item_debt_borrow_id, $item_debt_purpose_id) {
        global $ObjDebtPurpost;
        foreach($ObjDebtPurpost as $k=>$v) {
            if( $item_debt_borrow_id==$v["item_debt_borrow_id"] 
                && $item_debt_purpose_id==$v["item_debt_purpose_id"] ) return true;
        }
        return false;
    }
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
                <i class="fas fa-folder mr-2"></i> หนี้สิน
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr class="bg-light">
                            <th scope="col" style="min-width: 190px;">แหล่งกู้ยืม</th>
                            <th scope="col" class="text-center" style="min-width: 107px; width: 107px;">
                                จำนวนหนี้สิน
                            </th>
                            <th scope="col" class="text-center" style="min-width: 200px; width: 200px;">
                                วัตถุประสงค์ในการกู้
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach($ObjData as $key=>$row) {
                                $total = isset($row["total"]) ? $row["total"] : "0";
                                $purpose = '';
                                foreach($ObjItemDabtPurpose as $k=>$r) {
                                    $checked = (GetPurpose($row["item_debt_borrow_id"], $r["item_debt_purpose_id"])) ? "checked" : "";
                                    $purpose .= '
                                        <div class="form-inline form-choose">
                                            <div class="form-check mb-2 mr-sm-2">
                                                <input class="form-check-input" type="checkbox" 
                                                    id="item_contagious_id_'.$row["item_debt_borrow_id"].'_'.$k.'" 
                                                    name="item_debt_purpose_id['.$row["item_debt_borrow_id"].'][]" 
                                                    value="'.$r["item_debt_purpose_id"].'" '.$checked.'>
                                                <label class="form-check-label" for="item_contagious_id_'.$row["item_debt_borrow_id"].'_'.$k.'">
                                                '.$r["item_debt_purpose_id"].'. 
                                                '.$r["item_debt_purpose_name"].'
                                                </label>
                                            </div>
                                        </div>
                                    ';
                                }
                                echo '
                                    <tr>
                                        <td>'.($key+1).'. '.$row["item_debt_borrow_name"].'</td>
                                        <td class="p-2"><input type="tel" class="form-control form-control-sm" name="total['.$row["item_debt_borrow_id"].']" value="'.$total.'" data-input-number="0"></td>
                                        <td class="p-2">
                                            '.$purpose.'
                                        </td>
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