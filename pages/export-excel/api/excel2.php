<?php
    include_once("../../../php/autoload.php");
    include_once("../../../assets/uiExcelUpload/PHPExcel-1.8/Classes/PHPExcel.php");
    include_once("../../../assets/uiExcelUpload/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php");
    ini_set('max_execution_time', 14400); // 4 hours 
    ini_set('memory_limit', '2048M');
    if( $USER==null ) {
        echo "กรุณาเข้าสู่ระบบก่อนใช้งาน";
        exit();
    }

    $p = @$_GET["p"]*1; if($p==0) $p = 1;
    $show = @$_GET["show"]*1; if($show==0) $show = 50;
    
    $filename = "data-".date("Y-m-d-H-i").".xlsx";

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->setTitle('ข้อมูลสภาพเศรษฐกิจ');

    function StyleDefault() {
        return array(
            'font' => array(
                'size' => 9,
                'name'  => 'Tahoma'
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                )
            )
        );
    }
    function StyleCenter() {
        return array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'font' => array(
                'size' => 9,
                'name'  => 'Tahoma'
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                )
            )
        );
    }
    function StyleHeader($color) {
        return array(
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'font'  => array(
                // 'bold'  => true
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => $color)
            ),
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN,
                    'color' => array('rgb' => '000000')
                )
            )
        );
    }

    function MergeCell($col1=-1, $col2=-1, $row1=-1, $row2=-1, $style="") {
        global $objPHPExcel;
        $merge = 'A1:A1';
        if($col1>=0 && $col2>=0 && $row1>=0 && $row2>=0) {
            $start = PHPExcel_Cell::stringFromColumnIndex($col1);
            $end = PHPExcel_Cell::stringFromColumnIndex($col2);
            $merge = "$start{$row1}:$end{$row2}";
        }
        $objPHPExcel->getActiveSheet()->mergeCells($merge);
        if($col1>=0 && $col2>=0 && $row1>=0 && $row2>=0) {
            if( $style=="" ) $style = StyleDefault();
            for( $i=$row1; $i<=$row2; $i++ ) {
                for( $j=$col1; $j<=$col2; $j++ ) {
                    SetStyle($j, $i, $style);
                }
            }
        }
    }

    function SetValue($col, $row, $value, $style="") {
        global $objPHPExcel;
        $cell = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row);
        $cell->setValue($value);
        $cell->getStyle()->applyFromArray( StyleDefault() );
        if( $style!="" ) $cell->getStyle()->applyFromArray($style);
    }
    function SetStyle($col, $row, $style) {
        global $objPHPExcel;
        $cell = $objPHPExcel->getActiveSheet()->getCellByColumnAndRow($col, $row);
        $cell->getStyle()->applyFromArray($style);
    }

    function SetWidth($col, $width) {
        global $objPHPExcel;
        $start = PHPExcel_Cell::stringFromColumnIndex($col);
        $objPHPExcel->getActiveSheet()->getColumnDimension($start)->setWidth($width);
    }

    $start = ($p-1)*$show;

    $sql = "
        SELECT
            home.*, 
            tambol.tambol_name_thai, 
            amphur.amphur_name_thai, 
            province.province_name_thai,
            prefix.prefix_name AS informant_prefix,
            prefix2.prefix_name AS prefix_name,
            user.user_name,
            user.user_lname,
            user.phone,
            form.ch11,
            form.ch11_assign,
            form.ch12,
            form.ch13,
            form.ch14,
            form.ch15,
            form.ch16,
            form.ch17,
            form.ch17_assign,
            form.ch2,
            form.ch22_assign,
            form.ch3,
            form.ch33_assign,
            form.ch41,
            form.ch41_rai,
            form.ch41_ngan,
            form.ch41_wa,
            form.ch42,
            form.ch42_rai,
            form.ch42_ngan,
            form.ch42_wa,
            form.ch43,
            form.ch43_rai,
            form.ch43_ngan,
            form.ch43_wa,
            
            ( SELECT IFNULL(SUM(income),0) FROM income1 i WHERE i.home_id=home.home_id ) AS income1,
            ( SELECT IFNULL(SUM(cost),0) FROM income1 i WHERE i.home_id=home.home_id ) AS cost1,
            
            ( SELECT IFNULL(SUM(income),0) FROM income2 i WHERE i.home_id=home.home_id ) AS income2,
            ( SELECT IFNULL(SUM(cost),0) FROM income2 i WHERE i.home_id=home.home_id ) AS cost2,
            
            ( SELECT IFNULL(SUM(income),0) FROM income3 i WHERE i.home_id=home.home_id ) AS income3,
            ( SELECT IFNULL(SUM(cost),0) FROM income3 i WHERE i.home_id=home.home_id ) AS cost3,
            
            ( SELECT IFNULL(SUM(income),0) FROM income4 i WHERE i.home_id=home.home_id ) AS income4,
            ( SELECT IFNULL(SUM(cost),0) FROM income4 i WHERE i.home_id=home.home_id ) AS cost4,
            
            ( SELECT IFNULL(SUM(income),0) FROM income5 i WHERE i.home_id=home.home_id ) AS income5,
            ( SELECT IFNULL(SUM(cost),0) FROM income5 i WHERE i.home_id=home.home_id ) AS cost5,
            
            ( SELECT IFNULL(SUM(income),0) FROM income6 i WHERE i.home_id=home.home_id ) AS income6,
            ( SELECT IFNULL(SUM(cost),0) FROM income6 i WHERE i.home_id=home.home_id ) AS cost6,
            
            ( SELECT IFNULL(SUM(income),0) FROM income7 i WHERE i.home_id=home.home_id ) AS income7,
            ( SELECT IFNULL(SUM(cost),0) FROM income7 i WHERE i.home_id=home.home_id ) AS cost7,
            
            ( SELECT IFNULL(SUM(income),0) FROM income8 i WHERE i.home_id=home.home_id ) AS income8,
            ( SELECT IFNULL(SUM(cost),0) FROM income8 i WHERE i.home_id=home.home_id ) AS cost8,
            
            ( SELECT IFNULL(SUM(income),0) FROM income9 i WHERE i.home_id=home.home_id ) AS income9,
            ( SELECT IFNULL(SUM(cost),0) FROM income9 i WHERE i.home_id=home.home_id ) AS cost9,
            
            ( SELECT IFNULL(SUM(income),0) FROM income_other i WHERE i.home_id=home.home_id ) AS income_other,
            
            ( SELECT IFNULL(SUM(amount),0) FROM income_family i WHERE i.home_id=home.home_id ) AS income_family
            
        FROM home
            INNER JOIN tambol ON home.tambol_id = tambol.tambol_id
            INNER JOIN amphur ON home.amphur_id = amphur.amphur_id
            INNER JOIN province ON home.province_id = province.province_id
            INNER JOIN prefix ON prefix.prefix_id = home.informant_prefix_id
            INNER JOIN user ON user.user_id = home.user
            INNER JOIN prefix prefix2 ON prefix2.prefix_id = user.prefix_id
            LEFT JOIN form ON form.home_id=home.home_id
        WHERE home.status='2'
        ORDER BY home.form_code
        LIMIT ".$start.", ".$show."
    ";
    $Datas = $DATABASE->QueryObj($sql);

    $COL = 0;
    $ROW = 1;

    $LIMIT_MEMBER = 25;
    $LIMIT = 10;

    

    SetValue($COL, 1, "ลำดับ", StyleHeader("e1e1e1")); MergeCell($COL, $COL, 1, 3, StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    SetValue($COL, 1, "หมายเลขแบบสอบถาม", StyleHeader("e1e1e1")); MergeCell($COL, $COL, 1, 3, StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    SetValue($COL, 1, "รหัสบ้าน", StyleHeader("e1e1e1")); MergeCell($COL, $COL, 1, 3, StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    SetValue($COL, 1, "ชื่อหมู่บ้าน", StyleHeader("e1e1e1")); MergeCell($COL, $COL, 1, 3, StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    SetValue($COL, 1, "บ้านเลขที่", StyleHeader("e1e1e1")); MergeCell($COL, $COL, 1, 3, StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    SetValue($COL, 1, "หมู่ที่", StyleHeader("e1e1e1")); MergeCell($COL, $COL, 1, 3, StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    SetValue($COL, 1,"ตำบล",  StyleHeader("e1e1e1")); MergeCell($COL, $COL, 1, 3, StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    SetValue($COL, 1, "อำเภอ", StyleHeader("e1e1e1")); MergeCell($COL, $COL, 1, 3, StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    SetValue($COL, 1, "จังหวัด", StyleHeader("e1e1e1")); MergeCell($COL, $COL, 1, 3, StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    SetValue($COL, 1, "รหัสไปรษณีย์", StyleHeader("e1e1e1")); MergeCell($COL, $COL, 1, 3, StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    SetValue($COL, 1, "ชื่อเจ้าของบ้าน", StyleHeader("e1e1e1")); MergeCell($COL, $COL, 1, 3, StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    SetValue($COL, 1, "หมายเลขโทรศัพท์", StyleHeader("e1e1e1")); MergeCell($COL, $COL, 1, 3, StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    SetValue($COL, 1, "จำนวนครอบครัว", StyleHeader("e1e1e1")); MergeCell($COL, $COL, 1, 3, StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    SetValue($COL, 1, "จำนวนสมาชิก", StyleHeader("e1e1e1")); MergeCell($COL, $COL, 1, 3, StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    SetValue($COL, 1, "ชื่อผู้ให้ข้อมูล", StyleHeader("e1e1e1")); MergeCell($COL, $COL, 1, 3, StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    SetValue($COL, 1, "ผู้บันทึกข้อมูล", StyleHeader("e1e1e1")); MergeCell($COL, $COL, 1, 3, StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    SetValue($COL, 1, "หมายเลขโทรศัพท์", StyleHeader("e1e1e1")); MergeCell($COL, $COL, 1, 3, StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    SetValue($COL, 1, "วันที่บันทึก", StyleHeader("e1e1e1")); MergeCell($COL, $COL, 1, 3, StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;

    SetValue($COL, 1, "ท่านใช้แหล่งน้ำเพื่อการประกอบอาชีพจากแหล่งใด (สามารถระบุได้มากกว่า1 ข้อ) (น้ำการเกษตร)", StyleHeader("e1e1e1")); MergeCell($COL, $COL+8, 1, 2, StyleHeader("e1e1e1"));
    SetValue($COL, 3, "ลำห้วย ลำเหมือง", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    SetValue($COL, 3, "ระบุ", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    SetValue($COL, 3, "อ่างเก็บน้ำ สระน้ำหมู่บ้าน", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    SetValue($COL, 3, "บ่อน้ำผิวดิน น้ำบาดาล น้ำใต้ดิน", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    SetValue($COL, 3, "ระบบท่อ", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    SetValue($COL, 3, "ใช้แต่น้ำฝนตามฤดูกาลเท่านั้น", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    SetValue($COL, 3, "คลองชลประทาน", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    SetValue($COL, 3, "ฝาย", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    SetValue($COL, 3, "ระบุ", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;

    SetValue($COL, 1, "แหล่งน้ำสำหรับการประกอบอาชีพที่ท่านใช้ มีเพียงพอต่อการทำการเกษตรตลอดทั้งปีหรือไม่", StyleHeader("e1e1e1")); MergeCell($COL, $COL+2, 1, 2, StyleHeader("e1e1e1"));
    SetValue($COL, 3, "เพียงพอตลอดปี", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    SetValue($COL, 3, "ไม่เพียงพอตลอดปี", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    SetValue($COL, 3, "มีพอใช้จำนวน (เดือน)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;

    SetValue($COL, 1, "รูปแบบการนำน้ำมาใช้ในแปลงเกษตร", StyleHeader("e1e1e1")); MergeCell($COL, $COL+2, 1, 2, StyleHeader("e1e1e1"));
    SetValue($COL, 3, "ระบบสูบน้ำไฟฟ้า", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    SetValue($COL, 3, "ระบบสูบน้ำโซล่าเซลล์", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    SetValue($COL, 3, "อื่นๆ โปรดระบุ", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;

    SetValue($COL, 1, "พื้นที่ทำกิน (ไร่/งาน/วา)", StyleHeader("e1e1e1")); MergeCell($COL, $COL+3, 1, 2, StyleHeader("e1e1e1"));
    SetValue($COL, 3, "ทั้งหมด", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    SetValue($COL, 3, "เป็นของครัวเรือน", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    SetValue($COL, 3, "ที่เช่า", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    SetValue($COL, 3, "เจ้าของที่ดินให้ใช้ที่ดินทำกิน โดยไม่เก็บค่าเช่า", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;

    $size = 8;
    SetValue($COL, 1, "ข้อมูลพื้นฐานสมาชิกในครัวเรือน", StyleHeader("e1e1e1")); MergeCell($COL, $COL+$size*$LIMIT_MEMBER-1, 1, 1, StyleHeader("e1e1e1"));
    for($i=0; $i<$LIMIT_MEMBER; $i++) {
        SetValue($COL, 2, "ลำดับที่ ".($i+1), StyleHeader("e1e1e1")); MergeCell($COL, $COL+($size-1), 2, 2, StyleHeader("e1e1e1"));
        SetValue($COL, 3, "ชื่อ - นามสกุล", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "ความสัมพันธ์", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "ปีเกิด (พ.ศ.)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "อายุ (ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "เพศ", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "ระดับการศึกษา", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "ทำงาน", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "อาชีพ ณ ปัจจุบัน", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    }

    $size = 14;
    SetValue($COL, 1, "รายได้จากการปลูกข้าว", StyleHeader("e1e1e1")); MergeCell($COL, $COL+$size*$LIMIT-1, 1, 1, StyleHeader("e1e1e1"));
    for($i=0; $i<$LIMIT; $i++) {
        SetValue($COL, 2, "ลำดับที่ ".($i+1), StyleHeader("e1e1e1")); MergeCell($COL, $COL+($size-1), 2, 2, StyleHeader("e1e1e1"));
        SetValue($COL, 3, "ประเภทผลผลิต", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "พันธุ์พืช", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "ทำมาแล้ว (ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "เป็นผลผลิตที่ได้จากโครงการใด", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "พื้นที่ปลูก (ไร่/งาน/ตรว.)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "ผลผลิตเฉลี่ย (กก./ไร่/ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "ผลผลิตรวม (กก./ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "บริโภคในครัวเรือน (กก./ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "ขาย (กก./ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "ราคา (บาท/กก.)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "รายได้ (บาท/ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "รวมต้นทุน (บาท/ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "กำไรสุทธิ (บาท/ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "ตลาด", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    }

    $size = 14;
    SetValue($COL, 1, "รายได้จากการปลูกพืชผักสวนครัว/พืชอายุสั้น (ลดรายจ่ายและเชิงพาณิชย์)", StyleHeader("e1e1e1")); MergeCell($COL, $COL+$size*$LIMIT-1, 1, 1, StyleHeader("e1e1e1"));
    for($i=0; $i<$LIMIT; $i++) {
        SetValue($COL, 2, "ลำดับที่ ".($i+1), StyleHeader("e1e1e1")); MergeCell($COL, $COL+($size-1), 2, 2, StyleHeader("e1e1e1"));
        SetValue($COL, 3, "ประเภทผลผลิต", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "พันธุ์พืช", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "ทำมาแล้ว (ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "เป็นผลผลิตที่ได้จากโครงการใด", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "พื้นที่ปลูก (ไร่/งาน/ตรว.)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "ผลผลิตเฉลี่ย (กก./ไร่/ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "ผลผลิตรวม (กก./ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "บริโภคในครัวเรือน (กก./ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "ขาย (กก./ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "ราคา (บาท/กก.)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "รายได้ (บาท/ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "รวมต้นทุน (บาท/ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "กำไรสุทธิ (บาท/ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "ตลาด", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    }

    $size = 14;
    SetValue($COL, 1, "รายได้จากการปลูกพืชไร่", StyleHeader("e1e1e1")); MergeCell($COL, $COL+$size*$LIMIT-1, 1, 1, StyleHeader("e1e1e1"));
    for($i=0; $i<$LIMIT; $i++) {
        SetValue($COL, 2, "ลำดับที่ ".($i+1), StyleHeader("e1e1e1")); MergeCell($COL, $COL+($size-1), 2, 2, StyleHeader("e1e1e1"));
        SetValue($COL, 3, "ประเภทผลผลิต", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "พันธุ์พืช", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "ทำมาแล้ว (ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "เป็นผลผลิตที่ได้จากโครงการใด", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "พื้นที่ปลูก (ไร่/งาน/ตรว.)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "ผลผลิตเฉลี่ย", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "ผลผลิตรวม", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "บริโภคในครัวเรือน", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "ขาย", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "ราคา", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "รายได้ (บาท/ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "รวมต้นทุน (บาท/ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "กำไรสุทธิ (บาท/ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "ตลาด", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    }

    $size = 14;
    SetValue($COL, 1, "รายได้จากการปลูกพืชสวน", StyleHeader("e1e1e1")); MergeCell($COL, $COL+$size*$LIMIT-1, 1, 1, StyleHeader("e1e1e1"));
    for($i=0; $i<$LIMIT; $i++) {
        SetValue($COL, 2, "ลำดับที่ ".($i+1), StyleHeader("e1e1e1")); MergeCell($COL, $COL+($size-1), 2, 2, StyleHeader("e1e1e1"));
        SetValue($COL, 3, "ประเภทผลผลิต", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "พันธุ์พืช", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "ทำมาแล้ว (ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "เป็นผลผลิตที่ได้จากโครงการใด", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "พื้นที่ปลูก (ไร่/งาน/ตรว.)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "ผลผลิตเฉลี่ย", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "ผลผลิตรวม", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "บริโภคในครัวเรือน", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "ขาย", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "ราคา", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "รายได้ (บาท/ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "รวมต้นทุน (บาท/ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "กำไรสุทธิ (บาท/ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "ตลาด", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    }

    $size = 13;
    SetValue($COL, 1, "รายได้จากปศุสัตว์ (ถ้าเลี้ยงเป็ด/ไก่ ให้ระบุรายได้จากการขายไข่และเนื้อด้วย)", StyleHeader("e1e1e1")); MergeCell($COL, $COL+$size*$LIMIT-1, 1, 1, StyleHeader("e1e1e1"));
    for($i=0; $i<$LIMIT; $i++) {
        SetValue($COL, 2, "ลำดับที่ ".($i+1), StyleHeader("e1e1e1")); MergeCell($COL, $COL+($size-1), 2, 2, StyleHeader("e1e1e1"));
        SetValue($COL, 3, "ชนิดสัตว์", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "ทำมาแล้ว (ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "รวม", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "จำนวนบริโภคในครัวเรือน", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "จำนวนขาย", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "ราคา", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "รายได้รวม (บาท/ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "ต้นทุนพันธุ์ (บาท/ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "ต้นทุนอาหาร (บาท/ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "ต้นทุนยา (บาท/ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "ต้นอุปกรณ์ (บาท/ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "รวมต้นทุน (บาท/ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "กำไรสุทธิ (บาท/ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    }

    $size = 13;
    SetValue($COL, 1, "รายได้จากประมง", StyleHeader("e1e1e1")); MergeCell($COL, $COL+$size*$LIMIT-1, 1, 1, StyleHeader("e1e1e1"));
    for($i=0; $i<$LIMIT; $i++) {
        SetValue($COL, 2, "ลำดับที่ ".($i+1), StyleHeader("e1e1e1")); MergeCell($COL, $COL+($size-1), 2, 2, StyleHeader("e1e1e1"));
        SetValue($COL, 3, "ชนิดสัตว์", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "ทำมาแล้ว (ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "รวม (กก./ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "จำนวนบริโภคในครัวเรือน (กก./ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "จำนวนขาย (กก./ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "ราคา (บาท/กก.)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "รายได้รวม (บาท/ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "ต้นทุนพันธุ์ (บาท/ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "ต้นทุนอาหาร (บาท/ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "ต้นทุนยา (บาท/ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "ต้นอุปกรณ์ (บาท/ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "รวมต้นทุน (บาท/ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "กำไรสุทธิ (บาท/ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    }

    $size = 8;
    SetValue($COL, 1, "รายได้จากหัตถกรรม", StyleHeader("e1e1e1")); MergeCell($COL, $COL+$size*$LIMIT-1, 1, 1, StyleHeader("e1e1e1"));
    for($i=0; $i<$LIMIT; $i++) {
        SetValue($COL, 2, "ลำดับที่ ".($i+1), StyleHeader("e1e1e1")); MergeCell($COL, $COL+($size-1), 2, 2, StyleHeader("e1e1e1"));
        SetValue($COL, 3, "ชนิดผลิตภัณฑ์", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "ทำมาแล้ว (ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "มูลค่าใช้ในครัวเรือน (บาท/ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "มูลค่าขาย (บาท/ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "รายได้รวม (บาท/ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "ต้นทุน (บาท/ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "กำไรสุทธิ (บาท/ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "แหล่งขาย", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    }

    $size = 6;
    SetValue($COL, 1, "รายได้จากการค้าขาย (ร้านขายของชำ/อาหารตามสั่ง/ปั้มน้ำมัน/ทำอาหารขาย)", StyleHeader("e1e1e1")); MergeCell($COL, $COL+$size*$LIMIT-1, 1, 1, StyleHeader("e1e1e1"));
    for($i=0; $i<$LIMIT; $i++) {
        SetValue($COL, 2, "ลำดับที่ ".($i+1), StyleHeader("e1e1e1")); MergeCell($COL, $COL+($size-1), 2, 2, StyleHeader("e1e1e1"));
        SetValue($COL, 3, "ชนิดสินค้า", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "ทำมาแล้ว (ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "รายได้ (บาท/ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "ต้นทุน (บาท/ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "กำไร (บาท/ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "แหล่งขาย", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    }

    $size = 9;
    SetValue($COL, 1, "รายได้จากอาหารธรรมชาติ (การลดรายจ่าย)", StyleHeader("e1e1e1")); MergeCell($COL, $COL+$size*$LIMIT-1, 1, 1, StyleHeader("e1e1e1"));
    for($i=0; $i<$LIMIT; $i++) {
        SetValue($COL, 2, "ลำดับที่ ".($i+1), StyleHeader("e1e1e1")); MergeCell($COL, $COL+($size-1), 2, 2, StyleHeader("e1e1e1"));
        SetValue($COL, 3, "ชนิดอาหาร", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "ฤดูกาลที่หา", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "แหล่งที่หา", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "ปริมาณที่หา (กก./ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "มูลค่าบริโภคในครัวเรือน (กก./ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "มูลค่าขาย (กก./ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "รายได้ (บาท/ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "ต้นทุน (บาท/ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "กำไรสุทธิ (บาท/ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    }
    // รายได้อื่นๆ
    $sql = "
        SELECT *
        FROM income_other_item
        ORDER BY income_other_item_id
    ";
    $IncomeOtherItem = $DATABASE->QueryObj($sql);
    $size = sizeof($IncomeOtherItem);
    SetValue($COL, 1, "รายได้อื่น ๆ", StyleHeader("e1e1e1")); MergeCell($COL, $COL+$size-1, 1, 2, StyleHeader("e1e1e1"));
    foreach($IncomeOtherItem as $key=>$row) {
        SetValue($COL, 3, $row["income_other_item_name"], StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    }
    // รายได้จากสมาชิกในครัวเรือน (รายได้ประจำจากสมาชิกในครัวเรือน เช่น ผู้ใหญ่บ้าน ผู้ช่วย สอบต. นายก ตำรวจ ทหาร ครู)
    $size = 4;
    SetValue($COL, 1, "รายได้จากสมาชิกในครัวเรือน (รายได้ประจำจากสมาชิกในครัวเรือน เช่น ผู้ใหญ่บ้าน ผู้ช่วย สอบต. นายก ตำรวจ ทหาร ครู)", StyleHeader("e1e1e1")); MergeCell($COL, $COL+$size*$LIMIT-1, 1, 1, StyleHeader("e1e1e1"));
    for($i=0; $i<$LIMIT; $i++) {
        SetValue($COL, 2, "ลำดับที่ ".($i+1), StyleHeader("e1e1e1")); MergeCell($COL, $COL+($size-1), 2, 2, StyleHeader("e1e1e1"));
        SetValue($COL, 3, "ชื่อ-นามสกุล", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "อาชีพ", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "จำนวนเงิน (บาท/ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "สถานที่ทำงาน", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    }
    // เงินออม
    $sql = "
        SELECT *
        FROM saving_item
        ORDER BY saving_item_id
    ";
    $SavingItem = $DATABASE->QueryObj($sql);
    $size = sizeof($SavingItem);
    SetValue($COL, 1, "เงินออม", StyleHeader("e1e1e1")); MergeCell($COL, $COL+$size-1, 1, 2, StyleHeader("e1e1e1"));
    foreach($SavingItem as $key=>$row) {
        SetValue($COL, 3, $row["saving_item_name"], StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    }
    // เงินช่วยเหลือ
    $sql = "
        SELECT *
        FROM help_item
        ORDER BY help_item_id
    ";
    $HelpItem = $DATABASE->QueryObj($sql);
    $size = sizeof($HelpItem);
    SetValue($COL, 1, "เงินช่วยเหลือ", StyleHeader("e1e1e1")); MergeCell($COL, $COL+3*$size-1, 1, 1, StyleHeader("e1e1e1"));
    foreach($HelpItem as $key=>$row) {
        SetValue($COL, 2, $row["help_item_name"], StyleHeader("e1e1e1")); MergeCell($COL, $COL+2, 2, 2, StyleHeader("e1e1e1"));
        SetValue($COL, 3, "จำนวนคนในครอบครัวที่ได้รับ (คน)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "จำนวนเงินที่ได้รับ (บาท/เดือน)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "รวมเป็นเงิน (บาท/ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    }
    // รายจ่าย
    $sql = "
        SELECT *
        FROM expense_item
        WHERE expense_type_id IN ('1', '2', '3')
        ORDER BY expense_item_id
    ";
    $ExpenseItem = $DATABASE->QueryObj($sql);
    $size = sizeof($ExpenseItem);
    SetValue($COL, 1, "รายจ่าย (บาท/ปี)", StyleHeader("e1e1e1")); MergeCell($COL, $COL+$size-1, 1, 1, StyleHeader("e1e1e1"));
    $sql = "
        SELECT *
        FROM expense_item
        WHERE expense_type_id='1'
        ORDER BY expense_item_id
    ";
    $ExpenseItem = $DATABASE->QueryObj($sql);
    $size = sizeof($ExpenseItem);
    SetValue($COL, 2, "ค่าใช้จ่ายเพื่อการบริโภค (บาท/ปี)", StyleHeader("e1e1e1")); MergeCell($COL, $COL+$size-1, 2, 2, StyleHeader("e1e1e1"));
    foreach($ExpenseItem as $key=>$row) {
        SetValue($COL, 3, $row["expense_item_name"], StyleHeader("e1e1e1")); $COL++;
    }
    $sql = "
        SELECT *
        FROM expense_item
        WHERE expense_type_id='2'
        ORDER BY expense_item_id
    ";
    $ExpenseItem = $DATABASE->QueryObj($sql);
    $size = sizeof($ExpenseItem);
    SetValue($COL, 2, "ค่าใช้จ่ายเพื่อการอุปโภค (บาท/ปี)", StyleHeader("e1e1e1")); MergeCell($COL, $COL+$size-1, 2, 2, StyleHeader("e1e1e1"));
    foreach($ExpenseItem as $key=>$row) {
        SetValue($COL, 3, $row["expense_item_name"], StyleHeader("e1e1e1")); $COL++;
    }
    $sql = "
        SELECT *
        FROM expense_item
        WHERE expense_type_id='3'
        ORDER BY expense_item_id
    ";
    $ExpenseItem = $DATABASE->QueryObj($sql);
    $size = sizeof($ExpenseItem);
    SetValue($COL, 2, "ค่าใช้จ่ายที่ไม่เกี่ยวกับการอุปโภคบริโภค (ค่าใช้จ่ายอื่นๆ) (บาท/ปี)", StyleHeader("e1e1e1")); MergeCell($COL, $COL+$size-1, 2, 2, StyleHeader("e1e1e1"));
    foreach($ExpenseItem as $key=>$row) {
        SetValue($COL, 3, $row["expense_item_name"], StyleHeader("e1e1e1")); $COL++;
    }
    // หนี้สิน
    $sql = "
        SELECT *
        FROM debt_item
        ORDER BY debt_item_id
    ";
    $DebtItem = $DATABASE->QueryObj($sql);
    $size = sizeof($DebtItem);
    SetValue($COL, 1, "หนี้สิน", StyleHeader("e1e1e1")); MergeCell($COL, $COL+2*$size-1, 1, 1, StyleHeader("e1e1e1"));
    foreach($DebtItem as $key=>$row) {
        SetValue($COL, 2, $row["debt_item_name"], StyleHeader("e1e1e1")); MergeCell($COL, $COL+1, 2, 2, StyleHeader("e1e1e1"));
        SetValue($COL, 3, "จำนวนเงินกู้ (บาท/ปี)", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
        SetValue($COL, 3, "วัตถุประสงค์ในการกู้", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    }

    $ROW = 4;
    foreach($Datas as $key=>$data) {
        $COL = 0;
        $sql = "
            SELECT 
                home_member.*,
                prefix.prefix_name
            FROM home_member 
                INNER JOIN prefix ON prefix.prefix_id=home_member.prefix_id
            WHERE home_id='".$data["home_id"]."'
        ";
        $obj = $DATABASE->QueryObj($sql);
        $owner = array();
        $member = sizeof($obj);
        foreach($obj as $row) {
            if( $row["relation_id"]=="1" ) $owner[] = $row["prefix_name"].$row["name"]." ".$row["lname"];
        }
        if( sizeof($owner)==0 ) $owner = "ไม่พบเจ้าของบ้าน";
        else $owner = implode(", ", $owner);

        SetValue($COL, $ROW, ((($show*($p-1))+($key+1))).""); $COL++;
        SetValue($COL, $ROW, $data["form_code"]); $COL++;
        SetValue($COL, $ROW, $data["home_code"]); $COL++;
        SetValue($COL, $ROW, $data["village_name"]); $COL++;
        SetValue($COL, $ROW, $data["home_no"]); $COL++;
        SetValue($COL, $ROW, $data["moo"]); $COL++;
        SetValue($COL, $ROW, $data["tambol_name_thai"]); $COL++;
        SetValue($COL, $ROW, $data["amphur_name_thai"]); $COL++;
        SetValue($COL, $ROW, $data["province_name_thai"]); $COL++;
        SetValue($COL, $ROW, $data["zipcode"]); $COL++;
        SetValue($COL, $ROW, $owner); $COL++;
        SetValue($COL, $ROW, $data["phone"]); $COL++;
        SetValue($COL, $ROW, $data["family"]); $COL++;
        SetValue($COL, $ROW, $member.""); $COL++;
        SetValue($COL, $ROW, $data["informant_prefix"].$data["informant_name"]." ".$data["informant_lname"]); $COL++;
        SetValue($COL, $ROW, $data["prefix_name"].$data["user_name"]." ".$data["user_lname"]); $COL++;
        SetValue($COL, $ROW, $data["phone"]); $COL++;
        SetValue($COL, $ROW, DateTh($data["date"])); $COL++;

        SetValue($COL, $ROW, $data["ch11"]); $COL++;
        SetValue($COL, $ROW, $data["ch11_assign"]); $COL++;
        SetValue($COL, $ROW, $data["ch12"]); $COL++;
        SetValue($COL, $ROW, $data["ch13"]); $COL++;
        SetValue($COL, $ROW, $data["ch14"]); $COL++;
        SetValue($COL, $ROW, $data["ch15"]); $COL++;
        SetValue($COL, $ROW, $data["ch16"]); $COL++;
        SetValue($COL, $ROW, $data["ch17"]); $COL++;
        SetValue($COL, $ROW, $data["ch17_assign"]); $COL++;

        SetValue($COL, $ROW, ($data["ch2"]=="1") ? "Y":"N"); $COL++;
        SetValue($COL, $ROW, ($data["ch2"]=="2") ? "Y":"N"); $COL++;
        SetValue($COL, $ROW, $data["ch22_assign"]); $COL++;

        SetValue($COL, $ROW, ($data["ch3"]=="1") ? "Y":"N"); $COL++;
        SetValue($COL, $ROW, ($data["ch3"]=="2") ? "Y":"N"); $COL++;
        SetValue($COL, $ROW, ($data["ch3"]=="3") ? "Y (".$data["ch33_assign"].")":"N"); $COL++;

        $ch4_rai = $data["ch41_rai"] + $data["ch42_rai"] + $data["ch43_rai"];
        $ch4_ngan = $data["ch41_ngan"] + $data["ch42_ngan"] + $data["ch43_ngan"];
        $ch4_wa = $data["ch41_wa"] + $data["ch42_wa"] + $data["ch43_wa"];

        SetValue($COL, $ROW, $ch4_rai."/".$ch4_ngan."/".$ch4_wa); $COL++;
        SetValue($COL, $ROW, $data["ch41_rai"]."/".$data["ch41_ngan"]."/".$data["ch41_wa"]); $COL++;
        SetValue($COL, $ROW, $data["ch42_rai"]."/".$data["ch42_ngan"]."/".$data["ch42_wa"]); $COL++;
        SetValue($COL, $ROW, $data["ch43_rai"]."/".$data["ch43_ngan"]."/".$data["ch43_wa"]); $COL++;
        // ข้อมูลพื้นฐานสมาชิกในครัวเรือน
        $sql = "
            SELECT 
                home_member.*,
                prefix.prefix_name,
                relation.relation_name,
                sex.sex_name,
                education.education_name,
                work.work_name,
                occupation.occupation_name
            FROM home_member
                INNER JOIN prefix ON prefix.prefix_id=home_member.prefix_id
                INNER JOIN relation ON relation.relation_id=home_member.relation_id
                INNER JOIN sex ON sex.sex_id=home_member.sex_id
                LEFT JOIN education ON education.education_id=home_member.education_id
                LEFT JOIN work ON work.work_id=home_member.work_id
                LEFT JOIN occupation ON occupation.occupation_id=home_member.occupation_id
            WHERE home_member.home_id='".$data["home_id"]."'
            ORDER BY home_member.date
            LIMIT ".$LIMIT_MEMBER."
        ";
        $obj = $DATABASE->QueryObj($sql);
        for($i=0; $i<$LIMIT_MEMBER; $i++) {
            if( isset($obj[$i]) ) {
                $row = $obj[$i];
                $education_name = $row["education_name"]; if( $row["education_id"]=="999" ) $education_name = "อื่น (".$row["education_assign"].")";
                $work_name = $row["work_name"]; if( $row["work_id"]=="999" ) $work_name = "อื่น (".$row["work_assign"].")";
                $occupation_name = $row["occupation_name"]; if( $row["occupation_id"]=="999" ) $occupation_name = "อื่น (".$row["occupation_assign"].")";
                SetValue($COL, $ROW, $row["prefix_name"].$row["name"]." ".$row["lname"]); $COL++;
                SetValue($COL, $ROW, $row["relation_name"]); $COL++;
                SetValue($COL, $ROW, $row["year_bdate"]+543); $COL++;
                SetValue($COL, $ROW, date("Y") - $row["year_bdate"]); $COL++;
                SetValue($COL, $ROW, $row["sex_name"]); $COL++;
                SetValue($COL, $ROW, $education_name); $COL++;
                SetValue($COL, $ROW, $work_name); $COL++;
                SetValue($COL, $ROW, $occupation_name); $COL++;
            } else {
                for($j=0; $j<8; $j++) {
                    SetValue($COL, $ROW, "-"); $COL++;
                }
            }
        }
        // รายได้จากการปลูกข้าว
        $sql = "
            SELECT 
                income1.*
            FROM income1
            WHERE income1.home_id='".$data["home_id"]."'
            ORDER BY income1.order_id
            LIMIT ".$LIMIT."
        ";
        $obj = $DATABASE->QueryObj($sql);
        for($i=0; $i<$LIMIT; $i++) {
            if( isset($obj[$i]) ) {
                $row = $obj[$i];
                $ext = array(
                    "1"=>"ในพื้นที่โครงการปิดทองฯ",
                    "2"=>"นอกพื้นที่โครงการปิดทองฯ",
                    "3"=>"อื่นๆ"
                );
                $from = $ext[$row["from_id"]];
                if( $row["from_id"]=="3" ) $from .= " ( ".$row["from_assign"]." )";
                $ext = array(
                    "1"=>"ตลาดในชุมชน",
                    "2"=>"พ่อค้าในพื้นที่",
                    "3"=>"พ่อค้านอกพื้นที่",
                    "4"=>"สหกรณ์",
                    "5"=>"แมคโคร/โลตัส/บิ๊กซี",
                    "6"=>"บริโภค"
                );
                $market = $ext[$row["market_id"]];
                SetValue($COL, $ROW, $row["type"]); $COL++;
                SetValue($COL, $ROW, $row["plant"]); $COL++;
                SetValue($COL, $ROW, $row["year"]); $COL++;
                SetValue($COL, $ROW, $from); $COL++;
                SetValue($COL, $ROW, $row["rai"]."/".$row["ngan"]."/".$row["wa"]); $COL++;
                SetValue($COL, $ROW, $row["kg1"]); $COL++;
                SetValue($COL, $ROW, $row["kg2"]); $COL++;
                SetValue($COL, $ROW, $row["kg3"]); $COL++;
                SetValue($COL, $ROW, $row["kg4"]); $COL++;
                SetValue($COL, $ROW, $row["price"]); $COL++;
                SetValue($COL, $ROW, $row["income"]); $COL++;
                SetValue($COL, $ROW, $row["cost"]); $COL++;
                SetValue($COL, $ROW, $row["total_price"]); $COL++;
                SetValue($COL, $ROW, $market); $COL++;
            } else {
                for($j=0; $j<14; $j++) {
                    SetValue($COL, $ROW, "-"); $COL++;
                }
            }
        }
        // รายได้จากการปลูกพืชผักสวนครัว/พืชอายุสั้น (ลดรายจ่ายและเชิงพาณิชย์)
        $sql = "
            SELECT 
                income2.*
            FROM income2
            WHERE income2.home_id='".$data["home_id"]."'
            ORDER BY income2.order_id
            LIMIT ".$LIMIT."
        ";
        $obj = $DATABASE->QueryObj($sql);
        for($i=0; $i<$LIMIT; $i++) {
            if( isset($obj[$i]) ) {
                $row = $obj[$i];
                $ext = array(
                    "1"=>"ในพื้นที่โครงการปิดทองฯ",
                    "2"=>"นอกพื้นที่โครงการปิดทองฯ",
                    "3"=>"อื่นๆ"
                );
                $from = $ext[$row["from_id"]];
                if( $row["from_id"]=="3" ) $from .= " ( ".$row["from_assign"]." )";
                $ext = array(
                    "1"=>"ตลาดในชุมชน",
                    "2"=>"พ่อค้าในพื้นที่",
                    "3"=>"พ่อค้านอกพื้นที่",
                    "4"=>"สหกรณ์",
                    "5"=>"แมคโคร/โลตัส/บิ๊กซี",
                    "6"=>"บริโภค"
                );
                $market = $ext[$row["market_id"]];
                SetValue($COL, $ROW, $row["type"]); $COL++;
                SetValue($COL, $ROW, $row["plant"]); $COL++;
                SetValue($COL, $ROW, $row["year"]); $COL++;
                SetValue($COL, $ROW, $from); $COL++;
                SetValue($COL, $ROW, $row["rai"]."/".$row["ngan"]."/".$row["wa"]); $COL++;
                SetValue($COL, $ROW, $row["kg1"]); $COL++;
                SetValue($COL, $ROW, $row["kg2"]); $COL++;
                SetValue($COL, $ROW, $row["kg3"]); $COL++;
                SetValue($COL, $ROW, $row["kg4"]); $COL++;
                SetValue($COL, $ROW, $row["price"]); $COL++;
                SetValue($COL, $ROW, $row["income"]); $COL++;
                SetValue($COL, $ROW, $row["cost"]); $COL++;
                SetValue($COL, $ROW, $row["total_price"]); $COL++;
                SetValue($COL, $ROW, $market); $COL++;
            } else {
                for($j=0; $j<14; $j++) {
                    SetValue($COL, $ROW, "-"); $COL++;
                }
            }
        }
        // รายได้จากการปลูกพืชไร่
        $sql = "
            SELECT 
                income3.*
            FROM income3
            WHERE income3.home_id='".$data["home_id"]."'
            ORDER BY income3.order_id
            LIMIT ".$LIMIT."
        ";
        $obj = $DATABASE->QueryObj($sql);
        for($i=0; $i<$LIMIT; $i++) {
            if( isset($obj[$i]) ) {
                $row = $obj[$i];
                $ext = array(
                    "1"=>"กก.",
                    "2"=>"ดอก",
                );
                $unit = $ext[$row["unit"]];
                $ext = array(
                    "1"=>"ในพื้นที่โครงการปิดทองฯ",
                    "2"=>"นอกพื้นที่โครงการปิดทองฯ",
                    "3"=>"อื่นๆ"
                );
                $from = $ext[$row["from_id"]];
                if( $row["from_id"]=="3" ) $from .= " ( ".$row["from_assign"]." )";
                $ext = array(
                    "1"=>"ตลาดในชุมชน",
                    "2"=>"พ่อค้าในพื้นที่",
                    "3"=>"พ่อค้านอกพื้นที่",
                    "4"=>"สหกรณ์",
                    "5"=>"แมคโคร/โลตัส/บิ๊กซี",
                    "6"=>"บริโภค"
                );
                $market = $ext[$row["market_id"]];
                SetValue($COL, $ROW, $row["type"]); $COL++;
                SetValue($COL, $ROW, $row["plant"]); $COL++;
                SetValue($COL, $ROW, $row["year"]); $COL++;
                SetValue($COL, $ROW, $from); $COL++;
                SetValue($COL, $ROW, $row["rai"]."/".$row["ngan"]."/".$row["wa"]); $COL++;
                SetValue($COL, $ROW, $row["kg1"]." ".$unit."/ไร่/ปี"); $COL++;
                SetValue($COL, $ROW, $row["kg2"]." ".$unit."/ปี"); $COL++;
                SetValue($COL, $ROW, $row["kg3"]." ".$unit."/ปี"); $COL++;
                SetValue($COL, $ROW, $row["kg4"]." ".$unit."/ปี"); $COL++;
                SetValue($COL, $ROW, $row["price"]." บาท/".$unit); $COL++;
                SetValue($COL, $ROW, $row["income"]); $COL++;
                SetValue($COL, $ROW, $row["cost"]); $COL++;
                SetValue($COL, $ROW, $row["total_price"]); $COL++;
                SetValue($COL, $ROW, $market); $COL++;
            } else {
                for($j=0; $j<14; $j++) {
                    SetValue($COL, $ROW, "-"); $COL++;
                }
            }
        }
        // รายได้จากการปลูกพืชสวน
        $sql = "
            SELECT 
                income4.*
            FROM income4
            WHERE income4.home_id='".$data["home_id"]."'
            ORDER BY income4.order_id
            LIMIT ".$LIMIT."
        ";
        $obj = $DATABASE->QueryObj($sql);
        for($i=0; $i<$LIMIT; $i++) {
            if( isset($obj[$i]) ) {
                $row = $obj[$i];
                $ext = array(
                    "1"=>"กก.",
                    "2"=>"ลูก",
                );
                $unit = $ext[$row["unit"]];
                $ext = array(
                    "1"=>"ในพื้นที่โครงการปิดทองฯ",
                    "2"=>"นอกพื้นที่โครงการปิดทองฯ",
                    "3"=>"อื่นๆ"
                );
                $from = $ext[$row["from_id"]];
                if( $row["from_id"]=="3" ) $from .= " ( ".$row["from_assign"]." )";
                $ext = array(
                    "1"=>"ตลาดในชุมชน",
                    "2"=>"พ่อค้าในพื้นที่",
                    "3"=>"พ่อค้านอกพื้นที่",
                    "4"=>"สหกรณ์",
                    "5"=>"แมคโคร/โลตัส/บิ๊กซี",
                    "6"=>"บริโภค"
                );
                $market = $ext[$row["market_id"]];
                SetValue($COL, $ROW, $row["type"]); $COL++;
                SetValue($COL, $ROW, $row["plant"]); $COL++;
                SetValue($COL, $ROW, $row["year"]); $COL++;
                SetValue($COL, $ROW, $from); $COL++;
                SetValue($COL, $ROW, $row["rai"]."/".$row["ngan"]."/".$row["wa"]); $COL++;
                SetValue($COL, $ROW, $row["kg1"]." ".$unit."/ไร่/ปี"); $COL++;
                SetValue($COL, $ROW, $row["kg2"]." ".$unit."/ปี"); $COL++;
                SetValue($COL, $ROW, $row["kg3"]." ".$unit."/ปี"); $COL++;
                SetValue($COL, $ROW, $row["kg4"]." ".$unit."/ปี"); $COL++;
                SetValue($COL, $ROW, $row["price"]." บาท/".$unit); $COL++;
                SetValue($COL, $ROW, $row["income"]); $COL++;
                SetValue($COL, $ROW, $row["cost"]); $COL++;
                SetValue($COL, $ROW, $row["total_price"]); $COL++;
                SetValue($COL, $ROW, $market); $COL++;
            } else {
                for($j=0; $j<14; $j++) {
                    SetValue($COL, $ROW, "-"); $COL++;
                }
            }
        }
        // รายได้จากปศุสัตว์ (ถ้าเลี้ยงเป็ด/ไก่ ให้ระบุรายได้จากการขายไข่และเนื้อด้วย)
        $sql = "
            SELECT 
                income5.*
            FROM income5
            WHERE income5.home_id='".$data["home_id"]."'
            ORDER BY income5.order_id
            LIMIT ".$LIMIT."
        ";
        $obj = $DATABASE->QueryObj($sql);
        for($i=0; $i<$LIMIT; $i++) {
            if( isset($obj[$i]) ) {
                $row = $obj[$i];
                $ext = array(
                    "1"=>"กก.",
                    "2"=>"ตัว",
                    "3"=>"ฟอง",
                );
                $unit = $ext[$row["unit"]];
                SetValue($COL, $ROW, $row["type"]); $COL++;
                SetValue($COL, $ROW, $row["year"]); $COL++;
                SetValue($COL, $ROW, $row["kg1"]." ".$unit."/ปี"); $COL++;
                SetValue($COL, $ROW, $row["kg2"]." ".$unit."/ปี"); $COL++;
                SetValue($COL, $ROW, $row["kg3"]." ".$unit."/ปี"); $COL++;
                SetValue($COL, $ROW, $row["price"]." บาท/".$unit); $COL++;
                SetValue($COL, $ROW, $row["income"]); $COL++;
                SetValue($COL, $ROW, $row["cost1"]); $COL++;
                SetValue($COL, $ROW, $row["cost2"]); $COL++;
                SetValue($COL, $ROW, $row["cost3"]); $COL++;
                SetValue($COL, $ROW, $row["cost4"]); $COL++;
                SetValue($COL, $ROW, $row["cost"]); $COL++;
                SetValue($COL, $ROW, $row["total_price"]); $COL++;
            } else {
                for($j=0; $j<13; $j++) {
                    SetValue($COL, $ROW, "-"); $COL++;
                }
            }
        }
        // รายได้จากประมง
        $sql = "
            SELECT 
                income6.*
            FROM income6
            WHERE income6.home_id='".$data["home_id"]."'
            ORDER BY income6.order_id
            LIMIT ".$LIMIT."
        ";
        $obj = $DATABASE->QueryObj($sql);
        for($i=0; $i<$LIMIT; $i++) {
            if( isset($obj[$i]) ) {
                $row = $obj[$i];
                SetValue($COL, $ROW, $row["type"]); $COL++;
                SetValue($COL, $ROW, $row["year"]); $COL++;
                SetValue($COL, $ROW, $row["kg1"]); $COL++;
                SetValue($COL, $ROW, $row["kg2"]); $COL++;
                SetValue($COL, $ROW, $row["kg3"]); $COL++;
                SetValue($COL, $ROW, $row["price"]); $COL++;
                SetValue($COL, $ROW, $row["income"]); $COL++;
                SetValue($COL, $ROW, $row["cost1"]); $COL++;
                SetValue($COL, $ROW, $row["cost2"]); $COL++;
                SetValue($COL, $ROW, $row["cost3"]); $COL++;
                SetValue($COL, $ROW, $row["cost4"]); $COL++;
                SetValue($COL, $ROW, $row["cost"]); $COL++;
                SetValue($COL, $ROW, $row["total_price"]); $COL++;
            } else {
                for($j=0; $j<13; $j++) {
                    SetValue($COL, $ROW, "-"); $COL++;
                }
            }
        }
        // รายได้จากหัตถกรรม
        $sql = "
            SELECT 
                income7.*
            FROM income7
            WHERE income7.home_id='".$data["home_id"]."'
            ORDER BY income7.order_id
            LIMIT ".$LIMIT."
        ";
        $obj = $DATABASE->QueryObj($sql);
        for($i=0; $i<$LIMIT; $i++) {
            if( isset($obj[$i]) ) {
                $row = $obj[$i];
                SetValue($COL, $ROW, $row["type"]); $COL++;
                SetValue($COL, $ROW, $row["year"]); $COL++;
                SetValue($COL, $ROW, $row["kg1"]); $COL++;
                SetValue($COL, $ROW, $row["kg2"]); $COL++;
                SetValue($COL, $ROW, $row["income"]); $COL++;
                SetValue($COL, $ROW, $row["cost"]); $COL++;
                SetValue($COL, $ROW, $row["total_price"]); $COL++;
                SetValue($COL, $ROW, $row["market"]); $COL++;
            } else {
                for($j=0; $j<8; $j++) {
                    SetValue($COL, $ROW, "-"); $COL++;
                }
            }
        }
        // รายได้จากการค้าขาย (ร้านขายของชำ/อาหารตามสั่ง/ปั้มน้ำมัน/ทำอาหารขาย)
        $sql = "
            SELECT 
                income8.*
            FROM income8
            WHERE income8.home_id='".$data["home_id"]."'
            ORDER BY income8.order_id
            LIMIT ".$LIMIT."
        ";
        $obj = $DATABASE->QueryObj($sql);
        for($i=0; $i<$LIMIT; $i++) {
            if( isset($obj[$i]) ) {
                $row = $obj[$i];
                SetValue($COL, $ROW, $row["type"]); $COL++;
                SetValue($COL, $ROW, $row["year"]); $COL++;
                SetValue($COL, $ROW, $row["income"]); $COL++;
                SetValue($COL, $ROW, $row["cost"]); $COL++;
                SetValue($COL, $ROW, $row["total_price"]); $COL++;
                SetValue($COL, $ROW, $row["market"]); $COL++;
            } else {
                for($j=0; $j<6; $j++) {
                    SetValue($COL, $ROW, "-"); $COL++;
                }
            }
        }
        // รายได้จากอาหารธรรมชาติ (การลดรายจ่าย)
        $sql = "
            SELECT 
                income9.*
            FROM income9
            WHERE income9.home_id='".$data["home_id"]."'
            ORDER BY income9.order_id
            LIMIT ".$LIMIT."
        ";
        $obj = $DATABASE->QueryObj($sql);
        for($i=0; $i<$LIMIT; $i++) {
            if( isset($obj[$i]) ) {
                $row = $obj[$i];
                SetValue($COL, $ROW, $row["type"]); $COL++;
                SetValue($COL, $ROW, $row["season"]); $COL++;
                SetValue($COL, $ROW, $row["place"]); $COL++;
                SetValue($COL, $ROW, $row["kg1"]); $COL++;
                SetValue($COL, $ROW, $row["kg2"]); $COL++;
                SetValue($COL, $ROW, $row["kg3"]); $COL++;
                SetValue($COL, $ROW, $row["income"]); $COL++;
                SetValue($COL, $ROW, $row["cost"]); $COL++;
                SetValue($COL, $ROW, $row["total_price"]); $COL++;
            } else {
                for($j=0; $j<9; $j++) {
                    SetValue($COL, $ROW, "-"); $COL++;
                }
            }
        }
        // รายได้อื่นๆ
        $sql = "
            SELECT
                income_other_item.income_other_item_id,
                income_other_item.income_other_item_name, 
                income_other.income
            FROM income_other_item
                LEFT JOIN income_other ON income_other_item.income_other_item_id = income_other.income_other_item_id 
                    AND income_other.home_id='".$data["home_id"]."'
            ORDER BY income_other_item.income_other_item_id
        ";
        $IncomeOther = $DATABASE->QueryObj($sql);
        foreach($IncomeOther as $key=>$row) {
            SetValue($COL, $ROW, $row["income"]); $COL++;
        }
        // รายได้จากสมาชิกในครัวเรือน (รายได้ประจำจากสมาชิกในครัวเรือน เช่น ผู้ใหญ่บ้าน ผู้ช่วย สอบต. นายก ตำรวจ ทหาร ครู)
        $sql = "
            SELECT 
                income_family.*,
                prefix.prefix_name,
                home_member.name,
                home_member.lname
            FROM income_family
                INNER JOIN home_member ON home_member.order_id=income_family.home_order_id
                    AND home_member.home_id='".$data["home_id"]."'
                INNER JOIN prefix ON prefix.prefix_id=home_member.prefix_id
            WHERE income_family.home_id='".$data["home_id"]."'
            ORDER BY income_family.order_id
            LIMIT ".$LIMIT."
        ";
        $IncomeFamily = $DATABASE->QueryObj($sql);
        $ext = array(
            "1"=>"ในพื้นที่",
            "2"=>"นอกพื้นที่",
        );
        for($i=0; $i<$LIMIT; $i++) {
            if( isset($IncomeFamily[$i]) ) {
                $row = $IncomeFamily[$i];
                SetValue($COL, $ROW, $row["prefix_name"].$row["name"]." ".$row["lname"]); $COL++;
                SetValue($COL, $ROW, $row["occupation"]); $COL++;
                SetValue($COL, $ROW, $row["amount"]); $COL++;
                SetValue($COL, $ROW, $ext[$row["place"]]); $COL++;
            } else {
                for($j=0; $j<4; $j++) {
                    SetValue($COL, $ROW, "-"); $COL++;
                }
            }
        }
        // เงินออม
        $sql = "
            SELECT
                saving_item.saving_item_id,
                saving_item.saving_item_name, 
                saving.amount
            FROM saving_item
                LEFT JOIN saving ON saving_item.saving_item_id = saving.saving_item_id 
                    AND saving.home_id='".$data["home_id"]."'
            ORDER BY saving_item.saving_item_id
        ";
        $Saving = $DATABASE->QueryObj($sql);
        foreach($Saving as $key=>$row) {
            SetValue($COL, $ROW, $row["amount"]); $COL++;
        }
        // เงินช่วยเหลือ
        $sql = "
            SELECT
                help_item.help_item_id,
                help_item.help_item_name, 
                help.num,
                help.income,
                help.total_price
            FROM help_item
                LEFT JOIN help ON help_item.help_item_id = help.help_item_id 
                    AND help.home_id='".$data["home_id"]."'
            ORDER BY help_item.help_item_id
        ";
        $Help = $DATABASE->QueryObj($sql);
        foreach($Help as $key=>$row) {
            SetValue($COL, $ROW, $row["num"]); $COL++;
            SetValue($COL, $ROW, $row["income"]); $COL++;
            SetValue($COL, $ROW, $row["total_price"]); $COL++;
        }
        // รายจ่าย
        $sql = "
            SELECT
                expense_item.expense_item_id,
                expense_item.expense_item_name, 
                expense.total_expense
            FROM expense_item
                    LEFT JOIN expense ON expense_item.expense_item_id = expense.expense_item_id 
                        AND expense.home_id='".$data["home_id"]."'
            WHERE expense_item.expense_type_id IN ('1', '2', '3')
            ORDER BY expense_item.expense_type_id, expense_item.expense_item_id
        ";
        $Expense = $DATABASE->QueryObj($sql);
        foreach($Expense as $key=>$row) {
            SetValue($COL, $ROW, $row["total_expense"]); $COL++;
        }
        // หนี้สิน
        $sql = "
            SELECT
                debt_item.debt_item_id,
                debt_item.debt_item_name, 
                debt.amount,
                debt.purpose
            FROM debt_item
                LEFT JOIN debt ON debt_item.debt_item_id = debt.debt_item_id 
                    AND debt.home_id='".$data["home_id"]."'
            ORDER BY debt_item.debt_item_id
        ";
        $Debt = $DATABASE->QueryObj($sql);
        $ext = array(
            "1"=>"เพื่อการอุปโภคบริโภค",
            "2"=>"เพื่อการลงทุน",
        );
        foreach($Debt as $key=>$row) {
            SetValue($COL, $ROW, $row["amount"]); $COL++;
            SetValue($COL, $ROW, $ext[$row["purpose"]]); $COL++;
        }

        $ROW++;
    }




    // MergeCell($COL, $COL+5, 1, 1, StyleHeader("e1e1e1"));
    // SetValue($COL, 1, "รายได้ภาคการเกษตร", StyleHeader("e1e1e1"));

    // MergeCell($COL, $COL+3, 2, 2, StyleHeader("e1e1e1"));
    // SetValue($COL, 2, "พืช", StyleHeader("e1e1e1"));

    // MergeCell($COL+4, $COL+4+1, 2, 2, StyleHeader("e1e1e1"));
    // SetValue($COL+4, 2, "สัตว์", StyleHeader("e1e1e1"));

    // SetValue($COL, 3, "ข้าว", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    // SetValue($COL, 3, "พืชผักสวนครัว/พืชอายุสั้น", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    // SetValue($COL, 3, "พืชไร่", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    // SetValue($COL, 3, "พืชสวน", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    // SetValue($COL, 3, "ปศุสัตว์", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    // SetValue($COL, 3, "ประมง", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;

    // $sql = "
    //     SELECT
    //         income_other_item.income_other_item_id,
    //         income_other_item.income_other_item_name
    //     FROM income_other_item
    //     ORDER BY income_other_item.income_other_item_id
    // ";
    // $objIncomeOtherItem = $DATABASE->QueryObj($sql);

    // SetValue($COL, 1, "รายได้นอกภาคการเกษตร", StyleHeader("e1e1e1"));
    // MergeCell($COL, $COL+3+sizeof($objIncomeOtherItem), 1, 1, StyleHeader("e1e1e1"));

    // SetValue($COL, 2, "หัตถกรรม", StyleHeader("e1e1e1")); MergeCell($COL, $COL, 2, 3, StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    // SetValue($COL, 2, "การค้าขาย", StyleHeader("e1e1e1")); MergeCell($COL, $COL, 2, 3, StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    // SetValue($COL, 2, "อาหารธรรมชาติ", StyleHeader("e1e1e1")); MergeCell($COL, $COL, 2, 3, StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;

    // SetValue($COL, 2, "รายได้อื่นๆ", StyleHeader("e1e1e1"));
    // MergeCell($COL, $COL+sizeof($objIncomeOtherItem)-1, 2, 2);
    // foreach($objIncomeOtherItem as $key=>$row) {
    //     SetValue($COL, 3, $row["income_other_item_name"], StyleHeader("e1e1e1"));
    //     SetWidth($COL, 15);
    //     $COL++;
    // }

    // SetValue($COL, 2, "สมาชิกในครัวเรือน", StyleHeader("e1e1e1")); MergeCell($COL, $COL, 2, 3, StyleHeader("e1e1e1")); SetWidth($COL, 15);$COL++;
    



    // MergeCell($COL, $COL+5, 1, 1, StyleHeader("e1e1e1"));
    // SetValue($COL, 1, "ต้นทุนภาคการเกษตร", StyleHeader("e1e1e1"));

    // MergeCell($COL, $COL+3, 2, 2, StyleHeader("e1e1e1"));
    // SetValue($COL, 2, "พืช", StyleHeader("e1e1e1"));

    // MergeCell($COL+4, $COL+4+1, 2, 2, StyleHeader("e1e1e1"));
    // SetValue($COL+4, 2, "สัตว์", StyleHeader("e1e1e1"));

    // SetValue($COL, 3, "ข้าว", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    // SetValue($COL, 3, "พืชผักสวนครัว/พืชอายุสั้น", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    // SetValue($COL, 3, "พืชไร่", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    // SetValue($COL, 3, "พืชสวน", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    // SetValue($COL, 3, "ปศุสัตว์", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    // SetValue($COL, 3, "ประมง", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;

    // SetValue($COL, 1, "ต้นทุนนอกภาคการเกษตร", StyleHeader("e1e1e1"));
    // MergeCell($COL, $COL+2, 1, 1, StyleHeader("e1e1e1"));

    // SetValue($COL, 2, "หัตถกรรม", StyleHeader("e1e1e1")); MergeCell($COL, $COL, 2, 3, StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    // SetValue($COL, 2, "การค้าขาย", StyleHeader("e1e1e1")); MergeCell($COL, $COL, 2, 3, StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    // SetValue($COL, 2, "อาหารธรรมชาติ", StyleHeader("e1e1e1")); MergeCell($COL, $COL, 2, 3, StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;


    // $sql = "
    //     SELECT
    //         saving_item.saving_item_id,
    //         saving_item.saving_item_name
    //     FROM saving_item
    //     ORDER BY saving_item.saving_item_id
    // ";
    // $objSavingItem = $DATABASE->QueryObj($sql);
    // SetValue($COL, 1, "เงินออม", StyleHeader("e1e1e1"));
    // MergeCell($COL, $COL+sizeof($objSavingItem)-1, 1, 1);
    // foreach($objSavingItem as $key=>$row) {
    //     SetValue($COL, 2, $row["saving_item_name"], StyleHeader("e1e1e1"));
    //     MergeCell($COL, $COL, 2, 3);
    //     SetWidth($COL, 15);
    //     $COL++;
    // }


    // $sql = "
    //     SELECT
    //         help_item.help_item_id,
    //         help_item.help_item_name
    //     FROM help_item
    //     ORDER BY help_item.help_item_id
    // ";
    // $objSavingItem = $DATABASE->QueryObj($sql);
    // SetValue($COL, 1, "เงินช่วยเหลือ", StyleHeader("e1e1e1"));
    // MergeCell($COL, $COL+sizeof($objSavingItem)-1, 1, 1);
    // foreach($objSavingItem as $key=>$row) {
    //     SetValue($COL, 2, $row["help_item_name"], StyleHeader("e1e1e1"));
    //     MergeCell($COL, $COL, 2, 3);
    //     SetWidth($COL, 15);
    //     $COL++;
    // }


    
    // $ExpenseType = array(
    //     "1"=>"ค่าใช้จ่ายเพื่อการบริโภค",
    //     "2"=>"ค่าใช้จ่ายเพื่อการอุปโภค",
    //     "3"=>"ค่าใช้จ่ายที่ไม่เกี่ยวกับการอุปโภคบริโภค"
    // );
    // $sql = "
    //     SELECT
    //         expense_item.expense_item_id,
    //         expense_item.expense_item_name,
    //         expense_item.expense_type_id
    //     FROM expense_item
    //     ORDER BY expense_item.expense_type_id, expense_item.expense_item_id
    // ";
    // $objExpenseItem = $DATABASE->QueryObj($sql);
    // SetValue($COL, 1, "รายจ่าย", StyleHeader("e1e1e1"));
    // MergeCell($COL, $COL+sizeof($objExpenseItem)-1, 1, 1);
    // $expense_type_id = "1";
    // $old = $COL;
    // foreach($objExpenseItem as $key=>$row) {
    //     if( $row["expense_type_id"]!=$expense_type_id ) {
    //         SetValue($old, 2, $ExpenseType[$expense_type_id], StyleHeader("e1e1e1"));
    //         MergeCell($old, $COL-1, 2, 2);
    //         $expense_type_id = $row["expense_type_id"];
    //         $old = $COL;
    //     }
    //     SetValue($COL, 3, $row["expense_item_name"], StyleHeader("e1e1e1"));
    //     SetWidth($COL, 15);
    //     $COL++;
    // }
    // SetValue($old, 2, $ExpenseType[$expense_type_id], StyleHeader("e1e1e1"));
    // MergeCell($old, $COL-1, 2, 2);
    


    // $sql = "
    //     SELECT
    //         debt_item.debt_item_id,
    //         debt_item.debt_item_name
    //     FROM debt_item
    //     ORDER BY debt_item.debt_item_id
    // ";
    // $objDebtItem = $DATABASE->QueryObj($sql);
    // SetValue($COL, 1, "หนี้สิน", StyleHeader("e1e1e1"));
    // MergeCell($COL, $COL+sizeof($objDebtItem)-1, 1, 1);
    // foreach($objDebtItem as $key=>$row) {
    //     SetValue($COL, 2, $row["debt_item_name"], StyleHeader("e1e1e1"));
    //     MergeCell($COL, $COL, 2, 3);
    //     SetWidth($COL, 15);
    //     $COL++;
    // }

    
    // $ROW = 4;

    // foreach($Datas as $key=>$data) {
    //     $COL = 0;
    //     $sql = "
    //         SELECT 
    //             home_member.*,
    //             prefix.prefix_name
    //         FROM home_member 
    //             INNER JOIN prefix ON prefix.prefix_id=home_member.prefix_id
    //         WHERE home_id='".$data["home_id"]."'
    //     ";
    //     $obj = $DATABASE->QueryObj($sql);
    //     $owner = array();
    //     $member = sizeof($obj);
    //     foreach($obj as $row) {
    //         if( $row["relation_id"]=="1" ) $owner[] = $row["prefix_name"].$row["name"]." ".$row["lname"];
    //     }
    //     if( sizeof($owner)==0 ) $owner = "ไม่พบเจ้าของบ้าน";
    //     else $owner = implode(", ", $owner);


    //     SetValue($COL, $ROW, ($ROW-3).""); $COL++;
    //     SetValue($COL, $ROW, $data["form_code"]); $COL++;
    //     SetValue($COL, $ROW, $data["home_code"]); $COL++;
    //     SetValue($COL, $ROW, $data["village_name"]); $COL++;
    //     SetValue($COL, $ROW, $data["home_no"]); $COL++;
    //     SetValue($COL, $ROW, $data["moo"]); $COL++;
    //     SetValue($COL, $ROW, $data["tambol_name_thai"]); $COL++;
    //     SetValue($COL, $ROW, $data["amphur_name_thai"]); $COL++;
    //     SetValue($COL, $ROW, $data["province_name_thai"]); $COL++;
    //     SetValue($COL, $ROW, $data["zipcode"]); $COL++;
    //     SetValue($COL, $ROW, $owner); $COL++;
    //     SetValue($COL, $ROW, $data["phone"]); $COL++;
    //     SetValue($COL, $ROW, $data["family"]); $COL++;
    //     SetValue($COL, $ROW, $member.""); $COL++;
    //     SetValue($COL, $ROW, $data["income1"]); $COL++;
    //     SetValue($COL, $ROW, $data["income2"]); $COL++;
    //     SetValue($COL, $ROW, $data["income3"]); $COL++;
    //     SetValue($COL, $ROW, $data["income4"]); $COL++;
    //     SetValue($COL, $ROW, $data["income5"]); $COL++;
    //     SetValue($COL, $ROW, $data["income6"]); $COL++;
    //     SetValue($COL, $ROW, $data["income7"]); $COL++;
    //     SetValue($COL, $ROW, $data["income8"]); $COL++;
    //     SetValue($COL, $ROW, $data["income9"]); $COL++;

    //     $sql = "
    //         SELECT
    //             income_other_item.income_other_item_id,
    //             income_other_item.income_other_item_name, 
    //             income_other.income
    //         FROM income_other_item
    //             LEFT JOIN income_other ON income_other_item.income_other_item_id = income_other.income_other_item_id 
    //                 AND income_other.home_id='".$data["home_id"]."'
    //         ORDER BY income_other_item.income_other_item_id
    //     ";
    //     $objIncomeOther = $DATABASE->QueryObj($sql);
    //     foreach($objIncomeOther as $key=>$row) {
    //         SetValue($COL, $ROW, $row["income"]);
    //         $COL++;
    //     }
    //     SetValue($COL, $ROW, $data["income_family"]); $COL++;
    //     SetValue($COL, $ROW, $data["cost1"]); $COL++;
    //     SetValue($COL, $ROW, $data["cost2"]); $COL++;
    //     SetValue($COL, $ROW, $data["cost3"]); $COL++;
    //     SetValue($COL, $ROW, $data["cost4"]); $COL++;
    //     SetValue($COL, $ROW, $data["cost5"]); $COL++;
    //     SetValue($COL, $ROW, $data["cost6"]); $COL++;
    //     SetValue($COL, $ROW, $data["cost7"]); $COL++;
    //     SetValue($COL, $ROW, $data["cost8"]); $COL++;
    //     SetValue($COL, $ROW, $data["cost9"]); $COL++;
    //     $sql = "
    //         SELECT
    //             saving_item.saving_item_id,
    //             saving_item.saving_item_name, 
    //             saving.amount
    //         FROM saving_item
    //             LEFT JOIN saving ON saving_item.saving_item_id = saving.saving_item_id 
    //                 AND saving.home_id='".$data["home_id"]."'
    //         ORDER BY saving_item.saving_item_id
    //     ";
    //     $objSaving = $DATABASE->QueryObj($sql);
    //     foreach($objSaving as $key=>$row) {
    //         SetValue($COL, $ROW, $row["amount"]);
    //         $COL++;
    //     }
        
    //     $sql = "
    //         SELECT
    //             help_item.help_item_id,
    //             help_item.help_item_name, 
    //             help.total_price
    //         FROM help_item
    //             LEFT JOIN help ON help_item.help_item_id = help.help_item_id 
    //                 AND help.home_id='".$data["home_id"]."'
    //         ORDER BY help_item.help_item_id
    //     ";
    //     $objSaving = $DATABASE->QueryObj($sql);
    //     foreach($objSaving as $key=>$row) {
    //         SetValue($COL, $ROW, $row["total_price"]);
    //         $COL++;
    //     }

    //     $sql = "
    //         SELECT
    //             expense_item.expense_item_id,
    //             expense_item.expense_item_name, 
    //             expense.total_expense
    //         FROM expense_item
    //                 LEFT JOIN expense ON expense_item.expense_item_id = expense.expense_item_id 
    //                     AND expense.home_id='".$data["home_id"]."'
    //         WHERE expense_item.expense_type_id='1'
    //         ORDER BY expense_item.expense_item_id
    //     ";
    //     $objSaving = $DATABASE->QueryObj($sql);
    //     foreach($objSaving as $key=>$row) {
    //         SetValue($COL, $ROW, $row["total_expense"]);
    //         $COL++;
    //     }

    //     $sql = "
    //         SELECT
    //             expense_item.expense_item_id,
    //             expense_item.expense_item_name, 
    //             expense.total_expense
    //         FROM expense_item
    //                 LEFT JOIN expense ON expense_item.expense_item_id = expense.expense_item_id 
    //                     AND expense.home_id='".$data["home_id"]."'
    //         WHERE expense_item.expense_type_id='2'
    //         ORDER BY expense_item.expense_item_id
    //     ";
    //     $objSaving = $DATABASE->QueryObj($sql);
    //     foreach($objSaving as $key=>$row) {
    //         SetValue($COL, $ROW, $row["total_expense"]);
    //         $COL++;
    //     }

    //     $sql = "
    //         SELECT
    //             expense_item.expense_item_id,
    //             expense_item.expense_item_name, 
    //             expense.total_expense
    //         FROM expense_item
    //                 LEFT JOIN expense ON expense_item.expense_item_id = expense.expense_item_id 
    //                     AND expense.home_id='".$data["home_id"]."'
    //         WHERE expense_item.expense_type_id='3'
    //         ORDER BY expense_item.expense_item_id
    //     ";
    //     $objSaving = $DATABASE->QueryObj($sql);
    //     foreach($objSaving as $key=>$row) {
    //         SetValue($COL, $ROW, $row["total_expense"]);
    //         $COL++;
    //     }
        
    //     $sql = "
    //         SELECT
    //             debt_item.debt_item_id,
    //             debt_item.debt_item_name, 
    //             debt.amount
    //         FROM debt_item
    //             LEFT JOIN debt ON debt_item.debt_item_id = debt.debt_item_id 
    //                 AND debt.home_id='".$data["home_id"]."'
    //         ORDER BY debt_item.debt_item_id
    //     ";
    //     $objSaving = $DATABASE->QueryObj($sql);
    //     foreach($objSaving as $key=>$row) {
    //         SetValue($COL, $ROW, $row["amount"]);
    //         $COL++;
    //     }


    //     $ROW++;
    // }
    
    /*
    // Redirect output to a client’s web browser (Excel2007)
	header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="'.$filename.'"');
	header('Cache-Control: max-age=0');
	// If you're serving to IE 9, then the following may be needed
	header('Cache-Control: max-age=1');
	// If you're serving to IE over SSL, then the following may be needed
	header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
	header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
	header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
	header ('Pragma: public'); // HTTP/1.0
	
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');*/

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save($filename);

    echo json_encode(array(
        "status"=>true,
        "filename"=>$filename
    ));