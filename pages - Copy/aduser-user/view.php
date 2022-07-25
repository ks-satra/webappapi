<?php
    $p = @$_GET["p"]*1; if($p==0) $p = 1;
    $search = @$_GET["search"];

    $condition_search = "";
    if( $search!="" ) {
        $condition_search .= " AND (
            u.user_name LIKE '%".$search."%'
            OR u.user_lname LIKE '%".$search."%'
            OR u.username LIKE '%".$search."%'
            OR u.phone LIKE '%".$search."%'
        )";
    }
    $sql = "
        SELECT
            u.*, 
            ip.item_prefix_name
        FROM user u
            INNER JOIN item_prefix ip ON ip.item_prefix_id = u.item_prefix_id
        WHERE u.user_id IN (
                SELECT 
                    ua.user_id
                FROM user_area ua
                WHERE ua.province_id IN (SELECT province_id FROM user_area WHERE user_id='".$USER["user_id"]."' AND is_admin='Y')
            )
            ".$condition_search."
        ORDER BY u.user_id DESC
    ";
    $show = $GLOBAL["SHOW"];
    $all = sizeof( $DATABASE->QueryObj($sql) );
    $p_all = ceil( $all/$show );
    $start = ($p-1)*$show;
    $objData = $DATABASE->QueryObj($sql." LIMIT ".$start.", ".$show);
?>
<div id="content-title">
    ข้อมูลผู้ใช้งาน
    <small>ในพื้นที่ดูแลของฉัน</small>
