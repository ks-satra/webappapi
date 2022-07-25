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
    
    $data["year"] = ToNum($data["year"], 0);

    $obj = $DATABASE->QueryObj("SELECT * FROM member_group WHERE home_id='".$data["home_id"]."' ");
    $data["order_id"] = sizeof($obj)+1;
    if( $DATABASE->QueryInsert("member_group", $data) ) {
        $step = 34; $DATABASE->QueryDelete("form_step", " home_id='".$data["home_id"]."' AND step='".$step."' ");
        echo json_encode(array(
            "status"=>true,
            "message"=>"เพิ่มข้อมูลสำเร็จ",
            "home_id"=>$data["home_id"]
        ));
    } else {
        echo json_encode(array(
            "status"=>false,
            "message"=>"ไม่สามารถติดต่อฐานข้อมูลได้"
        ));
    }