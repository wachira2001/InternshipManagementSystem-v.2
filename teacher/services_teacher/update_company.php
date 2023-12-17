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
                $_POST['C_tambon'],
                $_POST['C_amphoe'],
                $_POST['C_province']
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
            $C_tambon = $_POST['C_tambon'];
            $C_amphoe = $_POST['C_amphoe'];
            $C_province = $_POST['C_province'];


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

                // ลบรูปเก่า
                $filesToDelete = glob('../../upload_img/' . $company_ID . '_*');
                foreach ($filesToDelete as $fileToDelete) {
                    unlink($fileToDelete);
                }

                // อัปโหลดรูปใหม่
                move_uploaded_file($_FILES['C_img']['tmp_name'], $targetFilePath);
            } else {
                $sql = "SELECT company_ID, C_img FROM company WHERE company_ID = $company_ID";
                $result = $conn->query($sql);

                if ($result->rowCount() > 0) {
                    $row = $result->fetch(PDO::FETCH_ASSOC);
                    $fileNameN = $row['C_img'];
                }
            }

            $updateStmt = $conn->prepare("UPDATE company
                                      SET 
                                          C_name = :C_name,
                                          C_telephone = :C_telephone,
                                          C_website = :C_website,
                                          C_staff_name = :C_staff_name,
                                          C_staff_position = :C_staff_position,
                                          C_staff_phone = :C_staff_phone,
                                          C_img = :C_img,
                                          C_tambon = :C_tambon,
                                          C_amphoe = :C_amphoe,
                                          C_province = :C_province
                                      WHERE company_ID = :company_ID");

            // กำหนดค่าพารามิเตอร์

            $updateStmt->bindParam(':C_name', $C_name, PDO::PARAM_STR);
            $updateStmt->bindParam(':C_telephone', $C_telephone, PDO::PARAM_STR);
            $updateStmt->bindParam(':C_website', $C_website, PDO::PARAM_STR);
            $updateStmt->bindParam(':C_staff_name', $C_staff_name, PDO::PARAM_STR);
            $updateStmt->bindParam(':C_staff_position', $C_staff_position, PDO::PARAM_STR);
            $updateStmt->bindParam(':C_staff_phone', $C_staff_phone, PDO::PARAM_STR);
            $updateStmt->bindParam(':C_img', $fileNameN, PDO::PARAM_STR);
            $updateStmt->bindParam(':C_tambon', $C_tambon, PDO::PARAM_STR);
            $updateStmt->bindParam(':C_amphoe', $C_amphoe, PDO::PARAM_STR);
            $updateStmt->bindParam(':C_province', $C_province, PDO::PARAM_STR);
            $updateStmt->bindParam(':company_ID', $company_ID, PDO::PARAM_STR);

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
