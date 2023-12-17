<?php
require_once 'conndb.php';
try {
    // ตรวจสอบว่ามีการส่งข้อมูลผ่าน POST request
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // ตรวจสอบข้อมูลที่ส่งมาจากฟอร์ม
        if (
            isset(
                $_POST['company_ID'],
                $_POST['C_name'],
                $_POST['C_telephone'],
                $_POST['C_website'],
                $_POST['C_staff_name'],
                $_POST['C_staff_position'],
                $_POST['C_staff_phone'],
                $_FILES['C_img'],
                $_POST['C_tambon'], // เพิ่มบรรทัดนี้
                $_POST['C_amphoe'], // เพิ่มบรรทัดนี้
                $_POST['C_province'] // เพิ่มบรรทัดนี้
            )
        ) {
            // ดึงข้อมูลจาก $_POST
            $company_ID = $_POST['company_ID'];
            $C_name = $_POST['C_name'];
            $C_telephone = $_POST['C_telephone'];
            $C_website = $_POST['C_website'];
            $C_staff_name = $_POST['C_staff_name'];
            $C_staff_position = $_POST['C_staff_position'];
            $C_staff_phone = $_POST['C_staff_phone'];
            $C_img = $_FILES['C_img'];
            $C_tambon = $_POST['C_tambon']; // เพิ่มบรรทัดนี้
            $C_amphoe = $_POST['C_amphoe']; // เพิ่มบรรทัดนี้
            $C_province = $_POST['C_province']; // เพิ่มบรรทัดนี้

            // ตรวจสอบข้อมูลซ้ำในฐานข้อมูล
            $stmt = $conn->prepare("SELECT COUNT(*) as count FROM company WHERE company_ID = :company_ID or C_name = :C_name");
            $stmt->execute(array(':company_ID' => $company_ID, ':C_name' => $C_name));

            if ($stmt->fetchColumn() > 0) {
                // แสดง SweetAlert2 สำหรับข้อมูลที่ซ้ำ
                echo 'สถานประกอบการนี้มีอยู่แล้ว';
                exit();
            }
            if (!preg_match('/^\d{10}$/', $_POST['C_telephone'])) {
                echo 'เบอร์โทรศัพท์สถานประกอบการไม่ถูกต้อง';
                exit;
            }
            if (!preg_match('/^\d{10}$/', $_POST['C_staff_phone'])) {
                echo 'เบอร์โทรศัพท์ผู้สอนงานไม่ถูกต้อง';
                exit;
            }
            if (preg_match('/[\d\s]/', $_POST['C_tambon'])) {
                echo 'ตำบลไม่สามารถมีตัวเลขหรือช่องว่างได้';
                exit;
            }
            if (preg_match('/[\d\s]/', $_POST['C_amphoe'])) {
                echo 'อำเภอไม่สามารถมีตัวเลขหรือช่องว่างได้';
                exit;
            }
            if (preg_match('/[\d\s]/', $_POST['C_province'])) {
                echo 'จังหวัดไม่สามารถมีตัวเลขหรือช่องว่างได้';
                exit;
            }

            if (!empty($_FILES['C_img']['name'])) {
                // มีการแนบรูปภาพเข้ามา
                $timestamp = time();
                $date = date("Ymd_His", $timestamp);

                $filename = $_FILES['C_img']['name'];
                $ext = pathinfo($filename, PATHINFO_EXTENSION);

                $fileNameN = $company_ID . '_' . $date . '.' . $ext;
                $targetFilePath = '../../upload_img/' . $fileNameN;
                // อัปโหลดรูปใหม่
                move_uploaded_file($_FILES['C_img']['tmp_name'], $targetFilePath);
            }
                $insertStmt = $conn->prepare("INSERT INTO company (
                    company_ID, C_name, C_telephone, C_website, C_staff_name, C_staff_position, C_staff_phone, C_img, C_tambon, C_amphoe, C_province
                ) VALUES (
                    :company_ID, :C_name, :C_telephone, :C_website, :C_staff_name, :C_staff_position, :C_staff_phone, :C_img, :C_tambon, :C_amphoe, :C_province
                )");

                // กำหนดค่าพารามิเตอร์
                $insertStmt->bindParam(':company_ID', $company_ID, PDO::PARAM_STR);
                $insertStmt->bindParam(':C_name', $C_name, PDO::PARAM_STR);
                $insertStmt->bindParam(':C_telephone', $C_telephone, PDO::PARAM_STR);
                $insertStmt->bindParam(':C_website', $C_website, PDO::PARAM_STR);
                $insertStmt->bindParam(':C_staff_name', $C_staff_name, PDO::PARAM_STR);
                $insertStmt->bindParam(':C_staff_position', $C_staff_position, PDO::PARAM_STR);
                $insertStmt->bindParam(':C_staff_phone', $C_staff_phone, PDO::PARAM_STR);
                $insertStmt->bindParam(':C_img', $fileNameN, PDO::PARAM_STR);
                $insertStmt->bindParam(':C_tambon', $C_tambon, PDO::PARAM_STR); // เพิ่มบรรทัดนี้
                $insertStmt->bindParam(':C_amphoe', $C_amphoe, PDO::PARAM_STR); // เพิ่มบรรทัดนี้
                $insertStmt->bindParam(':C_province', $C_province, PDO::PARAM_STR); // เพิ่มบรรทัดนี้
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
} catch (PDOException $e) {
    // แสดง SweetAlert2 กรณีเกิด Exception
    echo 'เกิดข้อผิดพลาด: ' . $e->getMessage();
}

?>
