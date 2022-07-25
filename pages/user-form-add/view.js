$(function () {
    $("#home_code").inputmask("9999-999999-9");
    $("#tambol_id").autoComplete({
        minChars: 1,
        cache: false,
        source: function (term, suggest) {
            $.post("./api/address-auto.php", {
                province_id: $("#area_province_id").val(),
                search: term
            }, function (res) {
                suggest(res.data);
            }, 'json').fail(function () { });
        },
        renderItem: function (item, search) {
            return '<div class="autocomplete-suggestion pt-2 pb-2" data-item=\'' + JSON.stringify(item) + '\'> ต.' + item.tambol_name_thai + ' อ.' + item.amphur_name_thai + ' จ.' + item.province_name_thai + ' ' + item.zipcode + '</div>';
        },
        onFocus: function (e, term, item) {
            // console.log(item);
        },
        onSelect: function (e, term, item) {
            e.preventDefault();
            var data = item.data("item");
            $("#tambol_id").val(data.tambol_name_thai);
            $("#amphur_id").val(data.amphur_name_thai);
            $("#province_id").val(data.province_name_thai);
            $("#zipcode").val(data.zipcode);
            $("[name=tambol_id]").val(data.tambol_id);
            $("[name=amphur_id]").val(data.amphur_id);
            $("[name=province_id]").val(data.province_id);
            $("[name=zipcode]").val(data.zipcode);
            $("#owner_prefix_id").focus();
        }
    });
    var old = "";
    $("#tambol_id").keydown(function () {
        old = $(this).val();
    });
    $("#tambol_id").keyup(function (e) {
        if (old != $(this).val()) {
            $("#amphur_id").val("");
            // $("#province_id").val("");
            $("#zipcode").val("");
            $("[name=tambol_id]").val("");
            $("[name=amphur_id]").val("");
            // $("[name=province_id]").val("");
            $("[name=tambol_id]").val("");
        }
    });
    $("#area_province_id").change(function () {
        var province_id = $(this).val();
        var arr = $(this).find("option[value='" + province_id + "']").html().split("จังหวัด");
        var province_name = arr[1];
        $("#province_id").val(province_name);
        $("[name=province_id]").val(province_id);
        $("#tambol_id").val("");
        $("#amphur_id").val("");
        $("#zipcode").val("");
        $("[name=tambol_id]").val("");
        $("[name=amphur_id]").val("");
        $("[name=tambol_id]").val("");
        GenFormCode();
    });

    BindUnload("#formdata");
    $("#formdata").submit(function (event) {
        event.preventDefault();
        if ($("[name=tambol_id]").val() == "") {
            ShowAlert({
                html: "ไม่พบข้อมูลตำบล",
                type: "error",
                callback: function () { $("#tambol_id").focus(); }
            });
            return;
        }
        if (!$("#home_code").inputmask('isComplete')) {
            ShowAlert({
                html: "กรุณาระบุรหัสบ้านให้ถูกต้อง",
                type: "error",
                callback: function () { $("#home_code").focus(); }
            });
            return;
        }
        ShowConfirm({
            html: "คุณแน่ใจต้องการยืนยันการเพิ่มใช่หรือไม่ ?",
            callback: function (rs) {
                if (rs) {
                    ShowLoading();
                    $.ajax({
                        type: "POST",
                        url: "pages/" + PAGE + "/api/add.php",
                        dataType: "JSON",
                        data: GetFormData('#formdata'),
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
                                        LinkTo("./?page=user-form-data&home_id=" + res.home_id + "&tab=2");
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
                }
            }
        });
    });
    GenFormCode();

    function GenFormCode() {
        ShowLoading();
        $.post("pages/" + PAGE + "/api/get-form-code-show.php", {
            province_id: $("#area_province_id").val()
        }, function (res) {
            HideLoading();
            if (!res.status) {
                ShowAlert({
                    html: "Error เนื่องจาก " + res.message,
                    type: "error"
                });
            } else {
                $("#form_code").val(res.code);
            }
        }, "JSON").fail(function () {
            HideLoading();
            ShowAlert({
                html: "ไม่สามารถติดต่อเครื่องแม่ข่ายได้",
                type: "error"
            });
        });
    }
});