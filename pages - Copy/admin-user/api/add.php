<?php
    include_once("../../../php/autoload.php");

    if( $USER==null ) {
        echo json_encode(array(
            "status"=>false,
            "message"=>"Session การเข้าสู่ระบบหมดอายุ กรุณาเข้าสู่ระบบใหม่อีกครั้ง"
        ));
        exit();
    }
    $dir = "../../../files/user/";

    $data = $_POST;
    $data["user_id"] = $DATABASE->QueryMaxId("user", "user_id");
    $data["user"] = $USER["user_id"];
    $data["date"] = date("Y-m-d H:i:s");

    if( $DATABASE->QueryHaving("user", "email", $data["email"]) ) {
        echo json_encode(array(
            "status"=>false,
            "message"=>"ไม่สามารถเพิ่มได้ เนื่องจากอีเมลนี้มีอยู่แล้ว"
        ));
        exit();
    }

    $upload = UploadFile("imagef", $dir, time(), $GLOBAL["ALLOW_IMAGE"]);
    $data['image'] = $upload["fileName"];
    if( $DATABASE->QueryInsert("user", $data) ) {
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