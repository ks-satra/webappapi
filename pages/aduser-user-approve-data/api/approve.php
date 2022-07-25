<?php
    include_once("../../../php/autoload.php");

    if( $USER==null ) {
        echo json_encode(array(
            "status"=>false,
            "message"=>"Session การเข้าสู่ระบบหมดอายุ กรุณาเข้าสู่ระบบใหม่อีกครั้ง"
        ));
        exit();
    }
    $dir = "../../../files/user/";
    $dirTmp = "../../../files/user-tmp/";

    $data = $_POST;
    $sql = "SELECT * FROM user_tmp WHERE user_id='".$data["user_id"]."' ";
    $obj = $DATABASE->QueryObj($sql);
    $data = $obj[0];
    $data["user_id"] = $DATABASE->QueryMaxId("user", "user_id");
    $data["status"] = "Y";
    $data["user"] = $USER["user_id"];
    $data["date"] = date("Y-m-d H:i:s");
    unset($data["area_province_id"]);
    $DATABASE->QueryInsert("user", $data);

    $DATABASE->QueryInsert("user_area", array(
        "user_id"=>$data["user_id"],
        "province_id"=>$obj[0]["area_province_id"],
        "is_admin"=>"N",
        "date"=>date("Y-m-d H:i:s"),
        "user"=>$USER["user_id"]
    ));

    $DATABASE->QueryDelete("user_tmp", " user_id='".$obj[0]["user_id"]."' ");
    if( $obj[0]["image"]!="" ) rename($dirTmp.$obj[0]["image"], $dir.$obj[0]["image"]);

    $link = $_SERVER["REQUEST_SCHEME"].'://'.$_SERVER["HTTP_HOST"].$ROOT;

    $body = '
        เรียนคุณ '.$data["user_name"].' '.$data["user_lname"].' <br><br>
        เมื่อวันที่ '.DateTh($data["date"]).' เจ้าหน้าที่ได้ทำการตรวจสอบแล้ว คุณได้รับอนุมัติเป็นที่เรียบร้อย สามารถเข้าสู่ระบบได้ ตามลิงก์ด้านล่างนี้<br><br>
        <a href="'.$link.'">'.$link.'</a>
    ';
    $mail = SendToMail($data["email"], "แจ้งผลการลงทะเบียนผู้ใช้งานระบบเศรษฐกิจและสังคม", $body);

    echo json_encode(array(
        "status"=>true,
        "message"=>"อนุมัติเรียบร้อย"
    ));