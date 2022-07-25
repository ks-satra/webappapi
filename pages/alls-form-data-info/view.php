<?php
    $home_id = @$_GET["home_id"];

    $sql = "
        SELECT
            h.*,
            id.item_domination_name,
            t.tambol_id, 
            t.tambol_name_thai, 
            t.latitude, 
            t.longitude, 
            t.zipcode, 
            a.amphur_id, 
            a.amphur_name_thai, 
            p.province_id, 
            p.province_name_thai,
            ip.item_prefix_name AS owner_prefix_name,
            ip2.item_prefix_name AS informant_prefix_name,
            ip3.item_prefix_name AS user_prefix_name,
            u.user_name,
            u.user_lname,
            u.phone
        FROM home h
            LEFT JOIN item_domination id ON id.item_domination_id = h.item_domination_id
            LEFT JOIN tambol t ON h.tambol_id = t.tambol_id
            LEFT JOIN amphur a ON h.amphur_id = a.amphur_id
            LEFT JOIN province p ON h.province_id = p.province_id
            LEFT JOIN item_prefix ip ON ip.item_prefix_id = h.owner_prefix_id
            LEFT JOIN item_prefix ip2 ON ip2.item_prefix_id = h.informant_prefix_id
            LEFT JOIN user u ON u.user_id = h.user
            LEFT JOIN item_prefix ip3 ON ip3.item_prefix_id = u.item_prefix_id
        WHERE h.status!='2' 
            AND h.home_id='".$home_id."' 
            AND h.year_id='".$YEAR_ID."'
    ";
    $obj = $DATABASE->QueryObj($sql);
    if( sizeof($obj)!=1 ) {
        Back();
    }
    $home = $obj[0];

    $sql = "
        SELECT 
            f.*,
            ip1.item_prefix_name AS staff1_prefix_name,
            ip2.item_prefix_name AS staff2_prefix_name,
            ip3.item_prefix_name AS staff3_prefix_name
        FROM form f
            LEFT JOIN item_prefix ip1 ON ip1.item_prefix_id = f.staff1_prefix_id
            LEFT JOIN item_prefix ip2 ON ip2.item_prefix_id = f.staff2_prefix_id
            LEFT JOIN item_prefix ip3 ON ip3.item_prefix_id = f.staff3_prefix_id
        WHERE f.home_id='".$home_id."'
    ";
    $obj = $DATABASE->QueryObj($sql);
    if( sizeof($obj)!=1 ) {
        LinkTo("./?page=user-form");
    }
    $form = $obj[0];
    function Ch($ch, $val) {
        global $form;
        if( $form[$ch]==$val ) return '<span class="color-answer">/</span>';
        return "&nbsp;";
    }
?>
<style>
#document {
    padding: 0px;
    margin: 0px;
    line-height: 1.3em;
    font-size: 12px;
}

.tb {
    font-size: 12px;
    width: 100%;
    line-height: 1.3em;
}

.text-success {
    color: #28a745;
}

.text-danger {
    color: #dc3545;
}

.text-warning {
    color: #ffc107;
}

.text-info {
    color: #17a2b8;
}

.text-left {
    text-align: left;
}

.text-center {
    text-align: center;
}

.text-right {
    text-align: right;
}

.text-bold {
    font-weight: bold;
}

.dotted {
    border-bottom: 2px dotted #000;
}

.wp-100 {
    width: 100%;
}

.wp-50 {
    width: 50%;
}

.text-underline {
    text-decoration: underline;
}

.doc-head {
    background-color: #ffd65d;
    padding: 6px;
    font-size: 12px;
    font-weight: bold;
    text-align: center;
    border-top: 1px solid #000;
}

.doc-sub-head {
    background-color: #ffcbf7;
    padding: 6px;
    font-size: 12px;
    font-weight: bold;
    border-top: 1px solid #000;
    border-bottom: 1px solid #000;
}

.doc-body {}

.answer {
    border-bottom: 1px dotted #000;
    text-align: center;
    color: #4550d1;
}

.color-answer {
    color: #4550d1;
}

.ch {
    font-family: 'Courier New', monospace;
    font-size: 18px;
}

.bg-light {
    background-color: #f8f9fa !important;
}

<?php for($i=1; $i<=200; $i++) {
    echo '.size-'.$i.' { font-size: '.$i.'px; }';
    echo '.pd-'.$i.' { padding: '.$i.'px; }';
    echo '.pdt-'.$i.' { padding-top: '.$i.'px; }';
    echo '.pdr-'.$i.' { padding-right: '.$i.'px; }';
    echo '.pdb-'.$i.' { padding-bottom: '.$i.'px; }';
    echo '.pdl-'.$i.' { padding-left: '.$i.'px; }';
    echo '.mg-'.$i.' { margin: '.$i.'px; }';
    echo '.mgt-'.$i.' { margin-top: '.$i.'px; }';
    echo '.mgr-'.$i.' { margin-right: '.$i.'px; }';
    echo '.mgb-'.$i.' { margin-bottom: '.$i.'px; }';
    echo '.mgl-'.$i.' { margin-left: '.$i.'px; }';
    echo '.line-height-'.$i.' { line-height: '.$i.'px; }';
}

for($i=1; $i<=400; $i++) {
    echo '.wd-'.$i.' { width: '.$i.'px; }';
}

?>
</style>
<input type="hidden" id="home_id" value="<?php echo $home_id; ?>">
<div id="content-title">
    รายละเอียดแบบสอบถาม
