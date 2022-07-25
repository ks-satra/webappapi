<?php
    include_once("../../../php/autoload.php");
    include_once("../../../assets/uiExcelUpload/PHPExcel-1.8/Classes/PHPExcel.php");
    include_once("../../../assets/uiExcelUpload/PHPExcel-1.8/Classes/PHPExcel/IOFactory.php");
    // ini_set('max_execution_time', 14400); // 4 hours 
    // ini_set('memory_limit', '2048M');
    if( $USER==null ) {
        echo "กรุณาเข้าสู่ระบบก่อนใช้งาน";
        exit();
    }

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

    $sql = "
        SELECT
            home.*, 
            tambol.tambol_name_thai, 
            amphur.amphur_name_thai, 
            province.province_name_thai,
            
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
        WHERE home.status='2'
        ORDER BY home.form_code
    ";
    $Datas = $DATABASE->QueryObj($sql);

    $COL = 0;
    $ROW = 1;

    SetValue($COL, 1, "ลำดับ", StyleHeader("e1e1e1")); MergeCell($COL, $COL, 1, 3, StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    SetValue($COL, 1, "หมายเลขแบบสำรวจ", StyleHeader("e1e1e1")); MergeCell($COL, $COL, 1, 3, StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
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
    
    MergeCell($COL, $COL+5, 1, 1, StyleHeader("e1e1e1"));
    SetValue($COL, 1, "รายได้ภาคการเกษตร", StyleHeader("e1e1e1"));

    MergeCell($COL, $COL+3, 2, 2, StyleHeader("e1e1e1"));
    SetValue($COL, 2, "พืช", StyleHeader("e1e1e1"));

    MergeCell($COL+4, $COL+4+1, 2, 2, StyleHeader("e1e1e1"));
    SetValue($COL+4, 2, "สัตว์", StyleHeader("e1e1e1"));

    SetValue($COL, 3, "ข้าว", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    SetValue($COL, 3, "พืชผักสวนครัว/พืชอายุสั้น", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    SetValue($COL, 3, "พืชไร่", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    SetValue($COL, 3, "พืชสวน", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    SetValue($COL, 3, "ปศุสัตว์", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    SetValue($COL, 3, "ประมง", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;

    $sql = "
        SELECT
            income_other_item.income_other_item_id,
            income_other_item.income_other_item_name
        FROM income_other_item
        ORDER BY income_other_item.income_other_item_id
    ";
    $objIncomeOtherItem = $DATABASE->QueryObj($sql);

    SetValue($COL, 1, "รายได้นอกภาคการเกษตร", StyleHeader("e1e1e1"));
    MergeCell($COL, $COL+3+sizeof($objIncomeOtherItem), 1, 1, StyleHeader("e1e1e1"));

    SetValue($COL, 2, "หัตถกรรม", StyleHeader("e1e1e1")); MergeCell($COL, $COL, 2, 3, StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    SetValue($COL, 2, "การค้าขาย", StyleHeader("e1e1e1")); MergeCell($COL, $COL, 2, 3, StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    SetValue($COL, 2, "อาหารธรรมชาติ", StyleHeader("e1e1e1")); MergeCell($COL, $COL, 2, 3, StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;

    SetValue($COL, 2, "รายได้อื่นๆ", StyleHeader("e1e1e1"));
    MergeCell($COL, $COL+sizeof($objIncomeOtherItem)-1, 2, 2);
    foreach($objIncomeOtherItem as $key=>$row) {
        SetValue($COL, 3, $row["income_other_item_name"], StyleHeader("e1e1e1"));
        SetWidth($COL, 15);
        $COL++;
    }

    SetValue($COL, 2, "สมาชิกในครัวเรือน", StyleHeader("e1e1e1")); MergeCell($COL, $COL, 2, 3, StyleHeader("e1e1e1")); SetWidth($COL, 15);$COL++;
    



    MergeCell($COL, $COL+5, 1, 1, StyleHeader("e1e1e1"));
    SetValue($COL, 1, "ต้นทุนภาคการเกษตร", StyleHeader("e1e1e1"));

    MergeCell($COL, $COL+3, 2, 2, StyleHeader("e1e1e1"));
    SetValue($COL, 2, "พืช", StyleHeader("e1e1e1"));

    MergeCell($COL+4, $COL+4+1, 2, 2, StyleHeader("e1e1e1"));
    SetValue($COL+4, 2, "สัตว์", StyleHeader("e1e1e1"));

    SetValue($COL, 3, "ข้าว", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    SetValue($COL, 3, "พืชผักสวนครัว/พืชอายุสั้น", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    SetValue($COL, 3, "พืชไร่", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    SetValue($COL, 3, "พืชสวน", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    SetValue($COL, 3, "ปศุสัตว์", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    SetValue($COL, 3, "ประมง", StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;

    SetValue($COL, 1, "ต้นทุนนอกภาคการเกษตร", StyleHeader("e1e1e1"));
    MergeCell($COL, $COL+2, 1, 1, StyleHeader("e1e1e1"));

    SetValue($COL, 2, "หัตถกรรม", StyleHeader("e1e1e1")); MergeCell($COL, $COL, 2, 3, StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    SetValue($COL, 2, "การค้าขาย", StyleHeader("e1e1e1")); MergeCell($COL, $COL, 2, 3, StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;
    SetValue($COL, 2, "อาหารธรรมชาติ", StyleHeader("e1e1e1")); MergeCell($COL, $COL, 2, 3, StyleHeader("e1e1e1")); SetWidth($COL, 15); $COL++;


    $sql = "
        SELECT
            saving_item.saving_item_id,
            saving_item.saving_item_name
        FROM saving_item
        ORDER BY saving_item.saving_item_id
    ";
    $objSavingItem = $DATABASE->QueryObj($sql);
    SetValue($COL, 1, "เงินออม", StyleHeader("e1e1e1"));
    MergeCell($COL, $COL+sizeof($objSavingItem)-1, 1, 1);
    foreach($objSavingItem as $key=>$row) {
        SetValue($COL, 2, $row["saving_item_name"], StyleHeader("e1e1e1"));
        MergeCell($COL, $COL, 2, 3);
        SetWidth($COL, 15);
        $COL++;
    }


    $sql = "
        SELECT
            help_item.help_item_id,
            help_item.help_item_name
        FROM help_item
        ORDER BY help_item.help_item_id
    ";
    $objSavingItem = $DATABASE->QueryObj($sql);
    SetValue($COL, 1, "เงินช่วยเหลือ", StyleHeader("e1e1e1"));
    MergeCell($COL, $COL+sizeof($objSavingItem)-1, 1, 1);
    foreach($objSavingItem as $key=>$row) {
        SetValue($COL, 2, $row["help_item_name"], StyleHeader("e1e1e1"));
        MergeCell($COL, $COL, 2, 3);
        SetWidth($COL, 15);
        $COL++;
    }


    
    $ExpenseType = array(
        "1"=>"ค่าใช้จ่ายเพื่อการบริโภค",
        "2"=>"ค่าใช้จ่ายเพื่อการอุปโภค",
        "3"=>"ค่าใช้จ่ายที่ไม่เกี่ยวกับการอุปโภคบริโภค"
    );
    $sql = "
        SELECT
            expense_item.expense_item_id,
            expense_item.expense_item_name,
            expense_item.expense_type_id
        FROM expense_item
        ORDER BY expense_item.expense_type_id, expense_item.expense_item_id
    ";
    $objExpenseItem = $DATABASE->QueryObj($sql);
    SetValue($COL, 1, "รายจ่าย", StyleHeader("e1e1e1"));
    MergeCell($COL, $COL+sizeof($objExpenseItem)-1, 1, 1);
    $expense_type_id = "1";
    $old = $COL;
    foreach($objExpenseItem as $key=>$row) {
        if( $row["expense_type_id"]!=$expense_type_id ) {
            SetValue($old, 2, $ExpenseType[$expense_type_id], StyleHeader("e1e1e1"));
            MergeCell($old, $COL-1, 2, 2);
            $expense_type_id = $row["expense_type_id"];
            $old = $COL;
        }
        SetValue($COL, 3, $row["expense_item_name"], StyleHeader("e1e1e1"));
        SetWidth($COL, 15);
        $COL++;
    }
    SetValue($old, 2, $ExpenseType[$expense_type_id], StyleHeader("e1e1e1"));
    MergeCell($old, $COL-1, 2, 2);
    


    $sql = "
        SELECT
            debt_item.debt_item_id,
            debt_item.debt_item_name
        FROM debt_item
        ORDER BY debt_item.debt_item_id
    ";
    $objDebtItem = $DATABASE->QueryObj($sql);
    SetValue($COL, 1, "หนี้สิน", StyleHeader("e1e1e1"));
    MergeCell($COL, $COL+sizeof($objDebtItem)-1, 1, 1);
    foreach($objDebtItem as $key=>$row) {
        SetValue($COL, 2, $row["debt_item_name"], StyleHeader("e1e1e1"));
        MergeCell($COL, $COL, 2, 3);
        SetWidth($COL, 15);
        $COL++;
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


        SetValue($COL, $ROW, ($ROW-3).""); $COL++;
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
        SetValue($COL, $ROW, $data["income1"]); $COL++;
        SetValue($COL, $ROW, $data["income2"]); $COL++;
        SetValue($COL, $ROW, $data["income3"]); $COL++;
        SetValue($COL, $ROW, $data["income4"]); $COL++;
        SetValue($COL, $ROW, $data["income5"]); $COL++;
        SetValue($COL, $ROW, $data["income6"]); $COL++;
        SetValue($COL, $ROW, $data["income7"]); $COL++;
        SetValue($COL, $ROW, $data["income8"]); $COL++;
        SetValue($COL, $ROW, $data["income9"]); $COL++;

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
        $objIncomeOther = $DATABASE->QueryObj($sql);
        foreach($objIncomeOther as $key=>$row) {
            SetValue($COL, $ROW, $row["income"]);
            $COL++;
        }
        SetValue($COL, $ROW, $data["income_family"]); $COL++;
        SetValue($COL, $ROW, $data["cost1"]); $COL++;
        SetValue($COL, $ROW, $data["cost2"]); $COL++;
        SetValue($COL, $ROW, $data["cost3"]); $COL++;
        SetValue($COL, $ROW, $data["cost4"]); $COL++;
        SetValue($COL, $ROW, $data["cost5"]); $COL++;
        SetValue($COL, $ROW, $data["cost6"]); $COL++;
        SetValue($COL, $ROW, $data["cost7"]); $COL++;
        SetValue($COL, $ROW, $data["cost8"]); $COL++;
        SetValue($COL, $ROW, $data["cost9"]); $COL++;
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
        $objSaving = $DATABASE->QueryObj($sql);
        foreach($objSaving as $key=>$row) {
            SetValue($COL, $ROW, $row["amount"]);
            $COL++;
        }
        
        $sql = "
            SELECT
                help_item.help_item_id,
                help_item.help_item_name, 
                help.total_price
            FROM help_item
                LEFT JOIN help ON help_item.help_item_id = help.help_item_id 
                    AND help.home_id='".$data["home_id"]."'
            ORDER BY help_item.help_item_id
        ";
        $objSaving = $DATABASE->QueryObj($sql);
        foreach($objSaving as $key=>$row) {
            SetValue($COL, $ROW, $row["total_price"]);
            $COL++;
        }

        $sql = "
            SELECT
                expense_item.expense_item_id,
                expense_item.expense_item_name, 
                expense.total_expense
            FROM expense_item
                    LEFT JOIN expense ON expense_item.expense_item_id = expense.expense_item_id 
                        AND expense.home_id='".$data["home_id"]."'
            WHERE expense_item.expense_type_id='1'
            ORDER BY expense_item.expense_item_id
        ";
        $objSaving = $DATABASE->QueryObj($sql);
        foreach($objSaving as $key=>$row) {
            SetValue($COL, $ROW, $row["total_expense"]);
            $COL++;
        }

        $sql = "
            SELECT
                expense_item.expense_item_id,
                expense_item.expense_item_name, 
                expense.total_expense
            FROM expense_item
                    LEFT JOIN expense ON expense_item.expense_item_id = expense.expense_item_id 
                        AND expense.home_id='".$data["home_id"]."'
            WHERE expense_item.expense_type_id='2'
            ORDER BY expense_item.expense_item_id
        ";
        $objSaving = $DATABASE->QueryObj($sql);
        foreach($objSaving as $key=>$row) {
            SetValue($COL, $ROW, $row["total_expense"]);
            $COL++;
        }

        $sql = "
            SELECT
                expense_item.expense_item_id,
                expense_item.expense_item_name, 
                expense.total_expense
            FROM expense_item
                    LEFT JOIN expense ON expense_item.expense_item_id = expense.expense_item_id 
                        AND expense.home_id='".$data["home_id"]."'
            WHERE expense_item.expense_type_id='3'
            ORDER BY expense_item.expense_item_id
        ";
        $objSaving = $DATABASE->QueryObj($sql);
        foreach($objSaving as $key=>$row) {
            SetValue($COL, $ROW, $row["total_expense"]);
            $COL++;
        }
        
        $sql = "
            SELECT
                debt_item.debt_item_id,
                debt_item.debt_item_name, 
                debt.amount
            FROM debt_item
                LEFT JOIN debt ON debt_item.debt_item_id = debt.debt_item_id 
                    AND debt.home_id='".$data["home_id"]."'
            ORDER BY debt_item.debt_item_id
        ";
        $objSaving = $DATABASE->QueryObj($sql);
        foreach($objSaving as $key=>$row) {
            SetValue($COL, $ROW, $row["amount"]);
            $COL++;
        }


        $ROW++;
    }
    
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