<?php
    include("php/autoload.php");
    if( $USER==null ) {
        LinkTo("./login.php");
    }
    $PAGE = isset($_GET["page"]) ? $_GET["page"] : "all-home";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("master/script.php"); ?>
    <script>
        $(function() {
            $(".btn-logout").click(function() {
                ShowConfirm({
                    html: "คุณแน่ใจต้องการออกระบบใช่หรือไม่ ?",
                    callback: function(rs) {
                        if (rs) {
                            LinkTo("./logout.php");
                        }
                    }
                });
            });
        });
    </script>
</head>
<body>
    <?php include("master/header.php"); ?>
    <div id="content" class="container pt-5 pb-5">
    <?php
        if( chkPermit() ) {
            echo '
                <link href="pages/'.$PAGE.'/view.css?version='.$VERSION.'" rel="stylesheet">
                <script src="pages/'.$PAGE.'/view.js?version='.$VERSION.'"></script>
            ';
            include_once("pages/".$PAGE."/view.php");
        } else {
            echo '
                <link href="pages/pagenotfound/view.css?version='.$VERSION.'" rel="stylesheet">
                <script src="pages/pagenotfound/view.js?version='.$VERSION.'"></script>
            ';
            include_once("pages/pagenotfound/view.php");
        }
        function chkPermit() {
            global $PAGE, $USER;
            if( !file_exists("pages/".$PAGE."/view.php") ) return false;
            $DENIED = array();
            $PERMIT = array();
            if( !file_exists("pages/".$PAGE."/permit.php") ) return false;
            include_once("pages/".$PAGE."/permit.php");
            foreach ($DENIED as $key => $value) {
                if( isset($USER["level"][$value]) && $USER["level"][$value]=="Y" ) return false;
            }
            foreach ($PERMIT as $key => $value) {
                if( $value=="all" ) return true;
                if( isset($USER["level"][$value]) && $USER["level"][$value]=="Y" ) return true;
            }
            return false;
            return true;
        }
    ?>
    </div>
    <?php include("master/footer.php"); ?>
</body>
</html>