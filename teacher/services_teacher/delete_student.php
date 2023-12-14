<?php
require_once 'conndb.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $S_ID = $_POST['S_ID'];

    $stmt = $conn->prepare("DELETE FROM student WHERE S_ID = :S_ID");
    $stmt->bindParam(':S_ID', $S_ID);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }
} else {
    echo 'Invalid Request';
}
?>
