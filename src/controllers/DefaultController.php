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
        $this->renderPage('dashboard');
    }

    public function configuration()
    {
        $this->renderPage('configuration');
    }

    public function snmp()
    {
        $this->renderPage('snmp');
    }

    public function users()
    {
        $this->renderPage('users');
    }

    private function isLogged(): bool
    {
        return isset($_SESSION['user_id']);
    }

    private function renderPage(string $page)
    {
        if ($this->isLogged()) {
            $this->render($page, ['username' => $_SESSION['full_name']]);
        } else {
            $this->render('login', ['messages' => ['You need to login first!']]);
        }
    }
}
