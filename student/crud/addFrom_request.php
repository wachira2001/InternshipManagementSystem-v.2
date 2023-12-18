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

if (!isset($_SESSION['username']) || ($_SESSION['role'] !== 'student')) {
    echo '
            <script>
            setTimeout(function() {
            swal({
                title: "คุณไม่มีสิทธิ์ใช้งานหน้านี้",
                type: "error"
            }, function() {
                window.location = "../../login.php"; // หน้าที่ต้องการให้กระโดดไป
            });
        }, 1000);
    </script>';
    exit();
}
$user = getuserS($conn, $_SESSION['username']);
$major = getmajor($conn);

if (isset($_GET['search']) && $_GET['search'] != '') {
    // ประกาศตัวแปรรับค่าจากฟอร์ม
    $search = "%" . $_GET['search'] . "%";

    // คิวรี่ข้อมูลมาแสดงจากการค้นหา
    $stmt = $conn->prepare("SELECT * FROM company WHERE C_name LIKE ?");
    $stmt->execute([$search]);
    $companys = $stmt->fetchAll();
} else {
    // คิวรี่ข้อมูลมาแสดงตามปกติ *แสดงทั้งหมด
    $companys = getCompanyToPetition($conn);
}


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
    <title>ยื่นคำร้องออกฝึกประสบการณ์วิชาชีพ</title>
    <link rel="icon" type="image/png" href="../../upload_img/<?php echo $major['M_img']; ?>">
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

        .card {
            height: 400px; /* กำหนดความสูงคงที่สำหรับการ์ด */
        }

        #imgs {
            object-fit: cover; /* ให้รูปภาพครอบคลุมพื้นที่ทั้งหมดของการ์ด */
            height: 200px; /* กำหนดความสูงคงที่สำหรับรูปภาพ */
            width: 100%; /* ทำให้รูปภาพครอบคลุมทั้งความกว้างของการ์ด */
        }
    </style>

    <link rel="stylesheet" href="../../assets/css/animate.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.3.4/sweetalert2.min.css">
    <link rel="stylesheet" href="../../assets/fonts/bootstrap/bootstrap-icons.css">
    <link rel="stylesheet" href="../../assets/css/main.min.css">
    <link rel="stylesheet" href="../../assets/vendor/overlay-scroll/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="../../assets/vendor/daterange/daterange.css">

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
                    <img src="../../upload_img/<?php echo $major['M_img']; ?>" alt="Admin Dashboards"
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
                        <a href="../index.php">
                            <i class="bi bi-house"></i>
                            <span class="menu-text">หน้าแรก</span>
                        </a>
                    </li>
                    <?php
                    // มื่อยืนคำร้องเสร็จ
                    if ($user['S_status'] == '1') {
                        ?>
                        <li>
                            <a href="CRUD/">ยื่นคำร้องออกฝึกงาน</a>
                        </li>

                        <?php
                    } else if ($user['S_status'] == '2') {
                        ?>
                        <li>
                            <a href="CRUD/">ยื่นคำร้องออกฝึกงาน</a>
                        </li>
                        <?php
                    } else {
                        ?>
                        <li class="">
                            <a href="addFrom_company.php">
                                <i class="bi bi-file-earmark-plus"></i>
                                <span class="menu-text">ลงทะเบียนสถานประกอบการ</span>
                            </a>
                        </li>
                        <li class="active-page-link">
                            <a href="addFrom_request.php">
                                <i class="bi bi-send-plus"></i>
                                <span class="menu-text">ยื่นคำร้องออกฝึกประสบการณ์วิชาชีพ</span>
                            </a>
                        </li>
                        <li class="">
                            <a href="show_status.php">
                                <i class="bi bi-clock-history"></i>
                                <span class="menu-text">เช็คสถานะ</span>
                            </a>
                        </li>

                        <?php
                    }
                    ?>
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
                    <i class="bi bi-send-plus"></i>
                    <a href="#">ยื่นคำร้องออกฝึกประสบการณ์วิชาชีพ</a>
                </li>
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
                                <span class="user-name d-none d-md-block"><?php echo $user['S_fname']; ?></span>
                                <!-- รูปประจำตัว -->
                                <span class="avatar">
                                <img src="../img/<?php echo $user['S_img']; ?>" alt="Admin Templates">
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
            <div class="content-wrapper">
                <div class="search-container m-2">
                    <form action="addFrom_request.php" method="get">
                        <!-- Search input group start -->
                        <div class="input-group">
                            <input type="text" class="form-control" name="search" placeholder="ค้นหาชื่อสถานประกอบการ"
                                   value="<?php if (isset($_GET['search'])) {
                                       echo $_GET['search'];
                                   } ?>">
                            <button class="btn" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">รายชื่อสถานประกอบการ</div>
                            </div>
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table class="table v-middle m-0">
                                        <thead>
                                        <tr>
                                            <th>ชื่อสถานประกอบการ</th>
                                            <th>เบอร์โทรศัพท์</th>
                                            <th>ชื่อผู้สอนงาน</th>
                                            <th>ตำแหน่งผู้สอนงาน</th>
                                            <th>ดู/ยื่นคำร้อง</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php if (empty($companys)) : ?>
                                            <tr>
                                                <td colspan="7" class="text-center"><center>
                                                        <h1>ไม่พบสถานประกอบการ  </h1>
                                                        <a href="addFrom_company.php">
                                                            <button  type="button" class="btn btn-info"><i class="bi bi-plus-square"></i> ลงทะเบียนสถานประกอบการ</button>
                                                        </a></center></td>
                                            </tr>
                                        <?php else : ?>
                                        <?php foreach ($companys as $company) : ?>
                                        <tr>
                                            <td>
                                                <div class="media-box">
                                                    <img src="../../upload_img/<?= $company['C_img']; ?>"
                                                         class="media-avatar" alt="Bootstrap Themes">
                                                    <div class="media-box-body">
                                                        <div class="text-truncate"><?= $company['C_name']; ?> </div>
                                                        <p>ID: <?= $company['company_ID']; ?></p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?= $company['C_telephone']; ?></td>
                                            <td><?= $company['C_staff_name']; ?></td>
                                            <td><?= $company['C_staff_position']; ?></td>
                                            <td>
                                                <div class="actions">
                                                    <a href="#" data-bs-toggle="offcanvas"
                                                       data-bs-target="#offcanvasExample<?= $company['company_ID']; ?>"
                                                       aria-controls="offcanvasExample">
                                                        <i class="bi bi-list text-green"> </i>
                                                    </a>
                                                    <a href="#" data-bs-toggle="modal"
                                                       data-bs-target="#staticBackdrop<?php echo $company['company_ID']; ?>">
                                                        <i class="bi bi-file-earmark-text text-blue" > </i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>

                                        <div class="modal fade" id="staticBackdrop<?php echo $company['company_ID']; ?>"
                                              data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                              aria-labelledby="staticBackdropLabel" style="display: none;" aria-hidden="true">
                                            <div class="modal-dialog modal-xl">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row container">
                                                            <div class="col-12">
                                                                <div class="form-section-title">
                                                                    รายละเอียดเกี่ยวกับสถานประกอบการ
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <label class="form-label">ชื่อสถานประกอบการ</label>
                                                                <input type="text" class="form-control"
                                                                       placeholder="Enter text"
                                                                       value="<?php echo $company['C_name']; ?>" readonly>
                                                            </div>
                                                            <div class="col-4 py-3">
                                                                <label class="form-label">ตำบล</label>
                                                                <input type="text" class="form-control"
                                                                       placeholder="Enter text"
                                                                       value="<?php echo $company['C_tambon']; ?>" readonly>
                                                            </div>
                                                            <div class="col-4 py-3">
                                                                <label class="form-label">อำเภอ</label>
                                                                <input type="text" class="form-control"
                                                                       placeholder="Enter text"
                                                                       value="<?php echo $company['C_amphoe']; ?>" readonly>
                                                            </div>
                                                            <div class="col-4 py-3">
                                                                <label class="form-label">จังหวัด</label>
                                                                <input type="text" class="form-control"
                                                                       placeholder="Enter text"
                                                                       value="<?php echo $company['C_province']; ?>"
                                                                       readonly>
                                                            </div>
                                                            <div class="col-6 py-1">
                                                                <label class="form-label">ผู้สอนงาน</label>
                                                                <input type="text" class="form-control"
                                                                       placeholder="Enter text"
                                                                       value="<?php echo $company['C_staff_name']; ?>"
                                                                       readonly>
                                                            </div>
                                                            <div class="col-6 py-1">
                                                                <label class="form-label">เบอร์โทรศัพท์</label>
                                                                <input type="text" class="form-control"
                                                                       placeholder="Enter text"
                                                                       value="<?php echo $company['C_staff_phone']; ?>"
                                                                       readonly>
                                                            </div>

                                                            <div class="col-12 py-3">
                                                                <div class="form-section-title">ป้อนรายละเอียดยื่นคำร้อง
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <form method="post" id="form-<?php echo $company['company_ID']; ?>"
                                                                      class="row d-flex justify-content-evenly">
                                                                    <div class="col-3">
                                                                        <?php $request_id = $user['S_ID'] . strval($company['company_ID']); ?>
                                                                        <label class="form-label">รหัสยื่นคำร้อง</label>
                                                                        <input type="text" class="form-control"
                                                                               placeholder="Enter text"
                                                                               value="<?php echo $request_id ?>"

                                                                               name="request_id" readonly>
                                                                    </div>
                                                                    <div class="col-3">
                                                                        <label class="form-label">ผู้ที่หาสถานประกอบการ</label>
                                                                        <input name="RE_how" type="text" class="form-control"
                                                                               placeholder="คุณรู้สักสถานประกอบการนี้ได้อย่างไร"
                                                                               required>
                                                                    </div>
                                                                    <div class="col-3 ">
                                                                        <div class="m-0">
                                                                            <div class="form-label">วัน/เดือน/ปี ที่ออกฝึก -
                                                                                วันจบการฝึก
                                                                            </div>
                                                                            <div class="input-group">
                                                                    <span class="input-group-text">
                                                                        <i class="bi bi-calendar4"></i>
                                                                    </span>
                                                                                <input type="text"
                                                                                       class="form-control datepicker-range-auto-apply"
                                                                                       name="RE_period"
                                                                                       placeholder="กรุณาป้อนวันที่ออกฝึกและสินสุดการฝึก"
                                                                                       required>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-3">
                                                                        <label class="form-label">ตำแหน่งที่ฝึกใน <?php echo $company['C_name']; ?> </label>
                                                                        <input type="text" class="form-control"
                                                                               placeholder="ป้อนตำแหน่งที่เข้ารับการฝึกประสบกาณ์วิชาชีพ"
                                                                               name="RE_position" required>
                                                                    </div>
                                                                    <div class="col-12 py-2">
                                                                        <label class="form-label">เหตุผลที่อยากฝึกที่ <?php echo $company['C_name']; ?> </label>
                                                                        <textarea type="text" class="form-control"
                                                                                  placeholder="กรุณาป้อนเหตุผลที่อยากฝึกที่สะถานประกอบการนี้"
                                                                                  name="RE_reason" required></textarea>

                                                                    </div>

                                                                    <input name="S_ID" type="hidden"
                                                                           value="<?php echo $user['S_ID']; ?>">
                                                                    <input name="company_ID" type="hidden"
                                                                           value="<?php echo $company['company_ID']; ?>">
                                                                    <input name="RE_status" type="hidden" value="1">
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-dark" data-bs-dismiss="modal">ยกเลิก
                                                                        </button>
                                                                        <button type="button" class="btn btn-success" onclick="saveDataRequest('<?php echo $company['company_ID']; ?>')">ยื่นคำร้อง</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>



                                        <div class="offcanvas offcanvas-start" tabindex="-1"
                                             id="offcanvasExample<?= $company['company_ID']; ?>"
                                             aria-labelledby="offcanvasExampleLabel">
                                            <div class="offcanvas-header">
                                                <h5 class="offcanvas-title" id="offcanvasExampleLabel">รายละเอียดของ <?= $company['C_name']; ?> </h5>
                                                <button type="button" class="btn-close text-reset"
                                                        data-bs-dismiss="offcanvas"
                                                        aria-label="Close">

                                                </button>
                                            </div>
                                            <div class="offcanvas-body">
                                                <div class="row ">
                                                    <div class="card">
                                                        <div class="col-12 py-3">
                                                            <img src="../../upload_img/<?= $company['C_img']; ?>"
                                                                 class="media-avatar rounded mx-auto d-block" alt="Bootstrap Themes" width="60%">
                                                        </div>
                                                        <div class="col-12 py-1">
                                                            <p>รหัสสถานประกอบการ : <?= $company['company_ID']; ?> </p>
                                                        </div>
                                                        <div class="col-12 py-1">
                                                            <p>ชื่อสถานประกอบการ : <?= $company['C_name']; ?></p>
                                                        </div>
                                                        <div class="col-12 py-1">
                                                            <p>เบอร์สถานประกอบการ : <?= $company['C_telephone']; ?> </p>
                                                        </div>
                                                        <div class="col-12 py-1">
                                                            <p>เว็บไซต์ : <?= $company['C_website']; ?>   </p>
                                                        </div>
                                                        <div class="col-12 py-1">
                                                            <p>ชื่อผู้สอนงาน : <?= $company['C_staff_name']; ?> </p>
                                                        </div>
                                                        <div class="col-12 py-1">
                                                            <p>ตำแหน่งผู้สอนงาน : <?= $company['C_staff_position']; ?> </p>
                                                        </div>
                                                        <div class="col-12 py-1">
                                                            <p>เบอร์ติดต่อผู้สอนงาน : <?= $company['C_staff_phone']; ?> </p>
                                                        </div>
                                                        <div class="col-12 py-1">
                                                            <p>ที่อยู่ของสถานประกอบการ  : ตำบล <?= $company['C_tambon']; ?> อำเภอ <?= $company['C_amphoe']; ?> จังหวัด <?= $company['C_province']; ?></p>
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
            <!-- ส่วนเริ่มต้นของคอนเทนเนอร์ -->
            <!-- เริ่มต้นของ App Footer -->
            <div class="app-footer">
                <span>สาขาเทคโนโลยีธุรกิจดิจิทัล</span>
            </div>
            <!-- ส่วนจบของ App Footer -->

        </div>
    </div>
</div>


<!-- ส่วนจบของคอนเทนเนอร์ -->

<!-- ส่วนจบของหน้า -->

<!-- เริ่มต้นของไฟล์ JavaScript ที่จำเป็น -->
<script src="../../assets/js/jquery.min.js"></script>
<script src="../../assets/js/bootstrap.bundle.min.js"></script>
<script src="../../assets/js/modernizr.js"></script>
<script src="../../assets/js/moment.js"></script>
<script src="../../assets/vendor/daterange/daterange.js"></script>
<script src="../../assets/vendor/daterange/custom-daterange.js"></script>

<!-- ไฟล์ JavaScript หลัก -->
<script src="../../assets/js/main.js"></script>
<script src="../../Function/addFrom_request.js"></script>
</body>
</html>
