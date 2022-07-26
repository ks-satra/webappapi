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
    
    // if( $DATABASE->QueryHaving("device_back", "email_name", $data["email_name"], "device_back_id", $data["device_back_id"]) ) {
    //     echo json_encode(array(
    //         "status"=>false,
    //         "message"=>"ไม่สามารถแก้ไขได้ เนื่องจากชื่ออุปกรณ์นี้มีอยู่แล้ว"
    //     ));
    //     exit();
    // }

    $sql = "SELECT * FROM device_back WHERE device_back_id='".$data["device_back_id"]."' ";
    $obj = $DATABASE->QueryObj($sql);
    
    if( $DATABASE->QueryUpdate("device_back", $data, " device_back_id='".$data["device_back_id"]."' ") ) {
        echo json_encode(array(
            "status"=>true,
            "message"=>"แก้ไขข้อมูลสำเร็จ"
        ));
    } else {
        echo json_encode(array(
            "status"=>false,
            "message"=>"ไม่สามารถติดต่อฐานข้อมูลได้"
        ));
    }