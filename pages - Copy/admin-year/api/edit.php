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
    //         "message"=>"ไม่สามารถแก้ไขได้ เนื่องจากข้อมูลนี้ถูกใช้งานแล้ว"
    //     ));
    //     exit();
    // }
    // if( $DATABASE->QueryHaving("user_tmp", "area_province_id", $data["province_id"]) ) {
    //     echo json_encode(array(
    //         "status"=>false,
    //         "message"=>"ไม่สามารถแก้ไขได้ เนื่องจากข้อมูลนี้ถูกใช้งานแล้ว"
    //     ));
    //     exit();
    // }
    if( $DATABASE->QueryHaving("year", "year_name", $data["year_name"], "year_id", $data["year_id"]) ) {
        echo json_encode(array(
            "status"=>false,
            "message"=>"ไม่สามารถแก้ไขได้ เนื่องจากชื่อปีงบประมาณซ้ำ"
        ));
        exit();
    }
    
    $data["user"] = $USER["user_id"];
    $data["date"] = date("Y-m-d H:i:s");

    $DATABASE->QueryUpdate("year", $data, "year_id='".$data["year_id"]."' ");
    echo json_encode(array(
        "status"=>true,
        "message"=>"แก้ไขข้อมูลสำเร็จ"
    ));