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

    $data["rai"] = ToNum($data["rai"], 0);
    $data["ngan"] = ToNum($data["ngan"], 0);
    $data["wa"] = ToNum($data["wa"], 0);
    $data["kg1"] = ToNum($data["kg1"], 0);
    $data["kg2"] = ToNum($data["kg2"], 0);
    $data["price"] = ToNum($data["price"], 0);
    $data["cost"] = ToNum($data["cost"], 0);

    $data["kg3"] = $data["kg1"] + $data["kg2"];
    $data["income"] = $data["kg3"]*$data["price"];
    $data["total"] = $data["income"] - $data["cost"];

    $obj = $DATABASE->QueryObj("SELECT * FROM income2 WHERE home_id='".$data["home_id"]."' ");
    $data["order_id"] = sizeof($obj)+1;
    if( $DATABASE->QueryInsert("income2", $data) ) {
        if( isset($_POST["item_market_id"]) ) {
            foreach($_POST["item_market_id"] as $item_market_id) {
                $feild = array(
                    "home_id"=>$data["home_id"],
                    "order_id"=>$data["order_id"],
                    "item_market_id"=>$item_market_id,
                );
                $DATABASE->QueryInsert("income2_market", $feild);
            }
        }
        $step = 14; $DATABASE->QueryDelete("form_step", " home_id='".$data["home_id"]."' AND step='".$step."' ");
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