<?php 

namespace app\controllers;

use micro\Application;
use micro\Controller;
use micro\helpers\form\Builder;

class HomeCtrl extends Controller
{
    
    public function hello() 
    {
        return $this->render('hello');
    }
    
}