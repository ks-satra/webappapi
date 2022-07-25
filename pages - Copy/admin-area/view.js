$(function () {
    var $template = $("#template");

    $("#frm-search").submit(function (e) {
        e.preventDefault();
        var search = $("#search").val();
        var page = PAGE;
        var p = GetUrlParameter("p");
        var url = "./?page=" + page;
        if (p != "") url += "&p=" + p;
        if (search != "") url += "&search=" + search;
        location.href = url;
    });

    $("#btn-add").click(function () {
        $title = $('\
			<div style="font-size: 16px;">\
                <i class="fas fa-plus mb-2"></i> เพิ่มพื้นที่ใหม่\
			</div>\
		');
        $contents = $('\
			<div>\
				\
			</div>\
		');
        $footer = $('\
			<div class="text-right">\
				<button class="btn btn-success btn-submit"><i class="fas fa-plus"></i> ยืนยันการเพิ่ม</button>\
				<button class="btn btn-light btn-cancel border"><i class="fas fa-times"></i> ยกเลิก</button>\
			</div>\
        ');
        $contents.html($template.html());
        $footer.find('.btn-submit').click(function (event) {
            $contents.find("input[type=submit]").click();
        });
        $footer.find('.btn-cancel').click(function (event) {
            popup.close();
        });
        $contents.find("#province_code").inputmask("AAA");
        BindUnload($contents.find('form'));
        $contents.find('form').submit(function (e) {
            e.preventDefault();
            if (!$contents.find("#province_code").inputmask('isComplete')) {
                ShowAlert({
                    html: "กรุณาระบุสัญลักษณ์ให้ถูกต้อง",
                    type: "error",
                    callback: function () { $contents.find("#province_code").focus(); }
                });
                return;
            }
            var _this = this;
            ShowLoading();
            $.ajax({
                type: "POST",
                url: "pages/" + PAGE + "/api/add.php",
                dataType: "JSON",
                data: GetFormData(_this),
                contentType: false,
                processData: false,
                success: function (res) {
                    HideLoading();
                    ShowAlert({
                        html: res.message,
                        type: (res.status) ? "info" : "error",
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
            // height: "200px",
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
                <i class="fas fa-pen mb-2"></i> แก้ไขพื้นที่\
			</div>\
		');
        $contents = $('\
			<div>\
				\
			</div>\
		');
        $footer = $('\
			<div class="text-right">\
				<button class="btn btn-warning btn-submit"><i class="fas fa-pen"></i> ยืนยันการแก้ไข</button>\
				<button class="btn btn-light btn-cancel border"><i class="fas fa-times"></i> ยกเลิก</button>\
			</div>\
        ');
        $contents.html($template.html());
        $contents.find("#province_code").inputmask("AAA");
        $contents.find("[name=province_id]")
            .val(data.province_id)
            .removeAttr("name")
            .attr("disabled", "disabled");
        $contents.find("[name=province_code]").val(data.province_code);
        $contents.find("form").append('<input type="hidden" name="province_id" value="' + data.province_id + '">');
        $footer.find('.btn-submit').click(function (event) {
            $contents.find("input[type=submit]").click();
        });
        $footer.find('.btn-cancel').click(function (event) {
            popup.close();
        });
        BindUnload($contents.find('form'));
        $contents.find('form').submit(function (e) {
            e.preventDefault();
            if (!$contents.find("#province_code").inputmask('isComplete')) {
                ShowAlert({
                    html: "กรุณาระบุสัญลักษณ์ให้ถูกต้อง",
                    type: "error",
                    callback: function () { $contents.find("#province_code").focus(); }
                });
                return;
            }
            var _this = this;
            ShowLoading();
            $.ajax({
                type: "POST",
                url: "pages/" + PAGE + "/api/edit.php",
                dataType: "JSON",
                data: GetFormData(_this),
                contentType: false,
                processData: false,
                success: function (res) {
                    HideLoading();
                    ShowAlert({
                        html: res.message,
                        type: (res.status) ? "info" : "error",
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
            // height: "200px",
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
                    $.post("pages/" + PAGE + "/api/del.php", {
                        province_id: data.province_id
                    }, function (res) {
                        HideLoading();
                        if (res.status == false) {
                            ShowAlert({
                                html: res.message,
                                type: "error",
                                callback: function () {
                                    Reload();
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