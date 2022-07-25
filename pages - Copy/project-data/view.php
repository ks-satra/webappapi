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
        ข้อมูลกิจกรรมทั้งหมด
    </div>
    <div class="mb-5">
        <table class="table"><thead>
            <tr>
                <th scope="col" class="text-center">#</th>
                <th scope="col">ชื่อโครงการ</th>
                <th scope="col" class="">ชื่อกิจกรรม</th>
                <th scope="col" class="text-center">งบประมาณ</th>
                <th scope="col" class="text-center">ผู้รับผิดชอบกิจกรรม</th>
                <th scope="col" class="text-center">สถานะ</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php
                $sql = "
                    SELECT
                        a.*,
                        p.project_id,
                        p.project_name,
                        p.project_money,
                        p.project_place,
                        p.project_type_id,
                        p.project_name_all,
                        pt.project_type_name,
                        ap.activity_process_name
                    FROM
                        activity a
                        INNER JOIN project p ON a.project_id = p.project_id AND p.project_id = '".$data["project_id"]."'
                        INNER JOIN project_type pt ON p.project_type_id = pt.project_type_id
                        INNER JOIN activity_process ap ON a.activity_process_id = ap.activity_process_id
                    WHERE p.project_id = '".$data["project_id"]."'
                    ";
                $obj = $DATABASE->QueryObj($sql);
                if( sizeof($obj)==0 ) {
                    echo '<tr><td>ไม่พบข้อมูลพื้นที่</td></tr>';
                } else {
                    foreach($obj as $key=>$row) {
                        $status_ext = array(
                            "1"=>'<span class="text-success"><i class="fas fa-check"></i> ดำเนินการ</span>',
                            "2"=>'<span class="text-danger"><i class="fas fa-times"></i> ยังไม่ได้ดำเนินการแล้ว</span>'
                        );
                        echo '
                            <tr>
                                <th class="text-center order">'.($key+1).'</th>
                                <td>
                                    <div class="custom-control">
                                        <label>'.$row["project_name"].'</label>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control">
                                        <label>'.$row["activity_name"].'</label>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control">
                                        <label>'.$row["activity_money"].'</label>
                                    </div>
                                </td>
                                <td>
                                    <div class="custom-control">
                                        <label>'.$row["activity_name"].'</label>
                                    </div>
                                </td>
                                <td class="text-center">'.$status_ext[$row["activity_process_id"]].'</td>
                            </tr>
                        ';
                    }
                }
            ?>
        </tbody>
        </table>
    </div>
    <div class="card text-center">
        <div class="card-header">
            ลบโครงการนี้
        </div>
        <div class="card-body">
            <button id="btn-del" class="btn btn-danger"><i class="fas fa-trash mr-1"></i> ลบโครงการนี้</button>
            <div class="p-4 text-danger" style="font-size: 16px;">หมายเหตุ !!! คุณไม่สามารถลบโครงการนี้ได้ 
             หากมีข้อมูลกิจกรรม คุณจะต้องลบข้อมูลกิจกรรมก่อน</div>
        </div>
    </div>
</div>