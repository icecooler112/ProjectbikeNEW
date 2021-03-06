<?php
    /**
     * เปิดใช้งาน Session
     */
    session_start();
    if (!$_SESSION['id']) {
        header("Location:../login.php");
    } else {
?>
<?php include('../connect.php'); ?>
<?php
$id = $_GET['id'];
$sql = "SELECT  `staff_id`, `staff_fname`,`staff_lname`, `staff_address`, `staff_email`,`staff_phone`,`staff_duty` FROM `staff`  WHERE staff_id = '" . $id . "' ";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
if (empty($row)) {
  echo '<script> alert("ไม่พบข้อมูล !") </script>';
  echo '<script> window.location = "../staff.php"</script>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>การจัดการข้อมูลพนักงาน</title>
    <!-- ติดตั้งการใช้งาน CSS ต่างๆ -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">

</head>
<body>
  <?php

        if(isset($_POST['submit'])){

          #SELECT OLD Data
          $sqlData = "SELECT * FROM staff WHERE staff_id={$_POST['staff_id']}";
          $queryData = $conn->query($sqlData);
          $data = $queryData->fetch_assoc();

          #SELECT CHECK Data
          $sqlCheck = "SELECT * FROM staff WHERE staff_fname='{$_POST["staff_fname"]}' AND staff_fname='{$_POST["staff_lname"]}'";
          $queryCheck = $conn->query($sqlCheck);
          $check = $queryCheck->num_rows;

            $has = true;
            if( $data["staff_fname"] == $_POST["staff_fname"]
            AND $data["staff_lname"] == $_POST["staff_lname"]){
              $has = false;
            }

              if( !empty($check) && $has ){
              echo '<script> alert("ตรวจสอบพบข้อมูลซ้ำในระบบ !")</script>';
              header('Refresh:0;');
              exit;
            }

                $sql = "UPDATE `staff`
                        SET `staff_id` = '".$_POST['staff_id']."',
                          `staff_fname` = '".$_POST['staff_fname']."',
                           `staff_lname` = '".$_POST['staff_lname']."',
                            `staff_address` = '".$_POST['staff_address']."',
                             `staff_email` = '".$_POST['staff_email']."',
                              `staff_phone` = '".$_POST['staff_phone']."',
                              `staff_duty` = '".$_POST['staff_duty']."'
                                WHERE staff.`staff_id` = '".$_POST['staff_id']."';";
                                $result = $conn->query($sql);
                    if($result){
                    echo '<script> alert("สำเร็จ! แก้ไขข้อมูลพนักงานเรียบร้อย!")</script>';
                    header('Refresh:0; url=../staff.php');
                }else{
                  echo '<script> alert("ล้มเหลว! ไม่สามารถแก้ไขข้อมูลพนักงานได้ กรุณาลองใหม่อีกครั้ง")</script>';
                  header('Refresh:1; url=create_staff.php');


            }
        }
    ?>
  <div class="wrapper">
       <!-- Sidebar  -->
       <nav id="sidebar">
           <div class="sidebar-header">
               <h3>Motocycle</h3>
           </div>

           <ul class="list-unstyled components">
             <li>
                 <a href="../index.php"><i class="fas fa-toolbox mr-1"></i>เพิ่มข้อมูลการซ่อม</a>
             </li>
             <li>
                 <a href="../history.php"><i class="fas fa-bell"></i> ประวัติการซ่อม</a>
             </li>
             <li>
                 <a href="../evidance.php"><i class="fas fa-sticky-note"></i> ข้อมูลใบรับรถ</a>
             </li>
             <li >
                 <a href="../user.php"><i class="fas fa-users"></i> ข้อมูลลูกค้า</a>
             </li>
             <li class="active">
                 <a href="../staff.php"><i class="fas fa-user-cog"></i> ข้อมูลพนักงาน</a>
             </li>

             <li>
                 <a href="../product.php"><i class="fas fa-box"></i> ข้อมูลสินค้า</a>
             </li>
             <li>
                 <a href="../dealer.php"><i class="fas fa-truck"></i> ข้อมูลผู้จำหน่ายสินค้า</a>
             </li>
         </ul>
       </nav>
       <!-- Page Content  -->
       <div id="content">

           <nav class="navbar navbar-expand-lg navbar-light bg-light">
               <div class="container-fluid">

                   <div class="collapse navbar-collapse" id="navbarSupportedContent">
                       <ul class="nav navbar-nav ml-auto">
                           <li class="nav-item active">
                             <?php if(isset($_SESSION['id'])) { ?>
                               <center><h5><?php echo $_SESSION["First_Name"];?> <?php echo $_SESSION["Last_Name"];?>  <a class="btn btn-danger ml-2"data-toggle="modal" data-target="#LogoutModal" href="#"><i class="fas fa-sign-out-alt"></i> ออกจากระบบ</a></h5></center>

                               <div id="LogoutModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
                                 <div class="modal-dialog" role="document">
                                   <div class="modal-content">
                                     <div class="modal-header">
                                       <h5 class="modal-title">ออกจากระบบ ?</h5>
                                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                         <span aria-hidden="true">&times;</span>
                                       </button>
                                     </div>
                                     <div class="modal-body text-center">
                                       <h1 style="font-size:5.5rem;"><i class="fas fa-sign-out-alt text-danger"></i></h1>
                                       <p>คุณต้องการออกจากระบบหรือไม่?</p>
                                     </div>
                                     <div class="modal-footer">
                                       <button type="button" class="btn btn-secondary" data-dismiss="modal">ยกเลิก</button>
                                       <a href="../logout.php" class="btn btn-danger">ออกจากระบบ</a>
                                     </div>
                                   </div>
                                 </div>
                               </div>

                             <?php }else header('location:../login.php'); { ?>

                  <?php } ?>
                           </li>
                       </ul>
                   </div>
               </div>
           </nav>

           <div class="container">
           <div class="row">
               <div class="col-md-8 mx-auto mt-5">
                   <div class="card">
                       <form class="was-validated" action="" method="POST" enctype="multipart/form-data">
                           <div class="card-header text-center text-white bg-primary">
                               <h3>แก้ไขข้อมูลพนักงาน</h3>
                           </div>
                           <div class="card-body">
                             <input type="text" class="form-control" id="staff_id" name="staff_id" value="<?php echo $row['staff_id']; ?>" hidden>
                               <div class="form-group row">
                                   <label for="staff_fname" class="col-sm-3 col-form-label">ชื่อ</label>
                                   <div class="col-sm-9">
                                       <input type="text" class="form-control" id="staff_fname" name="staff_fname" pattern="[A-Za-zก-๙]{1,}" value="<?php echo $row['staff_fname']; ?>" required>
                                       <div class="invalid-feedback">
                                           กรุณากรอกชื่อพนักงาน
                                       </div>
                                   </div>
                               </div>
                               <div class="form-group row">
                                   <label for="staff_lname" class="col-sm-3 col-form-label">นามสกุล</label>
                                   <div class="col-sm-9">
                                       <input type="text" class="form-control" id="staff_lname" name="staff_lname" pattern="[A-Za-zก-๙]{1,}" value="<?php echo $row['staff_lname']; ?>" required>
                                       <div class="invalid-feedback">
                                           กรุณากรอกนามสกุลพนักงาน
                                       </div>
                                   </div>
                               </div>

                               <div class="form-group row">
                                   <label for="staff_address" class="col-sm-3 col-form-label">ที่อยู่</label>
                                   <div class="col-sm-9">
                                       <textarea type="text" class="form-control" id="staff_address" name="staff_address" required><?php echo nl2br($row['staff_address']); ?></textarea>
                                       <div class="invalid-feedback">
                                           กรุณากรอกที่อยู่
                                       </div>
                                   </div>
                               </div>
                               <div class="form-group row">
                                   <label for="staff_email" class="col-sm-3 col-form-label">Email</label>
                                   <div class="col-sm-9">
                                       <input type="email" class="form-control" id="staff_email" name="staff_email" pattern="[a-zA-Z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" value="<?php echo $row['staff_email']; ?>" required>
                                       <div class="invalid-feedback">
                                           กรุณากรอกอีเมลล์ ตามรูปแบบที่กำหนด (@hotmail.com / @gmail.com)
                                       </div>
                                   </div>
                               </div>
                               <div class="form-group row">
                                   <label for="staff_phone" class="col-sm-3 col-form-label">เบอร์โทรศัพท์</label>
                                   <div class="col-sm-9">
                                       <input type="text" class="form-control" id="staff_phone"   name="staff_phone" maxlength="10" pattern="[0][0-9]{9}" title="กรุณากรอกตัวเลข 0-9 จำนวน 10 ตัวเท่านั้น" value="<?php echo $row['staff_phone']; ?>" required>
                                       <div class="invalid-feedback">
                                           กรุณากรอกเบอร์โทรศัพท์
                                       </div>
                                   </div>
                               </div>
                               <div class="form-group row">
                                   <label for="staff_duty" class="col-sm-3 col-form-label">ตำแหน่งงาน</label>
                                   <div class="col-sm-9">
                                     <select class="form-control" id="staff_duty" name="staff_duty" required>
                                       <option selected hidden value="<?php echo $row['staff_duty']; ?>"> <?php echo $row['staff_duty']; ?></option>
                                       <option>พนักงานซ่อม</option>
                                       <option>พนักงานขาย</option>
                                     </select>
                                     <div class="invalid-feedback">
                                         กรุณาเลือกตำแหน่งงาน
                                     </div>
                                   </div>
                                 </div>
                              <center><input type="submit" name="submit" class="btn btn-success" value="ยืนยันการทำรายการ">
                               <a class="btn btn-danger" href="../staff.php">ยกเลิก</a></center>
                           </div>
                       </form>
                   </div>
               </div>
           </div>
       </div>

    <!-- ติดตั้งการใช้งาน Javascript ต่างๆ -->
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
</body>
</html>
<?php } ?>
