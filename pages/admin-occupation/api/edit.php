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

    // if( $DATABASE->QueryHaving("item_occupation", "item_occupation_name", $data["item_occupation_name"], "item_occupation_id", $data["item_occupation_id"]) ) {
    //     echo json_encode(array(
    //         "status"=>false,
    //         "message"=>"ไม่สามารถแก้ไขได้ เนื่องจากข้อมูลนี้มีอยู่แล้ว"
    //     ));
    //     exit();
    // }
    if( $DATABASE->QueryHaving("home_member", "item_occupation_id", $data["item_occupation_id"]) ) {
        echo json_encode(array(
            "status"=>false,
            "message"=>"ไม่สามารถแก้ไขได้ เนื่องจากข้อมูลนี้ถูกใช้งานแล้ว"
        ));
        exit();
    }
    $data["user"] = $USER["user_id"];
    $data["date"] = date("Y-m-d H:i:s");
    if( $DATABASE->QueryUpdate("item_occupation", $data, " item_occupation_id='".$data["item_occupation_id"]."' ") ) {
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