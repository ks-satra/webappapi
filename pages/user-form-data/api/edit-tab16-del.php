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
    if( $DATABASE->QueryDelete("income4", " home_id='".$data["home_id"]."' AND order_id='".$data["order_id"]."' ") ) {
        $DATABASE->Query("UPDATE income4 SET order_id=order_id-1 WHERE home_id='".$data["home_id"]."' AND order_id>'".$data["order_id"]."' ");
        $DATABASE->QueryDelete("income4_market", " home_id='".$data["home_id"]."' AND order_id='".$data["order_id"]."' ");
        $DATABASE->Query("UPDATE income4_market SET order_id=order_id-1 WHERE home_id='".$data["home_id"]."' AND order_id>'".$data["order_id"]."' ");
        $step = 16; $DATABASE->QueryDelete("form_step", " home_id='".$data["home_id"]."' AND step='".$step."' ");
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