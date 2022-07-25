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
    if( $DATABASE->QueryHaving("user_tmp", "area_province_id", $data["province_id"]) ) {
        echo json_encode(array(
            "status"=>false,
            "message"=>"ไม่สามารถแก้ไขได้ เนื่องจากข้อมูลนี้ถูกใช้งานแล้ว"
        ));
        exit();
    }
    if( $DATABASE->QueryHaving("area", "province_code", $data["province_code"], "province_id", $data["province_id"]) ) {
        echo json_encode(array(
            "status"=>false,
            "message"=>"ไม่สามารถแก้ไขได้ เนื่องจากสัญลักษณ์ย่อพื้นที่ซ้ำ"
        ));
        exit();
    }
    
    $data["user"] = $USER["user_id"];
    $data["date"] = date("Y-m-d H:i:s");

    
    $DATABASE->QueryUpdate("area", $data, "province_id='".$data["province_id"]."' ");
    echo json_encode(array(
        "status"=>true,
        "message"=>"แก้ไขข้อมูลสำเร็จ"
    ));