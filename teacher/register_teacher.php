<?php
include_once '../config/conndb.php';
include_once '../config/show_data.php';
$getroom = getroomall($conn);
$getmajor = getmajor($conn);
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
    <title>สมัครสมาชิกสำหรับบุคลากร</title>
    <link rel="icon" type="image/png" href="../upload_img/<?php echo $getmajor['M_img']; ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Mitr&display=swap" rel="stylesheet">
    <style>
        #fonts {
            font-family: 'Mitr', sans-serif;
        }

        #fonts_b {
            font-family: 'Mitr', sans-serif;
            font-weight: bolder;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.3.4/sweetalert2.min.css">
    <link rel="stylesheet" href="../assets/fonts/bootstrap/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/main.min.css?v=9999">
    <link rel="stylesheet" href="../assets/vendor/overlay-scroll/OverlayScrollbars.min.css">
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
<div class="page-wrapper">
    <div style="font-size: 20px; font-weight: bolder;">
        <nav class="navbar navbar-expand-lg navbar-light bg-white py-2">
            <div class="container px-0">
                <a class="navbar-brand" href="index.php"><span class="fw-bolder text-primary">ระบบจัดการออกฝึกประสบการณ์วิชาชีพ</span></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 small fw-bolder">
                        <li class="nav-item"><a class="nav-link " href="../index.php">หน้าแรก</a></li>
                        <li class="nav-item"><a class="nav-link" href="../about.php">เกี่ยวกับเรา</a></li>
                        <li class="nav-item"><a class="nav-link " href="../register.php">สมัครสมาชิก</a></li>
                        <li class="nav-item"><a class="nav-link" href="../login.php">เข้าสู่ระบบ</a></li>

                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <!-- เริ่มต้นของ เนื้อหา content -->
    <div class="content-wrapper py-3">
        <div class="content py-3">
            <div class="card m-5 mx-5 ms-5 my-5 ">
                <div class="text-center py-2">
                    <h1>สมัครสมาชิกสำหรับบุคลากร</h1>
                </div>
                <div class="card-body">
                    <form id="Formteacher" method="post" class="row g-4 m-auto" enctype="multipart/form-data">

                        <div class=" col-md-4 ">
                            <label for="T_ID" class="form-label">รหัสบุคลากร</label>
                            <input type="text" class="form-control" id="T_ID" name="T_ID" maxlength="10"
                                   placeholder="รหัสบุคลากร 10 ตัว" required>
                        </div>
                        <div class=" col-md-4">
                            <label for="T_fname" class="form-label">ชื่อ</label>
                            <input type="text" class="form-control" id="T_fname" name="T_fname" maxlength="50"
                                   placeholder="ชื่อ" required>
                        </div>
                        <div class=" col-md-4">
                            <label for="T_lname" class="form-label">นามสกุล</label>
                            <input type="text" class="form-control" id="T_lname" name="T_lname" maxlength="50"
                                   placeholder="นามสกุล" required>
                        </div>
                        <div class="col-md-2">
                            <label for="T_gender" class="form-label">เพศ</label>
                            <select id="T_gender" class="form-select" name="T_gender" required>
                                <option selected>Choose...</option>
                                <option>ชาย</option>
                                <option>หญิง</option>
                                <option>ไม่ระบุ</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="T_birthday" class="form-label">วันเดือนปีเกิด</label>
                            <input type="date" id="T_birthday" class="form-control" name="T_birthday" required
                                   min="1950-01-01" max="2015-01-01">
                            <p id="demo"></p>
                        </div>
                        <div class=" col-md-3">
                            <label for="T_position" class="form-label">ตำแหน่ง</label>
                            <input type="text" class="form-control" id="T_position" name="T_position" maxlength="50"
                                   placeholder="ชื่อตำแหน่ง" required>
                        </div>
                        <div class="col-md-2">
                            <label for="T_phone" class="form-label">เบอร์โทรศัพท์</label>
                            <input type="text" class="form-control" id="T_phone" name="T_phone" maxlength="10"
                                   placeholder="เบอร์มือถือที่สามารถติดต่อได้" required>
                        </div>
                        <div class="col-md-3">
                            <label for="T_email" class="form-label">E-mail</label>
                            <input type="email" class="form-control" id="T_email" name="T_email" maxlength="100"
                                   placeholder="E-mail">
                        </div>
                        <div class="col-md-12 input-group">
                            <span class="input-group-text">ที่อยู่ปัจจุบัน</span>
                            <textarea class="form-control" aria-label="With textarea" id="T_address"
                                      name="T_address" required></textarea>
                        </div>

                        <input type="hidden" class="form-control date-own" id="T_status" name="T_status"
                               value="0">

                        <div class="col-md-12">
                            <label for="formFile" class="form-label">อัพรูปภาพตัวเอง</label>
                            <input class="form-control" type="file" id="T_img" name="T_img"
                                   accept="image/jpeg, image/png, image/jpg" required>
                            <!--                    <input class="form-control" type="text" id="T_img" name="T_img">-->
                        </div>
                        <!--                        <div class="col-md-6">-->
                        <!--                            <label for="R_ID" class="form-label">ห้องประจำชั้น</label>-->
                        <!--                            <select name="R_ID" id="R_ID" class="form-select" required>-->
                        <!--                                <option value="">-- เลือกครู --</option>-->
                        <!--                                --><?php //foreach ($getroom as $room) : ?>
                        <!--                                    <option value="-->
                        <?php //echo $room['R_ID']; ?><!--">--><?php //echo $room['R_level']; ?><!--. -->
                        <?php //echo $room['R_room']; ?><!-- ห้อง -->
                        <?php //echo $room['R_level_number']; ?><!--</option>-->
                        <!--                                --><?php //endforeach; ?>
                        <!--                            </select>-->
                        <!--                        </div>-->

                        <div class="container-fluid py-3">
                            <center>
                                <img src="../img/teacher.gif" width="100px" height="100px">
                            </center>


                        </div>
                        <div class="col-md-12">
                            <label for="S_username" class="form-label">ชื่อผู้ใช้</label>
                            <input type="text" class="form-control" id="T_username" name="T_username"
                                   maxlength="15"
                                   placeholder="ชื่อผู้ใช้" required>
                        </div>
                        <!--                        <div class="col-md-12">-->
                        <!--                            <label for="S_password" class="form-label">รหัสผ่าน</label>-->
                        <!--                            <input type="password" class="form-control" id="T_password" name="T_password"-->
                        <!--                                   maxlength="15"-->
                        <!--                                   placeholder="รหัสผ่าน" required>-->
                        <!--                        </div>-->
                        <div class="col-md-12">
                            <label for="exampleInputPassword1" class="form-label">รหัสผ่าน</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="T_password"
                                       placeholder="รหัสผ่าน" required minlength="10" maxlength="15">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary password-toggle-button"
                                            onclick="togglePasswordVisibility()">
                                        <i id="eye-icon" class="bi bi-eye"></i>
                                    </button>
                                </div>
                                <div id="emailHelp" class="form-text col-md-12">ป้อนขันต่ำ 10 ตัวอักษร และไม่เกิน 15
                                    ตัวอักษร
                                </div>
                            </div>
                        </div>
                        <div style="text-align: center" class="g-4 py-4">
                            <button type="button" class="btn btn-danger" onclick="showConfirmation()">ยกเลิก</button>
                            <button type="submit" class="btn btn-primary" id="submitBtn">บันทึก</button>

                        </div>
                    </form>
                </div>

            </div>
        </div>

    </div>
    <!-- ส่วนจบของ เนื้อหา content -->

