$(function () {
    setTimeout(function () {
        onlineUser({
            onOnline: function (user) {
                console.log(user);
                $("#body").html("");
                if (user.length == 0) {
                    $("#body").append(`
                    <tr>
                        <td class="text-center" colspan="3">ไม่พบผู้ออนไลน์</td>
                    </tr>
                `);
                } else {
                    $.each(user, function (i, v) {
                        $("#body").append(`
                        <tr>
                            <td class="text-center">` + (i + 1) + `</td>
                            <td>` + v.item_prefix_name + v.user_name + ` ` + v.user_lname + `</td>
                            <td>` + v.phone + `</td>
                        </tr>
                    `);
                    });
                }
            },
            onOffline: function (user) {
                $("#body2").html("");
                if (user.length == 0) {
                    $("#body2").append(`
                    <tr>
                        <td class="text-center" colspan="4">ไม่พบผู้ออฟไลน์</td>
                    </tr>
                `);
                } else {
                    user.sort(GetSortOrder("updated", false));
                    $.each(user, function (i, v) {
                        if (v.user_id != "1") {
                            var t = v.updated;
                            var m = moment.unix(t / 1000);
                            var date = m.fromNow();
                            $("#body2").append(`
                            <tr>
                                <td class="text-center">` + (i + 1) + `</td>
                                <td>` + v.item_prefix_name + v.user_name + ` ` + v.user_lname + `</td>
                                <td>` + v.phone + `</td>
                                <td class="text-center">` + date + `</td>
                            </tr>
                        `);
                        }
                    });
                }
            }
        });

        function GetSortOrder(prop, asc = true) {
            return function (a, b) {
                if (a[prop] > b[prop]) {
                    return (asc) ? 1 : -1;
                } else if (a[prop] < b[prop]) {
                    return (asc) ? -1 : 1;
                }
                return 0;
            }
        }
    }, 100);
});