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
    $data["student_id"] = $DATABASE->QueryMaxId("student", "student_id");
    $data["user"] = $USER["user_id"];
    $data["date"] = date("Y-m-d H:i:s");

    if( $DATABASE->QueryHaving("student", "student_code", $data["student_code"]) ) {
        echo json_encode(array(
            "status"=>false,
            "message"=>"ไม่สามารถเพิ่มได้ เนื่องจากรหัสนักศึกษานี้มีอยู่แล้ว"
        ));
        exit();
    }

    if( $DATABASE->QueryInsert("student", $data) ) {
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