<?php
    include_once("../../../php/autoload.php");

    if( $USER==null ) {
        echo json_encode(array(
            "status"=>false,
            "message"=>"Session การเข้าสู่ระบบหมดอายุ กรุณาเข้าสู่ระบบใหม่อีกครั้ง"
        ));
        exit();
    }

    $home_id = @$_POST["home_id"];
    $comment = @$_POST["comment"];

    $sql = "SELECT * FROM home WHERE home_id='".$home_id."' AND status='1' ";
    $obj = $DATABASE->QueryObj($sql);
    if( sizeof($obj)==0 ) {
        echo json_encode(array(
            "status"=>false,
            "message"=>"ไม่พบข้อมูล"
        ));
        exit();
    }
    $home = $obj[0];
    $sql = "
        SELECT 
            ua.* 
        FROM user_area ua 
        WHERE ua.user_id='".$USER["user_id"]."' 
            AND ua.province_id='".$home["area_province_id"]."' 
            AND ua.is_admin='Y'
    ";
    $obj = $DATABASE->QueryObj($sql);
    if( sizeof($obj)!=1 ) {
        echo json_encode(array(
            "status"=>false,
            "message"=>"คุณไม่ได้รับสิทธิ์ส่งกลับแก้ไขได้"
        ));
        exit();
    }
    
    $data = array();
    $data["status"] = "";
    $data["user_edit"] = $USER["user_id"];
    $data["date"] = date("Y-m-d H:i:s");
    if( $DATABASE->QueryUpdate("home", $data, " home_id='".$home_id."' ") ) {
        $DATABASE->QueryInsert("revert_comment", array(
            "revert_comment_id"=>$DATABASE->QueryMaxId("revert_comment", "revert_comment_id"),
            "home_id"=>$home_id,
            "comment"=>$comment,
            "user"=>$USER["user_id"],
            "date"=>date("Y-m-d H:i:s")
        ));
        $DATABASE->QueryInsert("excel_update", array(
            "home_id"=>$home_id,
            "user"=>$USER["user_id"],
            "date"=>date("Y-m-d H:i:s")
        ));
        echo json_encode(array(
            "status"=>true,
            "message"=>"ส่งกลับแก้ไขแล้ว"
        ));
    } else {
        echo json_encode(array(
            "status"=>false,
            "message"=>"ไม่สามารถติดต่อฐานข้อมูลได้"
        ));
    }