<?php
require_once 'conndb.php';
try {
    // ตรวจสอบว่ามีการส่งข้อมูลผ่าน POST request
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // ตรวจสอบข้อมูลที่ส่งมาจากฟอร์ม
        if (
            isset(
                $_POST['S_ID'],
                $_POST['S_fname'],
                $_POST['S_lname'],
                $_POST['S_gender'],
                $_POST['S_birthday'],
                $_POST['S_address'],
                $_POST['S_phone'],
                $_POST['S_email'],
                $_POST['S_enrollment_term'],
                $_POST['S_enrollment_year'],
                $_POST['S_status'],
                $_POST['S_gpa'],
                $_POST['S_health'],
                $_POST['S_major'],
                $_FILES['S_img'],
                $_POST['S_ralative_name'],
                $_POST['S_ralative_phone'],
                $_POST['S_ralative_address'],
                $_POST['T_ID'],
                $_POST['R_ID']
            )
        ) {
            // ดึงข้อมูลจาก $_POST
            $S_ID = $_POST['S_ID'];
            $S_fname = $_POST['S_fname'];
            $S_lname = $_POST['S_lname'];
            $S_gender = $_POST['S_gender'];
            $S_birthday = $_POST['S_birthday'];
            $S_address = $_POST['S_address'];
            $S_phone = $_POST['S_phone'];
            $S_email = $_POST['S_email'];
            $S_enrollment_term = $_POST['S_enrollment_term'];
            $S_enrollment_year = $_POST['S_enrollment_year'];
            $S_status = $_POST['S_status'];
            $S_gpa = $_POST['S_gpa'];
            $S_health = $_POST['S_health'];
            $S_major = $_POST['S_major'];
            $S_img = $_FILES['S_img'];
            $S_ralative_name = $_POST['S_ralative_name'];
            $S_ralative_phone = $_POST['S_ralative_phone'];
            $S_ralative_address = $_POST['S_ralative_address'];
            $T_ID = $_POST['T_ID'];
            $R_ID = $_POST['R_ID'];

            if (strlen($_POST['S_ID']) !== 10) {
                echo 'โปรดกรอกรหัสประจำตัวนักเรียน/นักศึกษา 10 หลัก';
                exit;
            }

            if (preg_match('/[\d\s]/', $_POST['S_fname'])) {
                echo 'ชื่อไม่สามารถมีตัวเลขหรือช่องว่างได้';
                exit;
            }

            if (preg_match('/[\d\s]/', $_POST['S_lname'])) {
                echo 'นามสกุลไม่สามารถมีตัวเลขหรือช่องว่างได้';
                exit;
            }

            $birthday = new DateTime($_POST['S_birthday']);
            $today = new DateTime();
            $age = $today->diff($birthday)->y; //ใช้เมธอด diff() เพื่อคำนวณระยะห่างระหว่างวันปัจจุบันและวันเกิด

            if ($age < 15) {
                echo 'ป้อนวัน/เดือน/ปี เกิดให้ถูกต้อง';
                exit;
            }
            if (!preg_match('/^\d{10}$/', $_POST['S_phone'])) {
                echo 'เบอร์โทรศัพท์ไม่ถูกต้อง';
                exit;
            }

            if (!filter_var($_POST['S_email'], FILTER_VALIDATE_EMAIL)) {
                echo 'อีเมลล์ไม่ถูกต้อง';
                exit;
            }

            if (!preg_match('/^25\d{2}$/', $_POST['S_enrollment_year'])) {
                echo 'ป้อนภาคเรียนที่ออกฝึกงานไม่ถูกต้อง';
                exit();
            }
            if (preg_match('/\d/', $S_ralative_name)) {
                echo 'ชื่อผู้ติดต่อฉุกเฉิน ต้องไม่มีตัวเลข';
                exit();
            }


            // ตรวจสอบข้อมูลซ้ำในฐานข้อมูล
            $stmt = $conn->prepare("SELECT COUNT(*) as count FROM student WHERE S_ID = :S_ID");
            $stmtemail = $conn->prepare("SELECT COUNT(*) as count FROM student WHERE S_email = :S_email");
            $stmt->execute(array(':S_ID' => $S_ID));
            $stmtemail->execute(array(':S_email' => $S_email));

            if ($stmt->fetchColumn() > 0) {
                echo 'รหัสนักเรียน/นักศึกษานี้มีอยู่แล้ว';
                exit();
            } elseif ($stmtemail->fetchColumn() > 0) {
                echo 'E-mail นี้มีแล้ว';
                exit();
            } else {

                if (!empty($_FILES['S_img']['name'])) {
                    // มีการแนบรูปภาพเข้ามา
                    $timestamp = time();
                    $date = date("Ymd_His", $timestamp);

                    $filename = $_FILES['S_img']['name'];
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);

                    $fileNameN = $S_ID . '_' . $date . '.' . $ext;
                    $targetFilePath = '../../student/img/' . $fileNameN;
                    // อัปโหลดรูปใหม่
                    move_uploaded_file($_FILES['S_img']['tmp_name'], $targetFilePath);
                }

//
//                // ตรวจสอบประเภทของไฟล์
//                $filename = $_FILES['S_img']['name'];
//                $ext = pathinfo($filename, PATHINFO_EXTENSION);
//
//                // อัปโหลดไฟล์
//                $fileName = $S_ID . '.' . $ext;
//                $targetFilePath = '../../student/img/' . $fileName;
//                move_uploaded_file($_FILES['S_img']['tmp_name'], $targetFilePath);

                // เพิ่มข้อมูลในฐานข้อมูล
                $insertStmt = $conn->prepare("INSERT INTO student (
                        S_ID, S_fname, S_lname, S_gender, S_birthday, S_address, S_phone, S_email, S_enrollment_term, S_enrollment_year, S_status, S_gpa, S_health, S_major, S_img, S_ralative_name, S_ralative_phone, S_ralative_address, T_ID,S_username,S_password,R_ID
                    ) VALUES (
                        :S_ID, :S_fname, :S_lname, :S_gender, :S_birthday, :S_address, :S_phone, :S_email, :S_enrollment_term, :S_enrollment_year, :S_status, :S_gpa, :S_health, :S_major, :S_img, :S_ralative_name, :S_ralative_phone, :S_ralative_address, :T_ID,:S_username,:S_password,:R_ID
                    )");

                // กำหนดค่าพารามิเตอร์

                $insertStmt->bindParam(':S_ID', $S_ID, PDO::PARAM_STR);
                $insertStmt->bindParam(':S_fname', $S_fname, PDO::PARAM_STR);
                $insertStmt->bindParam(':S_lname', $S_lname, PDO::PARAM_STR);
                $insertStmt->bindParam(':S_gender', $S_gender, PDO::PARAM_STR);
                $insertStmt->bindParam(':S_birthday', $S_birthday, PDO::PARAM_STR);
                $insertStmt->bindParam(':S_address', $S_address, PDO::PARAM_STR);
                $insertStmt->bindParam(':S_phone', $S_phone, PDO::PARAM_STR);
                $insertStmt->bindParam(':S_email', $S_email, PDO::PARAM_STR);
                $insertStmt->bindParam(':S_enrollment_term', $S_enrollment_term, PDO::PARAM_STR);
                $insertStmt->bindParam(':S_enrollment_year', $S_enrollment_year, PDO::PARAM_STR);
                $insertStmt->bindParam(':S_status', $S_status, PDO::PARAM_STR);
                $insertStmt->bindParam(':S_gpa', $S_gpa, PDO::PARAM_STR);
                $insertStmt->bindParam(':S_health', $S_health, PDO::PARAM_STR);
                $insertStmt->bindParam(':S_major', $S_major, PDO::PARAM_STR);
                $insertStmt->bindParam(':S_img', $fileNameN, PDO::PARAM_STR);
                $insertStmt->bindParam(':S_ralative_name', $S_ralative_name, PDO::PARAM_STR);
                $insertStmt->bindParam(':S_ralative_phone', $S_ralative_phone, PDO::PARAM_STR);
                $insertStmt->bindParam(':S_ralative_address', $S_ralative_address, PDO::PARAM_STR);
                $insertStmt->bindParam(':T_ID', $T_ID, PDO::PARAM_STR);
                $insertStmt->bindParam(':S_username', $S_email, PDO::PARAM_STR);
                $insertStmt->bindParam(':S_password', $S_ID, PDO::PARAM_STR);
                $insertStmt->bindParam(':R_ID', $R_ID, PDO::PARAM_STR);

                // ทำการเพิ่มข้อมูล
                if ($insertStmt->execute()) {
                    // แสดง SweetAlert2 แจ้งว่าบันทึกข้อมูลสำเร็จ
                    echo 'success';
                } else {
                    // แสดง SweetAlert2 กรณีเกิดข้อผิดพลาดในการบันทึกข้อมูล
                    echo 'เกิดข้อผิดพลาดในการลงทะเบียน';
                }
            }
        } else {
            // แสดง SweetAlert2 กรณีข้อมูลที่ส่งมาไม่ครบ
            echo 'โปรดกรอกข้อมูลที่จำเป็น';
        }
    }
} catch (PDOException $e) {
    // แสดง SweetAlert2 กรณีเกิด Exception
    echo 'เกิดข้อผิดพลาด: ' . $e->getMessage();
}















