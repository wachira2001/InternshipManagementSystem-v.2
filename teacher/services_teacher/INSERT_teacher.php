<?php
require_once 'conndb.php';
try {
    if (
        isset(
            $_POST['T_ID'],
            $_POST['T_fname'],
            $_POST['T_lname'],
            $_POST['T_position'],
            $_POST['T_address'],
            $_POST['T_birthday'],
            $_FILES['T_img'],
            $_POST['T_status'],
            $_POST['T_phone'],
            $_POST['T_email'],
            $_POST['T_gender'],
            $_POST['T_password'],
            $_POST['T_username'],
//            $_POST['R_ID']
        )
    ) {
        // ดึงข้อมูลจาก $_POST
        $T_ID = $_POST['T_ID'];
        $T_fname = $_POST['T_fname'];
        $T_lname = $_POST['T_lname'];
        $T_position = $_POST['T_position'];
        $T_address = $_POST['T_address'];
        $T_birthday = $_POST['T_birthday'];
        $T_img = $_FILES['T_img'];
        $T_status = $_POST['T_status'];
        $T_phone = $_POST['T_phone'];
        $T_email = $_POST['T_email'];
        $T_gender = $_POST['T_gender'];
        $T_password = $_POST['T_password'];
        $T_username = $_POST['T_username'];
//        $R_ID = $_POST['R_ID'];

        // ตรวจสอบข้อมูลซ้ำในฐานข้อมูล
        $stmt = $conn->prepare("SELECT COUNT(*) as count FROM teacher WHERE T_ID = :T_ID or T_username = :T_username");
        $stmt->execute(array(':T_ID' => $T_ID, ':T_username' => $T_username));

        // ถ้ามีข้อมูลที่ซ้ำ
        if ($stmt->fetchColumn() > 0) {
            // แสดง SweetAlert2 สำหรับข้อมูลที่ซ้ำ
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    title: 'ข้อมูลที่ซ้ำ',
                    text: 'ข้อมูล T_ID หรือ T_username ซ้ำกับข้อมูลที่มีอยู่แล้ว',
                    icon: 'warning',
                    showConfirmButton: true
                }).then(function () {
                    window.location.href = 'register_teacher.php';
                });
            </script>";
            return;
        }

        // ตรวจสอบประเภทของไฟล์
        $filename = $_FILES['T_img']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);

        // อัปโหลดไฟล์
        $fileName = $T_ID . '.' . $ext;
        $targetFilePath = '../teacher/img/' . $fileName;
        move_uploaded_file($_FILES['T_img']['tmp_name'], $targetFilePath);

        // เพิ่มข้อมูลในฐานข้อมูล
        $insertStmt = $conn->prepare("INSERT INTO teacher (
                    T_ID, T_fname, T_lname, T_position, T_address, T_birthday, T_img, T_status, T_phone, T_email, T_gender, T_password, T_username
                ) VALUES (
                    :T_ID, :T_fname, :T_lname, :T_position, :T_address, :T_birthday, :T_img, :T_status, :T_phone, :T_email, :T_gender, :T_password, :T_username
                )");

        // กำหนดค่าพารามิเตอร์
        $insertStmt->bindParam(':T_ID', $T_ID, PDO::PARAM_STR);
        $insertStmt->bindParam(':T_fname', $T_fname, PDO::PARAM_STR);
        $insertStmt->bindParam(':T_lname', $T_lname, PDO::PARAM_STR);
        $insertStmt->bindParam(':T_position', $T_position, PDO::PARAM_STR);
        $insertStmt->bindParam(':T_address', $T_address, PDO::PARAM_STR);
        $insertStmt->bindParam(':T_birthday', $T_birthday, PDO::PARAM_STR);
        $insertStmt->bindParam(':T_img', $fileName, PDO::PARAM_STR);
        $insertStmt->bindParam(':T_status', $T_status, PDO::PARAM_STR);
        $insertStmt->bindParam(':T_phone', $T_phone, PDO::PARAM_STR);
        $insertStmt->bindParam(':T_email', $T_email, PDO::PARAM_STR);
        $insertStmt->bindParam(':T_gender', $T_gender, PDO::PARAM_STR);
        $insertStmt->bindParam(':T_password', $T_password, PDO::PARAM_STR);
        $insertStmt->bindParam(':T_username', $T_username, PDO::PARAM_STR);

        // ทำการเพิ่มข้อมูล
        if ($insertStmt->execute()) {
            // แสดง SweetAlert2 แจ้งว่าบันทึกข้อมูลสำเร็จ
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    title: 'สำเร็จ',
                    text: 'ลงทะเบียนเรียบร้อยแล้ว',
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
                    text: 'เกิดข้อผิดพลาดในลงทะเบียน',
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
