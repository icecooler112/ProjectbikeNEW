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
           <div class="col-md-12 text-center"><h2>รายงานการใช้อะไหล่</h2></div>
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
                 <td width="30%">ประจำเดือน :</td>
                 <td width="70%"><?php echo $_GET["month"]; ?>/<?php echo $_GET["year"]; ?></td>
               </tr>
             </table>
           </div>
         </div>
             <br>
             <br>
             <div class="card-body">
                 <div class="table-responsive">
                     <table class="table table-bordered text-center DataTable">
                         <thead class="thead-light ">
                             <tr>
                                 <th>ลำดับที่</th>
                                 <th>รายการ</th>
                                 <th>จำนวนที่ใช้</th>
                                 <th>ราคาต่อหน่วย</th>
                                 <th>ราคารวม</th>
                             </tr>
                         </thead>
                         <tbody>
                  <?php
                  $condition = "";
                  if (!empty($_GET["month"]) || !empty($_GET["year"])) {
                      $condition = "WHERE history.datetime LIKE '{$_GET["year"]}-{$_GET["month"]}%'";
                  }
                  $sql = "SELECT product.pname,SUM(detail_repair.num) AS historynum,product.price,SUM(product.price) AS productprice ,history.datetime FROM product INNER JOIN detail_repair ON detail_repair.p_id = product.p_id INNER JOIN history ON detail_repair.h_id = history.h_id {$condition} GROUP BY detail_repair.p_id";
                  $result = $conn->query($sql);
                  $num = 0;
                  $total = 0;
                  while ($row = $result->fetch_assoc()) {
                      $num++;
                      $total = $total + ($row['historynum'] * $row['price']);
                  ?>
                      <tr>
                          <td><?php echo $num; ?></td>
                          <td><?php echo $row['pname']; ?></td>
                          <td class="text-right"><?php echo $row['historynum']; ?></td>
                          <td class="text-right"><?php echo $row['price']; ?></td>


                          <td class="text-right"><?php echo number_format($row['price'] * $row['historynum']); ?> บาท</td>

                          </td>
                      </tr>
                  <?php } ?>
                  <tr>
                    <td class="text-right" colspan="4">



                      <div>รวมเป็นเงินทั้งสิ้น</div>
                    </td>
                    <td class="text-right">
                      <div><?php echo number_format($total, 2);?> บาท</div>
                    </td>
                  </tr>
        </tbody>
      </table>
</form>
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
