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
    $data["user"] = $USER["user_id"];
    $data["date"] = date("Y-m-d H:i:s");
    
    if( $DATABASE->QueryHaving("user", "email", $data["email"], "user_id", $data["user_id"]) ) {
        echo json_encode(array(
            "status"=>false,
            "message"=>"ไม่สามารถแก้ไขได้ เนื่องจากอีเมลนี้มีอยู่แล้ว"
        ));
        exit();
    }

    $sql = "SELECT * FROM user WHERE user_id='".$data["user_id"]."' ";
    $obj = $DATABASE->QueryObj($sql);
    $image = ( sizeof($obj)==1 ) ? $obj[0]["image"] : "";

    $upload = UploadFile("imagef", $dir, time(), $GLOBAL["ALLOW_IMAGE"]);
    if( $upload["status"]==true ) {
        RemoveFile($dir, $image);
        $data['image'] = $upload["fileName"];
    }
    
    if( $DATABASE->QueryUpdate("user", $data, " user_id='".$data["user_id"]."' ") ) {
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