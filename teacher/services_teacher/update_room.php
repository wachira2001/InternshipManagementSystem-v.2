<?php
require_once 'conndb.php';
try {
    // ตรวจสอบว่ามีการส่งข้อมูลผ่าน POST request
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // ตรวจสอบข้อมูลที่ส่งมาจากฟอร์ม
        if (
            isset(
                $_POST['R_ID'],
                $_POST['R_level'],
                $_POST['R_level_number'],
                $_POST['R_room'],
                $_POST['T_ID']

            )
        ) {
            // ดึงข้อมูลจาก $_POST
            $R_ID = $_POST['R_ID'];
            $R_level = $_POST['R_level'];
            $R_level_number = $_POST['R_level_number'];
            $R_room = $_POST['R_room'];
            $T_ID = $_POST['T_ID'];

            // ตรวจสอบข้อมูลซ้ำในฐานข้อมูล
            $stmt = $conn->prepare("SELECT COUNT(*) as count FROM room WHERE T_ID = :T_ID");
            $stmt->execute(array(':T_ID' => $T_ID));

            // ถ้ามีข้อมูลที่ซ้ำ
            if ($stmt->fetchColumn() > 0) {
                // แสดง SweetAlert2 สำหรับข้อมูลที่ซ้ำ
                echo 'ไม่สามารถย้ายครูที่ปรึกษาได้ เนื่องจากเป็นที่ปรึกษาห้องอื่นอยู่';
                exit();
            }
            // ตรวจสอบข้อมูลซ้ำในฐานข้อมูล
            $stmt = $conn->prepare("SELECT COUNT(*) as count FROM room WHERE R_level = :R_level 
                                       AND R_level_number = :R_level_number AND R_room = :R_room AND T_ID = :T_ID AND R_ID = :R_ID");
            $stmt->execute(array(':R_level' => $R_level, ':R_level_number' => $R_level_number, ':R_room' => $R_room, ':T_ID' => $T_ID, ':R_ID' => $R_ID));

            // ถ้ามีข้อมูลที่ซ้ำ
            if ($stmt->fetchColumn() > 0) {
                // แสดง SweetAlert2 สำหรับข้อมูลที่ซ้ำ
                echo 'มีห้องนี้อยู่แล้ว';
                exit();
            }
            if ($R_level == 'ปวส.' && $R_level_number == '3')
            {
                echo 'ไม่สามรถเพิ่มชั้น ปวส.3 ได้ กรุณาเลือกใหม่';
                exit();
            }

            $updateRoomStmt = $conn->prepare("UPDATE room
                                          SET 
                                               R_level = :R_level,
                                               R_level_number = :R_level_number,
                                               R_room = :R_room,
                                               T_ID = :T_ID
                                          WHERE R_ID = :R_ID");
            $updateRoomStmt->bindParam(':R_level', $R_level, PDO::PARAM_STR);
            $updateRoomStmt->bindParam(':R_level_number', $R_level_number, PDO::PARAM_STR);
            $updateRoomStmt->bindParam(':T_ID', $T_ID, PDO::PARAM_STR);
            $updateRoomStmt->bindParam(':R_room', $R_room, PDO::PARAM_STR);
            $updateRoomStmt->bindParam(':R_ID', $R_ID, PDO::PARAM_STR);

            // ทำการเพิ่มข้อมูล
            if ($updateRoomStmt->execute()) {
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
