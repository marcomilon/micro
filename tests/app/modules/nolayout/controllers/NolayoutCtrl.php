<?php 

namespace app\modules\nolayout\controllers;

use micro\Controller;

class NolayoutCtrl extends Controller
{
    public function action($arg1, $arg2) 
    {
        return $this->render('arguments', [
            'arg1' => $arg1, 
            'arg2' => $arg2
        ]);
    }
    
}