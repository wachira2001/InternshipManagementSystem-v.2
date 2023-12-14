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
                window.location = "login.php"; // หน้าที่ต้องการให้กระโดดไป
            });
        }, 1000);
    </script>';
    exit();
}

$user = getuserT($conn,$_SESSION['username']);
$stmtD = getmajor($conn);
//$room = getroomToRID($conn,$_SESSION['data']['R_ID']);
//print_r($_SESSION['data']['R_ID']);
//return;
if (isset($_GET['search']) && $_GET['search'] != '') {
    // ประกาศตัวแปรรับค่าจากฟอร์ม
    $search = "%" . $_GET['search'] . "%";
    $room = getroomToRID($conn,$_SESSION['data']['R_ID'],$search);
} else {
    // คิวรี่ข้อมูลมาแสดงตามปกติ *แสดงทั้งหมด
    $search = '';
    $room = getroomToRID($conn,$_SESSION['data']['R_ID'],$search);
}

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
    <title>ข้อมูลห้อง</title>
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
                                        <a href="showdata_room.php" class="current-page">ข้อมูลห้องเรียน</a>
                                    </li>
                                    <li>
                                        <a href="showdata_student.php" >ข้อมูลนักศึกษา</a>
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
                    <a href="../../index.php">ข้อมูลทั่วไป</a>
                </li>
                <li class="breadcrumb-item breadcrumb-active" aria-current="page">ข้อมูลห้องเรียน</li>
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
                <div class="search-container m-2">
                    <form action="showdata_room.php" method="get">
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

                                <th>รหัสห้องเรียน</th>
                                <th>สาขา</th>
                                <th>ชั้น</th>
                                <th>ระดับชั้น</th>
                                <th>ลำดับห้อง</th>
                                <th>ปี</th>
                                <th>ชื่อนักเรียน</th>
                                <th>ชื่อครูที่ปรึกษา</th>
                                <th> </th>
                                <th> </th>
                                <th> </th>
                                <th> </th>
                                <th> </th>

                            </tr>
                            </thead>
                            <tbody>
                            <?php if (empty($room)) : ?>
                                <tr>
                                    <td colspan="13" class="text-center">ไม่พบข้อมูล</td>
                                </tr>
                            <?php else : ?>
                                <?php foreach ($room as $rooms) : ?>
                                <tr>
                                    <th><?=$rooms['R_ID'];?></th>
                                    <td><?=$rooms['S_major'];?></td>
                                    <td><?=$rooms['R_level'];?></td>
                                    <td><?=$rooms['R_level_numder'];?></td>
                                    <td><?=$rooms['R_room'];?></td>
                                    <td><?=$rooms['S_enrollment_year'];?></td>
                                    <td><?=$rooms['S_fname'];?></td>
                                    <td><?=$rooms['T_fname'];?></td>

                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>

                                    <td >
<!--                                        <a href="editFrom_room.php?R_ID=--><?php //=$rooms['R_ID'];?><!--"><button class="btn btn-primary">แก้ไข</button></a>-->
                                    </td>
                                </tr>
                                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#scrollable">
                                        Scrolling Content Modal
                                    </button>
                                    <div class="modal fade" id="scrollable" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="scrollableLabel" style="display: none;" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="scrollableLabel">Modal title</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    รายละเอียด
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">Understood</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
</body>
</html>