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
        $("[name=ch36_num], [name=ch37]").attr("disabled", "disabled");
        if ($("#ch35_2").prop("checked")) {
            $("[name=ch36_num], [name=ch37]").removeAttr("disabled");
        }
    }
    $("[name=ch35]").change(function () {
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
                        url: "pages/" + PAGE + "/api/edit-tab35.php",
                        dataType: "JSON",
                        data: GetFormData('#formdata'),
                        contentType: false,
                        processData: false,
                        success: function (res) {
                            HideLoading();
                            if (res.status) {
                                UnbindUnload();
                                LinkTo("./?page=" + PAGE + "&home_id=" + res.home_id + "&tab=36");
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