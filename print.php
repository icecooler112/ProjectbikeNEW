<?php
    /**
     * เปิดใช้งาน Session
     */
    session_start();
    if (!$_SESSION['id']) {
        header("Location:login.php");
    } else {
?>
<?php     include('connect.php'); // ดึงไฟล์เชื่อมต่อ Database เข้ามาใช้งาน ?>
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
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
       <!-- Page Content  -->
       <div id="content">

           <nav class="navbar navbar-expand-lg navbar-light bg-light">
               <div class="container-fluid">
                 <a class="btn btn-info" href="history.php"><i class="fas fa-home"></i> กลับสู่หน้าหลัก</a>
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

           <center><p><h2>ใบเสร็จรับเงิน</h2></p></center>
           <center><span>ร้านT.A.motor</span></center>
           <center><span>ที่อยู่506 หมู่7 ตำบล.พระบาท อำเภอ.เมือง จังหวัด.ลำปาง</span></center>
           <center><span>เบอร์ติดต่อ 081 564 5762</span></center>
           <br>
           <?php
           $id = $_GET['id'];
           $sql = "SELECT *
           FROM `history` WHERE h_id = '$id'";
           $result = $conn->query($sql);
           $row = $result->fetch_assoc();
           ?>
           <span>วันและเวลาที่ซ่อม : </span> <?php echo $row['datetime']; ?>
           <table class="table table-bordered text-center">

  <thead class="thead-light">
    <tr>
      <th width="10%">ลำดับ</th>
      <th width="50%">ชื่อสินค้า</th>
      <th width="10%">จำนวน</th>
      <th width="30%">ราคาต่อหน่วย</th>
    </tr>
  </thead>
  <tbody>
               <?php
            $sql = "SELECT * FROM detail_repair AS d1 INNER JOIN product AS d2 ON (d1.p_id = d2.p_id) INNER JOIN history AS d3 ON (d1.h_id = d3.h_id) WHERE d3.h_id ";
            $result = $conn->query($sql);
            $num = 0;
            $total = 0;
            while ($row = $result->fetch_assoc()) {
              $num++;
            $total = $total + ($row['price'] * $row['num']);
              ?>
              <tr>
                <td><?php echo $num; ?></td>
                <td><?php echo $row['pname']; ?></td>
                <td><?php echo $row['num']; ?> </td>
                <td><?php echo $row['price']; ?> บาท</td>
                </td>
              </tr>
    </tbody>
  </table>
  <p align="right">
  <?php echo "ราคารวมของสินค้าทั้งหมด : $total บาท"; ?>

  </form>
  <?php } ?>
  <!-- Script Print -->
  <script type="text/javascript">
      window.onload = function() { window.print(); }
 </script>


    <!-- ติดตั้งการใช้งาน Javascript ต่างๆ -->
    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <script src="node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
</body>
</html>
<?php } ?>
