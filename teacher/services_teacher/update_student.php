<?php
include_once 'conndb.php';

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
                $_POST['S_address'],
                $_POST['S_phone'],
                $_POST['S_health'],
                $_POST['S_ralative_address'],
                $_POST['R_ID']

            )
        ) {
            // ดึงข้อมูลจาก $_POST
            $S_ID = $_POST['S_ID'];
            $S_fname = $_POST['S_fname'];
            $S_lname = $_POST['S_lname'];
            $S_gender = $_POST['S_gender'];
            $S_address = $_POST['S_address'];
            $S_phone = $_POST['S_phone'];
            $S_health = $_POST['S_health'];
            $S_ralative_address = $_POST['S_ralative_address'];
            $R_ID = $_POST['R_ID'];

            if (preg_match('/[\d\s]/', $_POST['S_fname'])) {
                echo 'ชื่อไม่สามารถมีตัวเลขหรือช่องว่างได้';
                exit;
            }

            if (preg_match('/[\d\s]/', $_POST['S_lname'])) {
                echo 'นามสกุลไม่สามารถมีตัวเลขหรือช่องว่างได้';
                exit;
            }
            $sql = "SELECT room.* FROM room INNER JOIN teacher ON room.T_ID = teacher.T_ID WHERE room.R_ID = :R_ID";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':R_ID', $R_ID);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $T_ID = $result['T_ID'];

            $updateStmt = $conn->prepare("UPDATE student 
                      SET 
                          S_fname = :S_fname,
                          S_lname = :S_lname,
                          S_gender = :S_gender,
                          S_address = :S_address,
                          S_phone = :S_phone,
                          S_health = :S_health,
                          S_ralative_address = :S_ralative_address,
                          R_ID = :R_ID,
                           T_ID = :T_ID
                      WHERE S_ID = :S_ID");
            $updateStmt->bindParam(':S_fname', $S_fname, PDO::PARAM_STR);
            $updateStmt->bindParam(':S_lname', $S_lname, PDO::PARAM_STR);
            $updateStmt->bindParam(':S_gender', $S_gender, PDO::PARAM_STR);
            $updateStmt->bindParam(':S_address', $S_address, PDO::PARAM_STR);
            $updateStmt->bindParam(':S_phone', $S_phone, PDO::PARAM_STR);
            $updateStmt->bindParam(':S_health', $S_health, PDO::PARAM_STR);
            $updateStmt->bindParam(':S_ralative_address', $S_ralative_address, PDO::PARAM_STR);
            $updateStmt->bindParam(':R_ID', $R_ID, PDO::PARAM_STR);
            $updateStmt->bindParam(':T_ID', $T_ID, PDO::PARAM_STR);
            $updateStmt->bindParam(':S_ID', $S_ID, PDO::PARAM_STR);

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
