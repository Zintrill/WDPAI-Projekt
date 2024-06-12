<?php

require_once 'AppController.php';
require_once __DIR__.'/../repository/UserRepository.php';

class UserController extends AppController
{
    private function checkPermission($requiredRole)
    {
        $userRole = $_SESSION['user_role'];
        if ($userRole > $requiredRole) {
            header('HTTP/1.1 403 Forbidden');
            echo json_encode(['status' => 'error', 'message' => 'Access Denied']);
            exit();
        }
    }

    public function addUser()
    {
        $this->checkPermission(1); // Tylko administrator
        header('Content-Type: application/json');
        try {
            if ($this->isPost()) {
                $userRepository = new UserRepository();

                $fullName = $_POST['fullName'];
                $username = $_POST['username'];
                $password = $_POST['userPassword'];
                $role = $_POST['userRole'];
                $email = $_POST['email'];

                if ($userRepository->isUsernameTaken($username)) {
                    echo json_encode(['status' => 'error', 'message' => 'Username is already taken']);
                    return;
                }

                if ($userRepository->isEmailTaken($email)) {
                    echo json_encode(['status' => 'error', 'message' => 'Email is already taken']);
                    return;
                }

                $userRepository->addUser($fullName, $username, $password, $role, $email);

                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function updateUser()
    {
        $this->checkPermission(1); // Tylko administrator
        header('Content-Type: application/json');
        if ($this->isPost()) {
            $userRepository = new UserRepository();

            $userId = (int)$_POST['userId'];
            $fullName = $_POST['fullName'];
            $username = $_POST['username'];
            $password = $_POST['userPassword'];
            $role = $_POST['userRole'];
            $email = $_POST['email'];

            if ($userRepository->isUsernameTakenByAnother($username, $userId)) {
                echo json_encode(['status' => 'error', 'message' => 'Username is already taken by another user']);
                return;
            }

            if ($userRepository->isEmailTakenByAnother($email, $userId)) {
                echo json_encode(['status' => 'error', 'message' => 'Email is already taken by another user']);
                return;
            }

            // Aktualizacja użytkownika w bazie danych
            $userRepository->updateUser($userId, $fullName, $username, $password, $role, $email);

            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
        }
    }

    public function getUsers()
    {
        header('Content-Type: application/json');
        try {
            $userRepository = new UserRepository();
            $users = $userRepository->getAllUsers();
            echo json_encode($users);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function deleteUser()
    {
        $this->checkPermission(1); // Tylko administrator
        header('Content-Type: application/json');
        try {
            if ($this->isPost()) {
                if (isset($_POST['userId'])) {
                    $userId = (int)$_POST['userId']; // Konwersja ID na integer

                    $userRepository = new UserRepository();
                    $userRepository->deleteUser($userId);

                    echo json_encode(['status' => 'success']);
                    return;
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'No user ID provided']);
                    return;
                }
            }
            echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function getUserById()
    {
        header('Content-Type: application/json');
        try {
            if ($this->isGET()) {
                $userId = (int)$_GET['id'];
                $userRepository = new UserRepository();
                $user = $userRepository->getUserById($userId);

                // Logowanie danych użytkownika
                error_log(print_r($user, true));

                // Konwertowanie obiektu użytkownika na JSON
                echo json_encode($user);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
