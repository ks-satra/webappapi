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

    $DATABASE->QueryDelete("help", "home_id='".$data["home_id"]."'");
    foreach($data["num"] as $key=>$row) {
        $data["num"][$key] = ToNum($data["num"][$key]);
        $data["income"][$key] = ToNum($data["income"][$key]);
        $data["total"][$key] = $data["num"][$key] * $data["income"][$key];
        $field = array(
            "home_id"=>$data["home_id"],
            "item_help_id"=>$key,
            "num"=>$data["num"][$key],
            "income"=>$data["income"][$key],
            "total"=>$data["total"][$key],
            "user"=>$USER["user_id"],
            "date"=>date("Y-m-d H:i:s")
        );
        $DATABASE->QueryInsert("help", $field);
    }

    $step = 27; $DATABASE->QueryDelete("form_step", " home_id='".$data["home_id"]."' AND step='".$step."' "); $DATABASE->QueryInsert("form_step", array("home_id"=>$data["home_id"], "step"=>$step));
    echo json_encode(array(
        "status"=>true,
        "message"=>"บันทึกข้อมูลสำเร็จ",
        "home_id"=>$data["home_id"]
    ));