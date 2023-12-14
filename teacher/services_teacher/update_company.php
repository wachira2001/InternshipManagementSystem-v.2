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
            $_POST['C_tambon'],
            $_POST['C_amphoe'],
            $_POST['C_province']

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
        $C_tambon = $_POST['C_tambon'];
        $C_amphoe = $_POST['C_amphoe'];
        $C_province = $_POST['C_province'];

        // ตรวจสอบประเภทของไฟล์
        $filename = $_FILES['C_img']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        // อัปโหลดไฟล์
        $fileName = $company_ID . '.' . "jpg";
        $targetFilePath = '../../../upload_img/'. $fileName;
        move_uploaded_file($_FILES['C_img']['tmp_name'], $targetFilePath);

        // คำสั่ง SQL UPDATE
        $updateStmt = $conn->prepare("UPDATE company
                                      SET 
                                          C_name = :C_name,
                                          C_telephone = :C_telephone,
                                          C_website = :C_website,
                                          C_staff_name = :C_staff_name,
                                          C_staff_position = :C_staff_position,
                                          C_staff_phone = :C_staff_phone,
                                          C_img = :C_img,
                                          C_tambon = :C_tambon,
                                          C_amphoe = :C_amphoe,
                                          C_province = :C_province
                                      WHERE company_ID = :company_ID");

        // กำหนดค่าพารามิเตอร์

        $updateStmt->bindParam(':C_name', $C_name, PDO::PARAM_STR);
        $updateStmt->bindParam(':C_telephone', $C_telephone, PDO::PARAM_STR);
        $updateStmt->bindParam(':C_website', $C_website, PDO::PARAM_STR);
        $updateStmt->bindParam(':C_staff_name', $C_staff_name, PDO::PARAM_STR);
        $updateStmt->bindParam(':C_staff_position', $C_staff_position, PDO::PARAM_STR);
        $updateStmt->bindParam(':C_staff_phone', $C_staff_phone, PDO::PARAM_STR);
        $updateStmt->bindParam(':C_img', $fileName, PDO::PARAM_STR);
        $updateStmt->bindParam(':C_tambon', $C_tambon, PDO::PARAM_STR);
        $updateStmt->bindParam(':C_amphoe', $C_amphoe, PDO::PARAM_STR);
        $updateStmt->bindParam(':C_province', $C_province, PDO::PARAM_STR);
        $updateStmt->bindParam(':company_ID', $company_ID, PDO::PARAM_STR);

        // ทำการ execute คำสั่ง SQL
        if ($updateStmt->execute()) {
            // แสดง SweetAlert2 แจ้งว่าปรับปรุงข้อมูลสำเร็จ
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    title: 'สำเร็จ',
                    text: 'ปรับปรุงข้อมูลแผนกเรียบร้อยแล้ว',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 5000
                }).then(function () {
                    window.location.href = '../CRUD/showdata_company.php';
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
