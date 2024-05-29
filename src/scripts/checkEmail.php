<?php

require_once __DIR__.'/../repository/UserRepository.php';

header('Content-Type: application/json');

if (isset($_GET['email'])) {
    $email = $_GET['email'];
    $userRepository = new UserRepository();
    $isTaken = $userRepository->isEmailTaken($email);
    echo json_encode(['isTaken' => $isTaken]);
}
