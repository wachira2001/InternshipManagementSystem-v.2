<?php
require_once 'conndb.php';
try {
    // ตรวจสอบว่ามีการส่งข้อมูลผ่าน POST request
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // ตรวจสอบข้อมูลที่ส่งมาจากฟอร์ม
        if (
            isset(
                $_POST['M_ID'],
                $_POST['M_Name'],
                $_POST['M_college'],
                $_FILES['M_img'], // ตรวจสอบเฉพาะในกรณีที่มีการอัปเดตภาพ
                $_POST['M_address']
            )
        ) {
            // ดึงข้อมูลจาก $_POST
            $M_ID = $_POST['M_ID'];
            $M_Name = $_POST['M_Name'];
            $M_college = $_POST['M_college'];
            $M_address = $_POST['M_address'];
            $M_img = $_FILES['M_img'];

                if (!empty($_FILES['M_img']['name'])) {
                    // มีการแนบรูปภาพเข้ามา
                    $timestamp = time();
                    $date = date("Ymd_His", $timestamp);

                    $filename = $_FILES['M_img']['name'];
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);

                    $fileNameN = $M_ID . '_' . $date . '.' . $ext;
                    $targetFilePath = '../../upload_img/' . $fileNameN;

                    // ลบรูปเก่า
                    $filesToDelete = glob('../../upload_img/' . $M_ID . '_*');
                    foreach ($filesToDelete as $fileToDelete) {
                        unlink($fileToDelete);
                    }

                    // อัปโหลดรูปใหม่
                    move_uploaded_file($_FILES['M_img']['tmp_name'], $targetFilePath);
                } else {
                    $sql = "SELECT M_ID, M_img FROM major WHERE M_ID = $M_ID";
                    $result = $conn->query($sql);

                    if ($result->rowCount() > 0) {
                        $row = $result->fetch(PDO::FETCH_ASSOC);
                        $fileNameN = $row['M_img'];
                    }
                }

                $updateStmt = $conn->prepare("UPDATE major 
                                      SET 
                                          M_Name = :M_Name,
                                          M_college = :M_college,
                                          M_img = :M_img,
                                          M_address = :M_address
                                      WHERE M_ID = :M_ID");

                // กำหนดค่าพารามิเตอร์
                $updateStmt->bindParam(':M_Name', $M_Name, PDO::PARAM_STR);
                $updateStmt->bindParam(':M_college', $M_college, PDO::PARAM_STR);
                $updateStmt->bindParam(':M_img', $fileNameN, PDO::PARAM_STR);
                $updateStmt->bindParam(':M_address', $M_address, PDO::PARAM_STR);
                $updateStmt->bindParam(':M_ID', $M_ID, PDO::PARAM_STR);

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
