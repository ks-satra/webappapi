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
    if( $DATABASE->QueryDelete("home_member", " home_id='".$data["home_id"]."' AND order_id='".$data["order_id"]."' ") ) {
        $DATABASE->Query("UPDATE home_member SET order_id=order_id-1 WHERE home_id='".$data["home_id"]."' AND order_id>'".$data["order_id"]."' ");
        $home_member_count = $DATABASE->QueryString("SELECT COUNT(*) FROM home_member WHERE home_id='".$data["home_id"]."'");
        $DATABASE->QueryUpdate("home", array(
            "home_member_count"=>$home_member_count
        ), " home_id='".$data["home_id"]."' ");
        $step = 12; $DATABASE->QueryDelete("form_step", " home_id='".$data["home_id"]."' AND step='".$step."' ");
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