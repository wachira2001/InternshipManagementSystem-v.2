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
$R_ID = $_GET['R_ID'];
$room = getroom($conn,$R_ID);
//print_r($room);
$getTeacher = getTeacher($conn);
// ปิดการเชื่อมต่อ
$conn = null;
//print_r($teachers);
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
                <a href="../index.php" class="logo">
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
                                <i class="bi bi-folder2"></i>
                                <span class="menu-text">ข้อมูลทั่วไป</span>
                            </a>
                            <div class="sidebar-submenu">
                                <ul>

                                    <li>
                                        <a href="showdata_teacher.php" >ข้อมูลบุคลากร</a>
                                    </li>
                                    <li>
                                        <a href="showdata_student.php" >ข้อมูลนักศึกษา</a>
                                    </li>
                                    <li>
                                        <a href="showdata_major.php" >ข้อมูลแผนก</a>
                                    </li>
                                    <li>
                                        <a href="showdata_room.php" class="current-page">ข้อมูลห้องเรียน</a>
                                    </li>
                                    <li>
                                        <a href="showdata_company.php" >ข้อมูลสถานประกอบการ</a>
                                    </li>
                                    <li>
                                        <a href="showdata_request.php" >อนุมัติคำร้อง</a>
                                    </li>
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
                        <a href="#">ข้อมูลทั่วไป</a>
                    </li>
                    <li class="breadcrumb-item breadcrumb-active" aria-current="page">
                        <a href="showdata_major.php">ข้อมูลห้องเรียน</a>

                    </li>
                    <li class="breadcrumb-item breadcrumb-active" aria-current="page">
                        <a href="#">แก้ไขข้อมูลห้องเรียน</a>
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
                        <div class="row">
                            <div class="col-sm-12 col-12">

                                <!-- Card start -->
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title">แก้ไขข้อมูล</div>
                                    </div>

                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-sm-3 col-12">
                                                    <div class="m-0">
                                                        <label class="form-label">เลือกชั้น</label>
                                                        <select class="form-select" aria-label="Default select example" id="R_level" required>
                                                            <option value="" selected="">-- เลือกชั้น --</option>
                                                            <option value="ปวช." <?php echo ($room['R_level'] == 'ปวช.') ? 'selected' : ''; ?>>ปวช.</option>
                                                            <option value="ปวส." <?php echo ($room['R_level'] == 'ปวส.') ? 'selected' : ''; ?>>ปวส.</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3 col-12">
                                                    <div class="m-0">
                                                        <label class="form-label">เลือกชั้น</label>
                                                        <select class="form-select" aria-label="Default select example" id="R_level_number" required>
                                                            <option value="" selected="">-- เลือกชั้น --</option>
                                                            <option value="1" <?php echo ($room['R_level_number'] == '1' && $room['R_level'] == 'ปวช.' || $room['R_level'] == 'ปวส.') ? 'selected' : ''; ?>>1</option>
                                                            <option value="2" <?php echo ($room['R_level_number'] == '2' && $room['R_level'] == 'ปวช.' || $room['R_level'] == 'ปวส.' ) ? 'selected' : ''; ?>>2</option>
                                                            <option value="3" <?php echo ($room['R_level_number'] == '3' && $room['R_level'] == 'ปวช.'  ) ? 'selected' : ''; ?>>3</option>
                                                           </select>
                                                    </div>

                                                </div>
                                                <div class="col-sm-3 col-12">
                                                    <div class="m-0">
                                                        <label class="form-label">เลือกห้อง</label>
                                                        <select class="form-select" aria-label="Default select example" id="R_room" required>
                                                            <option value="" selected="">-- เลือกห้อง --</option>
                                                            <?php
                                                            // ในที่นี้เริ่มต้นที่ห้อง 1 และสิ้นสุดที่ห้อง 15
                                                            for ($i = 1; $i <= 15; $i++) {
                                                                $value = $i;
                                                                $selected = ($room['R_room'] == $value) ? 'selected' : '';
                                                                echo "<option value=\"$value\" $selected>ห้อง $value</option>";
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                    <div class="col-sm-3 col-12">
                                                    <div class="m-0">
                                                        <label class="form-label">เลือกครูประจำห้อง</label>
                                                        <select class="form-select" aria-label="Default select example" id="T_ID" required>
                                                            <option value="" selected="">-- ครูประจำห้อง --</option>
                                                            <?php foreach ($getTeacher as $teacher) : ?>
                                                                <option value="<?php echo $teacher['T_ID']; ?>" <?php echo ($room['T_ID'] == $teacher['T_ID'] ) ? 'selected' : ''; ?>><?php echo $teacher['T_fname']; ?></option>
<!--                                                                <option value="--><?php //echo $teacher['T_ID']; ?><!--">--><?php //echo $teacher['T_fname']; ?><!--</option>-->
                                                            <?php endforeach; ?>

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="py-5">
                                                    <div class="form-actions-footer">
                                                        <button class="btn btn-light" onclick="showConfirmation()">ยกเลิก</button>
                                                        <button class="btn btn-success" onclick="saveData(<?php echo $room['R_ID']; ?>)">บันทึก</button>
                                                    </div>
                                                </div>

                                            </div>
                                    <!-- Card end -->

                                </div>

                            </div>

                        </div>
                    </div>
                        <div class="app-footer">
                            <span>สาขาเทคโนโลยีธุรกิจดิจิทัล</span>
                        </div>

                </div>
                <!-- ส่วนจบของคอนเทนเนอร์ -->

                <!-- เริ่มต้นของ App Footer -->

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

<!--        <!-- เริ่มต้นของไฟล์ JavaScript ของ Vendor -->
<!--        <script src="../../../assets/vendor/overlay-scroll/jquery.overlayScrollbars.min.js"></script>-->
<!--        <script src="../../../assets/vendor/overlay-scroll/custom-scrollbar.js"></script>-->
<!--        <script src="../../../assets/vendor/apex/apexcharts.min.js"></script>-->
<!--        <script src="../../../assets/vendor/apex/custom/sales/salesGraph.js"></script>-->
<!--        <script src="../../../assets/vendor/apex/custom/sales/revenueGraph.js"></script>-->
<!--        <script src="../../../assets/vendor/apex/custom/sales/taskGraph.js"></script>-->

        <!-- ไฟล์ JavaScript หลัก -->
        <script src="../../../assets/js/main.js"></script>
        <script src="../../../Function/editFrom_room.js"></script>
    </body>
    </html>
