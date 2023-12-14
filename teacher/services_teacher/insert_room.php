<?php
include_once 'conndb.php';
//print_r($_POST);
//return;
try {
    if (
        isset(
            $_POST['R_level'],
            $_POST['R_level_numder'],
            $_POST['R_room']
        )
    ) {


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
                    window.location.href = '../crud/showdata_room.php';
                });
            </script>";
            return;
        }
        // คำสั่ง SQL UPDATE สำหรับตาราง room
        $RoomStmt = $conn->prepare("INSERT INTO room (R_level, R_level_numder, R_room) VALUES (:R_level, :R_level_numder, :R_room)");

        $RoomStmt->bindParam(':R_level', $R_level, PDO::PARAM_STR);
        $RoomStmt->bindParam(':R_level_numder', $R_level_numder, PDO::PARAM_STR);
        $RoomStmt->bindParam(':R_room', $R_room, PDO::PARAM_STR);

        if ($RoomStmt->execute()) {
            // แสดง SweetAlert2 แจ้งว่าปรับปรุงข้อมูลสำเร็จ
            echo "
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <script>
                Swal.fire({
                    title: 'สำเร็จ',
                    text: 'เพิ่มห้องเรียบร้อยแล้ว',
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
                    text: 'เกิดข้อผิดพลาดในการเพิ่มข้อมูล',
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
