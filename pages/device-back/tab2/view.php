<?php
    
?>
<div class="row">
    <div class="col-md-6">
        <?php
            $sql = "
                SELECT
                *
                FROM level
                ORDER BY level_id
            ";
            $obj = $DATABASE->QueryObj($sql);
            foreach($obj as $key=>$row) {
        ?>
        <div class="header1"><?php echo $row["level_name"]; ?></div>
        <div class="header2"><?php echo $row["level_desc"]; ?></div>
        <div class="sub-body">
            <?php
                $sql = "
                    SELECT
                        user.*
                    FROM user_level
                        INNER JOIN user ON user.user_id=user_level.user_id
                    WHERE user_level.level_id='".$row["level_id"]."'
                    ORDER BY user_level.date DESC
                ";
                $obj2 = $DATABASE->QueryObj($sql);
                foreach($obj2 as $key2=>$row2) {
                    echo '<div class="sub">'.($key2+1).'. '.$row2["user_name"].' '.$row2["user_lname"].'</div>';
                }
            ?>
        </div>
        <?php
            }
        ?>
    </div>
    <div class="col-md-6">
        <div class="header1">ผู้มีสิทธิ์การเข้าถึงพื้นที่จังหวัด</div>
        <select id="province_id" class="form-control form-control-sm mb-3">
            <?php
                $sql = "
                    SELECT 
                        province.*
                    FROM area
                        INNER JOIN province ON province.province_id=area.province_id
                    ORDER BY province.province_name_thai
                ";
                $obj = $DATABASE->QueryObj($sql);
                foreach($obj as $row) {
                    echo '<option value="'.$row["province_id"].'">'.$row["province_name_thai"].'</option>';
                }
            ?>
        </select>
        <div id="user-area">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>ลำดับ</th>
                        <th>ชื่อ-นามสกุล</th>
                        <th>สถานะ</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>