</div>
<div id="content-body">
    <div class="mb-3">
        <button class="btn btn-light" onclick="Back()"><i class="fas fa-arrow-left"></i> ย้อนกลับ</button>
        <button class="btn btn-light" id="btn-load">
            <i class="fas fa-download"></i>
            โหลดแบบสำรวจ
        </button>
        <?php
            /////////// แสดงปุ่มลิงก์ไปยังหน้าแก้ไข ////////////
            if($home["status"]=="0" && $home["user"]==$USER["user_id"]) { 
                echo '
                    <a href="./?page=user-form-data&home_id='.$home_id.'" class="btn btn-warning"><i class="fas fa-pen mr-1"></i> แก้ไข</a>
                ';
            }
            /////////// แสดงปุ่มส่งแบบสำรวจ ////////////
            $sql = "SELECT * FROM form_step WHERE home_id='".$home_id."' ";
            $objStep = $DATABASE->QueryObj($sql);
            if($home["status"]=="0" && $home["user"]==$USER["user_id"] && sizeof($objStep)==36) { 
                echo '
                    <button class="btn btn-success" id="btn-send">ส่งแบบสำรวจ <i class="fas fa-paper-plane"></i></button>
                ';
            }
            /////////// แสดงปุ่มส่งกลับแก้ไข ////////////
            if( $home["status"]=="1" && $USER["level"]["area-admin"]=="Y" ) {
                $sql = "
                    SELECT 
                        ua.* 
                    FROM user_area ua 
                    WHERE ua.user_id='".$USER["user_id"]."' 
                        AND ua.province_id='".$home["area_province_id"]."' 
                        AND ua.is_admin='Y'
                ";
                $obj = $DATABASE->QueryObj($sql);
                if( sizeof($obj)!=0 ) {
                    echo '
                        <button class="btn btn-warning" id="btn-revert">
                            <i class="fas fa-history"></i>
                            ส่งกลับแก้ไข
                        </button>
                    ';
                }
            }
            /////////// แสดงปุ่มข้อความและปุ่มตอบรับการแก้ไข ////////////
            function ChkUserApprove() {
                global $DATABASE, $home, $USER;
                if( $USER["level"]["area-admin"]=="Y" ) {
                    $sql = "
                        SELECT 
                            ua.* 
                        FROM user_area ua 
                        WHERE ua.user_id='".$USER["user_id"]."' 
                            AND ua.province_id='".$home["area_province_id"]."' 
                            AND ua.is_admin='Y'
                    ";
                    $obj = $DATABASE->QueryObj($sql);
                    if( sizeof($obj)!=0 ) return true;
                }
                return false;
            }
            $UserApprover = ChkUserApprove();
            if( $home["status"]=="" && ($home["user"]==$USER["user_id"] || $UserApprover) ) {
                $sql = "SELECT comment FROM revert_comment WHERE home_id='".$home_id."' ORDER BY revert_comment_id DESC ";
                $comment = $DATABASE->QueryString($sql);
                $message = ($home["user"]==$USER["user_id"]) ? 'ที่คุณได้บันทึก
                หัวหน้าของคุณได้ทำการตรวจสอบแล้วมีข้อผิดพลาดและส่งกลับให้คุณทำการแก้ไขใหม่ เนื่องจาก' : 'ถูกส่งกลับแก้ไขแล้ว เนื่องจาก';
                $btn = ($home["user"]==$USER["user_id"]) ? '<button id="btn-edit" class="btn btn-success">ตอบรับการแก้ไข</button>' : '';
                echo '
                    <div class="card border-warning mt-3 mb-4">
                        <h6 class="card-header border-warning">
                            <i class="fas fa-exclamation-triangle text-warning"></i>
                            แจ้งเตือนส่งกลับแก้ไข
                        </h6>
                        <div class="card-body">
                            <p class="card-text">แบบสำรวจหมายเลข <b>'.$home["form_code"].'</b> '.$message.'</p>
                            <p class="text-danger"><b>'.nl2br($comment).'</b></p>
                            '.$btn.'
                        </div>
                    </div>
                ';
            }
        ?>

    </div>
    <?php 
        // PrintData($ROOT_URL);
    ?>
    <div style="">
        <div id="document" style="padding-bottom:30px;">
            <?php 
                include("pdf/all/section1.php");
                include("pdf/all/section2.php");
                include("pdf/all/section3.php");
                include("pdf/all/section4.php");
                include("pdf/all/section5.php");
                include("pdf/all/section6.php");
                include("pdf/all/section7.php");
                include("pdf/all/section8.php");
                include("pdf/all/section9.php");
                include("pdf/all/section10.php");
                include("pdf/all/section11.php");
                include("pdf/all/section12.php");
                include("pdf/all/section13.php");
                include("pdf/all/section14.php");
                include("pdf/all/section15.php");
                include("pdf/all/section16.php");
                include("pdf/all/section17.php");
                include("pdf/all/section18.php");
                include("pdf/all/section19.php");
                include("pdf/all/section20.php");
                include("pdf/all/section21.php");
                include("pdf/all/section22.php");
                include("pdf/all/section23.php");
                include("pdf/all/section24_25.php");
                include("pdf/all/section26_27.php");
                include("pdf/all/section28_29.php");
                include("pdf/all/section30_31.php");
                include("pdf/all/section32.php");
                include("pdf/all/section33.php");
                include("pdf/all/section34.php");
                include("pdf/all/section35.php");
                include("pdf/all/section36.php");
            ?>
        </div>
    </div>
</div>