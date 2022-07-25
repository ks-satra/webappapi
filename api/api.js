function SaveExcel(home_id, callback) {
    $.get("api/excel-update.php", {
        home_id: home_id,
        t: moment().unix()
    }, function (res) {
        callback(res);
    }, "JSON").fail(function () {
        callback(false);
    });
}

function LoadPdf(home_id) {
    ShowLoading();
    $.get("pdf/all/index.php", {
        home_id: home_id,
        t: moment().unix()
    }, function (res) {
        HideLoading();
        if (res.status) {
            var a = document.createElement('a');
            a.setAttribute('href', "pdf/load.php?filename=" + res.filename);
            a.setAttribute('download', res.form_code + ".pdf");
            a.click();
        } else {
            ShowAlert({
                html: res.message,
                type: "error"
            });
        }
    }, "JSON").fail(function () {
        HideLoading();
        ShowAlert({
            html: "ไม่สามารถติดต่อเครื่องแม่ข่ายได้",
            type: "error"
        });
    });
}


function SavePdf(home_id, callback) {
    $.get("pdf/all/index.php", {
        home_id: home_id,
        t: moment().unix()
    }, function (res) {
        callback(res);
    }, "JSON").fail(function () {
        callback(false);
    });
}