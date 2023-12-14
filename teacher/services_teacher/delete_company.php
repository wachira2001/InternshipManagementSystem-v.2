<?php
require_once 'conndb.php';

try {
    if (isset($_GET['company_ID'])) {
        $company_ID = $_GET['company_ID'];

        // ใช้ parameterized query เพื่อป้องกัน SQL injection
        $deleteStmt = $conn->prepare("DELETE FROM company WHERE company_ID = :company_ID");
        $deleteStmt->bindParam(':company_ID', $company_ID, PDO::PARAM_STR);
        $deleteStmt->execute();

        // ตรวจสอบว่าการลบเสร็จสมบูรณ์หรือไม่
        if ($deleteStmt->rowCount() > 0) {
            // การลบเสร็จสมบูรณ์
            echo "
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <script>
                    Swal.fire({
                        title: 'สำเร็จ',
                        text: 'ลบข้อมูลเรียบร้อยแล้ว',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 5000
                    }).then(function () {
                        window.location.href = '../CRUD/showdata_company.php';
                    });
                </script>";
        } else {
            // ไม่มีบันทึกถูกลบ
            echo "
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                <script>
                    Swal.fire({
                        title: 'ผิดพลาด',
                        text: 'ไม่มีบันทึกถูกลบ',
                        icon: 'error',
                        showConfirmButton: true
                    });
                </script>";
        }
    }
} catch (PDOException $e) {
    // จัดการกับข้อผิดพลาด
    echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            Swal.fire({
                title: 'ผิดพลาด',
                text: 'ข้อผิดพลาด: {$e->getMessage()}',
                icon: 'error',
                showConfirmButton: true
            });
        </script>";
}
?>
