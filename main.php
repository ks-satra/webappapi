<?php
    include_once("php/autoload.php");

    $eml = @$_SESSION["eml"];
    $psw = @$_SESSION["psw"];
    $sql = "SELECT * FROM user_tmp WHERE email='".$eml."' AND password='".$psw."' ";
    $obj = $DATABASE->QueryObj($sql);
    if( sizeof($obj)==0 ) {
        LinkTo("./login.php");
    }
    $data = $obj[0];
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="images/yru.png">
    <title>ระบบ Web Application</title>
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
        $("#btn-logout").click(function() {
            ShowConfirm({
                html: "คุณแน่ใจต้องการออกระบบใช่หรือไม่ ?",
                callback: function(rs) {
                    if (rs) {
                        LinkTo("./logout.php");
                    }
                }
            });
        });
        $("#btn-cancel").click(function() {
            ShowConfirm({
                html: "คุณแน่ใจต้องการยกเลิกการลงทะเบียนใช่หรือไม่ ?",
                callback: function(rs) {
                    if (rs) {
                        ShowLoading();
                        $.ajax({
                            type: "POST",
                            url: "api/user-tmp-cancel.php",
                            dataType: "JSON",
                            data: GetFormData("#formdata"),
                            contentType: false,
                            processData: false,
                            success: function(res) {
                                HideLoading();
                                ShowAlert({
                                    html: res.message,
                                    type: (res.status) ? "info" :
                                        "error",
                                    callback: function() {
                                        if (res.status) {
                                            Reload();
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
    <?php
        if( isset($_POST["btn-submit"]) ) {
            Submit();
        }
        function Submit() {
            global $DATABASE, $GLOBAL;
            $dir = "files/user-tmp/";
            $data["user_id"] = @$DATABASE->Escape($_POST["user_id"]);
            $data["area_province_id"] = @$DATABASE->Escape($_POST["area_province_id"]);
            $data["item_prefix_id"] = @$DATABASE->Escape($_POST["item_prefix_id"]);
            $data["user_name"] = @$DATABASE->Escape($_POST["user_name"]);
            $data["user_lname"] = @$DATABASE->Escape($_POST["user_lname"]);
            $data["phone"] = @$DATABASE->Escape($_POST["phone"]);
            $data["password"] = @$DATABASE->Escape($_POST["password"]);
            $data["status"] = "N";
            $data["user"] = "";
            $data["date"] = date("Y-m-d H:i:s");
            
            $sql = "SELECT * FROM user_tmp WHERE user_id='".$data["user_id"]."' ";
            $obj = $DATABASE->QueryObj($sql);
            $image = ( sizeof($obj)==1 ) ? $obj[0]["image"] : "";

            $upload = UploadFile("imagef", $dir, time(), $GLOBAL["ALLOW_IMAGE"]);
            if( $upload["status"]==true ) {
                RemoveFile($dir, $image);
                $data['image'] = $upload["fileName"];
            }

            $DATABASE->QueryUpdate("user_tmp", $data, " user_id='".$data["user_id"]."' ");
            $_SESSION["psw"] = $data["password"];
            ShowAlert("", "บันทึกการเปลี่ยนแปลงสำเร็จ", "success", "./main.php");
        }
    ?>
    <div id="my-form" class="container-fluid">
        <form id="formdata" action="" autocomplete="off" method="post" enctype="multipart/form-data">
            <div class="alert alert-warning mb-4" role="alert">
                บัญชีการใช้งานของคุณอยู่ระหว่างตรวจสอบโดยเจ้าหน้าที่ สามารถเข้าใช้งานได้ภายใน 1 - 2 วัน 
            </div>
            <input type="hidden" name="user_id" value="<?php echo $data["user_id"]; ?>">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <label>รูปโปรไฟล์</label>
                    <img id="image" class="w-100 mb-3" src="./files/user-tmp/<?php echo $data["image"]; ?>"
                        alt="Profile" onerror="ImageError(this, './files/user/default.png')">
                    <input class="w-100" type="file" id="imagef" name="imagef"
                        accept="<?php echo AcceptImplode($GLOBAL["ALLOW_IMAGE"]);?>">
                </div>
                <div class="col-md-8">
                    <div class="form-row">
                        <!-- <div class="col-md-12">
                            <label for="area_province_id">พื้นที่</label>
                            <select class="form-control mb-3" id="area_province_id" name="area_province_id" required>
                                <?php
                                    // $sql = "
                                    //     SELECT 
                                    //         area.*,
                                    //         province.province_name_thai
                                    //     FROM area 
                                    //         INNER JOIN province ON province.province_id=area.province_id
                                    //     ORDER BY area.province_id
                                    // ";
                                    // $obj = $DATABASE->QueryObj($sql);
                                    // foreach($obj as $row) {
                                    //     $selected = ($row["province_id"]==$data["area_province_id"]) ? "selected": "";
                                    //     echo '<option value="'.$row["province_id"].'" '.$selected.'>จังหวัด'.$row["province_name_thai"].'</option>';
                                    // }
                                ?>
                            </select>
                        </div> -->
                        <div class="col-md-12">
                            <label for="item_prefix_id">คำนำหน้า</label>
                            <select class="form-control mb-3" id="item_prefix_id" name="item_prefix_id" required>
                                <?php
                                    $sql = "SELECT * FROM item_prefix ORDER BY item_prefix_id";
                                    $obj = $DATABASE->QueryObj($sql);
                                    foreach($obj as $row) {
                                        $selected = ($row["item_prefix_id"]==$data["item_prefix_id"]) ? "selected": "";
                                        echo '<option value="'.$row["item_prefix_id"].'" '.$selected.'>'.$row["item_prefix_name"].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label for="user_name">ชื่อ</label>
                            <input type="text" class="form-control mb-3" id="user_name" name="user_name"
                                placeholder="ชื่อ" value="<?php echo $data["user_name"]; ?>" required>
                        </div>
                        <div class="col-md-12">
                            <label for="user_lname">นามสกุล</label>
                            <input type="text" class="form-control mb-3" id="user_lname" name="user_lname"
                                placeholder="นามสกุล" value="<?php echo $data["user_lname"]; ?>" required>
                        </div>
                        <div class="col-md-12">
                            <label for="phone">โทรศัพท์</label>
                            <input type="text" class="form-control mb-3" id="phone" name="phone" placeholder="โทรศัพท์"
                                value="<?php echo $data["phone"]; ?>" required>
                        </div>
                        <div class="col-md-12">
                            <label for="email">อีเมล</label>
                            <input type="email" class="form-control mb-3" id="email" placeholder="อีเมล"
                                value="<?php echo $data["email"]; ?>" disabled>
                        </div>
                        <div class="col-md-12">
                            <label for="password">รหัสผ่าน</label>
                            <input type="password" class="form-control mb-3" id="password" name="password"
                                placeholder="รหัสผ่าน" value="<?php echo $data["password"]; ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <button class="btn btn-warning btn-block mb-3" type="submit" name="btn-submit"><i
                                    class="fas fa-check mr-1"></i> บันทึกการเปลี่ยนแปลง</button>
                        </div>
                        <div class="col-sm-6">
                            <button class="btn btn-dark btn-block mb-3" type="button" id="btn-logout"><i
                                    class="fas fa-sign-out-alt mr-1"></i> ออกจากระบบ</button>
                        </div>
                        <div class="col-sm-6">
                            <button class="btn btn-danger btn-block mb-3" type="button" id="btn-cancel"><i
                                    class="fas fa-times mr-1"></i> ยกเลิกการลงทะเบียน</button>
                        </div>
                    </div>
                    <p class="mt-5 mb-3 text-muted text-center">Copyright &copy; 2021 Pidthong Team</p>
                </div>
            </div>
        </form>
    </div>
</body>

</html>