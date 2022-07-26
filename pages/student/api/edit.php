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
    $data["user"] = $USER["user_id"];
    $data["date"] = date("Y-m-d H:i:s");
    
    if( $DATABASE->QueryHaving("student", "student_code", $data["student_code"], "student_id", $data["student_id"]) ) {
        echo json_encode(array(
            "status"=>false,
            "message"=>"ไม่สามารถแก้ไขได้ เนื่องจากอีเมลนี้มีอยู่แล้ว"
        ));
        exit();
    }

    $sql = "SELECT * FROM student WHERE student_id='".$data["student_id"]."' ";
    $obj = $DATABASE->QueryObj($sql);
    $image = ( sizeof($obj)==1 ) ? $obj[0]["image"] : "";
    
    if( $DATABASE->QueryUpdate("student", $data, " student_id='".$data["student_id"]."' ") ) {
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