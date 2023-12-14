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
$user = getuserS($conn, $_SESSION['username']);
$major = getmajor($conn);
$S_ID = $_SESSION['data']['S_ID'];
$request = getrequest($conn,$S_ID);
print_r($request);

if (isset($_GET['search']) && $_GET['search'] != '') {
    // ประกาศตัวแปรรับค่าจากฟอร์ม
    $search = "%" . $_GET['search'] . "%";

    // คิวรี่ข้อมูลมาแสดงจากการค้นหา
    $stmt = $conn->prepare("SELECT * FROM company WHERE C_name LIKE ?");
    $stmt->execute([$search]);
    $company = $stmt->fetchAll();
} else {
    // คิวรี่ข้อมูลมาแสดงตามปกติ *แสดงทั้งหมด
    $company = getCompanyToPetition($conn);
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
        </style>

        <link rel="stylesheet" href="../../assets/css/animate.css">
        <link rel="stylesheet"
              href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.3.4/sweetalert2.min.css">
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

                <!-- ส่วนเริ่มต้นของคอนเทนเนอร์ -->
                <div class="content-wrapper">
                    <!-- Row start -->
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-center">
                                <h3>สถานะ</h3>
                            </div>

                            <?php if ($request['RE_status'] == '1' && $request['RE_teacher_opinion'] != '1') { ?>
                                <div class="card-body">
                                    <div class="custom-tabs-container">
                                        <ul class="nav nav-tabs" id="customTab3" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link active" id="tab-oneAA" data-bs-toggle="tab" href="#oneAA" role="tab" aria-controls="oneAA" aria-selected="true">
                                                    <img class="" src="../../img/verified.gif" alt="Verified Image" height="30px">
                                                    ยื่นคำร้องสำเร็จ
                                                </a>
                                            </li>

                                        </ul>
                                        <div class="tab-content" id="customTabContent3">
                                            <div class="tab-pane fade show active" id="oneAA" role="tabpanel" aria-labelledby="tab-oneAA">
                                                <div class="d-flex justify-content-center">
                                                    <img class="" src="../../img/verified.gif" alt="Verified Image" height="320">
                                                </div>
                                                <p style="font-size: 20px;text-align: center">ยื่นคำร้องสำเร็จ</p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            <?php } elseif ($request['RE_status'] == '1' && $request['RE_teacher_opinion'] == '1'  ) { ?>
                                <div class="card-body">
                                    <div class="custom-tabs-container">
                                        <ul class="nav nav-tabs" id="customTab3" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link " id="tab-oneAA" data-bs-toggle="tab" href="#oneAA" role="tab" aria-controls="oneAA" aria-selected="true">
                                                    <img class="" src="../../img/verified.gif" alt="Verified Image" height="30px">
                                                    ยื่นคำร้องสำเร็จ
                                                </a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link active" id="tab-twoAA" data-bs-toggle="tab" href="#twoAA" role="tab" aria-controls="twoAA" aria-selected="false" tabindex="-1">
                                                    <img class="" src="../../img/hiring.gif" alt="Verified Image" height="30px">
                                                    อาจารย์ที่ปรึกษา
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="customTabContent3">
                                            <div class="tab-pane fade " id="oneAA" role="tabpanel" aria-labelledby="tab-oneAA">
                                                    <div class="d-flex justify-content-center">
                                                        <img class="" src="../../img/verified.gif" alt="Verified Image" height="320">
                                                    </div>
                                                    <p style="font-size: 20px;text-align: center">ยื่นคำร้องสำเร็จ</p>
                                            </div>
                                            <div class="tab-pane fade show active" id="twoAA" role="tabpanel" aria-labelledby="tab-twoAA">
                                                <div class="d-flex justify-content-center">
                                                    <img class="" src="../../img/hiring.gif" alt="Verified Image" height="320">
                                                </div>
                                                <p style="font-size: 20px;text-align: center">อาจารย์ที่ปรึกษา อนุมัติคำร้องเรียบร้อย</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } elseif ($request['RE_status'] == '0' && $request['RE_teacher_opinion'] == '0'  ) { ?>
                                <div class="card-body">
                                    <div class="custom-tabs-container">
                                        <ul class="nav nav-tabs" id="customTab3" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link " id="tab-oneAA" data-bs-toggle="tab" href="#oneAA" role="tab" aria-controls="oneAA" aria-selected="true">
                                                    <img class="" src="../../img/verified.gif" alt="Verified Image" height="30px">
                                                    ยื่นคำร้องสำเร็จ
                                                </a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link active" id="tab-twoAA" data-bs-toggle="tab" href="#twoAA" role="tab" aria-controls="twoAA" aria-selected="false" tabindex="-1">
                                                    <img class="" src="../../img/hiring.gif" alt="Verified Image" height="30px">
                                                    อาจารย์ที่ปรึกษา
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="customTabContent3">
                                            <div class="tab-pane fade " id="oneAA" role="tabpanel" aria-labelledby="tab-oneAA">
                                                <div class="d-flex justify-content-center">
                                                    <img class="" src="../../img/verified.gif" alt="Verified Image" height="320">
                                                </div>
                                                <p style="font-size: 20px;text-align: center">ยื่นคำร้องสำเร็จ</p>
                                            </div>
                                            <div class="tab-pane fade show active" id="twoAA" role="tabpanel" aria-labelledby="tab-twoAA">
                                                <div class="d-flex justify-content-center">
                                                    <img class="" src="../../img/will.gif" alt="Verified Image" height="320">
                                                </div>
                                                <p style="font-size: 20px;text-align: center">อาจารย์ที่ปรึกษาไม่อนุมัติคำร้อง เนื่องจาก : <?php echo $request['RE_comment'] ?></p>
                                                <a href="addFrom_request.php" class="d-flex justify-content-center py-3">
                                                 <button type="button" class="btn btn-info"><i class="bi bi-plus-square"></i> ยื่นคำร้องออกฝึกประสบการณ์วิชาชีพ</button>
                                               </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } elseif ($request['RE_status'] == '2' && $request['RE_teacher_opinion'] == '1' && $request['RE_teacherH_opinion'] == '1') { ?>
                                <div class="card-body">
                                    <div class="custom-tabs-container">
                                        <ul class="nav nav-tabs" id="customTab3" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link " id="tab-oneAA" data-bs-toggle="tab" href="#oneAA" role="tab" aria-controls="oneAA" aria-selected="true">
                                                    <img class="" src="../../img/verified.gif" alt="Verified Image" height="30px">
                                                    ยื่นคำร้องสำเร็จ
                                                </a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link " id="tab-twoAA" data-bs-toggle="tab" href="#twoAA" role="tab" aria-controls="twoAA" aria-selected="false" tabindex="-1">
                                                    <img class="" src="../../img/hiring.gif" alt="Verified Image" height="30px">
                                                    อาจารย์ที่ปรึกษา
                                                </a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link active" id="tab-threeAA" data-bs-toggle="tab" href="#threeAA" role="tab" aria-controls="threeAA" aria-selected="false" tabindex="-1">
                                                    <img class="" src="../../img/hiringH.gif" alt="Verified Image" height="30px">
                                                    หัวหน้าแผนก
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="customTabContent3">
                                            <div class="tab-pane fade " id="oneAA" role="tabpanel" aria-labelledby="tab-oneAA">
                                                <div class="d-flex justify-content-center">
                                                    <img class="" src="../../img/verified.gif" alt="Verified Image" height="320">
                                                </div>
                                                <p style="font-size: 20px;text-align: center">ยื่นคำร้องสำเร็จ</p>
                                            </div>
                                            <div class="tab-pane fade " id="twoAA" role="tabpanel" aria-labelledby="tab-twoAA">
                                                <div class="d-flex justify-content-center">
                                                    <img class="" src="../../img/hiring.gif" alt="Verified Image" height="320">
                                                </div>
                                                <p style="font-size: 20px;text-align: center">อาจารย์ที่ปรึกษา อนุมัติคำร้องเรียบร้อย</p>
                                            </div>

                                            <div class="tab-pane fade show active" id="threeAA" role="tabpanel" aria-labelledby="tab-threeAA">
                                                <div class="d-flex justify-content-center">
                                                    <img class="" src="../../img/hiringH.gif" alt="Verified Image" height="320">
                                                </div>
                                                <p style="font-size: 20px;text-align: center">หัวหน้าแผนก อนุมัติคำร้องเรียบร้อย</p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } elseif ($request['RE_status'] == '0' && $request['RE_teacher_opinion'] == '1' && $request['RE_teacherH_opinion'] == '0') { ?>
                                <div class="card-body">
                                    <div class="custom-tabs-container">
                                        <ul class="nav nav-tabs" id="customTab3" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link " id="tab-oneAA" data-bs-toggle="tab" href="#oneAA" role="tab" aria-controls="oneAA" aria-selected="true">
                                                    <img class="" src="../../img/verified.gif" alt="Verified Image" height="30px">
                                                    ยื่นคำร้องสำเร็จ
                                                </a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link " id="tab-twoAA" data-bs-toggle="tab" href="#twoAA" role="tab" aria-controls="twoAA" aria-selected="false" tabindex="-1">
                                                    <img class="" src="../../img/hiring.gif" alt="Verified Image" height="30px">
                                                    อาจารย์ที่ปรึกษา
                                                </a>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <a class="nav-link active" id="tab-threeAA" data-bs-toggle="tab" href="#threeAA" role="tab" aria-controls="threeAA" aria-selected="false" tabindex="-1">
                                                    <img class="" src="../../img/hiringH.gif" alt="Verified Image" height="30px">
                                                    หัวหน้าแผนก
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="customTabContent3">
                                            <div class="tab-pane fade " id="oneAA" role="tabpanel" aria-labelledby="tab-oneAA">
                                                <div class="d-flex justify-content-center">
                                                    <img class="" src="../../img/verified.gif" alt="Verified Image" height="320">
                                                </div>
                                                <p style="font-size: 20px;text-align: center">ยื่นคำร้องสำเร็จ</p>
                                            </div>
                                            <div class="tab-pane fade " id="twoAA" role="tabpanel" aria-labelledby="tab-twoAA">
                                                <div class="d-flex justify-content-center">
                                                    <img class="" src="../../img/will.gif" alt="Verified Image" height="320">
                                                </div>
                                                <p style="font-size: 20px;text-align: center">อาจารย์ที่ปรึกษา อนุมัติคำร้องเรียบร้อย</p>
                                            </div>

                                            <div class="tab-pane fade show active" id="threeAA" role="tabpanel" aria-labelledby="tab-threeAA">
                                                <div class="d-flex justify-content-center">
                                                    <img class="" src="../../img/will.gif" alt="Verified Image" height="320">
                                                </div>
                                                <p style="font-size: 20px;text-align: center">หัวหน้าแผนก ไม่อนุมัติคำร้อง เนื่องจาก : <?php echo $request['RE_commentH'] ?></p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>

                        </div>
                    </div>
                    <!-- ส่วนจบของคอนเทนเนอร์ -->
                </div>

                <!-- เริ่มต้นของ App Footer -->
                <div class="app-footer">
                    <span>สาขาเทคโนโลยีธุรกิจดิจิทัล</span>
                </div>
                <!-- ส่วนจบของ App Footer -->

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
                            window.location.href = '../crud/addFrom_request.php';
                        }
                    });
                }

                function saveData() {
                    Swal.fire({
                        title: 'คุณแน่ใจหรือไม่?',
                        text: 'ที่จะแก้ไขข้อมูล',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'ใช่, บันทึก!',
                        cancelButtonText: 'ยกเลิก'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.querySelector('#forms').submit();
                        }
                    });
                }

            </script>
    </body>
    </html>
<?php
require_once '../services_student/insert_request.php';
?>