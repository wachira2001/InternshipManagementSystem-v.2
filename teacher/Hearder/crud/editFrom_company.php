<?php
require_once '../../../config/conndb.php';
require_once '../../../config/show_data.php';
// ตรวจสอบ session
session_start();
echo '
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';

if (!isset($_SESSION['username']) || ($_SESSION['role'] !== 'H')) {
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
$company_ID = $_GET['company_ID'];
$company = getcompany($conn,$company_ID);
// ปิดการเชื่อมต่อ
$conn = null;
//print_r($company);
//return;
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
        <title>แก้ไขข้อมูลแผนก</title>
        <link rel="icon" type="image/png" href="../../../upload_img/<?php echo $major['M_img'];?>">
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

        <link rel="stylesheet" href="../../../assets/css/animate.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.3.4/sweetalert2.min.css">
        <link rel="stylesheet" href="../../../assets/fonts/bootstrap/bootstrap-icons.css">
        <link rel="stylesheet" href="../../../assets/css/main.min.css">
        <link rel="stylesheet" href="../../../assets/vendor/overlay-scroll/OverlayScrollbars.min.css">
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
                <a href="../../index.php" class="logo">
                <span class="avatar">
                    <img src="../../../upload_img/<?php echo $major['M_img'];?>" alt="Admin Dashboards" style="width: auto;height: 100px"/>
                </span>
                </a>
            </div>
            <!-- ส่วนเริ่มต้นของแบรนด์ในไซด์บาร์ -->

            <!-- ส่วนเริ่มต้นของเมนูในไซด์บาร์ -->
            <div class="sidebar-menu">
                <div class="sidebarMenuScroll">
                    <ul>
                        <li class="">
                            <a href="../../index.php">
                                <i class="bi bi-house"></i>
                                <span class="menu-text">หน้าแรก</span>
                            </a>
                        </li>
                        <li class="sidebar-dropdown active">
                            <a href="#">
                                <i class="bi bi-handbag"></i>
                                <span class="menu-text">ข้อมูลทั่วไป</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>


                                    <?php
                                    if ($user['T_status'] == '1' ) {
                                        ?>

                                        <li>
                                            <a href="showdata_major.php" >ข้อมูลแผนก</a>
                                        </li>
                                        <li>
                                            <a href="showdata_teacher.php">ข้อมูลบุคลากร</a>
                                        </li>
                                        <li>
                                            <a href="showdata_student.php">ข้อมูลนักศึกษา</a>
                                        </li>
                                        <li>
                                            <a href="showdata_company.php" class="current-page">ข้อมูลสถานประกอบการ</a>
                                        </li>

                                        <?php
                                    }else{

                                        ?>
                                        <li>
                                            <a href="showdata_student.php">ข้อมูลนักศึกษา</a>
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
                        <i class="bi bi-house"></i>
                        <a href="#">ข้อมูลทั่วไป</a>
                    </li>
                    <li class="breadcrumb-item breadcrumb-active" aria-current="page">
                        <a href="showdata_major.php">ข้อมูลสถานประกอบการ</a>

                    </li>
                    <li class="breadcrumb-item breadcrumb-active" aria-current="page">
                        <a href="#">แก้ไขข้อมูลข้อมูลสถานประกอบการ</a>
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
                                <img src="../../img/<?php echo $user['T_img']; ?>" alt="Admin Templates">
                                        <!-- สถานะออนไลน์ -->
                                <span class="status online"></span>
                            </span>
                                </a>
                                <!-- เริ่มต้นของเมนูดรอปดาวน์ -->
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userSettings">
                                    <!-- คำสั่งการดำเนินการในโปรไฟล์ -->
                                    <div class="header-profile-actions">
                                        <a href="../../crud/editFrom_profile.php">โปรไฟล์</a>
                                        <a href="../../../config/logout.php">ออกจากระบบ</a>
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

                    <div class="card-body">
                        <form method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-12">
                                    <div>
                                        <center>
                                            <img id="previewImage" src="../../../upload_img/<?php echo $company['C_img'] ?>" alt="Preview Image" class="col-12 start-50"
                                                 style="height: 300px; width: auto;  ">
                                        </center>

                                    </div>
                                    <input type="hidden" class="form-control" id="inputName" placeholder="รหัสสถานประกอบการ" name="company_ID"
                                           value="<?= $company['company_ID'];?>">
                                    <div>
                                        <div class="mb-3">
                                            <label for="formFile" class="form-label">อัพโหลดรูป</label>
                                            <input class="form-control" type="file" id="imageInput" accept="image/*" name="C_img">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="card-title">ข้อมูลสถานประกอบการ</div>
                                        </div>
                                        <div class="card-body">

                                            <!-- Row start -->
                                            <div class="row m-auto">
                                                <div class="col-12 text-center">
                                                    <div class="form-section-title">รายละเอียด</div>
                                                </div>
                                                <div class="col-4 py-2">
                                                    <div class="">
                                                        <label for="inputName" class="form-label">ชื่อสถานประกอบการ</label>
                                                        <input type="text" class="form-control" id="inputName" placeholder="ชื่อสถานประกอบการ" name="C_name"
                                                               value="<?= $company['C_name'];?>" >
                                                    </div>
                                                </div>
                                                <div class="col-4 py-2">
                                                    <div class="">
                                                        <label for="inputName" class="form-label">หมายเลขโทรศัพท์</label>
                                                        <input type="text" class="form-control" id="inputName" placeholder="ชหมายเลขโทรศัพท์" name="C_telephone"
                                                               value="<?= $company['C_telephone'];?>" >
                                                    </div>
                                                </div>
                                                <div class="col-4 py-2">
                                                    <div class="">
                                                        <label for="inputName" class="form-label">เว็บไซต์สถานประกอบการ</label>
                                                        <input type="text" class="form-control" id="inputName" placeholder="เว็บไซต์สถานประกอบการ" name="C_website"
                                                               value="<?= $company['C_website'];?>" >
                                                    </div>
                                                </div>
                                                <div class="col-4 py-2">
                                                    <div class="">
                                                        <label for="inputName" class="form-label">ชื่อ-สกุล ผู้สอนงาน</label>
                                                        <input type="text" class="form-control" id="inputName" placeholder="ชื่อ-สกุล ผู้สอนงาน" name="C_staff_name"
                                                               value="<?= $company['C_staff_name'];?>" >
                                                    </div>
                                                </div>
                                                <div class="col-4 py-2">
                                                    <div class="">
                                                        <label for="inputName" class="form-label">ตำแหน่ง</label>
                                                        <input type="text" class="form-control" id="inputName" placeholder="ตำแหน่ง" name="C_staff_position"
                                                               value="<?= $company['C_staff_position'];?>" >
                                                    </div>
                                                </div>
                                                <div class="col-4 py-2">
                                                    <div class="">
                                                        <label for="inputName" class="form-label">เบอร์ติดต่อผู้สอนงาน</label>
                                                        <input type="text" class="form-control" id="inputName" placeholder="เบอร์ติดต่อผู้สอนงาน" name="C_staff_phone"
                                                               value="<?= $company['C_staff_phone'];?>" >
                                                    </div>
                                                </div>
                                                <div class="col-4 py-2">
                                                    <div class="">
                                                        <label for="inputName" class="form-label">ตำบล</label>
                                                        <input type="text" class="form-control" id="inputName" placeholder="ตำบล" name="C_tambon"
                                                               value="<?= $company['C_tambon'];?>" >
                                                    </div>
                                                </div>
                                                <div class="col-4 py-2">
                                                    <div class="">
                                                        <label for="inputName" class="form-label">อำเภอ</label>
                                                        <input type="text" class="form-control" id="inputName" placeholder="ตำบล" name="C_amphoe"
                                                               value="<?= $company['C_amphoe'];?>" >
                                                    </div>
                                                </div>
                                                <div class="col-4 py-2">
                                                    <div class="">
                                                        <label for="inputName" class="form-label">จังหวัด</label>
                                                        <input type="text" class="form-control" id="inputName" placeholder="จังหวัด" name="C_province"
                                                               value="<?= $company['C_province'];?>" >
                                                    </div>
                                                </div>

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
        <script src="../../../assets/js/jquery.min.js"></script>
        <script src="../../../assets/js/bootstrap.bundle.min.js"></script>
        <script src="../../../assets/js/modernizr.js"></script>
        <script src="../../../assets/js/moment.js"></script>

        <!-- เริ่มต้นของไฟล์ JavaScript ของ Vendor -->
        <script src="../../../assets/vendor/overlay-scroll/jquery.overlayScrollbars.min.js"></script>
        <script src="../../../assets/vendor/overlay-scroll/custom-scrollbar.js"></script>
        <script src="../../../assets/vendor/apex/apexcharts.min.js"></script>
        <script src="../../../assets/vendor/apex/custom/sales/salesGraph.js"></script>
        <script src="../../../assets/vendor/apex/custom/sales/revenueGraph.js"></script>
        <script src="../../../assets/vendor/apex/custom/sales/taskGraph.js"></script>

        <!-- ไฟล์ JavaScript หลัก -->
        <script src="../../../assets/js/main.js"></script>
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
                        window.location.href = 'showdata_major.php';
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
        </script>
    </body>
    </html>
<?php
require_once '../../services_teacher/update_company.php';
?>