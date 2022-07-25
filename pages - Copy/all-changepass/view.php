<?php
    $field = array();
    $field["password1"] = "";
    $field["password2"] = "";
    $field["password3"] = "";
    function edit() {
        global $DATABASE, $USER, $field;
        $field['password1'] = @$_POST["password1"];
        $field['password2'] = @$_POST["password2"];
        $field['password3'] = @$_POST["password3"];
        $sql = "SELECT * FROM user WHERE email='".$USER["email"]."' AND password='".$field['password1']."' ";
        $obj = $DATABASE->QueryObj($sql);
        if( sizeof($obj)!=1 ) {
            ShowAlert('', 'รหัสผ่านเดิมไม่ถูกต้อง !!!', 'error');
            return;
        }
        if( $field['password2']!=$field['password3'] ) {
            ShowAlert('', 'รหัสผ่านยืนยันไม่ตรงกัน !!!', 'error');
            return;
        }
        $field2 = array();
        $field2['password'] = $field['password2'];
        if( $DATABASE->QueryUpdate("user", $field2, "user_id='".$USER['user_id']."'") ) {
            $_SESSION["password"] = $field['password2'];
            ShowAlert('', 'แก้ไขข้อมูลเสร็จเรียบร้อย', 'success', './');
        } else {
            ShowAlert('', 'ไม่สามารถติดต่อฐานข้อมูลได้ !!!', 'error');
        }
    }
    if( isset($_POST['btn-submit']) && $_POST['btn-submit'] == "submit") {
        edit();
    }
?>
<div id="content-title">
    เปลี่ยนรหัสผ่าน
</div>
<div id="content-body">
    <form action="" method="POST" autocomplete="off" id="formdata" class="mb-3">
        <div class="form-row">
            <div class="col-sm-4"></div>
            <div class="form-group col-sm-4">
                <label for="password1">รหัสผ่านเดิม <span class="text-danger">*</span></label>
                <input type="password" class="form-control" name="password1" id="password1" placeHolder="--รหัสผ่าน--" value="<?php echo $field['password1']; ?>" required>
            </div>
        </div>
        <div class="form-row">
            <div class="col-sm-4"></div>
            <div class="form-group col-sm-4">
                <label for="password2">รหัสผ่านใหม่ <span class="text-danger">*</span></label>
                <input type="password" class="form-control" name="password2" id="password2" placeHolder="--รหัสผ่าน--" value="<?php echo $field['password2']; ?>" required>
            </div>
        </div>
        <div class="form-row">
            <div class="col-sm-4"></div>
            <div class="form-group col-sm-4">
                <label for="password3">ยืนยันรหัสผ่านอีกครั้ง <span class="text-danger">*</span></label>
                <input type="password" class="form-control" name="password3" id="password3" placeHolder="--รหัสผ่าน--" value="<?php echo $field['password3']; ?>" required>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4"></div>
            <div class="col-sm-4">
                <button type="submit" name="btn-submit" value="submit" class="btn btn-warning"><i class="fas fa-pen"></i> ยืนยันการแก้ไข</button>
                <a href="./?page=changepass" class="btn btn-light border"><i class="fas fa-sync-alt"></i> รีโหลด</a>
            </div>
        </div>
    </form>
</div>