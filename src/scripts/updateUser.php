<?php
require_once 'src/repository/UserRepository.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    try {
        $userId = $_POST['userId'];
        $fullName = $_POST['fullName'];
        $username = $_POST['username'];
        $password = $_POST['userPassword'];
        $role = $_POST['userRole'];
        $email = $_POST['email'];

        $userRepository = new UserRepository();

        // Aktualizacja użytkownika w bazie danych
        $userRepository->updateUser($userId, $fullName, $username, $password, $role, $email);

        echo json_encode(['status' => 'success']);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}
