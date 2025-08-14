<?php
session_start();
include("../../includes/dbconnect.php");
header('Content-Type: application/json');

$response = ['success' => false];

if(isset($_POST['delete_id'])){
    $delete_id = $_POST['delete_id'];
    $stmt = $conn->prepare("DELETE FROM users WHERE User_ID = ?");
    $stmt->bind_param("i", $delete_id);

    if($stmt->execute()){
        $response['success'] = true;
    }
    $stmt->close();
    $conn->close();

    echo json_encode($response);
    exit();

}
?>