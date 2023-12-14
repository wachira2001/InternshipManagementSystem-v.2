<?php
include_once 'conndb.php';
try {
    // ตรวจสอบว่ามีข้อมูลที่จำเป็นหรือไม่
    if (
        isset(
            $_POST['T_ID'],
            $_POST['T_fname'],
            $_POST['T_lname'],
            $_POST['T_position'],
            $_POST['T_birthday'],
            $_POST['T_status'],
            $_POST['T_phone'],
            $_POST['T_email'],
            $_POST['T_username'],
            $_POST['T_password'],
            $_POST['T_address']
        )
    ) {
        $T_ID = $_POST['T_ID'];
        $T_fname =  $_POST['T_fname'];
        $T_lname = $_POST['T_lname'];
        $T_position = $_POST['T_position'];
        $T_birthday = $_POST['T_birthday'];
        $T_address = $_POST['T_address'];
        $T_status = $_POST['T_status'];
        $T_phone = $_POST['T_phone'];
        $T_email = $_POST['T_email'];
        $T_username = $_POST['T_username'];
        $T_password = $_POST['T_password'];

        // คำสั่ง SQL UPDATE
        $updateStmt = $conn->prepare("UPDATE teacher 
                          SET 
                              T_fname = :T_fname,
                              T_lname = :T_lname,
                              T_position = :T_position,
                              T_birthday = :T_birthday,
                              T_address = :T_address,
                              T_status = :T_status,
                              T_phone = :T_phone,
                              T_email = :T_email, 
                              T_username = :T_username,
                              T_password = :T_password
                          WHERE T_ID = :T_ID");
        // กำหนดค่าพารามิเตอร์
        $updateStmt->bindParam(':T_fname', $T_fname, PDO::PARAM_STR);
        $updateStmt->bindParam(':T_lname', $T_lname, PDO::PARAM_STR);
        $updateStmt->bindParam(':T_position', $T_position, PDO::PARAM_STR);
        $updateStmt->bindParam(':T_birthday', $T_birthday, PDO::PARAM_STR);
        $updateStmt->bindParam(':T_address', $T_address, PDO::PARAM_STR);
        $updateStmt->bindParam(':T_status', $T_status, PDO::PARAM_STR);
        $updateStmt->bindParam(':T_phone', $T_phone, PDO::PARAM_STR);
        $updateStmt->bindParam(':T_email', $T_email, PDO::PARAM_STR);
        $updateStmt->bindParam(':T_username', $T_username, PDO::PARAM_STR);
        $updateStmt->bindParam(':T_password', $T_password, PDO::PARAM_STR);
        $updateStmt->bindParam(':T_ID', $T_ID, PDO::PARAM_STR);

        // ทำการ execute คำสั่ง SQL
        if ($updateStmt->execute()) {
            // แสดง SweetAlert2 แจ้งว่าปรับปรุงข้อมูลสำเร็จ
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    title: 'สำเร็จ',
                    text: 'ปรับปรุงข้อมูลบุคลากรเรียบร้อยแล้ว',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 5000
                }).then(function () {
                    window.location.href = '../CRUD/showdata_teacher.php';
                });
            </script>";

        } else {
            // แสดง SweetAlert2 กรณีเกิดข้อผิดพลาดในการปรับปรุงข้อมูล
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    title: 'ผิดพลาด',
                    text: 'เกิดข้อผิดพลาดในการปรับปรุงข้อมูล',
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
