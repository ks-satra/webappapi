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

    $data["ch5_num"] = isset($data["ch5_num"]) ? $data["ch5_num"] : "0";
    for($i=1; $i<=4; $i++) {
        $data["ch6_".$i] = "N";
        if(isset($data["ch6"])) {
            foreach($data["ch6"] as $key=>$row) {
                if( $row*1==$i ) {
                    $data["ch6_".$i] = "Y";
                    unset( $data["ch6"][$key] );
                }
            }
        }
    }
    unset($data["ch6"]);

    $data["ch8_num"] = isset($data["ch8_num"]) ? $data["ch8_num"] : "0";
    for($i=1; $i<=4; $i++) {
        $data["ch9_".$i] = "N";
        if(isset($data["ch9"])) {
            foreach($data["ch9"] as $key=>$row) {
                if( $row*1==$i ) {
                    $data["ch9_".$i] = "Y";
                    unset( $data["ch9"][$key] );
                }
            }
        }
    }
    unset($data["ch9"]);

    for($i=1; $i<=7; $i++) {
        $data["ch11_".$i] = "N";
        if(isset($data["ch11"])) {
            foreach($data["ch11"] as $key=>$row) {
                if( $row*1==$i ) {
                    $data["ch11_".$i] = "Y";
                    unset( $data["ch11"][$key] );
                }
            }
        }
    }
    unset($data["ch11"]);
    
    $data["ch14_desc"] = isset($data["ch14_desc"]) ? $data["ch14_desc"] : "";
    $data["ch17_desc"] = isset($data["ch17_desc"]) ? $data["ch17_desc"] : "";

    $data["ch12_rai"] = ToNum($data["ch12_rai"]);
    $data["ch12_ngan"] = ToNum($data["ch12_ngan"]);
    $data["ch12_wa"] = ToNum($data["ch12_wa"]);
    $data["ch15_rai"] = ToNum($data["ch15_rai"]);
    $data["ch15_ngan"] = ToNum($data["ch15_ngan"]);
    $data["ch15_wa"] = ToNum($data["ch15_wa"]);

    $data["user_edit"] = $USER["user_id"];
    $data["date"] = date("Y-m-d H:i:s");
    if( $DATABASE->QueryUpdate("form", $data, " home_id='".$data["home_id"]."' ") ) {
        $step = 6; $DATABASE->QueryDelete("form_step", " home_id='".$data["home_id"]."' AND step='".$step."' "); $DATABASE->QueryInsert("form_step", array("home_id"=>$data["home_id"], "step"=>$step));
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