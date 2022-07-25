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

    $DATABASE->QueryDelete("debt", "home_id='".$data["home_id"]."'");
    foreach($data["total"] as $key=>$row) {
        $data["total"][$key] = ToNum($data["total"][$key]);
        $field = array(
            "home_id"=>$data["home_id"],
            "item_debt_borrow_id"=>$key,
            "total"=>$data["total"][$key],
            "user"=>$USER["user_id"],
            "date"=>date("Y-m-d H:i:s")
        );
        $DATABASE->QueryInsert("debt", $field);
    }

    $DATABASE->QueryDelete("debt_purpose", "home_id='".$data["home_id"]."'");
    if( isset($_POST["item_debt_purpose_id"]) ) {
        foreach($_POST["item_debt_purpose_id"] as $key=>$row) {
            foreach($row as $val) {
                $field = array(
                    "home_id"=>$data["home_id"],
                    "item_debt_borrow_id"=>$key,
                    "item_debt_purpose_id"=>$val,
                    "user"=>$USER["user_id"],
                    "date"=>date("Y-m-d H:i:s")
                );
                $DATABASE->QueryInsert("debt_purpose", $field);
            }
        }
    }

    $step = 31; $DATABASE->QueryDelete("form_step", " home_id='".$data["home_id"]."' AND step='".$step."' "); $DATABASE->QueryInsert("form_step", array("home_id"=>$data["home_id"], "step"=>$step));
    echo json_encode(array(
        "status"=>true,
        "message"=>"บันทึกข้อมูลสำเร็จ",
        "home_id"=>$data["home_id"]
    ));