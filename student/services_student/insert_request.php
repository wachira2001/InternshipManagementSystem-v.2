<?php
require_once 'conndb.php';
//print_r($_POST);
//return;
try {
    if (
        isset(
            $_POST['request_id'],
            $_POST['RE_how'],
            $_POST['RE_reason'],
//            $_POST['RE_teacher_opinion'],
//            $_POST['RE_teacherH_opinion'],
//            $_POST['RE_commentH'],
//            $_POST['RE_comment'],
            $_POST['RE_status'],
            $_POST['S_ID'],
            $_POST['company_ID'],
            $_POST['RE_period']
        )
    ) {
        $request_id = $_POST['request_id'];
        $RE_how = $_POST['RE_how'];
        $RE_reason = $_POST['RE_reason'];
//        $RE_teacher_opinion = $_POST['RE_teacher_opinion'];
//        $RE_teacherH_opinion = $_POST['RE_teacherH_opinion'];
//        $RE_commentH = $_POST['RE_commentH'];
//        $RE_comment = $_POST['RE_comment'];
        $RE_status = $_POST['RE_status'];
        $S_ID = $_POST['S_ID'];
        $company_ID = $_POST['company_ID'];
        $RE_period = $_POST['RE_period'];

        //ตรวจสอบจำนวนรายการที่มี company_ID เท่ากับค่าที่ส่งมา และมีจำนวนรายการที่ company_ID ซ้ำมากกว่า 3
        $stmt = $conn->prepare("SELECT COUNT(*) as count_company_id FROM request WHERE company_ID = :company_ID ");
        $stmt->execute(array(':company_ID' => $company_ID));
        $result_company_id = $stmt->fetch(PDO::FETCH_ASSOC);
        $count_company_id = $result_company_id['count_company_id'];

        $stmt = $conn->prepare("SELECT COUNT(*) as count FROM request WHERE request_id = :request_id AND RE_status = '0'");
        $stmt1 = $conn->prepare("SELECT COUNT(*) as count FROM request WHERE RE_status = :RE_status");
        $stmt->execute(array(':request_id' => $request_id));
        $stmt1->execute(array(':RE_status' => $RE_status));

        if ($stmt->fetchColumn() > 0) {
            // แสดง SweetAlert2 สำหรับข้อมูลที่ซ้ำ
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    title: 'แจ้งเตือน',
                    text: 'ท่านเคยลงสถานประกอบการนี้แล้วกรุณาลงสถานที่ใหม่',
                    icon: 'warning',
                    showConfirmButton: true
                }).then(function () {
                    window.location.href = '../CRUD/addFrom_request.php';
                });
            </script>";
            return;

        } elseif ($count_company_id > 3) {
            // แจ้งเตือน company_ID ซ้ำเกิน 3 รายการ
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    title: 'แจ้งเตือน',
                    text: 'สถานประกอบการนี้เต็มแล้ว',
                    icon: 'warning',
                    showConfirmButton: true
                }).then(function () {
                    window.location.href = '../CRUD/addFrom_request.php';
                });
            </script>";
            return;

        } elseif ($stmt1->fetchColumn() > 0 ) {
            // แจ้งเตือน company_ID ซ้ำเกิน 3 รายการ
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    title: 'แจ้งเตือน',
                    text: 'ท่านยื่นคำขอแล้วกรุณารอครูที่ปรึกษาและหัวหน้าแผนกอนุมัติ',
                    icon: 'warning',
                    showConfirmButton: true
                }).then(function () {
                    window.location.href = '../CRUD/addFrom_request.php';
                });
            </script>";
            return;

        }

        // เพิ่มข้อมูลในฐานข้อมูล
        $insertStmt = $conn->prepare("INSERT INTO request (
                    request_id, RE_how, RE_reason, RE_status, S_ID, company_ID,RE_period
                ) VALUES (
                    :request_id, :RE_how, :RE_reason,:RE_status, :S_ID, :company_ID,:RE_period
                )");

        // กำหนดค่าพารามิเตอร์
        $insertStmt->bindParam(':request_id', $request_id, PDO::PARAM_STR);
        $insertStmt->bindParam(':RE_how', $RE_how, PDO::PARAM_STR);
        $insertStmt->bindParam(':RE_reason', $RE_reason, PDO::PARAM_STR);
//        $insertStmt->bindParam(':RE_teacher_opinion', $RE_teacher_opinion, PDO::PARAM_STR);
//        $insertStmt->bindParam(':RE_teacherH_opinion', $RE_teacherH_opinion, PDO::PARAM_STR);
//        $insertStmt->bindParam(':RE_commentH', $RE_commentH, PDO::PARAM_STR);
//        $insertStmt->bindParam(':RE_comment', $RE_comment, PDO::PARAM_STR);
        $insertStmt->bindParam(':RE_status', $RE_status, PDO::PARAM_STR);
        $insertStmt->bindParam(':S_ID', $S_ID, PDO::PARAM_STR);
        $insertStmt->bindParam(':RE_period', $RE_period, PDO::PARAM_STR);
        $insertStmt->bindParam(':company_ID', $company_ID, PDO::PARAM_STR);

        // ทำการเพิ่มข้อมูล
        if ($insertStmt->execute()) {
            // แสดง SweetAlert2 แจ้งว่าบันทึกข้อมูลสำเร็จ
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    title: 'สำเร็จ',
                    text: 'ยื่นคำขอเสร็จเรียบร้อย',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 5000
                }).then(function () {
                    window.location.href = '../index.php';
                });
            </script>";
        } else {
            // แสดง SweetAlert2 กรณีเกิดข้อผิดพลาดในการบันทึกข้อมูล
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    title: 'ผิดพลาด',
                    text: 'เกิดข้อผิดพลาดในการยื่นคำขอบันทึกข้อมูล',
                    icon: 'error',
                    showConfirmButton: true
                });
            </script>";
        }
    }
} catch (PDOException $e) {
    // แสดง SweetAlert2 กรณีเกิด Exception
    echo "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script>
        Swal.fire({
            title: 'ผิดพลาด',
            text: 'เกิดข้อผิดพลาด: {$e->getMessage()}',
            icon: 'error',
            showConfirmButton: true
        });
    </script>";
}
?>
