$(function () {
    $("#btn-del").click(function (event) {
        event.preventDefault();
        var home = JSON.parse($("#home").val());
        ShowConfirm({
            html: "คุณแน่ใจต้องการลบข้อมูลแบบสำรวจนี้ทั้งหมดใช่หรือไม่ ?",
            callback: function (rs) {
                if (rs) {
                    ShowLoading();
                    $.post("pages/" + PAGE + "/api/del.php", {
                        home_id: home.home_id
                    }, function (res) {
                        HideLoading();
                        if (res.status == false) {
                            ShowAlert({
                                html: res.message,
                                type: "error",
                                callback: function () {
                                    LinkTo("./?page=user-form");
                                }
                            });
                        } else {
                            Reload();
                        }
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
    $("#btn-del-force").click(function (event) {
        event.preventDefault();
        var home = JSON.parse($("#home").val());
        ShowConfirm({
            html: "คุณแน่ใจต้องการลบข้อมูลแบบสำรวจนี้ทั้งหมดใช่หรือไม่ ?",
            callback: function (rs) {
                if (rs) {
                    ShowLoading();
                    $.post("pages/" + PAGE + "/api/del-force.php", {
                        home_id: home.home_id
                    }, function (res) {
                        HideLoading();
                        if (res.status == false) {
                            ShowAlert({
                                html: res.message,
                                type: "error",
                                callback: function () {
                                    LinkTo("./?page=user-form");
                                }
                            });
                        } else {
                            Reload();
                        }
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
});