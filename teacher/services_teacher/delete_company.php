<?php
require_once 'conndb.php';

require_once 'conndb.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $company_ID = $_POST['company_ID'];
    try {
        $stmt = $conn->prepare("DELETE FROM company WHERE company_ID = :company_ID");
        $stmt->bindParam(':company_ID', $company_ID, PDO::PARAM_STR);

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
