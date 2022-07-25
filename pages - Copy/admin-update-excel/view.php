<?php
    // include_once("assets/uiExcelUpload/PHPExcel-1.8/Classes/PHPExcel.php");
    // include_once("assets/uiExcelUpload/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php");


    // $dir = "files/form-excel/";
    // $filename = "data.xlsx";

    // if( file_exists($dir.$filename) ) {
    //     $objPHPExcel = PHPExcel_IOFactory::load($dir.$filename);
    // } else {
    //     $objPHPExcel = new PHPExcel();
    // }
    // $highestRow = $objPHPExcel->getActiveSheet()->getHighestRow() - 4;
    // if( $highestRow<0 ) $highestRow = 0;

    function GetNextTime($time) {
        $every = 5;
        $arr = explode(":", $time);
        $h = $arr[0];
        $m = $arr[1];
        for($i=$m+1; $i<=$m+$every; $i++) {
            if( $i==60 ) {
                $h++;
                $i="00";
                if($h==24) $h = "00";
                if($h<9) $h = "0".$h;
                return $h.":".$i; 
            }
            if( $i%$every==0 ) {
                return $h.":".$i;
                break;
            }
        }
    }

    
    
?>
<div id="content-title">
    อัพเดตรายการใน Excel
</div>
<div id="content-body">
    <div class="mb-4">
        <h6 class="mb-3">
            โดยปกติระบบจะทำการอัพเดตอัตโนมัติทุก ๆ 5 นาที
            อัพเดตครั้งต่อไปเมื่อเวลา
            <?php
                $time = date("H:i");
                // $time = "00:55";
                echo GetNextTime($time);
            ?> น.
        </h6>
    </div>
    <div class="mb-5">
        <h6 class="mb-3">อัพเดตรายการที่ค้างอัตโนมัติ</h6>
        <button id="btn-update1" class="btn btn-primary" title="อัพเดต">
            <i class="fas fa-file-import mr-1"></i> อัพเดต
            <?php 
                $sql = "SELECT * FROM excel_update";
                $obj = $DATABASE->QueryObj($sql);
                if(sizeof($obj)>0) { 
            ?>
            <span class="badge badge-danger"><?php echo sizeof($obj); ?></span>
            <?php } ?>
        </button>
    </div>
    <div class="mb-5">
        <h6 class="mb-3">อัพเดตตามหมายเลขแบบสำรวจ</h6>
        <div class="form-inline">
            <div class="form-group">
                <label for="form_code" class="mr-2">หมายเลขแบบสำรวจ</label>
                <input type="text" class="form-control mr-2" id="form_code">
            </div>
            <button id="btn-update2" class="btn btn-primary" title="อัพเดต">
                <i class="fas fa-file-import mr-1"></i> อัพเดต
            </button>
        </div>
    </div>
    <div class="mb-5">
        <h6 class="mb-3">ดาวน์โหลด Excel</h6>
        <a href="files/form-excel/data.xlsx" download="data.xlsx" class="btn btn-success" title="ดาวน์โหลด Excel">
            <i class="fas fa-file-excel mr-1"></i> ดาวน์โหลด
            <?php 
                $sql = "SELECT * FROM excel_added";
                $obj = $DATABASE->QueryObj($sql);
                if(sizeof($obj)>0) { 
            ?>
            <span class="badge badge-danger"><?php echo sizeof($obj); ?></span>
            <?php } ?>
        </a>
    </div>
    <!-- <div class="mb-5">
        <h6 class="mb-3">ทดสอบดาวน์โหลด Excel</h6>
        <div class="form-inline">
            <div class="form-group">
                <label for="form_code" class="mr-2">home_id</label>
                <input type="text" class="form-control mr-2" id="home_id" value="1">
            </div>
            <button id="btn-test-download" class="btn btn-success" title="ดาวน์โหลด Excel">
                <i class="fas fa-file-excel mr-1"></i> ดาวน์โหลด
            </button>
        </div>
    </div> -->
</div>