</div>
<div id="content-body">
    <div class="mb-4">
        <button id="btn-add" class="btn btn-success" title="เพิ่มผู้ใช้ใหม่">
            <i class="fas fa-plus"></i> เพิ่มผู้ใช้ใหม่
        </button>
    </div>
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
                <small class="form-text text-muted mb-3">ค้นหา โดยระบุ ชื่อ หรือนามสกุล หรือชื่อผู้ใช้งาน หรือโทรศัพท์
                    อย่างใดอย่างหนึ่ง และกด Enter</small>
            </form>
        </div>
        <div class="col-md-auto">
            <!-- แสดง Pagination -->
            <?php 
                if( sizeof($objData)>0 ) { 
                    $href = "./?page=".$PAGE;
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
                    <th scope="col">ชื่อ-นามสกุล</th>
                    <th scope="col" class="text-center">อีเมล</th>
                    <th scope="col" class="text-center">โทรศัพท์</th>
                    <th scope="col" class="text-center">พื้นที่</th>
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
                        $status_ext = array(
                            "Y"=>'<span class="text-success"><i class="fas fa-check"></i> ใช้งาน</span>',
                            "N"=>'<span class="text-danger"><i class="fas fa-times"></i> ไม่ใช้งาน</span>'
                        );
                        $area = "";
                        $sql = "
                            SELECT 
                                user_area.*,
                                province.province_name_thai
                            FROM user_area
                                INNER JOIN province ON province.province_id=user_area.province_id
                            WHERE user_area.user_id='".$row["user_id"]."'
                            ORDER BY province.province_name_thai
                        ";
                        $obj = $DATABASE->QueryObj($sql);
                        if( sizeof($obj)==0 ) $area = '<span class="text-danger">ไม่มีสิทธิ์เข้าถึงพื้นที่</span>';
                        else {
                            $areas = '';
                            foreach($obj as $key2=>$row2) {
                                if($key2==0) $area = "จังหวัด".$row2["province_name_thai"];
                                else {
                                    if($key2==1) $area .= " ...";
                                }
                                $admin = ( $row2["is_admin"]=="Y" ) ? "แอดมิน" : "อาสา";
                                $areas .= '<b>'.$admin.'</b> : จังหวัด'.$row2["province_name_thai"].'<br>';
                            }
                            $area = '
                                <div class="custom-tooltip txt-blue">
                                    '.$area.'
                                    <span class="tooltiptext" style="width:200px; font-size:12px;">
                                        '.$areas.'
                                    </span>
                                </div>
                            ';
                        }
                        echo '
                            <tr data-json="'.htmlspecialchars(json_encode($row)).'">
                                <th class="text-center order">'.(($show*($p-1))+($key+1)).'</th>
                                <td>'.$row["item_prefix_name"].''.$row["user_name"].' '.$row["user_lname"].'</td>
                                <td class="text-center">'.$row["email"].'</td>
                                <td class="text-center">'.$row["phone"].'</td>
                                <td class="text-center">'.$area.'</td>
                                <td class="text-center">'.$status_ext[$row["status"]].'</td>
                                <td class="p-0 pt-1 pr-1 text-right">
                                    <a href="./?page=aduser-user-data&user_id='.$row["user_id"].'" title="เปิดดูรายละเอียด" class="btn-open btn btn-light text-info btn-sm">
                                        <i class="fa fa-info"></i>
                                    </a>
                                    <button title="แก้ไข" class="btn-edit btn btn-light text-warning btn-sm" style="width: 32px">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button title="ลบผู้ใช้รายนี้" class="btn-del btn btn-light text-danger btn-sm">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        ';
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>
<div id="template" class="d-none">
    <div class="row">
        <div class="col-sm-3 text-center mb-3">
            <img id="image" class="w-100" src="./files/user/default.png" alt="Profile"
                onerror="ImageError(this, './files/user/default.png')">
        </div>
        <div class="col-sm-9">
            <form autocomplete="off">
                <input type="hidden" name="user_id" value="">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td class="pt-3" style="min-width: 95px; width: 95px;">โปรไฟล์</td>
                                <td class="pt-3" style="min-width: 200px;">
                                    <input type="file" id="imagef" name="imagef"
                                        accept="<?php echo AcceptImplode($GLOBAL["ALLOW_IMAGE"]);?>">
                                </td>
                            </tr>
                            <tr class="province_id">
                                <td class="pt-3">พื้นที่ใช้งาน</td>
                                <td class="pt-3">
                                    <select class="form-control" id="province_id" name="province_id" required>
                                        <?php
                                            $sql = "
                                                SELECT 
                                                    p.province_id,
                                                    p.province_name_thai
                                                FROM user_area ua
                                                    INNER JOIN province p ON p.province_id=ua.province_id
                                                WHERE ua.user_id='".$USER["user_id"]."' 
                                                    AND ua.is_admin='Y'
                                            ";
                                            $obj = $DATABASE->QueryObj($sql);
                                            foreach($obj as $key=>$row) {
                                                echo '<option value="'.$row["province_id"].'">'.$row["province_name_thai"].'</option>';
                                            }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="pt-3">คำนำหน้า</td>
                                <td class="p-2">
                                    <select class="form-control" id="item_prefix_id" name="item_prefix_id" required>
                                        <option value="">-- ระบุคำนำหน้า --</option>
                                        <?php
                                            $sql = "SELECT * FROM item_prefix ORDER BY item_prefix_id";
                                            $obj = $DATABASE->QueryObj($sql);
                                            foreach($obj as $key=>$row) {
                                                echo '<option value="'.$row["item_prefix_id"].'">-- '.$row["item_prefix_name"].' --</option>';
                                            }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="pt-3">ชื่อ</td>
                                <td class="p-2">
                                    <input type="text" class="form-control" id="user_name" name="user_name" required>
                                </td>
                            </tr>
                            <tr>
                                <td class="pt-3">นามสกุล</td>
                                <td class="p-2">
                                    <input type="text" class="form-control" id="user_lname" name="user_lname" required>
                                </td>
                            </tr>
                            <tr>
                                <td class="pt-3">โทรศัพท์</td>
                                <td class="p-2">
                                    <input type="text" class="form-control" id="phone" name="phone" required>
                                </td>
                            </tr>
                            <tr>
                                <td class="pt-3">อีเมล</td>
                                <td class="p-2">
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </td>
                            </tr>
                            <tr>
                                <td class="pt-3">รหัสผ่าน</td>
                                <td class="p-2">
                                    <input type="text" class="form-control" id="password" name="password" required>
                                </td>
                            </tr>
                            <tr>
                                <td class="pt-3">สถานะ</td>
                                <td class="p-2">
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="Y">ใช้งาน</option>
                                        <option value="N">ไม่ใช้งาน</option>
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <input type="submit" class="submit d-none">
            </form>
        </div>
    </div>
</div>