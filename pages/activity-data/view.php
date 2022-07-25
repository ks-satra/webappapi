<?php
    $activity_id = @$_GET["activity_id"];
    $sql = "
        SELECT
            a.*,
            p.activity_id,
            p.activity_name,
            p.activity_money,
            p.activity_place,
            p.activity_process_id,
            p.activity_name_all,
            pt.activity_process_name,
            ap.activity_process_name,
            u.user_name,
            u.user_lname,
            ip.item_prefix_name
        FROM
            activity a
            INNER JOIN activity p ON a.activity_id = p.activity_id AND p.activity_id = '".$activity_id."'
            INNER JOIN activity_process pt ON p.activity_process_id = pt.activity_process_id
            INNER JOIN activity_process ap ON a.activity_process_id = ap.activity_process_id
            INNER JOIN user u ON a.user = u.user_id
            INNER JOIN item_prefix ip ON u.item_prefix_id = ip.item_prefix_id
        WHERE p.activity_id = '".$activity_id."'
    "; 
    $obj = $DATABASE->QueryObj($sql);
    if( sizeof($obj)!=1 ) {
        Back();
    }
    $data = $obj[0];
?>
<input type="hidden" id="data" value="<?php echo htmlspecialchars(json_encode($data)); ?>">
<div id="content-title">
    ข้อมูลกิจกรรม
</div>
<div id="content-body">
    <div class="row">
        <div class="col-md-12">
            <div class="mb-4 profile">
                <div class="row">
                    <div class="col-sm-4 col-md-3 col-lg-2 profile-left">ชื่อกิจกรรม</div>
                    <div class="col-sm-8 col-md-3 col-lg-4 profile-right">
                        <?php echo $data["activity_name"]; ?>
                    </div>
                    <div class="col-sm-4 col-md-3 col-lg-2 profile-left">งบประมาณ</div>
                    <div class="col-sm-8 col-md-3 col-lg-4 profile-right">
                        <?php echo $data["activity_money"]; ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 col-md-3 col-lg-2 profile-left">สถานที่</div>
                    <div class="col-sm-8 col-md-3 col-lg-4 profile-right">
                        <?php echo $data["activity_place"]; ?>
                    </div>
                    <div class="col-sm-4 col-md-3 col-lg-2 profile-left">ชื่อผู้รับผิดชอบโครงการ</div>
                    <div class="col-sm-8 col-md-3 col-lg-4 profile-right">
                        <?php echo $data["activity_name_all"]; ?>
                    </div>
                    <!-- <div class="col-sm-4 col-md-3 col-lg-2 profile-left">สถานะ</div>
                    <div class="col-sm-8 col-md-3 col-lg-4 profile-right">
                        <?php 
                            $status = array(
                                "Y"=>"<span data-status='N' class='btn-status text-success'><i class='fas fa-check mr-1'></i> ใช้งาน</span>",
                                "N"=>"<span data-status='Y' class='btn-status text-danger'><i class='fas fa-times mr-1'></i> ไม่ได้ใช้งาน</span>",
                            );
                            echo $status[$data["status"]]; 
                        ?>
                    </div> -->
                </div>
                <div class="row">
                    <div class="col-sm-4 col-md-3 col-lg-2 profile-left">วันที่อัพเดตล่าสุด</div>
                    <div class="col-sm-8 col-md-3 col-lg-4 profile-right">
                        <?php echo DateTh($data["date"]); ?> น.
                    </div>
                    <div class="col-sm-4 col-md-3 col-lg-2 profile-left">ผู้อัพเดตล่าสุด</div>
                    <div class="col-sm-8 col-md-3 col-lg-4 profile-right">
                        <?php echo $data["item_prefix_name"]; ?><?php echo $data["user_name"]; ?>
                        <?php echo $data["user_lname"]; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card text-center">
        <div class="card-header">
            ลบโครงการนี้
        </div>
        <div class="card-body">
            <button id="btn-del" class="btn btn-danger"><i class="fas fa-trash mr-1"></i> ลบโครงการนี้</button>
            <div class="p-4 text-danger" style="font-size: 16px;">หมายเหตุ !!! หากคุณลบข้อมูลกิจกรรมนี้ คุณจะไม่สามารถกู้คืนได้อีก</div>
        </div>
    </div>
</div>