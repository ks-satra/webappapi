<?php
    include_once("../php/autoload.php");

    $eml = @$_SESSION["eml"];
    $psw = @$_SESSION["psw"];
    $sql = "SELECT * FROM user_tmp WHERE email='".$eml."' AND password='".$psw."' ";
    $obj = $DATABASE->QueryObj($sql);
    if( sizeof($obj)==0 ) {
        echo json_encode(array(
            "status"=>false,
            "message"=>"Session การเข้าสู่ระบบหมดอายุ กรุณาเข้าสู่ระบบใหม่อีกครั้ง"
        ));
        exit();
    }
    $data = $obj[0];

    $dir = "../files/user-tmp/";
    RemoveFile($dir, $data["image"]);
    $DATABASE->QueryDelete("user_tmp", "user_id='".$data["user_id"]."' ");
    session_destroy();
    echo json_encode(array(
        "status"=>true,
        "message"=>"ยกเลิกการลงทะเบียนสำเร็จ"
    ));