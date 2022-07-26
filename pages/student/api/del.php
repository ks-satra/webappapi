<?php
    include_once("../../../php/autoload.php");

    if( $USER==null ) {
        echo json_encode(array(
            "status"=>false,
            "message"=>"Session การเข้าสู่ระบบหมดอายุ กรุณาเข้าสู่ระบบใหม่อีกครั้ง"
        ));
        exit();
    }

    $dir = "../../../files/student/";
    $data = $_POST;

    if( $DATABASE->QueryHaving("device_lend", "student_id", $data["student_id"]) ) {
        echo json_encode(array(
            "status"=>false,
            "message"=>"ไม่สามารถลบได้ ผู้ใช้งานรายนี้ได้ทำการยืมอุปกรณ์"
        ));
        exit();
    }

    if( $DATABASE->QueryDelete("student", " student_id='".$data["student_id"]."' ") ) {
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