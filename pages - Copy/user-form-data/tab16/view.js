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
                        url: "pages/" + PAGE + "/api/edit-tab16.php",
                        dataType: "JSON",
                        data: GetFormData('#formdata'),
                        contentType: false,
                        processData: false,
                        success: function (res) {
                            HideLoading();
                            if (res.status) {
                                UnbindUnload();
                                LinkTo("./?page=" + PAGE + "&home_id=" + res.home_id + "&tab=17");
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
        ToggleInputNumber($contents.find('#rai'), 0);
        ToggleInputNumber($contents.find('#ngan'), 0);
        ToggleInputNumber($contents.find('#wa'), 0);
        ToggleInputNumber($contents.find('#kg1'), 0);
        ToggleInputNumber($contents.find('#kg2'), 0);
        ToggleInputNumber($contents.find('#price'), 0);
        ToggleInputNumber($contents.find('#cost'), 0);
        $contents.find('#kg1, #kg2, #price, #cost').keyup(function () {
            var kg1 = ToNum($contents.find('#kg1').val()) * 1;
            var kg2 = ToNum($contents.find('#kg2').val()) * 1;
            var price = ToNum($contents.find('#price').val()) * 1;
            var cost = ToNum($contents.find('#cost').val()) * 1;
            var kg3 = kg1 + kg2;
            var income = kg3 * price;
            var total = income - cost;
            $contents.find('#kg3').val(NumberFormat(kg3, 0));
            $contents.find('#income').val(NumberFormat(income, 0));
            $contents.find('#total').val(NumberFormat(total, 0));
        });
        BindUnload($contents.find('form'));
        $contents.find('form').submit(function (e) {
            e.preventDefault();
            var _this = this;
            ShowLoading();
            $.ajax({
                type: "POST",
                url: "pages/" + PAGE + "/api/edit-tab16-add.php",
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
        $contents.find("[name='item_horticulture_id']").val(data.item_horticulture_id);
        $contents.find("[name='type_cat']").val(data.type_cat);
        $contents.find("[name='rai']").val(data.rai);
        $contents.find("[name='ngan']").val(data.ngan);
        $contents.find("[name='wa']").val(data.wa);
        $contents.find("[name='kg1']").val(data.kg1);
        $contents.find("[name='kg2']").val(data.kg2);
        $contents.find("[name='kg3']").val(data.kg3);
        $contents.find("[name='price']").val(data.price);
        $contents.find("[name='income']").val(data.income);
        $contents.find("[name='cost']").val(data.cost);
        $contents.find("[name='total']").val(data.total);

        // console.log(data);
        $.each(data.income4_market, function (i, v) {
            $contents.find("[name^=item_market_id][value=" + v.item_market_id + "]").prop("checked", true);
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
        ToggleInputNumber($contents.find('#rai'), 0);
        ToggleInputNumber($contents.find('#ngan'), 0);
        ToggleInputNumber($contents.find('#wa'), 0);
        ToggleInputNumber($contents.find('#kg1'), 0);
        ToggleInputNumber($contents.find('#kg2'), 0);
        ToggleInputNumber($contents.find('#price'), 0);
        ToggleInputNumber($contents.find('#cost'), 0);
        $contents.find('#kg1, #kg2, #price, #cost').keyup(function () {
            var kg1 = ToNum($contents.find('#kg1').val()) * 1;
            var kg2 = ToNum($contents.find('#kg2').val()) * 1;
            var price = ToNum($contents.find('#price').val()) * 1;
            var cost = ToNum($contents.find('#cost').val()) * 1;
            var kg3 = kg1 + kg2;
            var income = kg3 * price;
            var total = income - cost;
            $contents.find('#kg3').val(NumberFormat(kg3, 0));
            $contents.find('#income').val(NumberFormat(income, 0));
            $contents.find('#total').val(NumberFormat(total, 0));
        });
        BindUnload($contents.find('form'));
        $contents.find('form').submit(function (e) {
            e.preventDefault();
            var _this = this;
            ShowLoading();
            $.ajax({
                type: "POST",
                url: "pages/" + PAGE + "/api/edit-tab16-edit.php",
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
                    $.post("pages/" + PAGE + "/api/edit-tab16-del.php", {
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