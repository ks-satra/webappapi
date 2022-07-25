<?php
    include_once("../../../php/autoload.php");

    if( $USER==null ) {
        echo json_encode(array(
            "status"=>false,
            "message"=>"Session การเข้าสู่ระบบหมดอายุ กรุณาเข้าสู่ระบบใหม่อีกครั้ง"
        ));
        exit();
    }

    $home_id = @$_POST["home_id"];

    $sql = "SELECT * FROM home WHERE home_id='".$home_id."' AND status='' ";
    $obj = $DATABASE->QueryObj($sql);
    if( sizeof($obj)==0 ) {
        echo json_encode(array(
            "status"=>false,
            "message"=>"ไม่พบข้อมูล"
        ));
        exit();
    }
    $home = $obj[0];
    if( $home["user"]!=$USER["user_id"] ) {
        echo json_encode(array(
            "status"=>false,
            "message"=>"คุณไม่ได้รับสิทธิ์ตอบรับการแก้ไข"
        ));
        exit();
    }
    
    $data = array();
    $data["status"] = "0";
    $data["user_edit"] = $USER["user_id"];
    $data["date"] = date("Y-m-d H:i:s");
    if( $DATABASE->QueryUpdate("home", $data, " home_id='".$home_id."' ") ) {
        echo json_encode(array(
            "status"=>true,
            "message"=>"ตอบรับการแก้ไขแล้ว"
        ));
    } else {
        echo json_encode(array(
            "status"=>false,
            "message"=>"ไม่สามารถติดต่อฐานข้อมูลได้"
        ));
    }