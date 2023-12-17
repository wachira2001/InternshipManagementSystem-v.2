<?php
include_once 'conndb.php';
try {
    // ตรวจสอบว่ามีการส่งข้อมูลผ่าน POST request
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // ตรวจสอบข้อมูลที่ส่งมาจากฟอร์ม
        if (
            isset(
                $_POST['T_ID'],
                $_POST['T_fname'],
                $_POST['T_lname'],
                $_POST['T_position'],
                $_POST['T_birthday'],
                $_POST['T_status'],
                $_POST['T_phone'],
                $_POST['T_email'],
                $_POST['T_address'],
                $_POST['T_gender']
            )
        ) {
            // ดึงข้อมูลจาก $_POST
            $T_ID = $_POST['T_ID'];
            $T_fname =  $_POST['T_fname'];
            $T_lname = $_POST['T_lname'];
            $T_position = $_POST['T_position'];
            $T_birthday = $_POST['T_birthday'];
            $T_address = $_POST['T_address'];
            $T_status = $_POST['T_status'];
            $T_phone = $_POST['T_phone'];
            $T_email = $_POST['T_email'];
            $T_gender = $_POST['T_gender'];



            // 2. $T_fname = $_POST['T_fname']; เช็คว่ามีตัวเลขหรือช่องว่างไหม:
            if (preg_match('/[\d\s]/', $_POST['T_fname'])) {
                echo 'ชื่อไม่สามารถมีตัวเลขหรือช่องว่างได้';
                exit;
            }

            // 3. $T_lname = $_POST['T_lname']; เช็คว่ามีตัวเลขหรือช่องว่างไหม:
            if (preg_match('/[\d\s]/', $_POST['T_lname'])) {
                echo 'นามสกุลไม่สามารถมีตัวเลขหรือช่องว่างได้';
                exit;
            }

            // 4. $T_position = $_POST['T_position']; เช็คว่ามีตัวเลขหรือช่องว่างไหม:
            if (preg_match('/[\d\s]/', $_POST['T_position'])) {
                echo 'ตำแหน่งไม่สามารถมีตัวเลขหรือช่องว่างได้';
                exit;
            }

            // 5. $T_birthday = $_POST['T_birthday']; เช็คว่าอายุเกิน 20 ปีไหม:
            $birthday = new DateTime($_POST['T_birthday']);
            $today = new DateTime();
            $age = $today->diff($birthday)->y; //ใช้เมธอด diff() เพื่อคำนวณระยะห่างระหว่างวันปัจจุบันและวันเกิด

            if ($age < 20) {
                echo 'ป้อนวัน/เดือน/ปี เกิดให้ถูกต้อง';
                exit;
            }

            // 6. $T_phone = $_POST['T_phone']; เช็คว่าเบอร์ถูกต้องไหม:
            if (!preg_match('/^\d{10}$/', $_POST['T_phone'])) {
                echo 'เบอร์โทรศัพท์ไม่ถูกต้อง';
                exit;
            }

            // 7. $T_email = $_POST['T_email']; เช็คว่าอีเมลล์ถูกต้องไหม:
            if (!filter_var($_POST['T_email'], FILTER_VALIDATE_EMAIL)) {
                echo 'อีเมลล์ไม่ถูกต้อง';
                exit;
            }


              $updateStmt = $conn->prepare("UPDATE teacher 
                      SET 
                          T_fname = :T_fname,
                          T_lname = :T_lname,
                          T_position = :T_position,
                          T_address = :T_address,
                          T_birthday = :T_birthday,
                          T_phone = :T_phone,
                          T_email = :T_email,
                          T_gender = :T_gender,
                          T_status = :T_status
                      WHERE T_ID = :T_ID");

                // กำหนดค่าพารามิเตอร์
                $updateStmt->bindParam(':T_fname', $T_fname, PDO::PARAM_STR);
                $updateStmt->bindParam(':T_lname', $T_lname, PDO::PARAM_STR);
                $updateStmt->bindParam(':T_position', $T_position, PDO::PARAM_STR);
                $updateStmt->bindParam(':T_address', $T_address, PDO::PARAM_STR);
                $updateStmt->bindParam(':T_birthday', $T_birthday, PDO::PARAM_STR);
                $updateStmt->bindParam(':T_status', $T_status, PDO::PARAM_STR);
                $updateStmt->bindParam(':T_phone', $T_phone, PDO::PARAM_STR);
                $updateStmt->bindParam(':T_email', $T_email, PDO::PARAM_STR);
                $updateStmt->bindParam(':T_gender', $T_gender, PDO::PARAM_STR);
                $updateStmt->bindParam(':T_ID', $T_ID, PDO::PARAM_STR);

                // ทำการเพิ่มข้อมูล
                if ($updateStmt->execute()) {
                    // แสดง SweetAlert2 แจ้งว่าบันทึกข้อมูลสำเร็จ
                    echo 'success';
                } else {
                    // แสดง SweetAlert2 กรณีเกิดข้อผิดพลาดในการบันทึกข้อมูล
                    echo 'เกิดข้อผิดพลาดในการแก้ไข';
                }
            }
        } else {
            // แสดง SweetAlert2 กรณีข้อมูลที่ส่งมาไม่ครบ
            echo 'โปรดกรอกข้อมูลที่จำเป็น';
        }
} catch (PDOException $e) {
    // แสดง SweetAlert2 กรณีเกิด Exception
    echo 'เกิดข้อผิดพลาด: ' . $e->getMessage();
}

?>
