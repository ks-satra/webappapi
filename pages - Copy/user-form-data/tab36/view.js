$(function () {
    ScrollTo("#first-scroll", -30);
    var staff_image = $("#staff_image_show").attr("src");
    $("#staff_image").change(function () {
        FileChange(GLOBAL.ALLOW_IMAGE, GLOBAL.ALLOW_SIZE, this, "#staff_image_show", staff_image);
    });

    $("#staff1_phone").inputmask({ "mask": "999-9999999" });
    $("#staff2_phone").inputmask({ "mask": "999-9999999" });
    $("#staff3_phone").inputmask({ "mask": "999-9999999" });
    BindUnload("#formdata");
    $("#formdata").submit(function (event) {
        event.preventDefault();
        if (!$("#staff1_phone").inputmask('isComplete')) {
            ShowAlert({
                html: "กรุณาระบุโทรศัพท์ผู้สำรวจข้อมูล คนที่ 1",
                type: "error",
                callback: function () { $("#staff1_phone").focus(); }
            });
            return;
        }
        if ($("#staff2_phone").val() != "") {
            if (!$("#staff2_phone").inputmask('isComplete')) {
                ShowAlert({
                    html: "กรุณาระบุโทรศัพท์ผู้สำรวจข้อมูล คนที่ 2",
                    type: "error",
                    callback: function () { $("#staff2_phone").focus(); }
                });
                return;
            }
        }
        if (!$("#staff3_phone").inputmask('isComplete')) {
            ShowAlert({
                html: "กรุณาระบุโทรศัพท์ผู้บันทึกข้อมูล",
                type: "error",
                callback: function () { $("#staff3_phone").focus(); }
            });
            return;
        }
        ShowConfirm({
            html: "คุณแน่ใจต้องการบันทึกการเปลี่ยนแปลงใช่หรือไม่ ?",
            callback: function (rs) {
                if (rs) {
                    ShowLoading();
                    $.ajax({
                        type: "POST",
                        url: "pages/" + PAGE + "/api/edit-tab36.php",
                        dataType: "JSON",
                        data: GetFormData('#formdata'),
                        contentType: false,
                        processData: false,
                        success: function (res) {
                            HideLoading();
                            if (res.status) {
                                UnbindUnload();
                                LinkTo("./?page=alls-form-data-info&home_id=" + res.home_id);
                            } else {
                                ShowAlert({
                                    html: res.message,
                                    type: (res.status) ? "success" : "error"
                                });
                            }
                        },
                        error: function () {
                            HideLoading();
                            ShowAlert({
                                html: "ไม่สามารถติดต่อเครื่องแม่ข่ายได้",
                                type: "error",
                                callback: function () {
                                    Reload();
                                }
                            });
                        }
                    });
                }
            }
        });
    });
});