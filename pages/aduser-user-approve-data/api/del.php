<?php
    include_once("../../../php/autoload.php");

    if( $USER==null ) {
        echo json_encode(array(
            "status"=>false,
            "message"=>"Session การเข้าสู่ระบบหมดอายุ กรุณาเข้าสู่ระบบใหม่อีกครั้ง"
        ));
        exit();
    }

    $dir = "../../../files/user-tmp/";
    $data = $_POST;
    $sql = "SELECT * FROM user_tmp WHERE user_id='".$data["user_id"]."' ";
    $obj = $DATABASE->QueryObj($sql);
    $data = $obj[0];
    $data["date"] = date("Y-m-d H:i:s");
    if( $DATABASE->QueryDelete("user_tmp", " user_id='".$data["user_id"]."' ") ) {
        RemoveFile($dir, $data["image"]);
        $body = '
            เรียนคุณ '.$data["user_name"].' '.$data["user_lname"].' <br><br>
            เมื่อวันที่ '.DateTh($data["date"]).' เจ้าหน้าที่ได้ทำการตรวจสอบแล้ว คุณไม่ได้รับอนุญาติใช้งานระบบเศรษฐกิจและสังคม
        ';
        $mail = SendToMail($data["email"], "แจ้งผลการลงทะเบียนผู้ใช้งานระบบเศรษฐกิจและสังคม", $body);
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