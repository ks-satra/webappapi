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

    $DATABASE->QueryDelete("form_behavior", " home_id='".$data["home_id"]."' ");
    foreach($data["item_behavior_id"] as $key=>$val) {
        $feild2 = array(
            "order_id"=>$val,
            "home_id"=>$data["home_id"],
            "item_behavior_id"=>$key
        );
        $DATABASE->QueryInsert("form_behavior", $feild2);
    }
    unset($data["item_behavior_id"]);

    $DATABASE->QueryDelete("form_contagious", " home_id='".$data["home_id"]."' ");
    if( isset($data["item_contagious_id"]) ) {
        foreach($data["item_contagious_id"] as $key=>$val) {
            $feild2 = array(
                "home_id"=>$data["home_id"],
                "item_contagious_id"=>$val
            );
            $DATABASE->QueryInsert("form_contagious", $feild2);
        }
        unset($data["item_contagious_id"]);
    }

    $DATABASE->QueryDelete("form_disability", " home_id='".$data["home_id"]."' ");
    if( isset($data["item_disability_id"]) ) {
        foreach($data["item_disability_id"] as $key=>$val) {
            $feild2 = array(
                "home_id"=>$data["home_id"],
                "item_disability_id"=>$val
            );
            $DATABASE->QueryInsert("form_disability", $feild2);
        }
        unset($data["item_disability_id"]);
    }

    $data["user_edit"] = $USER["user_id"];
    $data["date"] = date("Y-m-d H:i:s");
    if( $DATABASE->QueryUpdate("form", $data, " home_id='".$data["home_id"]."' ") ) {
        $step = 9; $DATABASE->QueryDelete("form_step", " home_id='".$data["home_id"]."' AND step='".$step."' "); $DATABASE->QueryInsert("form_step", array("home_id"=>$data["home_id"], "step"=>$step));
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