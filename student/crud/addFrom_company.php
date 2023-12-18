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
                window.location = "login.php"; // หน้าที่ต้องการให้กระโดดไป
            });
        }, 1000);
    </script>';
    exit();
}
$user = getuserS($conn,$_SESSION['username']);
$major = getmajor($conn);

$stmt = $conn->prepare("SELECT company_ID FROM company ORDER BY company_ID DESC LIMIT 1");
$stmt->execute();
// ดึงข้อมูลแบบ associative array
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result !== false) {
    // ดึงรหัสปัจจุบัน
    $currentCode = $result['company_ID'];

    // แยกตัวเลขจากรหัส
    $numericPart = (int)substr($currentCode, 1);

    // เพิ่มขึ้นไป 1
    $newNumericPart = $numericPart + 1;

    // สร้างรหัสใหม่ (เปลี่ยนตัวเลขเป็นตัวอักษรทั้งหมด)
    $newCode = 'C' . strtoupper(str_pad($newNumericPart, strlen($currentCode) - 1, '0', STR_PAD_LEFT));

} else {
    // กรณีไม่มีข้อมูล
    $newCode = 'C0001';

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
        <title>ลงทะเบียนสถานประกอบการ</title>
        <link rel="icon" type="image/png" href="../../upload_img/<?php echo $major['M_img'];?>">
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
                <a href="../index.php" class="logo">
                <span class="avatar">
                    <img src="../../upload_img/<?php echo $major['M_img'];?>" alt="Admin Dashboards" style="width: auto;height: 100px"/>
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
                            <li class="active-page-link">
                                <a href="addFrom_company.php">
                                    <i class="bi bi-file-earmark-plus"></i>
                                    <span class="menu-text">ลงทะเบียนสถานประกอบการ</span>
                                </a>
                            </li>
                            <li class="">
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
                        <i class="bi bi-file-earmark-plus"></i>
                        <a href="#">ลงทะเบียนสถานประกอบการ</a>
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

                    <!-- Row start -->
                    <div class="row">
                        <div class="col-sm-12 col-12">

                            <!-- Card start -->
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title">ลงทะเบียนสถานประกอบการที่นักศึกษาที่จะไปฝึกประสบการณ์</div>
                                </div>
                                <div class="card-body">
                                    <form method="post" enctype="multipart/form-data" id="FormAddCompany">
                                        <!-- Row start -->
                                        <div class="row m-auto">
                                            <div class="col-6">
                                                <label for="inputName" class="form-label">รหัสสถานประกอบการ</label>
                                                <input type="text" class="form-control" id="inputName"
                                                       placeholder="กรุณาป้อนรหัสสถานประกอบการ" name="company_ID" value="<?php echo $newCode ?>" maxlength="5" readonly>
                                            </div>

                                            <div class="col-6">
                                                <label for="inputName" class="form-label">ชื่อสถานประกอบการ</label>
                                                <input type="text" class="form-control" id="inputName"
                                                       placeholder="กรุณาป้อนชื่อสถานประกอบการ" name="C_name" maxlength="50" required>
                                            </div>

                                            <div class="col-4 py-2">
                                                <label for="inputName" class="form-label">ตำบล</label>
                                                <input type="text" class="form-control" id="inputName"
                                                       placeholder="กรุณาป้อนตำบล" name="C_tambon" maxlength="50" required>
                                            </div>

                                            <div class="col-4 py-2">
                                                <label for="inputName" class="form-label">อำเภอ</label>
                                                <input type="text" class="form-control" id="inputName"
                                                       placeholder="กรุณาป้อนอำเภอ" name="C_amphoe" maxlength="50" required>
                                            </div>

                                            <div class="col-4 py-2">
                                                <label for="inputName" class="form-label">จังหวัด</label>
                                                <input type="text" class="form-control" id="inputName"
                                                       placeholder="กรุณาป้อนจังหวัด" name="C_province" maxlength="50" required>
                                            </div>

                                            <div class="col-4 py-2">
                                                <label for="inputName" class="form-label">เบอร์โทรศัพท์</label>
                                                <input type="tel" class="form-control" id="inputName"
                                                       placeholder="กรุณาป้อนเบอร์โทรศัพท์" name="C_telephone" maxlength="10" required>
                                            </div>
                                            <div class="col-4 py-2">
                                                <label for="inputName" class="form-label">เว็บไซร์ของสถานประกอบการ</label>
                                                <input type="url" class="form-control" id="inputName"
                                                       placeholder="กรุณาป้อนเว็บไซร์ของสถานประกอบการ" name="C_website" required>
                                            </div>
                                            <div class="col-4 py-2">
                                                <label for="inputName" class="form-label">ชื่อ-สกุล ผู้ฝึกสอนงาน</label>
                                                <input type="text" class="form-control" id="inputName"
                                                       placeholder="กรุณาป้อนชื่อ-สกุล ผู้ฝึกสอนงาน" name="C_staff_name" required>
                                            </div>
                                            <div class="col-4 py-2">
                                                <label for="inputName" class="form-label">ตำแหน่งผู้ฝึกสอนงาน</label>
                                                <input type="text" class="form-control" id="inputName"
                                                       placeholder="กรุณาป้อนตำแหน่งผู้ฝึกสอนงาน" name="C_staff_position" required>
                                            </div>
                                            <div class="col-4 py-2">
                                                <label for="inputName" class="form-label">เบอร์ติดต่อ ผู้ฝึกสอนงาน</label>
                                                <input type="tel" class="form-control" id="inputName"
                                                       placeholder="กรุณาป้อนเบอร์ติดต่อผู้ฝึกสอนงาน" name="C_staff_phone" maxlength="10" required>
                                            </div>
                                            <div class="col-4 py-2">
                                                <label for="inputName" class="form-label">รูปบริษัท</label>
                                                <input type="file" class="form-control" id="inputName"
                                                        name="C_img" accept="image/jpeg, image/png, image/jpg" required>
                                            </div>
                                        </div>
                                        <!-- Row end -->
                                        <!-- Form actions footer start -->
                                        <div class="form-actions-footer">
                                            <button class="btn btn-light" onclick="showConfirmation()">ยกเลิก</button>
                                            <button class="btn btn-success" type="submit">ลงทะเบียน</button>
                                        </div>
                                        <!-- Form actions footer end -->
                                    </form>




                                </div>
                            </div>
                            <!-- Card end -->

                        </div>

                    </div>
                    <!-- Row end -->

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

        <script src="../../Function/addFrom_company.js"></script>

        <!-- ไฟล์ JavaScript หลัก -->
        <script src="../../assets/js/main.js"></script>

    </body>
    </html>
