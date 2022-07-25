<?php
    $project_id = @$_GET["project_id"];
    $sql = "
        SELECT 
            project.*,
            project_type.project_type_name,
            item_prefix.item_prefix_name,
            user.user_name,
            user.user_lname
        FROM project
            INNER JOIN project_type ON project_type.project_type_id=project.project_type_id
            INNER JOIN user ON user.user_id=project.user
            INNER JOIN item_prefix ON item_prefix.item_prefix_id=user.item_prefix_id
        WHERE project.project_id='".$project_id."'
    "; 
    $obj = $DATABASE->QueryObj($sql);
    if( sizeof($obj)!=1 ) {
        Back();
    }
    $data = $obj[0];
?>
<input type="hidden" id="data" value="<?php echo htmlspecialchars(json_encode($data)); ?>">
<div id="content-title">
    ข้อมูลโครงการ
</div>
<div id="content-body">
    <div class="row">
        <div class="col-md-12">
            <div class="mb-4 profile">
                <div class="row">
                    <div class="col-sm-4 col-md-3 col-lg-2 profile-left">ชื่อโครงการ</div>
                    <div class="col-sm-8 col-md-3 col-lg-4 profile-right">
                        <?php echo $data["project_name"]; ?>
                    </div>
                    <div class="col-sm-4 col-md-3 col-lg-2 profile-left">งบประมาณ</div>
                    <div class="col-sm-8 col-md-3 col-lg-4 profile-right">
                        <?php echo $data["project_money"]; ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 col-md-3 col-lg-2 profile-left">สถานที่</div>
                    <div class="col-sm-8 col-md-3 col-lg-4 profile-right">
                        <?php echo $data["project_place"]; ?>
                    </div>
                    <div class="col-sm-4 col-md-3 col-lg-2 profile-left">ชื่อผู้รับผิดชอบโครงการ</div>
                    <div class="col-sm-8 col-md-3 col-lg-4 profile-right">
                        <?php echo $data["project_name_all"]; ?>
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

    <div class="mb-3">
        ข้อมูลสิทธิ์การเข้าถึงแต่ละพื้นที่
    </div>
    <div class="mb-5">
        <table class="table">
            <?php
                $sql = "
                    SELECT 
                        p.province_id,
                        p.province_name_thai,
                        ua2.user_id,
                        ua2.is_admin
                    FROM user_area ua
                        INNER JOIN province p ON p.province_id=ua.province_id
                        LEFT JOIN user_area ua2 ON ua2.province_id=ua.province_id AND ua2.user_id='".$user_id."'
                    WHERE ua.user_id='".$USER["user_id"]."' AND ua.is_admin='Y'
                ";
                $obj = $DATABASE->QueryObj($sql);
                if( sizeof($obj)==0 ) {
                    echo '<tr><td>ไม่พบข้อมูลพื้นที่</td></tr>';
                } else {
                    foreach($obj as $key=>$row) {
                        $checked = ($row["user_id"]==$user_id) ? "checked" : "";
                        $checked2 = ($row["is_admin"]=="Y") ? "checked" : "";
                        echo '
                            <tr>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="area-'.$row["province_id"].'" value="'.$row["province_id"].'" '.$checked.' disabled>
                                        <label class="custom-control-label" for="area-'.$row["province_id"].'">'.$row["province_name_thai"].'</label>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="area1-'.$row["province_id"].'" '.$checked.' disabled>
                                        <label class="custom-control-label" for="area1-'.$row["province_id"].'">อาสาเก็บข้อมูล</label>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="area2-'.$row["province_id"].'" value="'.$row["province_id"].'" '.$checked2.' disabled>
                                        <label class="custom-control-label" for="area2-'.$row["province_id"].'">แอดมิน</label>
                                    </div>
                                </td>
                            </tr>
                        ';
                    }
                }
            ?>
        </table>
    </div>
    <div class="card text-center">
        <div class="card-header">
            ลบผู้ใช้งาน
        </div>
        <div class="card-body">
            <button id="btn-del" class="btn btn-danger"><i class="fas fa-trash mr-1"></i> ลบผู้ใช้งานรายนี้</button>
            <div class="p-4 text-danger" style="font-size: 16px;">คำเตือน !!! หากคุณลบผู้ใช้งานรายนี้
                ผู้ใช้งานรายนี้จะไม่สามารถใช้งานได้ และไม่สามารถทำการกู้กลับมาใช้งานอีกได้อีกต่อไป</div>
        </div>
    </div>
</div>