<?php
header('Content-Type: application/json');
require_once('config.php');

if (isset($_POST['UserID']) && is_numeric($_POST['UserID']) && $_POST['UserID'] > 0) {
    $userID = (int)$_POST['UserID'];
    $pdo = getDbConnection();

    // Determine which file field is set
    $field = null;
    if (isset($_FILES['Avatar'])) {
        $field = 'Avatar';
        $uploadBase = dirname(__DIR__, 1) . '/assets/images/profile-images/';
        $dbColumn = 'Avatar';
    } elseif (isset($_FILES['CoverPhoto'])) {
        $field = 'CoverPhoto';
        $uploadBase = dirname(__DIR__, 1) . '/assets/images/cover-photos/';
        $dbColumn = 'CoverPhoto';
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No valid file field provided']);
        exit;
    }

    $file = $_FILES[$field];
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    $maxSize = 5 * 1024 * 1024; // 5MB

    if (!in_array($file['type'], $allowedTypes)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid file type']);
        exit;
    }
    if ($file['size'] > $maxSize) {
        echo json_encode(['status' => 'error', 'message' => 'File too large']);
        exit;
    }
    if ($file['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['status' => 'error', 'message' => 'Upload error']);
        exit;
    }

    $userUploadDir = $uploadBase . $userID . '/';
    if (!is_dir($userUploadDir)) {
        mkdir($userUploadDir, 0777, true);
    }
    if (!is_writable($userUploadDir)) {
        echo json_encode(['status' => 'error', 'message' => 'Upload directory not writable']);
        exit;
    }

    // Clean filename
    $originalFilename = pathinfo($file['name'], PATHINFO_BASENAME);
    $filename = preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $originalFilename);
    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    $nameWithoutExt = pathinfo($filename, PATHINFO_FILENAME);
    $destination = $userUploadDir . $filename;

    // Prevent overwriting
    $counter = 1;
    while (file_exists($destination)) {
        $filename = $nameWithoutExt . '_' . $counter . '.' . $extension;
        $destination = $userUploadDir . $filename;
        $counter++;
    }

    // Delete old file if exists
    try {
        $stmt = $pdo->prepare("SELECT {$dbColumn} FROM profile WHERE ProfileID = :id");
        $stmt->bindParam(':id', $userID, PDO::PARAM_INT);
        $stmt->execute();
        $oldFile = $stmt->fetchColumn();

        if ($oldFile && file_exists($userUploadDir . $oldFile)) {
            unlink($userUploadDir . $oldFile);
        }
    } catch (PDOException $e) {
        
    }

    // Move new file
    if (!move_uploaded_file($file['tmp_name'], $destination)) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to save file']);
        exit;
    }

    // Update DB
    try {
        $stmt = $pdo->prepare("UPDATE profile SET {$dbColumn} = :filename, LastMod = NOW() WHERE ProfileID = :id");
        $stmt->bindParam(':filename', $filename);
        $stmt->bindParam(':id', $userID, PDO::PARAM_INT);
        $stmt->execute();

        echo json_encode(['status' => 'success', 'filename' => $filename]);
    } catch (PDOException $e) {
        unlink($destination);
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

$profileFields = ['Email', 'Website', 'Patreon', 'NiceName', 'Bio'];
$socialFields = ['Facebook', 'Twitter', 'Instagram', 'YouTube'];

try {
    $pdo = getDbConnection();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->beginTransaction();

    $userID = $_POST['userID'] ?? null; // ensure this matches your form name
    if (!$userID) {
        echo json_encode(['status' => 'error', 'message' => 'Missing user ID']);
        exit;
    }

    // Load current profile row
    $cur = $pdo->prepare("SELECT Bio, Website, Patreon, NiceName FROM profile WHERE ProfileID = :id");
    $cur->execute([':id' => $userID]);
    $current = $cur->fetch(PDO::FETCH_ASSOC) ?: ['Bio' => null, 'Website' => null, 'Patreon' => null, 'NiceName' => null];

    $p = $_POST['profile'] ?? [];

    $bio = array_key_exists('Bio', $p) ? trim((string)$p['Bio']) : $current['Bio'];
    $bio = (array_key_exists('Bio', $p) && $bio === '') ? null : $bio;

    $website = array_key_exists('Website', $p) ? trim((string)$p['Website']) : $current['Website'];
    $website = (array_key_exists('Website', $p) && $website === '') ? null : $website;

    $patreon = array_key_exists('Patreon', $p) ? trim((string)$p['Patreon']) : $current['Patreon'];
    $patreon = (array_key_exists('Patreon', $p) && $patreon === '') ? null : $patreon;

    $nicename = array_key_exists('NiceName', $p) ? trim((string)$p['NiceName']) : $current['NiceName'];
    $nicename = (array_key_exists('NiceName', $p) && $nicename === '') ? null : $nicename;

    $stmt = $pdo->prepare("
        UPDATE profile
        SET Bio = :bio,
            Website = :website,
            Patreon = :patreon,
            NiceName = :nicename,
            LastMod = NOW()
        WHERE ProfileID = :profileID
    ");
    $stmt->bindValue(':bio', $bio, $bio === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
    $stmt->bindValue(':website', $website, $website === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
    $stmt->bindValue(':patreon', $patreon, $patreon === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
    $stmt->bindValue(':nicename', $nicename, $nicename === null ? PDO::PARAM_NULL : PDO::PARAM_STR);
    $stmt->bindValue(':profileID', (int)$userID, PDO::PARAM_INT);
    $stmt->execute();

    // ----- Socials -----
    // Build current map
    $smup = $pdo->prepare("SELECT Platform, ProfileURL FROM usersocials WHERE UserID = :socid");
    $smup->execute([':socid' => $userID]);
    $currentSocMed = [];
    while ($row = $smup->fetch(PDO::FETCH_ASSOC)) {
        $currentSocMed[$row['Platform']] = $row['ProfileURL'];
    }

    // Index incoming socials by Platform for easy lookup
    $incoming = [];
    if (!empty($_POST['socials']) && is_array($_POST['socials'])) {
        foreach ($_POST['socials'] as $social) {
            $platform   = $social['Platform']   ?? null;
            $profileURL = $social['ProfileURL'] ?? null;
            if ($platform !== null) {
                $incoming[$platform] = $profileURL;
            }
        }
    }

    // Prepared statements for reuse
    $check = $pdo->prepare("SELECT COUNT(*) FROM usersocials WHERE UserID = :userID AND Platform = :platform");
    $upd   = $pdo->prepare("
        UPDATE usersocials
        SET ProfileURL = :profileURL, LastMod = NOW()
        WHERE UserID = :userID AND Platform = :platform
    ");
    $ins   = $pdo->prepare("
        INSERT INTO usersocials (UserID, Platform, ProfileURL, LastMod)
        VALUES (:userID, :platform, :profileURL, NOW())
    ");
    $del   = $pdo->prepare("
        DELETE FROM usersocials WHERE UserID = :userID AND Platform = :platform
    ");

    // Only touch platforms that were actually submitted.
    foreach ($incoming as $platform => $profileURL) {
        // Skip unknown platforms (assumes $socialFields whitelist exists)
        if (isset($socialFields) && !in_array($platform, $socialFields, true)) {
            continue;
        }

        $submitted = trim((string)($profileURL ?? '')); // will be '' if cleared

        // Does a row exist now?
        $check->execute([':userID' => (int)$userID, ':platform' => $platform]);
        $exists = (int)$check->fetchColumn() > 0;

        if ($submitted === '') {
            // User cleared the field: delete the row (or set to NULL if you prefer)
            if ($exists) {
                $del->execute([':userID' => (int)$userID, ':platform' => $platform]);
            }
        } else {
            if ($exists) {
                $upd->execute([
                    ':profileURL' => $submitted,
                    ':userID'     => (int)$userID,
                    ':platform'   => $platform,
                ]);
            } else {
                $ins->execute([
                    ':userID'     => (int)$userID,
                    ':platform'   => $platform,
                    ':profileURL' => $submitted,
                ]);
            }
        }
    }

    $pdo->commit();
    echo json_encode(['status' => 'success', 'message' => 'Profile updated successfully']);
} catch (PDOException $e) {
    if ($pdo && $pdo->inTransaction()) $pdo->rollBack();
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Database update failed: ' . $e->getMessage()]);
    exit;
}

?>
