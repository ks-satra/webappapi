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
                        url: "pages/" + PAGE + "/api/edit-tab7.php",
                        dataType: "JSON",
                        data: GetFormData('#formdata'),
                        contentType: false,
                        processData: false,
                        success: function (res) {
                            HideLoading();
                            if (res.status) {
                                UnbindUnload();
                                LinkTo("./?page=" + PAGE + "&home_id=" + res.home_id + "&tab=8");
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
                <i class="fas fa-plus mb-2"></i> เพิ่มแปลงใหม่\
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

        // บังคับกรอกสำหรับช่อง checkbox
        jQuery(function ($) {
            var requiredCheckboxes = $contents.find(':checkbox[required]');
            requiredCheckboxes.on('change', function (e) {
                var checkboxGroup = requiredCheckboxes.filter('[name="' + $(this).attr('name') + '"]');
                var isChecked = checkboxGroup.is(':checked');
                checkboxGroup.prop('required', !isChecked);
            });
            requiredCheckboxes.trigger('change');
        });
        $contents.find('label[for]').click(function () {
            var f = $(this).attr("for");
            $contents.find("#" + f).trigger("click");
        });

        $contents.find('[name=rai1]').val(0);
        $contents.find('[name=ngan1]').val(0);
        $contents.find('[name=wa1]').val(0);
        $contents.find('[name=rai2]').val(0);
        $contents.find('[name=ngan2]').val(0);
        $contents.find('[name=wa2]').val(0);
        $contents.find('[name=rai3]').val(0);
        $contents.find('[name=ngan3]').val(0);
        $contents.find('[name=wa3]').val(0);

        ToggleInputNumber($contents.find('[name=rai1]'), 0);
        ToggleInputNumber($contents.find('[name=ngan1]'), 0);
        ToggleInputNumber($contents.find('[name=wa1]'), 0);
        ToggleInputNumber($contents.find('[name=rai2]'), 0);
        ToggleInputNumber($contents.find('[name=ngan2]'), 0);
        ToggleInputNumber($contents.find('[name=wa2]'), 0);
        ToggleInputNumber($contents.find('[name=rai3]'), 0);
        ToggleInputNumber($contents.find('[name=ngan3]'), 0);
        ToggleInputNumber($contents.find('[name=wa3]'), 0);
        BindUnload($contents.find('form'));
        $contents.find('form').submit(function (e) {
            e.preventDefault();
            var _this = this;
            var a = ToNum($contents.find('[name=rai1]').val()) * 1 + ToNum($contents.find('[name=ngan1]').val()) * 1 + ToNum($contents.find('[name=wa1]').val()) * 1;
            if (a == 0) {
                ShowAlert({
                    html: "ระบุ จำนวนพื้นที่ (ไร/งาน/ตารางวา)", type: "error", callback: function () { $contents.find('[name=rai1]').focus(); }
                }); return;
            }
            ShowLoading();
            $.ajax({
                type: "POST",
                url: "pages/" + PAGE + "/api/edit-tab7-add.php",
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
            height: "400px",
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

        // console.log(data);
        $.each(data.form_area_utilization, function (i, v) {
            $contents.find("[name^=item_area_utilization_id][value=" + v.item_area_utilization_id + "]").prop("checked", true);
        });
        $.each(data.form_area_water, function (i, v) {
            $contents.find("[name^=item_area_water_id][value=" + v.item_area_water_id + "]").prop("checked", true);
        });

        // บังคับกรอกสำหรับช่อง checkbox
        jQuery(function ($) {
            var requiredCheckboxes = $contents.find(':checkbox[required]');
            requiredCheckboxes.on('change', function (e) {
                var checkboxGroup = requiredCheckboxes.filter('[name="' + $(this).attr('name') + '"]');
                var isChecked = checkboxGroup.is(':checked');
                checkboxGroup.prop('required', !isChecked);
            });
            requiredCheckboxes.trigger('change');
        });
        $contents.find('label[for]').click(function () {
            var f = $(this).attr("for");
            $contents.find("#" + f).trigger("click");
        });
        $contents.find("[name='order_id']").val(data.order_id);
        $contents.find('[name=rai1]').val(data.rai1);
        $contents.find('[name=ngan1]').val(data.ngan1);
        $contents.find('[name=wa1]').val(data.wa1);
        $contents.find('[name=rai2]').val(data.rai2);
        $contents.find('[name=ngan2]').val(data.ngan2);
        $contents.find('[name=wa2]').val(data.wa2);
        $contents.find('[name=rai3]').val(data.rai3);
        $contents.find('[name=ngan3]').val(data.ngan3);
        $contents.find('[name=wa3]').val(data.wa3);
        $contents.find('[name=item_area_status_id]').val(data.item_area_status_id);
        ToggleInputNumber($contents.find('[name=rai1]'), 0);
        ToggleInputNumber($contents.find('[name=ngan1]'), 0);
        ToggleInputNumber($contents.find('[name=wa1]'), 0);
        ToggleInputNumber($contents.find('[name=rai2]'), 0);
        ToggleInputNumber($contents.find('[name=ngan2]'), 0);
        ToggleInputNumber($contents.find('[name=wa2]'), 0);
        ToggleInputNumber($contents.find('[name=rai3]'), 0);
        ToggleInputNumber($contents.find('[name=ngan3]'), 0);
        ToggleInputNumber($contents.find('[name=wa3]'), 0);
        BindUnload($contents.find('form'));
        $contents.find('form').submit(function (e) {
            e.preventDefault();
            var _this = this;
            var a = ToNum($contents.find('[name=rai1]').val()) * 1 + ToNum($contents.find('[name=ngan1]').val()) * 1 + ToNum($contents.find('[name=wa1]').val()) * 1;
            if (a == 0) {
                ShowAlert({
                    html: "ระบุ จำนวนพื้นที่ (ไร/งาน/ตารางวา)", type: "error", callback: function () { $contents.find('[name=rai1]').focus(); }
                }); return;
            }
            ShowLoading();
            $.ajax({
                type: "POST",
                url: "pages/" + PAGE + "/api/edit-tab7-edit.php",
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
            height: "400px",
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
                    $.post("pages/" + PAGE + "/api/edit-tab7-del.php", {
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