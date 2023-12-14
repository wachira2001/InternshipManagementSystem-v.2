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

// กำหนดค่าในอาร์เรย์เพื่อเก็บเงื่อนไข
$conditions = array();

// ตรวจสอบและเพิ่มเงื่อนไขสำหรับแต่ละพารามิเตอร์
if (isset($_GET['R_ID']) && $_GET['R_ID'] != '') {
    $conditions[] = "room.R_ID = :R_ID";
}

if (isset($_GET['R_level']) && $_GET['R_level'] != '') {
    $conditions[] = "room.R_level = :R_level";
}

if (isset($_GET['R_level_numder']) && $_GET['R_level_numder'] != '') {
    $conditions[] = "room.R_level_numder = :R_level_numder";
}

if (isset($_GET['R_room']) && $_GET['R_room'] != '') {
    $conditions[] = "room.R_room = :R_room";
}

// สร้างคำสั่ง SQL
$sql = "SELECT room.*, student.S_fname, student.S_lname, teacher.T_fname, teacher.T_lname, student.S_enrollment_year
        FROM room
        LEFT JOIN student ON room.R_ID = student.R_ID
        LEFT JOIN teacher ON room.R_ID = teacher.R_ID";

// เพิ่ม WHERE clause หากมีเงื่อนไข
if (!empty($conditions)) {
    $sql .= " WHERE " . implode(" AND ", $conditions);
}

// เตรียมและประมวลผลคำสั่ง
$stmt = $conn->prepare($sql);

// ผูกพารามิเตอร์หากมีเงื่อนไข
if (!empty($conditions)) {
    foreach ($conditions as $key => $condition) {
        // ดึงชื่อพารามิเตอร์โดยตรงจากเงื่อนไข
        $param_name = ":" . substr($condition, strpos($condition, ':') + 1);
        // ผูกพารามิเตอร์
        $stmt->bindParam($param_name, $_GET[substr($param_name, 1)]);
    }
}

// ประมวลผลคำสั่ง
$stmt->execute();

// ดึงผลลัพธ์
$room = $stmt->fetchAll();

