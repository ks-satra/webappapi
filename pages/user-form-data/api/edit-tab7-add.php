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
    $ObjFormArea = $DATABASE->QueryObj("SELECT * FROM form_area WHERE home_id='".$data["home_id"]."'");
    $data["order_id"] = sizeof($ObjFormArea)+1;
    $data["rai1"] = ToNum($data["rai1"]);
    $data["ngan1"] = ToNum($data["ngan1"]);
    $data["wa1"] = ToNum($data["wa1"]);
    $data["rai2"] = ToNum($data["rai2"]);
    $data["ngan2"] = ToNum($data["ngan2"]);
    $data["wa2"] = ToNum($data["wa2"]);
    $data["rai3"] = ToNum($data["rai3"]);
    $data["ngan3"] = ToNum($data["ngan3"]);
    $data["wa3"] = ToNum($data["wa3"]);
    $data["user"] = $USER["user_id"];
    $data["date"] = date("Y-m-d H:i:s");
    unset($data["item_area_utilization_id"]);
    unset($data["item_area_water_id"]);
    if( !isset($_POST["item_area_utilization_id"]) ) {
        echo json_encode(array(
            "status"=>false,
            "message"=>"ไม่พบข้อมูลการใช้ประโยชน์"
        ));
        exit();
    }
    if( !isset($_POST["item_area_water_id"]) ) {
        echo json_encode(array(
            "status"=>false,
            "message"=>"ไม่พบข้อมูลแหล่งน้ำที่ใช้ในแปลง"
        ));
        exit();
    }
    if( $DATABASE->QueryInsert("form_area", $data) ) {
        $form = array();
        $form["area_num"] = $data["order_id"];
        $form["area_rai"] = $data["rai1"];
        $form["area_ngan"] = $data["ngan1"];
        $form["area_wa"] = $data["wa1"];
        foreach($ObjFormArea as $row) {
            $form["area_rai"] += $row["rai1"];
            $form["area_ngan"] += $row["ngan1"];
            $form["area_wa"] += $row["wa1"];
        }
        $DATABASE->QueryUpdate("form", $form, " home_id='".$data["home_id"]."' ");
        if( isset($_POST["item_area_utilization_id"]) ) {
            foreach($_POST["item_area_utilization_id"] as $item_area_utilization_id) {
                $feild = array(
                    "home_id"=>$data["home_id"],
                    "order_id"=>$data["order_id"],
                    "item_area_utilization_id"=>$item_area_utilization_id,
                );
                $DATABASE->QueryInsert("form_area_utilization", $feild);
            }
        }
        if( isset($_POST["item_area_water_id"]) ) {
            foreach($_POST["item_area_water_id"] as $item_area_water_id) {
                $feild = array(
                    "home_id"=>$data["home_id"],
                    "order_id"=>$data["order_id"],
                    "item_area_water_id"=>$item_area_water_id,
                );
                $DATABASE->QueryInsert("form_area_water", $feild);
            }
        }
        $step = 7; $DATABASE->QueryDelete("form_step", " home_id='".$data["home_id"]."' AND step='".$step."' ");
        echo json_encode(array(
            "status"=>true,
            "message"=>"เพิ่มข้อมูลสำเร็จ",
            "home_id"=>$data["home_id"]
        ));
    } else {
        echo json_encode(array(
            "status"=>false,
            "message"=>"ไม่สามารถติดต่อฐานข้อมูลได้"
        ));
    }