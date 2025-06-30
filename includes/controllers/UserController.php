<?php

function getUserInfo($pdo, $userID) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE userID = ?");
    $stmt->execute([$userID]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
function getProfileInfo($pdo, $profileID){
    $stmt = $pdo->prepare("SELECT * FROM profiles WHERE profileID = ? LEFT JOIN users where userID = ?");
    $stmt->execute([$userID]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}