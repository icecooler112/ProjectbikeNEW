<?php include('../connect.php'); ?>
<?php
 $id = $_GET['id'];
if (isset($id)){
        $sql = "DELETE FROM user WHERE `user`.`user_id` = '".$id."'";
        $result = $conn->query($sql);
        $sql1 = "DELETE FROM bike_user WHERE `bike_user`.`user_id` = '".$id."'";
        $results = $conn->query($sql1);
if ($result == TRUE AND $results == TRUE){
    echo '<script> alert("สำเร็จ! ลบข้อมูลลูกค้าเรียบร้อย")</script>';
    header('Refresh:0; url=../user.php');
}else{
    echo '<script> alert("ล้มเหลว! ไม่สามารถลบข้อมูลลูกค้าได้ กรุณาลองใหม่อีกครั้ง")</script>';
    header('Refresh:0; url=../user.php');
}


}else{
    header('Refresh:0; url=../user.php');
}

?>
