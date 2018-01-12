<?php 

namespace app\modulo\controllers;

use micro\Controller;

class AppCtrl extends Controller
{
    public function action($arg1, $arg2) 
    {
        return $this->render('arguments', [
            'arg1' => $arg1, 
            'arg2' => $arg2
        ]);
    }
    
    public function index() 
    {
        return "Hello modulo";
    }
    
    public function hello() {
        return $this->render('index');
    }
    
    public function viewnotfound() {
        return $this->render('viewnotfound');
    }
}