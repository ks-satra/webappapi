<?php
    include_once("../../../php/autoload.php");
    
    
    $province_id = $_POST["province_id"];
    
    $code = GenFormCode($province_id);
    if( !$code ) {
        echo json_encode(array(
            "status"=>false,
            "message"=>"Invalid Code."
        ));
    }

    $new_code = substr($code, 0, 7)."XXXX";
    
    echo json_encode(array(
        "status"=>true,
        "code"=>$new_code
    ));