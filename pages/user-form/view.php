<?php
    $p = @$_GET["p"]*1; if($p==0) $p = 1;
    $search = @$_GET["search"];
    $condition_search = "";
    if( $search!="" ) {
        $condition_search .= " AND (
            h.form_code='".$search."'
            OR h.home_code='".$search."'
            OR h.village_name LIKE '%".$search."%'
            OR h.home_no LIKE '%".$search."%'
            OR h.phone LIKE '%".$search."%'
            OR tambol.tambol_name_thai LIKE '%".$search."%'
            OR amphur.amphur_name_thai LIKE '%".$search."%'
            OR province.province_name_thai LIKE '%".$search."%'
            OR tambol.zipcode LIKE '%".$search."%'
        )";
    }
    
    $sql = "
        SELECT
            h.*, 
            t.tambol_name_thai, 
            t.zipcode, 
            a.amphur_name_thai, 
            p.province_name_thai,
            p2.province_name_thai area,
            u.user_name,
            u.user_lname
        FROM home h
            LEFT JOIN tambol t ON h.tambol_id = t.tambol_id
            LEFT JOIN amphur a ON h.amphur_id = a.amphur_id
            LEFT JOIN province p ON h.province_id = p.province_id
            LEFT JOIN province p2 ON p2.province_id = h.area_province_id
            LEFT JOIN user u ON u.user_id = h.user
        WHERE h.status!='2' 
            AND h.user='".$USER["user_id"]."'
            AND h.year_id='".$YEAR_ID."'
            ".$condition_search."
        ORDER BY h.home_id DESC
    ";
    $show = $GLOBAL["SHOW"];
    $all = sizeof( $DATABASE->QueryObj($sql) );
    $p_all = ceil( $all/$show );
    $start = ($p-1)*$show;
    $objData = $DATABASE->QueryObj($sql." LIMIT ".$start.", ".$show);
?>
<div id="content-title">
    แบบสอบถามของฉัน
