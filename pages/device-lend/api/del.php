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

    // if( $DATABASE->QueryHaving("device_lend_lend", "device_lend_id", $data["device_lend_id"]) ) {
    //     echo json_encode(array(
    //         "status"=>false,
    //         "message"=>"ไม่สามารถลบได้ เนื่องจากชื่ออุปกรณ์นี้ถูกใช้งานแล้ว"
    //     ));
    //     exit();
    // }

    if( $DATABASE->QueryDelete("device_lend", " device_lend_id='".$data["device_lend_id"]."' ") ) {
        echo json_encode(array(
            "status"=>true,
            "message"=>"ลบข้อมูลสำเร็จ"
        ));
    } else {
        echo json_encode(array(
            "status"=>false,
            "message"=>"ไม่สามารถติดต่อฐานข้อมูลได้"
        ));
    }