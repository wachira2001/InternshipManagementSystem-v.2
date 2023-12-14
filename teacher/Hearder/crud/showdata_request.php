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

$user = getuserT($conn,$_SESSION['username']);
$stmtD = getmajor($conn);
//$room = getroomall($conn);
$getselect = getselect($conn);
//print_r($getrequestall);

if (isset($_GET['search']) && $_GET['search'] != '') {
    // ประกาศตัวแปรรับค่าจากฟอร์ม
    $search = "%" . $_GET['search'] . "%";
    $getrequestall = getrequestallTOHsearch($conn,$_SESSION['data']['T_ID'],$search);
} else {
    // คิวรี่ข้อมูลมาแสดงตามปกติ *แสดงทั้งหมด
    $search = '';
    $getrequestall = getrequestallTOHsearch($conn,$_SESSION['data']['T_ID'],$search);
}
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
    <title>ข้อมูลห้องเรียน</title>
    <link rel="icon" type="image/png" href="../../../upload_img/<?php echo $stmtD['M_img'];?>">
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
                    <img src="../../../upload_img/<?php echo $stmtD['M_img'];?>" alt="Admin Dashboards" style="width: auto;height: 100px"/>
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
                                        <a href="showdata_major.php">ข้อมูลแผนก</a>
                                    </li>
                                    <li>
                                        <a href="showdata_teacher.php" >ข้อมูลบุคลากร</a>
                                    </li>
                                    <li>
                                        <a href="showdata_student.php">ข้อมูลนักศึกษา</a>
                                    </li>
                                    <li>
                                        <a href="showdata_room.php" class="current-page">ข้อมูลห้องเรียน</a>
                                    </li>
                                    <li>
                                        <a href="showdata_company.php" >ข้อมูลสถานประกอบการ</a>
                                    </li>
                                    <li>
                                        <a href="showdata_company.php" >อนุมัติคำร้อง</a>
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
                    <div class="search-container m-2">
                        <form action="showdata_request.php" method="get">
                            <!-- Search input group start -->
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" placeholder="ค้นหาชื่อสถานประกอบหรือชื่อนักศึกษา"
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
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title">รายการอนุมัติ</div>
                                </div>
                                <div class="card-body">

                                    <div class="table-responsive">
                                        <table class="table v-middle">
                                            <thead>
                                            <tr>
                                                <th>ชื่อนักศึกษา</th>
                                                <th>ชื่อสถานประกอบการ</th>
                                                <th>รหัสคำร้อง</th>
                                                <th>ระยะเวลาที่ออกฝึก</th>
                                                <th>วัน/เดือน/ปี เริ่ม - จบ ฝึก</th>
                                                <th>สถานนะ</th>
                                                <th>อนุมัต/ไม่อนุมัติ</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php if (empty($getrequestall)) : ?>
                                                <tr>
                                                    <td colspan="7" class="text-center">ไม่มีการอนุมัติคำขอ</td>
                                                </tr>
                                            <?php else : ?>
                                                <?php foreach ($getrequestall as $requestall) : ?>
                                                    <tr>
                                                        <td>
                                                            <div class="media-box">
                                                                <img src="../../../student/img/<?= $requestall['S_img']; ?>" class="media-avatar" alt="Bootstrap Gallery">
                                                                <div class="media-box-body">
                                                                    <div class="text-truncate"><?= $requestall['S_fname']; ?>  <?= $requestall['S_lname']; ?></div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="media-box">
                                                                <img src="../../../upload_img/<?= $requestall['C_img']; ?>" class="media-avatar" alt="Admin Themes">
                                                                <div class="media-box-body">
                                                                    <div class="text-truncate"><?= $requestall['C_name']; ?></div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td><?= $requestall['request_id']; ?></td>
                                                        <td><?= $requestall['months']; ?> เดือน</td>
                                                        <td><?= $requestall['RE_period']; ?></td>

                                                            <?php if ($requestall['RE_status'] == '1' && $requestall['RE_teacherH_opinion'] == '' ) {?>
                                                                <td>
                                                                        <span class="text-blue td-status"><i class="bi bi-clock-history"></i> รออนุมัติ</span>
                                                                </td>
                                                                <td>
                                                                    <button type="button" class="btn btn-primary" onclick="Approved(<?= $requestall['request_id']; ?>)">อนุมัติคำร้อง</button>
                                                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal<?= $requestall['request_id']; ?>">ไม่อนุมัติคำร้อง</button>
                                                                </td>
                                                            <?php } elseif ($requestall['RE_status'] == '2' && $requestall['RE_teacherH_opinion'] == '1' && $requestall['RE_teacher_opinion'] == '1') {?>
                                                                <td>
                                                                    <span class="text-green td-status"><i class="bi bi-check-circle"></i> อนุมัติ</span>
                                                                </td>
                                                                <td>
                                                                    <button type="button" class="btn btn-success" onclick="Cancel(<?= $requestall['request_id']; ?>)">ยกเลิก อนุมัติคำร้อง</button>
                                                                </td>

                                                            <?php } elseif ($requestall['RE_status'] == '0' && $requestall['RE_teacherH_opinion'] == '0' ) {?>
                                                                <td>
                                                                    <span class="text-red td-status"><i class="bi bi-x-circle"></i> ไม่อนุมัติ</span>
                                                                </td>
                                                                <td>
                                                                    <button type="button" class="btn btn-danger" onclick="Cancel(<?= $requestall['request_id']; ?>)">ยกเลิก ไม่อนุมัติคำร้อง</button>
                                                                </td>
                                                            <?php }?>

                                                    </tr>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="exampleModal<?= $requestall['request_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content align-self-center">
                                                                <div class="modal-header">
                                                                    <h3 class="modal-title text-danger text-center">ไม่อนุมัติคำร้อง</h3>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form method="post" id="insert">
                                                                        <div class="row">
                                                                            <div class="col-12">
                                                                                <div class="mb-12">
                                                                                    <label for="inputMessage2" class="form-label">เหตุผลไม่อนุมัติคำร้องของ <?= $requestall['S_fname']; ?>  <?= $requestall['S_lname']; ?></label>
                                                                                    <textarea class="form-control" id="RE_commentH<?= $requestall['request_id']; ?>" placeholder="กรุณาป้อนเหตุผล" rows="3" name="RE_commentH<?= $requestall['request_id']; ?>" required></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                                <div class="form-actions-footer">
                                                                    <button class="btn btn-light" type="button" onclick="showConfirmation()">ยกเลิก</button>
                                                                    <button class="btn btn-success" type="button" onclick="NOTApproved(<?= $requestall['request_id']; ?>)">ไม่อนุมัติคำร้อง</button>
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
                        </div>
                    </div>
                </div>
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
    <script src="../../services_teacher/update_request.php"></script>
    <script>
        //อนุมัติคำร้อง
        function Approved(request_id) {
            // ให้ถามก่อนที่จะส่งค่า
            Swal.fire({
                title: 'คุณแน่ใจหรือไม่?',
                text: 'คำร้องนี้จะถูกอนุมัติ',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'ใช่, อนุมัติ',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                // ถ้าผู้ใช้กด "ตกลง"
                if (result.isConfirmed) {
                    var RE_commentH = 'อนุมัติคำร้อง';
                    var RE_teacherH_opinion = '1';
                    var RE_status = '2';

                    $.ajax({
                        type: 'POST',
                        url: '../../services_teacher/update_request.php',
                        data: {
                            request_id: request_id,
                            RE_commentH: RE_commentH,
                            RE_teacherH_opinion: RE_teacherH_opinion,
                            RE_status : RE_status
                        },

                        success: function (response) {
                            if (response === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'อนุมัติคำร้องสำเร็จ',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(() => {
                                    window.location.href = 'showdata_request.php';
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'เกิดข้อผิดพลาดในอนุมัติคำร้องสำเร็จ อาจจะเป็นคีย์นอก',
                                    text: 'โปรดลองอีกครั้งหรือติดต่อผู้ดูแลระบบ',
                                });
                            }
                        },
                        error: function (xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'เกิดข้อผิดพลาดในการอนุมัติคำร้องสำเร็จ',
                                text: 'โปรดลองอีกครั้งหรือติดต่อผู้ดูแลระบบ',
                            });
                        }
                    });
                }
            });
        }
        //ไม่อนุมัติคำร้อง
        function NOTApproved(request_id) {
            // var RE_commentH = $('[name="RE_commentH"]').val();
            var RE_commentH = $('#RE_commentH' + request_id).val();
            var RE_teacherH_opinion = '0'
            var RE_status = '0'; // 0= ไม่ผ่านการอนุมัติ หัวหน้าแผนกไม่อนุมัติจะไม่ถึงให้ครูที่ปรึกษาอนุมัติ
            // ตรวจสอบว่า RE_commentH ไม่เป็นค่าว่างหรือไม่
            if (RE_commentH.trim() === '') {
                Swal.fire({
                    icon: 'error',
                    title: 'กรุณากรอกเหตุผลไม่อนุมัติคำร้อง',
                    showConfirmButton: true,
                });
                return;
            }


            $.ajax({
                type: 'POST',
                url: '../../services_teacher/update_request.php',
                data: {
                    request_id: request_id,
                    RE_commentH: RE_commentH,
                    RE_status: RE_status,
                    RE_teacherH_opinion: RE_teacherH_opinion
                },

                success: function (response) {
                    if (response === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'ไม่อนุมัติคำร้อง สำเร็จ',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href = 'showdata_room.php';
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาดในการไม่อนุมัติคำร้อง เนื่องจากเกิดข้อผิดพลาดบางอย่าง',
                            text: 'โปรดลองอีกครั้งหรือติดต่อผู้ดูแลระบบ',
                        });
                    }
                },
                error: function (xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาดในการไม่อนุมัติคำร้อง ',
                        text: 'โปรดลองอีกครั้งหรือติดต่อผู้ดูแลระบบ',
                    });
                }
            });
        }
        // ยกเลิกไม่อนุมัติคำร้อง/ยกเลิกอนุมัติ
        function Cancel(request_id) {
            // สร้าง Popup ถามยืนยัน
            Swal.fire({
                title: 'ยืนยันการยกเลิกไม่อนุมัติคำร้อง',
                text: 'คุณต้องการที่จะยกเลิกไม่อนุมัติคำร้องนี้หรือไม่?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ยืนยัน',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                // ถ้าผู้ใช้กด OK (ยืนยัน)
                if (result.isConfirmed) {
                    // ทำการส่งค่าผ่าน Ajax
                    var RE_commentH = '';
                    var RE_teacherH_opinion = '';
                    var RE_status = '1'; // 0= ไม่ผ่านการอนุมัติ หัวหน้าแผนกไม่อนุมัติจะไม่ถึงให้ครูที่ปรึกษาอนุมัติ
                    console.log({
                        request_id: request_id,
                        RE_commentH: RE_commentH,
                        RE_status: RE_status,
                        RE_teacherH_opinion: RE_teacherH_opinion
                    });
                    $.ajax({
                        type: 'POST',
                        url: '../../services_teacher/update_request.php',
                        data: {
                            request_id: request_id,
                            RE_commentH: RE_commentH,
                            RE_status: RE_status,
                            RE_teacherH_opinion: RE_teacherH_opinion
                        },
                        success: function (response) {
                            // การจัดการผลลัพธ์
                            if (response === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'ยกเลิก สำเร็จ',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(() => {
                                    window.location.href = 'showdata_request.php';
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'เกิดข้อผิดพลาด',
                                    text: 'ไม่สามารถยกเลิกไม่อนุมัติคำร้องได้',
                                });
                            }
                        },
                        error: function (xhr, status, error) {
                            // การจัดการข้อผิดพลาดจาก Ajax
                            Swal.fire({
                                icon: 'error',
                                title: 'เกิดข้อผิดพลาด',
                                text: 'ไม่สามารถยกเลิกไม่อนุมัติคำร้องได้',
                            });
                        }
                    });
                }
            });
        }
        //โชว์คอนเพิม
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
                    window.location.href = 'showdata_request.php';
                }
            });
        }
    </script>
</body>
</html>