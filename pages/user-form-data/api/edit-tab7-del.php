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
    if( $DATABASE->QueryDelete("form_area", " home_id='".$data["home_id"]."' AND order_id='".$data["order_id"]."' ") ) {
        $DATABASE->Query("UPDATE form_area SET order_id=order_id-1 WHERE home_id='".$data["home_id"]."' AND order_id>'".$data["order_id"]."' ");
        $ObjFormArea = $DATABASE->QueryObj("SELECT * FROM form_area WHERE home_id='".$data["home_id"]."'");
        $form = array();
        $form["area_num"] = sizeof($ObjFormArea);
        $form["area_rai"] = 0;
        $form["area_ngan"] = 0;
        $form["area_wa"] = 0;
        foreach($ObjFormArea as $row) {
            $form["area_rai"] += $row["rai1"];
            $form["area_ngan"] += $row["ngan1"];
            $form["area_wa"] += $row["wa1"];
        }
        $DATABASE->QueryUpdate("form", $form, " home_id='".$data["home_id"]."' ");

        $DATABASE->QueryDelete("form_area_utilization", " home_id='".$data["home_id"]."' AND order_id='".$data["order_id"]."' ");
        $DATABASE->Query("UPDATE form_area_utilization SET order_id=order_id-1 WHERE home_id='".$data["home_id"]."' AND order_id>'".$data["order_id"]."' ");

        $DATABASE->QueryDelete("form_area_water", " home_id='".$data["home_id"]."' AND order_id='".$data["order_id"]."' ");
        $DATABASE->Query("UPDATE form_area_water SET order_id=order_id-1 WHERE home_id='".$data["home_id"]."' AND order_id>'".$data["order_id"]."' ");

        $step = 7; $DATABASE->QueryDelete("form_step", " home_id='".$data["home_id"]."' AND step='".$step."' ");
        echo json_encode(array(
            "status"=>true,
            "message"=>"ลบข้อมูลสำเร็จ"
        ));
    } else {
        echo json_encode(array(
            "status"=>false,
            "message"=>"ไม่สามารถติดต่อฐานข้อมูลได้"
        ));
    }