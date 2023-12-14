<?php
require_once 'conndb.php';

try {
    if (isset(
        $_POST['M_ID'],
        $_POST['M_Name'],
        $_POST['M_college'],
        $_FILES['M_img'], // ตรวจสอบเฉพาะในกรณีที่มีการอัปเดตภาพ
        $_POST['M_address']
    )) {
        $M_ID = $_POST['M_ID'];
        $M_Name = $_POST['M_Name'];
        $M_college = $_POST['M_college'];
        $M_address = $_POST['M_address'];

        // ตรวจสอบว่ามีการเปลี่ยนแปลงในภาพหรือไม่
        if (!empty($_FILES['M_img']['name'])) {
            $filename = $_FILES['M_img']['name'];
            $ext = pathinfo($filename, PATHINFO_EXTENSION);
            $fileName = $M_ID.'.'.$ext;
            $targetFilePath ='../../../upload_img/'.$fileName;

            // อัปโหลดไฟล์
            move_uploaded_file($_FILES['M_img']['tmp_name'], $targetFilePath);
        } else {
            $sql = "SELECT * FROM major";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $fileName =  $result['M_img'];
        }
        $updateStmt = $conn->prepare("UPDATE major 
                                      SET 
                                          M_Name = :M_Name,
                                          M_college = :M_college,
                                          M_img = :M_img,
                                          M_address = :M_address
                                      WHERE M_ID = :M_ID");

        // กำหนดค่าพารามิเตอร์
        $updateStmt->bindParam(':M_Name', $M_Name, PDO::PARAM_STR);
        $updateStmt->bindParam(':M_college', $M_college, PDO::PARAM_STR);
        $updateStmt->bindParam(':M_img', $fileName, PDO::PARAM_STR);
        $updateStmt->bindParam(':M_address', $M_address, PDO::PARAM_STR);
        $updateStmt->bindParam(':M_ID', $M_ID, PDO::PARAM_STR);

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
                    window.location.href = '../crud/showdata_major.php';
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
