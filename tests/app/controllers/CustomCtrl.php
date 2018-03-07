<?php 

namespace app\controllers;

use micro\Application;
use micro\Controller;
use micro\helpers\form\Builder;

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
        $config = Application::getConfig();
        return $config['key'];
    }
    
    public function viewconfig() {
        return $this->render('viewconfig');
    }
    
    public function record() {
        $condition = [
            ['=', 'help_category_id', '1']
        ];
        $model = \app\models\HelpCategory::find()->where($condition)->one();
        return $model->name;
    }
    
    public function form() {
        $json = '[
            "name",
            "lastname"
        ]';
        
        $builder = new Builder();
        $form = $builder->render($json);
        
        return $form;
    }
    
    public function formHorizontal() {
        $json = '[
            "name",
            "lastname"
        ]';
    
        $builder = new Builder();
        $form = $builder->render($json);
    
        return $form;
    }
}