$(function () {
    ScrollTo("#first-scroll", -30);
    // บังคับกรอกสำหรับช่อง checkbox
    jQuery(function ($) {
        var requiredCheckboxes = $(':checkbox[required]');
        requiredCheckboxes.on('change', function (e) {
            var checkboxGroup = requiredCheckboxes.filter('[name="' + $(this).attr('name') + '"]');
            var isChecked = checkboxGroup.is(':checked');
            checkboxGroup.prop('required', !isChecked);
        });
        requiredCheckboxes.trigger('change');
    });
    ChkTick();
    function ChkTick() {
        $("#ch5_num").attr("disabled", "disabled");
        if ($("#ch52").prop("checked")) {
            $("#ch5_num").removeAttr("disabled");
        }
        $("#ch8_num").attr("disabled", "disabled");
        if ($("#ch82").prop("checked")) {
            $("#ch8_num").removeAttr("disabled");
        }
        $("#ch14_desc").attr("disabled", "disabled");
        if ($("#ch133").prop("checked")) {
            $("#ch14_desc").removeAttr("disabled");
        }
        $("#ch17_desc").attr("disabled", "disabled");
        if ($("#ch163").prop("checked")) {
            $("#ch17_desc").removeAttr("disabled");
        }
    }
    $("[name=ch5], [name=ch8], [name=ch13], [name=ch16]").change(function () {
        ChkTick();
    });
    BindUnload("#formdata");
    $("#formdata").submit(function (event) {
        event.preventDefault();
        var a = ToNum($("#ch12_rai").val()) * 1 + ToNum($("#ch12_ngan").val()) * 1 + ToNum($("#ch12_wa").val()) * 1;
        if (a == 0) {
            ShowAlert({
                html: "ระบุ จำนวนพื้นที่ (ไร/งาน/วา)", type: "error", callback: function () { $("#ch12_rai").focus(); }
            }); return;
        }
        var a = ToNum($("#ch15_rai").val()) * 1 + ToNum($("#ch15_ngan").val()) * 1 + ToNum($("#ch15_wa").val()) * 1;
        if (a == 0) {
            ShowAlert({
                html: "ระบุ จำนวนพื้นที่ (ไร/งาน/วา)", type: "error", callback: function () { $("#ch15_rai").focus(); }
            }); return;
        }
        ShowConfirm({
            html: "คุณแน่ใจต้องการบันทึกการเปลี่ยนแปลงใช่หรือไม่ ?",
            callback: function (rs) {
                if (rs) {
                    ShowLoading();
                    $.ajax({
                        type: "POST",
                        url: "pages/" + PAGE + "/api/edit-tab6.php",
                        dataType: "JSON",
                        data: GetFormData('#formdata'),
                        contentType: false,
                        processData: false,
                        success: function (res) {
                            HideLoading();
                            if (res.status) {
                                UnbindUnload();
                                LinkTo("./?page=" + PAGE + "&home_id=" + res.home_id + "&tab=7");
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