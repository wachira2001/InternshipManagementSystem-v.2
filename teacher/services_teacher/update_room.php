<?php
require_once 'conndb.php';

try {
    if (
        isset(
            $_POST['R_ID'],
            $_POST['R_level'],
            $_POST['R_level_number'],
            $_POST['R_room'],
            $_POST['T_ID']
        )
    ) {
        $R_ID = $_POST['R_ID'];
        $R_level = $_POST['R_level'];
        $R_level_number = $_POST['R_level_number'];
        $R_room = $_POST['R_room'];
        $T_ID = $_POST['T_ID'];

        // ตรวจสอบข้อมูลซ้ำในฐานข้อมูล
        $stmt = $conn->prepare("SELECT COUNT(*) as count FROM room WHERE R_level = :R_level 
                                       AND R_level_number = :R_level_number AND R_room = :R_room AND T_ID = :T_ID AND R_ID = :R_ID");
        $stmt->execute(array(':R_level' => $R_level, ':R_level_number' => $R_level_number, ':R_room' => $R_room, ':T_ID' => $T_ID, ':R_ID' => $R_ID));

        // ถ้ามีข้อมูลที่ซ้ำ
        if ($stmt->fetchColumn() > 0) {
            // แสดง SweetAlert2 สำหรับข้อมูลที่ซ้ำ
            echo 'duplicate';
            return;
        }

        // คำสั่ง SQL UPDATE สำหรับตาราง room
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

        if ($updateRoomStmt->execute()) {
            // ตรวจสอบว่ามีการอัปเดตบรรทัดใดบรรทัดหนึ่งหรือไม่
            if ($updateRoomStmt->rowCount() > 0) {
                echo "success";
            } else {
                echo "no_changes"; // ไม่มีการเปลี่ยนแปลง
            }
        } else {
            echo "error";
        }
    }
} catch (PDOException $e) {
    echo "<p>พบข้อผิดพลาด: " . $e->getMessage() . "</p>";
}

// ปิดการเชื่อมต่อกับฐานข้อมูล
$conn = null;
?>
