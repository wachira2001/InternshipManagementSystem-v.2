<?php
require_once '../../config/conndb.php';
require_once '../../config/show_data.php';
// ตรวจสอบ session
session_start();
echo '
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';

if (!isset($_SESSION['username']) || ($_SESSION['role'] !== 'H' && $_SESSION['role'] !== 'T')) {
    echo '
            <script>
            setTimeout(function() {
            swal({
                title: "คุณไม่มีสิทธิ์ใช้งานหน้านี้",
                type: "error"
            }, function() {
                window.location = "../../../login.php"; // หน้าที่ต้องการให้กระโดดไป
            });
        }, 1000);
    </script>';
    exit();
}
$user = getuserT($conn,$_SESSION['username']);
$major = getmajor($conn);
$getroom = getroomall($conn);

//print_r($user);
//return;
// ปิดการเชื่อมต่อ
$conn = null;


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
        <title>แก้ไขข้อมูลส่วนตัว</title>
        <link rel="icon" type="image/png" href="../../upload_img/<?php echo $major['M_img'];?>">
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

        <link rel="stylesheet" href="../../assets/css/animate.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.3.4/sweetalert2.min.css">
        <link rel="stylesheet" href="../../assets/fonts/bootstrap/bootstrap-icons.css">
        <link rel="stylesheet" href="../../assets/css/main.min.css">
        <link rel="stylesheet" href="../../assets/vendor/overlay-scroll/OverlayScrollbars.min.css">
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

        <!-- ส่วนเริ่มต้นของไซด์บาร์ -->
        <nav class="sidebar-wrapper">

            <!-- ส่วนเริ่มต้นของแบรนด์ในไซด์บาร์ -->
            <div class="sidebar-brand">
                <a href="../index.php" class="logo">
                <span class="avatar">
                    <img src="../../upload_img/<?php echo $major['M_img'];?>" alt="Admin Dashboards" style="width: auto;height: 100px"/>
                </span>
                </a>
            </div>
            <!-- ส่วนเริ่มต้นของแบรนด์ในไซด์บาร์ -->

            <!-- ส่วนเริ่มต้นของเมนูในไซด์บาร์ -->
            <div class="sidebar-menu">
                <div class="sidebarMenuScroll">
                    <ul>
                        <li class="">
                            <a href="../index.php">
                                <i class="bi bi-house"></i>
                                <span class="menu-text">หน้าแรก</span>
                            </a>
                        </li>
                        <li class="sidebar-dropdown ">
                            <a href="#">
                                <i class="bi bi-folder2"></i>
                                <span class="menu-text">ข้อมูลทั่วไป</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>


                                    <?php
                                    if ($user['T_status'] == '1' ) {
                                        ?>

                                        <li>
                                            <a href="../Hearder/crud/showdata_major.php">ข้อมูลแผนก</a>
                                        </li>
                                        <li>
                                            <a href="../Hearder/crud/showdata_teacher.php">ข้อมูลบุคลากร</a>
                                        </li>
                                        <li>
                                            <a href="../Hearder/crud/showdata_student.php" >ข้อมูลนักศึกษา</a>
                                        </li>
                                        <li>
                                            <a href="../Hearder/crud/showdata_room.php">ข้อมูลห้องเรียน</a>
                                        </li>
                                        <li>
                                            <a href="../Hearder/crud/showdata_company.php" >ข้อมูลสถานประกอบการ</a>
                                        </li>

                                        <?php
                                    }else{

                                        ?>
                                        <li>
                                            <a href="showdata_room.php" >ข้อมูลห้องเรียน</a>
                                        </li>
                                        <li>
                                            <a href="showdata_student.php" >ข้อมูลนักศึกษา</a>
                                        </li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                        </li>

                    </ul>
                    <!-- สิ้นสุดรายการเมนู -->
                </div>
            </div>
        </nav>
        <!-- ส่วนจบของเมนูในไซด์บาร์ -->
        <!-- ส่วนจบของไซด์บาร์ -->

        <!-- ส่วนเริ่มต้นของคอนเทนเนอร์หลัก -->
        <div class="main-container">
            <div class="page-header">
                <div class="toggle-sidebar" id="toggle-sidebar"><i class="bi bi-list"></i></div>
                <!-- ส่วนเริ่มต้นของการหลีกเลี่ยงข้อผิดพลาด -->
                <ol class="breadcrumb d-md-flex d-none" >
                    <li class="breadcrumb-item">
                        <i class="bi bi-folder2"></i>
                        <a href="#">แก้ไขข้อมูลส่วนตัว</a>
                    </li>
                </ol>
                <div class="header-actions-container">
                    <!-- เริ่มต้นของการกระทำของส่วนหัวเรื่อง -->
                    <div>
                        <ul class="header-actions">
                            <!-- เริ่มต้นของดรอปดาวน์ -->
                            <li class="dropdown">
                                <!-- ลิงค์การตั้งค่าผู้ใช้ -->
                                <a href="#" id="userSettings" class="user-settings" data-toggle="dropdown" aria-haspopup="true">
                                    <!-- ชื่อผู้ใช้ -->
                                    <span class="user-name d-none d-md-block"><?php echo $user['T_fname']; ?></span>
                                    <!-- รูปประจำตัว -->
                                    <span class="avatar">
                                <img src="../img/<?php echo $user['T_img']; ?>" alt="Admin Templates">
                                        <!-- สถานะออนไลน์ -->
                                <span class="status online"></span>
                            </span>
                                </a>
                                <!-- เริ่มต้นของเมนูดรอปดาวน์ -->
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userSettings">
                                    <!-- คำสั่งการดำเนินการในโปรไฟล์ -->
                                    <div class="header-profile-actions">
                                        <a href="editFrom_profile.php">โปรไฟล์</a>
                                        <a href="../../config/logout.php">ออกจากระบบ</a>
                                    </div>
                                    <!-- ส่วนจบของคำสั่งการดำเนินการในโปรไฟล์ -->
                                </div>
                                <!-- ส่วนจบของเมนูดรอปดาวน์ -->
                            </li>
                            <!-- ส่วนจบของดรอปดาวน์ -->
                        </ul>
                    </div>
                    <!-- ส่วนจบของการกระทำของส่วนหัวเรื่อง -->
                </div>
                <!-- ส่วนจบของการกระทำของส่วนหัวเรื่อง -->
            </div>
            <!-- ส่วนจบของคอนเทนเนอร์หลัก -->

            <!-- ส่วนเริ่มต้นของการหลีกเลี่ยงข้อผิดพลาด -->
            <div class="content-wrapper-scroll">

                <!-- ส่วนเริ่มต้นของคอนเทนเนอร์ -->
                <div class="content-wrapper">

                    <form method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-12">
                                <div>
                                    <center>
                                        <img id="previewImage" src="../img/<?php echo $user['T_img'] ?>" alt="Preview Image" class="col-12 start-50"
                                             style="height: 300px; width: auto; ">
                                    </center>

                                </div>
                                <input type="hidden" class="form-control" id="inputName" placeholder="รหัสแผนก" name="T_ID"
                                       value="<?=$user['T_ID'];?>">
                                <div>
                                    <div class="mb-3">
                                        <label for="formFile" class="form-label">อัพโหลดรูป</label>
                                        <input class="form-control" type="file" id="imageInput" accept="image/*" name="T_img">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title">ข้อมูลส่วนตัว</div>
                                    </div>
                                    <div class="card-body">

                                        <!-- Row start -->
                                        <div class="row m-auto">
                                            <div class="col-12 text-center">
                                                <div class="form-section-title">รายละเอียดส่วนตัว</div>
                                            </div>
                                            <div class="col-6 py-2">
                                                <div class="">
                                                    <label for="inputName" class="form-label">ชื่อ</label>
                                                    <input type="text" class="form-control" id="inputName" placeholder="ชื่อ" name="T_fname"
                                                           value="<?=$user['T_fname'];?>" >
                                                </div>
                                            </div>
                                            <div class="col-6 py-2">
                                                <div class="">
                                                    <label for="inputName" class="form-label">สกุล</label>
                                                    <input type="text" class="form-control" id="inputName" placeholder="สกุล" name="T_lname"
                                                           value="<?=$user['T_lname'];?>" >
                                                </div>
                                            </div>
                                            <div class="col-4 py-2">
                                                <div class="">
                                                    <label for="inputName" class="form-label">ตำแหน่ง</label>
                                                    <input type="text" class="form-control" id="inputName" placeholder="ตำแหน่ง" name="T_position"
                                                           value="<?=$user['T_position'];?>" >
                                                </div>
                                            </div>

                                            <div class="col-4 py-2">
                                                <div class="">
                                                    <label for="inputName" class="form-label">วัน/เดือน/ปีเกิด</label>
                                                    <input type="date" class="form-control" id="inputName" placeholder="วัน/เดือน/ปีเกิด" name="T_birthday"
                                                           value="<?=$user['T_birthday'];?>" >
                                                </div>
                                            </div>
                                            <div class="col-4 py-2">
                                                <div class="">
                                                    <label for="inputName" class="form-label">เบอร์โทรศัพท์</label>
                                                    <input type="tel" class="form-control" id="inputName" placeholder="เบอร์โทรศัพท์" name="T_phone"
                                                           value="<?=$user['T_phone'];?>" >
                                                </div>
                                            </div>
                                            <div class="col-4 py-2">
                                                <div class="">
                                                    <label for="inputName" class="form-label">E-mail</label>
                                                    <input type="email" class="form-control" id="inputName" placeholder="E-mail" name="T_email"
                                                           value="<?=$user['T_email'];?>" >
                                                </div>
                                            </div>
                                            <div class="col-4 py-2">
                                                <div class="">
                                                    <label for="T_gender" class="form-label">เพศ</label>
                                                    <select id="T_gender" class="form-select" name="T_gender">
                                                        <option <?php echo ($user['T_gender'] == 'Choose...') ? 'selected' : ''; ?>>Choose...</option>
                                                        <option <?php echo ($user['T_gender'] == 'ชาย') ? 'selected' : ''; ?>>ชาย</option>
                                                        <option <?php echo ($user['T_gender'] == 'หญิง') ? 'selected' : ''; ?>>หญิง</option>
                                                        <option <?php echo ($user['T_gender'] == 'ไม่ระบุ') ? 'selected' : ''; ?>>ไม่ระบุ</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-4 py-2">
                                                <div class="mb-3">
                                                    <label for="R_ID" class="form-label">ห้องประจำชั้น</label>
                                                    <select name="R_ID" id="R_ID" class="form-select" required>
                                                        <?php foreach ($getroom as $room) : ?>
                                                            <?php
                                                            // เช็คว่า T_ID ของครูนี้เท่ากับ T_ID ที่ต้องการให้เป็นค่าเริ่มต้นหรือไม่
                                                            $selected = ($getroom['R_ID'] == $room['R_ID']) ? 'selected' : '';
                                                            ?>
                                                            <option name="R_ID" value="<?php echo $room['R_ID']; ?>" <?php echo $selected; ?>>
                                                                <?php echo $room['R_level']; ?>. <?php echo $room['R_room']; ?> ห้อง <?php echo $room['R_level_numder']; ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-4 py-2">
                                                <label for="R_ID" class="form-label">เลือกระดับชั้น</label>
                                                <select name="R_ID" id="R_ID" class="form-select" required >
                                                    <option value="">-- เลือกครู --</option>

                                                    <?php foreach ($getroom as $room) : ?>
                                                        <?php
                                                        // เช็คว่า T_ID ของครูนี้เท่ากับ T_ID ที่ต้องการให้เป็นค่าเริ่มต้นหรือไม่
                                                        $selected = ($user['T_ID'] == $room['R_ID']) ? 'selected' : '';
                                                        ?>
                                                        <option value="<?php echo $room['R_ID']; ?>"><?php echo $room['R_level']; ?>. <?php echo $room['R_room']; ?> ห้อง <?php echo $room['R_level_numder']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="col-12 py-2">
                                                <div class="">
                                                    <label for="inputName" class="form-label">ที่อยู่</label>
                                                    <textarea type="text" class="form-control" id="inputName" placeholder="ที่อยู่" name="T_address"><?=$user['T_address'];?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-12 text-center">
                                                <div class="form-section-title">ตั้งค่า User และ Password</div>
                                            </div>
                                            <div class="col-12 py-2">
                                                <div class="">
                                                    <label for="inputEmail" class="form-label">Username</label>
                                                    <input type="text" class="form-control" id="inputEmail" placeholder="Username" name="T_username"
                                                           value="<?=$user['T_username'];?>" >
                                                </div>
                                            </div>
<!--                                            <div class="col-12 py-2">-->
<!--                                                <div class="">-->
<!--                                                    <label for="inputNumber" class="form-label">Password</label>-->
<!--                                                    <input type="text" class="form-control" id="inputNumber" placeholder="Password" name="T_password"-->
<!--                                                           value="--><?php //=$user['T_password'];?><!--" >-->
<!--                                                </div>-->
<!--                                            </div>-->
                                            <div class="mb-3">
                                                <label for="exampleInputPassword1" class="form-label">Password</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control" id="password" name="T_password" placeholder="password" value="<?=$user['T_password'];?>">
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-outline-secondary password-toggle-button" onclick="togglePasswordVisibility()">
                                                            <i id="eye-icon" class="bi bi-eye"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" class="form-control date-own" id="T_status" name="T_status"
                                                   value="<?=$user['T_status'];?>" >
                                        </div>
                                        <br>
                                        <br>

                                        <!-- Row end -->

                                        <!-- Form actions footer start -->
                                        <div class="form-actions-footer">
                                            <a><button class="btn btn-danger" type="button" onclick="showConfirmation()">ยกเลิก</button></a>
                                            <a><button class="btn btn-primary" type="button" onclick="saveData()">บันทึก</button></a>
                                        </div>
                                        <!-- Form actions footer end -->

                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
                <!-- ส่วนจบของคอนเทนเนอร์ -->

                <!-- เริ่มต้นของ App Footer -->
                <div class="app-footer">
                    <span>สาขาเทคโนโลยีธุรกิจดิจิทัล</span>
                </div>
                <!-- ส่วนจบของ App Footer -->
            </div>

        </div>

        <!-- ส่วนจบของคอนเทนเนอร์ -->

        <!-- ส่วนจบของหน้า -->

        <!-- เริ่มต้นของไฟล์ JavaScript ที่จำเป็น -->
        <script src="../../assets/js/jquery.min.js"></script>
        <script src="../../assets/js/bootstrap.bundle.min.js"></script>
        <script src="../../assets/js/modernizr.js"></script>
        <script src="../../assets/js/moment.js"></script>

        <!-- เริ่มต้นของไฟล์ JavaScript ของ Vendor -->
        <script src="../../assets/vendor/overlay-scroll/jquery.overlayScrollbars.min.js"></script>
        <script src="../../assets/vendor/overlay-scroll/custom-scrollbar.js"></script>
        <script src="../../assets/vendor/apex/apexcharts.min.js"></script>
        <script src="../../assets/vendor/apex/custom/sales/salesGraph.js"></script>
        <script src="../../assets/vendor/apex/custom/sales/revenueGraph.js"></script>
        <script src="../../assets/vendor/apex/custom/sales/taskGraph.js"></script>

        <!-- ไฟล์ JavaScript หลัก -->
        <script src="../../assets/js/main.js"></script>
        <script>
            document.getElementById('imageInput').addEventListener('change', function (e) {
                var preview = document.getElementById('previewImage');
                var file = e.target.files[0];
                var reader = new FileReader();

                reader.onloadend = function () {
                    preview.src = reader.result;
                };

                if (file) {
                    reader.readAsDataURL(file);
                } else {
                    preview.src = "#";
                }
            });

            // เมื่อกดปุ่ม "บันทึก" หรือ "อัพโหลดใหม่"
            function saveImage() {
                // ส่งข้อมูลรูปภาพไปยังเซิร์ฟเวอร์
                // ทำการอัพเดทในฐานข้อมูล
                // หลังจากอัพเดทสำเร็จ, ทำการแทนที่รูปภาพเก่าด้วยรูปภาพใหม่
                document.getElementById('currentImage').src = document.getElementById('previewImage').src;
            }
            function showConfirmation() {
                // แสดง SweetAlert หรือโค้ดที่ใช้ในการยืนยันก่อนที่จะยกเลิก
                Swal.fire({
                    title: 'คุณแน่ใจหรือไม่?',
                    text: 'การกระทำนี้จะยกเลิกขั้นตอนที่คุณทำ',
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
            function saveData() {
                Swal.fire({
                    title: 'คุณแน่ใจหรือไม่?',
                    text: 'ที่จะแก้ไขข้อมูล',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ใช่, บันทึก!',
                    cancelButtonText: 'ยกเลิก'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.querySelector('form').submit();
                    }
                });
            }




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

        </script>

    </body>
    </html>
<?php
require_once '../services_teacher/update_profile.php';
?>