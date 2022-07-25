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

    if( $DATABASE->QueryHaving("area", "province_id", $data["province_id"]) ) {
        echo json_encode(array(
            "status"=>false,
            "message"=>"ไม่สามารถเพิ่มได้ เนื่องจากจังหวัดซ้ำ"
        ));
        exit();
    }
    if( $DATABASE->QueryHaving("area", "province_code", $data["province_code"]) ) {
        echo json_encode(array(
            "status"=>false,
            "message"=>"ไม่สามารถเพิ่มได้ เนื่องจากสัญลักษณ์ย่อพื้นที่ซ้ำ"
        ));
        exit();
    }

    $data["user"] = $USER["user_id"];
    $data["date"] = date("Y-m-d H:i:s");
    $DATABASE->QueryInsert("area", $data);
    echo json_encode(array(
        "status"=>true,
        "message"=>"เพิ่มข้อมูลสำเร็จ"
    ));