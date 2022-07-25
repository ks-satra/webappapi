<?php
    $p = @$_GET["p"]*1; if($p==0) $p = 1;
    $search = @$_GET["search"];
    $condition = "";
    if( $search!="" ) {
        $condition .= " AND (
            login.session LIKE '%".$search."%' OR
            login.ip_local LIKE '%".$search."%' OR
            login.json_ip LIKE '%".$search."%' OR
            login.date LIKE '%".$search."%'
        )";
    }
    $sql = "
        SELECT
            *
        FROM login
        WHERE login.user='".$USER["user_id"]."' ".$condition."
            OR login.email='".$USER['email']."'
        ORDER BY login.login_id DESC
    ";
    $show = $GLOBAL["SHOW"];
    $all = sizeof( $DATABASE->QueryObj($sql) );
    $p_all = ceil( $all/$show );
    $start = ($p-1)*$show;
    $obj = $DATABASE->QueryObj($sql." LIMIT ".$start.", ".$show);
?>
<div id="content-title">
    <a href="./?page=<?php echo $PAGE; ?>">ประวัติการล็อกอิน</a>
</div>
<div id="content-body">
    <div>
        <a href="./?page=<?php echo $PAGE; ?>" class="btn btn-light mb-2 mr-2 border" title="รีโหลด"><i class="fa fa-sync"></i> รีโหลด</a>
    </div>
    <form action="" method="get" autocomplete="off">
        <input type="hidden" name="page" value="<?php echo $PAGE; ?>">
        <div class="form-row">
            <div class="form-group col-md-12">
                <label for="search">ค้นหา</label>
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="..คำค้นหา.." title="..คำค้นหา.." id="search" name="search" value="<?php echo $search; ?>">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="submit" title="ค้นหา"><i class="fa fa-search"></i></button>
                    </div>
                </div>
                <small class="form-text text-muted pl-3">พิมพ์คำค้นหา..IP Address, Public IP Address, สถานที่, พิกัด</small>
            </div>
        </div>
    </form>
    <div class="float-left mt-2 mb-2">
        ค้นพบ <?php echo $all; ?> รายการ
    </div>
    <!-- แสดง Pagination -->
    <?php 
        if( sizeof($obj)>0 ) { 
            $href = "./?page=".$PAGE;
            if( isset($_GET["search"]) ) $href .= "&search=".$_GET["search"];
            $p_show = $GLOBAL["PAGE_SHOW"];
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
        <ul class="pagination mb-2 pagination-sm">
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
                <a class="page-link" href="<?php echo $href; ?>" title="หน้าแรก"><<</a>
            </li>
            <li class="page-item <?php echo $disabled_pr; ?>">
                <a class="page-link" href="<?php echo $href_pr; ?>" title="หน้าก่อนหน้า"><</a>
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
    <div class="table-responsive">
        <table id="table" class="table table-bordered table-hover">
            <thead>
                <tr class="">
                    <th style="min-width: 50px; width: 50px;" class="text-right">#</th>
                    <th style="min-width: 152px; width: 152px;" class="text-center">วันเวลา</th>
                    <th style="min-width: 155px; width: 155px;" class="text-center">IP Address</th>
                    <th style="min-width: 155px; width: 155px;" class="text-center">Public IP Address</th>
                    <th style="min-width: 150px;">สถานที่</th>
                    <th style="min-width: 150px;">พิกัด</th>
                    <th style="min-width: 150px; width: 150px;" class="text-center">สถานะ</th>
                    <th style="min-width: 60px; width: 60px;"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if( sizeof($obj)==0 ) {
                        echo '<tr><td colspan="8" class="text-center font-italic">ไม่พบรายการ</td></tr>';
                    } else {
                        foreach ($obj as $key => $value) {
                            $more = json_decode($value["json_ip"], true);
                            $ip = isset($more["ip"]) ? $more["ip"] : "-";
                            $city = isset($more["city"]) ? $more["city"] : "-";
                            $region = isset($more["region"]) ? $more["region"] : "-";
                            $country = isset($more["country"]) ? $more["country"] : "-";
                            $location = isset($more["loc"]) ? $more["loc"] : "-";
                            $place = array();
                            if( $city!="-" ) $place[] = $city;
                            if( $region!="-" ) $place[] = $region;
                            if( $country!="-" ) $place[] = $countries[$country];
                            $status = "";
                            if( $value["status"]=="Y" ) {
                                $status = '<span class="text-success"><i class="fas fa-check mr-2"></i> ล็อกอินสำเร็จ</span>';
                            } else {
                                $status = '<span class="text-danger"><i class="fas fa-times mr-2"></i> ล็อกอินไม่สำเร็จ</span>';
                            }
                            $strPlace = ( sizeof($place)==0 ) ? "-" : implode(", ", $place);
                            echo '
                                <tr data-json="'.htmlspecialchars(json_encode($value)).'">
                                    <td class="text-right">'.(($show*($p-1))+($key+1)).'</td>
                                    <td show-date="DD MMM YYYY hh:mm น." class="text-center">'.DateTh($value["date"]).'</td>
                                    <td class="text-center">'.$value["ip_local"].'</td>
                                    <td class="text-center">'.$ip.'</td>
                                    <td>'.$strPlace.'</td>
                                    <td>'.$location.'</td>
                                    <td class="text-center">'.$status.'</td>
                                    <td class="text-center p-0 pt-2">
                                        <a href="./?page=all-login-detail&login_id='.$value["login_id"].'" title="ดูเพิ่มเติม" data-container="#table" class="btn btn-light text-info btn-sm" style="width: 32px"><i class="fa fa-info"></i></a>
                                    </td>
                                </tr>
                            ';
                        }
                    }
                    /*
                    {
                        "ip": "202.29.146.203",
                        "city": "Hat Yai",
                        "region": "Songkhla",
                        "country": "TH",
                        "loc": "7.0084,100.4770",
                        "postal": "90110",
                        "org": "AS9464 Prince of Songkla University (Sritrang'NET)"
                    }
                    */
                ?>
            </tbody>
        </table>
        <br>
    </div>
</div>