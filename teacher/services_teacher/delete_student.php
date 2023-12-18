<?php
require_once 'conndb.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $S_ID = $_POST['S_ID'];

    try {
        $stmt = $conn->prepare("DELETE FROM student WHERE S_ID = :S_ID");
        $stmt->bindParam(':S_ID', $S_ID);

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
