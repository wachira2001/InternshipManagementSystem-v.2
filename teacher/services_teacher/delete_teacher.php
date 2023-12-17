<?php
require_once 'conndb.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $T_ID = $_POST['T_ID'];

    try {
        $stmt = $conn->prepare("DELETE FROM teacher WHERE T_ID = :T_ID");
        $stmt->bindParam(':T_ID', $T_ID);

        if ($stmt->execute()) {
            echo 'success';
        } else {
            echo 'ไม่สามารถลบได้';
        }
    } catch (PDOException $e) {
        // ดักจับข้อผิดพลาดที่เกิดขึ้นจากการลบที่มีข้อมูลอ้างอิง
        if ($e->errorInfo[1] == 1451) {
            echo 'ไม่สามารถลบได้เนื่องจากมีข้อมูลอื่นเชื่อมอยู่';
        } else {
            echo 'เกิดข้อผิดพลาด: ' . $e->getMessage();
        }
    }
} else {
    echo 'Invalid Request';
}
?>
