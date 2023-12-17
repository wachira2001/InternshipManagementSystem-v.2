<?php
require_once 'conndb.php';
//print_r($_POST);
//return;
try {
    // ตรวจสอบว่ามีการส่งข้อมูลผ่าน POST request
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // ตรวจสอบข้อมูลที่ส่งมาจากฟอร์ม
        if (
            isset(
                $_POST['request_id'],
                $_POST['RE_how'],
                $_POST['RE_reason'],
                $_POST['RE_status'],
                $_POST['S_ID'],
                $_POST['company_ID'],
                $_POST['RE_period']
            )
        ) {
            $request_id = $_POST['request_id'];
            $RE_how = $_POST['RE_how'];
            $RE_reason = $_POST['RE_reason'];
            $RE_status = $_POST['RE_status'];
            $S_ID = $_POST['S_ID'];
            $company_ID = $_POST['company_ID'];
            $RE_period = $_POST['RE_period'];


            $stmt = $conn->prepare("SELECT COUNT(*) as count_company_id FROM request WHERE company_ID = :company_ID ");
            $stmt->execute(array(':company_ID' => $company_ID));
            $result_company_id = $stmt->fetch(PDO::FETCH_ASSOC);
            $count_company_id = $result_company_id['count_company_id'];

            $stmt = $conn->prepare("SELECT COUNT(*) as count FROM request WHERE request_id = :request_id AND RE_status = '0'");
            $stmt1 = $conn->prepare("SELECT COUNT(*) as count FROM request WHERE RE_status = '1' AND S_ID = :S_ID");
            $stmt->execute(array(':request_id' => $request_id));
            $stmt1->execute(array(':S_ID' => $S_ID));

            if ($stmt->fetchColumn() > 0) {
                // แสดง SweetAlert2 สำหรับข้อมูลที่ซ้ำ
                echo 'ท่านเคยลงสถานประกอบการนี้แล้วกรุณาลงสถานที่ใหม่';
                exit();

            } elseif ($count_company_id > 3) {
                echo 'สถานประกอบการนี้เต็มแล้วไม่สารถลงทะเบียนได้';
                exit();

            } elseif ($stmt1->fetchColumn() > 0 ) {
                echo 'ท่านยื่นคำขอแล้วกรุณารอครูที่ปรึกษาและหัวหน้าแผนกอนุมัติ';
                exit();

            }
            $insertStmt = $conn->prepare("INSERT INTO request (
                    request_id, RE_how, RE_reason, RE_status, S_ID, company_ID,RE_period
                ) VALUES (
                    :request_id, :RE_how, :RE_reason,:RE_status, :S_ID, :company_ID,:RE_period
                )");

            // กำหนดค่าพารามิเตอร์
            $insertStmt->bindParam(':request_id', $request_id, PDO::PARAM_STR);
            $insertStmt->bindParam(':RE_how', $RE_how, PDO::PARAM_STR);
            $insertStmt->bindParam(':RE_reason', $RE_reason, PDO::PARAM_STR);
            $insertStmt->bindParam(':RE_status', $RE_status, PDO::PARAM_STR);
            $insertStmt->bindParam(':S_ID', $S_ID, PDO::PARAM_STR);
            $insertStmt->bindParam(':RE_period', $RE_period, PDO::PARAM_STR);
            $insertStmt->bindParam(':company_ID', $company_ID, PDO::PARAM_STR);
            // ทำการเพิ่มข้อมูล
            if ($insertStmt->execute()) {
                // แสดง SweetAlert2 แจ้งว่าบันทึกข้อมูลสำเร็จ
                echo 'success';
            } else {
                // แสดง SweetAlert2 กรณีเกิดข้อผิดพลาดในการบันทึกข้อมูล
                echo 'เกิดข้อผิดพลาดในการยื่นคำขอ';
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
