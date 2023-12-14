<?php
require_once 'conndb.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $R_ID = $_POST['R_ID'];

    $stmt = $conn->prepare("DELETE FROM room WHERE R_ID = :R_ID");
    $stmt->bindParam(':R_ID', $R_ID);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }
} else {
    echo 'Invalid Request';
}
?>
