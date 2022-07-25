<?php
    $p = @$_GET["p"]*1; if($p==0) $p = 1;
    $search = @$_GET["search"];

    $condition_search = "";
    if( $search!="" ) {
        $condition_search .= " AND (
            ip.item_help_name LIKE '%".$search."%'
        )";
    }
    
    $sql = "
        SELECT
            ip.*
        FROM item_help ip
        WHERE 1=1
            ".$condition_search."
        ORDER BY ip.item_help_id DESC
    ";
    $show = $GLOBAL["SHOW"];
    $all = sizeof( $DATABASE->QueryObj($sql) );
    $p_all = ceil( $all/$show );
    $start = ($p-1)*$show;
    $objData = $DATABASE->QueryObj($sql." LIMIT ".$start.", ".$show);
?>
<?php include("pages/tabs-item/view-start.php"); ?>
<div id="content-title">
    ข้อมูลแหล่งเงินช่วยเหลือ
</div>
<div id="content-body">
    <div class="mb-4">
        <button id="btn-add" class="btn btn-success" title="เพิ่มแหล่งเงินช่วยเหลือ">
            <i class="fas fa-plus"></i> เพิ่มแหล่งเงินช่วยเหลือ
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
                <small class="form-text text-muted mb-3">ค้นหา โดยระบุ ชื่อแหล่งเงินช่วยเหลือ และกด Enter</small>
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
                    <th scope="col">ชื่อแหล่งเงินช่วยเหลือ</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if( sizeof($objData)==0 ) {
                        echo '
                            <tr>
                                <td colspan="3" class="text-center">
                                    ไม่พบรายการ
                                </td>
                            </tr>
                        ';
                    }
                    foreach($objData as $key=>$row) {
                        echo '
                            <tr data-json="'.htmlspecialchars(json_encode($row)).'">
                                <th class="text-center order">'.(($show*($p-1))+($key+1)).'</th>
                                <td>'.$row["item_help_name"].'</td>
                                <td class="p-0 pt-1 pr-1 text-right">
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
</div>
<?php include("pages/tabs-item/view-stop.php"); ?>
<div id="template" class="d-none">
    <form autocomplete="off">
        <input type="hidden" name="item_help_id" value="">
        <div class="table-responsive">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td class="pt-3" style="min-width: 150px; width: 150px;">แหล่งเงินช่วยเหลือ</td>
                        <td class="p-2" style="min-width: 200px;">
                            <input type="text" class="form-control" id="item_help_name" name="item_help_name"
                                required>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <input type="submit" class="submit d-none">
    </form>
</div>