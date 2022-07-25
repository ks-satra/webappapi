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

    if( $DATABASE->QueryHaving("user", "user", $data["user_id"]) ) {
        echo json_encode(array(
            "status"=>false,
            "message"=>"ไม่สามารถลบได้ เนื่องจากข้อมูลนี้ถูกใช้งานแล้ว"
        ));
        exit();
    }
    if( $DATABASE->QueryHaving("home", "user", $data["user_id"]) ) {
        echo json_encode(array(
            "status"=>false,
            "message"=>"ไม่สามารถลบได้ ผู้ใช้งานรายนี้เคยบันทึกแบบสำรวจ"
        ));
        exit();
    }

    $sql = "SELECT * FROM user WHERE user_id='".$data["user_id"]."' ";
    $obj = $DATABASE->QueryObj($sql);
    $image = ( sizeof($obj)==1 ) ? $obj[0]["image"] : "";
    if( $DATABASE->QueryDelete("user", " user_id='".$data["user_id"]."' ") ) {
        $DATABASE->QueryDelete("user_level", " user_id='".$data["user_id"]."' ");
        $DATABASE->QueryDelete("user_area", " user_id='".$data["user_id"]."' ");
        RemoveFile($dir, $image);
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