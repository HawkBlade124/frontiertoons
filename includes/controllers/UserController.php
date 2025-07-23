<?php

function getUserInfo($pdo, $userID) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE user_id = ?");
    $stmt->execute([$userID]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
function getProfileInfo($pdo, $profileID){
    $stmt = $pdo->prepare("SELECT * FROM profile WHERE profileID = ? LEFT JOIN users where user_id = ?");
    $stmt->execute([$profileID, $userID]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}