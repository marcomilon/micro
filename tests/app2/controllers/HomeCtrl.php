<?php 

namespace app\controllers;

use micro\Application;
use micro\Controller;

class HomeCtrl extends Controller
{
    
    public function hello() 
    {
        return $this->render('hello');
    }
    
}