</div>
<div class="app-footer">
    <span>สาขาเทคโนโลยีธุรกิจดิจิทัล</span>
</div>
<!-- ส่วนจบของคอนเทนเนอร์ -->

<!-- ส่วนจบของหน้า -->

<!-- เริ่มต้นของไฟล์ JavaScript ที่จำเป็น -->
<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/modernizr.js"></script>
<script src="../assets/js/moment.js"></script>

<!-- เริ่มต้นของไฟล์ JavaScript ของ Vendor -->
<!--<script src="../assets/vendor/overlay-scroll/jquery.overlayScrollbars.min.js"></script>-->
<!--<script src="../assets/vendor/overlay-scroll/custom-scrollbar.js"></script>-->
<!--<script src="../assets/vendor/apex/apexcharts.min.js"></script>-->
<!--<script src="../assets/vendor/apex/custom/sales/salesGraph.js"></script>-->
<!--<script src="../assets/vendor/apex/custom/sales/revenueGraph.js"></script>-->
<!--<script src="../assets/vendor/apex/custom/sales/taskGraph.js"></script>-->

<!-- ไฟล์ JavaScript หลัก -->
<script src="../assets/js/main.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="../check.js"></script>
<script>
    function showConfirmation() {
        // แสดง SweetAlert หรือโค้ดที่ใช้ในการยืนยันก่อนที่จะยกเลิก
        Swal.fire({
            title: 'คุณแน่ใจหรือไม่? ที่จะยกเลิกการสมัครสมาชิก',
            // text: 'การกระทำนี้จะยกเลิกขั้นตอนที่คุณทำ',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'ใช่, ยกเลิก!',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                // กระทำเมื่อยืนยัน
                window.location.href = '../index.php';
            }
        });
    }

    // function INSERT_teacher(){
    //     $(document).ready(function () {
    //         $('#submitBtn').on('click', function () {
    //             var formData = new FormData($('#Formteacher')[0]);
    //
    //             $.ajax({
    //                 type: 'POST',
    //                 url: 'services_teacher/INSERT_teacher.php', // Adjust the path to your PHP file
    //                 data: formData,
    //                 contentType: false,
    //                 processData: false,
    //                 success: function (response) {
    //                     console.log(response)
    //                     if (response === 'success') {
    //                         Swal.fire({
    //                             icon: 'success',
    //                             title: 'ลงทะเบียนสำเร็จ',
    //                             showConfirmButton: false,
    //                             timer: 1500
    //                         });
    //                         // Additional actions after successful registration
    //                     } else {
    //                         Swal.fire({
    //                             icon: 'error',
    //                             title: 'เกิดข้อผิดพลาดในการลงทะเบียน',
    //                             text: response
    //                         });
    //                     }
    //                 }
    //             });
    //         });
    //     });
    // }

</script>
<?php
include_once 'services_teacher/INSERT_teacher.php';
?>
</body>
</html>