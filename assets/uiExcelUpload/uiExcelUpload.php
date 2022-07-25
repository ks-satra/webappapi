<?php
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
	require_once 'PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';
	$file = (!isset($_FILES["file"]))?null:$_FILES["file"];
	$inputFileName = $file["tmp_name"];
	$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
	$objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
	$highestRow = $objWorksheet->getHighestRow();
	$highestColumn = $objWorksheet->getHighestColumn();
	$headingsArray = $objWorksheet->rangeToArray('A1:'.$highestColumn.'1',null, true, true, true);
	$headingsArray = $headingsArray[1];
	$r = -1;
	$namedDataArray = array();
	for ($row = 2; $row <= $highestRow; ++$row) {
		$dataRow = $objWorksheet->rangeToArray('A'.$row.':'.$highestColumn.$row,null, true, true, true);
		if ((isset($dataRow[$row]['A'])) && ($dataRow[$row]['A'] > '')) {
			++$r;
			foreach($headingsArray as $columnKey => $columnHeading) {
				$namedDataArray[$r][$columnHeading] = $dataRow[$row][$columnKey];
			}
		}
	}
	$data = array();
	$data["source"] = $namedDataArray;
	$data["column"] = array();
	foreach($namedDataArray as $row_idx=>$row_val) {
		foreach($row_val as $col_idx=>$col_val) {
			$data["column"][] = $col_idx;
		}
		break;
	}
	echo json_encode($data);