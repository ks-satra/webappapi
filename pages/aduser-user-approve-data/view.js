$(function() {
    $("#btn-approve").click(function() {
        var data = JSON.parse($("#data").val());
        ShowConfirm({
            html: "คุณแน่ใจต้องการอนุมัติผู้ใช้งานนี้ใช่หรือไม่ ?",
            callback: function(rs) {
                if (rs) {
                    ShowLoading();
                    $.post("pages/" + PAGE + "/api/approve.php", {
                        user_id: data.user_id
                    }, function(res) {
                        HideLoading();
                        ShowAlert({
                            html: res.message,
                            type: (res.status) ? "info" : "error",
                            callback: function() {
                                if (res.status) {
                                    UnbindUnload();
                                    Reload();
                                }
                            }
                        });
                    }, "JSON").fail(function(e) {
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
    $("#btn-del").click(function() {
        var data = JSON.parse($("#data").val());
        ShowConfirm({
            html: "คุณแน่ใจต้องการลบข้อมูลนี้ใช่หรือไม่ ?",
            callback: function(rs) {
                if (rs) {
                    ShowLoading();
                    $.post("pages/" + PAGE + "/api/del.php", {
                        user_id: data.user_id
                    }, function(res) {
                        HideLoading();
                        ShowAlert({
                            html: res.message,
                            type: (res.status) ? "info" : "error",
                            callback: function() {
                                if (res.status) {
                                    UnbindUnload();
                                    Reload();
                                }
                            }
                        });
                    }, "JSON").fail(function(e) {
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

function onError(ctrl) {
    ImageError(ctrl, './files/user/default.png');
    $(ctrl).closest("a").attr("href", './files/user/default.png');
    toggleImageViewer($(ctrl).closest("a"));
}