<?php

require_once 'AppController.php';

class DefaultController extends AppController
{
    public function index()
    {
        $this->render('login');
    }

    public function dashboard()
    {
        if ($this->isLogged()) {
            $this->render('dashboard', ['username' => $_SESSION['full_name']]);
        } else {
            $this->render('login', ['messages' => ['You need to login first!']]);
        }
    }

    public function configuration()
    {
        if ($this->isLogged()) {
            $this->render('configuration', ['username' => $_SESSION['full_name']]);
        } else {
            $this->render('login', ['messages' => ['You need to login first!']]);
        }
    }

    public function snmp()
    {
        if ($this->isLogged()) {
            $this->render('snmp', ['username' => $_SESSION['full_name']]);
        } else {
            $this->render('login', ['messages' => ['You need to login first!']]);
        }
    }

    public function users()
    {
        if ($this->isLogged()) {
            $this->render('users', ['username' => $_SESSION['full_name']]);
        } else {
            $this->render('login', ['messages' => ['You need to login first!']]);
        }
    }

    private function isLogged(): bool
    {
        return isset($_SESSION['user_id']);
    }
}