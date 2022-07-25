$(function () {
    ScrollTo("#first-scroll", -30);
    $("#informant_phone").inputmask({ "mask": "999-999999[9]" });
    BindUnload("#formdata");
    $("#formdata").submit(function (event) {
        event.preventDefault();
        if ($("#informant_phone").val() != "") {
            if (!$("#informant_phone").inputmask('isComplete')) {
                ShowAlert({
                    html: "กรุณาระบุโทรศัพท์ (บ้าน/มือถือ) ให้ถูกต้อง",
                    type: "error",
                    callback: function () { $("#informant_phone").focus(); }
                });
                return;
            }
        }
        ShowConfirm({
            html: "คุณแน่ใจต้องการบันทึกการเปลี่ยนแปลงใช่หรือไม่ ?",
            callback: function (rs) {
                if (rs) {
                    ShowLoading();
                    $.ajax({
                        type: "POST",
                        url: "pages/" + PAGE + "/api/edit-tab2.php",
                        dataType: "JSON",
                        data: GetFormData('#formdata'),
                        contentType: false,
                        processData: false,
                        success: function (res) {
                            HideLoading();
                            if (res.status) {
                                UnbindUnload();
                                LinkTo("./?page=" + PAGE + "&home_id=" + res.home_id + "&tab=3");
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