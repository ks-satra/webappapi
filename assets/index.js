$(function () {
    $.each($("[title]"), function (i, v) {
        ToggleTooltip($(this));
    });
    $.each($("[data-select]"), function (i, v) {
        ToggleSelect($(this));
    });
    $.each($("[data-datepicker]"), function (i, v) {
        ToggleDatepicker($(this));
    });
    $.each($("[data-input-number]"), function (i, v) {
        var digit = $(this).attr("data-input-number");
        if (!digit) digit = 2;
        ToggleInputNumber($(this), digit);
    });
    $.each($("[data-thai-baht]"), function (i, v) {
        ToggleThaiBaht($(this));
    });
    TogglePdfViewer($("[data-pdf-viewer]"));
    ToggleImageViewer($("[data-image-viewer]"));
    ToggleGalleryViewer($("[data-gallery-viewer]"));
    ToggleInputImage($("[data-input-image]"));
    ToggleInputPdf($("[data-input-pdf]"));
    ToggleInputDoc($("[data-input-doc]"));
    var href = window.location.href;
    window.history.replaceState({}, '', href);
});

function DateTh(date) {
    if (date == null) return date;
    var x = moment(date);
    var y = x.format("YYYY") * 1 + 543;
    return x.format("DD/MM/") + y;
}

function DateEn(date) {
    if (date == null) return date;
    var arr = date.split("/");
    return (arr[2] * 1 - 543) + "-" + arr[1] + "-" + arr[0];
}

function ToNum(num, digit = 2) {
    num = num.replace(" %", "");
    num = num.replace(/,/g, "");
    return (num * 1).toFixed(digit);
}

function ToggleInputImage(ctrl) {
    $(ctrl).change(function (event) {
        var allow_types = GLOBAL.ALLOW_IMAGE;
        var allow_size = GLOBAL.ALLOW_SIZE;
        var ctrl = $(this);
        var to = $(this).attr('data-input-image');
        FileChange(allow_types, allow_size, ctrl, to);
    });
}

function ToggleInputPdf(ctrl) {
    $(ctrl).change(function (event) {
        var allow_types = GLOBAL.ALLOW_PDF;
        var allow_size = GLOBAL.ALLOW_SIZE;
        var ctrl = $(this);
        FileChange(allow_types, allow_size, ctrl);
    });
}

function ToggleInputDoc(ctrl) {
    $(ctrl).change(function (event) {
        var allow_types = GLOBAL.ALLOW_DOC;
        var allow_size = GLOBAL.ALLOW_SIZE;
        var ctrl = $(this);
        FileChange(allow_types, allow_size, ctrl);
    });
}

function ToggleSelect(ctrl) {
    $(ctrl).select2({
        theme: 'bootstrap4',
    });
}

function ToggleTooltip(ctrl) {
    ctrl.tooltip();
}

function ToggleInputNumber(ctrl, digit) {
    if (digit == null) digit = 2;
    if ($(ctrl).val() != "") $(ctrl).val(($(ctrl).val() * 1).toFixed(digit));
    $(ctrl).inputmask({
        'alias': 'numeric',
        'groupSeparator': ',',
        'autoGroup': true,
        'digits': digit,
        //'digitsOptional': false, 
        'prefix': '',
        'placeholder': '0'
    });
    $(ctrl).click(function () { $(this).select(); });
}

function ToggleInputPercent(ctrl) {
    $(ctrl).inputmask('percentage');
}

function ToggleDatepicker(ctrl) {
    ctrl.datepicker({
        language: 'th-th',
        format: 'dd/mm/yyyy',
        autoclose: true
    });
    ctrl.inputmask("datetime", {
        inputFormat: "dd/mm/yyyy"
    });
}

function ToggleDatepickerRange(ctrl1, ctrl2) {
    var date1 = ctrl1.datepicker({
        language: 'th-th',
        format: 'dd/mm/yyyy',
        autoclose: true,
    }).on('show', function (e) {
        date1.datepicker("setEndDate", date2.val());
    });
    var date2 = ctrl2.datepicker({
        language: 'th-th',
        format: 'dd/mm/yyyy',
        autoclose: true,
    }).on('show', function (e) {
        date2.datepicker("setStartDate", date1.val());
    });
}

