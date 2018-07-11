<?php
$dbName = 'hinhanh';
    try {
        //Khởi tạo liên kết
        
        $obj = new Mongo();
        //chọn CSDL
        $objDB = $obj->$dbName;
    } catch (Exception $ex) {
        //Trường hợp lỗi, thông báo kết nối không thành công
        die('Kết nối không thành công!');
    }

if(isset($_REQUEST["action"])){
    $gridFS = $objDB -> getGridFS();
    $filename = $_FILE['image']['name'];
    $filetype = $_FILE['image']['type'];
    $filepath = $_FILE['image']['tmp_name'];
    $idImg = $gridFS->storeFile($filepath,array('filename'=>$filename, 'filetype'=>$filetype));
}
?>
<!DOCTYPE html>
<html>
<title>GridFS</title>
<body>

<div>
    <from role="form" action="../file.html" method="post" enctype="multipart/form-data">
        <input type="file" name="image">
        <button type="submit" class="btn btn-primary" name="action">Thêm</button>
    </from>
    
</div>

</body>
</html>