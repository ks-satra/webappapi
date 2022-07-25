<?php
    $p = @$_GET["p"]*1; if($p==0) $p = 1;
    $search = @$_GET["search"];

    $condition_search = "";
    if( $search!="" ) {
        $condition_search .= " AND (
            p.project_name LIKE '%".$search."%'
            OR p.project_name_all LIKE '%".$search."%'
            OR p.project_money LIKE '%".$search."%'
            OR p.project_place LIKE '%".$search."%'
            OR pt.project_type_name LIKE '%".$search."%'
        )";
    }
    
    $sql = "
        SELECT
            p.*, 
            pt.project_type_name
        FROM project p
            INNER JOIN project_type pt ON pt.project_type_id = p.project_type_id
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
    <button id="btn-add" class="btn btn-success" title="เพิ่มโครงการ">
        <i class="fas fa-plus"></i> เพิ่มโครงการ
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
            <small class="form-text text-muted mb-3">ค้นหา โดยระบุ ชื่อโครงการ หรืองบประมาณ หรือสถานที่ หรือประเภทโครงการ หรือผู้รับผิดชอบโครงการ
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
                <th scope="col" class="">งบประมาณ</th>
                <th scope="col" class="text-center">สถานที่</th>
                <th scope="col" class="text-center">ประเภทโครงการ</th>
                <th scope="col" class="text-center">ผู้รับผิดชอบโครงการ</th>
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
                    $sql = "
                        SELECT 
                            project.*,
                            project_type.project_type_name
                        FROM project
                            INNER JOIN project_type ON project_type.project_type_id=project.project_type_id
                        WHERE project.project_id='".$row["project_id"]."'
                        ORDER BY project_type.project_type_name
                    ";
                    $obj = $DATABASE->QueryObj($sql);
                    echo '
                        <tr data-json="'.htmlspecialchars(json_encode($row)).'">
                            <th class="text-center order">'.(($show*($p-1))+($key+1)).'</th>
                            <td>'.$row["project_name"].'</td>
                            <td class="">'.$row["project_money"].'</td>
                            <td class="text-center">'.$row["project_place"].'</td>
                            <td class="text-center">'.$row["project_type_name"].'</td>
                            <td class="text-center">'.$row["project_name_all"].'</td>
                            <td class="p-0 pt-1 pr-1 text-right">
                                <a href="./?page=project-data&project_id='.$row["project_id"].'" title="เปิดดูรายละเอียด" class="btn btn-light text-info btn-sm" style="width: 32px">
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
                <input type="hidden" name="project_id" value="">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td class="pt-3" style="min-width: 150px; width: 150px;">ชื่อโครงการ</td>
                                <td class="p-2">
                                    <input type="text" class="form-control" id="project_name" name="project_name" required>
                                </td>
                            </tr>
                            <tr>
                                <td class="pt-3">งบประมาณ</td>
                                <td class="p-2">
                                    <input type="text" class="form-control" id="project_money" name="project_money" required>
                                </td>
                            </tr>
                            <tr>
                                <td class="pt-3">สถานที่</td>
                                <td class="p-2">
                                    <input type="text" class="form-control" id="project_place" name="project_place" required>
                                </td>
                            </tr>
                            <tr>
                                <td class="pt-3">ผู้รับผิดชอบโครงการ</td>
                                <td class="p-2">
                                    <input type="text" class="form-control" id="project_name_all" name="project_name_all" required>
                                </td>
                            </tr>
                            <tr>
                                <td class="pt-3">ประเภทโครงการ</td>
                                <td class="p-2">
                                    <select class="form-control" id="project_type_id" name="project_type_id" required>
                                        <option value="">-- ระบุประเภทโครงการ --</option>
                                        <?php
                                            $sql = "SELECT * FROM project_type ORDER BY project_type_id";
                                            $obj = $DATABASE->QueryObj($sql);
                                            foreach($obj as $key=>$row) {
                                                echo '<option value="'.$row["project_type_id"].'">-- '.$row["project_type_name"].' --</option>';
                                            }
                                        ?>
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