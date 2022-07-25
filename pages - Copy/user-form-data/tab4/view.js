$(function () {
    ScrollTo("#first-scroll", -30);
    ChkTick();
    function ChkTick() {
        if ($("#ch2_1").prop("checked")) {
            $("#ch2_1_num, #ch2_1_rai, #ch2_1_ngan, #ch2_1_wa").removeAttr("disabled");
            $("#ch2_2, #ch2_3").attr("disabled", "disabled");
        } else {
            $("#ch2_1_num, #ch2_1_rai, #ch2_1_ngan, #ch2_1_wa").attr("disabled", "disabled");
            $("#ch2_2, #ch2_3").removeAttr("disabled");
        }
        if ($("#ch2_2").prop("checked")) {
            $("#ch2_2_num, #ch2_2_rai, #ch2_2_ngan, #ch2_2_wa").removeAttr("disabled");
            $("#ch2_1").attr("disabled", "disabled");
            $("#ch2_3").removeAttr("required");
        } else {
            $("#ch2_2_num, #ch2_2_rai, #ch2_2_ngan, #ch2_2_wa").attr("disabled", "disabled");
            $("#ch2_3").attr("required", "required");
        }
        if ($("#ch2_3").prop("checked")) {
            $("#ch2_3_num, #ch2_3_rai, #ch2_3_ngan, #ch2_3_wa").removeAttr("disabled");
            $("#ch2_1").attr("disabled", "disabled");
            $("#ch2_2").removeAttr("required");
        } else {
            $("#ch2_3_num, #ch2_3_rai, #ch2_3_ngan, #ch2_3_wa").attr("disabled", "disabled");
            $("#ch2_2").attr("required", "required");
        }
        if (!$("#ch2_2").prop("checked") && !$("#ch2_3").prop("checked")) {
            $("#ch2_1").removeAttr("disabled");
        }
    }
    $("#ch2_1, #ch2_2, #ch2_3").change(function () {
        ChkTick();
    });
    BindUnload("#formdata");
    $("#formdata").submit(function (event) {
        event.preventDefault();
        if ($("#ch2_1").prop("checked")) {
            if (ToNum($("#ch2_1_num").val()) * 1 == 0) {
                ShowAlert({
                    html: "ระบุ จำนวนบ้าน (หลัง)", type: "error", callback: function () { $("#ch2_1_num").focus(); }
                }); return;
            }
            var a = ToNum($("#ch2_1_rai").val()) * 1 + ToNum($("#ch2_1_ngan").val()) * 1 + ToNum($("#ch2_1_wa").val()) * 1;
            if (a == 0) {
                ShowAlert({
                    html: "ระบุ จำนวนพื้นที่ (ไร/งาน/วา)", type: "error", callback: function () { $("#ch2_1_rai").focus(); }
                }); return;
            }
        }
        if ($("#ch2_2").prop("checked")) {
            if (ToNum($("#ch2_2_num").val()) * 1 == 0) {
                ShowAlert({
                    html: "ระบุ จำนวนบ้าน (หลัง)", type: "error", callback: function () { $("#ch2_2_num").focus(); }
                }); return;
            }
            var a = ToNum($("#ch2_2_rai").val()) * 1 + ToNum($("#ch2_2_ngan").val()) * 1 + ToNum($("#ch2_2_wa").val()) * 1;
            if (a == 0) {
                ShowAlert({
                    html: "ระบุ จำนวนพื้นที่ (ไร/งาน/วา)", type: "error", callback: function () { $("#ch2_2_rai").focus(); }
                }); return;
            }
        }
        if ($("#ch2_3").prop("checked")) {
            if (ToNum($("#ch2_3_num").val()) * 1 == 0) {
                ShowAlert({
                    html: "ระบุ จำนวนบ้าน (หลัง)", type: "error", callback: function () { $("#ch2_3_num").focus(); }
                }); return;
            }
            var a = ToNum($("#ch2_3_rai").val()) * 1 + ToNum($("#ch2_3_ngan").val()) * 1 + ToNum($("#ch2_3_wa").val()) * 1;
            if (a == 0) {
                ShowAlert({
                    html: "ระบุ จำนวนพื้นที่ (ไร/งาน/วา)", type: "error", callback: function () { $("#ch2_3_rai").focus(); }
                }); return;
            }
        }
        ShowConfirm({
            html: "คุณแน่ใจต้องการบันทึกการเปลี่ยนแปลงใช่หรือไม่ ?",
            callback: function (rs) {
                if (rs) {
                    ShowLoading();
                    $.ajax({
                        type: "POST",
                        url: "pages/" + PAGE + "/api/edit-tab4.php",
                        dataType: "JSON",
                        data: GetFormData('#formdata'),
                        contentType: false,
                        processData: false,
                        success: function (res) {
                            HideLoading();
                            if (res.status) {
                                UnbindUnload();
                                LinkTo("./?page=" + PAGE + "&home_id=" + res.home_id + "&tab=5");
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