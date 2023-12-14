<?php
require_once 'conndb.php';

try {
    if (
        isset(
            $_POST['R_ID'],
            $_POST['R_level'],
            $_POST['R_level_numder'],
            $_POST['R_room']


        )
    ) {
        $R_ID = $_POST['R_ID'];
        $R_level = $_POST['R_level'];
        $R_level_numder = $_POST['R_level_numder'];
        $R_room = $_POST['R_room'];

        // ตรวจสอบข้อมูลซ้ำในฐานข้อมูล
        $stmt = $conn->prepare("SELECT COUNT(*) as count FROM room WHERE R_level = :R_level 
                                       AND R_level_numder = :R_level_numder AND R_room = :R_room");
        $stmt->execute(array(':R_level' => $R_level, ':R_level_numder' => $R_level_numder, ':R_room' => $R_room));

        // ถ้ามีข้อมูลที่ซ้ำ
        if ($stmt->fetchColumn() > 0) {
            // แสดง SweetAlert2 สำหรับข้อมูลที่ซ้ำ
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    title: 'ข้อมูลที่ซ้ำ',
                    text: 'ข้อมูลซ้ำกับข้อมูลที่มีอยู่แล้ว',
                    icon: 'warning',
                    showConfirmButton: true
                }).then(function () {
                    window.location.href = '../crud/editFrom_room.php?R_ID=$R_ID';
                });
            </script>";
            return;
        }

        // คำสั่ง SQL UPDATE สำหรับตาราง room
        $updateRoomStmt = $conn->prepare("UPDATE room
                                          SET 
                                               R_level = :R_level,
                                               R_level_numder = :R_level_numder,
                                               R_room = :R_room
                                          WHERE R_ID = :R_ID");
        $updateRoomStmt->bindParam(':R_level', $R_level, PDO::PARAM_STR);
        $updateRoomStmt->bindParam(':R_level_numder', $R_level_numder, PDO::PARAM_STR);
        $updateRoomStmt->bindParam(':R_room', $R_room, PDO::PARAM_STR);
        $updateRoomStmt->bindParam(':R_ID', $R_ID, PDO::PARAM_STR);

        if ($updateRoomStmt->execute()) {
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
                    window.location.href = '../CRUD/showdata_room.php';
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
