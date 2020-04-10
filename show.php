<?php
    /**
     * เปิดใช้งาน Session
     */
    session_start();
    if (!$_SESSION['id']) {
        header("Location:login.php");
    } else {

      $path = '';
if (!empty($_GET)) {
    foreach ($_GET as $key => $value) {
        $path .= !empty($path) ? "&" : "?";
        $path .= "{$key}={$value}";
    }
}


?>
<?php     include('connect.php'); // ดึงไฟล์เชื่อมต่อ Database เข้ามาใช้งาน ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>การจัดการข้อมูลสินค้า</title>
    <!-- ติดตั้งการใช้งาน CSS ต่างๆ -->

    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css"> -->
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">

</head>
<body>

  <div class="wrapper">
       <!-- Sidebar  -->
       <nav id="sidebar">
           <div class="sidebar-header">
               <h3>Motocycle</h3>
           </div>

           <ul class="list-unstyled components">
             <li>
                 <a href="index.php"><i class="fas fa-toolbox mr-1"></i>เพิ่มข้อมูลการซ่อม</a>
             </li>
             <li>
                 <a href="history.php"><i class="fas fa-bell"></i> ประวัติการซ่อม</a>
             </li>
             <li>
                 <a href="evidance.php"><i class="fas fa-sticky-note"></i> ข้อมูลใบรับรถ</a>
             </li>
             <li>
                 <a href="user.php"><i class="fas fa-users"></i> ข้อมูลลูกค้า</a>
             </li>
             <li>
                 <a href="staff.php"><i class="fas fa-user-cog"></i> ข้อมูลพนักงาน</a>
             </li>

             <li>
                 <a href="product.php"><i class="fas fa-box"></i> ข้อมูลสินค้า</a>
             </li>
             <li>
                 <a href="dealer.php"><i class="fas fa-truck"></i> ข้อมูลผู้จำหน่ายสินค้า</a>
             </li>
             <li  class="active">
                 <a href="show.php"><i class="fas fa-chart-line"></i> รายงานสถิติการใช้อะไหล่</a>
             </li>
         </ul>
       </nav>
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
           <center><p><h2>รายงานสถิติการใช้อะไหล่</h2></p></center>
                       <div class="table-responsive">
                           <div class="card">
                               <div class="card-header">
                                   <a href="print_show.php<?php echo $path; ?>" class="btn btn-primary float-left"><i class="fas fa-print"></i> พิมพ์</a>
                                   <div class="text-right">
                                       <form action="" method="GET">
                                           <span class="input-group-a" id="mount">เดือน</span>&nbsp;&nbsp;
                                           <select class="" name="month" id="list">
                                               <option value=""> ทุกเดือน </option>
                                               <option value="01" <?php if (!empty($_GET["month"]) && $_GET["month"] == "01") echo 'selected="1"'; ?>>มกราคม</option>
                                               <option value="02" <?php if (!empty($_GET["month"]) && $_GET["month"] == "02") echo 'selected="1"'; ?>>กุมภาพันธ์</option>
                                               <option value="03" <?php if (!empty($_GET["month"]) && $_GET["month"] == "03") echo 'selected="1"'; ?>>มีนาคม</option>
                                               <option value="04" <?php if (!empty($_GET["month"]) && $_GET["month"] == "04") echo 'selected="1"'; ?>>เมษายน</option>
                                               <option value="05" <?php if (!empty($_GET["month"]) && $_GET["month"] == "05") echo 'selected="1"'; ?>>พฤษภาคม</option>
                                               <option value="06" <?php if (!empty($_GET["month"]) && $_GET["month"] == "06") echo 'selected="1"'; ?>>มิถุนายน</option>
                                               <option value="07" <?php if (!empty($_GET["month"]) && $_GET["month"] == "07") echo 'selected="1"'; ?>>กรกฏาคม</option>
                                               <option value="08" <?php if (!empty($_GET["month"]) && $_GET["month"] == "08") echo 'selected="1"'; ?>>สิงหาคม</option>
                                               <option value="09" <?php if (!empty($_GET["month"]) && $_GET["month"] == "09") echo 'selected="1"'; ?>>กันยายน</option>
                                               <option value="10" <?php if (!empty($_GET["month"]) && $_GET["month"] == "10") echo 'selected="1"'; ?>>ตุลาคม</option>
                                               <option value="11" <?php if (!empty($_GET["month"]) && $_GET["month"] == "11") echo 'selected="1"'; ?>>พฤศจิกายน</option>
                                               <option value="12" <?php if (!empty($_GET["month"]) && $_GET["month"] == "12") echo 'selected="1"'; ?>>ธันวาคม</option>
                                           </select>
                                           &nbsp;&nbsp;
                                           <span class="input-group-a" id="year">ปี</span>&nbsp;&nbsp;
                                           <select class="" name="year" id="list">
                                               <option value=""> ทุกปี </option>
                                               <option value="2020" <?php if (!empty($_GET["year"]) && $_GET["year"] == 2020) echo 'selected="1"'; ?>>2563</option>
                                               <option value="2019" <?php if (!empty($_GET["year"]) && $_GET["year"] == 2019) echo 'selected="1"'; ?>>2562</option>
                                               <option value="2018" <?php if (!empty($_GET["year"]) && $_GET["year"] == 2018) echo 'selected="1"'; ?>>2561</option>
                                               <option value="2017" <?php if (!empty($_GET["year"]) && $_GET["year"] == 2017) echo 'selected="1"'; ?>>2560</option>
                                           </select>
                                           &nbsp;&nbsp;
                                           <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> ค้นหา</button>
                                       </form>
                                   </div>
                               </div>
                           </div>
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

  <!-- Script Delete -->

    <!-- ติดตั้งการใช้งาน Javascript ต่างๆ -->
    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <script src="node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script>
    $('.DataTable').DataTable({
            "oLanguage": {
                "sEmptyTable": "ไม่พบข้อมูลในตาราง",
                "sInfo": "แสดง _START_ ถึง _END_ จาก _TOTAL_ แถว",
                "sInfoEmpty": "แสดง 0 ถึง 0 จาก 0 แถว",
                "sInfoFiltered": "(กรองข้อมูล _MAX_ ทุกแถว)",
                "sInfoPostFix": "",
                "sInfoThousands": ",",
                "sLengthMenu": "แสดง _MENU_ แถว",
                "sLoadingRecords": "กำลังโหลดข้อมูล...",
                "sProcessing": "กำลังดำเนินการ...",
                "sSearch": "ค้นหา: ",
                "sZeroRecords": "ไม่พบข้อมูล",
                "oPaginate": {
                    "sFirst": "หน้าแรก",
                    "sPrevious": "ก่อนหน้า",
                    "sNext": "ถัดไป",
                    "sLast": "หน้าสุดท้าย"
                },
                "oAria": {
                    "sSortAscending": ": เปิดใช้งานการเรียงข้อมูลจากน้อยไปมาก",
                    "sSortDescending": ": เปิดใช้งานการเรียงข้อมูลจากมากไปน้อย"
                }
            }

        });
</script>

</body>
</html>
<?php } ?>
