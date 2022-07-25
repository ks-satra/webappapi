<?php
    $p = @$_GET["p"]*1; if($p==0) $p = 1;
    
    $sql = "
        SELECT
            home.*, 
            tambol.tambol_name_thai, 
            tambol.zipcode, 
            amphur.amphur_name_thai, 
            province.province_name_thai,
            p.province_name_thai area,
            u.user_name,
            u.user_lname
        FROM home
            INNER JOIN tambol ON home.tambol_id = tambol.tambol_id
            INNER JOIN amphur ON home.amphur_id = amphur.amphur_id
            INNER JOIN province ON home.province_id = province.province_id
            INNER JOIN province p ON p.province_id = home.area_province_id
            INNER JOIN user u ON u.user_id = home.user
        WHERE home.status='2'
        ORDER BY home.home_id DESC
    ";
    $show = 500;
    $all = sizeof( $DATABASE->QueryObj($sql) );
    $p_all = ceil( $all/$show );
    $start = ($p-1)*$show;
    $objData = $DATABASE->QueryObj($sql." LIMIT ".$start.", ".$show);
?>
<input type="hidden" id="p" value="<?php echo $p; ?>">
<input type="hidden" id="show" value="<?php echo $show; ?>">
<div id="content-title">
    Export Excel
</div>
<div id="content-body">
    <div class="row mb-3">
        <div class="col">
            <a href="Javascript:" id="btn-excel2" class="btn btn-light border mr-2 mb-3">
                <i class="fas fa-file-excel mr-2"></i> ดาวน์โหลดข้อมูลทั้งหมดรายการ
                <?php
                echo (($show*($p-1))+(0+1));
                echo " ถึง ";
                echo (($show*($p-1))+($show));
            ?>
            </a>
        </div>
        <div class="col-md-auto">
            <!-- แสดง Pagination -->
            <?php 
                        if( sizeof($objData)>0 ) { 
                            $href = "./?page=".$PAGE;
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
    <h6>ค้นพบทั้งพบ <?php echo number_format($all, 0); ?> รายการ</h6>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col" class="text-center">#</th>
                    <!-- <th scope="col" class="text-center">หมายเลขแบบสอบถาม</th> -->
                    <th scope="col" class="text-center">รหัสบ้าน</th>
                    <th scope="col" class="text-center">ที่อยู่</th>
                    <th scope="col" class="text-center">พื้นที่ดูแล</th>
                    <th scope="col" class="text-center">ผู้เก็บแบบสอบถาม</th>
                    <th scope="col"></th>
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
                        echo '
                            <tr data-json="'.htmlspecialchars(json_encode($row)).'">
                                <th class="text-center order">'.(($show*($p-1))+($key+1)).'</th>
                                <!--<td class="text-center">'.$row["form_code"].'</td>-->
                                <td class="text-center">'.$row["home_code"].'</td>
                                <td>'.$row["village_name"].' '.$row["home_no"].' ม.'.$row["moo"].' ต.'.$row["tambol_name_thai"].' อ.'.$row["amphur_name_thai"].' จ.'.$row["province_name_thai"].' '.$row["zipcode"].'</td>
                                <td class="text-center">จังหวัด'.$row["area"].'</td>
                                <td class="text-center">'.$row["user_name"].' '.$row["user_lname"].'</td>
                                <td class="p-0 pt-1 pr-1 text-right">
                                    <a href="./?page=report-form-data-info&home_id='.$row["home_id"].'" class="btn btn-link text-info" title="เปิดดูรายละเอียด">
                                        <i class="fas fa-folder-open"></i>
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