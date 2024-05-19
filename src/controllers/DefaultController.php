<?php

require_once 'AppController.php';

class DefaultController extends AppController {

    public function index() {
        $this->render('login');
    }

    public function dashboard() {
        $this->render('dashboard');
    }
        
    public function configuration() {
        $this->render('configuration');
    }

    public function snmp() {
        $this->render('snmp');
    }

    public function users() {
        $this->render('users');
    }
}
