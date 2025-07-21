<?php
require_once __DIR__ . '/config.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // --- 1. Handle TEXT FIELD UPDATES (nickname, email, website, bio) ---
if (isset($_POST['action']) && $_POST['action'] === 'updateField') {
    $userID = filter_var($_POST['userID'], FILTER_VALIDATE_INT);
    $field = $_POST['field'];
    $value = trim($_POST['value']);

    $allowedProfileFields = ['website', 'bio'];
    $allowedUserFields = ['email', 'niceName'];

    if (!in_array($field, array_merge($allowedProfileFields, $allowedUserFields))) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid field']);
        exit;
    }

    try {
        $pdo = getDbConnection();

        if (in_array($field, $allowedProfileFields)) {
            // Check if profile row exists
            $check = $pdo->prepare("SELECT COUNT(*) FROM profile WHERE profileID = :id");
            $check->execute([':id' => $userID]);
            $exists = $check->fetchColumn();
            
        if (!$exists) {
            $create = $pdo->prepare("INSERT INTO profile (profileID) VALUES (:id)");
            if (!$create->execute([':id' => $userID])) {
                echo json_encode(['status' => 'error', 'message' => 'Failed to create profile']);
                exit;
            }
        }
            // Update profile table with lastMod
            $stmt = $pdo->prepare("UPDATE profile SET $field = :value, lastMod = NOW() WHERE profileID = :id");                   
            $stmt->bindParam(':value', $value);
            $stmt->bindParam(':id', $userID, PDO::PARAM_INT);
            $stmt->execute();
            $stmt->rowCount();     
        } else {
            // Update users table
            $stmt = $pdo->prepare("UPDATE users SET $field = :value WHERE userID = :id");
            $stmt->bindParam(':value', $value);
            $stmt->bindParam(':id', $userID, PDO::PARAM_INT);
            $stmt->execute();
        }

        $rows = $stmt->rowCount();
        if ($rows > 0) {
            echo json_encode(['status' => 'success', 'message' => ucfirst($field) . ' updated!']);
        } else {
            echo json_encode(['status' => 'warning', 'message' => 'No change made.']);
        }
    } catch (PDOException $e) {
        error_log("Update error: " . $e->getMessage());
        echo json_encode(['status' => 'error', 'message' => 'Database error']);
    }
    exit;
}


    // --- 2. Handle AVATAR UPLOAD ---
    if (isset($_POST['userID']) && isset($_FILES['avatar'])) {
        $userID = filter_var($_POST['userID'], FILTER_VALIDATE_INT, [
            'options' => ['min_range' => 1]
        ]);
        if ($userID === false) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid userID']);
            exit;
        }

        $file = $_FILES['avatar'];
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $maxSize = 5 * 1024 * 1024; // 5MB

        if (!in_array($file['type'], $allowedTypes)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid file type. Only JPEG, PNG, or GIF allowed.']);
            exit;
        }
        if ($file['size'] > $maxSize) {
            echo json_encode(['status' => 'error', 'message' => 'File too large. Maximum size is 5MB.']);
            exit;
        }
        if ($file['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['status' => 'error', 'message' => 'File upload error.']);
            exit;
        }

        $namespace = 'user-images-v1';
        $hashedFolder = hash('sha256', $namespace . '-' . $userID);
        $baseUploadDir = dirname(__DIR__, 1) . '/assets/images/user-profile-images/';
        $userUploadDir = $baseUploadDir . $hashedFolder . '/';

        if (!is_dir($userUploadDir)) {
            mkdir($userUploadDir, 0777, true);
        }

        if (!is_writable($userUploadDir)) {
            echo json_encode(['status' => 'error', 'message' => 'Upload directory not writable']);
            exit;
        }

        $originalFilename = pathinfo($file['name'], PATHINFO_BASENAME);
        $filename = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $originalFilename);
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $nameWithoutExt = pathinfo($filename, PATHINFO_FILENAME);
        $destination = $userUploadDir . $filename;

        $counter = 1;
        while (file_exists($destination)) {
            $filename = $nameWithoutExt . '_' . $counter . '.' . $extension;
            $destination = $userUploadDir . $filename;
            $counter++;
        }

        try {
            $pdo = getDbConnection();
            $query = "SELECT avatar FROM profile WHERE profileID = :profileID";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':profileID', $userID, PDO::PARAM_INT);
            $stmt->execute();
            $oldAvatar = $stmt->fetchColumn();
        } catch (PDOException $e) {
            $oldAvatar = false;
        }

        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            echo json_encode(['status' => 'error', 'message' => 'Failed to move uploaded file']);
            exit;
        }

        if ($oldAvatar && file_exists($userUploadDir . $oldAvatar)) {
            unlink($userUploadDir . $oldAvatar);
        }

        try {
            $pdo = getDbConnection();
            $stmt = $pdo->prepare("UPDATE profile SET avatar = :avatar, lastMod = NOW() WHERE profileID = :profileID");
            $stmt->bindParam(':avatar', $filename);
            $stmt->bindParam(':profileID', $userID, PDO::PARAM_INT);
            $stmt->execute();

            echo json_encode(['status' => 'success', 'filename' => $filename]);
        } catch (PDOException $e) {
            if (file_exists($destination)) {
                unlink($destination);
            }
            echo json_encode(['status' => 'error', 'message' => 'Database update failed']);
        }
        exit;
    }
    if (isset($_POST['action']) && $_POST['action'] === 'deleteAccount') {
        $pdo = getDbConnection();
        
        $stmt = $pdo->prepare('DELETE FROM users WHERE userID = :userID');
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->execute();
    }
    echo json_encode(['status' => 'error', 'message' => 'No valid action received']);
    exit;
}
?>
