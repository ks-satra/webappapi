<?php
    include("../php/autoload.php");

    $province_id = @$_POST["province_id"];
    $search = $_POST["search"];

    $condition = "";
    if( $province_id!="" ) {
        $condition = " AND province.province_id='".$province_id."' ";
    }


    $sql = "
        SELECT
            tambol.tambol_id, 
            tambol.tambol_name_thai, 
            tambol.latitude, 
            tambol.longitude, 
            tambol.zipcode, 
            amphur.amphur_id, 
            amphur.amphur_name_thai, 
            province.province_id, 
            province.province_name_thai
        FROM tambol
            INNER JOIN amphur ON tambol.amphur_id = amphur.amphur_id
            INNER JOIN province ON amphur.province_id = province.province_id
        WHERE tambol.tambol_name_thai LIKE '%".$search."%'
            ".$condition."
        LIMIT 20
    ";
    $obj = $DATABASE->QueryObj($sql);
    echo json_encode(array(
        "status"=>true,
        "data"=>$obj
    ));
