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
    <link rel="icon" type="image/png" href="upload_img/1.jpg">
    <link rel="stylesheet" href="assets/fonts/bootstrap/bootstrap-icons.css">
</head>

<body>

<div class="card m-5">
    <div class="card-header">
        Featured
    </div>
    <div class="card-body">
        <div class="card mx-auto my-5 text-left" style="width: 30rem;">

            <form method="post" class="m-3">
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
                <button type="button" class="btn btn-primary" onclick="NOTApproved()">Submit</button>
            </form>
        </div>
    </div>

</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<script>
    // Your existing JavaScript code
    function togglePasswordVisibility() {
        // ...
    }

    function NOTApproved() {
        // ...
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
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
    function NOTApproved() {
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
<?php
//include 'config/login.php'
//?>