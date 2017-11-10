<?php 

namespace app\controller;

class CustomCtrl
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