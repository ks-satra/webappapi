<?php
    $sql = "
        SELECT 
            mg.*
        FROM member_group mg
        WHERE mg.home_id='".$home['home_id']."' 
        ORDER BY mg.order_id
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
                <i class="fas fa-folder mr-2"></i> การเป็นสมาชิกกลุ่ม
            </div>

            <div>
                <?php
                    foreach($ObjData as $key=>$row) {
                ?>
                <table class="table table-bordered table-sm"
                    data-json="<?php echo htmlspecialchars(json_encode($row)); ?>">
                    <tbody>
                        <tr class="bg-light">
                            <th scope="col" style="width: 235px;">ลำดับที่</th>
                            <th scope="col"><?php echo $key+1; ?></th>
                        </tr>
                        <tr>
                            <th scope="col">ชื่อกองทุน/กลุ่ม</th>
                            <td scope="col">
                                <?php echo $row["fund_name"]; ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="col">ระยะเวลาการเป็นสมาชิก</th>
                            <td scope="col">
                                <?php echo number_format($row["year"],0); ?> ปี
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
                    เพิ่มสมาชิกกลุ่มใหม่
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
                        <td>ชื่อกองทุน/กลุ่ม</td>
                        <td class="p-2" colspan="2">
                            <input type="text" class="form-control form-control-sm" id="fund_name" name="fund_name"
                                required>
                        </td>
                    </tr>
                    <tr>
                        <td>ระยะเวลาการเป็นสมาชิก </td>
                        <td class="p-2">
                            <input type="tel" class="form-control form-control-sm text-right" id="year" name="year"
                                value="0" required>
                        </td>
                        <td class="text-center">ปี</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <input type="submit" class="submit d-none">
    </form>
</div>