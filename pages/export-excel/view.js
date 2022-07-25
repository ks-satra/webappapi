$(function () {
    $("#btn-excel2").click(function () {
        var p = $("#p").val();
        var show = $("#show").val();
        ShowLoading();
        $.get("pages/" + PAGE + "/api/excel2.php?p=" + p + "&show=" + show + "&t=" + new Date().getTime(), function (res) {
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