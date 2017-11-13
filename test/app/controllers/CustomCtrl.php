<?php 

namespace app\controller;

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
}