<?php
session_start();
include_once 'conndb.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $request_id = $_POST['request_id'];
    $T_ID = $_SESSION['data']['T_ID'];

    $stmt = $conn->prepare("SELECT request.*, student.S_ID, teacher.T_ID 
                        FROM request
                        INNER JOIN student ON student.S_ID = request.S_ID
                        INNER JOIN teacher ON teacher.T_ID = student.T_ID
                        WHERE student.T_ID = :T_ID AND request.S_ID = student.S_ID");

    $stmt->execute(array(':T_ID' => $T_ID));
    $resultsT_ID = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($_SESSION['role'] == 'T' && $_POST['RE_status'] != '') {
        // กรณีครู
        $request_id = $_POST['request_id'];
        $RE_teacher_opinion = $_POST['RE_teacher_opinion'];
        $RE_comment = $_POST['RE_comment'];
        $RE_status = $_POST['RE_status'];

        $stmt = $conn->prepare("UPDATE request SET RE_teacher_opinion = :RE_teacher_opinion, RE_comment = :RE_comment, RE_status = :RE_status WHERE request_id = :request_id");
        $stmt->bindParam(':RE_teacher_opinion', $RE_teacher_opinion);
        $stmt->bindParam(':RE_comment', $RE_comment);
        $stmt->bindParam(':RE_status', $RE_status);
        $stmt->bindParam(':request_id', $request_id, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo 'success';
        } else {
            echo 'error';
        }
    } elseif ($_SESSION['role'] == 'H' && isset($resultsT_ID['request_id']) && $resultsT_ID['request_id'] == $_POST['request_id']) {
        // กรณีหัวหน้าแผนกที่เป็นที่ปรึกษาด้วย
        $request_id = $_POST['request_id'];
        $RE_teacherH_opinion = $_POST['RE_teacherH_opinion'];
        $RE_commentH = $_POST['RE_commentH'];
        $RE_status = $_POST['RE_status'];
        $RE_teacher_opinion = $_POST['RE_teacherH_opinion'];
        $RE_comment = $_POST['RE_commentH'];

        $stmt = $conn->prepare("UPDATE request SET 
        RE_teacherH_opinion = :RE_teacherH_opinion, 
        RE_commentH = :RE_commentH,
        RE_teacher_opinion = :RE_teacher_opinion, 
        RE_comment = :RE_comment, 
        RE_status = :RE_status 
        WHERE request_id = :request_id");

        $stmt->bindParam(':RE_teacherH_opinion', $RE_teacherH_opinion);
        $stmt->bindParam(':RE_commentH', $RE_commentH);
        $stmt->bindParam(':RE_teacher_opinion', $RE_teacher_opinion);
        $stmt->bindParam(':RE_comment', $RE_comment);
        $stmt->bindParam(':RE_status', $RE_status);
        $stmt->bindParam(':request_id', $request_id, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo 'success';
        } else {
            echo 'error';
        }
    } elseif ($_SESSION['role'] == 'H' && !isset($resultsT_ID['request_id'])) {
        // กรณีหัวหน้าแผนก
        $request_id = $_POST['request_id'];
        $RE_teacherH_opinion = $_POST['RE_teacherH_opinion'];
        $RE_commentH = $_POST['RE_commentH'];
        $RE_status = $_POST['RE_status'];

        $stmt = $conn->prepare("UPDATE request SET RE_teacherH_opinion = :RE_teacherH_opinion, RE_commentH = :RE_commentH, RE_status = :RE_status WHERE request_id = :request_id");
        $stmt->bindParam(':RE_teacherH_opinion', $RE_teacherH_opinion);
        $stmt->bindParam(':RE_commentH', $RE_commentH);
        $stmt->bindParam(':RE_status', $RE_status);
        $stmt->bindParam(':request_id', $request_id, PDO::PARAM_STR);

        if ($stmt->execute()) {
            echo 'success';
        } else {
            echo 'error';
        }
    }
} else {
    echo 'Invalid Request';
}
?>
