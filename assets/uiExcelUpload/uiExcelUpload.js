/*
** 	Project required 	: jQuery-3.2.1, bootstrap-4.3.1, jBox-0.6.4, PHPExcel
**	Auther				: Srikee Eatrong
**	Datetime			: 3/5/2019 15.46
**	Company				: Computer Center PSU Pattani Campus.
***********************************
	Example Usage
	
	var option = {
        title: 'Your Title',
        uploadURL: "dir/yourapi.php",
        column: [
            { value:"feild1", name:"Feild 1" },
            { value:"feild2", name:"Feild 2" },
        ],
        onClose: function(uploaded) {
            console.log(uploaded);
        }
    };
    uiExcelUpload(option);
*/
function uiExcelUpload(opt) {
	var option = {};
	option.title = opt.title || "Excel Upload";
	option.txtLoading = opt.txtLoading || "Loading...";
	option.txtUploading = opt.txtUploading || "Uploading...";
	option.column = opt.column || null;
	option.onClose = opt.onClose || function() {};
	option.uploaded = false;
	option.file = null;
	option.data = null;
	option.error = null;
	option.readerURL = opt.readerURL || "assets/uiExcelUpload/uiExcelUpload.php";
	option.uploadURL = opt.uploadURL || "";
	option.other = opt.other || {};

	var $title, $contents, $footer;

	var excelUploadGetData = function() {
		var data = Array();
		var header = Array();
		$.each($contents.find("table thead select"), function(i,v) {
			header.push( $(this).val() );
		});
		$.each($contents.find("table tbody tr"), function(tr_idx, tr_val) {
			var obj = {};
			$.each($(tr_val).find("td:not(.ordered)"), function(td_idx, td_val) {
				if(header[td_idx]!="-") {
					obj[ header[td_idx] ] = $(td_val).html();
				}
			});
			data.push(obj);
		});
		return data;
	}
	var excelUploadShowResult = function(data) {
		if( $contents.find("table tbody tr").length != data.length ) return ;
		$.each($contents.find("table thead tr"), function(i,v) {
			if(i==0) var $td = $("<th>&nbsp;</th>");
			if(i==1) var $td = $("<th style='min-width:200px;'>ผลลัพธ์</th>");
			$(this).append($td);
		});
		$.each($contents.find("table tbody tr"), function(tr_idx, tr_val) {
			var message = '';
			if(data[tr_idx].upload_status==true||data[tr_idx].upload_status=='true') {
				message = '<i class="fas fa-check-circle"></i> ';
				$(this).addClass("table-success");
			} else {
				message = '<i class="fas fa-times-circle"></i> ';
				$(this).addClass("table-danger");
			}
			message += data[tr_idx].upload_message;
			var $td = $('<td>'+message+'</td>');
			$(this).append($td);
		});
	}
	var excelUploadShowMessage = function(message) {
		$contents.html('<div class="text-center">'+message+'</div>');
	}

	var $file = $('<input type="file" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">');
	$file.click();
	$file.unbind('change').bind('change', function(event) {
		var input = $file[0];
		if (input.files && input.files[0]) {
			var name = input.files[0].name;
			var size = input.files[0].size;
			var type = input.files[0].type; // "image/jpeg" | image/png | image/gif | image/pjpeg
			var arr = name.split(".");
			var fType = (arr[arr.length-1]).toLowerCase();;
			if(arr.length >= 2 && (fType == "xls" || fType == "xlsx") ) { 
				option.file = $file.prop("files")[0];
				if( !option.file ) {
					$file.val('');
					option.file = null;
					option.error = "ไฟล์ผิดพลาด";
				}
			} else {
				$file.val('');
				option.file = null;
				option.error = "รูปแบบไม่รองรับ รองรับเฉพาะ .xls, .xlsx";
			}
		}

		/// Initial popup
		$title = $('\
			<div>\
				'+option.title+'\
			</div>\
		');
		$contents = $('\
			<div>\
				AA<br>AA<br>AA<br>AA<br>AA<br>AA<br>AA<br>AA<br>AA<br>AA<br>AA<br>AA<br>AA<br>AA<br>AA<br>AA<br>AA<br>AA<br>AA<br>AA<br>AA<br>AA<br>AA<br>AA<br>\
			</div>\
		');
		$footer = $('\
			<div class="text-right">\
				<button class="btn btn-primary btn-upload" disabled><i class="fas fa-upload"></i> เริ่มอัพโหลด</button>\
				<button class="btn btn-light btn-cancel border"><i class="fas fa-times"></i> ยกเลิก</button>\
			</div>\
		');
		$footer.find('.btn-upload').click(function(event) {
			var postdata = {
				data: excelUploadGetData(),
			};
			$.each(option.other, function(i, v) {
			    postdata[i] = v;
			});
			var uploading = new jBox('Modal', {
			  	content: '<div class="text-center">'+option.txtUploading+'</div>',
			  	width: 500,
			  	draggable: true,
			  	overlay: true,
			}); 
			uploading.open();

			$.post(option.uploadURL, postdata, function(res) {
            	uploading.close();
            	try {
            		var obj = JSON.parse(res);
            		if( obj.status==true ) {
            			var newdata = obj.data;
	            		excelUploadShowResult(newdata);
	            		option.uploaded = true;
	            		$contents.find('select').attr("disabled", "disabled");
	            		$footer.find('.btn-upload').attr("disabled", "disabled");
            		} else {
            			alert("Error เนื่องจาก "+obj.error);
            		}
            	} catch(e) {
            		alert("Error เนื่องจาก "+res);
            	}
            }).fail(function() {
            	uploading.close();
            	alert("Error เนื่องจากไม่สามารถติดต่อเครื่องแม่ข่ายได้");
            });
		});
		$footer.find('.btn-cancel').click(function(event) {
			option.popup.close();
		});
		option.popup = new jBox('Modal', {
		  	title: $title,
		  	content: $contents,
		  	footer: $footer,
		  	width: "100%",
		  	height: "100%",
		  	draggable: 'title',
		  	overlay: true,
		  	addClass: 'uiExcelUpload',
		  	onClose: function() {
		  		option.onClose(option.uploaded);
		  	}
		}); 
		option.popup.open();
		
		if( option.file==null || option.error!=null ) {
			excelUploadShowMessage(option.error);
			return;
		}
		excelUploadShowMessage(option.txtLoading);
		var form_data = new FormData();
		form_data.append('file', option.file);
		$.ajax({
			url: option.readerURL,
			dataType: 'text',
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,                         
			type: 'post',
		}).done(function(data) {
			try {
				option.data = JSON.parse(data);
				var source = option.data.source;
				var column = option.data.column;
				var $table = $('<div class="table-frame"><table class="table table-striped table-bordered table-hover table-condensed"><thead></thead><tbody></tbody></table></div>');
				var $tr_select = $('<tr><th style="min-width: 65px;">&nbsp;</th></tr>');
				var $tr_name = $('<tr><th>ลำดับ</th></tr>');
				$.each(option.column,function(i1, v1) {
					/////**** header select option ****/////
					var $th = $('<th></th>');
					var $select = $('<select></select>');
					$option = $('<option value="-">-</option>');
					$select.append($option);
					$.each(option.column,function(i2, v2) {
						$option = $('<option value="'+v2.value+'">'+v2.name+'</option>');
						$select.append($option);
					});
					$select.change(function() {
						$.each($table.find("select"), function(i2, v2) {
							if( i1 != i2 && $select.val() == $(v2).val() ) {
								$(v2).val("-").addClass("uiRed");
							}
						});
						if( $select.val()=="-" ) $select.addClass("uiRed");
						else $select.removeClass("uiRed");
					});
					$select.val( option.column[i1].value );
					$th.append($select);
					$tr_select.append($th);
					
					/////**** header name ****/////
					var $th = $('<th></th>');
					if(i1<=column.length-1) {
						$th.append(column[i1]);
					} else {
						$th.append("ไม่พบข้อมูล").addClass("uiRed");
						option.error = "ข้อมูลไม่สมบูรณ์";
					}
					$tr_name.append($th);
				});
				$table.find("thead").append($tr_select);
				$table.find("thead").append($tr_name);

				/////**** data value ****/////
				$.each(source,function(row_idx, row_val) {
					var $tr = $('<tr><td class="ordered">'+(row_idx+1)+'</td></tr>');
					var pointer = 0;
					$.each(row_val,function(col_idx, col_val) {
						if(pointer<=option.column.length-1) {
							var $td = $('<td></td>');
							if(pointer<=column.length-1) {
								$td.append(col_val);
							} else {
								$td.append("ไม่พบข้อมูล").addClass("uiRed");
							}
							$tr.append($td);
						}
						pointer++;
					});
					for(var i=column.length;i<option.column.length;i++) {
						var $td = $('<td></td>');
						$td.append("ไม่พบข้อมูล").addClass("uiRed");
						$tr.append($td);
						option.error = "ข้อมูลไม่สมบูรณ์";
					}
					$table.find("tbody").append($tr);
				});
				$contents.html($table);
				$footer.find('.btn-upload').removeAttr("disabled");
			} catch (e) {
				option.error = "Error เนื่องจาก "+ data;
				excelUploadShowMessage(option.error);
			}
		});
	});
}
