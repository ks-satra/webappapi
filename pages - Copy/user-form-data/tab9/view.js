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

        var order = {
            "1": true,
            "2": true,
            "3": true
        };
        $("[name^=item_behavior_id]").find("option").removeAttr("disabled");
        $.each($("[name^=item_behavior_id]"), function (i, v) {
            var item_behavior_id = $(this).val();
            if (item_behavior_id != "") {
                order[item_behavior_id] = false;
            }
        });
        var c_false = 0;
        $.each(order, function (i, v) {
            if (!v) {
                $.each($("[name^=item_behavior_id]"), function () {
                    var $option = $(this).find("option[value=" + i + "]")
                    if ($(this).val() != i) {
                        $option.attr("disabled", "disabled");
                    }
                });
                c_false++;
            }
        });
        $("[name^=item_behavior_id]").removeAttr("disabled");
        if (c_false == 3) {
            $.each($("[name^=item_behavior_id]"), function (i, v) {
                var item_behavior_id = $(this).val();
                if (item_behavior_id == "") {
                    $(this).attr("disabled", "disabled");
                }
            });
        }
        $("[name^=item_contagious_id]").attr("disabled", "disabled");
        if ($("#ch31_2").prop("checked")) {
            $("[name^=item_contagious_id]").removeAttr("disabled");
        }
        $("[name^=item_disability_id]").attr("disabled", "disabled");
        if ($("#ch32_2").prop("checked")) {
            $("[name^=item_disability_id]").removeAttr("disabled");
        }
    }
    $("[name^=item_behavior_id], [name=ch31], [name=ch32]").change(function () {
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
                        url: "pages/" + PAGE + "/api/edit-tab9.php",
                        dataType: "JSON",
                        data: GetFormData('#formdata'),
                        contentType: false,
                        processData: false,
                        success: function (res) {
                            HideLoading();
                            if (res.status) {
                                UnbindUnload();
                                LinkTo("./?page=" + PAGE + "&home_id=" + res.home_id + "&tab=10");
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