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

    // if( $DATABASE->QueryHaving("user_area", "province_id", $data["province_id"]) ) {
    //     echo json_encode(array(
    //         "status"=>false,
    //         "message"=>"ไม่สามารถลบได้ เนื่องจากข้อมูลนี้ถูกใช้งานแล้ว"
    //     ));
    //     exit();
    // }
    // if( $DATABASE->QueryHaving("user_tmp", "area_province_id", $data["province_id"]) ) {
    //     echo json_encode(array(
    //         "status"=>false,
    //         "message"=>"ไม่สามารถลบได้ เนื่องจากข้อมูลนี้ถูกใช้งานแล้ว"
    //     ));
    //     exit();
    // }
    if( $DATABASE->QueryDelete("year", " year_id='".$data["year_id"]."' ") ) {
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