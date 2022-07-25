$(function () {
    ScrollTo("#first-scroll", -30);
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
                        url: "pages/" + PAGE + "/api/edit-tab28.php",
                        dataType: "JSON",
                        data: GetFormData('#formdata'),
                        contentType: false,
                        processData: false,
                        success: function (res) {
                            HideLoading();
                            if (res.status) {
                                UnbindUnload();
                                LinkTo("./?page=" + PAGE + "&home_id=" + res.home_id + "&tab=29");
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
    $("[name^=amount]").keyup(function () {
        var name = $(this).attr("name");
        var k = (((name.split("["))[1]).split("]"))[0];
        Calc(k);
    });
    $("[name^=unit_id]").change(function () {
        var name = $(this).attr("name");
        var k = (((name.split("["))[1]).split("]"))[0];
        Calc(k);
    });
    function Calc(k) {
        var amount = $("[name='amount[" + k + "]']").val();
        var unit_id = $("[name='unit_id[" + k + "]']").val();
        var total = 0;
        if (unit_id == "1") total = ToNum(amount) * 1 * 365;
        if (unit_id == "2") total = ToNum(amount) * 1 * 12;
        if (unit_id == "3") total = ToNum(amount) * 1 * 1;
        $("[name='total[" + k + "]']").val(NumberFormat(total, 0));
    }
});