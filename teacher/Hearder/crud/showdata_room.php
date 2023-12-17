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
$getTeacher = getTeacher($conn);

// กำหนดค่าในอาร์เรย์เพื่อเก็บเงื่อนไข
$conditions = array();

// ตรวจสอบและเพิ่มเงื่อนไขสำหรับแต่ละพารามิเตอร์
if (isset($_GET['R_ID']) && $_GET['R_ID'] != '') {
    $conditions[] = "room.R_ID = :R_ID";
}

if (isset($_GET['R_level']) && $_GET['R_level'] != '') {
    $conditions[] = "room.R_level = :R_level";
}

if (isset($_GET['R_level_number']) && $_GET['R_level_number'] != '') {
    $conditions[] = "room.R_level_number = :R_level_number";
}

if (isset($_GET['R_room']) && $_GET['R_room'] != '') {
    $conditions[] = "room.R_room = :R_room";
}

// สร้างคำสั่ง SQL
$sql = "SELECT room.*, teacher.T_fname, teacher.T_lname, teacher.T_ID, COUNT(student.R_ID) AS student_count
FROM room
INNER JOIN teacher ON room.T_ID = teacher.T_ID
LEFT JOIN student ON room.R_ID = student.R_ID
GROUP BY room.R_ID, teacher.T_ID;
";

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
                                    <li>
                                        <a href="showdata_teacher.php" >ข้อมูลบุคลากร</a>
                                    </li>
                                    <li>
                                        <a href="showdata_student.php" >ข้อมูลนักศึกษา</a>
                                    </li>
                                    <li>
                                        <a href="showdata_major.php">ข้อมูลแผนก</a>
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
                            <select class="form-select" id="inputIndustryType2" name="R_level_number">
                                <option value="">เลือกรหัสระดับชั้น</option>
                                <?php
                                // ตรวจสอบว่า R_level_number จาก GET ตรงกับตัวเลือกหรือไม่ ถ้าใช่ ให้ตั้งค่าเป็น selected
                                //                                    if (!empty($_GET['R_level_number'])) {
                                //                                        echo '<option value="' . $_GET['R_level_number'] . '" selected>' . $_GET['R_level_number'] . '</option>';
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
                            <button type="button" class="btn btn-primary bi bi-plus-circle" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                เพิ่มห้องเรียน
                            </button>
                        </div>
                    </div>
                </form>
                <p class="text-blue">
                    ผลการค้นหา รหัสห้องเรียน : <?php echo isset($_GET['R_ID']) && $_GET['R_ID'] !== "" ? $_GET['R_ID'] : 'ทุกรายการ'; ?>
                    ชั้น : <?php echo isset($_GET['R_level']) && $_GET['R_level'] !== "" ? $_GET['R_level'] : 'ทุกรายการ'; ?>
                    ระดับชั้น : <?php echo isset($_GET['R_level_number']) && $_GET['R_level_number'] !== "" ? $_GET['R_level_number'] : 'ทุกรายการ'; ?>
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
                                    <th>จำนวนนักเรียน</th>
                                    <th>ชื่อครูที่ปรึกษา</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach ($room as $rooms) { ?>
                                    <tr>
                                        <td><?= $rooms['R_ID']; ?></td>
                                        <td><?= $rooms['R_level']; ?></td>
                                        <td><?= $rooms['R_level_number']; ?></td>
                                        <td><?= $rooms['R_room']; ?></td>
                                        <td><?= $rooms['student_count']; ?></td>
                                        <td><?= $rooms['T_fname'] . ' ' . $rooms['T_lname']; ?></td>
                                        <td class="">
                                            <div class="actions">

                                                <a href="editFrom_room.php?R_ID=<?= $rooms['R_ID']; ?>" >
                                                    <i class="bi bi-pencil-square text-warning"></i>
                                                </a>
                                                <a href="#" onclick="Delete(<?= $rooms['R_ID']; ?>)">
                                                    <i class="bi bi-trash text-red"></i>
                                                </a>
                                            </div>
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
                    <!-- Modal -->
                    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-3 col-12">
                                                    <div class="m-0">
                                                        <label class="form-label">เลือกชั้น</label>
                                                        <select class="form-select" aria-label="Default select example" id="R_level">
                                                            <option selected="">-- เลือกชั้น --</option>
                                                            <option value="ปวช.">ปวช.</option>
                                                            <option value="ปวส.">ปวส.</option>
                                                        </select>
                                                    </div>
                                        </div>
                                        <div class="col-sm-3 col-12">
                                            <div class="m-0">
                                                <label class="form-label">เลือกระดับชั้น</label>
                                                <select class="form-select" aria-label="Default select example" id="R_level_number">
                                                    <option selected="">-- เลือกระดับชั้น --</option>
                                                    <option value="1">ปวช.1</option>
                                                    <option value="2">ปวช.2</option>
                                                    <option value="3">ปวช.3</option>
                                                    <option value="1">ปวส.1</option>
                                                    <option value="2">ปวส.2</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 col-12">
                                            <div class="m-0">
                                                <label class="form-label">เลือกห้อง</label>
                                                <select class="form-select" aria-label="Default select example" id="R_room">
                                                    <option selected="">-- เลือกห้อง --</option>
                                                    <option value="1">ห้อง 1</option>
                                                    <option value="2">ห้อง 2</option>
                                                    <option value="3">ห้อง 3</option>
                                                    <option value="4">ห้อง 4</option>
                                                    <option value="5">ห้อง 5</option>
                                                    <option value="6">ห้อง 6</option>
                                                    <option value="7">ห้อง 7</option>
                                                    <option value="8">ห้อง 8</option>
                                                    <option value="9">ห้อง 9</option>
                                                    <option value="10">ห้อง 10</option>
                                                    <option value="11">ห้อง 11</option>
                                                    <option value="12">ห้อง 12</option>
                                                    <option value="13">ห้อง 13</option>
                                                    <option value="14">ห้อง 14</option>
                                                    <option value="15">ห้อง 15</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-3 col-12">
                                            <div class="m-0">
                                                <label class="form-label">เลือกครูประจำห้อง</label>
                                                <select class="form-select" aria-label="Default select example" id="T_ID">
                                                    <option selected="">-- ครูประจำห้อง --</option>
                                                    <?php foreach ($getTeacher as $teacher) : ?>
                                                        <option value="<?php echo $teacher['T_ID']; ?>"><?php echo $teacher['T_fname']; ?></option>
                                                    <?php endforeach; ?>

                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="modal-footer">

                                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" onclick="showConfirmation()">ยกเลิก</button>
                                    <button type="button" class="btn btn-primary" onclick="Addroom()">เพิ่มห้อง</button>
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

    <!-- ไฟล์ JavaScript หลัก -->
    <script src="../../../assets/js/main.js"></script>

    <script src="../../../Function/showdata_room.js"> </script>

</body>
</html>