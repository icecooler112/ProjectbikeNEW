<?php
    /**
     * เปิดใช้งาน Session
     */
    session_start();
    if (!$_SESSION['id']) {
        header("Location:login.php");
    } else {
?>
<?php     include('../connect.php'); // ดึงไฟล์เชื่อมต่อ Database เข้ามาใช้งาน ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print</title>
    <!-- ติดตั้งการใช้งาน CSS ต่างๆ -->

    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css"> -->
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">

</head>
<body>
       <!-- Page Content  -->
       <div id="content">

           <nav class="navbar navbar-expand-lg navbar-light bg-light">
               <div class="container-fluid">
                   <div class="collapse navbar-collapse" id="navbarSupportedContent">
                       <ul class="nav navbar-nav ml-auto ">
                           <li class="nav-item active">
                             <?php if(isset($_SESSION['id'])) { ?>
                               <center><h5><?php echo $_SESSION["First_Name"];?> <?php echo $_SESSION["Last_Name"];?> <a class="btn btn-danger ml-2"data-toggle="modal" data-target="#LogoutModal" href="#"><i class="fas fa-sign-out-alt"></i> ออกจากระบบ</a></h5></center>
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
                                       <a href="logout.php" class="btn btn-danger">ออกจากระบบ</a>
                                     </div>
                                   </div>
                                 </div>
                               </div>

                             <?php }else header('location:login.php'); { ?>
                             <?php } ?>
                           </li>
                       </ul>
                   </div>
               </div>
           </nav>
           <?php
           $id = $_GET['id'];
           $sql = "SELECT * FROM evidance INNER JOIN user ON evidance.user_id = user.user_id INNER JOIN bike_user ON bike_user.user_id = user.user_id = '$id'";
           $result = $conn->query($sql);
           $history = $result->fetch_assoc();
           if (empty($history)) {
             echo '<script> alert("ไม่พบข้อมูล !") </script>';
             echo '<script> window.location = "history.php"</script>';
           }

           ?>
           <div class="col-md-12 text-center"><h2>ใบรับฝากซ่อมรถจักรยานยนต์</h2></div>
           <br>
           <br>
           <br>
           <br>
           <div class="row">
           <div class="col-md-9">
           <span>อ๋องมอเตอร์ ปาย</span><br>
           <span>25 หมู่1 ตำบลเวียงใต้ อำเภอปาย จังหวัดแม่ฮ่องสอน</span><br>
           <span>รหัสไปรษณีย์ 58130</span><br>
           <span>เลขประจำตัวผู้เสียภาษี 0525560001000</span><br>
           <span>เบอร์ติดต่อ 082 193 1910</span><br>
         </div>
         <div class="col-md-3">
           <table width="300">
             <tr>
               <td width="30%">เลขที่ : </td>
               <td width="70%">SF<?php echo date("Y", strtotime($history['Date']))?>-<?php echo sprintf("%04d", $history["ed_id"]); ?></td>
             </tr>
             <tr>
               <td width="45%">วันที่ออกใบเสร็จ : </td>
               <td width="70%"><?php date_default_timezone_set('asia/bangkok');
                                 echo DateThaiNoTime(date('Y-m-d')); ?></td>
             </tr>
             <tr>
               <td width="30%">วันรับรถ : </td>
               <td width="70%"><?php echo DateThaiNoTime($history['Date']); ?></td>
             </tr>
           </table>
         </div>
       </div>
           <br>
           <br>
           <span style="font-weight:bold;">ลูกค้า</span><br>
           คุณ<?php echo $history['first_name']; ?> <?php echo $history['last_name']; ?>
           <br>
           <?php echo $history['user_address']; ?>

          <br>
          <br>
           <table class="table table-bordered">

  <thead class="thead-light text-center">
    <tr>
      <th width="5%">ลำดับ</th>
      <th width="20%">เลขทะเบียนรถ</th>
      <th width="20%">สีของรถ</th>
      <th width="20%">ปีของรถ</th>
      <th width="20%">ยี่ห้อของรถ</th>
    </tr>
  </thead>
  <tbody>
               <?php
            $sql = "SELECT * FROM evidance INNER JOIN user ON evidance.user_id = user.user_id INNER JOIN bike_user ON bike_user.user_id = user.user_id WHERE user.user_id ='" . $_GET['id'] . "'";
            $result = $conn->query($sql);
            $num = 0;

            while ($row = $result->fetch_assoc()) {
              $num++;

              ?>
              <tr>
                <td class="text-center"><?php echo $num; ?></td>
                <td class="text-center"><?php echo $row['bike_id']; ?></td>
                <td class="text-center"><?php echo $row['color']; ?> </td>
                <td class="text-center"><?php echo $row['year_bike']; ?> </td>
                <td class="text-center"><?php echo $row['brand']; ?> </td>
              </tr>
              <?php } ?>

    </tbody>
  </table>

  <br>
  <br>
  <br>
  <br>
  <br>
  <div class="row">

  <div class="col-md-6 text-center">
    <div>ในนาม อ๋องมอเตอร์ ปาย</div>
    <br>
    <br>
    <div>..............................................................</div>
    <div>ผู้รับผิดชอบ</div>
  </div>
</div>
  <?php } ?>
  <br>
  <br>
  <br>
  <br>
  <center>
    <h5>--- โปรดเก็บหลักฐานการรับฝากรถจักรยานยนต์ของท่าน ---</h5>
  </center>

  <!-- Script Print -->
  <script type="text/javascript">
      window.onload = function() { window.print(); }
 </script>


    <!-- ติดตั้งการใช้งาน Javascript ต่างๆ -->
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
</body>
</html>
