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

    $DATABASE->QueryDelete("saving", "home_id='".$data["home_id"]."'");
    foreach($data["total"] as $key=>$row) {
        $data["total"][$key] = ToNum($data["total"][$key]);
        $field = array(
            "home_id"=>$data["home_id"],
            "item_saving_id"=>$key,
            "total"=>$data["total"][$key],
            "user"=>$USER["user_id"],
            "date"=>date("Y-m-d H:i:s")
        );
        $DATABASE->QueryInsert("saving", $field);
    }

    $step = 26; $DATABASE->QueryDelete("form_step", " home_id='".$data["home_id"]."' AND step='".$step."' "); $DATABASE->QueryInsert("form_step", array("home_id"=>$data["home_id"], "step"=>$step));
    echo json_encode(array(
        "status"=>true,
        "message"=>"บันทึกข้อมูลสำเร็จ",
        "home_id"=>$data["home_id"]
    ));