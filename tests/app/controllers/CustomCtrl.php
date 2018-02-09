<?php 

namespace app\controllers;

use micro\Controller;

class CustomCtrl extends Controller
{
    public function action($arg1, $arg2) 
    {
        return "$arg1,$arg2";
    }
    
    public function index() 
    {
        return "Hello world";
    }
    
    public function hello() 
    {
        return $this->render('hello');
    }
    
    public function arguments($arg1, $arg2) 
    {
        return $this->render('arguments', [
            'arg1' => $arg1,
            'arg2' => $arg2
        ]);
    }
    
    public function viewnotfound() {
        return $this->render('viewnotfound');
    }
    
    public function config() {
        $config = $this->app->getConfig();
        return $config['key'];
    }
    
    public function viewconfig() {
        return $this->render('viewconfig');
    }
}