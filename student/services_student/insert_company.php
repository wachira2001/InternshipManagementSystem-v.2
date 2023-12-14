<?php
require_once 'conndb.php';
try {
    if (
        isset(
            $_POST['company_ID'],
            $_POST['C_name'],
            $_POST['C_telephone'],
            $_POST['C_website'],
            $_POST['C_staff_name'],
            $_POST['C_staff_position'],
            $_POST['C_staff_phone'],
            $_FILES['C_img'],
            $_POST['C_tambon'], // เพิ่มบรรทัดนี้
            $_POST['C_amphoe'], // เพิ่มบรรทัดนี้
            $_POST['C_province'] // เพิ่มบรรทัดนี้
        )
    ) {
        $company_ID = $_POST['company_ID'];
        $C_name = $_POST['C_name'];
        $C_telephone = $_POST['C_telephone'];
        $C_website = $_POST['C_website'];
        $C_staff_name = $_POST['C_staff_name'];
        $C_staff_position = $_POST['C_staff_position'];
        $C_staff_phone = $_POST['C_staff_phone'];
        $C_img = $_FILES['C_img'];
        $C_tambon = $_POST['C_tambon']; // เพิ่มบรรทัดนี้
        $C_amphoe = $_POST['C_amphoe']; // เพิ่มบรรทัดนี้
        $C_province = $_POST['C_province']; // เพิ่มบรรทัดนี้

        // ตรวจสอบข้อมูลซ้ำในฐานข้อมูล
        $stmt = $conn->prepare("SELECT COUNT(*) as count FROM company WHERE company_ID = :company_ID or C_name = :C_name");
        $stmt->execute(array(':company_ID' => $company_ID, ':C_name' => $C_name));

        if ($stmt->fetchColumn() > 0) {
            // แสดง SweetAlert2 สำหรับข้อมูลที่ซ้ำ
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    title: 'ข้อมูลที่ซ้ำ',
                    html: 'ข้อมูลบริษัทนี้มีอยู่แล้ว <br>สถานประกอบการ: {$C_name}',
                    icon: 'warning',
                    showConfirmButton: true
                }).then(function () {
                    window.location.href = '../crud/addFrom_request.php';
                });
            </script>";
            return;
        }

        // ตรวจสอบประเภทของไฟล์
        $filename = $_FILES['C_img']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);

        // อัปโหลดไฟล์
        $fileName = $company_ID . '.' . $ext;
        $targetFilePath = '../../upload_img/' . $fileName;
        move_uploaded_file($_FILES['C_img']['tmp_name'], $targetFilePath);

        // เพิ่มข้อมูลในฐานข้อมูล
        $insertStmt = $conn->prepare("INSERT INTO company (
                    company_ID, C_name, C_telephone, C_website, C_staff_name, C_staff_position, C_staff_phone, C_img, C_tambon, C_amphoe, C_province
                ) VALUES (
                    :company_ID, :C_name, :C_telephone, :C_website, :C_staff_name, :C_staff_position, :C_staff_phone, :C_img, :C_tambon, :C_amphoe, :C_province
                )");

        // กำหนดค่าพารามิเตอร์
        $insertStmt->bindParam(':company_ID', $company_ID, PDO::PARAM_STR);
        $insertStmt->bindParam(':C_name', $C_name, PDO::PARAM_STR);
        $insertStmt->bindParam(':C_telephone', $C_telephone, PDO::PARAM_STR);
        $insertStmt->bindParam(':C_website', $C_website, PDO::PARAM_STR);
        $insertStmt->bindParam(':C_staff_name', $C_staff_name, PDO::PARAM_STR);
        $insertStmt->bindParam(':C_staff_position', $C_staff_position, PDO::PARAM_STR);
        $insertStmt->bindParam(':C_staff_phone', $C_staff_phone, PDO::PARAM_STR);
        $insertStmt->bindParam(':C_img', $fileName, PDO::PARAM_STR);
        $insertStmt->bindParam(':C_tambon', $C_tambon, PDO::PARAM_STR); // เพิ่มบรรทัดนี้
        $insertStmt->bindParam(':C_amphoe', $C_amphoe, PDO::PARAM_STR); // เพิ่มบรรทัดนี้
        $insertStmt->bindParam(':C_province', $C_province, PDO::PARAM_STR); // เพิ่มบรรทัดนี้

        // ทำการเพิ่มข้อมูล
        if ($insertStmt->execute()) {
            // แสดง SweetAlert2 แจ้งว่าบันทึกข้อมูลสำเร็จ
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    title: 'สำเร็จ',
                    text: 'บันทึกข้อมูลบริษัทเรียบร้อยแล้ว',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 5000
                }).then(function () {
                    window.location.href = '../crud/addFrom_request.php';
                });
            </script>";
        } else {
            // แสดง SweetAlert2 กรณีเกิดข้อผิดพลาดในการบันทึกข้อมูล
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    title: 'ผิดพลาด',
                    text: 'เกิดข้อผิดพลาดในการบันทึกข้อมูล',
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
