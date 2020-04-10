<?php
    /**
     * เปิดใช้งาน Session
     */
    session_start();
    if (!$_SESSION['id']) {
        header("Location:../login.php");
    } else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>การจัดการข้อมูลลูกค้า</title>
    <!-- ติดตั้งการใช้งาน CSS ต่างๆ -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">

</head>
<body>
  <?php
  include('../connect.php'); // ดึงไฟล์เชื่อมต่อ Database เข้ามาใช้งาน

  /**
   * ตรวจสอบเงื่อนไขที่ว่า ตัวแปร $_POST['submit'] ได้ถูกกำหนดขึ้นมาหรือไม่
   */
  if(isset($_POST['submit'])){
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $idcard = $_POST["idcard"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];

    $check = "SELECT * FROM user  WHERE  first_name = '$first_name' AND last_name = '$last_name'";
     $result = $conn->query($check) or die(mysql_error());

        if($result->num_rows > 0)
        {
         echo "<script>";
            echo "alert('มีชื่อลูกค้านี้อยู่ในระบบแล้ว กรุณาลองใหม่อีกครั้ง!!!');";

         echo "</script>";

       }else {

         $check2 = "SELECT * FROM user  WHERE  idcard = '$idcard'";
          $result = $conn->query($check2) or die(mysql_error());
          if($result->num_rows > 0)
          {
            echo "<script>";
               echo "alert('มีรหัสบัตรประจำตัวประชาชนนี้อยู่ในระบบแล้ว กรุณาลองใหม่อีกครั้ง!!!');";
            echo "</script>";
          }else{
            $check3 = "SELECT * FROM user  WHERE  phone = '$phone'";
             $result = $conn->query($check3) or die(mysql_error());
             if($result->num_rows > 0)
             {
               echo "<script>";
                  echo "alert('มีเบอร์โทรศัพท์นี้อยู่ในระบบแล้ว กรุณาลองใหม่อีกครั้ง!!!');";

               echo "</script>";
             }else{
               $check4 = "SELECT * FROM user  WHERE  email = '$email'";
                $result = $conn->query($check4) or die(mysql_error());
                if($result->num_rows > 0)
                {
                  echo "<script>";
                     echo "alert('มี Email นี้อยู่ในระบบแล้ว กรุณาลองใหม่อีกครั้ง!!!');";

                  echo "</script>";
                }else{

                $sql = "INSERT INTO `user` (`user_id`, `first_name`, `last_name`, `idcard`, `user_address`, `phone`, `email`, `user_facebook`, `user_line`)
                        VALUES (NULL,'".$first_name."','".$last_name."','".$idcard."','".$_POST['user_address']."','".$phone."','".$email."','".$_POST['user_facebook']."','".$_POST['user_line']."');";
                        $result = mysqli_query($conn, $sql) or die ("Error in query: $sql " . mysqli_error());
                      }
                      mysqli_close($conn);


                if($result){
                    echo '<script> alert("สำเร็จ! เพิ่มข้อมูลลูกค้าเรียบร้อย!")</script>';
                    header('Refresh:0; url=../user.php');
                }else{
                  echo '<script> alert("ล้มเหลว! ไม่สามารถเพิ่มข้อมูลลูกค้าได้ กรุณาลองใหม่อีกครั้ง")</script>';

                    }
                  }
                }
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
             <li class="active">
                 <a href="../user.php"><i class="fas fa-users"></i> ข้อมูลลูกค้า</a>
             </li>
             <li>
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
                               <h3>กรอกข้อมูลลูกค้า</h3>
                           </div>
                           <div class="card-body">
                             <input type="text" class="form-control" id="user_id" name="user_id" hidden>
                               <div class="form-group row">
                                   <label for="first_name" class="col-sm-3 col-form-label">ชื่อ</label>
                                   <div class="col-sm-9">
                                       <input type="text" class="form-control" id="first_name" name="first_name" pattern="[A-Za-zก-๙]{1,}" required value="<?= !empty($_POST["first_name"]) ? $_POST["first_name"] : "" ?>">
                                       <div class="invalid-feedback">
                                           กรุณากรอกชื่อลูกค้า
                                       </div>
                                   </div>
                               </div>
                               <div class="form-group row">
                                   <label for="last_name" class="col-sm-3 col-form-label">นามสกุล</label>
                                   <div class="col-sm-9">
                                       <input type="text" class="form-control" id="last_name" name="last_name" pattern="[A-Za-zก-๙]{1,}" required value="<?= !empty($_POST["last_name"]) ? $_POST["last_name"] : "" ?>">
                                       <div class="invalid-feedback">
                                           กรุณากรอกนามสกุลลูกค้า
                                       </div>
                                   </div>
                               </div>
                               <div class="form-group row">
                                   <label for="idcard" class="col-sm-3 col-form-label">รหัสบัตรปรจำตัวประชาชน</label>
                                   <div class="col-sm-9">
                                       <input type="text" class="form-control" maxlength="13" pattern="[0-9]{13}" title="กรุณากรอกตัวเลข 0-9 จำนวน 13 ตัวเท่านั้น" id="idcard"  name="idcard" required value="<?= !empty($_POST["idcard"]) ? $_POST["idcard"] : "" ?>">
                                       <div class="invalid-feedback">
                                           กรุณากรอกรหัสบัรหัสบัตรประจำตัวประชาชน 13 หลัก
                                       </div>
                                       <message style="color:red; font-size:10pt;" hidden class="mgs-idcard">รูปแบบบัตรประชาชนไม่ถูกต้อง</message>
                                   </div>
                               </div>
                               <div class="form-group row">
                                   <label for="user_address" class="col-sm-3 col-form-label">ที่อยู่ลูกค้า</label>
                                   <div class="col-sm-9">
                                       <textarea type="text" class="form-control" id="user_address" name="user_address" required > <?= !empty($_POST["user_address"]) ? $_POST["user_address"] : "" ?> </textarea>
                                       <div class="invalid-feedback">
                                           กรุณากรอกที่อยู่
                                       </div>
                                   </div>
                               </div>
                               <div class="form-group row">
                                   <label for="phone" class="col-sm-3 col-form-label">เบอร์โทรศัพท์</label>
                                   <div class="col-sm-9">
                                       <input type="text" class="form-control" id="phone" maxlength="10" pattern="[0][0-9]{9}" title="กรุณากรอกตัวเลข 0-9 จำนวน 10 ตัวเท่านั้น" name="phone" required value="<?= !empty($_POST["phone"]) ? $_POST["phone"] : "" ?>">
                                       <div class="invalid-feedback">
                                           กรุณากรอกเบอร์เบอร์โทรศัพท์
                                       </div>
                                   </div>
                               </div>
                               <div class="form-group row">
                                   <label for="email" class="col-sm-3 col-form-label">Email</label>
                                   <div class="col-sm-9">
                                       <input type="email" class="form-control" id="email" name="email" pattern="[a-zA-Z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required value="<?= !empty($_POST["email"]) ? $_POST["email"] : "" ?>">
                                       <div class="invalid-feedback">
                                           กรุณากรอกอีเมลล์ ตามรูปแบบที่กำหนด (@hotmail.com / @gmail.com)
                                       </div>
                                   </div>
                               </div>
                               <div class="form-group row">
                                   <label for="user_facebook" class="col-sm-3 col-form-label">Facebook</label>
                                   <div class="col-sm-9">
                                       <input type="text" class="form-control" id="user_facebook" placeholder="ถ้ามี" name="user_facebook" value="<?= !empty($_POST["user_facebook"]) ? $_POST["user_facebook"] : "" ?>">
                                   </div>
                               </div>
                               <div class="form-group row">
                                   <label for="user_line" class="col-sm-3 col-form-label">Line</label>
                                   <div class="col-sm-9">
                                       <input type="text" class="form-control" id="user_line" placeholder="ถ้ามี" name="user_line" value="<?= !empty($_POST["user_line"]) ? $_POST["user_line"] : "" ?>">
                                   </div>
                               </div>

                               <center><input type="submit" name="submit" class="btn btn-success" value="ยืนยันการทำรายการ">
                               <a class="btn btn-danger" href="../user.php">ยกเลิก</a></center>
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
    <script>
    function checkID(id)
    {
        if(id.length != 13) {
          return false;
        }
        for(i=0, sum=0; i < 12; i++){
            sum += parseFloat(id.charAt(i))*(13-i);
        }
        if((11-sum%11)%10!=parseFloat(id.charAt(12))){
          return false;
        }
        else{
          return true;
        }
    }

    $("[name=idcard]").change(function(){
      if( !checkID($(this).val()) ){
        $(".mgs-idcard").attr('hidden', false);
        $("[name=submit]").attr("disabled", true);
      }
      else{
        $(".mgs-idcard").attr('hidden', true);
        $("[name=submit]").attr("disabled", false);
      }
      if( $(this).val() == "" ){
        $(".mgs-idcard").attr('hidden', true);
      }
    });
    </script>
</body>
</html>
  <?php } ?>
