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

    $sql = "SELECT * FROM home WHERE home_id='".$home_id."' AND status!='1' ";
    $obj = $DATABASE->QueryObj($sql);
    if( sizeof($obj)==0 ) {
        echo json_encode(array(
            "status"=>false,
            "message"=>"ไม่พบข้อมูล"
        ));
        exit();
    }
    $data = array();
    $data["status"] = "2";
    $data["user_edit"] = $USER["user_id"];
    $data["date"] = date("Y-m-d H:i:s");
    if( $DATABASE->QueryUpdate("home", $data, " home_id='".$home_id."' ") ) {
        echo json_encode(array(
            "status"=>true,
            "message"=>"ลบข้อมูลแล้ว"
        ));
    } else {
        echo json_encode(array(
            "status"=>false,
            "message"=>"ไม่สามารถติดต่อฐานข้อมูลได้"
        ));
    }