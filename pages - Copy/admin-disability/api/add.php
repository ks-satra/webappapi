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

    if( $DATABASE->QueryHaving("item_disability", "item_disability_name", $data["item_disability_name"]) ) {
        echo json_encode(array(
            "status"=>false,
            "message"=>"ไม่สามารถเพิ่มได้ เนื่องจากข้อมูลนี้มีอยู่แล้ว"
        ));
        exit();
    }

    $data["item_disability_id"] = $DATABASE->QueryMaxId("item_disability", "item_disability_id");
    $data["user"] = $USER["user_id"];
    $data["date"] = date("Y-m-d H:i:s");
    if( $DATABASE->QueryInsert("item_disability", $data) ) {
        echo json_encode(array(
            "status"=>true,
            "message"=>"เพิ่มข้อมูลสำเร็จ"
        ));
    } else {
        echo json_encode(array(
            "status"=>false,
            "message"=>"ไม่สามารถติดต่อฐานข้อมูลได้"
        ));
    }