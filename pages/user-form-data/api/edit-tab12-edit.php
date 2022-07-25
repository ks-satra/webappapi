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

    $data["age"] = date("Y") - $data["year_bdate"];
    $data["education_assign"] = ( $data["item_education_id"]=="999" ) ? $data["education_assign"] : "";
    $data["work_assign"] = ( $data["item_work_id"]=="999" ) ? $data["work_assign"] : "";
    $data["occupation_assign"] = ( $data["item_occupation_id"]=="999" ) ? $data["occupation_assign"] : "";

    if( $DATABASE->QueryUpdate("home_member", $data, " home_id='".$data["home_id"]."' AND order_id='".$data["order_id"]."' ") ) {
        $home_member_count = $DATABASE->QueryString("SELECT COUNT(*) FROM home_member WHERE home_id='".$data["home_id"]."'");
        $DATABASE->QueryUpdate("home", array(
            "home_member_count"=>$home_member_count
        ), " home_id='".$data["home_id"]."' ");
        $step = 12; $DATABASE->QueryDelete("form_step", " home_id='".$data["home_id"]."' AND step='".$step."' ");
        echo json_encode(array(
            "status"=>true,
            "message"=>"แก้ไขข้อมูลสำเร็จ",
            "home_id"=>$data["home_id"]
        ));
    } else {
        echo json_encode(array(
            "status"=>false,
            "message"=>"ไม่สามารถติดต่อฐานข้อมูลได้"
        ));
    }