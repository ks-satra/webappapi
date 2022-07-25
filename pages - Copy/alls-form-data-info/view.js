$(function () {
    $("#btn-load").click(function () {
        var home_id = $("#home_id").val();
        LoadPdf(home_id);
    });
    $("#btn-send").click(function () {
        ShowConfirm({
            html: "คุณแน่ใจต้องการส่งแบบสำรวจนี้ใช่หรือไม่ ?",
            callback: function (rs) {
                if (rs) {
                    ShowLoading();
                    $.post("pages/" + PAGE + "/api/send.php", {
                        home_id: $("#home_id").val()
                    }, function (res) {
                        HideLoading();
                        ShowAlert({
                            html: res.message,
                            type: (res.status) ? "info" : "error",
                            callback: function () {
                                if (res.status) {
                                    LinkTo("./?page=user-form");
                                }
                            }
                        });
                    }, "JSON").fail(function (err) {
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
    $("#btn-revert").click(function () {
        var home_id = $("#home_id").val();
        var $title = $('\
			<div style="font-size: 16px;">\
                <i class="fas fa-history mb-2"></i> ส่งกลับแก้ไข\
			</div>\
		');
        var $contents = $('\
			<div>\
				<form>\
                    <div class="form-group">\
                        <label for="comment">ความคิดเห็น <span class="text-danger">*</span></label>\
                        <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>\
                        <small class="form-text text-muted">แสดงความคิดเห็น ข้อผิดพลาด เพื่อให้อาสาผู้บันทึกแบบสำรวจเห็นความคิดเห็นนี้</small>\
                    </div>\
                    <input type="hidden" name="home_id" value="'+ home_id + '">\
                    <input type="submit" class="d-none">\
                </form>\
			</div>\
		');
        var $footer = $('\
			<div class="text-right">\
				<button class="btn btn-warning btn-submit"><i class="fas fa-history"></i> ยืนยันการส่งกลับแก้ไข</button>\
				<button class="btn btn-light btn-cancel border"><i class="fas fa-times"></i> ยกเลิก</button>\
			</div>\
        ');
        $footer.find('.btn-submit').click(function (event) {
            $contents.find("input[type=submit]").click();
        });
        $footer.find('.btn-cancel').click(function (event) {
            popup.close();
        });

        BindUnload($contents.find('form'));
        $contents.find('form').submit(function (e) {
            e.preventDefault();
            var _this = this;
            ShowLoading();
            $.ajax({
                type: "POST",
                url: "pages/" + PAGE + "/api/revert.php",
                dataType: "JSON",
                data: GetFormData(_this),
                contentType: false,
                processData: false,
                success: function (res) {
                    HideLoading();
                    ShowAlert({
                        html: res.message,
                        type: (res.status) ? "success" : "error",
                        callback: function () {
                            if (res.status) {
                                UnbindUnload();
                                Reload();
                            }
                        }
                    });
                },
                error: function () {
                    HideLoading();
                    ShowAlert({
                        html: "ไม่สามารถติดต่อเครื่องแม่ข่ายได้",
                        type: "error"
                    });
                }
            });
        });
        var popup = new jBox('Modal', {
            title: $title,
            content: $contents,
            footer: $footer,
            width: "700px",
            height: "190px",
            draggable: 'title',
            overlay: true,
            addClass: 'popup-edit',
            closeOnEsc: false,
            closeOnClick: false,
            onClose: function () {
                UnbindUnload();
            }
        });
        popup.open();
    });
    $("#btn-edit").click(function () {
        var home_id = $("#home_id").val();
        var $title = $('\
			<div style="font-size: 16px;">\
                ตอบรับการแก้ไข\
			</div>\
		');
        var $contents = $('\
			<div>\
				คุณแน่ใจต้องการตอบรับการแก้ไขแบบสำรวจนี้ใช่หรือไม่ ?\
			</div>\
		');
        var $footer = $('\
			<div class="text-right">\
				<button class="btn btn-success btn-submit"><i class="fas fa-check"></i> ยืนยันการตอบรับการแก้ไข</button>\
				<button class="btn btn-light btn-cancel border"><i class="fas fa-times"></i> ยกเลิก</button>\
			</div>\
        ');
        $footer.find('.btn-submit').click(function (event) {
            ShowLoading();
            $.post("pages/" + PAGE + "/api/edit.php", {
                home_id: home_id
            }, function (res) {
                HideLoading();
                ShowAlert({
                    html: res.message,
                    type: (res.status) ? "info" : "error",
                    callback: function () {
                        if (res.status) {
                            LinkTo("./?page=user-form-data&home_id=" + home_id);
                        }
                    }
                });
            }, "JSON").fail(function (err) {
                HideLoading();
                ShowAlert({
                    html: "ไม่สามารถติดต่อเครื่องแม่ข่ายได้",
                    type: "error"
                });
            });
        });
        $footer.find('.btn-cancel').click(function (event) {
            popup.close();
        });
        var popup = new jBox('Modal', {
            title: $title,
            content: $contents,
            footer: $footer,
            width: "500px",
            height: "100px",
            draggable: 'title',
            overlay: true,
            addClass: 'popup-add',
            closeOnEsc: false,
            closeOnClick: false,
            onClose: function () {
                UnbindUnload();
            }
        });
        popup.open();
    });
});