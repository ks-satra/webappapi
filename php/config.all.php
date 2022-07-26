<?php
    date_default_timezone_set("Asia/Bangkok");

    $VERSION = "1.0.28";

    if( $_SERVER["HTTP_HOST"]=="pts.yru.ac.th" ) {
        $ROOT = "/pts/";
        $MODE = "production";
        $HOST = "localhost";
        $USER = "";
        $PASS = "";
        $DBNAME = "";
    } else {
        $ROOT = "/project-api/";
        $MODE = "sanbox";
        $HOST = "localhost";
        $USER = "root";
        $PASS = "";
        $DBNAME = "db_webappapi";
    }
    $DATABASE = new Database($HOST, $USER, $PASS, $DBNAME);
    $CRYPTION = new cryption();
    // $ROOT_URL = $_SERVER["REQUEST_SCHEME"]."://".$_SERVER["HTTP_HOST"].$ROOT;
    $ROOT_URL = "http://".$_SERVER["HTTP_HOST"].$ROOT;

	$GLOBAL = array(
		"ALLOW_SIZE"=>10,  // 10MB
		"ALLOW_PDF"=>array("pdf"),
		"ALLOW_IMAGE"=>array("png", "jpg", "jpeg", "gif"),
        "ALLOW_DOC"=>array("pdf", "doc", "docx", "jpg", "png", "xls", "xlsx"),
        "SHOW"=>50,
        "PAGE_SHOW"=>7,
        "YEAR_FARM"=>100
    );

    $USER = GetUser();

    function Encrypt($data) {
        global $CRYPTION;
        return $CRYPTION->encrypt($data, "key123*");
    }
    function Decrypt($data) {
        global $CRYPTION;
        return $CRYPTION->decrypt($data, "key123*");
    }

    $NUMBER = 5;
    