<?php
require_once '../../services_teacher/conndb.php';
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
                window.location = "login.php"; // หน้าที่ต้องการให้กระโดดไป
            });
        }, 1000);
    </script>';
    exit();
}

$user = getuserT($conn, $_SESSION['username']);
$stmtD = getmajor($conn);

if (isset($_GET['search']) && $_GET['search'] != '') {
    // ประกาศตัวแปรรับค่าจากฟอร์ม
    $search = "%" . $_GET['search'] . "%";
    $getteacherall = getteacherall($conn,$search);
} else {
    // คิวรี่ข้อมูลมาแสดงตามปกติ *แสดงทั้งหมด
    $search = '';
    $getteacherall = getteacherall($conn,$search);
}

$conn = null;
//print_r($user);
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
    <title>ข้อมูลบุคลากร</title>
    <link rel="icon" type="image/png" href="../../../upload_img/<?php echo $stmtD['M_img']; ?>">
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
                    <img src="../../../upload_img/<?php echo $stmtD['M_img']; ?>" alt="Admin Dashboards"
                         style="width: auto;height: 100px"/>
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
                                <?php
                                // เงื่อนไขเพื่อตรวจสอบบทบาท
                                if ($user['T_status'] == '1') {
                                    ?>
                                    <li>
                                        <a href="showdata_teacher.php" class="current-page">ข้อมูลบุคลากร</a>
                                    </li>
                                    <li>
                                        <a href="showdata_student.php">ข้อมูลนักศึกษา</a>
                                    </li>
                                    <li>
                                        <a href="showdata_major.php">ข้อมูลแผนก</a>
                                    </li>
                                    <li>
                                        <a href="showdata_room.php">ข้อมูลห้องเรียน</a>
                                    </li>
                                    <li>
                                        <a href="showdata_company.php">ข้อมูลสถานประกอบการ</a>
                                    </li>
                                    <li>
                                        <a href="showdata_request.php">อนุมัติคำร้อง</a>
                                    </li>
                                    <?php
                                } else {

                                    ?>
                                    <li>
                                        <a href="../crud/showdata_student.php">ข้อมูลนักศึกษา</a>
                                    </li>
                                    <li>
                                        <a href="../crud/showdata_room.php">ข้อมูลห้องเรียน</a>
                                    </li>
                                    <li>
                                        <a href="../crud/showdata_request.php">อนุมัติคำร้อง</a>
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
            <ol class="breadcrumb d-md-flex d-none">
                <li class="breadcrumb-item">
                    <i class="bi bi-folder2"></i>
                    <a href="showdata_teacher.php">ข้อมูลทั่วไป</a>
                </li>
                <li class="breadcrumb-item breadcrumb-active" aria-current="page">ข้อมูลบุคลากร</li>
            </ol>
            <div class="header-actions-container">
                <!-- เริ่มต้นของการกระทำของส่วนหัวเรื่อง -->
                <div>
                    <ul class="header-actions">
                        <!-- เริ่มต้นของดรอปดาวน์ -->
                        <li class="dropdown">
                            <!-- ลิงค์การตั้งค่าผู้ใช้ -->
                            <a href="#" id="userSettings" class="user-settings" data-toggle="dropdown"
                               aria-haspopup="true">
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
                                    <a href="#" onclick="showConfirmationLogout()">ออกจากระบบ</a>
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
                <div class="search-container m-2">
                    <form action="showdata_teacher.php" method="get">
                        <!-- Search input group start -->
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="ค้นหาชื่อบุคลากร"
                                   value="<?php if (isset($_GET['search'])) {
                                       echo $_GET['search'];
                                   } ?>">
                            <button class="btn" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </form>
                    <!--                --><?php
                    //                // แสดงข้อความที่ค้นหา
                    //                if (isset($_GET['search']) && $_GET['search'] != '') {
                    //                    if (count($getrequestall) > 0) {
                    //                        echo '<font color="red"> ข้อมูลการค้นหา : ' . $_GET['search'];
                    //                        echo ' *พบ ' . count($getrequestall) . ' รายการ</font><br><br>';
                    //                        echo count($getrequestall);
                    //                    }
                    //                }
                    //                ?>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">รายชื่อบุคลากร</div>
                            </div>
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table class="table v-middle m-0">
                                        <thead>
                                        <tr>
                                            <th>ชื่อ</th>
                                            <th>ตำแหน่ง</th>
                                            <th>E-mail</th>
                                            <th>เพศ</th>
                                            <th>เบอร์โทร</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                            <tbody>
                                            <?php if (empty($getteacherall)) : ?>
                                            <tr>
                                                <td colspan="7" class="text-center">ไม่พบข้อมูล</td>
                                            </tr>
                                            <?php else : ?>
                                            <?php foreach ($getteacherall as $teacher) : ?>
                                            <tr>
                                                <td>
                                                    <div class="media-box">
                                                        <img src="../../img/<?= $teacher['T_img']; ?>"
                                                             class="media-avatar" alt="Bootstrap Themes">
                                                        <div class="media-box-body">
                                                            <div class="text-truncate"><?= $teacher['T_fname']; ?> <?= $teacher['T_lname']; ?></div>
                                                            <p>ID: <?= $teacher['T_ID']; ?></p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><?= $teacher['T_position']; ?></td>
                                                <td><?= $teacher['T_email']; ?></td>
                                                <td><?= $teacher['T_gender']; ?></td>
                                                <td><?= $teacher['T_phone']; ?></td>
                                                <td>
                                                    <div class="actions">
                                                        <a href="#"  data-bs-toggle="offcanvas"
                                                           data-bs-target="#offcanvasExample<?= $teacher['T_ID']; ?>"
                                                           aria-controls="offcanvasExample">
                                                            <i class="bi bi-list text-green"> </i>
                                                        </a>
                                                        <a href="editFrom_teacher.php?T_ID=<?= $teacher['T_ID']; ?>" >
                                                            <i class="bi bi-pencil-square text-warning"></i>
                                                        </a>
                                                        <a href="#" onclick="Delete(<?= $teacher['T_ID']; ?>)">
                                                            <i class="bi bi-trash text-red"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <div class="offcanvas offcanvas-start" tabindex="-1"
                                                 id="offcanvasExample<?= $teacher['T_ID']; ?>"
                                                 aria-labelledby="offcanvasExampleLabel">
                                                <div class="offcanvas-header">
                                                    <h5 class="offcanvas-title" id="offcanvasExampleLabel">รายละเอียดของ <?= $teacher['T_fname']; ?> <?= $teacher['T_lname']; ?></h5>
                                                    <button type="button" class="btn-close text-reset"
                                                            data-bs-dismiss="offcanvas"
                                                            aria-label="Close">

                                                    </button>
                                                </div>
                                                <div class="offcanvas-body">
                                                    <div class="row ">
                                                        <div class="card">
                                                            <div class="col-12 py-3">
                                                                <img src="../../img/<?= $teacher['T_img']; ?>"
                                                                     class="media-avatar rounded mx-auto d-block" alt="Bootstrap Themes" width="60%">
                                                            </div>
                                                            <div class="col-12 py-1">
                                                                <p>รหัสบุคลากร : <?= $teacher['T_ID']; ?> </p>
                                                            </div>
                                                            <div class="col-12 py-1">
                                                                <p>ชื่อ-สกุล : <?= $teacher['T_fname']; ?> <?= $teacher['T_lname']; ?></p>
                                                            </div>
                                                            <div class="col-12 py-1">
                                                                <p>ตำแหน่ง : <?= $teacher['T_position']; ?> </p>
                                                            </div>

                                                            <div class="col-12 py-1">
                                                                <p>วัน/เดือน/ปีเกิด : <?= $teacher['T_birthday']; ?> </p>
                                                            </div>
                                                            <div class="col-12 py-1">
                                                                <p>หมายเลขโทรศัพท์ : <?= $teacher['T_phone']; ?> </p>
                                                            </div>
                                                            <div class="col-12 py-1">
                                                                <p>E-mail : <?= $teacher['T_email']; ?> </p>
                                                            </div>
                                                            <div class="col-12 py-1">
                                                                <p>เพศ : <?= $teacher['T_gender']; ?> </p>
                                                            </div>
                                                            <div class="col-12 py-1">
                                                                <p>ที่อยู่ : <?= $teacher['T_address']; ?> </p>
                                                            </div>

                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                            </tbody>
                                        <?php endforeach; ?>
                                        <?php endif; ?>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
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
    <!--    <script src="../../../assets/vendor/overlay-scroll/jquery.overlayScrollbars.min.js"></script>-->
    <!--    <script src="../../../assets/vendor/overlay-scroll/custom-scrollbar.js"></script>-->
    <!--    <script src="../../../assets/vendor/apex/apexcharts.min.js"></script>-->
    <!--    <script src="../../../assets/vendor/apex/custom/sales/salesGraph.js"></script>-->
    <!--    <script src="../../../assets/vendor/apex/custom/sales/revenueGraph.js"></script>-->
    <!--    <script src="../../../assets/vendor/apex/custom/sales/taskGraph.js"></script>-->

    <!-- ไฟล์ JavaScript หลัก -->
    <script src="../../../assets/js/main.js"></script>
    <script src="../../../Function/showdata_teacher.js"></script>
    <script>

    </script>
</body>
</html>