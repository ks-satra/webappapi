$(function () {
    ScrollTo("#first-scroll", -30);
    ChkTick();
    function ChkTick() {
        $("[name=ch19], [name=ch19_num], [name=ch20]").attr("disabled", "disabled");
        if ($("#ch18_1").prop("checked")) {
            $("[name=ch19]").removeAttr("disabled");
            if ($("#ch19_2").prop("checked")) {
                $("[name=ch19_num]").removeAttr("disabled");
            }
        }
        if ($("#ch18_2").prop("checked")) {
            $("[name=ch20]").removeAttr("disabled");
        }
        $("[name=ch22], [name=ch22_num], [name=ch23]").attr("disabled", "disabled");
        if ($("#ch21_1").prop("checked")) {
            $("[name=ch22]").removeAttr("disabled");
            if ($("#ch22_2").prop("checked")) {
                $("[name=ch22_num]").removeAttr("disabled");
            }
        }
        if ($("#ch21_2").prop("checked")) {
            $("[name=ch23]").removeAttr("disabled");
        }
        $("[name=ch25], [name=ch25_num], [name=ch26]").attr("disabled", "disabled");
        if ($("#ch24_1").prop("checked")) {
            $("[name=ch25]").removeAttr("disabled");
            if ($("#ch25_2").prop("checked")) {
                $("[name=ch25_num]").removeAttr("disabled");
            }
        }
        if ($("#ch24_2").prop("checked")) {
            $("[name=ch26]").removeAttr("disabled");
        }

        $("[name=ch28], [name=ch28_num], [name=ch29]").attr("disabled", "disabled");
        if ($("#ch27_1").prop("checked")) {
            $("[name=ch28]").removeAttr("disabled");
            if ($("#ch28_2").prop("checked")) {
                $("[name=ch28_num]").removeAttr("disabled");
            }
        }
        if ($("#ch27_2").prop("checked")) {
            $("[name=ch29]").removeAttr("disabled");
        }
    }
    $("[name=ch18], [name=ch19], [name=ch21], [name=ch22], [name=ch24], [name=ch25], [name=ch27], [name=ch28]").change(function () {
        ChkTick();
    });
    BindUnload("#formdata");
    $("#formdata").submit(function (event) {
        event.preventDefault();
        ShowConfirm({
            html: "คุณแน่ใจต้องการบันทึกการเปลี่ยนแปลงใช่หรือไม่ ?",
            callback: function (rs) {
                if (rs) {
                    ShowLoading();
                    $.ajax({
                        type: "POST",
                        url: "pages/" + PAGE + "/api/edit-tab8.php",
                        dataType: "JSON",
                        data: GetFormData('#formdata'),
                        contentType: false,
                        processData: false,
                        success: function (res) {
                            HideLoading();
                            if (res.status) {
                                UnbindUnload();
                                LinkTo("./?page=" + PAGE + "&home_id=" + res.home_id + "&tab=9");
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