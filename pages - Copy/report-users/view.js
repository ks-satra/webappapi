$(function() {
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
    var type = $("[name=type]:checked").val();
    var date = DateEn($("#date").val(), 'DD/MM/YYYY');
    if (type == "date") {
        LinkTo("./?page=" + PAGE + "&type=date&date=" + date);
    } else {
        LinkTo("./?page=" + PAGE);
    }
}