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
    <link rel="icon" href="images/logo.png">
    <title>เข้าสู่ระบบเศรษฐกิจและสังคม</title>
    <script>
    var VERSION = "<?php echo $VERSION; ?>";
    var GLOBAL = JSON.parse('<?php echo json_encode($GLOBAL); ?>');
    var USER = JSON.parse('<?php echo json_encode($USER); ?>');
    </script>
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
    <!-- login -->
    <link href="assets/login.css?version=<?php echo $VERSION; ?>" rel="stylesheet">
    <script src="assets/login.js?version=<?php echo $VERSION; ?>"></script>
    <style>
    #my-form {
        padding-top: 70px;
        max-width: 700px;
    }
    </style>
    <script>
    $(function() {
        $("#phone").inputmask({
            "mask": "999-9999999"
        });
        $("#imagef").change(function() {
            FileChange(GLOBAL.ALLOW_IMAGE, GLOBAL.ALLOW_SIZE, this, $("#image"),
                './files/user/default.png',
                function() {});
        });
        BindUnload("#formdata");
        $("#formdata").submit(function(event) {
            event.preventDefault();
            if (!$("#phone").inputmask('isComplete')) {
                ShowAlert({
                    html: "กรุณาระบุโทรศัพท์ให้ถูกต้อง",
                    type: "error",
                    callback: function() {
                        $("#phone").focus();
                    }
                });
                return;
            }
            ShowConfirm({
                html: "คุณแน่ใจต้องการลงทะเบียนใช่หรือไม่ ?",
                callback: function(rs) {
                    if (rs) {
                        ShowLoading();
                        $.ajax({
                            type: "POST",
                            url: "api/register.php",
                            dataType: "JSON",
                            data: GetFormData('#formdata'),
                            contentType: false,
                            processData: false,
                            success: function(res) {
                                HideLoading();
                                ShowAlert({
                                    html: res.message,
                                    type: (res.status) ? "success" :
                                        "error",
                                    callback: function() {
                                        if (res.status) {
                                            UnbindUnload();
                                            LinkTo("./main.php");
                                        }
                                    }
                                });
                            },
                            error: function() {
                                HideLoading();
                                ShowAlert({
                                    html: "ไม่สามารถติดต่อเครื่องแม่ข่ายได้",
                                    type: "error"
                                });
                            }
                        });
                    }
                }
            });
        });
    });
    </script>
</head>

<body>
    <div id="my-form" class="container-fluid">
        <form id="formdata" autocomplete="off">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <label>รูปโปรไฟล์ <span class="text-danger">*</span></label>
                    <img id="image" class="w-100 mb-3" src="./files/user/default.png" alt="Profile"
                        onerror="ImageError(this, './files/user/default.png')">
                    <input class="w-100" type="file" id="imagef" name="imagef"
                        accept="<?php echo AcceptImplode($GLOBAL["ALLOW_IMAGE"]);?>" required>
                </div>
                <div class="col-md-8">
                    <div class="form-row">
                        <div class="col-md-12">
                            <label for="area_province_id">พื้นที่ <span class="text-danger">*</span></label>
                            <select class="form-control mb-3" id="area_province_id" name="area_province_id" required>
                                <?php
                                    $sql = "
                                        SELECT 
                                            area.*,
                                            province.province_name_thai
                                        FROM area 
                                            INNER JOIN province ON province.province_id=area.province_id
                                        ORDER BY area.province_id
                                    ";
                                    $obj = $DATABASE->QueryObj($sql);
                                    foreach($obj as $row) {
                                        echo '<option value="'.$row["province_id"].'">จังหวัด'.$row["province_name_thai"].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label for="item_prefix_id">คำนำหน้า <span class="text-danger">*</span></label>
                            <select class="form-control mb-3" id="item_prefix_id" name="item_prefix_id" required>
                                <?php
                                    $sql = "SELECT * FROM item_prefix ORDER BY item_prefix_id";
                                    $obj = $DATABASE->QueryObj($sql);
                                    foreach($obj as $row) {
                                        echo '<option value="'.$row["item_prefix_id"].'">'.$row["item_prefix_name"].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label for="user_name">ชื่อ <span class="text-danger">*</span></label>
                            <input type="text" class="form-control mb-3" id="user_name" name="user_name"
                                placeholder="ชื่อ" required>
                        </div>
                        <div class="col-md-12">
                            <label for="user_lname">นามสกุล <span class="text-danger">*</span></label>
                            <input type="text" class="form-control mb-3" id="user_lname" name="user_lname"
                                placeholder="นามสกุล" required>
                        </div>
                        <div class="col-md-12">
                            <label for="phone">โทรศัพท์ <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control mb-3" id="phone" name="phone" placeholder="โทรศัพท์"
                                required>
                        </div>
                        <div class="col-md-12">
                            <label for="email">อีเมล <span class="text-danger">*</span></label>
                            <input type="email" class="form-control mb-3" id="email" name="email" placeholder="อีเมล"
                                required>
                        </div>
                        <div class="col-md-12">
                            <label for="password">รหัสผ่าน <span class="text-danger">*</span></label>
                            <input type="password" class="form-control mb-3" id="password" name="password"
                                placeholder="รหัสผ่าน" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <button class="btn btn-primary btn-block" type="submit" name="btn-submit"><i
                                    class="fas fa-user-plus mr-1"></i> ลงทะเบียน</button>
                        </div>
                        <div class="col-sm-6">
                            <a class="btn btn-light btn-block" href="login.php"><i class="fas fa-arrow-left mr-1"></i>
                                ย้อนกลับ</a>
                        </div>
                    </div>
                    <p class="mt-5 mb-3 text-muted text-center">Copyright &copy; 2022 Satra Eadtrong Create</p>
                </div>
            </div>
        </form>
    </div>
</body>

</html>