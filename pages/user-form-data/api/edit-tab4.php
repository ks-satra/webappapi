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
    $data["ch2_1"] = isset($data["ch2_1"]) ? $data["ch2_1"] : "N";
    $data["ch2_1_num"] = isset($data["ch2_1_num"]) ? ToNum($data["ch2_1_num"]) : "0";
    $data["ch2_1_rai"] = isset($data["ch2_1_rai"]) ? ToNum($data["ch2_1_rai"]) : "0";
    $data["ch2_1_ngan"] = isset($data["ch2_1_ngan"]) ? ToNum($data["ch2_1_ngan"]) : "0";
    $data["ch2_1_wa"] = isset($data["ch2_1_wa"]) ? ToNum($data["ch2_1_wa"]) : "0";
    $data["ch2_2"] = isset($data["ch2_2"]) ? $data["ch2_2"] : "N";
    $data["ch2_2_num"] = isset($data["ch2_2_num"]) ? ToNum($data["ch2_2_num"]) : "0";
    $data["ch2_2_rai"] = isset($data["ch2_2_rai"]) ? ToNum($data["ch2_2_rai"]) : "0";
    $data["ch2_2_ngan"] = isset($data["ch2_2_ngan"]) ? ToNum($data["ch2_2_ngan"]) : "0";
    $data["ch2_2_wa"] = isset($data["ch2_2_wa"]) ? ToNum($data["ch2_2_wa"]) : "0";
    $data["ch2_3"] = isset($data["ch2_3"]) ? $data["ch2_3"] : "N";
    $data["ch2_3_num"] = isset($data["ch2_3_num"]) ? ToNum($data["ch2_3_num"]) : "0";
    $data["ch2_3_rai"] = isset($data["ch2_3_rai"]) ? ToNum($data["ch2_3_rai"]) : "0";
    $data["ch2_3_ngan"] = isset($data["ch2_3_ngan"]) ? ToNum($data["ch2_3_ngan"]) : "0";
    $data["ch2_3_wa"] = isset($data["ch2_3_wa"]) ? ToNum($data["ch2_3_wa"]) : "0";
    $data["user_edit"] = $USER["user_id"];
    $data["date"] = date("Y-m-d H:i:s");
    if( $DATABASE->QueryUpdate("form", $data, " home_id='".$data["home_id"]."' ") ) {
        $step = 4; $DATABASE->QueryDelete("form_step", " home_id='".$data["home_id"]."' AND step='".$step."' "); $DATABASE->QueryInsert("form_step", array("home_id"=>$data["home_id"], "step"=>$step));
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