<?php
    $p = @$_GET["p"]*1; if($p==0) $p = 1;
    $search = @$_GET["search"];

    $condition_search = "";
    if( $search!="" ) {
        $condition_search .= " AND (
            u.user_name LIKE '%".$search."%'
            OR u.user_lname LIKE '%".$search."%'
            OR u.email LIKE '%".$search."%'
            OR u.phone LIKE '%".$search."%'
        )";
    } 
    
    $sql = "
        SELECT
            a.*,
            p.project_id,
            p.project_name,
            p.project_name_all,
            p.project_money,
            p.project_place,
            p.project_type_id,
            pt.project_type_name,
            u.user_name,
            u.user_lname,
            pr.item_prefix_name,
            ap.activity_process_id
        FROM
            activity a
            INNER JOIN project p ON a.project_id = p.project_id
            INNER JOIN project_type pt ON p.project_type_id = pt.project_type_id
            INNER JOIN `user` u ON a.`user` = u.user_id
            INNER JOIN item_prefix pr ON u.item_prefix_id = pr.item_prefix_id
            INNER JOIN activity_process ap ON a.activity_process_id = ap.activity_process_id
        WHERE 1=1
            ".$condition_search."
        ORDER BY p.project_id DESC
    ";
    $show = $GLOBAL["SHOW"];
    $all = sizeof( $DATABASE->QueryObj($sql) );
    $p_all = ceil( $all/$show );
    $start = ($p-1)*$show;
    $objData = $DATABASE->QueryObj($sql." LIMIT ".$start.", ".$show);
?>
<div class="mb-4">
    <button id="btn-add" class="btn btn-success" title="เพิ่มกิจกรรมใหม่">
        <i class="fas fa-plus"></i> เพิ่มกิจกรรมใหม่
    </button>
</div>
<div class="row mb-3">
    <div class="col">
        <form id="frm-search" autocomplete="off">
            <div class="input-group inner-icon">
                <span class="fa fa-search form-control-feedback"></span>
                <input type="text" id="search" class="form-control" placeholder="ค้นหา" value="<?php echo $search; ?>"
                    style="border-radius: .25rem;">
                <?php if($search!="") { ?>
                <div class="input-group-append">
                    <a href="?page=<?php echo $PAGE; ?>" class="btn btn-outline-secondary" title="ล้างการค้นหา">ล้าง</a>
                </div>
                <?php } ?>
            </div>
            <small class="form-text text-muted mb-3">ค้นหา โดยระบุ ชื่อโครงการ หรือชื่อกิจกรรม หรืองบประมาณ หรือผู้รับผิดชอบกิจกรรม
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
                            "1"=>'<span class="text-success"><i class="fas fa-check"></i> ดำเนินการ</span>',
                            "2"=>'<span class="text-danger"><i class="fas fa-times"></i> ยังไม่ได้ดำเนินการแล้ว</span>'
                        );
                        echo '
                        <tr data-json="'.htmlspecialchars(json_encode($row)).'">
                            <th class="text-center order">'.(($show*($p-1))+($key+1)).'</th>
                            <td class="">'.$row["project_name"].'</td>
                            <td class="text-center">'.$row["activity_name"].'</td>
                            <td class="text-center">'.$row["activity_money"].'</td>
                            <td class="text-center">'.$row["item_prefix_name"].''.$row["user_name"].' '.$row["user_lname"].'</td>
                            <td class="text-center">'.$status_ext[$row["activity_process_id"]].'</td>
                            <td class="p-0 pt-1 pr-1 text-right">
                                <a href="./?page=activity-data&activity_id='.$row["activity_id"].'" title="เปิดดูรายละเอียด" class="btn btn-light text-info btn-sm" style="width: 32px">
                                    <i class="fa fa-info"></i>
                                </a>
                                <button title="แก้ไข" class="btn-edit btn btn-light text-warning btn-sm" style="width: 32px">
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button title="ลบ" class="btn-del btn btn-light text-danger btn-sm" style="width: 32px">
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

<div id="template" class="d-none">
    <div class="row">
        <div class="col-sm-12">
            <form autocomplete="off">
                <input type="hidden" name="activity_id" value="">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td class="pt-3" style="min-width: 150px; width: 150px;">ชื่อโครงการ</td>
                                <td class="p-2">
                                    <select class="form-control" id="project_id" name="project_id" required>
                                        <option value="">-- ระบุชื่อโครงการ --</option>
                                        <?php
                                            $sql = "SELECT * FROM project ORDER BY project_id";
                                            $obj = $DATABASE->QueryObj($sql);
                                            foreach($obj as $key=>$row) {
                                                echo '<option value="'.$row["project_id"].'">-- '.$row["project_name"].' --</option>';
                                            }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="pt-3" style="min-width: 150px; width: 150px;">ชื่อกิจกรรม</td>
                                <td class="p-2">
                                    <input type="text" class="form-control" id="activity_name" name="activity_name" required>
                                </td>
                            </tr>
                            <tr>
                                <td class="pt-3" style="min-width: 150px; width: 150px;">งบประมาณ</td>
                                <td class="p-2">
                                    <input type="text" class="form-control" id="activity_money" name="activity_money" required>
                                </td>
                            </tr>
                            <tr>
                                <td class="pt-3" style="min-width: 150px; width: 150px;">ผู้รับผิดชอบกิจกรรม</td>
                                <td class="p-2">
                                    <input type="text" class="form-control" id="activity_name_all" name="activity_name_all" required>
                                </td>
                            </tr>
                            <tr>
                                <td class="pt-3" style="min-width: 150px; width: 150px;">สถานที่</td>
                                <td class="p-2">
                                    <input type="activity_place" class="form-control" id="activity_place" name="activity_place" required>
                                </td>
                            </tr>
                            <tr>
                                <td class="pt-3" style="min-width: 150px; width: 150px;">สถานะ</td>
                                <td class="p-2">
                                    <select class="form-control" id="activity_process_id" name="activity_process_id" required>
                                        <option value="">-- ระบุสถานะ --</option>
                                        <?php
                                            $sql = "SELECT * FROM activity_process ORDER BY activity_process_id";
                                            $obj = $DATABASE->QueryObj($sql);
                                            foreach($obj as $key=>$row) {
                                                echo '<option value="'.$row["activity_process_id"].'">-- '.$row["activity_process_name"].' --</option>';
                                            }
                                        ?>
                                    </select>
                                </td>
                            </tr>
                            <!-- <tr>
                                <td class="pt-3">สถานะ</td>
                                <td class="p-2">
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="Y">ใช้งาน</option>
                                        <option value="N">ไม่ใช้งาน</option>
                                    </select>
                                </td>
                            </tr> -->
                        </tbody>
                    </table>
                </div>
                <input type="submit" class="submit d-none">
            </form>
        </div>
    </div>
</div>