$(function () {
    $("#btn-update1").click(function () {
        ShowConfirm({
            html: "คุณแน่ใจต้องการอัพเดตรายการที่ค้างอัตโนมัติใช่หรือไม่ ?",
            callback: function (rs) {
                if (rs) {
                    ShowLoading();
                    $.get("api/excel-update-runtime.php", {
                        t: moment().unix()
                    }, function (res) {
                        HideLoading();
                        ShowAlert({
                            html: res.message,
                            type: (res.status) ? "success" : "error",
                            callback: function () {
                                Reload();
                            }
                        });
                    }, "JSON").fail(function (e) {
                        HideLoading();
                        ShowAlert({
                            html: "ไม่สามารถติดต่อเครื่องแม่ข่ายได้",
                            type: "error"
                        });
                    });
                }
            }
        });
    });
    $("#form_code").inputmask("AAA-99-9999");
    $("#btn-update2").click(function () {
        var form_code = $("#form_code").val().trim();
        if (form_code == "") {
            $("#form_code").focus();
            return;
        }
        ShowConfirm({
            html: "คุณแน่ใจต้องการอัพเดตตามหมายเลขแบบสำรวจใช่หรือไม่ ?",
            callback: function (rs) {
                if (rs) {
                    ShowLoading();
                    $.get("api/excel-update.php", {
                        form_code: form_code,
                        t: moment().unix()
                    }, function (res) {
                        HideLoading();
                        ShowAlert({
                            html: res.message,
                            type: (res.status) ? "success" : "error",
                            callback: function () {
                                Reload();
                            }
                        });
                    }, "JSON").fail(function (e) {
                        HideLoading();
                        ShowAlert({
                            html: "ไม่สามารถติดต่อเครื่องแม่ข่ายได้",
                            type: "error"
                        });
                    });
                }
            }
        });
    });


    // $("#btn-test-download").click(function () {
    //     var home_id = $("#home_id").val();
    //     ShowLoading();
    //     $.get("api/excel-update.php", {
    //         home_id: home_id,
    //         t: moment().unix()
    //     }, function (res) {
    //         HideLoading();
    //         var a = document.createElement('a');
    //         a.setAttribute('href', "files/form-excel/" + res.filename);
    //         a.setAttribute('download', res.filename);
    //         a.click();
    //     }, "JSON").fail(function (e) {
    //         HideLoading();
    //         ShowAlert({
    //             html: "ไม่สามารถติดต่อเครื่องแม่ข่ายได้",
    //             type: "error"
    //         });
    //     });
    // });
});