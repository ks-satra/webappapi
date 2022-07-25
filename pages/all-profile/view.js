$(function () {
    var old = $("#profile-image").attr("src");
    var $input = null;
    $("#btn-edit").click(function (event) {
        $input = $('<input type="file" name="image" accept="' + AcceptImplode(GLOBAL.ALLOW_IMAGE) + '">');
        $input.change(function (event) {
            FileChange(GLOBAL.ALLOW_IMAGE, GLOBAL.ALLOW_SIZE, $input, "#profile-image", old, function (status) {
                if (status == true) {
                    $("#edit").hide();
                    $("#confirm").show();
                } else {
                    $("#edit").show();
                    $("#confirm").hide();
                }
            });
        });
        $input.trigger('click');
    });
    $("#btn-confirm").click(function (event) {
        ShowConfirm({
            html: "คุณแน่ใจต้องการเปลี่ยนรูปโปรไฟล์ใช่หรือไม่ ?",
            callback: function (rs) {
                if (rs) {
                    var $form = $('<form action="" method="post" enctype="multipart/form-data" style="visibility:hidden;"></form>');
                    $form.append('<input type="hidden" name="btn-edit-profile" value="submit">');
                    $input.appendTo($form);
                    $form.appendTo('body');
                    $form.submit();
                }
            }
        });
    });
    $("#btn-cancel").click(function (event) {
        $("#edit").show();
        $("#confirm").hide();
        $("#profile-image").attr("src", old);
    });
    $("#profile-image").click(function () {
        var $ctrl = $(this).closest("a");
        $ctrl.attr("href", $(this).attr("src"));
        $ctrl.fancybox();
    });
});