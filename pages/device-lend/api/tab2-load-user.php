<?php
    include_once("../../../php/autoload.php");

    if( $USER==null ) {
        echo json_encode(array(
            "status"=>false,
            "message"=>"Session การเข้าสู่ระบบหมดอายุ กรุณาเข้าสู่ระบบใหม่อีกครั้ง"
        ));
        exit();
    }
    $p = @$_GET["p"]*1; if($p==0) $p = 1;
    $province_id = $_GET["province_id"];

    $sql = "
        SELECT
            user_area.*,
            user.user_name,
            user.user_lname
        FROM user_area
            INNER JOIN user ON user.user_id = user_area.user_id
        WHERE user_area.province_id='".$province_id."'
        ORDER BY user_area.date DESC
    ";
    $show = $GLOBAL["SHOW"];
    $all = sizeof( $DATABASE->QueryObj($sql) );
    $p_all = ceil( $all/$show );
    $start = ($p-1)*$show;
    $objData = $DATABASE->QueryObj($sql." LIMIT ".$start.", ".$show);
?>
<table class="table table-sm table-bordered">
    <thead>
        <tr>
            <th class="text-center" style="width: 60px;">ลำดับ</th>
            <th class="">ชื่อ-นามสกุล</th>
            <th class="text-center" style="width: 100px;">สถานะ</th>
        </tr>
    </thead>
    <tbody>
        <?php
            if( sizeof($objData)==0 ) {
                echo '
                    <tr>
                        <td colspan="5" class="text-center">
                            ไม่พบรายการ
                        </td>
                    </tr>
                ';
            }
            foreach($objData as $key=>$row) {
                $status = array(
                    "Y"=>"แอดมิน",
                    "N"=>"อาสา"
                );
                echo '
                    <tr data-json="'.htmlspecialchars(json_encode($row)).'">
                        <th class="text-center order">'.(($show*($p-1))+($key+1)).'</th>
                        <td class="text-left">'.$row["user_name"].' '.$row["user_lname"].'</td>
                        <td class="text-center">'.$status[$row["is_admin"]].'</td>
                    </tr>
                ';
            }
        ?>
    </tbody>
</table>