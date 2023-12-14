<?php
session_start();
require_once('conndb.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $role = ''; // กำหนดตัวแปร role เพื่อให้ใส่ค่า role ที่ได้จากการค้นหา
    $data = ''; // กำหนดตัวแปร $data เพื่อให้ใส่ค่า ข้อมูล ที่ได้จากการค้นหา

    // ตรวจสอบข้อมูลในตาราง 'students'
    $stmt_student = $conn->prepare("SELECT * FROM student WHERE S_username = :S_username AND S_password = :S_password");
    $stmt_student->bindParam(':S_username', $username);
    $stmt_student->bindParam(':S_password', $password);
    $stmt_student->execute();

    if ($stmt_student->rowCount() > 0) {
        $student = $stmt_student->fetch(PDO::FETCH_ASSOC);
        $role = 'student';
        $data = $student ;
    }

    // ถ้าไม่เจอในตาราง 'students', ตรวจสอบในตาราง 'teachers'
    if (empty($role)) {
        $stmt_teacher = $conn->prepare("SELECT * FROM teacher WHERE T_username = :T_username AND T_password = :T_password ");
        $stmt_teacher->bindParam(':T_username', $username);
        $stmt_teacher->bindParam(':T_password', $password);
        $stmt_teacher->execute();

        if ($stmt_teacher->rowCount() > 0) {
            $teacher = $stmt_teacher->fetch(PDO::FETCH_ASSOC);
            $data =  $teacher;
            // ตรวจสอบระดับครู
            if ($teacher['T_status'] == 1) {
                $role = 'H'; // ถ้าเป็นหัวหน้าแผนก
            } else {
                $role = 'T'; // ถ้าเป็นครูปกติ

            }
        }
    }

    // ตรวจสอบ role และทำการล็อกอิน
    if (!empty($role)) {
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;
        $_SESSION['data'] = $data;
        if ($role == 'student') {
//            header("Location: student/index.php");
            echo 'student';
        } elseif ($role == 'H' || $role == 'T') {
//            header("Location: teacher/index.php");
            echo 'teacher';
        }
    } else {

//        echo '
//            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
//            <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
//            <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
//            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">';
//        echo "<script>
//                Swal.fire({
//                    title: 'ไม่มีชื่อผู้ใช้',
//                    icon: 'error'
//                }).then(function(){
//                    window.location.href = './login.php';
//                });
//            </script>";
        echo 'error';
    }
}
?>
