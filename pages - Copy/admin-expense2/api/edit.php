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

    if( $DATABASE->QueryHaving("item_expense2", "item_expense2_name", $data["item_expense2_name"], "item_expense2_id", $data["item_expense2_id"]) ) {
        echo json_encode(array(
            "status"=>false,
            "message"=>"ไม่สามารถแก้ไขได้ เนื่องจากข้อมูลนี้มีอยู่แล้ว"
        ));
        exit();
    }
    if( $DATABASE->QueryHaving("expense2", "item_expense2_id", $data["item_expense2_id"]) ) {
        echo json_encode(array(
            "status"=>false,
            "message"=>"ไม่สามารถลบได้ เนื่องจากข้อมูลนี้ถูกใช้งานแล้ว"
        ));
        exit();
    }
    // if( $DATABASE->QueryHaving("user_tmp", "item_expense2_id", $data["item_expense2_id"]) ) {
    //     echo json_encode(array(
    //         "status"=>false,
    //         "message"=>"ไม่สามารถแก้ไขได้ เนื่องจากข้อมูลนี้ถูกใช้งานแล้ว"
    //     ));
    //     exit();
    // }
    $data["user"] = $USER["user_id"];
    $data["date"] = date("Y-m-d H:i:s");
    if( $DATABASE->QueryUpdate("item_expense2", $data, " item_expense2_id='".$data["item_expense2_id"]."' ") ) {
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