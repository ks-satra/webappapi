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

    $data["ch35"] = isset($data["ch35"]) ? $data["ch35"] : "";
    $data["ch36_num"] = isset($data["ch36_num"]) ? $data["ch36_num"] : "0";
    $data["ch37"] = isset($data["ch37"]) ? $data["ch37"] : "";
    $data["ch38"] = isset($data["ch38"]) ? $data["ch38"] : "";
    $data["ch39"] = isset($data["ch39"]) ? $data["ch39"] : "";
    $data["ch40"] = isset($data["ch40"]) ? $data["ch40"] : "";
    $data["ch41"] = isset($data["ch41"]) ? $data["ch41"] : "";
    $data["ch42"] = isset($data["ch42"]) ? $data["ch42"] : "";
    $data["ch43"] = isset($data["ch43"]) ? $data["ch43"] : "";

    $data["user_edit"] = $USER["user_id"];
    $data["date"] = date("Y-m-d H:i:s");
    if( $DATABASE->QueryUpdate("form", $data, " home_id='".$data["home_id"]."' ") ) {
        $step = 35; $DATABASE->QueryDelete("form_step", " home_id='".$data["home_id"]."' AND step='".$step."' "); $DATABASE->QueryInsert("form_step", array("home_id"=>$data["home_id"], "step"=>$step));
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