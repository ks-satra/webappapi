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
                <i class="fas fa-plus mb-2"></i> เพิ่มผู้ใช้ใหม่\
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
        $contents.find("#imagef").change(function () {
            FileChange(GLOBAL.ALLOW_IMAGE, GLOBAL.ALLOW_SIZE, this, $contents.find("#image"), './files/user/default.png', function () { });
        });
        $footer.find('.btn-add').click(function (event) {
            $contents.find("input[type=submit]").click();
        });
        $footer.find('.btn-cancel').click(function (event) {
            popup.close();
        });
        $contents.find("#phone").inputmask({ "mask": "999-9999999" });
        BindUnload($contents.find('form'));
        $contents.find('form').submit(function (e) {
            e.preventDefault();
            if (!$contents.find("#phone").inputmask('isComplete')) {
                ShowAlert({
                    html: "กรุณาระบุโทรศัพท์",
                    type: "error",
                    callback: function () { $contents.find("#phone").focus(); }
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
                <i class="fas fa-edit mb-2"></i> แก้ไขผู้ใช้\
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
        $contents.find("#imagef").change(function () {
            FileChange(GLOBAL.ALLOW_IMAGE, GLOBAL.ALLOW_SIZE, this, $contents.find("#image"), './files/user/default.png', function () { });
        });
        $footer.find('.btn-edit').click(function (event) {
            $contents.find("input[type=submit]").click();
        });
        $footer.find('.btn-cancel').click(function (event) {
            popup.close();
        });
        $contents.find("#image").attr("src", './files/user/' + data.image);
        $contents.find("[name='user_id']").val(data.user_id);
        $contents.find("[name='item_prefix_id']").val(data.item_prefix_id);
        $contents.find("[name='user_name']").val(data.user_name);
        $contents.find("[name='user_lname']").val(data.user_lname);
        $contents.find("[name='email']").val(data.email);
        $contents.find("[name='phone']").val(data.phone);
        $contents.find("[name='status']").val(data.status);
        $contents.find("[name='password']").val(data.password);

        $contents.find("#phone").inputmask({ "mask": "999-9999999" });
        BindUnload($contents.find('form'));
        $contents.find('form').submit(function (e) {
            e.preventDefault();
            if (!$contents.find("#phone").inputmask('isComplete')) {
                ShowAlert({
                    html: "กรุณาระบุโทรศัพท์",
                    type: "error",
                    callback: function () { $contents.find("#phone").focus(); }
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
                        user_id: data.user_id
                    }, function (res) {
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