<?php
    /**
     * เปิดใช้งาน Session
     */
    session_start();
    if (!$_SESSION['id']) {
        header("Location:login.php");
    } else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-bikepatible" content="ie=edge">
    <title>ข้อมูลการซ่อม</title>
    <!-- ติดตั้งการใช้งาน CSS ต่างๆ -->
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>
    <!-- <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css"> -->
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">

</head>
<body>
  <?php
    include('../connect.php'); // ดึงไฟล์เชื่อมต่อ Database เข้ามาใช้งาน

    if (isset($_GET["search"])) {
  $sqlSearch = "SELECT * FROM bike_user WHERE bike_id='{$_GET["search"]}'";
  $querySearch = $conn->query($sqlSearch);

  // ถ้ากรอกแล้วค้นพบจะทำการแสดงรายชื่อ
  if (!empty($querySearch->num_rows)) {
      $databike = $querySearch->fetch_assoc();
      $sqluser = "SELECT * FROM user INNER JOIN bike_user ON user.user_id = bike_user.user_id WHERE user.user_id='{$databike["user_id"]}'";
      $queryuser = $conn->query($sqluser);
      $datause = $queryuser->fetch_assoc();
  } else {

      // ถ้าไม่พบจะทำการแจ้งเตือน
      echo '<script> alert("ไม่พบข้อมูลลูกค้าในฐานข้อมูล!")</script>';
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
             <li class="active">
                 <a href="../evidance.php"><i class="fas fa-user-cog"></i>ข้อมูลใบรับรถ</a>
             </li>
             <li>
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
             <li>
                 <a href="../show.php"><i class="fas fa-chart-line"></i> รายงานสถิติการใช้อะไหล่</a>
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

           <div class="container">
                <div class="row">
                    <div class="col-md-9 mx-auto mt-5">
                        <div class="card">

                                <div class="card-header text-center text-white bg-primary">
                                    <h3>กรอกข้อมูลใบรับรถ</h3>
                                </div>
                                  <div class="card-body">
                                    <form method="GET">
                                      <div class="form-group row">
                                                       <label for="search" class="col-sm-3 col-form-label"></label>
                                                       <div class="col-sm-7">
                                                           <input type="text" class="form-control" id="search" name="search"  pattern="[ก-ฮ0-9]{1,}" title="กรอกได้เฉพาะ ก-ฮ และ 0-9 เท่านั้น" required value="<?= !empty($_GET["search"]) ? $_GET["search"] : "" ?>" placeholder="กรอกเลขทะเบียนรถที่ต้องการค้นหา">
                                                       </div>
                                                       <button class="btn btn-primary mb-2 float-right" type="submit"><i class="fas fa-search"></i> ค้นหา </button>
                                                   </div>
                                               </form>
                                    <form  action="process.php" method="POST" enctype="multipart/form-data">
                                      <input type="hidden" name="bu_id" value="<?= !empty($datause["bu_id"]) ? $datause["bu_id"] : "" ?>">
                                      <input type="hidden" name="user_id" value="<?= !empty($datause["user_id"]) ? $datause["user_id"] : "" ?>">
                                      <input type="hidden" name="bike_id" value="<?= !empty($datause["bike_id"]) ? $datause["bike_id"] : "" ?>">
                                      <input type="hidden" name="first_name" value="<?= !empty($datause["first_name"]) ? $datause["first_name"] : "" ?>">
                                      <input type="hidden" name="last_name" value="<?= !empty($datause["last_name"]) ? $datause["last_name"] : "" ?>">
                                    <div class="form-group row">
                                        <label for="first_name" class="col-sm-3 col-form-label">ชื่อ</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="first_name" name="first_name" disabled value="<?= !empty($datause["first_name"]) ? $datause["first_name"] : "--- ไม่พบข้อมูลลูกค้า ---" ?>" >
                                            <div class="invalid-feedback">
                                                กรุณากรอกชื่อลูกค้า
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="last_name" class="col-sm-3 col-form-label">สกุล</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="last_name" name="last_name" disabled value="<?= !empty($datause["last_name"]) ? $datause["last_name"] : "--- ไม่พบข้อมูลลูกค้า ---" ?>" >
                                            <div class="invalid-feedback">
                                                กรุณากรอกชื่อลูกค้า
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="Date" class="col-sm-3 col-form-label">วันรับรถ</label>
                                        <div class="col-sm-9">
                                            <input type="date" class="form-control" id="Date"  value="" name="Date" required>
                                        </div>
                                    </div>

                                    <center><input type="submit" name="submit" class="btn btn-success" value="ยืนยันการทำรายการ">
                                     <a class="btn btn-danger" href="../evidance.php">ยกเลิก</a></center>
                                            </form>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>

    <!-- ติดตั้งการใช้งาน Javascript ต่างๆ -->
    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <script src="node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script>
    $('.DataTable').DataTable({
            "oLanguage": {
                "sEmptyTable": "ไม่มีข้อมูลในตาราง",
                "sInfo": "แสดง _START_ ถึง _END_ จาก _TOTAL_ แถว",
                "sInfoEmpty": "แสดง 0 ถึง 0 จาก 0 แถว",
                "sInfoFiltered": "(กรองข้อมูล _MAX_ ทุกแถว)",
                "sInfoPostFix": "",
                "sInfoThousands": ",",
                "sLengthMenu": "แสดง _MENU_ แถว",
                "sLoadingRecords": "กำลังโหลดข้อมูล...",
                "sProcessing": "กำลังดำเนินการ...",
                "sSearch": "ค้นหาอะไหล่ที่ต้องการ : ",
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
            },
            "lengthMenu": [[-1], ["All"]],
            "bPaginate": false,
            "bInfo" : false

        });
    </script>
    <script>
      $(".js-stocknum").change(function() {
          var tr = $(this).closest("tr");
          var stocknum = parseInt(tr.find(".stocknum").val());
          var input = parseInt($(this).val());

          if (input > stocknum) {
              alert("กรุณากรอกจำนวนสินค้าที่ไม่เกินจำนวนสินค้าที่มีในคลัง");
              $(this).val(1);
          }
      });
  </script>

</body>
</html>
<?php } ?>
