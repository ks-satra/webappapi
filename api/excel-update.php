<?php
    include_once("../php/autoload.php");
    include_once("../excel/index.php");

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

    $DATABASE->QueryUpdate("excel_running", array(
        "running"=>"N",
        "date"=>date("Y-m-d H:i:s")
    ), "id=1");

    $home_id = @$_GET["home_id"];
    $form_code = @$_GET["form_code"];
    
    $res = ExcelUpdate($home_id, $form_code);
    if( $res["status"] ) {
        $DATABASE->QueryDelete("excel_update", "home_id='".$res["home_id"]."'");
        $DATABASE->QueryInsert("excel_added", array(
            "home_id"=>$res["home_id"],
            "user"=>@$USER["user_id"],
            "date"=>date("Y-m-d H:i:s")
        ));
    }

    echo json_encode($res);
    