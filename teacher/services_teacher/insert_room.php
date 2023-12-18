<?php
include_once 'conndb.php';
//print_r($_POST);
//return;
try {
    if (
        isset(
            $_POST['R_level'],
            $_POST['R_level_number'],
            $_POST['R_room'],
            $_POST['T_ID']
        )
    ) {


        $R_level = $_POST['R_level'];
        $R_level_number = $_POST['R_level_number'];
        $R_room = $_POST['R_room'];
        $T_ID =  $_POST['T_ID'];

        // ตรวจสอบข้อมูลซ้ำในฐานข้อมูล
        $stmt = $conn->prepare("SELECT COUNT(*) as count FROM room WHERE R_level = :R_level 
                                       AND R_level_number = :R_level_number AND R_room = :R_room OR T_ID = :T_ID");
        $stmt->execute(array(':R_level' => $R_level, ':R_level_number' => $R_level_number, ':R_room' => $R_room,':T_ID' => $T_ID));

        // ถ้ามีข้อมูลที่ซ้ำ
        if ($stmt->fetchColumn() > 0) {
            // แสดง SweetAlert2 สำหรับข้อมูลที่ซ้ำ
                echo 'duplicate';
            return;
        }
        if ($R_level == 'ปวส.' && $R_level_number == '3')
        {
            echo 'ไม่สามรถเพิ่มชั้น ปวส.3 ได้ กรุณาเลือกใหม่';
            exit();
        }







        // คำสั่ง SQL UPDATE สำหรับตาราง room
        $RoomStmt = $conn->prepare("INSERT INTO room (R_level, R_level_number, R_room,T_ID) VALUES (:R_level, :R_level_number, :R_room,:T_ID)");

        $RoomStmt->bindParam(':R_level', $R_level, PDO::PARAM_STR);
        $RoomStmt->bindParam(':R_level_number', $R_level_number, PDO::PARAM_STR);
        $RoomStmt->bindParam(':R_room', $R_room, PDO::PARAM_STR);
        $RoomStmt->bindParam(':T_ID', $T_ID, PDO::PARAM_STR);

        if ($RoomStmt->execute()) {
            echo "success";
        } else {
            echo "error";
        }

    } else {
        echo "กรุณากรอกข้อมูลให้ครบ";
    }

} catch (PDOException $e) {
    // แสดงข้อความ Error ในหน้า HTML
    echo "<p>พบข้อผิดพลาด: " . $e->getMessage() . "</p>";
}
?>
