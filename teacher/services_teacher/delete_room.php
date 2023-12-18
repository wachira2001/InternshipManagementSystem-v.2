<?php
require_once 'conndb.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $R_ID = $_POST['R_ID'];
    try {
        $stmt = $conn->prepare("DELETE FROM room WHERE R_ID = :R_ID");
        $stmt->bindParam(':R_ID', $R_ID);

        if ($stmt->execute()) {
            echo 'success';
        } else {
            echo 'ไม่สามารถลบได้';
        }
    } catch (PDOException $e) {
        // ดักจับข้อผิดพลาดที่เกิดขึ้นจากการลบที่มีข้อมูลอ้างอิง
        if ($e->errorInfo[1] == 1451) {
            echo 'ไม่สามารถลบได้เนื่องจาก ข้อมูลดังกล่าวนำไปใช้ในส่วนอื่น';
        } else {
            echo 'เกิดข้อผิดพลาด: ' . $e->getMessage();
        }
    }
} else {
    echo 'Invalid Request';
}

?>
