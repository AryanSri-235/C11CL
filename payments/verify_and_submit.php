<?php
include 'db.php';
header('Content-Type: application/json');

try {
    $conn = new mysqli($host, $username, $password, $dbname);

    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // 3. POST Data Receive karna
    $name  = isset($_POST['name']) ? trim($_POST['name']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $reg   = isset($_POST['reg']) ? trim($_POST['reg']) : '';

    if (empty($name) || empty($phone) || empty($reg)) {
        echo json_encode(['status' => 'error', 'error' => 'All fields are required!']);
        exit;
    }

    // 4. Database mein search karna (Prepared Statement use karein security ke liye)
    // Maan lete hain table ka naam 'players' hai
    $sql = "SELECT * FROM players WHERE registration_id = ? AND mobile = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $reg, $phone);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Check karein kya Phase 1 complete hai (Example logic)
        if (isset($row['payment_status']) && $row['payment_status'] != 'Success') {
             echo json_encode(['status' => 'pending']);
             exit;
        }

        // 5. Data ko Frontend ke format mein bhejna
        // Note: Keys wahi honi chahiye jo aapke JS fetch mein hain (e.g., data.name, data.mobile)
        echo json_encode([
            'status' => 'success',
            'reg'    => $row['registration_id'],
            'name'   => $row['full_name'],
            'mobile' => $row['mobile'],
            'email'  => $row['email'],
            'state'  => $row['state'],
            'city'   => $row['city'],
            'player' => $row['player_role'] // Bowler, Batsman, etc.
        ]);

    } else {
        // Data nahi mila
        echo json_encode(['status' => 'not_found']);
    }

    $stmt->close();
    $conn->close();

} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'error' => $e->getMessage()]);
}
?>