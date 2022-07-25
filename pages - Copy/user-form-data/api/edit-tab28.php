<?php
    include_once("../../../php/autoload.php");

    if( $USER==null ) {
        echo json_encode(array(
            "status"=>false,
            "message"=>"Session การเข้าสู่ระบบหมดอายุ กรุณาเข้าสู่ระบบใหม่อีกครั้ง"
        ));
        exit();
    }
    $data = $_POST;

    $DATABASE->QueryDelete("expense1", "home_id='".$data["home_id"]."'");
    foreach($data["amount"] as $key=>$row) {
        $data["amount"][$key] = ToNum($data["amount"][$key]);
        $data["unit_id"][$key] = $data["unit_id"][$key];
        $data["total"][$key] = 0;
        if( $data["unit_id"][$key]=="1" ) $data["total"][$key] = $data["amount"][$key]*1*365;
        if( $data["unit_id"][$key]=="2" ) $data["total"][$key] = $data["amount"][$key]*1*12;
        if( $data["unit_id"][$key]=="3" ) $data["total"][$key] = $data["amount"][$key]*1*1;
        $field = array(
            "home_id"=>$data["home_id"],
            "item_expense1_id"=>$key,
            "amount"=>$data["amount"][$key],
            "unit_id"=>$data["unit_id"][$key],
            "total"=>$data["total"][$key],
            "user"=>$USER["user_id"],
            "date"=>date("Y-m-d H:i:s")
        );
        $DATABASE->QueryInsert("expense1", $field);
    }

    $step = 28; $DATABASE->QueryDelete("form_step", " home_id='".$data["home_id"]."' AND step='".$step."' "); $DATABASE->QueryInsert("form_step", array("home_id"=>$data["home_id"], "step"=>$step));
    echo json_encode(array(
        "status"=>true,
        "message"=>"บันทึกข้อมูลสำเร็จ",
        "home_id"=>$data["home_id"]
    ));