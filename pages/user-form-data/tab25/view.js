$(function () {
    ScrollTo("#first-scroll", -30);
    var ObjData = JSON.parse($("#ObjData").val());
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
                        url: "pages/" + PAGE + "/api/edit-tab25.php",
                        dataType: "JSON",
                        data: GetFormData('#formdata'),
                        contentType: false,
                        processData: false,
                        success: function (res) {
                            HideLoading();
                            if (res.status) {
                                UnbindUnload();
                                LinkTo("./?page=" + PAGE + "&home_id=" + res.home_id + "&tab=26");
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

    var $template = $("#template");

    $("#btn-add").click(function () {
        $title = $('\
            <div style="font-size: 16px;">\
                <i class="fas fa-plus mb-2"></i> เพิ่มรายได้ใหม่\
            </div>\
		');
        $contents = $('\
			<div>\
				\
			</div>\
		');
        $footer = $('\
			<div class="text-right">\
				<button class="btn btn-success btn-add"><i class="fas fa-plus"></i> ยืนยันการเพิ่ม</button>\
				<button class="btn btn-light btn-cancel border"><i class="fas fa-times"></i> ยกเลิก</button>\
			</div>\
        ');
        $contents.html($template.html());
        $footer.find('.btn-add').click(function (event) {
            $contents.find("input[type=submit]").click();
        });
        $footer.find('.btn-cancel').click(function (event) {
            popup.close();
        });
        ToggleInputNumber($contents.find('[name=amount]'), 0);
        $.each(ObjData, function (i, v) {
            $contents.find("#home_order_id>option[value='" + v.home_order_id + "']").attr("disabled", "disabled");
        });
        BindUnload($contents.find('form'));
        $contents.find('form').submit(function (e) {
            e.preventDefault();
            var _this = this;
            ShowLoading();
            $.ajax({
                type: "POST",
                url: "pages/" + PAGE + "/api/edit-tab25-add.php",
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
            height: "300px",
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

    $(".btn-edit").click(function () {
        var data = JSON.parse($(this).closest("[data-json]").attr("data-json"));
        $title = $('\
            <div style="font-size: 16px;">\
                <i class="fas fa-edit mb-2"></i> แก้ไขรายได้\
            </div>\
		');
        $contents = $('\
			<div>\
				\
			</div>\
		');
        $footer = $('\
			<div class="text-right">\
				<button class="btn btn-warning btn-edit"><i class="fas fa-edit"></i> ยืนยันการแก้ไข</button>\
				<button class="btn btn-light btn-cancel border"><i class="fas fa-times"></i> ยกเลิก</button>\
			</div>\
        ');
        $contents.html($template.html());
        $footer.find('.btn-edit').click(function (event) {
            $contents.find("input[type=submit]").click();
        });
        $footer.find('.btn-cancel').click(function (event) {
            popup.close();
        });
        $contents.find("[name='order_id']").val(data.order_id);
        $contents.find("[name='home_order_id']").val(data.home_order_id);
        $contents.find("[name='occupation']").val(data.occupation);
        $contents.find("[name='amount']").val(data.amount);
        $contents.find("[name='place_id'][value='" + data.place_id + "']").prop("checked", "checked");
        ToggleInputNumber($contents.find('#amount'), 0);
        $.each(ObjData, function (i, v) {
            if (v.home_order_id != data.home_order_id)
                $contents.find("#home_order_id>option[value='" + v.home_order_id + "']").attr("disabled", "disabled");
        });
        BindUnload($contents.find('form'));
        $contents.find('form').submit(function (e) {
            e.preventDefault();
            var _this = this;
            ShowLoading();
            $.ajax({
                type: "POST",
                url: "pages/" + PAGE + "/api/edit-tab25-edit.php",
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
            height: "450px",
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

    $(".btn-del").click(function () {
        var data = JSON.parse($(this).closest("[data-json]").attr("data-json"));
        ShowConfirm({
            html: "คุณแน่ใจต้องการลบข้อมูลนี้ใช่หรือไม่ ?",
            callback: function (rs) {
                if (rs) {
                    ShowLoading();
                    $.post("pages/" + PAGE + "/api/edit-tab25-del.php", {
                        home_id: data.home_id,
                        order_id: data.order_id
                    }, function (res) {
                        HideLoading();
                        Reload();
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