<?php

	$ids = $_REQUEST['id'];

	$dbName = 'hinhanh';

	try {
		//Khởi tạo đối tượng PHP Client
		$objClient = new Mongo();// <===========================================
		//Chọn CSDL
		$objDB = $objClient->$dbName;
		$gridFS = $objDB->getGridFS();
		$object = $gridFS->findOne(array('_id'=> new MongoId($ids)));
		$chunks = $objDB->fs->chunks->find(array('files_id'=>$object->file['_id']));
		header('Content-type: '.$object->file['filetype']);
		foreach ($chunks as $chunk) {              
			echo $chunk['data']->bin;              
		}
	} catch (Exception $ex) {
		//Trường hợp lỗi, thông báo kết nối không thành công
		die('Kết nối không thành công!');
	}

?>