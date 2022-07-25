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

    $DATABASE->QueryDelete("form_environment", " home_id='".$data["home_id"]."' ");
    foreach($data["level"] as $key=>$val) {
        $feild2 = array(
            "home_id"=>$data["home_id"],
            "item_environment_id"=>$key,
            "level"=>$val
        );
        $DATABASE->QueryInsert("form_environment", $feild2);
    }
    unset($data["level"]);

    $data["user_edit"] = $USER["user_id"];
    $data["date"] = date("Y-m-d H:i:s");
    if( $DATABASE->QueryUpdate("form", $data, " home_id='".$data["home_id"]."' ") ) {
        $step = 10; $DATABASE->QueryDelete("form_step", " home_id='".$data["home_id"]."' AND step='".$step."' "); $DATABASE->QueryInsert("form_step", array("home_id"=>$data["home_id"], "step"=>$step));
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