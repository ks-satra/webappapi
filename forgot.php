<?php
    include_once("php/autoload.php");
    if( $USER!=null ) {
        LinkTo("./");
    }

    $eml = @$_SESSION["eml"];
    $psw = @$_SESSION["psw"];
    $sql = "SELECT * FROM user_tmp WHERE email='".$eml."' AND password='".$psw."' ";
    $obj = $DATABASE->QueryObj($sql);
    if( sizeof($obj)==1 ) {
        LinkTo("./main.php");
    }

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="images/yru.png">
    <title>เข้าสู่ระบบ Web Application</title>
    <!-- googleapis -->
    <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
    <!-- jquery -->
    <script src="assets/jquery/jquery-3.2.1.min.js?version=<?php echo $VERSION; ?>"></script>
    <!-- bootstrap -->
    <link href="assets/bootstrap-4.3.1/css/bootstrap.min.css?version=<?php echo $VERSION; ?>" rel="stylesheet">
    <script src="assets/bootstrap-4.3.1/js/bootstrap.bundle.min.js?version=<?php echo $VERSION; ?>"></script>
    <!-- fontawesome -->
    <link rel="stylesheet" href="assets/fontawesome-free-5.15.1/css/all.css?version=<?php echo $VERSION; ?>" />
    <!-- sweetalert2 -->
    <script src='assets/sweetalert2/sweetalert.min.js?version=<?php echo $VERSION;?>'></script>
    <!-- pace -->
    <link href="assets/pace/themes/white/pace-theme-flash.css" rel="stylesheet" />
    <script data-pace-options='{"startOnPageLoad": false }' src="assets/pace/pace.min.js"></script>
    <!-- inputmask -->
    <script src="assets/inputmask/jquery.inputmask.bundle.js?version=<?php echo $VERSION;?>"></script>
    <script src="assets/inputmask/inputmask/bindings/inputmask.binding.js?version=<?php echo $VERSION;?>"></script>
    <!-- jBox -->
    <link href="assets/jBox-0.6.4/jBox.all.min.css?version=<?php echo $VERSION; ?>" rel="stylesheet">
    <script src="assets/jBox-0.6.4/jBox.all.min.js?version=<?php echo $VERSION; ?>"></script>
    <!-- index -->
    <link href="assets/index.css?version=<?php echo $VERSION; ?>" rel="stylesheet">
    <script src="assets/index.js?version=<?php echo $VERSION; ?>"></script>
    <style>
    html {
        min-height: 100%;
        background-color: #f5f5f5;
    }

    body {
        background-color: initial;
    }


    /**Login**/

    .body-login {
        height: 100%;
        display: -ms-flexbox;
        display: -webkit-box;
        display: flex;
        -ms-flex-align: center;
        -ms-flex-pack: center;
        -webkit-box-align: center;
        align-items: center;
        -webkit-box-pack: center;
        justify-content: center;
        padding-top: 40px;
        padding-bottom: 40px;
    }

    .hd-login {
        font-size: 25px;
    }

    .form-forgot {
        width: 100%;
        max-width: 500px;
        padding: 15px;
        margin: 0 auto;
    }

    .form-forgot img {
        width: 140px;
    }

    .form-forgot .checkbox {
        font-weight: 400;
    }

    .form-forgot .form-control {
        position: relative;
        box-sizing: border-box;
        height: auto;
        padding: 10px;
        font-size: 16px;
    }

    .form-forgot .form-control:focus {
        z-index: 2;
    }

    .form-forgot input[type="text"] {
        margin-bottom: -1px;
        border-bottom-right-radius: 0;
        border-bottom-left-radius: 0;
    }

    .form-forgot input[type="password"] {
        margin-bottom: 10px;
        border-top-left-radius: 0;
        border-top-right-radius: 0;
    }
    </style>
</head>

<body class="text-center">
    <?php
        $email = "";
        if( isset($_POST["btn-submit"]) ) {
            Forgot();
        }
        function Forgot() {
            global $DATABASE, $email;
            $email = @$DATABASE->Escape($_POST["email"]);
            $sql = "
                SELECT email, user_name, user_lname, password FROM user_tmp WHERE email='".$email."' 
                UNION ALL
                SELECT email, user_name, user_lname, password FROM user WHERE email='".$email."'
            ";
            $obj = $DATABASE->QueryObj($sql);
            if( sizeof($obj)==1 ) {
                $data = $obj[0];
                $data["date"] = date("Y-m-d H:i:s");
                ShowAlert("", "รหัสผ่านของท่าน คือ ".$data["password"], "error");
            } else {
                ShowAlert("", "ไม่พบอีเมลของคุณ", "error");
            }
        }
    ?>
    <div class="container-fluid body-login">
        <form class="form-forgot" autocomplete="off" method="post">
            <img src="images/yru.png" class="img-fluid p-2 mb-3" />
            <h1 class="hd-login h3 mb-5 font-weight-bold color-sys">ระบบ Web Application</h1>
            <h6 class="mb-3 text-danger">ลืมรหัสผ่าน? 
                <br>กรุณากรอกอีเมลในช่องข้างล่างเพื่อเริ่มการตั้งค่ารหัสผ่านใหม่</h6>
            <label for="email" class="sr-only">อีเมล</label>
            <input type="email" id="email" name="email" value="<?php echo $email; ?>" class="form-control"
                placeholder="อีเมล" required autofocus>
            <div class="row mt-3">
                <div class="col-sm-6">
                    <button class="btn btn-lg btn-primary btn-block" type="submit" name="btn-submit"><i
                        class="fas fa-check mr-1"></i> ตกลง</button>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-lg btn-light btn-block" href="login.php"><i class="fas fa-arrow-left mr-1"></i>
                        ย้อนกลับ</a>
                </div>
            </div>
            <p class="mt-5 mb-3 text-muted">Copyright &copy; 2022 Satra Eadtrong Create</p>
        </form>
    </div>
</body>

</html>