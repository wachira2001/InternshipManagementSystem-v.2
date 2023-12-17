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
                $_POST['S_gpa'],
                $_POST['S_health'],
                $_POST['S_major'],
                $_FILES['S_img'],
                $_POST['S_ralative_name'],
                $_POST['S_ralative_phone'],
                $_POST['S_ralative_address']

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
            $S_gpa = $_POST['S_gpa'];
            $S_health = $_POST['S_health'];
            $S_major = $_POST['S_major'];
            $S_img = $_FILES['S_img'];
            $S_ralative_name = $_POST['S_ralative_name'];
            $S_ralative_phone = $_POST['S_ralative_phone'];
            $S_ralative_address = $_POST['S_ralative_address'];


            // ตรวจสอบข้อมูลที่รับมา

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
                if (!empty($_FILES['S_img']['name'])) {
                    // มีการแนบรูปภาพเข้ามา
                    $timestamp = time();
                    $date = date("Ymd_His", $timestamp);

                    $filename = $_FILES['S_img']['name'];
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);

                    $fileNameN = $S_ID . '_' . $date . '.' . $ext;
                    $targetFilePath = '../img/' . $fileNameN;

//                     ลบรูปเก่า
                $filesToDelete = glob('../img/' . $S_ID . '_*');
                foreach ($filesToDelete as $fileToDelete) {
                    unlink($fileToDelete);
                }
                    // อัปโหลดรูปใหม่
                    move_uploaded_file($_FILES['S_img']['tmp_name'], $targetFilePath);
                } else {
                    $sql = "SELECT S_ID, S_img FROM student WHERE S_ID = $S_ID";
                    $result = $conn->query($sql);

                    if ($result->rowCount() > 0) {
                        $row = $result->fetch(PDO::FETCH_ASSOC);
                        $fileNameN = $row['S_img'];
                    }
                }

                $updateStmt = $conn->prepare("UPDATE student
                      SET 
                          S_fname = :S_fname,
                          S_lname = :S_lname,
                          S_gender = :S_gender,
                          S_birthday = :S_birthday,
                          S_address = :S_address,
                          S_phone = :S_phone,
                          S_enrollment_term = :S_enrollment_term,
                          S_enrollment_year = :S_enrollment_year,
                          S_gpa = :S_gpa,
                          S_health = :S_health,
                          S_img = :S_img,
                          S_ralative_name = :S_ralative_name,
                          S_ralative_phone = :S_ralative_phone,
                          S_ralative_address = :S_ralative_address
                      WHERE S_ID = :S_ID");

                // กำหนดค่าพารามิเตอร์
                $updateStmt->bindParam(':S_fname', $S_fname, PDO::PARAM_STR);
                $updateStmt->bindParam(':S_lname', $S_lname, PDO::PARAM_STR);
                $updateStmt->bindParam(':S_gender', $S_gender, PDO::PARAM_STR);
                $updateStmt->bindParam(':S_birthday', $S_birthday, PDO::PARAM_STR);
                $updateStmt->bindParam(':S_address', $S_address, PDO::PARAM_STR);
                $updateStmt->bindParam(':S_phone', $S_phone, PDO::PARAM_STR);
                $updateStmt->bindParam(':S_enrollment_term', $S_enrollment_term, PDO::PARAM_STR);
                $updateStmt->bindParam(':S_enrollment_year', $S_enrollment_year, PDO::PARAM_STR);
                $updateStmt->bindParam(':S_gpa', $S_gpa, PDO::PARAM_STR);
                $updateStmt->bindParam(':S_health', $S_health, PDO::PARAM_STR);
                $updateStmt->bindParam(':S_img', $fileNameN, PDO::PARAM_STR);
                $updateStmt->bindParam(':S_ralative_name', $S_ralative_name, PDO::PARAM_STR);
                $updateStmt->bindParam(':S_ralative_phone', $S_ralative_phone, PDO::PARAM_STR);
                $updateStmt->bindParam(':S_ralative_address', $S_ralative_address, PDO::PARAM_STR);
                $updateStmt->bindParam(':S_ID', $S_ID, PDO::PARAM_STR);

                // ทำการเพิ่มข้อมูล
                if ($updateStmt->execute()) {
                    // แสดง SweetAlert2 แจ้งว่าบันทึกข้อมูลสำเร็จ
                    echo 'success';
                } else {
                    // แสดง SweetAlert2 กรณีเกิดข้อผิดพลาดในการบันทึกข้อมูล
                    echo 'เกิดข้อผิดพลาดในการแก้ไข';
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

?>
