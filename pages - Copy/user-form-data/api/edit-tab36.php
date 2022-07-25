<?php
    include_once("../../../php/autoload.php");

    if( $USER==null ) {
        echo json_encode(array(
            "status"=>false,
            "message"=>"Session การเข้าสู่ระบบหมดอายุ กรุณาเข้าสู่ระบบใหม่อีกครั้ง"
        ));
        exit();
    }

    $dir = "../../../files/form/";
    $data = $_POST;

    $sql = "SELECT * FROM form WHERE home_id='".$data["home_id"]."' ";
    $obj = $DATABASE->QueryObj($sql);
    if( sizeof($obj)==0 ) {
        echo json_encode(array(
            "status"=>false,
            "message"=>"ไม่พบข้อมูล"
        ));
        exit();
    }
    $form = $obj[0];

    $res = UploadFile("staff_image", $dir, time(), $GLOBAL["ALLOW_IMAGE"]);
    if( $res["status"] ) {
        $data["staff_image"] = $res["fileName"];
        RemoveFile($dir, $form["staff_image"]);
    }

    $data["staff_date"] = DateEn($data["staff_date"]);

    $data["user_edit"] = $USER["user_id"];
    $data["date"] = date("Y-m-d H:i:s");
    if( $DATABASE->QueryUpdate("form", $data, " home_id='".$data["home_id"]."' ") ) {
        $step = 36; $DATABASE->QueryDelete("form_step", " home_id='".$data["home_id"]."' AND step='".$step."' "); $DATABASE->QueryInsert("form_step", array("home_id"=>$data["home_id"], "step"=>$step));
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