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
                        url: "pages/" + PAGE + "/api/edit-tab12.php",
                        dataType: "JSON",
                        data: GetFormData('#formdata'),
                        contentType: false,
                        processData: false,
                        success: function (res) {
                            HideLoading();
                            if (res.status) {
                                UnbindUnload();
                                LinkTo("./?page=" + PAGE + "&home_id=" + res.home_id + "&tab=13");
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
                <i class="fas fa-plus mb-2"></i> เพิ่มสมาชิกในครัวเรือนใหม่\
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
        $contents.find('#item_education_id').change(function (event) {
            if ($(this).val() == "999") $contents.find('#education_assign').removeAttr("disabled").focus();
            else $contents.find('#education_assign').attr("disabled", "disabled");
        });
        $contents.find('#item_work_id').change(function (event) {
            if ($(this).val() == "999") $contents.find('#work_assign').removeAttr("disabled").focus();
            else $contents.find('#work_assign').attr("disabled", "disabled");
        });
        $contents.find('#item_occupation_id').change(function (event) {
            if ($(this).val() == "999") $contents.find('#occupation_assign').removeAttr("disabled").focus();
            else $contents.find('#occupation_assign').attr("disabled", "disabled");
        });
        BindUnload($contents.find('form'));
        $contents.find('form').submit(function (e) {
            e.preventDefault();
            var _this = this;
            ShowLoading();
            $.ajax({
                type: "POST",
                url: "pages/" + PAGE + "/api/edit-tab12-add.php",
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
                <i class="fas fa-edit mb-2"></i> แก้ไขสมาชิกในครัวเรือน\
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
        $contents.find('#item_education_id').change(function (event) {
            if ($(this).val() == "999") $contents.find('#education_assign').removeAttr("disabled").focus();
            else $contents.find('#education_assign').attr("disabled", "disabled");
        });
        $contents.find('#item_work_id').change(function (event) {
            if ($(this).val() == "999") $contents.find('#work_assign').removeAttr("disabled").focus();
            else $contents.find('#work_assign').attr("disabled", "disabled");
        });
        $contents.find('#item_occupation_id').change(function (event) {
            if ($(this).val() == "999") $contents.find('#occupation_assign').removeAttr("disabled").focus();
            else $contents.find('#occupation_assign').attr("disabled", "disabled");
        });
        $contents.find("[name='order_id']").val(data.order_id);
        $contents.find("[name='item_prefix_id']").val(data.item_prefix_id);
        $contents.find("[name='name']").val(data.name);
        $contents.find("[name='lname']").val(data.lname);
        $contents.find("[name='item_sex_id']").val(data.item_sex_id);
        $contents.find("[name='year_bdate']").val(data.year_bdate);
        $contents.find("[name='item_relation_id']").val(data.item_relation_id);
        $contents.find("[name='item_education_id']").val(data.item_education_id);
        $contents.find("[name='education_assign']").val(data.education_assign);
        $contents.find("[name='item_work_id']").val(data.item_work_id);
        $contents.find("[name='work_assign']").val(data.work_assign);
        $contents.find("[name='item_occupation_id']").val(data.item_occupation_id);
        $contents.find("[name='occupation_assign']").val(data.occupation_assign);

        $contents.find("[name='item_place_id']").val(data.item_place_id);
        $contents.find("[name='back_home_id']").val(data.back_home_id);
        $contents.find("[name='live_area_id']").val(data.live_area_id);
        $contents.find("[name='item_disease_id']").val(data.item_disease_id);
        $contents.find("[name='internet_id']").val(data.internet_id);



        if (data.item_education_id == "999") $contents.find("[name='education_assign']").removeAttr("disabled");
        else $contents.find("[name='education_assign']").attr("disabled", "disabled");
        if (data.item_work_id == "999") $contents.find("[name='work_assign']").removeAttr("disabled");
        else $contents.find("[name='work_assign']").attr("disabled", "disabled");
        if (data.item_occupation_id == "999") $contents.find("[name='occupation_assign']").removeAttr("disabled");
        else $contents.find("[name='occupation_assign']").attr("disabled", "disabled");
        BindUnload($contents.find('form'));
        $contents.find('form').submit(function (e) {
            e.preventDefault();
            var _this = this;
            ShowLoading();
            $.ajax({
                type: "POST",
                url: "pages/" + PAGE + "/api/edit-tab12-edit.php",
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
                    $.post("pages/" + PAGE + "/api/edit-tab12-del.php", {
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