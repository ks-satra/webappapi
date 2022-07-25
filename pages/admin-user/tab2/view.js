$(function () {
    function Load() {
        var province_id = $("#province_id").val();
        $("#user-area").load("pages/" + PAGE + "/api/tab2-load-user.php?province_id=" + province_id);
    }
    $("#province_id").change(function () {
        Load();
    });
    Load();
});