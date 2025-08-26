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

    if($role === 'staff'){

    $fetch_customer = "SELECT User_ID, First_Name, Last_Name FROM users WHERE Role = 'customer' AND (First_Name LIKE ? OR Last_Name LIKE ?)";

    $stmt = $conn->prepare($fetch_customer);

    $stmt->bind_param("ss", $search_keyword, $search_keyword);

    $stmt->execute();

    $customers = $stmt->get_result();

    while ($row = $customers->fetch_assoc()) {

        $results[] = [

            'type' => 'Customer',

            'name' => $row['First_Name'] . ' ' . $row['Last_Name'],

            'url'  => './customer.php?uid=' . htmlspecialchars($UID).'&header_title=Customer Management',

            'id'   => $row['User_ID']

        ];
    }
    $stmt->close();

    $appt_sql = "SELECT Appointment_ID, Status, Session_Type, u.First_Name, u.Last_Name FROM appointments a JOIN users u ON a.User_ID = u.User_ID JOIN trainers t ON a.Trainer_ID = t.Trainer_ID WHERE t.User_ID = ? AND (a.Session_Type LIKE ? OR a.Status LIKE ?)";

    $stmt = $conn->prepare($appt_sql);

    $stmt->bind_param("iss", $UID, $search_keyword, $search_keyword);

    $stmt->execute();

    $appointments = $stmt->get_result();

    while ($row = $appointments->fetch_assoc()) {

        $results[] = [

            'type' => 'Appointment',

            'name' => $row['Session_Type'] . ' with ' . $row['First_Name'],

            'url'  => $row['Status'] == 'pending' ? './dashboard.php?uid='. htmlspecialchars($UID) : './appointments.php?uid=' . htmlspecialchars($UID).'&header_title=Appointments',

            'id'   => $row['Appointment_ID']

        ];

    }
    $stmt->close();
    
    $message_sql = "SELECT m.Message_ID, m.Status, m.Topic, u.First_Name 

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

            'url'  => $row['Status'] == 'pending' ? './dashboard.php?uid='. htmlspecialchars($UID) : './messages.php?uid=' . htmlspecialchars($UID).'&header_title=Messages',

            'id'   => $row['Message_ID']
        ];

    }
    $stmt->close();

    $membership_sql = "SELECT memberships.Membership_ID, memberships.Plan_Type, memberships.Status, users.First_Name, users.User_ID FROM memberships JOIN users ON memberships.User_ID = users.User_ID WHERE Plan_Type LIKE ? OR Status LIKE ?";

    $stmt = $conn->prepare($membership_sql);

    $stmt->bind_param("ss", $search_keyword, $search_keyword);

    $stmt->execute();

    $membership = $stmt->get_result();

    while ($row = $membership->fetch_assoc()) {

        $results[] =[

            'type' => 'Membership',

            'name' => htmlspecialchars($row['Plan_Type']). " " .htmlspecialchars($row['Status']).' for '. htmlspecialchars($row['First_Name']),

            'url' => $row['Status'] == 'Not Approved' ? './dashboard.php?uid='.htmlspecialchars($UID) : './customer.php?uid='. htmlspecialchars($UID),

            'id'   => $row['Status'] == 'Not Approved' ? $row['Membership_ID'] : $row['User_ID']

        ];

    }
    $stmt->close();

}

    elseif($role === 'admin'){
        
        $fetch_customer = "SELECT User_ID, First_Name, Last_Name FROM users WHERE Role = 'customer' AND (First_Name LIKE ? OR Last_Name LIKE ?)";

        $stmt = $conn->prepare($fetch_customer);

        $stmt->bind_param("ss", $search_keyword, $search_keyword);

        $stmt->execute();

        $customers = $stmt->get_result();

        while ($row = $customers->fetch_assoc()) {

            $results[] = [

                'type' => 'Customer',

                'name' => $row['First_Name'] . ' ' . $row['Last_Name'],

                'url'  => './customer.php?uid=' . htmlspecialchars($UID).'&header_title=Customer Management',

                'id'   => $row['User_ID']
            ];
        }
        $stmt->close();

        $appt_sql = "SELECT Appointment_ID, Status, Session_Type, u.First_Name, u.Last_Name FROM appointments a JOIN users u ON a.User_ID = u.User_ID JOIN trainers t ON a.Trainer_ID = t.Trainer_ID WHERE Status = 'pending' AND (a.Session_Type LIKE ? OR t.Name LIKE ?)";

        $stmt = $conn->prepare($appt_sql);

        $stmt->bind_param("ss", $search_keyword, $search_keyword);

        $stmt->execute();

        $appointments = $stmt->get_result();

        while ($row = $appointments->fetch_assoc()) {

            $results[] = [

                'type' => 'Appointment',

                'name' => $row['Session_Type'] . ' with ' . $row['First_Name'],

                'url'  => './dashboard.php?uid='. htmlspecialchars($UID),

                'id'   => $row['Appointment_ID']

            ];
        }
        $stmt->close();

        $membership_sql = "SELECT memberships.Membership_ID, memberships.Plan_Type, memberships.Status, users.First_Name FROM memberships JOIN users ON memberships.User_ID = users.User_ID WHERE Plan_Type LIKE ? OR Status LIKE ?";

        $stmt = $conn->prepare($membership_sql);

        $stmt->bind_param("ss", $search_keyword, $search_keyword);

        $stmt->execute();

        $membership = $stmt->get_result();

        while ($row = $membership->fetch_assoc()) {

            $results[] =[

                'type' => 'Membership',

                'name' => htmlspecialchars($row['Plan_Type']). " " .htmlspecialchars($row['Status']).' for '. htmlspecialchars($row['First_Name']),

                'url' => './dashboard.php?uid='.htmlspecialchars($UID),

                'id'   => $row['Membership_ID']

            ];

        }
        $stmt->close();


        $open_queries_sql = "SELECT Guest_ID, Name, Subject, Status FROM contact_queries WHERE Status LIKE ? OR Name LIKE ?";

        $stmt = $conn->prepare($open_queries_sql);

        $stmt->bind_param("ss", $search_keyword, $search_keyword);

        $stmt->execute();

        $Queries = $stmt->get_result();

        while($row = $Queries->fetch_assoc()){

            $results[] = [

                'type' => 'Open Query',

                'name' => $row['Subject'] . ' from ' . $row['Name'],

                'url'  => $row['Status'] == 'pending' ? './dashboard.php?uid='. htmlspecialchars($UID) : './messages.php?uid=' . htmlspecialchars($UID).'&header_title=Messages',

                'id'   => $row['Guest_ID']
            ];
        }

    }

    elseif($role == 'customer'){

        $fetch_appointments = "SELECT t.Name, a.Session_Type, a.Status, a.Appointment_ID FROM appointments AS a JOIN trainers AS t ON a.Trainer_ID = t.Trainer_ID JOIN users AS u ON u.User_ID = a.User_ID WHERE u.User_ID = ? AND (t.Name LIKE ? OR a.Session_Type LIKE ? OR a.Status LIKE ?)";

        $stmt = $conn->prepare($fetch_appointments);

        $stmt->bind_param("isss", $UID, $search_keyword, $search_keyword, $search_keyword);

        $stmt->execute();

        $appointment = $stmt->get_result();

        while($row = $appointment->fetch_assoc()){

            $results[] = [

                'type' => $row['Status'],

                'name' => $row['Session_Type']. " with ". $row['Name'],

                'url'  => '../schedule-section/manage-appointment.php?uid=' . htmlspecialchars($UID),

                'id'   => $row['Appointment_ID']

            ];
        }
        $stmt->close();

        $fetch_inbox = "SELECT m.Topic, m.Message_ID, t.Name FROM messages AS m JOIN users AS u ON m.User_ID = u.User_ID JOIN trainers AS t ON t.Trainer_ID = m.Recipient_ID WHERE u.User_ID = ? AND m.Status = 'responded' AND (m.Topic LIKE ? OR t.Name LIKE ?)";

        $stmt = $conn->prepare($fetch_inbox);

        $stmt->bind_param("iss", $UID, $search_keyword, $search_keyword);

        $stmt->execute();

        $inbox = $stmt->get_result();

        while($row = $inbox->fetch_assoc()){

            $results[] = [

                'type' => $row['Name'],

                'name' => 'Inquiry For: '. $row['Topic'],

                'url'  => '../message-section/inbox.php?uid=' . htmlspecialchars($UID),

                'id'   => $row['Message_ID']

            ];
        }
        $stmt->close();

        $fetch_broadcasts = "SELECT Broadcast_ID, Topic, Announcement FROM broadcasts WHERE Topic LIKE ? OR Announcement LIKE ?";

        $stmt = $conn->prepare($fetch_broadcasts);

        $stmt->bind_param("ss", $search_keyword, $search_keyword);

        $stmt->execute();

        $broadcasts = $stmt->get_result();

        while($row = $broadcasts->fetch_assoc()){

            $results[] = [

                'type' => 'Announcement',

                'name' => htmlspecialchars($row['Topic']),

                'url'  => '../message-section/inbox.php?uid=' . htmlspecialchars($UID),

                'id'   => $row['Broadcast_ID']

            ];
        }
        $stmt->close();
    }

}

$conn->close();

echo json_encode($results);
?>