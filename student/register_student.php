<?php
include_once '../config/conndb.php';
include_once '../config/show_data.php';
$getTeacher = getTeacher($conn);
$getroom = getroomall($conn);
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
    <title>สมัครสมาชิกนักศึกษา</title>
    <link rel="icon" type="image/png" href="../img/software.png">
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../assets/css/animate.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.3.4/sweetalert2.min.css">
    <link rel="stylesheet" href="../assets/fonts/bootstrap/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/main.min.css?v=9999">
    <link rel="stylesheet" href="../assets/vendor/overlay-scroll/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.3.4/sweetalert2.min.css">
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
    <div style="font-size: 20px; font-weight: bolder;">
        <nav class="navbar navbar-expand-lg navbar-light bg-white py-2">
            <div class="container px-0">
                <a class="navbar-brand" href="../index.php"><span class="fw-bolder text-primary">ระบบจัดการออกฝึกประสบการณ์วิชาชีพ</span></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 small fw-bolder">
                        <li class="nav-item" ><a class="nav-link " href="../../index.php">หน้าแรก</a></li>
                        <li class="nav-item"><a class="nav-link" href="about.php">เกี่ยวกับเรา</a></li>
                        <li class="nav-item"><a class="nav-link " href="../register.php">สมัครสมาชิก</a></li>
                        <li class="nav-item"><a class="nav-link" href="../login.php">เข้าสู่ระบบ</a></li>

                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <!-- เริ่มต้นของ เนื้อหา content -->
    <div class="content-wrapper py-3">
        <div class="container m-auto">
            <form method="post" class="m-3" enctype="multipart/form-data">
                <!-- ตราบาป้อนข้อมูลส่วนตัวของนักเรียน -->
                <div class="row g-4">
                    <div class=" col-md-4">
                        <label for="S_ID" class="form-label">รหัสนักศึกษา</label>
                        <input type="text" class="form-control" id="S_ID" name="S_ID" maxlength="10"
                               placeholder="รหัสบุคลากร 10 หลัก"
                               required>
                    </div>
                    <div class=" col-md-4">
                        <label for="S_fname" class="form-label">ชื่อ</label>
                        <input type="text" class="form-control" id="S_fname" name="S_fname" maxlength="50"
                               placeholder="ชื่อนักศึกษา" required>
                    </div>
                    <div class=" col-md-4">
                        <label for="S_lname" class="form-label">นามสกุล</label>
                        <input type="text" class="form-control" id="S_lname" name="S_lname" maxlength="50"
                               placeholder="นามสกุล" required>
                    </div>
                    <div class="col-md-3">
                        <label for="S_gender" class="form-label">เพศ</label>
                        <select id="S_gender" class="form-select" name="S_gender" required>
                            <option selected>Choose...</option>
                            <option>ชาย</option>
                            <option>หญิง</option>
                            <option>ไม่ระบุ</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <!-- ป้ายชื่อสำหรับฟิลด์วันเกิด -->
                        <label for="S_birthday" class="form-label">วันเดือนปีเกิด</label>
                        <!-- ฟิลด์ข้อมูลสำหรับเลือกวันเกิด -->
                        <input type="date" id="S_birthday" class="form-control" name="S_birthday" required>
                    </div>
                    <div class="col-md-3">
                        <label for="S_phone" class="form-label">เบอร์โทรศัพท์</label>
                        <input type="text" class="form-control" id="S_phone" name="S_phone" maxlength="10"
                               placeholder="เบอร์มือถือที่สามารถติดต่อได้" required>
                    </div>
                    <div class="col-md-3">
                        <label for="S_email" class="form-label">E-gmail</label>
                        <input type="email" class="form-control" id="S_email" name="S_email" maxlength="100"
                               placeholder="E-gmail" required>
                    </div>
                    <div class="col-md-12 input-group">
                        <span class="input-group-text">ที่อยู่ปัจจุบัน</span>
                        <textarea class="form-control" aria-label="With textarea" id="S_address"
                                  name="S_address" required></textarea>
                    </div>


                    <!-- สิ้นสุดการป้อนข้อมูลส่วนตัวของนักเรียน -->


                    <!-- ส่วนที่ 2 ป้อนข้อมูลส่วนตัวของนักเรียน -->

                    <div class="col-md-4">
                        <label for="S_enrollment_term" class="form-label">ภาคเรียนที่ออกฝึกงาน</label>
                        <select class="form-select" id="S_enrollment_term" name="S_enrollment_term" required>
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="S_enrollment_year" class="form-label">ปีการศึกษาที่ออกฝึกงาน</label>
                        <input type="text" class="form-control date-own" id="S_enrollment_year"
                               name="S_enrollment_year" maxlength="4"
                               placeholder="ประจำปีการศึกษา" pattern="[0-9]{4}" required>

                    </div>

                    <input type="hidden" class="form-control date-own" id="S_status" name="S_status"
                           value="0"/>


                    <div class="col-md-4">
                        <label for="S_gpa" class="form-label">เกรดเฉลี่ย</label>
                        <input type="text" class="form-control date-own" id="S_gpa" name="S_gpa" maxlength="4"
                               placeholder="เกรดเฉลี่ย" required>
                    </div>
                    <div class="col-md-12 input-group">
                        <span class="input-group-text">ข้อมูลสุขภาพ</span>
                        <textarea class="form-control" aria-label="With textarea" name="S_health"
                                  required></textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="S_major" class="form-label">สาขาวิชา</label>
                        <select id="S_major" class="form-select" name="S_major" required>
                            <option value="สาขาเทคโนโลยีธุรกิจดิจิทัล">สาขาเทคโนโลยีธุรกิจดิจิทัล</option>
                        </select>
                    </div>
