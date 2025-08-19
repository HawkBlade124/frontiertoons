<?php
header('Content-Type: application/json');
require_once('config.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
    exit;
}

$action = $_POST['action'] ?? '';
if ($action !== 'changeData') {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid or missing action']);
    exit;
}

$profileFields = ['Email', 'Website', 'Patreon', 'Nickname', 'Bio'];
$socialFields = ['Facebook', 'Twitter', 'Instagram', 'YouTube'];

try {
    $pdo = getDbConnection();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Load current profile row
    $userID = $_POST['userID'] ?? null;
    if (!$userID) {
        echo json_encode(['status' => 'error', 'message' => 'Missing user ID']);
        exit;
    }

    // Update profile table
    $cur = $pdo->prepare("SELECT Bio, Website, Patreon FROM profile WHERE ProfileID = :id");
    $cur->execute([':id' => $userID]);
    $current = $cur->fetch(PDO::FETCH_ASSOC) ?: ['Bio' => null, 'Website' => null, 'Patreon' => null];

    $bio = $_POST['profile']['Bio'] ?? $current['Bio'];
    $website = $_POST['profile']['Website'] ?? $current['Website'];
    $patreon = $_POST['profile']['Patreon'] ?? $current['Patreon'];

    $bio = ($bio === '') ? $current['Bio'] : $bio;
    $website = ($website === '') ? $current['Website'] : $website;
    $patreon = ($patreon === '') ? $current['Patreon'] : $patreon;

    $stmt = $pdo->prepare("
        UPDATE profile
        SET Bio = :bio,
            Website = :website,
            Patreon = :patreon,
            LastMod = NOW()
        WHERE ProfileID = :profileID
    ");

    $stmt->execute([
        ':bio' => $bio,
        ':website' => $website,
        ':patreon' => $patreon,
        ':profileID' => (int)$userID,
    ]);

    // Load current social media profiles
    $smup = $pdo->prepare("SELECT Platform, ProfileURL FROM usersocials WHERE UserID = :socid");
    $smup->execute([':socid' => $userID]);
    $currentSocMed = [];
    while ($row = $smup->fetch(PDO::FETCH_ASSOC)) {
        $currentSocMed[$row['Platform']] = $row['ProfileURL'];
    }

    // Process social media fields
    if (isset($_POST['socials']) && is_array($_POST['socials'])) {
        foreach ($_POST['socials'] as $social) {
            $platform = $social['Platform'] ?? null;
            $profileURL = $social['ProfileURL'] ?? null;

            if (!in_array($platform, $socialFields)) {
                continue; // Skip invalid platforms
            }

            // Use existing URL if new URL is empty
            $profileURL = ($profileURL === '') ? ($currentSocMed[$platform] ?? null) : $profileURL;

            // Check if the platform already exists for the user
            $check = $pdo->prepare("SELECT COUNT(*) FROM usersocials WHERE UserID = :userID AND Platform = :platform");
            $check->execute([':userID' => (int)$userID, ':platform' => $platform]);
            $exists = $check->fetchColumn();

            if ($exists) {
                // Update existing record
                $stmt = $pdo->prepare("
                    UPDATE usersocials
                    SET ProfileURL = :profileURL,
                        LastMod = NOW()
                    WHERE UserID = :userID AND Platform = :platform
                ");
                $stmt->execute([
                    ':profileURL' => $profileURL,
                    ':userID' => (int)$userID,
                    ':platform' => $platform,
                ]);
            } else {
                // Insert new record
                $stmt = $pdo->prepare("
                    INSERT INTO usersocials (UserID, Platform, ProfileURL, LastMod)
                    VALUES (:userID, :platform, :profileURL, NOW())
                ");
                $stmt->execute([
                    ':userID' => (int)$userID,
                    ':platform' => $platform,
                    ':profileURL' => $profileURL,
                ]);
            }
        }
    }

    echo json_encode(['status' => 'success', 'message' => 'Profile updated successfully']);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Database update failed: ' . $e->getMessage()]);
    exit;
}
// Handle avatar upload
if (isset($_POST['userID']) && isset($_FILES['Avatar'])) {
        $userID = filter_var($_POST['UserID'], FILTER_VALIDATE_INT, [
            'options' => ['min_range' => 1]
        ]);
        if ($userID === false) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid userID']);
            exit;
        }

        $file = $_FILES['Avatar'];
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
            $query = "SELECT Avatar FROM profile WHERE ProfileID = :profileID";
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
            $stmt = $pdo->prepare("UPDATE profile SET Avatar = :avatar, LastMod = NOW() WHERE ProfileID = :profileID");
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
if (isset($_POST['userID']) && isset($_FILES['CoverPhoto'])) {
        $userID = filter_var($_POST['UserID'], FILTER_VALIDATE_INT, [
            'options' => ['min_range' => 1]
        ]);
        if ($userID === false) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid userID']);
            exit;
        }

        $file = $_FILES['CoverPhoto'];
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
        $baseUploadDir = dirname(__DIR__, 1) . '/assets/images/user-cover-photos/';
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
            $query = "SELECT CoverPhoto FROM profile WHERE ProfileID = :profileID";
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
            $stmt = $pdo->prepare("UPDATE profile SET CoverPhoto = :cover, LastMod = NOW() WHERE ProfileID = :profileID");
            $stmt->bindParam(':cover', $filename);
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
    try {
        $pdo = getDbConnection();
        $stmt = $pdo->prepare('DELETE FROM users WHERE UserID = :userID');
        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->execute();
        echo json_encode(['status' => 'success', 'message' => 'Account deleted successfully']);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete account']);
    }
    exit;
}

?>
