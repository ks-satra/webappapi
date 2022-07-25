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
    <!-- index -->
    <link href="assets/index.css?version=<?php echo $VERSION; ?>" rel="stylesheet">
    <script src="assets/index.js?version=<?php echo $VERSION; ?>"></script>
    <!-- login -->
    <link href="assets/login.css?version=<?php echo $VERSION; ?>" rel="stylesheet">
    <script src="assets/login.js?version=<?php echo $VERSION; ?>"></script>
</head>

<body class="text-center">
    <?php
        $email = "";
        $password = "";
        if( isset($_POST["btn-login"]) ) {
            Login();
        }
        function Login() {
            global $DATABASE, $email, $password;
            $email = @$DATABASE->Escape($_POST["email"]);
            $password = @$DATABASE->Escape($_POST["password"]);

            $sql = "SELECT * FROM user_tmp WHERE email='".$email."' AND password='".$password."' ";
            $obj = $DATABASE->QueryObj($sql);
            if( sizeof($obj)==1 ) {
                $_SESSION["eml"] = $obj[0]["email"];
                $_SESSION["psw"] = $obj[0]["password"];
                LinkTo("./main.php");
            }



            $login_id = $DATABASE->QueryMaxId("login", "login_id");
            $json_ip = @$_POST["json_ip"];
            $session = session_id();
            $ip_local = GetClientIpEnv();
            if( trim($email)=='' || trim($password)=='' ) {
                ShowAlert("", "ชื่อบัญชีผู้ใช้ หรือรหัสผ่านมีค่าว่าง", "error");
                return;
            }
            $sql = "SELECT * FROM user WHERE email='".$email."' AND password='".$password."' AND `status`='Y' ";
            $obj = $DATABASE->QueryObj($sql);
            if( sizeof($obj)==1 ) {
                $_SESSION["email"] = $obj[0]["email"];
                $_SESSION["password"] = $obj[0]["password"];
                $sql = "
                    INSERT INTO login (
                        login_id,
                        session,
                        ip_local,
                        json_ip,
                        status,
                        email,
                        password,
                        user,
                        date
                    ) VALUES (
                        '".$login_id."',
                        '".$session."',
                        '".$ip_local."',
                        '".$DATABASE->Escape($json_ip)."',
                        'Y',
                        '".$email."',
                        '".$password."',
                        '".$obj[0]["user_id"]."',
                        '".date("Y-m-d H:i:s")."'
                    )
                ";
                $DATABASE->Query($sql);
                LinkTo("./");
            } else {
                $sql = "
                    INSERT INTO login (
                        login_id,
                        session,
                        ip_local,
                        json_ip,
                        status,
                        email,
                        password,
                        user,
                        date
                    ) VALUES (
                        '".$login_id."',
                        '".$session."',
                        '".$ip_local."',
                        '".$DATABASE->Escape($json_ip)."',
                        'N',
                        '".$email."',
                        '".$password."',
                        '',
                        '".date("Y-m-d H:i:s")."'
                    )
                ";
                $DATABASE->Query($sql);
                ShowAlert("", "กรุณาตรวจสอบรหัสผ่านของท่านอีกครั้ง !", "error");
            }
        }
    ?>
    <div class="container-fluid body-login">
        <form class="form-signin" autocomplete="off" method="post">
            <?php
                // PrintData($_SESSION);
            ?>
            <input type="hidden" name="json_ip">
            <input type="hidden" name="btn-login">
            <img src="images/yru.png" class="img-fluid p-2 mb-3" />
            <h1 class="hd-login h3 mb-5 font-weight-bold color-sys">Web Application</h1>
            <label for="email" class="sr-only">อีเมล</label>
            <input type="email" id="email" name="email" value="<?php echo $email; ?>" class="form-control"
                placeholder="อีเมล" required autofocus>
            <label for="password" class="sr-only">รหัสผ่าน</label>
            <input type="password" id="password" name="password" value="<?php echo $password; ?>" class="form-control"
                placeholder="รหัสผ่าน" required>
            <button class="btn btn-lg btn-primary btn-block mt-3 mb-3 text-white btn-login" type="submit"><i
                    class="fas fa-sign-in-alt"></i> เข้าสู่ระบบ</button>
            <div class="row">
                <div class="col-sm-6"><a class="btn btn-link" href="register.php"><i class="fas fa-user-plus mr-1"></i>
                        ลงทะเบียน</a></div>
                <div class="col-sm-6"><a class="btn btn-link" href="forgot.php"><i class="fas fa-unlock mr-1"></i>
                        ลืมรหัสผ่าน</a></div>
            </div>
            <p class="mt-5 mb-3 text-muted">Copyright &copy; 2022 Satra Eadtrong Create</p>
        </form>
    </div>
</body>

</html>