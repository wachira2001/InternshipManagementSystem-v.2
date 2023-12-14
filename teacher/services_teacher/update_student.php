<?php
include_once 'conndb.php';
try {
    // ตรวจสอบว่ามีข้อมูลที่จำเป็นหรือไม่
    if (
        isset(
            $_POST['S_ID'],
            $_POST['S_fname'],
            $_POST['S_lname'],
            $_POST['S_gender'],
            $_POST['S_birthday'],
            $_POST['S_address'],
            $_POST['S_phone'],
            $_POST['S_email'],
            $_POST['S_enrollment_term'],
            $_POST['S_enrollment_year'],
            $_POST['S_gpa'],
            $_POST['S_health'],
            $_POST['S_major'],
            $_POST['S_ralative_name'],
            $_POST['S_ralative_phone'],
            $_POST['S_ralative_address']
        )
    ) {
        $S_ID = $_POST['S_ID'];
        $S_fname = $_POST['S_fname'];
        $S_lname = $_POST['S_lname'];
        $S_gender = $_POST['S_gender'];
        $S_birthday = $_POST['S_birthday'];
        $S_address = $_POST['S_address'];
        $S_phone = $_POST['S_phone'];
        $S_email = $_POST['S_email'];
        $S_enrollment_term = $_POST['S_enrollment_term'];
        $S_enrollment_year = $_POST['S_enrollment_year'];
        $S_gpa = $_POST['S_gpa'];
        $S_health = $_POST['S_health'];
        $S_major = $_POST['S_major'];

        $S_ralative_name = $_POST['S_ralative_name'];
        $S_ralative_phone = $_POST['S_ralative_phone'];
        $S_ralative_address = $_POST['S_ralative_address'];
        // คำสั่ง SQL UPDATE
        $updateStmt = $conn->prepare("UPDATE student 
                      SET 
                          S_fname = :S_fname,
                          S_lname = :S_lname,
                          S_gender = :S_gender,
                          S_birthday = :S_birthday,
                          S_address = :S_address,
                          S_phone = :S_phone,
                          S_email = :S_email,
                          S_enrollment_term = :S_enrollment_term,
                          S_enrollment_year = :S_enrollment_year,
                          S_gpa = :S_gpa,
                          S_health = :S_health,
                          S_major = :S_major,
                          
                          S_ralative_name = :S_ralative_name,
                          S_ralative_phone = :S_ralative_phone,
                          S_ralative_address = :S_ralative_address
                      WHERE S_ID = :S_ID");
// กำหนดค่าพารามิเตอร์
        $updateStmt->bindParam(':S_fname', $S_fname, PDO::PARAM_STR);
        $updateStmt->bindParam(':S_lname', $S_lname, PDO::PARAM_STR);
        $updateStmt->bindParam(':S_gender', $S_gender, PDO::PARAM_STR);
        $updateStmt->bindParam(':S_birthday', $S_birthday, PDO::PARAM_STR);
        $updateStmt->bindParam(':S_address', $S_address, PDO::PARAM_STR);
        $updateStmt->bindParam(':S_phone', $S_phone, PDO::PARAM_STR);
        $updateStmt->bindParam(':S_email', $S_email, PDO::PARAM_STR);
        $updateStmt->bindParam(':S_enrollment_term', $S_enrollment_term, PDO::PARAM_STR);
        $updateStmt->bindParam(':S_enrollment_year', $S_enrollment_year, PDO::PARAM_STR);
        $updateStmt->bindParam(':S_gpa', $S_gpa, PDO::PARAM_STR);
        $updateStmt->bindParam(':S_health', $S_health, PDO::PARAM_STR);
        $updateStmt->bindParam(':S_major', $S_major, PDO::PARAM_STR);
        $updateStmt->bindParam(':S_ralative_name', $S_ralative_name, PDO::PARAM_STR);
        $updateStmt->bindParam(':S_ralative_phone', $S_ralative_phone, PDO::PARAM_STR);
        $updateStmt->bindParam(':S_ralative_address', $S_ralative_address, PDO::PARAM_STR);
        $updateStmt->bindParam(':S_ID', $S_ID, PDO::PARAM_STR);

        // ทำการ execute คำสั่ง SQL
        if ($updateStmt->execute()) {
            // แสดง SweetAlert2 แจ้งว่าปรับปรุงข้อมูลสำเร็จ
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    title: 'สำเร็จ',
                    text: 'ปรับปรุงข้อมูลนักเรียนเรียบร้อยแล้ว',
                    icon: 'success',
                    showConfirmButton: false,
                    timer: 5000
                }).then(function () {
                    window.location.href = '../CRUD/showdata_student.php';
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
