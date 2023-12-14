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
        <title>แก้ไขข้อมูลโปรไฟล์</title>
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
                            <li class="">
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
                <ol class="breadcrumb d-md-flex d-none" >
                    <li class="breadcrumb-item">
                        <i class="bi bi-house"></i>
                        <a href="#">แก้ไขข้อมูลส่วนตัว</a>
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

                    <div class="row">
                        <form method="post" enctype="multipart/form-data">

                            <div class="col-12">
                                <div>
                                    <center>
                                        <img id="previewImage" src="../img/<?php echo $user['S_img'] ?>" alt="Preview Image" class="col-12 start-50"
                                             style="height: 300px; width: auto; ">
                                    </center>

                                </div>
                                <div>
                                    <div class="mb-3">
                                        <label for="formFile" class="form-label">อัพโหลดรูป</label>
                                        <input class="form-control" type="file" id="imageInput" accept="image/*" name="S_img">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title">
                                            ข้อมูลของ <?php echo $user['S_fname'] ?> <?php echo $user['S_lname'] ?>  </div>
                                    </div>
                                    <div class="card-body py-4">

                                        <!-- Row start -->
                                        <div class="row ">
                                            <div class="col-12 text-center">
                                                <div class="form-section-title">รายละเอียดส่วนบุคคล</div>
                                            </div>
                                            <div class="col-3">
                                                <label for="inputName" class="form-label">รหัสนักศึกษา</label>
                                                <input type="text" class="form-control" id="inputName" name="S_ID"
                                                       placeholder="รหัสนักศึกษา"
                                                       value="<?= $user['S_ID']; ?>" readonly>
                                            </div>
                                            <div class="col-3">
                                                <label for="inputName" class="form-label">ชื่อ</label>
                                                <input type="text" class="form-control" id="inputName" name="S_fname"
                                                       placeholder="ชื่อ"
                                                       value="<?= $user['S_fname']; ?>" >
                                            </div>
                                            <div class="col-3">
                                                <label for="inputName" class="form-label">นามสกุล</label>
                                                <input type="text" class="form-control" id="inputName" name="S_lname"
                                                       placeholder="นามสกุล"
                                                       value="<?= $user['S_lname']; ?>" >
                                            </div>

                                            <div class="col-3 ">
                                                <label for="inputName" class="form-label">เพศ</label>
                                                <select class="form-select" id="inputName" name="S_gender" >
                                                    <option value="หญิง" <?= ($user['S_gender'] == 'หญิง') ? 'selected' : ''; ?>>
                                                        หญิง
                                                    </option>
                                                    <option value="ชาย" <?= ($user['S_gender'] == 'ชาย') ? 'selected' : ''; ?>>
                                                        ชาย
                                                    </option>
                                                    <option value="ไม่ระบุ" <?= ($user['S_gender'] == 'ไม่ระบุ') ? 'selected' : ''; ?>>
                                                        ไม่ระบุ
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col-3 py-3">

                                                <label for="inputName" class="form-label">วัน/เดือน/ปีเกิด</label>
                                                <input type="date" class="form-control" id="inputName" name="S_birthday"
                                                       placeholder="วัน/เดือน/ปีเกิด"
                                                       value="<?= $user['S_birthday']; ?>" >

                                            </div>

                                            <div class="col-3 py-3">
                                                <label for="inputName" class="form-label">หมายเลขโทรศัพท์</label>
                                                <input type="tel" class="form-control" id="inputName" name="S_phone"
                                                       placeholder="หมายเลขโทรศัพท์"
                                                       value="<?= $user['S_phone']; ?>">

                                            </div>
                                            <div class="col-3 py-3">
                                                <label for="inputName" class="form-label">E-mail</label>
                                                <input type="email" class="form-control" id="inputName" name="S_email"
                                                       placeholder="E-mail"
                                                       value="<?= $user['S_email']; ?>" readonly>

                                            </div>
                                            <div class="col-3 py-3">
                                                <label for="inputName" class="form-label">เกรดเฉลี่ย</label>
                                                <input type="text" class="form-control" id="inputName" name="S_gpa"
                                                       placeholder="เกรดเฉลี่ย"
                                                       value="<?= $user['S_gpa']; ?>">

                                            </div>
                                            <div class="col-2 py-3">
                                                <label for="inputName" class="form-label">ภาคเรียนที่ออกฝึกงาน</label>
                                                <input type="text" class="form-control" id="inputName" name="S_enrollment_term"
                                                       placeholder="เกรดเฉลี่ย"
                                                       value="<?= $user['S_enrollment_term']; ?>" >

                                            </div>
                                            <div class="col-2 py-3">
                                                <label for="inputName" class="form-label">ปีการศึกษาที่ออกฝึกงาน</label>
                                                <input type="text" class="form-control" id="inputName" name="S_enrollment_year"
                                                       placeholder="ปีการศึกษาที่ออกฝึกงาน"
                                                       value="<?= $user['S_enrollment_year']; ?>" >

                                            </div>
                                            <div class="col-3 py-3">
                                                <label for="inputName" class="form-label">แผนกสาขาวิชา</label>
                                                <input type="text" class="form-control" id="inputName" name="S_major"
                                                       placeholder="แผนก"
                                                       value="<?= $user['S_major']; ?>" readonly>

                                            </div>
                                            <div class="col-2 py-3">
                                                <label for="inputName" class="form-label">ระดับชั้น</label>
                                                <input type="text" class="form-control" id="inputName" name="S_level"
                                                       placeholder="ระดับชั้น"
                                                       value="<?= $user['S_level']; ?>" readonly>

                                            </div>



                                            <div class="col-3 py-3">
                                                <label for="inputName" class="form-label">ครูที่ปรึกษา</label>
                                                <input type="text" class="form-control" id="inputName" name="advisor_teacher_name" placeholder="ครูที่ปรึกษา"
                                                       value="<?= ($user['T_fname'])?>  <?= ($user['T_lname'])?> " readonly>
                                                <!-- ถ้า $user['T_ID'] เท่ากับ $userT['T_ID'] จะให้ค่าเป็น $userT['T_fname'] -->
                                            </div>

                                            <div class="col-3 py-3">

                                                <label for="inputName" class="form-label">ข้อมูลด้านสุขภาพ</label>
                                                <textarea type="text" class="form-control" id="inputName" name="S_health"
                                                          placeholder="ข้อมูลด้านสุขภาพ"
                                                > <?= $user['S_health']; ?></textarea>

                                            </div>
                                            <div class="col-3 py-3">

                                                <label for="inputName" class="form-label">ที่อยู่</label>
                                                <textarea type="text" class="form-control" id="inputName" name="S_address"
                                                          placeholder="ที่อยู่"
                                                > <?= $user['S_address']; ?></textarea>

                                            </div>
                                            <div class="col-12 text-center">
                                                <div class="form-section-title">ข้อมูลติดต่อฉุกเฉิน</div>
                                            </div>
                                            <div class="col-4 py-3">
                                                <label for="inputName" class="form-label">ชื่อ-สกุล</label>
                                                <input type="text" class="form-control" id="inputName" name="S_ralative_name"
                                                       placeholder="ระดับชั้น"
                                                       value="<?= $user['S_ralative_name']; ?>" >

                                            </div>
                                            <div class="col-4 py-3">
                                                <label for="inputName" class="form-label">เบอร์โทรศัพท์</label>
                                                <input type="text" class="form-control" id="inputName" name="S_ralative_phone"
                                                       placeholder="ระดับชั้น"
                                                       value="<?= $user['S_ralative_phone']; ?>" >

                                            </div>
                                            <div class="col-4 py-3">
                                                <label for="inputName" class="form-label">ที่อยู่</label>
                                                <textarea type="text" class="form-control" id="inputName" name="S_ralative_address"
                                                          placeholder="ที่อยู่"
                                                > <?= $user['S_ralative_address']; ?></textarea>

                                            </div>

                                        </div>
                                        <br>
                                        <br>


                                        <!-- Row end -->

                                        <!-- Form actions footer start -->
                                        <div class="form-actions-footer">
                                            <a>
                                                <button class="btn btn-danger" type="button" onclick="showConfirmation()">ยกเลิก
                                                </button>
                                            </a>
                                            <a>
                                                <button class="btn btn-primary" type="button" onclick="saveData()">บันทึก</button>
                                            </a>
                                        </div>
                                        <!-- Form actions footer end -->

                                    </div>
                                </div>
                            </div>
                        </form>
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
                        window.location.href = '../index.php';
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
                        document.querySelector('form').submit();
                    }
                });
            }

        </script>
    </body>
    </html>
<?php
require_once '../services_student/update_profile.php';
?>