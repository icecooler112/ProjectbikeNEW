<?php
    /**
     * เปิดใช้งาน Session
     */
    session_start();
    if (!$_SESSION['id']) {
        header("Location:login.php");
    } else {
?>
<?
$sql = "SELECT  * FROM `product`";

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
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
  <?php
    include('connect.php'); // ดึงไฟล์เชื่อมต่อ Database เข้ามาใช้งาน

    if (isset($_GET["search"])) {
  $sqlSearch = "SELECT * FROM bike_user WHERE bike_id='{$_GET["search"]}'";
  $querySearch = $conn->query($sqlSearch);

  // ถ้ากรอกแล้วค้นพบจะทำการแสดงรายชื่อ
  if (!empty($querySearch->num_rows)) {
      $databike = $querySearch->fetch_assoc();
      $sqluser = "SELECT * FROM user WHERE user_id='{$databike["user_id"]}'";
      $queryuser = $conn->query($sqluser);
      $datause = $queryuser->fetch_assoc();
  } else {

      // ถ้าไม่พบจะทำการแจ้งเตือน
      echo '<script> alert("ไม่พบข้อมูลลูกค้าในฐานข้อมูล!")</script>';
  }
}
?>
<?php
      if(isset($_POST['submit'])){

        // print_r($_POST);die;
        if (empty($_POST["lists"])) {
            echo '<script> alert("กรุณาเลือกรายการอะไหล่!")</script>';
            header("Refresh:0;");
            exit;
        }
              $sql_history = "INSERT INTO `history` (`h_id`, `bu_id`,`user_id`, `datetime`, `h_detail`, `staff_id`)
                      VALUES (NULL,'".$_POST['bu_id']."','".$_POST['user_id']."','".$_POST['datetime']."','".$_POST['h_detail']."','".$_POST['staff_id']."');";
              $result_history = $conn->query($sql_history);
              $h_id = $conn->insert_id;


              foreach($_POST["lists"] as $key => $Id_stock){
              $sqlStock = "SELECT price,numproduct FROM product WHERE p_id={$Id_stock}";
              $queryStock = $conn->query($sqlStock);
              $stock = $queryStock->fetch_assoc();

              $sql_detail = "INSERT INTO `detail_repair` (`dt_id`, `h_id`,`bu_id`,`p_id`, `price`, `num`)
              VALUES (NULL,'".$h_id."','".$_POST['bu_id']."','".$Id_stock."','".$stock['price']."','".$_POST['Pnum'][$Id_stock]."');";
              $stc = $stock['numproduct'] - $_POST["Pnum"][$Id_stock];
              $sql9 = "UPDATE product SET numproduct = '$stc' WHERE p_id = $Id_stock";
               $conn->query($sql9);
              $result_detail = $conn->query($sql_detail);

              #SET Evidance
              $evidance = "UPDATE evidance SET evidance.Status='1' WHERE evidance.bu_id='".$_POST['bu_id']."' AND evidance.Status=0";
              $eviQuery = $conn->query($evidance);

              if($result_history == TRUE AND $result_detail == TRUE){
                  echo '<script> alert("สำเร็จ! เพิ่มข้อมูลการซ่อมเรียบร้อย!")</script>';
                  header('Refresh:0; url=history.php');
              }else{
                echo '<script> alert("ล้มเหลว! ไม่สามารถเพิ่มข้อมูลการซ่อมได้ กรุณาลองใหม่อีกครั้ง")</script>';
                header('Refresh:0; url=index.php');

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
             <li  class="active">
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
             <li>
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

           <div class="container">
                <div class="row">
                    <div class="col-md-9 mx-auto mt-5">
                        <div class="card">

                                <div class="card-header text-center text-white bg-primary">
                                    <h3>กรอกข้อมูลการซ่อม</h3>
                                </div>
                                  <div class="card-body">
                                    <form method="GET">
                                      <div class="form-group row">
                                                       <label for="search" class="col-sm-3 col-form-label">เลขทะเบียนรถ</label>
                                                       <div class="col-sm-7">
                                                           <input type="text" class="form-control" id="search" name="search"  pattern="[ก-ฮ0-9]{1,}" title="กรอกได้เฉพาะ ก-ฮ และ 0-9 เท่านั้น" required value="<?= !empty($_GET["search"]) ? $_GET["search"] : "" ?>">
                                                       </div>
                                                       <button class="btn btn-primary mb-2 float-right" type="submit"><i class="fas fa-search"></i> ค้นหา </button>
                                                   </div>
                                               </form>
                                    <form  action="" method="POST" enctype="multipart/form-data">
                                      <input type="hidden" name="user_id" value="<?= !empty($datause["user_id"]) ? $datause["user_id"] : "" ?>">
                                      <input type="hidden" name="bu_id" value="<?= !empty($databike["bu_id"]) ? $databike["bu_id"] : "" ?>">
                                    <div class="form-group row">
                                        <label for="first_name" class="col-sm-3 col-form-label">ชื่อ</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="first_name" name="first_name" disabled value="<?= !empty($datause["first_name"]) ? $datause["first_name"] : "--- ไม่พบข้อมูลลุกค้า ---" ?>" >
                                            <div class="invalid-feedback">
                                                กรุณากรอกชื่อลูกค้า
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="last_name" class="col-sm-3 col-form-label">นามสกุล</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" id="last_name" name="last_name" disabled value="<?= !empty($datause["last_name"]) ? $datause["last_name"] : "--- ไม่พบข้อมูลลุกค้า ---" ?>" >
                                            <div class="invalid-feedback">
                                                กรุณากรอกนามสกุลลูกค้า
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="datetime" class="col-sm-3 col-form-label">วันที่เข้ารับการซ่อม</label>
                                        <div class="col-sm-9">
                                            <input type="datetime" class="form-control" id="datetime"  value="<?php date_default_timezone_set('asia/bangkok'); echo date('Y-m-d H:i:s');?>" name="datetime" required>
                                            <div class="invalid-feedback">
                                                กรุณาเลือกวันที่เข้ารับการซ่อม
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="h_detail" class="col-sm-3 col-form-label">รายละเอียดการซ่อม</label>
                                        <div class="col-sm-9">
                                            <textarea type="text" class="form-control" id="h_detail" name="h_detail" required></textarea>
                                            <div class="invalid-feedback">
                                                กรุณากรอกรายละเอียดการซ่อม
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="staff_id" class="col-sm-3 col-form-label">เลือกชื่อพนักงาน</label>
                                        <div class="col-sm-9">
                                          <select class="form-control" id = "staff_id" name="staff_id" required>
                                                  <option value="" disabled selected>----- กรุณาเลือกพนักงาน -----</option>
                                                    <?php $sql = "SELECT * FROM staff";
                                                    $result = $conn->query($sql);
                                                    while ($row = $result->fetch_assoc()) {
                                                            ?>
                                                            <option value="<?php echo $row['staff_id']; ?>"><?php echo $row["staff_fname"]; ?> <?php echo $row["staff_lname"]; ?></option>
                                                              <?php } ?>
                                                              </select>
                                            <div class="invalid-feedback">
                                                กรุณาเลือกชื่อพนักงาน
                                            </div>
                                        </div>
                                    </div>

                                     <table class="table table-bordered text-center DataTable">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th width="5%">ลำดับ</th>
                                                        <th width="40%">รายการอะไหล่</th>
                                                        <th width="20%">ราคาอะไหล่</th>
                                                        <th width="20%">สินค้าในคลัง</th>
                                                        <th width="5%">จำนวน</th>
                                                        <th width="10w%">เลือกรายการ</th>
                                                    </tr>
                                                </thead>
                                                <!-- คำสั่งในการแสดงข้อมูลใน Table = product ทั้งหมด -->
                                                <tbody>
                                                    <?php
                                                    $sql = "SELECT * FROM product";
                                                    $result = $conn->query($sql);
                                                    $num = 0;
                                                    while ($row = $result->fetch_assoc()) {
                                                        $num++;
                                                    ?>
                                                        <!-- คำสั่งที่ดึงข้อมูลมาจากฐานข้อมูล -->
                                                        <tr>
                                                            <td><?php echo $num; ?></td>
                                                            <td><?php echo $row['pname']; ?></td>
                                                            <td><?php echo number_format($row['price']); ?> บาท</td>
                                                            <td class="tr-stocknum"><input type="text " class="form-control stocknum text-center" value="<?php echo $row['numproduct']; ?>" disabled></td>
                                                            <td><input type="number" class="form-control js-stocknum" id="product-num" name="Pnum[<?=$row["p_id"]?>]" value="1"></td>
                                                            <td>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input"  id="customControlValidation<?= $num ?>" name="lists[]" value="<?= $row['p_id'] ?>" >
                                                                    <label class="custom-control-label" for="customControlValidation<?= $num ?>"> เลือก</label>
                                                                </div>
                                                            <?php } ?>
                                                            </td>
                                                        </tr>
                                                </tbody>
                                            </table>
                                             <br>
                                            <center><button class="btn btn-success" type="submit" name="submit" id="submit"><i class="fas fa-check-circle"></i></input> ยืนยันการทำรายการ </button></center>
                                            </form>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </form>
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
