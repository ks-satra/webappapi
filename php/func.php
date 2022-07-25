<?php
    function DateTh($date) {
        if( $date=="0000-00-00" || $date=="" ) return "";
        $arr1 = explode(" ", $date);
		$arr2 = explode("-", $arr1[0]);
        if( sizeof($arr2)<=2 ) return "";
        $rs = $arr2[2]."/".$arr2[1]."/".($arr2[0]*1+543);
        if( sizeof($arr1)==2 ) $rs .= " ".substr($arr1[1], 0, 5);
		return $rs;
    }
    function DateEn($date) {
		$arr = explode("/", $date);
		if( sizeof($arr)<=2 ) return "";
		return ($arr[2]*1-543)."-".$arr[1]."-".($arr[0]);
    }
    function GetDateNowTh() {
        $date = date("d/m/").(date("Y")*1+543);
        return $date;
    }
    function GetDateNowEn() {
        $date = date("Y-m-d");
        return $date;
    }
    function ToNum($num, $digit=2) {
        $num = str_replace(" %", "", $num);
        return number_format( str_replace(",","",$num)*1, $digit, '.', '');
    }
    function ShowAlert($title="แจ้งข้อความ", $html="ระบุข้อความ", $type="question", $href="") {
        echo '
            <script>
                ShowAlert({
                    title: "'.$title.'",
                    html: "'.$html.'",
                    type: "'.$type.'",
                    callback: function() {
                        if( "'.$href.'"!="" ) {
                            window.location.href = "'.$href.'";
                        }
                    }
                });
            </script>
        ';
    }
    function MakeDir($targetPath) {
        if ( !is_dir( $targetPath ) ) {
            mkdir($targetPath, 0777);
        }
    }
    function UploadFile($elementName, $dir, $rename, $allowType=null, $index="") {
        if( isset($_FILES[$elementName]) && $_FILES[$elementName]["size"]>0 ) {
            $tmpName = $_FILES[$elementName]['tmp_name'];
            $name = $_FILES[$elementName]['name'];
            $size = $_FILES[$elementName]['size'];
            if( $index!=="" ) {
                $tmpName = $_FILES[$elementName]['tmp_name'][$index];
                $name = $_FILES[$elementName]['name'][$index];
                $size = $_FILES[$elementName]['size'][$index];
            }
            $type = strtolower(pathinfo($name, PATHINFO_EXTENSION));
            if( $allowType!=null && !in_array($type, $allowType) ) return array( "status"=>false, "fileName"=>"", "message"=>"รูปแบบไฟล์ไม่รองรับ" );
            foreach ($allowType as $key => $value) {
                if( file_exists($dir.$rename.".".$value) ) unlink($dir.$rename.".".$value);
            }
            $fileName = $rename.".".$type;
            move_uploaded_file( $tmpName, $dir.$fileName );
            return array( "status"=>true, "fileName"=>$fileName );
        }
        return array( "status"=>false, "fileName"=>"", "message"=>"ไม่พบไฟล์" );
    }
    function AcceptImplode($type) {
        foreach ($type as $key => $value) {
            $type[$key] = ".".$type[$key];
        }
        return implode(", ", $type);
    }
    function RemoveDir($dirPath) {
        if (! is_dir($dirPath)) return;
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                RemoveDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }
    function RemoveFile($dir, $filename) {
        if( $filename!="" && file_exists($dir.$filename)  ) unlink($dir.$filename);
    }
    function PrintData($data) {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }
    function LinkTo($url) {
        echo '
            <script>
                location.href = "'.$url.'";
            </script>
        ';
        exit();
    }
    function Back() {
        echo '
            <script>
                history.back();
            </script>
        ';
        exit();
    }
    function Reload() {
        echo '
            <script>
                var href = window.location.href;
                window.history.replaceState({}, "", href);
                location.reload();
            </script>
        ';
        exit();
    }
    function GetClientIpEnv() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
     
        return $ipaddress;
    }

    function GetUser() {
    	global $DATABASE;
    	$email = @$_SESSION["email"];
    	$password = @$_SESSION["password"];
    	if( $email=='' || $password=='' ) return null;
    	$sql = "
            SELECT 
                user.*,
                ip.item_prefix_name
            FROM user 
                INNER JOIN item_prefix ip ON ip.item_prefix_id=user.item_prefix_id
            WHERE user.email='".$email."' AND user.password='".$password."' AND user.`status`='Y'
        ";
    	$obj = $DATABASE->QueryObj($sql);
    	if( sizeof($obj)==1 ) {
            unset($obj[0]["password"]);
            $sql = "
                SELECT * 
                FROM level 
                    LEFT JOIN user_level ON user_level.level_id=level.level_id AND user_level.user_id='".$obj[0]["user_id"]."'
                ORDER BY level.level_id
            ";
            $obj2 = $DATABASE->QueryObj($sql);
            $obj[0]["level"] = array();
            foreach($obj2 as $row) {
                $obj[0]["level"][$row["program_code"]] = ($row["user_id"]==$obj[0]["user_id"])? "Y" : "N";
            }
            
    		return $obj[0];
    	}
    	return null;
    }
    