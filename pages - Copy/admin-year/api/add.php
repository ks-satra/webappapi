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

    if( $DATABASE->QueryHaving("year", "year_name", $data["year_name"]) ) {
        echo json_encode(array(
            "status"=>false,
            "message"=>"ไม่สามารถเพิ่มได้ เนื่องชื่อปีงบประมาณซ้ำ"
        ));
        exit();
    }
    $data["year_id"] = $DATABASE->QueryMaxId("year", "year_id");
    $data["default"] = "N";
    $data["user"] = $USER["user_id"];
    $data["date"] = date("Y-m-d H:i:s");
    $DATABASE->QueryInsert("year", $data);
    echo json_encode(array(
        "status"=>true,
        "message"=>"เพิ่มข้อมูลสำเร็จ"
    ));