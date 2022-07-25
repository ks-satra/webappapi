<?php
    include("../php/autoload.php");
    
    $dir = "../files/user-tmp/";
    $data["user_id"] = $DATABASE->QueryMaxId("user_tmp", "user_id");
    $data["area_province_id"] = "1";
    $data["item_prefix_id"] = @$DATABASE->Escape($_POST["item_prefix_id"]);
    $data["user_name"] = @$DATABASE->Escape($_POST["user_name"]);
    $data["user_lname"] = @$DATABASE->Escape($_POST["user_lname"]);
    $data["phone"] = @$DATABASE->Escape($_POST["phone"]);
    $data["email"] = @$DATABASE->Escape($_POST["email"]);
    $data["password"] = @$DATABASE->Escape($_POST["password"]);
    $data["status"] = "N";
    $data["user"] = "";
    $data["date"] = date("Y-m-d H:i:s");

    $sql = "
        SELECT email FROM user WHERE email='".$data["email"]."' 
        UNION ALL
        SELECT email FROM user_tmp WHERE email='".$data["email"]."' 
    ";
    $obj = $DATABASE->QueryObj($sql);
    if( sizeof($obj)!=0 ) {
        echo json_encode(array(
            "status"=>false,
            "message"=>"อีเมลนี้ได้มีการลงทะเบียนอยู่แล้ว"
        ));
        exit();
    }
    $upload = UploadFile("imagef", $dir, time(), $GLOBAL["ALLOW_IMAGE"]);
    if( $upload["status"]==false ) {
        echo json_encode(array(
            "status"=>false,
            "message"=>$upload["message"]
        ));
        exit();
    }
    $data['image'] = $upload["fileName"];

    // $body = '
    //     เรียนคุณ '.$data["user_name"].' '.$data["user_lname"].' <br><br>
    //     เมื่อวันที่ '.DateTh($data["date"]).' คุณได้ทำการลงทะเบียนเพื่อใช้งานระบบเศรษฐกิจและสังคม ซึ่งบัญชีของคุณอยู่ระหว่างการตรวจสอบ โปรดรอผลการตรวจสอบได้ทางอีเมลของคุณ
    // ';
    // $mail = SendToMail($data["email"], "แจ้งผลการลงทะเบียนผู้ใช้งานระบบเศรษฐกิจและสังคม", $body);
    // if( $mail["status"]==false ) {
    //     RemoveFile($dir, $data["image"]);
    //     echo json_encode(array(
    //         "status"=>false,
    //         "message"=>$mail["message"]
    //     ));
    //     exit();
    // }

    $DATABASE->QueryInsert("user_tmp", $data);
    $_SESSION["eml"] = $data["email"];
    $_SESSION["psw"] = $data["password"];
    echo json_encode(array(
        "status"=>true,
        "message"=>"ลงทะเบียนสำเร็จ"
    ));