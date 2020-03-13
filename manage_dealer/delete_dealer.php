<?php include('../connect.php'); ?>
<?php
 $id = $_GET['id'];
if (isset($id)){
        $sql = "DELETE FROM dealer WHERE `dealer`.`dl_id` = '".$id."'";
        $result = $conn->query($sql);

if ($conn->affected_rows){

    echo '<script> alert("สำเร็จ! ลบข้อมูลผู้จำหน่ายสินค้าเรียบร้อย")</script>';
    header('Refresh:0; url=../dealer.php');

}else{
    echo '<script> alert("ล้มเหลว! ไม่สามารถลบข้อมูลผู้จำหน่ายสินค้าได้ กรุณาลองใหม่อีกครั้ง")</script>';
    header('Refresh:0; url=../dealer.php');
}


}else{
    header('Refresh:0; url=../dealer.php');
}

?>
