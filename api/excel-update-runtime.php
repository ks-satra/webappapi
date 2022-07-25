<?php
    include_once("../php/autoload.php");
    include_once("../excel/index.php");
    
    file_put_contents('../files/form-excel/test.txt', "test ". date("Y-m-d H:i:s") . PHP_EOL, FILE_APPEND);

    if( $DATABASE->QueryString("SELECT running FROM excel_running WHERE id='1' ")=="Y" ) {
        // echo json_encode(array(
        //     "status"=>false,
        //     "message"=>"ระบบกำลังรันข้อมูลอื่น ๆ อยู่"
        // ));
        // exit();
    }
    $DATABASE->QueryUpdate("excel_running", array(
        "running"=>"Y",
        "date"=>date("Y-m-d H:i:s")
    ), "id=1");

    
    $sql = "SELECT * FROM excel_update ORDER BY home_id LIMIT 2";
    $obj = $DATABASE->QueryObj($sql);
    $res = array();
    $count = 0;
    foreach($obj as $row) {
        $home_id = $row["home_id"];
        $r = ExcelUpdate($home_id);
        if( $r["status"] ) {
            $DATABASE->QueryDelete("excel_update", "home_id='".$r["home_id"]."'");
            $DATABASE->QueryInsert("excel_added", array(
                "home_id"=>$r["home_id"],
                "user"=>$row["user"],
                "date"=>date("Y-m-d H:i:s")
            ));
        }
        
        $res[] = $r;
        $count++;
    }

    $DATABASE->QueryUpdate("excel_running", array(
        "running"=>"N",
        "date"=>date("Y-m-d H:i:s")
    ), "id=1");
    
    echo json_encode(array(
        "status"=>true,
        "message"=>"อัพเดตแล้ว ".$count." รายการ",
        "res"=>$res
    ));
    

    // INSERT INTO excel_update SELECT home_id,user,date FROM home WHERE `status`='1';