function TogglePdfViewer(ctrl) {
    if (ctrl.length == 0) return;
    $.each(ctrl, function (i, v) {
        $(this).attr("href", "../assets/pdfjs/web/viewer.html?v=1&file=../../../" + $(this).attr("href"));
        $(this).attr("data-fancybox-type", "iframe");
    });
    ctrl.fancybox({
        maxWidth: 1000,
        maxHeight: 700,
        fitToView: false,
        width: '100%',
        height: '100%',
        autoSize: false,
        closeClick: false,
        openEffect: 'none',
        closeEffect: 'none'
    });
}

function ToggleImageViewer(ctrl) {
    if (ctrl.length == 0) return;
    ctrl.fancybox();
}

function ToggleGalleryViewer(ctrl) {
    if (ctrl.length == 0) return;
    $.each(ctrl, function (i, v) {
        var rel = $(this).attr("data-gallery-viewer");
        $(this).attr("rel", rel);
    });
    ctrl.fancybox({
        helpers: {
            title: {
                type: 'inside'
            },
            buttons: {},
            thumbs: {
                width: 50,
                height: 50
            }
        }
    });
}

function ToggleThaiBaht(ctrl) {
    if ($(ctrl).length == 0) return;
    var num = $(ctrl).attr('data-thai-baht');
    var txt = BAHTTEXT(num);
    if ($(ctrl).is('input')) $(ctrl).val(txt);
    else $(ctrl).html(txt);
}

function LinkTo(url) {
    window.location.href = url;
}

function Reload() {
    window.location.reload();
}

function Back() {
    window.history.back();
}

function ShowAlert(option) {
    option.title = option.title || 'แจ้งข้อความ';
    option.html = option.html || 'ระบุข้อความ';
    option.type = option.type || 'info';
    option.confirmButtonColor = option.confirmButtonColor || '#3085d6';
    option.confirmButtonText = option.confirmButtonText || '<i class="fa fa-check"></i> ตกลง';
    option.allowOutsideClick = option.allowOutsideClick || false;
    option.allowEscapeKey = option.allowEscapeKey || false;
    option.callback = option.callback || function () { };
    swal(option).then((result) => {
        option.callback(true);
    });
}

function ShowConfirm(option) {
    option.title = option.title || 'คำยืนยัน ?';
    option.html = option.html || 'ระบุข้อความ';
    option.type = option.type || 'question';
    option.showCancelButton = option.showCancelButton || true;
    option.confirmButtonColor = option.confirmButtonColor || '#3085d6';
    option.cancelButtonColor = option.cancelButtonColor || '#d33';
    option.confirmButtonText = option.confirmButtonText || '<i class="fa fa-check"></i> ตกลง';
    option.cancelButtonText = option.cancelButtonText || '<i class="fa fa-times"></i> ยกเลิก';
    option.allowOutsideClick = option.allowOutsideClick || false;
    option.allowEscapeKey = option.allowEscapeKey || false;
    option.callback = option.callback || function () { };
    swal(option).then((result) => {
        option.callback(true);
    }, function (dismiss) {
        option.callback(false);
    });
}

function SubmitPostData(url, data) {
    var $form = $("<form></form>");
    $form.attr("method", "post");
    $form.attr({
        'method': 'post',
        'action': url
    });
    $.each(data, function (i, v) {
        var $input = $("<input type='hidden'>");
        $input.attr({
            'name': i,
            'value': v
        });
        $form.append($input);
    });
    $form.appendTo('body');
    $form.submit();
}

function GetFormData(form_id) {
    var formData = new FormData();
    var x = $(form_id).serializeArray();
    for (var i = 0; i < x.length; i++) {
        formData.append(x[i].name, x[i].value);
    }
    x = $(form_id).find("[type=file][name]");
    for (var i = 0; i < x.length; i++) {
        var name = $(x[i]).attr('name');
        var value = x[i].files[0];
        if (value) {
            formData.append(name, value);
        }
    }
    return formData;
}