//try {
//    if (
//        isset(
//            $_POST['S_ID'],
//            $_POST['S_fname'],
//            $_POST['S_lname'],
//            $_POST['S_gender'],
//            $_POST['S_birthday'],
//            $_POST['S_address'],
//            $_POST['S_phone'],
//            $_POST['S_email'],
//            $_POST['S_enrollment_term'],
//            $_POST['S_enrollment_year'],
//            $_POST['S_status'],
//            $_POST['S_gpa'],
//            $_POST['S_health'],
//            $_POST['S_major'],
//            $_FILES['S_img'],
//            $_POST['S_ralative_name'],
//            $_POST['S_ralative_phone'],
//            $_POST['S_ralative_address'],
//            $_POST['T_ID'],
//            $_POST['R_ID']
//        )
//    ) {
//        $S_ID = $_POST['S_ID'];
//        $S_fname = $_POST['S_fname'];
//        $S_lname = $_POST['S_lname'];
//        $S_gender = $_POST['S_gender'];
//        $S_birthday = $_POST['S_birthday'];
//        $S_address = $_POST['S_address'];
//        $S_phone = $_POST['S_phone'];
//        $S_email = $_POST['S_email'];
//        $S_enrollment_term = $_POST['S_enrollment_term'];
//        $S_enrollment_year = $_POST['S_enrollment_year'];
//        $S_status = $_POST['S_status'];
//        $S_gpa = $_POST['S_gpa'];
//        $S_health = $_POST['S_health'];
//        $S_major = $_POST['S_major'];
//        $S_img = $_FILES['S_img'];
//        $S_ralative_name = $_POST['S_ralative_name'];
//        $S_ralative_phone = $_POST['S_ralative_phone'];
//        $S_ralative_address = $_POST['S_ralative_address'];
//        $T_ID = $_POST['T_ID'];
//        $R_ID = $_POST['R_ID'];
//
//        // ตรวจสอบข้อมูลซ้ำในฐานข้อมูล
//        $stmt = $conn->prepare("SELECT COUNT(*) as count FROM student WHERE S_ID = :S_ID");
//        $stmtemail = $conn->prepare("SELECT COUNT(*) as count FROM student WHERE S_email = :S_email");
//        $stmt->execute(array(':S_ID' => $S_ID));
//        $stmtemail->execute(array(':S_email' => $S_email));
//
//        if ($stmt->fetchColumn() > 0) {
//            // ดึงข้อมูลที่ซ้ำ
//            $duplicateDataStmt = $conn->prepare("SELECT * FROM student WHERE S_ID = :S_ID");
//            $duplicateDataStmt->execute(array(':S_ID' => $S_ID));
//            $duplicateData = $duplicateDataStmt->fetch(PDO::FETCH_ASSOC);
//
//            // แสดง SweetAlert2 สำหรับข้อมูลที่ซ้ำ
//            echo "
//            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
//            <script>
//                Swal.fire({
//                    title: 'ข้อมูลที่ซ้ำ',
//                    html: 'ข้อมูลนี้มีอยู่แล้ว:<br>ID: {$duplicateData['S_ID']}',
//                    icon: 'warning',
//                    showConfirmButton: true
//                }).then(function () {
//                    window.location.href = '../index.php';
//                });
//            </script>";
//            return;
//        }
//        if ($stmtemail->fetchColumn() > 0) {
//            // ดึงข้อมูลที่ซ้ำ
//            $duplicateDataStmt = $conn->prepare("SELECT * FROM student WHERE S_email = :S_email");
//            $duplicateDataStmt->execute(array(':S_email' => $S_email));
//            $duplicateData = $duplicateDataStmt->fetch(PDO::FETCH_ASSOC);
//
//            // แสดง SweetAlert2 สำหรับข้อมูลที่ซ้ำ
//            echo "
//            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
//            <script>
//                Swal.fire({
//                    title: 'ข้อมูลที่ซ้ำ',
//                    html: 'ข้อมูลนี้มีอยู่แล้ว:<br>Email: {$duplicateData['S_email']}',
//                    icon: 'warning',
//                    showConfirmButton: true
//                }).then(function () {
//                    window.location.href = '../index.php';
//                });
//            </script>";
//            return;
//        }
//
//        // ตรวจสอบประเภทของไฟล์
//        $filename = $_FILES['S_img']['name'];
//        $ext = pathinfo($filename, PATHINFO_EXTENSION);
//
//        // อัปโหลดไฟล์
//        $fileName = $S_ID . '.' . $ext;
//        $targetFilePath = '../student/img/' . $fileName;
//        move_uploaded_file($_FILES['S_img']['tmp_name'], $targetFilePath);
//
//        // เพิ่มข้อมูลในฐานข้อมูล
//        $insertStmt = $conn->prepare("INSERT INTO student (
//                    S_ID, S_fname, S_lname, S_gender, S_birthday, S_address, S_phone, S_email, S_enrollment_term, S_enrollment_year, S_status, S_gpa, S_health, S_major, S_img, S_ralative_name, S_ralative_phone, S_ralative_address, T_ID,S_username,S_password,R_ID
//                ) VALUES (
//                    :S_ID, :S_fname, :S_lname, :S_gender, :S_birthday, :S_address, :S_phone, :S_email, :S_enrollment_term, :S_enrollment_year, :S_status, :S_gpa, :S_health, :S_major, :S_img, :S_ralative_name, :S_ralative_phone, :S_ralative_address, :T_ID,:S_username,:S_password,:R_ID
//                )");
//
//        // กำหนดค่าพารามิเตอร์
//
//        $insertStmt->bindParam(':S_ID', $S_ID, PDO::PARAM_STR);
//        $insertStmt->bindParam(':S_fname', $S_fname, PDO::PARAM_STR);
//        $insertStmt->bindParam(':S_lname', $S_lname, PDO::PARAM_STR);
//        $insertStmt->bindParam(':S_gender', $S_gender, PDO::PARAM_STR);
//        $insertStmt->bindParam(':S_birthday', $S_birthday, PDO::PARAM_STR);
//        $insertStmt->bindParam(':S_address', $S_address, PDO::PARAM_STR);
//        $insertStmt->bindParam(':S_phone', $S_phone, PDO::PARAM_STR);
//        $insertStmt->bindParam(':S_email', $S_email, PDO::PARAM_STR);
//        $insertStmt->bindParam(':S_enrollment_term', $S_enrollment_term, PDO::PARAM_STR);
//        $insertStmt->bindParam(':S_enrollment_year', $S_enrollment_year, PDO::PARAM_STR);
//        $insertStmt->bindParam(':S_status', $S_status, PDO::PARAM_STR);
//        $insertStmt->bindParam(':S_gpa', $S_gpa, PDO::PARAM_STR);
//        $insertStmt->bindParam(':S_health', $S_health, PDO::PARAM_STR);
//        $insertStmt->bindParam(':S_major', $S_major, PDO::PARAM_STR);
//        $insertStmt->bindParam(':S_img', $fileName, PDO::PARAM_STR);
//        $insertStmt->bindParam(':S_ralative_name', $S_ralative_name, PDO::PARAM_STR);
//        $insertStmt->bindParam(':S_ralative_phone', $S_ralative_phone, PDO::PARAM_STR);
//        $insertStmt->bindParam(':S_ralative_address', $S_ralative_address, PDO::PARAM_STR);
//        $insertStmt->bindParam(':T_ID', $T_ID, PDO::PARAM_STR);
//        $insertStmt->bindParam(':S_username', $S_email, PDO::PARAM_STR);
//        $insertStmt->bindParam(':S_password', $S_ID, PDO::PARAM_STR);
//        $insertStmt->bindParam(':R_ID', $R_ID, PDO::PARAM_STR);
//
//
//        // ทำการเพิ่มข้อมูล
//        if ($insertStmt->execute()) {
//            // แสดง SweetAlert2 แจ้งว่าบันทึกข้อมูลสำเร็จ
//            echo "
//            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
//            <script>
//                Swal.fire({
//                    title: 'สำเร็จ',
//                    text: 'ลงทะเบียนนักเรียนเรียบร้อยแล้ว',
//                    icon: 'success',
//                    showConfirmButton: false,
//                    timer: 5000
//                }).then(function () {
//                    window.location.href = '../index.php';
//                });
//            </script>";
//        } else {
//            // แสดง SweetAlert2 กรณีเกิดข้อผิดพลาดในการบันทึกข้อมูล
//            echo "
//            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
//            <script>
//                Swal.fire({
//                    title: 'ผิดพลาด',
//                    text: 'เกิดข้อผิดพลาดในการลงทะเบียน',
//                    icon: 'error',
//                    showConfirmButton: true
//                });
//            </script>";
//        }
//    }
//} catch (PDOException $e) {
//    // แสดง SweetAlert2 กรณีเกิด Exception
//    echo "
//    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
//    <script>
//        Swal.fire({
//            title: 'ผิดพลาด',
//            text: 'เกิดข้อผิดพลาด: {$e->getMessage()}',
//            icon: 'error',
//            showConfirmButton: true
//        });
//    </script>";
//}
?>
