$(function() {
    var href = window.location.href;
    window.history.replaceState({}, '', href);
	$(".form-signin").submit(function(event) {
		if( $("[name=json_ip]").val()=="" ) {
			event.preventDefault();
			var url = window.location.href;
			var arr = url.split('://');
			var protocol = arr[0];
			$.getJSON(protocol+'://ipinfo.io?token=70a5c58075438b', function(result) {
				try {
					var json = JSON.stringify(result);
					$("[name=json_ip]").val(json);
					signin();
				} catch(e) {
					$("[name=json_ip]").val("{}");
					signin();
				}
			}).fail(function() {
				$("[name=json_ip]").val("{}");
				signin();
			});
		}
	});
	function signin() {
		$(".form-signin").trigger("submit");
	}
});