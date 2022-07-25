<div id="content-title">
    Dashboard
</div>
<div id="content-body">
    <h5>
        กำลังปรับปรุง Dashboard
    </h5>
    <!-- <div class="row mb-5">
        <div class="col-md-4 mb-3">
            <div class="card border-left-primary shadow h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <?php
                                $sql = "SELECT * FROM home WHERE status='1'";
                                $num = $DATABASE->QueryNumRow($sql);
                            ?>
                            <div class="text-xs text-primary text-uppercase mb-1" style="font-size: 26px;">แบบสอบถาม
                            </div>
                            <div class="text-xs text-muted text-uppercase mb-5" style="font-size: 20px;">ตรวจสอบแล้ว
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: 34px;">
                                <?php echo number_format($num, 0); ?> ชุด
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="card border-left-danger shadow h-100">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <?php
                                        $sql = "SELECT * FROM home WHERE status IN ('', '0')";
                                        $num = $DATABASE->QueryNumRow($sql);
                                    ?>
                                    <div class="text-xs text-danger text-uppercase mb-1">แบบสอบถาม</div>
                                    <div class="text-xs text-muted text-uppercase mb-4">ยังไม่ตรวจสอบ</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php echo number_format($num, 0); ?> ชุด
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar-times fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card border-left-success shadow h-100">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <?php
                                        $sql = "
                                            SELECT
                                                user.*
                                            FROM user
                                            WHERE user.user_id NOT IN (
                                                SELECT user_id FROM user_level WHERE level_id='1'
                                            ) AND user.user_id IN (
                                                SELECT user_id FROM user_area WHERE is_admin='N'
                                            )
                                        ";
                                        $numAasa = $DATABASE->QueryNumRow($sql);
                                        $sql = "
                                            SELECT
                                                user.*
                                            FROM user
                                            WHERE user.user_id NOT IN (
                                                SELECT user_id FROM user_level WHERE level_id='1'
                                            ) AND user.user_id IN (
                                                SELECT user_id FROM user_area WHERE is_admin='Y'
                                            )
                                        ";
                                        $numAdminAasa = $DATABASE->QueryNumRow($sql);
                                    ?>
                                    <div class="text-xs text-success text-uppercase mb-1">จำนวนอาสา</div>
                                    <div class="text-xs text-muted text-uppercase mb-4">ทั้งหมด</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php echo number_format($numAasa, 0); ?> คน
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user-friends fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card border-left-info shadow h-100">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <?php
                                        $date = date("Y-m-d");
                                        $sql = "SELECT * FROM home WHERE status!='2' AND date BETWEEN '".$date." 00:00' AND '".$date." 23:59' ";
                                        $num = $DATABASE->QueryNumRow($sql);
                                    ?>
                                    <div class="text-xs text-info text-uppercase mb-1">แบบสอบถาม</div>
                                    <div class="text-xs text-muted text-uppercase mb-4">เก็บวันนี้</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php echo number_format($num, 0); ?> ชุด
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar-day fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card border-left-warning shadow h-100">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <?php
                                        $date = date("Y-m-d", strtotime("-1 day"));
                                        $sql = "SELECT * FROM home WHERE status!='2' AND date BETWEEN '".$date." 00:00' AND '".$date." 23:59' ";
                                        $num = $DATABASE->QueryNumRow($sql);
                                    ?>
                                    <div class="text-xs text-warning text-uppercase mb-1">แบบสอบถาม</div>
                                    <div class="text-xs text-muted text-uppercase mb-4">เก็บเมื่อวาน</div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?php echo number_format($num, 0); ?> ชุด
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar-week fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-12">
            <h6 class="mb-3">รายงานจำนวนแบบสอบถามแต่ละพื้นที่</h6>
            <div class="table-responsive shadow p-3 border-left-primary">
                <table class="table table-bordered m-0">
                    <thead class="">
                        <tr>
                            <th rowspan="2" class="text-center" style="width: 60px;">ลำดับ</th>
                            <th rowspan="2" class="text-left" style="min-width: 200px;">พื้นที่</th>
                            <th rowspan="2" class="text-center" style="width: 120px;">จำนวนอาสา (คน)</th>
                            <th rowspan="2" class="text-center" style="width: 120px;">จำนวนแอดมินพื้นที่ (คน)</th>
                            <th colspan="3" class="text-center">จำนวนแบบสอบถาม (ชุด)</th>
                        </tr>
                        <tr>
                            <th class="text-center" style="width: 120px;">ทั้งหมด</th>
                            <th class="text-center" style="width: 120px;">ตรวจสอบแล้ว</th>
                            <th class="text-center" style="width: 120px;">ยังไม่ตรวจสอบ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql = "
                                SELECT
                                    province.province_name_thai,
                                    IFNULL(a1.num, 0) AS num1,
                                    IFNULL(a2.num, 0) AS num2,
                                    IFNULL(a5.num, 0) + IFNULL(a4.num, 0) AS num3,
                                    IFNULL(a4.num, 0) AS num4,
                                    IFNULL(a5.num, 0) AS num5
                                FROM area
                                    INNER JOIN province ON area.province_id = province.province_id
                                    LEFT JOIN (
                                        SELECT
                                            user_area.province_id,
                                            COUNT(*) AS num
                                        FROM user
                                            INNER JOIN user_area ON user_area.user_id=user.user_id AND is_admin='N'
                                        WHERE user.user_id NOT IN (
                                            SELECT user_id FROM user_level WHERE level_id='1'
                                        )
                                        GROUP BY user_area.province_id
                                    ) a1 ON a1.province_id=area.province_id
                                    LEFT JOIN (
                                        SELECT
                                            user_area.province_id,
                                            COUNT(*) AS num
                                        FROM user
                                            INNER JOIN user_area ON user_area.user_id=user.user_id AND is_admin='Y'
                                        WHERE user.user_id NOT IN (
                                            SELECT user_id FROM user_level WHERE level_id='1'
                                        )
                                        GROUP BY user_area.province_id
                                    ) a2 ON a2.province_id=area.province_id
                                    LEFT JOIN (
                                        SELECT 
                                            area_province_id,
                                            COUNT(*) AS num
                                        FROM home
                                        WHERE home.`status` IN ('1')
                                        GROUP BY home.area_province_id
                                    ) a4 ON a4.area_province_id=area.province_id
                                    LEFT JOIN (
                                        SELECT 
                                            area_province_id,
                                            COUNT(*) AS num
                                        FROM home
                                        WHERE home.`status` IN ('', '0')
                                        GROUP BY home.area_province_id
                                    ) a5 ON a5.area_province_id=area.province_id
                                ORDER BY province.province_name_thai
                            ";
                            $obj = $DATABASE->QueryObj($sql);
                            $num3 = 0;
                            $num5 = 0;
                            $num4 = 0;
                            foreach($obj as $key=>$row) {
                                $num3 += $row["num3"];
                                $num5 += $row["num5"];
                                $num4 += $row["num4"];
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $key+1; ?></td>
                            <td>จังหวัด<?php echo $row["province_name_thai"]; ?></td>
                            <td class="text-right"><?php echo number_format($row["num1"], 0); ?></td>
                            <td class="text-right"><?php echo number_format($row["num2"], 0); ?></td>
                            <td class="text-right"><?php echo number_format($row["num3"], 0); ?></td>
                            <td class="text-right"><?php echo number_format($row["num4"], 0); ?></td>
                            <td class="text-right"><?php echo number_format($row["num5"], 0); ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                    <tfooter>
                        <tr>
                            <td colspan="2" class="text-right font-weight-bold">รวมทั้งหมด</td>
                            <td class="text-right font-weight-bold"><?php echo number_format($numAasa, 0); ?></td>
                            <td class="text-right font-weight-bold"><?php echo number_format($numAdminAasa, 0); ?></td>
                            <td class="text-right font-weight-bold"><?php echo number_format($num3, 0); ?></td>
                            <td class="text-right font-weight-bold"><?php echo number_format($num4, 0); ?></td>
                            <td class="text-right font-weight-bold"><?php echo number_format($num5, 0); ?></td>
                        </tr>
                    </tfooter>
                </table>
            </div>
        </div>
    </div> -->
</div>