<!--                    <div class="col-md-6">-->
<!--                        <label for="S_level" class="form-label">ระดับชั้น</label>-->
<!--                        <select id="S_level" class="form-select" name="S_level" required>-->
<!--                            <option selected>เลือกระดับชั้น</option>-->
<!--                            <option>ปวช.1</option>-->
<!--                            <option>ปวช.2</option>-->
<!--                            <option>ปวช.3</option>-->
<!--                            <option>ปวส.1</option>-->
<!--                            <option>ปวส.2</option>-->
<!--                        </select>-->
<!--                    </div>-->
                    <div class="col-md-6">
                        <label for="T_ID" class="form-label">เลือกครูที่ปรึกษา</label>
                        <select name="T_ID" id="T_ID" class="form-select" required>
                            <option value="">-- เลือกครู --</option>
                            <?php foreach ($getTeacher as $teacher) : ?>
                                <option value="<?php echo $teacher['T_ID']; ?>"><?php echo $teacher['T_fname']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="R_ID" class="form-label">เลือกระดับชั้น</label>
                        <select name="R_ID" id="R_ID" class="form-select" required>
                            <option value="">-- เลือกครู --</option>
                            <?php foreach ($getroom as $room) : ?>
                                <option value="<?php echo $room['R_ID']; ?>"><?php echo $room['R_level']; ?>. <?php echo $room['R_room']; ?> ห้อง <?php echo $room['R_level_numder']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>



                    <div class="col-md-6">
                        <label for="S_level" class="form-label">อัพโหลดไฟล์รูป</label>
                        <input type="file" id="S_img" class="form-control" aria-label="Upload" name="S_img" accept="image/jpeg, image/png, image/jpg" required>
                    </div>
                    <!-- สิ้นสุดการป้อนข้อมูลส่วนตัวของนักเรียน -->

                    <!-- ส่วนที่ 3 ป้อนข้อมูลติดต่อฉุกเฉิน -->
                    <div class="col-md-12 py-3" style="text-align: center ; ">
                        <h1>ข้อมูลติดต่อฉุกเฉิน</h1>
                    </div>
                    <div class="col-md-6">
                        <label for="S_ralative_name" class="form-label">ชื่อ-สกุล</label>
                        <input type="text" class="form-control" id="S_ralative_name" name="S_ralative_name"
                               maxlength="50"
                               placeholder="ชื่อ-สกุล" required>
                    </div>

                    <div class="col-md-6">
                        <label for="S_ralative_phone" class="form-label">เบอร์โทรศัพท์</label>
                        <input type="text" class="form-control" id="S_ralative_phone" name="S_ralative_phone"
                               maxlength="10"
                               placeholder="เบอร์มือถือที่สามารถติดต่อได้" required>
                    </div>
                    <div class="col-md-12 input-group">
                        <span class="input-group-text">ที่อยู่</span>
                        <textarea class="form-control" aria-label="With textarea"
                                  name="S_ralative_address" required placeholder="ที่อยู่ปัจจุบัน"></textarea>
                    </div>

                    <div style="text-align: center" class="g-4 py-4">
                        <button type="button" class="btn btn-danger" onclick="showConfirmation()">ยกเลิก</button>
                        <button type="submit" class="btn btn-primary" >บันทึก</button>
                    </div>

                </div>

            </form>
        </div>


    </div>
    <!-- ส่วนจบของ เนื้อหา content -->

    <!-- เริ่มต้นของ App Footer -->
    <div class="app-footer">
        <span>สาขาเทคโนโลยีธุรกิจดิจิทัล</span>
    </div>
    <!-- ส่วนจบของ App Footer -->

</div>

<!-- ส่วนจบของคอนเทนเนอร์ -->

<!-- ส่วนจบของหน้า -->

<!-- เริ่มต้นของไฟล์ JavaScript ที่จำเป็น -->
<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/modernizr.js"></script>
<script src="../assets/js/moment.js"></script>

<!-- เริ่มต้นของไฟล์ JavaScript ของ Vendor -->
<script src="../assets/vendor/overlay-scroll/jquery.overlayScrollbars.min.js"></script>
<script src="../assets/vendor/overlay-scroll/custom-scrollbar.js"></script>
<script src="../assets/vendor/apex/apexcharts.min.js"></script>
<script src="../assets/vendor/apex/custom/sales/salesGraph.js"></script>
<script src="../assets/vendor/apex/custom/sales/revenueGraph.js"></script>
<script src="../assets/vendor/apex/custom/sales/taskGraph.js"></script>

<!-- ไฟล์ JavaScript หลัก -->
<script src="../assets/js/main.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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
                window.location.href = '../index.php';
            }
        });
    }
    function cancelAction() {
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
                console.log('Cancel action');
            }
        });
    }
    function submitForm() {
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
                console.log('Submit form action');
            }
        });
    }
</script>
<?php
include_once 'services_student/INSERT_student.php';
?>
</body>
</html>