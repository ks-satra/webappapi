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

    $sql = "SELECT * FROM home WHERE home_code='".$data['home_code']."' AND year_id='".$YEAR_ID."' ";
    $obj = $DATABASE->QueryObj($sql);
    if( sizeof($obj)>0 ) {
        echo json_encode(array(
            "status"=>false,
            "message"=>"ไม่สามารถเพิ่มได้ เนื่องจากในปีงบประมาณ ".$YEAR_NAME." รหัสบ้านนี้มีการบันทึกแล้ว !!!"
        ));
        exit();
    }
    $data["home_id"] = $DATABASE->QueryMaxId("home", "home_id");
    $data["year_id"] = $YEAR_ID;
    $data["form_code"] = GenFormCode($data["area_province_id"]);
    $data["status"] = "0";
    $data["user"] = $USER["user_id"];
    $data["date"] = date("Y-m-d H:i:s");
    if( $DATABASE->QueryInsert("home", $data) ) {
        $DATABASE->QueryInsert("form", array(
            "home_id"=>$data["home_id"],
            "user"=>$data["user"],
            "date"=>$data["date"],
        ));
        $step = 1; $DATABASE->QueryDelete("form_step", " home_id='".$data["home_id"]."' AND step='".$step."' "); $DATABASE->QueryInsert("form_step", array("home_id"=>$data["home_id"], "step"=>$step));
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