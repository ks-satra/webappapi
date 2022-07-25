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

    $dir = "../../../files/form/";
    $staff_image = $DATABASE->QueryString("SELECT staff_image FROM form WHERE home_id='".$home_id."' ");
    $tables = array(
        "home",
        "form",
        "form_area",
        "form_area_utilization",
        "form_area_water",
        "form_behavior",
        "form_contagious",
        "form_disability",
        "form_environment",
        "form_society",
        "home_member",
        "saving",
        "help",
        "expense1",
        "expense2",
        "expense3",
        "debt",
        "debt_purpose",
        "asset",
        "member_group",
        "form_step"
    );
    foreach($tables as $table) {
        $DATABASE->QueryDelete($table, " home_id='".$home_id."' ");
    }
    for($i=1; $i<=13; $i++) {
        $DATABASE->QueryDelete("income".$i, " home_id='".$home_id."' ");
        if( $i<=10 ) {
            $DATABASE->QueryDelete("income".$i."_market", " home_id='".$home_id."' ");
        }
    }
    RemoveFile($dir, $staff_image);
    echo json_encode(array(
        "status"=>true,
        "message"=>"ลบข้อมูลแล้ว"
    ));