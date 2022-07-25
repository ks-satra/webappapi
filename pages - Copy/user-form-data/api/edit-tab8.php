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
    
    $data["ch18"] = isset($data["ch18"]) ? $data["ch18"] : "";
    $data["ch19"] = isset($data["ch19"]) ? $data["ch19"] : "";
    $data["ch19_num"] = isset($data["ch19_num"]) ? $data["ch19_num"] : "";
    $data["ch20"] = isset($data["ch20"]) ? $data["ch20"] : "";

    $data["ch21"] = isset($data["ch21"]) ? $data["ch21"] : "";
    $data["ch22"] = isset($data["ch22"]) ? $data["ch22"] : "";
    $data["ch22_num"] = isset($data["ch22_num"]) ? $data["ch22_num"] : "";
    $data["ch23"] = isset($data["ch23"]) ? $data["ch23"] : "";

    $data["ch24"] = isset($data["ch24"]) ? $data["ch24"] : "";
    $data["ch25"] = isset($data["ch25"]) ? $data["ch25"] : "";
    $data["ch25_num"] = isset($data["ch25_num"]) ? $data["ch25_num"] : "";
    $data["ch26"] = isset($data["ch26"]) ? $data["ch26"] : "";

    $data["ch27"] = isset($data["ch27"]) ? $data["ch27"] : "";
    $data["ch28"] = isset($data["ch28"]) ? $data["ch28"] : "";
    $data["ch28_num"] = isset($data["ch28_num"]) ? $data["ch28_num"] : "";
    $data["ch29"] = isset($data["ch29"]) ? $data["ch29"] : "";

    $data["user_edit"] = $USER["user_id"];
    $data["date"] = date("Y-m-d H:i:s");
    if( $DATABASE->QueryUpdate("form", $data, " home_id='".$data["home_id"]."' ") ) {
        $step = 8; $DATABASE->QueryDelete("form_step", " home_id='".$data["home_id"]."' AND step='".$step."' "); $DATABASE->QueryInsert("form_step", array("home_id"=>$data["home_id"], "step"=>$step));
        echo json_encode(array(
            "status"=>true,
            "message"=>"บันทึกข้อมูลสำเร็จ",
            "home_id"=>$data["home_id"]
        ));
    } else {
        echo json_encode(array(
            "status"=>false,
            "message"=>"ไม่สามารถติดต่อฐานข้อมูลได้"
        ));
    }