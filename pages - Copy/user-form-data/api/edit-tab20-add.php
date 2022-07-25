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
    unset($data["item_market_id"]);

    $data["income"] = ToNum($data["income"], 0);
    $data["cost"] = ToNum($data["cost"], 0);
    $data["total"] = $data["income"] - $data["cost"];

    $obj = $DATABASE->QueryObj("SELECT * FROM income8 WHERE home_id='".$data["home_id"]."' ");
    $data["order_id"] = sizeof($obj)+1;
    if( $DATABASE->QueryInsert("income8", $data) ) {
        if( isset($_POST["item_market_id"]) ) {
            foreach($_POST["item_market_id"] as $item_market_id) {
                $feild = array(
                    "home_id"=>$data["home_id"],
                    "order_id"=>$data["order_id"],
                    "item_market_id"=>$item_market_id,
                );
                $DATABASE->QueryInsert("income8_market", $feild);
            }
        }
        $step = 20; $DATABASE->QueryDelete("form_step", " home_id='".$data["home_id"]."' AND step='".$step."' ");
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