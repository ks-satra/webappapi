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
    if($data["checked"]=="Y") {
        $field = $data;
        unset( $field["checked"] );
        $field["user"] = $USER["user_id"];
        $field["date"] = date("Y-m-d H:i:s");
        $DATABASE->QueryInsert("user_level", $field);
    } else {
        $DATABASE->QueryDelete("user_level", "user_id='".$data["user_id"]."' AND level_id='".$data["level_id"]."'");
    }
    echo json_encode(array(
        "status"=>true,
    ));
