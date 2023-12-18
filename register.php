<?php
require_once 'config/conndb.php';
require_once 'config/show_data.php';
$major = getmajor($conn);
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
    <title>หน้าแรก</title>
    <link rel="icon" type="image/png" href="upload_img/<?php echo $major['M_img'];?>">
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
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.3.4/sweetalert2.min.css">
    <link rel="stylesheet" href="assets/fonts/bootstrap/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/main.min.css">
    <link rel="stylesheet" href="assets/vendor/overlay-scroll/OverlayScrollbars.min.css">
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
                        <img src="upload_img/<?php echo $major['M_img'];?>" alt="Admin Dashboards" style="width: auto;height: 100px"/>
                    </span>
            </a>
        </div>
        <!-- ส่วนเริ่มต้นของแบรนด์ในไซด์บาร์ -->

        <!-- ส่วนเริ่มต้นของเมนูในไซด์บาร์ -->
        <div class="sidebar-menu m-auto" >
            <div class="sidebarMenuScroll">
                <ul>
                    <li class="">
                        <a href="index.php">
                            <i class="bi bi-house"></i>
                            <span class="menu-text" >หน้าแรก</span>
                        </a>
                    </li>
                    <li class="">
                        <a href="about.php">
                            <i class="bi bi-exclamation-circle"></i>
                            <span class="menu-text" >เกี่ยวกับเรา</span>
                        </a>
                    </li>
                    <li class="active">
                        <a href="register.php">
                            <i class="bi bi-person-plus"></i>
                            <span class="menu-text" >สมัครสมาชิก</span>
                        </a>
                    </li>
                    <li class="">
                        <a href="login.php">
                            <i class="bi bi-person-square"></i>
                            <span class="menu-text" >เข้าสู่ระบบ</span>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
        <!-- สิ้นสุดรายการเมนู -->
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

                </li>

            </ol>
            <div class="header-actions-container">
                <!-- เริ่มต้นของการกระทำของส่วนหัวเรื่อง -->
                <div>
                    <ul class="header-actions">
                        <!-- เริ่มต้นของดรอปดาวน์ -->
                        <li class="dropdown">

                            <a href="#" id="userSettings" class="user-settings" data-toggle="dropdown" aria-haspopup="true">

                                <span class="avatar">

                                </span>
                            </a>

                        </li>

                    </ul>
                </div>

            </div>

        </div>

        <!-- ส่วนเริ่มต้นของการหลีกเลี่ยงข้อผิดพลาด -->
        <div class="content-wrapper-scroll">

            <!-- ส่วนเริ่มต้นของคอนเทนเนอร์ -->

            <div class="content-wrapper">
                <div class="m-auto">
                    <div>
                        <div class="text-center m-5">
                            <h1>กรุณาเลือกลงทะเบียน</h1>
                        </div>
                        <div class="row row-cols-1 row-cols-md-3 mb-3 text-center">
                            <div class="col mx-auto py-5">
                                <div class="card mb-6">
                                    <div class="card-header py-3">
                                        <h4 class="my-0 fw-normal fw-bold">สำหรับบุคลากร</h4>
                                    </div>
                                    <div class="card-body">
                                        <h3 class="card-title pricing-card-title">เป็นการสมัครสมาชิกเพื่อเข้าใช้งานระบบ <br>สำหรับบุคลากร

                                        </h3>
                                        <div class="list-unstyled mt-3 mb-4">
                                            <a href="teacher/register_teacher.php">
                                                <img src="img/teacher.gif" width="50%" height="50%" alt="Teacher Image">
                                            </a>
                                        </div>
                                        <a href="teacher/register_teacher.php">
                                            <button type="button" class="w-100 btn btn-lg btn-outline-primary fw-bold">สมัคร</button>
                                        </a>

                                    </div>
                                </div>
                            </div>
                            <div class="col mx-auto py-5">
                                <div class="card mb-6">
                                    <div class="card-header py-3">
                                        <h4 class="my-0 fw-normal fw-bold">สำหรับนักเรียน/นักศึกษา</h4>
                                    </div>
                                    <div class="card-body ">
                                        <h3 class="card-title pricing-card-title ">เป็นการสมัครสมาชิกเพื่อเข้าใช้งานระบบ <br>สำหรับนักเรียน/นักศึกษา

                                        </h3>
                                        <div class="list-unstyled mt-3 mb-4">
                                            <a href="student/register_student.php">
                                                <img src="img/student.gif" width="50%" height="50%" alt="Teacher Image">
                                            </a>
                                        </div>
                                        <a href="student/register_student.php">
                                            <button type="button" class="w-100 btn btn-lg btn-outline-primary fw-bold" >สมัคร</button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ส่วนจบของคอนเทนเนอร์ -->

            <!-- เริ่มต้นของ App Footer -->
            <div class="app-footer">
                <span><?php echo $major['M_Name'];?></span>
            </div>
            <!-- ส่วนจบของ App Footer -->

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

</body>
</html>



