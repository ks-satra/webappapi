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
    $data["device_id"] = $DATABASE->QueryMaxId("device", "device_id");
    $data["user"] = $USER["user_id"];
    $data["date"] = date("Y-m-d H:i:s");

    if( $DATABASE->QueryHaving("device", "device_name", $data["device_name"]) ) {
        echo json_encode(array(
            "status"=>false,
            "message"=>"ไม่สามารถเพิ่มได้ เนื่องจากชื่ออุปกรณ์นี้มีอยู่แล้ว"
        ));
        exit();
    }

    if( $DATABASE->QueryInsert("device", $data) ) {
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