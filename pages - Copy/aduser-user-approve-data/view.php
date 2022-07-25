<?php
    $user_id = @$_GET["user_id"];
    $sql = "
        SELECT
            u1.*, 
            ip.item_prefix_name
        FROM user_tmp u1
            INNER JOIN item_prefix ip ON ip.item_prefix_id = u1.item_prefix_id
        WHERE u1.user_id='".$user_id."'
    ";
    $obj = $DATABASE->QueryObj($sql);
    if( sizeof($obj)!=1 ) {
        Back();
    }
    $data = $obj[0];
?>
<input type="hidden" id="data" value="<?php echo htmlspecialchars(json_encode($data)); ?>">
<div id="content-title">
    อนุมัติผู้ใช้งานใหม่
</div>
<div id="content-body">
    <div class="row">
        <div class="col-md-2 text-center mb-5">
            <a class="d-block text-center m-auto" style="max-width: 200px;"
                href="./files/user-tmp/<?php echo $data["image"]; ?>" data-image-viewer>
                <img class="img-thumbnail w-100" src="./files/user-tmp/<?php echo $data["image"]; ?>"
                    alt="Profile Image" onerror="onError(this)">
            </a>
        </div>
        <div class="col-md-10">
            <div class="mb-4 profile">
                <div class="row">
                    <div class="col-sm-4 col-md-3 col-lg-2 profile-left">ชื่อ - นามสกุล</div>
                    <div class="col-sm-8 col-md-3 col-lg-4 profile-right">
                        <?php echo $data["item_prefix_name"]; ?><?php echo $data["user_name"]; ?>
                        <?php echo $data["user_name"]; ?>
                    </div>
                    <div class="col-sm-4 col-md-3 col-lg-2 profile-left">โทรศัพท์</div>
                    <div class="col-sm-8 col-md-3 col-lg-4 profile-right">
                        <?php echo $data["phone"]; ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 col-md-3 col-lg-2 profile-left">อีเมล</div>
                    <div class="col-sm-8 col-md-3 col-lg-4 profile-right">
                        <?php echo $data["email"]; ?>
                    </div>
                    <div class="col-sm-4 col-md-3 col-lg-2 profile-left">สถานะ</div>
                    <div class="col-sm-8 col-md-3 col-lg-4 profile-right">
                        <?php 
                            // $status = array(
                            //     "Y"=>"<span data-status='N' class='btn-status text-success'><i class='fas fa-check mr-1'></i> ใช้งาน</span>",
                            //     "N"=>"<span data-status='Y' class='btn-status text-danger'><i class='fas fa-times mr-1'></i> ไม่ได้ใช้งาน</span>",
                            // );
                            // echo $status[$data["status"]]; 
                        ?>
                        <span class='btn-status text-warning'><i class='fas fa-hourglass-half mr-1'></i>
                            รออนุมัติ</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 col-md-3 col-lg-2 profile-left">วันที่อัพเดตล่าสุด</div>
                    <div class="col-sm-8 col-md-9 col-lg-10 profile-right">
                        <?php echo DateTh($data["date"]); ?> น.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card text-center">
        <div class="card-header">
            ดำเนินการ
        </div>
        <div class="card-body">
            <button id="btn-approve" class="btn btn-success mr-2"><i class="fas fa-check mr-1"></i>
                อนุมัติผู้ใช้งานรายนี้</button>
            <button id="btn-del" class="btn btn-danger"><i class="fas fa-trash mr-1"></i> ลบผู้ใช้งานรายนี้</button>
        </div>
    </div>
</div>