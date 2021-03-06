<?php session_start();?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>เข้าสู่ระบบ</title>
    <!-- ติดตั้งการใช้งาน CSS ต่างๆ -->
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <?php
        require_once('connect.php'); // ดึงไฟล์เชื่อมต่อ Database เข้ามาใช้งาน
        /**
         * ตรวจสอบเงื่อนไขที่ว่า ตัวแปร $_POST['submit'] ได้ถูกกำหนดขึ้นมาหรือไม่
         */
        if (isset($_POST['submit'])) {
            /**
             * กำหนดตัวแปรเพื่อมารับค่า
             */
            $username =  $conn->real_escape_string($_POST['username']);
            $password = $conn->real_escape_string($_POST['password']);
            /**
             * สร้างตัวแปร $sql เพื่อเก็บคำสั่ง Sql
             * จากนั้นให้ใช้คำสั่ง $conn->query($sql) เพื่อที่จะประมาณผลการทำงานของคำสั่ง sql
             */
             $query = "SELECT * FROM admin_lg WHERE username = '$username'";
       $result = mysqli_query($conn, $query);
       $row = $result->fetch_assoc();
       if (!empty($row) && password_verify($_POST["password"], $row["password"])) {
                $_SESSION['id'] = $row['id'];
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['First_Name'] = $row['First_Name'];
                $_SESSION['Last_Name'] = $row['Last_Name'];
                header('location:index.php');
            }else{
              echo '<script> alert("แจ้งเตือน! Username หรือ Password ของคุณไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง")</script>';
              header('Refresh:0;');
            }
        }

    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-6 mx-auto mt-5">
                <div class="card">
                    <form action="" method="POST">
                        <div class="card-header text-center">
                        <h3><a><b>Admin</b>Login</a></h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="username" class="col-sm-3 col-form-label">ชื่อผู้ใช้</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="username" name="username" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="password" class="col-sm-3 col-form-label">รหัสผ่าน</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="password" name="password" required>

                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-center col-12">
                            <input type="submit" name="submit" class="btn btn-primary" value="เข้าสู่ระบบ">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- ติดตั้งการใช้งาน Javascript ต่างๆ -->
    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="node_modules/popper.js/dist/umd/popper.min.js"></script>
</body>
</html>
