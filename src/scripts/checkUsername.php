<?php

require_once __DIR__.'/../repository/UserRepository.php';

header('Content-Type: application/json');

if (isset($_GET['username'])) {
    $username = $_GET['username'];
    $userRepository = new UserRepository();
    $isTaken = $userRepository->isUsernameTaken($username);
    echo json_encode(['isTaken' => $isTaken]);
}
