$(function () {
    $("#frm-search").submit(function (e) {
        e.preventDefault();
        var search = $("#search").val();
        var page = PAGE;
        var p = GetUrlParameter("p");
        var status = GetUrlParameter("status");
        var url = "./?page=" + page;
        if (p != "") url += "&p=" + p;
        if (search != "") url += "&search=" + search;
        if (status != "") url += "&status=" + status;
        location.href = url;
    });
});