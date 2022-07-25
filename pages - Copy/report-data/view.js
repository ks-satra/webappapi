$(function () {
    $("#btn-excel").click(function () {
        ShowLoading();
        $.get("pages/report-data/api/excel.php?t=" + new Date().getTime(), function (res) {
            HideLoading();
            if (res.status) {
                var a = document.createElement("a");
                a.setAttribute('href', "pages/" + PAGE + "/api/" + res.filename);
                a.setAttribute('download', res.filename);
                a.click();
            } else {
                alert("การสร้างไฟล์เกิดข้อผิดพลาด");
            }
        }, "JSON").fail(function () {
            HideLoading();
            alert("ผิดพลาดไม่สามารถดาวน์โหลดได้");
        });
    });
    $("#btn-excel2").click(function () {
        ShowLoading();
        $.get("pages/report-data/api/excel2.php?t=" + new Date().getTime(), function (res) {
            HideLoading();
            if (res.status) {
                var a = document.createElement("a");
                a.setAttribute('href', "pages/" + PAGE + "/api/" + res.filename);
                a.setAttribute('download', res.filename);
                a.click();
            } else {
                alert("การสร้างไฟล์เกิดข้อผิดพลาด");
            }
        }, "JSON").fail(function () {
            HideLoading();
            alert("ผิดพลาดไม่สามารถดาวน์โหลดได้");
        });
    });
});