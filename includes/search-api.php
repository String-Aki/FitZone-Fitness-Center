<?php
header('Content-Type: application/json');

session_start();
include("./dbconnect.php");

$UID = $_GET['uid'] ?? NULL;
$role = $_GET['role'] ?? NULL;
$current_user = NULL;

if ($UID && isset($_SESSION['auth'][$role][$UID])) {
    $current_user = $_SESSION['auth'][$role][$UID];
}

if ($current_user === NULL) {
    echo json_encode(['error' => 'Authentication failed.']);
    exit();
}

$search_term = $_GET['query'] ?? '';
$results = [];

if (!empty($search_term)) {
    $search_keyword = "%" . trim($search_term) . "%";

    $fetch_customer = "SELECT User_ID, First_Name, Last_Name FROM users WHERE Role = 'customer' AND (First_Name LIKE ? OR Last_Name LIKE ?)";
    $stmt = $conn->prepare($fetch_customer);
    $stmt->bind_param("ss", $search_keyword, $search_keyword);
    $stmt->execute();
    $customers = $stmt->get_result();
    while ($row = $customers->fetch_assoc()) {
        $results[] = [
            'type' => 'Customer',
            'name' => $row['First_Name'] . ' ' . $row['Last_Name'],
            'url'  => './customer.php?uid=' . htmlspecialchars($UID)
        ];
    }
    $stmt->close();

    $appt_sql = "SELECT Appointment_ID, Session_Type, u.First_Name, u.Last_Name FROM appointments a JOIN users u ON a.User_ID = u.User_ID JOIN trainers t ON a.Trainer_ID = t.Trainer_ID WHERE t.User_ID = ? AND a.Session_Type LIKE ?";
    $stmt = $conn->prepare($appt_sql);
    $stmt->bind_param("is", $UID, $search_keyword);
    $stmt->execute();
    $appointments = $stmt->get_result();
    while ($row = $appointments->fetch_assoc()) {
        $results[] = [
            'type' => 'Appointment',
            'name' => $row['Session_Type'] . ' with ' . $row['First_Name'],
            'url'  => './appointments.php?uid=' . htmlspecialchars($UID)
        ];
    }
    $stmt->close();
    
    $message_sql = "SELECT m.Message_ID, m.Topic, u.First_Name 

                    FROM messages m 

                    JOIN users u ON m.User_ID = u.User_ID 

                    JOIN trainers t ON m.Recipient_ID = t.Trainer_ID 

                    WHERE t.User_ID = ? AND (m.Topic LIKE ? OR m.Message LIKE ?)";

    $stmt = $conn->prepare($message_sql);

    $stmt->bind_param("iss", $UID, $search_keyword, $search_keyword);

    $stmt->execute();

    $messages = $stmt->get_result();

    while ($row = $messages->fetch_assoc()) {

        $results[] = [

            'type' => 'Message',

            'name' => htmlspecialchars($row['Topic'] . ' from ' . $row['First_Name']),

            'url'  => './messages.php?uid=' . htmlspecialchars($UID)
        ];

    }

    $stmt->close();
}

$conn->close();

echo json_encode($results);
?>