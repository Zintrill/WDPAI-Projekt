<?php

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../repository/UserRepository.php';

class SecurityController extends AppController
{
    public function login()
    {
        $userRepository = new UserRepository();

        if ($this->isPost()) {
            $username = $_POST["username"];
            $password = $_POST["password"];

            $user = $userRepository->getUser($username);

            if (!$user) {
                return $this->render('login', ['messages' => ['User not exists!']]);
            }

            if ($user->getUsername() !== $username) {
                return $this->render('login', ['messages' => ['User with this username not exist!']]);
            }

            if ($user->getPassword() !== $password) {
                return $this->render('login', ['messages' => ['Wrong password!']]);
            }

            // Przechowywanie danych użytkownika w sesji
            $_SESSION['user_id'] = $user->getUsername();
            $_SESSION['full_name'] = $user->getFullName();

            return $this->render('dashboard', ['username' => $user->getFullName()]);
        }

        return $this->render('login');
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        $this->render('login', ['messages' => ['You have been logged out!']]);
    }
}
