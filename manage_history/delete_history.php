<?php include('../connect.php'); ?>
<?php
 $id = $_GET['id'];
if (isset($id)){
        $sql = "DELETE FROM history WHERE `history`.`h_id` = '".$id."'";
        $result = $conn->query($sql);

        $sql1 = "DELETE FROM detail_repair WHERE `detail_repair`.`h_id` = '".$id."'";
        $results = $conn->query($sql1);
if ($result == TRUE AND $results == TRUE){
    echo '<script> alert("สำเร็จ! ลบข้อมูลรายละเอียดการซ่อมเรียบร้อย")</script>';
    header('Refresh:0; url=../history.php');
}else{
    echo '<script> alert("ล้มเหลว! ไม่สามารถลบข้อมูลรายละเอียดการซ่อมได้ กรุณาลองใหม่อีกครั้ง")</script>';
    header('Refresh:0; url=../history.php');
}


}else{
    header('Refresh:0; url=../history.php');
}

?>
