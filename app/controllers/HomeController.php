<?php

use Phalcon\Mvc\Controller;

class HomeController extends Controller
{
    public function indexAction()
    {
        $this->view->auth = $this->session->get('auth');
        //$this->view->users = Users::find();
        
    }
}
