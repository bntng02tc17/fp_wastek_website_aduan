<?php

use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {
        return $this->response->redirect('login');
        //$this->view->users = Users::find();
        
    }
}
