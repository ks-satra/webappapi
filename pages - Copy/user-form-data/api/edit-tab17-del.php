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
    if( $DATABASE->QueryDelete("income5", " home_id='".$data["home_id"]."' AND order_id='".$data["order_id"]."' ") ) {
        $DATABASE->Query("UPDATE income5 SET order_id=order_id-1 WHERE home_id='".$data["home_id"]."' AND order_id>'".$data["order_id"]."' ");
        $DATABASE->QueryDelete("income5_market", " home_id='".$data["home_id"]."' AND order_id='".$data["order_id"]."' ");
        $DATABASE->Query("UPDATE income5_market SET order_id=order_id-1 WHERE home_id='".$data["home_id"]."' AND order_id>'".$data["order_id"]."' ");
        $step = 17; $DATABASE->QueryDelete("form_step", " home_id='".$data["home_id"]."' AND step='".$step."' ");
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