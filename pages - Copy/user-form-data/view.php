<?php
    $tab = isset( $_GET["tab"] ) ? $_GET["tab"] : "1";
    $home_id = @$_GET["home_id"];

    $sql = "
        SELECT
            h.*,
            tambol.tambol_id, 
            tambol.tambol_name_thai, 
            tambol.latitude, 
            tambol.longitude, 
            tambol.zipcode, 
            amphur.amphur_id, 
            amphur.amphur_name_thai, 
            province.province_id, 
            province.province_name_thai
        FROM home h
            LEFT JOIN tambol ON h.tambol_id = tambol.tambol_id
            LEFT JOIN amphur ON h.amphur_id = amphur.amphur_id
            LEFT JOIN province ON h.province_id = province.province_id
        WHERE h.status IN ('0') 
            AND h.home_id='".$home_id."' 
            AND h.year_id='".$YEAR_ID."'
    ";
    $obj = $DATABASE->QueryObj($sql);
    if( sizeof($obj)!=1 ) {
        LinkTo("./?page=user-form");
    }
    $home = $obj[0];

    $sql = "SELECT * FROM form WHERE home_id='".$home_id."'";
    $obj = $DATABASE->QueryObj($sql);
    if( sizeof($obj)!=1 ) {
        LinkTo("./?page=user-form");
    }
    $form = $obj[0];
?>
<input type="hidden" id="home" value="<?php echo htmlspecialchars(json_encode($home)); ?>">
<div id="content-title">
    รายละเอียดแบบสำรวจ
    <div class="float-right">
        <div class="dropdown">
            <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButton"
                data-toggle="dropdown">
                <i class="fas fa-cogs"></i> ตั้งค่า
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item text-info" href="?page=alls-form-data-info&home_id=<?php echo $home_id; ?>"><i
                        class="fas fa-folder-open mr-2"></i>
                    เปิดดูรายละเอียด</a>
                <button class="dropdown-item text-danger" id="btn-del"><i class="fas fa-trash mr-2"></i>
                    ลบแบบสำรวจนี้ทั้งหมด</button>
                <!-- <button class="dropdown-item text-danger" id="btn-del-force"><i class="fas fa-trash mr-2"></i>
                    ลบแบบสำรวจนี้ทั้งหมดกู้ไม่ได้</button> -->
            </div>
        </div>
    </div>
</div>
<div id="content-body">
    <?php
        echo '
            <link href="pages/'.$PAGE.'/tab'.$tab.'/view.css?version='.$VERSION.'" rel="stylesheet">
            <script src="pages/'.$PAGE.'/tab'.$tab.'/view.js?version='.$VERSION.'"></script>
        ';
        include_once('pages/'.$PAGE.'/tab'.$tab.'/view.php');
    ?>
</div>