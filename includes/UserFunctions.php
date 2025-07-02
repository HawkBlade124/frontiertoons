<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['userID']) && isset($_FILES['avatar'])) {
        $userID = $_POST['userID'];
        $pic = base64_encode(file_get_contents($_FILES['avatar']['tmp_name']));

        $data = new Data();
        $query = "REPLACE INTO profile (profileID, avatar) VALUES (:userID, :avatar)";
        $stmt = $data->prepare($query);
        $stmt->bindParam(':userID', $userID);
        $stmt->bindParam(':avatar', $pic);
        $stmt->execute();
        echo json_encode(['status' => 'success']);
        exit;
    }
    echo json_encode(['status' => 'error', 'message' => 'Missing data']);
}
