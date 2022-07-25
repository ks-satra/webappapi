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
    $data["user"] = $USER["user_id"];
    $data["date"] = date("Y-m-d H:i:s");
    
    $data["kg1"] = ToNum($data["kg1"], 0);
    $data["kg2"] = ToNum($data["kg2"], 0);
    $data["kg3"] = ToNum($data["kg3"], 0);
    $data["cost"] = ToNum($data["cost"], 0);
    $data["income"] = $data["kg2"] + $data["kg3"];
    $data["total"] = $data["income"] - $data["cost"];

    if( $DATABASE->QueryUpdate("income11", $data, " home_id='".$data["home_id"]."' AND order_id='".$data["order_id"]."' ") ) {
        $step = 23; $DATABASE->QueryDelete("form_step", " home_id='".$data["home_id"]."' AND step='".$step."' ");
        echo json_encode(array(
            "status"=>true,
            "message"=>"แก้ไขข้อมูลสำเร็จ",
            "home_id"=>$data["home_id"]
        ));
    } else {
        echo json_encode(array(
            "status"=>false,
            "message"=>"ไม่สามารถติดต่อฐานข้อมูลได้"
        ));
    }