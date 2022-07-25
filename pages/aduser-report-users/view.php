<?php
    $sql = "
        SELECT
            user_area.*,
            province.*
        FROM user_area
            INNER JOIN province ON province.province_id=user_area.province_id
        WHERE user_id='1'
    ";
    $objProvince = $DATABASE->QueryObj($sql);
    $province_id = isset($_GET["province_id"]) ? $_GET["province_id"] : $objProvince[0]["province_id"];
    $type = isset($_GET["type"]) ? $_GET["type"] : "all";
    $date = isset($_GET["date"]) ? $_GET["date"] : date("Y-m-d");
    $condition_type = "";
    if( $type=="date" ) {
        $condition_type = " AND `date` LIKE '".$date."%' ";
    }
    $sql = "
        SELECT
            u.user_name,
            u.user_lname,
            IFNULL(a.num, 0) AS num1,
            IFNULL(b.num, 0) AS num2,
            IFNULL(c.num, 0) AS num3,
            ua.is_admin
        FROM `user` u
            INNER JOIN user_area ua ON ua.user_id=u.user_id
            LEFT JOIN ( SELECT `user`, COUNT(*) AS num FROM home WHERE `status`='2' AND area_province_id='".$province_id."' ".$condition_type." GROUP BY `user` ) AS a ON a.`user`=u.user_id
            LEFT JOIN ( SELECT `user`, COUNT(*) AS num FROM home WHERE `status`='1' AND area_province_id='".$province_id."' ".$condition_type." GROUP BY `user` ) AS b ON b.`user`=u.user_id
            LEFT JOIN ( SELECT `user`, COUNT(*) AS num FROM home WHERE `status`='0' AND area_province_id='".$province_id."' ".$condition_type." GROUP BY `user` ) AS c ON c.`user`=u.user_id
        WHERE ua.province_id='".$province_id."'
        ORDER BY u.date DESC
    ";
    $objData = $DATABASE->QueryObj($sql);
?>
<div id="content-title">
    จำนวนผู้บันทึกแบบสำรวจ
    <small>ในพื้นที่ดูแลของฉัน</small>
</div>
<div id="content-body">
    <div class="report-body">
        <div class="form-inline mb-3">
            <label class="mr-3" for="area_province_id">พื้นที่ดูแล</label>
            <select class="custom-select mr-3" id="area_province_id">
                <?php
                    foreach($objProvince as $row) {
                        $selected = ($province_id==$row["province_id"]) ? "selected": "";
                        echo '<option value="'.$row["province_id"].'" '.$selected.'>'.$row["province_name_thai"].'</option>';
                    }
                ?>
            </select>
            <div class="custom-control custom-radio mr-3">
                <input type="radio" id="type-all" name="type" value="all" class="custom-control-input"
                    <?php if($type=="all") echo 'checked'; ?>>
                <label class="custom-control-label" for="type-all">ทั้งหมด</label>
            </div>
            <div class="custom-control custom-radio mr-3">
                <input type="radio" id="type-date" name="type" value="date" class="custom-control-input"
                    <?php if($type=="date") echo 'checked'; ?>>
                <label class="custom-control-label" for="type-date">ระบุวันที่</label>
            </div>
            <input type="text" class="form-control" id="date" data-datepicker value="<?php echo DateTh($date); ?>"
                <?php if($type!="date") echo 'disabled'; ?>>
        </div>
        <table class="table table-bordered table-hover">
            <thead>
                <tr class="table-active">
                    <th class="text-center" rowspan="2" style="width: 70px;">ลำดับ</th>
                    <th class="text-center" rowspan="2">ผู้บันทึกแบบสำรวจ</th>
                    <th class="text-center" rowspan="2">สถานะ</th>
                    <th class="text-center" colspan="4">จำนวนแบบสำรวจที่บันทึก (รายการ)</th>
                </tr>
                <tr class="table-active">
                    <th class="text-center" style="width: 120px;">ตรวจสอบแล้ว</th>
                    <th class="text-center" style="width: 120px;">รอตรวจสอบ</th>
                    <th class="text-center" style="width: 120px;">รอส่งหัวหน้า</th>
                    <th class="text-center" style="width: 120px;">รวมทั้งหมด</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sum_all = array(
                        "num1"=>0,
                        "num2"=>0,
                        "num3"=>0,
                    );
                    $sum_total = 0;
                    foreach($objData as $key=>$row) {
                        $sum = $row["num1"]*1 + $row["num2"]*1 + $row["num3"]*1;
                        $sum_all["num1"] += $row["num1"]*1;
                        $sum_all["num2"] += $row["num2"]*1;
                        $sum_all["num3"] += $row["num3"]*1;
                        $sum_total += $sum;
                        $status = array(
                            "Y"=>"แอดมิน",
                            "N"=>"อาสา"
                        );
                ?>
                <tr>
                    <td class="text-center"><?php echo ($key+1); ?></td>
                    <td class="desc"><?php echo $row["user_name"]; ?> <?php echo $row["user_lname"]; ?></td>
                    <td class="text-center"><?php echo $status[$row["is_admin"]]; ?></td>
                    <td class="amount"><?php echo ($row["num1"]!="0") ? number_format($row["num1"], 0) : "-"; ?></td>
                    <td class="amount"><?php echo ($row["num2"]!="0") ? number_format($row["num2"], 0) : "-"; ?></td>
                    <td class="amount"><?php echo ($row["num3"]!="0") ? number_format($row["num3"], 0) : "-"; ?></td>
                    <td class="amount font-weight-bold"><?php echo ($sum!=0) ? number_format($sum, 0) : "-"; ?></td>
                </tr>
                <?php
                    }
                ?>
                <tr class="table-active">
                    <td class="text-center font-weight-bold" colspan="3">รวมทั้งหมด</td>
                    <td class="amount font-weight-bold">
                        <?php echo ($sum_all["num1"]!=0) ? number_format($sum_all["num1"], 0) : "-"; ?></td>
                    <td class="amount font-weight-bold">
                        <?php echo ($sum_all["num2"]!=0) ? number_format($sum_all["num2"], 0) : "-"; ?></td>
                    <td class="amount font-weight-bold">
                        <?php echo ($sum_all["num3"]!=0) ? number_format($sum_all["num3"], 0) : "-"; ?></td>
                    <td class="amount font-weight-bold">
                        <?php echo ($sum_total!=0) ? number_format($sum_total, 0) : "-"; ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>