</div>
<div id="content-body">
    <div class="row mb-3">
        <div class="col">
            <form id="frm-search" autocomplete="off">
                <div class="input-group inner-icon">
                    <span class="fa fa-search form-control-feedback"></span>
                    <input type="text" id="search" class="form-control" placeholder="ค้นหา"
                        value="<?php echo $search; ?>" style="border-radius: .25rem;">
                    <?php if($search!="") { ?>
                    <div class="input-group-append">
                        <a href="?page=<?php echo $PAGE; ?>" class="btn btn-outline-secondary"
                            title="ล้างการค้นหา">ล้าง</a>
                    </div>
                    <?php } ?>
                </div>
                <small class="form-text text-muted mb-3">ค้นหา โดยระบุ หมายเลขแบบสอบถาม หรือรหัสบ้าน หรือที่อยู่
                    อย่างใดอย่างหนึ่ง และกด Enter</small>
            </form>
        </div>
        <div class="col-md-auto">
            <!-- แสดง Pagination -->
            <?php 
                if( sizeof($objData)>0 ) { 
                    $href = "./?page=".$PAGE;
                    if( isset($_GET["area_province_id"]) ) $href .= "&area_province_id=".$_GET["area_province_id"];
                    if( isset($_GET["search"]) ) $href .= "&search=".$_GET["search"];
                    $p_show = 7;
                    $diff_center = floor($p_show/2);
                    $min_page = $p-$diff_center;
                    $max_page = $p+$diff_center;
                    $duration = 0;
                    if( $min_page<1 ) $duration=1-$min_page;
                    else if( $max_page>$p_all ) $duration=$p_all-$max_page;
                    $min_page = $min_page+$duration;
                    $max_page = $max_page+$duration;
                    if( $min_page<=0 ) $min_page = 1;
                    if( $max_page>$p_all ) $max_page = $p_all;
            ?>
            <nav aria-label="Page navigation" class="float-right">
                <ul class="pagination mb-2">
                    <?php 
                        $disabled_pr = "";
                        $href_pr = $href;
                        if( $p-1>1 ) $href_pr .= "&p=".($p-1);
                        if( $p==1 ) {
                            $disabled_pr = "disabled";
                            $href_pr = "#";
                        }
                    ?>
                    <li class="page-item <?php echo $disabled_pr; ?>">
                        <a class="page-link" href="<?php echo $href; ?>" title="หน้าแรก">
                            << </a>
                    </li>
                    <li class="page-item <?php echo $disabled_pr; ?>">
                        <a class="page-link" href="<?php echo $href_pr; ?>" title="หน้าก่อนหน้า">
                            < </a>
                    </li>
                    <?php
                        for($i=$min_page; $i<=$max_page; $i++) {
                            $href_p = $href;
                            if( $i>1 ) $href_p .= "&p=".$i;
                            $active = "";
                            if( $i==$p ) $active = "active";
                            echo '<li class="page-item '.$active.'"><a class="page-link" href="'.$href_p.'">'.$i.'</a></li>';
                        }
                    ?>
                    <?php 
                        $disabled_ne = "";
                        $href_ne = $href;
                        $href_ne .= "&p=".($p+1);
                        if( $p==$p_all ) {
                            $disabled_ne = "disabled";
                            $href_ne = "#";
                        }
                    ?>
                    <li class="page-item <?php echo $disabled_ne; ?>">
                        <a class="page-link" href="<?php echo $href_ne; ?>" title="หน้าถัดไป">></a>
                    </li>
                    <li class="page-item <?php echo $disabled_ne; ?>">
                        <a class="page-link" href="<?php echo $href."&p=".$p_all; ?>" title="หน้าสุดท้าย">>></a>
                    </li>
                </ul>
            </nav>
            <?php
                }
            ?>
            <!-- สิ้นสุดแสดง Pagination -->
        </div>
    </div>
    <h6>ค้นพบทั้งพบ <?php echo $all; ?> รายการ</h6>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col" class="text-center">#</th>
                    <th scope="col" class="text-center">หมายเลขแบบสำรวจ</th>
                    <th scope="col" class="text-center">รหัสบ้าน</th>
                    <th scope="col" class="text-center">ที่อยู่</th>
                    <th scope="col" class="text-center">สถานะ</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if( sizeof($objData)==0 ) {
                        echo '
                            <tr>
                                <td colspan="7" class="text-center">
                                    ไม่พบรายการ
                                </td>
                            </tr>
                        ';
                    }
                    foreach($objData as $key=>$row) {
                        $StatusExt = array(
                            "0"=>'<div class="p-2 text-danger">รอส่งหัวหน้า</div>',
                            "1"=>'<div class="p-2 text-success">ตรวจสอบแล้ว</div>',
                            ""=>'<div class="p-2 text-warning">ส่งกลับแก้ไข</div>'
                        );
                        $DisabledEdit = "text-warning";
                        if( $row["status"]=="" || $row["status"]=="1" ) $DisabledEdit = "text-secondary disabled";
                        echo '
                            <tr data-json="'.htmlspecialchars(json_encode($row)).'">
                                <th class="text-center order">'.(($show*($p-1))+($key+1)).'</th>
                                <td class="text-center">'.$row["form_code"].'</td>
                                <td class="text-center">'.$row["home_code"].'</td>
                                <td>'.$row["village_name"].' '.$row["home_no"].' ม.'.$row["moo"].' ต.'.$row["tambol_name_thai"].' อ.'.$row["amphur_name_thai"].' จ.'.$row["province_name_thai"].' '.$row["zipcode"].'</td>
                                <td class="p-0 pt-1 pr-1 text-center">
                                    '.$StatusExt[$row["status"]].'
                                </td>
                                <td class="p-0 pt-2 pr-1 text-right">
                                    <a href="./?page=alls-form-data-info&home_id='.$row["home_id"].'" class="btn btn-link btn-sm text-info" title="เปิดดูรายละเอียด">
                                        <i class="fas fa-folder-open"></i>
                                    </a>
                                    <a href="./?page=user-form-data&home_id='.$row["home_id"].'" class="btn btn-link btn-sm '.$DisabledEdit.'" title="แก้ไข">
                                        <i class="fas fa-pen"></i>
                                    </a>
                                </td>
                            </tr>
                        ';
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>