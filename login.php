<?php
include_once 'config/conndb.php';
include_once 'config/show_data.php';
$major = getmajor($conn);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Best Bootstrap Admin Dashboards">
    <meta name="author" content="Bootstrap Gallery"/>
    <link rel="canonical" href="https://www.bootstrap.gallery/">
    <meta property="og:url" content="https://www.bootstrap.gallery">
    <meta property="og:title" content="Admin Templates - Dashboard Templates | Bootstrap Gallery">
    <meta property="og:description" content="Marketplace for Bootstrap Admin Dashboards">
    <meta property="og:type" content="Website">
    <meta property="og:site_name" content="Bootstrap Gallery">
    <title>LOGIN</title>
    <link rel="icon" type="image/png" href="upload_img/<?php echo $major['M_img']?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mitr&display=swap" rel="stylesheet">
    <style>
        #fonts{
            font-family: 'Mitr', sans-serif;
        }
        #fonts_b{
            font-family: 'Mitr', sans-serif;
            font-weight: bolder;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.3.4/sweetalert2.min.css">
    <link rel="stylesheet" href="assets/fonts/bootstrap/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/main.min.css?v=9999">
    <link rel="stylesheet" href="assets/vendor/overlay-scroll/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.3.4/sweetalert2.min.css">

</head>

<body id="fonts">

<!-- ส่วนเริ่มต้นของการโหลด -->
<div id="loading-wrapper">
    <div class="spinner">
        <div class="line1"></div>
        <div class="line2"></div>
        <div class="line3"></div>
        <div class="line4"></div>
        <div class="line5"></div>
    </div>
</div>
<!-- ส่วนจบการโหลด -->

<!-- ส่วนเริ่มต้นของหน้า -->
<div class="container-fluid">
    <div class="card" style="margin-top: auto;margin-right: 30%;margin-left: 30%">
        <div class="text-center py-3" style="font-size: 25px">
            เข้าสู่ระบบ
        </div>

        <div class="text-center my-2">
            <img src="upload_img/<?php echo $major['M_img'] ?>" width="150px">
        </div>
        <p style="font-size: 20px;font-weight: bolder; text-align: center">ระบบจัดการออกฝึกประสอบการวิชาชีพ</p>
        <p style="font-size: 18px;font-weight: bolder; text-align: center">แผนก <?php echo $major['M_Name'] ?></p>
        <p style="font-size: 18px;font-weight: bolder; text-align: center"><?php echo $major['M_college'] ?></p>
        <div class="card-body">
            <div class="card mx-auto my-2 text-left" >

                <form method="post" class="m-3" id="login">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" aria-describedby="emailHelp" name="username" placeholder="username">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" name="password" placeholder="password">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-outline-secondary password-toggle-button" onclick="togglePasswordVisibility()">
                                    <i id="eye-icon" class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="button" class="btn btn-primary" onclick="login()">เข้าสู่ระบบ</button>

                    </div>
                    <a href="register.php">สมัครสมาชิก</a>

                </form>
            </div>
        </div>

    </div>
</div>
        <!-- ส่วนจบของคอนเทนเนอร์ -->

        <!-- ส่วนจบของหน้า -->

        <!-- เริ่มต้นของไฟล์ JavaScript ที่จำเป็น -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/modernizr.js"></script>
        <script src="assets/js/moment.js"></script>


        <!-- ไฟล์ JavaScript หลัก -->
        <script src="assets/js/main.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script>
            // กำหนดฟังก์ชันชื่อ togglePasswordVisibility
            function togglePasswordVisibility() {
                // ดึงอิลิเมนต์ DOM ที่มี id "password" และเก็บไว้ในตัวแปร passwordField
                var passwordField = document.getElementById("password");

                // ดึงอิลิเมนต์ DOM ที่มี id "eye-icon" และเก็บไว้ในตัวแปร eyeIcon
                var eyeIcon = document.getElementById("eye-icon");

                // ตรวจสอบว่าแอตทริบิวต์ type ของฟิลด์รหัสผ่านในปัจจุบันตั้งค่าเป็น "password" หรือไม่
                if (passwordField.type === "password") {
                    // ถ้าใช่, เปลี่ยนแอตทริบิวต์ type เป็น "text" (เปิดเผยรหัสผ่าน)
                    passwordField.type = "text";

                    // ลบคลาส "bi-eye" ออกจากไอคอนตา และเพิ่มคลาส "bi-eye-slash"
                    eyeIcon.classList.remove("bi-eye");
                    eyeIcon.classList.add("bi-eye-slash");
                } else {
                    // ถ้าแอตทริบิวต์ไม่ได้เป็น "password" (เป็นไปได้ว่าเป็น "text"), เปลี่ยนกลับเป็น "password"
                    passwordField.type = "password";

                    // ลบคลาส "bi-eye-slash" ออกจากไอคอนตา และเพิ่มคลาส "bi-eye"
                    eyeIcon.classList.remove("bi-eye-slash");
                    eyeIcon.classList.add("bi-eye");
                }
            }
            function login() {
                var username = document.getElementById('username').value;
                var password = document.getElementById('password').value;

                if ($.trim(username) === '' && $.trim(password) === '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'กรุณากรอกข้อมูลให้ครบ',
                        showConfirmButton: true,
                    });
                    return;
                }

                $.ajax({
                    type: 'POST',
                    url: 'config/login.php',
                    data: {
                        username: username,
                        password: password,
                    },

                    success: function (response) {
                        if (response === 'student') {
                            window.location.href = 'student/index.php';
                        } else if (response === 'teacher') {
                            window.location.href = 'teacher/index.php';
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'เกิดข้อผิดพลาดในการเข้าสู่ระบบ',
                                text: 'ไม่พบ username password',
                            });
                        }
                    }
                });
            }
        </script>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.3.4/sweetalert2.min.css">

    <!-- SweetAlert2 script -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>login</title>
    <link rel="icon" type="image/png" href="upload_img/<?php echo $major['M_img'] ?>">
    <link rel="stylesheet" href="assets/fonts/bootstrap/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mitr&display=swap" rel="stylesheet">
    <style>
        #fonts{
            font-family: 'Mitr', sans-serif;
        }
        #fonts_b{
            font-family: 'Mitr', sans-serif;
            font-weight: bolder;
        }
        body {
            background-image: url('img/0c330780791341.5cebec82264ac.jpg');
            background-size: 100% 100%; /* ปรับขนาดให้เต็ม 100% ของ element */
            background-attachment: fixed;
             /* เบลอภาพ */
            /* สามารถเพิ่มคุณสมบัติ CSS อื่น ๆ ที่นี่ */
        }



    </style>
</head>

<body id="fonts">




</body>
</html>