function AcceptImplode(type) {
    var str = "";
    for (var i = 0; i < type.length; i++) {
        str += "." + type[i];
        if (i < type.length - 1) {
            str = str + ", ";
        }
    }
    return str;
}

function FileChange(allow_types, allow_size, ctrl, to, df, cb) {
    if (!df) df = "";
    var input = $(ctrl)[0];
    if (input.files && input.files[0]) {
        var name = input.files[0].name;
        var size = input.files[0].size;
        var type = input.files[0].type; // "image/jpeg" | image/png | image/gif | image/pjpeg
        var arr = name.split(".");
        var fType = (arr[arr.length - 1]).toLowerCase(); // "jpeg" | png | gif | pjpeg
        if (arr.length < 2 || ($.inArray(fType, allow_types) == -1)) {
            ShowAlert({
                html: "รูปแบบไม่รองรับ รองรับเฉพาะ " + AcceptImplode(allow_types) + " เท่านั้น",
                type: "error",
                callback: function () {
                    $(ctrl).val('');
                    if (to) $(to).attr('src', df);
                    if (cb) cb(false);
                }
            });
            return;
        }
        if (size > allow_size * 1024 * 1024) {
            ShowAlert({
                html: "ขนาดของไฟล์ที่คุณเลือกเท่ากับ " + (size / 1024 / 1024).toFixed(2) + " MB ซึ่งสูงกว่าที่กำหนด กรุณาเลือกไฟล์ที่ไม่เกิน " + allow_size + " MB",
                type: "error",
                callback: function () {
                    $(ctrl).val('');
                    if (to) $(to).attr('src', df);
                    if (cb) cb(false);
                }
            });
            return;
        }
        if (to) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $(to).attr('src', e.target.result);
                if (cb) cb(true);
            };
            reader.readAsDataURL(input.files[0]);
        }
    } else {
        ShowAlert({
            html: "รูปแบบไม่รองรับ รองรับเฉพาะ " + AcceptImplode(types) + " เท่านั้น",
            type: "error",
            callback: function () {
                $(ctrl).val('');
                $(to).attr('src', df);
                if (cb) cb(false);
            }
        });
    }
}

function ImageError(ctrl, df) {
    $(ctrl).attr("src", df);
}

var POPUP;

function ShowLoading() {
    POPUP = new jBox('Modal', {
        title: '<span class="font-weight-bold">กำลังประมวลผล...</span>',
        content: '\
            <div class="progress" style="height: 30px;">\
                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>\
            </div>\
            ',
        width: "500px",
        height: "60px",
        draggable: false,
        overlay: true,
        closeOnClick: false,
        closeButton: false,
        onClose: function () {
            setTimeout(function () {
                POPUP.destroy();
            }, 200);
        }
    });
    POPUP.open();
}

function HideLoading() {
    POPUP.close();
}

function NumberFormat(x, digit) {
    if (digit) x = x.toFixed(digit);
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

function BindUnload(form_id) {
    var _old = "";
    var _bind = false;
    var get_value = function (form_id) {
        var val = $(form_id).serializeArray();
        return JSON.stringify(val);
    }
    _old = get_value(form_id);
    $(form_id).change(function () {
        var _new = get_value(this);
        if (_old == _new) {
            if (_bind == true) {
                $(window).unbind("beforeunload");
                _bind = false;
            }
        } else {
            if (_bind == false) {
                $(window).unbind("beforeunload").bind("beforeunload", function () { return ""; });
                _bind = true;
            }
        }
    });
}

function UnbindUnload() {
    $(window).unbind("beforeunload");
}

function GetUrlParameter(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    var results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
}

function ScrollTo(id, move = 0) {
    // ScrollTo("#first-scroll", -30);  | id="first-scroll"
    $('html,body').animate({
        scrollTop: $(id).offset().top + move
    }, 'slow');
}