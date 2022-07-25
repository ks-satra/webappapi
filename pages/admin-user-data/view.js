$(function() {
    $("#btn-del").click(function() {
        var data = JSON.parse($("#data").val());
        ShowConfirm({
            html: "คุณแน่ใจต้องการลบข้อมูลนี้ใช่หรือไม่ ?",
            callback: function(rs) {
                if (rs) {
                    ShowLoading();
                    $.post("pages/admin-user/api/del.php", {
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
    $("[id^='level-']").click(function() {
        var level_id = $(this).val();
        var checked = ($(this).prop("checked")) ? "Y" : "N";
        var data = JSON.parse($("#data").val());
        ShowLoading();
        $.post("pages/" + PAGE + "/api/user-level-edit.php", {
            user_id: data.user_id,
            level_id: level_id,
            checked: checked
        }, function(res) {
            HideLoading();
            if (!res.status) {
                ShowAlert({
                    html: res.message,
                    type: (res.status) ? "info" : "error",
                    callback: function() {
                        Reload();
                    }
                });
            } else {
                Reload();
            }
        }, "JSON").fail(function(e) {
            HideLoading();
            ShowAlert({
                html: "ไม่สามารถติดต่อเครื่องแม่ข่ายได้",
                type: "error",
                callback: function() {
                    Reload();
                }
            });
        });
    });
    $("[id^='area-']").click(function() {
        var province_id = $(this).val();
        var checked = ($(this).prop("checked")) ? "Y" : "N";
        var data = JSON.parse($("#data").val());
        ShowLoading();
        $.post("pages/" + PAGE + "/api/user-area-edit.php", {
            user_id: data.user_id,
            province_id: province_id,
            checked: checked
        }, function(res) {
            HideLoading();
            if (!res.status) {
                ShowAlert({
                    html: res.message,
                    type: (res.status) ? "info" : "error",
                    callback: function() {
                        Reload();
                    }
                });
            } else {
                Reload();
            }
        }, "JSON").fail(function(e) {
            HideLoading();
            ShowAlert({
                html: "ไม่สามารถติดต่อเครื่องแม่ข่ายได้",
                type: "error",
                callback: function() {
                    Reload();
                }
            });
        });
    });
    $("[id^='area2-']").click(function() {
        var province_id = $(this).val();
        var checked = ($(this).prop("checked")) ? "Y" : "N";
        var data = JSON.parse($("#data").val());
        ShowLoading();
        $.post("pages/" + PAGE + "/api/user-area-admin-edit.php", {
            user_id: data.user_id,
            province_id: province_id,
            checked: checked
        }, function(res) {
            HideLoading();
            if (!res.status) {
                ShowAlert({
                    html: res.message,
                    type: (res.status) ? "info" : "error",
                    callback: function() {
                        Reload();
                    }
                });
            } else {
                Reload();
            }
        }, "JSON").fail(function(e) {
            HideLoading();
            ShowAlert({
                html: "ไม่สามารถติดต่อเครื่องแม่ข่ายได้",
                type: "error",
                callback: function() {
                    Reload();
                }
            });
        });
    });
});

function onError(ctrl) {
    ImageError(ctrl, './files/user/default.png');
    $(ctrl).closest("a").attr("href", './files/user/default.png');
    toggleImageViewer($(ctrl).closest("a"));
}