// ตรวจสอบว่ามีข้อมูลหรือไม่
if (count($room) > 0) {
    // แสดงข้อมูล
    foreach ($room as $rooms) {
        // แสดงข้อมูลตามที่ต้องการ
    }
} else {

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
                                        <a href="showdata_request.php" >อนุมัติคำร้อง</a>
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
                <form method="get" action="showdata_room.php" id="searchForm">
                    <div class="row d-flex justify-content-center" >
                        <div class="col-2 mb-3">
                            <label for="inputIndustryType2" class="form-label">เลือกรหัสห้อง</label>
                            <select class="form-select" id="inputIndustryType2" name="R_ID">
                                <option value="">เลือกห้อง</option>
                                <?php
                                // ตรวจสอบว่า R_ID จาก GET ตรงกับตัวเลือกหรือไม่ ถ้าใช่ ให้ตั้งค่าเป็น selected
                                //                                    if (!empty($_GET['R_ID'])) {
                                //                                        echo '<option value="' . $_GET['R_ID'] . '" selected>' . $_GET['R_ID'] . '</option>';
                                //                                    }
                                ?>
                                <?php echo $getselect['0'] ?>
                            </select>
                        </div>
                        <div class="col-2 mb-3">
                            <label for="inputIndustryType2" class="form-label">เลือกชั้น</label>
                            <select class="form-select" id="inputIndustryType2" name="R_level">
                                <option value="">เลือกชั้น</option>
                                <?php
                                // ตรวจสอบว่า R_level จาก GET ตรงกับตัวเลือกหรือไม่ ถ้าใช่ ให้ตั้งค่าเป็น selected
                                //                                    if (!empty($_GET['R_level'])) {
                                //                                        echo '<option value="' . $_GET['R_level'] . '" selected>' . $_GET['R_level'] . '</option>';
                                //                                    }
                                echo $getselect['1'];
                                ?>
                            </select>
                        </div>
                        <div class="col-2 mb-3">
                            <label for="inputIndustryType2" class="form-label">เลือกรหัสระดับชั้น</label>
                            <select class="form-select" id="inputIndustryType2" name="R_level_numder">
                                <option value="">เลือกรหัสระดับชั้น</option>
                                <?php
                                // ตรวจสอบว่า R_level_numder จาก GET ตรงกับตัวเลือกหรือไม่ ถ้าใช่ ให้ตั้งค่าเป็น selected
                                //                                    if (!empty($_GET['R_level_numder'])) {
                                //                                        echo '<option value="' . $_GET['R_level_numder'] . '" selected>' . $_GET['R_level_numder'] . '</option>';
                                //                                    }
                                echo $getselect['2'];
                                ?>
                            </select>
                        </div>
                        <div class="col-2 mb-3">
                            <label for="inputIndustryType2" class="form-label">เลือกห้อง</label>
                            <select class="form-select" id="inputIndustryType2" name="R_room">
                                <option value="">เลือกห้อง</option>
                                <?php
                                // ตรวจสอบว่า R_room จาก GET ตรงกับตัวเลือกหรือไม่ ถ้าใช่ ให้ตั้งค่าเป็น selected
                                //                                    if (!empty($_GET['R_room'])) {
                                //                                        echo '<option value="' . $_GET['R_room'] . '" selected>' . $_GET['R_room'] . '</option>';
                                //                                    }
                                echo $getselect['3'];
                                ?>
                            </select>
                        </div>
                        <div class="col-3 mb-3 py-4">
                            <button class="btn btn-light  bi bi-folder2" type="submit"> ค้นหา</button> &nbsp;
                            <button type="button" class="btn btn-primary bi bi-plus-circle" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                เพิ่มห้องเรียน
                            </button>
                        </div>
                    </div>
                </form>
                <p class="text-blue">
                    ผลการค้นหา รหัสห้องเรียน : <?php echo isset($_GET['R_ID']) && $_GET['R_ID'] !== "" ? $_GET['R_ID'] : 'ทุกรายการ'; ?>
                    ชั้น : <?php echo isset($_GET['R_level']) && $_GET['R_level'] !== "" ? $_GET['R_level'] : 'ทุกรายการ'; ?>
                    ระดับชั้น : <?php echo isset($_GET['R_level_numder']) && $_GET['R_level_numder'] !== "" ? $_GET['R_level_numder'] : 'ทุกรายการ'; ?>
                    ห้อง : <?php echo isset($_GET['R_room']) && $_GET['R_room'] !== "" ? $_GET['R_room'] : 'ทุกรายการ'; ?>
                </p>

                <div class="card-body">
                    <div class="table-responsive">
                        <?php
                        // ตรวจสอบว่ามีข้อมูลห้องเรียนหรือไม่
                        if (count($room) > 0) {
                            ?>
                            <table class="table m-0">
                                <thead>
                                <tr>
                                    <th>รหัสห้องเรียน</th>
                                    <th>ชั้น</th>
                                    <th>ระดับชั้น</th>
                                    <th>ห้อง</th>
                                    <th>ปี</th>
                                    <th>ชื่อนักเรียน</th>
                                    <th>ชื่อครูที่ปรึกษา</th>
                                    <th>การจัดการ</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($room as $rooms) { ?>
                                    <tr>
                                        <td><?= $rooms['R_ID']; ?></td>
                                        <td><?= $rooms['R_level']; ?></td>
                                        <td><?= $rooms['R_level_numder']; ?></td>
                                        <td><?= $rooms['R_room']; ?></td>
                                        <td><?= $rooms['S_enrollment_year']; ?></td>
                                        <td><?= $rooms['S_fname'] . ' ' . $rooms['S_lname']; ?></td>
                                        <td><?= $rooms['T_fname'] . ' ' . $rooms['T_lname']; ?></td>
                                        <td class="">
                                            <button class="btn btn-danger" onclick="deleteUser(<?= $rooms['R_ID']; ?>)">ลบ</button> <dr>
                                            <a href="editFrom_room.php?R_ID=<?= $rooms['R_ID']; ?>">
                                                <button class="btn btn-primary ml-2">แก้ไข</button>
                                            </a>
                                            <!-- เพิ่มปุ่มหรือลิงก์อื่น ๆ ตามต้องการ -->
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                            <?php
                        } else {
                            // ถ้าไม่มีข้อมูลที่ตรงตามเงื่อนไข
                            echo '<h1 class="text-danger text-center py-5">ไม่พบข้อมูล</h1>';
                        }
                        ?>
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
<!--    <script src="../../../assets/vendor/overlay-scroll/jquery.overlayScrollbars.min.js"></script>-->
<!--    <script src="../../../assets/vendor/overlay-scroll/custom-scrollbar.js"></script>-->
<!--    <script src="../../../assets/vendor/apex/apexcharts.min.js"></script>-->
<!--    <script src="../../../assets/vendor/apex/custom/sales/salesGraph.js"></script>-->
<!--    <script src="../../../assets/vendor/apex/custom/sales/revenueGraph.js"></script>-->
<!--    <script src="../../../assets/vendor/apex/custom/sales/taskGraph.js"></script>-->


    <!-- ไฟล์ JavaScript หลัก -->
    <script src="../../../assets/js/main.js"></script>
    <script>
        function deleteUser(R_ID) {
            Swal.fire({
                title: 'คุณแน่ใจหรือไม่?',
                text: 'คุณต้องการลบข้อมูลนี้หรือไม่?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'ใช่, ลบ!'
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteUserData(R_ID);
                }
            });
        }

        function deleteUserData(R_ID) {
            $.ajax({
                type: 'POST',
                url: '../../services_teacher/delete_room.php',
                data: { R_ID: R_ID },
                success: function(response) {
                    if (response === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'ลบข้อมูลสำเร็จ',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.href = 'showdata_room.php';
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'เกิดข้อผิดพลาดในการลบข้อมูลเนื่องจากมีดารเชื่อมคีย์นอกแล้ว',
                            text: 'โปรดลองอีกครั้งหรือติดต่อผู้ดูแลระบบ',
                        });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'เกิดข้อผิดพลาดในการลบข้อมูล',
                        text: 'โปรดลองอีกครั้งหรือติดต่อผู้ดูแลระบบ',
                    });
                }
            });
        }
    </script>
    <script>
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
                    window.location.href = 'showdata_room.php';
                }
            });
        }
        function saveData() {
            Swal.fire({
                title: 'คุณแน่ใจหรือไม่?',
                text: 'ที่จะบันทึกการแก้ไขข้อมูล',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่, บันทึก!',
                cancelButtonText: 'ยกเลิก'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.querySelector('#insert').submit();
                }
            });
        }

    </script>
    <?php
    include_once '../../services_teacher/insert_room.php';
    $conn = null;
    ?>
</body>
</html>