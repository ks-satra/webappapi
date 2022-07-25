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
        $("#ch4_1, #ch4_2, #ch4_3, #ch4_4, #ch4_5").attr("disabled", "disabled");
        if ($("#ch32").prop("checked")) {
            $("#ch4_1, #ch4_2, #ch4_3, #ch4_4, #ch4_5").removeAttr("disabled");
        }
    }
    $("#ch31, #ch32").change(function () {
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
                        url: "pages/" + PAGE + "/api/edit-tab5.php",
                        dataType: "JSON",
                        data: GetFormData('#formdata'),
                        contentType: false,
                        processData: false,
                        success: function (res) {
                            HideLoading();
                            if (res.status) {
                                UnbindUnload();
                                LinkTo("./?page=" + PAGE + "&home_id=" + res.home_id + "&tab=6");
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