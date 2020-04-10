<?php include_once('../connect.php') ?>
<?php
#CHECK STATUS
$check = "SELECT * FROM evidance WHERE bu_id='".$_POST["bu_id"]."' AND Status=0";
$query = $conn->query($check);
if( $query->num_rows > 0 ){
    echo '<script> alert("ตรวจสอบพบเลขทะเบียนนี้มีใบรับซ่อมซ้ำในระบบ !")</script>';
    header('Refresh:0; url=../evidance.php');
    exit;
}


$sql = "INSERT INTO evidance (bu_id,user_id,Date)
VALUES (
        '" . $_POST['bu_id'] . "',
        '" . $_POST['user_id'] . "',
        '" . $_POST['Date'] . "');";
        $result = $conn->query($sql);
if ($result) {
    echo '<script> alert("บันทึกข้อมูลสำเร็จ!")</script>';
    header('Refresh:0; url=../evidance.php');
} else {
    echo '<script> alert("บันทึกข้อมูลไม่สำเร็จ!")</script>';
    header('Refresh:0; url=../evidance.php');
}

?>
