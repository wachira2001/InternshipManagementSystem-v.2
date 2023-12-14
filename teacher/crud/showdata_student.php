<?php
require_once '../services_teacher/conndb.php';
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

$userT = getuserT($conn,$_SESSION['username']);
$getstudentToID = getstudentToID($conn,$_SESSION['data']['T_ID']);
$stmtD = getmajor($conn);


if (isset($_GET['search']) && $_GET['search'] != '') {
    // ประกาศตัวแปรรับค่าจากฟอร์ม
    $search = "%" . $_GET['search'] . "%";
    $getstudentToID = getstudentToID($conn,$_SESSION['data']['T_ID'],$search);
} else {
    // คิวรี่ข้อมูลมาแสดงตามปกติ *แสดงทั้งหมด
    $search = '';
    $getstudentToID = getstudentToID($conn,$_SESSION['data']['T_ID'],$search);
}








// ปิดการเชื่อมต่อ
$conn = null;
//print_r($getstudentToID);
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
    <title>ข้อมูลนักศึกษา</title>
    <link rel="icon" type="image/png" href="../../upload_img/<?php echo $stmtD['M_img'];?>">
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
            <a href="../../index.php" class="logo">
                <span class="avatar">
                    <img src="../../upload_img/<?php echo $stmtD['M_img'];?>" alt="Admin Dashboards" style="width: auto;height: 100px"/>
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
                                if ($userT['T_status'] == '1' ) {
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
                                        <a href="showdata_room.php">ข้อมูลห้องเรียน</a>
                                    </li>
                                    <li>
                                        <a href="showdata_student.php" class="current-page">ข้อมูลนักศึกษา</a>
                                    </li>
                                    <li>
                                        <a href="showdata_request.php" >อนุมัติคำร้อง</a>
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
                    <a href="../index.php">ข้อมูลทั่วไป</a>
                </li>
                <li class="breadcrumb-item breadcrumb-active" aria-current="page">ข้อมูลนักศึกษา</li>
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
                                <span class="user-name d-none d-md-block"><?php echo $userT['T_fname']; ?></span>
                                <!-- รูปประจำตัว -->
                                <span class="avatar">
                                <img src="../img/<?php echo $userT['T_img'] ?>" alt="Admin Templates">
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
                <div class="search-container m-2">
                    <form action="showdata_student.php" method="get">
                        <!-- Search input group start -->
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="ค้นหาชื่อนักศึกษา"
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
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table m-0">
                            <thead>
                            <tr>
                                <th>รหัสนักศึกษา</th>
                                <th>ชื่อ</th>
                                <th>สกุล</th>
                                <th>สาขา</th>
                                <th>ระดับชั้น</th>
                                <th>ชั้น</th>
                                <th>ห้อง</th>
                                <th>ภาคเรียนที่ออกฝึกงาน</th>
                                <th>ปีการศึกษาที่ออกฝึกงาน</th>
                                <th>ครูที่ปรึกษา</th>
                                <th> </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if (empty($getstudentToID)) : ?>
                                <tr>
                                    <td colspan="12" class="text-center">ไม่มีข้อมูล</td>
                                </tr>
                            <?php else : ?>
                            <?php foreach ($getstudentToID as $student) : ?>
                                <tr>
                                    <th><?=$student['S_ID'];?></th>
                                    <td><?=$student['S_fname'];?></td>
                                    <td><?=$student['S_lname'];?></td>
                                    <td><?=$student['S_major'];?></td>
                                    <td><?=$student['R_level'];?></td>
                                    <td><?=$student['R_room'];?></td>
                                    <td><?=$student['R_level_numder'];?></td>
                                    <td><?=$student['S_enrollment_term'];?></td>
                                    <th><?=$student['S_enrollment_year'];?></th>
                                    <td><?=$student['T_fname'];?></td>

                                    <td>
<!--                                        <a href="editFrom_student.php?S_ID=--><?php //=$student['S_ID'];?><!--"><button class="btn btn-primary">แก้ไข</button></a>-->
<!--                                        <a href="services/delete_user.php?iduser=--><?php //=$student['S_ID'];?><!--"><button class="btn btn-danger">ลบ</button></a>-->
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>

                            </tbody>
                        </table>
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
                    window.location.href = 'showdata_department.php';
                }
            });
        }

    </script>
</body>
</html>