<?php 

namespace app\controllers;

use micro\Application;
use micro\Controller;

class HomeappCtrl extends Controller
{
    
    public function hello() 
    {
        return $this->render('hello', [
            'name' => 'Marco'
        ]);
    }
    
}