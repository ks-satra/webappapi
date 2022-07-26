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
    $data["device_lend_id"] = $DATABASE->QueryMaxId("device_lend", "device_lend_id");
    $data["user"] = $USER["user_id"];
    $data["date"] = date("Y-m-d H:i:s");

    // if( $DATABASE->QueryHaving("device_lend", "device_lend_no", $data["device_lend_no"]) ) {
    //     echo json_encode(array(
    //         "status"=>false,
    //         "message"=>"ไม่สามารถเพิ่มได้ เนื่องจากชื่ออุปกรณ์นี้มีอยู่แล้ว"
    //     ));
    //     exit();
    // }

    if( $DATABASE->QueryInsert("device_lend", $data) ) {
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