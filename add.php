<?php

if(isset($_REQUEST["id_quan"]) and isset($_REQUEST["action"])){
    //THAY ĐỔI
    $gridFS = $objDB->getGridFS();
    $objCollection = new MongoCollection($objDB, 'monan');
    $filename = $_FILES['image']['name'];
    $filetype = $_FILES['image']['type'];
    $filepath = $_FILES['image']['tmp_name'];
    $idImg = $gridFS->storeFile($filepath,array('filename' => $filename,'filetype' => $filetype));
    $id_quan=$_REQUEST['id_quan'];
    $result2 = $objCollection->insert( [ 
        
         'id_quan' => new MongoId("$id_quan"),
         'ten' => $_REQUEST['ten'], 
         'gia' => $_REQUEST['gia'],
         'hinhanh' => $idImg//THAY ĐỔI
  ] );
echo "Đã thêm thành công một document";
$adminURL = '/thucpham/NiceAdmin/monan.php?id_quan='.$_REQUEST['id_quan'];
  header('Location: '.$adminURL);
}

?>
<html>
</html>
 <div class="toan_cuc">
  <div class="content">
  <!--Địa điểm nỗi bật-->
    <div class="main_content">
    <div class="form" style="width: 500px;margin: auto;" id="them" >
      <form role="form" action="../monan/them.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id_quan" value="<?php if(isset($_REQUEST["id_quan"])) echo  $_REQUEST["id_quan"]; ?>">
        <div class="form-group">      
          <label class=""><b>Tên Món</b></label>
          <input class="form-control" name="ten" type="text">
        </div>
        <div class="form-group">      
          <label class="w3-text-black"><b>Giá</b></label>
          <input class="form-control" name="gia" type="text"></p>
        </div>
        <div class="form-group">
            <label for="exampleInputFile">Chọn ảnh món ăn</label>
            <input type="file" name="image">
        </div>
        <center> <button type="submit" class="btn btn-primary" name="action">Thêm</button></center>      
        
      </form>
    </div>
    <br>
    <table class="table table-striped table-advance table-hover">
    <tbody>
    <tr>
    <th>STT</th>
    <th>Tên món ăn</th>
    <th>Giá</th>
    <th>Hình ảnh</th>
    <th>Thêm, Xóa</th>
    </tr>
    <?php $objCollection = new MongoCollection($objDB, 'monan');
          //Thực hiện truy vấn theo field _id và gán kết quả vào biến $userData
          $id_quan=$_REQUEST['id_quan'];
          $ds_monan = $objCollection->find(["id_quan"=>new MongoId("$id_quan")]);
          $i=0;
          foreach($ds_monan as $monan){ $i=$i+1;?>
    <tr>
      <td><?php echo $i; ?></td>
      <td><?php echo $monan ["ten"] ?></td>
      <td><?php echo $monan["gia"] ?></td>
      <td> 
        <?php
          $idImg = $monan["hinhanh"];
          echo "<img src='../showimg.php?id=".$idImg."' width=100px height=100px>";
        ?></td>
      <td>
        <a href="#them"><i class="icon_plus_alt2"></i></a>
        <a href="../monan/Xoa.php?id_quan=<?php echo $_REQUEST['id_quan']; ?>&code=<?php echo $monan["_id"]; ?>"><i class="icon_close_alt2"></i></a>
      </td>
    </tr>
    <?php } ?>
  </table>

    </div>
 
  </div>
  