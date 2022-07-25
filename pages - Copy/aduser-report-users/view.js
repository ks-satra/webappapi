$(function() {
    $("#area_province_id").change(function() {
        reload();
    });
    $("#date").change(function() {
        reload();
    });
    $("#type-all").change(function() {
        reload();
    });
    $("#type-date").change(function() {
        reload();
    });
});

function reload() {
    var province_id = $("#area_province_id").val();
    var type = $("[name=type]:checked").val();
    var date = DateEn($("#date").val(), 'DD/MM/YYYY');
    if (type == "date") {
        LinkTo("./?page=" + PAGE + "&province_id=" + province_id + "&type=date&date=" + date);
    } else {
        LinkTo("./?page=" + PAGE + "&province_id=" + province_id);
    }
}