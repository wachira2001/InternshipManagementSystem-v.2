<?php
require_once 'conndb.php';
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
                $_POST['T_address'],
                $_POST['T_birthday'],
                $_FILES['T_img'],
                $_POST['T_phone'],
                $_POST['T_email'],
                $_POST['T_gender'],
                $_POST['T_password'],
                $_POST['T_username']
            )
        ) {
            // ดึงข้อมูลจาก $_POST
            $T_ID = $_POST['T_ID'];
            $T_fname = $_POST['T_fname'];
            $T_lname = $_POST['T_lname'];
            $T_position = $_POST['T_position'];
            $T_address = $_POST['T_address'];
            $T_birthday = $_POST['T_birthday'];
            $T_img = $_FILES['T_img'];
            $T_phone = $_POST['T_phone'];
            $T_email = $_POST['T_email'];
            $T_gender = $_POST['T_gender'];
            $T_password = $_POST['T_password'];
            $T_username = $_POST['T_username'];


            // ตรวจสอบข้อมูลที่รับมา

            // 1. $T_ID = $_POST['T_ID']; เช็คว่าครบ 10 ตัวไหม:
            if (strlen($_POST['T_ID']) !== 10) {
                echo 'โปรดกรอกรหัสประจำตัวบุคลากร 10 หลัก';
                exit;
            }

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


            // ตรวจสอบข้อมูลซ้ำในฐานข้อมูล
            $stmt = $conn->prepare("SELECT COUNT(*) as count FROM teacher WHERE T_username = :T_username AND T_ID != :T_ID");
            $stmt->execute(array(':T_username' => $T_username, ':T_ID' => $T_ID));

// ถ้ามีข้อมูลที่ซ้ำ
            if ($stmt->fetchColumn() > 0) {
                // แสดง SweetAlert2 สำหรับข้อมูลที่ซ้ำ
                echo "เกิดข้อผิดพลาด: username ซ้ำกับข้อมูลที่มีอยู่แล้ว";
                exit();
            } else {

                if (!empty($_FILES['T_img']['name'])) {
                    // มีการแนบรูปภาพเข้ามา
                    $timestamp = time();
                    $date = date("Ymd_His", $timestamp);

                    $filename = $_FILES['T_img']['name'];
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);

                    $fileNameN = $T_ID . '_' . $date . '.' . $ext;
                    $targetFilePath = '../img/' . $fileNameN;

                    // ลบรูปเก่า
                    $filesToDelete = glob('../img/' . $T_ID . '_*');
                    foreach ($filesToDelete as $fileToDelete) {
                        unlink($fileToDelete);
                    }

                    // อัปโหลดรูปใหม่
                    move_uploaded_file($_FILES['T_img']['tmp_name'], $targetFilePath);
                } else {
                    $sql = "SELECT T_ID, T_img FROM teacher WHERE T_ID = $T_ID";
                    $result = $conn->query($sql);

                    if ($result->rowCount() > 0) {
                        $row = $result->fetch(PDO::FETCH_ASSOC);
                        $fileNameN = $row['T_img'];
                    }
                }

                $updateStmt = $conn->prepare("UPDATE teacher 
                      SET 
                          T_fname = :T_fname,
                          T_lname = :T_lname,
                          T_position = :T_position,
                          T_address = :T_address,
                          T_birthday = :T_birthday,
                          T_img = :T_img,
                          T_phone = :T_phone,
                          T_email = :T_email,
                          T_gender = :T_gender,
                          T_username = :T_username,
                          T_password = :T_password
                      WHERE T_ID = :T_ID");

                // กำหนดค่าพารามิเตอร์
                $updateStmt->bindParam(':T_fname', $T_fname, PDO::PARAM_STR);
                $updateStmt->bindParam(':T_lname', $T_lname, PDO::PARAM_STR);
                $updateStmt->bindParam(':T_position', $T_position, PDO::PARAM_STR);
                $updateStmt->bindParam(':T_address', $T_address, PDO::PARAM_STR);
                $updateStmt->bindParam(':T_birthday', $T_birthday, PDO::PARAM_STR);
                $updateStmt->bindParam(':T_img', $fileNameN, PDO::PARAM_STR); // ใช้ชื่อไฟล์ใหม่ที่อัปโหลด
                $updateStmt->bindParam(':T_phone', $T_phone, PDO::PARAM_STR);
                $updateStmt->bindParam(':T_email', $T_email, PDO::PARAM_STR);
                $updateStmt->bindParam(':T_gender', $T_gender, PDO::PARAM_STR);
                $updateStmt->bindParam(':T_username', $T_username, PDO::PARAM_STR);
                $updateStmt->bindParam(':T_password', $T_password, PDO::PARAM_STR);
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
    }
} catch (PDOException $e) {
    // แสดง SweetAlert2 กรณีเกิด Exception
    echo 'เกิดข้อผิดพลาด: ' . $e->getMessage();
}

?>
